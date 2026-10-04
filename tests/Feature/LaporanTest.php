<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriPengeluaran;
use App\Enums\StatusTagihan;
use App\Filament\Pages\Laporan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji halaman Laporan.
 */
class LaporanTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    private Spk $spk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'email' => 'admin-lap@bks.test',
        ]);
        $this->direktur = Pengguna::factory()->direktur()->create([
            'email' => 'dir-lap@bks.test',
        ]);

        $this->spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'LAPORAN-001',
            'nama_pekerjaan' => 'Pekerjaan Laporan',
            'nilai_spk' => 200_000_000,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
            'mitra_id' => Mitra::factory()->pln()->create(['nama' => 'PT PLN Batam']),
            'dibuat_oleh' => $this->admin->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $this->spk->id,
            'jumlah' => 120_000_000,
            'tanggal' => now()->subMonth(),
            'mitra_id' => null,
        ]);
        UangMasuk::factory()->create([
            'spk_id' => null,
            'nama_pekerjaan' => 'Penjualan sisa',
            'jumlah' => 5_000_000,
            'tanggal' => now(),
            'mitra_id' => null,
        ]);
        UangKeluar::factory()->create([
            'spk_id' => $this->spk->id,
            'kategori' => KategoriPengeluaran::Material,
            'jumlah' => 40_000_000,
            'tanggal' => now()->subMonth(),
        ]);
        UangKeluar::factory()->create([
            'spk_id' => $this->spk->id,
            'kategori' => KategoriPengeluaran::Upah,
            'jumlah' => 25_000_000,
            'tanggal' => now(),
        ]);
    }

    // ---------------------------------------------------------
    // Akses halaman
    // ---------------------------------------------------------

    public function test_admin_bisa_buka_laporan(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/laporan')
            ->assertOk();
    }

    public function test_direktur_bisa_buka_laporan(): void
    {
        $this->actingAs($this->direktur)
            ->get('/admin/laporan')
            ->assertOk();
    }

    public function test_tamu_tidak_bisa_buka_laporan(): void
    {
        $this->get('/admin/laporan')->assertRedirect('/admin/login');
    }

    // ---------------------------------------------------------
    // Isi laporan
    // ---------------------------------------------------------

    public function test_laporan_menampilkan_semua_bagian(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        // ⚠️ KEPUTUSAN USER: laba/rugi, aging, retensi DIHAPUS.
        // PIUTANG tetap ada (PRD FR-RPT-005, datanya nyata).
        foreach ([
            'Ringkasan',
            'Arus Uang per Bulan',
            'Pengeluaran per Kategori',
            'Piutang (Belum Diterima)',
            'Daftar SPK',
            'Tenggat SPK',
            'Bulan Ini',
        ] as $bagian) {
            $this->assertStringContainsString($bagian, $html, "Bagian '$bagian' tidak tampil");
        }
    }

    /**
     * ⚠️ PERBAIKAN UI (2 Okt 2026):
     * Dulu SATU dropdown ekspor berisi 5 laporan × 3 format = 15 baris
     * menumpuk di atas halaman. Sekarang tiap bagian laporan punya tombol
     * ekspor SENDIRI di header-nya.
     *
     * Tes ini menjaga agar setiap bagian tetap punya jalan ekspor, dan
     * rute ekspor untuk tiap jenis laporan tetap terpasang.
     */
    public function test_setiap_bagian_punya_tombol_ekspor_sendiri(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        // Tiap jenis laporan harus punya tautan ekspor di halaman.
        foreach (['spk', 'piutang', 'masuk', 'keluar', 'tenggat'] as $jenis) {
            $this->assertStringContainsString(
                route('laporan.ekspor', ['jenis' => $jenis, 'format' => 'xlsx']),
                $html,
                "Tautan ekspor Excel untuk laporan '$jenis' tidak ada",
            );
            $this->assertStringContainsString(
                route('laporan.ekspor', ['jenis' => $jenis, 'format' => 'pdf']),
                $html,
                "Tautan ekspor PDF untuk laporan '$jenis' tidak ada",
            );
        }
    }

    public function test_laporan_menghitung_total_dengan_benar(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        // Masuk 125jt (120jt dari SPK + 5jt luar), keluar 65jt, saldo 60jt
        $this->assertStringContainsString('125.000.000', $html, 'Total uang masuk salah');
        $this->assertStringContainsString('65.000.000', $html, 'Total uang keluar salah');
        $this->assertStringContainsString('60.000.000', $html, 'Saldo bersih salah');
        $this->assertStringContainsString('80.000.000', $html, 'Piutang salah');
    }

    public function test_piutang_laporan_sederhana(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        // SPK di test ini tanpa retensi -> piutang = 200jt - 120jt = 80jt
        $this->assertStringContainsString('80.000.000', $html);
    }

    public function test_label_kategori_enum_tampil_bukan_nilai_mentah(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        // Harus tampil label "Material" dan "Upah", bukan "material"/"upah"
        $this->assertStringContainsString('Material', $html);
        $this->assertStringContainsString('Upah', $html);
    }

    // ---------------------------------------------------------
    // Filter periode
    // ---------------------------------------------------------

    public function test_filter_periode_bisa_diubah(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(Laporan::class)
            ->assertSet('periode', 12)
            ->call('setPeriode', 1)
            ->assertSet('periode', 1);

        Livewire::test(Laporan::class)
            ->call('setPeriode', 0)
            ->assertSet('periode', 0);
    }

    public function test_periode_semua_menampilkan_seluruh_data(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)
            ->call('setPeriode', 0)
            ->html();

        $this->assertStringContainsString('LAPORAN-001', $html);
    }

    // ---------------------------------------------------------
    // Ekspor CSV
    // ---------------------------------------------------------

    public function test_ekspor_spk_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        $res = (new Laporan)->ekspor('spk');

        $this->assertSame(200, $res->getStatusCode());
        $this->assertStringContainsString('text/csv', $res->headers->get('Content-Type'));

        ob_start();
        $res->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Daftar SPK', $csv);
        $this->assertStringContainsString('LAPORAN-001', $csv);
        $this->assertStringContainsString('Nomor SPK', $csv);
    }

    public function test_ekspor_masuk_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('masuk')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Uang Masuk per Bulan', $csv);
        $this->assertStringContainsString('Total Masuk', $csv);
    }

    public function test_ekspor_keluar_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('keluar')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Uang Keluar per Kategori', $csv);
        $this->assertStringContainsString('Material', $csv);
    }

    public function test_ekspor_spk_menghasilkan_csv2(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('spk')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Daftar SPK', $csv);
    }

    public function test_ekspor_tenggat_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('tenggat')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Tenggat SPK', $csv);
        $this->assertStringContainsString('Sisa Hari', $csv);
    }

    public function test_direktur_bisa_ekspor_laporan(): void
    {
        $this->actingAs($this->direktur);

        $res = (new Laporan)->ekspor('spk');

        $this->assertSame(200, $res->getStatusCode());
    }

    public function test_csv_punya_bom_untuk_excel(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('spk')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv, 'CSV harus diawali BOM agar Excel membaca UTF-8');
    }

    // ---------------------------------------------------------
    // PEMBARUAN TAMPILAN & FITUR LAPORAN (2 Okt 2026)
    // ---------------------------------------------------------

    /**
     * ⚠️ PERMINTAAN USER (2 Okt 2026): "update terbaru pada laporan saya rasa
     * masih kurang juga tampilan dan fiturnya".
     *
     * Saldo "Masuk − Keluar" tadinya hanya angka merah/hijau tanpa label, jadi
     * admin harus menafsirkan sendiri. Sekarang diberi status yang jelas:
     * "Surplus" kalau positif, "Defisit" kalau negatif.
     */
    public function test_ringkasan_menampilkan_status_surplus_atau_defisit(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertMatchesRegularExpression(
            '/Surplus|Defisit/',
            $html,
            'Saldo harus diberi status Surplus/Defisit supaya jelas.'
        );
    }

    /**
     * ⚠️ PERMINTAAN USER: laporan terasa "kurang". Angka bulanan susah
     * dibandingkan tanpa gambaran visual. Ditambah tren arus uang (batang
     * CSS sederhana, tanpa pustaka chart baru).
     */
    public function test_laporan_menampilkan_tren_arus_uang(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('Tren', $html, 'Bagian tren arus uang tidak tampil.');
    }

    /**
     * Data jumlah mitra & transaksi sudah dihitung di getViewData() tetapi
     * tidak pernah ditampilkan. Ditampilkan sebagai konteks di bawah ringkasan
     * supaya admin tahu seberapa besar data yang mendasarinya.
     */
    public function test_ringkasan_menampilkan_konteks_jumlah_data(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('Mitra', $html);
        $this->assertStringContainsString('Transaksi', $html);
    }
}
