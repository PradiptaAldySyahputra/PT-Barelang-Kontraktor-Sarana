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
