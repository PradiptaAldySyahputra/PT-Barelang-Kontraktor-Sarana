<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji TEMA: Clean Minimalist Enterprise (Vercel / Linear style).
 *
 * Tema di-inject lewat viteTheme('resources/css/filament/admin/theme.css').
 *
 * ⚠️ Titik rawan yang dijaga test ini:
 * Filament menaruh CSS variable-nya di <style> INLINE dalam <head>.
 * File tema dimuat lewat <link> yang posisinya LEBIH AKHIR, sehingga
 * aturan kita menang. Kalau urutan ini berubah, tema akan tertimpa.
 */
class TemaTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-tema@bks.test',
        ]);
    }

    private function html(): string
    {
        return $this->actingAs($this->admin)->get('/admin')->assertOk()->getContent();
    }

    // ---------------------------------------------------------
    // Tema terpasang
    // ---------------------------------------------------------

    public function test_tema_vite_terdaftar_di_panel(): void
    {
        $this->assertSame(
            'resources/css/filament/admin/theme.css',
            filament()->getPanel('admin')->getViteTheme()
        );
    }

    public function test_file_tema_dimuat_di_halaman(): void
    {
        $html = $this->html();

        $this->assertMatchesRegularExpression(
            '/href="[^"]*theme-[^"]*\.css"/',
            $html,
            'File tema tidak dimuat di halaman'
        );
    }

    public function test_tema_dimuat_setelah_css_inline_filament(): void
    {
        $html = $this->html();

        $posisiInline = strpos($html, '<style>');
        $posisiTema = strpos($html, 'theme-');

        $this->assertNotFalse($posisiInline);
        $this->assertNotFalse($posisiTema);

        $this->assertLessThan(
            $posisiTema,
            $posisiInline,
            'CSS inline Filament harus dimuat SEBELUM file tema, '
            .'kalau tidak aturan tema akan tertimpa'
        );
    }

    // ---------------------------------------------------------
    // Skema warna monokrom
    // ---------------------------------------------------------

    public function test_primary_bukan_biru(): void
    {
        $primary = filament()->getPanel('admin')->getColors()['primary'][600];

        // Blue Filament = oklch(0.546 0.245 262.881)
        $this->assertStringNotContainsString(
            '262.881',
            $primary,
            'Primary masih biru — tema harus monokrom (Zinc)'
        );
    }

    public function test_primary_dan_gray_sama_sama_monokrom(): void
    {
        $colors = filament()->getPanel('admin')->getColors();

        $this->assertSame(
            $colors['primary'][600],
            $colors['gray'][600],
            'Primary dan gray harus sama-sama Zinc agar konsisten monokrom'
        );
    }

    public function test_css_tema_memakai_palet_monokrom(): void
    {
        $css = $this->cssTema();

        foreach (['#18181b' => 'teks arang', '#fafafa' => 'latar', '#e4e4e7' => 'border'] as $warna => $label) {
            $this->assertStringContainsString(
                $warna,
                $css,
                "Warna $warna ($label) tidak ada di CSS tema"
            );
        }
    }

    // ---------------------------------------------------------
    // Tipografi font sistem
    // ---------------------------------------------------------

    public function test_tema_memakai_font_sistem(): void
    {
        $css = $this->cssTema();

        $this->assertStringContainsString(
            'system-ui, -apple-system',
            $css,
            'Tema harus memakai font sistem (system-ui, -apple-system)'
        );
    }

    public function test_font_dipaksa_dengan_important(): void
    {
        $css = $this->cssTema();

        // Filament memakai --font-sans: var(--font-family) (Inter).
        // Tanpa !important, aturan tema bisa kalah.
        $this->assertStringContainsString(
            'font-family:var(--font-sans)!important',
            $css,
            'font-family harus !important agar menang atas Inter bawaan Filament'
        );
    }

    // ---------------------------------------------------------
    // Shadow minimal
    // ---------------------------------------------------------

    public function test_shadow_dihilangkan_di_komponen_utama(): void
    {
        $css = $this->cssTema();

        $jumlah = substr_count($css, 'box-shadow:none!important');

        $this->assertGreaterThanOrEqual(
            8,
            $jumlah,
            "Hanya $jumlah aturan box-shadow:none — komponen utama harus tanpa shadow"
        );
    }

    // ---------------------------------------------------------
    // Komponen utama ditata
    // ---------------------------------------------------------

    public function test_komponen_utama_punya_aturan_tema(): void
    {
        $css = $this->cssTema();

        $komponen = [
            'fi-sidebar' => 'sidebar',
            'fi-topbar' => 'topbar',
            'fi-section' => 'section/kartu',
            'fi-btn' => 'tombol',
            'fi-input-wrp' => 'input',
            'fi-ta-header-cell' => 'header tabel',
            'fi-badge' => 'badge',
            'fi-dropdown-panel' => 'dropdown',
        ];

        foreach ($komponen as $kelas => $label) {
            $this->assertStringContainsString(
                $kelas,
                $css,
                "Komponen $label ($kelas) belum ditata di tema"
            );
        }
    }

    public function test_angka_memakai_tabular_nums(): void
    {
        $this->assertStringContainsString('tabular-nums', $this->cssTema());
    }

    // ---------------------------------------------------------
    // Helper
    // ---------------------------------------------------------

    private function cssTema(): string
    {
        $files = glob(base_path('public/build/assets/theme-*.css'));

        $this->assertNotEmpty($files, 'CSS tema belum di-build — jalankan npm run build');

        return file_get_contents(end($files));
    }
}
