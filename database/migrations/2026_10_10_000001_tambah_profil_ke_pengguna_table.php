<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom profil ke tabel `pengguna`.
 *
 * ⚠️ SESUAI ATURAN SKEMA (`Rules.md` §1): skema tetap 5 tabel domain. Penambahan
 * dilakukan lewat KOLOM, bukan tabel baru.
 *
 * Kolom:
 *   - `avatar`        → path gambar profil di disk privat `nota` (mis. "profil/abc.jpg")
 *   - `tanda_tangan`  → path gambar tanda tangan (untuk blok ttd PDF)
 *   - `terakhir_masuk`→ waktu login terakhir (diisi otomatis saat login)
 *
 * ⚠️ KENAPA DISK PRIVAT: avatar & tanda tangan adalah data pribadi pegawai.
 * Menyimpannya di disk `public` membuatnya bisa diunduh siapa pun tanpa login
 * (kesalahan yang pernah terjadi pada nota — lihat catatan audit 26 Sep 2026).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->string('avatar', 255)->nullable()->after('is_aktif');
            $table->string('tanda_tangan', 255)->nullable()->after('avatar');
            $table->timestamp('terakhir_masuk')->nullable()->after('tanda_tangan');
        });
    }

    public function down(): void
    {
        Schema::table('pengguna', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'tanda_tangan', 'terakhir_masuk']);
        });
    }
};
