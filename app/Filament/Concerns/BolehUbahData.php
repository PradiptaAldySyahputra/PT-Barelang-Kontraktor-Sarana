<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

/**
 * Pembatasan hak akses tombol aksi di panel Filament.
 *
 * ⚠️ PENTING — kenapa trait ini diperlukan:
 *
 * Filament HANYA memakai `Resource::canCreate()` / `canEdit()` / `canDelete()`
 * untuk menolak akses di halaman (abort 403). Filament **TIDAK** otomatis
 * menyembunyikan tombolnya. Akibatnya tanpa trait ini, Direktur tetap melihat
 * tombol "Tambah / Edit / Hapus" — tombolnya baru ditolak saat diklik.
 *
 * Itu aman dari kebocoran data, tetapi menyesatkan bagi pengguna dan tidak
 * sesuai semangat Rules.md §4 ("bukan hanya menyembunyikan menu" — di sini
 * justru sebaliknya: menu HARUS disembunyikan juga, DAN ditolak).
 *
 * Jadi dipakai dua lapis:
 *   1. `bolehUbahData()` → sembunyikan tombol (UI)
 *   2. `canCreate/canEdit/canDelete` di Resource → tolak akses (otorisasi)
 */
trait BolehUbahData
{
    /**
     * Apakah pengguna yang login boleh mengubah data?
     *
     * Hanya Admin (Rules.md §4). Direktur hanya boleh melihat.
     */
    public static function bolehUbahData(): bool
    {
        return auth()->user()?->bolehInput() ?? false;
    }
}
