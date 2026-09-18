<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Batasi akses berdasarkan peran pengguna.
 *
 * PENTING: ini bukan sekadar menyembunyikan menu — request yang tidak
 * berhak akan DITOLAK dengan 403. Sesuai Rules.md §4.
 *
 * Pemakaian di route:
 *   Route::middleware('peran:admin')->group(...)
 *   Route::middleware('peran:admin,direktur')->group(...)
 */
class PastikanPeran
{
    public function handle(Request $request, Closure $next, string ...$peran): Response
    {
        $pengguna = $request->user();

        if ($pengguna === null) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        // Akun nonaktif tidak boleh masuk sama sekali
        if (! $pengguna->is_aktif) {
            abort(403, 'Akun Anda tidak aktif. Hubungi Admin.');
        }

        $peranPengguna = $pengguna->peran->value;

        if (! in_array($peranPengguna, $peran, true)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}
