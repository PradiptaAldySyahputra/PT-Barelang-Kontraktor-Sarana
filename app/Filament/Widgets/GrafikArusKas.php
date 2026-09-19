<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

/**
 * Grafik arus kas 6 bulan terakhir — uang masuk vs uang keluar.
 */
class GrafikArusKas extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Arus Kas 6 Bulan Terakhir';

    protected ?string $description = 'Perbandingan uang masuk dan uang keluar per bulan';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $bulan = collect(range(5, 0))
            ->map(fn (int $i): Carbon => now()->subMonths($i)->startOfMonth());

        $masuk = UangMasuk::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $keluar = UangKeluar::query()
            ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan, SUM(jumlah) as total")
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        return [
            'datasets' => [
                [
                    'label' => 'Uang Masuk',
                    'data' => $bulan->map(fn (Carbon $b): float => (float) ($masuk[$b->format('Y-m')] ?? 0))->all(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                    'borderColor' => 'rgb(16, 185, 129)',
                ],
                [
                    'label' => 'Uang Keluar',
                    'data' => $bulan->map(fn (Carbon $b): float => (float) ($keluar[$b->format('Y-m')] ?? 0))->all(),
                    'backgroundColor' => 'rgba(244, 63, 94, 0.7)',
                    'borderColor' => 'rgb(244, 63, 94)',
                ],
            ],
            'labels' => $bulan->map(fn (Carbon $b): string => $b->translatedFormat('M Y'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => null,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
        ];
    }
}
