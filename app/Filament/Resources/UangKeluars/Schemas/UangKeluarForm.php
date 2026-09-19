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
 *   1. `configure()`         → SATU pengeluaran + pratinjau nota.
 *                              Dipakai halaman UBAH.
 *   2. `configureSekaligus()` → BEBERAPA pengeluaran sekaligus.
 *                              Dipakai halaman TAMBAH.
 *
 * ⚠️ TATA LETAK (revisi user):
 *   "gunakan space semuanya, form upload diatas dan form input dibawah...
 *    form pertama akan luas, ketika di scroll kebawah form akan jelas dan
 *    gambar/pdf nota pasti jelas dan harus presisi, jangan separuh"
 *
 *   Maka tiap baris disusun VERTIKAL dan LEBAR PENUH:
 *
 *     ┌────────────────────────────────────────────┐
 *     │  PRATINJAU NOTA  (lebar penuh, tinggi besar)│
 *     ├────────────────────────────────────────────┤
 *     │  Tanggal        │ Jumlah                    │
 *     │  Kategori       │ Penerima                  │
 *     │  Terkait SPK    │ Keterangan                │
 *     └────────────────────────────────────────────┘
 *
 *   Tidak ada kolom yang dihemat — pratinjau dapat lebar penuh supaya
 *   PDF/gambar nota jelas terbaca (bukan separuh).
 *
 * ⚠️ CARA KERJA "SEKALIGUS":
 *   Unggah N nota → otomatis N baris. Tidak ada tombol tambah/hapus baris.
 *
 *   Catatan: isi nota TIDAK dibaca otomatis (tidak ada OCR). Angka diisi
 *   manual sesuai nota yang tampil di atasnya.
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
     * Ambil path dari state FileUpload.
     *
     * ⚠️ BUG YANG PERNAH TERJADI (penting, jangan diulang):
     * Versi sebelumnya memanggil `$f->store($disk)` dengan `$disk` = 'public'.
     * Padahal parameter pertama `store()` adalah **NAMA FOLDER**, bukan nama
     * disk. Akibatnya file tersimpan di folder bersarang:
     *
     *     storage/app/public/public/xxxx.pdf   ← SALAH
     *     storage/app/public/uang_keluar/...   ← seharusnya
     *
     * Sekarang: pakai `getStatePath()` (Filament sudah menyimpan file ke
     * folder yang benar). Fallback pun memakai signature yang benar:
     * `store('uang_keluar', $disk)`.
     */
    private static function pathFile(mixed $f): ?string
    {
        if (is_string($f)) {
            return $f;
        }

        if (! is_object($f)) {
            return null;
        }

        // TemporaryUploadedFile / FileUploadedFile — Filament sudah tahu
        // lokasinya. Ini jalur normal.
        if (method_exists($f, 'getStatePath')) {
            $path = $f->getStatePath();

            if (filled($path)) {
                return $path;
            }
        }

        // Fallback: simpan sendiri ke folder yang BENAR.
        // Perhatikan urutan argumen: (folder, disk) — bukan (disk).
        if (method_exists($f, 'store')) {
            return $f->store('uang_keluar', config('filament.default_filesystem_disk', 'public'));
        }

        return null;
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
            ->panelLayout('grid')
            ->imagePreviewHeight('150')
            ->helperText('Pilih BANYAK nota sekaligus (Ctrl/Cmd + klik). Jumlah baris form di bawah otomatis menyesuaikan jumlah nota. Angka diisi manual sesuai nota.')
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
     * Satu baris form pengeluaran.
     *
     * Susunan VERTIKAL & LEBAR PENUH:
     *   [pratinjau nota — lebar penuh]
     *   [field form — lebar penuh, 2 kolom]
     *
     * @return array<int, mixed>
     */
    private static function fieldPengeluaran(): array
    {
        return [
            // ---------------------------------------------------------
            // PRATINJAU NOTA — LEBAR PENUH, di ATAS field (permintaan user).
            // ---------------------------------------------------------
            Placeholder::make('pratinjau_nota')
                ->hiddenLabel()
                ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                    'files' => $get('bukti'),
                ]))
                ->columnSpanFull(),

            // ---------------------------------------------------------
            // FIELD FORM — LEBAR PENUH, di BAWAH pratinjau.
            // ---------------------------------------------------------
            Group::make([
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
                    ->maxLength(500),
            ])
                ->columns(2)
                ->columnSpanFull(),

            // Path nota diisi otomatis oleh unggahan (bukan diketik), jadi
            // tidak perlu tampil — tetapi HARUS ada sebagai komponen agar
            // nilainya ikut tersimpan.
            Hidden::make('bukti'),
        ];
    }

    // =========================================================
    // BENTUK 1 — SATU pengeluaran (halaman UBAH)
    // =========================================================

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Nota')
                    ->description('Pratinjau nota. Klik "Buka di tab baru" untuk melihat ukuran penuh.')
                    ->schema([
                        Placeholder::make('pratinjau_nota')
                            ->hiddenLabel()
                            ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                                'files' => $get('bukti'),
                            ]))
                            ->columnSpanFull(),
                    ]),

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
                            ->rows(3)
                            ->maxLength(500)
                            ->placeholder('mis. di potong 120.000 (uang material)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

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
                    ->description('Satu baris untuk tiap nota — nota tampil di atas, isi angkanya di bawah sesuai nota tersebut. Baris kosong tidak akan tersimpan.')
                    ->schema([
                        Repeater::make('pengeluaran')
                            ->hiddenLabel()
                            ->schema(self::fieldPengeluaran())
                            // 1 kolom: pratinjau & field sama-sama lebar penuh
                            ->columns(1)
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
