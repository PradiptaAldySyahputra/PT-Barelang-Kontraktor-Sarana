<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusAntar;
use Tests\TestCase;

/**
 * Enum StatusAntar — status PENGANTARAN DOKUMEN SPK.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "SPK ini perlu keterangan (lihat LIST SPK 2026.xlsx) — kalau di dalam SPK
 *  tersebut ada keterangan, jadi admin perlu itu... karena itu penting juga
 *  untuk admin mengetahui apakah SPK tersebut sudah diantar atau belum."
 *
 * Keputusan pengguna: **CUKUP 3 NILAI** —
 *   Belum / Sudah Diantar / Diterima
 * (nilai tambahan bisa menyusul bila diperlukan)
 */
class StatusAntarTest extends TestCase
{
    public function test_punya_tepat_tiga_nilai(): void
    {
        $this->assertCount(
            3,
            StatusAntar::cases(),
            'StatusAntar harus punya TEPAT 3 nilai (keputusan pengguna): belum, sudah diantar, diterima.',
        );
    }

    public function test_nilai_dan_label(): void
    {
        $this->assertSame('belum', StatusAntar::Belum->value);
        $this->assertSame('sudah_diantar', StatusAntar::SudahDiantar->value);
        $this->assertSame('diterima', StatusAntar::Diterima->value);

        $this->assertSame('Belum Diantar', StatusAntar::Belum->label());
        $this->assertSame('Sudah Diantar', StatusAntar::SudahDiantar->label());
        $this->assertSame('Diterima', StatusAntar::Diterima->label());
    }

    public function test_opsi_untuk_dropdown(): void
    {
        $opsi = StatusAntar::opsi();

        $this->assertSame([
            'belum' => 'Belum Diantar',
            'sudah_diantar' => 'Sudah Diantar',
            'diterima' => 'Diterima',
        ], $opsi);
    }

    public function test_setiap_nilai_punya_warna_badge(): void
    {
        foreach (StatusAntar::cases() as $kasus) {
            $this->assertNotEmpty(
                $kasus->warnaBadge(),
                "Status {$kasus->value} harus punya warna badge.",
            );
        }
    }
}
