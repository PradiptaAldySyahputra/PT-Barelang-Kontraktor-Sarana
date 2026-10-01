<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\Spk;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

/**
 * Exporter SPK — dipakai bersama oleh semua menu berbasis SPK
 * (List SPK, Status SPK, Tagihan SPK, Tagihan Selesai SPK).
 *
 * ⚠️ KENAPA SATU EXPORTER UNTUK BANYAK MENU:
 * Keempat menu itu menampilkan MODEL YANG SAMA (`spk`) dengan filter berbeda.
 * Karena ExportAction menghormati filter yang sedang aktif, satu exporter
 * sudah cukup — dan kolomnya jadi konsisten di semua menu (tidak ada menu
 * yang mengekspor kolom berbeda tanpa disadari).
 */
class SpkExporter extends Exporter
{
    protected static ?string $model = Spk::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('nomor_spk')->label('Nomor SPK'),
            ExportColumn::make('tanggal_spk')->label('Tanggal SPK'),
            ExportColumn::make('tanggal_akhir')->label('Tenggat'),
            ExportColumn::make('nama_pekerjaan')->label('Nama Pekerjaan'),
            ExportColumn::make('lokasi')->label('Lokasi'),
            ExportColumn::make('mitra.nama')->label('Pemberi Kerja'),
            ExportColumn::make('nilai_spk')->label('Nilai SPK'),
            ExportColumn::make('totalPenerimaan')->label('Sudah Diterima'),
            ExportColumn::make('sisaTagih')->label('Belum Diterima'),
            ExportColumn::make('status_spk')->label('Status Pekerjaan'),
            ExportColumn::make('status_tagihan')->label('Status Tagihan'),
            ExportColumn::make('dikerjakan_oleh')->label('Dikerjakan Oleh'),
            ExportColumn::make('subkon.nama')->label('Mitra Subkon'),
            ExportColumn::make('jenis_sumber')->label('Jenis Sumber'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Ekspor SPK selesai — '.number_format($export->successful_rows).' baris tersimpan.';
    }
}
