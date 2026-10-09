<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Pages;

use App\Filament\Resources\UangMasuks\UangMasukResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUangMasuk extends CreateRecord
{
    protected static string $resource = UangMasukResource::class;

    protected static ?string $title = 'Tambah Uang Masuk';

    public function getSubheading(): ?string
    {
        return 'Pilih dulu SUMBER penerimaan: "Berdasarkan SPK" (penagihan pekerjaan) atau "Manual" (di luar SPK). '
            .'Kolom yang muncul menyesuaikan pilihan itu.';
    }

    /**
     * Pastikan `spk_id` kosong saat mode manual, agar sumbernya
     * tersimpul benar sebagai "Luar SPK".
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['mode'] ?? 'spk') === 'manual') {
            $data['spk_id'] = null;
        }

        unset($data['mode']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Uang masuk berhasil dicatat';
    }
}
