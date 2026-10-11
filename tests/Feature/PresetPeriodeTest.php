<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\RentangPeriode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * PRESET PERIODE SEKALI-KLIK.
 *
 * ⚠️ SARAN USER (9 Okt 2026):
 * "Filter periode sekali klik: Hari ini · Bulan ini · Bulan lalu · Tahun ini ·
 *  Pilih rentang — selalu terlihat di atas daftar."
 *
 * ⚠️ MASALAH YANG DIPERBAIKI:
 * Filter periode lama hanya punya dropdown Tahun/Bulan + dua DatePicker, jadi
 * untuk "bulan lalu" admin harus: pilih tahun, pilih bulan, dan tahu persis
 * bulan apa yang dimaksud. Dengan preset, cukup SATU klik.
 *
 * Rentang tanggal tidak dihitung di dalam komponen UI (sulit diuji), melainkan
 * di `App\Support\RentangPeriode` yang murni & teruji.
 */
class PresetPeriodeTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================
    // Logika rentang (murni, tanpa browser)
    // =========================================================

    public function test_hari_ini_menghitung_satu_hari(): void
    {
        $acuan = Carbon::parse('2026-10-09 14:30:00');

        $rentang = RentangPeriode::hitung('hari_ini', $acuan);

        $this->assertSame('2026-10-09', $rentang['dari']);
        $this->assertSame('2026-10-09', $rentang['sampai']);
    }

    public function test_bulan_ini_mencakup_awal_sampai_akhir_bulan(): void
    {
        $rentang = RentangPeriode::hitung('bulan_ini', Carbon::parse('2026-10-09'));

        $this->assertSame('2026-10-01', $rentang['dari']);
        $this->assertSame('2026-10-31', $rentang['sampai']);
    }

    public function test_bulan_lalu_menghitung_bulan_penuh_sebelumnya(): void
    {
        $rentang = RentangPeriode::hitung('bulan_lalu', Carbon::parse('2026-10-09'));

        $this->assertSame('2026-09-01', $rentang['dari']);
        $this->assertSame('2026-09-30', $rentang['sampai']);
    }

    public function test_bulan_lalu_saat_januari_mundur_ke_desember_tahun_sebelumnya(): void
    {
        $rentang = RentangPeriode::hitung('bulan_lalu', Carbon::parse('2026-01-15'));

        $this->assertSame('2025-12-01', $rentang['dari']);
        $this->assertSame('2025-12-31', $rentang['sampai']);
    }

    public function test_tahun_ini_mencakup_awal_sampai_akhir_tahun(): void
    {
        $rentang = RentangPeriode::hitung('tahun_ini', Carbon::parse('2026-06-15'));

        $this->assertSame('2026-01-01', $rentang['dari']);
        $this->assertSame('2026-12-31', $rentang['sampai']);
    }

    public function test_semua_waktu_tidak_membatasi_tanggal(): void
    {
        $rentang = RentangPeriode::hitung('semua');

        $this->assertNull($rentang['dari']);
        $this->assertNull($rentang['sampai']);
    }

    public function test_preset_tak_dikenal_tidak_membatasi(): void
    {
        $rentang = RentangPeriode::hitung('entah_apa');

        $this->assertNull($rentang['dari']);
        $this->assertNull($rentang['sampai']);
    }

    // =========================================================
    // Terpasang di menu Uang Masuk & Uang Keluar
    // =========================================================

    public function test_preset_tampil_di_menu_uang_masuk_dan_keluar(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        foreach (['/admin/uang-masuks', '/admin/uang-keluars'] as $url) {
            $html = $this->get($url)->assertSuccessful()->getContent();

            foreach (['Hari ini', 'Bulan ini', 'Bulan lalu', 'Tahun ini'] as $label) {
                $this->assertStringContainsString(
                    $label,
                    $html,
                    "Menu {$url} harus punya preset periode \"{$label}\".",
                );
            }
        }
    }

    public function test_preset_bulan_lalu_menyaring_data_dengan_benar(): void
    {
        // Acuan: 9 Okt 2026 → bulan lalu = September 2026.
        Carbon::setTestNow('2026-10-09');

        UangMasuk::factory()->create(['tanggal' => '2026-09-15', 'jumlah' => 111_000]);
        UangMasuk::factory()->create(['tanggal' => '2026-10-05', 'jumlah' => 222_000]);

        $rentang = RentangPeriode::hitung('bulan_lalu');

        $hasil = (clone UangMasukResource::getEloquentQuery())
            ->whereDate('tanggal', '>=', $rentang['dari'])
            ->whereDate('tanggal', '<=', $rentang['sampai'])
            ->get();

        $this->assertCount(1, $hasil);
        $this->assertSame('111000.00', (string) $hasil->first()->jumlah);

        Carbon::setTestNow();
    }

    public function test_preset_tahun_ini_menyaring_uang_keluar(): void
    {
        Carbon::setTestNow('2026-10-09');

        UangKeluar::factory()->create(['tanggal' => '2025-12-31', 'jumlah' => 1000]);
        UangKeluar::factory()->create(['tanggal' => '2026-03-01', 'jumlah' => 2000]);

        $rentang = RentangPeriode::hitung('tahun_ini');

        $hasil = (clone UangKeluarResource::getEloquentQuery())
            ->whereDate('tanggal', '>=', $rentang['dari'])
            ->whereDate('tanggal', '<=', $rentang['sampai'])
            ->get();

        $this->assertCount(1, $hasil);
        $this->assertSame('2000.00', (string) $hasil->first()->jumlah);

        Carbon::setTestNow();
    }
}
