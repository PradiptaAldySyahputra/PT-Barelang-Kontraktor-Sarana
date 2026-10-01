<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Jadwal Tugas
|--------------------------------------------------------------------------
|
| Backup database setiap hari pukul 23:00 (setelah jam kerja).
| Simpan 30 hari terakhir.
|
| ⚠️ PENTING untuk deployment: jalankan scheduler-nya.
|   Linux : * * * * * cd /path/ke/proyek && php artisan schedule:run >> /dev/null 2>&1
|   Windows: buat Task Scheduler tiap 1 menit -> php artisan schedule:run
|
*/

Schedule::command('bks:backup --hari=30')
    ->dailyAt('23:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->description('Backup database harian');

/*
| Bersihkan potongan nota hasil OCR yang sudah tidak dipakai.
|
| Setiap OCR menyimpan gambar potongan per nota. Tanpa pembersihan, folder
| `storage/app/public/uang_keluar/potongan` menumpuk (terbukti 177 MB di mesin
| pengembangan) dan lama-lama menghabiskan disk server kantor.
|
| Dijalankan tiap Minggu dini hari — saat tidak ada admin yang bekerja.
*/
Schedule::command('ocr:bersihkan')
    ->weeklyOn(0, '02:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->description('Bersihkan potongan OCR yang menumpuk');

/*
| Bersihkan berkas SEMENTARA unggahan Livewire.
|
| ⚠️ TEMUAN AUDIT (26 Sep 2026):
| Setiap unggahan berkas lewat Filament menyisakan salinan di
| `storage/app/public/livewire-tmp`. Terbukti menumpuk 190 berkas / 92 MB
| di mesin pengembangan — berkas asli sudah tersimpan rapi di disk `nota`,
| jadi salinan sementara ini murni sampah.
|
| Livewire hanya membersihkannya otomatis kalau pakai S3; untuk disk lokal
| harus dijadwalkan sendiri (terdokumentasi di dokumentasi Livewire).
|
| Dijalankan tiap hari 01:00 — berkas >6 jam dianggap sisa (tidak ada admin
| yang mengunggah selama itu).
*/
Schedule::call(function (): void {
    $dir = storage_path('app/public/livewire-tmp');

    if (! is_dir($dir)) {
        return;
    }

    $batas = now()->subHours(6)->getTimestamp();

    foreach (glob($dir.'/*') ?: [] as $berkas) {
        if (is_file($berkas) && filemtime($berkas) < $batas) {
            @unlink($berkas);
        }
    }
})
    ->name('bersihkan-livewire-tmp')
    ->dailyAt('01:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->description('Bersihkan berkas sementara unggahan Livewire');
