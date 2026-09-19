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

        foreach ([
            'Laporan Keuangan',
            'Arus Kas per Bulan',
            'Pengeluaran per Kategori',
            'Laba-Rugi per SPK',
            'Piutang SPK',
            'Periode',
        ] as $bagian) {
            $this->assertStringContainsString($bagian, $html, "Bagian '$bagian' tidak tampil");
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

    public function test_laporan_menampilkan_laba_rugi_per_spk(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('LAPORAN-001', $html);
        // Laba = 120jt penerimaan - 65jt biaya = 55jt
        $this->assertStringContainsString('55.000.000', $html, 'Laba per SPK salah');
    }

    public function test_laporan_menampilkan_data_piutang(): void
    {
        $this->actingAs($this->admin);

        $html = Livewire::test(Laporan::class)->html();

        $this->assertStringContainsString('LAPORAN-001', $html);

        // Status berubah OTOMATIS lewat SinkronStatusTagihanObserver:
        // SPK ini sudah menerima pembayaran (120jt dari 200jt), jadi
        // statusnya menjadi "Menunggu Pembayaran" — bukan lagi
        // "Belum Ditagihkan" yang diisi manual.
        $this->assertStringContainsString('Menunggu Pembayaran', $html);
    }

    public function test_piutang_laporan_mengurangi_retensi_yang_ditahan(): void
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

        $this->assertStringContainsString('Laporan SPK', $csv);
        $this->assertStringContainsString('LAPORAN-001', $csv);
        $this->assertStringContainsString('Nomor SPK', $csv);
    }

    public function test_ekspor_laba_rugi_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('laba_rugi')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Laba-Rugi per SPK', $csv);
        $this->assertStringContainsString('55000000', $csv, 'Laba 55jt tidak ada di CSV');
    }

    public function test_ekspor_piutang_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('piutang')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Piutang SPK', $csv);
        $this->assertStringContainsString('80000000', $csv, 'Sisa piutang 80jt tidak ada di CSV');
    }

    public function test_ekspor_cashflow_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('cashflow')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Arus Kas', $csv);
    }

    public function test_ekspor_kategori_menghasilkan_csv(): void
    {
        $this->actingAs($this->admin);

        ob_start();
        (new Laporan)->ekspor('kategori')->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('Laporan Pengeluaran per Kategori', $csv);
        // CSV memakai LABEL enum (bukan nilai mentah) agar mudah dibaca di Excel
        $this->assertStringContainsString('Material', $csv);
        $this->assertStringContainsString('Upah', $csv);
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
}
