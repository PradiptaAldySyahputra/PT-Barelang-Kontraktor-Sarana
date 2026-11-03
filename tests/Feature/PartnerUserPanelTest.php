<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Enums\Peran;
use App\Livewire\Partner\PartnerTable;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Modul MITRA & PENGGUNA pada panel Blade.
 *
 * Yang diuji adalah perilaku yang gampang rusak dan menyangkut aturan bisnis:
 *   - pembatasan peran (Rules.md §4: hanya Admin yang input, akun hanya Direktur)
 *   - pengaman "sistem terkunci": akun sendiri tidak bisa dikunci/dihapus
 *   - mitra yang sudah dipakai SPK tidak boleh dihapus (data keuangan)
 */
class PartnerUserPanelTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    /* =====================================================
       Mitra
       ===================================================== */

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/panel/partners')->assertRedirect('/panel/login');
    }

    public function test_direktur_melihat_daftar_mitra(): void
    {
        Mitra::factory()->create(['nama' => 'PT UJI PANEL MITRA']);

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get('/panel/partners')
            ->assertOk()
            ->assertSee('PT UJI PANEL MITRA');
    }

    public function test_admin_melihat_tombol_tambah_mitra(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/partners')
            ->assertOk()
            ->assertSee('Tambah Mitra');
    }

    public function test_direktur_sebagai_super_admin_boleh_menambah_mitra(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->post('/panel/partners', [
                'nama' => 'Mitra Baru Direktur',
                'kategori' => KategoriMitra::Mitra->value,
                'is_aktif' => '1',
            ])
            ->assertRedirect(route('panel.partners.index'));

        $this->assertDatabaseHas('mitra', ['nama' => 'Mitra Baru Direktur']);
    }

    public function test_admin_menambah_mitra(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/partners', [
                'nama' => 'CV Mitra Baru',
                'kategori' => KategoriMitra::Subkon->value,
                'kontak' => '0812-0000',
                'is_aktif' => '1',
            ])
            ->assertRedirect(route('panel.partners.index'));

        $this->assertDatabaseHas('mitra', [
            'nama' => 'CV Mitra Baru',
            'kategori' => KategoriMitra::Subkon->value,
            'is_aktif' => true,
        ]);
    }

    public function test_nama_mitra_wajib_diisi(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/partners', ['nama' => '', 'kategori' => KategoriMitra::Mitra->value])
            ->assertSessionHasErrors('nama');
    }

    public function test_mitra_yang_dipakai_spk_tidak_boleh_dihapus(): void
    {
        $mitra = Mitra::factory()->create(['nama' => 'Mitra Terpakai']);
        Spk::factory()->create(['mitra_id' => $mitra->id]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->delete(route('panel.partners.destroy', $mitra))
            ->assertRedirect(route('panel.partners.index'));

        $this->assertDatabaseHas('mitra', ['id' => $mitra->id]);
    }

    public function test_mitra_tanpa_relasi_bisa_dihapus(): void
    {
        $mitra = Mitra::factory()->create(['nama' => 'Mitra Bebas']);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->delete(route('panel.partners.destroy', $mitra));

        $this->assertDatabaseMissing('mitra', ['id' => $mitra->id]);
    }

    public function test_tab_mitra_menyaring_kategori(): void
    {
        Mitra::factory()->create(['nama' => 'PT Pemberi Saja', 'kategori' => KategoriMitra::Mitra]);
        Mitra::factory()->create(['nama' => 'Rekanan Subkon', 'kategori' => KategoriMitra::Subkon]);

        Livewire::test(PartnerTable::class)
            ->call('pilihTab', 'subkon')
            ->assertSee('Rekanan Subkon')
            ->assertDontSee('PT Pemberi Saja');
    }

    public function test_pencarian_mitra_menemukan_nama_dan_kontak(): void
    {
        Mitra::factory()->create(['nama' => 'PT CARI SAYA', 'kontak' => '0811']);
        Mitra::factory()->create(['nama' => 'PT LAIN', 'kontak' => '0822']);

        Livewire::test(PartnerTable::class)
            ->set('cari', 'CARI SAYA')
            ->assertSee('PT CARI SAYA')
            ->assertDontSee('PT LAIN');
    }

    /* =====================================================
       Pengguna - HANYA Direktur
       ===================================================== */

    public function test_admin_tidak_boleh_membuka_manajemen_akun(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/users')
            ->assertForbidden();
    }

    public function test_direktur_membuka_manajemen_akun(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get('/panel/users')
            ->assertOk()
            ->assertSee('Tambah Pengguna');
    }

    public function test_direktur_membuat_akun_admin_baru(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->post('/panel/users', [
                'nama' => 'Admin Kedua',
                'email' => 'admin2@bks.test',
                'peran' => Peran::Admin->value,
                'password' => 'rahasia123',
                'is_aktif' => '1',
            ])
            ->assertRedirect(route('panel.users.index'));

        $this->assertDatabaseHas('pengguna', ['email' => 'admin2@bks.test', 'peran' => 'admin']);
    }

    public function test_password_terlalu_pendek_ditolak(): void
    {
        $this->actingAs($this->pengguna(Peran::Direktur))
            ->post('/panel.users', [
                'nama' => 'Admin Pendek',
                'email' => 'pendek@bks.test',
                'peran' => Peran::Admin->value,
                'password' => 'abc',
            ]);

        $this->assertDatabaseMissing('pengguna', ['email' => 'pendek@bks.test']);
    }

    public function test_direktur_tidak_bisa_menonaktifkan_atau_mengubah_peran_akunnya_sendiri(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);

        $this->actingAs($direktur)
            ->put(route('panel.users.update', $direktur), [
                'nama' => 'Direktur Utama',
                'email' => $direktur->email,
                'peran' => Peran::Admin->value,
                'is_aktif' => '0',
            ])
            ->assertRedirect(route('panel.users.index'));

        $direktur->refresh();

        $this->assertSame(Peran::Direktur, $direktur->peran);
        $this->assertTrue($direktur->is_aktif);
        $this->assertSame('Direktur Utama', $direktur->nama);
    }

    public function test_direktur_tidak_bisa_menghapus_akunnya_sendiri(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);

        $this->actingAs($direktur)
            ->delete(route('panel.users.destroy', $direktur))
            ->assertRedirect(route('panel.users.index'));

        $this->assertDatabaseHas('pengguna', ['id' => $direktur->id]);
    }

    public function test_akun_yang_dipakai_membuat_spk_tidak_dihapus_hanya_dinonaktifkan(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $admin = $this->pengguna(Peran::Admin);
        Spk::factory()->create(['dibuat_oleh' => $admin->id]);

        $this->actingAs($direktur)
            ->delete(route('panel.users.destroy', $admin))
            ->assertRedirect(route('panel.users.index'));

        $this->assertDatabaseHas('pengguna', ['id' => $admin->id]);
    }

    public function test_direktur_mengubah_akun_lain_dan_ganti_password(): void
    {
        $direktur = $this->pengguna(Peran::Direktur);
        $admin = $this->pengguna(Peran::Admin);
        $sandiLama = $admin->password;

        $this->actingAs($direktur)
            ->put(route('panel.users.update', $admin), [
                'nama' => 'Admin Diubah',
                'email' => $admin->email,
                'peran' => Peran::Admin->value,
                'password' => 'sandibaru123',
                'is_aktif' => '1',
            ]);

        $admin->refresh();

        $this->assertSame('Admin Diubah', $admin->nama);
        $this->assertNotSame($sandiLama, $admin->password);
    }
}
