<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\KategoriMitra;
use App\Enums\KategoriPengeluaran;
use App\Enums\Peran;
use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\Mitras\Pages\CreateMitra;
use App\Filament\Resources\Mitras\Pages\ListMitras;
use App\Filament\Resources\Penggunas\Pages\CreatePengguna;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\Pages\ListUangKeluars;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\Pages\CreateUangMasuk;
use App\Filament\Resources\UangMasuks\Pages\ListUangMasuks;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji resource Filament: Mitra, Uang Masuk (2 mode), Uang Keluar, Pengguna.
 */
class FilamentResourceTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create([
            'nama' => 'Admin Uji',
            'email' => 'admin-res@bks.test',
        ]);

        $this->direktur = Pengguna::factory()->direktur()->create([
            'nama' => 'Direktur Uji',
            'email' => 'dir-res@bks.test',
        ]);
    }

    // =========================================================
    // MITRA
    // =========================================================

    public function test_admin_bisa_membuat_mitra(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateMitra::class)
            ->fillForm([
                'nama' => 'PT PLN Batam',
                'kategori' => KategoriMitra::Mitra->value,
                'kontak' => '0812-3456',
                'is_aktif' => true,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('mitra', [
            'nama' => 'PT PLN Batam',
            'kategori' => KategoriMitra::Mitra->value,
        ]);
    }

    public function test_form_mitra_menolak_kategori_ngawur(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateMitra::class)
            ->fillForm([
                'nama' => 'Mitra Ngawur',
                'kategori' => 'kategori_ngawur',
            ])
            ->call('create')
            ->assertHasFormErrors(['kategori']);
    }

    public function test_daftar_mitra_bisa_dibuka_dan_menampilkan_data(): void
    {
        $mitra = Mitra::factory()->create(['nama' => 'Vendor Uji']);
        $this->actingAs($this->admin);

        Livewire::test(ListMitras::class)
            ->assertOk()
            ->assertCanSeeTableRecords([$mitra]);
    }

    public function test_direktur_tidak_boleh_ubah_mitra(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(MitraResource::canCreate());
        $this->assertTrue(MitraResource::canViewAny());
    }

    // =========================================================
    // UANG MASUK — 2 MODE
    // =========================================================

    public function test_mode_spk_mengisi_nomor_dan_nama_pekerjaan_otomatis(): void
    {
        $mitra = Mitra::factory()->pln()->create();
        $spk = Spk::factory()->create([
            'nomor_spk' => 'AUTO-ISI-001',
            'nama_pekerjaan' => 'Pekerjaan Auto',
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm(['mode' => 'spk'])
            ->fillForm(['spk_id' => $spk->id])
            ->assertFormSet([
                'nomor_spk' => 'AUTO-ISI-001',
                'nama_pekerjaan' => 'Pekerjaan Auto',
            ]);
    }

    public function test_mode_spk_menyimpan_spk_id(): void
    {
        $mitra = Mitra::factory()->pln()->create();
        $spk = Spk::factory()->create([
            'nomor_spk' => 'MODE-SPK-001',
            // Nilai ditentukan agar nominal uji (Rp 50 jt) pasti di bawah
            // piutang. Tanpa ini, nilai acak factory bisa lebih kecil dan
            // validasi batas uang masuk menolaknya (test jadi flaky).
            'nilai_spk' => 200_000_000,
            'mitra_id' => $mitra->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'spk',
                'spk_id' => $spk->id,
                'tanggal' => '2026-08-15',
                'jumlah' => 50000000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $masuk = UangMasuk::where('spk_id', $spk->id)->first();

        $this->assertNotNull($masuk, 'Uang masuk mode SPK gagal dibuat');
        $this->assertTrue($masuk->isDariSpk());
        $this->assertSame('Dari SPK', $masuk->labelSumber());
        $this->assertEquals(50_000_000, (float) $masuk->jumlah);
    }

    public function test_mode_manual_menyimpan_spk_id_null(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'manual',
                'nomor_spk' => 'REF-MANUAL-1',
                'nama_pekerjaan' => 'Penjualan sisa material',
                'tanggal' => '2026-08-20',
                'jumlah' => 2500000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $masuk = UangMasuk::where('nama_pekerjaan', 'Penjualan sisa material')->first();

        $this->assertNotNull($masuk, 'Uang masuk mode manual gagal dibuat');
        $this->assertNull($masuk->spk_id, 'Mode manual seharusnya menyimpan spk_id NULL');
        $this->assertFalse($masuk->isDariSpk());
        $this->assertSame('Luar SPK', $masuk->labelSumber());
    }

    public function test_tab_dari_spk_dan_luar_spk_bekerja(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $dariSpk = UangMasuk::factory()->create(['spk_id' => $spk->id, 'mitra_id' => null]);
        $luarSpk = UangMasuk::factory()->create([
            'spk_id' => null,
            'nama_pekerjaan' => 'Luar',
            'mitra_id' => null,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(ListUangMasuks::class)
            ->assertCanSeeTableRecords([$dariSpk, $luarSpk])
            ->set('activeTab', 'dari_spk')
            ->assertCanSeeTableRecords([$dariSpk])
            ->assertCanNotSeeTableRecords([$luarSpk]);
    }

    public function test_uang_masuk_menolak_jumlah_nol(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'manual',
                'tanggal' => '2026-08-01',
                'jumlah' => 0,
            ])
            ->call('create')
            ->assertHasFormErrors(['jumlah']);
    }

    public function test_direktur_tidak_boleh_ubah_uang_masuk(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(UangMasukResource::canCreate());
        $this->assertFalse(UangMasukResource::canEdit(new UangMasuk));
        $this->assertTrue(UangMasukResource::canViewAny());
    }

    // =========================================================
    // UANG KELUAR
    // =========================================================

    public function test_admin_bisa_membuat_uang_keluar_terkait_spk(): void
    {
        /*
         * ⚠️ `berjalan()` WAJIB: factory Spk memakai status ACAK
         * (`fake()->randomElement(StatusSpk::cases())`). Tanpa state ini, tes
         * kadang mendapat SPK `Dibatalkan` — dan validasi Rules §5 butir 3
         * (SPK Dibatalkan tidak menerima transaksi) menolaknya. Itu membuat
         * tes ini FLAKY: lulus/gagal tanpa perubahan kode.
         */
        $spk = Spk::factory()->berjalan()->create([
            'nomor_spk' => 'KELUAR-SPK-001',
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => '2026-08-10',
                        'jumlah' => 40000000,
                        'kategori' => KategoriPengeluaran::Material->value,
                        'penerima' => 'Toko Bangunan Jaya',
                        'spk_id' => $spk->id,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $keluar = UangKeluar::where('spk_id', $spk->id)->first();

        $this->assertNotNull($keluar);
        $this->assertSame(KategoriPengeluaran::Material, $keluar->kategori);
        $this->assertTrue($keluar->isTerkaitSpk());
    }

    public function test_uang_keluar_boleh_tanpa_spk_untuk_operasional(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => '2026-08-11',
                        'jumlah' => 3000000,
                        'kategori' => KategoriPengeluaran::Operasional->value,
                        'penerima' => 'Kantor',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $keluar = UangKeluar::where('jumlah', 3000000)->first();

        $this->assertNotNull($keluar);
        $this->assertNull($keluar->spk_id);
        $this->assertFalse($keluar->isTerkaitSpk());
    }

    public function test_form_uang_keluar_menolak_kategori_typo(): void
    {
        $this->actingAs($this->admin);

        // Inilah yang mencegah laporan terpecah
        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => '2026-08-12',
                        'jumlah' => 1000000,
                        'kategori' => 'Material Bangunan',   // typo — tidak ada di enum
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors(['pengeluaran.0.kategori']);
    }

    public function test_semua_kategori_enum_diterima_form(): void
    {
        $this->actingAs($this->admin);

        // Sekarang form bisa mengisi 4 baris sekaligus; uji semua kategori
        // dalam satu kali simpan (4 baris pertama, lalu sisanya).
        $semua = KategoriPengeluaran::cases();

        foreach (array_chunk($semua, 4) as $chunk) {
            $baris = [];

            foreach ($chunk as $i => $kategori) {
                $baris[] = [
                    'tanggal' => '2026-08-13',
                    'jumlah' => 1_000_000 + $i,
                    'kategori' => $kategori->value,
                ];
            }

            Livewire::test(CreateUangKeluar::class)
                ->fillForm(['pengeluaran' => $baris])
                ->call('create')
                ->assertHasNoFormErrors();
        }

        $this->assertSame(count(KategoriPengeluaran::cases()), UangKeluar::count());
    }

    public function test_tab_terkait_spk_dan_umum_bekerja(): void
    {
        $spk = Spk::factory()->create([
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $terkait = UangKeluar::factory()->create(['spk_id' => $spk->id]);
        $umum = UangKeluar::factory()->create(['spk_id' => null]);

        $this->actingAs($this->admin);

        Livewire::test(ListUangKeluars::class)
            ->set('activeTab', 'terkait_spk')
            ->assertCanSeeTableRecords([$terkait])
            ->assertCanNotSeeTableRecords([$umum]);
    }

    public function test_direktur_tidak_boleh_ubah_uang_keluar(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(UangKeluarResource::canCreate());
        $this->assertTrue(UangKeluarResource::canViewAny());
    }

    // =========================================================
    // PENGGAJIAN & PENGGUNA
    // =========================================================

    public function test_direktur_bisa_membuat_pengguna_baru(): void
    {
        // ⚠️ REVISI USER: menu Pengguna hanya untuk Direktur.
        $this->actingAs($this->direktur);

        Livewire::test(CreatePengguna::class)
            ->fillForm([
                'nama' => 'Staf Baru',
                'email' => 'staf@bks.test',
                'peran' => Peran::Admin->value,
                'is_aktif' => true,
                'password' => 'rahasia12345',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $pengguna = Pengguna::where('email', 'staf@bks.test')->first();

        $this->assertNotNull($pengguna);
        $this->assertSame(Peran::Admin, $pengguna->peran);
    }

    public function test_form_pengguna_menolak_email_duplikat(): void
    {
        // ⚠️ REVISI USER: menu Pengguna hanya untuk Direktur.
        $this->actingAs($this->direktur);

        Livewire::test(CreatePengguna::class)
            ->fillForm([
                'nama' => 'Duplikat',
                'email' => 'admin-res@bks.test',   // sudah dipakai di setUp
                'peran' => Peran::Admin->value,
                'password' => 'rahasia12345',
            ])
            ->call('create')
            ->assertHasFormErrors(['email']);
    }

    public function test_admin_tidak_boleh_kelola_pengguna(): void
    {
        // ⚠️ REVISI USER: menu Pengguna HANYA untuk Direktur.
        // Jadi ADMIN yang tidak boleh — kebalikan dari resource lain.
        $this->actingAs($this->admin);

        $this->assertFalse(
            PenggunaResource::canCreate(),
            'Admin TIDAK boleh menambah pengguna'
        );
        $this->assertFalse(PenggunaResource::canViewAny());
    }

    public function test_direktur_boleh_kelola_pengguna(): void
    {
        $this->actingAs($this->direktur);

        $this->assertTrue(
            PenggunaResource::canCreate(),
            'Direktur HARUS bisa menambah pengguna'
        );
    }

    // =========================================================
    // INTEGRASI: laba-rugi per SPK lewat form
    // =========================================================

    public function test_laba_rugi_per_spk_terhitung_setelah_input_lewat_form(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'LABA-FORM-001',
            'nilai_spk' => 200000000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        // Uang masuk lewat form mode SPK
        Livewire::test(CreateUangMasuk::class)
            ->fillForm([
                'mode' => 'spk',
                'spk_id' => $spk->id,
                'tanggal' => '2026-08-01',
                'jumlah' => 120000000,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        // Uang keluar terkait SPK
        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => '2026-08-05',
                        'jumlah' => 65000000,
                        'kategori' => KategoriPengeluaran::Material->value,
                        'spk_id' => $spk->id,
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spk->refresh();

        $this->assertEquals(120_000_000, $spk->totalPenerimaan());
        $this->assertEquals(80_000_000, $spk->piutang());
    }
}
