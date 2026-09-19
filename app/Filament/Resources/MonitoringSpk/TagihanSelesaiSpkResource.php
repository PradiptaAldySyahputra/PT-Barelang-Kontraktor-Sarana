<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\StatusTagihan;
use App\Filament\Resources\MonitoringSpk\Pages\ListTagihanSelesaiSpk;
use App\Filament\Resources\Spks\Pages\UbahStatusTagihan;
use App\Models\Spk;
use Filament\Actions\Action;
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
 * Isi: SPK yang status tagihannya sudah `Dibayar`.
 * Fokus: arsip & pencarian.
 *
 * ⚠️ PERMINTAAN USER: "ditagihan selesai bisa di edit kalau misal salah input."
 * Jadi ada tombol "Perbaiki Status" yang mengembalikan SPK ke menu Tagihan
 * SPK kalau ternyata statusnya salah.
 *
 * Kolom Laba/Rugi DIHAPUS (sistem tidak menghitung laba/rugi).
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
            ->defaultSort('updated_at', 'desc')
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
                    ->label('Total Diterima')
                    ->state(fn (Spk $r): float => $r->totalPenerimaan())
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('updated_at')
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
            ->recordActions([
                // PERMINTAAN USER: bisa diperbaiki kalau salah input.
                Action::make('perbaikiStatus')
                    ->label('Perbaiki Status')
                    ->icon('heroicon-m-arrow-uturn-left')
                    ->color('warning')
                    ->visible(fn (): bool => static::bolehUbahData())
                    ->url(fn (Spk $r): string => UbahStatusTagihan::getUrl([
                        'record' => $r,
                        'asal' => 'tagihan-selesai',
                    ])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTagihanSelesaiSpk::route('/'),
        ];
    }
}
