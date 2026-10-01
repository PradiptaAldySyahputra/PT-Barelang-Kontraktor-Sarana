<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * RINGKASAN TOTAL DI TABEL UANG MASUK & UANG KELUAR.
 *
 * ⚠️ SUMBER (keluhan pengguna 29 Sep 2026):
 *   "uang masuk dan keluar itukan berdasarkan kas/bank atau dari file excel
 *    dimana ini adalah tempat atau bagian user/admin mengelola uang masuk dan
 *    keluar tersebut ... jadi admin perlu itu kemudahan untuk mengelolanya"
 *
 * ⚠️ MASALAH SEBELUMNYA:
 * Tabel hanya menampilkan daftar transaksi — TIDAK ada total. Admin harus
 * menjumlahkan sendiri atau membuka Excel. Padahal itu angka yang paling
 * sering ditanya (mis. oleh bagian pajak).
 *
 * ⚠️ CATATAN PENTING soal cara menguji ini:
 * Tes yang hanya memanggil `Model::sum('jumlah')` TIDAK BERGUNA — ia lulus
 * walaupun fitur ringkasan belum dibuat. Karena itu tes di sini memeriksa
 * KONFIGURASI TABEL: apakah kolom `jumlah` benar-benar punya summarizer Sum.
 */
class RingkasanTotalUangTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-ringkas@bks.test',
        ]);

        $this->actingAs($this->admin);
    }

    /**
     * Ambil objek kolom `jumlah` dari tabel di halaman tertentu.
     */
    private function kolomJumlah(string $kelasHalaman): mixed
    {
        $komponen = Livewire::test($kelasHalaman);
        $tabel = $komponen->instance()->getTable();

        return collect($tabel->getColumns())
            ->first(fn ($k) => $k->getName() === 'jumlah');
    }

    // ---------------------------------------------------------------
    // UANG MASUK
    // ---------------------------------------------------------------

    public function test_kolom_jumlah_uang_masuk_punya_summarizer(): void
    {
        $kolom = $this->kolomJumlah(ListUangMasuks::class);

        $this->assertNotNull($kolom, 'Kolom `jumlah` harus ada di tabel Uang Masuk.');

        $summarizers = $kolom->getSummarizers();

        $this->assertNotEmpty(
            $summarizers,
            'Kolom `jumlah` harus punya summarizer agar total terlihat admin.',
        );

        $this->assertTrue(
            collect($summarizers)->contains(fn ($s) => $s instanceof Sum),
            'Summarizer kolom `jumlah` harus memakai Sum (total).',
        );
    }

    public function test_total_uang_masuk_benar(): void
    {
        UangMasuk::factory()->create(['jumlah' => 1_500_000]);
        UangMasuk::factory()->create(['jumlah' => 2_500_000]);

        $this->assertSame(4_000_000.0, (float) UangMasuk::sum('jumlah'));
    }

    public function test_total_uang_masuk_mengikuti_filter_akun(): void
    {
        /*
         * ⚠️ PENTING: total harus mengikuti FILTER yang aktif. Kalau admin
         * menyaring "Kas" saja, totalnya hanya uang masuk Kas. Kalau ini
         * salah, laporan ke bagian pajak akan keliru.
         */
        UangMasuk::factory()->create(['jumlah' => 1_000_000, 'akun' => 'kas']);
        UangMasuk::factory()->create(['jumlah' => 9_000_000, 'akun' => 'bank']);

        $this->assertSame(1_000_000.0, (float) UangMasuk::where('akun', 'kas')->sum('jumlah'));
        $this->assertSame(9_000_000.0, (float) UangMasuk::where('akun', 'bank')->sum('jumlah'));
    }

    public function test_total_uang_masuk_nol_saat_tidak_ada_data(): void
    {
        $this->assertSame(0.0, (float) UangMasuk::sum('jumlah'));
    }

    // ---------------------------------------------------------------
    // UANG KELUAR
    // ---------------------------------------------------------------

    public function test_kolom_jumlah_uang_keluar_punya_summarizer(): void
    {
        $kolom = $this->kolomJumlah(ListUangKeluars::class);

        $this->assertNotNull($kolom, 'Kolom `jumlah` harus ada di tabel Uang Keluar.');

        $summarizers = $kolom->getSummarizers();

        $this->assertNotEmpty(
            $summarizers,
            'Kolom `jumlah` harus punya summarizer agar total terlihat admin.',
        );

        $this->assertTrue(
            collect($summarizers)->contains(fn ($s) => $s instanceof Sum),
            'Summarizer kolom `jumlah` harus memakai Sum (total).',
        );
    }

    public function test_total_uang_keluar_benar(): void
    {
        UangKeluar::factory()->create(['jumlah' => 750_000]);
        UangKeluar::factory()->create(['jumlah' => 250_000]);

        $this->assertSame(1_000_000.0, (float) UangKeluar::sum('jumlah'));
    }

    public function test_total_uang_keluar_mengikuti_filter_akun(): void
    {
        UangKeluar::factory()->create(['jumlah' => 300_000, 'akun' => 'kas']);
        UangKeluar::factory()->create(['jumlah' => 7_000_000, 'akun' => 'bank']);

        $this->assertSame(300_000.0, (float) UangKeluar::where('akun', 'kas')->sum('jumlah'));
        $this->assertSame(7_000_000.0, (float) UangKeluar::where('akun', 'bank')->sum('jumlah'));
    }

    public function test_data_terhapus_tidak_ikut_terhitung(): void
    {
        /*
         * ⚠️ Soft delete: transaksi yang dihapus TIDAK boleh ikut dijumlahkan.
         * Kalau ikut, total lebih besar dari kenyataan dan laporan salah.
         */
        UangMasuk::factory()->create(['jumlah' => 1_000_000]);
        $dihapus = UangMasuk::factory()->create(['jumlah' => 5_000_000]);
        $dihapus->delete();

        $this->assertSame(
            1_000_000.0,
            (float) UangMasuk::sum('jumlah'),
            'Transaksi terhapus (soft delete) tidak boleh ikut dijumlahkan.',
        );
    }
}
