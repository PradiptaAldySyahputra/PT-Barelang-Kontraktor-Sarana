<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Pembuat URL berkas nota (PRIVAT).
 *
 * ⚠️ KENAPA TIDAK PAKAI Storage::url() LAGI (temuan audit 26 Sep 2026):
 * Dulu nota disimpan di disk `public` dan ditautkan lewat `/storage/...`.
 * Ternyata berkas itu bisa diunduh SIAPA PUN TANPA LOGIN — nota memuat
 * harga material, pembayaran subkon, dan gaji karyawan.
 *
 * Sekarang nota ada di disk privat `nota`, dan URL-nya menunjuk ke rute
 * ber-otentikasi `/admin/nota/{path}`. Dengan begitu:
 *   - berkas hanya bisa dibaca pengguna yang sudah login;
 *   - URL tetap RELATIF (tidak terikat host), jadi benar di localhost,
 *     ngrok, maupun IP LAN server kantor.
 *
 * Dipakai di Blade (pratinjau nota) dan bisa dipakai di mana pun.
 */
final class Nota
{
    /**
     * URL untuk membuka/menampilkan berkas nota.
     *
     * @param  string|null  $path  Path relatif di disk `nota` (mis. "uang_keluar/x.pdf")
     */
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $bersih = ltrim(str_replace('\\', '/', $path), '/');

        // Tolak path traversal sejak awal — jangan pernah bikin URL '..'.
        if (str_contains($bersih, '..')) {
            return null;
        }

        return route('nota.lihat', ['path' => $bersih]);
    }

    /**
     * Apakah berkas nota benar-benar ada di disk privat?
     */
    public static function ada(?string $path): bool
    {
        if (blank($path)) {
            return false;
        }

        $bersih = ltrim(str_replace('\\', '/', $path), '/');

        if (str_contains($bersih, '..')) {
            return false;
        }

        try {
            return Storage::disk('nota')->exists($bersih);
        } catch (\Throwable) {
            return false;
        }
    }
}
