<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusSpk;
use App\Filament\Actions\CatatPembayaran;
use App\Filament\Exports\SpkExporter;
use App\Filament\Resources\MonitoringSpk\Pages\ListStatusSpk;
use App\Filament\Resources\Spks\Pages\UbahStatusSpk;
use App\Models\Spk;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\ExportAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * MONITORING STATUS SPK (progres pekerjaan).
 *
 * ⚠️ KEPUTUSAN USER:
 *   "di spk bagian status spk merubahnya lewat ubah status saja, jadi status
 *    cuman menampilkan progres."
 *
 * Jadi:
 *   - Kolom status di sini READ-ONLY (hanya menampilkan progres)
 *   - Perubahan lewat tombol "Ubah Status Pekerjaan" → form TERPISAH
 *   - Data lain (nomor, nilai, mitra) tetap di menu List SPK
 *
 * Status tagihan TIDAK diubah dari sini — ada menu & form sendiri
 * (Tagihan SPK) supaya jelas bedanya.
 */
class StatusSpkResource extends MonitoringSpkResource
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Status SPK';

    protected static ?string $pluralModelLabel = 'Status SPK';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_akhir')
            ->columns([
                // ---- STATUS DI DEPAN (tampil saja) ----
                TextColumn::make('status_spk')
                    ->label('Status Pekerjaan')
                    ->badge()
                    ->formatStateUsing(fn (?StatusSpk $state): string => $state?->label() ?? '—')
                    ->color(fn (?StatusSpk $state): string => $state?->warnaBadge() ?? 'gray')
                    ->sortable(),

                TextColumn::make('tenggat')
                    ->label('Tenggat')
                    ->state(fn (Spk $r): ?string => $r->labelTenggat())
                    ->description(fn (Spk $r): ?string => $r->tanggal_akhir?->format('d/m/Y'))
                    ->badge()
                    ->color(fn (Spk $r): string => match (true) {
                        $r->sudahLewatTenggat() => 'danger',
                        $r->isMendekatiTenggat() => 'warning',
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
                    ->lineClamp(3)
                    ->description(fn (Spk $r): ?string => $r->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—'),

                TextColumn::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof DikerjakanOleh
                        ? $state->labelPendek()
                        : '—')
                    ->color(fn ($state): string => $state === DikerjakanOleh::Subkon ? 'warning' : 'gray')
                    ->description(fn (Spk $r): ?string => $r->subkon?->nama)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->filters([
                SelectFilter::make('status_spk')
                    ->label('Status')
                    ->options(StatusSpk::opsi())
                    ->multiple(),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                Filter::make('belum_selesai')
                    ->label('Belum Selesai')
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

                SelectFilter::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->options(DikerjakanOleh::opsi()),

                Filter::make('disubkonkan')
                    ->label('Disubkonkan')
                    ->query(fn (Builder $q): Builder => $q->disubkonkan())
                    ->toggle(),
            ])
            ->recordActions([
                /*
                 * ⚠️ PERBAIKAN UI (29 Sep 2026): "Catat Pembayaran" dan
                 * "Ubah Status" digabung jadi SATU menu — keduanya mengurus
                 * kondisi SPK yang sama. Dua tombol berdampingan membuat admin
                 * bingung mana yang harus diklik.
                 */
                ActionGroup::make([
                    // Catat pembayaran (termasuk sebagian) dari menu Status SPK.
                    CatatPembayaran::make(),

                    // Form TERPISAH, hanya status pekerjaan.
                    // `asal` dipakai supaya setelah simpan kembali ke sini.
                    Action::make('ubahStatus')
                        ->label('Ubah Status Pekerjaan')
                        ->icon('heroicon-m-pencil-square')
                        ->color('primary')
                        ->visible(fn (): bool => static::bolehUbahData())
                        ->url(fn (Spk $r): string => UbahStatusSpk::getUrl([
                            'record' => $r,
                            'asal' => 'status-spk',
                        ])),
                ])
                    ->label('Kelola SPK')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('primary')
                    ->button(),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(SpkExporter::class),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatusSpk::route('/'),
        ];
    }
}
