<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\RelationManagers;

use App\Enums\AkunKas;
use App\Models\UangMasuk;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * PANEL UANG MASUK milik satu SPK — dipakai di halaman Detail SPK.
 *
 * ⚠️ SUMBER (PRD.md FR-SPK-005, prioritas High):
 *   "Sistem menampilkan detail SPK: data lengkap, uang masuk terkait,
 *    pengeluaran terkait."
 *
 * Sebelumnya angka penerimaan hanya tampil sebagai TOTAL (`withSum`), tanpa
 * daftar transaksinya. Panel ini menampilkan DAFTAR penerimaan SPK tersebut,
 * sehingga admin tidak perlu membuka menu Uang Masuk lalu memfilter SPK.
 *
 * BACA SAJA: tidak ada tombol tambah/ubah/hapus di sini — pencatatan tetap
 * lewat menu Uang Masuk (satu tempat input, sesuai alur yang sudah dikenal).
 */
class UangMasukRelationManager extends RelationManager
{
    protected static string $relationship = 'uangMasuk';

    protected static ?string $title = 'Uang Masuk (Penerimaan)';

    protected static ?string $modelLabel = 'Uang Masuk';

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

                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR', locale: 'id')
                    ->weight('medium')
                    ->color('success')
                    ->alignEnd()
                    ->summarize(Sum::make()->label('Total')),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->placeholder('—')
                    ->wrap(),

                TextColumn::make('jumlah_bukti')
                    ->label('Bukti')
                    ->state(fn (UangMasuk $r): string => $r->jumlahFileBukti() > 0
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
                    ->visible(fn (UangMasuk $r): bool => $r->jumlahFileBukti() > 0)
                    ->modalHeading('Bukti Penerimaan')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (UangMasuk $r) => view('filament.components.daftar-bukti', [
                        'berkas' => $r->bukti ?? [],
                    ])),
            ])
            ->toolbarActions([]);
    }
}
