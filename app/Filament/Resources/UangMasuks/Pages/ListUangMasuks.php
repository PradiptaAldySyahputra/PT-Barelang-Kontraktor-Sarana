<?php

namespace App\Filament\Resources\UangMasuks\Pages;

use App\Filament\Resources\UangMasuks\UangMasukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUangMasuks extends ListRecords
{
    protected static string $resource = UangMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
