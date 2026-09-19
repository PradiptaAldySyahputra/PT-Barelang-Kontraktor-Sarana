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
        // ---------------------------------------------------------
        $labaRugiSpk = Spk::query()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->withSum('uangKeluar as total_keluar', 'jumlah')
            ->get()
            ->map(fn (Spk $spk): array => [
                'nomor_spk' => $spk->nomor_spk,
                'pekerjaan' => $spk->nama_pekerjaan,
                'mitra' => $spk->mitra?->nama,
                'nilai_spk' => (float) $spk->nilai_spk,
                'penerimaan' => (float) ($spk->total_masuk ?? 0),
                'biaya' => (float) ($spk->total_keluar ?? 0),
                'laba' => (float) ($spk->total_masuk ?? 0) - (float) ($spk->total_keluar ?? 0),
                'piutang' => max(0, (float) $spk->nilai_spk - (float) ($spk->total_masuk ?? 0)),
            ])
            ->sortByDesc('laba')
            ->values();

        // ---------------------------------------------------------
        // Piutang (SPK belum lunas)
        // ---------------------------------------------------------
        $piutang = Spk::query()
            ->with('mitra')
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->get()
            ->map(fn (Spk $spk): array => [
                'nomor_spk' => $spk->nomor_spk,
                'pekerjaan' => $spk->nama_pekerjaan,
                'mitra' => $spk->mitra?->nama,
                'nilai_spk' => (float) $spk->nilai_spk,
                'diterima' => (float) ($spk->total_masuk ?? 0),
                'sisa' => max(0, (float) $spk->nilai_spk - (float) ($spk->total_masuk ?? 0)),
                'status_tagihan' => $spk->status_tagihan?->label() ?? '—',
            ])
            ->filter(fn (array $r): bool => $r['sisa'] > 0)
            ->sortByDesc('sisa')
            ->values();

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
            'jumlahSpk' => Spk::count(),
            'jumlahMitra' => Mitra::count(),
            'totalPiutang' => $piutang->sum('sisa'),
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
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Nilai SPK', 'Penerimaan', 'Biaya', 'Laba/Rugi', 'Piutang'],
                $data['labaRugiSpk']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['nilai_spk'],
                    $r['penerimaan'],
                    $r['biaya'],
                    $r['laba'],
                    $r['piutang'],
                ])->all(),
            ],
            'piutang' => [
                'Laporan Piutang SPK',
                ['Nomor SPK', 'Pekerjaan', 'Mitra', 'Nilai SPK', 'Diterima', 'Sisa Piutang', 'Status Tagihan'],
                $data['piutang']->map(fn (array $r): array => [
                    $r['nomor_spk'],
                    $r['pekerjaan'],
                    $r['mitra'] ?? '—',
                    $r['nilai_spk'],
                    $r['diterima'],
                    $r['sisa'],
                    $r['status_tagihan'],
                ])->all(),
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

            fputcsv($out, [$judul], ';');
            fputcsv($out, ['Dicetak: '.now()->format('d/m/Y H:i')], ';');
            fputcsv($out, [], ';');
            fputcsv($out, $header, ';');

            foreach ($baris as $r) {
                fputcsv($out, $r, ';');
            }

            fclose($out);
        }, $namaFile, ['Content-Type' => 'text/csv; charset=UTF-8']);
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
