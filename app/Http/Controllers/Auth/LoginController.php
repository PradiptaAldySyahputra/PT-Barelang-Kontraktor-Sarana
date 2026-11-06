<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Login & logout untuk panel Blade (/panel/login).
 *
 * Satu-satunya pintu masuk: rute lama `/admin/login` hanya **redirect** ke
 * `/panel/login`. Guard `web` + tabel `pengguna` yang sama untuk kedua peran.
 *
 * Pengamanan:
 *   - akun nonaktif (is_aktif = false) ditolak walau kata sandi benar,
 *   - pembatasan percobaan (5 kali / menit per email+IP),
 *   - sesi diperbarui setelah login (cegah session fixation).
 */
final class LoginController
{
    private const BATAS_PERCOBAAN = 5;

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak sah.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $kunci = 'panel-masuk|'.mb_strtolower($data['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunci, self::BATAS_PERCOBAAN)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan. Coba lagi dalam '
                    .RateLimiter::availableIn($kunci).' detik.',
            ]);
        }

        $berhasil = Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
        ], $request->boolean('ingat'));

        if (! $berhasil) {
            RateLimiter::hit($kunci, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi salah.',
            ]);
        }

        $pengguna = Auth::user();

        // Akun nonaktif tidak boleh masuk sama sekali (sama dengan PastikanPeran).
        if (! $pengguna?->is_aktif) {
            Auth::logout();
            RateLimiter::hit($kunci, 60);

            throw ValidationException::withMessages([
                'email' => 'Akun Anda tidak aktif. Hubungi Admin.',
            ]);
        }

        RateLimiter::clear($kunci);
        $request->session()->regenerate();

        return redirect()->intended(route('panel.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('panel.login');
    }
}
