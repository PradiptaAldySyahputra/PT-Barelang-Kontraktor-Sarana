<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * "Revisi Dokumen" adalah keadaan PEKERJAAN (dokumen SPK sedang direvisi),
 * bukan keadaan penagihan. Sebelumnya nilai ini hanya hidup di
 * `status_tagihan`; sekarang dicatat juga di `status_spk` agar bisa disaring
 * di menu Status SPK.
 *
 * Kolom `status_tagihan` sengaja TIDAK diubah: nilai lamanya tetap terbaca
 * sampai admin memutuskan status penagihan yang benar untuk SPK tersebut.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('spk')
            ->where('status_tagihan', 'revisi_dokumen')
            ->update(['status_spk' => 'revisi_dokumen']);
    }

    public function down(): void
    {
        DB::table('spk')
            ->where('status_spk', 'revisi_dokumen')
            ->update(['status_spk' => 'berjalan']);
    }
};
