<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `uang_keluar` — pengeluaran dana.
 *
 * Asal: db.txt (`uang_keluar`) + revisi user + keputusan user.
 *
 * Yang TIDAK digunakan (revisi user + keputusan user):
 *   nomor_transaksi, mitra_id, metode_pembayaran, status, dicatat_oleh,
 *   disetujui_oleh, tanggal_persetujuan  <-- TIDAK ADA APPROVAL
 *
 * Yang DIPERTAHANKAN:
 *   spk_id  <-- keputusan user "tambahkan kalau wajib".
 *              WAJIB ada agar laba-rugi per SPK bisa dihitung.
 *
 * Yang DITAMBAH (revisi user):
 *   bukti (jumlah file bebas)
 *
 * Kolom `kategori` divalidasi memakai App\Enums\KategoriPengeluaran.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uang_keluar', function (Blueprint $table) {
            $table->id();

            // Boleh NULL untuk pengeluaran umum (non-SPK)
            $table->foreignId('spk_id')->nullable()->constrained('spk')->nullOnDelete();

            $table->date('tanggal')->index();
            $table->decimal('jumlah', 18, 2);
            $table->string('kategori', 100)->nullable()->index();
            $table->string('penerima', 200)->nullable();
            $table->text('keterangan')->nullable();

            // Jumlah file BEBAS (keputusan user)
            $table->json('bukti')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uang_keluar');
    }
};
