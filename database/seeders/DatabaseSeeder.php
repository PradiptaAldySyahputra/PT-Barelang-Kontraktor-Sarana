<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\KategoriPengeluaran;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Seeder;

/**
 * Seeder utama — data awal sistem.
 *
 * Membuat:
 *   1. Akun Admin & Direktur
 *   2. Mitra (PLN, pelanggan, subkon)
 *   3. Contoh SPK (PLN & subkon dengan retensi 5%)
 *   4. Contoh uang masuk (dari SPK & luar SPK)
 *   5. Contoh uang keluar (terkait SPK & umum)
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // 1. Akun pengguna
        // ---------------------------------------------------------
        $admin = Pengguna::factory()->admin()->create([
            'nama' => 'Admin BKS',
            'email' => 'admin@bks.test',
            'password' => 'password',
        ]);

        Pengguna::factory()->direktur()->create([
            'nama' => 'Direktur BKS',
            'email' => 'direktur@bks.test',
            'password' => 'password',
        ]);

        $this->command->info('✓ Akun: admin@bks.test & direktur@bks.test (password: password)');

        // ---------------------------------------------------------
        // 2. Mitra
        // ---------------------------------------------------------
        $pln = Mitra::factory()->pln()->create([
            'nama' => 'PT PLN Batam',
            'kontak' => '0778-000000',
            'alamat' => 'Jl. Contoh No. 1, Batam',
        ]);

        $pelanggan = Mitra::factory()->mitra()->create([
            'nama' => 'PT Contoh Pelanggan',
            'alamat' => 'Kawasan Industri Contoh, Batam',
        ]);

        $subkon = Mitra::factory()->subkon()->create([
            'nama' => 'CV Contoh Subkon',
            'kontak' => '0812-0000-0000',
            'alamat' => 'Batam Center',
        ]);

        $this->command->info('✓ Mitra: PLN, pelanggan, subkon');

        // ---------------------------------------------------------
        // 3. SPK
        // ---------------------------------------------------------

        // SPK dari PLN — pekerjaan utama
        $spkPln = Spk::factory()->pln()->berjalan()->create([
            'nomor_spk' => 'SPK-CONTOH-D',
            'tanggal_spk' => '2026-06-29',
            'tanggal_akhir' => '2026-09-30',
            'nama_pekerjaan' => 'Pengadaan Pembangunan Shelter',
            'lokasi' => 'Lokasi Contoh',
            'nilai_spk' => 200_000_000,
            'mitra_id' => $pln->id,
            'dibuat_oleh' => $admin->id,
        ]);

        // SPK subkon/vendor — dengan retensi 5%
        $spkSubkon = Spk::factory()->subkon()->berjalan()->create([
            'nomor_spk' => 'SUBKON-001',
            'tanggal_spk' => '2026-07-01',
            'tanggal_akhir' => '2026-08-31',
            'nama_pekerjaan' => 'Borongan Material Shelter',
            'lokasi' => 'Lokasi Contoh',
            'nilai_spk' => 100_000_000,
            'mitra_id' => $subkon->id,
            'dibuat_oleh' => $admin->id,
        ]);

        // SPK tanpa nomor resmi (kasus "TANPA SPK" di Excel)
        Spk::factory()->tanpaSpk()->berjalan()->create([
            'nama_pekerjaan' => 'Bahan Bakar Genset 420 Liter',
            'lokasi' => 'Kantor Korporat',
            'nilai_spk' => 5_565_000,
            'mitra_id' => $pelanggan->id,
            'dibuat_oleh' => $admin->id,
        ]);

        // SPK yang sudah lunas
        Spk::factory()->pln()->lunas()->create([
            'nomor_spk' => 'SPK-CONTOH-C',
            'tanggal_spk' => '2026-04-23',
            'nama_pekerjaan' => 'Pembuatan Ruang Rapat Lokasi Contoh 2',
            'lokasi' => 'Lokasi Contoh 2',
            'nilai_spk' => 371_746_922,
            'mitra_id' => $pln->id,
            'dibuat_oleh' => $admin->id,
        ]);

        $this->command->info('✓ SPK: 4 contoh (PLN, subkon, tanpa SPK, lunas)');

        // ---------------------------------------------------------
        // 4. Uang masuk
        // ---------------------------------------------------------

        // Dari SPK PLN — termin
        UangMasuk::factory()->dariSpk()->denganBukti(2)->create([
            'spk_id' => $spkPln->id,
            'nomor_spk' => $spkPln->nomor_spk,
            'nama_pekerjaan' => $spkPln->nama_pekerjaan,
            'tanggal' => '2026-08-11',
            'jumlah' => 120_000_000,
            'mitra_id' => $pln->id,
            'keterangan' => 'Termin 1 sudah diantar ke imperium',
        ]);

        // Dari SPK subkon
        UangMasuk::factory()->dariSpk()->denganBukti(1)->create([
            'spk_id' => $spkSubkon->id,
            'nomor_spk' => $spkSubkon->nomor_spk,
            'nama_pekerjaan' => $spkSubkon->nama_pekerjaan,
            'tanggal' => '2026-08-20',
            'jumlah' => 45_000_000,
            'mitra_id' => $subkon->id,
        ]);

        // Dari LUAR SPK (mode manual)
        UangMasuk::factory()->dariLuarSpk()->denganBukti(1)->create([
            'tanggal' => '2026-08-25',
            'jumlah' => 5_000_000,
            'keterangan' => 'Penjualan material sisa proyek',
        ]);

        $this->command->info('✓ Uang masuk: 3 contoh (2 dari SPK, 1 luar SPK)');

        // ---------------------------------------------------------
        // 5. Uang keluar
        // ---------------------------------------------------------

        // Terkait SPK PLN
        UangKeluar::factory()->terkaitSpk()->denganBukti(2)->create([
            'spk_id' => $spkPln->id,
            'tanggal' => '2026-07-05',
            'jumlah' => 40_000_000,
            'kategori' => KategoriPengeluaran::Material,
            'penerima' => 'Toko Material Contoh',
            'keterangan' => 'Pembelian besi dan semen',
        ]);

        UangKeluar::factory()->terkaitSpk()->denganBukti(1)->create([
            'spk_id' => $spkPln->id,
            'tanggal' => '2026-07-20',
            'jumlah' => 25_000_000,
            'kategori' => KategoriPengeluaran::Upah,
            'penerima' => 'Mandor Contoh',
            'keterangan' => 'Upah tukang minggu ke-3',
        ]);

        // Umum (tanpa SPK) — operasional kantor
        UangKeluar::factory()->umum()->denganBukti(1)->create([
            'tanggal' => '2026-08-01',
            'jumlah' => 3_000_000,
            'kategori' => KategoriPengeluaran::Operasional,
            'penerima' => 'Kantor',
            'keterangan' => 'Biaya operasional bulanan',
        ]);

        $this->command->info('✓ Uang keluar: 3 contoh (2 terkait SPK, 1 umum)');

        // ---------------------------------------------------------
        // Ringkasan
        // ---------------------------------------------------------
        $this->command->newLine();
        $this->command->info('=== RINGKASAN DATA AWAL ===');
        $this->command->table(
            ['Tabel', 'Jumlah'],
            [
                ['pengguna', Pengguna::count()],
                ['mitra', Mitra::count()],
                ['spk', Spk::count()],
                ['uang_masuk', UangMasuk::count()],
                ['uang_keluar', UangKeluar::count()],
            ]
        );

        // Tabel ringkasan per SPK — hanya angka yang BENAR-BENAR dipakai.
        // ⚠️ Kolom Laba/Rugi & Biaya DIHAPUS: fitur itu sudah dibuang dari
        // sistem (keputusan user, v4.3). Menampilkannya di sini hanya
        // menyesatkan orang yang membaca output seeder.
        $this->command->newLine();
        $this->command->info('=== RINGKASAN PER SPK ===');

        $rows = Spk::all()->map(fn (Spk $s): array => [
            $s->nomor_spk,
            number_format((float) $s->nilai_spk, 0, ',', '.'),
            number_format($s->totalPenerimaan(), 0, ',', '.'),
            number_format($s->piutang(), 0, ',', '.'),
        ])->all();

        $this->command->table(
            ['Nomor SPK', 'Nilai SPK', 'Sudah Diterima', 'Belum Diterima'],
            $rows
        );
    }
}
