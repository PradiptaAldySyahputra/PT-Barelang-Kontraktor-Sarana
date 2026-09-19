<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Kartu ringkasan di dashboard Filament.
 *
 * Semua angka dihitung on-the-fly dari transaksi (tidak ada tabel ringkasan),
 * sesuai Schema.md §6.
 */
class RingkasanKeuangan extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalNilaiSpk = (float) Spk::sum('nilai_spk');
        $totalUangMasuk = (float) UangMasuk::sum('jumlah');
        $totalUangKeluar = (float) UangKeluar::sum('jumlah');
        $saldoBersih = $totalUangMasuk - $totalUangKeluar;

        $masukDariSpk = (float) UangMasuk::dariSpk()->sum('jumlah');
        $masukDariLuar = (float) UangMasuk::dariLuarSpk()->sum('jumlah');

        $piutang = max(0, $totalNilaiSpk - $masukDariSpk);

        $jumlahSpk = Spk::count();
        $jumlahMitra = Mitra::count();
        $spkBerjalan = Spk::berjalan()->count();

        return [
            Stat::make('Total Nilai SPK', 'Rp '.number_format($totalNilaiSpk, 0, ',', '.'))
                ->description($jumlahSpk.' SPK · '.$spkBerjalan.' berjalan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Uang Masuk', 'Rp '.number_format($totalUangMasuk, 0, ',', '.'))
                ->description('Dari SPK Rp '.number_format($masukDariSpk, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Uang Keluar', 'Rp '.number_format($totalUangKeluar, 0, ',', '.'))
                ->description('Pengeluaran tercatat')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo Bersih', 'Rp '.number_format($saldoBersih, 0, ',', '.'))
                ->description('Masuk − Keluar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($saldoBersih >= 0 ? 'success' : 'danger'),

            Stat::make('Piutang SPK', 'Rp '.number_format($piutang, 0, ',', '.'))
                ->description('Nilai SPK − penerimaan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Uang Masuk Luar SPK', 'Rp '.number_format($masukDariLuar, 0, ',', '.'))
                ->description($jumlahMitra.' mitra terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('gray'),
        ];
    }
}
