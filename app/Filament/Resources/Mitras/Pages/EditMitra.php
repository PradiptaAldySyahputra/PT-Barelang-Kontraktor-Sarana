<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Pages;

use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMitra extends EditRecord
{
    protected static string $resource = MitraResource::class;

    protected static ?string $title = 'Ubah Mitra';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perubahan mitra tersimpan';
    }
}
