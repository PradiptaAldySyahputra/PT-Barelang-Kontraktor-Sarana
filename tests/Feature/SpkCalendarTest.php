<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpkCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_tidak_bisa_membuka_kalender_spk(): void
    {
        $this->get(route('panel.spk.calendar'))->assertRedirect(route('panel.login'));
    }

    public function test_pengguna_dapat_melihat_kalender_tenggat_spk_dan_statistiknya(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        $bulanSekarang = now()->format('Y-m');
        $tenggat1 = now()->startOfMonth()->addDays(5);
        $tenggat2 = now()->startOfMonth()->addDays(10);

        Spk::factory()->create([
            'nomor_spk' => 'SPK-CALENDAR-001',
            'tanggal_akhir' => $tenggat1,
            'nilai_spk' => 25000000,
            'status_spk' => StatusSpk::Berjalan,
        ]);

        Spk::factory()->create([
            'nomor_spk' => 'SPK-CALENDAR-002',
            'tanggal_akhir' => $tenggat2,
            'nilai_spk' => 30000000,
            'status_spk' => StatusSpk::Selesai,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('panel.spk.calendar', ['bulan' => $bulanSekarang]));

        $response->assertOk()
            ->assertSee('Kalender Tenggat SPK')
            ->assertSee('SPK-CALENDAR-001')
            ->assertSee('SPK-CALENDAR-002');
    }

    public function test_navigasi_bulan_kalender_bekerja_dengan_aman(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        $bulanLalu = now()->subMonth()->format('Y-m');

        Spk::factory()->create([
            'nomor_spk' => 'SPK-BULAN-LALU',
            'tanggal_akhir' => now()->subMonth()->startOfMonth()->addDays(2),
        ]);

        $response = $this->actingAs($admin)
            ->get(route('panel.spk.calendar', [
                'bulan' => $bulanLalu,
                'status_spk' => StatusSpk::Berjalan->value,
                'mitra_id' => '99',
            ]));

        $response->assertOk()
            ->assertSee('SPK-BULAN-LALU')
            ->assertSee('status_spk='.StatusSpk::Berjalan->value)
            ->assertSee('mitra_id=99');
    }

    public function test_parameter_bulan_invalid_aman_dan_fallback_ke_bulan_sekarang(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        Spk::factory()->create([
            'nomor_spk' => 'SPK-BULAN-INI',
            'tanggal_akhir' => now()->startOfMonth()->addDays(3),
        ]);

        // Coba parameter string acak / format rusak
        $this->actingAs($admin)
            ->get(route('panel.spk.calendar', ['bulan' => 'invalid-data']))
            ->assertOk()
            ->assertSee('SPK-BULAN-INI');

        $this->actingAs($admin)
            ->get(route('panel.spk.calendar', ['bulan' => '2026-99']))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('panel.spk.calendar', ['bulan' => 'abc']))
            ->assertOk();

        $this->actingAs($admin)
            ->get(route('panel.spk.calendar', ['bulan' => 'null']))
            ->assertOk();
    }

    public function test_filter_mitra_dan_status_membatasi_data_spk_secara_akurat(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);

        $mitraA = Mitra::factory()->create(['nama' => 'PT Mitra Alfa']);
        $mitraB = Mitra::factory()->create(['nama' => 'PT Mitra Beta']);

        $bulanSekarang = now()->format('Y-m');
        $tenggat = now()->startOfMonth()->addDays(5);

        Spk::factory()->create([
            'nomor_spk' => 'SPK-ALFA-BERJALAN',
            'mitra_id' => $mitraA->id,
            'tanggal_akhir' => $tenggat,
            'status_spk' => StatusSpk::Berjalan,
        ]);

        $spkBeta = Spk::factory()->create([
            'nomor_spk' => 'SPK-BETA-SELESAI',
            'mitra_id' => $mitraB->id,
            'tanggal_akhir' => $tenggat,
        ]);
        $spkBeta->update(['status_spk' => StatusSpk::Selesai]);

        // 1. Filter Mitra A (hanya SPK-ALFA-BERJALAN yang ada di kalender, bukan SPK-BETA-SELESAI)
        $respMitra = $this->actingAs($admin)
            ->get(route('panel.spk.calendar', [
                'bulan' => $bulanSekarang,
                'mitra_id' => $mitraA->id,
            ]));
        $respMitra->assertOk()
            ->assertSee('SPK-ALFA-BERJALAN');
        $this->assertTrue($respMitra->viewData('spkList')->contains('nomor_spk', 'SPK-ALFA-BERJALAN'));
        $this->assertFalse($respMitra->viewData('spkList')->contains('nomor_spk', 'SPK-BETA-SELESAI'));

        // 2. Filter Status Selesai
        $respStatus = $this->actingAs($admin)
            ->get(route('panel.spk.calendar', [
                'bulan' => $bulanSekarang,
                'status_spk' => StatusSpk::Selesai->value,
            ]));
        $respStatus->assertOk()
            ->assertSee('SPK-BETA-SELESAI');
        $this->assertTrue($respStatus->viewData('spkList')->contains('nomor_spk', 'SPK-BETA-SELESAI'));
        $this->assertFalse($respStatus->viewData('spkList')->contains('nomor_spk', 'SPK-ALFA-BERJALAN'));

        // 3. Filter kombinasi Mitra A + Selesai (harus tidak menemukan apa-apa)
        $respKombinasi = $this->actingAs($admin)
            ->get(route('panel.spk.calendar', [
                'bulan' => $bulanSekarang,
                'mitra_id' => $mitraA->id,
                'status_spk' => StatusSpk::Selesai->value,
            ]));
        $respKombinasi->assertOk();
        $this->assertFalse($respKombinasi->viewData('spkList')->contains('nomor_spk', 'SPK-ALFA-BERJALAN'));
        $this->assertFalse($respKombinasi->viewData('spkList')->contains('nomor_spk', 'SPK-BETA-SELESAI'));
        $this->assertCount(0, $respKombinasi->viewData('spkList'));
    }
}
