<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Pages;

use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Support\Format;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUangMasuk extends EditRecord
{
    protected static string $resource = UangMasukResource::class;

    protected static ?string $title = 'Ubah Uang Masuk';

    /**
     * ⚠️ BUG-02 — normalisasi nominal sebelum form diisi (lihat EditSpk).
     * Tanpa ini `"10000.00"` tampil `1.000.000` (100× lipat).
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['jumlah'])) {
            $data['jumlah'] = Format::untukInputUang($data['jumlah']);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perubahan uang masuk tersimpan';
    }
}
