<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->pastikanDatabaseUji();
    }

    /**
     * ⚠️ PENGAMAN KERAS — JANGAN DIHAPUS.
     *
     * Temuan uji deploy 7 Okt 2026: `php artisan test` yang dijalankan di
     * server dapat berjalan terhadap database PRODUKSI `bks`, bukan `bks_test`.
     * Penyebabnya dua, dan keduanya senyap:
     *
     *   1. `.env.testing` TIDAK ikut ter-commit (gitignored). Setelah clone di
     *      server, file itu tidak ada → PHPUnit jatuh ke `.env` (database
     *      produksi). 52 tes memakai `RefreshDatabase`, yang MENGHAPUS seluruh
     *      isi tabel — artinya data perusahaan bisa hilang.
     *   2. `php artisan config:cache` membekukan nilai `.env` ke
     *      `bootstrap/cache/config.php`, sehingga `APP_ENV=testing` dari
     *      `phpunit.xml` DIABAIKAN → tes kembali menunjuk `bks`.
     *
     * Dampak nyata saat itu: 35–63 tes gagal, dan yang lebih berbahaya, tes
     * menulis ke database produksi.
     *
     * Pengaman ini MENGHENTIKAN suite sebelum satu pun tes berjalan bila
     * koneksi aktif bukan database uji. Lebih baik gagal keras daripada
     * menghapus data asli diam-diam.
     */
    private function pastikanDatabaseUji(): void
    {
        // SQLite in-memory (jika suatu saat dipakai) selalu aman.
        $koneksi = config('database.default');
        $driver = config("database.connections.{$koneksi}.driver");

        if ($driver === 'sqlite' && in_array(config("database.connections.{$koneksi}.database"), [':memory:', null], true)) {
            return;
        }

        $nama = (string) config("database.connections.{$koneksi}.database");

        // Nama database uji wajib berakhiran `_test` (konvensi proyek: bks_test).
        if (str_ends_with($nama, '_test')) {
            return;
        }

        throw new \RuntimeException(
            "BERHENTI: tes akan berjalan pada database PRODUKSI '{$nama}', bukan database uji.\n"
            ."Ini bisa MENGHAPUS data asli (RefreshDatabase).\n\n"
            ."Perbaiki salah satu:\n"
            ."  1. Buat `.env.testing` dari contoh: `cp .env.testing.example .env.testing`\n"
            ."     lalu pastikan DB_DATABASE=bks_test.\n"
            ."  2. Jangan `php artisan config:cache` saat menjalankan tes — jalankan\n"
            ."     `php artisan config:clear` dulu.\n"
        );
    }
}
