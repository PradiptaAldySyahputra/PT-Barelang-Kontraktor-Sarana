<?php

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUangKeluars extends ListRecords
{
    protected static string $resource = UangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
