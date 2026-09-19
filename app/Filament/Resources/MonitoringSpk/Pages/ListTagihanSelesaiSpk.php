<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk\Pages;

use App\Filament\Resources\MonitoringSpk\TagihanSelesaiSpkResource;
use Filament\Resources\Pages\ListRecords;

/**
 * Daftar Tagihan Selesai SPK — riwayat/arsip (baca saja).
 */
class ListTagihanSelesaiSpk extends ListRecords
{
    protected static string $resource = TagihanSelesaiSpkResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getSubheading(): ?string
    {
        return 'Riwayat SPK yang tagihannya sudah selesai (dibayar).';
    }
}
