<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------
// Halaman publik
// ---------------------------------------------------------

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('beranda');

// ---------------------------------------------------------
// Autentikasi (hanya untuk tamu)
// ---------------------------------------------------------

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'tampilkan'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')   // maks 5 percobaan per menit
        ->name('login.proses');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------------------------------------------------------
// Area terproteksi (harus login)
// ---------------------------------------------------------

Route::middleware('auth')->group(function (): void {
    // Dashboard — Admin & Direktur
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---------------------------------------------------------
    // Hanya ADMIN yang boleh menginput/mengubah data
    // Sesuai Rules.md §4
    // ---------------------------------------------------------
    Route::middleware('peran:admin')->group(function (): void {
        // Rute CRUD akan ditambahkan di tahap berikutnya:
        // - SPK
        // - Uang Masuk (2 mode)
        // - Uang Keluar
        // - Mitra
        // - Pengguna
    });

    // ---------------------------------------------------------
    // Laporan — Admin & Direktur boleh melihat
    // ---------------------------------------------------------
    Route::middleware('peran:admin,direktur')->group(function (): void {
        // Rute laporan akan ditambahkan di tahap berikutnya
    });
});
