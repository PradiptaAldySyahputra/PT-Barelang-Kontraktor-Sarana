<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Status PENGANTARAN DOKUMEN SPK.
 *
 * ⚠️ KENAPA INI ADA (permintaan pengguna 26 Sep 2026):
 * Excel perusahaan ("LIST SPK 2026.xlsx") punya kolom **Keterangan** yang
 * mencatat apakah dokumen SPK sudah diantar ke pihak terkait atau belum —
 * mis. "diantar ke imperium", "dibawa", "sudah masuk rek BKS".
 *
 * Sebelumnya SPK tidak punya tempat untuk itu, sehingga admin tidak tahu
 * mana SPK yang dokumennya belum diantar.
 *
 * KEPUTUSAN PENGGUNA: **CUKUP 3 NILAI** untuk saat ini. Nilai tambahan
 * (mis. "Revisi") dapat ditambahkan menyusul bila diperlukan.
 *
 * Dipakai bersama kolom:
 *   - `spk.status_antar`    → nilai enum ini
 *   - `spk.tanggal_antar`   → kapan diantar
 *   - `spk.keterangan`      → catatan bebas (mis. "diantar ke imperium")
 */
enum StatusAntar: string
{
    case Belum = 'belum';
    case SudahDiantar = 'sudah_diantar';
    case Diterima = 'diterima';

    public function label(): string
    {
        return match ($this) {
            self::Belum => 'Belum Diantar',
            self::SudahDiantar => 'Sudah Diantar',
            self::Diterima => 'Diterima',
        };
    }

    /**
     * Warna badge Filament.
     *
     * Ditaruh di Enum (bukan di tiap tabel) supaya warna KONSISTEN di seluruh
     * halaman — pola yang sama dengan StatusSpk::warnaBadge().
     */
    public function warnaBadge(): string
    {
        return match ($this) {
            self::Belum => 'danger',
            self::SudahDiantar => 'warning',
            self::Diterima => 'success',
        };
    }

    /**
     * Apakah dokumen sudah keluar dari kantor (minimal sudah diantar)?
     */
    public function sudahKeluar(): bool
    {
        return $this !== self::Belum;
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
