<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Akun kas/bank.
 *
 * ⚠️ KENAPA INI PERLU (permintaan pengguna 26 Sep 2026):
 * Excel perusahaan ("BKS - Format Kas & Bank") memisahkan dua buku:
 * KAS (operasional harian) dan BANK (transfer, gaji, setoran). Sistem
 * sebelumnya mencampur keduanya, sehingga laporan tidak bisa disajikan
 * per akun saat diminta bagian pajak.
 *
 * Sama seperti KategoriPengeluaran: kolomnya berupa TEKS, divalidasi enum
 * ini + dropdown di form, supaya laporan tidak terpecah.
 */
enum AkunKas: string
{
    case Kas = 'kas';
    case Bank = 'bank';

    public function label(): string
    {
        return match ($this) {
            self::Kas => 'Kas',
            self::Bank => 'Bank',
        };
    }

    /**
     * Warna badge Filament — konsisten di seluruh halaman.
     */
    public function warnaBadge(): string
    {
        return match ($this) {
            self::Kas => 'success',
            self::Bank => 'info',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $a): array => [$a->value => $a->label()])
            ->all();
    }
}
