<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk\Pages;

use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use Filament\Resources\Pages\ListRecords;

/**
 * Daftar Status SPK — monitoring.
 *
 * Status BISA diubah langsung dari tabel (klik kolom Status) atau lewat
 * tombol "Ubah Status". Data lain tetap harus lewat menu List SPK.
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
        return 'Klik kolom Status untuk mengubahnya langsung. Data lain diubah lewat menu List SPK.';
    }
}
