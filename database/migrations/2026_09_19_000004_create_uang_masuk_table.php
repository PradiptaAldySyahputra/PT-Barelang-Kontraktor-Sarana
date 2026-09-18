<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `uang_masuk` — penerimaan dana.
 *
 * Asal: db.txt (`uang_masuk`) + revisi user.
 *
 * Yang TIDAK digunakan (revisi user):
 *   nomor_transaksi, sumber, metode_pembayaran, status, dicatat_oleh
 *
 * Yang DITAMBAH (revisi user):
 *   nama_pekerjaan, nomor_spk, bukti
 *
 * Sumber uang masuk DISIMPULKAN dari spk_id:
 *   - spk_id terisi -> dari SPK
 *   - spk_id NULL   -> dari luar SPK
 *
 * Form punya 2 mode: (1) berdasarkan SPK, (2) manual.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uang_masuk', function (Blueprint $table) {
            $table->id();

            // NULL = uang masuk dari LUAR SPK
            $table->foreignId('spk_id')->nullable()->constrained('spk')->nullOnDelete();

            $table->string('nomor_spk', 150)->nullable();
            $table->string('nama_pekerjaan', 255)->nullable();
            $table->date('tanggal')->index();
            $table->decimal('jumlah', 18, 2);

            $table->foreignId('mitra_id')->nullable()->constrained('mitra')->nullOnDelete();
            $table->text('keterangan')->nullable();

            // Jumlah file BEBAS (keputusan user) — array path file
            $table->json('bukti')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uang_masuk');
    }
};
