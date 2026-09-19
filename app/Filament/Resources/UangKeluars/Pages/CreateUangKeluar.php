<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUangKeluar extends CreateRecord
{
    protected static string $resource = UangKeluarResource::class;

    protected static ?string $title = 'Tambah Uang Keluar';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Uang keluar berhasil dicatat';
    }
}
