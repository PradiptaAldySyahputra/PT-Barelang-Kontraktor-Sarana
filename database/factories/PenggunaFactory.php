<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Peran;
use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Pengguna>
 */
class PenggunaFactory extends Factory
{
    protected $model = Pengguna::class;

    /**
     * Password default yang dipakai bersama.
     */
    protected static ?string $password = null;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'peran' => Peran::Admin,
            'is_aktif' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * User dengan peran Admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'peran' => Peran::Admin,
        ]);
    }

    /**
     * User dengan peran Direktur.
     */
    public function direktur(): static
    {
        return $this->state(fn (array $attributes): array => [
            'peran' => Peran::Direktur,
        ]);
    }

    /**
     * Akun nonaktif.
     */
    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_aktif' => false,
        ]);
    }
}
