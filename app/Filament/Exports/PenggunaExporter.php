<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\Pengguna;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

/**
 * Exporter Daftar Pengguna.
 *
 * ⚠️ `password` TIDAK diekspor — sengaja, agar hash password tidak
 * ikut tersebar dalam berkas Excel.
 */
class PenggunaExporter extends Exporter
{
    protected static ?string $model = Pengguna::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nama')->label('Nama'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('peran')->label('Peran'),
            ExportColumn::make('is_aktif')->label('Aktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor daftar pengguna selesai — '.number_format($export->successful_rows).' baris tersimpan.';
    }
}
