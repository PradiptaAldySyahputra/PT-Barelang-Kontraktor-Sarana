<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks;

use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Filament\Resources\UangMasuks\Pages\EditUangMasuk;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Filament\Resources\UangMasuks\Schemas\UangMasukForm;
use App\Filament\Resources\UangMasuks\Tables\UangMasuksTable;
use App\Models\UangMasuk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Uang Masuk — penerimaan dana.
 *
 * Form 2 mode: Berdasarkan SPK / Manual (luar SPK).
 * Sumber disimpulkan dari `spk_id`, bukan kolom tersimpan.
 *
 * Hak akses (Rules.md §4): Admin = CRUD penuh; Direktur = hanya lihat.
 */
class UangMasukResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = UangMasuk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $modelLabel = 'Uang Masuk';

    protected static ?string $pluralModelLabel = 'Uang Masuk';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return UangMasukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UangMasuksTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUangMasuks::route('/'),
            'create' => CreateUangMasuk::route('/create'),
            'edit' => EditUangMasuk::route('/{record}/edit'),
        ];
    }

    // ---------------------------------------------------------
    // Hak akses — hanya Admin yang boleh mengubah data
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
