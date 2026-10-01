<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusTagihan;
use App\Models\Spk;
use Filament\Widgets\ChartWidget;

/**
 * Donut: status tagihan SPK.
 *
 * ⚠️ REVISI USER: dashboard harus jelas menunjukkan bagian penting dari
 * menu/fitur. Grafik ini menggantikan "Pengeluaran per Kategori" yang
 * menyisakan banyak ruang kosong, dan langsung terhubung ke menu
 * Tagihan SPK / Tagihan Selesai SPK.
 */
class StatusTagihanChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Status Tagihan';

    protected ?string $description = 'Sebaran SPK menurut tahap penagihan';

    protected int|string|array $columnSpan = 1;

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $jumlah = Spk::query()
            ->selectRaw('status_tagihan, COUNT(*) as jumlah')
            ->groupBy('status_tagihan')
            ->pluck('jumlah', 'status_tagihan');

        $labels = [];
        $nilai = [];
        $warna = [];

        foreach (StatusTagihan::cases() as $status) {
            $n = (int) ($jumlah[$status->value] ?? 0);

            if ($n === 0) {
                continue;
            }

            $labels[] = $status->label();
            $nilai[] = $n;
            $warna[] = match ($status) {
                StatusTagihan::BelumDitagihkan => 'rgba(148, 163, 184, 0.8)',
                StatusTagihan::SudahDitagihkan => 'rgba(59, 130, 246, 0.8)',
                StatusTagihan::RevisiDokumen => 'rgba(249, 115, 22, 0.8)',
                StatusTagihan::MenungguPembayaran => 'rgba(245, 158, 11, 0.8)',
                StatusTagihan::Dibayar => 'rgba(16, 185, 129, 0.8)',
            };
        }

        if ($labels === []) {
            $labels = ['Belum ada SPK'];
            $nilai = [1];
            $warna = ['rgba(203, 213, 225, 0.6)'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah SPK',
                    'data' => $nilai,
                    'backgroundColor' => $warna,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'cutout' => '62%',
            'maintainAspectRatio' => false,
        ];
    }
}
