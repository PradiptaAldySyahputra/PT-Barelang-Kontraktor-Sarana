<?php

namespace App\Filament\Resources\UangMasuks;

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

class UangMasukResource extends Resource
{
    protected static ?string $model = UangMasuk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UangMasukForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UangMasuksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUangMasuks::route('/'),
            'create' => CreateUangMasuk::route('/create'),
            'edit' => EditUangMasuk::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
