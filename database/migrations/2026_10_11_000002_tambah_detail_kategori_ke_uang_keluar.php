<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom `detail_kategori` pada uang_keluar.
 *
 * ⚠️ PERMINTAAN USER (11 Okt 2026, prompt desain Bagian A.5):
 * "Kategori = 'Lainnya' → field 'Detail kategori' muncul dan WAJIB diisi
 *  (kebijakan diputuskan 11 Okt 2026)."
 *
 * Keputusan user: simpan sebagai KOLOM BARU (bukan menumpang `keterangan`),
 * supaya bisa difilter & dilaporkan terpisah nanti.
 *
 * ⚠️ TETAP 5 TABEL DOMAIN: ini KOLOM tambahan pada tabel `uang_keluar` yang
 * sudah ada - bukan tabel baru (Rules.md §1).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->string('detail_kategori', 150)->nullable()->after('kategori');
        });
    }

    public function down(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->dropColumn('detail_kategori');
        });
    }
};
