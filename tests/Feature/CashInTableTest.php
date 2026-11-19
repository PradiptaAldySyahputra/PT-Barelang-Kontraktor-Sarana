<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\Peran;
use App\Livewire\CashIn\CashInTable;
use App\Models\Pengguna;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CashInTableTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_tamu_tidak_bisa_membuka_halaman_cash_in(): void
    {
        $this->get('/panel/cash-in')->assertRedirect('/panel/login');
    }

    public function test_admin_dan_direktur_bisa_melihat_daftar_uang_masuk(): void
    {
        UangMasuk::factory()->create([
            'keterangan' => 'Pembayaran Termin Spesifik 1',
            'jumlah' => 12500000,
        ]);

        $this->actingAs($this->admin())
            ->get('/panel/cash-in')
            ->assertOk()
            ->assertSee('Pembayaran Termin Spesifik 1');

        $this->actingAs(Pengguna::factory()->create(['peran' => Peran::Direktur]))
            ->get('/panel/cash-in')
            ->assertOk()
            ->assertSee('Pembayaran Termin Spesifik 1');
    }

    public function test_pencarian_uang_masuk_menyaring_tepat(): void
    {
        $this->actingAs($this->admin());

        UangMasuk::factory()->create(['keterangan' => 'Injeksi Modal Operasional']);
        UangMasuk::factory()->create(['keterangan' => 'Pengembalian Dana Vendor']);

        Livewire::test(CashInTable::class)
            ->set('cari', 'Injeksi Modal')
            ->assertSee('Injeksi Modal Operasional')
            ->assertDontSee('Pengembalian Dana Vendor');
    }

    public function test_penyaring_akun_kas_memfilter_data(): void
    {
        $this->actingAs($this->admin());

        UangMasuk::factory()->create([
            'keterangan' => 'Setoran Kas Tunai',
            'akun' => AkunKas::Kas,
        ]);
        UangMasuk::factory()->create([
            'keterangan' => 'Transfer Bank BCA',
            'akun' => AkunKas::Bank,
        ]);

        Livewire::test(CashInTable::class)
            ->set('akun', 'kas')
            ->assertSee('Setoran Kas Tunai')
            ->assertDontSee('Transfer Bank BCA');
    }

    public function test_daftar_putih_pengurutan_mencegah_kolom_ilegal(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(CashInTable::class)
            ->call('urutkan', 'password')
            ->assertSet('urut', 'tanggal')
            ->call('urutkan', 'jumlah')
            ->assertSet('urut', 'jumlah');
    }

    public function test_perubahan_filter_mereset_tampilan_terbatas(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(CashInTable::class)
            ->set('semua', true)
            ->assertSet('semua', true)
            ->set('cari', 'Keyword Baru')
            ->assertSet('semua', false);
    }
}
