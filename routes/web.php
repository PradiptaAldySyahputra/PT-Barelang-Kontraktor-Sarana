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
| Halaman Blade lama sudah DIHAPUS — lihat docs/CHANGELOG.md v3.5.
| Rute di bawah hanya berfungsi sebagai pintu masuk.
|
*/

// Beranda langsung diarahkan ke panel Filament.
// Filament sendiri akan mengarahkan tamu ke halaman login.
Route::get('/', fn () => redirect('/admin'))->name('beranda');
