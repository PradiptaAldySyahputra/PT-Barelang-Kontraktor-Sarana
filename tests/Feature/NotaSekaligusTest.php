<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji REVISI USER: nota PDF sejajar dengan form & jumlah baris otomatis.
 *
 * Permintaan user:
 *   "di form uang keluar pdf atau nota bisa dibuat sejajar dengan form?
 *    jadi upload pdf dulu langsung pdf nota tampil sejajar dengan form
 *    dan perbarui juga bukan hanya bisa 4 pdf terdeteksi berapa nota yang
 *    terupload segitu formnya, jangan buat tambah manual formnya."
 *
 * Yang diuji:
 *   1. Jumlah baris = jumlah nota yang diunggah (bukan tetap 4).
 *   2. Tidak ada tombol tambah/hapus baris manual.
 *   3. Tiap baris punya notanya sendiri.
 *   4. Pratinjau nota dirender (sejajar dengan form).
 *   5. Data yang sudah diisi tidak hilang saat menambah nota.
 */
class NotaSekaligusTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-nota@bks.test']);
    }

    private function nota(string $nama = 'nota.pdf'): UploadedFile
    {
        return UploadedFile::fake()->create($nama, 100, 'application/pdf');
    }

    // =========================================================
    // 1. JUMLAH BARIS MENGIKUTI JUMLAH NOTA
    // =========================================================

    public function test_unggah_3_nota_membuat_3_baris(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [
                    $this->nota('nota-1.pdf'),
                    $this->nota('nota-2.pdf'),
                    $this->nota('nota-3.pdf'),
                ],
            ])
            ->assertSet('data.pengeluaran', function ($value): bool {
                return is_array($value) && count($value) === 3;
            });
    }

    public function test_unggah_7_nota_membuat_7_baris(): void
    {
        // User: "bukan hanya bisa 4 pdf, terdeteksi berapa nota yang
        // terupload segitu formnya"
        $this->actingAs($this->admin);

        $nota = [];

        foreach (range(1, 7) as $i) {
            $nota[] = $this->nota("nota-$i.pdf");
        }

        Livewire::test(CreateUangKeluar::class)
            ->fillForm(['nota_sekaligus' => $nota])
            ->assertSet('data.pengeluaran', function ($value): bool {
                return is_array($value) && count($value) === 7;
            });
    }

    public function test_unggah_1_nota_membuat_1_baris(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm(['nota_sekaligus' => [$this->nota()]])
            ->assertSet('data.pengeluaran', function ($value): bool {
                return is_array($value) && count($value) === 1;
            });
    }

    public function test_tiap_baris_punya_notanya_sendiri(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [
                    $this->nota('a.pdf'),
                    $this->nota('b.pdf'),
                ],
            ]);

        $data = $test->get('data.pengeluaran');

        $this->assertCount(2, $data);
        $this->assertNotEmpty($data[0]['bukti'] ?? [], 'Baris 1 harus punya nota');
        $this->assertNotEmpty($data[1]['bukti'] ?? [], 'Baris 2 harus punya nota');
        $this->assertNotSame($data[0]['bukti'], $data[1]['bukti'], 'Tiap baris nota berbeda');
    }

    public function test_data_terisi_tidak_hilang_saat_tambah_nota(): void
    {
        $this->actingAs($this->admin);

        $test = Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [$this->nota('satu.pdf')],
            ]);

        // Isi angka pada baris pertama
        $test->fillForm([
            'pengeluaran' => [
                ['tanggal' => '2026-09-01', 'jumlah' => 5_000_000, 'kategori' => 'material'],
            ],
        ]);

        // Lalu tambah nota kedua
        $test->fillForm([
            'nota_sekaligus' => [
                $this->nota('satu.pdf'),
                $this->nota('dua.pdf'),
            ],
        ]);

        $data = $test->get('data.pengeluaran');

        $this->assertCount(2, $data);
        $this->assertSame(5_000_000, (int) ($data[0]['jumlah'] ?? 0), 'Angka baris 1 harus tetap ada');
    }

    // =========================================================
    // 2. TIDAK ADA TAMBAH/HAPUS BARIS MANUAL
    // =========================================================

    public function test_tidak_ada_tombol_tambah_baris_manual(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringNotContainsString('Tambah baris', $html);
        $this->assertStringNotContainsString('+ Tambah', $html);
    }

    // =========================================================
    // 3. PRATINJAU SEJAJAR
    // =========================================================

    public function test_halaman_tambah_menampilkan_placeholder_pratinjau(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        // Teks dari komponen pratinjau-nota
        $this->assertStringContainsString('pratinjau', strtolower($html));
    }

    public function test_halaman_ubah_juga_punya_pratinjau(): void
    {
        $keluar = UangKeluar::factory()->create();

        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/'.$keluar->id.'/edit')
            ->assertOk()
            ->getContent();

        // Revisi user: pratinjau LEBAR PENUH di ATAS field, bukan di samping.
        $this->assertStringContainsString('Buka di tab baru', $html);
    }

    // =========================================================
    // 4. PENYIMPANAN
    // =========================================================

    public function test_simpan_3_nota_menyimpan_3_transaksi(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [
                    $this->nota('n1.pdf'),
                    $this->nota('n2.pdf'),
                    $this->nota('n3.pdf'),
                ],
            ])
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                    ['tanggal' => '2026-09-02', 'jumlah' => 2_000_000, 'kategori' => 'upah'],
                    ['tanggal' => '2026-09-03', 'jumlah' => 3_000_000, 'kategori' => 'transportasi'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(3, UangKeluar::count());
        $this->assertSame(6_000_000.0, (float) UangKeluar::sum('jumlah'));
    }

    public function test_nota_tersimpan_di_kolom_bukti(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [$this->nota('bukti-saya.pdf')],
            ])
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $keluar = UangKeluar::first();

        $this->assertNotNull($keluar->bukti, 'Kolom bukti harus terisi path nota');
        $this->assertIsArray($keluar->bukti);
        $this->assertNotEmpty($keluar->bukti);
    }

    /**
     * ⚠️ REGRESI BUG PENTING.
     *
     * Versi lama memanggil `$f->store('public')` — padahal parameter pertama
     * `store()` adalah NAMA FOLDER, bukan nama disk. Akibatnya file tersimpan
     * di folder bersarang `storage/app/public/public/xxx.pdf` sehingga nota
     * TIDAK bisa dibuka (file "belum ada").
     *
     * Test ini memastikan path nota selalu berada di dalam folder
     * `uang_keluar/`, dan TIDAK diawali `public/`.
     */
    public function test_path_nota_tidak_bersarang_di_folder_public(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [$this->nota('path-uji.pdf')],
            ])
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $keluar = UangKeluar::first();
        $path = is_array($keluar->bukti) ? ($keluar->bukti[0] ?? null) : $keluar->bukti;

        $this->assertNotNull($path, 'Path nota tidak boleh kosong');
        $this->assertStringStartsWith(
            'uang_keluar/',
            $path,
            'Path nota harus di dalam folder uang_keluar/ — bukan folder bersarang'
        );
        $this->assertStringNotContainsString(
            'public/',
            $path,
            'Path nota TIDAK boleh mengandung "public/" (bug store($disk))'
        );
        $this->assertFalse(
            str_starts_with($path, 'public/'),
            'Path nota tidak boleh diawali "public/"'
        );
    }

    public function test_file_nota_benar_benar_tersimpan(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'nota_sekaligus' => [$this->nota('tersimpan.pdf')],
            ])
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $keluar = UangKeluar::first();
        $path = is_array($keluar->bukti) ? ($keluar->bukti[0] ?? null) : $keluar->bukti;

        Storage::disk('public')->assertExists($path);
    }

    // =========================================================
    // 5. BUG: FILE BUKTI HARUS BISA DIAKSES
    // =========================================================

    public function test_disk_default_adalah_public(): void
    {
        // Bug sebelumnya: FILESYSTEM_DISK=local membuat file tersimpan di
        // storage/app/private yang TIDAK bisa diakses browser, sehingga
        // semua link bukti 404.
        $this->assertSame('public', config('filament.default_filesystem_disk'));
    }
}
