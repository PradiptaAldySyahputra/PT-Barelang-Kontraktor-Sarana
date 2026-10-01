<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Kolom baru di tabel `spk` untuk kebutuhan pengantaran dokumen &
 * perpanjangan tenggat.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * 1. "SPK ini perlu keterangan (lihat LIST SPK 2026.xlsx)" → kolom
 *    `keterangan` dikembalikan (pernah dihapus 19 Sep).
 * 2. Status pengantaran dokumen → `status_antar` + `tanggal_antar`.
 * 3. "perpanjangan tenggat SPK tidak bergantung tenggat waktu awal" →
 *    kolom `perpanjangan` (JSON) menyimpan riwayat adendum.
 *
 * ⚠️ TETAP 5 TABEL: semua tambahan berupa KOLOM di tabel `spk` yang sudah
 * ada — tidak ada tabel baru.
 */
class KolomSpkBaruTest extends TestCase
{
    use RefreshDatabase;

    public function test_kolom_keterangan_ada(): void
    {
        $this->assertTrue(
            Schema::hasColumn('spk', 'keterangan'),
            'Kolom `keterangan` harus ada (kebutuhan LIST SPK).',
        );
    }

    public function test_kolom_status_antar_ada(): void
    {
        $this->assertTrue(Schema::hasColumn('spk', 'status_antar'));
        $this->assertTrue(Schema::hasColumn('spk', 'tanggal_antar'));
    }

    public function test_kolom_perpanjangan_ada(): void
    {
        $this->assertTrue(
            Schema::hasColumn('spk', 'perpanjangan'),
            'Kolom `perpanjangan` (JSON) menyimpan riwayat adendum tenggat.',
        );
    }

    public function test_kolom_lama_tidak_hilang(): void
    {
        // Pastikan migrasi tidak merusak kolom yang sudah ada.
        foreach ([
            'nomor_spk', 'tanggal_spk', 'tanggal_akhir', 'nama_pekerjaan',
            'nilai_spk', 'status_spk', 'status_tagihan', 'mitra_id',
        ] as $kolom) {
            $this->assertTrue(
                Schema::hasColumn('spk', $kolom),
                "Kolom `{$kolom}` hilang setelah migrasi!",
            );
        }
    }
}
