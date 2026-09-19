<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Pages;

use App\Filament\Resources\UangMasuks\UangMasukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUangMasuks extends ListRecords
{
    protected static string $resource = UangMasukResource::class;

    protected static ?string $title = 'Daftar Uang Masuk';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData())->label('Tambah Uang Masuk'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua'),

            'dari_spk' => Tab::make('Dari SPK')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('spk_id'))
                ->badge(fn (): int => UangMasukResource::getModel()::dariSpk()->count()),

            'luar_spk' => Tab::make('Luar SPK')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('spk_id'))
                ->badge(fn (): int => UangMasukResource::getModel()::dariLuarSpk()->count()),
        ];
    }
}
