<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\Mitras\Pages\ListMitras;
use App\Models\Mitra;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * TAB MENU MITRA — hanya TIGA: Semua · PLN · Subkon.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "di filter menu mitra kenapa anda buat jadi banyak filter navbarnya buat
 *  semua, pln, subkon saja"
 *
 * Juga: "pln itu dimasukkan kedalam mitra jadi atau dua mitra dan subkon"
 * → benar, PLN dilebur ke kategori `mitra` (pemberi kerja). Jadi cukup
 *   3 tab: Semua, PLN (= pemberi kerja), Subkon.
 *
 * ⚠️ RIWAYAT BUG: versi lama punya tab "PLN" yang menyaring
 * `kategori = 'pln'` — padahal nilai 'pln' SUDAH TIDAK ADA di enum
 * (hanya `mitra` & `subkon`), sehingga tab itu SELALU KOSONG.
 * Sekarang tab PLN menyaring kategori `mitra` yang BENAR.
 */
class TabMitraTest extends TestCase
{
    use RefreshDatabase;

    private function siapkan(): Pengguna
    {
        $admin = Pengguna::factory()->admin()->create();

        Mitra::factory()->create(['nama' => 'PT PLN Batam', 'kategori' => KategoriMitra::Mitra->value, 'is_aktif' => true]);
        Mitra::factory()->create(['nama' => 'Subkon Arif', 'kategori' => KategoriMitra::Subkon->value, 'is_aktif' => true]);
        Mitra::factory()->create(['nama' => 'Subkon Cut', 'kategori' => KategoriMitra::Subkon->value, 'is_aktif' => false]);

        return $admin;
    }

    public function test_hanya_tiga_tab(): void
    {
        $admin = $this->siapkan();
        $this->actingAs($admin);

        $komponen = Livewire::test(ListMitras::class);
        $tab = $komponen->instance()->getTabs();

        $this->assertSame(
            ['semua', 'pln', 'subkon'],
            array_keys($tab),
            'Menu Mitra harus punya TEPAT 3 tab: Semua, PLN, Subkon.',
        );
    }

    public function test_tab_pln_menampilkan_pemberi_kerja(): void
    {
        $admin = $this->siapkan();
        $this->actingAs($admin);

        // Tab PLN = kategori mitra (pemberi kerja). Dulu tab ini KOSONG
        // karena menyaring nilai 'pln' yang tidak ada di enum.
        $hasil = Mitra::query()->where('kategori', KategoriMitra::Mitra->value)->get();

        $this->assertCount(1, $hasil);
        $this->assertSame('PT PLN Batam', $hasil->first()->nama);
    }

    public function test_tab_subkon_menampilkan_subkon(): void
    {
        $admin = $this->siapkan();
        $this->actingAs($admin);

        $hasil = Mitra::query()->where('kategori', KategoriMitra::Subkon->value)->get();

        $this->assertCount(2, $hasil);
    }

    public function test_tab_tidak_menyaring_kategori_yang_tidak_ada(): void
    {
        // Tidak boleh ada lagi penyaringan 'pln' / 'vendor' yang tidak ada
        // di KategoriMitra — itu penyebab tab kosong.
        //
        // Catatan: komentar ikut dibuang dulu, supaya penjelasan riwayat bug
        // (yang menyebut kata 'vendor') tidak dianggap pelanggaran.
        $isi = file_get_contents(app_path('Filament/Resources/Mitras/Pages/ListMitras.php'));
        $isi = (string) preg_replace('#/\*.*?\*/#s', '', $isi);
        $isi = (string) preg_replace('#//[^\n]*#', '', $isi);

        $this->assertStringNotContainsString(
            "'kategori', 'pln'",
            $isi,
            "Tab masih menyaring kategori 'pln' yang TIDAK ADA di enum — tab akan selalu kosong.",
        );

        $this->assertStringNotContainsString(
            "'vendor'",
            $isi,
            "Tab masih menyaring kategori 'vendor' yang TIDAK ADA di enum.",
        );
    }

    public function test_halaman_mitra_bisa_dibuka(): void
    {
        $admin = $this->siapkan();

        $this->actingAs($admin)
            ->get(MitraResource::getUrl('index'))
            ->assertSuccessful();
    }
}
