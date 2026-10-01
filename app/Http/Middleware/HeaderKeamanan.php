<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Header keamanan dasar.
 *
 * ⚠️ TEMUAN AUDIT (26 Sep 2026):
 * Aplikasi tidak mengirim satu pun header keamanan. Dampak nyata:
 *
 *   - X-Frame-Options / frame-ancestors kosong → halaman admin bisa
 *     dimuat dalam <iframe> situs lain (clickjacking). Admin bisa
 *     tertipu menekan tombol "Hapus"/"Simpan" di halaman palsu.
 *   - X-Content-Type-Options kosong → browser boleh "menebak" tipe berkas,
 *     sehingga berkas yang diunggah bisa diperlakukan sebagai HTML/JS.
 *   - Referrer-Policy kosong → URL halaman (kadang memuat id data) bocor
 *     ke situs luar lewat header Referer.
 *
 * Dipasang GLOBAL (web) — murah, tidak mengubah perilaku aplikasi.
 *
 * CATATAN: Content-Security-Policy TIDAK dipasang. Filament + Livewire +
 * Alpine memakai inline script/style yang banyak; CSP yang salah akan
 * membuat panel admin rusak total. Butuh pengujian menyeluruh, jadi
 * sengaja ditunda — jangan dipasang tanpa uji browser.
 */
class HeaderKeamanan
{
    public function handle(Request $request, Closure $next): Response
    {
        $respons = $next($request);

        // Cegah halaman dimuat dalam iframe situs lain (clickjacking).
        // SAMEORIGIN: masih boleh dipakai pratinjau nota di dalam aplikasi.
        if (! $respons->headers->has('X-Frame-Options')) {
            $respons->headers->set('X-Frame-Options', 'SAMEORIGIN');
        }

        // Larang browser menebak tipe berkas (cegah berkas jadi HTML/JS).
        if (! $respons->headers->has('X-Content-Type-Options')) {
            $respons->headers->set('X-Content-Type-Options', 'nosniff');
        }

        // Jangan bocorkan URL halaman ke situs luar.
        if (! $respons->headers->has('Referrer-Policy')) {
            $respons->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        }

        // Batasi fitur browser yang tidak dipakai aplikasi.
        if (! $respons->headers->has('Permissions-Policy')) {
            $respons->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        }

        return $respons;
    }
}
