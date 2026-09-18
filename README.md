# SIAKAD SPK — Sistem Informasi SPK & Kontrol Keuangan
## PT Barelang Kontraktor Sarana

Sistem web internal untuk mengelola **SPK**, **uang masuk**, dan **uang keluar**,
serta memantau laba-rugi per SPK.

> **Stack:** Laravel 13 · PHP 8.3+ · MySQL/MariaDB · Blade · Tailwind CSS
> **Dokumentasi lengkap:** folder [`docs/`](docs/)

---

## 1. Fitur yang Sudah Jadi

| Modul | Status |
|---|---|
| **Database (5 tabel)** | ✅ `pengguna`, `mitra`, `spk`, `uang_masuk`, `uang_keluar` |
| **PHP Enum** | ✅ `Peran`, `StatusSpk`, `StatusTagihan`, `KategoriPengeluaran`, `KategoriMitra` |
| **Model Eloquent + relasi** | ✅ 5 model, relasi lengkap, soft delete |
| **Kolom turunan** | ✅ Laba-rugi, piutang, total penerimaan/biaya per SPK |
| **Auto-hitung retensi 5%** | ✅ Otomatis saat SPK disimpan |
| **Seeder data contoh** | ✅ Akun, mitra, SPK, transaksi |
| **Unit & Feature test** | ✅ 34 test, 86 assertion — semua lulus |
| Autentikasi & middleware role | ⏳ Belum |
| CRUD (form & tabel) | ⏳ Belum |
| Dashboard & laporan | ⏳ Belum |

---

## 2. Prasyarat

- PHP 8.3 atau lebih baru
- Composer 2
- MySQL atau MariaDB
- Node.js 20+ (untuk Tailwind CSS)

---

## 3. Setup Database

### 3.1 Konfigurasi `.env`

Database `bks` sudah dibuat lewat DBeaver. Pastikan `.env` berisi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bks
DB_USERNAME=root
DB_PASSWORD=***
```

> ⚠️ **`DB_PASSWORD` tidak boleh kosong.** Kalau dikosongkan padahal user punya
> password, akan muncul error **1698** — bukan 1045.

### 3.2 (Opsional) Pakai user khusus, bukan root

Memakai `root` untuk aplikasi kurang aman. Untuk membuat user khusus,
jalankan [`docs/FIX-MYSQL-USER.sql`](docs/FIX-MYSQL-USER.sql) **sebagai root**:

```bash
sudo mysql < docs/FIX-MYSQL-USER.sql
```

File itu membuat user `bks` + database `bks_test` (untuk PHPUnit).
Kalau memakainya, ubah `.env` jadi `DB_USERNAME=bks`.

### 3.3 Migrasi & seeder

```bash
php artisan config:clear
php artisan migrate --seed
```

Seeder akan membuat:

| Akun | Email | Password | Peran |
|---|---|---|---|
| Admin | `admin@bks.test` | `password` | admin |
| Direktur | `direktur@bks.test` | `password` | direktur |

Plus 4 mitra, 4 SPK, 3 uang masuk, dan 3 uang keluar sebagai contoh.

> ⚠️ **Ganti password ini sebelum dipakai di kantor.**

---

## 4. Menjalankan Aplikasi

```bash
php artisan serve
```

Buka <http://localhost:8000>.

> Untuk pemakaian harian di PC kantor, **jangan** pakai `php artisan serve`.
> Gunakan Apache/Nginx (Laragon/XAMPP). Lihat `docs/Architecture.md` §7.

---

## 5. Menjalankan Test

```bash
php artisan test
```

Test memakai database `bks_test` (diatur di `phpunit.xml`).

Kalau perlu mengubah kredensial test, edit `phpunit.xml` bagian:

```xml
<env name="DB_DATABASE" value="bks_test"/>
<env name="DB_USERNAME" value="bks"/>
<env name="DB_PASSWORD" value=""/>
```

### Formatter kode

```bash
./vendor/bin/pint          # perbaiki otomatis
./vendor/bin/pint --test   # cek saja
```

---

## 6. Struktur Database

Hanya **5 tabel** sesuai `docs/db.txt`:

```
pengguna ──┬──< spk >──┬──< uang_masuk
           │           └──< uang_keluar
mitra ─────┘
```

| Tabel | Fungsi |
|---|---|
| `pengguna` | Akun Admin & Direktur |
| `mitra` | PLN, pelanggan, vendor, subkon |
| `spk` | ⭐ Entitas inti |
| `uang_masuk` | Penerimaan (dari SPK / luar SPK) |
| `uang_keluar` | Pengeluaran (terkait SPK / umum) |

### Aturan penting

1. **Sumber uang masuk disimpulkan dari `spk_id`** — terisi = dari SPK, NULL = luar SPK.
2. **Retensi 5% dihitung otomatis** saat SPK disimpan (`nilai_retensi = nilai_spk × persen_retensi / 100`).
3. **Tidak ada approval** — Admin langsung mencatat transaksi.
4. **Tidak ada entitas PROYEK** — SPK adalah entitas inti.
5. **`status_spk`, `status_tagihan`, `kategori` WAJIB divalidasi dengan PHP Enum.**

> ⚠️ **Aturan #5 tidak boleh dilanggar.** Karena kolomnya berupa teks (schema 5 tabel),
> tanpa validasi Enum laporan akan **terpecah** — misalnya "Material", "Material Bangunan",
> dan "Material2" tercatat sebagai 3 kategori berbeda. Lihat `docs/Schema.md` §7.

---

## 7. Struktur Kode

```
app/
├── Enums/                    # 5 PHP Enum — pengganti tabel master
│   ├── Peran.php
│   ├── StatusSpk.php
│   ├── StatusTagihan.php
│   ├── KategoriPengeluaran.php
│   └── KategoriMitra.php
└── Models/
    ├── Pengguna.php          # auth + peran
    ├── Mitra.php
    ├── Spk.php               # + kolom turunan & auto-retensi
    ├── UangMasuk.php
    └── UangKeluar.php

database/
├── migrations/               # 5 tabel + tabel bawaan Laravel
├── factories/                # 5 factory
└── seeders/DatabaseSeeder.php

tests/Feature/
├── EnumTest.php              # 19 test
└── ModelTest.php             # 15 test
```

---

## 8. Kolom Turunan (Dihitung, Tidak Disimpan)

Semua dihitung *on-the-fly* agar tidak ada data tidak sinkron:

```php
$spk->totalPenerimaan();   // SUM(uang_masuk.jumlah) untuk SPK ini
$spk->totalBiaya();        // SUM(uang_keluar.jumlah) untuk SPK ini
$spk->labaRugi();          // penerimaan - biaya
$spk->piutang();           // nilai_spk - penerimaan
$spk->nilaiBersih();       // nilai_spk - nilai_retensi
```

Contoh hasil dari seeder:

| Nomor SPK | Nilai SPK | Penerimaan | Biaya | Laba/Rugi | Piutang |
|---|---|---|---|---|---|
| SPK-CONTOH-D | 200.000.000 | 120.000.000 | 65.000.000 | **55.000.000** | 80.000.000 |
| SUBKON-001 | 100.000.000 | 45.000.000 | 0 | **45.000.000** | 55.000.000 |

---

## 9. Deployment Lokal (PC Kantor)

Ringkasan dari `docs/Architecture.md` §7:

| Perangkat | Peran |
|---|---|
| **PC Direktur** | Server lokal (Laravel + MySQL) **dan** client Direktur |
| **PC Admin** | Client — akses lewat browser ke IP PC Direktur |

Langkah penting:
1. Set **static IP** untuk PC Direktur
2. Pakai **Apache/Nginx** (Laragon/XAMPP), bukan `php artisan serve`
3. Aktifkan **auto-start service** agar aplikasi hidup sendiri
4. Jadwalkan **backup otomatis** (`mysqldump` + folder `storage/app`)
5. Pasang **UPS** — melindungi PC kerja Direktur sekaligus data keuangan
6. Batasi `innodb_buffer_pool_size` supaya MySQL tidak menghabiskan RAM

---

## 10. Yang Belum Dikerjakan

| # | Item |
|---|---|
| 1 | Autentikasi (login/logout) + middleware role Admin/Direktur |
| 2 | CRUD SPK (form + tabel + filter) |
| 3 | Form uang masuk **2 mode** (berdasarkan SPK / manual) |
| 4 | Form uang keluar + upload bukti (jumlah file bebas) |
| 5 | CRUD mitra |
| 6 | Dashboard (kartu ringkasan + grafik) |
| 7 | Laporan (SPK, cashflow, piutang, laba-rugi per SPK) |
| 8 | Export PDF & Excel |
| 9 | Blade layout + Tailwind |

### Keputusan yang Masih Menggantung

| Hal | Opsi |
|---|---|
| **Dokumen SPK** (scan SPK, BAST, kuitansi, foto) | (a) tambah kolom `dokumen` JSON di `spk` · (b) simpan di luar sistem |
| **Rekening koran** | Format file & perannya |
| **Data lama 2024–2026** | Import dari Excel atau mulai dari nol |
| **Pajak (PPN/PPh)** | Perlu dihitung atau tidak |
| **To-Do List** | Masuk MVP atau tidak |

---

## 11. Dokumentasi Terkait

| File | Isi |
|---|---|
| `docs/PRD.md` | Kebutuhan produk & ruang lingkup |
| `docs/Architecture.md` | Stack & deployment lokal 2 PC |
| `docs/Schema.md` | Struktur database + risiko |
| `docs/Design.md` | UI/UX & daftar halaman |
| `docs/Rules.md` | Aturan bisnis yang wajib dipatuhi |
| `docs/CHANGELOG.md` | Riwayat keputusan & perubahan |
| `docs/db.txt` | ERD asli dari user |
| `docs/FIX-MYSQL-USER.sql` | Perbaikan user MySQL |
| `docs/docs-backup-29agu/` | Dokumentasi versi lama |
