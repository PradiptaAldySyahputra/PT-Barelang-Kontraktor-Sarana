<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\UangMasuk;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Carbon;

/**
 * Exporter Uang Masuk.
 *
 * Dipakai menu Uang Masuk. ExportAction menghormati filter aktif
 * (mis. bulan + akun) — untuk permintaan bagian pajak.
 *
 * ⚠️ FORMAT ISIAN: tanggal dibuat `d/m/Y` dan akun berlabel `Kas`/`Bank`,
 * supaya berkas yang diserahkan langsung rapi (lihat UangKeluarExporter).
 */
class UangMasukExporter extends Exporter
{
    protected static ?string $model = UangMasuk::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('tanggal')
                ->label('Tanggal')
                ->formatStateUsing(fn ($state): string => $state
                    ? Carbon::parse($state)->format('d/m/Y')
                    : ''),

            ExportColumn::make('akun')
                ->label('Akun')
                ->formatStateUsing(fn ($state): string => $state?->label() ?? 'Kas'),

            ExportColumn::make('nomor_spk')->label('Nomor SPK'),

            ExportColumn::make('nama_pekerjaan')->label('Nama Pekerjaan'),

            ExportColumn::make('mitra.nama')->label('Mitra'),

            ExportColumn::make('jumlah')->label('Jumlah'),

            ExportColumn::make('keterangan')->label('Keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor uang masuk selesai — '.number_format($export->successful_rows).' baris tersimpan.';
    }
}
