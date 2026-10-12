<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Tables;

use App\Enums\AkunKas;
use App\Filament\Concerns\FilterPeriodeUang;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use App\Models\UangMasuk;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

/**
 * Tabel daftar Uang Masuk.
 *
 * Kolom "Sumber" disimpulkan dari spk_id - bukan kolom tersimpan.
 *
 * Cara membaca: `configure()` memanggil `kolom()`, `filter()`, dan `aksi()`.
 */
class UangMasuksTable
{
    use FilterPeriodeUang;

    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            /*
             * Total bawaan Filament (bawah tabel) DIMATIKAN TOTAL - total
             * ditampilkan di bar ATAS tabel (lihat `->header()` di bawah).
             * Ini menghapus total ganda.
             */
            ->summaries(pageCondition: false, allTableCondition: false)
            // Kotak cari tabel ini dibedakan dari pencarian GLOBAL topbar.
            ->searchPlaceholder('Cari di tabel ini')
            // Cukup SATU baris total (11 Okt 2026 - keputusan user):
            // sebelumnya ada DUA total (bar atas + summarize bawah kolom).
            ->header(fn ($livewire) => view('filament.components.total-terfilter', [
                'judul' => 'Total Uang Masuk (terfilter)',
                'total' => (clone $livewire->getFilteredTableQuery())->sum('jumlah'),
                'catatan' => 'dari '.$livewire->getFilteredTableQuery()->count().' transaksi',
                'nada' => 'masuk',
            ]))
            ->columns(self::kolom())
            ->filters(self::filter())
            ->recordActions(self::aksi());
    }

    /**
     * @return array<int, mixed>
     */
    private static function kolom(): array
    {
        return [
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
                ->placeholder('-')
                ->searchable()
                ->wrap()
                ->description(fn ($record): ?string => $record->nama_pekerjaan),

            TextColumn::make('mitra.nama')
                ->label('Mitra')
                ->placeholder('-')
                ->toggleable(),

            TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR', locale: 'id')
                ->sortable()
                ->weight('medium')
                ->color('success')
                ->alignEnd(),

            TextColumn::make('jumlah_bukti')
                ->label('Bukti')
                ->state(fn ($record): string => $record->jumlahFileBukti() > 0
                    ? $record->jumlahFileBukti().' file'
                    : '-')
                ->badge()
                ->color(fn ($state): string => $state === '-' ? 'gray' : 'info')
                ->alignCenter(),

            TextColumn::make('keterangan')
                ->label('Keterangan')
                ->placeholder('-')
                ->limit(35)
                ->tooltip(fn ($record): ?string => $record->keterangan)
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('created_at')
                ->label('Dicatat')
                ->dateTime('d/m/Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private static function filter(): array
    {
        return [
            // SATU filter periode (Tahun/Bulan/Tanggal) - bukan tiga
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

            // Filter SPK - PRD FR-IN-004. Satu SPK bisa punya puluhan
            // penerimaan; admin harus bisa menyaring HANYA SPK itu.
            SelectFilter::make('spk_id')
                ->label('SPK')
                ->relationship('spk', 'nomor_spk')
                ->getOptionLabelFromRecordUsing(fn ($record): string => $record->nomor_spk.' - '.$record->nama_pekerjaan)
                ->searchable()
                ->preload(),

            TrashedFilter::make()->label('Data Terhapus'),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private static function aksi(): array
    {
        return [
            // LIHAT BUKTI - keluhan pengguna 29 Sep 2026: admin perlu cara
            // cepat mencari bukti transaksi tanpa membuka Edit.
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

            // `->visible()` MENIMPA visibility bawaan RestoreAction, yang
            // hanya tampil untuk record terhapus (`trashed()`). Tanpa cek
            // `trashed()`, tombol "Pulihkan data" muncul di SEMUA baris.
            RestoreAction::make()->visible(fn (UangMasuk $r): bool => UangMasukResource::bolehUbahData() && $r->trashed()),
        ];
    }
}
