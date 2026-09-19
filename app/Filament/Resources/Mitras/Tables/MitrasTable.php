<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Tables;

use App\Enums\KategoriMitra;
use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

/**
 * Tabel daftar Mitra.
 */
class MitrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Mitra')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?KategoriMitra $state): string => $state?->label() ?? '—')
                    ->color(fn (?KategoriMitra $state): string => match ($state) {
                        KategoriMitra::Pln => 'primary',
                        KategoriMitra::Pelanggan => 'info',
                        KategoriMitra::Subkon => 'warning',
                        KategoriMitra::Vendor => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('kontak')
                    ->label('Kontak')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('spk_count')
                    ->label('Jml SPK')
                    ->counts('spk')
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->placeholder('—')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(KategoriMitra::opsi()),

                TernaryFilter::make('is_aktif')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif saja')
                    ->falseLabel('Nonaktif saja'),
            ])
            ->recordActions([
                EditAction::make()->visible(fn (): bool => MitraResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => MitraResource::bolehUbahData()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => MitraResource::bolehUbahData()),
            ]);
    }
}
