<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Tables;

use App\Enums\KategoriPengeluaran;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

/**
 * Tabel daftar Uang Keluar.
 */
class UangKeluarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?KategoriPengeluaran $state): string => $state?->label() ?? '—')
                    ->color(fn (?KategoriPengeluaran $state): string => match ($state) {
                        KategoriPengeluaran::Material => 'primary',
                        KategoriPengeluaran::Upah => 'warning',
                        KategoriPengeluaran::Transportasi => 'info',
                        KategoriPengeluaran::Operasional => 'gray',
                        KategoriPengeluaran::Gaji => 'success',
                        KategoriPengeluaran::Nota => 'info',
                        KategoriPengeluaran::Lainnya => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('spk.nomor_spk')
                    ->label('Nomor SPK')
                    ->placeholder('Umum')
                    ->badge()
                    ->color(fn ($state): string => $state ? 'primary' : 'gray')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('penerima')
                    ->label('Penerima')
                    ->placeholder('—')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('medium')
                    ->color('danger')
                    ->alignEnd(),

                TextColumn::make('jumlah_bukti')
                    ->label('Bukti')
                    ->state(fn ($record): string => $record->jumlahFileBukti() > 0
                        ? $record->jumlahFileBukti().' file'
                        : '—')
                    ->badge()
                    ->color(fn ($state): string => $state === '—' ? 'gray' : 'info')
                    ->alignCenter(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('—')
                    ->limit(35)
                    ->tooltip(fn ($record): ?string => $record->keterangan)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dicatat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(KategoriPengeluaran::opsi()),

                SelectFilter::make('spk_id')
                    ->label('SPK')
                    ->relationship('spk', 'nomor_spk')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('kaitan_spk')
                    ->label('Kaitan SPK')
                    ->options([
                        'terkait' => 'Terkait SPK',
                        'umum' => 'Umum / Operasional',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'terkait' => $query->whereNotNull('spk_id'),
                            'umum' => $query->whereNull('spk_id'),
                            default => $query,
                        };
                    }),

                TrashedFilter::make()->label('Data Terhapus'),
            ])
            ->recordActions([
                EditAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
                RestoreAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
            ]);
    }
}
