<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Livewire\CashOut\CashOutForm;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Verifikasi ALUR BISNIS end-to-end sesuai docs/Rules.md §2 pada panel Blade.
 */
class AlurBisnisE2ETest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->admin()->create();
    }

    public function test_alur_lengkap_dari_spk_sampai_lunas(): void
    {
        $this->actingAs($this->admin());
        $mitra = Mitra::factory()->create(['kategori' => KategoriMitra::Mitra]);

        // ── 1. INPUT SPK lewat form panel ───────────────────────────
        $this->post('/panel/spk', [
            'nomor_spk' => 'E2E-001',
            'nama_pekerjaan' => 'Pekerjaan E2E',
            'mitra_id' => $mitra->id,
            'tanggal_spk' => '2026-09-01',
            'nilai_spk' => 100000000,
            'status_antar' => StatusAntar::Belum->value,
            'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
        ])->assertRedirect();

        $spk = Spk::where('nomor_spk', 'E2E-001')->firstOrFail();
        fwrite(STDERR, "\n[1] SPK dibuat: nilai=".$spk->nilai_spk.' status='.$spk->status_spk->value."\n");
        $this->assertSame(100000000.0, (float) $spk->nilai_spk, 'Input SPK nominal salah');
        $this->assertSame(100000000.0, $spk->piutang(), 'Piutang awal harus = nilai_spk');

        // ── 2. UANG MASUK sebagian (30jt) ──────────────────────────
        $this->post('/panel/cash-in', [
            'mode' => 'spk',
            'spk_id' => $spk->id,
            'akun' => AkunKas::Kas->value,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => 30000000,
        ])->assertRedirect();

        $spk->refresh();
        fwrite(STDERR, '[2] Uang masuk 30jt → diterima='.$spk->totalPenerimaan()
            .' piutang='.$spk->piutang().' status_tagihan='.$spk->status_tagihan->value."\n");
        $this->assertSame(70000000.0, $spk->piutang(), 'Piutang setelah bayar sebagian salah');
        $this->assertSame(StatusTagihan::MenungguPembayaran, $spk->status_tagihan,
            'Status tagihan tidak auto-sync ke MenungguPembayaran');

        // ── 3. UANG MASUK MELEBIHI PIUTANG harus DITOLAK ───────────
        $this->post('/panel/cash-in', [
            'mode' => 'spk',
            'spk_id' => $spk->id,
            'akun' => AkunKas::Kas->value,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => 80000000,
        ])->assertSessionHasErrors('jumlah');

        fwrite(STDERR, "[3] Uang masuk 80jt (> piutang 70jt) DITOLAK ✅\n");
        $this->assertSame(70000000.0, $spk->fresh()->piutang(), 'Piutang berubah padahal input harus ditolak');

        // ── 4. UANG MASUK LUAR SPK (manual) TIDAK DIBATASI ─────────
        $this->post('/panel/cash-in', [
            'mode' => 'manual',
            'akun' => AkunKas::Bank->value,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => 500000000,
            'nomor_spk' => 'BUNGA-01',
            'nama_pekerjaan' => 'Bunga bank',
        ])->assertRedirect();

        fwrite(STDERR, "[4] Uang masuk luar SPK 500jt DITERIMA ✅\n");

        // ── 5. LUNASI sisa 70jt → status Dibayar ───────────────────
        $this->post('/panel/cash-in', [
            'mode' => 'spk',
            'spk_id' => $spk->id,
            'akun' => AkunKas::Kas->value,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => 70000000,
        ])->assertRedirect();

        $spk->refresh();
        fwrite(STDERR, '[5] Pelunasan 70jt → piutang='.$spk->piutang()
            .' status_tagihan='.$spk->status_tagihan->value."\n");
        $this->assertSame(0.0, $spk->piutang(), 'Piutang harus 0 setelah lunas');
        $this->assertSame(StatusTagihan::Dibayar, $spk->status_tagihan,
            'Status tagihan tidak auto-sync ke Dibayar saat lunas');

        // ── 6. UANG KELUAR tersimpan benar ─────────────────────────
        $komponen = Livewire::test(CashOutForm::class);
        $kunci = array_key_first($komponen->get('baris'));
        $komponen
            ->set("baris.$kunci.tanggal", now()->format('Y-m-d'))
            ->set("baris.$kunci.jumlah", '1500000')
            ->set("baris.$kunci.kategori", KategoriPengeluaran::Material->value)
            ->set("baris.$kunci.spk_id", $spk->id)
            ->call('simpan')
            ->assertHasNoErrors();

        $uk = UangKeluar::where('spk_id', $spk->id)->first();
        fwrite(STDERR, '[6] Uang keluar tersimpan: jumlah='.($uk?->jumlah ?? 'NULL')
            .' kategori='.($uk?->kategori?->value ?? 'NULL')."\n");
        $this->assertNotNull($uk, 'Uang keluar tidak tersimpan');
        $this->assertSame(1500000.0, (float) $uk->jumlah, 'Nominal uang keluar salah');
        $this->assertSame(KategoriPengeluaran::Material, $uk->kategori, 'Kategori uang keluar salah');

        // ── 7. Uang masuk TIDAK mengubah piutang SPK lain ──────────
        $spk2 = Spk::factory()->create(['nomor_spk' => 'E2E-002', 'nilai_spk' => 50000000]);
        fwrite(STDERR, '[7] SPK lain piutang tetap='.$spk2->piutang()." (harus 50jt)\n");
        $this->assertSame(50000000.0, $spk2->piutang(), 'totalPenerimaan bocor ke SPK lain');

        fwrite(STDERR, "\n✅ ALUR BISNIS LENGKAP SESUAI RULES.md\n");
    }

    public function test_spk_dibatalkan_tidak_menerima_transaksi(): void
    {
        $this->actingAs($this->admin());
        $spk = Spk::factory()->create(['nomor_spk' => 'E2E-BATAL', 'status_spk' => StatusSpk::Dibatalkan]);

        $this->post('/panel/cash-in', [
            'mode' => 'spk',
            'spk_id' => $spk->id,
            'akun' => AkunKas::Kas->value,
            'tanggal' => now()->format('Y-m-d'),
            'jumlah' => 1000000,
        ])->assertSessionHasErrors('spk_id');

        fwrite(STDERR, "\n[8] SPK Dibatalkan menolak transaksi ✅\n");
    }
}
