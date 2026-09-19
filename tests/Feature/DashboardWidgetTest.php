<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji widget dashboard Filament.
 *
 * Widget dirender LAZY oleh Filament, jadi isinya tidak ada di HTML awal
 * /admin. Karena itu diuji dengan Livewire::test() langsung.
 */
class DashboardWidgetTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-widget@bks.test',
        ]);
    }

    // ---------------------------------------------------------
    // Kartu ringkasan
    // ---------------------------------------------------------

    public function test_kartu_ringkasan_menampilkan_semua_stat(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(RingkasanKeuangan::class)->html();

        foreach ([
            'Total Nilai SPK',
            'Uang Masuk',
            'Uang Keluar',
            'Saldo Bersih',
            'Piutang SPK',
        ] as $label) {
            $this->assertStringContainsString($label, $html, "Kartu '$label' tidak tampil");
        }
    }

    public function test_kartu_ringkasan_menghitung_angka_dengan_benar(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'WIDGET-001',
            'nilai_spk' => 200_000_000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create(['spk_id' => $spk->id, 'jumlah' => 120_000_000, 'mitra_id' => null]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 65_000_000]);

        $this->actingAs($this->admin);

        $html = Livewire::test(RingkasanKeuangan::class)->html();

        // 200jt nilai SPK, 120jt masuk, 65jt keluar, 55jt saldo, 80jt piutang
        $this->assertStringContainsString('200.000.000', $html, 'Total nilai SPK salah');
        $this->assertStringContainsString('120.000.000', $html, 'Total uang masuk salah');
        $this->assertStringContainsString('65.000.000', $html, 'Total uang keluar salah');
        $this->assertStringContainsString('55.000.000', $html, 'Saldo bersih salah');
        $this->assertStringContainsString('80.000.000', $html, 'Piutang salah');
    }

    // ---------------------------------------------------------
    // Grafik arus kas
    // ---------------------------------------------------------

    public function test_grafik_arus_kas_tampil(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(GrafikArusKas::class)->html();

        $this->assertStringContainsString('Arus Kas', $html);
    }

    public function test_grafik_arus_kas_menghitung_data_bulanan(): void
    {
        UangMasuk::factory()->create([
            'tanggal' => now()->startOfMonth(),
            'jumlah' => 50_000_000,
            'spk_id' => null,
            'mitra_id' => null,
        ]);
        UangKeluar::factory()->create([
            'tanggal' => now()->startOfMonth(),
            'jumlah' => 20_000_000,
            'spk_id' => null,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(GrafikArusKas::class)
            ->assertOk()
            ->assertSee('Arus Kas');
    }

    // ---------------------------------------------------------
    // Tabel SPK berjalan
    // ---------------------------------------------------------

    public function test_tabel_spk_berjalan_menampilkan_data(): void
    {
        $spk = Spk::factory()->berjalan()->create([
            'nomor_spk' => 'WIDGET-BERJALAN-001',
            'nama_pekerjaan' => 'Pekerjaan Widget',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        $html = Livewire::test(SpkBerjalan::class)->html();

        $this->assertStringContainsString('WIDGET-BERJALAN-001', $html);
        $this->assertStringContainsString('Laba/Rugi', $html);
        $this->assertStringContainsString('Piutang', $html);
    }

    public function test_tabel_spk_berjalan_hanya_menampilkan_spk_berjalan(): void
    {
        $berjalan = Spk::factory()->berjalan()->create([
            'nomor_spk' => 'WIDGET-BERJALAN-002',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);
        Spk::factory()->lunas()->create([
            'nomor_spk' => 'WIDGET-LUNAS-002',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        $html = Livewire::test(SpkBerjalan::class)->html();

        $this->assertStringContainsString('WIDGET-BERJALAN-002', $html);
        $this->assertStringNotContainsString('WIDGET-LUNAS-002', $html, 'SPK lunas seharusnya tidak muncul');
    }

    // ---------------------------------------------------------
    // Widget tampil di dashboard
    // ---------------------------------------------------------

    public function test_widget_terdaftar_di_panel(): void
    {
        $widgets = filament()->getPanel('admin')->getWidgets();

        $this->assertContains(RingkasanKeuangan::class, $widgets);
        $this->assertContains(GrafikArusKas::class, $widgets);
        $this->assertContains(SpkBerjalan::class, $widgets);
    }

    public function test_dashboard_bisa_dibuka_admin_dan_direktur(): void
    {
        $direktur = Pengguna::factory()->direktur()->create();

        $this->actingAs($this->admin)->get('/admin')->assertOk();
        $this->actingAs($direktur)->get('/admin')->assertOk();
    }
}
