<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom `akun` (kas | bank) pada uang_masuk.
 *
 * ⚠️ KENAPA: pengguna meminta laporan kas/bank terpisah seperti Excel
 * perusahaan. Data lama otomatis menjadi 'kas' (keputusan pengguna).
 * Skema tetap 5 tabel — ini hanya KOLOM baru.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->string('akun', 20)->nullable()->default('kas')->after('tanggal')->index();
        });
    }

    public function down(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->dropColumn('akun');
        });
    }
};
