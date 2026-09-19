<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk\Pages;

use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use Filament\Resources\Pages\ListRecords;

/**
 * Daftar Status SPK — monitoring (baca saja).
 *
 * Halaman ini sengaja TIDAK punya tombol "Tambah" karena hanya untuk
 * memantau. Perubahan data lewat "List SPK".
 */
class ListStatusSpk extends ListRecords
{
    protected static string $resource = StatusSpkResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getSubheading(): ?string
    {
        return 'Pantau status pekerjaan & tenggat. Untuk mengubah data, buka menu List SPK.';
    }
}
