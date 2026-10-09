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
        return [
            CreateAction::make()->visible(fn (): bool => PenggunaResource::bolehUbahData())->label('Tambah Pengguna'),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'Akun yang boleh masuk sistem. Ada 2 peran: Admin (input data) & Direktur (hanya melihat). '
            .'Pengguna nonaktif tidak bisa login.';
    }
}
