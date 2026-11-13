<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Halaman sistem (Arsip Nota, Ekspor & Unduhan, Status Sistem, Backup,
 * Impor Data) + Profil akun pada panel Blade.
 */
class SystemPanelTest extends TestCase
{
    use RefreshDatabase;

    private function pengguna(Peran $peran): Pengguna
    {
        return Pengguna::factory()->create(['peran' => $peran]);
    }

    public function test_admin_bisa_mengunggah_berkas_impor_csv(): void
    {
        Storage::fake('local');
        $admin = $this->pengguna(Peran::Admin);

        $kontenCsv = "tanggal,jumlah,akun,kategori,penerima,keterangan\n".
            now()->format('Y-m-d').",500000,kas,material,Toko Bangunan Uji,Beli semen 10 sak\n";

        $fileCsv = UploadedFile::fake()->createWithContent('impor-transaksi.csv', $kontenCsv);

        $response = $this->actingAs($admin)
            ->post(route('panel.import.store'), [
                'jenis' => 'keluar',
                'berkas' => $fileCsv,
            ]);

        $response->assertRedirect(route('panel.import'));
        $response->assertSessionHas('berhasil');
        $response->assertSessionHas('impor_hasil');
    }

    public function test_direktur_juga_bisa_menjalankan_impor_data(): void
    {
        Storage::fake('local');
        $direktur = $this->pengguna(Peran::Direktur);

        $kontenCsv = "tanggal,jumlah,akun,kategori,penerima,keterangan\n".
            now()->format('Y-m-d').",750000,kas,material,Vendor Baja Batam,Beli besi beton\n";

        $fileCsv = UploadedFile::fake()->createWithContent('impor-direktur.csv', $kontenCsv);

        $response = $this->actingAs($direktur)
            ->post(route('panel.import.store'), [
                'jenis' => 'keluar',
                'berkas' => $fileCsv,
            ]);

        $response->assertRedirect(route('panel.import'));
        $response->assertSessionHas('berhasil');
    }

    /* =====================================================
       Hak akses per halaman
       ===================================================== */

    public function test_halaman_bersama_boleh_dibuka_kedua_peran(): void
    {
        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $pengguna = $this->pengguna($peran);
            $this->actingAs($pengguna)->get('/panel/exports')->assertRedirect('/panel/reports');
            $this->actingAs($pengguna)->get('/panel/profile')->assertOk();
        }

        // Halaman unggah nota mandiri dapat diakses oleh Admin & Direktur (Super Admin)
        $admin = $this->pengguna(Peran::Admin);
        $this->actingAs($admin)->get('/panel/receipts/upload')->assertOk();

        $direktur = $this->pengguna(Peran::Direktur);
        $this->actingAs($direktur)->get('/panel/receipts/upload')->assertOk();
    }

    public function test_halaman_sistem_bisa_diakses_admin_dan_direktur(): void
    {
        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $pengguna = $this->pengguna($peran);

            foreach (['/panel/status', '/panel/backup', '/panel/import'] as $url) {
                $this->actingAs($pengguna)->get($url)->assertOk();
            }
        }
    }

    /* =====================================================
       Impor data
       ===================================================== */

    public function test_impor_uang_masuk_dari_csv(): void
    {
        $csv = "tanggal,jumlah,akun,kategori,penerima,keterangan\n"
            ."2026-01-05,1500000,Kas,,,Setoran awal\n"
            ."2026-01-06,2500000,Bank,,,Termin 1\n";

        $berkas = UploadedFile::fake()->createWithContent('impor.csv', $csv);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/import', ['jenis' => 'masuk', 'berkas' => $berkas])
            ->assertRedirect(route('panel.import'));

        $this->assertSame(2, UangMasuk::query()->count());
        $this->assertSame(4_000_000.0, (float) UangMasuk::query()->sum('jumlah'));
    }

    public function test_impor_csv_dengan_nomor_spk_otomatis_menautkan_spk_id_dan_menjaga_batas_piutang(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => 'SPK/IMPOR/BTM/2026/001',
            'nilai_spk' => 5_000_000,
        ]);

        // Baris 1 (3jt) valid -> masuk ke SPK; Baris 2 (4jt) melebihi sisa piutang 2jt -> ditolak
        $csv = "tanggal,jumlah,akun,nomor_spk,kategori,penerima,keterangan\n"
            ."2026-01-10,3000000,Bank,SPK/IMPOR/BTM/2026/001,,,Termin 1\n"
            ."2026-01-11,4000000,Bank,SPK/IMPOR/BTM/2026/001,,,Termin 2 Lebih\n";

        $berkas = UploadedFile::fake()->createWithContent('impor-spk.csv', $csv);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->post('/panel/import', ['jenis' => 'masuk', 'berkas' => $berkas])
            ->assertRedirect(route('panel.import'));

        $this->assertSame(1, UangMasuk::where('spk_id', $spk->id)->count());
        $this->assertSame(3_000_000.0, (float) UangMasuk::where('spk_id', $spk->id)->sum('jumlah'));
    }

    public function test_template_impor_bisa_diunduh(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get(route('panel.import.template'))
            ->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    /* =====================================================
       Profil
       ===================================================== */

    public function test_ubah_nama_dan_email_sendiri(): void
    {
        $pengguna = $this->pengguna(Peran::Admin);

        $this->actingAs($pengguna)
            ->put('/panel/profile', [
                'nama' => 'Nama Baru',
                'email' => 'baru@bks.test',
            ])
            ->assertRedirect(route('panel.profile'));

        $pengguna->refresh();

        $this->assertSame('Nama Baru', $pengguna->nama);
        $this->assertSame('baru@bks.test', $pengguna->email);
    }

    public function test_simpan_avatar_crop_base64(): void
    {
        $pengguna = $this->pengguna(Peran::Admin);

        // 1x1 pixel PNG transparent base64
        $fakeBase64 = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

        $this->actingAs($pengguna)
            ->put('/panel/profile', [
                'nama' => $pengguna->nama,
                'email' => $pengguna->email,
                'avatar_base64' => $fakeBase64,
            ])
            ->assertRedirect(route('panel.profile'));

        $pengguna->refresh();
        $this->assertNotNull($pengguna->avatar);
        $this->assertStringStartsWith('profil/', $pengguna->avatar);
    }

    public function test_email_tidak_boleh_bentrok_dengan_akun_lain(): void
    {
        $lain = $this->pengguna(Peran::Direktur);
        $pengguna = $this->pengguna(Peran::Admin);

        $this->actingAs($pengguna)
            ->put('/panel/profile', ['nama' => 'X', 'email' => $lain->email])
            ->assertSessionHasErrors('email');
    }

    public function test_ganti_sandi_butuh_sandi_lama_yang_benar(): void
    {
        $pengguna = $this->pengguna(Peran::Admin);

        $this->actingAs($pengguna)
            ->put('/panel/profile/password', [
                'password_lama' => 'salah-sekali',
                'password' => 'sandibaru123',
                'password_confirmation' => 'sandibaru123',
            ])
            ->assertSessionHasErrors('password_lama');

        $this->assertTrue(Hash::check('password', (string) $pengguna->fresh()?->password));
    }

    public function test_ganti_sandi_berhasil(): void
    {
        $pengguna = $this->pengguna(Peran::Admin);

        $this->actingAs($pengguna)
            ->put('/panel/profile/password', [
                'password_lama' => 'password',
                'password' => 'sandibaru123',
                'password_confirmation' => 'sandibaru123',
            ])
            ->assertRedirect(route('panel.profile'));

        $this->assertTrue(Hash::check('sandibaru123', (string) $pengguna->fresh()?->password));
    }

    public function test_sandi_baru_harus_dikonfirmasi(): void
    {
        $pengguna = $this->pengguna(Peran::Admin);

        $this->actingAs($pengguna)
            ->put('/panel/profile/password', [
                'password_lama' => 'password',
                'password' => 'sandibaru123',
                'password_confirmation' => 'beda-sendiri',
            ])
            ->assertSessionHasErrors('password');
    }

    /* =====================================================
       Arsip nota
       ===================================================== */

    public function test_arsip_nota_menampilkan_berkas_transaksi(): void
    {
        UangMasuk::factory()->create([
            'jumlah' => 1_000_000,
            'akun' => AkunKas::Kas,
            'bukti' => ['uang_masuk/nota-uji.pdf'],
            'keterangan' => 'Setoran uji arsip',
        ]);

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get('/panel/receipts')
            ->assertOk()
            ->assertSee('Uang Masuk')
            // Nama berkas di arsip dibuat otomatis: "YYYY-MM-DD (n).ext".
            ->assertSee('(1).pdf');
    }

    public function test_arsip_nota_mendukung_filter_satu_tanggal(): void
    {
        UangMasuk::factory()->create([
            'tanggal' => '2026-02-10',
            'jumlah' => 1_000_000,
            'akun' => AkunKas::Kas,
            'bukti' => ['uang_masuk/nota-feb.pdf'],
            'keterangan' => 'Nota Februari',
        ]);

        UangMasuk::factory()->create([
            'tanggal' => '2026-08-20',
            'jumlah' => 2_000_000,
            'akun' => AkunKas::Kas,
            'bukti' => ['uang_masuk/nota-agu.pdf'],
            'keterangan' => 'Nota Agustus',
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/receipts?tanggal=2026-02-10')
            ->assertOk()
            ->assertSee('Nota Februari')
            ->assertDontSee('Nota Agustus');
    }

    public function test_arsip_nota_filter_kategori_pengeluaran_menyembunyikan_uang_masuk(): void
    {
        UangMasuk::factory()->create([
            'tanggal' => '2026-03-10',
            'jumlah' => 5_000_000,
            'akun' => AkunKas::Bank,
            'bukti' => ['uang_masuk/nota-masuk.pdf'],
            'keterangan' => 'Termin Masuk PLN',
        ]);

        UangKeluar::factory()->create([
            'tanggal' => '2026-03-10',
            'jumlah' => 500_000,
            'akun' => AkunKas::Kas,
            'kategori' => KategoriPengeluaran::Material,
            'bukti' => ['uang_keluar/nota-material.pdf'],
            'keterangan' => 'Beli Kabel NYY',
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/panel/receipts?kategori=material')
            ->assertOk()
            ->assertSee('Beli Kabel NYY')
            ->assertDontSee('Termin Masuk PLN');
    }

    public function test_bundel_laporan_zip_bisa_diunduh(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/admin/laporan/bundel-zip?periode=12')
            ->assertOk()
            ->assertHeader('content-type', 'application/zip');
    }

    public function test_cetak_kuitansi_uang_masuk_pdf(): void
    {
        $mitra = Mitra::factory()->create(['nama' => 'PT Pelanggan Batam']);
        $spk = Spk::factory()->create([
            'mitra_id' => $mitra->id,
            'nomor_spk' => 'SPK-2026-TEST',
            'nama_pekerjaan' => 'Pengadaan Kabel BKS',
            'lokasi' => 'Batam Center',
            'nilai_spk' => 20_000_000,
        ]);
        $uangMasuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 5_000_000,
            'akun' => AkunKas::Bank,
            'keterangan' => 'Pembayaran Termin 1',
            'tanggal' => '2026-11-10',
        ]);

        $response = $this->actingAs($this->pengguna(Peran::Admin))
            ->get(route('panel.cash-in.kuitansi', $uangMasuk));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertNotEmpty($response->getContent());
    }

    public function test_api_termin_drawer_spk(): void
    {
        $spk = Spk::factory()->create(['nilai_spk' => 15_000_000]);
        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 5_000_000,
            'akun' => AkunKas::Bank,
        ]);

        $this->actingAs($this->pengguna(Peran::Direktur))
            ->get(route('panel.spk.termin-drawer', $spk))
            ->assertOk()
            ->assertJsonStructure([
                'nomor_spk',
                'pekerjaan',
                'nilai_spk',
                'total_masuk',
                'sisa_piutang',
                'transaksi',
            ]);
    }

    public function test_unduh_backup_bisa_oleh_admin_dan_direktur(): void
    {
        // Folder sementara: berkas uji tidak boleh nyasar ke backup sungguhan.
        $dir = sys_get_temp_dir().'/bks-unduh-uji-'.uniqid();
        File::ensureDirectoryExists($dir);
        config(['filesystems.backup_path' => $dir]);
        $nama = 'test-backup.zip';
        File::put($dir.'/'.$nama, 'dummy zip content');

        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $pengguna = $this->pengguna($peran);
            $this->actingAs($pengguna)
                ->get('/admin/backup/unduh/'.$nama)
                ->assertOk()
                ->assertHeader('content-type', 'application/zip');
        }

        // Penjagaan path traversal
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/admin/backup/unduh/../../etc/passwd')
            ->assertNotFound();

        File::deleteDirectory($dir);
    }
}
