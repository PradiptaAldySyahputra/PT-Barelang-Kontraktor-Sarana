<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji RETENSI, UMUR PIUTANG (aging), dan TENGGAT.
 *
 * ⚠️ KONSEP RETENSI yang diuji di sini:
 * Retensi adalah bagian nilai SPK yang DITAHAN pemberi kerja sampai masa
 * pemeliharaan selesai. Karena itu retensi BUKAN piutang lancar.
 *
 *   nilai_tagih  = nilai_spk − retensi_ditahan
 *   piutang      = nilai_tagih − sudah_diterima
 *
 * Retensi dilepas saat status tagihan = Dibayar.
 */
class RetensiTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-retensi@bks.test',
        ]);
    }

    private function buatSpk(array $atribut = []): Spk
    {
        return Spk::factory()->pln()->create(array_merge([
            'nomor_spk' => 'RETENSI-001',
            'nama_pekerjaan' => 'Pekerjaan Retensi',
            'nilai_spk' => 100_000_000,
            'mitra_id' => Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam'])->id,
            'dibuat_oleh' => $this->admin->id,
        ], $atribut));
    }

    // ---------------------------------------------------------
    // Perhitungan retensi
    // ---------------------------------------------------------

    public function test_retensi_dihitung_5_persen(): void
    {
        $spk = $this->buatSpk();
        $spk->terapkanRetensi(5.00)->save();

        $this->assertSame(5_000_000.0, (float) $spk->nilai_retensi);
    }

    public function test_nilai_tagih_mengurangi_retensi_ditahan(): void
    {
        $spk = $this->buatSpk(['status_tagihan' => StatusTagihan::BelumDitagihkan]);
        $spk->terapkanRetensi(5.00)->save();

        // 100jt - 5jt retensi = 95jt boleh ditagih
        $this->assertSame(95_000_000.0, $spk->nilaiTagih());
        $this->assertSame(5_000_000.0, $spk->retensiDitahan());
    }

    public function test_piutang_tidak_menghitung_retensi_ditahan(): void
    {
        $spk = $this->buatSpk(['status_tagihan' => StatusTagihan::BelumDitagihkan]);
        $spk->terapkanRetensi(5.00)->save();

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 45_000_000,
            'mitra_id' => null,
        ]);

        // SEBELUM perbaikan: 100jt - 45jt = 55jt (SALAH, retensi dihitung piutang)
        // SESUDAH perbaikan: 95jt - 45jt = 50jt (BENAR)
        $this->assertSame(50_000_000.0, $spk->fresh()->piutang());
    }

    public function test_retensi_dilepas_saat_spk_dibayar(): void
    {
        $spk = $this->buatSpk(['status_tagihan' => StatusTagihan::BelumDitagihkan]);
        $spk->terapkanRetensi(5.00)->save();

        $this->assertSame(5_000_000.0, $spk->retensiDitahan());

        // Setelah dibayar, retensi dilepas -> nilai penuh boleh ditagih
        $spk->status_tagihan = StatusTagihan::Dibayar;
        $spk->save();

        $this->assertSame(0.0, $spk->fresh()->retensiDitahan());
        $this->assertSame(100_000_000.0, $spk->fresh()->nilaiTagih());
    }

    public function test_spk_tanpa_retensi_tidak_terpengaruh(): void
    {
        $spk = $this->buatSpk();

        $this->assertNull($spk->nilai_retensi);
        $this->assertSame(0.0, $spk->retensiDitahan());
        $this->assertSame(100_000_000.0, $spk->nilaiTagih());
    }

    // ---------------------------------------------------------
    // Umur piutang (aging)
    // ---------------------------------------------------------

    public function test_umur_piutang_dihitung_dari_tanggal_spk(): void
    {
        $spk = $this->buatSpk(['tanggal_spk' => now()->subDays(45)]);

        $this->assertSame(45, $spk->umurHari());
        $this->assertSame('31-60', $spk->kategoriUmur());
    }

    public function test_kelompok_umur_piutang(): void
    {
        $kasus = [
            10 => '0-30',
            30 => '0-30',
            31 => '31-60',
            60 => '31-60',
            61 => '61-90',
            90 => '61-90',
            91 => '>90',
            200 => '>90',
        ];

        foreach ($kasus as $hari => $harapan) {
            $spk = $this->buatSpk([
                'nomor_spk' => 'AGING-'.$hari,
                'tanggal_spk' => now()->subDays($hari),
            ]);

            $this->assertSame(
                $harapan,
                $spk->kategoriUmur(),
                "Umur {$hari} hari seharusnya masuk kelompok {$harapan}"
            );
        }
    }

    public function test_spk_tanpa_tanggal_masuk_kelompok_khusus(): void
    {
        $spk = $this->buatSpk(['tanggal_spk' => null]);

        $this->assertNull($spk->umurHari());
        $this->assertSame('tanpa-tanggal', $spk->kategoriUmur());
    }

    // ---------------------------------------------------------
    // Tenggat
    // ---------------------------------------------------------

    public function test_spk_lewat_tenggat_terdeteksi(): void
    {
        $spk = $this->buatSpk(['tanggal_akhir' => now()->subDays(5)]);

        $this->assertTrue($spk->sudahLewatTenggat());
        $this->assertFalse($spk->mendekatiTenggat());
        $this->assertSame('Lewat 5 hari', $spk->labelTenggat());
    }

    public function test_spk_mendekati_tenggat_terdeteksi(): void
    {
        $spk = $this->buatSpk(['tanggal_akhir' => now()->addDays(7)]);

        $this->assertFalse($spk->sudahLewatTenggat());
        $this->assertTrue($spk->mendekatiTenggat());
        $this->assertSame('7 hari lagi', $spk->labelTenggat());
    }

    public function test_spk_tenggat_masih_lama(): void
    {
        $spk = $this->buatSpk(['tanggal_akhir' => now()->addDays(60)]);

        $this->assertFalse($spk->sudahLewatTenggat());
        $this->assertFalse($spk->mendekatiTenggat());
    }

    public function test_tenggat_hari_ini(): void
    {
        $spk = $this->buatSpk(['tanggal_akhir' => now()]);

        $this->assertSame('Hari ini', $spk->labelTenggat());
        $this->assertTrue($spk->mendekatiTenggat());
    }

    public function test_scope_lewat_tenggat(): void
    {
        $this->buatSpk(['nomor_spk' => 'L-1', 'tanggal_akhir' => now()->subDays(3)]);
        $this->buatSpk(['nomor_spk' => 'L-2', 'tanggal_akhir' => now()->addDays(30)]);

        $hasil = Spk::lewatTenggat()->pluck('nomor_spk');

        $this->assertContains('L-1', $hasil);
        $this->assertNotContains('L-2', $hasil);
    }

    public function test_scope_piutang_menua(): void
    {
        $this->buatSpk([
            'nomor_spk' => 'TUA-1',
            'tanggal_spk' => now()->subDays(120),
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);
        $this->buatSpk([
            'nomor_spk' => 'BARU-1',
            'tanggal_spk' => now()->subDays(10),
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);

        $hasil = Spk::piutangMenua(90)->pluck('nomor_spk');

        $this->assertContains('TUA-1', $hasil);
        $this->assertNotContains('BARU-1', $hasil);
    }
}
