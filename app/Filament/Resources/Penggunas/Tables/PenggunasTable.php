<?php

declare(strict_types=1);

namespace App\Filament\Resources\Penggunas\Tables;

use App\Enums\Peran;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Models\Pengguna;
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
 * Tabel daftar Pengguna.
 *
 * ⚠️ Tombol Edit/Hapus DISEMBUNYIKAN untuk akun sendiri — supaya Direktur
 * tidak bisa mengunci dirinya dari sistem (temuan audit keamanan).
 */
class PenggunasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('peran')
                    ->label('Peran')
                    ->badge()
                    ->formatStateUsing(fn (?Peran $state): string => $state?->label() ?? '—')
                    ->color(fn (?Peran $state): string => match ($state) {
                        Peran::Admin => 'primary',
                        Peran::Direktur => 'warning',
                        default => 'gray',
                    }),

                IconColumn::make('is_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('spk_dibuat_count')
                    ->label('SPK Dibuat')
                    ->counts('spkDibuat')
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('peran')
                    ->label('Peran')
                    ->options(Peran::opsi()),

                TernaryFilter::make('is_aktif')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn (Pengguna $record): bool => PenggunaResource::canEdit($record)),

                DeleteAction::make()
                    ->visible(fn (Pengguna $record): bool => PenggunaResource::canDelete($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
