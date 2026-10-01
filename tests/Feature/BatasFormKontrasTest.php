<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Batas antar baris form harus JELAS di mode terang & gelap.
 *
 * Permintaan user:
 *   "untuk semua form dibuat jelas lagi batasnya karna ketika mode
 *    gelap/terang terasa susah untuk navigasi mengisi formnya"
 *
 * Uji ini memeriksa FILE TEMA (sumber), bukan tampilan di layar — karena
 * "jelas atau tidak" pada akhirnya dinilai mata user. Yang bisa dipastikan
 * di sini: aturan CSS-nya BENAR-BENAR ADA dan punya nilai untuk KEDUA mode.
 *
 * PENTING: file ini juga memastikan CSS tema sudah di-BUILD ulang, karena
 * kelas baru (mis. h-[68vh]) tidak akan berpengaruh sebelum `npm run build`.
 */
class BatasFormKontrasTest extends TestCase
{
    private function tema(): string
    {
        return file_get_contents(resource_path('css/filament/admin/theme.css'));
    }

    public function test_kartu_baris_repeater_punya_border_tegas(): void
    {
        $css = $this->tema();

        $this->assertMatchesRegularExpression(
            '/\.fi-fo-repeater-item\s*\{[^}]*border:\s*2px\s+solid/s',
            $css,
            'Baris repeater harus punya border 2px agar batasnya jelas',
        );
    }

    public function test_judul_baris_punya_latar_kontras(): void
    {
        $css = $this->tema();

        $this->assertMatchesRegularExpression(
            '/\.fi-fo-repeater-item-header\s*\{[^}]*background-color/s',
            $css,
            'Judul baris harus punya latar kontras supaya batas antar form terlihat',
        );
    }

    /**
     * Setiap aturan mode terang harus punya pasangan `.dark` — kalau tidak,
     * mode gelap jadi tidak terbaca (atau sebaliknya).
     */
    public function test_ada_aturan_untuk_mode_gelap(): void
    {
        $css = $this->tema();

        foreach ([
            '.dark .fi-fo-repeater-item',
            '.dark .fi-fo-repeater-item-header',
            '.dark .fi-fo-repeater-item-header-label',
            '.dark .nota-kotak',
        ] as $selector) {
            $this->assertStringContainsString(
                $selector,
                $css,
                "Aturan mode gelap '$selector' tidak ada — mode gelap akan sulit dibaca",
            );
        }
    }

    /**
     * Kontras: warna border mode gelap harus LEBIH TERANG dari latar kartu,
     * supaya benar-benar terlihat sebagai garis.
     *
     * Pemeriksaan visual sebelumnya menyebut border lama "almost invisible",
     * jadi selisihnya juga diuji minimal — bukan sekadar "lebih terang".
     */
    public function test_border_mode_gelap_jauh_lebih_terang_dari_latar(): void
    {
        $css = $this->tema();

        preg_match('/\.dark \.fi-fo-repeater-item\s*\{[^}]*border-color:\s*(#[0-9a-f]{6})/i', $css, $m);
        $this->assertNotEmpty($m, 'Border mode gelap tidak ditemukan');
        $border = $m[1];

        preg_match('/\.dark \.fi-fo-repeater-item\s*\{[^}]*background-color:\s*(#[0-9a-f]{6})/i', $css, $m2);
        $this->assertNotEmpty($m2, 'Latar kartu mode gelap tidak ditemukan');
        $latar = $m2[1];

        $terang = fn (string $hex): int => (int) hexdec(substr($hex, 1, 2))
            + (int) hexdec(substr($hex, 3, 2))
            + (int) hexdec(substr($hex, 5, 2));

        $selisih = $terang($border) - $terang($latar);

        $this->assertGreaterThan(
            0,
            $selisih,
            'Border mode gelap harus lebih terang dari latar kartu agar terlihat',
        );

        // Selisih minimal 80 (dari 765) supaya garisnya benar-benar kelihatan,
        // bukan cuma "secara teknis lebih terang".
        $this->assertGreaterThanOrEqual(
            80,
            $selisih,
            'Selisih border vs latar terlalu kecil — garis akan terlihat samar di mode gelap',
        );
    }

    /**
     * Hierarki 3 tingkat mode gelap: halaman < kartu < judul baris.
     * Tanpa hierarki ini, semua terlihat menyatu dan admin sulit navigasi.
     */
    public function test_mode_gelap_punya_hierarki_tiga_tingkat(): void
    {
        $css = $this->tema();

        preg_match('/\.dark \.fi-fo-repeater-item\s*\{[^}]*background-color:\s*#([0-9a-f]{6})/i', $css, $m);
        preg_match('/\.dark \.fi-fo-repeater-item-header\s*\{[^}]*background-color:\s*#([0-9a-f]{6})/i', $css, $m2);

        $this->assertNotEmpty($m, 'Latar kartu gelap tidak ditemukan');
        $this->assertNotEmpty($m2, 'Latar judul baris gelap tidak ditemukan');

        $terang = fn (string $hex): int => (int) hexdec(substr($hex, 0, 2))
            + (int) hexdec(substr($hex, 2, 2))
            + (int) hexdec(substr($hex, 4, 2));

        $this->assertGreaterThan(
            $terang($m[1]),
            $terang($m2[1]),
            'Judul baris harus LEBIH TERANG dari badan kartu agar batasnya terlihat',
        );
    }

    /**
     * CSS HARUS sudah di-build. Kelas arbitrary (h-[68vh]) hanya bekerja
     * setelah `npm run build` — kalau belum, gambar kembali terpotong.
     */
    public function test_css_tema_sudah_di_build_ulang(): void
    {
        $manifest = json_decode(
            file_get_contents(public_path('build/manifest.json')),
            true,
        );

        $this->assertIsArray($manifest, 'manifest.json tidak terbaca');

        $tema = null;

        foreach ($manifest as $key => $entri) {
            if (str_contains($key, 'theme.css')) {
                $tema = $entri['file'] ?? null;
            }
        }

        $this->assertNotNull($tema, 'Tema tidak ada di manifest');

        $isi = file_get_contents(public_path('build/'.$tema));

        $this->assertStringContainsString(
            '68vh',
            $isi,
            'CSS belum di-build ulang — kelas h-[68vh] belum ada, nota akan terpotong lagi',
        );

        $this->assertStringContainsString(
            'nota-kotak',
            $isi,
            'CSS belum di-build ulang — kelas nota-kotak belum ada',
        );
    }
}
