<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Laporan;
use App\Filament\Widgets\PengeluaranPerKategori;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkPerStatus;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji tampilan panel: brand, sidebar, dan widget dashboard.
 */
class TampilanPanelTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-tampilan@bks.test',
        ]);
    }

    // ---------------------------------------------------------
    // Brand — tidak boleh ada sisa nama proyek lama
    // ---------------------------------------------------------

    public function test_brand_tidak_lagi_memakai_nama_siakad(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringNotContainsString(
            'SIAKAD',
            $html,
            '"SIAKAD" adalah sisa nama proyek lama dan tidak boleh muncul lagi'
        );
    }

    public function test_brand_menampilkan_nama_perusahaan(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringContainsString('PT Barelang Kontraktor Sarana', $html);
    }

    public function test_logo_panel_memakai_inisial_perusahaan(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringContainsString('BKS', $html);
    }

    // ---------------------------------------------------------
    // Sidebar bisa ditutup / dibuka
    // ---------------------------------------------------------

    public function test_sidebar_bisa_ditutup_dan_dibuka(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringContainsString('fi-sidebar', $html, 'Elemen sidebar tidak ada');

        // Tombol toggle di topbar — untuk menutup / membuka sidebar
        $this->assertStringContainsString(
            'fi-topbar-collapse-sidebar-btn-ctn',
            $html,
            'Tombol toggle sidebar tidak ada — sidebar tidak bisa ditutup/dibuka'
        );
    }

    public function test_grup_navigasi_bisa_dilipat(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringContainsString(
            'fi-sidebar-group-collapse-btn',
            $html,
            'Grup navigasi tidak bisa dilipat'
        );
    }

    public function test_sidebar_ada_di_semua_halaman(): void
    {
        foreach (['/admin', '/admin/spks', '/admin/laporan'] as $url) {
            $html = $this->actingAs($this->admin)->get($url)->assertOk()->getContent();

            $this->assertStringContainsString('fi-sidebar', $html, "Sidebar tidak ada di $url");
        }
    }

    public function test_menu_navigasi_lengkap(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        foreach (['Dashboard', 'SPK', 'Uang Masuk', 'Uang Keluar', 'Mitra', 'Laporan'] as $menu) {
            $this->assertStringContainsString($menu, $html, "Menu '$menu' tidak ada di sidebar");
        }
    }

    // ---------------------------------------------------------
    // Dashboard
    // ---------------------------------------------------------

    public function test_dashboard_memakai_halaman_kustom(): void
    {
        // Route /admin harus memakai Dashboard KUSTOM kita, bukan bawaan Filament.
        $aksi = null;
        foreach (app('router')->getRoutes() as $rute) {
            if ($rute->uri() === 'admin') {
                $aksi = $rute->getActionName();
                break;
            }
        }

        $this->assertSame(
            Dashboard::class,
            $aksi,
            'Route /admin seharusnya memakai App\Filament\Pages\Dashboard (kustom)'
        );

        $this->assertNotSame(
            \Filament\Pages\Dashboard::class,
            $aksi,
            'Dashboard bawaan Filament masih dipakai — seharusnya digantikan'
        );

        $this->actingAs($this->admin)->get('/admin')->assertOk();
    }

    public function test_dashboard_menampilkan_subjudul(): void
    {
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertStringContainsString('Ringkasan SPK', $html);
    }

    public function test_widget_dashboard_terdaftar(): void
    {
        $widgets = filament()->getPanel('admin')->getWidgets();

        $this->assertContains(RingkasanKeuangan::class, $widgets);
        $this->assertContains(SpkPerStatus::class, $widgets);
        $this->assertContains(PengeluaranPerKategori::class, $widgets);
    }

    public function test_kartu_ringkasan_menampilkan_tren_bulan_lalu(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(RingkasanKeuangan::class)->html();

        // Kartu harus menjelaskan konteks, bukan hanya angka
        $this->assertStringContainsString('SPK', $html);
        $this->assertStringContainsString('mitra terdaftar', $html);
    }

    // ---------------------------------------------------------
    // Laporan — ekspor berupa dropdown, bukan 5 tombol berjajar
    // ---------------------------------------------------------

    public function test_ekspor_laporan_berupa_dropdown(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('Ekspor CSV', $html);
        $this->assertStringContainsString('fi-dropdown', $html, 'Ekspor harus berupa dropdown');
    }

    public function test_section_laporan_bisa_dilipat(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('fi-collapsible', $html);
    }
}
