<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\KategoriPengeluaran;
use App\Models\UangKeluar;
use Filament\Widgets\ChartWidget;

/**
 * Bar chart horizontal: pengeluaran per kategori.
 */
class PengeluaranPerKategori extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Pengeluaran per Kategori';

    protected ?string $description = 'Total pengeluaran pada 12 bulan terakhir';

    protected ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $data = UangKeluar::query()
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->where('tanggal', '>=', now()->subMonths(12)->startOfMonth())
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $labels = [];
        $nilai = [];

        foreach ($data as $row) {
            $enum = $row->kategori instanceof KategoriPengeluaran
                ? $row->kategori
                : KategoriPengeluaran::tryFrom((string) $row->kategori);

            $labels[] = $enum?->label() ?? ($row->kategori ?: 'Tanpa kategori');
            $nilai[] = (float) $row->total;
        }

        if ($labels === []) {
            $labels = ['Belum ada pengeluaran'];
            $nilai = [0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengeluaran',
                    'data' => $nilai,
                    'backgroundColor' => 'rgba(244, 63, 94, 0.75)',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => ['beginAtZero' => true],
            ],
        ];
    }
}
