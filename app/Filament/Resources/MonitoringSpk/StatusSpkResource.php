<?php

declare(strict_types=1);

namespace App\Filament\Resources\MonitoringSpk;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusSpk;
use App\Filament\Resources\MonitoringSpk\Pages\ListStatusSpk;
use App\Filament\Resources\Spks\Pages\EditSpk;
use App\Models\Spk;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * MONITORING STATUS SPK.
 *
 * Fokus: pekerjaan mana yang perlu dikerjakan / mendekati tenggat.
 * Kolom Status & Tenggat diletakkan DI DEPAN agar langsung terlihat.
 *
 * ⚠️ REVISI USER: status sekarang bisa DIUBAH LANGSUNG dari tabel
 * (klik pada kolom Status → pilih status baru). Tidak perlu buka form.
 * Untuk ubah cepat lewat form ringkas, ada tombol "Ubah Status".
 *
 * Data lain (nomor, nilai, mitra, dll) tetap TIDAK bisa diubah dari sini —
 * itu ada di menu List SPK.
 */
class StatusSpkResource extends MonitoringSpkResource
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $navigationLabel = 'Status SPK';

    protected static ?string $pluralModelLabel = 'Status SPK';

    protected static ?int $navigationSort = 2;

    /**
     * Status boleh diubah dari halaman monitoring ini.
     *
     * Ini pengecualian dari aturan "monitoring = baca saja": user meminta
     * perubahan status dibuat semudah mungkin. Yang dibuka hanya kolom
     * `status_spk` & `status_tagihan`, bukan seluruh data SPK.
     */
    public static function canEdit($record): bool
    {
        return static::bolehUbahData();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_akhir')
            ->columns([
                // ---- STATUS DI DEPAN & LANGSUNG BISA DIUBAH ----
                //
                // SelectColumn = dropdown langsung di dalam tabel, jadi
                // mengubah status cukup 2 klik tanpa pindah halaman.
                // Catatan: SelectColumn TIDAK mendukung badge()/color(),
                // jadi tampil sebagai dropdown biasa (bukan lencana berwarna).
                SelectColumn::make('status_spk')
                    ->label('Status')
                    ->options(StatusSpk::opsi())
                    ->selectablePlaceholder(false)
                    ->disabled(fn (): bool => ! static::bolehUbahData())
                    ->afterStateUpdated(function (Spk $record): void {
                        // Pastikan perubahan langsung tersimpan & tercatat.
                        $record->save();
                    }),

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
                    ->description(fn (Spk $r): ?string => $r->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—'),

                TextColumn::make('tanggal_spk')
                    ->label('Tanggal SPK')
                    ->date('d/m/Y')
                    ->placeholder('TANPA SPK')
                    ->sortable(),

                TextColumn::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof DikerjakanOleh
                        ? $state->labelPendek()
                        : '—')
                    ->color(fn ($state): string => $state === DikerjakanOleh::Subkon ? 'warning' : 'gray')
                    ->description(fn (Spk $r): ?string => $r->subkon?->nama)
                    ->placeholder('—'),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->filters([
                // ---- FILTER STATUS (permintaan user) ----
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
                // Form ringkas: hanya status. Untuk data lain, buka List SPK.
                Action::make('ubahStatus')
                    ->label('Ubah Status')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->visible(fn (): bool => static::bolehUbahData())
                    ->url(fn (Spk $r): string => EditSpk::getUrl([
                        'record' => $r,
                        'ringkas' => 1,
                    ])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStatusSpk::route('/'),
        ];
    }
}
