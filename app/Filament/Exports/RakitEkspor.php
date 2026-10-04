<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use Filament\Actions\Exports\Enums\Contracts\ExportFormat;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Collection;

/**
 * Menyusun HEADER + BARIS dari sebuah Exporter Filament, tanpa menjalankan
 * pipeline ekspor bawaan (job + tabel `exports`).
 *
 * ⚠️ KENAPA PERLU:
 * `ExportAction` bawaan Filament hanya mendukung CSV & XLSX — TIDAK ada PDF.
 * Untuk menu yang butuh PDF (permintaan pengguna: "tambah tombol PDF di semua
 * menu"), isi tabel harus diambil langsung dari kolom exporter yang SAMA,
 * supaya isi PDF identik dengan isi Excel/CSV (satu sumber definisi kolom).
 *
 * Formatter kolom tetap dipakai lewat `Exporter::__invoke()` — jadi tanggal
 * `d/m/Y`, label enum `Kas`/`Material`, dst. konsisten di semua format.
 */
class RakitEkspor
{
    /**
     * @param  class-string<Exporter>  $exporterClass
     * @return array{header: list<string>, baris: list<list<mixed>>}
     */
    public static function susun(string $exporterClass, iterable $records): array
    {
        $columns = $exporterClass::getVisibleColumns();

        $header = [];
        $columnMap = [];

        foreach ($columns as $column) {
            $nama = $column->getName();
            $label = (string) $column->getLabel();

            $header[] = $label;
            $columnMap[$nama] = $label;
        }

        $exporter = new $exporterClass(new Export, $columnMap, []);

        $baris = [];

        foreach ($records as $record) {
            $baris[] = array_map(
                fn (mixed $nilai): mixed => $nilai instanceof ExportFormat ? $nilai->value : $nilai,
                $exporter($record),
            );
        }

        return ['header' => $header, 'baris' => $baris];
    }

    /**
     * Susun dari collection Eloquent/array apa pun.
     *
     * @param  class-string<Exporter>  $exporterClass
     * @return array{header: list<string>, baris: list<list<mixed>>}
     */
    public static function susunDari(string $exporterClass, Collection $records): array
    {
        return self::susun($exporterClass, $records->all());
    }
}
