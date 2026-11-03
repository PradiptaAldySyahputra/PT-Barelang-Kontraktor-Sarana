<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use App\Models\UangKeluar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UangKeluar>
 */
class UangKeluarFactory extends Factory
{
    protected $model = UangKeluar::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'spk_id' => Spk::factory(),
            'tanggal' => fake()->dateTimeBetween('-6 months', 'now'),
            'akun' => 'kas',
            'jumlah' => fake()->randomFloat(2, 500_000, 50_000_000),
            /*
             * ⚠️ "Lainnya" SENGAJA TIDAK diacak di sini (11 Okt 2026).
             * Kategori "Lainnya" mewajibkan `detail_kategori` (kebijakan A.5).
             * Kalau ikut diacak tanpa detail, data jadi invalid dan tes bisa
             * gagal acak (flaky). Pakai state `lainnya()` bila memang butuh.
             */
            'kategori' => fake()->randomElement([
                KategoriPengeluaran::Material,
                KategoriPengeluaran::Upah,
                KategoriPengeluaran::Operasional,
                KategoriPengeluaran::Gaji,
                KategoriPengeluaran::Nota,
                KategoriPengeluaran::Transportasi,
            ]),
            'penerima' => fake()->randomElement([
                'Toko Material Contoh', 'Mandor Contoh', 'CV Contoh Subkon',
                'Kantor', 'Bengkel Las Batam', 'Supplier Besi',
            ]),
            'keterangan' => fake()->optional()->sentence(),
            'bukti' => null,
        ];
    }

    /**
     * Transaksi pada buku BANK.
     */
    public function bank(): static
    {
        return $this->state(fn (array $attributes): array => ['akun' => 'bank']);
    }

    /**
     * Kategori "Lainnya" - WAJIB disertai `detail_kategori` (kebijakan A.5).
     */
    public function lainnya(string $detail = 'Pengeluaran lain-lain'): static
    {
        return $this->state(fn (array $attributes): array => [
            'kategori' => KategoriPengeluaran::Lainnya,
            'detail_kategori' => $detail,
        ]);
    }

    /**
     * Pengeluaran terkait SPK tertentu.
     */
    public function terkaitSpk(): static
    {
        return $this->state(fn (array $attributes): array => [
            'spk_id' => Spk::factory(),
            'kategori' => fake()->randomElement([
                KategoriPengeluaran::Material,
                KategoriPengeluaran::Upah,
                KategoriPengeluaran::Transportasi,
            ]),
        ]);
    }

    /**
     * Pengeluaran umum (tanpa SPK) - operasional kantor.
     */
    public function umum(): static
    {
        return $this->state(fn (array $attributes): array => [
            'spk_id' => null,
            'kategori' => fake()->randomElement([
                KategoriPengeluaran::Operasional,
                KategoriPengeluaran::Gaji,
                KategoriPengeluaran::Nota,
            ]),
        ]);
    }

    /**
     * Dengan beberapa file bukti (jumlah bebas).
     */
    public function denganBukti(int $jumlah = 2): static
    {
        return $this->state(function (array $attributes) use ($jumlah): array {
            $file = [];
            for ($i = 1; $i <= $jumlah; $i++) {
                $ext = fake()->randomElement(['pdf', 'jpg', 'png']);
                $file[] = 'bukti/uang-keluar/'.fake()->uuid().'.'.$ext;
            }

            return ['bukti' => $file];
        });
    }
}
