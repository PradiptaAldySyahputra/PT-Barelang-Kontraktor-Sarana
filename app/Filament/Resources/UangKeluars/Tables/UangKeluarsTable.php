<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Tables;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Filament\Concerns\FilterPeriodeUang;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Models\UangKeluar;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

/**
 * Tabel daftar Uang Keluar.
 *
 * Cara membaca: `configure()` memanggil `kolom()`, `filter()`, dan `aksi()`.
 */
class UangKeluarsTable
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
            // Cukup SATU baris total (11 Okt 2026 - keputusan user): dulu ada
            // bar atas + `summarize(Sum)` bawah kolom = dua angka total.
            ->header(function ($livewire) {
                $rincian = (clone $livewire->getFilteredTableQuery())
                    ->selectRaw('kategori, SUM(jumlah) as total')
                    ->groupBy('kategori')
                    ->orderByDesc('total')
                    ->pluck('total', 'kategori');

                $pecahan = [];
                foreach ($rincian as $kode => $nilai) {
                    $kategori = KategoriPengeluaran::tryFrom((string) $kode);
                    $pecahan[$kategori?->label() ?? 'Lainnya'] = (float) $nilai;
                }

                return view('filament.components.total-terfilter', [
                    'judul' => 'Total Uang Keluar (terfilter)',
                    'total' => (clone $livewire->getFilteredTableQuery())->sum('jumlah'),
                    'catatan' => 'dari '.$livewire->getFilteredTableQuery()->count().' transaksi',
                    'rincian' => $pecahan,
                    'nada' => 'keluar',
                ]);
            })
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

            TextColumn::make('kategori')
                ->label('Kategori')
                ->badge()
                ->formatStateUsing(fn (?KategoriPengeluaran $state): string => $state?->label() ?? '-')
                ->color(fn (?KategoriPengeluaran $state): string => ($state ?? KategoriPengeluaran::Lainnya)->warnaBadge())
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
                ->placeholder('-')
                ->searchable()
                ->wrap(),

            TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR', locale: 'id')
                ->sortable()
                ->weight('medium')
                ->color('danger')
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

            SelectFilter::make('kategori')
                ->label('Kategori')
                ->options(KategoriPengeluaran::opsi()),

            // Filter SPK - PRD FR-OUT-004. Biaya langsung pekerjaan dikaitkan
            // ke SPK (Rules §2 butir 6); admin harus bisa menyaring HANYA SPK
            // itu saat ada selisih atau pemeriksaan pajak.
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
            // cepat mencari bukti transaksi. Satu transaksi bisa punya
            // beberapa nota yang digabung jadi 1 PDF/bulan.
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

            // `->visible()` MENIMPA visibility bawaan RestoreAction, yang
            // hanya tampil untuk record terhapus (`trashed()`). Tanpa cek
            // `trashed()`, tombol "Pulihkan data" muncul di SEMUA baris.
            RestoreAction::make()->visible(fn (UangKeluar $r): bool => UangKeluarResource::bolehUbahData() && $r->trashed()),
        ];
    }
}
