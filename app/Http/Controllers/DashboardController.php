<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\View\View;

/**
 * Dashboard — ringkasan kondisi keuangan.
 *
 * Semua angka dihitung on-the-fly dari transaksi (tidak ada tabel ringkasan),
 * sesuai Schema.md §6.
 */
class DashboardController extends Controller
{
    public function index(): View
    {
        // ---------------------------------------------------------
        // Kartu ringkasan
        // ---------------------------------------------------------
        $totalNilaiSpk = (float) Spk::sum('nilai_spk');
        $totalUangMasuk = (float) UangMasuk::sum('jumlah');
        $totalUangKeluar = (float) UangKeluar::sum('jumlah');
        $saldoBersih = $totalUangMasuk - $totalUangKeluar;

        // ---------------------------------------------------------
        // Uang masuk: dipisah dari SPK vs luar SPK
        // ---------------------------------------------------------
        $masukDariSpk = (float) UangMasuk::dariSpk()->sum('jumlah');
        $masukDariLuar = (float) UangMasuk::dariLuarSpk()->sum('jumlah');

        // ---------------------------------------------------------
        // Piutang: nilai SPK - penerimaan
        // ---------------------------------------------------------
        $totalPiutang = max(0, $totalNilaiSpk - $masukDariSpk);

        // ---------------------------------------------------------
        // Jumlah SPK per status
        // ---------------------------------------------------------
        $spkPerStatus = Spk::query()
            ->selectRaw('status_spk, COUNT(*) as jumlah')
            ->groupBy('status_spk')
            ->pluck('jumlah', 'status_spk');

        // ---------------------------------------------------------
        // Pengeluaran per kategori
        // ---------------------------------------------------------
        $pengeluaranPerKategori = UangKeluar::query()
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->pluck('total', 'kategori');

        // ---------------------------------------------------------
        // Daftar SPK berjalan + laba-rugi (dihitung per SPK)
        // ---------------------------------------------------------
        $spkBerjalan = Spk::query()
            ->berjalan()
            ->with(['mitra'])
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->withSum('uangKeluar as total_keluar', 'jumlah')
            ->orderByDesc('nilai_spk')
            ->limit(10)
            ->get()
            ->map(function (Spk $spk): Spk {
                $spk->setAttribute('hitung_penerimaan', (float) ($spk->total_masuk ?? 0));
                $spk->setAttribute('hitung_biaya', (float) ($spk->total_keluar ?? 0));
                $spk->setAttribute(
                    'hitung_laba',
                    (float) ($spk->total_masuk ?? 0) - (float) ($spk->total_keluar ?? 0)
                );

                return $spk;
            });

        // ---------------------------------------------------------
        // Grafik: uang masuk vs keluar per bulan (6 bulan terakhir)
        // ---------------------------------------------------------
        $bulan = collect(range(5, 0))->map(fn (int $i): string => now()->subMonths($i)->format('Y-m'));

        $masukPerBulan = UangMasuk::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $keluarPerBulan = UangKeluar::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $grafikBulanan = $bulan->map(fn (string $b): array => [
            'bulan' => $b,
            'label' => now()->parse($b.'-01')->translatedFormat('M Y'),
            'masuk' => (float) ($masukPerBulan[$b] ?? 0),
            'keluar' => (float) ($keluarPerBulan[$b] ?? 0),
        ])->values();

        return view('dashboard', [
            'totalNilaiSpk' => $totalNilaiSpk,
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
            'saldoBersih' => $saldoBersih,
            'masukDariSpk' => $masukDariSpk,
            'masukDariLuar' => $masukDariLuar,
            'totalPiutang' => $totalPiutang,
            'spkPerStatus' => $spkPerStatus,
            'pengeluaranPerKategori' => $pengeluaranPerKategori,
            'spkBerjalan' => $spkBerjalan,
            'grafikBulanan' => $grafikBulanan,
            'jumlahMitra' => Mitra::count(),
            'jumlahSpk' => Spk::count(),
        ]);
    }
}
