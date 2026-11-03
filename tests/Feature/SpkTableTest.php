<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Livewire\Spk\SpkTable;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * TABEL LIST SPK pada panel Blade (/panel/spk).
 *
 * Tabel ini adalah POLA ACUAN untuk tabel lain (Uang Masuk, Uang Keluar,
 * Mitra, Pengguna), jadi yang diuji adalah perilaku yang gampang rusak
 * diam-diam saat pola ini disalin:
 *
 *   1. Menyaring TIDAK boleh kehilangan data lain (penyaring bocor).
 *   2. Nama kolom pengurutan datang dari URL → wajib ada daftar putih.
 *   3. Penyaring berubah wajib mengembalikan ke halaman 1.
 *   4. Hak akses tetap ditegakkan di rute, bukan cuma disembunyikan di menu.
 */
class SpkTableTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    /* =====================================================
       Akses halaman
       ===================================================== */

    public function test_tamu_tidak_bisa_membuka_daftar_spk(): void
    {
        $this->get('/panel/spk')->assertRedirect('/panel/login');
    }

    public function test_admin_melihat_daftar_spk(): void
    {
        $spk = Spk::factory()->create(['nomor_spk' => 'SPK-PANEL-001']);

        $this->actingAs($this->admin())
            ->get('/panel/spk')
            ->assertOk()
            ->assertSee('SPK-PANEL-001')
            ->assertSee($spk->nama_pekerjaan);
    }

    public function test_direktur_juga_boleh_melihat_daftar_spk(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-PANEL-002']);

        $this->actingAs(Pengguna::factory()->create(['peran' => Peran::Direktur]))
            ->get('/panel/spk')
            ->assertOk()
            ->assertSee('SPK-PANEL-002');
    }

    /* =====================================================
       Pencarian
       ===================================================== */

    public function test_cari_nomor_spk_menyaring_tanpa_membuang_data_lain(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-AAA-111']);
        Spk::factory()->create(['nomor_spk' => 'SPK-BBB-222']);

        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->set('cari', 'AAA')
            ->assertSee('SPK-AAA-111')
            ->assertDontSee('SPK-BBB-222');
    }

    public function test_cari_juga_menjangkau_nama_mitra(): void
    {
        $mitra = Mitra::factory()->create(['nama' => 'CV Sinar Abadi']);
        Spk::factory()->create(['nomor_spk' => 'SPK-MITRA-1', 'mitra_id' => $mitra->id]);
        Spk::factory()->create(['nomor_spk' => 'SPK-MITRA-2']);

        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->set('cari', 'Sinar Abadi')
            ->assertSee('SPK-MITRA-1')
            ->assertDontSee('SPK-MITRA-2');
    }

    public function test_ringkasan_mengikuti_penyaring_bukan_seluruh_tabel(): void
    {
        Spk::factory()->create([
            'nomor_spk' => 'SPK-RINGKAS-DRAFT',
            'status_spk' => StatusSpk::Draft,
            'nilai_spk' => 10_000_000,
        ]);
        Spk::factory()->create([
            'nomor_spk' => 'SPK-RINGKAS-JALAN',
            'status_spk' => StatusSpk::Berjalan,
            'nilai_spk' => 90_000_000,
        ]);

        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->set('status', StatusSpk::Draft->value)
            ->assertViewHas('ringkas', fn (array $r): bool => $r['jumlah'] === 1 && $r['nilai'] === 10_000_000.0);
    }

    /* =====================================================
       Penyaring
       ===================================================== */

    public function test_penyaring_status_spk_dan_status_tagihan_bekerja_terpisah(): void
    {
        Spk::factory()->create([
            'nomor_spk' => 'SPK-SARING-A',
            'status_spk' => StatusSpk::Selesai,
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);
        Spk::factory()->create([
            'nomor_spk' => 'SPK-SARING-B',
            'status_spk' => StatusSpk::Berjalan,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);

        $komponen = Livewire::actingAs($this->admin())->test(SpkTable::class);

        $komponen->set('status', StatusSpk::Selesai->value)
            ->assertSee('SPK-SARING-A')
            ->assertDontSee('SPK-SARING-B');

        $komponen->set('status', '')
            ->set('tagihan', StatusTagihan::BelumDitagihkan->value)
            ->assertSee('SPK-SARING-B')
            ->assertDontSee('SPK-SARING-A');
    }

    public function test_tombol_bersihkan_mengembalikan_seluruh_baris(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK-BERSIH-1']);
        Spk::factory()->create(['nomor_spk' => 'SPK-BERSIH-2']);

        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->set('cari', 'tidak-ada-yang-cocok')
            ->assertDontSee('SPK-BERSIH-1')
            ->call('bersihkan')
            ->assertSee('SPK-BERSIH-1')
            ->assertSee('SPK-BERSIH-2');
    }

    /* =====================================================
       Pengurutan
       ===================================================== */

    public function test_klik_kolom_yang_sama_membalik_arah(): void
    {
        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->assertSet('urut', 'tanggal_spk')
            ->assertSet('arah', 'desc')
            ->call('urutkan', 'tanggal_spk')
            ->assertSet('arah', 'asc')
            ->call('urutkan', 'tanggal_spk')
            ->assertSet('arah', 'desc');
    }

    public function test_kolom_pengurutan_dari_luar_daftar_putih_diabaikan(): void
    {
        // `?urut=id;drop table spk` tidak boleh sampai ke orderBy().
        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->call('urutkan', 'nilai_spk')
            ->assertSet('urut', 'nilai_spk')
            ->call('urutkan', 'password')
            ->assertSet('urut', 'nilai_spk');
    }

    /* =====================================================
       Paginasi
       ===================================================== */

    public function test_mengubah_penyaring_kembali_ke_halaman_satu(): void
    {
        Spk::factory()->count(20)->create();

        Livewire::actingAs($this->admin())
            ->test(SpkTable::class)
            ->call('setPage', 2)
            ->assertSet('paginators.page', 2)
            ->set('cari', 'SPK')
            ->assertSet('paginators.page', 1);
    }
}
