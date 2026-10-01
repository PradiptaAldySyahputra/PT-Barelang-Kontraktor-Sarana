<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Pages;

use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use App\Support\Format;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Halaman DETAIL SPK (FR-SPK-005, prioritas High).
 *
 * ⚠️ SUMBER (PRD.md FR-SPK-005):
 *   "Sistem menampilkan detail SPK: data lengkap, uang masuk terkait,
 *    pengeluaran terkait."
 *
 * ⚠️ MASALAH SEBELUMNYA (temuan AUDIT-MENU-DAN-ALUR.md T-2):
 * Tidak ada halaman detail SPK. Yang ada hanya angka TOTAL lewat `withSum`,
 * bukan DAFTAR transaksi. Admin harus membuka menu Uang Masuk lalu memfilter
 * SPK untuk melihat transaksi mana saja milik satu SPK.
 *
 * Halaman ini menampilkan DATA LENGKAP SPK + dua panel read-only berisi
 * daftar uang masuk & uang keluar milik SPK tersebut (lihat RelationManager).
 */
class ViewSpk extends ViewRecord
{
    protected static string $resource = SpkResource::class;

    protected static ?string $title = 'Detail SPK';

    public function getSubheading(): ?string
    {
        $r = $this->getRecord();

        return $r->nomor_spk.' — '.$r->nama_pekerjaan;
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data SPK')
                    ->schema([
                        TextEntry::make('nomor_spk')->label('Nomor SPK'),
                        TextEntry::make('nama_pekerjaan')->label('Nama Pekerjaan')->columnSpanFull(),
                        TextEntry::make('mitra.nama')->label('Pemberi Kerja / Mitra')->placeholder('—'),
                        TextEntry::make('lokasi')->label('Lokasi')->placeholder('—'),
                        TextEntry::make('tanggal_spk')->label('Tanggal SPK')->date('d/m/Y')->placeholder('TANPA SPK'),
                        TextEntry::make('tanggal_akhir')->label('Tenggat')->date('d/m/Y')->placeholder('—'),
                    ])
                    ->columns(3),

                Section::make('Nilai & Tagihan')
                    ->schema([
                        TextEntry::make('nilai_spk')
                            ->label('Nilai SPK')
                            ->state(fn (Spk $r): string => Format::rupiah((float) $r->nilai_spk)),

                        TextEntry::make('total_masuk')
                            ->label('Sudah Diterima')
                            ->state(fn (Spk $r): string => Format::rupiah($r->totalPenerimaan()))
                            ->color('success'),

                        TextEntry::make('sisa_tagih')
                            ->label('Belum Diterima')
                            ->state(fn (Spk $r): string => Format::rupiah($r->sisaTagih()))
                            ->color(fn (Spk $r): string => $r->sisaTagih() > 0 ? 'warning' : 'success'),

                        TextEntry::make('status_spk')
                            ->label('Status Pekerjaan')
                            ->badge()
                            ->formatStateUsing(fn (?StatusSpk $state): string => $state?->label() ?? '—')
                            ->color(fn (?StatusSpk $state): string => $state?->warnaBadge() ?? 'gray'),

                        TextEntry::make('status_tagihan')
                            ->label('Status Tagihan')
                            ->badge()
                            ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? '—')
                            ->color(fn (?StatusTagihan $state): string => $state?->warnaBadge() ?? 'gray'),

                        TextEntry::make('status_antar')
                            ->label('Pengantaran Dokumen')
                            ->badge()
                            ->formatStateUsing(fn (?StatusAntar $state): string => $state?->label() ?? 'Belum Diantar')
                            ->color(fn (?StatusAntar $state): string => $state?->warnaBadge() ?? 'danger'),
                    ])
                    ->columns(3),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn (): bool => SpkResource::bolehUbahData()),
        ];
    }
}
