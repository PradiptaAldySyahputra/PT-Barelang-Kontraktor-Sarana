<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSpk;
use App\Filament\Resources\Spks\Pages\UbahStatusTagihan;
use App\Models\Spk;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * MONITORING TAGIHAN SPK — tagihan yang BELUM selesai.
 *
 * Isi: SPK yang status tagihannya belum `Dibayar`.
 * Fokus: mana yang belum ditagih, sedang ditagih, dan berapa yang belum diterima.
 *
 * ⚠️ KEPUTUSAN USER:
 *   - Status tagihan READ-ONLY di sini; diubah lewat tombol "Ubah Status
 *     Tagihan" → form TERPISAH (jelas bedanya dengan status pekerjaan).
 *   - Kolom Retensi & Umur Piutang (aging) DIHAPUS — sistem tidak memakai
 *     retensi, dan umur piutang tidak dipakai perusahaan.
 *   - Saat status diubah jadi "Dibayar", SPK otomatis pindah ke menu
 *     "Tagihan Selesai SPK".
 */
class TagihanSpkResource extends MonitoringSpkResource
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedReceiptPercent;

    protected static ?string $navigationLabel = 'Tagihan SPK';

    protected static ?string $pluralModelLabel = 'Tagihan SPK';

    protected static ?int $navigationSort = 3;

    /**
     * Hanya SPK yang BELUM lunas.
     *
     * @return Builder<Spk>
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function (Builder $q): void {
                $q->where('status_tagihan', '!=', StatusTagihan::Dibayar->value)
                    ->orWhereNull('status_tagihan');
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_spk')
            ->columns([
                TextColumn::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->badge()
                    ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? 'Belum Ditagihkan')
                    ->color(fn (?StatusTagihan $state): string => $state?->warnaBadge() ?? 'gray'),

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
                    ->lineClamp(3)
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
                    ->label('Sudah Diterima')
                    ->state(fn (Spk $r): float => $r->totalPenerimaan())
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('sisa')
                    ->label('Belum Diterima')
                    ->state(fn (Spk $r): float => $r->sisaTagih())
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color('warning')
                    ->alignEnd(),
            ])
            ->filters([
                SelectFilter::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->options(StatusTagihan::opsi()),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                // Form TERPISAH, hanya status tagihan.
                Action::make('ubahStatusTagihan')
                    ->label('Ubah Status')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->visible(fn (): bool => static::bolehUbahData())
                    ->url(fn (Spk $r): string => UbahStatusTagihan::getUrl([
                        'record' => $r,
                        'asal' => 'tagihan-spk',
                    ])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanSpk::route('/'),
        ];
    }
}
