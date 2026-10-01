<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom `akun` (kas | bank) pada uang_keluar.
 *
 * Lihat catatan di migrasi uang_masuk — alasan & keputusan sama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->string('akun', 20)->nullable()->default('kas')->after('tanggal')->index();
        });
    }

    public function down(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->dropColumn('akun');
        });
    }
};
