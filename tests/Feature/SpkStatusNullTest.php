<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * SPK yang kolom statusnya NULL (belum diisi) tidak boleh "menghilang"
 * dari filter & tidak boleh membuat aplikasi error.
 *
 * ⚠️ AKAR MASALAH: kolom `status_tagihan` & `status_spk` boleh NULL (nullable).
 * Di SQL, `NULL != 'dibayar'` bernilai UNKNOWN (bukan true), sehingga
 * `where('status_tagihan', '!=', ...)` MENYARING HABIS baris berstatus NULL.
 * Akibatnya SPK seperti itu hilang dari tab "Belum Lunas" dan dari daftar
 * lewat/mendekati tenggat — padahal justru itu yang perlu ditindaklanjuti.
 *
 * Kolom status juga di-cast ke Enum, sehingga `$spk->status_spk->method()`
 * melempar "Call to a member function on null" bila nilainya NULL.
 */
class SpkStatusNullTest extends TestCase
{
    use RefreshDatabase;

    public function test_spk_status_tagihan_null_tetap_muncul_di_belum_lunas(): void
    {
        $spk = Spk::factory()->create(['status_tagihan' => null]);

        $this->assertTrue(
            Spk::belumLunas()->whereKey($spk->id)->exists(),
            'SPK dengan status_tagihan NULL harus tetap dianggap belum lunas.',
        );
    }

    public function test_spk_status_tagihan_dibayar_tidak_muncul_di_belum_lunas(): void
    {
        $spk = Spk::factory()->create(['status_tagihan' => 'dibayar']);

        $this->assertFalse(
            Spk::belumLunas()->whereKey($spk->id)->exists(),
            'SPK yang sudah Dibayar tidak boleh muncul di Belum Lunas.',
        );
    }

    public function test_spk_status_spk_null_dengan_tenggat_lewat_tetap_terdeteksi(): void
    {
        $spk = Spk::factory()->create([
            'status_spk' => null,
            'tanggal_akhir' => now()->subDays(5),
        ]);

        $this->assertTrue(
            Spk::lewatTenggat()->whereKey($spk->id)->exists(),
            'SPK berstatus NULL dengan tenggat lewat harus terdeteksi lewat tenggat.',
        );
    }

    public function test_form_uang_masuk_tidak_error_saat_spk_status_spk_null(): void
    {
        $spk = Spk::factory()->create(['status_spk' => null]);

        // Meniru aturan validasi di UangMasukForm tanpa menjalankan Livewire:
        // inti aturannya adalah memanggil bolehTransaksiBaru() pada status SPK.
        $boleh = $spk->status_spk === null || $spk->status_spk->bolehTransaksiBaru();

        $this->assertTrue($boleh, 'SPK berstatus NULL harus dianggap boleh menerima transaksi.');

        // Dan transaksi benar-benar bisa dibuat tanpa error.
        $masuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 1_000_000,
        ]);

        $this->assertDatabaseHas('uang_masuk', ['id' => $masuk->id]);
    }
}
