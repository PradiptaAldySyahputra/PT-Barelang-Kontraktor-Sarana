<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\PembacaIsiNota;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Pembaca nota — pembungkus skrip Python `python/ocr_nota.py`.
 *
 * KENAPA DIPISAH KE SERVICE
 * -------------------------
 * Memanggil proses Python langsung dari komponen Filament akan membuat kode
 * form sulit diuji dan rawan crash. Service ini jadi satu-satunya tempat yang
 * tahu cara memanggil OCR, sehingga:
 *   - form cukup memanggil `baca()` dan menerima hasil yang sudah rapi;
 *   - kalau OCR mati/error, form tetap jalan (fallback jumlah nota manual).
 *
 * PRINSIP PENTING
 * ---------------
 * 1. OCR ini BANTUAN, bukan penentu. Kalau gagal, sistem TIDAK boleh ikut
 *    gagal — admin tetap bisa mengisi jumlah nota manual seperti sebelumnya.
 * 2. OCR HANYA mendeteksi jumlah & posisi nota. Nominal rupiah TIDAK dibaca
 *    otomatis — itu tetap diisi admin (lihat catatan di skrip Python).
 */
class PembacaNota
{
    /**
     * Baca satu berkas nota.
     *
     * @param  string  $pathRelatif  Path relatif di disk (mis. "uang_keluar/x.pdf").
     * @return array{
     *     ok: bool,
     *     jumlah_nota: int,
     *     metode: string,
     *     potongan: array<int, string>,
     *     alasan?: string
     * }
     */
    public function baca(string $pathRelatif, string $disk = 'nota'): array
    {
        $gagal = [
            'ok' => false,
            'jumlah_nota' => 1,
            'metode' => 'gagal',
            'potongan' => [],
        ];

        if (! $this->aktif()) {
            return $gagal + ['alasan' => 'OCR tidak diaktifkan'];
        }

        if (blank($pathRelatif)) {
            return $gagal + ['alasan' => 'Path berkas kosong'];
        }

        $storage = Storage::disk($disk);

        if (! $storage->exists($pathRelatif)) {
            return $gagal + ['alasan' => 'Berkas tidak ditemukan di storage'];
        }

        /*
         * ⚠️ CACHE HASIL OCR — permintaan pengguna: "jangan buat aplikasi berat".
         *
         * Sebelumnya hasil OCR tidak disimpan, jadi setiap form dibuka/diperbarui
         * (Livewire memanggil ulang berkas yang sama) proses Python jalan lagi:
         *     4 nota  → ~1,7 detik
         *     57 nota → ~38 detik
         *
         * Nama berkas sudah DETERMINISTIK (dari isi berkas), jadi kunci cache
         * dari path aman: berkas yang sama selalu menghasilkan hasil yang sama.
         *
         * Hasil GAGAL juga di-cache supaya berkas rusak tidak di-OCR berulang
         * (yang justru paling membuang waktu).
         */
        $kunci = 'ocr:nota:'.md5($pathRelatif);

        $tersimpan = Cache::get($kunci);

        if (is_array($tersimpan)) {
            return $tersimpan;
        }

        $pathPenuh = $storage->path($pathRelatif);

        // Folder potongan: di dalam storage supaya bisa ditampilkan di form.
        $dirRelatif = 'uang_keluar/potongan/'.md5($pathRelatif);
        $dirPenuh = $storage->path($dirRelatif);

        try {
            $hasil = $this->jalankan($pathPenuh, $dirPenuh);
        } catch (Throwable $e) {
            Log::warning('OCR nota gagal', [
                'path' => $pathRelatif,
                'error' => $e->getMessage(),
            ]);

            $gagal += ['alasan' => 'OCR error: '.$e->getMessage()];

            // Jangan cache kegagalan SEMENTARA (mis. proses dimatikan timeout,
            // Python belum terpasang) — berkas bisa berhasil di percobaan lain.
            return $gagal;
        }

        if (! ($hasil['ok'] ?? false)) {
            $gagal += ['alasan' => (string) ($hasil['alasan'] ?? 'Tidak diketahui')];

            // Kegagalan yang DILAPORKAN skrip (mis. berkas tidak bisa dibaca)
            // bersifat tetap untuk berkas itu → aman di-cache.
            Cache::put($kunci, $gagal, now()->addDays(7));

            return $gagal;
        }

        // Ubah path potongan (absolut) jadi path relatif storage, supaya bisa
        // dipakai Storage::url() saat ditampilkan.
        //
        // Sekaligus baca ISI tiap nota (nominal, tanggal, penerima, saran
        // kategori) dari teks yang sudah dikelompokkan skrip Python. Hasilnya
        // DRAF — admin WAJIB konfirmasi sebelum dipakai (nota sering tulisan
        // tangan, OCR bisa salah baca).
        $potongan = [];
        $daftarNota = [];

        foreach (($hasil['nota'] ?? []) as $nota) {
            $file = $nota['potongan'] ?? null;
            $path = null;

            if (filled($file)) {
                $nama = basename((string) $file);
                $path = $dirRelatif.'/'.$nama;
                $potongan[] = $path;
            }

            $isi = PembacaIsiNota::urai(
                is_array($nota['teks'] ?? null) ? $nota['teks'] : []
            );

            $daftarNota[] = [
                'ke' => (int) ($nota['ke'] ?? count($daftarNota) + 1),
                'halaman' => (int) ($nota['halaman'] ?? 1),
                'potongan' => $path,
                'nominal' => $isi['nominal'],
                'tanggal' => $isi['tanggal'],
                'penerima' => $isi['penerima'],
                'kategori' => $isi['kategori'],
                'keterangan' => $isi['keterangan'],
                'keyakinan' => $isi['keyakinan'],
            ];
        }

        $hasilAkhir = [
            'ok' => true,
            'jumlah_nota' => max(1, (int) ($hasil['jumlah_nota'] ?? 1)),
            'metode' => (string) ($hasil['metode'] ?? 'ocr'),
            'potongan' => $potongan,
            // Isi tiap nota (DRAF) — dipakai form untuk mengisi otomatis.
            'nota' => $daftarNota,
        ];

        // Simpan hasil SUKSES ke cache (7 hari) — permintaan pengguna:
        // "jangan buat aplikasi berat". Tanpa ini, OCR jalan ulang setiap
        // form dibuka/diperbarui untuk berkas yang sama.
        Cache::put($kunci, $hasilAkhir, now()->addDays(7));

        return $hasilAkhir;
    }

    /**
     * Apakah OCR diaktifkan? (bisa dimatikan lewat .env)
     *
     * Penting untuk server yang belum dipasangi Python — sistem tetap jalan
     * dengan jumlah nota manual, tanpa error.
     */
    public function aktif(): bool
    {
        return (bool) config('ocr.aktif', false);
    }

    /**
     * Jalankan skrip Python dan urai JSON-nya.
     *
     * @return array<string, mixed>
     */
    private function jalankan(string $pathBerkas, string $dirPotongan): array
    {
        $skrip = config('ocr.skrip');
        $python = config('ocr.python');

        /*
         * ⚠️ LEPAS BATAS WAKTU PHP — SENGAJA.
         *
         * php.ini web punya `max_execution_time = 30`, sedangkan OCR berkas
         * besar (contoh nyata: 57 nota dalam 15 halaman) butuh ~38 detik.
         * Tanpa ini, proses bisa dimatikan di tengah jalan dan admin melihat
         * error — padahal berkasnya sah.
         *
         * Pembatasan waktu diserahkan ke `Process::timeout()` di bawah, yang
         * memang dirancang untuk itu. set_time_limit(0) = tanpa batas; aman
         * karena proses anak tetap dibatasi timeout sendiri.
         */
        if (function_exists('set_time_limit')) {
            set_time_limit(0);
        }

        $hasil = Process::timeout((int) config('ocr.timeout', 60))
            ->run([$python, $skrip, $pathBerkas, $dirPotongan]);

        if (! $hasil->successful()) {
            throw new \RuntimeException(
                trim($hasil->errorOutput()) ?: 'Skrip OCR keluar dengan kode '.$hasil->exitCode()
            );
        }

        $keluaran = trim($hasil->output());

        // Ambil baris JSON terakhir — kalau skrip mencetak peringatan library
        // ke stdout, kita tetap dapat JSON-nya.
        $baris = collect(preg_split('/\R/', $keluaran))
            ->map(fn (string $b): string => trim($b))
            ->filter(fn (string $b): bool => str_starts_with($b, '{'))
            ->last();

        if (blank($baris)) {
            throw new \RuntimeException('OCR tidak mengeluarkan JSON');
        }

        $data = json_decode($baris, true);

        if (! is_array($data)) {
            throw new \RuntimeException('JSON dari OCR tidak bisa dibaca');
        }

        return $data;
    }
}
