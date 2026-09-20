<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Filament\Resources\Spks\SpkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Halaman UBAH SPK — data lengkap SPK.
 *
 * ⚠️ STATUS tidak bisa diubah dari sini (hanya ditampilkan). Perubahan
 * status punya halaman sendiri supaya tidak salah ubah data lain:
 *   - UbahStatusSpk      → status pekerjaan
 *   - UbahStatusTagihan  → status tagihan
 */
class EditSpk extends EditRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Ubah SPK';

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
        return 'Perubahan SPK tersimpan';
    }
}
