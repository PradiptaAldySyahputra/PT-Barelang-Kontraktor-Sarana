<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Mitra;
use App\Models\Spk;
use App\Models\UangMasuk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UangMasuk>
 */
class UangMasukFactory extends Factory
{
    protected $model = UangMasuk::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'spk_id' => Spk::factory(),
            'nomor_spk' => null,
            'nama_pekerjaan' => null,
            'tanggal' => fake()->dateTimeBetween('-6 months', 'now'),
            'jumlah' => fake()->randomFloat(2, 1_000_000, 100_000_000),
            'mitra_id' => Mitra::factory(),
            'keterangan' => fake()->optional()->sentence(),
            'bukti' => null,
        ];
    }

    /**
     * Uang masuk dari SPK (spk_id wajib diisi).
     */
    public function dariSpk(): static
    {
        return $this->state(fn (array $attributes): array => [
            'spk_id' => Spk::factory(),
        ]);
    }

    /**
     * Uang masuk dari LUAR SPK (mode manual di form).
     */
    public function dariLuarSpk(): static
    {
        return $this->state(fn (array $attributes): array => [
            'spk_id' => null,
            'nomor_spk' => '-',
            'nama_pekerjaan' => fake()->randomElement([
                'Penjualan material sisa',
                'Pendapatan lain-lain',
                'Reimbursement',
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
                $file[] = 'bukti/uang-masuk/'.fake()->uuid().'.pdf';
            }

            return ['bukti' => $file];
        });
    }
}
