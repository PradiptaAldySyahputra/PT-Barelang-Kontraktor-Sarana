<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\KategoriPengeluaran;

/**
 * PEMBACA ISI NOTA — mengurai TEKS hasil OCR menjadi field yang bisa dipakai.
 *
 * ⚠️ KENAPA DIPISAH DARI SKRIP PYTHON
 * -----------------------------------
 * Skrip Python hanya tahu koordinat & teks mentah. Mengurai teks jadi
 * "nominal / tanggal / penerima / kategori" adalah pekerjaan LOGIKA, bukan
 * gambar — jadi ditaruh di PHP supaya:
 *   - bisa diuji unit dengan cepat (tanpa Python/model OCR);
 *   - bisa diperbaiki tanpa menyentuh pipeline gambar.
 *
 * ⚠️ HASILNYA SELALU "DRAF", BUKAN KEBENARAN
 * ------------------------------------------
 * Nota proyek ini banyak yang TULISAN TANGAN. OCR tulisan tangan sering salah
 * baca (contoh nyata: "580m", "y59r000", "42 8a0"). Karena itu:
 *   - parser mengembalikan `keyakinan` ('tinggi'/'sedang'/'rendah');
 *   - pemanggil WAJIB menampilkan hasil sebagai DRAF yang dikonfirmasi admin,
 *     BUKAN langsung menyimpan ke laporan keuangan.
 * Ini membalik aturan lama ("OCR tidak membaca nominal") atas permintaan user,
 * TAPI dengan pengaman konfirmasi supaya salah baca tidak masuk laporan.
 */
final class PembacaIsiNota
{
    /** Kata kunci label yang menandai baris TOTAL. */
    private const LABEL_TOTAL = ['total', 'jumlah rp', 'grand total', 'total rp'];

    /** Kata kunci yang menandai nama penerima/toko. */
    private const LABEL_PENERIMA = ['kepada yth', 'kepada', 'yth', 'nama', 'toko', 'penerima'];

    /** Kata kunci yang menunjukkan ini bukan nominal (nomor nota, qty, dst). */
    private const PENGECUALI = ['nota no', 'no.', 'no ', 'hp', 'telp', 'tgl', 'tanggal', 'npwp'];

    /**
     * Peta kata kunci -> kategori pengeluaran (saran, bukan keputusan).
     *
     * @var array<string, KategoriPengeluaran>
     */
    private const KATA_KATEGORI = [
        'semen' => KategoriPengeluaran::Material,
        'pasir' => KategoriPengeluaran::Material,
        'batu' => KategoriPengeluaran::Material,
        'besi' => KategoriPengeluaran::Material,
        'kayu' => KategoriPengeluaran::Material,
        'cat' => KategoriPengeluaran::Material,
        'pipa' => KategoriPengeluaran::Material,
        'material' => KategoriPengeluaran::Material,
        'upah' => KategoriPengeluaran::Upah,
        'tukang' => KategoriPengeluaran::Upah,
        'gaji' => KategoriPengeluaran::Gaji,
        'bensin' => KategoriPengeluaran::Transportasi,
        'solar' => KategoriPengeluaran::Transportasi,
        'transport' => KategoriPengeluaran::Transportasi,
        'jalan' => KategoriPengeluaran::Transportasi,
        'kantor' => KategoriPengeluaran::Operasional,
        'atk' => KategoriPengeluaran::Operasional,
        'listrik' => KategoriPengeluaran::Operasional,
        'air' => KategoriPengeluaran::Operasional,
    ];

    /**
     * Urai teks satu nota menjadi draf field.
     *
     * @param  array<int, array{teks?: string, x?: float, y?: float}|string>  $teksNota
     *                                                                                   Daftar teks terurut baca (dari Python), atau daftar string biasa.
     * @return array{
     *     nominal: int|null,
     *     tanggal: string|null,
     *     penerima: string|null,
     *     kategori: string|null,
     *     keterangan: string|null,
     *     keyakinan: string,
     *     teks: array<int, string>
     * }
     */
    public static function urai(array $teksNota): array
    {
        // Normalisasi jadi daftar string (buang koordinat).
        $baris = [];

        foreach ($teksNota as $item) {
            if (is_array($item)) {
                $t = trim((string) ($item['teks'] ?? ''));
            } else {
                $t = trim((string) $item);
            }

            if ($t !== '') {
                $baris[] = $t;
            }
        }

        $nominal = self::cariNominal($baris);
        $tanggal = self::cariTanggal($baris);
        $penerima = self::cariPenerima($baris);
        $kategori = self::cariKategori($baris);
        $keterangan = self::cariKeterangan($baris);

        return [
            'nominal' => $nominal,
            'tanggal' => $tanggal,
            'penerima' => $penerima,
            'kategori' => $kategori?->value,
            'keterangan' => $keterangan,
            'keyakinan' => self::hitungKeyakinan($nominal, $tanggal, $penerima),
            'teks' => $baris,
        ];
    }

    /**
     * Nominal rupiah.
     *
     * Strategi: utamakan angka di baris berlabel "Total". Kalau tidak ada,
     * ambil angka TERBESAR di nota (pada nota belanja, total biasanya angka
     * terbesar). Angka di baris yang jelas bukan nominal (nomor nota, telp,
     * tanggal) dibuang lebih dulu.
     *
     * @param  array<int, string>  $baris
     */
    private static function cariNominal(array $baris): ?int
    {
        /*
         * ⚠️ PERBAIKAN BUG "nominal halu" (temuan 8 Okt 2026).
         *
         * Pada nota kuitansi proyek ini (layout 2 kolom), nilai TOTAL sering
         * tercetak di baris SEBELUM label "Total Rp." — bukan sesudahnya.
         * Contoh nyata dari berkas 57-nota:
         *     '3375000'                       <- nilai total
         *     'tidak dapat dikembalikan...'
         *     'Total Rp.'
         * Dulu parser hanya melihat baris label & 2 baris SESUDAHNYA, jadi
         * melewatkan nilai ini lalu jatuh ke "angka terbesar" yang bisa
         * menangkap nomor nota. Sekarang kita periksa juga 1-2 baris SEBELUM.
         */
        foreach ($baris as $i => $t) {
            $rendah = mb_strtolower($t);

            $adaTotal = false;
            foreach (self::LABEL_TOTAL as $label) {
                if (str_contains($rendah, $label)) {
                    $adaTotal = true;
                    break;
                }
            }

            if (! $adaTotal) {
                continue;
            }

            // 1) Angka di baris total itu sendiri.
            $v = self::angkaTerbesar($t);

            if ($v !== null && $v >= 1000) {
                return $v;
            }

            // 2) Baris SESUDAH label (format "Total Rp." lalu angkanya).
            for ($j = $i + 1; $j <= min($i + 2, count($baris) - 1); $j++) {
                if (self::barisPengecuali($baris[$j])) {
                    continue;
                }

                $v = self::angkaTerbesar($baris[$j]);

                if ($v !== null && $v >= 1000) {
                    return $v;
                }
            }

            // 3) Baris SEBELUM label (layout 2 kolom: nilai di kiri, label di
            //    kanan-bawah). Ini yang paling sering benar di nota proyek.
            for ($j = $i - 1; $j >= max(0, $i - 2); $j--) {
                if (self::barisPengecuali($baris[$j])) {
                    continue;
                }

                $v = self::angkaTerbesar($baris[$j]);

                if ($v !== null && $v >= 1000) {
                    return $v;
                }
            }
        }

        // 4. Fallback: angka terbesar yang wajar sebagai nominal.
        $kandidat = [];

        foreach ($baris as $t) {
            if (self::barisPengecuali($t)) {
                continue;
            }

            $v = self::angkaTerbesar($t);

            if ($v !== null && $v >= 1000) {
                $kandidat[] = $v;
            }
        }

        return $kandidat === [] ? null : max($kandidat);
    }

    /**
     * Tanggal nota (format d/m/Y atau Y-m-d).
     *
     * @param  array<int, string>  $baris
     */
    private static function cariTanggal(array $baris): ?string
    {
        foreach ($baris as $t) {
            // dd/mm/yyyy, dd-mm-yyyy, dd.mm.yyyy
            if (preg_match('#\b(\d{1,2})[/\-.](\d{1,2})[/\-.](\d{2,4})\b#', $t, $m)) {
                $d = (int) $m[1];
                $bl = (int) $m[2];
                $th = (int) $m[3];

                if ($th < 100) {
                    $th += 2000;
                }

                if (checkdate($bl, $d, $th)) {
                    return sprintf('%04d-%02d-%02d', $th, $bl, $d);
                }
            }

            // yyyy-mm-dd
            if (preg_match('#\b(\d{4})-(\d{2})-(\d{2})\b#', $t, $m)) {
                if (checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
                    return sprintf('%04d-%02d-%02d', $m[1], $m[2], $m[3]);
                }
            }
        }

        return null;
    }

    /**
     * Nama penerima / toko — teks setelah label "Kepada Yth".
     *
     * @param  array<int, string>  $baris
     */
    private static function cariPenerima(array $baris): ?string
    {
        foreach ($baris as $i => $t) {
            $rendah = mb_strtolower($t);

            foreach (self::LABEL_PENERIMA as $label) {
                if (! str_contains($rendah, $label)) {
                    continue;
                }

                // Nama bisa ada di baris yang sama setelah titik dua.
                $sisa = trim(preg_replace('/^.*?:\s*/', '', $t) ?? '');

                if (self::namaWajar($sisa)) {
                    return self::rapikanNama($sisa);
                }

                // Atau di baris berikutnya.
                for ($j = $i + 1; $j <= min($i + 2, count($baris) - 1); $j++) {
                    if (self::namaWajar($baris[$j])) {
                        return self::rapikanNama($baris[$j]);
                    }
                }
            }
        }

        return null;
    }

    /**
     * Saran kategori dari kata kunci pada teks nota.
     *
     * @param  array<int, string>  $baris
     */
    private static function cariKategori(array $baris): ?KategoriPengeluaran
    {
        $gabung = mb_strtolower(implode(' ', $baris));

        foreach (self::KATA_KATEGORI as $kata => $kategori) {
            if (preg_match('/\b'.preg_quote($kata, '/').'\b/u', $gabung) === 1) {
                return $kategori;
            }
        }

        return null;
    }

    /**
     * Keterangan ringkas — gabungan beberapa baris item (dibersihkan).
     *
     * @param  array<int, string>  $baris
     */
    private static function cariKeterangan(array $baris): ?string
    {
        $buang = ['nota', 'kepada', 'total', 'nb:', 'terima kasih', 'hormat', 'banyak', 'uraian', 'harga', 'jumlah', 'nya'];

        $item = [];

        foreach ($baris as $t) {
            $rendah = mb_strtolower($t);

            $lewati = false;
            foreach ($buang as $b) {
                if (str_contains($rendah, $b)) {
                    $lewati = true;
                    break;
                }
            }

            // Buang baris yang isinya hanya angka.
            if ($lewati || preg_match('/^[\d\s.,:\-\/]+$/', $t) === 1) {
                continue;
            }

            // Buang baris yang isinya terlalu pendek.
            if (mb_strlen($t) < 3) {
                continue;
            }

            $item[] = $t;

            if (count($item) >= 3) {
                break;
            }
        }

        return $item === [] ? null : mb_substr(implode('; ', $item), 0, 200);
    }

    /**
     * Tingkat keyakinan hasil baca.
     */
    private static function hitungKeyakinan(?int $nominal, ?string $tanggal, ?string $penerima): string
    {
        $poin = 0;
        $poin += $nominal !== null ? 2 : 0; // nominal paling penting
        $poin += $tanggal !== null ? 1 : 0;
        $poin += $penerima !== null ? 1 : 0;

        return match (true) {
            $poin >= 3 => 'tinggi',
            $poin >= 1 => 'sedang',
            default => 'rendah',
        };
    }

    /**
     * Ambil angka terbesar dari sebuah baris teks.
     *
     * ⚠️ PERBAIKAN BUG "nominal halu" (temuan 8 Okt 2026):
     * Dulu regex `\d[\d.,\s\-]*\d` memakai SPASI sebagai pemisah bebas,
     * sehingga deret angka tak berhubungan tergabung jadi satu angka raksasa —
     * contoh nyata dari berkas 57-nota: "26 20" → 2620, dan sebuah nota
     * menghasilkan 2.600.030.000 (miliaran) dari potongan nomor nota + qty.
     *
     * Sekarang angka hanya digabung kalau berpola PEMISAH RIBUAN yang sah
     * (kelompok 3 digit): "1.500.000", "1,500,000", "1 500 000", "80-000".
     * Di luar pola itu, tiap rangkaian digit dihitung sendiri.
     */
    private static function angkaTerbesar(string $teks): ?int
    {
        $kandidat = [];

        // 1) Angka berformat pemisah ribuan (kelompok 3 digit).
        if (preg_match_all('/\d{1,3}(?:[.,\s\-]\d{3})+(?!\d)/', $teks, $m) !== false) {
            foreach ($m[0] as $token) {
                $digit = preg_replace('/\D/', '', $token) ?? '';

                if ($digit !== '' && strlen($digit) <= 12) {
                    $kandidat[] = (int) $digit;
                }
            }
        }

        // 2) Angka polos (tanpa pemisah).
        if (preg_match_all('/\d+/', $teks, $m2) !== false) {
            foreach ($m2[0] as $token) {
                if (strlen($token) <= 12) {
                    $kandidat[] = (int) $token;
                }
            }
        }

        return $kandidat === [] ? null : max($kandidat);
    }

    /**
     * Apakah baris ini jelas BUKAN nominal (nomor nota, telepon, tanggal).
     */
    private static function barisPengecuali(string $teks): bool
    {
        $rendah = mb_strtolower($teks);

        foreach (self::PENGECUALI as $p) {
            if (str_contains($rendah, $p)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Apakah teks ini wajar jadi nama penerima?
     */
    private static function namaWajar(string $teks): bool
    {
        $t = trim($teks);

        if (mb_strlen($t) < 3 || mb_strlen($t) > 60) {
            return false;
        }

        // Bukan hanya angka / simbol.
        if (preg_match('/[A-Za-z]{3,}/', $t) !== 1) {
            return false;
        }

        $rendah = mb_strtolower($t);

        // Buang label struktural yang bukan nama.
        foreach (['nota', 'banyak', 'uraian', 'harga', 'jumlah', 'nyari', 'nya', 'total'] as $b) {
            if (str_contains($rendah, $b)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Rapikan nama: buang tanda baca berlebih, batasi panjang.
     */
    private static function rapikanNama(string $teks): string
    {
        $t = trim(preg_replace('/\s+/', ' ', $teks) ?? $teks);
        $t = trim($t, " :.\t\n\r\0\x0B");

        return mb_substr($t, 0, 60);
    }
}
