<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enums\DikerjakanOleh;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Filament\Resources\Spks\Pages\ViewSpk;
use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use App\Support\Format;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\Width;

/**
 * PREVIEW SPK — SLIDE-OVER berisi data lengkap satu SPK, dibuka dengan
 * MENGKLIK BARIS tabel. Tombol "Detail" terpisah di baris TIDAK lagi ada
 * (duplikat).
 *
 * ⚠️ PERMINTAAN USER (2 Okt 2026):
 *   "di list spk kenapa ada dua preview detail itu ketika di klik spk dan di
 *    klik button detail ... maksud saya satu slide menampilkan data ... kalau
 *    ingin lihat detail bisa di direct ke halaman detail, tapi bisa lakukan
 *    preview terlebih dahulu ... apakah button detail masih diperlukan kalau
 *    data diklik langsung bisa preview?"
 *
 * MASALAH SEBELUMNYA (akar masalah — dua jalur berbeda):
 *   - KLIK BARIS  → halaman detail (Filament ListRecords otomatis mengisi
 *                   `recordUrl` selama Resource punya halaman `view`).
 *   - TOMBOL      → modal preview (lebar 976px, memanjang ke samping).
 *   Dua jalur ini membingungkan dan tampak seperti "dua preview".
 *
 * SOLUSI (satu jalan, preview dulu):
 *   1. Baris tabel di-set `recordUrl(null)` → klik baris membuka preview.
 *   2. Tombol "Detail" di baris DIHAPUS (`hidden()`), tapi aksinya tetap
 *      terdaftar supaya baris tetap bisa diklik (lihat `recordAction`).
 *   3. Preview = SLIDE-OVER (panel samping), bukan modal lebar tengah.
 *   4. Di dalam preview ada tombol "Buka Halaman Detail" menuju halaman
 *      detail penuh — jadi admin "preview dulu, baru pindah ke halaman".
 *   5. Aksi Ubah/Hapus/Kelola ada DI DALAM preview (Admin saja).
 *
 * ⚠️ OTORISASI DIJAGA:
 * Tombol Ubah/Hapus hanya muncul untuk role berwenang (Admin). Direktur —
 * yang hanya boleh melihat — tidak melihat tombol itu di preview.
 */
class PreviewSpk
{
    /**
     * @param  array<int, Action|ActionGroup>  $aksi  aksi khusus menu (mis. Kelola Tagihan)
     * @param  bool  $aksiUbahHapus  tampilkan Ubah & Hapus (List SPK); menu monitoring = false
     */
    public static function make(array $aksi = [], bool $aksiUbahHapus = true): Action
    {
        return AksiKlikBaris::make('view')
            ->label('Detail')
            ->icon('heroicon-m-eye')
            ->color('gray')
            // Baris sudah bisa diklik → tombol "Detail" di baris tidak perlu.
            // Aksi tetap terdaftar (recordAction) supaya klik baris membuka
            // preview ini. `AksiKlikBaris` memastikan aksi tetap bisa di-mount
            // walau tombolnya disembunyikan.
            ->hidden()
            ->slideOver()
            ->modalHeading(fn (Spk $record): string => 'Detail SPK — '.$record->nomor_spk)
            ->modalDescription('Ringkasan SPK. Buka halaman detail untuk transaksi lengkap.')
            ->modalWidth(Width::ScreenMedium)
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Tutup')
            ->schema(self::skema())
            ->modalFooterActions(function () use ($aksi, $aksiUbahHapus): array {
                $aksiFooter = [...$aksi];

                if ($aksiUbahHapus) {
                    $aksiFooter[] = self::ubah();
                    $aksiFooter[] = self::hapus();
                }

                // "Preview dulu, baru pindah ke halaman detail" (permintaan user).
                $aksiFooter[] = self::bukaDetail();

                return $aksiFooter;
            });
    }

    /**
     * Tombol menuju HALAMAN DETAIL penuh — dipakai setelah admin selesai
     * melihat ringkasan di preview.
     */
    public static function bukaDetail(): Action
    {
        return Action::make('bukaDetail')
            ->label('Buka Halaman Detail')
            ->icon('heroicon-m-arrow-top-right-on-square')
            ->color('gray')
            ->url(fn (Spk $record): string => ViewSpk::getUrl(['record' => $record]));
    }

    /**
     * Tombol "Ubah" — buka halaman Edit SPK.
     */
    public static function ubah(): EditAction
    {
        return EditAction::make('ubah')
            ->label('Ubah')
            ->icon('heroicon-m-pencil-square')
            ->visible(fn (): bool => SpkResource::bolehUbahData());
    }

    /**
     * Tombol "Hapus" — hapus SPK (soft delete).
     */
    public static function hapus(): DeleteAction
    {
        return DeleteAction::make('hapus')
            ->label('Hapus')
            ->icon('heroicon-m-trash')
            ->visible(fn (): bool => SpkResource::bolehUbahData());
    }

    /**
     * @return array<int, Section>
     */
    private static function skema(): array
    {
        return [
            Section::make('Data SPK')
                ->schema([
                    TextEntry::make('nomor_spk')->label('Nomor SPK'),
                    TextEntry::make('tanggal_spk')->label('Tanggal SPK')->date('d/m/Y')->placeholder('TANPA SPK'),
                    TextEntry::make('nama_pekerjaan')->label('Nama Pekerjaan')->columnSpanFull(),
                    TextEntry::make('mitra.nama')->label('Pemberi Kerja / Mitra')->placeholder('—'),
                    TextEntry::make('lokasi')->label('Lokasi')->placeholder('—'),
                    TextEntry::make('tanggal_akhir')->label('Tenggat')->date('d/m/Y')->placeholder('—'),
                    TextEntry::make('keterangan')->label('Keterangan')->placeholder('—')->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Nilai & Tagihan')
                ->schema([
                    TextEntry::make('nilai_spk')
                        ->label('Nilai SPK')
                        ->state(fn (Spk $r): string => Format::rupiah((float) $r->nilai_spk)),

                    TextEntry::make('diterima')
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
                        ->formatStateUsing(fn (?StatusTagihan $state): string => $state?->label() ?? 'Belum Ditagihkan')
                        ->color(fn (?StatusTagihan $state): string => $state?->warnaBadge() ?? 'gray'),

                    TextEntry::make('status_antar')
                        ->label('Pengantaran Dokumen')
                        ->badge()
                        ->formatStateUsing(fn (?StatusAntar $state): string => $state?->label() ?? 'Belum Diantar')
                        ->color(fn (?StatusAntar $state): string => $state?->warnaBadge() ?? 'danger'),
                ])
                ->columns(2),

            Section::make('Pelaksana, Dokumen & Perpanjangan')
                ->schema([
                    TextEntry::make('dikerjakan_oleh')
                        ->label('Pelaksana')
                        ->badge()
                        ->formatStateUsing(fn ($state): string => $state instanceof DikerjakanOleh
                            ? $state->labelPendek()
                            : '—')
                        ->color(fn ($state): string => $state === DikerjakanOleh::Subkon ? 'warning' : 'gray'),

                    TextEntry::make('subkon.nama')->label('Subkon')->placeholder('—'),

                    TextEntry::make('tanggal_antar')->label('Tanggal Antar')->date('d/m/Y')->placeholder('—'),

                    TextEntry::make('dokumen')
                        ->label('Dokumen')
                        ->state(fn (Spk $r): string => $r->jumlahDokumen() > 0
                            ? $r->jumlahDokumen().' berkas'
                            : 'Belum ada dokumen'),

                    TextEntry::make('perpanjangan')
                        ->label('Perpanjangan Tenggat')
                        ->state(fn (Spk $r): string => $r->pernahDiperpanjang()
                            ? 'Diperpanjang '.$r->jumlahPerpanjangan().'×'
                            : 'Tidak ada')
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ];
    }
}
