<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSelesaiSpk;
use App\Models\Spk;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * RIWAYAT TAGIHAN SELESAI SPK.
 *
 * Isi: SPK yang status tagihannya sudah `Dibayar` — untuk data riwayat.
 * Fokus: arsip, pencarian, dan rekap nilai yang sudah selesai.
 *
 * Baca saja.
 */
class TagihanSelesaiSpkResource extends MonitoringSpkResource
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $navigationLabel = 'Tagihan Selesai SPK';

    protected static ?string $pluralModelLabel = 'Tagihan Selesai SPK';

    protected static ?int $navigationSort = 4;

    /**
     * Hanya SPK yang SUDAH lunas.
     *
     * @return Builder<Spk>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('status_tagihan', StatusTagihan::Dibayar->value);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_spk', 'desc')
            ->columns([
                TextColumn::make('status_tagihan')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? 'Dibayar')
                    ->color('success'),

                TextColumn::make('nomor_spk')
                    ->label('Nomor SPK')
                    ->searchable()
                    ->copyable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('nama_pekerjaan')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->wrap()
                    ->description(fn (Spk $r): ?string => $r->mitra?->nama),

                TextColumn::make('tanggal_spk')
                    ->label('Tanggal SPK')
                    ->date('d/m/Y')
                    ->placeholder('TANPA SPK')
                    ->sortable(),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('diterima')
                    ->label('Total Diterima')
                    ->state(fn (Spk $r): float => (float) ($r->total_masuk ?? 0))
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('laba_rugi')
                    ->label('Laba/Rugi')
                    ->state(fn (Spk $r): float => (float) ($r->total_masuk ?? 0) - (float) ($r->total_keluar ?? 0))
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger')
                    ->alignEnd(),

                TextColumn::make('selesai_pada')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                Filter::make('periode')
                    ->label('Periode SPK')
                    ->form([
                        DatePicker::make('dari')
                            ->label('Dari Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('sampai')
                            ->label('Sampai Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['dari'] ?? null, fn (Builder $q, $t): Builder => $q->whereDate('tanggal_spk', '>=', $t))
                        ->when($data['sampai'] ?? null, fn (Builder $q, $t): Builder => $q->whereDate('tanggal_spk', '<=', $t))),
            ])
            ->recordActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanSelesaiSpk::route('/'),
        ];
    }
}
