<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Tables;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
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
 * Tabel daftar SPK.
 *
 * Laba/rugi & piutang dihitung on-the-fly lewat subquery SUM
 * (withSum) — bukan kolom tersimpan.
 */
class SpksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_spk', 'desc')
            ->columns([
                TextColumn::make('nomor_spk')
                    ->label('Nomor SPK')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('nama_pekerjaan')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->wrap()
                    ->description(fn ($record): ?string => $record->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('tanggal_spk')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->placeholder('TANPA SPK')
                    ->sortable(),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('nilai_retensi')
                    ->label('Retensi')
                    ->money('IDR', locale: 'id')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->alignEnd(),

                TextColumn::make('total_masuk')
                    ->label('Penerimaan')
                    ->money('IDR', locale: 'id')
                    ->state(fn ($record): float => (float) ($record->total_masuk ?? 0))
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('total_keluar')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id')
                    ->state(fn ($record): float => (float) ($record->total_keluar ?? 0))
                    ->color('danger')
                    ->alignEnd(),

                TextColumn::make('laba_rugi')
                    ->label('Laba/Rugi')
                    ->state(fn ($record): float => (float) ($record->total_masuk ?? 0) - (float) ($record->total_keluar ?? 0))
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger')
                    ->alignEnd(),

                TextColumn::make('status_spk')
                    ->label('Status SPK')
                    ->badge()
                    ->formatStateUsing(fn (?StatusSpk $state): string => $state?->label() ?? '—')
                    ->color(fn (?StatusSpk $state): string => match ($state) {
                        StatusSpk::Draft => 'gray',
                        StatusSpk::Terbit => 'info',
                        StatusSpk::Berjalan => 'warning',
                        StatusSpk::Selesai => 'success',
                        StatusSpk::SudahDitagihkan => 'primary',
                        StatusSpk::Dibatalkan => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('status_tagihan')
                    ->label('Tagihan')
                    ->badge()
                    ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? '—')
                    ->color(fn (?StatusTagihan $state): string => match ($state) {
                        StatusTagihan::BelumDitagihkan => 'gray',
                        StatusTagihan::SudahDitagihkan => 'info',
                        StatusTagihan::RevisiDokumen => 'warning',
                        StatusTagihan::MenungguPembayaran => 'warning',
                        StatusTagihan::Dibayar => 'success',
                        default => 'gray',
                    })
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status_spk')
                    ->label('Status SPK')
                    ->options(StatusSpk::opsi()),

                SelectFilter::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->options(StatusTagihan::opsi()),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('jenis_sumber')
                    ->label('Jenis Sumber')
                    ->options([
                        'pln' => 'PLN',
                        'luar' => 'Luar',
                        'internal' => 'Internal',
                        'lainnya' => 'Lainnya',
                    ]),

                TrashedFilter::make()->label('Data Terhapus'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
