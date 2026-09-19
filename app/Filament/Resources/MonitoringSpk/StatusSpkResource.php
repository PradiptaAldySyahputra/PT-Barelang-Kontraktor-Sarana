<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\StatusSpk;
use App\Filament\Resources\MonitoringSpk\Pages\ListStatusSpk;
use App\Models\Spk;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * MONITORING STATUS SPK.
 *
 * Fokus: pekerjaan mana yang perlu dikerjakan / mendekati tenggat.
 * Kolom status & tenggat diletakkan DI DEPAN agar langsung terlihat.
 *
 * Baca saja — tidak bisa menambah/mengubah/menghapus.
 */
class StatusSpkResource extends MonitoringSpkResource
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Status SPK';

    protected static ?string $pluralModelLabel = 'Status SPK';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_akhir')
            ->columns([
                // ---- STATUS DI DEPAN (permintaan user) ----
                TextColumn::make('status_spk')
                    ->label('Status')
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

                TextColumn::make('tenggat')
                    ->label('Tenggat')
                    ->state(fn (Spk $r): ?string => $r->labelTenggat())
                    ->description(fn (Spk $r): ?string => $r->tanggal_akhir?->format('d/m/Y'))
                    ->badge()
                    ->color(fn (Spk $r): string => match (true) {
                        $r->sudahLewatTenggat() => 'danger',
                        $r->mendekatiTenggat() => 'warning',
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
                    ->description(fn (Spk $r): ?string => $r->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—'),

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
            ])
            ->filters([
                SelectFilter::make('status_spk')
                    ->label('Status')
                    ->options(StatusSpk::opsi()),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                Filter::make('aktif')
                    ->label('Hanya yang belum selesai')
                    ->query(fn (Builder $q): Builder => $q->whereNotIn('status_spk', [
                        StatusSpk::Selesai->value,
                        StatusSpk::SudahDitagihkan->value,
                        StatusSpk::Dibatalkan->value,
                    ]))
                    ->toggle(),

                Filter::make('lewat_tenggat')
                    ->label('Lewat Tenggat')
                    ->query(fn (Builder $q): Builder => $q->lewatTenggat())
                    ->toggle(),

                Filter::make('mendekati_tenggat')
                    ->label('Mendekati Tenggat (14 hari)')
                    ->query(fn (Builder $q): Builder => $q->mendekatiTenggat())
                    ->toggle(),
            ])
            // TIDAK ada recordActions — monitoring baca saja
            ->recordActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatusSpk::route('/'),
        ];
    }
}
