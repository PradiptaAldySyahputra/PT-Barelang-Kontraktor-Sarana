<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\PembacaNota;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use RuntimeException;
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
 * KENAPA ADA PERCOBAAN ULANG (audit 12 Nov 2026)
 * Sebelumnya `$tries = 1`: satu gangguan sesaat (proses Python dimatikan,
 * memori habis) membuat admin harus mengunggah ulang berkas yang sama. Kini
 * kegagalan SEMENTARA dicoba ulang; kegagalan tetap (berkas rusak) langsung
 * diserahkan ke admin sebagai kartu isian manual.
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

    /** Tiga percobaan: sesaat, jeda 30 detik, lalu 120 detik. */
    public int $tries = 3;

    /** @var list<int> */
    public array $backoff = [30, 120];

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
            $hasil = ['ok' => false, 'alasan' => 'OCR error: '.$e->getMessage()];
        }

        // Titipkan hasil apa pun (termasuk gagal) supaya polling di form
        // berhenti. Kalau masih ada jatah percobaan, lempar setelahnya agar
        // antrean menjadwalkan ulang dan hasil sukses menimpa yang gagal.
        Cache::put(self::kunciCache($this->kunci), $hasil, now()->addHour());

        // Tanpa objek job berarti dipanggil langsung (bukan lewat antrean):
        // jangan lempar, cukup titipkan kegagalan.
        if ($this->job !== null && $this->sementara($hasil) && $this->attempts() < $this->tries) {
            throw new RuntimeException('OCR belum berhasil, dicoba ulang: '.($hasil['alasan'] ?? 'tanpa alasan'));
        }
    }

    /**
     * Dipanggil antrean setelah percobaan terakhir gagal - beri tahu pengunggah
     * supaya spinner berhenti dan admin mengisi kartu secara manual.
     */
    public function failed(?Throwable $e): void
    {
        Cache::put(self::kunciCache($this->kunci), [
            'ok' => false,
            'alasan' => 'OCR gagal setelah '.$this->tries.' percobaan',
            'jumlah_nota' => 1,
            'metode' => 'gagal',
            'potongan' => [],
        ], now()->addHour());
    }

    /**
     * Kegagalan sementara = proses Python mati/timeout, bukan berkas yang
     * memang tidak terbaca. Hanya jenis ini yang layak dicoba ulang.
     *
     * @param  array<string, mixed>  $hasil
     */
    private function sementara(array $hasil): bool
    {
        if ((bool) ($hasil['ok'] ?? false)) {
            return false;
        }

        return str_starts_with((string) ($hasil['alasan'] ?? ''), 'OCR error');
    }

    public static function kunciCache(string $kunci): string
    {
        return 'ocr-nota:'.$kunci;
    }
}
