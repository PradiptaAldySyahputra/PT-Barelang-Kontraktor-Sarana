<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Tables;

use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Tabel daftar SPK.
 *
 * Laba/rugi & piutang dihitung on-the-fly lewat subquery SUM (withSum)
 * — bukan kolom tersimpan. Lihat Schema.md §6.
 *
 * `piutang_lancar` memakai `piutangDari()` yang SADAR RETENSI: retensi yang
 * masih ditahan tidak dihitung sebagai piutang (lihat Rules.md §2).
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
                    ->description(fn (Spk $record): ?string => $record->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('tanggal_spk')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->placeholder('TANPA SPK')
                    ->sortable(),

                TextColumn::make('tenggat')
                    ->label('Tenggat')
                    ->state(fn (Spk $record): ?string => $record->labelTenggat())
                    ->description(fn (Spk $record): ?string => $record->tanggal_akhir?->format('d/m/Y'))
                    ->badge()
                    ->color(fn (Spk $record): string => match (true) {
                        $record->sudahLewatTenggat() => 'danger',
                        $record->mendekatiTenggat() => 'warning',
                        default => 'gray',
                    })
                    ->placeholder('—')
                    ->toggleable(),

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
                    ->state(fn (Spk $record): float => (float) ($record->total_masuk ?? 0))
                    ->color('success')
                    ->alignEnd(),

                TextColumn::make('total_keluar')
                    ->label('Biaya')
                    ->money('IDR', locale: 'id')
                    ->state(fn (Spk $record): float => (float) ($record->total_keluar ?? 0))
                    ->color('danger')
                    ->alignEnd(),

                TextColumn::make('laba_rugi')
                    ->label('Laba/Rugi')
                    ->state(fn (Spk $record): float => (float) ($record->total_masuk ?? 0) - (float) ($record->total_keluar ?? 0))
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color(fn ($state): string => (float) $state >= 0 ? 'success' : 'danger')
                    ->alignEnd(),

                // Piutang LANCAR — retensi ditahan TIDAK dihitung
                TextColumn::make('piutang_lancar')
                    ->label('Piutang')
                    ->state(fn (Spk $record): float => $record->piutangDari((float) ($record->total_masuk ?? 0)))
                    ->money('IDR', locale: 'id')
                    ->color('warning')
                    ->alignEnd()
                    ->description(fn (Spk $record): ?string => $record->retensiDitahan() > 0
                        ? 'retensi '.number_format($record->retensiDitahan(), 0, ',', '.')
                        : null),

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
                        StatusTagihan::RevisiDokumen => 'danger',
                        StatusTagihan::MenungguPembayaran => 'warning',
                        StatusTagihan::Dibayar => 'success',
                        default => 'gray',
                    })
                    ->toggleable(),
            ])
            ->filters([
                // ---------------------------------------------------------
                // FILTER CEPAT — pekerjaan sehari-hari
                // ---------------------------------------------------------
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

                Filter::make('belum_lunas')
                    ->label('Belum Lunas')
                    ->query(fn (Builder $q): Builder => $q->where('status_tagihan', '!=', StatusTagihan::Dibayar->value))
                    ->toggle(),

                Filter::make('lewat_tenggat')
                    ->label('Lewat Tenggat')
                    ->query(fn (Builder $q): Builder => $q->lewatTenggat())
                    ->toggle(),

                Filter::make('mendekati_tenggat')
                    ->label('Mendekati Tenggat (14 hari)')
                    ->query(fn (Builder $q): Builder => $q->mendekatiTenggat())
                    ->toggle(),

                Filter::make('ada_retensi')
                    ->label('Ada Retensi')
                    ->query(fn (Builder $q): Builder => $q->whereNotNull('persen_retensi')->where('persen_retensi', '>', 0))
                    ->toggle(),

                Filter::make('piutang_menua')
                    ->label('Piutang lebih dari 90 hari')
                    ->query(fn (Builder $q): Builder => $q->piutangMenua(90))
                    ->toggle(),

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
                        ->when($data['sampai'] ?? null, fn (Builder $q, $t): Builder => $q->whereDate('tanggal_spk', '<=', $t)))
                    ->indicateUsing(function (array $data): array {
                        $indikator = [];

                        if ($data['dari'] ?? null) {
                            $indikator[] = 'Dari: '.$data['dari'];
                        }

                        if ($data['sampai'] ?? null) {
                            $indikator[] = 'Sampai: '.$data['sampai'];
                        }

                        return $indikator;
                    }),

                TrashedFilter::make()->label('Data Terhapus'),
            ])
            ->recordActions([
                EditAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
                RestoreAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
                ForceDeleteAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ])->visible(fn (): bool => SpkResource::bolehUbahData()),
            ]);
    }
}
