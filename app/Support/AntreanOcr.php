<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ringkasan antrean OCR untuk ditampilkan di panel.
 *
 * KENAPA: kalau worker `queue:work` mati, unggahan hanya berhenti di status
 * menunggu dan admin mengira unggahannya gagal. Angka di sini membuat keadaan
 * antrean terlihat tanpa harus masuk ke server.
 */
final class AntreanOcr
{
    /** Job lebih tua dari sekian menit dianggap tertahan. */
    public const BATAS_TERTAHAN_MENIT = 10;

    /**
     * @return array{menunggu: int, gagal: int, tertahan: int, tertua_menit: int|null}
     */
    public static function ringkasan(): array
    {
        $kosong = ['menunggu' => 0, 'gagal' => 0, 'tertahan' => 0, 'tertua_menit' => null];

        if (! Schema::hasTable('jobs')) {
            return $kosong;
        }

        $menunggu = (int) DB::table('jobs')->count();
        $gagal = Schema::hasTable('failed_jobs') ? (int) DB::table('failed_jobs')->count() : 0;

        $tertua = DB::table('jobs')->min('created_at');
        $tertuaMenit = null;
        $tertahan = 0;

        if ($tertua !== null) {
            $tertuaMenit = (int) floor((time() - (int) $tertua) / 60);
            $tertahan = DB::table('jobs')
                ->where('created_at', '<', time() - (self::BATAS_TERTAHAN_MENIT * 60))
                ->count();
        }

        return [
            'menunggu' => $menunggu,
            'gagal' => $gagal,
            'tertahan' => (int) $tertahan,
            'tertua_menit' => $tertuaMenit,
        ];
    }

    /** Antrean berhenti bila ada job tertahan atau penumpukan tanpa hasil. */
    public static function macet(): bool
    {
        return self::ringkasan()['tertahan'] > 0;
    }
}
