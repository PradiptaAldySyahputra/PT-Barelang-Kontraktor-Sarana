<?php

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUangKeluar extends EditRecord
{
    protected static string $resource = UangKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
