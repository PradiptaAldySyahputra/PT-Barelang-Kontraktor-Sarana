<?php

declare(strict_types=1);

namespace App\Filament\Resources\Mitras\Tables;

use App\Enums\KategoriMitra;
use App\Filament\Actions\EksporPdf;
use App\Filament\Exports\MitraExporter;
use App\Filament\Resources\Mitras\MitraResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Tabel daftar Mitra.
 */
class MitrasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('nama')
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Mitra')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?KategoriMitra $state): string => $state?->label() ?? '—')
                    ->color(fn (?KategoriMitra $state): string => match ($state) {
                        KategoriMitra::Mitra => 'primary',
                        KategoriMitra::Subkon => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('kontak')
                    ->label('Kontak')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('spk_count')
                    ->label('Jml SPK')
                    ->counts('spk')
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->placeholder('—')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                /*
                 * ⚠️ FILTER DIHAPUS — sudah diwakili TAB (permintaan pengguna:
                 * "filter dropdown terlalu banyak dan panjang susah user").
                 *
                 * Dulu di sini ada TernaryFilter 'Aktif' + SelectFilter
                 * 'Kategori'. Keduanya DUPLIKAT dengan tab di atas halaman
                 * (Aktif / Mitra / Subkon) → membingungkan: admin bisa
                 * memilih tab "Subkon" TAPI filter "Kategori = Mitra"
                 * sekaligus, hasilnya kosong tanpa penjelasan.
                 *
                 * Sekarang cukup satu tempat: TAB.
                 *
                 * Filter yang TETAP dipertahankan: pencarian (search) — itu
                 * tidak duplikat dengan tab dan justru cara tercepat mencari.
                 */
            ])
            ->recordActions([
                EditAction::make()->visible(fn (): bool => MitraResource::bolehUbahData()),
                DeleteAction::make()->visible(fn (): bool => MitraResource::bolehUbahData()),
            ])
            ->toolbarActions([
                ExportAction::make()
                    ->label('Ekspor Excel')
                    ->icon('heroicon-m-table-cells')
                    ->exporter(MitraExporter::class),

                EksporPdf::make(MitraExporter::class, 'Daftar Mitra'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => MitraResource::bolehUbahData()),
            ]);
    }
}
