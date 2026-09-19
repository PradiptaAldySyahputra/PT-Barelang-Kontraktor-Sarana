<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Schemas;

use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
 * DUA BENTUK (revisi user):
 *   1. `configure()`       → SATU pengeluaran. Dipakai halaman UBAH.
 *   2. `configureSekaligus()` → 4 baris sekaligus. Dipakai halaman TAMBAH,
 *      supaya admin bisa memasukkan 4 nota dalam sekali input.
 *
 * `spk_id` OPSIONAL (nullable): pengeluaran boleh dikaitkan ke SPK tertentu
 * (untuk perhitungan laba-rugi per SPK) atau dibiarkan kosong untuk biaya
 * operasional kantor.
 *
 * TIDAK ADA approval Direktur (keputusan user 19 Sep 2026).
 */
class UangKeluarForm
{
    /**
     * Aturan anti-salah-ketik nominal.
     *
     * Tanpa ini, "upah tukang" bisa terisi Rp 250 miliar (pernah terjadi saat
     * uji) dan laporan laba-rugi langsung rusak.
     *
     * Batas: Rp 10 miliar — jauh di atas transaksi nyata perusahaan, tetapi
     * menahan salah ketik.
     *
     * @return array<int, mixed>
     */
    private static function aturanJumlah(): array
    {
        return [
            fn (Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get): void {
                $spkId = $get('spk_id');

                if (blank($spkId)) {
                    return;
                }

                $spk = Spk::find($spkId);

                if (! $spk) {
                    return;
                }

                // Peringatkan jika biaya total SPK sudah melebihi nilai SPK —
                // biasanya salah input.
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
        ];
    }

    private static function helperJumlah(): \Closure
    {
        return function (Get $get): ?string {
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
        };
    }

    /**
     * @return array<string, mixed>
     */
    private static function opsiSpk(): \Closure
    {
        return fn (): array => Spk::query()
            ->orderByDesc('tanggal_spk')
            ->get()
            ->mapWithKeys(fn (Spk $spk): array => [
                $spk->id => $spk->nomor_spk.' — '.$spk->nama_pekerjaan,
            ])
            ->all();
    }

    // =========================================================
    // BENTUK 1 — SATU pengeluaran (halaman UBAH)
    // =========================================================

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
                            ->maxValue(10_000_000_000)
                            ->rules(self::aturanJumlah())
                            ->helperText(self::helperJumlah()),

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
                            ->options(self::opsiSpk())
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

    // =========================================================
    // BENTUK 2 — 4 SEKALIGUS (halaman TAMBAH)
    // =========================================================

    public static function configureSekaligus(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unggah Nota Sekaligus (opsional)')
                    ->description('Pilih sampai 4 file nota dalam SATU kali pilih. File ke-1 otomatis masuk Baris 1, ke-2 → Baris 2, dan seterusnya. Angka tetap diisi manual sesuai masing-masing nota.')
                    ->schema([
                        FileUpload::make('nota_sekaligus')
                            ->label('Pilih Beberapa Nota Sekaligus')
                            ->multiple()
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->maxFiles(4)
                            ->dehydrated(false)
                            ->live()
                            ->helperText('Tekan Ctrl/Cmd saat memilih untuk memilih beberapa file. Boleh dikosongkan — Anda bisa mengunggah per baris di bawah.')
                            ->afterStateUpdated(function ($state, Set $set): void {
                                // Sebarkan file ke baris 1..4 sesuai urutan.
                                $files = is_array($state) ? array_values($state) : [];

                                if ($files === []) {
                                    return;
                                }

                                $baris = [];

                                foreach (range(0, 3) as $i) {
                                    $baris[$i] = [
                                        'bukti' => isset($files[$i]) ? [$files[$i]] : [],
                                    ];
                                }

                                $set('pengeluaran', $baris);
                            })
                            ->columnSpanFull(),
                    ]),

                Section::make('Detail Pengeluaran')
                    ->description('Ada 4 baris siap isi. Kosongkan baris yang tidak dipakai — baris kosong tidak akan tersimpan.')
                    ->schema([
                        Repeater::make('pengeluaran')
                            ->hiddenLabel()
                            ->schema([
                                DatePicker::make('tanggal')
                                    ->label('Tanggal')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->default(now()),

                                TextInput::make('jumlah')
                                    ->label('Jumlah (Rp)')
                                    ->numeric()
                                    ->minValue(0.01)
                                    ->maxValue(10_000_000_000)
                                    ->prefix('Rp')
                                    ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                                    ->stripCharacters('.')
                                    ->dehydrateStateUsing(fn ($state): ?float => filled($state) ? (float) $state : null),

                                Select::make('kategori')
                                    ->label('Kategori')
                                    ->options(KategoriPengeluaran::opsi())
                                    ->native(false),

                                TextInput::make('penerima')
                                    ->label('Penerima / Toko')
                                    ->maxLength(200)
                                    ->placeholder('mis. Toko Material Contoh'),

                                Select::make('spk_id')
                                    ->label('Terkait SPK')
                                    ->options(self::opsiSpk())
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('— umum / tidak terkait SPK —'),

                                FileUpload::make('bukti')
                                    ->label('Nota (PDF / gambar)')
                                    ->multiple()
                                    ->directory('uang_keluar')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                                    ->maxSize(10240)
                                    ->helperText('Nota untuk baris ini.'),

                                Textarea::make('keterangan')
                                    ->label('Keterangan')
                                    ->rows(2)
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(10)
                            ->addActionLabel('+ Tambah baris')
                            ->reorderable(false)
                            ->itemLabel(fn (array $state): ?string => filled($state['jumlah'] ?? null)
                                ? 'Rp '.number_format((float) $state['jumlah'], 0, ',', '.')
                                : null)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
