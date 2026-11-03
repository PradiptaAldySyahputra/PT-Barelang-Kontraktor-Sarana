<?php

declare(strict_types=1);

namespace App\Support;

use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;

/**
 * Pembaca berkas impor (B3-13) - XLSX/CSV → array baris asosiatif.
 *
 * ⚠️ KENAPA PERLU:
 * Admin memigrasi data awal dari Excel. Pembaca ini mencari baris header
 * yang sah (toleran terhadap baris KOP/judul di baris 1-3) dan mengubahnya
 * menjadi kunci asosiatif.
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
                    $val = $cell->getValue();
                    if ($val instanceof \DateTimeInterface) {
                        $val = $val->format('Y-m-d');
                    }
                    $sel[] = $val;
                }

                if ($header === null) {
                    $kandidatHeader = array_map(
                        fn ($h): string => self::normalkanHeader((string) $h),
                        $sel,
                    );

                    // Pastikan baris ini adalah header tabel sungguhan (memuat minimal 2 kolom kunci)
                    $kunciPenting = ['tanggal', 'keterangan', 'jumlah', 'masuk', 'keluar', 'akun', 'nomor_spk', 'kategori'];
                    if (count(array_intersect($kandidatHeader, $kunciPenting)) >= 2) {
                        $header = $kandidatHeader;
                    }

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

                // Jika kolom 'jumlah' belum ada tapi ada 'masuk' atau 'keluar', petakan ke 'jumlah'
                if (!isset($baris['jumlah'])) {
                    if (isset($baris['masuk']) && $baris['masuk'] !== null && $baris['masuk'] !== '') {
                        $baris['jumlah'] = $baris['masuk'];
                    } elseif (isset($baris['keluar']) && $baris['keluar'] !== null && $baris['keluar'] !== '') {
                        $baris['jumlah'] = $baris['keluar'];
                    }
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
            'pemasukan', 'debet' => 'masuk',
            'pengeluaran', 'kredit' => 'keluar',
            'ref', 'no_spk', 'spk' => 'nomor_spk',
            'kas_bank', 'akun_kas', 'sumber' => 'akun',
            'kategori_pengeluaran' => 'kategori',
            'keterangan_transaksi', 'deskripsi', 'uraian' => 'keterangan',
            default => $h,
        };
    }
}
