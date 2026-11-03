<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->index(['akun', 'tanggal'], 'uang_masuk_akun_tanggal_index');
            $table->index(['spk_id', 'tanggal'], 'uang_masuk_spk_tanggal_index');
        });

        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->index(['akun', 'tanggal'], 'uang_keluar_akun_tanggal_index');
            $table->index(['spk_id', 'tanggal'], 'uang_keluar_spk_tanggal_index');
        });
    }

    public function down(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->dropIndex('uang_masuk_akun_tanggal_index');
            $table->dropIndex('uang_masuk_spk_tanggal_index');
        });

        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->dropIndex('uang_keluar_akun_tanggal_index');
            $table->dropIndex('uang_keluar_spk_tanggal_index');
        });
    }
};
