<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\UangKeluars\Pages\EditUangKeluar;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BUG — aturan "biaya SPK wajar" salah hitung saat MENGUBAH Uang Keluar.
 *
 * ⚠️ TEMUAN (9 Okt 2026):
 * `UangKeluarForm::aturanJumlah()` menghitung:
 *
 *     $total = $spk->uangKeluar()->sum('jumlah') + $value;
 *
 * Saat halaman UBAH, record yang sedang diedit SUDAH ADA di DB, sehingga
 * `sum('jumlah')` sudah MEMASUKKAN nilai LAMA record itu — lalu `$value`
 * (nilai BARU) ditambahkan lagi. Akibatnya nilai record terhitung DUA KALI.
 *
 * Bandingkan `UangMasukForm` yang BENAR: ia mengecualikan record sendiri
 * dengan `->when($record?->id, fn ($q) => $q->whereKeyNot($record->id))`.
 *
 * DAMPAK NYATA: mengubah nominal pengeluaran (mis. dari 90jt → 95jt) bisa
 * DITOLAK PALSU dengan pesan "jauh melebihi nilai SPK", padahal total
 * sebenarnya masih wajar. Admin tidak bisa memperbaiki data.
 */
class BugAturanJumlahUangKeluarTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Spk $spk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-bug-jumlah@bks.test',
        ]);

        $this->spk = Spk::factory()->pln()->berjalan()->create([
            'nomor_spk' => 'BUG-JUMLAH-001',
            'nilai_spk' => 100_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);
    }

    public function test_mengubah_nominal_pengeluaran_tidak_ditolak_palsu(): void
    {
        $this->actingAs($this->admin);

        // Pengeluaran awal 90jt (batas wajar = 1.5 × 100jt = 150jt).
        $keluar = UangKeluar::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 90_000_000,
            'tanggal' => now()->toDateString(),
        ]);

        /*
         * Ubah nominal menjadi 95jt. Total SEBENARNYA = 95jt (< 150jt) → harus
         * DITERIMA. Dengan bug double-count: 90 + 95 = 185jt (> 150jt) → DITOLAK
         * PALSU.
         */
        Livewire::test(EditUangKeluar::class, ['record' => $keluar->getRouteKey()])
            ->fillForm([
                'jumlah' => 95_000_000,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(
            95_000_000.0,
            (float) $keluar->fresh()->jumlah,
            'Perubahan nominal yang wajar harus tersimpan, bukan ditolak palsu.',
        );
    }

    public function test_pengeluaran_yang_benar_benar_melebihi_batas_tetap_ditolak(): void
    {
        $this->actingAs($this->admin);

        $keluar = UangKeluar::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 10_000_000,
            'tanggal' => now()->toDateString(),
        ]);

        // Total setelah ubah = 400jt (> 150jt) → WAJIB tetap ditolak.
        Livewire::test(EditUangKeluar::class, ['record' => $keluar->getRouteKey()])
            ->fillForm([
                'jumlah' => 400_000_000,
            ])
            ->call('save')
            ->assertHasFormErrors(['jumlah']);

        $this->assertSame(
            10_000_000.0,
            (float) $keluar->fresh()->jumlah,
            'Nominal yang benar-benar berlebihan tetap harus ditolak.',
        );
    }
}
