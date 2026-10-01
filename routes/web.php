<?php

declare(strict_types=1);

use App\Filament\Pages\Laporan;
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
| Halaman Blade lama sudah dihapus — lihat docs/CHANGELOG.md v3.5.
|
| ⚠️ Rute lama TETAP disediakan sebagai PENGALIHAN (redirect) supaya
| bookmark/link lama tidak menghasilkan 404. Lihat v3.7.
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
        in_array($jenis, ['spk', 'masuk', 'keluar', 'tenggat', 'piutang'], true),
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
