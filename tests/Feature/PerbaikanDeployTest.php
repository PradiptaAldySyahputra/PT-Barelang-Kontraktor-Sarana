<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Exports\SpkExporter;
use App\Filament\Resources\Spks\Pages\EditSpk;
use App\Filament\Resources\UangKeluars\Pages\CreateUangKeluar;
use App\Filament\Resources\UangKeluars\Pages\EditUangKeluar;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Support\Format;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * REPRO BUG SAAT UJI DEPLOY (7 Okt 2026).
 * Tes ini menjaga perbaikan BUG-01/02/03 tetap bekerja.
 */
class PerbaikanDeployTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // BUG-01 — form Ubah Uang Keluar tidak bisa disimpan
    // ---------------------------------------------------------------
    public function test_bug01_edit_uang_keluar_bisa_disimpan(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'R1', 'nilai_spk' => 100_000_000]);
        $uk = UangKeluar::create([
            'tanggal' => '2026-09-01', 'jumlah' => 500000, 'kategori' => 'material', 'spk_id' => $spk->id,
        ]);

        Livewire::test(EditUangKeluar::class, ['record' => $uk->id])
            ->fillForm(['jumlah' => 600000])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('600000.00', $uk->fresh()->jumlah);
    }

    public function test_bug01_edit_uang_keluar_tanpa_spk_juga_bisa(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $uk = UangKeluar::create([
            'tanggal' => '2026-09-01', 'jumlah' => 250000, 'kategori' => 'operasional',
        ]);

        Livewire::test(EditUangKeluar::class, ['record' => $uk->id])
            ->fillForm(['jumlah' => 300000])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('300000.00', $uk->fresh()->jumlah);
    }

    // ---------------------------------------------------------------
    // BUG-02 — nominal tidak boleh tampil 100x lipat di form
    // ---------------------------------------------------------------
    public function test_bug02_format_untuk_input_membuang_desimal(): void
    {
        // Cast decimal:2 menghasilkan string berdesimal.
        $this->assertSame('10000', Format::untukInputUang('10000.00'));
        $this->assertSame('1000', Format::untukInputUang('1000.00'));
        $this->assertSame('1000000', Format::untukInputUang('1000000.00'));
        $this->assertSame('1501', Format::untukInputUang('1500.50'));
        $this->assertNull(Format::untukInputUang(null));
    }

    /**
     * ⚠️ INI TES INTI BUG-02 — menjaga agar state form benar-benar 10000,
     * bukan 1000000.
     *
     * Akar masalah: `StripCharactersStateCast` (dari `stripCharacters('.')`)
     * dijalankan Filament SEBELUM `NumberStateCast` saat hidrasi, sehingga
     * `"10000.00"` kehilangan titiknya menjadi `"1000000"`. Perbaikannya di
     * `mutateFormDataBeforeFill()`, dan tes ini mengunci perilaku itu.
     */
    public function test_bug02_state_form_spk_tidak_100x_lipat(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'B02', 'nilai_spk' => 10000]);

        $komponen = Livewire::test(EditSpk::class, ['record' => $spk->id]);

        $this->assertSame(
            10000.0,
            (float) $komponen->get('data.nilai_spk'),
            'BUG-02: state form SPK harus 10000, bukan 1000000 (100x lipat)',
        );
    }

    public function test_bug02_state_form_uang_keluar_tidak_100x_lipat(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $uk = UangKeluar::create([
            'tanggal' => '2026-09-01', 'jumlah' => 1500, 'kategori' => 'material',
        ]);

        $komponen = Livewire::test(EditUangKeluar::class, ['record' => $uk->id]);

        $this->assertSame(
            1500.0,
            (float) $komponen->get('data.jumlah'),
            'BUG-02: state form Uang Keluar harus 1500, bukan 150000',
        );
    }

    public function test_bug02_simpan_tanpa_mengetik_ulang_tidak_mengubah_nilai(): void
    {
        // Skenario paling berbahaya: admin buka Ubah lalu Simpan langsung.
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);
        $spk = Spk::factory()->pln()->create(['nomor_spk' => 'B02B', 'nilai_spk' => 10000]);

        Livewire::test(EditSpk::class, ['record' => $spk->id])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame(
            10000.0,
            (float) $spk->fresh()->nilai_spk,
            'BUG-02: simpan tanpa mengetik ulang tidak boleh mengubah nilai menjadi 100x',
        );
    }

    // ---------------------------------------------------------------
    // BUG-03 — ekspor butuh binding Authenticatable -> Pengguna
    // ---------------------------------------------------------------
    public function test_bug03_binding_authenticatable_ke_pengguna(): void
    {
        $this->assertSame(
            Pengguna::class,
            app(Authenticatable::class)::class,
        );
    }

    public function test_bug03_export_user_tidak_melempar_exception(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $export = new Export;
        $export->exporter = SpkExporter::class;
        $export->file_disk = 'local';
        $export->file_name = 'x.xlsx';
        $export->total_rows = 0;
        $export->user_id = $admin->id;
        $export->save();

        // Dulu ini melempar LogicException "No [App\Models\User] model found".
        $this->assertInstanceOf(Pengguna::class, $export->user);
    }

    // ---------------------------------------------------------------
    // BUG-04/05 — dilaporkan tapi TIDAK tereproduksi (bukan bug)
    // ---------------------------------------------------------------
    public function test_bug04_penerima_tersimpan_saat_create(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        Livewire::test(CreateUangKeluar::class)
            ->fillForm(['pengeluaran' => [[
                'tanggal' => '2026-09-01', 'jumlah' => 100000, 'kategori' => 'material',
                'penerima' => 'Toko Material Contoh',
            ]]])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('uang_keluar', ['penerima' => 'Toko Material Contoh']);
    }

    public function test_bug05_total_penerimaan_tidak_bocor_per_mitra(): void
    {
        $spkA = Spk::factory()->pln()->create(['nomor_spk' => 'A', 'nilai_spk' => 10_000_000]);
        $spkB = Spk::factory()->pln()->create(['nomor_spk' => 'B', 'nilai_spk' => 10_000_000]);

        UangMasuk::create(['spk_id' => $spkA->id, 'tanggal' => '2026-09-01', 'jumlah' => 5_000_000]);
        UangMasuk::create(['spk_id' => null, 'tanggal' => '2026-09-01', 'jumlah' => 5_000_000]);

        $this->assertSame(5000000.0, $spkA->totalPenerimaan(), 'spkA harus 5jt');
        $this->assertSame(0.0, $spkB->totalPenerimaan(), 'spkB harus 0 — tidak boleh bocor per mitra');
    }
}
