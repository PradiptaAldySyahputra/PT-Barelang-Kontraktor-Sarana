<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Services\PenyimpanBerkas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * Profil akun sendiri (`/panel/profile`).
 *
 * Berbeda dari Manajemen Akun (khusus Direktur): halaman ini untuk SIAPA PUN
 * yang sedang login mengubah datanya sendiri.
 *
 * Keamanan: ganti kata sandi wajib menyertakan sandi lama, dan sesi lain
 * diputus setelahnya (kalau pernah login di komputer lain).
 */
final class ProfileController
{
    public function edit(Request $request): View
    {
        return view('profile.index', [
            'judul' => 'Profil Saya',
            'keterangan' => 'Data diri, foto, tanda tangan, dan kata sandi',
            'pengguna' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var Pengguna $pengguna */
        $pengguna = $request->user();

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200', 'unique:pengguna,email,'.$pengguna->id],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
            'avatar_base64' => ['nullable', 'string'],
            'hapus_avatar' => ['nullable', 'boolean'],
            'tanda_tangan' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:'.PenyimpanBerkas::maksUkuranKb()],
            'hapus_tanda_tangan' => ['nullable', 'boolean'],
        ]);

        $perubahan = [
            'nama' => trim($data['nama']),
            'email' => mb_strtolower(trim($data['email'])),
        ];

        // Hapus avatar
        if ($request->boolean('hapus_avatar')) {
            $perubahan['avatar'] = null;
        }

        // Simpan hasil crop base64 jika ada (validasi MIME gambar asli untuk mencegah injeksi file sembarang)
        if (! $request->boolean('hapus_avatar') && $request->filled('avatar_base64')) {
            $b64 = (string) $request->input('avatar_base64');
            if (str_contains($b64, ';base64,')) {
                [, $b64Data] = explode(';base64,', $b64, 2);
                $decoded = base64_decode($b64Data, true);
                if ($decoded !== false && strlen($decoded) <= PenyimpanBerkas::maksUkuranKb() * 1024) {
                    $infoGambar = @getimagesizefromstring($decoded);
                    $mimeSah = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
                    $mime = is_array($infoGambar) ? ($infoGambar['mime'] ?? '') : '';

                    if (isset($mimeSah[$mime])) {
                        $tmpBase = tempnam(sys_get_temp_dir(), 'bks_crop_');
                        if ($tmpBase !== false) {
                            $tmpPath = $tmpBase.'.'.$mimeSah[$mime];
                            file_put_contents($tmpPath, $decoded);
                            $path = app(PenyimpanBerkas::class)->simpanKe($tmpPath, 'profil', 'nota');
                            if ($path !== null) {
                                $perubahan['avatar'] = $path;
                            }
                            @unlink($tmpPath);
                            @unlink($tmpBase);
                        }
                    }
                }
            }
        } elseif ($request->hasFile('avatar')) {
            $path = app(PenyimpanBerkas::class)->simpanKe($request->file('avatar'), 'profil', 'nota');
            if ($path !== null) {
                $perubahan['avatar'] = $path;
            }
        }

        if ($request->boolean('hapus_tanda_tangan')) {
            $perubahan['tanda_tangan'] = null;
        }

        if ($request->hasFile('tanda_tangan')) {
            $path = app(PenyimpanBerkas::class)->simpanKe($request->file('tanda_tangan'), 'profil', 'nota');
            if ($path !== null) {
                $perubahan['tanda_tangan'] = $path;
            }
        }

        $pengguna->update($perubahan);

        return redirect()
            ->route('panel.profile')
            ->with('berhasil', 'Profil tersimpan.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var Pengguna $pengguna */
        $pengguna = $request->user();

        $data = $request->validate([
            'password_lama' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::default()],
        ]);

        $pengguna->update(['password' => $data['password']]);

        // Putus sesi lain: kalau sandi pernah dipakai di komputer lain,
        // sesi itu tidak boleh tetap hidup.
        DB::table('sessions')
            ->where('user_id', $pengguna->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        return redirect()
            ->route('panel.profile')
            ->with('berhasil', 'Kata sandi diganti. Sesi lain sudah diputus.');
    }
}