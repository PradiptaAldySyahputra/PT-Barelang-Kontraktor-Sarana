<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Enums\KategoriMitra;
use App\Models\Mitra;
use App\Models\Spk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * CRUD Mitra pada panel Blade (`/panel/partners`).
 *
 * Hak akses (Rules.md §4):
 *   - Lihat daftar (`index`) : Admin + Direktur
 *   - Tambah/Ubah/Hapus      : HANYA Admin (`peran:admin` di rute + cek `bolehInput()`)
 */
final class PartnerController
{
    public function index(): View
    {
        return view('partners.index', [
            'judul' => 'Daftar Mitra',
            'keterangan' => 'Semua mitra pemberi kerja & subkon pelaksana',
        ]);
    }

    public function create(): View
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        return view('partners.form', [
            'judul' => 'Tambah Mitra',
            'keterangan' => 'Tambahkan mitra pemberi kerja atau subkon baru',
            'mitra' => null,
            'opsiKategori' => KategoriMitra::opsi(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless((bool) $request->user()?->bolehInput(), 403);

        $data = $this->validasi($request);

        Mitra::query()->create($data);

        return redirect()
            ->route('panel.partners.index')
            ->with('berhasil', 'Mitra baru berhasil ditambahkan.');
    }

    public function edit(Request $request, Mitra $mitra): View
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);

        $asal = $request->string('asal')->toString();
        $kembali = (str_starts_with($asal, '/panel/') && ! str_starts_with($asal, '//'))
            ? url($asal)
            : route('panel.partners.index');

        return view('partners.form', [
            'judul' => 'Ubah Mitra',
            'keterangan' => $mitra->nama,
            'mitra' => $mitra,
            'kembali' => $kembali,
            'opsiKategori' => KategoriMitra::opsi(),
        ]);
    }

    public function update(Request $request, Mitra $mitra): RedirectResponse
    {
        abort_unless((bool) $request->user()?->bolehInput(), 403);

        $data = $this->validasi($request);

        $mitra->update($data);

        return redirect()
            ->route('panel.partners.index')
            ->with('berhasil', 'Perubahan mitra tersimpan.');
    }

    public function destroy(Request $request, Mitra $mitra): RedirectResponse
    {
        abort_unless((bool) $request->user()?->bolehInput(), 403);

        $terpakai = $mitra->spk()->withTrashed()->exists()
            || Spk::withTrashed()->where('subkon_id', $mitra->id)->exists()
            || $mitra->uangMasuk()->withTrashed()->exists();

        if ($terpakai) {
            return redirect()
                ->route('panel.partners.index')
                ->with('gagal', 'Mitra sudah terhubung ke SPK atau transaksi uang masuk. Nonaktifkan mitra ini jika tidak dipakai lagi.');
        }

        $mitra->delete();

        return redirect()
            ->route('panel.partners.index')
            ->with('berhasil', 'Mitra berhasil dihapus.');
    }

    /**
     * @return array{nama: string, kategori: string, kontak: string|null, alamat: string|null, is_aktif: bool}
     */
    private function validasi(Request $request): array
    {
        /** @var array{nama: string, kategori: string, kontak?: string|null, alamat?: string|null} $tervalidasi */
        $tervalidasi = $request->validate([
            'nama' => ['required', 'string', 'max:200'],
            'kategori' => ['required', Rule::in(array_keys(KategoriMitra::opsi()))],
            'kontak' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'is_aktif' => ['nullable', 'boolean'],
        ]);

        return [
            'nama' => trim($tervalidasi['nama']),
            'kategori' => $tervalidasi['kategori'],
            'kontak' => filled($tervalidasi['kontak'] ?? null) ? trim((string) $tervalidasi['kontak']) : null,
            'alamat' => filled($tervalidasi['alamat'] ?? null) ? trim((string) $tervalidasi['alamat']) : null,
            'is_aktif' => $request->boolean('is_aktif'),
        ];
    }
}
