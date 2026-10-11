<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Pages;

use App\Filament\Concerns\AksiFormMenempel;
use App\Filament\Resources\Mitras\MitraResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMitra extends CreateRecord
{
    use AksiFormMenempel;

    protected static string $resource = MitraResource::class;

    protected static ?string $title = 'Tambah Mitra';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Mitra berhasil disimpan';
    }
}
