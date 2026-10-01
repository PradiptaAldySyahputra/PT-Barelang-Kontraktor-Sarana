<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Laporan;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkPerStatus;
use App\Filament\Widgets\StatusTagihanChart;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
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

        $this->assertStringContainsString('Barelang Kontraktor Sarana', $html);
    }

    public function test_brand_tampil_di_komponen_logo(): void
    {
        // Nama brand harus ada di dalam elemen .fi-logo (bukan hanya di <title>)
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertMatchesRegularExpression(
            '/fi-logo[^>]*>\s*Barelang Kontraktor Sarana/',
            $html,
            'Nama brand tidak tampil di komponen logo topbar'
        );
    }

    public function test_brand_tidak_memakai_logo_gambar_custom(): void
    {
        // brandLogo() custom membuat nama brand HILANG dan navbar tampak rusak.
        // Cukup pakai brandName() agar rapi & responsif.
        $html = $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression(
            '/<img[^>]*fi-logo/',
            $html,
            'brandLogo custom masih dipakai — nama brand akan hilang dari navbar'
        );
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

        $this->assertStringContainsString('Ringkasan pekerjaan', $html);
    }

    public function test_widget_dashboard_terdaftar(): void
    {
        $widgets = filament()->getPanel('admin')->getWidgets();

        $this->assertContains(RingkasanKeuangan::class, $widgets);
        $this->assertContains(SpkPerStatus::class, $widgets);
        $this->assertContains(StatusTagihanChart::class, $widgets);
    }

    // ---------------------------------------------------------
    // Laporan — ekspor berupa dropdown, bukan 5 tombol berjajar
    // ---------------------------------------------------------

    /**
     * ⚠️ DIPERBARUI 29 Sep 2026 — permintaan pengguna:
     *   "kenapa double ada pdf sama excel dan disamping ada ekspor csv, kenapa
     *    tidak digabung untuk pdf sama excel dan dibedakan saja"
     *
     * Sebelumnya: TIGA tombol terpisah ("Ekspor PDF", "Ekspor Excel",
     * "Ekspor CSV") — memakan ruang dan membingungkan.
     *
     * Sekarang: SATU tombol "Ekspor" berisi daftar laporan, dan tiap laporan
     * menawarkan 3 format (xlsx / pdf / csv) dalam satu baris.
     */
    public function test_ekspor_laporan_berupa_satu_dropdown(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('fi-dropdown', $html, 'Ekspor harus berupa dropdown');

        // TIDAK boleh ada lagi tiga tombol ekspor terpisah.
        $this->assertStringNotContainsString('Ekspor PDF', $html, 'Tombol "Ekspor PDF" terpisah harus dihapus.');
        $this->assertStringNotContainsString('Ekspor Excel', $html, 'Tombol "Ekspor Excel" terpisah harus dihapus.');
        $this->assertStringNotContainsString('Ekspor CSV', $html, 'Tombol "Ekspor CSV" terpisah harus dihapus.');

        // Ketiga format harus tetap tersedia DI DALAM dropdown.
        foreach (['xlsx', 'pdf', 'csv'] as $format) {
            $this->assertStringContainsString(
                'format='.$format,
                $html,
                "Format {$format} harus tetap bisa dipilih dari dalam dropdown Ekspor.",
            );
        }
    }

    public function test_section_laporan_bisa_dilipat(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('fi-collapsible', $html);
    }

    // ---------------------------------------------------------
    // Laporan responsif
    // ---------------------------------------------------------

    public function test_angka_laporan_memakai_tabular_nums(): void
    {
        $this->buatDataLaporan();

        $html = $this->actingAs($this->admin)
            ->get('/admin/laporan')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('tabular-nums', $html, 'Angka harus rata agar mudah dibandingkan');
    }

    // ---------------------------------------------------------
    // Ekspor lewat route (bukan aksi Livewire)
    // ---------------------------------------------------------

    public function test_ekspor_laporan_lewat_route_biasa(): void
    {
        $this->actingAs($this->admin);

        $res = $this->get(route('laporan.ekspor', 'masuk'));

        $res->assertOk();
        $this->assertStringContainsString('text/csv', $res->headers->get('Content-Type'));
    }

    public function test_semua_jenis_ekspor_bisa_diunduh(): void
    {
        $this->actingAs($this->admin);

        foreach (['spk', 'masuk', 'keluar', 'spk', 'tenggat'] as $jenis) {
            $this->get(route('laporan.ekspor', $jenis))
                ->assertOk()
                ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        }
    }

    public function test_jenis_ekspor_ngawur_ditolak_404(): void
    {
        $this->actingAs($this->admin);

        $this->get(route('laporan.ekspor', 'jenis-ngawur'))->assertNotFound();
    }

    public function test_ekspor_butuh_login(): void
    {
        // Tamu diarahkan LANGSUNG ke login Filament (bukan lewat /login).
        $this->get(route('laporan.ekspor', 'spk'))->assertRedirect('/admin/login');
    }

    // ---------------------------------------------------------
    // Helper: buat data supaya tabel (bukan empty-state) yang dirender
    // ---------------------------------------------------------

    private function buatDataLaporan(): void
    {
        $mitra = Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam']);

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'TAMPILAN-001',
            'nama_pekerjaan' => 'Pekerjaan Uji Tampilan',
            'nilai_spk' => 200_000_000,
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 120_000_000,
            'mitra_id' => null,
        ]);

        UangKeluar::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 65_000_000,
        ]);
    }
}
