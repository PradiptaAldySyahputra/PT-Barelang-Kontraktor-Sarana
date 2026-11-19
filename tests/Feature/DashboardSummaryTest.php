<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusSpk;
use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\DashboardSummary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_ringkasan_eksekutif_menghitung_kpi_dan_piutang_dengan_benar(): void
    {
        $spk = Spk::factory()->create([
            'nilai_spk' => 100000000,
            'status_spk' => StatusSpk::Berjalan,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 40000000,
            'tanggal' => now()->toDateString(),
        ]);

        UangKeluar::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 15000000,
            'tanggal' => now()->toDateString(),
        ]);

        $data = DashboardSummary::eksekutif();

        $this->assertIsArray($data['kpi']);
        $this->assertIsArray($data['sebaranTagihan']);
        $this->assertIsArray($data['tren']);

        // Nilai pekerjaan harus mencerminkan 100jt dan sisa piutang 60jt
        $this->assertStringContainsString('100.000.000', $data['kpi'][0]['nilai']);
        $this->assertStringContainsString('60.000.000', $data['kpi'][1]['nilai']);
    }

    public function test_ringkasan_operasional_menampilkan_saldo_dan_tugas_kritis(): void
    {
        Spk::factory()->create([
            'tanggal_akhir' => now()->subDays(2),
            'status_spk' => StatusSpk::Berjalan,
        ]);

        $data = DashboardSummary::operasional();

        $this->assertArrayHasKey('saldo', $data);
        $this->assertArrayHasKey('antrean', $data);
        $this->assertArrayHasKey('hariIni', $data);
        $this->assertArrayHasKey('bandingMasuk', $data['bulanIni']);
        $this->assertArrayHasKey('bandingKeluar', $data['bulanIni']);
    }

    public function test_spk_berjalan_mencakup_status_terbit_dan_berjalan(): void
    {
        Spk::factory()->create(['nomor_spk' => 'SPK/TEST/TERBIT/01', 'status_spk' => StatusSpk::Terbit]);
        Spk::factory()->create(['nomor_spk' => 'SPK/TEST/BERJALAN/02', 'status_spk' => StatusSpk::Berjalan]);
        Spk::factory()->create(['nomor_spk' => 'SPK/TEST/DRAFT/03', 'status_spk' => StatusSpk::Draft]);

        $data = DashboardSummary::operasional();

        $this->assertSame(2, $data['spkBerjalanCount']);
        $nomorTerdaftar = array_column($data['spkBerjalan'], 'nomor_spk');
        $this->assertContains('SPK/TEST/TERBIT/01', $nomorTerdaftar);
        $this->assertContains('SPK/TEST/BERJALAN/02', $nomorTerdaftar);
        $this->assertNotContains('SPK/TEST/DRAFT/03', $nomorTerdaftar);
    }

    public function test_top_mitra_piutang_mengecualikan_spk_dibatalkan(): void
    {
        $alpha = Mitra::factory()->create(['nama' => 'PT Alpha']);
        $beta = Mitra::factory()->create(['nama' => 'PT Beta']);

        Spk::factory()->create([
            'mitra_id' => $alpha->id,
            'nilai_spk' => 100000000,
            'status_spk' => StatusSpk::Berjalan,
        ]);
        UangMasuk::factory()->create([
            'spk_id' => Spk::where('mitra_id', $alpha->id)->first()->id,
            'jumlah' => 40000000,
            'tanggal' => now()->toDateString(),
        ]);
        Spk::factory()->create([
            'mitra_id' => $beta->id,
            'nilai_spk' => 50000000,
            'status_spk' => StatusSpk::Berjalan,
        ]);
        // SPK Dibatalkan tidak boleh ikut dihitung.
        Spk::factory()->create([
            'mitra_id' => $alpha->id,
            'nilai_spk' => 500000000,
            'status_spk' => StatusSpk::Dibatalkan,
        ]);

        $top = DashboardSummary::eksekutif()['topMitraPiutang'];

        $this->assertCount(2, $top);
        $this->assertSame('PT Alpha', $top[0]['mitra']);
        $this->assertSame(100000000.0, $top[0]['nilai']);
        $this->assertSame(60000000.0, $top[0]['sisa']);
        $this->assertSame('PT Beta', $top[1]['mitra']);
        $this->assertSame(50000000.0, $top[1]['sisa']);
    }
}
