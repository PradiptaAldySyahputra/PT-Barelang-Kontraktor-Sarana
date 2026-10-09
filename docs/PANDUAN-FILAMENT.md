# Panduan Filament — Untuk yang Terbiasa Blade Biasa

> **Untuk siapa:** developer yang sebelumnya coding halaman di `resources/views`
> (Blade manual), kini memakai **Filament 5**.
>
> **Tujuan:** supaya Anda bisa **membaca, mereview, dan mengubah** kode proyek
> BKS ini tanpa bingung — tanpa perlu migrasi ke Blade biasa.
>
> Terakhir diperbarui: 8 Oktober 2026.

---

## 1. Konsep inti: Filament itu "deklarasi", bukan "tulis HTML"

**Dulu (Blade biasa):**
```
Route → Controller → view .blade.php  (Anda tulis HTML + loop + form sendiri)
```

**Sekarang (Filament):**
```
Resource.php  →  Schemas/ (FORM)  +  Tables/ (TABEL)  +  Pages/ (LOGIKA)
                 Anda DEKLARASIKAN komponen; Filament generate HTML+JS+CSS.
```

Anda **tidak menulis `<input>`**. Anda menulis:

```php
TextInput::make('nama')->label('Nama')->required()
```

Filament yang mengurus HTML, styling, validasi, pesan error, dark mode, mobile.

**Analogi:** Filament itu seperti **rangka rumah jadi**. Anda tunjuk "di sini
jendela, di sini pintu" — tukangnya (Filament) yang bikin. Blade manual = Anda
bikin dari batako satu per satu.

---

## 2. Peta Proyek BKS

Semua UI ada di `app/Filament/`. Pola folder **sama** untuk setiap Resource:

```
app/Filament/
├── Resources/
│   └── <Nama>/                        ← satu modul = satu folder
│       ├── <Nama>Resource.php         ← PINTU MASUK (menu, ikon, hak akses)
│       ├── Schemas/<Nama>Form.php     ← BENTUK FORM (field & validasi)
│       ├── Tables/<Nama>Table.php     ← KOLOM TABEL (daftar data)
│       └── Pages/                     ← HALAMAN
│           ├── List<Nama>.php         ← halaman daftar
│           ├── Create<Nama>.php       ← halaman tambah
│           └── Edit<Nama>.php         ← halaman ubah
├── Pages/                             ← halaman kustom (bukan CRUD)
│   ├── Dashboard.php
│   └── Laporan.php
├── Widgets/                           ← kartu/grafik dashboard
├── Concerns/                          ← "trait" dipakai ulang
├── Actions/                           ← aksi (tombol) kustom
└── Exports/                           ← ekspor CSV/XLSX/PDF
```

### Daftar Resource di proyek ini

| Resource | Grup Menu | Isi |
|:---------|:----------|:----|
| `Spks/SpkResource` | SPK | Data SPK (inti sistem) |
| `Mitras/MitraResource` | Master Data | Mitra (PLN / Subkon) |
| `Penggunas/PenggunaResource` | Master Data | Akun admin & direktur |
| `UangMasuks/UangMasukResource` | Keuangan | Pemasukan |
| `UangKeluars/UangKeluarResource` | Keuangan | Pengeluaran |
| `MonitoringSpk/*` | Laporan | Status SPK, Tagihan, Tagihan Selesai |

### Halaman kustom & widget

- `Pages/Laporan.php` — halaman laporan + ekspor (Blade: `pages/laporan.blade.php`)
- `Pages/Dashboard.php` — dashboard
- `Widgets/` — GrafikArusKas, RingkasanKeuangan, SpkBerjalan, SpkPerStatus, StatusTagihanChart

---

## 3. Cara Review Kode — Langkah demi Langkah

### Langkah 1 — Buka file `*Resource.php` (pintu masuk)

Di situ kelihatan "kartu identitas" modul:

```php
class UangKeluarResource extends Resource
{
    protected static ?string $model = UangKeluar::class;              // model Eloquent
    protected static string|BackedEnum|null $navigationIcon = ...;     // ikon menu
    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan'; // grup menu
    protected static ?string $modelLabel = 'Uang Keluar';              // nama tunggal
    protected static ?int $navigationSort = 12;                        // urutan menu

    public static function form(Schema $schema): Schema   // → Schemas/UangKeluarForm.php
    { return UangKeluarForm::configure($schema); }

    public static function table(Table $table): Table      // → Tables/UangKeluarsTable.php
    { return UangKeluarsTable::configure($table); }

    public static function getPages(): array               // → Pages/*
    {
        return [
            'index'  => ListUangKeluars::route('/'),
            'create' => CreateUangKeluar::route('/create'),
            'edit'   => EditUangKeluar::route('/{record}/edit'),
        ];
    }
}
```

**Baca ini dulu** — dari sini Anda tahu file mana yang harus dibuka berikutnya.

### Langkah 2 — Ikuti `form()` dan `table()`

Keduanya menunjuk ke file di `Schemas/` dan `Tables/`. Itu isi UI-nya.

### Langkah 3 — Baca komponennya seperti kalimat

```php
TextInput::make('jumlah')
    ->label('Jumlah (Rp)')       // label yang tampil
    ->required()                 // wajib diisi
    ->numeric()                  // hanya angka
    ->minValue(0.01)             // nilai minimum
    ->prefix('Rp');              // awalan "Rp"
```

Dibaca: *"Bikin input `jumlah`, label 'Jumlah (Rp)', wajib, angka, min 0.01,
diawali 'Rp'."* — Filament sengaja dirancang mengalir seperti bahasa.

### Langkah 4 — Logika khusus ada di `Pages/`

Operasi standar (simpan, ubah, hapus) **sudah otomatis**. Yang ditulis manual
hanya logika khas proyek, mis. di `CreateUangKeluar.php`:

- `mutateFormDataBeforeCreate()` — olah data sebelum simpan
- `beforeCreate()` — validasi khusus / tolak kalau ada baris belum lengkap
- `handleRecordCreation()` — cara menyimpan (di sini: banyak baris sekaligus)

---

## 4. Kamus Komponen Filament (yang dipakai proyek ini)

### Field Form (`Schemas/`)

| Kode | Artinya | Sama dengan HTML |
|:-----|:--------|:-----------------|
| `TextInput::make('x')` | input teks | `<input type="text">` |
| `Textarea::make('x')` | teks panjang | `<textarea>` |
| `Select::make('x')->options([...])` | dropdown | `<select>` |
| `Radio::make('x')->options([...])` | pilihan radio | `<input type="radio">` |
| `DatePicker::make('x')` | pilih tanggal | `<input type="date">` |
| `FileUpload::make('x')` | unggah berkas | `<input type="file">` |
| `Toggle::make('x')` | saklar on/off | `<input type="checkbox">` |
| `Hidden::make('x')` | data tersembunyi | `<input type="hidden">` |
| `Placeholder::make('x')->content(...)` | teks/tampilan statis | `<div>` |

### Susunan (`Layout`)

| Kode | Artinya |
|:-----|:--------|
| `Section::make('Judul')->schema([...])` | kelompok field berjudul |
| `Group::make([...])->columns(2)` | kelompok tanpa judul |
| `Repeater::make('x')->schema([...])` | field berulang (banyak baris) |
| `->columns(2)` | bagi jadi 2 kolom |
| `->columnSpanFull()` | lebar penuh |

### Kolom Tabel (`Tables/`)

| Kode | Artinya |
|:-----|:--------|
| `TextColumn::make('x')` | kolom teks |
| `IconColumn::make('x')->boolean()` | kolom ✓/✗ |
| `BadgeColumn::make('x')` | kolom label berwarna |
| `->searchable()` | bisa dicari |
| `->sortable()` | bisa diurutkan |
| `->summarize(...)` | baris total di bawah |
| `->formatStateUsing(fn ($state) => ...)` | ubah tampilan nilai |

### Modifier yang sering muncul

| Kode | Artinya |
|:-----|:--------|
| `->required()` | wajib diisi |
| `->label('...')` | ganti label |
| `->helperText('...')` | teks bantuan kecil di bawah field |
| `->default(...)` | nilai awal |
| `->live()` | kirim ke server saat berubah (tanpa tekan Simpan) |
| `->rules([...])` | aturan validasi |
| `->visible(fn () => ...)` | sembunyikan/tampilkan bersyarat |
| `->disabled()` | matikan input |
| `->maxLength(200)` | batas panjang |

---

## 5. Di Mana Blade-nya? (yang Anda sudah familiar)

Blade **tetap dipakai** — tapi hanya untuk bagian yang benar-benar kustom.
Ini file Blade proyek ini:

```
resources/views/filament/
├── components/                          ← potongan kecil (dipakai di form/tabel)
│   ├── penanda-berkas.blade.php         ← label "Berkas 1 · Nota 2/4"
│   ├── progres-pengisian.blade.php      ← baris progres pengisian
│   ├── info-ocr.blade.php               ← pesan hasil OCR
│   ├── pratinjau-nota.blade.php         ← pratinjau gambar nota
│   └── daftar-bukti.blade.php           ← daftar berkas bukti
├── pages/
│   ├── laporan.blade.php                ← halaman Laporan (kustom penuh)
│   ├── laporan-pdf.blade.php            ← template PDF laporan
│   └── partials/ekspor-laporan.blade.php
├── exports/tabel-pdf.blade.php          ← template PDF tabel
└── sidebar-toggle.blade.php             ← tombol buka/tutup sidebar
```

**Cara Blade dipanggil dari kode Filament** — lewat `->content()`:

```php
Placeholder::make('progres_pengisian')
    ->content(fn (Get $get) => view('filament.components.progres-pengisian', [
        'pengeluaran' => $get('pengeluaran'),
    ]));
```

Artinya: "tampilkan isi Blade `progres-pengisian`, kirim data `pengeluaran` ke
dalamnya." Ini jembatan antara Filament (PHP) dan Blade (HTML) Anda.

---

## 6. Cara Mengubah Sesuatu — Resep Cepat

| Ingin mengubah... | Buka file... |
|:------------------|:-------------|
| Nama menu / ikon / grup | `<Nama>Resource.php` |
| Field di form | `Schemas/<Nama>Form.php` |
| Urutan field | susun ulang di `Schemas/<Nama>Form.php` |
| Kolom di tabel daftar | `Tables/<Nama>Table.php` |
| Aturan wajib/tidak field | `->required()` di field terkait |
| Teks label | `->label('...')` di field terkait |
| Logika saat Simpan | `Pages/Create<Nama>.php` |
| Logika saat Ubah | `Pages/Edit<Nama>.php` |
| Tampilan halaman Laporan | `resources/views/filament/pages/laporan.blade.php` |
| Hak akses (siapa boleh apa) | `canCreate()` / `canEdit()` di `Resource.php` |
| Warna & gaya | `resources/css/filament/admin/theme.css` |

### Contoh nyata: menambah field "Catatan" di form Uang Keluar

1. Buka `app/Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php`
2. Cari `fieldInti()` (kumpulan field yang dipakai ulang)
3. Tambahkan sebelum `Textarea::make('keterangan')`:

```php
TextInput::make('catatan')
    ->label('Catatan')
    ->maxLength(200),
```

4. Pastikan kolom `catatan` ada di tabel database (migration).
5. Tambahkan `'catatan'` ke `$fillable` di `app/Models/UangKeluar.php`.
6. Jalankan tes: `php artisan test --filter=UangKeluar`

---

## 7. Hak Akses (Admin vs Direktur)

Tidak ditulis di controller seperti Blade biasa. Dipasang di `Resource.php`:

```php
public static function canCreate(): bool
{
    return auth()->user()?->bolehInput() ?? false;   // hanya Admin
}
```

Dan trait `app/Filament/Concerns/BolehUbahData.php` dipakai ulang di banyak
Resource supaya aturannya hidup di **satu tempat** saja.

---

## 8. Cara Mengetes Perubahan

Proyek ini punya **616 tes**. Setelah mengubah apa pun:

```bash
# Tes semua (paling aman)
php artisan test

# Tes satu modul saja (lebih cepat)
php artisan test --filter=UangKeluar

# Rapikan gaya kode otomatis
./vendor/bin/pint
```

⚠️ **Penting:** 46 dari 72 file tes bergantung pada Filament/Livewire. Kalau
mengubah form/tabel, jalankan **seluruh** suite — bukan hanya tes yang Anda
kira terdampak.

---

## 9. Kenapa Tidak Migrasi ke Blade Biasa?

Pertanyaan yang wajar. Jawaban singkat: **Blade biasa = lebih banyak kode, bukan
lebih sedikit.**

| | Filament (sekarang) | Blade manual |
|:--|:--------------------|:-------------|
| 5 CRUD lengkap | 62 file | 90–120 file |
| Yang ditulis manual | hampir tidak ada | tabel, form, validasi, filter, hak akses, ekspor, JS |
| Tes | sudah ada 616 | 46 file tes harus ditulis ulang |

Filament **menghemat** kode. Ganti ke Blade = aplikasi jadi sama saja, tapi
lebih sulit dirawat dan berisiko menghidupkan lagi bug yang sudah diperbaiki.

---

## 10. Rujukan

- Dokumentasi resmi Filament 5: https://filamentphp.com/docs/5.x
- `docs/Architecture.md` — struktur teknis proyek
- `docs/Design.md` — panduan UI/UX
- `AGENTS.md` — aturan keras proyek

---

*Dokumen ini dibuat untuk membantu review kode. Kalau ada bagian yang masih
membingungkan, tanyakan saja — akan ditambahkan ke sini.*
