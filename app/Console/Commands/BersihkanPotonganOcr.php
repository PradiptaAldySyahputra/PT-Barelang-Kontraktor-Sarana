<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\UangKeluar;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

/**
 * Bersihkan potongan nota hasil OCR yang sudah tidak dipakai.
 *
 * KENAPA PERINTAH INI ADA
 * -----------------------
 * Setiap kali OCR membaca satu berkas nota, ia menyimpan gambar potongan
 * (satu per nota) di `storage/app/public/uang_keluar/potongan/<hash>/`.
 *
 * Masalahnya: potongan TIDAK PERNAH dihapus. Terbukti di mesin pengembangan,
 * folder potongan mencapai 177 MB / 36 folder — sebagian besar sudah tidak
 * dipakai (berkas sumbernya sudah hilang). Kalau dibiarkan, disk server kantor
 * akan penuh dan aplikasi berhenti bisa menyimpan nota.
 *
 * CARA KERJA
 * ----------
 * Nama folder potongan = md5(path berkas sumber). Jadi kita bisa tahu folder
 * mana yang masih dipakai (ada berkas sumbernya) dan mana yang yatim
 * (berkas sumbernya sudah tidak ada) — lalu buang yang yatim saja.
 *
 * Pakai:
 *     php artisan ocr:bersihkan          # buang potongan yatim
 *     php artisan ocr:bersihkan --kering # hanya tampilkan, tidak menghapus
 *     php artisan ocr:bersihkan --semua  # buang SEMUA potongan (dibuat ulang
 *                                        # otomatis saat form dibuka lagi)
 */
class BersihkanPotonganOcr extends Command
{
    protected $signature = 'ocr:bersihkan
                            {--kering : Hanya tampilkan yang akan dibuang, jangan hapus}
                            {--tak-dipakai : Buang juga potongan berkas yang TIDAK dirujuk pengeluaran tersimpan}
                            {--semua : Buang SEMUA potongan (bukan hanya yang yatim)}';

    protected $description = 'Buang gambar potongan nota hasil OCR yang sudah tidak dipakai';

    private const FOLDER = 'uang_keluar/potongan';

    public function handle(): int
    {
        $disk = Storage::disk(config('filament.default_filesystem_disk', 'public'));

        if (! $disk->exists(self::FOLDER)) {
            $this->info('Tidak ada folder potongan — tidak ada yang perlu dibersihkan.');

            return self::SUCCESS;
        }

        $kering = (bool) $this->option('kering');
        $semua = (bool) $this->option('semua');
        $takDipakai = (bool) $this->option('tak-dipakai');

        // Kumpulkan berkas sumber yang masih ada (untuk tahu mana yang yatim).
        $sumberAda = $this->berkasSumberAda($disk);

        // Path berkas yang BENAR-BENAR dirujuk pengeluaran tersimpan.
        // Potongan untuk berkas yang tidak dirujuk = murni sisa (tidak akan
        // pernah tampil lagi), jadi paling aman dibuang.
        $dirujuk = $takDipakai || $semua ? $this->berkasDirujuk() : [];

        $folder = $disk->directories(self::FOLDER);
        $dibuang = 0;
        $disimpan = 0;
        $byteDibuang = 0;

        foreach ($folder as $dir) {
            $hash = basename($dir);

            $masihAdaSumber = in_array($hash, $sumberAda, true);
            $masihDirujuk = in_array($hash, $dirujuk, true);

            // Aturan simpan:
            //   - default      : simpan kalau berkas sumbernya masih ada
            //   - --tak-dipakai: simpan HANYA kalau dirujuk pengeluaran tersimpan
            //   - --semua      : tidak menyimpan apa pun
            $simpan = match (true) {
                $semua => false,
                $takDipakai => $masihDirujuk,
                default => $masihAdaSumber,
            };

            if ($simpan) {
                $disimpan++;

                continue;
            }

            foreach ($disk->files($dir) as $file) {
                $byteDibuang += (int) $disk->size($file);

                if (! $kering) {
                    $disk->delete($file);
                }

                $dibuang++;
            }

            if (! $kering) {
                $disk->deleteDirectory($dir);
            }
        }

        $mb = round($byteDibuang / 1024 / 1024, 1);

        if ($kering) {
            $this->warn("[KERING] Akan dibuang: {$dibuang} potongan ({$mb} MB). Disimpan: {$disimpan} folder.");
            $this->line('Jalankan tanpa --kering untuk benar-benar menghapus.');
        } else {
            $this->info("Dibuang: {$dibuang} potongan ({$mb} MB). Disimpan: {$disimpan} folder yang masih dipakai.");
        }

        return self::SUCCESS;
    }

    /**
     * Daftar md5(path) untuk semua berkas sumber yang masih ada.
     *
     * @return array<int, string>
     */
    private function berkasSumberAda(FilesystemAdapter $disk): array
    {
        $hash = [];

        foreach ($disk->files('uang_keluar') as $file) {
            // Lewati folder potongan itu sendiri.
            if (str_starts_with($file, self::FOLDER.'/')) {
                continue;
            }

            $hash[] = md5($file);
        }

        return $hash;
    }

    /**
     * Daftar md5(path) untuk berkas yang dirujuk pengeluaran TERSIMPAN.
     *
     * Potongan untuk berkas di luar daftar ini tidak akan pernah tampil lagi,
     * jadi aman dibuang.
     *
     * @return array<int, string>
     */
    private function berkasDirujuk(): array
    {
        $hash = [];

        foreach (UangKeluar::query()->get(['bukti']) as $record) {
            foreach ((array) ($record->bukti ?? []) as $path) {
                if (is_string($path) && filled($path)) {
                    $hash[] = md5($path);
                }
            }
        }

        return array_values(array_unique($hash));
    }
}
