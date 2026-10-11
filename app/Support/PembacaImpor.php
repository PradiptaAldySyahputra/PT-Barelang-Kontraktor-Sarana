<?php

declare(strict_types=1);

namespace App\Support;

use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;

/**
 * Pembaca berkas impor (B3-13) — XLSX/CSV → array baris asosiatif.
 *
 * ⚠️ KENAPA PERLU:
 * Admin memigrasi data awal dari Excel. Pembaca ini mengubah baris pertama
 * (header) menjadi KUNCI, sehingga sisa berkas bisa dipetakan ke kolom model
 * tanpa peduli urutan kolom.
 *
 * Header yang dikenali (huruf kecil, tanpa spasi):
 *   tanggal | jumlah | akun | kategori | penerima | keterangan | spk_id |
 *   nomor_spk | nama_pekerjaan
 */
final class PembacaImpor
{
    /**
     * @return list<array<string, mixed>>
     */
    public static function baca(string $path): array
    {
        $ekstensi = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $reader = match ($ekstensi) {
            'csv' => new CsvReader,
            default => new XlsxReader,
        };

        $reader->open($path);

        $hasil = [];
        $header = null;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $sel = [];

                foreach ($row->getCells() as $cell) {
                    $sel[] = $cell->getValue();
                }

                if ($header === null) {
                    $header = array_map(
                        fn ($h): string => self::normalkanHeader((string) $h),
                        $sel,
                    );

                    continue;
                }

                // Lewati baris kosong.
                if (count(array_filter($sel, fn ($v): bool => $v !== null && $v !== '')) === 0) {
                    continue;
                }

                $baris = [];

                foreach ($header as $i => $kunci) {
                    if ($kunci === '') {
                        continue;
                    }

                    $baris[$kunci] = $sel[$i] ?? null;
                }

                $hasil[] = $baris;
            }

            // Hanya sheet pertama.
            break;
        }

        $reader->close();

        return $hasil;
    }

    private static function normalkanHeader(string $h): string
    {
        $h = strtolower(trim($h));
        $h = str_replace([' ', '-', '.'], '_', $h);

        return match ($h) {
            'tanggal_transaksi', 'tgl', 'date' => 'tanggal',
            'nominal', 'total', 'nilai', 'amount' => 'jumlah',
            'kas_bank', 'akun_kas', 'sumber' => 'akun',
            'kategori_pengeluaran' => 'kategori',
            'keterangan_transaksi', 'deskripsi', 'uraian' => 'keterangan',
            default => $h,
        };
    }
}
