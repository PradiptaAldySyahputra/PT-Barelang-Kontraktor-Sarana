<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Filament\Resources\Spks\SpkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSpk extends CreateRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Tambah SPK';

    /**
     * Isi `dibuat_oleh` otomatis dari pengguna yang login.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dibuat_oleh'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'SPK berhasil disimpan';
    }
}
