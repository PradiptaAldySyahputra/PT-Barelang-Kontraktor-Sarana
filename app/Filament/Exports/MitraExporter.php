<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\Mitra;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

/**
 * Exporter Data Mitra.
 */
class MitraExporter extends Exporter
{
    protected static ?string $model = Mitra::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')->label('Nama'),
            ExportColumn::make('kategori')->label('Kategori'),
            ExportColumn::make('kontak')->label('Kontak'),
            ExportColumn::make('alamat')->label('Alamat'),
            ExportColumn::make('is_aktif')->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor data mitra selesai — '.number_format($export->successful_rows).' baris tersimpan.';
    }
}
