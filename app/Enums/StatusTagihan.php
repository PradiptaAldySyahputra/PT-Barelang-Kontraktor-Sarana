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

    /**
     * Label pendek untuk tabel padat di panel Blade.
     *
     * Label penuh ("Menunggu Pembayaran") butuh ±150px; di tabel 7 kolom
     * ruang itu tidak ada. Yang pendek dipakai HANYA di sel tabel, sedangkan
     * badge detail/filter tetap memakai label().
     */
    public function labelPendek(): string
    {
        return match ($this) {
            self::BelumDitagihkan => 'Belum ditagih',
            self::SudahDitagihkan => 'Sudah ditagih',
            self::RevisiDokumen => 'Revisi dok.',
            self::MenungguPembayaran => 'Menunggu bayar',
            self::Dibayar => 'Dibayar',
        };
    }

    /**
     * Warna badge panel.
     *
     * Ditaruh di Enum supaya konsisten di seluruh halaman - lihat catatan
     * di StatusSpk::warnaBadge().
     */
    public function warnaBadge(): string
    {
        return match ($this) {
            self::BelumDitagihkan => 'gray',
            self::SudahDitagihkan => 'info',
            self::RevisiDokumen => 'danger',
            self::MenungguPembayaran => 'warning',
            self::Dibayar => 'success',
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
