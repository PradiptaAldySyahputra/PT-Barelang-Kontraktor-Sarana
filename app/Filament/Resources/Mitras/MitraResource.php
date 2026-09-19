<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras;

use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\Mitras\Pages\CreateMitra;
use App\Filament\Resources\Mitras\Pages\EditMitra;
use App\Filament\Resources\Mitras\Pages\ListMitras;
use App\Filament\Resources\Mitras\Schemas\MitraForm;
use App\Filament\Resources\Mitras\Tables\MitrasTable;
use App\Models\Mitra;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Resource Mitra — pihak terkait (PLN, pelanggan, vendor, subkon).
 *
 * Hak akses (Rules.md §4): Admin = CRUD penuh; Direktur = hanya lihat.
 */
class MitraResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Mitra::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|\UnitEnum|null $navigationGroup = 'Data Mitra';

    protected static ?string $modelLabel = 'Mitra';

    protected static ?string $pluralModelLabel = 'Mitra';

    protected static ?string $recordTitleAttribute = 'nama';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MitraForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MitrasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMitras::route('/'),
            'create' => CreateMitra::route('/create'),
            'edit' => EditMitra::route('/{record}/edit'),
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
