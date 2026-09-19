<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\PengeluaranPerKategori;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use App\Filament\Widgets\SpkPerStatus;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

/**
 * Dashboard utama.
 *
 * Mengatur urutan & tata letak widget supaya informasinya mengalir:
 *   1. Kartu ringkasan (angka terpenting lebih dulu)
 *   2. Grafik arus kas + status SPK (berdampingan)
 *   3. Tabel SPK berjalan (laba/rugi)
 */
class Dashboard extends BaseDashboard
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = -10;

    /**
     * Widget yang tampil, sesuai urutan.
     *
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            RingkasanKeuangan::class,
            GrafikArusKas::class,
            SpkPerStatus::class,
            PengeluaranPerKategori::class,
            SpkBerjalan::class,
        ];
    }

    /**
     * Jumlah kolom grid dashboard.
     */
    public function getColumns(): int|array
    {
        return 2;
    }

    public function getSubheading(): ?string
    {
        return 'Ringkasan SPK, arus kas, dan laba-rugi per SPK';
    }

    /**
     * Widget bawaan Filament yang tidak dipakai (profil akun sudah ada di menu atas).
     *
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
