<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

/**
 * Filter PERIODE (SATU filter, bukan tiga).
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "filternya terlalu panjang ux jadi ribet" — sebelumnya ada TIGA filter
 * terpisah (Tahun, Bulan, Rentang Tanggal) sehingga panel filter panjang
 * dan membingungkan.
 *
 * Sekarang digabung jadi SATU filter "Periode" dengan tiga isian yang
 * saling melengkapi. Admin mengisi sesuai kebutuhan:
 *   - hanya Tahun      → semua transaksi tahun itu
 *   - Tahun + Bulan    → semua transaksi bulan itu
 *   - Dari + Sampai    → rentang tanggal bebas (mengalahkan Tahun/Bulan)
 *
 * ⚠️ FILTER INI HANYA DIPAKAI DI MENU UANG MASUK & UANG KELUAR.
 * Pemisah seperti "Terkait SPK / Umum" TIDAK dibuat sebagai dropdown karena
 * sudah diwakili TAB di atas tabel — mencegah dua tempat yang bisa saling
 * bertentangan.
 */
trait FilterPeriodeUang
{
    protected static function filterPeriode(): Filter
    {
        return Filter::make('periode')
            ->label('Periode')
            ->form([
                Select::make('tahun')
                    ->label('Tahun')
                    ->options(fn (): array => static::daftarTahun())
                    ->placeholder('Semua tahun')
                    ->native(false),

                Select::make('bulan')
                    ->label('Bulan')
                    ->options([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                    ])
                    ->placeholder('Semua bulan')
                    ->native(false),

                DatePicker::make('dari')
                    ->label('Dari Tanggal')
                    ->native(false)
                    ->displayFormat('d/m/Y'),

                DatePicker::make('sampai')
                    ->label('Sampai Tanggal')
                    ->native(false)
                    ->displayFormat('d/m/Y'),
            ])
            ->columns(2)
            ->query(function (Builder $query, array $data): Builder {
                $tahun = $data['tahun'] ?? null;
                $bulan = $data['bulan'] ?? null;
                $dari = $data['dari'] ?? null;
                $sampai = $data['sampai'] ?? null;

                // Rentang tanggal paling spesifik — kalau diisi, itu yang menang.
                if ($dari || $sampai) {
                    return $query
                        ->when($dari, fn (Builder $q, $t): Builder => $q->whereDate('tanggal', '>=', $t))
                        ->when($sampai, fn (Builder $q, $t): Builder => $q->whereDate('tanggal', '<=', $t));
                }

                return $query
                    ->when($tahun, fn (Builder $q, $t): Builder => $q->whereYear('tanggal', (int) $t))
                    ->when($bulan, fn (Builder $q, $b): Builder => $q->whereMonth('tanggal', (int) $b));
            })
            ->indicateUsing(function (array $data): array {
                $indikator = [];

                if ($data['dari'] ?? null) {
                    $indikator[] = 'Dari '.Carbon::parse($data['dari'])->format('d/m/Y');
                }

                if ($data['sampai'] ?? null) {
                    $indikator[] = 'Sampai '.Carbon::parse($data['sampai'])->format('d/m/Y');
                }

                if (! ($data['dari'] ?? null) && ! ($data['sampai'] ?? null)) {
                    if ($data['bulan'] ?? null) {
                        $namaBulan = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                        ][(int) $data['bulan']] ?? '';

                        $indikator[] = $namaBulan.($data['tahun'] ? ' '.$data['tahun'] : '');
                    } elseif ($data['tahun'] ?? null) {
                        $indikator[] = 'Tahun '.$data['tahun'];
                    }
                }

                return $indikator;
            });
    }

    /**
     * Daftar tahun yang ADA datanya — supaya admin tidak memilih tahun kosong.
     *
     * ⚠️ CATATAN: class Table TIDAK punya `getModel()` (itu milik Resource).
     * Model diambil dari tabel Livewire-nya, dengan pengaman kalau belum siap
     * (mis. saat pertama render) → kembalikan daftar kosong, bukan error.
     *
     * @return array<string, string>
     */
    protected static function daftarTahun(): array
    {
        try {
            $livewire = Livewire::current();
            $resource = $livewire ? $livewire->getResource() : null;
            $model = $resource ? $resource::getModel() : null;

            if (! is_string($model) || ! class_exists($model)) {
                return [];
            }

            return $model::query()
                ->selectRaw('DISTINCT YEAR(tanggal) as tahun')
                ->whereNotNull('tanggal')
                ->orderByDesc('tahun')
                ->pluck('tahun')
                ->mapWithKeys(fn ($t): array => [(string) $t => (string) $t])
                ->all();
        } catch (\Throwable) {
            // Jangan pernah menggagalkan render tabel hanya karena filter tahun.
            return [];
        }
    }
}
