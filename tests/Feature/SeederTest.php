<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji SEEDER — memastikan data awal bisa dibuat dari database kosong.
 *
 * ⚠️ BUG YANG DICEGAH:
 * `DatabaseSeeder` pernah memanggil `MitraFactory::pelanggan()`, padahal
 * state itu sudah dihapus saat kategori mitra disederhanakan jadi 2
 * (mitra & subkon) pada v4.3. Akibatnya `php artisan migrate:fresh --seed`
 * GAGAL — dan tidak ada satu pun test yang menangkapnya, karena semua test
 * membuat data lewat factory langsung, bukan lewat seeder.
 *
 * Seeder yang rusak berbahaya: orang baru yang menjalankan proyek ini tidak
 * akan bisa memulai sama sekali.
 */
class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_utama_bisa_dijalankan(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(2, Pengguna::count(), 'harus ada 2 akun');
        $this->assertSame(4, Mitra::count(), 'harus ada 4 mitra');
        $this->assertSame(4, Spk::count(), 'harus ada 4 contoh SPK');
        $this->assertSame(3, UangMasuk::count(), 'harus ada 3 uang masuk');
        $this->assertSame(3, UangKeluar::count(), 'harus ada 3 uang keluar');
    }

    public function test_seeder_membuat_akun_yang_bisa_login(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = Pengguna::where('email', 'admin@bks.test')->first();
        $direktur = Pengguna::where('email', 'direktur@bks.test')->first();

        $this->assertNotNull($admin, 'akun admin harus ada');
        $this->assertNotNull($direktur, 'akun direktur harus ada');
        $this->assertTrue($admin->bolehInput(), 'admin harus bisa input');
        $this->assertFalse($direktur->bolehInput(), 'direktur hanya monitoring');
    }

    /**
     * Semua state factory yang dipanggil seeder harus benar-benar ada.
     *
     * Ini menangkap kasus seperti `pelanggan()` — nama state yang sudah
     * dihapus tapi masih dipanggil.
     */
    public function test_semua_state_factory_yang_dipakai_seeder_ada(): void
    {
        $mitra = new \ReflectionClass(Mitra::factory()::class);

        foreach (['pln', 'mitra', 'subkon'] as $state) {
            $this->assertTrue(
                $mitra->hasMethod($state),
                "State MitraFactory::$state() tidak ada — seeder akan gagal"
            );
        }
    }

    /**
     * Seeder TIDAK boleh memakai method yang sudah dihapus dari model.
     * labaRugi() & totalBiaya() sudah dibuang pada v4.3.
     */
    public function test_model_tidak_lagi_punya_method_laba_rugi(): void
    {
        $spk = new \ReflectionClass(Spk::class);

        $this->assertFalse(
            $spk->hasMethod('labaRugi'),
            'labaRugi() sudah dihapus — jangan dipakai lagi'
        );
        $this->assertFalse(
            $spk->hasMethod('totalBiaya'),
            'totalBiaya() sudah dihapus — jangan dipakai lagi'
        );
    }

    public function test_seeder_bisa_dijalankan_dua_kali_tanpa_merusak(): void
    {
        // Seeder tidak idempoten (data sudah ada -> duplicate), tapi harus
        // GAGAL DENGAN JELAS, bukan meninggalkan data setengah jadi.
        $this->seed(DatabaseSeeder::class);
        $sebelum = Spk::count();

        try {
            $this->seed(DatabaseSeeder::class);
        } catch (\Throwable) {
            // wajar: unique constraint
        }

        $this->assertSame($sebelum, Spk::count(), 'jumlah SPK tidak boleh bertambah');
    }
}
