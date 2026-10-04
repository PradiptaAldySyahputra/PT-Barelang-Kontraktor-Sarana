<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Exports\RakitEkspor;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\Exports\Exporter;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Aksi "Ekspor PDF" untuk SEMUA menu tabel.
 *
 * ⚠️ KENAPA DIBUAT SENDIRI:
 * `ExportAction` bawaan Filament hanya mendukung CSV & XLSX. Tidak ada opsi
 * PDF. Pengguna meminta PDF tersedia di semua menu (SPK, Status SPK, Tagihan
 * SPK, Tagihan Selesai, Mitra, Pengguna, Uang Masuk, Uang Keluar).
 *
 * ⚠️ SATU SUMBER DEFINISI KOLOM:
 * Isi PDF diambil dari **exporter yang sama** dengan Excel/CSV
 * (`RakitEkspor`), sehingga kolom & format tanggal/enum/rupiah selalu sama.
 * Tidak ada risiko kolom PDF berbeda diam-diam dari Excel.
 *
 * ⚠️ MENGHORMATI FILTER:
 * Aksi ini memakai `$livewire->getTableQueryForExport()` (mekanisme yang sama
 * dengan ExportAction bawaan), jadi PDF mengikuti filter & pencarian yang
 * sedang aktif — bukan seluruh tabel.
 */
class EksporPdf
{
    /**
     * @param  class-string<Exporter>  $exporterClass
     */
    public static function make(string $exporterClass, ?string $judul = null): Action
    {
        return Action::make('eksporPdf')
            ->label('Ekspor PDF')
            ->icon('heroicon-m-document-text')
            ->color('gray')
            ->action(function ($livewire) use ($exporterClass, $judul): StreamedResponse {
                $query = method_exists($livewire, 'getTableQueryForExport')
                    ? $livewire->getTableQueryForExport()
                    : $exporterClass::getModel()::query();

                $query = $exporterClass::modifyQuery($query);

                return self::unduh($exporterClass, $query->get(), $judul ?? 'Data');
            });
    }

    /**
     * Bangun & kembalikan berkas PDF. Dipisah supaya bisa diuji langsung.
     *
     * @param  class-string<Exporter>  $exporterClass
     * @param  iterable<mixed>  $records
     */
    public static function unduh(string $exporterClass, iterable $records, string $judul): StreamedResponse
    {
        if ($records instanceof Collection) {
            $records = $records->all();
        }

        $susunan = RakitEkspor::susun($exporterClass, $records);

        $pdf = Pdf::loadView('filament.exports.tabel-pdf', [
            'judul' => $judul,
            'header' => $susunan['header'],
            'baris' => $susunan['baris'],
        ])->setPaper('a4', 'landscape');

        $namaFile = str($judul)->slug().'-'.now()->format('Y-m-d').'.pdf';

        return response()->streamDownload(
            function () use ($pdf): void {
                echo $pdf->output();
            },
            $namaFile,
            ['Content-Type' => 'application/pdf'],
        );
    }
}
