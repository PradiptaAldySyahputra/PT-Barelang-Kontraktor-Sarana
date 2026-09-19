<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Spk;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

/**
 * Tabel SPK berjalan + laba/rugi per SPK.
 *
 * Laba/rugi dihitung on-the-fly dari transaksi terkait (withSum),
 * bukan kolom tersimpan.
 */
class SpkBerjalan extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'SPK Berjalan — Laba/Rugi';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Spk::query()
                    ->berjalan()
                    ->with('mitra')
                    ->withSum('uangMasuk as total_masuk', 'jumlah')
                    ->withSum('uangKeluar as total_keluar', 'jumlah')
                    ->orderByDesc('nilai_spk')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('nomor_spk')
                    ->label('Nomor SPK')
                    ->searchable()
                    ->wrap()
                    ->weight('medium'),

                TextColumn::make('nama_pekerjaan')
                    ->label('Pekerjaan')
                    ->wrap()
                    ->description(fn (Spk $record): ?string => $record->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->alignEnd(),

                TextColumn::make('total_masuk')
                    ->label('Penerimaan')
                    ->state(fn (Spk $record): float => (float) ($record->total_masuk ?? 0))
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('total_keluar')
                    ->label('Biaya')
                    ->state(fn (Spk $record): float => (float) ($record->total_keluar ?? 0))
                    ->money('IDR', locale: 'id')
                    ->color('danger')
                    ->alignEnd(),

                TextColumn::make('laba_rugi')
                    ->label('Laba/Rugi')
                    ->state(fn (Spk $record): float => (float) ($record->total_masuk ?? 0) - (float) ($record->total_keluar ?? 0))
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger')
                    ->alignEnd(),

                TextColumn::make('piutang')
                    ->label('Piutang')
                    ->state(fn (Spk $record): float => $record->piutangDari((float) ($record->total_masuk ?? 0)))
                    ->money('IDR', locale: 'id')
                    ->color('warning')
                    ->alignEnd()
                    ->description(fn (Spk $record): ?string => $record->retensiDitahan() > 0
                        ? 'retensi '.number_format($record->retensiDitahan(), 0, ',', '.')
                        : null),

                TextColumn::make('tenggat')
                    ->label('Tenggat')
                    ->state(fn (Spk $record): ?string => $record->labelTenggat())
                    ->badge()
                    ->color(fn (Spk $record): string => match (true) {
                        $record->sudahLewatTenggat() => 'danger',
                        $record->isMendekatiTenggat() => 'warning',
                        default => 'gray',
                    })
                    ->placeholder('—'),
            ])
            ->paginated([5, 10, 25]);
    }
}
