<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel `spk` — ENTITAS INTI sistem.
 *
 * Asal: skema awal (`spk`) + revisi user + keputusan user.
 *
 * Yang TIDAK ada (sesuai revisi & keputusan user):
 *   - `pic`        -> dihapus
 *   - `keterangan` -> dihapus (keputusan user 19 Sep 2026)
 *   - tabel `proyek` -> tidak ada entitas PROYEK
 *   - tabel `subcon_spk` -> dilebur ke tabel ini
 *
 * Yang DITAMBAH:
 *   - `tanggal_akhir`  (revisi user)
 *   - `persen_retensi` & `nilai_retensi` (retensi 5% SPK subkon/vendor)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spk', 150)->unique();
            $table->date('tanggal_spk')->nullable()->index(); // NULL jika "TANPA SPK"
            $table->date('tanggal_akhir')->nullable();
            $table->string('nama_pekerjaan', 255)->index();
            $table->string('lokasi', 255)->nullable();
            $table->decimal('nilai_spk', 18, 2);

            // Retensi (untuk SPK subkon/vendor) — Rules.md §2 butir 2
            $table->decimal('persen_retensi', 5, 2)->nullable();
            $table->decimal('nilai_retensi', 18, 2)->nullable();

            $table->string('jenis_sumber', 50)->nullable(); // pln | luar | internal | lainnya
            $table->string('sheet_lama', 100)->nullable();  // referensi sheet Excel lama

            $table->foreignId('mitra_id')->nullable()->constrained('mitra')->nullOnDelete();
            $table->string('status_spk', 50)->nullable()->index();
            $table->string('status_tagihan', 50)->nullable()->index();
            $table->foreignId('dibuat_oleh')->constrained('pengguna')->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk');
    }
};
