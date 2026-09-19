<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Schemas;

use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

/**
 * Form Uang Keluar — pengeluaran.
 *
 * `spk_id` OPSIONAL (nullable): pengeluaran boleh dikaitkan ke SPK tertentu
 * (untuk perhitungan laba-rugi per SPK) atau dibiarkan kosong untuk biaya
 * operasional kantor.
 *
 * TIDAK ADA approval Direktur (keputusan user 19 Sep 2026).
 */
class UangKeluarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengeluaran')
                    ->schema([
                        DatePicker::make('tanggal')
                            ->label('Tanggal Keluar')
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
                            // CEGAH NOMINAL TIDAK WAJAR.
                            //
                            // Tanpa ini, "upah tukang" bisa terisi Rp 250 miliar
                            // (pernah terjadi saat uji) dan laporan laba-rugi
                            // langsung rusak.
                            //
                            // Batas: Rp 10 miliar — jauh di atas transaksi nyata
                            // perusahaan, tetapi menahan salah ketik.
                            // -------------------------------------------------
                            ->maxValue(10_000_000_000)
                            ->rules([
                                fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get): void {
                                    $spkId = $get('spk_id');

                                    if (blank($spkId)) {
                                        return;
                                    }

                                    $spk = Spk::find($spkId);

                                    if (! $spk) {
                                        return;
                                    }

                                    // Peringatkan (bukan tolak) jika biaya total SPK
                                    // sudah melebihi nilai SPK — biasanya salah input.
                                    $biayaLain = (float) $spk->uangKeluar()->sum('jumlah');
                                    $total = $biayaLain + (float) $value;
                                    $nilai = (float) $spk->nilai_spk;

                                    if ($nilai > 0 && $total > $nilai * 1.5) {
                                        $fail(sprintf(
                                            'Total biaya SPK ini akan menjadi Rp %s, jauh melebihi nilai SPK Rp %s. Periksa kembali nominalnya.',
                                            number_format($total, 0, ',', '.'),
                                            number_format($nilai, 0, ',', '.'),
                                        ));
                                    }
                                },
                            ])
                            ->helperText(function (Get $get): ?string {
                                $spkId = $get('spk_id');

                                if (blank($spkId)) {
                                    return null;
                                }

                                $spk = Spk::find($spkId);

                                if (! $spk) {
                                    return null;
                                }

                                $biaya = (float) $spk->uangKeluar()->sum('jumlah');

                                return 'Biaya SPK ini tercatat: Rp '.number_format($biaya, 0, ',', '.').
                                    ' dari nilai SPK Rp '.number_format((float) $spk->nilai_spk, 0, ',', '.');
                            }),

                        Select::make('kategori')
                            ->label('Kategori')
                            ->options(KategoriPengeluaran::opsi())
                            ->required()
                            ->native(false)
                            ->helperText('WAJIB dipilih dari daftar — agar laporan tidak terpecah.'),

                        TextInput::make('penerima')
                            ->label('Penerima')
                            ->maxLength(200)
                            ->placeholder('mis. Toko Bangunan Jaya / Mandor Arif'),
                    ])
                    ->columns(2),

                Section::make('Kaitkan ke SPK (opsional)')
                    ->description('Isi jika pengeluaran ini bagian dari SPK tertentu. Kosongkan untuk biaya umum/operasional. Pengeluaran yang terkait SPK akan ikut mengurangi laba SPK tersebut.')
                    ->schema([
                        Select::make('spk_id')
                            ->label('SPK')
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
                            ->placeholder('— Tidak terkait SPK —')
                            ->live()
                            ->afterStateUpdated(function (?int $state, Set $set, Get $get): void {
                                $spk = $state ? Spk::find($state) : null;

                                if ($spk !== null && blank($get('penerima'))) {
                                    $set('penerima', $spk->mitra?->nama);
                                }
                            })
                            ->helperText('Kosongkan untuk biaya operasional kantor.')
                            ->columnSpanFull(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder('mis. di potong 120.000 (uang material)')
                            ->columnSpanFull(),
                    ]),

                Section::make('Bukti Pengeluaran')
                    ->description('Jumlah file BEBAS — nota, kuitansi, transfer, foto. Bisa lebih dari satu.')
                    ->schema([
                        FileUpload::make('bukti')
                            ->label('File Bukti')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->helperText('JPG, PNG, WEBP, atau PDF. Maks 10 MB per file.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
