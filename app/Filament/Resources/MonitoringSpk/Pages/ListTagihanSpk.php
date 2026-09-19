<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk\Pages;

use App\Filament\Resources\MonitoringSpk\TagihanSpkResource;
use Filament\Resources\Pages\ListRecords;

/**
 * Daftar Tagihan SPK — monitoring tagihan yang belum selesai (baca saja).
 */
class ListTagihanSpk extends ListRecords
{
    protected static string $resource = TagihanSpkResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getSubheading(): ?string
    {
        return 'Tagihan yang belum selesai — pantau umur piutang & sisa yang harus ditagih.';
    }
}
