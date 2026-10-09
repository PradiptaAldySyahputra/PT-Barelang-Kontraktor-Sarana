<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Filament\Resources\Spks\SpkResource;
use App\Support\Format;
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

    /**
     * ⚠️ BUG-02 (uji deploy 7 Okt 2026) — normalisasi nominal SEBELUM form diisi.
     *
     * Cast `decimal:2` menghasilkan string berdesimal `"10000.00"`. Field uang
     * memakai mask Alpine `$money($input, ',', '.')` (`,` desimal, `.` ribuan)
     * DAN `stripCharacters('.')`. Filament menerapkan `StripCharactersStateCast`
     * LEBIH DULU daripada `NumberStateCast` saat hidrasi, sehingga `"10000.00"`
     * kehilangan titiknya menjadi `"1000000"` → tampil **1.000.000** (100×),
     * dan bila disimpan tanpa mengetik ulang database ikut rusak.
     *
     * `formatStateUsing()` TIDAK bisa menolong karena ia berjalan SETELAH cast.
     * Satu-satunya titik yang cukup awal adalah hook ini, yang dipanggil
     * sebelum `$this->form->fill()`.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        foreach (['nilai_spk'] as $kolom) {
            if (isset($data[$kolom])) {
                $data[$kolom] = Format::untukInputUang($data[$kolom]);
            }
        }

        return $data;
    }

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
