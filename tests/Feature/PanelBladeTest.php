<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\Peran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PANEL BLADE BARU (/panel) - fase 0 migrasi.
 *
 * Yang diuji BUKAN "halaman terbuka", tapi tiga hal yang mudah rusak diam-diam:
 *
 *   1. Pintu masuk  - tamu diarahkan ke /panel/login, akun nonaktif ditolak.
 *   2. Diferensiasi peran - Direktur melihat panel eksekutif, Admin melihat
 *      panel operasional. Bukan tampilan yang sama dengan sebagian disembunyikan.
 *   3. Menu sesuai hak akses - Manajemen Akun hanya Direktur, Backup/Impor/
 *      Status Sistem hanya Admin (disalin dari aturan Filament).
 *
 * Selama transisi, otorisasi sebenarnya tetap di middleware `peran:` pada
 * rute; menyembunyikan menu bukan pengamanan (Rules.md §4).
 */
class PanelBladeTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Admin]);
    }

    private function direktur(): Pengguna
    {
        return Pengguna::factory()->create(['peran' => Peran::Direktur]);
    }

    /* =====================================================
       Pintu masuk
       ===================================================== */

    public function test_tamu_diarahkan_ke_halaman_login_panel(): void
    {
        // Bukan ke /admin/login - tamu panel tidak boleh dilempar ke antarmuka lain.
        $this->get('/panel')->assertRedirect('/panel/login');
    }

    public function test_halaman_login_tampil(): void
    {
        $this->get('/panel/login')
            ->assertOk()
            ->assertSee('Masuk ke panel')
            ->assertSee('PT Barelang Kontraktor Sarana');
    }

    public function test_login_berhasil_membuka_dashboard(): void
    {
        $admin = $this->admin();

        $this->post('/panel/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('panel.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_ditolak_bila_sandi_salah(): void
    {
        $admin = $this->admin();

        $this->post('/panel/login', [
            'email' => $admin->email,
            'password' => 'sandi-keliru',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_ditolak_untuk_akun_nonaktif(): void
    {
        $nonaktif = Pengguna::factory()->create([
            'peran' => Peran::Admin,
            'is_aktif' => false,
        ]);

        $this->post('/panel/login', [
            'email' => $nonaktif->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_mengakhiri_sesi(): void
    {
        $this->actingAs($this->admin())
            ->post('/panel/logout')
            ->assertRedirect(route('panel.login'));

        $this->assertGuest();
    }

    /* =====================================================
       Diferensiasi peran
       ===================================================== */

    public function test_dashboard_admin_menampilkan_panel_operasional(): void
    {
        $this->actingAs($this->admin())
            ->get('/panel')
            ->assertOk()
            // Aksi cepat input - hanya Admin yang mencatat transaksi.
            ->assertSee('SPK Baru')
            ->assertSee('Uang Keluar')
            ->assertSee('Saldo Kas')
            ->assertSee('Saldo Bank')
            ->assertSee('Transaksi Terbaru')
            ->assertSee('SPK Berjalan')
            // Panel eksekutif Direktur tidak boleh ikut tampil.
            ->assertDontSee('SPK Prioritas Pantauan')
            ->assertDontSee('Tahapan Tagihan SPK');
    }

    public function test_dashboard_direktur_menampilkan_panel_eksekutif(): void
    {
        $admin = $this->admin();

        Spk::factory()->pln()->create([
            'nomor_spk' => 'PANEL-BLADE-999',
            'nilai_spk' => 350_000_000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $admin->id,
        ]);

        $this->actingAs($this->direktur())
            ->get('/panel')
            ->assertOk()
            ->assertSee('Arus Kas 6 Bulan')
            ->assertSee('Perbandingan uang masuk vs keluar 6 bulan terakhir')
            ->assertSee('Tahapan Tagihan SPK')
            ->assertSee('SPK Prioritas Pantauan')
            // SPK yang belum lunas harus muncul sebagai pantauan.
            ->assertSee('PANEL-BLADE-999')
            ->assertSee('350.000.000')
            // Direktur read-only: tidak ada tombol input.
            ->assertDontSee('SPK Baru')
            ->assertDontSee('Transaksi Terbaru');
    }

    public function test_angka_masuk_dan_keluar_tampil_di_dasbor_direktur(): void
    {
        $admin = $this->admin();

        $spk = Spk::factory()->pln()->create([
            'nomor_spk' => 'PANEL-ANGKA-001',
            'nilai_spk' => 200_000_000,
            'mitra_id' => Mitra::factory(),
            'dibuat_oleh' => $admin->id,
        ]);

        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 120_000_000,
            'mitra_id' => null,
        ]);
        UangKeluar::factory()->create(['spk_id' => $spk->id, 'jumlah' => 65_000_000]);

        $this->actingAs($this->direktur())
            ->get('/panel')
            ->assertOk()
            // Piutang = 200jt - 120jt = 80jt
            ->assertSee('80.000.000');
    }

    /* =====================================================
       Menu sesuai hak akses
       ===================================================== */

    public function test_menu_manajemen_akun_hanya_untuk_direktur(): void
    {
        $this->actingAs($this->admin())
            ->get('/panel')
            ->assertOk()
            ->assertDontSee('Manajemen Akun');

        $this->actingAs($this->direktur())
            ->get('/panel')
            ->assertOk()
            ->assertSee('Manajemen Akun');
    }

    public function test_menu_sistem_tampil_untuk_admin_dan_direktur(): void
    {
        foreach ([$this->admin(), $this->direktur()] as $pengguna) {
            $this->actingAs($pengguna)
                ->get('/panel')
                ->assertOk()
                ->assertSee('Status Sistem')
                ->assertSee('Impor Data');
        }
    }

    public function test_menu_umum_tampil_untuk_kedua_peran(): void
    {
        foreach ([$this->admin(), $this->direktur()] as $pengguna) {
            $this->actingAs($pengguna)
                ->get('/panel')
                ->assertOk()
                ->assertSee('List SPK')
                ->assertSee('Uang Masuk')
                ->assertSee('Arsip Nota')
                ->assertSee('Laporan')
                ->assertSee('Mitra');
        }
    }

    public function test_semua_menu_sudah_menunjuk_ke_panel_baru(): void
    {
        // Migrasi UI selesai: tidak boleh ada lagi item menu yang menaut ke
        // /admin (Filament). Kalau test ini gagal, ada modul yang tertinggal.
        $this->actingAs($this->admin())
            ->get('/panel')
            ->assertOk()
            ->assertSee('/panel/spk', false)
            ->assertSee('/panel/cash-in', false)
            ->assertSee('/panel/cash-out', false)
            ->assertSee('/panel/spk/monitoring/billing', false)
            ->assertDontSee('/admin/', false);
    }
}
