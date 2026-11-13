<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

        // Jika akun dinonaktifkan atau sandinya diganti oleh Direktur, putus sesi aktifnya segera.
        // Bila Direktur mengubah sandi miliknya sendiri, jangan hapus sesi saat ini agar tidak terlempar keluar.
        if (! $perubahan['is_aktif'] || isset($perubahan['password'])) {
            DB::table('sessions')
                ->where('user_id', $pengguna->id)
                ->when($diriSendiri, fn ($q) => $q->where('id', '!=', $request->session()->getId()))
                ->delete();
        }

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', $diriSendiri
                ? 'Data akun Anda tersimpan. Peran & status aktif tidak diubah.'
                : 'Perubahan akun tersimpan.');
    }

    public function resetPassword(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $this->pastikanDirektur();

        if ($pengguna->id === auth()->id()) {
            return redirect()
                ->route('panel.users.index')
                ->with('gagal', 'Tidak bisa mereset password akun sendiri lewat rute ini. Silakan ubah password lewat menu Profil.');
        }

        $request->validate([
            'password' => ['required', 'string', Password::default()],
        ]);

        $pengguna->update([
            'password' => $request->string('password')->toString(),
        ]);

        DB::table('sessions')->where('user_id', $pengguna->id)->delete();

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', "Kata sandi untuk pengguna {$pengguna->nama} berhasil direset.");
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

        DB::table('sessions')->where('user_id', $pengguna->id)->delete();
        $pengguna->delete();

        return redirect()
            ->route('panel.users.index')
            ->with('berhasil', 'Akun pengguna berhasil dihapus.');
    }

    /**
     * Daftar sesi aktif (Fase 2 MASTER-PLAN, S-4).
     *
     * Tanpa halaman ini, kata sandi yang bocor hanya bisa ditangani dengan
     * mengganti kata sandi - tidak ada cara memutus sesi yang sudah berjalan.
     */
    public function sesi(Request $request): View
    {
        $this->pastikanDirektur();

        $sesiIni = $request->session()->getId();

        $daftar = DB::table('sessions')
            ->leftJoin('pengguna', 'pengguna.id', '=', 'sessions.user_id')
            ->orderByDesc('sessions.last_activity')
            ->get([
                'sessions.id',
                'sessions.user_id',
                'sessions.ip_address',
                'sessions.user_agent',
                'sessions.last_activity',
                'pengguna.nama',
                'pengguna.email',
            ])
            ->map(fn ($row): array => [
                'id' => (string) $row->id,
                'nama' => $row->nama ?? 'Tidak dikenal',
                'email' => $row->email ?? '-',
                'ip' => $row->ip_address ?? '-',
                'perangkat' => $this->ringkasPerangkat((string) ($row->user_agent ?? '')),
                'terakhir' => Carbon::createFromTimestamp((int) $row->last_activity),
                'sendiri' => (string) $row->id === $sesiIni,
            ])
            ->all();

        return view('users.sesi', [
            'judul' => 'Sesi Aktif',
            'keterangan' => 'Perangkat yang sedang masuk ke sistem. Direktur dapat memutus sesi yang mencurigakan.',
            'daftar' => $daftar,
        ]);
    }

    public function putusSesi(Request $request, string $sesi): RedirectResponse
    {
        $this->pastikanDirektur();

        if ($sesi === $request->session()->getId()) {
            return back()->with('gagal', 'Sesi yang sedang dipakai tidak bisa diputus dari halaman ini.');
        }

        $terhapus = DB::table('sessions')->where('id', $sesi)->delete();

        return back()->with(
            $terhapus > 0 ? 'berhasil' : 'gagal',
            $terhapus > 0 ? 'Sesi berhasil diputus.' : 'Sesi tidak ditemukan atau sudah berakhir.'
        );
    }

    /** Ringkas user-agent menjadi nama perangkat yang mudah dibaca. */
    private function ringkasPerangkat(string $agent): string
    {
        $browser = match (true) {
            str_contains($agent, 'Edg/') => 'Edge',
            str_contains($agent, 'OPR/'), str_contains($agent, 'Opera') => 'Opera',
            str_contains($agent, 'Chrome/') => 'Chrome',
            str_contains($agent, 'Firefox/') => 'Firefox',
            str_contains($agent, 'Safari/') => 'Safari',
            default => 'Perangkat lain',
        };

        $sistem = match (true) {
            str_contains($agent, 'Windows') => 'Windows',
            str_contains($agent, 'Android') => 'Android',
            str_contains($agent, 'iPhone'), str_contains($agent, 'iPad') => 'iOS',
            str_contains($agent, 'Mac OS') => 'macOS',
            str_contains($agent, 'Linux') => 'Linux',
            default => 'sistem tidak dikenal',
        };

        return $browser.' di '.$sistem;
    }

    private function pastikanDirektur(): void
    {
        abort_unless(auth()->user()?->isDirektur() === true, 403);
    }
}
