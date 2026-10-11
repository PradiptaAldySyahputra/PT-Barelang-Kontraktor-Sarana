<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\UangKeluar;
use App\Support\ArsipNota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * ARSIP NOTA (B2-7) — pencarian & ZIP.
 *
 * ⚠️ KENAPA DIUJI:
 * Fitur ini menggantikan penelusuran folder manual untuk mencari nota per
 * tanggal. Salah di sini berarti admin mengunduh berkas yang salah.
 */
class ArsipNotaTest extends TestCase
{
    use RefreshDatabase;

    private function siapkanNota(string $path, string $isi = 'PDF'): void
    {
        Storage::disk('nota')->put($path, $isi);
    }

    public function test_mencari_nota_uang_keluar(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf');

        UangKeluar::factory()->create([
            'tanggal' => '2026-08-01',
            'akun' => 'kas',
            'bukti' => ['uang_keluar/a.pdf'],
            'penerima' => 'Toko A',
        ]);

        $arsip = ArsipNota::cari();

        $this->assertCount(1, $arsip);
        $this->assertSame('Uang Keluar', $arsip[0]['jenis']);
        $this->assertTrue($arsip[0]['ada']);
        $this->assertSame('2026-08-01 (1).pdf', $arsip[0]['nama']);
    }

    public function test_filter_periode(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf');
        $this->siapkanNota('uang_keluar/b.pdf');

        UangKeluar::factory()->create(['tanggal' => '2026-07-15', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-15', 'bukti' => ['uang_keluar/b.pdf']]);

        $arsip = ArsipNota::cari(['tanggal_awal' => '2026-08-01', 'tanggal_akhir' => '2026-08-31']);

        $this->assertCount(1, $arsip);
        $this->assertSame('uang_keluar/b.pdf', $arsip[0]['path']);
    }

    public function test_filter_akun(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf');
        $this->siapkanNota('uang_keluar/b.pdf');

        UangKeluar::factory()->create(['akun' => 'kas', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['akun' => 'bank', 'bukti' => ['uang_keluar/b.pdf']]);

        $arsip = ArsipNota::cari(['akun' => 'bank']);

        $this->assertCount(1, $arsip);
        $this->assertSame('bank', $arsip[0]['akun']);
    }

    public function test_kata_kunci_penerima(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf');
        $this->siapkanNota('uang_keluar/b.pdf');

        UangKeluar::factory()->create(['penerima' => 'Toko Bangunan Jaya', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['penerima' => 'Bengkel Las', 'bukti' => ['uang_keluar/b.pdf']]);

        $arsip = ArsipNota::cari(['q' => 'Bangunan']);

        $this->assertCount(1, $arsip);
        $this->assertSame('Toko Bangunan Jaya', $arsip[0]['penerima']);
    }

    public function test_penomoran_otomatis_per_tanggal(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf');
        $this->siapkanNota('uang_keluar/b.pdf');

        // Dua nota pada tanggal yang sama.
        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/b.pdf']]);

        $nama = ArsipNota::cari()->pluck('nama')->all();

        $this->assertContains('2026-08-01 (1).pdf', $nama);
        $this->assertContains('2026-08-01 (2).pdf', $nama);
    }

    public function test_buat_zip_berisi_semua_nota(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf', 'ISI-A');
        $this->siapkanNota('uang_keluar/b.pdf', 'ISI-B');

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-02', 'bukti' => ['uang_keluar/b.pdf']]);

        $arsip = ArsipNota::cari();
        $zipPath = ArsipNota::buatZip($arsip);

        $this->assertNotNull($zipPath);
        $this->assertFileExists($zipPath);

        $zip = new \ZipArchive;
        $zip->open($zipPath);
        $this->assertSame(2, $zip->numFiles);
        $zip->close();

        @unlink($zipPath);
    }

    public function test_buat_zip_null_bila_tidak_ada_berkas(): void
    {
        Storage::fake('nota');

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/hilang.pdf']]);

        $arsip = ArsipNota::cari();

        $this->assertNull(ArsipNota::buatZip($arsip));
    }

    public function test_menandai_berkas_hilang(): void
    {
        Storage::fake('nota');
        // Tidak menyimpan berkas apa pun.

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/hilang.pdf']]);

        $arsip = ArsipNota::cari();

        $this->assertCount(1, $arsip);
        $this->assertFalse($arsip[0]['ada']);
    }

    // ---------------------------------------------------------
    // Thumbnail (B2-7)
    // ---------------------------------------------------------

    public function test_menandai_berkas_gambar_untuk_thumbnail(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/foto.jpg');
        $this->siapkanNota('uang_keluar/dokumen.pdf');

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/foto.jpg']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-02', 'bukti' => ['uang_keluar/dokumen.pdf']]);

        $arsip = ArsipNota::cari();

        $jpg = $arsip->firstWhere('path', 'uang_keluar/foto.jpg');
        $pdf = $arsip->firstWhere('path', 'uang_keluar/dokumen.pdf');

        $this->assertTrue($jpg['gambar'], 'JPG harus ditandai gambar (thumbnail).');
        $this->assertFalse($pdf['gambar'], 'PDF bukan gambar → pakai ikon dokumen.');
    }

    public function test_helper_gambar_mengenali_ekstensi(): void
    {
        $this->assertTrue(ArsipNota::gambar('x.jpg'));
        $this->assertTrue(ArsipNota::gambar('x.JPEG'));
        $this->assertTrue(ArsipNota::gambar('x.png'));
        $this->assertTrue(ArsipNota::gambar('x.webp'));
        $this->assertFalse(ArsipNota::gambar('x.pdf'));
        $this->assertFalse(ArsipNota::gambar('x.bin'));
    }
}
