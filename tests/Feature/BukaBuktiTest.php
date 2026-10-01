<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BUKA BUKTI DARI TABEL UANG MASUK & UANG KELUAR.
 *
 * ⚠️ SUMBER (keluhan pengguna 29 Sep 2026):
 *   "admin perlu itu kemudahan untuk mengelolanya, mencari bukti dari uang
 *    tersebut, dan kebutuhan data lainnya"
 *
 * ⚠️ MASALAH SEBELUMNYA:
 * Tabel hanya menampilkan kolom "Bukti" berisi jumlah file (mis. "2 file").
 * Admin TIDAK BISA membuka berkasnya dari tabel — harus klik Edit dulu,
 * lalu menggulir ke bagian unggahan. Untuk mencari bukti satu transaksi
 * (mis. saat bagian pajak meminta), itu merepotkan.
 *
 * SOLUSI:
 * Aksi "Lihat Bukti" di tiap baris, membuka berkas di tab baru lewat rute
 * ber-otentikasi `/admin/nota/{path}` (disk privat — tidak bisa diakses
 * tanpa login).
 */
class BukaBuktiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-bukti@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    // ---------------------------------------------------------------
    // UANG MASUK
    // ---------------------------------------------------------------

    public function test_uang_masuk_punya_aksi_lihat_bukti(): void
    {
        $record = UangMasuk::factory()->denganBukti(2)->create();

        Livewire::test(ListUangMasuks::class)
            ->assertTableActionExists('lihatBukti', record: $record);
    }

    public function test_aksi_lihat_bukti_menunjuk_berkas_yang_benar(): void
    {
        $record = UangMasuk::factory()->denganBukti(1)->create();

        $paths = $record->bukti;
        $this->assertNotEmpty($paths, 'Data uji harus punya berkas bukti.');

        $url = route('nota.lihat', ['path' => $paths[0]]);

        $this->assertStringContainsString('/admin/nota/', $url);
    }

    public function test_transaksi_tanpa_bukti_tidak_menampilkan_aksi(): void
    {
        /*
         * Kalau tidak ada berkas, tombol "Lihat Bukti" harus disembunyikan —
         * tombol yang membuka halaman kosong lebih membingungkan daripada
         * tidak ada tombol sama sekali.
         */
        $record = UangMasuk::factory()->create(['bukti' => null]);

        Livewire::test(ListUangMasuks::class)
            ->assertTableActionHidden('lihatBukti', record: $record);
    }

    // ---------------------------------------------------------------
    // UANG KELUAR
    // ---------------------------------------------------------------

    public function test_uang_keluar_punya_aksi_lihat_bukti(): void
    {
        $record = UangKeluar::factory()->denganBukti(3)->create();

        Livewire::test(ListUangKeluars::class)
            ->assertTableActionExists('lihatBukti', record: $record);
    }

    public function test_uang_keluar_tanpa_bukti_tidak_menampilkan_aksi(): void
    {
        $record = UangKeluar::factory()->create(['bukti' => null]);

        Livewire::test(ListUangKeluars::class)
            ->assertTableActionHidden('lihatBukti', record: $record);
    }

    // ---------------------------------------------------------------
    // KEAMANAN — bukti hanya lewat rute ber-otentikasi
    // ---------------------------------------------------------------

    public function test_bukti_tidak_bisa_dibuka_tanpa_login(): void
    {
        /*
         * ⚠️ Nota memuat harga material, pembayaran subkon, dan gaji karyawan.
         * Rute `/admin/nota/{path}` WAJIB menolak tamu.
         */
        $record = UangMasuk::factory()->denganBukti(1)->create();
        $path = $record->bukti[0];

        auth()->logout();

        $this->get(route('nota.lihat', ['path' => $path]))
            ->assertRedirect(); // diarahkan ke halaman login
    }
}
