<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\KategoriMitra;
use App\Models\Mitra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mitra>
 */
class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->company(),
            'kategori' => fake()->randomElement(KategoriMitra::cases()),
            'kontak' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'is_aktif' => true,
        ];
    }

    public function pln(): static
    {
        return $this->state(fn (array $attributes): array => [
            'nama' => 'PT PLN Batam',
            'kategori' => KategoriMitra::Pln,
        ]);
    }

    public function pelanggan(): static
    {
        return $this->state(fn (array $attributes): array => [
            'kategori' => KategoriMitra::Pelanggan,
        ]);
    }

    public function subkon(): static
    {
        return $this->state(fn (array $attributes): array => [
            'kategori' => KategoriMitra::Subkon,
        ]);
    }
}
