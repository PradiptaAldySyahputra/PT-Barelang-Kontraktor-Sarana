<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * HAPUS RETENSI dari sistem.
 *
 * ⚠️ KEPUTUSAN USER (19 Sep 2026):
 * "retensi itu untuk apa? kalau tidak penting dan tidak mempengaruhi sistem
 *  hapus saja"
 *
 * Alasan retensi dihapus:
 *   - Data Excel tidak memuat retensi (semua NULL)
 *   - Perusahaan tidak memakainya dalam pencatatan sehari-hari
 *   - Menambah rumus yang tidak dipakai = sumber kebingungan
 *
 * Sistem kembali SEDERHANA: nilai SPK, uang masuk, uang keluar.
 * Tidak ada pajak, biaya, laba/rugi, piutang, atau retensi yang dihitung.
 * Murni mencatat data yang diinput.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->dropColumn(['persen_retensi', 'nilai_retensi']);
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->decimal('persen_retensi', 5, 2)->nullable()->after('nilai_spk');
            $table->decimal('nilai_retensi', 18, 2)->nullable()->after('persen_retensi');
        });
    }
};
