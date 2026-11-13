# MANUAL BOOK — Sistem Informasi SPK & Kontrol Keuangan

## PT Barelang Kontraktor Sarana

> **Untuk:** Admin (operator harian) & Direktur (Super Admin & pemantau)
> **Versi dokumen:** 2.0 — 9 November 2026
> **Aplikasi:** Laravel 13 + Blade + Livewire 4 (TailAdmin), berjalan **lokal di jaringan kantor**
> **Alamat:** `http://192.168.100.10:8232/panel` (atau `http://127.0.0.1:8232/panel` di PC server)
> **Hak Akses:** **Admin** (input & operasional) dan **Direktur** (Super Admin: full akses input/ubah/hapus + kelola Pengguna)
>
> ⚠️ Manual ini ditulis berdasarkan **kode yang benar-benar berjalan**, bukan
> dari rencana. Setiap menu & tombol yang disebut sudah diverifikasi ada.

---

## 1. Cara Masuk

### 1.1 Alamat aplikasi

| Dari | Alamat |
|:-----|:-------|
| PC server (`bks-server`) | `http://127.0.0.1:8232/panel` |
| PC lain di jaringan kantor | `http://192.168.100.10:8232/panel` |

> 📌 **Sebelum dipakai kantor**, ikuti `docs/Architecture.md` §12 (pemasangan PC
> server) agar aplikasi hidup otomatis saat PC menyala dan alamatnya tidak berubah.

### 1.2 Akun

| Peran | Email | Password awal |
|:------|:------|:--------------|
| **Admin** | `admin@bks.test` | dibuat saat instalasi (`php artisan app:buat-admin`) |
| **Direktur** | `direktur@bks.test` | dibuat saat instalasi (`php artisan app:buat-admin --direktur`) |

> 🔴 **WAJIB diganti sebelum dipakai sungguhan.** Kata sandi dapat diganti mandiri lewat menu
> **Profil Saya**, atau direset oleh Direktur lewat **Master Data → Manajemen Akun**.
>
> 💡 **Staf Lupa Password di Jaringan Intranet (Offline)?**
> Karena sistem intranet kantor tidak terhubung ke internet dan tidak menggunakan layanan email SMTP luar, tidak tersedia tautan *Lupa Password* via email di layar login. Jika staf operasional (Admin) lupa kata sandi, laporkan langsung kepada **Direktur**. Direktur dapat mereset kata sandi staf secara instan melalui menu **Master Data → Manajemen Akun** (lihat panduan di §4.4 atau skenario UAT §2.8).

### 1.3 Apa bedanya Admin dan Direktur

| | Admin | Direktur (Super Admin) |
|:--|:------|:-----------------------|
| Input / Ubah / Hapus SPK | ✅ bisa | ✅ bisa |
| Input / Ubah / Hapus Uang Masuk & Keluar | ✅ bisa | ✅ bisa |
| Unggah & Ekstraksi Nota (OCR) | ✅ bisa | ✅ bisa |
| Kelola Mitra | ✅ bisa | ✅ bisa |
| Kelola Pengguna (Manajemen Akun) | ❌ ditolak (403) | ✅ bisa (khusus direktur) |
| Dashboard, Laporan & Ekspor | ✅ bisa | ✅ bisa |
| Sistem (Status, Backup, Impor) | ✅ bisa | ✅ bisa |

> ⚠️ Admin yang mencoba membuka halaman Manajemen Akun (`/panel/users`) akan **ditolak sistem** (403),
> bukan sekadar tidak melihat menunya.

---

## 2. Peta Menu

```
Dashboard                      — ringkasan keuangan (/panel)
SPK
  ├── List SPK                 — daftar & input SPK
  ├── Kalender Tenggat         — jadwal & tenggat SPK bulanan
  ├── Status SPK               — pantau status pekerjaan
  ├── Tagihan SPK              — pantau status tagihan
  └── Tagihan Selesai SPK      — tagihan yang sudah lunas
Keuangan
  ├── Uang Masuk               — penerimaan & cetak kuitansi PDF
  └── Uang Keluar              — pengeluaran (multi-baris & OCR)
Nota & Bukti
  ├── Unggah & Ekstraksi Nota  — potong & ekstrak nota tumpuk/satuan otomatis
  └── Arsip Nota               — pencarian & unduh ZIP seluruh bukti nota
Laporan                        — laporan + ekspor Excel/PDF/CSV + bundel ZIP
Master Data
  ├── Mitra                    — PLN & Subkon/Vendor
  └── Manajemen Akun           — akun pengguna (khusus Direktur)
Sistem
  ├── Status Sistem            — kesehatan database, queue, OCR, backup, disk
  ├── Backup Database          — buat & unduh cadangan database (.zip)
  └── Impor Data               — impor transaksi dari CSV/XLSX
```

---

## 3. Untuk ADMIN

### 3.1 Mengisi Data Mitra

**Master Data → Mitra → Tambah**

Hanya **2 kategori** (keputusan perusahaan):

| Kategori | Isi |
|:---------|:----|
| **PLN (Pemberi Kerja)** | Yang memberi pekerjaan kepada BKS |
| **Subkon/Vendor** | Yang mengerjakan sebagian pekerjaan BKS |

> 📌 Nomor telepon/kontak **opsional** — boleh dikosongkan.

### 3.2 Membuat SPK Baru

**SPK → List SPK → Tambah**

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Nomor SPK | ✅ | **Tidak boleh duplikat** — sistem menolak |
| Nama Pekerjaan | ✅ | Tulis lengkap, mis. "Pengadaan Material Accessories" |
| Mitra | ✅ | Pilih dari daftar mitra |
| Nilai SPK | ✅ | Angka rupiah |
| Tanggal SPK | — | Boleh kosong untuk SPK lama tanpa tanggal |
| Tanggal Akhir | — | Dipakai untuk **peringatan tenggat** |
| Lokasi | — | |
| Status | ✅ | Draft / Terbit / Berjalan / Selesai / Sudah Ditagihkan / Dibatalkan |
| Status Tagihan | ✅ | Belum Ditagihkan / Sudah Ditagihkan / Revisi Dokumen / Menunggu Pembayaran / Dibayar |
| Pelaksana | ✅ | Dikerjakan Sendiri / Disubkonkan |
| Keterangan Pengantaran | — | Belum Diantar / Sudah Diantar / Diterima |
| Dokumen | — | BAST, scan SPK, kuitansi — **boleh banyak berkas** |

> 💡 **Keterangan Pengantaran** menjawab pertanyaan "SPK ini sudah diantar atau
> belum?" — kolom ini ada di Excel lama Anda, jadi ikut dipindahkan.

> ⚠️ **Tanggal tidak boleh lebih dari hari ini.** Salah ketik tahun (2062
> alih-alih 2026) akan ditolak sistem — supaya transaksi tidak "hilang" dari
> filter bulan.

### 3.3 Mengubah Status SPK

**Tidak diubah dari halaman edit.** Gunakan tombol khusus:

| Yang diubah | Caranya |
|:------------|:--------|
| Status pekerjaan | **SPK → Status SPK** → tombol **Ubah Status** |
| Status tagihan | **SPK → Tagihan SPK** → tombol **Ubah Status** |

> 📌 Dipisah supaya jelas: satu form untuk satu tujuan, tidak tercampur.

### 3.4 Mencatat Uang Masuk

**Keuangan → Uang Masuk → Tambah**

Ada **2 mode**:

**Mode 1 — Dari SPK** (paling sering dipakai)
1. Pilih **Dari SPK**
2. Pilih SPK dari dropdown → nomor & nama pekerjaan terisi otomatis
3. Isi tanggal & jumlah

**Mode 2 — Manual / Luar SPK**
1. Pilih **Manual / Luar SPK**
2. Isi nomor SPK & nama pekerjaan sendiri

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Tanggal Masuk | ✅ | **Tidak boleh lebih dari hari ini** |
| Jumlah | ✅ | Harus > 0 |
| Kas/Bank | — | Kosong = dianggap **Kas** |
| Keterangan | — | |
| Bukti | — | Boleh banyak berkas |

> 🔴 **PENTING:** jumlah uang masuk **tidak boleh melebihi piutang** SPK yang
> dipilih. Kalau SPK nilainya Rp 100 juta dan sudah diterima Rp 60 juta, input
> maksimal Rp 40 juta. Sistem menolak dengan pesan yang menjelaskan batasnya.
>
> Uang masuk **luar SPK** (Mode 2) **tidak dibatasi**.

> 💡 **Status tagihan berubah otomatis** dari pembayaran nyata — tidak perlu
> diubah manual:
> - Piutang habis → **Dibayar**
> - Sudah ada bayar tapi belum lunas → **Menunggu Pembayaran**

### 3.5 Mencatat Uang Keluar

**Keuangan → Uang Keluar → Tambah**

Form ini bisa memuat **beberapa pengeluaran sekaligus** dalam satu halaman.

| Field | Wajib | Catatan |
|:------|:-----:|:--------|
| Tanggal Keluar | ✅ | **Tidak boleh lebih dari hari ini** |
| Jumlah | ✅ | Harus > 0 |
| Kategori | ✅ | Material / Upah / Operasional / Gaji / Nota / Transportasi / Lainnya |
| Kas/Bank | — | Kosong = dianggap **Kas** |
| Penerima | — | Terisi otomatis dari mitra SPK bila dikaitkan ke SPK |
| Kaitkan ke SPK | — | Opsional. Kosongkan untuk biaya kantor |
| Keterangan | — | |

#### Cara cepat mengisi dari foto/PDF nota

1. **Unggah berkas nota** (bisa PDF berisi banyak nota, atau foto)
2. Sistem menghitung **berapa nota** di dalam berkas itu
3. Pilih mode:

| Mode | Untuk | Hasil |
|:-----|:------|:------|
| **Total** (default) | Nota sebulan yang di-merge jadi 1 PDF | 1 baris, isi total saja |
| **Rinci** | Nota satuan/harian | 1 baris per nota |

> ⚠️ **Sistem TIDAK membaca nominal rupiah dari nota.** Nominal tetap diisi
> admin. Alasannya: salah hitung jumlah nota mudah diperbaiki, tapi salah baca
> nominal langsung masuk laporan keuangan. OCR terbukti tidak akurat untuk
> tulisan tangan.

### 3.6 Melihat & Menyaring Data

Semua tabel punya filter. Di **Uang Masuk** dan **Uang Keluar**:

| Filter | Fungsi |
|:-------|:-------|
| Periode | Saring per tahun / bulan / rentang tanggal |
| Kas/Bank | Pisahkan Kas dan Bank |
| Kategori | (Uang Keluar) saring per jenis pengeluaran |
| Mitra | (Uang Masuk) saring per mitra |
| **SPK** | **Saring hanya satu SPK** |
| Data Terhapus | Lihat data yang dihapus (soft delete) |

> 💡 **Filter SPK** berguna saat ada selisih, atau saat bagian pajak meminta
> rincian satu pekerjaan tertentu.

### 3.7 Ekspor Laporan

**Laporan** → pilih tombol ekspor (ada **3 pilihan**):

| Tombol | Format | Kapan dipakai |
|:-------|:-------|:--------------|
| **Ekspor Excel** | `.xlsx` | **Untuk mengolah angka** — nominal tersimpan sebagai angka, bisa langsung di-`SUM` |
| **Ekspor PDF** | `.pdf` | **Untuk menyerahkan/mengarsipkan** — ada kop perusahaan & kolom tanda tangan, tidak mudah diubah |
| **Ekspor CSV** | `.csv` | Pertukaran data antar sistem |

Jenis laporan: Daftar SPK · Piutang · Uang Masuk per Bulan · Pengeluaran per Kategori · Tenggat SPK

> 📌 Ekspor mengikuti **filter yang sedang aktif** dan **periode** yang dipilih.
> Kalau memilih periode 3 bulan, ekspor hanya 3 bulan itu.

### 3.8 Impor Data (Daftar SPK & Transaksi Keuangan)

**Sistem → Impor Data** (`/panel/import`)

Admin dapat melakukan migrasi atau pengunggahan data massal dari berkas spreadsheet (`.xlsx`, `.csv`, `.txt`) tanpa risiko duplikasi data (*append-only*).

#### 1. Pilihan Jenis Data
Ada **3 pilihan jenis data** yang dapat diimpor:
- **Daftar SPK**: Mengimpor daftar kontrak/pekerjaan SPK ke sistem. Mendukung penomoran SPK resmi maupun baris pekerjaan tanpa nomor SPK (otomatis diberi nomor `TANPA-SPK-xxxx`). Kolom status tagihan otomatis disinkronkan menjadi *Dibayar* jika kolom catatan bayar/keterangan mengindikasikan pelunasan ke rekening BKS.
- **Uang Masuk**: Mengimpor mutasi penerimaan kas/bank. Otomatis menautkan ke SPK terkait bila nomor SPK cocok serta menjaga batas sisa piutang SPK.
- **Uang Keluar**: Mengimpor mutasi biaya operasional atau biaya pekerjaan lapangan. Mendukung pemetaan otomatis kategori pengeluaran dan SPK terkait.

#### 2. Format Template & Kolom
Template dapat diunduh langsung melalui tautan di bawah kolom unggah berkas:
- **Template SPK**: Kolom `nomor_spk`, `tanggal_spk`, `nama_pekerjaan`, `lokasi`, `nilai_spk`, `mitra`, `keterangan`, `catatan_bayar`.
- **Template Transaksi (Uang Masuk / Keluar)**: Kolom `tanggal`, `jumlah`, `akun` (Kas/Bank), `nomor_spk`, `kategori`, `penerima`, `keterangan`.

#### 3. Fleksibilitas & Toleransi Format Excel
Sistem impor dirancang toleran terhadap kebiasaan format lembar kerja Excel:
- **Toleransi Header & Judul**: Baris kop surat, judul laporan di baris teratas, baris kosong, dan baris rumus total (`=SUM(...)`) otomatis dilewati. Sistem mendeteksi baris tabel data sebenarnya secara cerdas.
- **Variasi Format Tanggal**: Mendukung tanggal standar ISO (`YYYY-MM-DD`), format Indonesia dengan garis miring (`DD/MM/YYYY`, `D/M/YY`), format strip (`DD-MM-YYYY`), maupun format *serial number* bawaan Excel (mis. `45469`).
- **Pencegahan Duplikat**: Baris yang sudah pernah diimpor atau nomor SPK yang sudah terdaftar akan otomatis dilewati tanpa menggagalkan baris lainnya.
- **Laporan Hasil**: Setelah diproses, sistem menyajikan rincian jumlah baris **Ditambah**, **Dilewati (duplikat)**, dan baris **Gagal** (jika ada kesalahan validasi).

#### 4. Impor Massal Arsip Kantor via CLI (`bks:impor-arsip`)
Selain melalui web panel, administrator server dapat memanfaatkan perintah CLI Artisan untuk migrasi data awal (*onboarding*) dari berkas arsip kantor secara langsung di terminal:

```bash
# 1. Simulasi cek data arsip (dry-run) tanpa menulis ke database
php artisan bks:impor-arsip --dry-run

# 2. Impor berkas arsip default kantor (LIST SPK 2026.xlsx)
php artisan bks:impor-arsip

# 3. Impor dari lokasi berkas Excel kustom tertentu
php artisan bks:impor-arsip "/lokasi/arsip/daftar-spk.xlsx"

# 4. Impor langsung tanpa dialog konfirmasi (mode otomasi / skrip)
php artisan bks:impor-arsip --force
```

Keunggulan perintah CLI:
- **Deteksi Otomatis Berkas Default**: Jika argumen berkas dikosongkan, sistem otomatis memeriksa ketersediaan berkas standar di `BKS-Data-Perusahaan/dokumen/LIST SPK 2026.xlsx`.
- **Mode Uji Coba Aman (`--dry-run`)**: Menghitung baris valid dan estimasi duplikat tanpa mengubah isi database.
- **Toleran & Aman**: Mengabaikan baris rumus/total Excel dan mencegah duplikasi nomor SPK secara *append-only*.

---

### 3.9 Menghapus Data

Hapus bersifat **soft delete** — data tidak benar-benar hilang, bisa dipulihkan
lewat filter **Data Terhapus** → tombol **Pulihkan**.

> ⚠️ Data keuangan **tidak boleh hilang permanen** (Rules §2 butir 9).

---

## 4. Untuk DIREKTUR

### 4.1 Dashboard

**Dashboard** menampilkan ringkasan:

| Kartu | Isi |
|:------|:----|
| Total Nilai SPK | Jumlah nilai semua SPK |
| Total Uang Masuk | Total penerimaan tercatat |
| Total Uang Keluar | Total pengeluaran tercatat |
| Saldo Bersih | Selisih masuk dan keluar |

Grafik: **arus kas per bulan**, **SPK per status**, **status tagihan**,
dan tabel **SPK berjalan**.

> 📌 **Laba-rugi TIDAK dihitung** — keputusan perusahaan (Rules §2). Sistem
> murni mencatat data yang diinput.

### 4.2 Memantau Tenggat & Piutang

| Menu | Isi |
|:-----|:----|
| **SPK → Status SPK** | Status pekerjaan; tenggat **lewat** = badge merah, **≤14 hari** = kuning |
| **SPK → Tagihan SPK** | Tagihan yang belum lunas |
| **SPK → Tagihan Selesai SPK** | Tagihan yang sudah lunas |
| **Laporan → Piutang** | Daftar SPK yang uangnya belum diterima penuh, diurutkan dari **piutang terbesar** |

### 4.3 Ekspor untuk Pemeriksaan

Saat bagian pajak meminta "tanggal sekian, bulan sekian":
1. Buka **Keuangan → Uang Masuk** (atau Uang Keluar)
2. Atur **filter periode**
3. Klik **Ekspor** → berkas Excel

### 4.4 Mereset Kata Sandi Staf (Khusus Direktur / Skenario UAT §2.8)

Dalam operasional intranet tanpa akses internet / server email luar, Direktur memiliki wewenang penuh untuk mereset kata sandi akun staf (Admin) yang lupa kata sandi langsung dari panel:

1. Buka menu **Master Data → Manajemen Akun** (`/panel/users`).
2. Temukan nama atau email staf yang bersangkutan pada daftar pengguna.
3. Klik tombol ikon kunci (**Reset Password**) pada kolom aksi baris akun staf tersebut.
4. Jendela dialog modal akan terbuka:
   - Masukkan **Password Baru** (minimal 8 karakter).
   - Klik **Simpan Password**.
5. Notifikasi hijau akan muncul: `Kata sandi untuk pengguna [Nama] berhasil direset.`
6. **Perlindungan Keamanan Sesi**:
   - Seluruh sesi login staf tersebut di perangkat lain langsung **diputus seketika** dari basis data (`sessions`).
   - Staf diwajibkan melakukan login ulang menggunakan kata sandi baru yang telah ditetapkan oleh Direktur.
7. *Catatan Keamanan*: Direktur **tidak dapat** mereset kata sandi akun miliknya sendiri melalui tombol ini (akan dicegah dan diarahkan untuk mengubah kata sandi secara aman melalui menu **Profil Saya** di pojok kanan atas).

---

## 5. Hal Penting yang Perlu Diingat

| # | Hal | Kenapa |
|:-:|:----|:-------|
| 1 | Ganti password `password` sebelum dipakai | Keamanan |
| 2 | Backup rutin + **uji restore** | Data keuangan kritikal |
| 3 | Jangan pakai `php artisan serve` untuk harian | Tidak untuk produksi (Rules §11) |
| 4 | Jangan buka aplikasi ke internet | Hanya jaringan kantor |
| 5 | UPS untuk PC server | Listrik mati bisa merusak database |
| 6 | Nominal selalu **angka**, bukan teks | Supaya bisa dijumlahkan |
| 7 | Status/kategori **wajib pilih dari dropdown** | Kalau diketik bebas, laporan terpecah |

---

## 6. Kalau Ada Masalah

| Gejala | Kemungkinan | Tindakan |
|:-------|:------------|:---------|
| Tidak bisa login | Salah password / akun nonaktif | Hubungi Direktur untuk reset password di menu Manajemen Akun (§4.4) |
| Angka tidak muncul di laporan | Tanggal salah (beda bulan/tahun) | Cek filter periode |
| Uang masuk ditolak | Melebihi piutang SPK | Cek nilai SPK & penerimaan sebelumnya |
| Tombol tidak muncul | Peran tidak berhak | Direktur tidak bisa input |
| Halaman error | Lihat `storage/logs/laravel.log` | Hubungi pengembang |
| Data terhapus tidak sengaja | Soft delete | Filter "Data Terhapus" → Pulihkan |

---

## 7. Berkas Rujukan

| Berkas | Isi |
|:-------|:----|
| `docs/PRD.md` | Kebutuhan fitur & ruang lingkup |
| `docs/Rules.md` | Aturan bisnis (WAJIB dipatuhi) |
| `docs/Architecture.md` | Struktur teknis, deployment, backup, pengujian |
| `docs/Schema.md` | Struktur database |
| `docs/Design.md` | UI/UX |

---

*Manual ini disusun 29 September 2026 berdasarkan kode yang berjalan.
Setiap menu & tombol yang disebut sudah diverifikasi ada di aplikasi.*
