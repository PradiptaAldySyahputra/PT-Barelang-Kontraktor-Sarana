<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Tables;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Actions\CatatPembayaran;
use App\Filament\Actions\EksporPdf;
use App\Filament\Actions\PreviewSpk;
use App\Filament\Exports\SpkExporter;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Tabel LIST SPK - data induk SPK (bukan monitoring).
 *
 * KEPUTUSAN USER (19 Sep 2026):
 *   - Kolom Biaya, Laba/Rugi, Piutang, dan Retensi DIHAPUS.
 *   - Status TIDAK diubah dari sini (lewat menu monitoring).
 *
 * Tabel ini fokus pada identitas SPK: nomor, pekerjaan, mitra,
 * tanggal, nilai, pelaksana, dan status (tampil saja).
 *
 * Cara membaca: `configure()` memanggil tiga method di bawah - `kolom()`,
 * `filter()`, dan `aksi()`.
 */
class SpksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_spk', 'desc')
            /*
             * KOTAK CARI GANDA (perbaikan 12 Okt 2026):
             * Topbar punya pencarian GLOBAL, toolbar tabel punya pencarian
             * LOKAL. Dulu keduanya berlabel "Cari" sehingga membingungkan.
             * Sekarang dibedakan: yang ini menyaring HANYA tabel ini.
             */
            ->searchPlaceholder('Cari di tabel ini')
            ->columns(self::kolom())
            ->filters(self::filter())
            /*
             * SATU JALAN MASUK (perbaikan 2 Okt 2026) - permintaan user:
             *   "kenapa ada dua preview detail itu ketika di klik spk dan di
             *    klik button detail ... apakah button detail masih diperlukan
             *    kalau data diklik langsung bisa preview?"
             *
             * AKAR MASALAH: Filament otomatis mengisi `recordUrl` selama
             * Resource punya halaman `view` -> KLIK BARIS menuju HALAMAN
             * detail, sedangkan tombol "Detail" membuka MODAL.
             *
             * SOLUSI:
             *   - `recordUrl(null)`      -> klik baris tidak lagi ke halaman.
             *   - `recordAction('view')` -> klik baris membuka PREVIEW.
             *   - Tombol "Detail" di baris dihapus (aksi `view` di-`hidden()`).
             *   - Tombol "Buka Halaman Detail" ada di dalam preview.
             */
            ->recordUrl(null)
            ->recordAction('view')
            ->recordActions([
                PreviewSpk::make(),

                // Catat pembayaran tetap di baris: aksi CEPAT yang sering
                // dipakai admin saat menagih - bukan jalur "detail".
                CatatPembayaran::make(),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(SpkExporter::class),

                // PDF - untuk menyerahkan/mengarsipkan (mis. lampiran pajak).
                // Memakai exporter yang sama, jadi kolomnya identik dengan Excel.
                EksporPdf::make(SpkExporter::class, 'Daftar SPK'),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => SpkResource::bolehUbahData()),
            ]);
    }

    /**
     * @return array<int, mixed>
     */
    private static function kolom(): array
    {
        return [
            TextColumn::make('nomor_spk')
                ->label('Nomor SPK')
                ->searchable()
                ->sortable()
                ->copyable()
                ->weight('medium')
                ->wrap(),

            // Pekerjaan ditampilkan sebagai paragraf yang dibatasi.
            //
            // ⚠️ DIKETATKAN (12 Okt 2026) - kepadatan tabel:
            // Dulu `lineClamp(4)` membuat satu baris setinggi ~153px (5 baris
            // teks) sehingga tabel keuangan harus banyak di-scroll. Tabel
            // keuangan dibaca baris-per-baris; 2 baris cukup untuk mengenali
            // pekerjaan, detail lengkap ada di preview. Lokasi tetap di
            // `description` (baris kedua yang kecil).
            TextColumn::make('nama_pekerjaan')
                ->label('Pekerjaan')
                ->searchable()
                ->wrap()
                ->lineClamp(2)
                ->description(fn (Spk $record): ?string => $record->lokasi),

            TextColumn::make('mitra.nama')
                ->label('Mitra')
                ->placeholder('-')
                ->toggleable(),

            TextColumn::make('tanggal_spk')
                ->label('Tanggal SPK')
                ->date('d/m/Y')
                ->placeholder('Tanpa tanggal')
                ->sortable(),

            TextColumn::make('tanggal_akhir')
                ->label('Tenggat')
                ->date('d/m/Y')
                ->placeholder('-')
                ->sortable()
                ->toggleable(),

            TextColumn::make('nilai_spk')
                ->label('Nilai SPK')
                ->money('IDR', locale: 'id')
                ->sortable()
                // ⚠️ Nilai uang WAJIB rata kanan + tebal agar antar baris
                // mudah dibandingkan (dosa besar tabel keuangan bila tidak).
                ->weight('medium')
                ->alignEnd(),

            // Keluhan pengguna 26 Sep 2026: "pada spk uang dibayar kenapa
            // tidak diperbarui?" Datanya sudah benar, tetapi kolomnya tidak
            // ada di List SPK. Kolom ini menampilkannya.
            TextColumn::make('diterima')
                ->label('Sudah Diterima')
                ->state(fn (Spk $record): float => $record->totalPenerimaan())
                ->money('IDR', locale: 'id')
                ->color('success')
                ->weight('medium')
                ->description(fn (Spk $record): ?string => $record->nilai_spk > 0
                    ? number_format(min(100, $record->totalPenerimaan() / (float) $record->nilai_spk * 100), 1, ',', '.').'%'
                    : null)
                ->alignEnd()
                // Disembunyikan default (11 Okt 2026): info tagihan punya
                // menu sendiri (Tagihan SPK).
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('sisa_tagih')
                ->label('Belum Diterima')
                ->state(fn (Spk $record): float => $record->sisaTagih())
                ->money('IDR', locale: 'id')
                ->weight('bold')
                ->color(fn (Spk $record): string => $record->sisaTagih() > 0 ? 'warning' : 'success')
                ->alignEnd()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('dikerjakan_oleh')
                ->label('Pelaksana')
                ->badge()
                ->formatStateUsing(fn ($state): string => $state instanceof DikerjakanOleh
                    ? $state->labelPendek()
                    : '-')
                ->color(fn ($state): string => ($state ?? DikerjakanOleh::Sendiri)->warnaBadge())
                ->description(fn (Spk $record): ?string => $record->subkon?->nama)
                ->placeholder('-')
                ->toggleable(),

            TextColumn::make('status_spk')
                ->label('Status SPK')
                ->badge()
                ->formatStateUsing(fn (?StatusSpk $state): string => $state?->label() ?? '-')
                ->color(fn (?StatusSpk $state): string => $state?->warnaBadge() ?? 'gray')
                // Disembunyikan default (11 Okt 2026): status punya menu sendiri.
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('status_tagihan')
                ->label('Status Tagihan')
                ->badge()
                ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? '-')
                ->color(fn (?StatusTagihan $state): string => $state?->warnaBadge() ?? 'gray')
                ->toggleable(isToggledHiddenByDefault: true),

            // Kolom baru (permintaan pengguna 26 Sep 2026): admin perlu
            // langsung tahu mana dokumen SPK yang belum diantar.
            TextColumn::make('status_antar')
                ->label('Pengantaran')
                ->badge()
                ->formatStateUsing(fn (?StatusAntar $state): string => $state?->label() ?? 'Belum Diantar')
                ->color(fn (?StatusAntar $state): string => $state?->warnaBadge() ?? 'danger')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('tanggal_antar')
                ->label('Tgl Antar')
                ->date('d/m/Y')
                ->placeholder('-')
                ->toggleable(isToggledHiddenByDefault: true),

            IconColumn::make('jumlah_dokumen')
                ->label('Dokumen')
                ->state(fn (Spk $record): int => $record->jumlahDokumen())
                ->icon(fn (int $state): string => $state > 0
                    ? 'heroicon-o-paper-clip'
                    : 'heroicon-o-x-circle')
                ->color(fn (int $state): string => $state > 0 ? 'success' : 'gray')
                ->tooltip(fn (Spk $record): string => $record->jumlahDokumen() > 0
                    ? $record->jumlahDokumen().' berkas'
                    : 'Belum ada dokumen')
                ->alignCenter(),

            TextColumn::make('jumlah_perpanjangan')
                ->label('Perpanjangan')
                ->badge()
                ->state(fn (Spk $record): string => $record->pernahDiperpanjang()
                    ? 'Diperpanjang '.$record->jumlahPerpanjangan().'×'
                    : '-')
                ->color(fn (Spk $record): string => $record->pernahDiperpanjang() ? 'warning' : 'gray')
                ->tooltip(fn (Spk $record): ?string => $record->pernahDiperpanjang()
                    ? 'Tenggat awal: '.($record->perpanjangan[0]['dari'] ?? '-')
                    : null)
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<int, mixed>
     */
    private static function filter(): array
    {
        return [
            SelectFilter::make('status_spk')
                ->label('Status SPK')
                ->options(StatusSpk::opsi()),

            SelectFilter::make('status_tagihan')
                ->label('Status Tagihan')
                ->options(StatusTagihan::opsi()),

            // Filter pengantaran - supaya admin bisa langsung menyaring
            // "mana dokumen yang belum diantar" (permintaan pengguna).
            SelectFilter::make('status_antar')
                ->label('Pengantaran')
                ->options(StatusAntar::opsi()),

            SelectFilter::make('mitra_id')
                ->label('Mitra')
                ->relationship('mitra', 'nama')
                ->searchable()
                ->preload(),

            /*
             * FILTER `Jenis Sumber` & `Disubkonkan` DIHAPUS (26 Sep 2026).
             *
             * `Jenis Sumber`: SPK `jenis_sumber = 'luar'` identik dengan
             * SPK `tanggal_spk = NULL`, yang sudah diwakili tab "Tanpa SPK".
             * `Disubkonkan`: memakai kolom `dikerjakan_oleh` yang SAMA dengan
             * filter `Pelaksana` - duplikat.
             *
             * Permintaan pengguna: filter jangan bertumpuk & panjang.
             */

            SelectFilter::make('dikerjakan_oleh')
                ->label('Pelaksana')
                ->options(DikerjakanOleh::opsi()),

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
        ];
    }
}
