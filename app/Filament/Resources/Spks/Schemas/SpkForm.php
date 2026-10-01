<?php

declare(strict_types=1);

namespace App\Filament\Resources\Spks\Schemas;

use App\Enums\DikerjakanOleh;
use App\Enums\KategoriMitra;
use App\Enums\StatusAntar;
use App\Enums\StatusSpk;
use App\Enums\StatusTagihan;
use App\Models\Mitra;
use App\Models\Spk;
use App\Services\PenyimpanBerkas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

/**
 * Form SPK.
 *
 * CATATAN PENTING (keputusan user 19 Sep 2026):
 *   - `pic`        TIDAK ADA
 *   - `keterangan` TIDAK ADA
 *   - `tanggal_akhir` ADA (revisi user)
 *
 * `status_spk` & `status_tagihan` WAJIB dropdown dari Enum — bukan input bebas.
 * Ini mencegah laporan terpecah (lihat Schema.md §7).
 */
class SpkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data SPK')
                    ->description('Nomor SPK wajib unik. Untuk pekerjaan tanpa surat resmi, isi nomor dengan "TANPA SPK" dan biarkan tanggal kosong.')
                    ->schema([
                        TextInput::make('nomor_spk')
                            ->label('Nomor SPK')
                            ->required()
                            ->maxLength(150)
                            ->unique(ignoreRecord: true)
                            ->placeholder('mis. 0123/SPK/DAN.01.03/2026'),

                        DatePicker::make('tanggal_spk')
                            ->label('Tanggal SPK')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Kosongkan jika TANPA SPK'),

                        DatePicker::make('tanggal_akhir')
                            ->label('Tanggal Akhir SPK')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->afterOrEqual('tanggal_spk')
                            ->helperText('Batas akhir pekerjaan'),
                    ])
                    ->columns(3),

                Section::make('Pekerjaan')
                    ->schema([
                        TextInput::make('nama_pekerjaan')
                            ->label('Nama Pekerjaan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('lokasi')
                            ->label('Lokasi')
                            ->maxLength(255),

                        Select::make('mitra_id')
                            ->label('Pemberi Kerja / Mitra')
                            ->relationship('mitra', 'nama')
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(2),

                // ---------------------------------------------------------
                // PENGANTARAN DOKUMEN
                // ---------------------------------------------------------
                //
                // ⚠️ PERMINTAAN PENGGUNA (26 Sep 2026): Excel "LIST SPK 2026"
                // punya kolom Keterangan (mis. "diantar ke imperium", "sudah
                // masuk rek BKS"). Admin perlu tahu mana dokumen yang BELUM
                // diantar — dulu tidak ada tempatnya sama sekali.
                Section::make('Pengantaran Dokumen')
                    ->description('Catat apakah dokumen SPK sudah diantar ke pihak terkait.')
                    ->schema([
                        Select::make('status_antar')
                            ->label('Status Pengantaran')
                            ->options(StatusAntar::opsi())
                            ->default(StatusAntar::Belum->value)
                            ->native(false)
                            ->helperText('Pilih "Belum Diantar" bila dokumen masih di kantor.'),

                        DatePicker::make('tanggal_antar')
                            ->label('Tanggal Diantar')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->maxDate(now())
                            ->helperText('Isi bila sudah diantar.'),

                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->maxLength(255)
                            ->placeholder('mis. diantar ke imperium / sudah masuk rek BKS')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // ---------------------------------------------------------
                // DOKUMEN SPK (BAST, scan SPK, kuitansi)
                // ---------------------------------------------------------
                //
                // ⚠️ PRD FR-SPK-007 + PRD §9 no.2: dokumen SPK tidak punya
                // tempat karena tabel lampiran dihapus. Sekarang disimpan di
                // kolom JSON `dokumen` — banyak berkas per SPK.
                Section::make('Dokumen SPK')
                    ->description('Unggah scan SPK, BAST, atau kuitansi. Boleh lebih dari satu berkas.')
                    ->schema([
                        FileUpload::make('dokumen')
                            ->label('Berkas')
                            ->multiple()
                            ->reorderable()
                            ->disk('nota')
                            ->directory('spk')
                            ->visibility('private')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(PenyimpanBerkas::maksUkuranKb())
                            ->maxFiles(10)
                            ->fetchFileInformation(false)
                            ->helperText('PDF, JPG, PNG, atau WEBP. Maks '.round(PenyimpanBerkas::maksUkuranKb() / 1024).' MB per berkas.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Nilai SPK')
                    ->schema([
                        TextInput::make('nilai_spk')
                            ->label('Nilai SPK (Rp)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                            ->stripCharacters('.')
                            ->dehydrateStateUsing(fn ($state): float => (float) $state),
                    ])
                    ->columns(1),

                // ---------------------------------------------------------
                // STATUS — HANYA TAMPIL, tidak bisa diubah dari sini
                //
                // ⚠️ KEPUTUSAN USER: status diubah lewat menu monitoring
                // (Status SPK / Tagihan SPK) dengan form terpisah, supaya
                // tidak ada risiko salah ubah data lain saat ganti status.
                // ---------------------------------------------------------
                // ---------------------------------------------------------
                // STATUS
                //
                // ⚠️ KEPUTUSAN USER: saat UBAH, status hanya DITAMPILKAN —
                // perubahannya lewat form terpisah (Ubah Status Pekerjaan /
                // Ubah Status Tagihan). Saat TAMBAH (SPK baru), status diisi
                // otomatis: Draft + Belum Ditagihkan.
                // ---------------------------------------------------------
                Section::make('Status (hanya tampil)')
                    ->description('Status diubah lewat menu Status SPK & Tagihan SPK — bukan dari sini.')
                    ->hiddenOn('create')
                    ->schema([
                        Placeholder::make('status_spk_tampil')
                            ->label('Status Pekerjaan')
                            ->content(fn (?Spk $record): string => $record?->status_spk?->label() ?? 'Draft'),

                        Placeholder::make('status_tagihan_tampil')
                            ->label('Status Tagihan')
                            ->content(fn (?Spk $record): string => $record?->status_tagihan?->label() ?? 'Belum Ditagihkan'),
                    ])
                    ->columns(2),

                // Saat TAMBAH: status diisi otomatis (tidak perlu dipilih).
                Section::make('Status Awal')
                    ->description('SPK baru otomatis berstatus Draft & Belum Ditagihkan. Ubah lewat menu Status SPK / Tagihan SPK.')
                    ->visibleOn('create')
                    ->schema([
                        Hidden::make('status_spk')
                            ->default(StatusSpk::Draft->value),

                        Hidden::make('status_tagihan')
                            ->default(StatusTagihan::BelumDitagihkan->value),
                    ]),

                Section::make('Klasifikasi')
                    ->schema([
                        Select::make('jenis_sumber')
                            ->label('Jenis Sumber')
                            ->options([
                                'pln' => 'PLN',
                                'luar' => 'Luar',
                                'internal' => 'Internal',
                                'lainnya' => 'Lainnya',
                            ])
                            ->native(false),

                        TextInput::make('sheet_lama')
                            ->label('Sheet Lama (referensi Excel)')
                            ->maxLength(100)
                            ->helperText('Opsional — untuk keperluan migrasi data lama'),
                    ])
                    ->columns(2),

                // ---------------------------------------------------------
                // PELAKSANA PEKERJAAN (permintaan user)
                //
                // Kasus: bangun 5 gardu — 3 dikerjakan sendiri, 2 disubkonkan.
                // Karena schema dibatasi 5 tabel, pekerjaan yang sebagian
                // disubkonkan dibuat sebagai SPK TERPISAH.
                // ---------------------------------------------------------
                Section::make('Pelaksana Pekerjaan')
                    ->description('Tandai apakah SPK ini dikerjakan tim sendiri atau diserahkan ke subkon (kita bayar mereka).')
                    ->schema([
                        Radio::make('dikerjakan_oleh')
                            ->label('Dikerjakan Oleh')
                            ->options(DikerjakanOleh::opsi())
                            ->default(DikerjakanOleh::Sendiri->value)
                            ->required()
                            ->live()
                            ->inline()
                            ->columnSpanFull(),

                        Select::make('subkon_id')
                            ->label('Mitra Subkon')
                            ->options(
                                fn (): array => Mitra::query()
                                    ->where('kategori', KategoriMitra::Subkon->value)
                                    ->orderBy('nama')
                                    ->pluck('nama', 'id')
                                    ->all()
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->required(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->helperText('Belum ada subkon? Tambahkan dulu di menu Data Mitra dengan kategori "Subkon".')
                            ->columnSpanFull(),

                        Placeholder::make('catatan_subkon')
                            ->label('')
                            ->content('Kalau pekerjaan hanya SEBAGIAN disubkonkan (mis. 5 gardu: 3 sendiri, 2 subkon), buat SPK terpisah untuk bagian yang disubkonkan.')
                            ->visible(fn (Get $get): bool => $get('dikerjakan_oleh') === DikerjakanOleh::Subkon->value)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
