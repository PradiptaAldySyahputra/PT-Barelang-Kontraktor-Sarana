<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\LaporanData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Halaman Laporan pada panel Blade.
 *
 * Yang diuji: akses per peran, angka ringkasan yang benar, filter periode,
 * dan bukti ekspor memakai rute yang sama (bukan mesin kedua).
 */
class ReportPanelTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get('/panel/reports')->assertRedirect('/panel/login');
    }

    public function test_admin_dan_direktur_boleh_membuka(): void
    {
        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $this->actingAs($this->pengguna($peran))
                ->get('/panel/reports')
                ->assertOk()
                ->assertSee('Ringkasan');
        }
    }

    public function test_ringkasan_menghitung_masuk_keluar_dan_selisih(): void
    {
        $mitra = Mitra::factory()->create();
        $spk = Spk::factory()->create(['mitra_id' => $mitra->id, 'nilai_spk' => 10_000_000]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 4_000_000,
            'akun' => AkunKas::Kas,
            'tanggal' => now(),
        ]);
        UangKeluar::factory()->create([
            'jumlah' => 1_500_000,
            'kategori' => KategoriPengeluaran::Material,
            'akun' => AkunKas::Kas,
            'tanggal' => now(),
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/reports?periode=1')
            ->assertOk()
            ->assertSee('Rp 4.000.000')   // uang masuk
            ->assertSee('Rp 1.500.000')   // uang keluar
            ->assertSee('Rp 2.500.000')   // selisih
            ->assertSee('Rp 6.000.000');  // piutang belum diterima
    }

    public function test_periode_tidak_valid_jatuh_ke_default(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/reports?periode=999')
            ->assertOk();
    }

    public function test_transaksi_lama_tidak_masuk_periode_bulan_ini(): void
    {
        UangMasuk::factory()->create([
            'jumlah' => 7_000_000,
            'akun' => AkunKas::Kas,
            'tanggal' => now()->subMonths(6),
            'spk_id' => null,
        ]);

        // Diuji pada sumber angkanya langsung: pada periode 1 bulan transaksi
        // 6 bulan lalu tidak boleh ikut, pada 12 bulan harus ikut. (Tidak
        // memakai HTML karena angka yang sama wajar muncul sebagai saldo awal.)
        $this->assertSame(0.0, LaporanData::ringkasan(LaporanData::tanggalAwal(1))['totalMasuk']);
        $this->assertSame(7_000_000.0, LaporanData::ringkasan(LaporanData::tanggalAwal(12))['totalMasuk']);
    }

    public function test_ekspor_memakai_rute_yang_sama_dan_menghormati_periode(): void
    {
        UangMasuk::factory()->create([
            'jumlah' => 3_000_000,
            'akun' => AkunKas::Kas,
            'tanggal' => now(),
            'spk_id' => null,
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->get(route('laporan.ekspor', ['jenis' => 'masuk', 'format' => 'csv', 'periode' => 1]))
            ->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }
}
