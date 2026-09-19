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
 * HANYA Admin yang boleh mengelola pengguna (termasuk Direktur tidak
 * boleh menambah akun). Ini lebih ketat dari resource lain karena
 * menyangkut hak akses.
 */
class PenggunaResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Pengguna::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';

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

    public static function canEdit($record): bool
    {
        return auth()->user()?->bolehInput() ?? false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()?->bolehInput() ?? false;
    }
}
