<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\UangKeluar;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Carbon;

/**
 * Exporter Uang Keluar.
 *
 * Dipakai menu Uang Keluar. ExportAction menghormati filter aktif
 * (mis. bulan + akun + kategori) — inilah yang dibutuhkan admin saat bagian
 * pajak meminta "tanggal sekian, bulan sekian".
 *
 * ⚠️ FORMAT ISIAN (audit 26 Sep 2026):
 * Sebelumnya berkas ekspor berisi nilai MENTAH: tanggal `2026-09-25 00:00:00`
 * dan akun `kas` (huruf kecil). Berkas ini diserahkan ke pihak luar, jadi
 * formatnya diperbaiki agar langsung rapi: tanggal `25/09/2026`, akun `Kas`,
 * kategori `Material`, dst.
 */
class UangKeluarExporter extends Exporter
{
    protected static ?string $model = UangKeluar::class;

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

            ExportColumn::make('kategori')
                ->label('Kategori')
                ->formatStateUsing(fn ($state): string => $state?->label() ?? ''),

            ExportColumn::make('spk.nomor_spk')->label('Nomor SPK'),

            ExportColumn::make('penerima')->label('Penerima'),

            ExportColumn::make('jumlah')->label('Jumlah'),

            ExportColumn::make('keterangan')->label('Keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor uang keluar selesai — '.number_format($export->successful_rows).' baris tersimpan.';
    }
}
