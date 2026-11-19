<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Console\Commands\BackupDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

/**
 * BACKUP DATABASE - fitur KRITIKAL (data keuangan perusahaan).
 *
 * ⚠️ KENAPA DIUJI:
 * `bks:backup` dijadwalkan harian (routes/console.php) dan menyimpan data
 * keuangan perusahaan. Sebelumnya TIDAK ADA tes sama sekali - kalau rusak
 * diam-diam, data tak ter-backup dan baru ketahuan saat butuh restore.
 *
 * ⚠️ CARA UJI (tanpa mysqldump nyata):
 * Perintah ini memanggil binary `mysqldump`. Di lingkungan tes, binary itu
 * mungkin tak ada. Jadi kita MEMALSUKAN `Process` (facade) supaya mengembalikan
 * dump palsu - tujuannya menguji LOGIKA kita sendiri:
 *   1. berkas .sql.gz terbentuk & isinya benar (hasil gunzip = dump),
 *   2. retensi `--hari` menghapus berkas lama,
 *   3. `--simpan` tetap menyimpan meski dump gagal.
 *
 * CATATAN: File ini sengaja TANPA RefreshDatabase/DatabaseTransactions.
 * Bersifat READ-ONLY terhadap database. Jika test di sini mulai menulis
 * DB (factory->create / post / update), WAJIB tambah trait refresh agar
 * data tidak bocor antar-test (order-dependency).
 */
class BackupDatabaseTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();

        // Folder SEMENTARA, bukan storage/app/backup: tes tidak boleh
        // menyentuh (apalagi menghapus) backup sungguhan di server.
        $this->dir = sys_get_temp_dir().'/bks-backup-uji-'.uniqid();
        File::ensureDirectoryExists($this->dir);
        config(['filesystems.backup_path' => $this->dir]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->dir);

        parent::tearDown();
    }

    public function test_backup_membuat_berkas_zip_yang_benar(): void
    {
        $dump = "-- dump palsu\nCREATE TABLE spk (id INT);\n";

        Process::fake([
            '*' => Process::result(output: $dump, exitCode: 0),
        ]);

        $this->artisan('bks:backup')->assertSuccessful();

        $berkas = File::files($this->dir);
        $this->assertCount(1, $berkas, 'Harus ada tepat satu berkas backup.');

        // ⚠️ Berkas harus .zip (bukan .sql.gz) agar bisa dibuka di Windows
        // tanpa WinRAR. Isi .sql di dalamnya harus sama dengan hasil dump.
        $this->assertSame('zip', strtolower($berkas[0]->getExtension()), 'Backup harus berformat .zip.');

        $zip = new \ZipArchive;
        $this->assertTrue($zip->open($berkas[0]->getPathname()) === true, 'Berkas backup harus ZIP yang valid.');
        $this->assertSame(1, $zip->numFiles, 'ZIP backup harus berisi tepat satu berkas.');
        $this->assertSame($dump, $zip->getFromIndex(0), 'Isi .sql harus sama dengan hasil dump.');
        $zip->close();
    }

    public function test_backup_dengan_nota_memaketkan_folder_nota(): void
    {
        $dump = "-- dump palsu\nCREATE TABLE spk (id INT);\n";

        Process::fake([
            '*' => Process::result(output: $dump, exitCode: 0),
        ]);

        $folderNota = $this->dir.'/nota-uji';
        File::ensureDirectoryExists($folderNota);
        File::put($folderNota.'/kw-001.jpg', 'gambar-nota-1');
        File::put($folderNota.'/kw-002.pdf', 'pdf-nota-2');

        config(['filesystems.disks.nota.root' => $folderNota]);

        $this->artisan('bks:backup', ['--dengan-nota' => true])->assertSuccessful();

        $berkas = File::files($this->dir);
        // Folder nota-uji bukan berkas jadi File::files hanya mengambil berkas ZIP
        $zipFiles = array_values(array_filter($berkas, fn ($f) => $f->getExtension() === 'zip'));
        $this->assertCount(1, $zipFiles);

        $zip = new \ZipArchive;
        $this->assertTrue($zip->open($zipFiles[0]->getPathname()) === true);

        // Harus ada file .sql dan file nota
        $this->assertNotNull($zip->locateName('nota/kw-001.jpg'));
        $this->assertNotNull($zip->locateName('nota/kw-002.pdf'));
        $this->assertSame('gambar-nota-1', $zip->getFromName('nota/kw-001.jpg'));
        $this->assertSame('pdf-nota-2', $zip->getFromName('nota/kw-002.pdf'));
        $zip->close();
    }

    public function test_retensi_menghapus_backup_lama(): void
    {
        Process::fake([
            '*' => Process::result(output: "-- dump\n", exitCode: 0),
        ]);

        // Buat berkas "lama" (mtime 40 hari lalu) + berkas "baru".
        // Dua-duanya .zip (format baru); retensi juga harus mendukung .gz lama.
        $lama = $this->dir.'/bks-lama.zip';
        File::put($lama, 'lama');
        touch($lama, now()->subDays(40)->getTimestamp());

        $lamaGz = $this->dir.'/bks-lama-lagi.sql.gz';
        File::put($lamaGz, gzencode('lama', 9));
        touch($lamaGz, now()->subDays(40)->getTimestamp());

        $baru = $this->dir.'/bks-baru.zip';
        File::put($baru, 'baru');

        $this->artisan('bks:backup', ['--hari' => 30])->assertSuccessful();

        $this->assertFileDoesNotExist($lama, 'Backup > 30 hari harus dihapus.');
        $this->assertFileDoesNotExist($lamaGz, 'Backup .sql.gz lama juga harus ikut dihapus.');
        $this->assertFileExists($baru, 'Backup baru tidak boleh ikut terhapus.');
    }

    public function test_simpan_menyimpan_meski_dump_gagal(): void
    {
        Process::fake([
            '*' => Process::result(output: '', errorOutput: 'mysqldump: not found', exitCode: 1),
        ]);

        // Tanpa --simpan → GAGAL.
        $this->artisan('bks:backup')->assertFailed();

        // Dengan --simpan → tetap SUCCESS (untuk uji di lingkungan tanpa mysqldump).
        $this->artisan('bks:backup', ['--simpan' => true])->assertSuccessful();
    }

    public function test_perintah_terdaftar(): void
    {
        $this->assertTrue(
            class_exists(BackupDatabase::class),
            'Perintah bks:backup harus ada.',
        );

        $this->artisan('list')
            ->expectsOutputToContain('bks:backup');
    }
}
