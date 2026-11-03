<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
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

    /* =====================================================
       Hak akses per halaman
       ===================================================== */

    public function test_halaman_bersama_boleh_dibuka_kedua_peran(): void
    {
        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $pengguna = $this->pengguna($peran);

            $this->actingAs($pengguna)->get('/panel/receipts')->assertOk();
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

    public function test_bundel_laporan_zip_bisa_diunduh(): void
    {
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/admin/laporan/bundel-zip?periode=12')
            ->assertOk()
            ->assertHeader('content-type', 'application/zip');
    }

    public function test_cetak_kuitansi_uang_masuk_pdf(): void
    {
        $mitra = \App\Models\Mitra::factory()->create();
        $spk = \App\Models\Spk::factory()->create(['mitra_id' => $mitra->id, 'nilai_spk' => 20_000_000]);
        $uangMasuk = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 5_000_000,
            'akun' => AkunKas::Bank,
            'keterangan' => 'Pembayaran Termin 1',
        ]);

        $this->actingAs($this->pengguna(Peran::Admin))
            ->get(route('panel.cash-in.kuitansi', $uangMasuk))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_api_termin_drawer_spk(): void
    {
        $spk = \App\Models\Spk::factory()->create(['nilai_spk' => 15_000_000]);
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
        $dir = storage_path('app/backup');
        \Illuminate\Support\Facades\File::ensureDirectoryExists($dir);
        $nama = 'test-backup.zip';
        \Illuminate\Support\Facades\File::put($dir . '/' . $nama, 'dummy zip content');

        foreach ([Peran::Admin, Peran::Direktur] as $peran) {
            $pengguna = $this->pengguna($peran);
            $this->actingAs($pengguna)
                ->get('/admin/backup/unduh/' . $nama)
                ->assertOk()
                ->assertHeader('content-type', 'application/zip');
        }

        // Penjagaan path traversal
        $this->actingAs($this->pengguna(Peran::Admin))
            ->get('/admin/backup/unduh/../../etc/passwd')
            ->assertNotFound();
    }
}