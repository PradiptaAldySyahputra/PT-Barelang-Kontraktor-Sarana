<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Modul Uang Keluar — tahap sekarang: daftar + hapus/pulihkan.
 * Form input (OCR nota) belum dimigrasi, jadi tidak diuji di sini.
 */
class CashOutPanelTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/panel/cash-out')->assertRedirect('/panel/login');
    }

    public function test_direktur_boleh_melihat_daftar(): void
    {
        UangKeluar::factory()->create(['jumlah' => 1_500_000]);

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get('/panel/cash-out')
            ->assertOk()
            ->assertSee('Total Uang Keluar (terfilter)');
    }

    public function test_admin_bisa_menghapus_dan_memulihkan(): void
    {
        $admin = $this->pengguna(Peran::Admin);
        $trx = UangKeluar::factory()->create();

        $this->actingAs($admin)->delete(route('panel.cash-out.destroy', $trx));
        $this->assertSoftDeleted($trx);

        $this->actingAs($admin)->post(route('panel.cash-out.restore', $trx->id));
        $this->assertNotSoftDeleted($trx);
    }

    public function test_direktur_sebagai_super_admin_bisa_menghapus(): void
    {
        $trx = UangKeluar::factory()->create();

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->delete(route('panel.cash-out.destroy', $trx))
            ->assertRedirect();

        $this->assertSoftDeleted($trx);
    }

    public function test_filter_kategori_dan_sumber_bekerja(): void
    {
        $spk = Spk::factory()->create();
        UangKeluar::factory()->create([
            'kategori' => KategoriPengeluaran::Material,
            'akun' => AkunKas::Kas,
            'spk_id' => $spk->id,
            'jumlah' => 2_000_000,
        ]);
        UangKeluar::factory()->create([
            'kategori' => KategoriPengeluaran::Gaji,
            'akun' => AkunKas::Bank,
            'spk_id' => null,
            'jumlah' => 5_000_000,
        ]);

        $this->actingAs($this->pengguna(Peran::Admin));

        $this->get('/panel/cash-out?kategori=gaji')
            ->assertOk()
            ->assertSee('Rp 5.000.000')
            ->assertDontSee('Rp 2.000.000');

        $this->get('/panel/cash-out?sumber=luar')
            ->assertOk()
            ->assertSee('Rp 5.000.000')
            ->assertDontSee('Rp 2.000.000');
    }
}