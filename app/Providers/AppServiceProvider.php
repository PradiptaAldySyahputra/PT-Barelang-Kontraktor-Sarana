<?php

namespace App\Providers;

use App\Models\Pengguna;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password as PasswordRule;

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
         * gagal - file tidak pernah terunduh.
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
        /*
         * ATURAN PASSWORD TERPUSAT - permintaan user (9 Okt 2026):
         * "Aturan minimal: 8 karakter, kombinasi huruf & angka."
         *
         * Ditaruh di sini (bukan di satu form) supaya SEMUA jalur yang memakai
         * `Password::default()` - halaman Profil, Lupa Password, dan form
         * Pengguna - memakai aturan yang SAMA. Kalau aturan ditulis ulang per
         * form, cepat atau lambat akan berbeda diam-diam.
         */
        PasswordRule::defaults(
            PasswordRule::min(8)->letters()->numbers(),
        );

        /*
         * Nama broker reset password tetap 'users' (lihat config/auth.php),
         * memakai provider 'users' → model Pengguna. Tidak perlu diubah, tetapi
         * didokumentasikan di sini supaya jelas bahwa Lupa Password memakai
         * tabel `password_reset_tokens` (migrasi 0001_01_01_000000).
         */
        Password::broker();

        /*
         * CATAT WAKTU LOGIN TERAKHIR (permintaan user 10 Okt 2026).
         *
         * Halaman Profil menampilkan "Login terakhir". Nilainya diisi di sini
         * lewat event `Login` - jadi berlaku untuk SEMUA jalur login (panel
         * Filament maupun seeder/tes), tanpa menambah kolom di form.
         *
         * ⚠️ `terakhir_masuk` di-update TANPA memicu event model lain supaya
         * tidak ada efek samping (pakai update queri, bukan `save()`).
         */
        Event::listen(Login::class, function (Login $event): void {
            if ($event->user instanceof Pengguna) {
                $event->user->forceFill(['terakhir_masuk' => now()])->saveQuietly();
            }
        });
    }
}
