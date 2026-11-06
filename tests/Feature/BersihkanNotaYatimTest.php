<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * PEMBERSIH NOTA YATIM (ocr:bersihkan).
 *
 * ⚠️ KENAPA DIUJI:
 * Unggahan yang dibatalkan menumpuk di disk (1,3 GB di mesin pengembangan).
 * Pembersih ini menghapus berkas yang tidak dirujuk database. Kalau aturannya
 * salah, BERKAS BUKTI TRANSAKSI bisa hilang — kerusakan yang tidak bisa
 * dibatalkan. Masa tenggang wajib melindungi unggahan yang sedang diisi.
 */
class BersihkanNotaYatimTest extends TestCase
{
    use RefreshDatabase;

    private function tua(string $path): void
    {
        touch(Storage::disk('nota')->path($path), now()->subHours(48)->getTimestamp());
    }

    public function test_berkas_yang_dirujuk_tetap_ada_walau_tua(): void
    {
        Storage::fake('nota');

        UangKeluar::factory()->create(['bukti' => ['uang_keluar/2026/08/01/nota-a.jpg']]);
        Storage::disk('nota')->put('uang_keluar/2026/08/01/nota-a.jpg', 'isi');
        $this->tua('uang_keluar/2026/08/01/nota-a.jpg');

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        Storage::disk('nota')->assertExists('uang_keluar/2026/08/01/nota-a.jpg');
    }

    public function test_berkas_yatim_yang_sudah_tua_dibuang(): void
    {
        Storage::fake('nota');

        Storage::disk('nota')->put('uang_keluar/2026/08/01/nota-batal.jpg', 'isi');
        $this->tua('uang_keluar/2026/08/01/nota-batal.jpg');

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        Storage::disk('nota')->assertMissing('uang_keluar/2026/08/01/nota-batal.jpg');
        // Folder bertanggal yang kosong ikut dibersihkan.
        $this->assertDirectoryDoesNotExist(
            Storage::disk('nota')->path('uang_keluar/2026/08/01'),
        );
    }

    public function test_unggahan_baru_belum_disapu(): void
    {
        Storage::fake('nota');

        // Baru diunggah, admin mungkin masih mengisi form.
        Storage::disk('nota')->put('uang_keluar/2026/11/06/nota-baru.jpg', 'isi');

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        Storage::disk('nota')->assertExists('uang_keluar/2026/11/06/nota-baru.jpg');
    }

    public function test_mode_kering_tidak_menghapus(): void
    {
        Storage::fake('nota');

        Storage::disk('nota')->put('uang_keluar/2026/08/01/nota-batal.jpg', 'isi');
        $this->tua('uang_keluar/2026/08/01/nota-batal.jpg');

        $this->artisan('ocr:bersihkan --kering')->assertSuccessful();

        Storage::disk('nota')->assertExists('uang_keluar/2026/08/01/nota-batal.jpg');
    }

    public function test_potongan_ocr_yatim_dibuang_potongan_dirujuk_disimpan(): void
    {
        Storage::fake('nota');

        $dipakai = 'uang_keluar/potongan/abc123/potong-1.jpg';
        $yatim = 'uang_keluar/potongan/def456/potong-1.jpg';

        UangKeluar::factory()->create(['bukti' => [$dipakai]]);

        Storage::disk('nota')->put($dipakai, 'isi');
        Storage::disk('nota')->put($yatim, 'isi');
        $this->tua($dipakai);
        $this->tua($yatim);

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        Storage::disk('nota')->assertExists($dipakai);
        Storage::disk('nota')->assertMissing($yatim);
    }

    public function test_data_terhapus_soft_delete_masih_melindungi_berkas(): void
    {
        Storage::fake('nota');

        $transaksi = UangKeluar::factory()->create(['bukti' => ['uang_keluar/2026/08/01/nota-c.jpg']]);
        $transaksi->delete();

        Storage::disk('nota')->put('uang_keluar/2026/08/01/nota-c.jpg', 'isi');
        $this->tua('uang_keluar/2026/08/01/nota-c.jpg');

        $this->artisan('ocr:bersihkan')->assertSuccessful();

        Storage::disk('nota')->assertExists('uang_keluar/2026/08/01/nota-c.jpg');
    }

    public function test_semua_membuang_potongan_walau_dirujuk(): void
    {
        Storage::fake('nota');

        $potongan = 'uang_keluar/potongan/abc123/potong-1.jpg';
        UangKeluar::factory()->create(['bukti' => [$potongan]]);

        Storage::disk('nota')->put($potongan, 'isi');

        $this->artisan('ocr:bersihkan --semua')->assertSuccessful();

        Storage::disk('nota')->assertMissing($potongan);
    }
}
