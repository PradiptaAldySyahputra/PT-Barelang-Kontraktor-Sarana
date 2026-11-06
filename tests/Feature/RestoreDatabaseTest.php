<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;
use Tests\TestCase;

class RestoreDatabaseTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();
        // Folder sementara: tes tidak boleh menghapus backup sungguhan.
        $this->dir = sys_get_temp_dir().'/bks-restore-uji-'.uniqid();
        File::ensureDirectoryExists($this->dir);
        config(['filesystems.backup_path' => $this->dir]);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->dir);
        parent::tearDown();
    }

    public function test_restore_gagal_bila_berkas_tidak_ada(): void
    {
        $this->artisan('bks:restore', ['berkas' => 'tidak-ada.zip', '--force' => true])
            ->assertFailed();
    }

    public function test_restore_berhasil_memanggil_mysql_dengan_input_sql(): void
    {
        $namaZip = 'test-restore.zip';
        $pathZip = $this->dir.'/'.$namaZip;

        $zip = new \ZipArchive;
        $zip->open($pathZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFromString('backup.sql', '-- DUMP RESTORE TEST');
        $zip->close();

        Process::fake([
            '*' => Process::result(output: '', exitCode: 0),
        ]);

        $this->artisan('bks:restore', ['berkas' => $namaZip, '--force' => true])
            ->assertSuccessful();

        Process::assertRan(function (PendingProcess $process) {
            $cmd = is_array($process->command) ? implode(' ', $process->command) : (string) $process->command;

            return str_contains($cmd, 'mysql');
        });
    }
}
