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
 * ⚠️ KEPUTUSAN USER (19 Sep 2026):
 * "laba rugi per spk itu untuk apa karna bagian rugi tadi di hapus, saya
 *  mengikuti dari user kalau bagian bagian tersebut dihapus apakah tidak
 *  masalah, karna dari user tidak ada itu seperti pajak, biaya, laba/rugi,
 *  dan piutang jadi murni input berdasarkan data yang ada."
 *
 * Maka laporan HANYA memuat data yang BENAR-BENAR ADA & DIINPUT:
 *
 *   1. Ringkasan        — nilai SPK, uang masuk, uang keluar, selisih
 *   2. Uang Masuk       — per bulan
 *   3. Uang Keluar      — per bulan
 *   4. Pengeluaran      — per kategori
 *   5. Daftar SPK       — nilai & status per SPK
 *   6. Tenggat SPK      — yang lewat / mendekati tenggat
 *
 * DIHAPUS (tidak ada datanya / tidak dipakai perusahaan):
 *   - Laba-Rugi per SPK   (tidak ada data biaya & laba)
 *   - Piutang             (tidak ada data pembayaran lengkap)
 *   - Umur Piutang (aging)
 *   - Retensi
 *
 * Semua angka dihitung on-the-fly dari transaksi (tidak ada tabel ringkasan).
 */
class Laporan extends Page
{
    protected string $view = 'filament.pages.laporan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $title = 'Laporan';

    protected static ?int $navigationSort = 1;

    /** Periode laporan: 1 = bulan ini, 3 = 3 bulan, 12 = 1 tahun, 0 = semua */
    public int $periode = 12;

    public function setPeriode(int $periode): void
    {
        $this->periode = $periode;
    }

    protected function tanggalAwal(): ?Carbon
    {
        return $this->periode > 0
            ? now()->subMonths($this->periode)->startOfMonth()
            : null;
    }

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
        // 1. RINGKASAN
        // ---------------------------------------------------------
        $totalMasuk = (float) $this->queryMasuk()->sum('jumlah');
        $totalKeluar = (float) $this->queryKeluar()->sum('jumlah');
        $selisih = $totalMasuk - $totalKeluar;

        $masukDariSpk = (float) $this->queryMasuk()->whereNotNull('spk_id')->sum('jumlah');
        $masukLuarSpk = (float) $this->queryMasuk()->whereNull('spk_id')->sum('jumlah');

        $nilaiSpk = (float) Spk::sum('nilai_spk');
        $belumDiterima = $nilaiSpk - (float) UangMasuk::whereNotNull('spk_id')->sum('jumlah');

        // ---------------------------------------------------------
        // 2 & 3. UANG MASUK / KELUAR PER BULAN
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
        // 4. PENGELUARAN PER KATEGORI
        // ---------------------------------------------------------
        $perKategori = $this->queryKeluar()
            ->selectRaw('kategori, COUNT(*) as jumlah_transaksi, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get()
            ->map(function ($row): array {
                $enum = $row->kategori instanceof KategoriPengeluaran
                    ? $row->kategori
                    : KategoriPengeluaran::tryFrom((string) $row->kategori);

                return [
                    'label' => $enum?->label() ?? ($row->kategori ?: 'Tanpa kategori'),
                    'jumlah_transaksi' => (int) $row->jumlah_transaksi,
                    'total' => (float) $row->total,
                ];
            });

        // ---------------------------------------------------------
        // 5. DAFTAR SPK (nilai & status)
        // ---------------------------------------------------------
        $daftarSpk = Spk::query()
            ->with(['mitra', 'subkon'])
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->orderByDesc('tanggal_spk')
            ->get()
            ->map(fn (Spk $spk): array => [
                'nomor_spk' => $spk->nomor_spk,
                'pekerjaan' => $spk->nama_pekerjaan,
                'mitra' => $spk->mitra?->nama,
                'tanggal' => $spk->tanggal_spk?->format('d/m/Y'),
                'nilai_spk' => (float) $spk->nilai_spk,
                'diterima' => (float) ($spk->total_masuk ?? 0),
                'belum_diterima' => max(0, $spk->piutangDari((float) ($spk->total_masuk ?? 0))),
                'status_spk' => $spk->status_spk?->label() ?? '—',
                'status_tagihan' => $spk->status_tagihan?->label() ?? 'Belum Ditagihkan',
            ]);

        // ---------------------------------------------------------
        // 6. TENGGAT SPK
        // ---------------------------------------------------------
        $spkLewatTenggat = Spk::query()
            ->lewatTenggat()
            ->with('mitra')
            ->orderBy('tanggal_akhir')
            ->get();

        $spkMendekatiTenggat = Spk::query()
            ->mendekatiTenggat()
            ->with('mitra')
            ->orderBy('tanggal_akhir')
            ->get();

        return [
            'periode' => $this->periode,

            // Ringkasan
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'selisih' => $selisih,
            'masukDariSpk' => $masukDariSpk,
            'masukLuarSpk' => $masukLuarSpk,
            'nilaiSpk' => $nilaiSpk,
            'belumDiterima' => max(0, $belumDiterima),

            // Rincian
            'perBulan' => $perBulan,
            'perKategori' => $perKategori,
            'daftarSpk' => $daftarSpk,
            'spkLewatTenggat' => $spkLewatTenggat,
            'spkMendekatiTenggat' => $spkMendekatiTenggat,

            // Jumlah
            'jumlahSpk' => Spk::count(),
            'jumlahMitra' => Mitra::count(),
            'jumlahMasuk' => UangMasuk::count(),
            'jumlahKeluar' => UangKeluar::count(),
        ];
    }

    /**
     * Ekspor data laporan ke CSV.
     */
    public function ekspor(string $jenis): StreamedResponse
    {
        $data = $this->getViewData();

        [$judul, $header, $baris] = match ($jenis) {
            'masuk' => [
                'Laporan Uang Masuk per Bulan',
                ['Bulan', 'Jumlah Transaksi', 'Total Masuk', 'Total Keluar', 'Selisih'],
                $data['perBulan']->map(fn (array $r): array => [
                    $r['label'],
                    $r['jumlah_masuk'],
                    $r['masuk'],
                    $r['keluar'],
                    $r['selisih'],
                ])->all(),
            ],
            'keluar' => [
                'Laporan Uang Keluar per Kategori',
                ['Kategori', 'Jumlah Transaksi', 'Total'],
                $data['perKategori']->map(fn (array $r): array => [
                    $r['label'],
                    $r['jumlah_transaksi'],
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
                'Laporan Daftar SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Tanggal', 'Nilai SPK', 'Sudah Diterima', 'Belum Diterima', 'Status SPK', 'Status Tagihan'],
                $data['daftarSpk']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['tanggal'] ?? 'TANPA SPK',
                    $r['nilai_spk'],
                    $r['diterima'],
                    $r['belum_diterima'],
                    $r['status_spk'],
                    $r['status_tagihan'],
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
     * menganggapnya RUMUS dan menjalankannya. Karena file CSV ini dibuka di
     * Excel (aplikasi yang dipakai perusahaan), nilai dari database HARUS
     * dinetralkan dulu.
     *
     * Angka asli (int/float) TIDAK disentuh supaya tetap bisa dijumlahkan.
     */
    private static function amanCsv(mixed $nilai): mixed
    {
        if ($nilai === null || is_int($nilai) || is_float($nilai)) {
            return $nilai;
        }

        $teks = (string) $nilai;

        if ($teks === '') {
            return $teks;
        }

        if (preg_match('/^[=+\-@\t\r]/', $teks) === 1) {
            return "'".$teks;
        }

        return $teks;
    }

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
