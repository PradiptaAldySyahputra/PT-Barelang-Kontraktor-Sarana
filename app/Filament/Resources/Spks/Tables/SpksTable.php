<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Tables;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Actions\CatatPembayaran;
use App\Filament\Exports\SpkExporter;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
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

                // ⚠️ KENAPA KOLOM INI DITAMBAH (keluhan pengguna 26 Sep 2026):
                // "pada spk uang dibayar kenapa tidak diperbarui?"
                // Ternyata datanya SUDAH benar (totalPenerimaan dihitung dari
                // uang_masuk), tetapi di menu List SPK kolomnya TIDAK ADA —
                // admin hanya melihat Nilai SPK & Status. Jadi walaupun uang
                // masuk tercatat, angka pembayaran tidak pernah tampil.
                TextColumn::make('diterima')
                    ->label('Sudah Diterima')
                    ->state(fn (Spk $record): float => $record->totalPenerimaan())
                    ->money('IDR', locale: 'id')
                    ->color('success')
                    ->description(fn (Spk $record): ?string => $record->nilai_spk > 0
                        ? number_format(min(100, $record->totalPenerimaan() / (float) $record->nilai_spk * 100), 1, ',', '.').'%'
                        : null)
                    ->alignEnd(),

                TextColumn::make('sisa_tagih')
                    ->label('Belum Diterima')
                    ->state(fn (Spk $record): float => $record->sisaTagih())
                    ->money('IDR', locale: 'id')
                    ->weight('bold')
                    ->color(fn (Spk $record): string => $record->sisaTagih() > 0 ? 'warning' : 'success')
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

                /*
                 * ⚠️ KOLOM BARU (permintaan pengguna 26 Sep 2026):
                 * Admin perlu langsung tahu mana dokumen SPK yang BELUM
                 * diantar & mana yang belum diunggah — dulu harus dibuka
                 * satu-satu.
                 */
                TextColumn::make('status_antar')
                    ->label('Pengantaran')
                    ->badge()
                    ->formatStateUsing(fn (?StatusAntar $state): string => $state?->label() ?? 'Belum Diantar')
                    ->color(fn (?StatusAntar $state): string => $state?->warnaBadge() ?? 'danger')
                    ->sortable(),

                TextColumn::make('tanggal_antar')
                    ->label('Tgl Antar')
                    ->date('d/m/Y')
                    ->placeholder('—')
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
                        : '—')
                    ->color(fn (Spk $record): string => $record->pernahDiperpanjang() ? 'warning' : 'gray')
                    ->tooltip(fn (Spk $record): ?string => $record->pernahDiperpanjang()
                        ? 'Tenggat awal: '.($record->perpanjangan[0]['dari'] ?? '—')
                        : null)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status_spk')
                    ->label('Status SPK')
                    ->options(StatusSpk::opsi()),

                SelectFilter::make('status_tagihan')
                    ->label('Status Tagihan')
                    ->options(StatusTagihan::opsi()),

                // Filter pengantaran — supaya admin bisa langsung menyaring
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
                 * ⚠️ FILTER `Jenis Sumber` DIHAPUS (26 Sep 2026).
                 *
                 * Bukti dari data: SPK dengan `jenis_sumber = 'luar'` (14 buah)
                 * IDENTIK dengan SPK `tanggal_spk = NULL` — yaitu yang sudah
                 * diwakili tab **"Tanpa SPK"** di atas tabel.
                 *
                 * Jadi filter ini DUPLIKAT: admin bisa memilih tab "Tanpa SPK"
                 * TAPI filter "Jenis Sumber = PLN" → hasil kosong. Permintaan
                 * pengguna: filter jangan bertumpuk & panjang.
                 *
                 * Filter `Pengantaran` di bawah TETAP ADA (informasi baru,
                 * tidak duplikat dengan tab mana pun).
                 */

                SelectFilter::make('dikerjakan_oleh')
                    ->label('Pelaksana')
                    ->options(DikerjakanOleh::opsi()),

                /*
                 * ⚠️ FILTER `Disubkonkan` DIHAPUS (26 Sep 2026).
                 *
                 * Filter itu memakai kolom `dikerjakan_oleh` yang SAMA dengan
                 * filter `Pelaksana` di atas — jadi DUPLIKAT. Admin bisa
                 * menyalakan "Disubkonkan" TAPI memilih Pelaksana "Dikerjakan
                 * Sendiri" → hasil kosong tanpa penjelasan.
                 *
                 * Cukup pakai `Pelaksana` (pilih "Disubkonkan") untuk maksud
                 * yang sama. Permintaan pengguna: filter jangan bertumpuk.
                 */

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
                // Detail SPK (FR-SPK-005) — membuka halaman berisi data lengkap
                // + daftar uang masuk & uang keluar milik SPK ini.
                ViewAction::make()
                    ->label('Detail')
                    ->visible(fn (): bool => true),

                // Catat pembayaran (termasuk sebagian: 50%, 95%, dst).
                CatatPembayaran::make(),

                EditAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => SpkResource::bolehUbahData()),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(SpkExporter::class),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => SpkResource::bolehUbahData()),
            ]);
    }
}
