<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\Peran;
use App\Enums\StatusTagihan;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\Format;
use App\Support\SaldoKas;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * RINGKASAN DIREKTUR (B3-12) — dashboard ringkas khusus Direktur.
 *
 * ⚠️ KENAPA PERLU:
 * Dashboard lengkap dirancang untuk ADMIN yang menginput data (grafik rinci,
 * tabel SPK berjalan, dsb). Direktur hanya butuh ANGKA KUNCI untuk memantau
 * perusahaan sekilas — jadi widget ini menampilkan SATU baris angka penting:
 * nilai pekerjaan, uang masuk/keluar, sisa tagihan, saldo, dan pekerjaan
 * bermasalah (lewat tenggat).
 *
 * Hanya tampil untuk peran Direktur (`canView()`).
 */
class RingkasanDirektur extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    /**
     * Hanya Direktur yang melihat widget ini.
     */
    public static function canView(): bool
    {
        return auth()->user()?->peran === Peran::Direktur;
    }

    protected function getStats(): array
    {
        $nilaiSpk = (float) Spk::sum('nilai_spk');
        $masuk = (float) UangMasuk::sum('jumlah');
        $keluar = (float) UangKeluar::sum('jumlah');
        $belumDiterima = max(0, $nilaiSpk - $masuk);

        $lewatTenggat = Spk::lewatTenggat()->count();
        $belumLunas = Spk::where('status_tagihan', '!=', StatusTagihan::Dibayar->value)
            ->orWhereNull('status_tagihan')
            ->count();

        $saldo = SaldoKas::ringkasan();

        return [
            Stat::make('Nilai Pekerjaan', Format::rupiah($nilaiSpk))
                ->description(Spk::count().' SPK')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Uang Masuk', Format::rupiah($masuk))
                ->description('Total penerimaan')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success'),

            Stat::make('Uang Keluar', Format::rupiah($keluar))
                ->description('Total pengeluaran')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('danger'),

            Stat::make('Belum Diterima', Format::rupiah($belumDiterima))
                ->description($belumLunas.' SPK belum lunas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($belumDiterima > 0 ? 'warning' : 'success'),

            Stat::make('Total Saldo', Format::rupiah($saldo['total']))
                ->description('Kas '.Format::rupiah($saldo['kas']).' · Bank '.Format::rupiah($saldo['bank']))
                ->descriptionIcon('heroicon-m-wallet')
                ->color($saldo['total'] < 0 ? 'danger' : 'primary'),

            Stat::make('Lewat Tenggat', (string) $lewatTenggat)
                ->description($lewatTenggat > 0 ? 'Perlu ditindaklanjuti' : 'Semua sesuai jadwal')
                ->descriptionIcon($lewatTenggat > 0
                    ? 'heroicon-m-exclamation-triangle'
                    : 'heroicon-m-check-circle')
                ->color($lewatTenggat > 0 ? 'danger' : 'success'),
        ];
    }
}
