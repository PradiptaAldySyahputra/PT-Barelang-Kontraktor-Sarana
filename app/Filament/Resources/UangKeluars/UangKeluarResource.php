<?php

namespace App\Filament\Resources\UangKeluars;

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

class UangKeluarResource extends Resource
{
    protected static ?string $model = UangKeluar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UangKeluarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UangKeluarsTable::configure($table);
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
            'index' => ListUangKeluars::route('/'),
            'create' => CreateUangKeluar::route('/create'),
            'edit' => EditUangKeluar::route('/{record}/edit'),
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
