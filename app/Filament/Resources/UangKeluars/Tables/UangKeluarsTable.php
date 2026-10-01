<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Tables;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Filament\Concerns\FilterPeriodeUang;
use App\Filament\Exports\UangKeluarExporter;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Models\UangKeluar;
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
 * Tabel daftar Uang Keluar.
 */
class UangKeluarsTable
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

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?KategoriPengeluaran $state): string => $state?->label() ?? '—')
                    ->color(fn (?KategoriPengeluaran $state): string => match ($state) {
                        KategoriPengeluaran::Material => 'primary',
                        KategoriPengeluaran::Upah => 'warning',
                        KategoriPengeluaran::Transportasi => 'info',
                        KategoriPengeluaran::Operasional => 'gray',
                        KategoriPengeluaran::Gaji => 'success',
                        KategoriPengeluaran::Nota => 'info',
                        KategoriPengeluaran::Lainnya => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('spk.nomor_spk')
                    ->label('Nomor SPK')
                    ->placeholder('Umum')
                    ->badge()
                    ->color(fn ($state): string => $state ? 'primary' : 'gray')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('penerima')
                    ->label('Penerima')
                    ->placeholder('—')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('medium')
                    ->color('danger')
                    ->alignEnd()
                    /*
                     * ⚠️ RINGKASAN TOTAL — keluhan pengguna 29 Sep 2026:
                     *   "admin perlu itu kemudahan untuk mengelolanya"
                     *
                     * Sebelumnya admin harus menjumlahkan sendiri atau membuka
                     * Excel untuk tahu total pengeluaran periode terpilih.
                     *
                     * `Sum` dihitung oleh DATABASE dan MENGHORMATI FILTER aktif:
                     * menyaring "Kas" → totalnya hanya Kas.
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

                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(KategoriPengeluaran::opsi()),

                /*
                 * FILTER SPK — PRD FR-OUT-004 ("Filter & pencarian uang keluar
                 * per periode/kategori/SPK").
                 *
                 * Biaya langsung pekerjaan dikaitkan ke SPK (Rules §2 butir 6).
                 * Saat ada selisih atau bagian pajak meminta rincian satu
                 * pekerjaan, admin harus bisa menyaring HANYA SPK itu.
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
                 * Uang keluar paling butuh ini: satu transaksi bisa punya
                 * beberapa nota (nota digabung jadi 1 PDF/bulan), dan admin
                 * sering harus menunjukkan buktinya.
                 */
                Action::make('lihatBukti')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-m-paper-clip')
                    ->color('info')
                    ->visible(fn (UangKeluar $r): bool => $r->jumlahFileBukti() > 0)
                    ->modalHeading('Bukti Transaksi')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (UangKeluar $r) => view('filament.components.daftar-bukti', [
                        'berkas' => $r->bukti ?? [],
                    ])),

                EditAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
                RestoreAction::make()->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(UangKeluarExporter::class),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => UangKeluarResource::bolehUbahData()),
            ]);
    }
}
