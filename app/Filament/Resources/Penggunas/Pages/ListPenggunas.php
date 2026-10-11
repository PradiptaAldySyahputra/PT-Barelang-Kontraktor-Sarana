<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas\Pages;

use App\Filament\Resources\Penggunas\PenggunaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPenggunas extends ListRecords
{
    protected static string $resource = PenggunaResource::class;

    protected static ?string $title = 'Daftar Pengguna';

    protected function getHeaderActions(): array
    {
        /*
         * ⚠️ BUG YANG DIPERBAIKI (temuan 10 Okt 2026):
         * Sebelumnya memakai `PenggunaResource::bolehUbahData()` — trait itu
         * memakai `bolehInput()` yang TRUE HANYA untuk Admin. Padahal
         * `PenggunaResource::canCreate()` justru TRUE untuk DIREKTUR (pemilik
         * keputusan kelola akun). Kontradiksi ini membuat tombol "Tambah
         * Pengguna" TIDAK PERNAH muncul untuk Direktur — walau Direktur boleh
         * membuka /penggunas/create. Praktis Direktur tak bisa menambah user.
         *
         * Perbaikan: ikuti OTORISASI Resource yang sebenarnya (`canCreate()`),
         * bukan aturan input-data. Filament juga sudah otomatis menyembunyikan
         * tombol bila `canCreate()` false — tapi `->visible()` eksplisit ini
         * menjaga niat tetap terbaca jelas.
         */
        return [
            CreateAction::make()
                ->visible(fn (): bool => PenggunaResource::canCreate())
                ->label('Tambah Pengguna'),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'Akun yang boleh masuk sistem. Ada 2 peran: Admin (input data) & Direktur (hanya melihat). '
            .'Pengguna nonaktif tidak bisa login.';
    }
}
