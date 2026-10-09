<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSelesaiSpkResource;
use App\Filament\Resources\MonitoringSpk\TagihanSpkResource;
use App\Filament\Resources\Spks\Pages\ListSpks;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji REVISI USER (lanjutan):
 *   1. Menu SPK disatukan & diletakkan paling atas.
 *   2. List SPK: hanya Edit & Delete (tanpa Restore/Force Delete).
 *   3. Status SPK: status bisa diubah + ada filter status.
 *   4. Tanggal SPK untuk "TANPA SPK" dipertegas.
 *   5. Uang keluar: 4 baris sekaligus di Tambah Uang Keluar (tanpa menu baru).
 */
class RevisiMenuSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-rev@bks.test']);
    }

    // =========================================================
    // 1. NAVIGASI
    // =========================================================

    public function test_list_spk_berada_di_grup_spk(): void
    {
        $this->assertSame('SPK', SpkResource::getNavigationGroup());
        $this->assertSame('List SPK', SpkResource::getNavigationLabel());
    }

    public function test_monitoring_berada_di_grup_spk_yang_sama(): void
    {
        // Disatukan: bukan lagi grup "Monitoring SPK" terpisah.
        $this->assertSame('SPK', StatusSpkResource::getNavigationGroup());
        $this->assertSame(
            SpkResource::getNavigationGroup(),
            StatusSpkResource::getNavigationGroup(),
            'List SPK & monitoring harus satu grup'
        );
    }

    public function test_urutan_menu_spk_benar(): void
    {
        $list = SpkResource::getNavigationSort();
        $status = StatusSpkResource::getNavigationSort();
        $tagihan = TagihanSpkResource::getNavigationSort();
        $selesai = TagihanSelesaiSpkResource::getNavigationSort();

        $this->assertSame(1, $list, 'List SPK harus paling atas');
        $this->assertSame(2, $status);
        $this->assertSame(3, $tagihan);
        $this->assertSame(4, $selesai);
    }

    // =========================================================
    // 2. LIST SPK — hanya Edit & Delete
    // =========================================================

    public function test_list_spk_punya_edit_dan_delete(): void
    {
        $spk = Spk::factory()->pln()->create(['dibuat_oleh' => $this->admin->id]);

        $this->actingAs($this->admin);

        /*
         * ⚠️ PERUBAHAN (2 Okt 2026) — permintaan pengguna:
         *   "untuk button edit, hapus, kelola, dan lainya itu diletakkan pada
         *    preview dari data spk yang dipilih"
         *
         * Dulu 'Ubah'/'Hapus' tampil di TIAP baris tabel. Sekarang keduanya
         * ada DI DALAM preview (tombol "Detail"), supaya tabel bersih dan
         * tombol tidak mudah salah klik. Jadi tes ini tidak lagi mencari teks
         * di halaman, melainkan memastikan aksinya ADA di dalam preview.
         */
        Livewire::test(ListSpks::class)
            ->mountAction(TestAction::make('view')->table($spk))
            ->assertActionVisible('ubah')
            ->assertActionVisible('hapus');
    }

    public function test_list_spk_tidak_punya_restore_dan_force_delete(): void
    {
        Spk::factory()->pln()->create(['dibuat_oleh' => $this->admin->id]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/spks')
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString('Restore', $html, 'Aksi Restore harus dihapus');
        $this->assertStringNotContainsString('Force', $html, 'Aksi Force Delete harus dihapus');
    }

    public function test_tanpa_spk_tanggal_diberi_keterangan(): void
    {
        Spk::factory()->pln()->tanpaSpk()->create(['dibuat_oleh' => $this->admin->id]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/spks')
            ->assertOk()
            ->getContent();

        // Kolom Tanggal SPK untuk SPK tanpa tanggal kini menampilkan
        // "Tanpa tanggal" (dulu "TANPA SPK" — membingungkan karena kolomnya
        // Tanggal, bukan status SPK). Temuan uji deploy 9 Okt 2026.
        $this->assertStringContainsString('Tanpa tanggal', $html);
    }

    // =========================================================
    // 3. STATUS SPK — bisa diubah + filter status
    // =========================================================

    public function test_status_spk_diubah_lewat_form_terpisah(): void
    {
        // ⚠️ REVISI USER: status TIDAK lagi diubah dari halaman monitoring.
        // Status hanya menampilkan progres; perubahan lewat form terpisah
        // (UbahStatusSpk) supaya tidak salah ubah data lain.
        $spk = Spk::factory()->pln()->create(['dibuat_oleh' => $this->admin->id]);

        $this->actingAs($this->admin);

        // Form terpisah bisa dibuka
        $this->get('/admin/spks/'.$spk->getRouteKey().'/status-pekerjaan')->assertOk();
        $this->get('/admin/spks/'.$spk->getRouteKey().'/status-tagihan')->assertOk();
    }

    public function test_direktur_tidak_bisa_ubah_status(): void
    {
        $direktur = Pengguna::factory()->direktur()->create(['email' => 'dir-rev@bks.test']);
        $spk = Spk::factory()->pln()->create(['dibuat_oleh' => $this->admin->id]);

        $this->actingAs($direktur);
        $this->assertFalse(StatusSpkResource::canEdit($spk));
    }

    public function test_halaman_status_spk_menampilkan_dropdown_status(): void
    {
        Spk::factory()->pln()->create(['dibuat_oleh' => $this->admin->id]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/monitoring-spk/status-spks')
            ->assertOk()
            ->getContent();

        // SelectColumn = dropdown untuk mengubah status langsung
        $this->assertMatchesRegularExpression('/<select[^>]*fi-select-input|fi-select-input/', $html);
    }

    public function test_form_ubah_status_hanya_berisi_status(): void
    {
        // Form terpisah: konteks read-only + SATU field status.
        // Data lain (nomor, nilai, pekerjaan) hanya ditampilkan.
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'RINGKAS-1',
            'nama_pekerjaan' => 'Pekerjaan Uji Ringkas',
            'dibuat_oleh' => $this->admin->id,
        ]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/spks/'.$spk->id.'/status-pekerjaan')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Ubah Status Pekerjaan', $html);
        // Field data SPK tidak boleh bisa diisi dari sini
        $this->assertStringNotContainsString('name="data[nama_pekerjaan]"', $html);
        $this->assertStringNotContainsString('name="data[nilai_spk]"', $html);
    }

    // =========================================================
    // 4. UANG KELUAR — 4 baris di Tambah, tanpa menu baru
    // =========================================================

    public function test_tidak_ada_menu_input_uang_keluar_terpisah(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/input-uang-keluar-massal')
            ->assertNotFound();
    }

    public function test_tambah_uang_keluar_menyediakan_unggah_nota(): void
    {
        // Revisi lanjutan: jumlah baris mengikuti jumlah nota, bukan 4 tetap.
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Unggah Berkas Nota', $html);
        $this->assertStringContainsString('berkas_nota', $html);
        $this->assertStringContainsString('Isi Rincian', $html);
    }

    public function test_ubah_uang_keluar_masih_satu_form(): void
    {
        $keluar = UangKeluar::factory()->create();

        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/'.$keluar->id.'/edit')
            ->assertOk()
            ->getContent();

        // Halaman UBAH tetap form tunggal (tidak ada repeater & tidak ada
        // bagian unggah sekaligus).
        $this->assertStringContainsString('Detail Pengeluaran', $html);
        $this->assertStringNotContainsString('Isi Rincian', $html);
    }
}
