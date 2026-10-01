<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * NAVIGASI UI — permintaan user:
 *   "sekarang desain atau tampilan memang polos saya ingin tetap pertahankan
 *    tetapi diperbarui dengan navigasi yang jelas juga, di button, alert, icon,
 *    atau bagian yang membantu user dan admin dalam menggunakan sistem karna
 *    ini berkaitan dengan data penting"
 *
 * Yang ditambahkan (gaya polos tetap dipertahankan):
 *   1. PROGRES pengisian — berapa baris sudah lengkap dari total.
 *   2. IKON STATUS per baris — ✓ lengkap / ⚠ belum lengkap / kosong.
 *   3. ALERT peringatan kalau masih ada baris belum lengkap.
 *   4. RINGKASAN total rupiah sebelum menyimpan.
 *   5. TOMBOL berbahasa Indonesia yang menjelaskan aksinya.
 *
 * Alasan pentingnya: ini data keuangan. Admin harus tahu kondisi pengisian
 * SEBELUM menyimpan, bukan setelah ada data yang tidak ikut tersimpan.
 */
class NavigasiUangKeluarTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('nota');

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-navigasi@bks.test']);
    }

    private function nota(string $nama = 'nota.pdf'): UploadedFile
    {
        return UploadedFile::fake()->create($nama, 100, 'application/pdf');
    }

    // =========================================================
    // 1. PROGRES PENGISIAN
    // =========================================================

    public function test_ada_komponen_progres_pengisian(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Progres pengisian', $html);
    }

    /**
     * Progres harus benar-benar MENGHITUNG, bukan teks statis.
     */
    public function test_progres_menghitung_baris_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 100_000, 'kategori' => 'material'],
                ['tanggal' => '2026-09-01', 'jumlah' => 200_000, 'kategori' => 'upah'],
                ['tanggal' => '2026-09-01', 'jumlah' => null, 'kategori' => null],
            ],
        ])->render();

        $this->assertStringContainsString('2 dari 3 baris lengkap', $view);
    }

    /**
     * RINGKASAN total harus menjumlahkan HANYA baris yang lengkap — kalau
     * baris setengah terisi ikut dihitung, totalnya menyesatkan.
     */
    public function test_ringkasan_total_menghitung_hanya_yang_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 1_500_000, 'kategori' => 'material'],
                ['tanggal' => '2026-09-01', 'jumlah' => 500_000, 'kategori' => 'upah'],
                // Baris ini nominalnya ADA tapi kategori kosong -> TIDAK dihitung
                ['tanggal' => '2026-09-01', 'jumlah' => 9_999_999, 'kategori' => null],
            ],
        ])->render();

        $this->assertStringContainsString('Rp 2.000.000', $view);
        $this->assertStringNotContainsString('Rp 11.999.999', $view);
    }

    public function test_ringkasan_muncul_kalau_ada_yang_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 250_000, 'kategori' => 'material'],
            ],
        ])->render();

        $this->assertStringContainsString('Total yang akan tersimpan', $view);
        $this->assertStringContainsString('Rp 250.000', $view);
    }

    public function test_tidak_ada_ringkasan_kalau_belum_ada_yang_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => null, 'kategori' => null],
            ],
        ])->render();

        $this->assertStringNotContainsString('Total yang akan tersimpan', $view);
    }

    // =========================================================
    // 2. ALERT — peringatan SEBELUM menyimpan
    // =========================================================

    public function test_alert_muncul_kalau_ada_baris_belum_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 100_000, 'kategori' => 'material'],
                ['tanggal' => '2026-09-01', 'jumlah' => null, 'kategori' => null],
            ],
        ])->render();

        $this->assertStringContainsString('belum lengkap', $view);
        $this->assertStringContainsString('TIDAK akan tersimpan', $view);
    }

    public function test_alert_tidak_muncul_kalau_semua_lengkap(): void
    {
        $view = view('filament.components.progres-pengisian', [
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 100_000, 'kategori' => 'material'],
                ['tanggal' => '2026-09-01', 'jumlah' => 200_000, 'kategori' => 'upah'],
            ],
        ])->render();

        $this->assertStringContainsString('Semua baris sudah lengkap', $view);
        $this->assertStringNotContainsString('TIDAK akan tersimpan', $view);
    }

    // =========================================================
    // 3. IKON STATUS PER BARIS
    // =========================================================

    public function test_penanda_berkas_punya_ikon_status(): void
    {
        $view = file_get_contents(resource_path('views/filament/components/penanda-berkas.blade.php'));

        $this->assertStringContainsString('Lengkap', $view);
        $this->assertStringContainsString('Belum lengkap', $view);
        $this->assertStringContainsString('Belum diisi', $view);
        $this->assertStringContainsString('heroicon-m-check-circle', $view);
        $this->assertStringContainsString('heroicon-m-exclamation-triangle', $view);
    }

    /**
     * Status harus dihitung dari data baris, bukan selalu "kosong".
     */
    public function test_status_baris_lengkap_ditandai_lengkap(): void
    {
        $view = view('filament.components.penanda-berkas', [
            'berkasKe' => 1,
            'berkasDari' => 1,
            'notaKe' => 1,
            'notaDari' => 1,
            'nama' => 'nota.pdf',
            'lengkap' => true,
            'adaIsi' => true,
        ])->render();

        $this->assertStringContainsString('Lengkap', $view);
    }

    public function test_status_baris_sebagian_ditandai_belum_lengkap(): void
    {
        $view = view('filament.components.penanda-berkas', [
            'berkasKe' => 1,
            'berkasDari' => 1,
            'notaKe' => 1,
            'notaDari' => 1,
            'nama' => 'nota.pdf',
            'lengkap' => false,
            'adaIsi' => true,
        ])->render();

        $this->assertStringContainsString('Belum lengkap', $view);
    }

    public function test_status_baris_kosong_ditandai_belum_diisi(): void
    {
        $view = view('filament.components.penanda-berkas', [
            'berkasKe' => 1,
            'berkasDari' => 1,
            'notaKe' => 1,
            'notaDari' => 1,
            'nama' => 'nota.pdf',
            'lengkap' => false,
            'adaIsi' => false,
        ])->render();

        $this->assertStringContainsString('Belum diisi', $view);
    }

    // =========================================================
    // 4. TOMBOL — teks jelas berbahasa Indonesia
    // =========================================================

    public function test_tombol_simpan_berbahasa_indonesia(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString(
            'Simpan Pengeluaran',
            $html,
            'Tombol simpan harus jelas — bukan "Create"',
        );
    }

    public function test_tombol_simpan_dan_tambah_lagi_ada(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        // `&` di-escape browser jadi `&amp;` — cek keduanya supaya tidak rapuh.
        $this->assertTrue(
            str_contains($html, 'Simpan &amp; Tambah Lagi') || str_contains($html, 'Simpan & Tambah Lagi'),
            'Tombol "Simpan & Tambah Lagi" harus ada',
        );
    }

    /**
     * Semua aksi harus berbahasa Indonesia — jangan campur "Cancel"/"Create".
     */
    public function test_tombol_batal_berbahasa_indonesia(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Batal', $html);

        // Label Inggris tidak boleh tersisa di tombol aksi form.
        $this->assertStringNotContainsString('>Cancel<', $html);
        $this->assertStringNotContainsString('>Create<', $html);
    }

    // =========================================================
    // 5. STATUS LIVE — berubah saat admin mengetik
    // =========================================================

    /**
     * Progres harus ikut berubah begitu admin mengisi baris, tanpa reload.
     * Kalau field tidak `live`, admin tidak akan pernah melihat progresnya.
     */
    public function test_progres_ikut_berubah_setelah_baris_diisi(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'berkas_nota' => [
                    // Mode rinci supaya jumlah_nota menentukan banyak baris.
                    'b1' => ['file' => [$this->nota('satu.pdf')], 'jumlah_nota' => 2, 'mode' => 'rinci'],
                ],
            ]);

        // Awalnya 2 baris, semuanya kosong
        $this->assertCount(2, $test->get('data.pengeluaran'));

        // Isi lengkap 1 baris
        $test->fillForm([
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 100_000, 'kategori' => 'material'],
                ['tanggal' => '2026-09-01', 'jumlah' => null, 'kategori' => null],
            ],
        ]);

        $html = $test->html();

        $this->assertStringContainsString('1 dari 2 baris lengkap', $html);
    }
}
