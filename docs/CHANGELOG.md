# CHANGELOG — Dokumentasi Proyek
## Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana

---

## [4.0] — Tema Clean Minimalist Enterprise (Vercel/Linear) — 19 September 2026

### Permintaan User

> *"Bertindaklah sebagai Senior UI/UX Designer... tema Clean Minimalist Enterprise /
> Modern SaaS (Gaya Vercel & Linear style)... monokrom netral, border tipis, tanpa
> gradasi/shadow berlebihan, font sistem, tombol minimalis... **kalau tidak sesuai
> kembalikan lagi desainnya**"*

### 🛡️ TITIK ROLLBACK (dibuat SEBELUM perubahan)

Sesuai permintaan *"kalau tidak sesuai kembalikan lagi"*, dibuat tag Git lebih dulu:

```bash
git tag sebelum-redesign-v1   # = commit e082cef
```

Cara mengembalikan:

| Perintah | Efek |
|---|---|
| `git checkout sebelum-redesign-v1` | Lihat versi lama (read-only, aman) |
| `git revert 1df98b9` | Batalkan tema ini, buat commit baru (aman) |
| `git reset --hard sebelum-redesign-v1` | Hapus semua setelahnya (**hati-hati**) |

---

### Cara Tema Dipasang

```bash
php artisan make:filament-theme admin
```

Perintah ini membuat `resources/css/filament/admin/theme.css` dan **otomatis**
mendaftarkan `->viteTheme('resources/css/filament/admin/theme.css')` di
`AdminPanelProvider`. Lalu `npm run build`.

---

### Prinsip Desain yang Diterapkan

| # | Prinsip | Penerapan |
|---|---|---|
| 1 | **Monokrom netral** | `primary` & `gray` = `Color::Zinc` (**bukan biru lagi**) |
| 2 | **Tipografi font sistem** | `system-ui, -apple-system, Segoe UI, Roboto…` |
| 3 | **Border tipis** | `1px #e4e4e7` sebagai pembatas, bukan shadow |
| 4 | **Shadow minimal** | 8 aturan `box-shadow:none!important` di komponen utama |
| 5 | **Tint lembut** | Header tabel `#fafafa`, sidebar aktif `#f4f4f5` |
| 6 | **Tombol minimalis** | Utama hampir hitam `#18181b`, sekunder putih + border tipis |

**Palet:**

| Peran | Warna |
|---|---|
| Latar | `#fafafa` |
| Kartu/panel | `#ffffff` |
| Border | `#e4e4e7` |
| Teks utama | `#18181b` |
| Teks sekunder | `#71717a` |
| Tombol utama | `#18181b` → hover `#09090b` |

### 14 Komponen Ditata

Tipografi · Warna · Latar · Sidebar · Topbar · Section/kartu · Tombol · Input ·
Tabel · Badge · Dropdown & modal · Stat widget · Header halaman · Pagination & tabs

Mode gelap juga didukung untuk semua komponen.

---

### ⚠️ Titik Rawan yang Ditemukan

**1. Urutan CSS menentukan kemenangan.**
Filament menaruh CSS variable-nya di `<style>` **inline** dalam `<head>`.
File tema dimuat lewat `<link>` yang posisinya **lebih akhir** → aturan tema menang.

> Diverifikasi: `<style>` inline di posisi 434, `<link theme>` di posisi ~4000.
> Test `test_tema_dimuat_setelah_css_inline_filament()` menjaga urutan ini.

**2. Filament memaksa font Inter.**
Filament mendefinisikan `--font-sans: var(--font-family)` di mana
`--font-family: 'Inter Variable'`. Override saya di `:root` diletakkan **setelah**
definisi Filament sehingga menang, plus `font-family: var(--font-sans) !important`
untuk mengunci.

**3. Warna biru tidak cukup dihapus lewat CSS.**
Lebih kokoh mengubahnya di **level PHP** (`Color::Zinc`) daripada menimpa
`--primary-*` lewat CSS. Dua lapis: PHP + CSS.

---

### Verifikasi

| Uji | Hasil |
|---|---|
| Tema terdaftar di panel | ✅ `resources/css/filament/admin/theme.css` |
| File tema dimuat di halaman | ✅ `theme-R2cOj57n.css` |
| Tema dimuat **setelah** CSS inline | ✅ (posisi 434 < 4000) |
| Warna biru default | ✅ **0 kemunculan** |
| `--primary-600` | ✅ `oklch(0.442 0.017 285.786)` (Zinc) |
| Font sistem | ✅ `system-ui, -apple-system` + `!important` |
| Shadow dihapus | ✅ 8 aturan `box-shadow:none!important` |
| 14 komponen ditata | ✅ Semua ada di CSS |
| 9 halaman utama | ✅ HTTP 200 semua |

**184 test, 515 assertion — semua lulus.** Pint (PSR-12) lolos.

> Test regresi: `tests/Feature/TemaTest.php` (11 test).

---

### 🔴 BATASAN PENTING

**Saya tidak bisa melihat gambar.** Verifikasi saya bersifat **struktural**:
CSS variable, urutan pemuatan, kelas komponen, warna dalam file CSS.

**Saya TIDAK bisa menilai apakah tampilannya enak dilihat.** Penilaian estetika
harus dari user. Kalau ada yang janggal, sebutkan **bagian mana** dan
**apa yang salah** (mis. "tombol terlalu gelap", "jarak antar section terlalu
lebar") — deskripsi konkret sangat membantu.

---

### Git

```
1df98b9 feat: tema Clean Minimalist Enterprise (Vercel/Linear style)
e082cef docs: catat v3.9 (perbaikan navbar, panel 500, laporan responsif)
cea5f04 fix: rapikan navbar, panel, dan halaman laporan agar responsif
6b042b4 docs: catat v3.8 (hapus SIAKAD, sidebar collapsible, UI diperbaiki)
077122f feat: hapus nama SIAKAD, sidebar bisa ditutup, perbaiki UI dashboard & laporan
2b003d8 docs: catat v3.7 (perbaikan /login 404 + pelajaran rute)
6980e16 fix: /login 404 - tambah pengalihan rute lama ke Filament
4162348 docs: catat v3.6 (halaman laporan + ekspor CSV)
9e5b59b feat: halaman Laporan + ekspor CSV
3b438c3 docs: catat v3.5 (antarmuka tunggal Filament) + perbarui README
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

---

## [3.9] — Perbaikan Navbar & Tata Letak Laporan — 19 September 2026

### 🐞 Masalah yang Dilaporkan User

> *"masih kurang, ui/ux berantakan apa lagi pada bagian laporan, itu navbar diatas
> kenapa cuman bks dan tidak rapi, panel berantakan dan tidak responsif"*

Tiga keluhan: **navbar cuma "BKS"**, **panel berantakan**, **laporan tidak responsif**.

---

### 1. Navbar "cuma BKS" — akar masalah ditemukan

**Penyebab:** saya memakai `brandLogo()` berisi **view HTML**. Di Filament 5, jika
`brandLogo` diisi, komponen logo **HANYA merender gambar itu** dan
**nama brand disembunyikan**:

```blade
{{-- vendor/filament/.../logo.blade.php --}}
@if ($logo instanceof Htmlable)
    <div>{{ $logo }}</div>          {{-- nama brand TIDAK dirender --}}
@elseif (filled($logo))
    <img src="{{ $logo }}" />       {{-- nama brand TIDAK dirender --}}
@else
    <div>{{ $brandName }}</div>     {{-- hanya di sini nama brand muncul --}}
@endif
```

Ditambah `brandLogoHeight('2.25rem')` yang **memotong kotak logo** → navbar tampak
rusak: hanya kotak "BKS" tanpa keterangan.

**Perbaikan:** hapus `brandLogo()`, `brandLogoHeight()`, dan view `brand-logo.blade.php`.
Cukup `brandName('Barelang Kontraktor Sarana')` → nama brand tampil rapi dan responsif.

> 💡 Kalau nanti ada file logo asli (PNG/SVG), **boleh** pakai
> `->brandLogo(asset('images/logo.svg'))` — tapi sadari nama brand akan hilang.

---

### 2. Bug: Dashboard & Laporan ERROR 500

**Penyebab:** saya menambahkan `databaseNotifications()` yang membutuhkan tabel
`notifications` yang **belum ada**:

```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'bks.notifications' doesn't exist
```

Fitur ini **tidak diminta** — saya menambahkannya sendiri. Sudah dihapus.

> ⚠️ Bug ini membuat **seluruh panel error 500**. Ketangkap karena verifikasi
> memeriksa **HTTP status halaman**, bukan hanya menguji widget satu per satu.

---

### 3. Halaman Laporan Ditata Ulang

| Sebelum | Sesudah |
|---|---|
| Toolbar tidak responsif | Menumpuk di HP, sejajar di layar lebar (`sm:flex-row`) |
| Kartu ringkasan kaku | **1 kolom (HP) → 2 (tablet) → 4 (desktop)** |
| Tabel meluber di HP | Setiap tabel punya **versi kartu** untuk layar kecil (`md:hidden` + `md:block`) |
| Angka tidak sejajar | Rata kanan + `tabular-nums` |
| Selisih/laba tanpa tanda | Tanda **+ / −** |
| Jumlah transaksi teks polos | **Badge** berwarna |
| Section tanpa ikon | Setiap section **berikon** |
| Tabel kosong bila tanpa data | **Empty state** yang rapi |
| 4 section terbuka semua | Bisa dilipat; 2 tertutup default |

---

### 4. Ekspor Dipindah ke Route Biasa

**Alasan:** halaman `Page` kustom **tidak punya** `getHeaderActions()`, dan route
biasa lebih andal untuk mengunduh file.

| Sebelum | Sesudah |
|---|---|
| `wire:click="ekspor('spk')"` (aksi Livewire) | `GET /admin/laporan/ekspor/{jenis}` |

Pengamanan:
- Jenis tidak dikenal → **404**
- Belum login → redirect **`/admin/login`**

### 5. Tamu Diarahkan Langsung ke Login Filament

| Sebelum | Sesudah |
|---|---|
| `/admin/laporan/ekspor/spk` → `/login` → `/admin/login` (**2 hop**) | → `/admin/login` (**1 hop**) |

### 6. Panel Memakai Lebar Penuh

Ditambahkan `maxContentWidth('full')`.

---

### Verifikasi

| Uji | Hasil |
|---|---|
| `/admin` | ✅ HTTP 200 (sebelumnya 500) |
| `/admin/laporan` | ✅ HTTP 200 (sebelumnya 500) |
| Brand di `.fi-logo` | ✅ "Barelang Kontraktor Sarana" tampil |
| Logo gambar custom | ✅ Tidak dipakai (nama brand tidak hilang) |
| Tombol toggle sidebar | ✅ Ada |
| Kelas responsif | ✅ `grid-cols-1`, `sm:grid-cols-2`, `xl:grid-cols-4`, `sm:flex-row`, `md:block`, `md:hidden` |
| Ikon di 4 section | ✅ Semua ada |
| Ekspor 5 jenis via route | ✅ HTTP 200, `text/csv` |
| Jenis ekspor ngawur | ✅ 404 |
| Ekspor tanpa login | ✅ redirect `/admin/login` |

**173 test, 484 assertion — semua lulus.** Pint (PSR-12) lolos.

> Test regresi: `tests/Feature/TampilanPanelTest.php` (22 test).

---

### 🔴 PELAJARAN PENTING

1. **Jangan pakai `brandLogo()` kalau nama brand mau tetap tampil** — Filament akan
   menyembunyikannya dan navbar terlihat rusak.
2. **Selalu periksa HTTP status halaman utuh.** Menguji widget satu per satu dengan
   `Livewire::test()` semuanya lulus, tetapi halaman tetap error 500 karena
   konfigurasi panel (mis. `databaseNotifications()` tanpa tabel).
3. **Jangan menambah fitur yang tidak diminta** (`databaseNotifications()`) —
   fitur itu membutuhkan migration yang belum ada dan menjatuhkan seluruh panel.
4. **`Livewire::test()->html()` tidak memuat seluruh markup halaman.** Untuk menguji
   kelas responsif, pakai HTTP penuh (`$this->get(...)`).
5. **Test dengan database kosong tidak merender tabel** — yang muncul `empty-state`.
   Perlu data untuk menguji markup tabel.

---

### Git

```
cea5f04 fix: rapikan navbar, panel, dan halaman laporan agar responsif
6b042b4 docs: catat v3.8 (hapus SIAKAD, sidebar collapsible, UI diperbaiki)
077122f feat: hapus nama SIAKAD, sidebar bisa ditutup, perbaiki UI dashboard & laporan
2b003d8 docs: catat v3.7 (perbaikan /login 404 + pelajaran rute)
6980e16 fix: /login 404 - tambah pengalihan rute lama ke Filament
4162348 docs: catat v3.6 (halaman laporan + ekspor CSV)
9e5b59b feat: halaman Laporan + ekspor CSV
3b438c3 docs: catat v3.5 (antarmuka tunggal Filament) + perbarui README
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

---

## [3.8] — Perbaikan Tampilan & Nama Aplikasi — 19 September 2026

### 1. Nama "SIAKAD" Dihapus

**Masalah yang dilaporkan user:** *"kenapa ada siakad?"*

**Penyebab:** "SIAKAD" adalah **sisa dari proyek sebelumnya** (SIAKAD SDN 004 Teluk
Dalam) yang terbawa saat saya menamai aplikasi ini. Tidak relevan untuk
PT Barelang Kontraktor Sarana — **kelalaian saya**.

Dihapus dari:

| File | Sebelum | Sesudah |
|---|---|---|
| `AdminPanelProvider.php` | brandName `SIAKAD SPK — ...` | `PT Barelang Kontraktor Sarana` |
| `.env` | `APP_NAME="SIAKAD SPK"` | `APP_NAME="SPK & Kontrol Keuangan"` |
| `.env.testing`, `.env.testing.example` | idem | idem |
| `README.md` | judul `SIAKAD SPK — ...` | `Sistem Informasi SPK & Kontrol Keuangan` |

Ditambahkan **logo inisial "BKS"** di panel.

### 2. Sidebar Bisa Ditutup / Dibuka

Sebelumnya sidebar hanya menyusut jadi ikon. Sekarang:

| Pengaturan | Efek |
|---|---|
| `sidebarFullyCollapsibleOnDesktop()` | Sidebar bisa **ditutup total** lalu dibuka kembali |
| `collapsibleNavigationGroups(true)` | Grup menu bisa dilipat satu per satu |
| `sidebarWidth('16rem')` | Lebar normal |
| `collapsedSidebarWidth('4.5rem')` | Lebar saat menyusut |

### 3. Dashboard Diperbaiki

| Sebelum | Sesudah |
|---|---|
| Dashboard bawaan Filament (polos) | **Dashboard kustom** dengan alur informasi |
| Kartu hanya menampilkan angka | Kartu memberi **konteks**: perbandingan bulan lalu + sparkline tren 6 bulan |
| Tidak ada grafik status | **Donut** SPK per status |
| Tidak ada grafik kategori | **Bar horizontal** pengeluaran per kategori |
| Urutan widget acak | Kartu → grafik → tabel (mengalir) |

### 4. Laporan Diperbaiki

| Sebelum | Sesudah |
|---|---|
| **5 tombol ekspor berjajar** (berantakan) | **1 dropdown** "Ekspor CSV" |
| Filter periode tombol polos | **Segmented control** |
| Semua bagian terbuka (panjang) | Bagian bisa **dilipat**; 2 bagian tertutup default |
| Angka tidak sejajar | Rata kanan + `tabular-nums` (mudah dibandingkan) |
| Selisih/laba tanpa tanda | Diberi tanda **+ / −** |
| Jumlah transaksi teks polos | **Badge** berwarna |

### 5. 🔴 Bug Ditemukan & Diperbaiki

**Dashboard error 500** — *"Undefined variable $attributes"*.

**Penyebab:** `resources/views/filament/brand-logo.blade.php` saya tulis seperti
**Blade component** (memakai `$attributes`), padahal dipanggil lewat `view()`
sebagai **view biasa**. Variabel `$attributes` hanya ada di dalam component.

**Perbaikan:** hapus penggunaan `$attributes`.

> ⚠️ **Bug ini ketangkap karena verifikasi memeriksa HTTP status halaman
> sungguhan.** Saat saya menguji widget satu per satu dengan `Livewire::test()`,
> semuanya **lulus** — bug baru muncul di halaman utuh. Pelajaran: selalu uji
> halaman lengkap, bukan hanya komponennya.

### Verifikasi

| Uji | Hasil |
|---|---|
| `/admin` | ✅ HTTP 200 (sebelumnya 500) |
| `/admin/laporan` | ✅ HTTP 200 |
| "SIAKAD" di HTML | ✅ Tidak ada |
| Brand perusahaan | ✅ Tampil |
| Logo "BKS" | ✅ Tampil |
| Tombol toggle sidebar | ✅ Ada (`fi-topbar-collapse-sidebar-btn-ctn`) |
| Grup navigasi bisa dilipat | ✅ Ada (`fi-sidebar-group-collapse-btn`) |
| Dropdown ekspor | ✅ Ada (`fi-dropdown`) |
| Section collapsible | ✅ Ada (`fi-collapsible`) |

**164 test, 448 assertion — semua lulus.** Pint (PSR-12) lolos.

> Test regresi: `tests/Feature/TampilanPanelTest.php` (13 test).

### Git

```
077122f feat: hapus nama SIAKAD, sidebar bisa ditutup, perbaiki UI dashboard & laporan
2b003d8 docs: catat v3.7 (perbaikan /login 404 + pelajaran rute)
6980e16 fix: /login 404 - tambah pengalihan rute lama ke Filament
4162348 docs: catat v3.6 (halaman laporan + ekspor CSV)
9e5b59b feat: halaman Laporan + ekspor CSV
3b438c3 docs: catat v3.5 (antarmuka tunggal Filament) + perbarui README
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

---

## [3.7] — Perbaikan: /login 404 — 19 September 2026

### 🐞 Masalah yang Dilaporkan User

> *"halaman login tidak bisa diakses notfound, bagian apa yang belum anda lakukan?"*

**Jawaban: pengalihan rute lama belum dibuat.**

### Penyebab

Di **v3.5** halaman Blade lama dihapus dan login dipindah ke `/admin/login`.
Namun rute **`/login` tidak disisakan pengalihannya** — jadi membuka `/login`
menghasilkan **404**, padahal sebelumnya di situ ada halaman login.

> Ini **kelalaian saya**: saat menghapus rute lama, seharusnya sekaligus
> menyediakan pengalihan agar bookmark/link lama tidak mati.

### Perbaikan — Pengalihan Rute Lama

| URL lama | Dialihkan ke |
|---|---|
| `/login` | `/admin/login` |
| `/dashboard` | `/admin` |
| `/home` | `/admin` |
| `/admin/dashboard` | `/admin` |

URL yang **benar-benar** tidak ada **tetap 404** — pengalihan tidak menelan semua URL.

### Verifikasi

| URL | Hasil |
|---|---|
| `/` | ✅ 302 → `/admin` |
| **`/login`** | ✅ 302 → `/admin/login` **(sebelumnya 404)** |
| `/dashboard` | ✅ 302 → `/admin` |
| `/home` | ✅ 302 → `/admin` |
| `/admin/login` | ✅ 200 |
| `/halaman-ngawur` | ✅ 404 (benar) |

**151 test, 411 assertion — semua lulus.** Pint (PSR-12) lolos.

> Test regresi: `tests/Feature/PengalihanRuteTest.php` (10 test).

### 🔴 PELAJARAN PENTING

**Saat menghapus/memindahkan rute, SELALU sisakan pengalihan (redirect).**
Menghapus rute tanpa pengalihan akan mematikan bookmark, tautan yang sudah
dibagikan, dan kebiasaan pengguna mengetik URL — dan menghasilkan 404 yang
membingungkan.

### Git

```
6980e16 fix: /login 404 - tambah pengalihan rute lama ke Filament
4162348 docs: catat v3.6 (halaman laporan + ekspor CSV)
9e5b59b feat: halaman Laporan + ekspor CSV
3b438c3 docs: catat v3.5 (antarmuka tunggal Filament) + perbarui README
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

---

## [3.6] — Halaman Laporan — 19 September 2026

### Halaman Laporan (`/admin/laporan`)

| Bagian | Isi |
|---|---|
| **Ringkasan** | Uang masuk · uang keluar · saldo bersih · total piutang |
| **Arus Kas per Bulan** | Masuk, keluar, selisih, jumlah transaksi per bulan |
| **Pengeluaran per Kategori** | Total + bar proporsi per kategori |
| **Laba-Rugi per SPK** | Nilai SPK · penerimaan · biaya · **laba/rugi** · piutang |
| **Piutang SPK** | SPK belum lunas + status tagihan |

**Filter periode:** Bulan Ini · 3 Bulan · 12 Bulan · Semua.

### Ekspor CSV (5 jenis)

Ekspor SPK · Arus Kas · Kategori · Laba-Rugi · Piutang.

**Keputusan teknis:** memakai **CSV**, bukan PDF/Excel, karena:
- Bisa dibuka langsung di **Excel** — aplikasi yang selama ini dipakai perusahaan
- Tidak perlu paket tambahan (ringan)
- Pemisah titik-koma (`;`) + **BOM UTF-8** agar Excel membaca karakter dengan benar

> Isi CSV memakai **label Enum** (mis. "Material"), bukan nilai mentah ("material"),
> agar mudah dibaca saat dibuka di Excel.

**Hak akses:** Admin **dan** Direktur boleh melihat serta mengekspor laporan.
Sesuai `Rules.md` §4 — Direktur hanya melihat, tapi laporan justru untuk dia.

### 2 Bug Ditemukan & Diperbaiki

| # | Bug | Penyebab | Perbaikan |
|---|---|---|---|
| 1 | Halaman laporan **error 500** — *"Object of class KategoriPengeluaran could not be converted to string"* | Kolom `kategori` **sudah di-cast ke Enum** oleh model, sehingga `KategoriPengeluaran::tryFrom((string) $x)` gagal | Pemeriksaan `instanceof` di view |
| 2 | Ekspor CSV kategori ikut error yang sama | Sama — nilai Enum di-`fputcsv` langsung | Diperbaiki di **sumbernya** (method `ekspor()`), bukan hanya di view |

> Pelajaran: ketika sebuah kolom sudah di-cast ke Enum, ia **bukan** string lagi.
> Jangan di-cast ulang ke string — periksa dengan `instanceof`.

### Testing

**141 test, 386 assertion — semua lulus.** Pint (PSR-12) lolos.

### Git

```
9e5b59b feat: halaman Laporan + ekspor CSV
3b438c3 docs: catat v3.5 (antarmuka tunggal Filament) + perbarui README
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

### Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | Perbarui `Architecture.md` & `Design.md` agar konsisten dengan Filament |
| 2 | Impor data lama 2024–2026 dari Excel `file-Excel-perusahaan.xlsx` |
| 3 | Deployment lokal 2 PC (static IP, auto-start, backup, UPS) |

---

## [3.5] — Antarmuka Tunggal Filament — 19 September 2026

### 🐞 Masalah yang Dilaporkan User

> *"kenapa tampilan masih yang sebelumnya belum filament?"*

**Penyebab:** rute `/` mengarah ke `/dashboard` (halaman **Blade lama**), bukan ke `/admin`
(panel Filament). Jadi meskipun Filament sudah terpasang, pengguna tetap disajikan
tampilan Blade buatan v3.2.

### Perbaikan

| Sebelum | Sesudah |
|---|---|
| `/` → `/dashboard` (Blade) | `/` → **`/admin`** (Filament) |
| Login Blade di `/login` | Login **Filament** di `/admin/login` |
| Dashboard Blade di `/dashboard` | Dashboard **Filament** di `/admin` |

**File yang DIHAPUS** (halaman Blade lama):

- `resources/views/dashboard.blade.php`
- `resources/views/auth/login.blade.php`
- `resources/views/layouts/app.blade.php`
- `app/Http/Controllers/DashboardController.php`
- `app/Http/Controllers/Auth/LoginController.php`

`routes/web.php` kini hanya berisi satu rute: `/` → `/admin`.

> Middleware `peran` tetap tersedia untuk halaman Filament kustom di masa depan,
> tetapi CRUD standar sudah dibatasi lewat `canCreate/canEdit/canDelete`
> + trait `BolehUbahData` (lihat v3.4).

### Dashboard Widget Baru

| Widget | Isi |
|---|---|
| **RingkasanKeuangan** | 6 kartu stat: nilai SPK · uang masuk · uang keluar · saldo bersih · piutang SPK · uang masuk luar SPK |
| **GrafikArusKas** | Grafik batang arus kas 6 bulan terakhir (masuk vs keluar) |
| **SpkBerjalan** | Tabel SPK berjalan + penerimaan, biaya, **laba/rugi**, piutang per SPK |

> 📌 **Catatan teknis:** widget Filament dirender **lazy** via Livewire, jadi isinya
> **tidak ada** di HTML awal `/admin`. Karena itu pengujian dilakukan dengan
> `Livewire::test()` — bukan memeriksa HTML halaman. Ini sempat membuat saya salah
> menduga widget tidak tampil saat verifikasi pertama.

### Verifikasi

| Uji | Hasil |
|---|---|
| `/` | ✅ HTTP 302 → `/admin` |
| `/admin` tanpa login | ✅ HTTP 302 → `/admin/login` |
| `/admin/login` | ✅ HTTP 200, memakai kelas Filament (`fi-`, `wire:submit="authenticate"`) |
| Kartu ringkasan | ✅ Semua 6 stat tampil, angka benar |
| Grafik arus kas | ✅ Tampil dengan canvas |
| Tabel SPK berjalan | ✅ Data & kolom laba/rugi tampil |
| Angka dashboard | ✅ SPK 677.311.922 · masuk 170 jt · keluar 68 jt · saldo 102 jt · piutang 512.311.922 |

**124 test, 347 assertion — semua lulus.** Pint (PSR-12) lolos.

### Git

```
715c46e feat: dashboard Filament + hapus halaman Blade lama
aa69e59 docs: catat 4 resource selesai + bug tombol Direktur (v3.4)
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

### Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | Laporan (SPK, cashflow, piutang, laba-rugi per SPK) + export PDF/Excel |
| 2 | Perbarui `Architecture.md` & `Design.md` agar konsisten dengan Filament |

---

## [3.4] — Semua Resource Selesai — 19 September 2026

### Yang Sudah Jadi

| Resource | Form | Tabel | Tab | Catatan |
|---|---|---|---|---|
| **SPK** | ✅ | ✅ | ✅ | Entitas inti |
| **Mitra** | ✅ | ✅ | ✅ | PLN, pelanggan, subkon, vendor |
| **Uang Masuk** | ✅ **2 mode** | ✅ | ✅ | Dari SPK / Luar SPK |
| **Uang Keluar** | ✅ | ✅ | ✅ | Terkait SPK / Umum |
| **Pengguna** | ✅ | ✅ | — | Hanya Admin |

### Form Uang Masuk — 2 Mode (permintaan user)

| Mode | Cara Kerja | `spk_id` |
|---|---|---|
| **Berdasarkan SPK** | Pilih SPK → nomor SPK & nama pekerjaan **terisi otomatis** | Terisi |
| **Manual / Luar SPK** | Isi nomor referensi & keterangan manual | **NULL** |

> Sumber uang masuk **tidak disimpan sebagai kolom** — disimpulkan dari `spk_id`.
> Ini sesuai `Schema.md` dan mencegah data tidak sinkron.

### Upload Bukti

Semua transaksi mendukung **jumlah file bebas** (JSON array):
bukti transfer + nota + screenshot sekaligus. Format JPG/PNG/WEBP/PDF, maks 10 MB/file.

### 🔴 BUG PENTING YANG DITEMUKAN

**Direktur tetap melihat tombol Tambah / Edit / Hapus.**

**Penyebab:** Filament **hanya** memakai `Resource::canCreate()` / `canEdit()` / `canDelete()`
untuk menolak akses halaman (`abort 403`). Filament **tidak** otomatis menyembunyikan tombolnya.

**Dampak:** Aman dari kebocoran data (klik tombol → 403), tetapi:
- Menyesatkan Direktur — tombol terlihat padahal tidak bisa dipakai
- Tidak sesuai semangat `Rules.md` §4

**Perbaikan:** Trait `App\Filament\Concerns\BolehUbahData` + `->visible()` pada
**semua** `CreateAction`, `EditAction`, `DeleteAction`, dan `BulkActionGroup` di 5 resource.

**Verifikasi (render HTML sungguhan):**

| | Link `create` | Link `edit` | Halaman create |
|---|---|---|---|
| **Direktur** | **0** ✅ | **0** ✅ | 403 ✅ |
| **Admin** | 1 | 12–44 | 200 ✅ |

> Dua lapis sekarang bekerja: tombol disembunyikan (UI) **dan** akses ditolak (otorisasi).
> Test regresi: `tests/Feature/TombolAksiTest.php` (23 test).

### Testing

**121 test, 349 assertion — semua lulus.** Pint (PSR-12) lolos.

### Git

```
89e7e2c feat: lengkapi Resource Mitra, Uang Masuk, Uang Keluar, Pengguna
53d4ed2 docs: catat keputusan Filament + 2 bug yang diperbaiki (v3.3)
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

### Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | Dashboard widget Filament (kartu ringkasan + grafik arus kas) |
| 2 | Laporan (SPK, cashflow, piutang, laba-rugi per SPK) + export PDF/Excel |
| 3 | Perbarui `Architecture.md` & `Design.md` agar konsisten dengan Filament |
| 4 | Hapus halaman Blade lama (`/dashboard`) atau arahkan ke Filament |

---

## [3.3] — Filament Dipakai — 19 September 2026

### ⚠️ Keputusan yang Menyimpang dari SRS

| Aspek | SRS (`docs/Architecture.md`) | Implementasi |
|---|---|---|
| Frontend admin | **Blade Template** | **Filament 5.8.2** |

**Alasan penyimpangan** (keputusan user):
1. Proyek memiliki 5 modul CRUD — Blade memakan **3–4 minggu**, Filament **1–2 minggu**.
2. Filament menyediakan tabel (search/filter/sort/paginate), form, validasi, dan upload file
   secara bawaan — menghemat banyak waktu pada target 4 bulan.
3. Model, migration, dan Enum yang sudah dibangun **tetap terpakai** — Filament bekerja di
   atas Eloquent yang sama, jadi tidak ada pekerjaan yang terbuang.

**Yang perlu diperbarui di SRS:** bagian `Architecture.md` §2 baris *Frontend* dan
`Design.md` §3 (struktur navigasi sidebar).

> 📌 **Catatan:** halaman **login** dan **dashboard Blade** yang dibuat di v3.2 tetap ada,
> tetapi panel admin sekarang diakses lewat `/admin` (Filament).

### Yang Sudah Jadi

| Komponen | Isi |
|---|---|
| **Panel Filament** | `/admin`, warna primary biru, brand PT Barelang Kontraktor Sarana |
| **Resource SPK** | ⭐ Lengkap: form, tabel, filter, tab, pencarian, soft delete |
| **Hak akses** | Admin = CRUD penuh; **Direktur = hanya lihat** |
| **Resource lain** | Mitra, UangMasuk, UangKeluar, Pengguna — baru ter-generate, isi menyusul |

### Detail Resource SPK

**Form:** nomor SPK (unik), tanggal SPK, tanggal akhir, nama pekerjaan, lokasi, mitra,
nilai SPK (format rupiah otomatis), persen retensi, nilai retensi (read-only),
status SPK (dropdown Enum), status tagihan (dropdown Enum), jenis sumber, sheet lama.

**Tabel:** nomor SPK (bisa di-copy), pekerjaan + lokasi, mitra, tanggal, nilai SPK,
retensi, penerimaan, biaya, **laba/rugi** (hijau/merah otomatis), status SPK (badge),
status tagihan (badge).

**Filter:** status SPK, status tagihan, mitra, jenis sumber, data terhapus.

**Tab:** Semua · Berjalan · Belum Lunas · Tanpa SPK (masing-masing dengan badge jumlah).

### 🔒 Pembuktian Hak Akses (Rules.md §4)

| Uji | Hasil |
|---|---|
| Direktur buka `/admin/spks` (daftar) | ✅ Boleh (200) |
| Direktur buka `/admin/spks/create` | ✅ **DITOLAK 403** |
| Tombol "Tambah SPK" untuk Direktur | ✅ Tidak tampil |
| Admin buka `/admin/spks/create` | ✅ Boleh (200) |

> Ini membuktikan pembatasan dilakukan di **level otorisasi**, bukan sekadar
> menyembunyikan menu — sesuai tuntutan Rules.md §4.

### 2 Bug Ditemukan & Diperbaiki

| # | Bug | Penyebab | Perbaikan |
|---|---|---|---|
| 1 | Dashboard Filament **error 500** | Filament mencari atribut `name`, sedangkan tabel `pengguna` memakai kolom `nama` → `getUserName()` mengembalikan null | Implementasikan kontrak `HasName` + `getFilamentName()` |
| 2 | Data provider test gagal | PHPUnit 12 memakai atribut `#[DataProvider]`, anotasi `@dataProvider` sudah tidak didukung | Ganti ke atribut |

> ⚠️ **Bug #1 akan muncul di produksi** saat Direktur/Admin membuka dashboard.
> Ketangkap karena diuji dengan render halaman sungguhan, bukan hanya unit test.

### Git

```
4aa6215 feat: install Filament 5 + Resource SPK
47eb7be docs: catat progres implementasi v3.2
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

### Testing

**78 test, 193 assertion — semua lulus.** Pint (PSR-12) lolos.

### Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | Isi Resource **Mitra** (form + tabel) |
| 2 | Isi Resource **Uang Masuk** — form **2 mode** (berdasarkan SPK / manual) |
| 3 | Isi Resource **Uang Keluar** + upload bukti (jumlah file bebas) |
| 4 | Isi Resource **Pengguna** |
| 5 | Dashboard widget Filament (kartu ringkasan + grafik) |
| 6 | Laporan + export PDF/Excel |
| 7 | Perbarui `Architecture.md` & `Design.md` agar konsisten dengan Filament |

---

## [3.2] — Implementasi Dimulai — 19 September 2026

Kode Laravel mulai dibangun. Dokumentasi di folder `docs/` tidak diubah pada tahap ini.

### Keputusan Teknis

| Aspek | Keputusan |
|---|---|
| Database | **MySQL** — database `bks` |
| Framework | **Full Laravel** (Laravel 13.32.0) |
| Frontend | **Blade + Tailwind CSS v4** (sesuai SRS) — **belum** Filament |
| Jumlah tabel | **5** sesuai `db.txt` |
| Status & kategori | **PHP Enum + dropdown** (bukan tabel master) |
| Audit log | ❌ Tidak dipakai (keputusan user) |

> 📌 **Filament belum dipasang.** SRS menetapkan Blade Template. Jika nanti ingin
> pindah ke Filament, model/migration/Enum yang sudah ada **tetap terpakai** —
> Filament bekerja di atas Eloquent yang sama.

### Yang Sudah Jadi

| Komponen | Isi |
|---|---|
| **Migration** | 5 tabel: `pengguna`, `mitra`, `spk`, `uang_masuk`, `uang_keluar` |
| **PHP Enum** | `Peran`, `StatusSpk`, `StatusTagihan`, `KategoriPengeluaran`, `KategoriMitra` |
| **Model** | 5 model + relasi + soft delete + cast Enum |
| **Kolom turunan** | `totalPenerimaan()`, `totalBiaya()`, `labaRugi()`, `piutang()`, `nilaiBersih()` |
| **Auto-retensi 5%** | Dihitung otomatis di hook `saving` model `Spk` |
| **Seeder** | 2 akun, 4 mitra, 4 SPK, 3 uang masuk, 3 uang keluar |
| **Autentikasi** | Login/logout + rate limiting 5x/menit |
| **Middleware peran** | `peran:admin` — request tanpa hak ditolak **403** |
| **Dashboard** | Kartu ringkasan, grafik arus kas 6 bulan, SPK per status, laba-rugi per SPK |
| **Tampilan** | Layout Blade + sidebar (menu menyesuaikan peran) + halaman login |
| **Testing** | **53 test, 133 assertion** — semua lulus |
| **Formatter** | Pint (PSR-12) lolos |

### 2 Bug yang Ditemukan & Diperbaiki Saat Pengujian

| # | Bug | Penyebab | Perbaikan |
|---|---|---|---|
| 1 | `nilai_retensi` salah (22.692.087,90 padahal seharusnya 5.000.000) | Factory menghitung dari nilai random, lalu seeder menimpa `nilai_spk` tanpa menimpa retensi | Retensi dihitung otomatis di hook `saving` model `Spk` |
| 2 | `UangMasuk::dariSpk()` error "Non-static method cannot be called statically" | Nama scope `scopeDariSpk` bertabrakan dengan method instance `dariSpk()` | Method instance dinamai `isDariSpk()` |

### 🔒 Perbaikan Keamanan

**Password MySQL sempat tertulis di `phpunit.xml`**, dan file itu **tidak di-gitignore** —
artinya akan ter-push ke GitHub publik.

Perbaikan:
- Kredensial test dipindah ke **`.env.testing`** (masuk `.gitignore`)
- `phpunit.xml` dibuat bersih, hanya berisi konfigurasi non-sensitif
- Ditambahkan `.env.testing.example` sebagai template

> ⚠️ **Jika repo sudah pernah ter-push dengan password di dalamnya**, ganti password
> MySQL dan bersihkan riwayat Git (`git filter-repo`).

### Hasil Verifikasi

| Uji | Hasil |
|---|---|
| Migrasi + seeder ke MySQL | ✅ 5 tabel, data contoh masuk |
| `php artisan test` | ✅ 53 lulus, 133 assertion |
| `pint --test` | ✅ lolos |
| `npm run build` | ✅ Tailwind 60 KB ter-build |
| Login Admin via HTTP | ✅ HTTP 302 → dashboard |
| Login Direktur via HTTP | ✅ berhasil |
| Dashboard tanpa login | ✅ redirect ke `/login` |
| Password salah | ✅ ditolak, tetap tamu |
| Logout | ✅ kembali ke login |
| Angka dashboard | ✅ SPK 677.311.922 · masuk 170 jt · keluar 68 jt · saldo 102 jt · piutang 512.311.922 |

### Akun Seeder

| Email | Password | Peran |
|---|---|---|
| `admin@bks.test` | `password` | Admin |
| `direktur@bks.test` | `password` | Direktur |

> ⚠️ **Ganti password ini sebelum dipakai di kantor.**

### Git

Repository sudah diinisialisasi dengan 2 commit:

```
bb0a500 feat: autentikasi, middleware peran, dan dashboard
494f9c2 feat: fondasi database + model SPK & kontrol keuangan
```

### Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | CRUD SPK (form + tabel + filter + board status) |
| 2 | Form uang masuk **2 mode** (berdasarkan SPK / manual) |
| 3 | Form uang keluar + upload bukti (jumlah file bebas) |
| 4 | CRUD mitra |
| 5 | Laporan (SPK, cashflow, piutang, laba-rugi per SPK) |
| 6 | Export PDF & Excel |

---

## [3.1] — 19 September 2026

**4 keputusan tambahan dari user.**

### Keputusan User

| # | Pertanyaan | Keputusan | Dampak |
|---|---|---|---|
| 1 | Kolom `keterangan` di SPK? | **"tidak perlu"** | Kolom `keterangan` **dihapus** dari tabel `spk` |
| 2 | Audit log? | **"tidak perlu"** | Audit log **dihapus**. Menyimpang dari SRS NFR-SEC-004 |
| 3 | Jumlah file bukti? | **"bebas"** | Kolom `bukti` = JSON array, jumlah file **tidak dibatasi** |
| 4 | Deployment? | **"lokal run pc, pcnya bisa dipake juga"** | Lokal dikonfirmasi; PC Direktur **boleh dipakai kerja lain** |

### ⚠️ Konsekuensi yang Dicatat

**1. `keterangan` dihapus dari `spk`**
Catatan follow-up dari Excel **tidak punya tempat di sistem**:
`27/7/2026 sudah diantar ke imperium`, `ada denda`, `PAKAI PT BKS`,
`di potong 120.000 (uang material)`.
Bisa ditambahkan kembali nanti dengan 1 migration.

**2. Audit log dihapus — menyimpang dari SRS**
SRS **NFR-SEC-004** mewajibkan *"setiap perubahan nominal & upload dokumen harus tercatat"*.
Konsekuensi: tidak ada jejak siapa mengubah nominal; sulit menelusuri kalau ada selisih.
NFR-SEC-004 di `PRD.md` sudah ditandai **DIHAPUS**.

**3. PC Direktur dipakai kerja lain**
Risiko diterima. Mitigasi wajib ditambahkan di `Architecture.md` §7.2:
auto-start service · batasi `innodb_buffer_pool_size` · backup di luar jam kerja ·
monitoring kapasitas · UPS.

### Hasil Uji Schema v3.1 (MariaDB 11.8)

| Uji | Hasil |
|---|---|
| DDL dijalankan | ✅ 5 tabel, 5 FK, 3 CHECK — **nol error** |
| Kolom `keterangan` di `spk` | ✅ **Tidak ada** (terkonfirmasi via `SHOW COLUMNS`) |
| Bukti 1 file | ✅ |
| Bukti 3 file | ✅ |
| Bukti 5 file | ✅ |
| Bukti NULL (tanpa file) | ✅ |
| Retensi 5% & laba-rugi per SPK | ✅ benar |

### File yang Diperbarui

| File | Perubahan |
|---|---|
| `docs/Schema.md` | v3.1 — `keterangan` dihapus, audit log dihapus, bukti bebas |
| `docs/PRD.md` | NFR-SEC-004 ditandai DIHAPUS; baris audit log dihapus |
| `docs/Architecture.md` | Audit log dihapus; §7.2 mitigasi PC dipakai kerja lain |
| `docs/Design.md` | Form SPK tanpa Keterangan; bukti jumlah bebas |
| `docs/Rules.md` | §10 audit log DIHAPUS; keputusan #14 diperbarui |
| `docs-backup-29agu/Schema-v3.0.md` | 🆕 Versi 3.0 disimpan |

### ⏳ Sisa 1 Keputusan

| Hal | Opsi |
|---|---|
| **Dokumen SPK** (scan SPK, BAST, BAAP, kuitansi, foto) | (a) tambah kolom `dokumen` JSON di `spk` — tetap 5 tabel · (b) simpan di luar sistem |

---

## [3.0] — 19 September 2026

**Schema disederhanakan ke 5 tabel** sesuai `db.txt`, atas permintaan user.

### Keputusan User

> *"kalau saya menggunakan hanya 5 tabel tersebut apa resikonya, karna user saya maunya
> seperti itu dan db yang saya gunakan mysql ya dan full laravel saja semuanya, nanti
> kedepannya baru pivot kelain"*

| Aspek | Keputusan |
|---|---|
| Jumlah tabel | **5 tabel** — ikuti `db.txt` |
| Database | **MySQL** |
| Framework | **Full Laravel** |
| Pivot ke 10 tabel | Nanti, kalau diperlukan |
| Mitigasi risiko | **PHP Enum + dropdown** (bukan tabel master) |

### Perubahan Besar

| Aspek | v2.2 (10 tabel) | v3.0 (5 tabel) |
|---|---|---|
| Jumlah tabel | 10 | **5** |
| Nama tabel | Inggris (`users`, `spks`, `cash_ins`) | **Indonesia** (`pengguna`, `spk`, `uang_masuk`) |
| Nama kolom | Inggris | **Indonesia** |
| Status & kategori | Tabel master + FK | **Kolom teks + PHP Enum** |
| Audit log | Tabel `audit_logs` | **`spatie/laravel-activitylog`** |
| Sesuai `db.txt` | Tidak | **Ya** |
| Sesuai `Rules.md` §4 (nama Indonesia) | ❌ Tidak | **✅ Ya** |

> ⚠️ **Koreksi pelanggaran aturan:** versi 10 tabel memakai nama tabel/kolom **bahasa Inggris**,
> padahal `Rules.md` §4 v1.0 sudah menetapkan *"Nama tabel database menggunakan `snake_case`
> berbahasa Indonesia... jangan diterjemahkan ke bahasa Inggris"*. Ini dilanggar sejak v2.0
> dan **diperbaiki di v3.0**.

### Bukti Risiko 5 Tabel (Diuji di MariaDB 11.8)

Data identik dimasukkan ke dua skema untuk laporan "Pengeluaran per Kategori":

| Kategori yang diketik | Jumlah |
|---|---|
| Material | 40.000.000 |
| Material Bangunan | 15.000.000 |
| Material2 *(typo)* | 5.000.000 |
| Upah | 25.000.000 |
| Upah Tukang | 10.000.000 |
| Operasional | 3.000.000 |

**Hasil skema kolom teks (5 tabel):** **6 baris** — Material terpecah 3, Upah terpecah 2. **Salah.**
**Hasil skema master + FK (10 tabel):** **3 baris** — Material 60 jt, Upah 35 jt. **Benar.**

**Mitigasi:** PHP Enum + dropdown → Admin tidak bisa mengetik bebas → typo mustahil.
Detail di `Schema.md` §8.

### Hasil Uji Schema 5 Tabel

| Uji | Hasil |
|---|---|
| DDL dijalankan ke MariaDB 11.8 | ✅ 5 tabel, 5 FK, 3 CHECK — **nol error** |
| Retensi 5% (100 jt) | ✅ retensi 5 jt, nilai bersih 95 jt |
| Sumber uang masuk (dari `spk_id`) | ✅ Dari SPK 120 jt · Luar SPK 5 jt |
| Saldo bersih | ✅ 125 jt − 68 jt = 57 jt |
| Laba-rugi & piutang per SPK | ✅ laba 55 jt, piutang 80 jt |
| Pengeluaran per kategori | ✅ material 40 jt · upah 25 jt · operasional 3 jt |
| Bukti multi-file (JSON) | ✅ 1 transaksi = 2 file |
| `jumlah = 0` | ✅ Ditolak (CHECK) |
| `jumlah` negatif | ✅ Ditolak (CHECK) |
| `nomor_spk` duplikat | ✅ Ditolak (UNIQUE) |
| FK `spk_id` tidak valid | ✅ Ditolak (FK) |

### File yang Diperbarui

| File | Perubahan |
|---|---|
| `docs/Schema.md` | **Ditulis ulang** — 5 tabel, nama Indonesia, DDL, risiko, jalur pivot |
| `docs/PRD.md` | Modul Master Data → Data Mitra + Enum; Log Aktivitas |
| `docs/Architecture.md` | Struktur modul `app/Enums/`; stack + Enum + activitylog |
| `docs/Design.md` | Sidebar tanpa Master Data; halaman disesuaikan |
| `docs/Rules.md` | Aturan §2 butir 10 (wajib Enum); Log Aktivitas via package |
| `docs-backup-29agu/Schema-v2.2-10tabel.md` | 🆕 Versi 10 tabel disimpan sebagai referensi pivot |

### ⚠️ Yang Masih Perlu Keputusan

| No | Hal | Pilihan |
|---|---|---|
| 1 | **Kolom `keterangan` pada `spk`** | `db.txt` hapus vs SRS wajibkan — **saya pertahankan sementara** |
| 2 | **Audit log** | (a) tabel `log_aktivitas` = 6 tabel · (b) package `spatie` = tetap 5 tabel · (c) tidak ada |
| 3 | **Dokumen SPK** (BAST, kuitansi, scan) | (a) kolom `dokumen` JSON di `spk` · (b) simpan di luar sistem |
| 4 | **Jumlah file bukti** | Satu file atau banyak file (sekarang JSON array) |
| 5 | **Deployment** | Lokal / cloud / hybrid |

---

## [2.2] — 19 September 2026

**Klarifikasi ketertelusuran tabel.** User bertanya mengapa schema berisi 10 tabel
sedangkan `db.txt` hanya memuat 6 (setelah revisi → 5).

### Jawaban

`db.txt` memang hanya punya **6 tabel**:

| # | Tabel di `db.txt` |
|---|---|
| 1 | `pengguna` |
| 2 | `mitra` |
| 3 | `spk` |
| 4 | `uang_masuk` |
| 5 | `uang_keluar` |
| 6 | `bukti` *(dihapus sesuai revisi user → jadi 5)* |

Schema final berisi **10 tabel** = **5 dari `db.txt`** + **5 tambahan dari desain 3NF SRS**.

### ⚠️ Kesalahan Proses yang Dicatat

5 tabel tambahan (`roles`, `spk_statuses`, `billing_statuses`, `expense_categories`,
`audit_logs`) **dimasukkan tanpa memberi tahu user terlebih dahulu**. Seharusnya ditanyakan
lebih dulu. Hal ini sudah dikoreksi dengan menambahkan **§3.1 Ketertelusuran Tabel** pada
`docs/Schema.md`, yang mencatat asal-usul setiap tabel secara terbuka.

### Keputusan User

User memilih **Opsi B: pertahankan 10 tabel** (`db.txt` + master 3NF dari SRS).
Alasan: sesuai SRS §3.0.5 yang menyatakan desain semi-normalized hanya cocok untuk prototipe,
bukan sistem jangka panjang.

### Perubahan

| File | Perubahan |
|---|---|
| `docs/Schema.md` | v2.2 — tambah §3.1 Ketertelusuran Tabel (`db.txt` vs tambahan) + konsekuensi pilihan |

---

## [2.1] — 19 September 2026

**Keputusan user diterapkan.** Dokumentasi disusun ulang sesuai 6 keputusan final.

### ✅ 6 Keputusan yang Diterapkan

| # | Pertanyaan | Keputusan User | Aksi di Dokumen |
|---|---|---|---|
| 1 | Entitas PROYEK? | **"gunakan SPK saja"** | Tabel `projects` **dihapus**. SPK jadi entitas inti. Modul Manajemen Proyek dihapus dari PRD & Design |
| 2 | Pengajuan Dana & Approval? | **"tidak menggunakan pengajuan dana dan approval"** | Tabel `cash_requests` **dihapus**. Modul + semua referensi approval dihapus |
| 3 | Uang keluar → `spk_id`? | **"tambahkan saja kalau memang wajib"** | **Dipertahankan** (nullable) — wajib agar laba-rugi per SPK bisa dihitung |
| 4 | Approval Direktur di uang keluar? | **"hapus, tidak ada approval dari Direktur"** | Field `disetujui_oleh` & `tanggal_persetujuan` **dihapus**. Tidak ada alur approval sama sekali |
| 5 | SPK subkon? | **"jadikan tabel spk"** | Tabel `subcon_spks` **dilebur** ke `spks`. Kolom retensi ditambahkan ke `spks` |
| 6 | Tabel bukti? | *"atribut bukti itu cuma ada pada uang masuk dan keluar"* | Tabel `attachments` + `attachment_types` **dihapus**. Bukti jadi kolom `bukti` (JSON) di `cash_ins` & `cash_outs` |

### 📉 Penyederhanaan Schema: 14 → 10 Tabel

**Dihapus (7 tabel):**

| Tabel | Alasan |
|---|---|
| `projects` | Keputusan #1 |
| `subcon_spks` | Keputusan #5 |
| `cash_requests` | Keputusan #2 |
| `attachments` | Keputusan #6 |
| `attachment_types` | Ikut `attachments` |
| `income_sources` | Tidak perlu — sumber disimpulkan dari `spk_id` |
| `payment_methods` | Revisi `db.txt`: `metode_pembayaran` tidak digunakan |

**Ditambah (3 tabel):**

| Tabel | Alasan |
|---|---|
| `spk_statuses` | Normalisasi 3NF |
| `billing_statuses` | Normalisasi 3NF |
| `expense_categories` | Normalisasi 3NF |

**Schema final — 10 tabel:**
`roles` · `users` · `partners` · `spk_statuses` · `billing_statuses` · `expense_categories` ·
`spks` · `cash_ins` · `cash_outs` · `audit_logs`

### 📄 File yang Diperbarui

| File | Perubahan |
|---|---|
| `docs/Schema.md` | v2.1 — 10 tabel, DDL lengkap, tanpa approval/proyek/attachments |
| `docs/PRD.md` | v2.1 — modul approval & proyek dihapus, alur tanpa approval |
| `docs/Architecture.md` | v2.1 — alur data tanpa approval, struktur modul disesuaikan |
| `docs/Design.md` | v2.1 — menu Proyek/Approval/Bukti dihapus, form uang masuk 2 mode |
| `docs/Rules.md` | v2.1 — aturan bisnis tanpa approval, status kanonis dikunci |

### ⚠️ 4 Hal yang MASIH Perlu Konfirmasi

| No | Hal | Pertanyaan |
|---|---|---|
| 1 | **Kolom `keterangan` pada SPK** | `db.txt` bilang tidak digunakan, tetapi SRS bilang wajib ada dan setiap baris Excel punya catatan follow-up (`ada denda`, `PAKAI PT BKS`). **Hapus atau pertahankan?** Saya pertahankan sementara di dokumen. |
| 2 | **Upload dokumen SPK** | Tabel bukti dihapus & bukti hanya di uang masuk/keluar → dokumen SPK (BAST, kuitansi, scan SPK) **tidak punya tempat**. Tambahkan kolom `dokumen` (JSON) pada `spks`? |
| 3 | **Format bukti** | Satu file per transaksi, atau banyak file? (Saat ini dirancang JSON array = banyak file) |
| 4 | **Pilihan deployment** | Lokal / cloud / hybrid — dokumen sumber SRS masih tidak konsisten |

### 📋 Hal Lain yang Belum Dikunci

- Data keuangan final dari Admin (belum diterima)
- Rekening koran: format & peran
- Data lama 2024–2026: import atau mulai dari nol
- Pajak (PPN/PPh): perlu dihitung atau tidak
- To-Do List sistem: masuk MVP atau tidak

---

## [2.0] — 19 September 2026

**Revisi besar pertama.** Sumber:
1. `Project Hub Pengembangan Sistem SPK & Kontrol Keuangan` (PDF, 41 halaman — SRS + WBS + laporan)
2. `db.txt` (ERD konseptual + revisi dari user)
3. Analisis `file-Excel-perusahaan.xlsx` (sistem manual yang dimodernisasi)

### 🔴 Perubahan Besar dari v1.0

| No | Sebelum (v1.0) | Sesudah (v2.0) |
|---|---|---|
| 1 | Hosting **VPS DigitalOcean/Niagahoster** | **Deployment lokal: PC Direktur = server, PC Admin = client** |
| 2 | Sistem keuangan umum | **Berbasis SPK** + normalisasi **3NF** |
| 3 | 3 role (Admin, Staf Keuangan, Pengawas Lapangan) | **2 role (Admin, Direktur)** |
| 4 | Frontend: Vue/React via Inertia | **Blade Template** |
| 5 | Website publik + PWA + peta Leaflet | **Dihapus** — sistem murni internal |
| 6 | Target 20–30 pengguna | **< 10 pengguna** |
| 7 | Tidak menyebut jaringan lokal | **BAB deployment lokal lengkap** |
| 8 | Tidak ada retensi | **Retensi 5%** pada SPK subkon/vendor |

---

## [1.0] — 29 Agustus 2026

Versi awal dokumentasi: PRD, Architecture, Design, Rules, Schema untuk *"Sistem Informasi
Keuangan Internal PT Barelang Kontraktor Sarana"* — masih generik, belum berbasis SPK, dan
belum memuat rencana deployment lokal.

**Tersimpan di `docs-backup-29agu/`** (tidak dihapus).

---

## 🧹 Catatan Kualitas Data (sebelum migrasi)

| Masalah | Jumlah | Aksi |
|---|---|---|
| Record tanpa nomor SPK | 14 | Lengkapi atau tandai |
| Record tanpa tanggal | 14 | Lengkapi atau tandai |
| Record tanpa dokumen | 91 (semua) | Upload dokumen |
| Nomor SPK duplikat | Ada | Deduplikasi |

**Urutan:** `cleansing` → `deduplikasi` → `rekonsiliasi nilai` → `validasi sampel` →
tetapkan `spk_number` sebagai unique key.
