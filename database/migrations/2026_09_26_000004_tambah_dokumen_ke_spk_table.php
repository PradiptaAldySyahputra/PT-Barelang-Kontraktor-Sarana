<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom `dokumen` (JSON) di `spk` — tempat berkas SPK.
 *
 * ⚠️ KENAPA INI PERLU (PRD FR-SPK-007 + PRD §9 no.2):
 * Dokumen SPK seperti BAST, scan SPK, dan kuitansi TIDAK PUNYA TEMPAT karena
 * tabel `attachments` dihapus dan kolom `bukti` hanya ada di uang masuk/keluar.
 *
 * Disimpan sebagai JSON ARRAY supaya SATU SPK bisa punya BANYAK berkas
 * (mis. scan SPK + BAST + berita acara), pola sama seperti `bukti`:
 *   ["spk/scan-spk-001.pdf", "spk/bast-001.pdf"]
 *
 * ⚠️ TETAP 5 TABEL — hanya menambah KOLOM di tabel `spk` yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->json('dokumen')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->dropColumn('dokumen');
        });
    }
};
