<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Schemas\UangKeluarForm;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * SKENARIO USER — "1 upload tapi isinya cuma 1 nota, kenapa dibuat 4 form?"
 *
 * Bug yang dilaporkan user punya DUA sebab:
 *
 *   1. OCR belum aktif di `.env` (`OCR_NOTA` tidak ada, `ocr-venv` belum
 *      dibuat). Akibatnya sistem memakai DEFAULT 4 — permintaan sebelumnya —
 *      dan tidak pernah membaca isi berkasnya.
 *   2. Jalur OCR tidak teruji lewat Livewire: `fillForm()` TIDAK memicu
 *      `afterStateUpdated`, jadi tes berbasis Livewire tidak pernah
 *      menjalankan OCR. Itu sebabnya bug ini lolos dari 350 tes.
 *
 * Karena itu tes di sini memanggil jalur OCR secara LANGSUNG lewat
 * `UangKeluarForm::jalankanOcrPenuh()` — fungsi murni yang memang dipakai
 * form saat admin mengunggah berkas.
 */
class SkenarioSatuNotaTest extends TestCase
{
    use RefreshDatabase;

    protected Pengguna $admin;

    protected string $python;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('nota');

        $this->python = base_path('ocr-venv/bin/python');

        if (! is_executable($this->python)) {
            $this->markTestSkipped('venv OCR belum dipasang — lewati tes OCR nyata.');
        }

        config([
            'ocr.aktif' => true,
            'ocr.python' => $this->python,
        ]);

        $this->admin = Pengguna::factory()->admin()->create();
    }

    /**
     * Simpan berkas asli ke storage palsu, kembalikan path relatifnya.
     *
     * Sumber berkas uji diambil dari tests/Fixtures/ — BUKAN dari
     * storage/app/public/. Dulu fixture disimpan di storage, padahal:
     *   1. `storage/app/public` di-gitignore → fixture hilang setelah clone,
     *   2. perintah `ocr:bersihkan` menghapus isi folder itu → tes rusak
     *      sendiri (inilah yang dulu membuat 3 tes ini gagal).
     * Fixture yang ikut Git tidak akan hilang lagi.
     */
    private function simpanBerkas(string $sumber, string $nama): string
    {
        $file = UploadedFile::fake()->createWithContent($nama, (string) file_get_contents($sumber));

        return $file->store('uang_keluar', 'nota');
    }

    /** Path fixture yang ikut Git (aman dari pembersihan storage). */
    private function fixture(string $nama): string
    {
        return base_path('tests/Fixtures/'.$nama);
    }

    /**
     * ⚠️ INTI LAPORAN USER.
     *
     * 1 berkas berisi 1 nota harus jadi 1 baris, bukan 4.
     */
    public function test_satu_berkas_satu_nota_menghasilkan_satu_baris(): void
    {
        $this->actingAs($this->admin);

        $path = $this->simpanBerkas(
            $this->fixture('nota-contoh.jpg'),
            'nota.jpg',
        );

        $hasil = UangKeluarForm::jalankanOcrPenuh([
            'b1' => ['file' => [$path], 'jumlah_nota' => 1],
        ]);

        // Jumlah nota harus TERISI OTOMATIS oleh OCR (bukan 4 default).
        $this->assertSame(
            1,
            (int) ($hasil['berkas']['b1']['jumlah_nota'] ?? 0),
            'OCR harus mengisi jumlah_nota = 1 untuk berkas berisi 1 nota',
        );

        // Baris rincian harus 1, bukan 4.
        $this->assertCount(
            1,
            $hasil['baris'],
            'Berkas 1 nota harus menghasilkan 1 baris — bukan 4',
        );
    }

    /**
     * Pesan OCR harus muncul supaya admin tahu berkasnya sudah dibaca.
     */
    public function test_potongan_dan_pesan_ocr_dihasilkan(): void
    {
        $this->actingAs($this->admin);

        $path = $this->simpanBerkas(
            $this->fixture('nota-contoh.jpg'),
            'nota.jpg',
        );

        $hasil = UangKeluarForm::jalankanOcrPenuh([
            'b1' => ['file' => [$path], 'jumlah_nota' => 1, 'mode' => 'rinci'],
        ]);

        // Potongan disimpan di PETA (path berkas -> daftar potongan), bukan di
        // dalam item repeater. Ini disengaja: lihat catatan di repeaterBerkas().
        $this->assertArrayHasKey(
            $path,
            $hasil['potongan'],
            'OCR harus mencatat potongan untuk berkas ini',
        );

        $this->assertNotEmpty(
            $hasil['potongan'][$path],
            'OCR harus menghasilkan minimal 1 potongan',
        );

        // Potongan juga harus sampai ke baris rincian.
        $this->assertNotNull(
            $hasil['baris'][0]['potongan'] ?? null,
            'Baris pertama harus memakai potongan hasil OCR',
        );
    }

    /**
     * ⚠️ REGRESI PENTING: PDF MULTI-HALAMAN.
     *
     * Bug nyata yang dilaporkan admin: berkas "(12) nota simada bulan ags 26.pdf"
     * berisi 15 halaman × 4 nota = 57 nota, tapi sistem melaporkan cuma 4 nota
     * karena skrip OCR hanya membaca HALAMAN PERTAMA.
     *
     * Ini menyesatkan admin — dia mengira berkasnya cuma berisi 4 nota.
     *
     * Tes ini memastikan skrip memproses SEMUA halaman.
     */
    public function test_skrip_ocr_memproses_semua_halaman_pdf(): void
    {
        $sumber = file_get_contents(base_path('python/ocr_nota.py'));

        $this->assertStringContainsString(
            'render_semua_halaman',
            $sumber,
            'Skrip harus punya fungsi render semua halaman',
        );

        $this->assertStringContainsString(
            'for nomor in range(dokumen.page_count)',
            $sumber,
            'Skrip harus mengulang SELURUH halaman, bukan hanya halaman 0',
        );

        // Pastikan TIDAK ada pemanggilan load_page(0) yang tersisa di jalur utama.
        $this->assertStringNotContainsString(
            'load_page(0)',
            $sumber,
            'load_page(0) hanya membaca halaman pertama — itu bug yang pernah terjadi',
        );

        $this->assertStringContainsString(
            '"halaman_diproses"',
            $sumber,
            'Jumlah halaman yang diproses harus dilaporkan',
        );
    }

    /**
     * Penomoran potongan harus lanjut antar halaman — supaya nota_1.png dari
     * halaman 1 tidak tertimpa nota_1.png dari halaman 2.
     */
    public function test_penomoran_potongan_lanjut_antar_halaman(): void
    {
        $sumber = file_get_contents(base_path('python/ocr_nota.py'));

        $this->assertStringContainsString(
            'mulai_dari',
            $sumber,
            'simpan_potongan harus menerima nomor awal supaya tidak bentrok',
        );
    }

    /**
     * Berkas 4 nota harus tetap jadi 4 baris (jangan over-correct).
     */
    public function test_berkas_empat_nota_tetap_empat_baris(): void
    {
        $this->actingAs($this->admin);

        $pdf = $this->fixture('nota-4nota.pdf');

        if (! is_file($pdf)) {
            $this->markTestSkipped('Fixture 4 nota (tests/Fixtures/nota-4nota.pdf) tidak ada.');
        }

        $path = $this->simpanBerkas($pdf, 'empat.pdf');

        $hasil = UangKeluarForm::jalankanOcrPenuh([
            'b1' => ['file' => [$path], 'jumlah_nota' => 1, 'mode' => 'rinci'],
        ]);

        $this->assertSame(4, (int) $hasil['berkas']['b1']['jumlah_nota']);
        $this->assertCount(4, $hasil['baris'], 'Berkas 4 nota harus menghasilkan 4 baris');
    }

    /**
     * REGRESI: OCR mati -> jangan error, dan jangan menimpa jumlah manual.
     */
    public function test_ocr_mati_tidak_menimpa_jumlah_nota_manual(): void
    {
        config(['ocr.aktif' => false]);

        $this->actingAs($this->admin);

        $path = $this->simpanBerkas(
            $this->fixture('nota-contoh.jpg'),
            'nota.jpg',
        );

        $hasil = UangKeluarForm::jalankanOcrPenuh([
            'b1' => ['file' => [$path], 'jumlah_nota' => 3, 'mode' => 'rinci'],
        ]);

        // Jumlah nota manual TIDAK boleh ditimpa saat OCR mati.
        $this->assertSame(
            3,
            (int) $hasil['berkas']['b1']['jumlah_nota'],
            'Saat OCR mati, jumlah nota manual harus dipertahankan',
        );

        $this->assertCount(3, $hasil['baris']);
    }
}
