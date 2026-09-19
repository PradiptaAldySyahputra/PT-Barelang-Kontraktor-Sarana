<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUangKeluars extends ListRecords
{
    protected static string $resource = UangKeluarResource::class;

    protected static ?string $title = 'Daftar Uang Keluar';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData())->label('Tambah Uang Keluar'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua'),

            'terkait_spk' => Tab::make('Terkait SPK')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('spk_id')),

            'umum' => Tab::make('Umum / Operasional')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('spk_id')),
        ];
    }
}
