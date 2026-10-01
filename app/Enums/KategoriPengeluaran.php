<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Kategori pengeluaran (uang keluar).
 *
 * PENTING: enum ini adalah pengganti tabel master `expense_categories`.
 * Karena schema hanya 5 tabel (sesuai skema awal), kolom `uang_keluar.kategori`
 * berupa teks. WAJIB divalidasi memakai enum ini + dropdown di form,
 * agar laporan tidak terpecah (mis. "Material" vs "Material Bangunan").
 *
 * Lihat Schema.md §7 dan Rules.md §2 butir 10.
 */
enum KategoriPengeluaran: string
{
    case Material = 'material';
    case Upah = 'upah';
    case Operasional = 'operasional';
    case Gaji = 'gaji';
    case Nota = 'nota';
    case Transportasi = 'transportasi';
    case Lainnya = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::Material => 'Material',
            self::Upah => 'Upah',
            self::Operasional => 'Operasional',
            self::Gaji => 'Gaji',
            self::Nota => 'Nota',
            self::Transportasi => 'Transportasi',
            self::Lainnya => 'Lainnya',
        };
    }

    /**
     * Kelompok besar untuk ringkasan laporan.
     */
    public function kelompok(): string
    {
        return match ($this) {
            self::Material => 'Biaya Proyek',
            self::Upah => 'Biaya Proyek',
            self::Transportasi => 'Biaya Proyek',
            self::Operasional => 'Biaya Kantor',
            self::Gaji => 'Biaya Kantor',
            self::Nota => 'Biaya Kantor',
            self::Lainnya => 'Lain-lain',
        };
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
