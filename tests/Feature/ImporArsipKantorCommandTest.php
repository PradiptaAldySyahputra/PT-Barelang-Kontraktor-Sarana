<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Console\Commands\ImporArsipKantor;
use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Tests\TestCase;

class ImporArsipKantorCommandTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Mitra $mitraPln;

    private string $tempFilePath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->create([
            'peran' => Peran::Admin,
        ]);

        $this->mitraPln = Mitra::factory()->pln()->create([
            'nama' => 'PT PLN Batam',
        ]);

        $this->tempFilePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_arsip_spk_'.uniqid().'.xlsx';
    }

    protected function tearDown(): void
    {
        if (is_file($this->tempFilePath)) {
            @unlink($this->tempFilePath);
        }

        parent::tearDown();
    }

    public function test_file_tidak_ditemukan_melempar_error_atau_exit_code_failure(): void
    {
        $pathPalsu = '/tmp/berkas_spk_tidak_akan_pernah_ada_'.uniqid().'.xlsx';

        $this->artisan('bks:impor-arsip', ['berkas' => $pathPalsu])
            ->expectsOutputToContain('Berkas arsip tidak ditemukan')
            ->assertExitCode(1);
    }

    public function test_opsi_dry_run_tidak_menambah_data_ke_tabel_spk(): void
    {
        $this->buatFileExcel([
            ['0001.SPK/DAN.01.03/PLNBATAM020300/2026', '2026-01-05', 'Pekerjaan Jaringan Dry Run', '25000000'],
            ['0002.SPK/DAN.01.03/PLNBATAM020300/2026', '2026-01-06', 'Pekerjaan Gardu Dry Run', '50000000'],
        ]);

        $jumlahAwal = Spk::count();

        $this->artisan('bks:impor-arsip', [
            'berkas' => $this->tempFilePath,
            '--dry-run' => true,
        ])
            ->expectsOutputToContain('=== MODE SIMULASI (DRY-RUN) ===')
            ->expectsOutputToContain('Total baris terbaca: 2')
            ->expectsOutputToContain('0001.SPK/DAN.01.03/PLNBATAM020300/2026')
            ->expectsOutputToContain('Simulasi selesai. Berkas siap diimpor ke sistem BKS.')
            ->assertSuccessful();

        $this->assertSame($jumlahAwal, Spk::count());
    }

    public function test_impor_data_valid_menambah_baris_ke_tabel_spk(): void
    {
        $this->buatFileExcel([
            ['0005.SPK/DAN.01.03/PLNBATAM020300/2026', '2026-01-10', 'Pengadaan Trafo 100kVA', '75000000'],
        ]);

        $this->artisan('bks:impor-arsip', [
            'berkas' => $this->tempFilePath,
            '--force' => true,
        ])
            ->expectsOutputToContain('Memulai impor transaksi SPK...')
            ->expectsOutputToContain('Proses impor selesai.')
            ->assertSuccessful();

        $this->assertDatabaseHas('spk', [
            'nomor_spk' => '0005.SPK/DAN.01.03/PLNBATAM020300/2026',
            'nama_pekerjaan' => 'Pengadaan Trafo 100kVA',
            'nilai_spk' => '75000000.00',
        ]);
    }

    public function test_impor_ulang_dengan_berkas_sama_menandai_baris_sebagai_dilewati(): void
    {
        $this->buatFileExcel([
            ['0006.SPK/DAN.01.03/PLNBATAM020300/2026', '2026-01-12', 'Pemasangan Tiang Beton', '30000000'],
        ]);

        // Eksekusi pertama: berhasil menambah
        $this->artisan('bks:impor-arsip', [
            'berkas' => $this->tempFilePath,
            '--force' => true,
        ])->assertSuccessful();

        $this->assertSame(1, Spk::where('nomor_spk', '0006.SPK/DAN.01.03/PLNBATAM020300/2026')->count());

        // Eksekusi kedua: harus dilewati (duplikat)
        $this->artisan('bks:impor-arsip', [
            'berkas' => $this->tempFilePath,
            '--force' => true,
        ])
            ->expectsTable(
                ['Status', 'Jumlah Baris'],
                [
                    ['Ditambah', '0'],
                    ['Dilewati (Duplikat)', '1'],
                    ['Gagal', '0'],
                ]
            )
            ->assertSuccessful();

        $this->assertSame(1, Spk::where('nomor_spk', '0006.SPK/DAN.01.03/PLNBATAM020300/2026')->count());
    }

    public function test_impor_arsip_fallback_ke_file_default_jika_ada(): void
    {
        if (! is_file(ImporArsipKantor::DEFAULT_FILE)) {
            $this->markTestSkipped('File arsip kantor default tidak ada di path host pengujian.');
        }

        // Uji eksekusi tanpa argumen dengan --dry-run
        $this->artisan('bks:impor-arsip', ['--dry-run' => true])
            ->expectsOutputToContain('Menggunakan berkas arsip default: '.ImporArsipKantor::DEFAULT_FILE)
            ->expectsOutputToContain('=== MODE SIMULASI (DRY-RUN) ===')
            ->assertSuccessful();
    }

    /**
     * Helper untuk membuat file Excel sederhana dengan header standar BKS
     *
     * @param  list<array{0: string, 1: string, 2: string, 3: string}>  $data
     */
    private function buatFileExcel(array $data): void
    {
        $writer = new Writer;
        $writer->openToFile($this->tempFilePath);

        // Header
        $writer->addRow(Row::fromValues([
            'nomor_spk',
            'tanggal_spk',
            'nama_pekerjaan',
            'nilai_spk',
        ]));

        foreach ($data as $baris) {
            $writer->addRow(Row::fromValues($baris));
        }

        $writer->close();
    }
}
