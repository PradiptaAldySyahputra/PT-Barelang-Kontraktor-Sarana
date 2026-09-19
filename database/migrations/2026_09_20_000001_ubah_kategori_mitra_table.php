<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Ubah kategori mitra dari 4 nilai menjadi 2.
 *
 * SEBELUM : pln · pelanggan · vendor · subkon
 * SESUDAH : mitra (gabungan pln+pelanggan+vendor) · subkon
 *
 * Alasan: user memutuskan **PLN masuk ke mitra**, sehingga kategori
 * pelanggan/vendor tidak lagi dibedakan.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('mitra')
            ->whereIn('kategori', ['pln', 'pelanggan', 'vendor'])
            ->update(['kategori' => 'mitra']);
    }

    public function down(): void
    {
        // Tidak bisa dikembalikan persis — informasi kategori lama
        // (pln/pelanggan/vendor) sudah hilang setelah digabung.
        // Baris yang tadinya 'pln' dikembalikan sebagai 'pln' bila namanya PLN,
        // sisanya tetap 'mitra'.
        DB::table('mitra')
            ->where('kategori', 'mitra')
            ->where('nama', 'like', '%PLN%')
            ->update(['kategori' => 'pln']);
    }
};
