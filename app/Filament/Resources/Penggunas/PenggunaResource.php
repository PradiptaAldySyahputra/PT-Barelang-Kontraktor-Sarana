<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas;

use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\Penggunas\Pages\CreatePengguna;
use App\Filament\Resources\Penggunas\Pages\EditPengguna;
use App\Filament\Resources\Penggunas\Pages\ListPenggunas;
use App\Filament\Resources\Penggunas\Schemas\PenggunaForm;
use App\Filament\Resources\Penggunas\Tables\PenggunasTable;
use App\Models\Pengguna;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Resource Pengguna — manajemen akun.
 *
 * HANYA Admin yang boleh mengelola pengguna (Direktur tidak boleh).
 *
 * ⚠️ PENGAMAN SISTEM TERKUNCI (temuan audit keamanan):
 * Admin TIDAK boleh menghapus atau menonaktifkan akunnya SENDIRI.
 * Tanpa pengaman ini, seorang Admin bisa mengunci dirinya keluar dari
 * sistem — dan kalau dia satu-satunya Admin, tidak ada yang bisa
 * mengembalikan akses.
 */
class PenggunaResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Pengguna::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return PenggunaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenggunasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenggunas::route('/'),
            'create' => CreatePengguna::route('/create'),
            'edit' => EditPengguna::route('/{record}/edit'),
        ];
    }

    // ---------------------------------------------------------
    // Hak akses — HANYA Admin
    // ---------------------------------------------------------

    public static function canCreate(): bool
    {
        return auth()->user()?->bolehInput() ?? false;
    }

    /**
     * Ubah data pengguna.
     *
     * Admin boleh mengubah pengguna LAIN, tetapi tidak boleh mengubah
     * dirinya sendiri lewat halaman ini (mencegah menonaktifkan diri
     * sendiri lalu terkunci). Untuk ganti nama/password sendiri, tidak
     * disediakan di MVP — minta Admin lain.
     */
    public static function canEdit($record): bool
    {
        if (! (auth()->user()?->bolehInput() ?? false)) {
            return false;
        }

        return ! static::adalahDiriSendiri($record);
    }

    /**
     * Hapus pengguna.
     *
     * Admin TIDAK boleh menghapus akunnya sendiri — sistem bisa terkunci
     * kalau dia satu-satunya Admin.
     */
    public static function canDelete($record): bool
    {
        if (! (auth()->user()?->bolehInput() ?? false)) {
            return false;
        }

        return ! static::adalahDiriSendiri($record);
    }

    /**
     * Apakah record ini adalah akun yang sedang login?
     */
    protected static function adalahDiriSendiri(mixed $record): bool
    {
        if (! $record instanceof Pengguna) {
            return false;
        }

        return auth()->id() === $record->getKey();
    }
}
