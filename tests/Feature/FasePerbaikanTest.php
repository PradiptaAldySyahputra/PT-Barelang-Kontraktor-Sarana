<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Penjaga hasil eksekusi MASTER-PLAN (Fase 1 & 2).
 */
class FasePerbaikanTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    public function test_cek_server_memeriksa_optimasi_dan_lokasi_backup(): void
    {
        $this->artisan('bks:cek-server')
            ->expectsOutputToContain('Optimasi & Produksi')
            ->assertExitCode(0);
    }

    public function test_halaman_konsistensi_menampilkan_spk_kelebihan_bayar(): void
    {
        $spk = Spk::factory()->create([
            'nilai_spk' => 1_000_000,
            'status_spk' => StatusSpk::Berjalan,
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'tanggal' => now()->subDay()->toDateString(),
            'jumlah' => 1_500_000,
            'akun' => AkunKas::Kas,
            'keterangan' => 'Kelebihan bayar uji',
        ]);

        $this->actingAs($this->admin())
            ->get('/panel/laporan/konsistensi')
            ->assertOk()
            ->assertSee($spk->nomor_spk)
            ->assertSee('Uang masuk melebihi nilai SPK');
    }

    public function test_konsistensi_tanpa_temuan_menampilkan_pesan_aman(): void
    {
        Spk::factory()->create([
            'nilai_spk' => 2_000_000,
            'status_spk' => StatusSpk::Berjalan,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);

        $this->actingAs($this->direktur())
            ->get('/panel/laporan/konsistensi')
            ->assertOk()
            ->assertSee('Tidak ada ketidakcocokan');
    }

    public function test_daftar_sesi_aktif_hanya_untuk_direktur(): void
    {
        DB::table('sessions')->insert([
            'id' => 'sesi-uji-1',
            'user_id' => $this->direktur()->id,
            'ip_address' => '192.168.100.20',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0) Chrome/130.0',
            'payload' => '',
            'last_activity' => time(),
        ]);

        $this->actingAs($this->direktur())
            ->get('/panel/users/sesi')
            ->assertOk()
            ->assertSee('192.168.100.20')
            ->assertSee('Chrome di Windows');

        $this->actingAs($this->admin())
            ->get('/panel/users/sesi')
            ->assertForbidden();
    }

    public function test_direktur_dapat_memutus_sesi_lain(): void
    {
        DB::table('sessions')->insert([
            'id' => 'sesi-uji-2',
            'user_id' => $this->admin()->id,
            'ip_address' => '10.0.0.9',
            'user_agent' => 'Firefox/130 Linux',
            'payload' => '',
            'last_activity' => time(),
        ]);

        $this->actingAs($this->direktur())
            ->delete('/panel/users/sesi/sesi-uji-2')
            ->assertRedirect();

        $this->assertSame(0, DB::table('sessions')->where('id', 'sesi-uji-2')->count());
    }

    public function test_kalender_mendukung_filter_satu_tanggal(): void
    {
        $pada = Spk::factory()->create([
            'nama_pekerjaan' => 'Pekerjaan Tanggal Uji',
            'tanggal_akhir' => '2026-12-15',
            'status_spk' => StatusSpk::Berjalan,
        ]);

        Spk::factory()->create([
            'nama_pekerjaan' => 'Pekerjaan Hari Lain',
            'tanggal_akhir' => '2026-12-20',
            'status_spk' => StatusSpk::Berjalan,
        ]);

        $this->actingAs($this->admin())
            ->get('/panel/spk/calendar?tanggal=2026-12-15')
            ->assertOk()
            ->assertSee('Pekerjaan Tanggal Uji')
            ->assertDontSee('Pekerjaan Hari Lain');
    }

    public function test_perintah_verifikasi_backup_memeriksa_zip_terbaru(): void
    {
        $dir = storage_path('app/backup');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $nama = $dir.'/uji-verifikasi.zip';
        $zip = new \ZipArchive;
        $zip->open($nama, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFromString('bks.sql', '-- dump uji');
        $zip->close();

        $this->artisan('bks:backup', ['--verifikasi' => true])
            ->assertExitCode(0)
            ->expectsOutputToContain('utuh dan berisi dump SQL');

        @unlink($nama);
    }
}
