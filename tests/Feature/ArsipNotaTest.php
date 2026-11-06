<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Support\ArsipNota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * ARSIP NOTA (B2-7) - pencarian & ZIP.
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

        // Tidak boleh ada berkas kosong sisa tempnam() di sebelah ZIP.
        $this->assertFileDoesNotExist(substr($zipPath, 0, -4), 'Berkas dasar tempnam() harus dihapus.');

        $zip = new \ZipArchive;
        $zip->open($zipPath);
        $this->assertSame(2, $zip->numFiles);

        // BUG-3: dengan addFile() (streaming), isi berkas harus TETAP utuh.
        $this->assertSame('ISI-A', $zip->getFromName('2026-08-01/2026-08-01 (1).pdf'));
        $this->assertSame('ISI-B', $zip->getFromName('2026-08-02/2026-08-02 (1).pdf'));
        $zip->close();

        @unlink($zipPath);
    }

    /**
     * BUG-3: satu berkas hilang di tengah jalan tidak boleh menggagalkan
     * seluruh ZIP - berkas lain tetap terunduh.
     */
    public function test_buat_zip_tetap_jalan_walau_sebagian_berkas_hilang(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/ada.pdf', 'ADA');

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/ada.pdf']]);
        // Berkas ini TIDAK dibuat di disk → "hilang".
        UangKeluar::factory()->create(['tanggal' => '2026-08-02', 'bukti' => ['uang_keluar/hilang.pdf']]);

        $arsip = ArsipNota::cari();
        $zipPath = ArsipNota::buatZip($arsip);

        $this->assertNotNull($zipPath, 'ZIP tetap dibuat selama ada minimal satu berkas.');

        $zip = new \ZipArchive;
        $zip->open($zipPath);
        $this->assertSame(1, $zip->numFiles, 'Hanya berkas yang ada yang masuk ZIP.');
        $this->assertSame('ADA', $zip->getFromName('2026-08-01/2026-08-01 (1).pdf'));
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

    // Thumbnail (B2-7)

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

    public function test_hitung_ukuran_hanya_menghitung_berkas_yang_ada(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/ada.pdf', '12345');

        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/ada.pdf']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-02', 'bukti' => ['uang_keluar/hilang.pdf']]);

        $ukuran = ArsipNota::hitungUkuran(ArsipNota::cari());

        $this->assertSame(1, $ukuran['berkas']);
        $this->assertSame(5, $ukuran['byte']);
    }

    public function test_unduh_zip_ditolak_bila_melebihi_batas(): void
    {
        Storage::fake('nota');
        config(['filesystems.arsip_zip_maks_berkas' => 1]);

        $this->siapkanNota('uang_keluar/a.pdf', 'A');
        $this->siapkanNota('uang_keluar/b.pdf', 'B');
        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/a.pdf']]);
        UangKeluar::factory()->create(['tanggal' => '2026-08-02', 'bukti' => ['uang_keluar/b.pdf']]);

        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);
        $sebelum = glob(sys_get_temp_dir().'/arsip-nota*.zip') ?: [];

        $this->actingAs($admin)
            ->get('/panel/arsip-nota/zip')
            ->assertRedirect()
            ->assertSessionHas('gagal', fn (string $pesan) => str_contains($pesan, 'terlalu besar'));

        // Ditolak sebelum ZIP dibangun → tidak ada berkas temp baru.
        $baru = array_values(array_diff(glob(sys_get_temp_dir().'/arsip-nota*.zip') ?: [], $sebelum));
        $this->assertSame([], $baru, 'ZIP tidak boleh dibuat untuk arsip di atas batas.');
    }

    public function test_unduh_zip_di_bawah_batas_tetap_jalan(): void
    {
        Storage::fake('nota');
        $this->siapkanNota('uang_keluar/a.pdf', 'A');
        UangKeluar::factory()->create(['tanggal' => '2026-08-01', 'bukti' => ['uang_keluar/a.pdf']]);

        $admin = Pengguna::factory()->create(['peran' => Peran::Admin]);
        $sebelum = glob(sys_get_temp_dir().'/arsip-nota*.zip') ?: [];

        $this->actingAs($admin)->get('/panel/arsip-nota/zip')->assertOk();

        // Response download di lingkungan tes tidak "mengirim" berkas, jadi
        // deleteFileAfterSend() belum jalan — bersihkan sendiri.
        foreach (array_diff(glob(sys_get_temp_dir().'/arsip-nota*.zip') ?: [], $sebelum) as $sisa) {
            @unlink($sisa);
        }
    }
}
