<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status tagihan/pembayaran SPK.
 *
 * Alur: BelumDitagihkan -> SudahDitagihkan -> RevisiDokumen
 *       -> MenungguPembayaran -> Dibayar
 *
 * Sesuai Rules.md §3.2.
 */
enum StatusTagihan: string
{
    case BelumDitagihkan = 'belum_ditagihkan';
    case SudahDitagihkan = 'sudah_ditagihkan';
    case RevisiDokumen = 'revisi_dokumen';
    case MenungguPembayaran = 'menunggu_pembayaran';
    case Dibayar = 'dibayar';

    public function label(): string
    {
        return match ($this) {
            self::BelumDitagihkan => 'Belum Ditagihkan',
            self::SudahDitagihkan => 'Sudah Ditagihkan',
            self::RevisiDokumen => 'Revisi Dokumen',
            self::MenungguPembayaran => 'Menunggu Pembayaran',
            self::Dibayar => 'Dibayar',
        };
    }

    public function warna(): string
    {
        return match ($this) {
            self::BelumDitagihkan => 'bg-slate-100 text-slate-700',
            self::SudahDitagihkan => 'bg-blue-100 text-blue-700',
            self::RevisiDokumen => 'bg-orange-100 text-orange-700',
            self::MenungguPembayaran => 'bg-amber-100 text-amber-700',
            self::Dibayar => 'bg-emerald-100 text-emerald-700',
        };
    }

    /**
     * Tagihan pada status ini masih dianggap piutang?
     */
    public function isPiutang(): bool
    {
        return $this !== self::Dibayar;
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
