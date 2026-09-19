<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusSpk;
use App\Models\Spk;
use Filament\Widgets\ChartWidget;

/**
 * Donut chart: sebaran SPK per status.
 */
class SpkPerStatus extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'SPK per Status';

    protected ?string $description = 'Sebaran SPK berdasarkan tahapan';

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $data = Spk::query()
            ->selectRaw('status_spk, COUNT(*) as jumlah')
            ->groupBy('status_spk')
            ->pluck('jumlah', 'status_spk');

        $labels = [];
        $nilai = [];
        $warna = [];

        foreach (StatusSpk::cases() as $status) {
            $jumlah = (int) ($data[$status->value] ?? 0);

            if ($jumlah === 0) {
                continue;
            }

            $labels[] = $status->label();
            $nilai[] = $jumlah;
            $warna[] = match ($status) {
                StatusSpk::Draft => 'rgba(148, 163, 184, 0.8)',
                StatusSpk::Terbit => 'rgba(59, 130, 246, 0.8)',
                StatusSpk::Berjalan => 'rgba(245, 158, 11, 0.8)',
                StatusSpk::Selesai => 'rgba(16, 185, 129, 0.8)',
                StatusSpk::SudahDitagihkan => 'rgba(99, 102, 241, 0.8)',
                StatusSpk::Dibatalkan => 'rgba(244, 63, 94, 0.8)',
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
        ];
    }
}
