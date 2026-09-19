<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use App\Filament\Widgets\SpkPerStatus;
use App\Filament\Widgets\StatusTagihanChart;
use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

/**
 * Dashboard utama.
 *
 * ⚠️ REVISI USER: "dashboard masih kurang untuk tata letak dan informasi
 * yang disampaikan yang jelas menampilkan ringkasan atau bagian penting
 * dari menu atau fitur."
 *
 * SUSUNAN BARU (2 kolom):
 *
 *   ┌───────────────────────────────────────────────────────┐
 *   │  KARTU RINGKASAN (lebar penuh, 4 baris logis)          │
 *   │  Uang · Pekerjaan · Tagihan · Master                   │
 *   ├───────────────────────────┬───────────────────────────┤
 *   │  Arus Kas (6 bulan)       │  Status Tagihan (donut)   │
 *   ├───────────────────────────┼───────────────────────────┤
 *   │  SPK per Status (donut)   │  ...                      │
 *   ├───────────────────────────┴───────────────────────────┤
 *   │  Perlu Perhatian — SPK Berjalan (tabel, lebar penuh)   │
 *   └───────────────────────────────────────────────────────┘
 *
 * Perubahan dari versi lama:
 *   - Widget "Pengeluaran per Kategori" DIHAPUS — grafiknya pendek
 *     sehingga menyisakan banyak ruang kosong di sebelahnya.
 *   - Ditambah "Status Tagihan" (donut) — pasangan seimbang dengan
 *     "SPK per Status", keduanya pendek sehingga berdampingan rapi.
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
            StatusTagihanChart::class,
            SpkPerStatus::class,
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
        return 'Ringkasan pekerjaan, tagihan, dan arus kas perusahaan';
    }

    /**
     * Widget bawaan Filament yang tidak dipakai.
     *
     * @return array<class-string>
     */
    protected function getHeaderWidgets(): array
    {
        return [];
    }
}
