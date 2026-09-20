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
}
