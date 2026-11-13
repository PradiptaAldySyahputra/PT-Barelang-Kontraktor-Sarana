<?php

declare(strict_types=1);

namespace Tests\E2E;

use App\Enums\AkunKas;
use App\Enums\DikerjakanOleh;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Livewire\CashOut\CashOutForm;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Pengujian Alur Penuh (End-to-End) Siklus Operasional Proyek Kontraktor:
 *
 * 1. Admin login dan mendaftarkan Mitra & SPK Baru.
 * 2. SPK berpindah status Terbit -> Berjalan.
 * 3. Proyek berjalan: operasional dicatat di Uang Keluar.
 * 4. Proyek fisik selesai: status SPK jadi Selesai -> Tagihan terbit.
 * 5. (BAST dihapus 12 Nov 2026 - di luar ruang lingkup.)
 * 6. Pembayaran termin 1 diterima di Uang Masuk -> sisa piutang menyusut.
 * 7. Kuitansi resmi pembayaran dicetak PDF.
 * 8. Pembayaran pelunasan diterima -> status tagihan otomatis menjadi 'Dibayar' (Lunas).
 * 9. Sisa piutang menjadi Rp 0 dan SPK masuk ke arsip Tagihan Selesai.
 * 10. SPK yang dibatalkan tidak boleh menerima transaksi baru.
 */
class SiklusOperasionalProyekE2ETest extends TestCase
{
    use RefreshDatabase;

    public function test_siklus_penuh_operasional_kontrak_hingga_lunas(): void
    {
        $admin = Pengguna::factory()->create([
            'nama' => 'Admin Keuangan Operasional',
            'email' => 'admin.ops@bks.test',
            'peran' => Peran::Admin,
            'is_aktif' => true,
        ]);

        $direktur = Pengguna::factory()->create([
            'nama' => 'Direktur Utama Lapangan',
            'email' => 'direktur.ops@bks.test',
            'peran' => Peran::Direktur,
            'is_aktif' => true,
            'tanda_tangan' => 'profil/2026/11/06/ttd-direktur.png',
        ]);

        $mitra = Mitra::factory()->create([
            'nama' => 'PT PLN Batam Distribusi',
            'kontak' => '08123456789 (Ir. Setiawan)',
        ]);

        // Langkah 1: Pendaftaran SPK Baru bernilai Rp 100.000.000
        $spkData = [
            'nomor_spk' => '9901.SPK/E2E.01/BTM/2026',
            'nama_pekerjaan' => 'Pemasangan Jaringan Distribusi Udara 20kV Nagoya',
            'lokasi' => 'Nagoya, Batam',
            'nilai_spk' => '100.000.000',
            'mitra_id' => $mitra->id,
            'tanggal_spk' => '2026-08-01',
            'tanggal_akhir' => '2026-10-31',
            'status_antar' => StatusAntar::Belum->value,
            'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
            'keterangan' => 'Proyek pemeliharaan keandalan gardu trafo.',
        ];

        $resSpk = $this->actingAs($admin)->post(route('panel.spk.store'), $spkData);
        $resSpk->assertRedirect();

        $spk = Spk::where('nomor_spk', '9901.SPK/E2E.01/BTM/2026')->firstOrFail();
        $this->assertEquals(100000000, (float) $spk->nilai_spk);
        $this->assertEquals(StatusSpk::Draft, $spk->status_spk);
        $this->assertEquals(100000000, $spk->piutang());

        // Langkah 2: Update status SPK ke Berjalan
        $this->actingAs($admin)->put(route('panel.spk.status.update', $spk), [
            'status_spk' => StatusSpk::Berjalan->value,
            'keterangan' => 'Pekerjaan fisik tiang dan kabel dimulai.',
        ])->assertRedirect();

        $spk->refresh();
        $this->assertEquals(StatusSpk::Berjalan, $spk->status_spk);

        // Langkah 3: Belanja material dan operasional proyek (Uang Keluar via Livewire Form)
        $komponenKeluar = Livewire::actingAs($admin)->test(CashOutForm::class);
        $kunciKeluar = array_key_first($komponenKeluar->get('baris'));
        $komponenKeluar->set("baris.{$kunciKeluar}.tanggal", '2026-08-15');
        $komponenKeluar->set("baris.{$kunciKeluar}.akun", AkunKas::Bank->value);
        $komponenKeluar->set("baris.{$kunciKeluar}.jumlah", '15.000.000');
        $komponenKeluar->set("baris.{$kunciKeluar}.kategori", KategoriPengeluaran::Material->value);
        $komponenKeluar->set("baris.{$kunciKeluar}.spk_id", $spk->id);
        $komponenKeluar->set("baris.{$kunciKeluar}.penerima", 'Toko Besi Batam Maju');
        $komponenKeluar->set("baris.{$kunciKeluar}.keterangan", 'Beli tiang beton dan kabel tembaga');
        $komponenKeluar->call('simpan')->assertHasNoErrors();

        $this->assertDatabaseHas('uang_keluar', [
            'spk_id' => $spk->id,
            'jumlah' => 15000000,
            'kategori' => KategoriPengeluaran::Material->value,
        ]);

        // Langkah 4: Pekerjaan selesai & dokumen ditagihkan ke PLN Batam
        $this->actingAs($admin)->put(route('panel.spk.status.update', $spk), [
            'status_spk' => StatusSpk::Selesai->value,
            'keterangan' => 'Fisik 100% rampung, siap uji beban.',
        ])->assertRedirect();

        $this->actingAs($admin)->put(route('panel.spk.billing.update', $spk), [
            'status_tagihan' => StatusTagihan::SudahDitagihkan->value,
            'tanggal_antar' => '2026-10-25',
            'status_antar' => StatusAntar::Diterima->value,
        ])->assertRedirect();

        $spk->refresh();
        $this->assertEquals(StatusSpk::Selesai, $spk->status_spk);
        $this->assertEquals(StatusTagihan::SudahDitagihkan, $spk->status_tagihan);

        // Langkah 6: Termin 1 Masuk Rp 40.000.000
        $resMasuk1 = $this->actingAs($admin)->post(route('panel.cash-in.store'), [
            'mode' => 'spk',
            'tanggal' => '2026-11-01',
            'akun' => AkunKas::Bank->value,
            'jumlah' => '40.000.000',
            'spk_id' => $spk->id,
            'keterangan' => 'Pencairan termin 1 dari PLN Batam',
        ]);
        $resMasuk1->assertSessionHasNoErrors();
        $resMasuk1->assertRedirect();

        $spk->refresh();
        $this->assertEquals(40000000, $spk->totalPenerimaan());
        $this->assertEquals(60000000, $spk->piutang());
        $this->assertEquals(StatusTagihan::MenungguPembayaran, $spk->status_tagihan);

        // Langkah 7: Cetak Kuitansi Resmi Termin 1
        $uangMasuk1 = UangMasuk::where('spk_id', $spk->id)->firstOrFail();
        $resKuitansi = $this->actingAs($admin)->get(route('panel.cash-in.kuitansi', $uangMasuk1));
        $resKuitansi->assertOk();
        $resKuitansi->assertHeader('content-type', 'application/pdf');

        // Langkah 8: Pelunasan Sisa Termin Rp 60.000.000
        $resMasuk2 = $this->actingAs($admin)->post(route('panel.cash-in.store'), [
            'mode' => 'spk',
            'tanggal' => '2026-11-05',
            'akun' => AkunKas::Bank->value,
            'jumlah' => '60.000.000',
            'spk_id' => $spk->id,
            'keterangan' => 'Pelunasan termin akhir 100%',
        ]);
        $resMasuk2->assertSessionHasNoErrors();
        $resMasuk2->assertRedirect();

        // Langkah 9: Verifikasi Status Lunas Otomatis
        $spk->refresh();
        $this->assertEquals(100000000, $spk->totalPenerimaan());
        $this->assertEquals(0, $spk->piutang());
        $this->assertEquals(StatusTagihan::Dibayar, $spk->status_tagihan);

        // Langkah 10: Uji Proteksi SPK Dibatalkan
        $spkBatal = Spk::factory()->create([
            'status_spk' => StatusSpk::Dibatalkan,
            'nilai_spk' => 20000000,
        ]);

        $resTolakMasuk = $this->actingAs($admin)->post(route('panel.cash-in.store'), [
            'mode' => 'spk',
            'tanggal' => now()->toDateString(),
            'akun' => AkunKas::Kas->value,
            'jumlah' => '5.000.000',
            'spk_id' => $spkBatal->id,
            'keterangan' => 'Uji uang masuk ditolak',
        ]);
        $resTolakMasuk->assertSessionHasErrors(['spk_id']);

        // Uang keluar ditolak untuk SPK dibatalkan
        $komponenBatal = Livewire::actingAs($admin)->test(CashOutForm::class);
        $kunciBatal = array_key_first($komponenBatal->get('baris'));
        $komponenBatal->set("baris.{$kunciBatal}.tanggal", now()->toDateString());
        $komponenBatal->set("baris.{$kunciBatal}.akun", AkunKas::Kas->value);
        $komponenBatal->set("baris.{$kunciBatal}.jumlah", '2.000.000');
        $komponenBatal->set("baris.{$kunciBatal}.kategori", KategoriPengeluaran::Operasional->value);
        $komponenBatal->set("baris.{$kunciBatal}.spk_id", $spkBatal->id);
        $komponenBatal->call('simpan')->assertHasErrors(["baris.{$kunciBatal}.spk_id"]);
    }
}
