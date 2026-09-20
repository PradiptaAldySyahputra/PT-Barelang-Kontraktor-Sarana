<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Schemas;

use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

/**
 * Form Uang Keluar.
 *
 * Dua bentuk, memakai definisi field yang SAMA:
 *   - `configure()`          → satu pengeluaran (halaman Ubah)
 *   - `configureSekaligus()` → beberapa sekaligus (halaman Tambah)
 *
 * Definisi field hanya ada di `fieldInti()`; bentuk mana pun tinggal
 * membungkusnya. Sebelumnya field yang sama ditulis dua kali dan sempat
 * berbeda diam-diam (rows(3) vs rows(2), required vs tidak).
 *
 * Tata letak tiap baris: pratinjau nota lebar penuh di ATAS, field di bawah.
 */
class UangKeluarForm
{
    /**
     * Batas nominal untuk menahan salah ketik.
     *
     * Tanpa ini, "upah tukang" bisa terisi Rp 250 miliar dan laporan
     * langsung tidak masuk akal.
     */
    private const BATAS_NOMINAL = 10_000_000_000;

    private const TIPE_FILE = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];

    private const MAKS_UKURAN_KB = 10240;

    /**
     * Field inti pengeluaran — dipakai ulang oleh kedua bentuk form.
     *
     * @return array<int, mixed>
     */
    private static function fieldInti(bool $wajib): array
    {
        return [
            DatePicker::make('tanggal')
                ->label($wajib ? 'Tanggal Keluar' : 'Tanggal')
                ->required($wajib)
                ->native(false)
                ->displayFormat('d/m/Y')
                ->default(now()),

            TextInput::make('jumlah')
                ->label('Jumlah (Rp)')
                ->required($wajib)
                ->numeric()
                ->minValue(0.01)
                ->maxValue(self::BATAS_NOMINAL)
                ->prefix('Rp')
                ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                ->stripCharacters('.')
                ->dehydrateStateUsing(fn ($state): ?float => filled($state) ? (float) $state : null)
                ->when($wajib, fn (TextInput $field): TextInput => $field
                    ->live(onBlur: true)
                    ->rules(self::aturanJumlah())
                    ->helperText(self::helperJumlah())),

            Select::make('kategori')
                ->label('Kategori')
                ->options(KategoriPengeluaran::opsi())
                ->required($wajib)
                ->native(false)
                ->helperText($wajib ? 'WAJIB dipilih dari daftar — agar laporan tidak terpecah.' : null),

            TextInput::make('penerima')
                ->label($wajib ? 'Penerima' : 'Penerima / Toko')
                ->maxLength(200)
                ->placeholder($wajib ? 'mis. Toko Bangunan Jaya / Mandor Arif' : 'mis. Toko Material Contoh'),

            Select::make('spk_id')
                ->label($wajib ? 'Kaitkan ke SPK (opsional)' : 'Terkait SPK')
                ->options(self::opsiSpk())
                ->searchable()
                ->preload()
                ->placeholder($wajib ? '— Tidak terkait SPK —' : '— umum / tidak terkait SPK —')
                ->when($wajib, fn (Select $field): Select => $field
                    ->live()
                    ->afterStateUpdated(function (?int $state, Set $set, Get $get): void {
                        // Isi penerima otomatis dari mitra SPK, kalau masih kosong.
                        $spk = $state ? Spk::find($state) : null;

                        if ($spk !== null && blank($get('penerima'))) {
                            $set('penerima', $spk->mitra?->nama);
                        }
                    })
                    ->helperText('Kosongkan untuk biaya operasional kantor.')),

            Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows($wajib ? 3 : 2)
                ->maxLength(500)
                ->placeholder($wajib ? 'mis. di potong 120.000 (uang material)' : null)
                ->columnSpanFull(),
        ];
    }

    /**
     * Pratinjau nota — dipakai di kedua bentuk form.
     */
    private static function pratinjauNota(): Placeholder
    {
        return Placeholder::make('pratinjau_nota')
            ->hiddenLabel()
            ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                'files' => $get('bukti'),
            ]))
            ->columnSpanFull();
    }

    /**
     * Aturan anti-salah-ketik: total biaya SPK tidak wajar.
     *
     * @return array<int, mixed>
     */
    private static function aturanJumlah(): array
    {
        return [
            function (string $attribute, $value, \Closure $fail, Get $get): void {
                $spk = self::spkTerkait($get);

                if ($spk === null) {
                    return;
                }

                $total = (float) $spk->uangKeluar()->sum('jumlah') + (float) $value;
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
            $spk = self::spkTerkait($get);

            if ($spk === null) {
                return null;
            }

            return 'Biaya SPK ini tercatat: Rp '.number_format((float) $spk->uangKeluar()->sum('jumlah'), 0, ',', '.')
                .' dari nilai SPK Rp '.number_format((float) $spk->nilai_spk, 0, ',', '.');
        };
    }

    /**
     * SPK yang dipilih pada form, atau null kalau tidak terkait.
     */
    private static function spkTerkait(Get $get): ?Spk
    {
        $spkId = $get('spk_id');

        return blank($spkId) ? null : Spk::find($spkId);
    }

    /**
     * Pilihan SPK untuk dropdown.
     *
     * Mengambil hanya 3 kolom yang dibutuhkan dalam SATU query. Jangan
     * memakai `pluck()` lalu `Spk::find()` per baris — itu jadi N+1.
     *
     * @return \Closure(): array<int, string>
     */
    private static function opsiSpk(): \Closure
    {
        return fn (): array => Spk::query()
            ->orderByDesc('tanggal_spk')
            ->get(['id', 'nomor_spk', 'nama_pekerjaan'])
            ->mapWithKeys(fn (Spk $spk): array => [
                $spk->id => $spk->nomor_spk.' — '.$spk->nama_pekerjaan,
            ])
            ->all();
    }

    /**
     * Ambil path file dari state FileUpload.
     *
     * PENTING: pakai `getStatePath()` karena Filament sudah menyimpan file
     * ke folder yang benar. Jangan panggil `store($disk)` — argumen pertama
     * `store()` adalah NAMA FOLDER, bukan disk; pernah menyebabkan file
     * tersimpan di `storage/app/public/public/` dan tidak bisa dibuka.
     */
    private static function pathFile(mixed $file): ?string
    {
        if (is_string($file)) {
            return $file;
        }

        if (! is_object($file)) {
            return null;
        }

        if (method_exists($file, 'getStatePath') && filled($path = $file->getStatePath())) {
            return $path;
        }

        if (method_exists($file, 'store')) {
            return $file->store('uang_keluar', config('filament.default_filesystem_disk', 'public'));
        }

        return null;
    }

    /**
     * Unggah beberapa nota → jumlah baris form mengikuti jumlah nota.
     */
    private static function unggahNota(): FileUpload
    {
        return FileUpload::make('nota_sekaligus')
            ->label('Unggah Nota')
            ->multiple()
            ->disk(config('filament.default_filesystem_disk', 'public'))
            ->directory('uang_keluar')
            ->acceptedFileTypes(self::TIPE_FILE)
            ->maxSize(self::MAKS_UKURAN_KB)
            ->maxFiles(30)
            ->dehydrated(false)
            ->live()
            ->panelLayout('grid')
            ->imagePreviewHeight('150')
            ->helperText('Pilih BANYAK nota sekaligus (Ctrl/Cmd + klik). Jumlah baris form di bawah otomatis menyesuaikan jumlah nota. Angka diisi manual sesuai nota.')
            ->afterStateUpdated(function ($state, Set $set, Get $get): void {
                // Data yang sudah diisi tidak hilang — hanya jumlah barisnya
                // disesuaikan, dan tiap baris diberi notanya sendiri.
                $files = collect(is_array($state) ? $state : [])
                    ->filter()
                    ->map(self::pathFile(...))
                    ->values();

                $lama = collect($get('pengeluaran') ?? [])->values();

                if ($files->isEmpty()) {
                    $set('pengeluaran', [array_merge($lama->get(0) ?? [], ['bukti' => []])]);

                    return;
                }

                $baris = [];

                foreach ($files as $i => $path) {
                    $sebelumnya = $lama->get($i) ?? [];

                    $baris[$i] = array_merge($sebelumnya, [
                        'bukti' => $path ? [$path] : [],
                        'tanggal' => $sebelumnya['tanggal'] ?? now()->toDateString(),
                    ]);
                }

                $set('pengeluaran', $baris);
            });
    }

    /**
     * Satu baris repeater: pratinjau (lebar penuh) di atas, field di bawah.
     *
     * @return array<int, mixed>
     */
    private static function fieldPengeluaran(): array
    {
        return [
            self::pratinjauNota(),

            Group::make(self::fieldInti(false))
                ->columns(2)
                ->columnSpanFull(),

            // Path nota diisi otomatis oleh unggahan, tapi komponennya harus
            // tetap ada agar nilainya ikut tersimpan.
            Hidden::make('bukti'),
        ];
    }

    /**
     * Bentuk 1 — satu pengeluaran (halaman Ubah).
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nota')
                    ->description('Pratinjau nota. Klik "Buka di tab baru" untuk melihat ukuran penuh.')
                    ->schema([self::pratinjauNota()]),

                Section::make('Detail Pengeluaran')
                    ->schema(self::fieldInti(true))
                    ->columns(2),

                Section::make('Bukti Pengeluaran')
                    ->description('Jumlah file bebas — nota, kuitansi, transfer, foto.')
                    ->schema([
                        FileUpload::make('bukti')
                            ->label('File Bukti')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->disk(config('filament.default_filesystem_disk', 'public'))
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(self::TIPE_FILE)
                            ->maxSize(self::MAKS_UKURAN_KB)
                            ->helperText('JPG, PNG, WEBP, atau PDF. Maks 10 MB per file.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    /**
     * Bentuk 2 — beberapa pengeluaran sekaligus (halaman Tambah).
     */
    public static function configureSekaligus(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('1. Unggah Nota')
                    ->description('Pilih banyak nota sekaligus. Jumlah baris form di bawah otomatis mengikuti jumlah nota.')
                    ->schema([self::unggahNota()]),

                Section::make('2. Isi Rincian')
                    ->description('Satu baris untuk tiap nota — nota tampil di atas, isi angkanya di bawah. Baris kosong tidak tersimpan.')
                    ->schema([
                        Repeater::make('pengeluaran')
                            ->hiddenLabel()
                            ->schema(self::fieldPengeluaran())
                            ->columns(1)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(30)
                            // Tidak ada tambah/hapus manual — baris mengikuti
                            // jumlah nota yang diunggah.
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
