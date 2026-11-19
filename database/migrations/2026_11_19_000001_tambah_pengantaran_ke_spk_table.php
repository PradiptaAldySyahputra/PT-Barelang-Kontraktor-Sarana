<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah riwayat pengantaran dokumen SPK (JSON) pada tabel `spk`.
 *
 * Latar belakang: kolom tunggal `status_antar` + `tanggal_antar` hanya bisa
 * mencatat SATU peristiwa. Padahal realita (Excel "LIST SPK 2026.xlsx")
 * menunjukkan pengantaran sering terjadi berulang (mis. antar awal, lalu
 * revisi kuitansi/dokumen), tercatat siapa pembawa & ke mana. Riwayat ini
 * disimpan sebagai array JSON; `status_antar`/`tanggal_antar` tetap menjadi
 * snapshot dari entri TERAKHIR supaya badge & filter cepat tetap bekerja.
 *
 * ⚠️ TETAP 5 TABEL — penambahan kolom pada tabel `spk` yang sudah ada.
 *
 * Struktur tiap entri (urut kronologis):
 *   {"tanggal":"2026-11-19","status":"sudah_diantar","oleh":"","tujuan":"","catatan":"..."}
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->json('pengantaran')->nullable()->after('perpanjangan');
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->dropColumn('pengantaran');
        });
    }
};
