<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `exports` — infrastruktur Filament untuk ExportAction.
 *
 * ⚠️ PERUBAHAN dari versi bawaan Filament:
 * Bawaan memakai `$table->foreignId('user_id')->constrained()` yang menunjuk
 * ke tabel `users`. Sistem ini TIDAK punya tabel `users` — pengguna disimpan
 * di tabel `pengguna`. Akibatnya migrasi gagal dengan
 * "Foreign key constraint is incorrectly formed" (errno 150).
 * Di sini foreign key diarahkan eksplisit ke tabel `pengguna`.
 *
 * Tabel ini tabel INFRASTRUKTUR (seperti jobs/cache), bukan tabel domain —
 * skema domain tetap 5 tabel.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exports', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('completed_at')->nullable();
            $table->string('file_disk');
            $table->string('file_name')->nullable();
            $table->string('exporter');
            $table->unsignedInteger('processed_rows')->default(0);
            $table->unsignedInteger('total_rows');
            $table->unsignedInteger('successful_rows')->default(0);
            $table->foreignId('user_id')->constrained('pengguna')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exports');
    }
};
