<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ConsoleCommandsTest extends TestCase
{
    use RefreshDatabase;

    public function test_perintah_buat_admin_berhasil_membuat_akun_admin_baru(): void
    {
        $this->artisan('app:buat-admin')
            ->expectsQuestion('Nama lengkap', 'Admin Operasional Baru')
            ->expectsQuestion('Email', 'admin.baru@bks.test')
            ->expectsQuestion('Password (min 8 karakter, huruf & angka)', 'PasswordKuat#2026')
            ->expectsQuestion('Ulangi password', 'PasswordKuat#2026')
            ->assertSuccessful();

        $pengguna = Pengguna::where('email', 'admin.baru@bks.test')->first();
        $this->assertNotNull($pengguna);
        $this->assertSame('Admin Operasional Baru', $pengguna->nama);
        $this->assertSame(Peran::Admin, $pengguna->peran);
        $this->assertTrue($pengguna->is_aktif);
        $this->assertTrue(Hash::check('PasswordKuat#2026', $pengguna->password));
    }

    public function test_perintah_buat_admin_opsi_direktur(): void
    {
        $this->artisan('app:buat-admin', ['--direktur' => true])
            ->expectsQuestion('Nama lengkap', 'Direktur Eksekutif Baru')
            ->expectsQuestion('Email', 'direktur.baru@bks.test')
            ->expectsQuestion('Password (min 8 karakter, huruf & angka)', 'PasswordDirektur#2026')
            ->expectsQuestion('Ulangi password', 'PasswordDirektur#2026')
            ->assertSuccessful();

        $pengguna = Pengguna::where('email', 'direktur.baru@bks.test')->first();
        $this->assertNotNull($pengguna);
        $this->assertSame(Peran::Direktur, $pengguna->peran);
    }

    public function test_perintah_rekap_harian_menghasilkan_output_ringkasan_finansial(): void
    {
        UangMasuk::factory()->create(['tanggal' => now()->toDateString(), 'jumlah' => 15000000]);
        UangKeluar::factory()->create(['tanggal' => now()->toDateString(), 'jumlah' => 5000000]);

        $this->artisan('bks:rekap-harian')
            ->expectsOutputToContain('PT BARELANG KONTRAKTOR SARANA')
            ->assertSuccessful();
    }
}
