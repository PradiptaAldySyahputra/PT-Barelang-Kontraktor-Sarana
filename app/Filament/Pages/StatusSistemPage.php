<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Support\StatusSistem;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

/**
 * HALAMAN STATUS SISTEM (B2-10).
 *
 * ⚠️ KENAPA PERLU:
 * Satu halaman untuk non-teknisi (Direktur) memantau kesehatan sistem:
 * database, queue worker, backup terakhir, penyimpanan, versi. Tanpa ini,
 * masalah hanya ketahuan setelah fatal.
 *
 * ⚠️ KHUSUS ADMIN: berisi info teknis (path, versi). Direktur read-only
 * tidak perlu.
 */
class StatusSistemPage extends Page
{
    protected string $view = 'filament.pages.status-sistem';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedServerStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?string $navigationLabel = 'Status Sistem';

    protected static ?string $title = 'Status Sistem';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        /** @var Pengguna|null $user */
        $user = Auth::user();

        return $user?->peran === Peran::Admin;
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Pantau kesehatan sistem: database, queue, backup, penyimpanan.';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'status' => StatusSistem::semua(),
        ];
    }
}
