<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

/**
 * Bersihkan nota yang TIDAK PERNAH DISIMPAN, beserta potongan OCR-nya.
 *
 * KENAPA PERINTAH INI ADA
 * Form Unggah Nota menyimpan berkas ke disk SAAT DIUNGGAH (dibutuhkan worker
 * OCR yang berjalan di latar belakang). Kalau admin batal, menutup tab, atau
 * mengganti berkas, berkas itu tidak pernah tercatat di database - tapi tetap
 * menumpuk di disk. Terbukti di mesin pengembangan: 1,3 GB / 1.837 berkas,
 * sementara yang benar-benar dirujuk transaksi hanya puluhan.
 *
 * ATURAN
 * Database adalah sumber kebenaran: berkas yang TIDAK dirujuk kolom
 * `uang_keluar.bukti`, `uang_masuk.bukti`, `spk.dokumen`, atau
 * `pengguna.tanda_tangan` (termasuk data soft delete) dibuang setelah
 * melewati masa tenggang.
 *
 * Masa tenggang (bawaan 24 jam) melindungi unggahan yang sedang diisi:
 * berkas baru belum punya rujukan sampai admin menekan Simpan.
 *
 * Pakai:
 *     php artisan ocr:bersihkan              # buang yang yatim & lebih tua dari 24 jam
 *     php artisan ocr:bersihkan --kering     # hanya tampilkan, tidak menghapus
 *     php artisan ocr:bersihkan --umur=2     # masa tenggang 2 jam
 *     php artisan ocr:bersihkan --semua       # buang SEMUA potongan OCR
 */
class BersihkanPotonganOcr extends Command
{
    protected $signature = 'ocr:bersihkan
                            {--kering : Hanya tampilkan yang akan dibuang, jangan hapus}
                            {--umur=24 : Masa tenggang (jam) sebelum berkas yatim dibuang}
                            {--semua : Buang SEMUA potongan OCR (dibuat ulang saat form dibuka lagi)}';

    protected $description = 'Buang nota yatim (tidak tersimpan di database) dan potongan OCR yang menumpuk';

    /** Folder transaksi yang disapu. */
    private const FOLDER = ['uang_keluar', 'uang_masuk'];

    private const FOLDER_POTONGAN = 'uang_keluar/potongan';

    public function handle(): int
    {
        // ⚠️ Berkas nota ada di disk PRIVAT `nota` (lihat PembacaNota), BUKAN
        // disk `public`. Dulu perintah ini membaca disk `public` sehingga tidak
        // pernah menemukan apa pun.
        $disk = Storage::disk('nota');

        $kering = (bool) $this->option('kering');
        $semua = (bool) $this->option('semua');
        $batas = now()->subHours(max(0, (int) $this->option('umur')))->getTimestamp();

        $dirujuk = $this->pathDirujuk();

        $dibuang = 0;
        $byteDibuang = 0;
        $disimpan = 0;

        foreach (self::FOLDER as $folder) {
            if (! $disk->exists($folder)) {
                continue;
            }

            foreach ($disk->allFiles($folder) as $file) {
                $potongan = str_starts_with($file, self::FOLDER_POTONGAN.'/');

                if ($potongan && $semua) {
                    // Potongan selalu bisa dibuat ulang saat form dibuka lagi.
                    $buang = true;
                } elseif (isset($dirujuk[$file])) {
                    $disimpan++;

                    continue;
                } else {
                    // Berkas baru (belum disimpan) masih muda: beri kesempatan
                    // admin menyelesaikan isian sebelum disapu.
                    $buang = $disk->lastModified($file) < $batas;
                }

                if (! $buang) {
                    $disimpan++;

                    continue;
                }

                $byteDibuang += (int) $disk->size($file);

                if (! $kering) {
                    $disk->delete($file);
                }

                $dibuang++;
            }
        }

        if (! $kering) {
            $this->hapusFolderKosong($disk);
        }

        $mb = round($byteDibuang / 1024 / 1024, 1);

        if ($kering) {
            $this->warn("[KERING] Akan dibuang: {$dibuang} berkas ({$mb} MB). Disimpan: {$disimpan} berkas.");
            $this->line('Jalankan tanpa --kering untuk benar-benar menghapus.');
        } else {
            $this->info("Dibuang: {$dibuang} berkas ({$mb} MB). Disimpan: {$disimpan} berkas yang masih dirujuk.");
        }

        return self::SUCCESS;
    }

    /**
     * Semua path berkas yang dirujuk database (termasuk data soft delete).
     *
     * @return array<string, true>
     */
    private function pathDirujuk(): array
    {
        $dirujuk = [];

        $tambah = function (mixed $nilai) use (&$dirujuk): void {
            foreach (is_array($nilai) ? $nilai : [$nilai] as $path) {
                if (is_string($path) && $path !== '') {
                    $dirujuk[str_replace('\\', '/', ltrim($path, '/'))] = true;
                }
            }
        };

        foreach (UangKeluar::withTrashed()->get(['bukti']) as $record) {
            $tambah($record->bukti);
        }

        foreach (UangMasuk::withTrashed()->get(['bukti']) as $record) {
            $tambah($record->bukti);
        }

        foreach (Spk::withTrashed()->get(['dokumen']) as $record) {
            $tambah($record->dokumen);
        }

        foreach (Pengguna::query()->get(['tanda_tangan']) as $record) {
            $tambah($record->tanda_tangan);
        }

        return $dirujuk;
    }

    /**
     * Buang folder bertanggal yang kini kosong.
     */
    private function hapusFolderKosong(FilesystemAdapter $disk): void
    {
        foreach (self::FOLDER as $folder) {
            if (! $disk->exists($folder)) {
                continue;
            }

            // Terdalam dulu supaya induk ikut terhapus bila kosong.
            $daftar = collect($disk->directories($folder))
                ->flatMap(fn (string $dir): array => $this->semuaSubfolder($disk, $dir))
                ->sortByDesc(fn (string $dir): int => substr_count($dir, '/'));

            foreach ($daftar as $dir) {
                if ($disk->files($dir) === [] && $disk->directories($dir) === []) {
                    $disk->deleteDirectory($dir);
                }
            }
        }
    }

    /**
     * @return array<int, string>
     */
    private function semuaSubfolder(FilesystemAdapter $disk, string $folder): array
    {
        $hasil = [$folder];

        foreach ($disk->directories($folder) as $sub) {
            $hasil = [...$hasil, ...$this->semuaSubfolder($disk, $sub)];
        }

        return $hasil;
    }
}
