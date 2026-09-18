<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `pengguna` — akun pengguna sistem.
 *
 * Asal: db.txt (`pengguna`) + SRS.
 * Kolom `peran` divalidasi memakai App\Enums\Peran (admin | direktur).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('peran', 50)->index(); // admin | direktur
            $table->boolean('is_aktif')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
