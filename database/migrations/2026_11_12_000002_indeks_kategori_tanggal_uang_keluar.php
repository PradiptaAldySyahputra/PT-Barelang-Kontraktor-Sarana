<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Audit performa 12 Nov 2026: filter "kategori + tanggal" pada Uang Keluar
 * hanya memakai indeks kategori, lalu mengurutkan di memori (EXPLAIN:
 * "Using where; Using filesort"). Indeks gabungan membuat urutan ikut terbaca
 * dari indeks.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->index(['kategori', 'tanggal'], 'uang_keluar_kategori_tanggal_index');
        });
    }

    public function down(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->dropIndex('uang_keluar_kategori_tanggal_index');
        });
    }
};
