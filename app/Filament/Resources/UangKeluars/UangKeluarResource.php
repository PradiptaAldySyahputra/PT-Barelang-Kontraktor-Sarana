<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars;

use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\Pages\EditUangKeluar;
use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Filament\Resources\UangKeluars\Tables\UangKeluarsTable;
use App\Models\UangKeluar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Uang Keluar — pengeluaran.
 *
 * `spk_id` opsional: pengeluaran terkait SPK akan mengurangi laba SPK tsb.
 * TIDAK ADA approval Direktur (keputusan user 19 Sep 2026).
 *
 * Hak akses (Rules.md §4): Admin = CRUD penuh; Direktur = hanya lihat.
 */
class UangKeluarResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = UangKeluar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowTrendingDown;

    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?string $modelLabel = 'Uang Keluar';

    protected static ?string $pluralModelLabel = 'Uang Keluar';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return UangKeluarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UangKeluarsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUangKeluars::route('/'),
            'create' => CreateUangKeluar::route('/create'),
            'edit' => EditUangKeluar::route('/{record}/edit'),
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
