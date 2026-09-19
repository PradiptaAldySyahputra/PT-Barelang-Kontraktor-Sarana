<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Pengguna;
use App\Models\Spk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spk>
 */
class SpkFactory extends Factory
{
    protected $model = Spk::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nilai = fake()->randomFloat(2, 10_000_000, 500_000_000);

        return [
            'nomor_spk' => fake()->unique()->numerify('####').'.SPK/DAN.01.03/PLNCONTOH',
            'tanggal_spk' => fake()->dateTimeBetween('-1 year', 'now'),
            'tanggal_akhir' => fake()->dateTimeBetween('now', '+6 months'),
            'nama_pekerjaan' => fake()->randomElement([
                'Pengadaan dan Pemasangan Jaringan',
                'Pembangunan Gardu Distribusi',
                'Pengadaan Pembangunan Shelter',
                'Upgrade SUTM Menjadi SKTM',
                'Pemeliharaan Gedung Area',
                'Pengadaan Material Accessories',
            ]),
            'lokasi' => fake()->randomElement([
                'Batam Tersebar', 'Lokasi Contoh', 'Neutra DC',
                'Lokasi Contoh 2', 'Gudang PT PLN Batam', 'Batu Aji',
            ]),
            'nilai_spk' => $nilai,
            'persen_retensi' => null,
            'nilai_retensi' => null,
            'jenis_sumber' => fake()->randomElement(['pln', 'luar']),
            'sheet_lama' => null,
            'mitra_id' => Mitra::factory(),
            'status_spk' => fake()->randomElement(StatusSpk::cases()),
            'status_tagihan' => fake()->randomElement(StatusTagihan::cases()),
            'dikerjakan_oleh' => DikerjakanOleh::Sendiri,
            'subkon_id' => null,
            'dibuat_oleh' => Pengguna::factory(),
        ];
    }

    /**
     * SPK dari PLN.
     */
    public function pln(): static
    {
        return $this->state(fn (array $attributes): array => [
            'jenis_sumber' => 'pln',
        ]);
    }

    /**
     * SPK subkon/vendor dengan retensi 5%.
     *
     * CATATAN: `nilai_retensi` TIDAK dihitung di sini — model Spk yang
     * menghitungnya otomatis lewat hook `saving`, agar nilainya selalu
     * mengikuti `nilai_spk` yang sebenarnya (termasuk saat ditimpa di seeder).
     */
    public function subkon(): static
    {
        return $this->state(fn (array $attributes): array => [
            'jenis_sumber' => 'subkon',
            'persen_retensi' => 5.00,
        ]);
    }

    /**
     * SPK tanpa nomor/tanggal resmi ("TANPA SPK" di Excel).
     */
    public function tanpaSpk(): static
    {
        return $this->state(fn (array $attributes): array => [
            'nomor_spk' => 'TANPA-SPK-'.fake()->unique()->numerify('####'),
            'tanggal_spk' => null,
        ]);
    }

    /**
     * SPK berstatus berjalan.
     */
    public function berjalan(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status_spk' => StatusSpk::Berjalan,
            'status_tagihan' => StatusTagihan::BelumDitagihkan,
        ]);
    }

    /**
     * SPK yang sudah dibayar lunas.
     */
    public function lunas(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status_spk' => StatusSpk::SudahDitagihkan,
            'status_tagihan' => StatusTagihan::Dibayar,
        ]);
    }

    /**
     * SPK yang disubkonkan ke pihak lain (kita bayar mereka).
     */
    public function disubkonkan(): static
    {
        return $this->state(fn (array $attributes): array => [
            'dikerjakan_oleh' => DikerjakanOleh::Subkon,
            'subkon_id' => Mitra::factory()->subkon(),
        ]);
    }

    /**
     * SPK yang dikerjakan tim sendiri.
     */
    public function dikerjakanSendiri(): static
    {
        return $this->state(fn (array $attributes): array => [
            'dikerjakan_oleh' => DikerjakanOleh::Sendiri,
            'subkon_id' => null,
        ]);
    }
}
