<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\ImporTransaksi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImporSpkTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Mitra $mitraPln;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->create([
            'peran' => Peran::Admin,
        ]);

        $this->mitraPln = Mitra::factory()->pln()->create([
            'nama' => 'PT PLN Batam',
        ]);
    }

    public function test_impor_spk_bernomor_resmi(): void
    {
        $baris = [
            [
                'nomor_spk' => '0001.SPK/DAN.01.03/PLNBATAM020300/2026',
                'tanggal_spk' => '2026-01-05',
                'nama_pekerjaan' => 'Pemasangan Jaringan Pelanggan',
                'lokasi' => 'Batam Tersebar',
                'nilai_spk' => 20_000_000,
                'mitra' => 'PT PLN Batam',
                'catatan_bayar' => '',
            ],
        ];

        $hasil = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);

        $this->assertSame(1, $hasil['ditambah']);
        $this->assertSame(0, $hasil['dilewati']);
        $this->assertCount(0, $hasil['gagal']);

        $spk = Spk::first();
        $this->assertNotNull($spk);
        $this->assertSame('0001.SPK/DAN.01.03/PLNBATAM020300/2026', $spk->nomor_spk);
        $this->assertSame('2026-01-05', $spk->tanggal_spk?->toDateString());
        $this->assertSame('20000000.00', $spk->nilai_spk);
        $this->assertSame($this->mitraPln->id, $spk->mitra_id);
        $this->assertSame(StatusSpk::Berjalan, $spk->status_spk);
        $this->assertSame(StatusTagihan::BelumDitagihkan, $spk->status_tagihan);
    }

    public function test_impor_spk_tanpa_spk_membuat_sequence_nomor_otomatis(): void
    {
        $baris = [
            [
                'nomor_spk' => '',
                'tanggal_spk' => 'TANPA SPK',
                'nama_pekerjaan' => 'Bahan Bakar Genset 420 Liter',
                'lokasi' => 'Kantor',
                'nilai_spk' => 5_565_000,
            ],
            [
                'nomor_spk' => 'TANPA SPK',
                'tanggal_spk' => '',
                'nama_pekerjaan' => 'Pemeliharaan Gedung Area PLN',
                'lokasi' => 'AP Tiban',
                'nilai_spk' => 32_314_000,
            ],
        ];

        $hasil = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);

        $this->assertSame(2, $hasil['ditambah']);
        $this->assertSame(0, $hasil['dilewati']);

        $spk1 = Spk::where('nama_pekerjaan', 'Bahan Bakar Genset 420 Liter')->first();
        $this->assertNotNull($spk1);
        $this->assertSame('TANPA-SPK-0001', $spk1->nomor_spk);
        $this->assertNull($spk1->tanggal_spk);

        $spk2 = Spk::where('nama_pekerjaan', 'Pemeliharaan Gedung Area PLN')->first();
        $this->assertNotNull($spk2);
        $this->assertSame('TANPA-SPK-0002', $spk2->nomor_spk);
        $this->assertNull($spk2->tanggal_spk);
    }

    public function test_impor_spk_cegah_duplikat_nomor_dan_tanpa_spk(): void
    {
        $baris = [
            [
                'nomor_spk' => '0002.SPK/DAN.01.03/PLNBATAM020300/2026',
                'nama_pekerjaan' => 'Pekerjaan A',
                'nilai_spk' => 10_000_000,
            ],
            [
                'nomor_spk' => 'TANPA SPK',
                'nama_pekerjaan' => 'Pekerjaan B',
                'nilai_spk' => 5_000_000,
            ],
        ];

        $pertama = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);
        $this->assertSame(2, $pertama['ditambah']);

        // Impor ulang berkas yang sama
        $kedua = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);
        $this->assertSame(0, $kedua['ditambah']);
        $this->assertSame(2, $kedua['dilewati']);
        $this->assertSame(2, Spk::count());
    }

    public function test_impor_spk_dengan_catatan_bayar_lunas_langsung_status_dibayar(): void
    {
        $baris = [
            [
                'nomor_spk' => '0003.SPK/DAN.01.03/PLNBATAM020300/2026',
                'nama_pekerjaan' => 'Pekerjaan C',
                'nilai_spk' => 15_000_000,
                'catatan_bayar' => 'sudah masuk ke rek bks',
            ],
        ];

        $hasil = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);
        $this->assertSame(1, $hasil['ditambah']);

        $spk = Spk::where('nomor_spk', '0003.SPK/DAN.01.03/PLNBATAM020300/2026')->first();
        $this->assertNotNull($spk);
        $this->assertSame(StatusTagihan::Dibayar, $spk->status_tagihan);
    }

    public function test_berbagai_format_tanggal_pada_impor(): void
    {
        $baris = [
            [
                'nomor_spk' => 'SPK-TGL-1',
                'tanggal_spk' => '26/06/2026',
                'nama_pekerjaan' => 'Pekerjaan Tgl 1',
                'nilai_spk' => 1_000_000,
            ],
            [
                'nomor_spk' => 'SPK-TGL-2',
                'tanggal_spk' => '2/7/26',
                'nama_pekerjaan' => 'Pekerjaan Tgl 2',
                'nilai_spk' => 2_000_000,
            ],
            [
                'nomor_spk' => 'SPK-TGL-3',
                'tanggal_spk' => '26-06-2026',
                'nama_pekerjaan' => 'Pekerjaan Tgl 3',
                'nilai_spk' => 3_000_000,
            ],
            [
                'nomor_spk' => 'SPK-TGL-4',
                'tanggal_spk' => 45469, // 2024-06-26 dalam serial Excel
                'nama_pekerjaan' => 'Pekerjaan Tgl 4',
                'nilai_spk' => 4_000_000,
            ],
        ];

        $hasil = ImporTransaksi::spk($baris, dibuatOleh: $this->admin->id);
        $this->assertSame(4, $hasil['ditambah']);

        $this->assertSame('2026-06-26', Spk::where('nomor_spk', 'SPK-TGL-1')->first()?->tanggal_spk?->toDateString());
        $this->assertSame('2026-07-02', Spk::where('nomor_spk', 'SPK-TGL-2')->first()?->tanggal_spk?->toDateString());
        $this->assertSame('2026-06-26', Spk::where('nomor_spk', 'SPK-TGL-3')->first()?->tanggal_spk?->toDateString());
        $this->assertSame('2024-06-26', Spk::where('nomor_spk', 'SPK-TGL-4')->first()?->tanggal_spk?->toDateString());
    }

    public function test_kategori_fallback_ke_lainnya_dengan_detail_kategori_tersimpan(): void
    {
        $baris = [
            [
                'tanggal' => '2026-01-05',
                'jumlah' => 250_000,
                'akun' => 'Kas',
                'kategori' => 'Kategori Tidak Dikenal',
                'keterangan' => 'Uji fallback kategori',
            ],
        ];

        $hasil = ImporTransaksi::uangKeluar($baris);
        $this->assertSame(1, $hasil['ditambah']);

        $uk = UangKeluar::first();
        $this->assertNotNull($uk);
        $this->assertSame('lainnya', $uk->kategori?->value);
        $this->assertSame('Kategori Tidak Dikenal', $uk->detail_kategori);
    }

    public function test_cari_spk_toleran_secara_parsial_pada_uang_masuk(): void
    {
        $spk = Spk::factory()->create([
            'nomor_spk' => '0187.SPK/DAN.01.02/PLNBATAM030300/2025',
            'nilai_spk' => 100_000_000,
        ]);

        $baris = [
            [
                'tanggal' => '2026-01-05',
                'jumlah' => 10_000_000,
                'akun' => 'Bank',
                'nomor_spk' => '0187.SPK', // pencarian parsial
                'keterangan' => 'Pembayaran termin 1',
            ],
        ];

        $hasil = ImporTransaksi::uangMasuk($baris);
        $this->assertSame(1, $hasil['ditambah']);

        $um = UangMasuk::first();
        $this->assertNotNull($um);
        $this->assertSame($spk->id, $um->spk_id);
    }

    public function test_upload_impor_spk_melalui_controller_dan_unduh_template(): void
    {
        Storage::fake('local');

        // Uji unduh template SPK
        $resTemplate = $this->actingAs($this->admin)->get(route('panel.import.template', ['jenis' => 'spk']));
        $resTemplate->assertOk();
        $resTemplate->assertHeader('content-type', 'text/csv; charset=UTF-8');

        // Uji post impor CSV SPK
        $konten = "nomor_spk,tanggal_spk,nama_pekerjaan,lokasi,nilai_spk,mitra,keterangan\n"
            ."0099.SPK/DAN.01.03/PLNBATAM020300/2026,2026-01-05,Pekerjaan Uji Web,Batam,50000000,PT PLN Batam,Keterangan uji\n";

        $file = UploadedFile::fake()->createWithContent('spk.csv', $konten);

        $resUpload = $this->actingAs($this->admin)->post(route('panel.import.store'), [
            'jenis' => 'spk',
            'berkas' => $file,
        ]);

        $resUpload->assertRedirect(route('panel.import'));
        $resUpload->assertSessionHas('berhasil');

        $this->assertDatabaseHas('spk', [
            'nomor_spk' => '0099.SPK/DAN.01.03/PLNBATAM020300/2026',
            'nama_pekerjaan' => 'Pekerjaan Uji Web',
        ]);
    }
}
