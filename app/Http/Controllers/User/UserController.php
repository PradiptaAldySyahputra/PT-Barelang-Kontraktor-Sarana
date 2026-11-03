<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

/**
 * CRUD akun pengguna pada panel Blade (`/panel/users`).
 *
 * Hak akses: HANYA Direktur (ditegakkan di middleware rute `peran:direktur`
 * DAN di setiap method lewat `pastikanDirektur()` - dua lapis, supaya tidak
 * ada celah lewat pemanggilan langsung).
 *
 * ⚠️ PENGAMAN SISTEM TERKUNCI: akun yang sedang login tidak boleh diubah
 * perannya, dinonaktifkan, atau dihapus - kalau tidak, Direktur bisa
 * mengunci dirinya sendiri dari sistem.
 */
final class UserController
{
    public function index(): View
    {
        return view('users.index', [
            'judul' => 'Manajemen Akun',
            'keterangan' => 'Akun Admin & Direktur yang bisa masuk sistem',
        ]);
    }

    public function create(): View
    {
        $this->pastikanDirektur();

        return view('users.form', [
            'judul' => 'Tambah Pengguna',
            'keterangan' => 'Buat akun baru untuk Admin atau Direktur',
            'pengguna' => null,
            'opsiPeran' => Peran::opsi(),
            'diriSendiri' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->pastikanDirektur();

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200', Rule::unique('pengguna', 'email')],
            'peran' => ['required', Rule::in(array_keys(Peran::opsi()))],
            'password' => ['required', 'string', Password::default()],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        Pengguna::query()->create([
            'nama' => trim($data['nama']),
            'email' => mb_strtolower(trim($data['email'])),
            'peran' => $data['peran'],
            'password' => $data['password'],
            'is_aktif' => $request->boolean('is_aktif'),
        ]);

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(Request $request, Pengguna $pengguna): View
    {
        $this->pastikanDirektur();

        $asal = $request->string('asal')->toString();
        $kembali = (str_starts_with($asal, '/panel/') && ! str_starts_with($asal, '//'))
            ? url($asal)
            : route('panel.users.index');

        return view('users.form', [
            'judul' => 'Ubah Pengguna',
            'keterangan' => $pengguna->nama,
            'pengguna' => $pengguna,
            'kembali' => $kembali,
            'opsiPeran' => Peran::opsi(),
            'diriSendiri' => $pengguna->id === auth()->id(),
        ]);
    }

    public function update(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $this->pastikanDirektur();

        $diriSendiri = $pengguna->id === auth()->id();

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'peran' => ['required', Rule::in(array_keys(Peran::opsi()))],
            'password' => ['nullable', 'string', Password::default()],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        $perubahan = [
            'nama' => trim($data['nama']),
            'email' => mb_strtolower(trim($data['email'])),
            'peran' => $data['peran'],
            'is_aktif' => $request->boolean('is_aktif'),
        ];

        // Pengaman: akun sendiri - peran & status aktif dikembalikan ke nilai
        // semula supaya Direktur tidak mengunci dirinya sendiri.
        if ($diriSendiri) {
            $perubahan['peran'] = $pengguna->peran->value;
            $perubahan['is_aktif'] = true;
        }

        if (filled($data['password'] ?? null)) {
            $perubahan['password'] = $data['password'];
        }

        $pengguna->update($perubahan);

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', $diriSendiri
                ? 'Data akun Anda tersimpan. Peran & status aktif tidak diubah.'
                : 'Perubahan akun tersimpan.');
    }

    public function destroy(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $this->pastikanDirektur();

        if ($pengguna->id === $request->user()?->id) {
            return redirect()
                ->route('panel.users.index')
                ->with('gagal', 'Tidak bisa menghapus akun yang sedang Anda pakai. Minta pengguna lain melakukannya.');
        }

        if ($pengguna->spkDibuat()->withTrashed()->exists()) {
            return redirect()
                ->route('panel.users.index')
                ->with('gagal', 'Akun ini tercatat sebagai pembuat SPK. Nonaktifkan saja agar riwayat tetap utuh.');
        }

        $pengguna->delete();

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', 'Akun pengguna berhasil dihapus.');
    }

    private function pastikanDirektur(): void
    {
        abort_unless(auth()->user()?->isDirektur() === true, 403);
    }
}
