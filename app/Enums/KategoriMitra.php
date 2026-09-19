<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Kategori mitra — HANYA 2 (revisi user).
 *
 * | Kategori | Arti |
 * |---|---|
 * | `mitra`  | Pemberi kerja / pihak luar: **PT PLN Batam**, pelanggan, vendor |
 * | `subkon` | Penerima pekerjaan dari kita (kita bayar mereka) |
 *
 * ⚠️ PERUBAHAN dari versi sebelumnya (4 kategori: pln/pelanggan/vendor/subkon):
 * User memutuskan PLN masuk ke **mitra**, sehingga hanya tersisa 2 kategori.
 * Data lama dimigrasi lewat `2026_09_20_000001_ubah_kategori_mitra_table.php`.
 *
 * Sesuai Schema.md — kolom `mitra.kategori`.
 */
enum KategoriMitra: string
{
    case Mitra = 'mitra';
    case Subkon = 'subkon';

    public function label(): string
    {
        return match ($this) {
            self::Mitra => 'Mitra',
            self::Subkon => 'Subkon',
        };
    }

    /**
     * Keterangan singkat untuk helper di form.
     */
    public function keterangan(): string
    {
        return match ($this) {
            self::Mitra => 'Pemberi kerja / pihak luar — termasuk PT PLN Batam & pelanggan',
            self::Subkon => 'Penerima pekerjaan dari kita — kita bayar mereka',
        };
    }

    /**
     * Boleh menjadi pemberi kerja SPK?
     *
     * `mitra` (termasuk PLN) = pemberi kerja.
     * `subkon` = penerima pekerjaan, bukan pemberi kerja.
     */
    public function pemberiKerja(): bool
    {
        return $this === self::Mitra;
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $k): array => [$k->value => $k->label()])
            ->all();
    }
}
