<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\PembacaNota;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Throwable;

/**
 * Jalankan OCR nota di latar belakang (AUD-6).
 *
 * KENAPA JOB, BUKAN PANGGILAN LANGSUNG
 * OCR memanggil proses Python yang bisa makan puluhan detik untuk PDF tumpuk.
 * Kalau dijalankan di dalam request Livewire, request menggantung sampai batas
 * waktu PHP habis dan hasil ekstraksi hilang. Di sini hasilnya dititipkan ke
 * cache, lalu komponen Livewire mengambilnya lewat `periksaHasilOcr()`.
 *
 * KUNCI CACHE
 * `ocr-nota:{uuid}` - uuid dibuat komponen, hanya diketahui sesi pengunggah.
 * Umur 1 jam; hasil lama dibuang sendiri oleh cache.
 */
class EkstrakNotaOcr implements ShouldQueue
{
    use Queueable;

    /** OCR panjang: beri ruang, tapi jangan menggantung selamanya. */
    public int $timeout = 600;

    public int $tries = 1;

    public function __construct(
        public string $kunci,
        public string $pathRelatif,
        public string $disk = 'nota',
    ) {}

    public function handle(PembacaNota $pembaca): void
    {
        try {
            $hasil = $pembaca->baca($this->pathRelatif, $this->disk);
        } catch (Throwable $e) {
            // OCR bantuan, bukan penentu: gagal = kartu manual, bukan error 500.
            report($e);
            $hasil = ['ok' => false, 'alasan' => 'OCR gagal dijalankan'];
        }

        Cache::put(self::kunciCache($this->kunci), $hasil, now()->addHour());
    }

    public static function kunciCache(string $kunci): string
    {
        return 'ocr-nota:'.$kunci;
    }
}
