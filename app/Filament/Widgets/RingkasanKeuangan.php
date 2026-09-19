<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

/**
 * Kartu ringkasan di dashboard.
 *
 * Semua angka dihitung on-the-fly dari transaksi (tidak ada tabel ringkasan),
 * sesuai Schema.md §6.
 *
 * Setiap kartu menampilkan angka utama + konteks pembanding bulan lalu,
 * supaya angkanya bisa dibaca, bukan sekadar deretan nomor.
 */
class RingkasanKeuangan extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $bulanIni = now()->startOfMonth();
        $bulanLalu = now()->subMonth()->startOfMonth();
        $akhirBulanLalu = now()->subMonth()->endOfMonth();

        // ---------------------------------------------------------
        // Total keseluruhan
        // ---------------------------------------------------------
        $totalNilaiSpk = (float) Spk::sum('nilai_spk');
        $totalMasuk = (float) UangMasuk::sum('jumlah');
        $totalKeluar = (float) UangKeluar::sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        $masukDariSpk = (float) UangMasuk::dariSpk()->sum('jumlah');
        $masukLuarSpk = (float) UangMasuk::dariLuarSpk()->sum('jumlah');

        $piutang = max(0, $totalNilaiSpk - $masukDariSpk);

        // ---------------------------------------------------------
        // Bulan ini vs bulan lalu (untuk konteks)
        // ---------------------------------------------------------
        $masukBulanIni = (float) UangMasuk::where('tanggal', '>=', $bulanIni)->sum('jumlah');
        $masukBulanLalu = (float) UangMasuk::whereBetween('tanggal', [$bulanLalu, $akhirBulanLalu])->sum('jumlah');

        $keluarBulanIni = (float) UangKeluar::where('tanggal', '>=', $bulanIni)->sum('jumlah');
        $keluarBulanLalu = (float) UangKeluar::whereBetween('tanggal', [$bulanLalu, $akhirBulanLalu])->sum('jumlah');

        // ---------------------------------------------------------
        // Jumlah data
        // ---------------------------------------------------------
        $jumlahSpk = Spk::count();
        $spkBerjalan = Spk::berjalan()->count();
        $spkBelumLunas = Spk::belumLunas()->count();
        $jumlahMitra = Mitra::count();

        return [
            Stat::make('Nilai SPK', $this->rupiah($totalNilaiSpk))
                ->description($jumlahSpk.' SPK · '.$spkBerjalan.' berjalan')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart($this->trenSpk())
                ->color('primary'),

            Stat::make('Uang Masuk', $this->rupiah($totalMasuk))
                ->description($this->banding($masukBulanIni, $masukBulanLalu, 'bulan ini'))
                ->descriptionIcon($masukBulanIni >= $masukBulanLalu
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->chart($this->trenMasuk())
                ->color('success'),

            Stat::make('Uang Keluar', $this->rupiah($totalKeluar))
                ->description($this->banding($keluarBulanIni, $keluarBulanLalu, 'bulan ini'))
                ->descriptionIcon($keluarBulanIni >= $keluarBulanLalu
                    ? 'heroicon-m-arrow-trending-up'
                    : 'heroicon-m-arrow-trending-down')
                ->chart($this->trenKeluar())
                ->color('danger'),

            Stat::make('Saldo Bersih', $this->rupiah($saldo))
                ->description('Uang masuk − uang keluar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($saldo >= 0 ? 'success' : 'danger'),

            Stat::make('Piutang SPK', $this->rupiah($piutang))
                ->description($spkBelumLunas.' SPK belum lunas')
                ->descriptionIcon('heroicon-m-clock')
                ->color($piutang > 0 ? 'warning' : 'success'),

            Stat::make('Penerimaan Luar SPK', $this->rupiah($masukLuarSpk))
                ->description($jumlahMitra.' mitra terdaftar')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
        ];
    }

    // ---------------------------------------------------------
    // Helper
    // ---------------------------------------------------------

    protected function rupiah(float $nilai): string
    {
        return 'Rp '.number_format($nilai, 0, ',', '.');
    }

    /**
     * Teks pembanding bulan ini vs bulan lalu.
     */
    protected function banding(float $ini, float $lalu, string $label): string
    {
        if ($lalu <= 0 && $ini <= 0) {
            return 'Belum ada transaksi '.$label;
        }

        if ($lalu <= 0) {
            return $this->rupiah($ini).' '.$label;
        }

        $persen = (($ini - $lalu) / $lalu) * 100;
        $arah = $persen >= 0 ? 'naik' : 'turun';

        return sprintf(
            '%s %s %.0f%% vs bulan lalu',
            $this->rupiah($ini),
            $arah,
            abs($persen)
        );
    }

    /**
     * Data tren untuk sparkline (6 bulan terakhir).
     *
     * @return array<int, float>
     */
    protected function trenMasuk(): array
    {
        return $this->tren(fn (Carbon $awal, Carbon $akhir): float => (float) UangMasuk::query()
            ->whereBetween('tanggal', [$awal, $akhir])
            ->sum('jumlah'));
    }

    /**
     * @return array<int, float>
     */
    protected function trenKeluar(): array
    {
        return $this->tren(fn (Carbon $awal, Carbon $akhir): float => (float) UangKeluar::query()
            ->whereBetween('tanggal', [$awal, $akhir])
            ->sum('jumlah'));
    }

    /**
     * @return array<int, float>
     */
    protected function trenSpk(): array
    {
        return $this->tren(fn (Carbon $awal, Carbon $akhir): float => (float) Spk::query()
            ->whereBetween('tanggal_spk', [$awal, $akhir])
            ->sum('nilai_spk'));
    }

    /**
     * @param  callable(Carbon, Carbon): float  $hitung
     * @return array<int, float>
     */
    protected function tren(callable $hitung): array
    {
        return collect(range(5, 0))
            ->map(function (int $i) use ($hitung): float {
                $awal = now()->subMonths($i)->startOfMonth();
                $akhir = now()->subMonths($i)->endOfMonth();

                return $hitung($awal, $akhir);
            })
            ->all();
    }
}
