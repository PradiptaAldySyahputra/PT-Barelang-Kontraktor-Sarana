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
            $sheetHeader = null;
            $sheetName = trim($sheet->getName());
            $sheetNameLower = mb_strtolower($sheetName);

            // Tentukan akun default dari nama sheet jika sheet bernama Kas atau Bank
            $defaultAkunSheet = null;
            if (str_contains($sheetNameLower, 'kas') && ! str_contains($sheetNameLower, 'bank')) {
                $defaultAkunSheet = 'kas';
            } elseif (str_contains($sheetNameLower, 'bank')) {
                $defaultAkunSheet = 'bank';
            }

            foreach ($sheet->getRowIterator() as $row) {
                // OpenSpout v5 menghapus Row::getCells(); toArray() mengembalikan nilai sel langsung.
                $sel = array_map(
                    static fn ($val) => $val instanceof \DateTimeInterface ? $val->format('Y-m-d') : $val,
                    array_values($row->toArray()),
                );

                $kandidatHeader = array_map(
                    fn ($h): string => self::normalkanHeader((string) $h),
                    $sel,
                );

                // Pastikan baris ini adalah header tabel sungguhan (memuat minimal 2 kolom kunci)
                $kunciPenting = [
                    'tanggal', 'tanggal_spk', 'keterangan', 'jumlah', 'nilai_spk',
                    'masuk', 'keluar', 'akun', 'nomor_spk', 'kategori', 'nama_pekerjaan',
                ];
                if (count(array_intersect($kandidatHeader, $kunciPenting)) >= 2) {
                    $sheetHeader = $kandidatHeader;

                    continue;
                }

                if ($sheetHeader === null) {
                    continue;
                }

                // Lewati baris kosong atau baris judul/total/subtotal yang tidak memuat data transaksi/SPK
                $nonKosong = array_filter($sel, fn ($v): bool => $v !== null && trim((string) $v) !== '');
                if (count($nonKosong) === 0) {
                    continue;
                }

                $baris = [];

                foreach ($sheetHeader as $i => $kunci) {
                    if ($kunci === '') {
                        continue;
                    }

                    $baris[$kunci] = $sel[$i] ?? null;
                }

                // Lewati jika ini baris subtotal / judul seksi / tanpa nama dan tanpa nominal
                $adaNominal = (isset($baris['jumlah']) && trim((string) $baris['jumlah']) !== '') ||
                              (isset($baris['nilai_spk']) && trim((string) $baris['nilai_spk']) !== '') ||
                              (isset($baris['masuk']) && trim((string) $baris['masuk']) !== '') ||
                              (isset($baris['keluar']) && trim((string) $baris['keluar']) !== '');
                $adaIdentitas = (isset($baris['nama_pekerjaan']) && trim((string) $baris['nama_pekerjaan']) !== '') ||
                                (isset($baris['nomor_spk']) && trim((string) $baris['nomor_spk']) !== '') ||
                                (isset($baris['keterangan']) && trim((string) $baris['keterangan']) !== '');

                // Bila hanya ada teks di 1 kolom (misal "TAGIHAN YANG SUDAH DIBAYARKAN" atau "TOTAL") dan tidak ada nominal/identitas valid
                if (! $adaNominal && ! $adaIdentitas) {
                    continue;
                }
                if (! $adaIdentitas && $adaNominal && is_string($baris['jumlah'] ?? null) && str_starts_with(trim($baris['jumlah']), '=')) {
                    continue; // Baris rumus total Excel seperti =SUM(...)
                }

                // Catat nama sheet asal
                $baris['_sheet'] = $sheetName;

                // Jika akun belum ditentukan tetapi sheet dinamai Kas/Bank, gunakan akun sheet
                if (! isset($baris['akun']) || blank($baris['akun'])) {
                    if ($defaultAkunSheet !== null) {
                        $baris['akun'] = $defaultAkunSheet;
                    }
                }

                // Jika kolom 'jumlah' belum ada tapi ada 'nilai_spk', 'masuk' atau 'keluar', petakan ke 'jumlah'
                if (! isset($baris['jumlah']) || $baris['jumlah'] === null || $baris['jumlah'] === '') {
                    if (isset($baris['nilai_spk']) && $baris['nilai_spk'] !== null && $baris['nilai_spk'] !== '') {
                        $baris['jumlah'] = $baris['nilai_spk'];
                    } elseif (isset($baris['masuk']) && $baris['masuk'] !== null && $baris['masuk'] !== '') {
                        $baris['jumlah'] = $baris['masuk'];
                    } elseif (isset($baris['keluar']) && $baris['keluar'] !== null && $baris['keluar'] !== '') {
                        $baris['jumlah'] = $baris['keluar'];
                    }
                }

                // Harmonisasi kolom SPK & tanggal
                if ((! isset($baris['nilai_spk']) || $baris['nilai_spk'] === null || $baris['nilai_spk'] === '') && isset($baris['jumlah']) && $baris['jumlah'] !== null && $baris['jumlah'] !== '') {
                    $baris['nilai_spk'] = $baris['jumlah'];
                }
                if ((! isset($baris['tanggal_spk']) || $baris['tanggal_spk'] === null || $baris['tanggal_spk'] === '') && isset($baris['tanggal']) && $baris['tanggal'] !== null && $baris['tanggal'] !== '') {
                    $baris['tanggal_spk'] = $baris['tanggal'];
                }
                if ((! isset($baris['tanggal']) || $baris['tanggal'] === null || $baris['tanggal'] === '') && isset($baris['tanggal_spk']) && $baris['tanggal_spk'] !== null && $baris['tanggal_spk'] !== '') {
                    $baris['tanggal'] = $baris['tanggal_spk'];
                }

                $hasil[] = $baris;
            }
        }

        $reader->close();

        return $hasil;
    }

    private static function normalkanHeader(string $h): string
    {
        $h = mb_strtolower(trim($h));
        $h = preg_replace('/[^a-z0-9]+/i', '_', $h) ?? $h;
        $h = trim($h, '_');

        return match ($h) {
            'tanggal_spk', 'tgl_spk', 'tanggal_kontrak', 'tgl_kontrak', 'tanggal_po', 'tgl_po' => 'tanggal_spk',
            'tanggal', 'tgl', 'date', 'tgl_transaksi', 'tanggal_transaksi', 'tgl_bayar', 'tanggal_bayar' => 'tanggal',
            'jumlah', 'nominal', 'total', 'nilai', 'amount', 'nilai_spk', 'nilai_kontrak', 'harga_kontrak', 'total_nilai' => 'jumlah',
            'pemasukan', 'debet', 'debit', 'terima', 'penerimaan' => 'masuk',
            'pengeluaran', 'kredit', 'credit', 'biaya' => 'keluar',
            'nomor_spk', 'no_spk', 'spk', 'no_kontrak', 'nomor_kontrak', 'no_po', 'nomor_po', 'ref' => 'nomor_spk',
            'nama_pekerjaan', 'pekerjaan', 'uraian_pekerjaan', 'uraian', 'deskripsi_pekerjaan', 'deskripsi', 'nama_proyek', 'proyek', 'item_pekerjaan' => 'nama_pekerjaan',
            'lokasi', 'lokasi_pekerjaan', 'tempat', 'wilayah', 'area' => 'lokasi',
            'mitra', 'nama_mitra', 'pelanggan', 'client', 'customer', 'rekanan', 'pemberi_kerja', 'pemberi_tugas' => 'mitra',
            'akun', 'kas_bank', 'akun_kas', 'sumber', 'rekening' => 'akun',
            'kategori', 'kategori_pengeluaran', 'pos_anggaran' => 'kategori',
            'sub_kategori', 'rincian_kategori' => 'detail_kategori',
            'penerima', 'vendor', 'toko', 'dibayar_kepada', 'kepada' => 'penerima',
            'keterangan_transaksi', 'catatan' => 'keterangan',
            'catatan_bayar', 'keterangan_sudah_masuk_ke_rek_bks', 'sudah_masuk_ke_rek_bks', 'sudah_masuk', 'status_bayar' => 'catatan_bayar',
            default => $h,
        };
    }
}
