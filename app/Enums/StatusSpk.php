<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status siklus hidup SPK.
 *
 * Alur: Draft -> Terbit -> Berjalan -> Selesai -> SudahDitagihkan
 * Dibatalkan adalah jalur akhir alternatif.
 *
 * Sesuai Rules.md §3.1.
 */
enum StatusSpk: string
{
    case Draft = 'draft';
    case Terbit = 'terbit';
    case Berjalan = 'berjalan';
    case Selesai = 'selesai';
    case SudahDitagihkan = 'sudah_ditagihkan';
    case Dibatalkan = 'dibatalkan';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Terbit => 'Terbit',
            self::Berjalan => 'Berjalan',
            self::Selesai => 'Selesai',
            self::SudahDitagihkan => 'Sudah Ditagihkan',
            self::Dibatalkan => 'Dibatalkan',
        };
    }

    /**
     * Warna badge Filament.
     *
     * Ditaruh di Enum (bukan di tiap tabel) supaya warna status SPK
     * KONSISTEN di seluruh halaman — sebelumnya logika yang sama disalin
     * ke beberapa file dan bisa berbeda tanpa disadari.
     */
    public function warnaBadge(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Terbit => 'info',
            self::Berjalan => 'warning',
            self::Selesai => 'success',
            self::SudahDitagihkan => 'primary',
            self::Dibatalkan => 'danger',
        };
    }

    /**
     * SPK pada status ini masih boleh menerima transaksi baru?
     * Sesuai Rules.md §5 butir 3.
     */
    public function bolehTransaksiBaru(): bool
    {
        return match ($this) {
            self::Draft, self::Terbit, self::Berjalan, self::Selesai, self::SudahDitagihkan => true,
            self::Dibatalkan => false,
        };
    }

    /**
     * Status yang menandakan pekerjaan sudah tidak aktif lagi.
     */
    public function isAkhir(): bool
    {
        return in_array($this, [self::Selesai, self::SudahDitagihkan, self::Dibatalkan], true);
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $s): array => [$s->value => $s->label()])
            ->all();
    }
}
