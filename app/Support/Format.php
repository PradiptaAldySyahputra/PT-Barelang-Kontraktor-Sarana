<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Number;

/**
 * Pemformat angka untuk tampilan.
 *
 * Ditaruh di satu tempat supaya format rupiah KONSISTEN di seluruh aplikasi.
 * Sebelumnya tiap halaman menulis `'Rp '.number_format(...)` sendiri -
 * rawan berbeda diam-diam (mis. ada yang pakai desimal, ada yang tidak).
 */
final class Format
{
    /**
     * Rupiah tanpa desimal: `Rp 1.234.567`.
     */
    public static function rupiah(float|int|string|null $nilai): string
    {
        return 'Rp '.self::angka($nilai);
    }

    /**
     * Angka bergaya Indonesia tanpa desimal: `1.234.567`.
     */
    public static function angka(float|int|string|null $nilai): string
    {
        return number_format((float) ($nilai ?? 0), 0, ',', '.');
    }

    /**
     * Persentase: `12,5%`.
     */
    public static function persen(float $nilai, int $desimal = 1): string
    {
        return Number::format($nilai, precision: $desimal, locale: 'id').'%';
    }

    /**
     * Nilai uang untuk INPUT form (state awal field ber-mask).
     *
     * ⚠️ BUG YANG DICEGAH (BUG-02, ditemukan saat uji deploy 7 Okt 2026):
     *
     * Cast `decimal:2` menghasilkan STRING berdesimal, mis. `"10000.00"`.
     * Field uang memakai mask Alpine `$money($input, ',', '.')` yang artinya
     * `,` = desimal dan `.` = ribuan (format Indonesia). Mask menerima
     * `"10000.00"`, menganggap titiknya PEMISAH RIBUAN, membuangnya, lalu
     * memformat ulang → `"1.000.000"` - angka tampil **100× lipat**. Kalau
     * admin menyimpan tanpa mengetik ulang, database ikut tersimpan 100×.
     *
     * Ini melanggar Rules §5.6 (format tampilan tidak boleh mengubah nilai
     * asli). Kuncinya: beri mask nilai TANPA titik/desimal, lalu biarkan mask
     * yang menambahkan pemisah ribuan.
     *
     * Catatan: Rupiah tidak memakai pecahan, jadi pembulatan ke bilangan bulat
     * aman dan konsisten dengan `Format::angka()` (0 desimal).
     */
    /**
     * Bersihkan input string rupiah mentah (misal: "Rp 15.000.000,-", "15.000.000", "15000000.00")
     * menjadi float murni yang aman divalidasi dan disimpan ke DECIMAL(18,2).
     */
    public static function bersihkanUang(mixed $nilai): float
    {
        if ($nilai === null || $nilai === '') {
            return 0.0;
        }

        if (is_numeric($nilai)) {
            return (float) $nilai;
        }

        $teks = (string) $nilai;
        // Buang awalan "Rp", spasi, dan akhiran ",-"
        $teks = preg_replace('/^(\s*rp\.?\s*)/i', '', $teks);
        $teks = preg_replace('/(,-\s*)$/', '', (string) $teks);

        // Jika mengandung pemisah ribuan titik (format ID: 15.000.000 atau 15.000.000,50)
        if (str_contains((string) $teks, '.') && str_contains((string) $teks, ',')) {
            $teks = str_replace('.', '', (string) $teks);
            $teks = str_replace(',', '.', (string) $teks);
        } elseif (str_contains((string) $teks, '.')) {
            // Cek apakah titik dipakai sebagai pemisah ribuan (3 digit terakhir setelah titik)
            if (preg_match('/\.\d{3}/', (string) $teks)) {
                $teks = str_replace('.', '', (string) $teks);
            }
        } elseif (str_contains((string) $teks, ',')) {
            $teks = str_replace(',', '.', (string) $teks);
        }

        // Hapus karakter non-numerik selain minus dan titik desimal
        $bersih = preg_replace('/[^\d.-]/', '', (string) $teks);

        return is_numeric($bersih) ? (float) $bersih : 0.0;
    }

    public static function untukInputUang(float|int|string|null $nilai): ?string
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        return (string) (int) round((float) $nilai);
    }

    /**
     * Konversi angka nominal ke kalimat terbilang rupiah Indonesia.
     */
    public static function terbilang(float|int|string|null $nilai): string
    {
        $angka = abs((int) ($nilai ?? 0));
        $baca = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($angka === 0) {
            return 'nol rupiah';
        }

        $hasil = self::hitungTerbilang($angka, $baca);

        return trim($hasil).' rupiah';
    }

    private static function hitungTerbilang(int $angka, array $baca): string
    {
        if ($angka < 12) {
            return $baca[$angka];
        }
        if ($angka < 20) {
            return self::hitungTerbilang($angka - 10, $baca).' belas';
        }
        if ($angka < 100) {
            return self::hitungTerbilang((int) ($angka / 10), $baca).' puluh'.($angka % 10 !== 0 ? ' '.self::hitungTerbilang($angka % 10, $baca) : '');
        }
        if ($angka < 200) {
            return 'seratus'.($angka - 100 !== 0 ? ' '.self::hitungTerbilang($angka - 100, $baca) : '');
        }
        if ($angka < 1000) {
            return self::hitungTerbilang((int) ($angka / 100), $baca).' ratus'.($angka % 100 !== 0 ? ' '.self::hitungTerbilang($angka % 100, $baca) : '');
        }
        if ($angka < 2000) {
            return 'seribu'.($angka - 1000 !== 0 ? ' '.self::hitungTerbilang($angka - 1000, $baca) : '');
        }
        if ($angka < 1000000) {
            return self::hitungTerbilang((int) ($angka / 1000), $baca).' ribu'.($angka % 1000 !== 0 ? ' '.self::hitungTerbilang($angka % 1000, $baca) : '');
        }
        if ($angka < 1000000000) {
            return self::hitungTerbilang((int) ($angka / 1000000), $baca).' juta'.($angka % 1000000 !== 0 ? ' '.self::hitungTerbilang($angka % 1000000, $baca) : '');
        }
        if ($angka < 1000000000000) {
            return self::hitungTerbilang((int) ($angka / 1000000000), $baca).' milyar'.($angka % 1000000000 !== 0 ? ' '.self::hitungTerbilang($angka % 1000000000, $baca) : '');
        }

        return self::hitungTerbilang((int) ($angka / 1000000000000), $baca).' triliun'.($angka % 1000000000000 !== 0 ? ' '.self::hitungTerbilang($angka % 1000000000000, $baca) : '');
    }
}
