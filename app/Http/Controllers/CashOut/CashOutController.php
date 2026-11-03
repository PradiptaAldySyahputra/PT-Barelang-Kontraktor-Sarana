<?php

declare(strict_types=1);

namespace App\Http\Controllers\CashOut;

use App\Models\UangKeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Uang Keluar pada panel Blade (`/panel/cash-out`).
 *
 * TAHAP SEKARANG: daftar + hapus/pulihkan di Blade.
 * Form input (dengan OCR nota multi-berkas, 879 LOC Filament) dimigrasi
 * terakhir karena paling berat; selama itu tombol input menunjuk ke
 * /admin/uang-keluars/create dan diberi label jelas di halaman.
 */
final class CashOutController
{
    public function index(): View
    {
        return view('cash-out.index', [
            'judul' => 'Uang Keluar',
            'keterangan' => 'Seluruh pengeluaran: material, upah, operasional, gaji',
        ]);
    }

    public function create(): View
    {
        $this->pastikanBolehInput();

        return view('cash-out.create', [
            'judul' => 'Catat Uang Keluar',
            'keterangan' => 'Beberapa nota sekaligus - satu baris satu nota',
        ]);
    }

    public function edit(Request $request, UangKeluar $uangKeluar): View
    {
        $this->pastikanBolehInput();

        $asal = $request->string('asal')->toString();
        $kembali = $asal === 'receipts'
            ? route('panel.receipts')
            : ((str_starts_with($asal, '/panel/') && ! str_starts_with($asal, '//'))
                ? url($asal)
                : route('panel.cash-out.index'));

        return view('cash-out.edit', [
            'judul' => 'Ubah Uang Keluar',
            'keterangan' => 'Perbarui data transaksi uang keluar',
            'uangKeluar' => $uangKeluar,
            'kembali' => $kembali,
        ]);
    }

    public function destroy(UangKeluar $uangKeluar): RedirectResponse
    {
        $this->pastikanBolehInput();

        $uangKeluar->delete();

        return redirect()
            ->route('panel.cash-out.index')
            ->with('berhasil', 'Uang keluar dihapus. Data masih bisa dipulihkan lewat penyaring "Data Terhapus".');
    }

    public function restore(int $id): RedirectResponse
    {
        $this->pastikanBolehInput();

        UangKeluar::withTrashed()->findOrFail($id)->restore();

        return redirect()
            ->route('panel.cash-out.index', ['terhapus' => 'saja'])
            ->with('berhasil', 'Uang keluar dipulihkan.');
    }

    private function pastikanBolehInput(): void
    {
        abort_unless((bool) auth()->user()?->bolehInput(), 403);
    }
}