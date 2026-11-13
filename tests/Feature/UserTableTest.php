<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Livewire\User\UserTable;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserTableTest extends TestCase
{
    use RefreshDatabase;

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    public function test_tamu_dan_admin_tidak_bisa_membuka_halaman_manajemen_user(): void
    {
        $this->get('/panel/users')->assertRedirect('/panel/login');

        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);
        $this->actingAs($admin)->get('/panel/users')->assertForbidden();
    }

    public function test_direktur_bisa_melihat_daftar_pengguna(): void
    {
        $direktur = $this->direktur();
        $targetUser = Pengguna::factory()->create([
            'nama' => 'Staff Keuangan Unik BKS',
            'email' => 'staff.keuangan@bks.test',
        ]);

        $this->actingAs($direktur)
            ->get('/panel/users')
            ->assertOk()
            ->assertSee('Staff Keuangan Unik BKS');
    }

    public function test_pencarian_pengguna_menyaring_tepat(): void
    {
        $direktur = $this->direktur();
        $this->actingAs($direktur);

        Pengguna::factory()->create(['nama' => 'Ahmad Teknisi Lapangan']);
        Pengguna::factory()->create(['nama' => 'Budi Supervisor Proyek']);

        Livewire::test(UserTable::class)
            ->set('cari', 'Teknisi')
            ->assertSee('Ahmad Teknisi Lapangan')
            ->assertDontSee('Budi Supervisor Proyek');
    }

    public function test_tab_peran_memfilter_daftar_pengguna(): void
    {
        $direktur = $this->direktur();
        $this->actingAs($direktur);

        Pengguna::factory()->create(['nama' => 'Admin Khusus Satu', 'peran' => Peran::Admin]);
        Pengguna::factory()->create(['nama' => 'Direktur Utama Dua', 'peran' => Peran::Direktur]);

        Livewire::test(UserTable::class)
            ->call('pilihTab', 'admin')
            ->assertSee('Admin Khusus Satu')
            ->assertDontSee('Direktur Utama Dua');
    }

    public function test_daftar_putih_pengurutan_mencegah_kolom_ilegal(): void
    {
        $direktur = $this->direktur();
        $this->actingAs($direktur);

        Livewire::test(UserTable::class)
            ->call('urutkan', 'password')
            ->assertSet('urut', 'nama')
            ->call('urutkan', 'email')
            ->assertSet('urut', 'email');
    }
}
