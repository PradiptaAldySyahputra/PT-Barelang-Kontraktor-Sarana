<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use App\Support\LaporanData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Penjaga temuan audit pasca-migrasi Filament -> Blade (Nov 2026):
 * navigasi Kembali/asal, open redirect, filter rentang laporan, ZIP terfilter,
 * dan konsistensi status "selesai" di notifikasi/kalender.
 */
class AuditPascaMigrasiTest extends TestCase
{
    use RefreshDatabase;

    private function masuk(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_status_dari_monitoring_kembali_ke_monitoring(): void
    {
        $spk = Spk::factory()->create();

        $this->actingAs($this->masuk())
            ->get(route('panel.spk.status', ['spk' => $spk, 'asal' => 'status-spk']))
            ->assertOk()
            ->assertSee(route('panel.spk.monitoring', 'status'), false);

        $this->actingAs($this->masuk())
            ->put(route('panel.spk.status.update', ['spk' => $spk, 'asal' => 'status-spk']), [
                'status_spk' => StatusSpk::Berjalan->value,
            ])
            ->assertRedirect(route('panel.spk.monitoring', 'status'));
    }

    public function test_ubah_dari_detail_kembali_ke_detail_dan_asal_asing_ditolak(): void
    {
        $spk = Spk::factory()->create();
        $admin = $this->masuk();

        $this->actingAs($admin)
            ->get(route('panel.spk.edit', ['spk' => $spk, 'asal' => 'show']))
            ->assertSee(route('panel.spk.show', $spk), false);

        // Open redirect: URL luar tidak boleh jadi tujuan Kembali.
        $this->actingAs($admin)
            ->get(route('panel.spk.edit', ['spk' => $spk, 'asal' => 'https://evil.example']))
            ->assertOk()
            ->assertDontSee('evil.example', false);

        $this->actingAs($admin)
            ->put(route('panel.spk.status.update', ['spk' => $spk, 'asal' => '//evil.example']), [
                'status_spk' => StatusSpk::Berjalan->value,
            ])
            ->assertRedirect(route('panel.spk.index'));
    }

    public function test_laporan_rentang_tanggal_kustom_memfilter_data(): void
    {
        UangMasuk::factory()->create(['tanggal' => '2026-01-10', 'jumlah' => 1000, 'spk_id' => null, 'mitra_id' => null]);
        UangMasuk::factory()->create(['tanggal' => '2026-03-10', 'jumlah' => 5000, 'spk_id' => null, 'mitra_id' => null]);

        $data = LaporanData::lengkap(0, Carbon::parse('2026-03-01'), Carbon::parse('2026-03-31'));

        $this->assertSame(5000.0, $data['totalMasuk']);
    }

    public function test_zip_arsip_nota_memakai_filter_dari_url(): void
    {
        // Tanpa berkas nyata ZIP kosong -> 404; yang diuji: rute menerima q/tgl tanpa error 500.
        $this->actingAs($this->masuk())
            ->get(route('arsip-nota.zip', ['q' => 'tidak-ada-apa-apa', 'tgl' => '2026-01-01']))
            ->assertNotFound();
    }

    public function test_spk_sudah_ditagihkan_tidak_dihitung_lewat_tenggat(): void
    {
        $spk = Spk::factory()->create([
            'tanggal_akhir' => now()->subDays(10),
            'status_spk' => StatusSpk::SudahDitagihkan,
        ]);

        $this->assertFalse(Spk::query()->lewatTenggat()->whereKey($spk->id)->exists());
        $this->assertTrue($spk->sudahSelesai());
    }

    public function test_bast_pdf_dengan_nomor_spk_bergaris_miring_berhasil_diunduh(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => '0000.SPK/UJI.00.00/UJIBATAM000000/2026',
        ]);

        $this->actingAs($this->masuk())
            ->get(route('panel.spk.bast', $spk))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_halaman_status_sistem_tidak_menampilkan_tombol_kembali(): void
    {
        $this->actingAs($this->masuk())
            ->get(route('panel.status'))
            ->assertOk()
            ->assertDontSee('Kembali ke halaman sebelumnya', false);
    }
}
