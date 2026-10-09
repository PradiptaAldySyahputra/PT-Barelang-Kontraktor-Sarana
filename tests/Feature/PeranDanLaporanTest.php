<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeranDanLaporanTest extends TestCase
{
    use RefreshDatabase;

    /** Rules §4: Direktur TIDAK boleh CRUD input. */
    public function test_direktur_ditolak_akses_input_spk(): void
    {
        $dir = Pengguna::factory()->create(['peran' => Peran::Direktur]);
        $this->actingAs($dir);
        // Akses halaman tambah harus ditolak sistem (403), bukan sekadar menu disembunyikan.
        $this->get(CreateSpk::getUrl())->assertForbidden();
        fwrite(STDERR, "\n[9] Direktur → CreateSpk = 403 Forbidden ✅\n");
    }

    public function test_admin_diizinkan_akses_input_spk(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $this->get(CreateSpk::getUrl())->assertSuccessful();
        fwrite(STDERR, "[10] Admin → CreateSpk = 200 OK ✅\n");
    }

    /** Rules §2: piutang = nilai_spk − sudah_diterima. */
    public function test_laporan_piutang_sesuai_rumus(): void
    {
        $spk = Spk::factory()->create(['nomor_spk' => 'LAP-1', 'nilai_spk' => 100_000_000]);
        UangMasuk::create(['spk_id' => $spk->id, 'tanggal' => '2026-09-01', 'jumlah' => 25_000_000]);
        $spk->refresh();
        fwrite(STDERR, '[11] Laporan piutang: nilai=100jt diterima=25jt piutang='.$spk->piutang()."\n");
        $this->assertSame(75_000_000.0, $spk->piutang(), 'Piutang != nilai − diterima');
    }
}
