<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\KategoriPengeluaran;
use App\Models\Spk;
use App\Models\UangKeluar;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

/**
 * INPUT UANG KELUAR — 4 SEKALIGUS (permintaan user).
 *
 * ⚠️ CARA PAKAI (jawaban atas pertanyaan user):
 * File nota (PDF/gambar) TIDAK dibaca otomatis — aplikasi tidak melakukan OCR.
 * Jadi alurnya:
 *   1. Scan 4 nota menjadi 4 file PDF.
 *   2. Buka halaman ini → ada 4 baris form.
 *   3. Di tiap baris: unggah nota PDF-nya, lalu isi angka yang terbaca dari
 *      nota tersebut (tanggal, jumlah, kategori, penerima).
 *   4. Simpan sekali → 4 transaksi tersimpan, tiap nota menempel pada
 *      transaksinya sendiri.
 *
 * Jadi "presisi" terjaga karena tiap nota terpasang pada barisnya sendiri —
 * tidak mungkin tertukar.
 *
 * Kalau nota kurang dari 4, biarkan baris sisanya kosong (tidak akan
 * tersimpan). Bisa juga tambah baris dengan tombol "+".
 *
 * Halaman ini adalah ALTERNATIF cepat; form uang keluar satu-per-satu tetap
 * tersedia di menu Transaksi → Uang Keluar.
 */
class InputUangKeluarMassal extends Page
{
    protected string $view = 'filament.pages.input-uang-keluar-massal';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowUp;

    protected static string|\UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?string $navigationLabel = 'Input Uang Keluar (4 sekaligus)';

    protected static ?string $title = 'Input Uang Keluar — 4 Sekaligus';

    protected static ?int $navigationSort = 4;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        // Siapkan 4 baris kosong sejak awal (permintaan user: 4 form).
        $this->form->fill([
            'pengeluaran' => array_fill(0, 4, [
                'tanggal' => now()->toDateString(),
            ]),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Keterangan')
                    ->schema([
                        Placeholder::make('panduan')
                            ->label('')
                            ->content(new HtmlString(
                                '<div class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">'
                                .'<strong>Cara pakai:</strong> scan 4 nota menjadi 4 file, lalu di tiap baris '
                                .'unggah nota dan isi angkanya sesuai nota tersebut. Simpan sekali → '
                                .'4 transaksi tersimpan, tiap nota menempel pada transaksinya sendiri.'
                                .'<br><span class="text-xs">Nota tidak dibaca otomatis — angka diisi manual '
                                .'sesuai nota, supaya tetap presisi. Baris yang dikosongkan tidak akan tersimpan.</span>'
                                .'</div>'
                            )),
                    ]),

                Repeater::make('pengeluaran')
                    ->label('Daftar Pengeluaran')
                    ->schema([
                        // -------------------------------------------------
                        // Field TIDAK `required` di level repeater.
                        //
                        // Alasannya: user selalu melihat 4 baris, dan boleh
                        // mengosongkan baris yang tidak dipakai. Kalau
                        // `required` dipasang di sini, baris kosong akan
                        // memblokir penyimpanan.
                        //
                        // Validasi "baris terisi harus lengkap" dilakukan di
                        // method simpan().
                        // -------------------------------------------------
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

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
                            ->placeholder('— umum / tidak terkait SPK —'),

                        FileUpload::make('bukti')
                            ->label('Nota (PDF / gambar)')
                            ->multiple()
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(10240)
                            ->helperText('Boleh 1 atau beberapa file per baris.'),

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
                    ->cloneable()
                    ->itemLabel(fn (array $state): ?string => filled($state['jumlah'] ?? null)
                        ? 'Rp '.number_format((float) $state['jumlah'], 0, ',', '.')
                        : null)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    /**
     * Simpan semua baris yang terisi.
     *
     * Baris yang dikosongkan (tidak dipakai) diabaikan.
     * Baris yang terisi sebagian → ditolak dengan pesan jelas, supaya tidak
     * ada data setengah jadi yang tersimpan.
     */
    public function simpan(): void
    {
        $data = $this->form->getState();

        $semua = collect($data['pengeluaran'] ?? []);

        // Baris dianggap TERISI kalau minimal ada jumlah atau kategori.
        $terisi = $semua->filter(fn (array $r): bool => filled($r['jumlah'] ?? null) || filled($r['kategori'] ?? null));

        if ($terisi->isEmpty()) {
            Notification::make()
                ->title('Tidak ada yang disimpan')
                ->body('Isi minimal satu baris (tanggal, jumlah, kategori).')
                ->warning()
                ->send();

            return;
        }

        // Validasi: baris terisi harus lengkap.
        $tidakLengkap = [];

        foreach ($terisi as $i => $r) {
            $kurang = [];

            if (blank($r['tanggal'] ?? null)) {
                $kurang[] = 'tanggal';
            }

            if (blank($r['jumlah'] ?? null)) {
                $kurang[] = 'jumlah';
            }

            if (blank($r['kategori'] ?? null)) {
                $kurang[] = 'kategori';
            }

            if ($kurang !== []) {
                $tidakLengkap[] = 'Baris '.($i + 1).' belum lengkap: '.implode(', ', $kurang);
            }
        }

        if ($tidakLengkap !== []) {
            Notification::make()
                ->title('Ada baris yang belum lengkap')
                ->body(implode(' · ', $tidakLengkap))
                ->danger()
                ->persistent()
                ->send();

            return;
        }

        DB::transaction(function () use ($terisi): void {
            foreach ($terisi as $r) {
                UangKeluar::create([
                    'tanggal' => $r['tanggal'],
                    'jumlah' => $r['jumlah'],
                    'kategori' => $r['kategori'],
                    'penerima' => $r['penerima'] ?? null,
                    'spk_id' => $r['spk_id'] ?? null,
                    'keterangan' => $r['keterangan'] ?? null,
                    'bukti' => $r['bukti'] ?? null,
                ]);
            }
        });

        $jumlah = $terisi->count();
        $total = $terisi->sum(fn (array $r): float => (float) $r['jumlah']);

        Notification::make()
            ->title($jumlah.' pengeluaran tersimpan')
            ->body('Total Rp '.number_format($total, 0, ',', '.'))
            ->success()
            ->send();

        // Reset ke 4 baris kosong
        $this->form->fill([
            'pengeluaran' => array_fill(0, 4, ['tanggal' => now()->toDateString()]),
        ]);
    }

    /**
     * @return array<Action>
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('simpan')
                ->label('Simpan Semua')
                ->icon('heroicon-m-check')
                ->submit('simpan'),
        ];
    }
}
