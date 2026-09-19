<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Spk;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

/**
 * Daftar SPK yang perlu perhatian: berjalan + mendekati/lewat tenggat.
 *
 * ⚠️ REVISI USER: kolom Laba/Rugi dan Piutang DIHAPUS (sistem tidak
 * menghitung laba/rugi). Yang ditampilkan: identitas pekerjaan + status
 * + tenggat + berapa yang sudah diterima.
 *
 * Diurutkan: yang PALING LEWAT TENGGAT di atas, supaya langsung terlihat
 * pekerjaan mana yang perlu ditindaklanjuti.
 */
class SpkBerjalan extends TableWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Perlu Perhatian — SPK Berjalan';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn (): Builder => Spk::query()
                    ->berjalan()
                    ->with(['mitra', 'subkon'])
                    ->withSum('uangMasuk as total_masuk', 'jumlah')
                    ->orderByRaw('tanggal_akhir IS NULL, tanggal_akhir ASC')
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
                    ->lineClamp(3)
                    ->description(fn (Spk $record): ?string => $record->mitra?->nama),

                TextColumn::make('tenggat')
                    ->label('Tenggat')
                    ->state(fn (Spk $record): ?string => $record->labelTenggat())
                    ->description(fn (Spk $record): ?string => $record->tanggal_akhir?->format('d/m/Y'))
                    ->badge()
                    ->color(fn (Spk $record): string => match (true) {
                        $record->sudahLewatTenggat() => 'danger',
                        $record->isMendekatiTenggat() => 'warning',
                        default => 'gray',
                    })
                    ->placeholder('Tanpa tenggat'),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->alignEnd(),

                TextColumn::make('total_masuk')
                    ->label('Sudah Diterima')
                    ->state(fn (Spk $record): float => (float) ($record->total_masuk ?? 0))
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('sisa')
                    ->label('Belum Diterima')
                    ->state(fn (Spk $record): float => max(0, $record->piutangDari((float) ($record->total_masuk ?? 0))))
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color('warning')
                    ->alignEnd(),
            ])
            ->paginated([5, 10, 25]);
    }
}
