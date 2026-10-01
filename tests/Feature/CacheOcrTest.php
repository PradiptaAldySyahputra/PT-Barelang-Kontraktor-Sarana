<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Services\PembacaNota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Cache hasil OCR.
 *
 * ⚠️ KENAPA INI PERLU (permintaan pengguna 26 Sep 2026: "jangan buat aplikasi
 * jadi berat"):
 *
 * Sebelumnya hasil OCR TIDAK disimpan. Setiap kali form dibuka atau diperbarui
 * (Livewire memanggil ulang berkas yang sama), proses Python dijalankan lagi:
 *
 *     4 nota   → ~1,7 detik
 *     57 nota  → ~38 detik
 *
 * Admin yang mengisi 10 baris nota bisa memicu OCR puluhan kali untuk berkas
 * yang SAMA → panel terasa berat.
 *
 * Perbaikan: hasil OCR disimpan di cache dengan kunci dari path berkas. Nama
 * berkas sudah deterministik (dari isi berkas), jadi kunci ini aman.
 *
 * Tes ini TIDAK menjalankan Python (tidak perlu venv) — cukup memastikan
 * mekanisme cache-nya bekerja.
 */
class CacheOcrTest extends TestCase
{
    use RefreshDatabase;

    public function test_hasil_ocr_disimpan_di_cache(): void
    {
        Storage::fake('nota');

        // Berkas kosong: OCR akan "gagal" dengan alasan, tapi hasilnya tetap
        // harus di-cache supaya berkas rusak tidak di-OCR berulang-ulang.
        Storage::disk('nota')->put('uang_keluar/uji.pdf', 'bukan pdf asli');

        config(['ocr.aktif' => true]);

        Cache::flush();

        $pembaca = app(PembacaNota::class);
        $pembaca->baca('uang_keluar/uji.pdf');

        $kunci = 'ocr:nota:'.md5('uang_keluar/uji.pdf');

        $this->assertTrue(
            Cache::has($kunci),
            'Hasil OCR harus disimpan di cache — kalau tidak, OCR jalan ulang setiap form dibuka (berat).',
        );
    }

    public function test_pemanggilan_kedua_tidak_menjalankan_ulang_proses(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/uji.pdf', 'bukan pdf asli');

        config(['ocr.aktif' => true]);
        Cache::flush();

        $pembaca = app(PembacaNota::class);

        $pertama = $pembaca->baca('uang_keluar/uji.pdf');

        // Sisipkan hasil "palsu" ke cache — kalau pemanggilan kedua memakai
        // cache (bukan menjalankan Python lagi), hasil palsu ini yang muncul.
        $kunci = 'ocr:nota:'.md5('uang_keluar/uji.pdf');
        Cache::put($kunci, [
            'ok' => true,
            'jumlah_nota' => 7,
            'metode' => 'uji-cache',
            'potongan' => [],
        ], now()->addDay());

        $kedua = $pembaca->baca('uang_keluar/uji.pdf');

        $this->assertSame(
            7,
            $kedua['jumlah_nota'],
            'Pemanggilan kedua harus memakai CACHE, bukan menjalankan OCR ulang.',
        );
        $this->assertSame('uji-cache', $kedua['metode']);
    }

    public function test_berkas_berbeda_punya_cache_berbeda(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/a.pdf', 'isi a');
        Storage::disk('nota')->put('uang_keluar/b.pdf', 'isi b');

        config(['ocr.aktif' => true]);
        Cache::flush();

        $pembaca = app(PembacaNota::class);
        $pembaca->baca('uang_keluar/a.pdf');
        $pembaca->baca('uang_keluar/b.pdf');

        $this->assertTrue(Cache::has('ocr:nota:'.md5('uang_keluar/a.pdf')));
        $this->assertTrue(Cache::has('ocr:nota:'.md5('uang_keluar/b.pdf')));
        $this->assertNotSame(
            md5('uang_keluar/a.pdf'),
            md5('uang_keluar/b.pdf'),
        );
    }

    public function test_ocr_mati_tidak_mengisi_cache(): void
    {
        Storage::fake('nota');
        Storage::disk('nota')->put('uang_keluar/uji.pdf', 'isi');

        config(['ocr.aktif' => false]);
        Cache::flush();

        app(PembacaNota::class)->baca('uang_keluar/uji.pdf');

        $this->assertFalse(
            Cache::has('ocr:nota:'.md5('uang_keluar/uji.pdf')),
            'OCR yang dimatikan tidak boleh mengisi cache — nanti dianggap sudah dibaca padahal belum.',
        );
    }
}
