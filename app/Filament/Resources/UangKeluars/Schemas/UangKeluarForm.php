<?php

declare(strict_types=1);

namespace App\Filament\Resources\UangKeluars\Schemas;

use App\Enums\AkunKas;
use App\Enums\KategoriPengeluaran;
use App\Filament\Concerns\PratinjauNotaPrivat;
use App\Models\Spk;
use App\Services\PembacaNota;
use App\Services\PenyimpanBerkas;
use App\Support\Format;
use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Throwable;

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
 *
 * JUMLAH NOTA — DITENTUKAN ADMIN, BUKAN DITEBAK SISTEM.
 *
 * Satu berkas (PDF/gambar) bisa berisi BEBERAPA nota. Contoh nyata di proyek
 * ini: 1 halaman A4 berisi 4 form "NOTA NO." sekaligus (lihat nota-contoh).
 * Jadi "1 berkas = 1 nota" adalah asumsi yang SALAH.
 *
 * Sistem sengaja TIDAK menebak jumlah nota, karena:
 *   - PDF hasil scan tidak punya text layer → tidak bisa dihitung.
 *   - PDF digital pun teksnya terpecah ("BANYAKNYA" terbaca "BA YA YA")
 *     akibat font subsetting, jadi pencarian kata kunci tidak andal.
 * Menebak salah = angka pengeluaran salah = laporan keuangan salah.
 *
 * CARA KERJA (revisi desain — sebelumnya pakai dropdown, terasa kerja dua kali):
 *   1. Admin unggah berkas, lalu isi "Jumlah nota" pada berkas itu.
 *   2. Sistem membuat baris rincian SEBANYAK jumlah nota tersebut, otomatis
 *      terhubung ke berkasnya. Admin tidak perlu memilih berkas lagi.
 *   3. Admin mengisi angka tiap baris.
 *
 * Jadi: 1 berkas berisi 4 nota → otomatis 4 baris. Tanpa dropdown, tanpa
 * klik "tambah baris" berulang.
 *
 * BATAS: `MAKS_BARIS` ada sebagai pengaman teknis (bukan pembatas kerja).
 * Tanpa batas, salah ketik jumlah bisa membuat browser hang dan transaksi
 * database menyimpan ratusan record sekaligus.
 *
 * ───────────────────────────────────────────────────────────────
 * PETA FILE INI (urutan dari atas ke bawah — pakai Ctrl+F nama fungsi)
 * ───────────────────────────────────────────────────────────────
 *   KONSTANTA BATAS  MAKS_BARIS · MAKS_NOTA_PER_BERKAS · DEFAULT_NOTA
 *                    MODE_DEFAULT · MAKS_NOTA_INFO
 *
 *   FIELD FORM       fieldInti()        field yang dipakai KEDUA bentuk
 *                    fieldPengeluaran() satu baris repeater (bukti + form)
 *                    pratinjauNota()    pratinjau gambar/potongan nota
 *
 *   UPLOAD + OCR     repeaterBerkas()   unggah berkas + pemicu OCR
 *                    bacaDenganOcr()    OCR satu berkas
 *                    prosesOcr()        OCR semua berkas (pakai cache)
 *                    hitungPetaPotongan() · jalankanOcrPenuh()
 *
 *   PENYUSUN BARIS   susunBaris()       berkas → daftar baris rincian
 *                    gabungBaris()      pertahankan kunci baris (Livewire)
 *                    isianAdmin() · isianOcr()
 *
 *   PINTU MASUK      configure()          form Ubah (1 pengeluaran)
 *                    configureSekaligus() form Tambah (banyak sekaligus)
 *
 * CARA MEMBACA: mulai dari `configureSekaligus()` (halaman Tambah) → ikuti ke
 * `fieldInti()` (isi field) → `repeaterBerkas()` (unggah + OCR) → `susunBaris()`
 * (cara baris dibuat). Bagian OCR & penyusunan baris ada di tengah file.
 */
class UangKeluarForm
{
    use PratinjauNotaPrivat;

    /**
     * Batas pengaman jumlah berkas & baris sekaligus.
     *
     * Dinaikkan 20 → 50 (8 Okt 2026) → 200 (permintaan user 8 Okt 2026):
     * "upload banyak nota dalam satu pdf hanya terdeteksi sampai 50".
     * Berkas gabungan sebulan sering berisi puluhan–ratusan nota (contoh
     * nyata: 57 nota dalam 15 halaman), jadi 50 terlalu ketat dan memotong
     * nota di tengah. 200 memberi ruang cukup, sekaligus tetap menahan salah
     * ketik ekstrem (mis. "4000") yang bisa membuat browser hang.
     */
    public const MAKS_BARIS = 200;

    /**
     * Maksimal nota yang boleh dideklarasikan untuk SATU berkas (mode rinci).
     *
     * ⚠️ PERBAIKAN BUG (audit): dulu nilainya 10, SEDANGKAN `MAKS_BARIS` 20.
     * Akibatnya mode rinci dengan 12 nota hanya membuat 10 baris DIAM-DIAM —
     * 2 nota hilang dari laporan tanpa peringatan apa pun. Sekarang disamakan
     * dengan `MAKS_BARIS`, jadi batas per berkas TIDAK PERNAH lebih ketat
     * daripada batas total baris.
     *
     * Nilai ini hanya pengaman teknis (menahan salah ketik seperti "4000"),
     * bukan pembatas kerja.
     */
    public const MAKS_NOTA_PER_BERKAS = self::MAKS_BARIS;

    /**
     * Jumlah nota default saat berkas baru diunggah.
     *
     * Permintaan user: "untuk jumlah nota default buat saja langsung 4 form
     * tetapi masih bisa diubah". Dipilih 4 karena 1 lembar nota di lapangan
     * biasanya berisi 4 form "NOTA NO." (lihat nota-contoh.pdf).
     */
    public const DEFAULT_NOTA = 4;

    /**
     * Batas nominal untuk menahan salah ketik.
     *
     * Tanpa ini, "upah tukang" bisa terisi Rp 250 miliar dan laporan
     * langsung tidak masuk akal.
     */
    private const BATAS_NOMINAL = 10_000_000_000;

    private const TIPE_FILE = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];

    private const MAKS_UKURAN_KB = 25600;

    /**
     * Mode input per berkas.
     *
     * Permintaan admin:
     *   "1 file upload itu satu form untuk semua total dari nota yang diupload
     *    tapi bisa juga satuan dan random juga"
     *
     *   - 'total' → 1 berkas = 1 baris (isi TOTAL saja). Untuk nota sebulan
     *     yang di-merge jadi satu PDF (mis. 57 nota jadi 1 file).
     *   - 'rinci' → 1 berkas = N baris (tiap nota sendiri). Untuk nota
     *     satuan / harian, DAN untuk berkas gabungan saat user ingin tiap
     *     nota dicatat sendiri (mis. 25 nota → 25 form).
     *
     * DEFAULT 'rinci' (keputusan user 8 Okt 2026): ketika satu berkas berisi
     * banyak nota, user ingin tiap nota dipotong & dibuatkan form sendiri
     * ("kalau ada 25 nota berarti ada 25 form"). Admin TETAP bisa memilih
     * 'total' kalau memang ingin mencatat satu total untuk berkas gabungan.
     */
    public const MODE_DEFAULT = 'rinci';

    /**
     * Kolom yang diisi ADMIN (bukan struktur) pada satu baris pengeluaran.
     *
     * Dipakai `isianAdmin()` untuk mempertahankan isian admin saat baris
     * disusun ulang. JANGAN masukkan kolom struktur (`bukti`, `nota_ke`,
     * `mode`, `potongan`, `sumber`, `berkas_ke`) — itu selalu dibuat baru.
     *
     * @var list<string>
     */
    private const KOLOM_ISIAN = [
        'jumlah',
        'kategori',
        'penerima',
        'spk_id',
        'keterangan',
        'tanggal',
    ];

    /**
     * Batas atas jumlah nota untuk keperluan INFORMASI (mode total).
     *
     * Berkas gabungan sebulan bisa berisi puluhan nota (contoh nyata: 57 nota
     * dalam 15 halaman). Angka ini hanya dipakai sebagai info "berkas ini
     * berisi N nota", BUKAN untuk membuat baris — jadi batasnya longgar.
     * Fungsinya hanya menahan nilai ngawur (mis. hasil salah baca OCR).
     */
    public const MAKS_NOTA_INFO = 999;

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
                /*
                 * ⚠️ Rules.md §5 butir 1: "Tanggal transaksi tidak boleh lebih
                 * dari hari ini". Tanpa batas ini, salah ketik tahun (2062 alih-
                 * alih 2026) membuat transaksi tidak muncul di filter bulan mana
                 * pun yang wajar — saldo & laporan pajak jadi salah, dan tidak
                 * ketahuan sampai dibandingkan dengan buku kas fisik.
                 *
                 * Tanggal LAMPAU tetap boleh (input transaksi terlambat).
                 */
                ->maxDate(now())
                ->default(now()),

            TextInput::make('jumlah')
                ->label('Jumlah (Rp)')
                ->required($wajib)
                ->numeric()
                ->minValue(0.01)
                ->maxValue(self::BATAS_NOMINAL)
                ->prefix('Rp')
                // ⚠️ BUG-02: normalisasi sebelum mask, kalau tidak nilai
                // "10000.00" tampil "1.000.000" (100× lipat) dan bisa
                // tersimpan salah kalau admin tidak mengetik ulang.
                ->formatStateUsing(fn ($state): ?string => Format::untukInputUang($state))
                ->mask(RawJs::make('$money($input, \',\', \'.\')'))
                ->stripCharacters('.')
                ->dehydrateStateUsing(fn ($state): ?float => filled($state) ? (float) $state : null)
                // `live` supaya PROGRES + ikon status per baris langsung
                // berubah saat admin mengetik — bukan baru saat Simpan.
                ->live(onBlur: true)
                ->when($wajib, fn (TextInput $field): TextInput => $field
                    ->rules(self::aturanJumlah())
                    ->helperText(self::helperJumlah())),

            Select::make('akun')
                ->label('Kas/Bank')
                ->options(AkunKas::opsi())
                ->default(AkunKas::Kas->value)
                ->native(false)
                ->helperText('Boleh dikosongkan — kalau kosong dianggap Kas. Isi hanya kalau perlu memisahkan buku Kas & Bank.'),

            Select::make('kategori')
                ->label('Kategori')
                ->options(KategoriPengeluaran::opsi())
                ->required($wajib)
                ->native(false)
                ->live()
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
                /*
                 * ⚠️ RULES.md §5 butir 3: SPK berstatus `Dibatalkan` TIDAK
                 * menerima transaksi baru. Biaya langsung pekerjaan yang sudah
                 * batal tidak boleh dicatat — laporan jadi menyesatkan.
                 *
                 * ⚠️ DITARUH DI LUAR `when($wajib, ...)` dengan sengaja:
                 * repeater `pengeluaran` memakai `fieldInti(false)`, sedangkan
                 * blok `when($wajib)` hanya berlaku untuk `fieldInti(true)`.
                 * Kalau aturan ini ditaruh di dalam `when`, ia TIDAK PERNAH
                 * dijalankan di halaman Tambah — dan celahnya kembali terbuka.
                 * (Kesalahan ini sempat terjadi dan tertangkap oleh tes.)
                 *
                 * Memakai `StatusSpk::bolehTransaksiBaru()` supaya aturan hidup
                 * di SATU tempat saja.
                 */
                ->rules([
                    fn (): Closure => function (string $attribute, mixed $value, Closure $fail): void {
                        $spk = $value ? Spk::find($value) : null;

                        // ⚠️ `status_spk` boleh NULL (data lama/belum diisi).
                        // Tanpa guard ini, memanggil method pada NULL melempar
                        // "Call to a member function bolehTransaksiBaru() on null"
                        // sehingga form gagal total. NULL = belum dibatalkan.
                        if ($spk !== null && $spk->status_spk !== null && ! $spk->status_spk->bolehTransaksiBaru()) {
                            $fail('SPK ini berstatus Dibatalkan — tidak bisa menerima transaksi baru.');
                        }
                    },
                ])
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
     *
     * @param  array<string, int>|null  $columnSpan  Lebar kolom (mis. ['default' => 2, 'lg' => 1]).
     *                                               Null = lebar penuh.
     */
    private static function pratinjauNota(?array $columnSpan = null): Placeholder
    {
        $placeholder = Placeholder::make('pratinjau_nota')
            ->hiddenLabel()
            ->content(fn (Get $get) => view('filament.components.pratinjau-nota', [
                'files' => $get('bukti'),
                // Potongan hasil OCR: kalau ada, pratinjau menampilkan notanya
                // sendiri (bukan gambar penuh yang sama di tiap baris).
                'potongan' => $get('potongan'),
            ]));

        return $columnSpan === null
            ? $placeholder->columnSpanFull()
            : $placeholder->columnSpan($columnSpan);
    }

    /**
     * Aturan anti-salah-ketik: total biaya SPK tidak wajar.
     *
     * ⚠️ BUG YANG DICEGAH (BUG-01, ditemukan saat uji deploy 7 Okt 2026):
     *
     * Sebelumnya closure ini memakai signature validator Laravel SEKALIGUS
     * injeksi Filament:
     *
     *     function (string $attribute, $value, Closure $fail, Get $get): void
     *
     * Filament mengevaluasi closure lewat `EvaluatesClosures::evaluate()`, yang
     * menyuntikkan dependensi PER PARAMETER lewat refleksi. Parameter `$attribute`
     * dan `$value` TIDAK dikenal (bukan nama/tipe injeksi yang dikenali), jadi
     * Filament melempar:
     *
     *     BindingResolutionException: An attempt was made to evaluate a closure
     *     for [Filament\Forms\Components\TextInput], but [$attribute] was
     *     unresolvable.
     *
     * Akibatnya halaman UBAH Uang Keluar gagal total — admin tidak bisa
     * menyimpan perubahan sama sekali.
     *
     * PERBAIKAN: pisahkan dua tanggung jawab.
     *   1. Closure LUAR adalah closure Filament — hanya menerima `Get $get`,
     *      yang MEMANG dikenali & disuntik Filament. Di dalamnya `spk` dihitung
     *      dari state form.
     *   2. Closure DALAM adalah aturan validator Laravel murni
     *      (`$attribute, $value, $fail`) — dipanggil Laravel sendiri saat
     *      validasi, jadi signature-nya valid. Nilai `$spk` ditangkap lewat
     *      `use`, bukan disuntik.
     *
     * @return array<int, mixed>
     */
    private static function aturanJumlah(): array
    {
        return [
            fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get): void {
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

    private static function helperJumlah(): Closure
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
     * @return Closure(): array<int, string>
     */
    private static function opsiSpk(): Closure
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
     *
     * Menerima ARRAY juga, karena FileUpload memakai `multiple()` (state-nya
     * array walau isinya satu berkas).
     */
    private static function pathFile(mixed $file): ?string
    {
        // State `multiple()` berbentuk array — ambil berkas pertamanya.
        if (is_array($file)) {
            foreach ($file as $satu) {
                if (filled($path = self::pathFile($satu))) {
                    return $path;
                }
            }

            return null;
        }

        if (is_string($file)) {
            return $file;
        }

        if (! is_object($file)) {
            return null;
        }

        if (method_exists($file, 'getStatePath') && filled($path = $file->getStatePath())) {
            return $path;
        }

        /*
         * ⚠️ JANGAN kembalikan path berkas SEMENTARA (livewire-tmp/...).
         *
         * Bug yang pernah terjadi: berkas sementara dikembalikan sebagai path,
         * sehingga `Storage::disk('public')->exists()` gagal ("File tidak
         * ditemukan") dan OCR tidak bisa membaca berkas.
         *
         * Sekarang berkas diringankan (kompres) lalu DISIMPAN ke disk, dan yang
         * dikembalikan adalah path RELATIF yang benar (mis. uang_keluar/x.jpg).
         * Karena nama berkas deterministik, pemanggilan berulang tidak membuat
         * salinan ganda — Filament memakai path yang SAMA saat Simpan.
         */
        if ($file instanceof UploadedFile) {
            return app(PenyimpanBerkas::class)->simpanKe(
                $file,
                'uang_keluar',
                'nota',
            );
        }

        return null;
    }

    /**
     * Berkas nota + jumlah nota di dalamnya.
     *
     * PERUBAHAN DESAIN (menggantikan dropdown "Nota / Berkas"):
     *
     * Sebelumnya: unggah berkas → pilih lagi berkas itu di dropdown tiap baris.
     * Admin mengeluh tidak praktis (kerja dua kali). Sekarang admin cukup
     * mengisi "Jumlah nota" SEKALI per berkas, lalu sistem membuat barisnya.
     *
     * Catatan: `dehydrated(false)` karena repeater ini hanya ALAT BANTU
     * menghasilkan baris — yang disimpan ke database tetap kolom `bukti`
     * milik tiap baris `pengeluaran`, bukan struktur berkas ini.
     */
    private static function repeaterBerkas(): Repeater
    {
        return Repeater::make('berkas_nota')
            ->hiddenLabel()
            ->schema([
                FileUpload::make('file')
                    ->label('Berkas Nota')
                    // TIDAK required — aturan bisnis lama membolehkan
                    // pengeluaran TANPA nota (mis. biaya operasional kantor).
                    // Jangan diubah jadi wajib tanpa keputusan user.
                    ->multiple()
                    ->maxFiles(1)
                    ->disk('nota')
                    ->directory('uang_keluar')
                    ->acceptedFileTypes(self::TIPE_FILE)
                    ->maxSize(self::MAKS_UKURAN_KB)
                    ->live()
                    /*
                     * SIMPAN SEKALI SAJA — berkas diringankan lalu ditulis.
                     *
                     * `$file` bisa berupa UploadedFile (berkas baru) atau path
                     * berkas yang sudah diringankan `siapkan()` (dipakai OCR).
                     * Keduanya ditangani `simpanKe()`; tidak ada penyimpanan
                     * ganda, jadi tidak ada berkas besar jadi sampah.
                     */
                    ->saveUploadedFileUsing(fn ($file): ?string => app(PenyimpanBerkas::class)->simpanKe(
                        $file,
                        'uang_keluar',
                        'nota',
                    ))
                    ->panelLayout('grid')
                    ->imagePreviewHeight('150')
                    // Disk nota PRIVAT: URL bawaan Filament (/storage/...) TIDAK
                    // boleh dipakai — berkas hanya boleh dibaca lewat rute ber-otentikasi.
                    ->fetchFileInformation(false)
                    ->tap(fn ($field) => self::pratinjauPrivat($field))
                    ->helperText('JPG, PNG, WEBP, atau PDF. Maks '.round(self::MAKS_UKURAN_KB / 1024).' MB. Gambar dikecilkan otomatis. Boleh dikosongkan kalau tanpa nota.'),

                // Path potongan nota per baris — diisi OCR, dipakai pratinjau.
                Hidden::make('potongan'),

                // Pesan hasil OCR untuk admin (mis. "OCR mendeteksi 4 nota").
                Hidden::make('ocr_info'),

                Placeholder::make('info_ocr')
                    ->hiddenLabel()
                    ->content(function (Get $get) {
                        $info = $get('ocr_info');

                        return blank($info) ? '' : view('filament.components.info-ocr', [
                            'pesan' => (string) $info,
                            'gagal' => str_contains((string) $info, 'tidak bisa membaca'),
                        ]);
                    })
                    ->visible(fn (Get $get): bool => filled($get('ocr_info')))
                    ->columnSpanFull(),

                /*
                 * MODE INPUT — admin memilih cara mencatat berkas ini.
                 *
                 * Permintaan admin: berkas gabungan sebulan (banyak nota) di-input
                 * sebagai SATU form berisi TOTAL; tapi nota satuan/harian tetap
                 * bisa dicatat per nota. Admin yang memilih, sistem tidak menebak.
                 */
                Radio::make('mode')
                    ->label('Cara mencatat berkas ini')
                    ->options([
                        'total' => 'Total (1 berkas = 1 baris)',
                        'rinci' => 'Rinci (1 baris per nota)',
                    ])
                    ->default(self::MODE_DEFAULT)
                    ->descriptions([
                        'total' => 'Untuk berkas gabungan (mis. nota sebulan di-merge jadi 1 PDF). Cukup isi TOTAL-nya.',
                        'rinci' => 'Untuk nota satuan/harian. Tiap nota diisi sendiri.',
                    ])
                    ->inline()
                    ->live()
                    ->columnSpanFull(),

                TextInput::make('jumlah_nota')
                    ->label('Jumlah nota dalam berkas ini')
                    // Tidak required: hanya bermakna kalau ada berkasnya.
                    ->numeric()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(self::MAKS_NOTA_PER_BERKAS)
                    // DEFAULT 4 — permintaan user: "untuk jumlah nota default
                    // buat saja langsung 4 form tetapi masih bisa diubah".
                    // Nilai ini ditimpa hasil OCR kalau OCR berhasil.
                    ->default(self::DEFAULT_NOTA)
                    ->live(onBlur: true)
                    ->helperText('Default 4 (1 lembar biasanya berisi 4 nota). Ubah kalau jumlah notanya berbeda — baris rincian ikut menyesuaikan.')
                    // Hanya relevan di mode rinci. Di mode total, jumlah nota
                    // tetap dipakai OCR untuk info, tapi admin tidak perlu isi.
                    ->visible(fn (Get $get): bool => ($get('mode') ?? self::MODE_DEFAULT) === 'rinci')
                    ->columnSpanFull(),
            ])
            ->columns(['default' => 1, 'lg' => 3])
            ->defaultItems(1)
            ->minItems(1)
            ->maxItems(self::MAKS_BARIS)
            ->addActionLabel('Tambah berkas nota')
            ->reorderable(false)
            ->dehydrated(false)
            /*
             * `live()` WAJIB ada di sini.
             *
             * Tanpa `live()`, `afterStateUpdated` TIDAK terpanggil saat
             * FilePond selesai mengunggah berkas — sudah dibuktikan lewat
             * trace (file trace kosong). Akibatnya OCR tidak pernah jalan dan
             * baris rincian tetap memakai DEFAULT 4 — persis bug yang
             * dilaporkan user: "1 upload isinya 1 nota, kenapa dibuat 4 form".
             */
            ->live()
            ->afterStateUpdated(function (Set $set, Get $get): void {
                $berkas = is_array($get('berkas_nota')) ? $get('berkas_nota') : [];
                $cache = is_array($get('potongan_ocr')) ? $get('potongan_ocr') : [];
                $cacheIsi = is_array($get('isi_nota_ocr')) ? $get('isi_nota_ocr') : [];
                // Baris yang SUDAH ada — isian admin di dalamnya harus
                // dipertahankan, jangan dibuat ulang jadi kosong.
                $lama = is_array($get('pengeluaran')) ? $get('pengeluaran') : [];

                $hasil = self::prosesOcr($berkas, $cache, $cacheIsi);

                // Tulis hasil OCR ke item berkas (jumlah_nota + info),
                // HANYA kalau memang berubah — supaya tidak memicu loop.
                if ($hasil['berkas'] !== $berkas) {
                    $set('berkas_nota', $hasil['berkas']);
                }

                $set('potongan_ocr', $hasil['potongan']);
                $set('isi_nota_ocr', $hasil['isi']);
                // `$lama` diteruskan supaya isian admin TIDAK hilang saat OCR
                // selesai belakangan, DAN kunci item dipertahankan supaya
                // pilihan dropdown (Kategori) tidak nyasar jadi null.
                $set('pengeluaran', self::gabungBaris($lama, self::susunBaris(
                    $hasil['berkas'],
                    $hasil['potongan'],
                    [],
                    $lama,
                    $hasil['isi'],
                )));
            });
    }

    /**
     * Gabungkan baris BARU dengan baris LAMA sambil MEMPERTAHANKAN KUNCI item.
     *
     * ⚠️ INI PENTING — JANGAN DIHAPUS.
     *
     * Livewire mengenali tiap baris repeater dari KUNCI array-nya (UUID).
     * Kalau `$set('pengeluaran', ...)` mengembalikan array dengan kunci BARU,
     * semua item dianggap "baris baru" — akibatnya:
     *   - fokus/kursor admin bisa lepas saat mengetik;
     *   - pilihan dropdown (mis. Kategori) yang dikirim browser "nyasar" ke
     *     item lama, sehingga tersimpan sebagai NULL.
     *     (Terbukti: kategori terpilih "Material" di layar, tapi tersimpan null.)
     *
     * Dengan memakai ulang kunci lama, item tetap dikenali Livewire.
     *
     * @param  array<mixed>  $lama
     * @param  array<int, array<string, mixed>>  $baru
     * @return array<string, array<string, mixed>>
     */
    private static function gabungBaris(array $lama, array $baru): array
    {
        $kunciLama = array_keys(array_filter(
            $lama,
            fn ($r): bool => is_array($r),
        ));

        $hasil = [];

        foreach ($baru as $i => $r) {
            $kunci = $kunciLama[$i] ?? (string) Str::uuid();
            $hasil[$kunci] = $r;
        }

        return $hasil;
    }

    /**
     * Jalankan OCR saat berkas nota diunggah.
     *
     * Yang dilakukan:
     *   1. Hitung jumlah nota di dalam berkas -> isi field `jumlah_nota`.
     *   2. Simpan path potongan tiap nota -> dipakai pratinjau per baris.
     *
     * ⚠️ OCR ini BANTUAN. Kalau gagal, TIDAK boleh menghalangi admin:
     * jumlah nota dibiarkan apa adanya (default 4) dan admin bisa ubah manual.
     * Karena itu semua kegagalan ditangkap dan hanya dicatat di log.
     *
     * ⚠️ CATATAN PENTING SOAL SCOPE STATE (bug yang pernah terjadi):
     * Method ini dipanggil dari dalam repeater `berkas_nota`, jadi `$set()`
     * menulis ke ITEM repeater — bukan ke form utama. Karena itu potongan
     * TIDAK disimpan lewat `$set()`, melainkan dikembalikan sebagai nilai
     * balik, lalu disebar ke baris oleh pemanggil (`simpanHasilOcr()`).
     * Sebelumnya potongan disimpan lewat `$set('potongan', ...)` dan nilainya
     * HILANG — baris rincian tetap memakai gambar penuh.
     *
     * @param  mixed  $state  state FileUpload (array path, karena multiple)
     * @return array{jumlah_nota: int|null, potongan: array<int, string>, isi: array<int, array<string, mixed>>, pesan: string|null}
     */
    private static function bacaDenganOcr(mixed $state): array
    {
        $kosong = ['jumlah_nota' => null, 'potongan' => [], 'isi' => [], 'pesan' => null];

        $pembaca = app(PembacaNota::class);

        if (! $pembaca->aktif()) {
            return $kosong;
        }

        $path = self::pathFile($state);

        if (blank($path)) {
            // Berkas dihapus — bersihkan hasil OCR sebelumnya.
            return ['jumlah_nota' => null, 'potongan' => [], 'isi' => [], 'pesan' => ''];
        }

        try {
            $hasil = $pembaca->baca($path);
        } catch (Throwable $e) {
            // OCR tidak boleh menjatuhkan form.
            report($e);

            return $kosong;
        }

        if (! ($hasil['ok'] ?? false)) {
            // Gagal baca: beri tahu admin supaya dia tahu harus isi manual.
            return [
                'jumlah_nota' => null,
                'potongan' => [],
                'isi' => [],
                'pesan' => 'OCR tidak bisa membaca berkas ini — isi jumlah nota manual.',
            ];
        }

        $jumlah = (int) $hasil['jumlah_nota'];

        // DRAF isi tiap nota (nominal/tanggal/penerima/kategori) — dipakai
        // mengisi baris otomatis. Admin tetap bisa mengubah.
        $isi = is_array($hasil['nota'] ?? null) ? $hasil['nota'] : [];

        return [
            'jumlah_nota' => $jumlah,
            'potongan' => $hasil['potongan'] ?? [],
            'isi' => $isi,
            'pesan' => $jumlah > 1
                ? "OCR mendeteksi {$jumlah} nota di berkas ini."
                : null,
        ];
    }

    /**
     * Jalankan OCR untuk seluruh berkas, kembalikan state yang sudah diperbarui.
     *
     * ⚠️ CARA KERJA & KENAPA BEGINI
     *
     * Dipanggil dari `Repeater::afterStateUpdated()` (repeater WAJIB `live()`,
     * kalau tidak event-nya tidak pernah terpanggil saat FilePond selesai
     * mengunggah — sudah dibuktikan lewat trace).
     *
     * Hasil OCR (jumlah nota + potongan) TIDAK ditulis ke dalam item repeater
     * lewat `$set()` dari dalam item, karena itu menyebabkan error
     * "$attribute was unresolvable". Sebagai gantinya:
     *
     *   1. Hasil OCR disimpan di CACHE tingkat form (`potongan_ocr`).
     *   2. `berkas` yang dikembalikan sudah berisi `jumlah_nota` hasil OCR.
     *   3. Pemanggil menulis kembali `berkas_nota` HANYA kalau ada perubahan —
     *      ini yang memutus potensi loop (putaran kedua: cache sudah terisi,
     *      tidak ada perubahan, berhenti).
     *
     * @param  array<mixed>  $berkas
     * @param  array<string, array<int, string>>  $cache
     * @param  array<string, array<int, array<string, mixed>>>  $cacheIsi
     * @return array{berkas: array<mixed>, potongan: array<string, array<int, string>>, isi: array<string, array<int, array<string, mixed>>>}
     */
    public static function prosesOcr(array $berkas, array $cache = [], array $cacheIsi = []): array
    {
        if (! app(PembacaNota::class)->aktif()) {
            return ['berkas' => $berkas, 'potongan' => $cache, 'isi' => $cacheIsi];
        }

        $peta = $cache;
        $petaIsi = $cacheIsi;

        foreach ($berkas as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            // Sudah pernah dibaca -> pakai hasil cache (jangan OCR ulang).
            if (array_key_exists($path, $peta)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            $peta[$path] = $hasil['potongan'];
            $petaIsi[$path] = $hasil['isi'];

            // Tulis hasil OCR ke item, supaya `jumlah_nota` di form ikut terisi
            // dan baris rincian disusun dengan jumlah yang benar.
            if ($hasil['jumlah_nota'] !== null) {
                $berkas[$index]['jumlah_nota'] = $hasil['jumlah_nota'];
            }

            $berkas[$index]['ocr_info'] = $hasil['pesan'];
        }

        return ['berkas' => $berkas, 'potongan' => $peta, 'isi' => $petaIsi];
    }

    /**
     * Hitung peta potongan (path berkas -> daftar potongan) dengan menjalankan
     * OCR hanya untuk berkas yang BELUM ada di peta.
     *
     * DIBUAT FUNGSI MURNI supaya bisa diuji langsung tanpa Livewire — tes
     * lewat `fillForm` tidak memicu `afterStateUpdated`, sehingga jalur ini
     * tidak terjangkau oleh tes berbasis Livewire.
     *
     * Penjaga idempoten: berkas yang sudah ada di `$petaLama` dilewati, jadi
     * OCR jalan SEKALI per berkas (tidak diulang tiap admin mengetik).
     *
     * @param  array<mixed>  $berkas  state repeater `berkas_nota`
     * @param  array<string, array<int, string>>  $petaLama
     * @return array<string, array<int, string>>
     */
    public static function hitungPetaPotongan(array $berkas, array $petaLama = []): array
    {
        foreach ($berkas as $i => $b) {
        }

        if (! app(PembacaNota::class)->aktif()) {
            return $petaLama;
        }

        $peta = $petaLama;

        foreach ($berkas as $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            // Sudah pernah dibaca -> lewati.
            if (array_key_exists($path, $peta)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            $peta[$path] = $hasil['potongan'];
        }

        return $peta;
    }

    /**
     * Jalankan OCR lalu kembalikan state form yang sudah diperbarui.
     *
     * Dipakai oleh tes dan oleh tempat lain yang butuh hasil lengkap
     * (jumlah nota per berkas + baris rincian) dalam satu panggilan.
     *
     * @param  array<mixed>  $berkas
     * @return array{berkas: array<mixed>, potongan: array<string, array<int, string>>, isi: array<string, array<int, array<string, mixed>>>, baris: array<int, array<string, mixed>>}
     */
    public static function jalankanOcrPenuh(array $berkas): array
    {
        $peta = self::hitungPetaPotongan($berkas);
        $petaIsi = [];

        // Isi jumlah_nota per berkas dari hasil OCR.
        foreach ($berkas as $index => $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            $hasil = self::bacaDenganOcr($item['file'] ?? null);

            if ($hasil['jumlah_nota'] !== null) {
                $berkas[$index]['jumlah_nota'] = $hasil['jumlah_nota'];
            }

            $berkas[$index]['ocr_info'] = $hasil['pesan'];
            $petaIsi[$path] = $hasil['isi'];
        }

        return [
            'berkas' => $berkas,
            'potongan' => $peta,
            'isi' => $petaIsi,
            'baris' => self::susunBaris($berkas, $peta, [], [], $petaIsi),
        ];
    }

    /**
     * Ambil HANYA isian admin dari satu baris lama, untuk disalin ke baris baru.
     *
     * ⚠️ INI KUNCI PERBAIKAN BUG "isian hilang".
     *
     * `susunBaris()` membuat baris baru setiap kali berkas berubah. Tanpa
     * fungsi ini, isian admin (jumlah, kategori, dst) ikut terbuang dan alert
     * "belum lengkap" muncul padahal sudah diisi.
     *
     * Sengaja HANYA kolom isian yang disalin — kolom struktur (`bukti`,
     * `berkas_ke`, `nota_ke`, `mode`, `potongan`, `sumber`) TIDAK disalin,
     * supaya struktur baru dari `susunBaris()` yang menang.
     *
     * @param  array<string, mixed>  $lama
     * @return array<string, mixed>
     */
    private static function isianAdmin(array $lama): array
    {
        $isian = [];

        foreach (self::KOLOM_ISIAN as $kolom) {
            if (array_key_exists($kolom, $lama) && filled($lama[$kolom])) {
                $isian[$kolom] = $lama[$kolom];
            }
        }

        return $isian;
    }

    /**
     * Ubah DRAF hasil OCR satu nota menjadi isian baris.
     *
     * ⚠️ HANYA field yang BERHASIL dibaca yang diisi (null/blank dilewati),
     * supaya baris tidak terisi nilai kosong yang menutupi input admin.
     *
     * ⚠️ Hasilnya DRAF. `susunBaris()` memasang draf ini LEBIH DULU daripada
     * isian admin (`isianAdmin`), jadi apa pun yang sudah diketik admin selalu
     * menang. Ini pengaman agar OCR tidak pernah menimpa pekerjaan admin —
     * penting karena nota banyak yang tulisan tangan dan bisa salah baca.
     *
     * @param  array<string, mixed>  $isi  satu entri dari `petaIsi` hasil OCR
     * @return array<string, mixed>
     */
    private static function isianOcr(array $isi): array
    {
        $isian = [];

        // Nominal → kolom `jumlah` (hanya kalau wajar).
        $nominal = $isi['nominal'] ?? null;

        if (is_numeric($nominal) && (int) $nominal > 0) {
            $isian['jumlah'] = (int) $nominal;
        }

        // Kategori saran — HANYA kalau kode enum-nya valid, supaya dropdown
        // tidak menerima nilai asing.
        $kategori = $isi['kategori'] ?? null;

        if (is_string($kategori) && array_key_exists($kategori, KategoriPengeluaran::opsi())) {
            $isian['kategori'] = $kategori;
        }

        if (filled($isi['penerima'] ?? null)) {
            $isian['penerima'] = mb_substr((string) $isi['penerima'], 0, 200);
        }

        if (filled($isi['keterangan'] ?? null)) {
            $isian['keterangan'] = mb_substr((string) $isi['keterangan'], 0, 500);
        }

        return $isian;
    }

    /**
     * Susun baris rincian dari daftar berkas + jumlah notanya.
     *
     * Aturan penting:
     *   1. Isian admin yang SUDAH ADA dipertahankan (jangan hilang saat
     *      berkas ditambah/diubah) — dicocokkan lewat posisi baris.
     *   2. Tiap baris otomatis menunjuk berkasnya sendiri (`sumber` + `bukti`),
     *      jadi admin tidak perlu memilih berkas lagi.
     *   3. Jumlah total baris dibatasi MAKS_BARIS sebagai pengaman.
     *
     * @param  mixed  $berkas  state repeater `berkas_nota`
     * @param  array<string, array<int, string>>  $petaPotongan
     *                                                           Peta path berkas -> daftar path potongan hasil OCR.
     *                                                           Dipisah dari `$berkas` supaya tidak ada masalah state basi
     *                                                           (lihat catatan di repeaterBerkas()).
     * @param  array<string, array<int, array<string, mixed>>>  $petaIsi
     *                                                                    Peta path berkas -> daftar DRAF isi tiap nota hasil OCR
     *                                                                    (nominal, tanggal, penerima, kategori, keterangan).
     *                                                                    Dipakai mengisi otomatis baris; admin tetap bisa ubah.
     * @return array<int, array<string, mixed>>
     */
    public static function susunBaris(mixed $berkas, array $petaPotongan = [], array $petaJumlah = [], mixed $lama = [], array $petaIsi = []): array
    {
        $baris = [];
        $nomorBerkas = 0;
        $terpotong = false;

        /*
         * ⚠️ PETA ISIAN ADMIN YANG SUDAH ADA — SUMBER PERBAIKAN BUG PENTING.
         *
         * `susunBaris()` dipanggil ULANG setiap kali berkas berubah (mis. OCR
         * selesai 40 detik setelah admin mulai mengetik). Dulu setiap panggilan
         * MEMBUAT BARIS BARU KOSONG, sehingga isian admin (jumlah, kategori,
         * tanggal) HILANG — dan alert "Masih ada N baris belum lengkap" muncul
         * padahal barisnya sudah diisi lengkap.
         *
         * Perbaikan: baris lama diindeks per (berkas + nomor nota), lalu isian
         * admin disalin kembali ke baris baru. Kunci baris = path berkas +
         * `nota_ke` (0 untuk mode total), jadi baris tetap terpasang ke
         * notanya walau OCR menambah/mengurangi baris di berkas lain.
         */
        $petaIsian = [];

        foreach (collect(is_array($lama) ? $lama : [])->filter() as $r) {
            if (! is_array($r)) {
                continue;
            }

            $pLama = self::pathFile($r['bukti'] ?? null);

            if (blank($pLama)) {
                continue;
            }

            $petaIsian[$pLama][(int) ($r['nota_ke'] ?? 0)] = $r;
        }

        $totalBerkas = collect(is_array($berkas) ? $berkas : [])
            ->filter(fn ($item): bool => is_array($item) && filled(self::pathFile($item['file'] ?? null)))
            ->count();

        foreach (collect(is_array($berkas) ? $berkas : [])->filter() as $item) {
            if (! is_array($item)) {
                continue;
            }

            $path = self::pathFile($item['file'] ?? null);

            if (blank($path)) {
                continue;
            }

            $nomorBerkas++;

            /*
             * MODE PER BERKAS — "total" atau "rinci".
             *
             * Permintaan admin:
             *   "1 file upload itu satu form untuk semua total dari nota yang
             *    diupload tapi bisa juga satuan dan random juga yang jelas
             *    dalam file nota yang banyak itu satu bulan jadi admin sengaja
             *    marge nota jadi satu selama sebulan dan di input dengan satu
             *    form saja total dari file nota tersebut"
             *
             * Jadi:
             *   - mode 'total' → 1 berkas = 1 baris (isi TOTAL saja).
             *     Dipakai untuk nota sebulan yang di-merge (mis. 57 nota).
             *   - mode 'rinci' → 1 berkas = N baris (tiap nota sendiri).
             *     Dipakai untuk nota satuan / harian.
             *
             * Mode dipilih ADMIN per berkas — sistem tidak menebak.
             */
            $mode = ($item['mode'] ?? self::MODE_DEFAULT) === 'rinci' ? 'rinci' : 'total';

            /*
             * Jumlah nota dari OCR (paling akurat) atau isian admin.
             *
             * ⚠️ BEDA BATAS PER MODE — penting:
             *   - mode RINCI: dibatasi MAKS_NOTA_PER_BERKAS, karena jumlah ini
             *     menentukan berapa BARIS form yang dibuat. Salah ketik "4000"
             *     harus ditahan supaya browser tidak hang.
             *   - mode TOTAL: TIDAK dibatasi seketat itu, karena jumlah ini
             *     hanya INFO ("berkas ini isinya 57 nota"). Berkas gabungan
             *     sebulan bisa berisi puluhan nota — kalau dibatasi 10,
             *     informasinya jadi bohong.
             */
            $dariOcr = (int) ($petaJumlah[$path] ?? 0);
            $dariAdmin = (int) ($item['jumlah_nota'] ?? 0);

            $mentah = $dariOcr > 0 ? $dariOcr : ($dariAdmin > 0 ? $dariAdmin : self::DEFAULT_NOTA);

            $jumlahNota = $mode === 'total'
                ? max(1, min(self::MAKS_NOTA_INFO, $mentah))
                : max(1, min(self::MAKS_NOTA_PER_BERKAS, $mentah));

            // Potongan nota hasil OCR. Sumber utamanya `$petaPotongan`
            // (state tingkat form); item repeater dipakai sebagai cadangan
            // supaya tetap jalan kalau dipanggil dari tempat lain.
            $potongan = $petaPotongan[$path]
                ?? (is_array($item['potongan'] ?? null) ? array_values($item['potongan']) : []);

            // MODE TOTAL: satu baris untuk seluruh berkas.
            if ($mode === 'total') {
                if (count($baris) >= self::MAKS_BARIS) {
                    $terpotong = true;
                    break;
                }

                $baris[] = array_merge([
                    'bukti' => [$path],
                    'sumber' => $path,
                    'berkas_ke' => $nomorBerkas,
                    'berkas_dari' => $totalBerkas,
                    // nota_ke = 0 menandai "ini total seluruh berkas",
                    // bukan nota ke-N. Dipakai penanda berkas & label.
                    'nota_ke' => 0,
                    'nota_dari' => $jumlahNota,
                    'mode' => 'total',
                    // Mode total: tampilkan berkas UTUH, bukan potongan.
                    'potongan' => null,
                    'tanggal' => now()->toDateString(),
                ], self::isianAdmin($petaIsian[$path][0] ?? []));

                continue;
            }

            // MODE RINCI: satu baris per nota.
            //
            // ⚠️ Kalau jumlah nota MENTAH melebihi batas pengaman, sistem
            // memotongnya. Itu harus DITANDAI (bukan diam-diam), supaya admin
            // tahu ada nota yang belum tercatat.
            if ($mentah > $jumlahNota) {
                $terpotong = true;
            }

            for ($n = 1; $n <= $jumlahNota; $n++) {
                if (count($baris) >= self::MAKS_BARIS) {
                    // ⚠️ Baris ke-n TIDAK dibuat karena batas pengaman.
                    // Tandai supaya admin tahu ada nota yang belum tercatat —
                    // jangan diam-diam menghilangkan nota dari laporan.
                    $terpotong = true;
                    break 2;
                }

                $baris[] = array_merge([
                    'bukti' => [$path],
                    // Penanda asal — dipakai untuk MEMBEDAKAN baris mana milik
                    // berkas mana. Tanpa ini, baris dari berkas berbeda
                    // bercampur tanpa navigasi yang jelas.
                    'sumber' => $path,
                    'berkas_ke' => $nomorBerkas,
                    'berkas_dari' => $totalBerkas,
                    'nota_ke' => $n,
                    'nota_dari' => $jumlahNota,
                    'mode' => 'rinci',
                    // Potongan khusus untuk baris ini (kalau OCR berhasil).
                    'potongan' => $potongan[$n - 1] ?? null,
                    'tanggal' => now()->toDateString(),
                ],
                    // 1) DRAF dari OCR — hanya field yang berhasil dibaca.
                    self::isianOcr($petaIsi[$path][$n - 1] ?? []),
                    // 2) Isian admin yang SUDAH ADA menang atas draf OCR, jadi
                    //    OCR tidak pernah menimpa apa yang sudah diisi admin.
                    self::isianAdmin($petaIsian[$path][$n] ?? []));
            }
        }

        // Tandai baris TERAKHIR kalau ada yang terpotong batas pengaman.
        // Dipakai UI untuk memberi tahu admin — supaya tidak ada nota yang
        // hilang dari laporan tanpa disadari.
        if ($terpotong && $baris !== []) {
            $baris[count($baris) - 1]['terpotong'] = true;
        }

        return $baris === [] ? [[]] : $baris;
    }

    /**
     * Satu baris repeater: BUKTI di KIRI, FORM di KANAN.
     *
     * Permintaan user:
     *   "gambar bukti masih terpotong, bisa anda buat bersebelahan kiri kanan,
     *    kiri bukti kanan form yang jelas bukti terlihat full dan jelas"
     *
     * Rasio 2:3 → bukti dapat 2/5 lebar. Bukti dibuat `object-contain` +
     * tinggi tetap, jadi nota SELALU tampil utuh (tidak terpotong) apa pun
     * bentuk aslinya. Form dapat 3/5 lebar supaya field tetap lega.
     *
     * Di layar sempit (< lg) otomatis menumpuk atas-bawah, karena
     * `default => 2` / `lg => 1` = satu kolom penuh per bagian.
     *
     * @return array<int, mixed>
     */
    private static function fieldPengeluaran(): array
    {
        return [
            self::pratinjauNota(['default' => 2, 'lg' => 2]),

            Group::make([
                /*
                 * Keterangan asal nota — MENGGANTIKAN dropdown "Nota / Berkas".
                 *
                 * Admin tidak perlu memilih berkas lagi: baris sudah otomatis
                 * terhubung ke berkasnya oleh `susunBaris()`. Yang ditampilkan
                 * hanya info, supaya admin tahu baris ini nota ke-berapa.
                 */
                Placeholder::make('asal_nota')
                    ->hiddenLabel()
                    ->content(function (Get $get) {
                        $jumlah = $get('jumlah');
                        $kategori = $get('kategori');
                        $tanggal = $get('tanggal');

                        return view('filament.components.penanda-berkas', [
                            'berkasKe' => (int) ($get('berkas_ke') ?? 1),
                            'berkasDari' => (int) ($get('berkas_dari') ?? 1),
                            'notaKe' => (int) ($get('nota_ke') ?? 1),
                            'notaDari' => (int) ($get('nota_dari') ?? 1),
                            'mode' => (string) ($get('mode') ?? ''),
                            'nama' => blank($get('sumber')) ? null : basename((string) $get('sumber')),
                            // Status baris — dipakai untuk ikon ✓ / ⚠ / kosong.
                            'lengkap' => filled($jumlah) && filled($kategori) && filled($tanggal),
                            'adaIsi' => filled($jumlah) || filled($kategori),
                        ]);
                    })
                    ->columnSpanFull(),

                ...self::fieldInti(false),
            ])
                ->columns(2)
                ->columnSpan(['default' => 2, 'lg' => 3]),

            // Path nota diisi otomatis oleh susunBaris(), tapi komponennya
            // harus tetap ada agar nilainya ikut tersimpan.
            Hidden::make('bukti'),
        ];
    }

    /**
     * Bentuk 1 — satu pengeluaran (halaman Ubah).
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Nota')
                    ->description('Pratinjau nota. Klik "Buka di tab baru" untuk melihat ukuran penuh.')
                    ->schema([self::pratinjauNota()])
                    ->columnSpanFull(),

                /*
                 * SATU KOLOM PENUH (brief UI/UX 8 Okt 2026).
                 *
                 * Form Uang Keluar dipakai admin untuk pencatatan cepat di
                 * lapangan lewat HP. Satu kolom dari atas ke bawah membuat
                 * tiap field lebar penuh → mudah disentuh & tidak salah tekan,
                 * dan tidak ada field yang berdempetan di layar sempit.
                 *
                 * (Sebelumnya `columns(2)` — di HP tetap menumpuk, tapi di
                 * tablet/desktop field jadi sempit & berjejer, kurang nyaman.)
                 */
                Section::make('Detail Pengeluaran')
                    ->schema(self::fieldInti(true))
                    ->columns(1)
                    ->columnSpanFull(),

                Section::make('Bukti Pengeluaran')
                    ->description('Jumlah file bebas — nota, kuitansi, transfer, foto.')
                    ->schema([
                        FileUpload::make('bukti')
                            ->label('File Bukti')
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->disk('nota')
                            ->directory('uang_keluar')
                            ->acceptedFileTypes(self::TIPE_FILE)
                            ->maxSize(self::MAKS_UKURAN_KB)
                            // Kompres gambar otomatis (lihat PenyimpanBerkas).
                            ->saveUploadedFileUsing(fn ($file): ?string => app(PenyimpanBerkas::class)->simpanKe(
                                $file,
                                'uang_keluar',
                                'nota',
                            ))
                            ->helperText('JPG, PNG, WEBP, atau PDF. Maks '.round(self::MAKS_UKURAN_KB / 1024).' MB. Gambar dikecilkan otomatis.')
                            // Disk nota PRIVAT: URL bawaan Filament (/storage/...)
                            // TIDAK boleh dipakai — berkas hanya boleh dibaca lewat
                            // rute ber-otentikasi. Tanpa ini, pratinjau di form
                            // menunjuk ke /storage yang sudah ditutup (403).
                            ->fetchFileInformation(false)
                            ->tap(fn ($field) => self::pratinjauPrivat($field))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Bentuk 2 — beberapa pengeluaran sekaligus (halaman Tambah).
     */
    public static function configureSekaligus(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('1. Unggah Berkas Nota')
                    ->description('Unggah berkas nota, lalu isi jumlah nota di dalamnya. Baris rincian dibuat otomatis.')
                    ->schema([
                        // Peta path berkas -> daftar potongan hasil OCR.
                        //
                        // Disimpan di tingkat FORM (bukan di dalam item repeater)
                        // supaya tidak terhapus oleh re-entrancy afterStateUpdated.
                        Hidden::make('potongan_ocr'),

                        // Peta path berkas -> jumlah nota hasil OCR.
                        //
                        // Terpisah dari `berkas_nota.*.jumlah_nota` karena saat
                        // OCR selesai, Livewire belum menyimpan set terbaru —
                        // jadi state di dalam repeater masih LAMA.
                        Hidden::make('jumlah_nota_ocr'),

                        // Peta path berkas -> DRAF isi tiap nota hasil OCR
                        // (nominal, tanggal, penerima, kategori, keterangan).
                        // Dipakai mengisi baris rincian otomatis; admin bisa ubah.
                        Hidden::make('isi_nota_ocr'),

                        self::repeaterBerkas(),
                    ])
                    ->columnSpanFull(),

                Section::make('2. Isi Rincian')
                    ->description('Nota tampil di kiri, isi angkanya di kanan. Baris kosong tidak tersimpan.')
                    ->schema([
                        /*
                         * PROGRES + RINGKASAN di ATAS daftar baris.
                         *
                         * Ditaruh paling atas supaya admin langsung tahu status
                         * pengisian sebelum mulai mengetik — dan tidak kaget saat
                         * menyimpan ada baris yang belum lengkap.
                         */
                        Placeholder::make('progres_pengisian')
                            ->hiddenLabel()
                            ->content(fn (Get $get) => view('filament.components.progres-pengisian', [
                                'pengeluaran' => $get('pengeluaran'),
                            ]))
                            ->columnSpanFull(),

                        Repeater::make('pengeluaran')
                            ->hiddenLabel()
                            ->schema(self::fieldPengeluaran())
                            // 5 kolom: bukti ambil 2, form ambil 3 (rasio 2:3).
                            // Di layar sempit menumpuk jadi 1 kolom.
                            ->columns(['default' => 1, 'lg' => 5])
                            ->defaultItems(1)
                            ->minItems(1)
                            ->maxItems(self::MAKS_BARIS)
                            // Label baris = PENANDA ASAL BERKAS + nominal.
                            //
                            // Permintaan user: "bisa diberi pembeda untuk setiap
                            // bukti atau nota karna anda hanya buat pengeluaran 1
                            // sampai selanjutnya itu bergabung dengan nota yang
                            // lain jadi admin tidak ada navigasi yang jelas untuk
                            // membedakanya".
                            //
                            // Jadi label menyebut: BERKAS ke-berapa, NOTA
                            // ke-berapa di dalam berkas itu, plus nama berkasnya.
                            // Contoh: "Berkas 2/3 · Nota 1/4 — empat.pdf"
                            ->itemLabel(function (mixed $state, int $index): ?string {
                                $s = is_array($state) ? $state : [];

                                $berkasKe = (int) ($s['berkas_ke'] ?? 1);
                                $berkasDari = (int) ($s['berkas_dari'] ?? 1);
                                $notaKe = (int) ($s['nota_ke'] ?? 1);
                                $notaDari = (int) ($s['nota_dari'] ?? 1);
                                $nama = blank($s['sumber'] ?? null) ? null : basename((string) $s['sumber']);

                                $label = $berkasDari > 1
                                    ? "Berkas {$berkasKe}/{$berkasDari}"
                                    : 'Berkas 1';

                                /*
                                 * Mode total: berkas ini berisi BANYAK nota yang
                                 * dicatat sebagai satu total. Label harus
                                 * menjelaskannya, bukan menulis "Nota 1" yang
                                 * membingungkan (seolah cuma ada 1 nota).
                                 */
                                if (($s['mode'] ?? '') === 'total') {
                                    $label .= $notaDari > 1
                                        ? " · TOTAL dari {$notaDari} nota"
                                        : ' · Total';
                                } else {
                                    $label .= $notaDari > 1
                                        ? " · Nota {$notaKe}/{$notaDari}"
                                        : ' · Nota 1';
                                }

                                if ($nama !== null) {
                                    $label .= ' — '.$nama;
                                }

                                // Nominal ikut ditampilkan supaya admin tahu
                                // baris mana yang sudah terisi.
                                if (filled($s['jumlah'] ?? null)) {
                                    $label .= ' · Rp '.number_format((float) $s['jumlah'], 0, ',', '.');
                                }

                                return $label;
                            })
                            /*
                             * TIDAK ada tambah/hapus manual.
                             *
                             * Baris disusun otomatis oleh `susunBaris()` dari
                             * jumlah nota tiap berkas. Menambah baris manual
                             * justru bisa membuat baris tanpa nota — sumber
                             * kebingungan yang sudah dihindari desain ini.
                             * Untuk menambah baris: ubah "Jumlah nota" di atas.
                             */
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
