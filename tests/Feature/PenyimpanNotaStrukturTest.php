<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\PenyimpanBerkas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * STRUKTUR FOLDER NOTA BERTANGGAL (B2-7).
 *
 * ⚠️ KENAPA DIUJI:
 * Dokumen minta berkas nota tersimpan otomatis di
 * `storage/nota/{tahun}/{bulan}/{tanggal}/`. Perubahan struktur folder
 * BERISIKO: kalau salah, berkas tidak terbaca atau perintah pembersih OCR
 * menghapus potongan yang masih dipakai.
 *
 * Yang dikunci tes ini:
 *   1. berkas BARU disimpan di sub-folder bertanggal;
 *   2. berkas LAMA (tanpa sub-folder tanggal) TETAP bisa dikembalikan apa adanya
 *      (idempoten) — jadi tidak ada migrasi berkas yang perlu.
 */
class PenyimpanNotaStrukturTest extends TestCase
{
    use RefreshDatabase;

    private function gambarUji(): string
    {
        if (! function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('Ekstensi GD tidak tersedia.');
        }

        $img = imagecreatetruecolor(300, 300);
        $putih = imagecolorallocate($img, 250, 250, 250);
        imagefilledrectangle($img, 0, 0, 300, 300, $putih);

        $tmp = tempnam(sys_get_temp_dir(), 'nota').'.png';
        imagepng($img, $tmp);
        imagedestroy($img);

        return $tmp;
    }

    public function test_berkas_baru_disimpan_di_folder_bertanggal(): void
    {
        Storage::fake('nota');

        $tanggal = Carbon::parse('2026-08-01');
        $path = app(PenyimpanBerkas::class)->simpanKe($this->gambarUji(), 'uang_keluar', 'nota', $tanggal);

        $this->assertNotNull($path);
        $this->assertStringStartsWith('uang_keluar/2026/08/01/', $path, 'Berkas baru harus di folder bertanggal.');
        $this->assertTrue(Storage::disk('nota')->exists($path));
    }

    public function test_tanpa_tanggal_memakai_waktu_unggah(): void
    {
        Storage::fake('nota');

        $path = app(PenyimpanBerkas::class)->simpanKe($this->gambarUji(), 'uang_masuk', 'nota');

        $this->assertNotNull($path);
        $this->assertStringStartsWith('uang_masuk/'.now()->format('Y/m/d').'/', $path);
    }

    public function test_berkas_lama_tanpa_tanggal_dikembalikan_apa_adanya(): void
    {
        Storage::fake('nota');

        // Berkas LAMA (struktur sebelum perubahan).
        Storage::disk('nota')->put('uang_keluar/nota-lama.jpg', 'ISI');

        $path = app(PenyimpanBerkas::class)->simpanKe('uang_keluar/nota-lama.jpg', 'uang_keluar', 'nota');

        $this->assertSame(
            'uang_keluar/nota-lama.jpg',
            $path,
            'Berkas lama harus dipakai apa adanya — jangan dipindah/diduplikasi.',
        );
    }

    public function test_idempoten_tidak_membuat_salinan_ganda(): void
    {
        Storage::fake('nota');

        $berkas = $this->gambarUji();
        $tanggal = Carbon::parse('2026-08-01');

        $a = app(PenyimpanBerkas::class)->simpanKe($berkas, 'uang_keluar', 'nota', $tanggal);
        $b = app(PenyimpanBerkas::class)->simpanKe($berkas, 'uang_keluar', 'nota', $tanggal);

        $this->assertSame($a, $b, 'Nama deterministik: simpan dua kali harus path SAMA.');
        $this->assertCount(1, Storage::disk('nota')->allFiles('uang_keluar/2026/08/01'));
    }
}
