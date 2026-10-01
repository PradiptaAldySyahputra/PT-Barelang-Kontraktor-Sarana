<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Tables;

use App\Enums\AkunKas;
use App\Filament\Concerns\FilterPeriodeUang;
use App\Filament\Exports\UangMasukExporter;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\UangMasuk;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\Summarizers\Sum;
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
    use FilterPeriodeUang;

    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->columns([
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('akun')
                    ->label('Kas/Bank')
                    ->badge()
                    ->formatStateUsing(fn (?AkunKas $state): string => ($state ?? AkunKas::Kas)->label())
                    ->color(fn (?AkunKas $state): string => ($state ?? AkunKas::Kas)->warnaBadge()),

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
                    ->alignEnd()
                    /*
                     * ⚠️ RINGKASAN TOTAL — keluhan pengguna 29 Sep 2026:
                     *   "admin perlu itu kemudahan untuk mengelolanya"
                     *
                     * Sebelumnya admin harus menjumlahkan sendiri atau membuka
                     * Excel untuk tahu total periode terpilih — padahal itu
                     * angka yang paling sering ditanya.
                     *
                     * `Sum` dihitung oleh DATABASE dan MENGHORMATI FILTER yang
                     * aktif: menyaring "Kas" → totalnya hanya Kas.
                     */
                    ->summarize(Sum::make()->label('Total')),

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
                // SATU filter periode (Tahun/Bulan/Tanggal) — bukan tiga
                // terpisah, supaya panel filter pendek & tidak ribet.
                self::filterPeriode(),

                SelectFilter::make('akun')
                    ->label('Kas/Bank')
                    ->options(AkunKas::opsi()),

                SelectFilter::make('mitra_id')
                    ->label('Mitra')
                    ->relationship('mitra', 'nama')
                    ->searchable()
                    ->preload(),

                /*
                 * FILTER SPK — PRD FR-IN-004 ("Filter & pencarian uang masuk
                 * per periode/SPK").
                 *
                 * Satu SPK bisa punya puluhan penerimaan. Saat ada selisih atau
                 * bagian pajak meminta rincian satu pekerjaan, admin harus bisa
                 * menyaring HANYA SPK itu — bukan memilah manual di Excel.
                 */
                SelectFilter::make('spk_id')
                    ->label('SPK')
                    ->relationship('spk', 'nomor_spk')
                    ->getOptionLabelFromRecordUsing(fn ($record): string => $record->nomor_spk.' — '.$record->nama_pekerjaan)
                    ->searchable()
                    ->preload(),

                TrashedFilter::make()->label('Data Terhapus'),
            ])
            ->recordActions([
                /*
                 * ⚠️ LIHAT BUKTI — keluhan pengguna 29 Sep 2026:
                 *   "admin perlu itu kemudahan untuk mengelolanya, mencari
                 *    bukti dari uang tersebut"
                 *
                 * Sebelumnya admin harus klik Edit dulu, lalu menggulir ke
                 * bagian unggahan — merepotkan saat mencari bukti satu
                 * transaksi (mis. saat bagian pajak meminta).
                 *
                 * Kalau ada BEBERAPA berkas, ditampilkan sebagai sub-menu;
                 * kalau satu, langsung membuka berkasnya.
                 */
                Action::make('lihatBukti')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-m-paper-clip')
                    ->color('info')
                    ->visible(fn (UangMasuk $r): bool => $r->jumlahFileBukti() > 0)
                    ->modalHeading('Bukti Transaksi')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (UangMasuk $r) => view('filament.components.daftar-bukti', [
                        'berkas' => $r->bukti ?? [],
                    ])),

                EditAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
                RestoreAction::make()->visible(fn (): bool => UangMasukResource::bolehUbahData()),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(UangMasukExporter::class),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => UangMasukResource::bolehUbahData()),
            ]);
    }
}
