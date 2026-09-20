<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Tables;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Tabel LIST SPK — data induk SPK (bukan monitoring).
 *
 * ⚠️ KEPUTUSAN USER (19 Sep 2026):
 *   - Kolom **Biaya**, **Laba/Rugi**, **Piutang**, dan **Retensi** DIHAPUS.
 *     Sistem murni mencatat data yang diinput — tidak ada perhitungan pajak,
 *     biaya, laba/rugi, atau piutang.
 *   - Status TIDAK diubah dari sini. Status diubah lewat menu monitoring
 *     (Status SPK / Tagihan SPK) dengan form terpisah.
 *
 * Tabel ini fokus pada **identitas SPK**: nomor, pekerjaan, mitra,
 * tanggal, nilai, pelaksana, dan status (tampil saja).
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

                // Pekerjaan ditampilkan sebagai PARAGRAF memanjang (wrap)
                // supaya tidak memotong nama pekerjaan yang panjang —
                // permintaan user: "dibuat paragraf atau memanjang saja".
                TextColumn::make('nama_pekerjaan')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->wrap()
                    ->lineClamp(4)
                    ->description(fn (Spk $record): ?string => $record->lokasi),

                TextColumn::make('mitra.nama')
                    ->label('Mitra')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('tanggal_spk')
                    ->label('Tanggal SPK')
                    ->date('d/m/Y')
                    ->placeholder('TANPA SPK')
                    ->description(fn (Spk $record): ?string => $record->tanggal_spk === null
                        ? 'Tidak ada tanggal resmi'
                        : null)
                    ->sortable(),

                TextColumn::make('tanggal_akhir')
                    ->label('Tenggat')
                    ->date('d/m/Y')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('nilai_spk')
                    ->label('Nilai SPK')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state instanceof DikerjakanOleh
                        ? $state->labelPendek()
                        : '—')
                    ->color(fn ($state): string => $state === DikerjakanOleh::Subkon ? 'warning' : 'gray')
                    ->description(fn (Spk $record): ?string => $record->subkon?->nama)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('status_spk')
                    ->label('Status SPK')
                    ->badge()
                    ->formatStateUsing(fn (?StatusSpk $state): string => $state?->label() ?? '—')
                    ->color(fn (?StatusSpk $state): string => $state?->warnaBadge() ?? 'gray'),

                TextColumn::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->badge()
                    ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? '—')
                    ->color(fn (?StatusTagihan $state): string => $state?->warnaBadge() ?? 'gray')
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

                SelectFilter::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->options(DikerjakanOleh::opsi()),

                Filter::make('disubkonkan')
                    ->label('Disubkonkan')
                    ->query(fn (Builder $q): Builder => $q->disubkonkan())
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
            // HANYA Edit dan Delete (permintaan user).
            // Restore dan Force Delete dihapus dari baris. Data yang sudah
            // dihapus tetap bisa dilihat lewat filter "Data Terhapus".
            ->recordActions([
                EditAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => SpkResource::bolehUbahData()),
            ]);
    }
}
