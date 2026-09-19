<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Pages;

use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMitras extends ListRecords
{
    protected static string $resource = MitraResource::class;

    protected static ?string $title = 'Daftar Mitra';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => MitraResource::bolehUbahData())->label('Tambah Mitra'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua'),

            'aktif' => Tab::make('Aktif')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_aktif', true)),

            'pln' => Tab::make('PLN')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('kategori', 'pln')),

            'subkon_vendor' => Tab::make('Subkon & Vendor')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('kategori', ['subkon', 'vendor'])),
        ];
    }
}
