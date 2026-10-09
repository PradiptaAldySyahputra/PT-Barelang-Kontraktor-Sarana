<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Support\Format;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUangKeluar extends EditRecord
{
    protected static string $resource = UangKeluarResource::class;

    protected static ?string $title = 'Ubah Uang Keluar';

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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Perubahan uang keluar tersimpan';
    }
}
