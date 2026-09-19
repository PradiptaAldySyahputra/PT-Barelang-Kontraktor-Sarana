<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Tables;

use App\Filament\Resources\UangMasuks\UangMasukResource;
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
 * Tabel daftar Uang Masuk.
 *
 * Kolom "Sumber" disimpulkan dari spk_id — bukan kolom tersimpan.
 */
class UangMasuksTable
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

                TextColumn::make('sumber')
                    ->label('Sumber')
                    ->badge()
                    ->state(fn ($record): string => $record->labelSumber())
                    ->color(fn ($record): string => $record->isDariSpk() ? 'primary' : 'warning'),

                TextColumn::make('nomor_spk')
                    ->label('Nomor SPK')
                    ->placeholder('—')
                    ->searchable()
                    ->wrap()
                    ->description(fn ($record): ?string => $record->nama_pekerjaan),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('medium')
                    ->color('success')
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
                SelectFilter::make('sumber')
                    ->label('Sumber')
                    ->options([
                        'spk' => 'Dari SPK',
                        'luar' => 'Luar SPK',
                    ])
                    ->query(function ($query, array $data) {
                        return match ($data['value'] ?? null) {
                            'spk' => $query->whereNotNull('spk_id'),
                            'luar' => $query->whereNull('spk_id'),
                            default => $query,
                        };
                    }),

                SelectFilter::make('spk_id')
                    ->label('SPK')
                    ->relationship('spk', 'nomor_spk')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                TrashedFilter::make()->label('Data Terhapus'),
            ])
            ->recordActions([
                EditAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
                RestoreAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => UangMasukResource::bolehUbahData()),
            ]);
    }
}
