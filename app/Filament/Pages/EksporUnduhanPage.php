<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Support\RiwayatEkspor;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

/**
 * HALAMAN EKSPOR & UNDUHAN (peta menu C).
 *
 * ⚠️ KENAPA PERLU:
 * Riwayat ekspor (Excel/CSV) yang pernah dibuat — supaya admin bisa mengunduh
 * ulang tanpa menunggu notifikasi, dan melihat ekspor yang masih diproses/gagal.
 *
 * ⚠️ Data dari tabel `exports` bawaan Filament; TIDAK ada tabel baru.
 */
class EksporUnduhanPage extends Page
{
    protected string $view = 'filament.pages.ekspor-unduhan';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;

    protected static string|\UnitEnum|null $navigationGroup = 'Laporan';

    protected static ?string $navigationLabel = 'Ekspor & Unduhan';

    protected static ?string $title = 'Ekspor & Unduhan';

    protected static ?int $navigationSort = 32;

    public function getSubheading(): string|Htmlable|null
    {
        return 'Riwayat berkas ekspor — unduh ulang kapan saja.';
    }

    /**
     * Riwayat ekspor: Admin melihat miliknya; Direktur boleh melihat semua
     * (read-only, tidak mengubah data).
     */
    public static function canAccess(): bool
    {
        /** @var Pengguna|null $user */
        $user = Auth::user();

        return $user !== null && in_array($user->peran, [Peran::Admin, Peran::Direktur], true);
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        /** @var Pengguna $user */
        $user = Auth::user();

        // Admin hanya melihat riwayatnya sendiri; Direktur melihat semua.
        $batasi = $user->peran === Peran::Admin ? (int) $user->getKey() : null;

        return [
            'riwayat' => RiwayatEkspor::daftar($batasi),
        ];
    }
}
