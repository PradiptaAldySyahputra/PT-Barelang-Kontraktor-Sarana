<?php

declare(strict_types=1);

use App\Enums\Peran;
use App\Filament\Pages\Laporan;
use App\Models\Pengguna;
use App\Support\ArsipNota;
use App\Support\Nota;
use App\Support\StatusBackup;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Rute Web
|--------------------------------------------------------------------------
|
| Seluruh antarmuka aplikasi memakai panel Filament di /admin
| (login, dashboard, CRUD, dan laporan).
|
| Halaman Blade lama sudah dihapus — seluruh antarmuka memakai Filament.
|
| ⚠️ Rute lama TETAP disediakan sebagai PENGALIHAN (redirect) supaya
| bookmark/link lama tidak menghasilkan 404.
|
*/

// ---------------------------------------------------------
// Pintu masuk
// ---------------------------------------------------------

Route::get('/', fn () => redirect('/admin'))->name('beranda');

// ---------------------------------------------------------
// Pengalihan rute LAMA -> Filament
// ---------------------------------------------------------

Route::redirect('/login', '/admin/login')->name('login');
Route::redirect('/dashboard', '/admin')->name('dashboard');
Route::redirect('/home', '/admin')->name('home');
Route::redirect('/admin/dashboard', '/admin');

// ---------------------------------------------------------
// Penyaji berkas NOTA (PRIVAT)
// ---------------------------------------------------------
//
// ⚠️ TEMUAN AUDIT KEAMANAN (26 Sep 2026):
// Sebelumnya nota disimpan di disk `public` → bisa diunduh SIAPA PUN tanpa
// login (`GET /storage/uang_keluar/xxx.pdf` = 200). Nota memuat harga
// material, pembayaran subkon, dan gaji karyawan.
//
// Sekarang nota ada di disk privat `nota` dan HANYA dilayani lewat rute ini,
// yang memerlukan login. Dipakai untuk gambar & PDF di form.
Route::get('/admin/nota/{path}', function (string $path) {
    // Tolak path traversal: hanya boleh di dalam folder nota.
    $bersih = str_replace('\\', '/', $path);

    abort_if(
        str_contains($bersih, '..') || str_starts_with($bersih, '/'),
        404,
        'Path tidak sah.',
    );

    $disk = Storage::disk('nota');

    abort_unless($disk->exists($bersih), 404);

    return $disk->response($bersih);
})->middleware('auth')->where('path', '.*')->name('nota.lihat');

// ---------------------------------------------------------
// Ekspor laporan (unduh CSV)
// ---------------------------------------------------------
//
// Dibuat sebagai ROUTE BIASA, bukan aksi Livewire, karena halaman Laporan
// adalah Page kustom yang tidak punya getHeaderActions(). Route biasa juga
// lebih andal untuk mengunduh file.

Route::get('/admin/laporan/ekspor/{jenis}', function (string $jenis) {
    abort_unless(
        in_array($jenis, ['spk', 'masuk', 'keluar', 'tenggat', 'piutang', 'buku-kas', 'buku-bank'], true),
        404
    );

    /*
     * Format ekspor: `csv` (default) atau `xlsx`.
     *
     * ⚠️ Nilai diambil dari daftar putih, bukan diteruskan apa adanya — supaya
     *    `?format=...` tidak bisa dipakai memanggil jalur tak terduga.
     */
    $format = request()->string('format')->toString();
    $format = in_array($format, ['csv', 'xlsx', 'pdf'], true) ? $format : 'csv';

    return (new Laporan)->ekspor($jenis, $format);
})->middleware('auth')->name('laporan.ekspor');

// ---------------------------------------------------------
// Unduh berkas BACKUP database (B1-4)
// ---------------------------------------------------------
// ⚠️ KHUSUS ADMIN: berkas backup memuat SELURUH data keuangan. Hanya Admin
// yang boleh mengunduh. Nama berkas divalidasi terhadap daftar berkas nyata
// (cegah path traversal).
Route::get('/admin/backup/unduh/{nama}', function (string $nama) {
    /** @var Pengguna|null $user */
    $user = auth()->user();

    abort_unless($user?->peran === Peran::Admin, 403);

    $path = StatusBackup::pathAman($nama);

    abort_if($path === null || ! is_file($path), 404);

    return response()->download($path, basename($path), [
        'Content-Type' => 'application/gzip',
    ]);
})->middleware('auth')->name('backup.unduh');

// ---------------------------------------------------------
// Arsip Nota — unduh satu berkas & unduh ZIP (B2-7)
// ---------------------------------------------------------
// ⚠️ Path dikirim base64 agar tidak bisa ditebak; tetap divalidasi terhadap
// daftar berkas nyata lewat Nota::ada() (cegah path traversal).

Route::get('/admin/arsip-nota/unduh', function () {
    $path = base64_decode((string) request('path'), true);
    $nama = (string) request('nama', 'nota');

    abort_if($path === false || blank($path), 404);
    abort_unless(Nota::ada($path), 404);

    // Nama unduhan dibersihkan (buang path).
    $nama = str_replace(['/', '\\', '..'], '', $nama) ?: 'nota';

    return Storage::disk('nota')->download($path, $nama);
})->middleware('auth')->name('arsip-nota.unduh');

Route::get('/admin/arsip-nota/zip', function () {
    $filterJson = base64_decode((string) request('f'), true);
    $filter = $filterJson !== false ? (json_decode($filterJson, true) ?: []) : [];

    // Hanya terima kunci filter yang dikenal.
    $filter = array_intersect_key($filter, array_flip([
        'tanggal_awal', 'tanggal_akhir', 'akun', 'kategori', 'q',
    ]));

    $arsip = ArsipNota::cari($filter);
    $zip = ArsipNota::buatZip($arsip);

    abort_if($zip === null, 404, 'Tidak ada berkas untuk diunduh.');

    return response()->download($zip, 'arsip-nota-'.now()->format('Y-m-d').'.zip', [
        'Content-Type' => 'application/zip',
    ])->deleteFileAfterSend(true);
})->middleware('auth')->name('arsip-nota.zip');

// ---------------------------------------------------------
// Unduh ULANG berkas ekspor (peta menu C — Ekspor & Unduhan)
// ---------------------------------------------------------
// ⚠️ Admin hanya boleh mengunduh ekspornya sendiri; Direktur boleh semua.
// Path diambil dari tabel `exports` (bukan dari input user) → tidak bisa
// traversal.
Route::get('/admin/ekspor-unduhan/{ekspor}/unduh', function (int $ekspor) {
    /** @var Pengguna $user */
    $user = auth()->user();

    $record = Export::findOrFail($ekspor);

    abort_unless(
        $user->peran === Peran::Direktur || (int) $record->user_id === (int) $user->getKey(),
        403
    );

    abort_if($record->completed_at === null || $record->file_name === null, 404, 'Ekspor belum selesai.');

    $disk = $record->getFileDisk();
    $path = $record->getFileDirectory().DIRECTORY_SEPARATOR.$record->file_name;

    abort_unless($disk->exists($path), 404, 'Berkas tidak ditemukan.');

    return $disk->download($path, $record->file_name);
})->middleware('auth')->name('ekspor.unduh');
