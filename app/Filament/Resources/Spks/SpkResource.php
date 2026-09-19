<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks;

use App\Filament\Concerns\BolehUbahData;
use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Filament\Resources\Spks\Pages\EditSpk;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Filament\Resources\Spks\Schemas\SpkForm;
use App\Filament\Resources\Spks\Tables\SpksTable;
use App\Models\Spk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource SPK — ENTITAS INTI sistem.
 *
 * Hak akses (Rules.md §4):
 *   - Admin   : boleh lihat, tambah, ubah, hapus
 *   - Direktur: HANYA boleh lihat
 *
 * Tidak ada entitas PROYEK (keputusan user) dan tidak ada approval.
 */
class SpkResource extends Resource
{
    use BolehUbahData;

    protected static ?string $model = Spk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'SPK';

    protected static ?string $modelLabel = 'SPK';

    protected static ?string $pluralModelLabel = 'SPK';

    protected static ?string $navigationLabel = 'List SPK';

    protected static ?string $recordTitleAttribute = 'nomor_spk';

    protected static ?int $navigationSort = 1; // paling atas di grup SPK

    public static function form(Schema $schema): Schema
    {
        return SpkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpksTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->withSum('uangMasuk as total_masuk', 'jumlah')
            ->withSum('uangKeluar as total_keluar', 'jumlah');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpks::route('/'),
            'create' => CreateSpk::route('/create'),
            'edit' => EditSpk::route('/{record}/edit'),
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
