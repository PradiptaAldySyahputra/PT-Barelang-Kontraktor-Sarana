<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Spk;
use App\Support\Format;
use App\Support\ImporTransaksi;
use App\Support\PembacaImpor;
use Illuminate\Console\Command;

/**
 * Perintah Artisan Onboarding Impor Arsip Excel Kantor ke Database BKS.
 *
 * Mendukung dry-run untuk menghitung baris & estimasi duplikat tanpa menyimpan.
 */
class ImporArsipKantor extends Command
{
    public const DEFAULT_FILE = '/home/pradipta/Project/BKS-Data-Perusahaan/dokumen/LIST SPK 2026.xlsx';

    protected $signature = 'bks:impor-arsip
                            {berkas? : Path absolut atau relatif ke berkas Excel arsip SPK}
                            {--dry-run : Simulasi baca dan hitung tanpa menyimpan ke database}
                            {--force : Jalankan impor tanpa dialog konfirmasi}';

    protected $description = 'Onboarding data riil dari arsip Excel kantor ke database sistem BKS';

    public function handle(): int
    {
        $pathInput = $this->argument('berkas');

        if (blank($pathInput)) {
            if (is_file(self::DEFAULT_FILE)) {
                $path = self::DEFAULT_FILE;
                $this->info('Menggunakan berkas arsip default: '.$path);
            } else {
                $pathInput = $this->ask('Masukkan path ke berkas Excel arsip SPK');
                $path = $this->selesaikanPath((string) $pathInput);
            }
        } else {
            $path = $this->selesaikanPath((string) $pathInput);
        }

        if (blank($path) || ! is_file($path)) {
            $this->error('Berkas arsip tidak ditemukan: '.($path ?: '(kosong)'));

            return self::FAILURE;
        }

        $this->info('Membaca berkas: '.$path);

        try {
            $baris = PembacaImpor::baca($path);
        } catch (\Throwable $e) {
            $this->error('Gagal membaca berkas Excel: '.$e->getMessage());

            return self::FAILURE;
        }

        $totalBaris = count($baris);
        $this->line("Ditemukan <info>{$totalBaris}</info> baris data.");

        if ($totalBaris === 0) {
            $this->warn('Tidak ada data baris yang valid untuk diimpor.');

            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->jalankanDryRun($baris);

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("Apakah Anda yakin ingin mengimpor {$totalBaris} baris data ke database?")) {
            $this->info('Impor dibatalkan oleh pengguna.');

            return self::SUCCESS;
        }

        $this->info('Memulai impor transaksi SPK...');
        $hasil = ImporTransaksi::spk($baris, cegahDuplikat: true);

        $this->table(
            ['Status', 'Jumlah Baris'],
            [
                ['Ditambah', $hasil['ditambah']],
                ['Dilewati (Duplikat)', $hasil['dilewati']],
                ['Gagal', count($hasil['gagal'])],
            ]
        );

        if (! empty($hasil['gagal'])) {
            $this->newLine();
            $this->error('Daftar baris yang gagal diimpor:');
            foreach ($hasil['gagal'] as $alasan) {
                $this->line(" - <fg=red>{$alasan}</>");
            }
        }

        $this->info('Proses impor selesai.');

        return self::SUCCESS;
    }

    /**
     * @param  list<array<string, mixed>>  $baris
     */
    private function jalankanDryRun(array $baris): void
    {
        $this->info('=== MODE SIMULASI (DRY-RUN) ===');
        $this->line('Total baris terbaca: <info>'.count($baris).'</info>');

        // Tampilkan sampel 5 baris pertama
        $sampel = array_slice($baris, 0, 5);
        $tabelSampel = [];

        foreach ($sampel as $i => $b) {
            $tabelSampel[] = [
                'No' => $i + 1,
                'Nomor SPK' => (string) ($b['nomor_spk'] ?? '-'),
                'Tanggal SPK' => (string) ($b['tanggal_spk'] ?? $b['tanggal'] ?? '-'),
                'Nama Pekerjaan' => (string) ($b['nama_pekerjaan'] ?? '-'),
                'Nilai SPK' => isset($b['nilai_spk']) || isset($b['jumlah'])
                    ? Format::rupiah((float) ($b['nilai_spk'] ?? $b['jumlah'] ?? 0))
                    : '-',
            ];
        }

        $this->newLine();
        $this->line('<comment>Sampel 5 Baris Pertama:</comment>');
        $this->table(['No', 'Nomor SPK', 'Tanggal SPK', 'Nama Pekerjaan', 'Nilai SPK'], $tabelSampel);

        // Hitung estimasi duplikat vs baris baru tanpa menyimpan
        $spkAda = [];
        foreach (Spk::withTrashed()->pluck('nomor_spk') as $n) {
            $spkAda[mb_strtolower(trim((string) $n))] = true;
        }

        $tanpaSpkAset = [];
        foreach (Spk::withTrashed()->where('nomor_spk', 'like', 'TANPA-SPK-%')->get(['nama_pekerjaan', 'nilai_spk']) as $s) {
            $kunci = mb_strtolower(trim($s->nama_pekerjaan)).'|'.number_format((float) $s->nilai_spk, 2, '.', '');
            $tanpaSpkAset[$kunci] = true;
        }

        $estimasiBaru = 0;
        $estimasiDuplikat = 0;
        $estimasiTidakValid = 0;

        foreach ($baris as $b) {
            $namaPekerjaan = trim((string) ($b['nama_pekerjaan'] ?? ''));
            if ($namaPekerjaan === '') {
                $estimasiTidakValid++;

                continue;
            }

            $rawNomor = trim((string) ($b['nomor_spk'] ?? ''));
            $isTanpaSpk = $rawNomor === '' || strtoupper($rawNomor) === 'TANPA SPK';

            $nilaiRaw = $b['jumlah'] ?? $b['nilai_spk'] ?? 0;
            $nilai = ImporTransaksi::jumlah($nilaiRaw) ?? 0.0;

            if ($isTanpaSpk) {
                $kunciTanpaSpk = mb_strtolower($namaPekerjaan).'|'.number_format($nilai, 2, '.', '');
                if (isset($tanpaSpkAset[$kunciTanpaSpk])) {
                    $estimasiDuplikat++;
                } else {
                    $estimasiBaru++;
                    // Simulasikan penambahan agar duplikat internal terdeteksi
                    $tanpaSpkAset[$kunciTanpaSpk] = true;
                }
            } else {
                $kunciSpk = mb_strtolower($rawNomor);
                if (isset($spkAda[$kunciSpk])) {
                    $estimasiDuplikat++;
                } else {
                    $estimasiBaru++;
                    // Simulasikan penambahan agar duplikat internal terdeteksi
                    $spkAda[$kunciSpk] = true;
                }
            }
        }

        $this->newLine();
        $this->table(
            ['Estimasi Kategori', 'Jumlah Baris'],
            [
                ['Estimasi Baris Baru', $estimasiBaru],
                ['Estimasi Duplikat (Akan Dilewati)', $estimasiDuplikat],
                ['Estimasi Tidak Valid (Tanpa Pekerjaan)', $estimasiTidakValid],
            ]
        );

        $this->newLine();
        $this->info('Simulasi selesai. Berkas siap diimpor ke sistem BKS.');
    }

    private function selesaikanPath(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '';
        }

        if (str_starts_with($path, '/') || (DIRECTORY_SEPARATOR === '\\' && preg_match('/^[a-zA-Z]:\\\\/', $path))) {
            return $path;
        }

        return base_path($path);
    }
}
