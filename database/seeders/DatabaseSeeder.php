<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeder utama - data awal sistem.
 *
 * Membuat:
 *   1. Akun Admin & Direktur
 *   2. Data real BKS dari docs/file bks/*.xlsx (SPK + kas/bank)
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun pengguna
        //
        // ⚠️ KEAMANAN (checklist hardening B1-5):
        // Seeder ini untuk DATA DEMO/PENGEMBANGAN saja. Sebelumnya ia menanam
        // password harfiah `password` - siapa pun yang membaca repo tahu
        // password default server. Sekarang:
        //
        //   - DI PRODUKSI: seeder MENOLAK jalan. Buat admin lewat
        //     `php artisan app:buat-admin` (password diminta, tidak di kode).
        //   - Di pengembangan: password diambil dari env SEEDER_PASSWORD, atau
        //     dibuat ACAK lalu DICETAK - bukan `password` polos.
        if (app()->environment('production')) {
            $this->command->error(
                'Seeder ini untuk pengembangan saja. Di produksi, buat akun '
                .'lewat: php artisan app:buat-admin'
            );

            return;
        }

        $passwordDemo = (string) (env('SEEDER_PASSWORD') ?: Str::password(12));

        $admin = Pengguna::factory()->admin()->create([
            'nama' => 'Admin BKS',
            'email' => 'admin@bks.test',
            'password' => $passwordDemo,
        ]);

        Pengguna::factory()->direktur()->create([
            'nama' => 'Direktur BKS',
            'email' => 'direktur@bks.test',
            'password' => $passwordDemo,
        ]);

        $this->command->info('✓ Akun demo: admin@bks.test & direktur@bks.test');
        $this->command->warn('  Password demo: '.$passwordDemo.' (hanya untuk pengembangan)');

        // 2. Data real BKS (docs/file bks/*.xlsx) untuk test & simulasi.
        //    Seeder ini juga memastikan mitra PT PLN Batam & akun admin ada.
        $this->call(DataRealSeeder::class);

        // Ringkasan
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

        // Tabel ringkasan per SPK - hanya angka yang BENAR-BENAR dipakai.
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
