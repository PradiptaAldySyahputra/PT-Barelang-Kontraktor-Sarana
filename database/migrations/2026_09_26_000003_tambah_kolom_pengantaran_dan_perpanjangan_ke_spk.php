<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Kolom baru di `spk`: keterangan, status pengantaran dokumen, perpanjangan tenggat.
 *
 * ⚠️ KENAPA INI PERLU (permintaan pengguna 26 Sep 2026):
 *
 * 1. `keterangan` — Excel "LIST SPK 2026.xlsx" punya kolom Keterangan
 *    (mis. "diantar ke imperium", "sudah masuk rek BKS"). Kolom ini pernah
 *    dihapus 19 Sep, sekarang dikembalikan karena dibutuhkan admin.
 *
 * 2. `status_antar` + `tanggal_antar` — agar admin tahu mana dokumen SPK
 *    yang BELUM diantar. Nilainya dari enum App\Enums\StatusAntar
 *    (belum | sudah_diantar | diterima).
 *
 * 3. `perpanjangan` (JSON) — SPK sering diperpanjang lewat adendum tanpa
 *    menghapus tenggat awal. Disimpan sebagai riwayat agar jejaknya ada:
 *    [{"dari":"2026-08-01","ke":"2026-11-01","alasan":"...","dicatat":"..."}]
 *
 * ⚠️ TETAP 5 TABEL — ini penambahan KOLOM pada tabel `spk` yang sudah ada.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            // Catatan bebas dari Excel (mis. "diantar ke imperium").
            $table->string('keterangan', 255)->nullable()->after('lokasi');

            // Status pengantaran dokumen (index agar bisa difilter cepat).
            $table->string('status_antar', 30)->nullable()->index()->after('status_tagihan');
            $table->date('tanggal_antar')->nullable()->after('status_antar');

            // Riwayat perpanjangan tenggat (adendum).
            $table->json('perpanjangan')->nullable()->after('tanggal_akhir');
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            // Index harus dilepas lebih dulu sebelum kolomnya dihapus.
            $table->dropIndex(['status_antar']);

            $table->dropColumn([
                'keterangan',
                'status_antar',
                'tanggal_antar',
                'perpanjangan',
            ]);
        });
    }
};
