<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

class CekKesiapanServerTest extends TestCase
{
    use RefreshDatabase;

    public function test_perintah_bks_cek_server_berhasil_dijalankan_dan_menampilkan_tabel_serta_kesimpulan(): void
    {
        $this->artisan('bks:cek-server')
            ->expectsOutputToContain('DIAGNOSA KESIAPAN SERVER INTRANET BKS')
            ->expectsOutputToContain('Koneksi Database')
            ->expectsOutputToContain('Tabel Domain Utama')
            ->expectsOutputToContain('Direktori Nota')
            ->expectsOutputToContain('Direktori Backup')
            ->expectsOutputToContain('Symlink Storage')
            ->expectsOutputToContain('Tabel Antrean')
            ->expectsOutputToContain('Status Antrean')
            ->expectsOutputToContain('Versi PHP')
            ->expectsOutputToContain('KESIMPULAN: SERVER SIAP OPERASIONAL')
            ->assertExitCode(0);
    }

    public function test_perintah_bks_cek_server_opsi_json_mengembalikan_format_json_yang_valid(): void
    {
        $this->artisan('bks:cek-server', ['--json' => true])
            ->assertExitCode(0);

        // Ambil output langsung untuk memvalidasi struktur JSON
        $bufferedOutput = new BufferedOutput;
        Artisan::call('bks:cek-server', ['--json' => true], $bufferedOutput);
        $jsonString = $bufferedOutput->fetch();

        $this->assertJson($jsonString);

        $data = json_decode($jsonString, true);
        $this->assertArrayHasKey('waktu', $data);
        $this->assertArrayHasKey('siap_operasional', $data);
        $this->assertArrayHasKey('kesimpulan', $data);
        $this->assertArrayHasKey('hasil', $data);
        $this->assertTrue($data['siap_operasional']);
        $this->assertSame('SERVER SIAP OPERASIONAL', $data['kesimpulan']);

        $komponen = collect($data['hasil'])->pluck('komponen')->all();
        $this->assertContains('Koneksi Database', $komponen);
        $this->assertContains('Tabel Domain Utama', $komponen);
        $this->assertContains('Direktori Nota', $komponen);
        $this->assertContains('Direktori Backup', $komponen);
        $this->assertContains('Symlink Storage', $komponen);
        $this->assertContains('Tabel Antrean', $komponen);
        $this->assertContains('Ekstensi pdo_mysql', $komponen);
        $this->assertContains('Ekstensi zip', $komponen);
        $this->assertContains('Ekstensi mbstring', $komponen);
        $this->assertContains('Ekstensi Grafis (gd/imagick)', $komponen);
        $this->assertContains('Versi PHP', $komponen);
        $this->assertContains('Batas Memori (memory_limit)', $komponen);
    }

    public function test_perintah_bks_cek_server_gagal_jika_ada_tabel_domain_yang_hilang(): void
    {
        // Drop tabel child (uang_keluar) agar foreign key constraint tidak terlanggar
        Schema::dropIfExists('uang_keluar');

        $this->artisan('bks:cek-server')
            ->expectsOutputToContain('Tabel domain tidak ditemukan: uang_keluar')
            ->expectsOutputToContain('KESIMPULAN: SERVER BELUM SIAP OPERASIONAL')
            ->assertExitCode(1);
    }

    public function test_perintah_bks_cek_server_json_gagal_jika_ada_tabel_domain_yang_hilang(): void
    {
        // Drop tabel child (uang_masuk)
        Schema::dropIfExists('uang_masuk');

        $bufferedOutput = new BufferedOutput;
        $exitCode = Artisan::call('bks:cek-server', ['--json' => true], $bufferedOutput);
        $jsonString = $bufferedOutput->fetch();

        $this->assertSame(1, $exitCode);
        $data = json_decode($jsonString, true);
        $this->assertFalse($data['siap_operasional']);
        $this->assertSame('TERDAPAT KEGAGALAN KRITIS PADA SERVER', $data['kesimpulan']);

        $tabelCheck = collect($data['hasil'])->firstWhere('komponen', 'Tabel Domain Utama');
        $this->assertNotNull($tabelCheck);
        $this->assertSame('GAGAL', $tabelCheck['status']);
        $this->assertStringContainsString('uang_masuk', $tabelCheck['detail']);
    }

    public function test_perintah_bks_cek_server_gagal_jika_tabel_queue_hilang(): void
    {
        Schema::dropIfExists('jobs');

        $this->artisan('bks:cek-server')
            ->expectsOutputToContain('Tabel queue tidak ditemukan: jobs')
            ->expectsOutputToContain('KESIMPULAN: SERVER BELUM SIAP OPERASIONAL')
            ->assertExitCode(1);
    }

    public function test_perintah_bks_cek_server_gagal_jika_folder_nota_tidak_ada(): void
    {
        $folderFiktif = storage_path('app/nota_fiktif_'.uniqid());
        config(['filesystems.disks.nota.root' => $folderFiktif]);

        $this->artisan('bks:cek-server')
            ->expectsOutputToContain('Direktori storage/app/nota tidak ditemukan')
            ->expectsOutputToContain('KESIMPULAN: SERVER BELUM SIAP OPERASIONAL')
            ->assertExitCode(1);
    }
}
