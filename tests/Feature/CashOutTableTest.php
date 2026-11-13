<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Livewire\CashOut\CashOutTable;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CashOutTableTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_tamu_tidak_bisa_membuka_halaman_cash_out(): void
    {
        $this->get('/panel/cash-out')->assertRedirect('/panel/login');
    }

    public function test_admin_dan_direktur_bisa_melihat_daftar_uang_keluar(): void
    {
        UangKeluar::factory()->create([
            'penerima' => 'Toko Bangunan Unik 99',
            'jumlah' => 4500000,
        ]);

        $this->actingAs($this->admin())
            ->get('/panel/cash-out')
            ->assertOk()
            ->assertSee('Toko Bangunan Unik 99');

        $this->actingAs(Pengguna::factory()->create(['peran' => Peran::Direktur]))
            ->get('/panel/cash-out')
            ->assertOk()
            ->assertSee('Toko Bangunan Unik 99');
    }

    public function test_pencarian_uang_keluar_menyaring_tepat(): void
    {
        $this->actingAs($this->admin());

        UangKeluar::factory()->create(['penerima' => 'Bengkel Las Kurnia']);
        UangKeluar::factory()->create(['penerima' => 'Distributor Besi Baja']);

        Livewire::test(CashOutTable::class)
            ->set('cari', 'Kurnia')
            ->assertSee('Bengkel Las Kurnia')
            ->assertDontSee('Distributor Besi Baja');
    }

    public function test_penyaring_kategori_dan_akun_memfilter_data(): void
    {
        $this->actingAs($this->admin());

        UangKeluar::factory()->create([
            'penerima' => 'Toko Semen Super',
            'kategori' => KategoriPengeluaran::Material,
            'akun' => AkunKas::Bank,
        ]);
        UangKeluar::factory()->create([
            'penerima' => 'Jasa Angkut Pasir',
            'kategori' => KategoriPengeluaran::Upah,
            'akun' => AkunKas::Kas,
        ]);

        Livewire::test(CashOutTable::class)
            ->set('kategori', KategoriPengeluaran::Material->value)
            ->assertSee('Toko Semen Super')
            ->assertDontSee('Jasa Angkut Pasir');
    }

    public function test_daftar_putih_pengurutan_mencegah_kolom_ilegal(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(CashOutTable::class)
            ->call('urutkan', 'status_rahasia')
            ->assertSet('urut', 'tanggal')
            ->call('urutkan', 'jumlah')
            ->assertSet('urut', 'jumlah');
    }

    public function test_perubahan_filter_mereset_halaman(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(CashOutTable::class)
            ->set('cari', 'Pencarian Baru')
            ->assertSet('paginators.page', 1);
    }
}
