<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Filament\Pages\ArsipNotaPage;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * HALAMAN & ROUTE ARSIP NOTA (B2-7).
 *
 * ⚠️ KENAPA DIUJI:
 * Route unduh harus aman (hanya berkas nota yang ada, tidak bisa traversal)
 * dan halaman harus bisa dibuka & memfilter.
 */
class ArsipNotaPageTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    public function test_halaman_bisa_dibuka(): void
    {
        $this->actingAs($this->admin());

        Livewire::test(ArsipNotaPage::class)
            ->assertOk()
            ->assertSee('Arsip Nota')
            ->assertSee('Pencarian');
    }

    public function test_halaman_menampilkan_nota_hasil_filter(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/a.pdf', 'PDF');

        UangKeluar::factory()->create([
            'tanggal' => now()->toDateString(),
            'bukti' => ['uang_keluar/a.pdf'],
            'penerima' => 'Toko Uji',
        ]);

        $this->actingAs($this->admin());

        Livewire::test(ArsipNotaPage::class)
            ->assertOk()
            ->assertSee('Toko Uji')
            ->assertSee('(1).pdf');
    }

    public function test_halaman_menampilkan_thumbnail_gambar(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/foto.jpg', 'JPEG');

        UangKeluar::factory()->create([
            'tanggal' => now()->toDateString(),
            'bukti' => ['uang_keluar/foto.jpg'],
            'penerima' => 'Toko Foto',
        ]);

        $this->actingAs($this->admin());

        $html = Livewire::test(ArsipNotaPage::class)->html();

        // Gambar harus dirender sebagai <img> (thumbnail) — bukan ikon dokumen.
        $this->assertStringContainsString('<img', $html, 'Thumbnail gambar tidak dirender.');
        $this->assertStringContainsString('nota', $html);
    }

    public function test_route_unduh_berkas_nota(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/a.pdf', 'ISI-PDF');

        $this->actingAs($this->admin())
            ->get(route('arsip-nota.unduh', [
                'path' => base64_encode('uang_keluar/a.pdf'),
                'nama' => '2026-08-01 (1).pdf',
            ]))
            ->assertOk()
            ->assertDownload('2026-08-01 (1).pdf');
    }

    public function test_route_unduh_menolak_berkas_tidak_ada(): void
    {
        Storage::fake('nota');

        $this->actingAs($this->admin())
            ->get(route('arsip-nota.unduh', [
                'path' => base64_encode('uang_keluar/tidak-ada.pdf'),
                'nama' => 'x.pdf',
            ]))
            ->assertNotFound();
    }

    public function test_route_unduh_menolak_path_traversal(): void
    {
        Storage::fake('nota');

        $this->actingAs($this->admin())
            ->get(route('arsip-nota.unduh', [
                'path' => base64_encode('../../.env'),
                'nama' => 'x',
            ]))
            ->assertNotFound();
    }

    public function test_route_unduh_butuh_login(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/a.pdf', 'PDF');

        $this->get(route('arsip-nota.unduh', [
            'path' => base64_encode('uang_keluar/a.pdf'),
            'nama' => 'x.pdf',
        ]))->assertRedirect();
    }

    public function test_route_zip_mengunduh_semua(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/a.pdf', 'A');
        Storage::disk('nota')->put('uang_keluar/b.pdf', 'B');

        UangKeluar::factory()->create(['tanggal' => now()->toDateString(), 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['tanggal' => now()->toDateString(), 'bukti' => ['uang_keluar/b.pdf']]);

        $filter = base64_encode(json_encode(['tanggal_awal' => now()->startOfMonth()->toDateString()]));

        $this->actingAs($this->admin())
            ->get(route('arsip-nota.zip', ['f' => $filter]))
            ->assertOk()
            ->assertDownload();
    }
}
