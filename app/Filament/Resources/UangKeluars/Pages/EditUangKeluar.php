<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Pages;

use App\Filament\Concerns\AksiFormMenempel;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Support\Format;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditUangKeluar extends EditRecord
{
    use AksiFormMenempel;

    protected static string $resource = UangKeluarResource::class;

    protected static ?string $title = 'Ubah Uang Keluar';

    public function getSubheading(): ?string
    {
        return 'Ubah satu catatan pengeluaran. Untuk mencatat banyak nota sekaligus, pakai menu Tambah Uang Keluar.';
    }

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
        /*
         * ⚠️ HAPUS PERMANEN DIBUANG (survei 10 Okt 2026).
         *
         * `Rules.md` §2 butir 9 — WAJIB DIPATUHI:
         *   "Transaksi tidak boleh dihapus permanen — gunakan soft delete
         *    dengan jejak audit."
         *
         * Sebelumnya halaman ini menyediakan `ForceDeleteAction` (tombol
         * "Hapus Permanen") yang membuat baris `uang_keluar` HILANG dari
         * database tanpa bisa dipulihkan — melanggar aturan di atas dan
         * berisiko saat audit/pajak. Sudah dibuktikan bisa dieksekusi.
         *
         * Yang TETAP ada: Hapus (soft delete) + Pulihkan. Data tidak pernah
         * benar-benar lenyap.
         */
        return [
            DeleteAction::make(),
            RestoreAction::make(),
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
