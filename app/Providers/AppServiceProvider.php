<?php

namespace App\Providers;

use App\Models\Pengguna;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*
         * ⚠️ BUG YANG DICEGAH (BUG-03, ditemukan saat uji deploy 7 Okt 2026):
         *
         * Filament `ExportAction` menyimpan pemilik ekspor lewat
         * `Export::user()` → `$this->belongsTo($authenticatable::class)`, dan
         * kalau binding `Authenticatable` KOSONG ia jatuh ke tebakan
         * `App\Models\User`. Aplikasi ini TIDAK punya model `User` (memakai
         * `Pengguna`), sehingga ekspor melempar:
         *
         *   LogicException: No [App\Models\User] model found. Please bind an
         *   authenticatable model to the [Illuminate\Contracts\Auth\
         *   Authenticatable] interface in a service provider's [register()]
         *   method.
         *
         * Akibatnya tombol "Ekspor Excel"/PDF di daftar SPK (dan menu lain)
         * gagal — file tidak pernah terunduh.
         *
         * Perbaikan: beri tahu container model autentikasi yang BENAR. Ini
         * juga dipakai Filament untuk ImportAction.
         */
        $this->app->bind(Authenticatable::class, Pengguna::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
