<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Peran pengguna sistem.
 *
 * Hanya ada 2 role: Admin (input data) dan Direktur (monitoring).
 * Sesuai PRD.md §3 dan skema awal (kolom `peran`).
 */
enum Peran: string
{
    case Admin = 'admin';
    case Direktur = 'direktur';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Direktur => 'Direktur',
        };
    }

    /**
     * Apakah peran ini boleh menginput/mengubah data?
     */
    public function bolehInput(): bool
    {
        return $this === self::Admin;
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $p): array => [$p->value => $p->label()])
            ->all();
    }
}
