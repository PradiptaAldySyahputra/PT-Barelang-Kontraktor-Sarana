<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\RelationManagers;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Models\UangKeluar;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * PANEL UANG KELUAR milik satu SPK — dipakai di halaman Detail SPK.
 *
 * ⚠️ SUMBER (PRD.md FR-SPK-005, prioritas High):
 *   "Sistem menampilkan detail SPK: data lengkap, uang masuk terkait,
 *    pengeluaran terkait."
 *
 * Menampilkan DAFTAR biaya yang dikaitkan ke SPK ini (material, upah,
 * transportasi, dst) — supaya admin bisa melihat rincian per pekerjaan
 * tanpa membuka menu Uang Keluar lalu memfilter SPK.
 *
 * BACA SAJA: pencatatan tetap lewat menu Uang Keluar.
 */
class UangKeluarRelationManager extends RelationManager
{
    protected static string $relationship = 'uangKeluar';

    protected static ?string $title = 'Uang Keluar (Pengeluaran)';

    protected static ?string $modelLabel = 'Uang Keluar';

    public function table(Table $table): Table
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
                    ->color('gray'),

                TextColumn::make('penerima')
                    ->label('Penerima')
                    ->placeholder('—')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->weight('medium')
                    ->color('danger')
                    ->alignEnd()
                    ->summarize(Sum::make()->label('Total')),

                TextColumn::make('jumlah_bukti')
                    ->label('Bukti')
                    ->state(fn (UangKeluar $r): string => $r->jumlahFileBukti() > 0
                        ? $r->jumlahFileBukti().' file'
                        : '—')
                    ->badge()
                    ->color(fn (string $state): string => $state === '—' ? 'gray' : 'info')
                    ->alignCenter(),
            ])
            ->headerActions([])
            ->recordActions([
                Action::make('lihatBukti')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-m-paper-clip')
                    ->color('info')
                    ->visible(fn (UangKeluar $r): bool => $r->jumlahFileBukti() > 0)
                    ->modalHeading('Bukti Pengeluaran')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (UangKeluar $r) => view('filament.components.daftar-bukti', [
                        'berkas' => $r->bukti ?? [],
                    ])),
            ])
            ->toolbarActions([]);
    }
}
