<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom "dikerjakan oleh" pada SPK.
 *
 * Permintaan user: SPK perlu menandai apakah dikerjakan sendiri atau
 * disubkonkan ke pihak lain (kita bayar mereka).
 *
 * Tetap 5 tabel — tidak ada tabel baru. Pekerjaan yang sebagian
 * disubkonkan dibuat sebagai SPK terpisah.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            // 'sendiri' | 'subkon'
            $table->string('dikerjakan_oleh', 20)
                ->default('sendiri')
                ->after('status_tagihan')
                ->index();

            // Mitra subkon — hanya diisi jika dikerjakan_oleh = 'subkon'
            $table->foreignId('subkon_id')
                ->nullable()
                ->after('dikerjakan_oleh')
                ->constrained('mitra')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('spk', function (Blueprint $table): void {
            $table->dropForeign(['subkon_id']);
            $table->dropColumn(['subkon_id', 'dikerjakan_oleh']);
        });
    }
};
