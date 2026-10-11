<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `notifications` — notifikasi dalam aplikasi (B1-2).
 *
 * ⚠️ KENAPA INI PENTING (pelajaran dari repo lama — "BUG-03"):
 * Ekspor Excel/PDF berjalan di belakang layar (queue). Ketika selesai, sistem
 * memberi tahu pengguna lewat notifikasi database. Di repo lama tabel ini TIDAK
 * ADA sejak awal, sehingga ekspor yang sudah jadi GAGAL memberi notifikasi —
 * file terunduh tapi pengguna tidak tahu, dan job melempar error.
 *
 * Karena itu tabel ini dibuat SEJAK MIGRASI AWAL, bukan ditambal belakangan.
 *
 * ⚠️ Ini tabel INFRASTRUKTUR, bukan tabel domain ke-6. Scope lock
 * (`Rules.md` §1 / blueprint §2) mengizinkan tabel infrastruktur
 * (sessions, jobs, cache, notifications) — yang dilarang adalah menambah
 * entitas domain baru.
 *
 * Struktur mengikuti standar Laravel `notifications` (uuid + notifiable morph)
 * supaya kompatibel dengan fitur bawaan Filament/Laravel.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
