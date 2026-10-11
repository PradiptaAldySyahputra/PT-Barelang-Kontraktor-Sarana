<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\EditUangKeluar;
use App\Filament\Resources\UangMasuks\Pages\EditUangMasuk;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * TRANSAKSI TIDAK BOLEH DIHAPUS PERMANEN — Rules.md §2 butir 9.
 *
 * ⚠️ TEMUAN SURVEI (10 Okt 2026):
 * Halaman Ubah Uang Masuk & Uang Keluar menyediakan `ForceDeleteAction`
 * ("Hapus Permanen") yang membuat baris HILANG dari database tanpa bisa
 * dipulihkan — bertentangan dengan aturan di atas, dan berisiko saat
 * audit/pajak. Sudah dibuktikan bisa dieksekusi (tes survei).
 *
 * Berkas ini mengunci perbaikan: hapus permanen TIDAK tersedia lagi, tetapi
 * soft delete + pulihkan TETAP ada.
 */
class TanpaHapusPermanenTransaksiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-hapus@bks.test']);
        $this->actingAs($this->admin);
    }

    public function test_uang_keluar_tidak_punya_aksi_hapus_permanen(): void
    {
        $keluar = UangKeluar::factory()->create([
            'jumlah' => 1_000_000,
            'tanggal' => now()->toDateString(),
        ]);
        $keluar->delete(); // terhapus (soft) → supaya kalau ada tombol, ia muncul

        Livewire::test(EditUangKeluar::class, ['record' => $keluar->id])
            ->assertActionDoesNotExist('forceDelete');
    }

    public function test_uang_masuk_tidak_punya_aksi_hapus_permanen(): void
    {
        $masuk = UangMasuk::factory()->create([
            'jumlah' => 1_000_000,
            'tanggal' => now()->toDateString(),
        ]);
        $masuk->delete();

        Livewire::test(EditUangMasuk::class, ['record' => $masuk->id])
            ->assertActionDoesNotExist('forceDelete');
    }

    public function test_soft_delete_dan_pulihkan_tetap_tersedia(): void
    {
        $keluar = UangKeluar::factory()->create([
            'jumlah' => 2_000_000,
            'tanggal' => now()->toDateString(),
        ]);

        // Soft delete lewat model → baris masih ada (deleted_at terisi).
        $keluar->delete();

        $this->assertSoftDeleted('uang_keluar', ['id' => $keluar->id]);

        // Pulihkan.
        $keluar->restore();

        $this->assertDatabaseHas('uang_keluar', [
            'id' => $keluar->id,
            'deleted_at' => null,
        ]);
    }
}
