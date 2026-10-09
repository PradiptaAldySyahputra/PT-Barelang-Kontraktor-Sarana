<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Resources\Spks\SpkResource;
use App\Models\Spk;
use App\Models\UangMasuk;
use App\Support\Format;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

/**
 * Aksi "Catat Pembayaran" untuk SPK — termasuk pembayaran SEBAGIAN.
 *
 * ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026):
 * "dibagian spk juga belum anda update bagian tagihan atau bagian spk kalau
 *  sudah bayar setengah atau berapa persen untuk update nilai atau uangnya
 *  tidak ada jadi dari hasil yang belum diterima bagaimana kalau sudah ada
 *  yang bayar setengah, dari mana hasil potongan uang terima kalau tidak ada
 *  uang dibayar"
 *
 * MASALAH SEBELUMNYA:
 * Angka "Sudah Diterima" dihitung dari tabel `uang_masuk`, tetapi TIDAK ADA
 * jalan mencatat pembayaran dari halaman SPK. Admin harus membuka menu
 * Uang Masuk, membuat transaksi baru, lalu memilih SPK-nya secara manual —
 * merepotkan dan mudah salah pilih.
 *
 * SOLUSI (tetap 5 tabel — tidak ada tabel baru):
 * Aksi ini membuat satu baris `uang_masuk` yang terhubung ke SPK. Karena
 * `SinkronStatusTagihanObserver` sudah ada, status tagihan langsung
 * menyesuaikan sendiri:
 *   - bayar sebagian  → "Menunggu Pembayaran" (sisa tetap terlihat)
 *   - bayar penuh     → "Dibayar"
 *
 * Admin cukup mengetik jumlah ATAU memilih persen (50% / 95% / dst) — jumlah
 * dihitung otomatis dari Nilai SPK.
 */
class CatatPembayaran
{
    public static function make(string $nama = 'catatPembayaran'): Action
    {
        return Action::make($nama)
            ->label('Catat Pembayaran')
            ->icon('heroicon-m-banknotes')
            ->color('success')
            ->modalHeading('Catat Pembayaran SPK')
            ->modalDescription('Pembayaran sebagian diperbolehkan — sisa akan otomatis dihitung.')
            ->modalSubmitActionLabel('Simpan Pembayaran')
            ->visible(fn (): bool => SpkResource::bolehUbahData())
            ->fillForm(fn (Spk $record): array => [
                'tanggal' => now()->toDateString(),
            ])
            ->form([
                // Ringkasan supaya admin tahu posisi uangnya sebelum mengisi.
                Placeholder::make('ringkasan')
                    ->hiddenLabel()
                    ->content(fn (Spk $record): string => implode('  •  ', array_filter([
                        'Nilai SPK: '.Format::rupiah((float) $record->nilai_spk),
                        'Sudah Diterima: '.Format::rupiah($record->totalPenerimaan()),
                        'Belum Diterima: '.Format::rupiah($record->sisaTagih()),
                    ]))),

                // --- Pilih persen (opsional) -> jumlah terisi otomatis ---
                Select::make('persen')
                    ->label('Bayar berapa persen?')
                    ->options([
                        '100' => '100% — Lunas',
                        '95' => '95%',
                        '90' => '90%',
                        '70' => '70%',
                        '50' => '50% — Setengah',
                        '30' => '30%',
                        '20' => '20%',
                        'sisa' => 'Seluruh sisa tagihan',
                    ])
                    ->placeholder('(opsional) pilih untuk menghitung otomatis')
                    ->native(false)
                    ->live()
                    ->dehydrated(false)
                    ->afterStateUpdated(function (?string $state, Get $get, Set $set, Spk $record): void {
                        if (blank($state)) {
                            return;
                        }

                        $nilai = (float) $record->nilai_spk;

                        $jumlah = $state === 'sisa'
                            ? $record->sisaTagih()
                            : round($nilai * ((float) $state / 100), 2);

                        $set('jumlah', $jumlah);
                    }),

                // --- Jumlah rupiah (wajib) ---
                TextInput::make('jumlah')
                    ->label('Jumlah Diterima (Rp)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->prefix('Rp')
                    // -------------------------------------------------
                    // ⚠️ BUG (temuan 9 Okt 2026) — CEGAH OVERPAY.
                    //
                    // Form Uang Masuk SUDAH menolak penerimaan melebihi
                    // piutang SPK, TAPI aksi ini TIDAK. Akibatnya admin bisa
                    // mencatat pembayaran Rp 500 juta untuk SPK Rp 100 juta
                    // lewat halaman SPK → piutang jadi NEGATIF & laporan rusak.
                    // Aturan yang sama kini diterapkan di sini.
                    // -------------------------------------------------
                    ->rules([
                        fn (Spk $record): Closure => function (string $attribute, $value, Closure $fail) use ($record): void {
                            $sisa = $record->sisaTagih();

                            if ((float) $value > $sisa + 0.01) {
                                $fail(sprintf(
                                    'Melebihi sisa tagihan. Nilai SPK Rp %s, sudah diterima Rp %s — maksimal Rp %s.',
                                    number_format((float) $record->nilai_spk, 0, ',', '.'),
                                    number_format($record->totalPenerimaan(), 0, ',', '.'),
                                    number_format($sisa, 0, ',', '.'),
                                ));
                            }
                        },
                    ])
                    ->helperText(fn (Spk $record): string => 'Sisa tagihan saat ini: '.Format::rupiah($record->sisaTagih())),

                DatePicker::make('tanggal')
                    ->label('Tanggal Diterima')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),

                TextInput::make('keterangan')
                    ->label('Keterangan (opsional)')
                    ->maxLength(255)
                    ->placeholder('mis. Termin 1 / DP 50% / Pelunasan'),
            ])
            ->action(function (array $data, Spk $record): void {
                $jumlah = (float) $data['jumlah'];

                UangMasuk::create([
                    'spk_id' => $record->id,
                    'tanggal' => $data['tanggal'],
                    'jumlah' => $jumlah,
                    'mitra_id' => $record->mitra_id,
                    'keterangan' => $data['keterangan']
                        ?: 'Pembayaran SPK '.$record->nomor_spk,
                ]);

                // Status tagihan sudah disinkronkan otomatis oleh observer.
                $record->refresh();

                $persen = (float) $record->nilai_spk > 0
                    ? round($record->totalPenerimaan() / (float) $record->nilai_spk * 100, 1)
                    : 0;

                Notification::make()
                    ->title('Pembayaran dicatat')
                    ->body(
                        Format::rupiah($jumlah).' tersimpan. '
                        .'Total diterima '.Format::rupiah($record->totalPenerimaan())
                        .' ('.$persen.'% dari nilai SPK). '
                        .'Sisa: '.Format::rupiah($record->sisaTagih()).'.'
                    )
                    ->success()
                    ->send();
            });
    }
}
