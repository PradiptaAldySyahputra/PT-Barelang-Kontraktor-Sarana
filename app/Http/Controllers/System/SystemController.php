<?php

declare(strict_types=1);

namespace App\Http\Controllers\System;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Support\ArsipNota;
use App\Support\ImporTransaksi;
use App\Support\PembacaImpor;
use App\Support\RiwayatEkspor;
use App\Support\StatusBackup;
use App\Support\StatusSistem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Halaman sistem: Arsip Nota, Ekspor & Unduhan, Backup, Status Sistem, Impor Data.
 *
 * Semua perhitungan ada di App\Support; halaman ini hanya menyusun tampilan
 * dan memeriksa hak akses. Tautan unduhan memakai rute yang sudah ada
 * (`arsip-nota.*`, `ekspor.unduh`, `backup.unduh`) supaya tidak ada dua jalur
 * pengunduhan berkas.
 */
final class SystemController
{
    public function receipts(Request $request): View
    {
        $tanggalPilihan = $request->string('tgl')->toString() ?: $request->string('dari')->toString() ?: null;
        $filter = [
            'tanggal_awal' => $tanggalPilihan,
            'tanggal_akhir' => $tanggalPilihan ?: ($request->string('sampai')->toString() ?: null),
            'akun' => $request->string('akun')->toString() ?: null,
            'kategori' => $request->string('kategori')->toString() ?: null,
            'q' => $request->string('q')->toString() ?: null,
        ];

        $semuaArsip = ArsipNota::cari($filter);
        $perHalaman = 15;
        $halaman = (int) $request->input('page', 1);
        $total = $semuaArsip->count();
        $arsipSlice = $semuaArsip->slice(($halaman - 1) * $perHalaman, $perHalaman)->values();

        $arsipPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $arsipSlice,
            $total,
            $perHalaman,
            $halaman,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('system.receipts', [
            'judul' => 'Arsip Nota',
            'keterangan' => 'Semua berkas bukti uang masuk & uang keluar',
            'arsip' => $arsipPaginated,
            'semuaArsip' => $semuaArsip,
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'filter' => $filter,
        ]);
    }

    public function receiptsUpload(): View
    {
        return view('system.receipts-upload', [
            'judul' => 'Unggah & Ekstraksi Nota',
            'keterangan' => 'Unggah berkas nota fisik (satuan atau scan tumpuk PDF/gambar) untuk diekstrak otomatis dengan OCR',
        ]);
    }

    public function exports(): View
    {
        $pengguna = auth()->user();
        $periode = request()->integer('periode', 12);
        if (! in_array($periode, [1, 3, 12, 0], true)) {
            $periode = 12;
        }

        return view('system.exports', [
            'judul' => 'Ekspor & Unduhan',
            'keterangan' => 'Pusat unduhan dokumen resmi PT BKS dan riwayat berkas ekspor',
            'periode' => $periode,
            // Admin hanya melihat ekspornya sendiri; Direktur melihat semua.
            'daftar' => RiwayatEkspor::daftar(
                $pengguna?->peran === Peran::Admin ? $pengguna->id : null,
            ),
        ]);
    }

    public function status(): View
    {
        $this->pastikanAdmin();

        return view('system.status', [
            'judul' => 'Status Sistem',
            'keterangan' => 'Database, queue, backup, penyimpanan, email, versi',
            'status' => StatusSistem::semua(),
        ]);
    }

    public function backup(): View
    {
        $this->pastikanAdmin();

        return view('system.backup', [
            'judul' => 'Backup Database',
            'keterangan' => 'Pantau backup & unduh salinan terakhir',
            'ringkasan' => StatusBackup::ringkasan(),
            'daftar' => StatusBackup::daftar(),
        ]);
    }

    public function backupRun(): RedirectResponse
    {
        $this->pastikanAdmin();

        $exit = Artisan::call('bks:backup', ['--hari' => 30]);
        $keluaran = trim(Artisan::output());

        return redirect()
            ->route('panel.backup')
            ->with(
                $exit === 0 ? 'berhasil' : 'gagal',
                $keluaran !== ''
                    ? $keluaran
                    : ($exit === 0 ? 'Berkas backup dibuat.' : 'Backup gagal. Periksa konfigurasi database & mysqldump.'),
            );
    }

    public function import(): View
    {
        $this->pastikanAdmin();

        return view('system.import', [
            'judul' => 'Impor Data',
            'keterangan' => 'Impor uang masuk / uang keluar dari CSV',
            'hasil' => session('impor_hasil'),
        ]);
    }

    public function importStore(Request $request): RedirectResponse
    {
        $this->pastikanAdmin();

        $data = $request->validate([
            'jenis' => ['required', 'in:masuk,keluar'],
            'berkas' => ['required', 'file', 'mimes:csv,txt,xlsx', 'max:10240'],
        ]);

        $berkas = $request->file('berkas');

        if ($berkas === null) {
            return back()->with('gagal', 'Berkas tidak terbaca.');
        }

        // Simpan dulu dengan ekstensi aslinya: pembaca (OpenSpout) menentukan
        // format dari ekstensi, sedangkan berkas sementara PHP tidak punya.
        $nama = uniqid('impor-', true).'.'.strtolower($berkas->getClientOriginalExtension());
        $berkas->storeAs('impor', $nama, 'local');

        $path = Storage::disk('local')->path('impor/'.$nama);

        if (! is_file($path)) {
            return back()->with('gagal', 'Berkas gagal disimpan.');
        }

        $baris = PembacaImpor::baca($path);
        @unlink($path);

        $hasil = $data['jenis'] === 'keluar'
            ? ImporTransaksi::uangKeluar($baris)
            : ImporTransaksi::uangMasuk($baris);

        return redirect()
            ->route('panel.import')
            ->with('berhasil', $hasil['ditambah'].' ditambah · '.$hasil['dilewati'].' dilewati · '.count($hasil['gagal']).' gagal')
            ->with('impor_hasil', array_merge($hasil, ['jenis' => $data['jenis']]));
    }

    public function template()
    {
        $this->pastikanAdmin();

        $csv = "tanggal,jumlah,akun,kategori,penerima,keterangan\n"
            ."2026-01-05,1500000,Kas,,,Setoran awal\n"
            ."2026-01-06,2500000,Bank,material,Toko A,Beli material\n";

        return response()->streamDownload(function () use ($csv): void {
            echo $csv;
        }, 'template-impor.csv', ['Content-Type' => 'text/csv']);
    }

    private function pastikanAdmin(): void
    {
        abort_unless(in_array(auth()->user()?->peran, [Peran::Admin, Peran::Direktur], true), 403);
    }
}