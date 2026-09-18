<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Kategori mitra (pihak terkait).
 *
 * Sesuai Schema.md — kolom `mitra.kategori`.
 */
enum KategoriMitra: string
{
    case Pln = 'pln';
    case Pelanggan = 'pelanggan';
    case Vendor = 'vendor';
    case Subkon = 'subkon';

    public function label(): string
    {
        return match ($this) {
            self::Pln => 'PLN',
            self::Pelanggan => 'Pelanggan',
            self::Vendor => 'Vendor',
            self::Subkon => 'Subkon',
        };
    }

    /**
     * Mitra yang bisa menjadi pemberi kerja SPK?
     */
    public function pemberiKerja(): bool
    {
        return in_array($this, [self::Pln, self::Pelanggan], true);
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
