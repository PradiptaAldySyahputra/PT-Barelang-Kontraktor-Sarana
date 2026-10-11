<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BATAS ATAS NILAI SPK — temuan audit (9 Okt 2026).
 *
 * ⚠️ MASALAH YANG DICEGAH:
 * Field `nilai_spk` sebelumnya HANYA punya `->numeric()->minValue(0)` — TIDAK
 * ada batas atas. Berbeda dari Uang Keluar yang punya `BATAS_NOMINAL`. Salah
 * ketik nilai SPK (mis. 20 miliar alih-alih 200 juta) tidak tertangkap dan
 * langsung merusak laporan piutang: sisa tagih membengkak tanpa peringatan.
 *
 * Batas yang dipakai SAMA dengan Uang Keluar (`BATAS_NOMINAL` = 10 miliar),
 * supaya konsisten di seluruh aplikasi.
 */
class BatasNilaiSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-batas-spk@bks.test',
        ]);
    }

    public function test_nilai_spk_dalam_batas_diterima(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'BATAS-SPK-1',
                'nama_pekerjaan' => 'Pekerjaan dalam batas',
                'nilai_spk' => 250_000_000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(
            250_000_000.0,
            (float) Spk::where('nomor_spk', 'BATAS-SPK-1')->value('nilai_spk'),
        );
    }

    public function test_nilai_spk_melebihi_batas_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'BATAS-SPK-2',
                'nama_pekerjaan' => 'Pekerjaan nilai ngawur',
                // 50 miliar — jelas salah ketik, harus ditolak.
                'nilai_spk' => 50_000_000_000,
            ])
            ->call('create')
            ->assertHasFormErrors(['nilai_spk']);

        $this->assertSame(
            0,
            Spk::where('nomor_spk', 'BATAS-SPK-2')->count(),
            'SPK dengan nilai di luar batas wajar TIDAK boleh tersimpan.',
        );
    }
}
