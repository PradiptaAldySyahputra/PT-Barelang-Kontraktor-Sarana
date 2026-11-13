<?php

declare(strict_types=1);

namespace Tests\Security;

use App\Enums\Peran;
use App\Enums\StatusSpk;
use App\Livewire\Receipt\ReceiptUploadForm;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Pengujian Edge Case Keamanan & Integritas Akun Pengguna:
 * 1. Self-Lock Prevention: Direktur tidak boleh bisa menghapus akunnya sendiri.
 * 2. Audit Trail Preservation: Pengguna yang tercatat membuat SPK dilarang dihapus hard/soft delete.
 * 3. Privilege Escalation Prevention: Admin tidak boleh bisa menembus endpoint penghapusan akun.
 */
class IntegritasAksesPenggunaTest extends TestCase
{
    use RefreshDatabase;

    public function test_direktur_tidak_bisa_menghapus_akunnya_sendiri(): void
    {
        $direktur = Pengguna::factory()->create([
            'peran' => Peran::Direktur,
            'is_aktif' => true,
        ]);

        $response = $this->actingAs($direktur)
            ->delete(route('panel.users.destroy', $direktur));

        $response->assertRedirect(route('panel.users.index'));
        $response->assertSessionHas('gagal', 'Tidak bisa menghapus akun yang sedang Anda pakai. Minta pengguna lain melakukannya.');

        $this->assertDatabaseHas('pengguna', ['id' => $direktur->id]);
    }

    public function test_pengguna_pembuat_spk_dilarang_dihapus(): void
    {
        $direktur = Pengguna::factory()->create(['peran' => Peran::Direktur, 'is_aktif' => true]);
        $pembuatSpk = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        Spk::factory()->create(['dibuat_oleh' => $pembuatSpk->id]);

        $response = $this->actingAs($direktur)
            ->delete(route('panel.users.destroy', $pembuatSpk));

        $response->assertRedirect(route('panel.users.index'));
        $response->assertSessionHas('gagal', 'Akun ini tercatat sebagai pembuat SPK. Nonaktifkan saja agar riwayat tetap utuh.');

        $this->assertDatabaseHas('pengguna', ['id' => $pembuatSpk->id]);
    }

    public function test_admin_tidak_bisa_mengeksekusi_penghapusan_akun(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $target = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        $this->actingAs($admin)
            ->delete(route('panel.users.destroy', $target))
            ->assertForbidden();

        $this->assertDatabaseHas('pengguna', ['id' => $target->id]);
    }

    public function test_admin_dilarang_mengakses_seluruh_endpoint_manajemen_pengguna(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $target = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        // 1. Index
        $this->actingAs($admin)->get(route('panel.users.index'))->assertForbidden();

        // 2. Create form
        $this->actingAs($admin)->get(route('panel.users.create'))->assertForbidden();

        // 3. Store
        $this->actingAs($admin)->post(route('panel.users.store'), [
            'nama' => 'Penyusup',
            'email' => 'penyusup@bks.test',
            'peran' => Peran::Admin->value,
            'password' => 'Password123!',
        ])->assertForbidden();

        // 4. Edit form
        $this->actingAs($admin)->get(route('panel.users.edit', $target))->assertForbidden();

        // 5. Update
        $this->actingAs($admin)->put(route('panel.users.update', $target), [
            'nama' => 'Diubah Admin',
            'email' => $target->email,
            'peran' => Peran::Direktur->value,
        ])->assertForbidden();

        // 6. Reset password
        $this->actingAs($admin)->post(route('panel.users.reset-password', $target), [
            'password' => 'PasswordBaru123!',
        ])->assertForbidden();
    }

    public function test_nonaktifkan_atau_hapus_akun_langsung_memutus_sesi_aktif_di_database(): void
    {
        $direktur = Pengguna::factory()->create(['peran' => Peran::Direktur, 'is_aktif' => true]);
        $target = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);

        DB::table('sessions')->insert([
            'id' => 'sesi-target-aktif-001',
            'user_id' => $target->id,
            'ip_address' => '192.168.100.25',
            'user_agent' => 'Mozilla/5.0',
            'payload' => 'dummypayload',
            'last_activity' => now()->timestamp,
        ]);

        // Saat dinonaktifkan oleh Direktur, sesi di tabel sessions harus terhapus
        $this->actingAs($direktur)->put(route('panel.users.update', $target), [
            'nama' => $target->nama,
            'email' => $target->email,
            'peran' => Peran::Admin->value,
            'is_aktif' => '0',
        ])->assertRedirect(route('panel.users.index'));

        $this->assertDatabaseMissing('sessions', ['id' => 'sesi-target-aktif-001']);
    }

    public function test_pemulihan_uang_masuk_ditolak_jika_spk_dihapus_dibatalkan_atau_melebihi_piutang(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);

        $masukTerhapus = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 8_000_000,
        ]);
        $masukTerhapus->delete();

        // Tambahkan uang masuk pengganti sebesar 5.000.000 (sisa piutang tinggal 5.000.000)
        UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 5_000_000,
        ]);

        // 1. Coba pulihkan uang masuk 8jt ketika sisa piutang tinggal 5jt -> harus ditolak
        $this->actingAs($admin)
            ->post(route('panel.cash-in.restore', $masukTerhapus->id))
            ->assertRedirect(route('panel.cash-in.index', ['terhapus' => 'saja']))
            ->assertSessionHas('gagal');
        $this->assertSoftDeleted($masukTerhapus);

        // 2. Jika SPK dibatalkan, pemulihan uang masuk kecil pun harus ditolak
        $masukKecil = UangMasuk::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 1_000_000,
        ]);
        $masukKecil->delete();
        $spk->update(['status_spk' => StatusSpk::Dibatalkan]);

        $this->actingAs($admin)
            ->post(route('panel.cash-in.restore', $masukKecil->id))
            ->assertSessionHas('gagal');
        $this->assertSoftDeleted($masukKecil);

        // 3. Jika SPK di-soft-delete, pemulihan harus ditolak
        $spk->update(['status_spk' => StatusSpk::Berjalan]);
        $spk->delete();

        $this->actingAs($admin)
            ->post(route('panel.cash-in.restore', $masukKecil->id))
            ->assertSessionHas('gagal');
        $this->assertSoftDeleted($masukKecil);
    }

    public function test_pemulihan_uang_keluar_ditolak_jika_spk_dihapus_atau_dibatalkan(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);

        $keluar = UangKeluar::factory()->create([
            'spk_id' => $spk->id,
            'jumlah' => 2_000_000,
        ]);
        $keluar->delete();

        $spk->update(['status_spk' => StatusSpk::Dibatalkan]);

        $this->actingAs($admin)
            ->post(route('panel.cash-out.restore', $keluar->id))
            ->assertSessionHas('gagal');
        $this->assertSoftDeleted($keluar);
    }

    public function test_unggah_nota_multi_kartu_uang_masuk_mencegah_akumulasi_melebihi_piutang_spk(): void
    {
        $admin = Pengguna::factory()->create(['peran' => Peran::Admin, 'is_aktif' => true]);
        $spk = Spk::factory()->create(['nilai_spk' => 10_000_000]);

        // Dua kartu nota uang masuk masing-masing 6jt pada SPK yang sama (total 12jt > 10jt)
        Livewire::actingAs($admin)
            ->test(ReceiptUploadForm::class)
            ->set('jenisTransaksi', 'masuk')
            ->set('daftarNota', [
                [
                    'id' => 'kartu-1',
                    'ke' => 1,
                    'potongan' => null,
                    'potongan_path' => null,
                    'tanggal' => now()->toDateString(),
                    'nominal' => '6000000',
                    'penerima' => 'PT PLN Batam',
                    'kategori' => 'nota',
                    'keterangan' => 'Termin 1A',
                    'spk_id' => $spk->id,
                    'akun' => 'bank',
                ],
                [
                    'id' => 'kartu-2',
                    'ke' => 2,
                    'potongan' => null,
                    'potongan_path' => null,
                    'tanggal' => now()->toDateString(),
                    'nominal' => '6000000',
                    'penerima' => 'PT PLN Batam',
                    'kategori' => 'nota',
                    'keterangan' => 'Termin 1B',
                    'spk_id' => $spk->id,
                    'akun' => 'bank',
                ],
            ])
            ->call('simpanSemua')
            ->assertHasErrors(['daftarNota.1.nominal']);

        $this->assertSame(0, UangMasuk::where('spk_id', $spk->id)->count());
    }
}
