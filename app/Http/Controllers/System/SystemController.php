<?php

declare(strict_types=1);

namespace App\Http\Controllers\System;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Support\ArsipNota;
use App\Support\RiwayatEkspor;
use App\Support\StatusBackup;
use App\Support\StatusSistem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

/**
 * Halaman sistem: Arsip Nota, Ekspor & Unduhan, Backup, Status Sistem.
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
        // Satu tanggal: filter arsip memakai tanggal tunggal, bukan rentang.
        $tanggal = $request->string('tanggal')->toString() ?: $request->string('tgl')->toString() ?: null;
        $dari = $tanggal;
        $sampai = $tanggal;

        // Preset periode (hari ini / 3 hari / 7 hari / bulan / tahun) mendahului tanggal tunggal.
        $periode = $request->string('periode')->toString();
        $awalPeriode = match ($periode) {
            'hari-ini' => now()->format('Y-m-d'),
            '7-hari' => now()->subDays(6)->format('Y-m-d'),
            'bulan' => now()->startOfMonth()->format('Y-m-d'),
            'tahun' => now()->startOfYear()->format('Y-m-d'),
            default => null,
        };
        if ($awalPeriode !== null) {
            $dari = $awalPeriode;
            $sampai = now()->format('Y-m-d');
        }

        $filter = [
            'tanggal_awal' => $dari,
            'tanggal_akhir' => $sampai,
            'akun' => $request->string('akun')->toString() ?: null,
            'kategori' => $request->string('kategori')->toString() ?: null,
            'q' => $request->string('q')->toString() ?: null,
        ];

        $semuaArsip = ArsipNota::cari($filter);
        $semua = (bool) $request->boolean('semua');
        $perHalaman = 50;
        $daftar = $semua ? $semuaArsip : $semuaArsip->take($perHalaman)->values();

        return view('system.receipts', [
            'judul' => 'Arsip Nota',
            'keterangan' => 'Semua berkas bukti uang masuk & uang keluar',
            'arsip' => $daftar,
            'semuaArsip' => $semuaArsip,
            'semua' => $semua,
            'batas' => $perHalaman,
            'opsiAkun' => AkunKas::opsi(),
            'opsiKategori' => KategoriPengeluaran::opsi(),
            'filter' => $filter,
            'periode' => $periode,
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

        $fileTerbaru = null;
        if ($exit === 0) {
            $daftar = StatusBackup::daftar();
            $fileTerbaru = $daftar[0]['nama'] ?? null;
        }

        return redirect()
            ->route('panel.backup')
            ->with('backup_baru', $fileTerbaru)
            ->with(
                $exit === 0 ? 'berhasil' : 'gagal',
                $keluaran !== ''
                    ? $keluaran
                    : ($exit === 0 ? 'Berkas backup dibuat.' : 'Backup gagal. Periksa konfigurasi database & mysqldump.'),
            );
    }

    private function pastikanAdmin(): void
    {
        abort_unless(in_array(auth()->user()?->peran, [Peran::Admin, Peran::Direktur], true), 403);
    }
}
