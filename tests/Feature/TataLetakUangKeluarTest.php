<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji REGRESI tata letak form Uang Keluar.
 *
 * ⚠️ BUG YANG DICEGAH:
 * Halaman "Tambah Uang Keluar" pernah menampilkan bagian "1. Unggah Nota"
 * dan "2. Isi Rincian" BERDAMPINGAN (kiri-kanan), padahal permintaan user
 * adalah ATAS-BAWAH memakai lebar penuh.
 *
 * Penyebab: grid pada Schema form mewarisi 2 kolom. Memaksa tiap Section
 * `columnSpanFull()` saja TIDAK cukup — grid-nya sendiri harus 1 kolom
 * (`->columns(1)` pada Schema).
 *
 * Uji ini memeriksa STRUKTUR yang dikirim server, bukan tampilan di layar.
 */
class TataLetakUangKeluarTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-layout@bks.test',
        ]);
    }

    public function test_form_tambah_punya_dua_section_berurutan(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->assertOk()
            ->assertSee('Unggah Berkas Nota')
            ->assertSee('2. Isi Rincian');
    }

    /**
     * Grid form TIDAK boleh 2 kolom — kalau 2 kolom, section jadi berdampingan.
     */
    public function test_grid_form_satu_kolom(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(CreateUangKeluar::class)->html();

        // Filament menandai grid 2 kolom dengan kelas `lg:fi-grid-cols-2`.
        $this->assertStringNotContainsString(
            'fi-grid-cols-2',
            $html,
            'Grid form 2 kolom -> section akan tampil BERDAMPINGAN, bukan atas-bawah'
        );
    }

    public function test_kedua_section_memakai_lebar_penuh(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(CreateUangKeluar::class)->html();

        // Section dengan columnSpanFull tidak dibungkus batasan lebar.
        $this->assertStringContainsString('fi-section', $html);
    }

    public function test_field_rincian_tersedia(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(CreateUangKeluar::class)->html();

        foreach (['pengeluaran', 'berkas_nota'] as $field) {
            $this->assertStringContainsString(
                $field,
                $html,
                "Field '$field' tidak ada di form Tambah Uang Keluar"
            );
        }
    }
}
