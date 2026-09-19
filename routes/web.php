<?php

declare(strict_types=1);

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
| ⚠️ PENTING: rute lama TETAP disediakan sebagai PENGALIHAN (redirect),
| supaya bookmark/link lama tidak menghasilkan 404. Lihat v3.7.
|
*/

// ---------------------------------------------------------
// Pintu masuk
// ---------------------------------------------------------

// Beranda langsung diarahkan ke panel Filament.
// Filament sendiri akan mengarahkan tamu ke halaman login.
Route::get('/', fn () => redirect('/admin'))->name('beranda');

// ---------------------------------------------------------
// Pengalihan rute LAMA -> Filament
// ---------------------------------------------------------
//
// Sebelum v3.5, login ada di /login dan dashboard di /dashboard.
// Rute itu sudah dihapus, tetapi tetap disediakan pengalihannya agar
// tautan lama, bookmark, atau kebiasaan mengetik /login tidak 404.

Route::redirect('/login', '/admin/login')->name('login');
Route::redirect('/dashboard', '/admin')->name('dashboard');
Route::redirect('/home', '/admin')->name('home');
Route::redirect('/admin/dashboard', '/admin');
