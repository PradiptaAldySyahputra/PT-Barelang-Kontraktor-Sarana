<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangMasuks\Schemas;

use App\Models\Spk;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

/**
 * Form Uang Masuk — 2 MODE.
 *
 * MODE 1: Berdasarkan SPK
 *   Pilih SPK -> nomor_spk & nama_pekerjaan terisi OTOMATIS (read-only).
 *   spk_id terisi -> sistem tahu ini penerimaan dari SPK.
 *
 * MODE 2: Manual / Luar SPK
 *   Isi nomor & nama pekerjaan manual. spk_id dibiarkan NULL.
 *
 * Sumber uang masuk TIDAK disimpan sebagai kolom terpisah — disimpulkan
 * dari `spk_id` (lihat Schema.md §3 dan model UangMasuk::isDariSpk()).
 */
class UangMasukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Sumber Penerimaan')
                    ->description('Pilih "Berdasarkan SPK" jika uang masuk dari penagihan SPK. Pilih "Manual" untuk penerimaan di luar SPK (mis. penjualan sisa material).')
                    ->schema([
                        Radio::make('mode')
                            ->label('Mode Input')
                            ->options([
                                'spk' => 'Berdasarkan SPK',
                                'manual' => 'Manual / Luar SPK',
                            ])
                            ->default('spk')
                            ->required()
                            ->live()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->afterStateHydrated(function (Radio $component, $state, ?object $record): void {
                                // Saat mengubah data lama, tentukan mode dari spk_id
                                if ($record !== null) {
                                    $component->state($record->spk_id !== null ? 'spk' : 'manual');
                                }
                            }),
                    ]),

                Section::make('Data SPK')
                    ->visible(fn (Get $get): bool => $get('mode') === 'spk')
                    ->schema([
                        Select::make('spk_id')
                            ->label('Pilih SPK')
                            ->options(
                                fn (): array => Spk::query()
                                    ->orderByDesc('tanggal_spk')
                                    ->get()
                                    ->mapWithKeys(fn (Spk $spk): array => [
                                        $spk->id => $spk->nomor_spk.' — '.$spk->nama_pekerjaan,
                                    ])
                                    ->all()
                            )
                            ->searchable()
                            ->preload()
                            ->required(fn (Get $get): bool => $get('mode') === 'spk')
                            ->live()
                            ->afterStateUpdated(function (?int $state, Set $set): void {
                                $spk = $state ? Spk::find($state) : null;

                                if ($spk !== null) {
                                    $set('nomor_spk', $spk->nomor_spk);
                                    $set('nama_pekerjaan', $spk->nama_pekerjaan);
                                    $set('mitra_id', $spk->mitra_id);
                                }
                            })
                            ->helperText('Nomor SPK & nama pekerjaan akan terisi otomatis.')
                            ->columnSpanFull(),

                        TextInput::make('nomor_spk')
                            ->label('Nomor SPK')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('terisi otomatis'),

                        TextInput::make('nama_pekerjaan')
                            ->label('Nama Pekerjaan')
                            ->disabled()
                            ->dehydrated()
                            ->placeholder('terisi otomatis'),
                    ])
                    ->columns(2),

                Section::make('Data Manual (Luar SPK)')
                    ->visible(fn (Get $get): bool => $get('mode') === 'manual')
                    ->schema([
                        TextInput::make('nomor_spk')
                            ->label('Nomor Referensi')
                            ->maxLength(150)
                            ->placeholder('Boleh dikosongkan'),

                        TextInput::make('nama_pekerjaan')
                            ->label('Keterangan Pekerjaan / Sumber')
                            ->maxLength(255)
                            ->placeholder('mis. Penjualan sisa material'),
                    ])
                    ->columns(2),

                Section::make('Detail Penerimaan')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal Masuk')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),

                        TextInput::make('jumlah')
                            ->label('Jumlah (Rp)')
                            ->required()
                            ->numeric()
                            ->minValue(0.01)
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                            ->stripCharacters('.')
                            ->live(onBlur: true)
                            ->dehydrateStateUsing(fn ($state): float => (float) $state)
                            // -------------------------------------------------
                            // CEGAH uang masuk melebihi piutang SPK.
                            //
                            // Tanpa ini, untuk SPK Rp 100 juta bisa diinput
                            // Rp 500 juta dan angka laba-rugi langsung rusak.
                            // -------------------------------------------------
                            ->rules([
                                fn (Get $get, ?object $record): \Closure => function (string $attribute, $value, \Closure $fail) use ($get, $record): void {
                                    $spkId = $get('spk_id');

                                    if (blank($spkId)) {
                                        return; // mode manual (luar SPK) — tidak dibatasi
                                    }

                                    $spk = Spk::find($spkId);

                                    if (! $spk) {
                                        return;
                                    }

                                    // Saat EDIT, kecualikan nominal record ini sendiri.
                                    $sudahDiterima = $spk->uangMasuk()
                                        ->when($record?->id, fn ($q) => $q->whereKeyNot($record->id))
                                        ->sum('jumlah');

                                    $batas = $spk->nilaiTagih() - (float) $sudahDiterima;

                                    if ((float) $value > $batas + 0.01) {
                                        $fail(sprintf(
                                            'Melebihi piutang SPK. Nilai SPK Rp %s, retensi ditahan Rp %s, sudah diterima Rp %s — maksimal Rp %s.',
                                            number_format((float) $spk->nilai_spk, 0, ',', '.'),
                                            number_format($spk->retensiDitahan(), 0, ',', '.'),
                                            number_format((float) $sudahDiterima, 0, ',', '.'),
                                            number_format(max(0, $batas), 0, ',', '.'),
                                        ));
                                    }
                                },
                            ])
                            ->helperText(function (Get $get, ?object $record): ?string {
                                $spkId = $get('spk_id');

                                if (blank($spkId)) {
                                    return null;
                                }

                                $spk = Spk::find($spkId);

                                if (! $spk) {
                                    return null;
                                }

                                $sudahDiterima = $spk->uangMasuk()
                                    ->when($record?->id, fn ($q) => $q->whereKeyNot($record->id))
                                    ->sum('jumlah');

                                $sisa = $spk->piutangDari((float) $sudahDiterima);

                                return 'Piutang lancar SPK ini: Rp '.number_format($sisa, 0, ',', '.').
                                    ($spk->retensiDitahan() > 0
                                        ? ' (retensi ditahan Rp '.number_format($spk->retensiDitahan(), 0, ',', '.').' belum boleh ditagih)'
                                        : '');
                            }),

                        Select::make('mitra_id')
                            ->label('Mitra / Pengirim')
                            ->relationship('mitra', 'nama')
                            ->searchable()
                            ->preload()
                            ->placeholder('—'),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('mis. TF BKS, potongan material 120.000')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Bukti Penerimaan')
                    ->description('Jumlah file BEBAS — bisa 1, bisa banyak (bukti transfer + nota + screenshot).')
                    ->schema([
                        FileUpload::make('bukti')
                            ->label('File Bukti')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('uang_masuk')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->helperText('JPG, PNG, WEBP, atau PDF. Maks 10 MB per file.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
