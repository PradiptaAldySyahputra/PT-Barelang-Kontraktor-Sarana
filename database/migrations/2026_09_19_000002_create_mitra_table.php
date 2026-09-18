<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `mitra` — pihak terkait (PLN, pelanggan, vendor, subkon).
 *
 * Asal: db.txt (`mitra`) + SRS.
 * Kolom `kategori` divalidasi memakai App\Enums\KategoriMitra.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 200);
            $table->string('kategori', 50)->index(); // pln | pelanggan | vendor | subkon
            $table->string('kontak', 100)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
