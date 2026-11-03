<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * Rentang tanggal untuk PRESET PERIODE ("Hari ini", "Bulan ini", dst).
 *
 * ⚠️ KENAPA DIPISAH JADI CLASS MURNI:
 * Logika rentang tanggal gampang salah di batas bulan/tahun (mis. "bulan lalu"
 * saat Januari harus mundur ke Desember tahun sebelumnya). Dengan memisahkannya
 * dari komponen Filament, logika bisa diuji langsung tanpa browser.
 *
 * ⚠️ PRINSIP: "Bulan lalu" dihitung relatif terhadap TANGGAL HARI INI, bukan
 * awal bulan - supaya admin yang membuka awal bulan tetap dapat bulan penuh
 * sebelumnya, bukan bulan berjalan yang baru mulai.
 */
class RentangPeriode
{
    /**
     * Daftar preset yang tersedia: kode => label.
     *
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return [
            'hari_ini' => 'Hari ini',
            'bulan_ini' => 'Bulan ini',
            'bulan_lalu' => 'Bulan lalu',
            'tahun_ini' => 'Tahun ini',
            'semua' => 'Semua waktu',
        ];
    }

    /**
     * Hitung rentang [dari, sampai] (format Y-m-d) untuk sebuah preset.
     *
     * @return array{dari: string|null, sampai: string|null}
     */
    public static function hitung(string $preset, ?Carbon $acuan = null): array
    {
        $kini = ($acuan ?? Carbon::now())->copy();

        return match ($preset) {
            'hari_ini' => [
                'dari' => $kini->startOfDay()->toDateString(),
                'sampai' => $kini->endOfDay()->toDateString(),
            ],
            'bulan_ini' => [
                'dari' => $kini->startOfMonth()->toDateString(),
                'sampai' => $kini->endOfMonth()->toDateString(),
            ],
            'bulan_lalu' => [
                'dari' => $kini->copy()->subMonthNoOverflow()->startOfMonth()->toDateString(),
                'sampai' => $kini->copy()->subMonthNoOverflow()->endOfMonth()->toDateString(),
            ],
            'tahun_ini' => [
                'dari' => $kini->startOfYear()->toDateString(),
                'sampai' => $kini->endOfYear()->toDateString(),
            ],
            'semua' => [
                'dari' => null,
                'sampai' => null,
            ],
            default => [
                'dari' => null,
                'sampai' => null,
            ],
        };
    }
}
