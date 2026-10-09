<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Number;

/**
 * Pemformat angka untuk tampilan.
 *
 * Ditaruh di satu tempat supaya format rupiah KONSISTEN di seluruh aplikasi.
 * Sebelumnya tiap halaman menulis `'Rp '.number_format(...)` sendiri —
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
     * memformat ulang → `"1.000.000"` — angka tampil **100× lipat**. Kalau
     * admin menyimpan tanpa mengetik ulang, database ikut tersimpan 100×.
     *
     * Ini melanggar Rules §5.6 (format tampilan tidak boleh mengubah nilai
     * asli). Kuncinya: beri mask nilai TANPA titik/desimal, lalu biarkan mask
     * yang menambahkan pemisah ribuan.
     *
     * Catatan: Rupiah tidak memakai pecahan, jadi pembulatan ke bilangan bulat
     * aman dan konsisten dengan `Format::angka()` (0 desimal).
     */
    public static function untukInputUang(float|int|string|null $nilai): ?string
    {
        if ($nilai === null || $nilai === '') {
            return null;
        }

        return (string) (int) round((float) $nilai);
    }
}
