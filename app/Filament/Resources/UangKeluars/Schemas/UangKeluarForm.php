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
 * Form Uang Keluar — pengeluaran.
 *
 * DUA BENTUK:
 *   1. `configure()`        → SATU pengeluaran + pratinjau nota sejajar.
 *                             Dipakai halaman UBAH.
 *   2. `configureSekaligus()` → BEBERAPA pengeluaran sekaligus.
 *                             Dipakai halaman TAMBAH.
 *
 * ⚠️ CARA KERJA "SEKALIGUS" (revisi user):
 *   1. Admin mengunggah nota (boleh banyak sekaligus, tanpa batas 4).
 *   2. Sistem MENGHITUNG jumlah nota yang diunggah.
 *   3. Sistem otomatis membuat SEJUMLAH ITU baris form.
 *   4. Tiap baris menampilkan PRATINJAU notanya SEJAJAR dengan field.
 *
 *   Jadi admin tidak menambah baris manual — baris muncul sendiri
 *   mengikuti jumlah nota.
 *
 *   Catatan: isi nota TIDAK dibaca otomatis (tidak ada OCR). Angka
 *   diisi manual sesuai nota yang tampil di sebelahnya.
 *
 * TIDAK ADA approval Direktur (keputusan user 19 Sep 2026).
 */
class UangKeluarForm
{
    /**
     * Batas nominal untuk menahan salah ketik.
     *
     * Tanpa ini, "upah tukang" bisa terisi Rp 250 miliar (pernah terjadi saat
     * uji) dan laporan laba-rugi langsung rusak.
     */
    private const BATAS_NOMINAL = 10_000_000_000;

    /**
     * Aturan anti-salah-ketik nominal.
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
     * @return \Closure(): array<int|string, string>
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

    /**
     * Field unggah nota + logika yang membuat baris form mengikuti jumlah nota.
     */
    private static function unggahNota(): FileUpload
    {
        return FileUpload::make('nota_sekaligus')
            ->label('Unggah Nota')
            ->multiple()
            ->disk(config('filament.default_filesystem_disk', 'public'))
            ->directory('uang_keluar')
            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
            ->maxSize(10240)
            ->maxFiles(30)
            ->dehydrated(false)
            ->live()
            ->helperText('Boleh pilih BANYAK nota sekaligus (Ctrl/Cmd + klik). Jumlah baris form di bawah akan otomatis menyesuaikan jumlah nota. Angka diisi manual sesuai nota.')
            ->afterStateUpdated(function ($state, Set $set, Get $get): void {
                // ---------------------------------------------------------
                // INTI FITUR: jumlah baris = jumlah nota yang diunggah.
                //
                // Data yang SUDAH diisi tidak hilang — hanya disesuaikan
                // jumlahnya, dan tiap baris diberi notanya sendiri.
                // ---------------------------------------------------------
                $files = collect(is_array($state) ? $state : [])
                    ->filter()
                    ->map(fn ($f): ?string => self::pathFile($f))
                    ->values();

                $lama = collect($get('pengeluaran') ?? [])->values();

                if ($files->isEmpty()) {
                    // Belum ada nota → sediakan 1 baris kosong supaya form
                    // tetap bisa dipakai tanpa nota.
                    $set('pengeluaran', [
                        array_merge($lama->get(0) ?? [], ['bukti' => []]),
                    ]);

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
     * Ambil path dari state FileUpload (bisa string atau objek file).
     */
    private static function pathFile(mixed $f): ?string
    {
        if (is_string($f)) {
            return $f;
        }

        if (is_object($f)) {
            if (method_exists($f, 'getStatePath')) {
                return $f->getStatePath();
            }

            if (method_exists($f, 'store')) {
                return $f->store(config('filament.default_filesystem_disk', 'public'));
            }
        }

        return null;
    }

    /**
     * Satu baris form pengeluaran (dipakai di repeater & form tunggal).
     *
     * @param  bool  $denganPratinjau  tampilkan pratinjau nota di sebelah kiri
     * @return array<int, mixed>
     */
    private static function fieldPengeluaran(bool $denganPratinjau = true): array
    {
        $field = [];

        if ($denganPratinjau) {
            // ---------------------------------------------------------
            // PRATINJAU NOTA — SEJAJAR dengan field (permintaan user).
            //
            // Karena kolom `bukti` sudah terisi path nota oleh unggahan,
            // pratinjau bisa langsung dirender dari state baris ini.
            // ---------------------------------------------------------
            $field[] = Placeholder::make('pratinjau_nota')
                ->hiddenLabel()
                ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                    'files' => $get('bukti'),
                ]))
                ->columnSpan(1);
        }

        $field[] = Group::make([
            DatePicker::make('tanggal')
                ->label('Tanggal')
                ->native(false)
                ->displayFormat('d/m/Y')
                ->default(now()),

            TextInput::make('jumlah')
                ->label('Jumlah (Rp)')
                ->numeric()
                ->minValue(0.01)
                ->maxValue(self::BATAS_NOMINAL)
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

            Textarea::make('keterangan')
                ->label('Keterangan')
                ->rows(2)
                ->maxLength(500)
                ->columnSpanFull(),
        ])
            ->columns(2)
            ->columnSpan($denganPratinjau ? 3 : 2);

        // ---------------------------------------------------------
        // Simpan path nota sebagai state tersembunyi.
        //
        // Path nota diisi otomatis oleh unggahan (bukan diketik), jadi
        // field-nya tidak perlu tampil — tetapi HARUS tetap ada sebagai
        // komponen agar nilainya ikut tersimpan saat form disimpan.
        // ---------------------------------------------------------
        $field[] = Hidden::make('bukti');

        return $field;
    }

    // =========================================================
    // BENTUK 1 — SATU pengeluaran (halaman UBAH)
    // =========================================================

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Pengeluaran')
                    ->description('Pratinjau nota tampil di sebelah kiri form.')
                    ->schema([
                        // Pratinjau nota lama (sudah tersimpan) — sejajar.
                        Placeholder::make('pratinjau_nota')
                            ->hiddenLabel()
                            ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                                'files' => $get('bukti'),
                            ]))
                            ->columnSpan(1),

                        Group::make([
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
                                ->maxValue(self::BATAS_NOMINAL)
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

                            Select::make('spk_id')
                                ->label('Kaitkan ke SPK (opsional)')
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
                                ->helperText('Kosongkan untuk biaya operasional kantor.'),

                            Textarea::make('keterangan')
                                ->label('Keterangan')
                                ->rows(2)
                                ->maxLength(500)
                                ->placeholder('mis. di potong 120.000 (uang material)')
                                ->columnSpanFull(),
                        ])
                            ->columns(2)
                            ->columnSpan(3),
                    ])
                    ->columns(4),

                Section::make('Bukti Pengeluaran')
                    ->description('Jumlah file BEBAS — nota, kuitansi, transfer, foto. Bisa lebih dari satu.')
                    ->schema([
                        FileUpload::make('bukti')
                            ->label('File Bukti')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->disk(config('filament.default_filesystem_disk', 'public'))
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'application/pdf'])
                            ->maxSize(10240)
                            ->helperText('JPG, PNG, WEBP, atau PDF. Maks 10 MB per file.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    // =========================================================
    // BENTUK 2 — BEBERAPA pengeluaran sekaligus (halaman TAMBAH)
    // =========================================================

    public static function configureSekaligus(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('1. Unggah Nota')
                    ->description('Pilih BANYAK nota sekaligus. Jumlah baris form di bawah otomatis mengikuti jumlah nota yang diunggah.')
                    ->schema([
                        self::unggahNota(),
                    ]),

                Section::make('2. Isi Rincian')
                    ->description('Satu baris untuk tiap nota. Nota tampil di sebelah kiri, isi angkanya di kanan sesuai nota tersebut. Baris kosong tidak akan tersimpan.')
                    ->schema([
                        Repeater::make('pengeluaran')
                            ->hiddenLabel()
                            ->schema(self::fieldPengeluaran(denganPratinjau: true))
                            ->columns(4)
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(30)
                            // Tidak ada tambah/hapus manual — baris mengikuti
                            // jumlah nota yang diunggah (permintaan user).
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
