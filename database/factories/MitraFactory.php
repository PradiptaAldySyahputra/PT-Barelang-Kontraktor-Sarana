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

    /**
     * Pemberi kerja — termasuk PT PLN Batam.
     *
     * Nama method `pln()` dipertahankan agar test lama tetap jalan,
     * tetapi kategorinya sekarang `mitra` (revisi user).
     */
    public function pln(): static
    {
        return $this->state(fn (array $attributes): array => [
            'nama' => 'PT PLN Batam',
            'kategori' => KategoriMitra::Mitra,
        ]);
    }

    /**
     * Pemberi kerja / pihak luar (bukan PLN).
     */
    public function mitra(): static
    {
        return $this->state(fn (array $attributes): array => [
            'kategori' => KategoriMitra::Mitra,
        ]);
    }

    /**
     * Subkon — penerima pekerjaan dari kita.
     */
    public function subkon(): static
    {
        return $this->state(fn (array $attributes): array => [
            'nama' => 'CV Subkon '.fake()->numerify('###'),
            'kategori' => KategoriMitra::Subkon,
        ]);
    }
}
