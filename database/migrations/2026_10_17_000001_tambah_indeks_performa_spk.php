<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->index(['status_spk', 'tanggal_akhir'], 'spk_status_tanggal_akhir_index');
            $table->index(['status_spk', 'status_tagihan'], 'spk_status_spk_tagihan_index');
            $table->index(['mitra_id', 'status_spk'], 'spk_mitra_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->dropIndex('spk_status_tanggal_akhir_index');
            $table->dropIndex('spk_status_spk_tagihan_index');
            $table->dropIndex('spk_mitra_status_index');
        });
    }
};
