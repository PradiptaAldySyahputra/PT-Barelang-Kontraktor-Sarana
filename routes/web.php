<?php

declare(strict_types=1);

use App\Filament\Pages\Laporan;
use Illuminate\Support\Facades\Route;

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
// Ekspor laporan (unduh CSV)
// ---------------------------------------------------------
//
// Dibuat sebagai ROUTE BIASA, bukan aksi Livewire, karena halaman Laporan
// adalah Page kustom yang tidak punya getHeaderActions(). Route biasa juga
// lebih andal untuk mengunduh file.

Route::get('/admin/laporan/ekspor/{jenis}', function (string $jenis) {
    abort_unless(
        in_array($jenis, ['spk', 'laba_rugi', 'piutang', 'aging', 'tenggat', 'cashflow', 'kategori'], true),
        404
    );

    return (new Laporan)->ekspor($jenis);
})->middleware('auth')->name('laporan.ekspor');
