<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\DikerjakanOleh;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Uji REVISI USER:
 *   1. SPK menandai pelaksana: dikerjakan sendiri atau disubkonkan.
 *   2. Input uang keluar 4 sekaligus (halaman massal).
 */
class PelaksanaDanMassalTest extends TestCase
{
    use RefreshDatabase;

    private Pengguna $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Pengguna::factory()->admin()->create(['email' => 'admin-pel@bks.test']);
    }

    // =========================================================
    // 1. PELAKSANA PEKERJAAN (sendiri / subkon)
    // =========================================================

    public function test_enum_pelaksana_punya_dua_pilihan(): void
    {
        $this->assertCount(2, DikerjakanOleh::cases());
        $this->assertSame(['sendiri', 'subkon'], array_column(DikerjakanOleh::cases(), 'value'));
        $this->assertSame('Dikerjakan Sendiri', DikerjakanOleh::Sendiri->label());
        $this->assertSame('Disubkonkan', DikerjakanOleh::Subkon->label());
    }

    public function test_spk_default_dikerjakan_sendiri(): void
    {
        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'PEL-1',
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertSame(DikerjakanOleh::Sendiri, $spk->fresh()->dikerjakan_oleh);
        $this->assertFalse($spk->fresh()->isDisubkonkan());
    }

    public function test_spk_bisa_ditandai_disubkonkan(): void
    {
        $subkon = Mitra::factory()->subkon()->create(['nama' => 'CV Contoh Subkon']);

        $spk = Spk::factory()->pln()->disubkonkan()->create([
            'nomor_spk' => 'PEL-SUBKON-1',
            'subkon_id' => $subkon->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $spk = $spk->fresh();

        $this->assertSame(DikerjakanOleh::Subkon, $spk->dikerjakan_oleh);
        $this->assertTrue($spk->isDisubkonkan());
        $this->assertSame('CV Contoh Subkon', $spk->subkon?->nama);
    }

    public function test_scope_disubkonkan_dan_dikerjakan_sendiri(): void
    {
        $subkon = Mitra::factory()->subkon()->create();

        Spk::factory()->pln()->create(['nomor_spk' => 'SC-1', 'dibuat_oleh' => $this->admin->id]);
        Spk::factory()->pln()->disubkonkan()->create([
            'nomor_spk' => 'SC-2',
            'subkon_id' => $subkon->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertSame(['SC-2'], Spk::disubkonkan()->pluck('nomor_spk')->all());
        $this->assertSame(['SC-1'], Spk::dikerjakanSendiri()->pluck('nomor_spk')->all());
    }

    public function test_kasus_5_gardu_dibuat_dua_spk(): void
    {
        // Contoh user: bangun 5 gardu — 3 dikerjakan sendiri, 2 disubkonkan.
        // Karena schema dibatasi 5 tabel, dibuat 2 SPK terpisah.
        $subkon = Mitra::factory()->subkon()->create(['nama' => 'CV Mitra Gardu']);

        $sendiri = Spk::factory()->pln()->create([
            'nomor_spk' => 'GARDU-1-3',
            'nama_pekerjaan' => 'Bangun Gardu 1-3 (sendiri)',
            'nilai_spk' => 300_000_000,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $subkonkan = Spk::factory()->pln()->disubkonkan()->create([
            'nomor_spk' => 'GARDU-4-5',
            'nama_pekerjaan' => 'Bangun Gardu 4-5 (subkon)',
            'nilai_spk' => 200_000_000,
            'subkon_id' => $subkon->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $this->assertFalse($sendiri->fresh()->isDisubkonkan());
        $this->assertTrue($subkonkan->fresh()->isDisubkonkan());

        // Total nilai tetap 500jt
        $this->assertSame(500_000_000.0, (float) Spk::sum('nilai_spk'));
    }

    public function test_form_spk_punya_pilihan_pelaksana(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/spks/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Dikerjakan Oleh', $html);
        $this->assertStringContainsString('Dikerjakan Sendiri', $html);
        $this->assertStringContainsString('Disubkonkan', $html);
    }

    public function test_list_spk_menampilkan_kolom_pelaksana(): void
    {
        $subkon = Mitra::factory()->subkon()->create();

        Spk::factory()->pln()->disubkonkan()->create([
            'nomor_spk' => 'TAMPIL-SUBKON',
            'subkon_id' => $subkon->id,
            'dibuat_oleh' => $this->admin->id,
        ]);

        $html = $this->actingAs($this->admin)
            ->get('/admin/spks')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('Pelaksana', $html);
        $this->assertStringContainsString('Subkon', $html);
    }

    // =========================================================
    // 2. INPUT UANG KELUAR 4 SEKALIGUS (di halaman Tambah Uang Keluar)
    // =========================================================

    public function test_halaman_tambah_uang_keluar_bisa_dibuka(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk();
    }

    public function test_halaman_tambah_menyiapkan_1_baris_awal(): void
    {
        // Revisi user: baris TIDAK lagi tetap 4 — jumlahnya mengikuti
        // jumlah nota yang diunggah. Tanpa nota, disediakan 1 baris kosong.
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->assertSet('data.pengeluaran', function ($value): bool {
                return is_array($value) && count($value) === 1;
            });
    }

    public function test_halaman_tambah_punya_unggah_nota(): void
    {
        $html = $this->actingAs($this->admin)
            ->get('/admin/uang-keluars/create')
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('berkas_nota', $html);
        $this->assertStringContainsString('Unggah Berkas Nota', $html);
    }

    public function test_simpan_4_pengeluaran_sekaligus(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 5_000_000, 'kategori' => 'material', 'penerima' => 'Toko A'],
                    ['tanggal' => '2026-09-02', 'jumlah' => 3_000_000, 'kategori' => 'upah', 'penerima' => 'Mandor B'],
                    ['tanggal' => '2026-09-03', 'jumlah' => 1_500_000, 'kategori' => 'transportasi', 'penerima' => 'Driver C'],
                    ['tanggal' => '2026-09-04', 'jumlah' => 750_000, 'kategori' => 'operasional', 'penerima' => 'Kantor'],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(4, UangKeluar::count());
        $this->assertSame(10_250_000.0, (float) UangKeluar::sum('jumlah'));
    }

    public function test_baris_kosong_tidak_tersimpan(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 2_000_000, 'kategori' => 'material'],
                    ['tanggal' => null, 'jumlah' => null, 'kategori' => null],
                    ['tanggal' => null, 'jumlah' => null, 'kategori' => null],
                    ['tanggal' => null, 'jumlah' => null, 'kategori' => null],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count(), 'Hanya baris terisi yang disimpan');
    }

    public function test_baris_terisi_sebagian_ditolak(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    ['tanggal' => '2026-09-01', 'jumlah' => 1_000_000, 'kategori' => 'material'],
                    ['tanggal' => '2026-09-02', 'jumlah' => null, 'kategori' => 'upah'], // jumlah kosong
                ],
            ])
            ->call('create');

        // Baris tidak lengkap ditolak — TIDAK ADA yang tersimpan
        // (semua atau tidak sama sekali, supaya tidak ada data setengah jadi).
        $this->assertSame(0, UangKeluar::count(), 'Baris tidak lengkap membatalkan seluruh penyimpanan');
    }

    public function test_kalau_semua_kosong_tidak_menyimpan_apa_pun(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => array_fill(0, 4, ['tanggal' => null, 'jumlah' => null, 'kategori' => null]),
            ])
            ->call('create');

        $this->assertSame(0, UangKeluar::count());
    }

    public function test_tidak_ada_lagi_menu_input_massal_terpisah(): void
    {
        // Menu terpisah sudah dihapus; semuanya lewat Tambah Uang Keluar.
        $this->actingAs($this->admin)
            ->get('/admin/input-uang-keluar-massal')
            ->assertNotFound();
    }

    public function test_uang_keluar_tidak_bisa_diakses_tamu(): void
    {
        $this->get('/admin/uang-keluars/create')->assertRedirect('/admin/login');
    }

    // =========================================================
    // 3. BATAS NOMINAL UANG KELUAR (temuan bug Rp 250 M)
    // =========================================================

    public function test_uang_keluar_menolak_nominal_tidak_wajar(): void
    {
        $this->actingAs($this->admin);

        // Rp 250 miliar — "upah tukang". Melebihi batas Rp 10 miliar.
        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->toDateString(),
                        'jumlah' => 250_000_000_000,
                        'kategori' => 'upah',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasFormErrors(['pengeluaran.0.jumlah']);

        $this->assertSame(0, UangKeluar::count());
    }

    public function test_uang_keluar_menerima_nominal_wajar(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm([
                'pengeluaran' => [
                    [
                        'tanggal' => now()->toDateString(),
                        'jumlah' => 25_000_000,
                        'kategori' => 'upah',
                        'penerima' => 'Mandor',
                    ],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, UangKeluar::count());
    }
}
