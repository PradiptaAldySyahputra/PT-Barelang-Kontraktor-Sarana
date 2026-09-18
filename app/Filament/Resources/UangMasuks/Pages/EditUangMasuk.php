<?php

namespace App\Filament\Resources\UangMasuks\Pages;

use App\Filament\Resources\UangMasuks\UangMasukResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUangMasuk extends EditRecord
{
    protected static string $resource = UangMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
