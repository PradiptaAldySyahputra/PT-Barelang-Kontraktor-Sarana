<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSpk;
use App\Models\Spk;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * MONITORING TAGIHAN SPK — tagihan yang BELUM selesai.
 *
 * Isi: SPK yang status tagihannya belum `Dibayar`.
 * Fokus: berapa yang masih harus ditagih & sudah berapa lama (umur piutang).
 * Kolom status tagihan diletakkan DI DEPAN agar langsung terlihat.
 *
 * Baca saja.
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
                // ---- STATUS TAGIHAN DI DEPAN (permintaan user) ----
                TextColumn::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->badge()
                    ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? 'Belum Ditagihkan')
                    ->color(fn (?StatusTagihan $state): string => match ($state) {
                        StatusTagihan::Dibayar => 'success',
                        StatusTagihan::MenungguPembayaran => 'warning',
                        StatusTagihan::RevisiDokumen => 'danger',
                        StatusTagihan::SudahDitagihkan => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('umur')
                    ->label('Umur Piutang')
                    ->state(fn (Spk $r): ?string => $r->umurHari() !== null ? $r->umurHari().' hari' : null)
                    ->badge()
                    ->color(fn (Spk $r): string => match ($r->kategoriUmur()) {
                        '>90' => 'danger',
                        '61-90' => 'warning',
                        '31-60' => 'info',
                        default => 'gray',
                    })
                    ->placeholder('—'),

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

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('retensi')
                    ->label('Retensi Ditahan')
                    ->state(fn (Spk $r): float => $r->retensiDitahan())
                    ->money('IDR', locale: 'id')
                    ->placeholder('—')
                    ->color('gray')
                    ->toggleable()
                    ->alignEnd(),

                TextColumn::make('diterima')
                    ->label('Sudah Diterima')
                    ->state(fn (Spk $r): float => (float) ($r->total_masuk ?? 0))
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('piutang')
                    ->label('Piutang Lancar')
                    ->state(fn (Spk $r): float => $r->piutangDari((float) ($r->total_masuk ?? 0)))
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

                Filter::make('piutang_menua')
                    ->label('Piutang lebih dari 90 hari')
                    ->query(fn (Builder $q): Builder => $q->piutangMenua(90))
                    ->toggle(),

                Filter::make('ada_retensi')
                    ->label('Ada Retensi')
                    ->query(fn (Builder $q): Builder => $q->whereNotNull('persen_retensi')->where('persen_retensi', '>', 0))
                    ->toggle(),
            ])
            ->recordActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanSpk::route('/'),
        ];
    }
}
