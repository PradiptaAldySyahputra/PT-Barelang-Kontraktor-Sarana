# Panduan & Lembar Uji User Acceptance Testing (UAT)
## PT Barelang Kontraktor Sarana — Sistem Informasi SPK & Kontrol Keuangan

> **Tujuan:** Panduan langkah-demi-langkah pengujian nyata bersama Admin (staf operasional) dan Direktur (Super Admin) untuk memvalidasi alur kerja harian sebelum sistem diterapkan resmi.
> **Versi:** 1.0 (Pasca-Migrasi Penuh Blade + TailAdmin)
> **Alamat Panel:** `http://[IP-SERVER-KANTOR]:8232/panel` (atau `http://localhost:8232/panel` jika di PC server langsung)

---

## 1. Persiapan Sesi Pengujian

| Item | Nilai / Keterangan |
|:-----|:-------------------|
| **Topologi Jaringan** | **Dedicated Server Intranet 24 Jam** (PC Rakitan Ubuntu Server via LAN) · Akses Jarak Jauh Pengembang via Tailscale |
| **Alamat Server** | Misal: `http://192.168.1.100:8232/panel` (PC server wajib IP Statis) |
| **Akun Admin** | `admin@bks.test` — password dibuat saat seeding/`php artisan app:buat-admin` (tidak ditulis di dokumen) |
| **Akun Direktur** | `direktur@bks.test` — password dibuat saat seeding/`php artisan app:buat-admin` (tidak ditulis di dokumen) |
| **Berkas Uji OCR** | `(12) nota simada bulan ags 26.pdf` (multi-halaman) atau `nota1.jpg` (satuan) |
| **Perangkat Uji** | Peramban Chrome / Firefox / Edge di PC klien & PC server kantor |
| **Ketergantungan Internet** | **Nol (100% Offline)** — seluruh aset JS/CSS/Font lokal tanpa CDN luar |

---

## 2. Skenario Uji 1: Alur Kerja Harian Admin (Staf Operasional)

Instruksi: Masuk sebagai **Admin** (`admin@bks.test`).

| No | Aktivitas / Langkah Pengujian | Hasil yang Diharapkan | Status (✓ / ✗) | Catatan / Masukan User |
|:--:|:------------------------------|:----------------------|:--------------:|:-----------------------|
| **1.1** | **Login & Dashboard Operasional**<br>Buka `/panel/login`, masukkan kredensial Admin. | Masuk ke dashboard operasional, logo BKS tampil proporsional di sidebar, kartu mutasi hari ini tampil. | [ ] | |
| **1.2** | **Tambah Mitra Rekanan Baru**<br>Buka menu *Master Data → Mitra*, klik *Tambah Mitra*. | Form terbuka, simpan data rekanan PLN / Subkon baru, data langsung tampil di tabel mitra. | [ ] | |
| **1.3** | **Pendaftaran SPK Baru**<br>Buka menu *SPK → List SPK*, klik *SPK Baru*. | Form pendaftaran terbuka. Dropdown mitra responsif. Ketik nilai kontrak (misal: `100.000.000`), simpan data. | [ ] | |
| **1.4** | **Pencarian & Pratinjau Detail SPK**<br>Gunakan filter pencarian nomor SPK di tabel, klik nomor SPK. | Halaman detail terbuka, tombol *Cetak BAST* tersedia, breadcrumb menunjukkan `SPK > Detail SPK`. | [ ] | |
| **1.5** | **Unggah Scan PDF Nota Tumpuk (OCR)**<br>Buka menu *Nota & Bukti → Unggah & Ekstraksi Nota*, unggah berkas PDF nota multi-halaman. | Berkas dipecah otomatis menjadi N kartu nota. Tiap kartu memiliki pratinjau gambar, input nominal, tanggal, dan cari SPK. | [ ] | |
| **1.6** | **Simpan Arsip Nota Hasil Ekstraksi**<br>Pilih SPK terkait pada salah satu kartu nota, lalu klik *Simpan N Nota ke Arsip & Sistem*. | Seluruh nota tersimpan ke **Arsip Nota** (`/panel/receipts`), pratinjau dibuka lewat modal ukuran besar. | [ ] | |
| **1.7** | **Pencatatan Uang Keluar & Pengingat Kas**<br>Buka menu *Keuangan → Uang Keluar*, klik *Catat Uang Keluar* dengan nominal besar. | Jika melebihi kas riil, banner peringatan kuning muncul. Transaksi tetap dapat disimpan sesuai faktur fisik. | [ ] | |
| **1.8** | **Pencatatan Termin Uang Masuk**<br>Buka menu *Keuangan → Uang Masuk*, pilih mode SPK dan masukkan termin (misal `30.000.000`). | Saldo piutang SPK berkurang otomatis, tombol kembali berfungsi tepat, tombol *Cetak Kuitansi* PDF aktif. | [ ] | |
| **1.9** | **Cetak Bukti Kuitansi Resmi**<br>Klik tombol *Kuitansi* pada baris uang masuk. | Berkas PDF resmi A4 terbuka dengan KOP surat PT BKS, terbilang otomatis, dan tanda tangan digital. | [ ] | |
| **1.10** | **Uji Batasan Keamanan Admin**<br>Coba ketik alamat URL `/panel/users` di browser. | Sistem menolak akses dengan tampilan **403 Akses Ditolak** (Manajemen akun khusus Direktur). | [ ] | |

---

## 3. Skenario Uji 2: Pengawasan & Pengambilan Keputusan Direktur (Super Admin)

Instruksi: Logout, lalu masuk sebagai **Direktur** (`direktur@bks.test`).

| No | Aktivitas / Langkah Pengujian | Hasil yang Diharapkan | Status (✓ / ✗) | Catatan / Masukan User |
|:--:|:------------------------------|:----------------------|:--------------:|:-----------------------|
| **2.1** | **Dashboard Eksekutif & Ringkasan Kas**<br>Periksa tampilan dashboard setelah login. | Header menyapa nama Direktur, kartu *Arus Kas Bulan Ini* (Masuk vs Keluar) + grafik *Arus Kas 6 Bulan*, serta daftar SPK prioritas pantauan. | [ ] | |
| **2.2** | **Wewenang Penuh Transaksi (Super Admin)**<br>Coba buat atau ubah SPK dan Uang Masuk. | Direktur memiliki hak input, edit, dan hapus 100% pada seluruh modul transaksi tanpa hambatan. | [ ] | |
| **2.3** | **Monitoring Status Progres & Tagihan**<br>Buka menu *SPK → Status SPK* dan *Tagihan SPK*. | Daftar SPK terpilah jelas antara pekerjaan fisik lapangan vs proses pencairan tagihan PLN Batam. | [ ] | |
| **2.4** | **Drawer Riwayat Termin SPK**<br>Klik tautan *Sisa Piutang / Termin* pada salah satu baris SPK. | Panel laci (drawer) kanan meluncur tanpa reload halaman, menyajikan rincian seluruh termin yang telah cair. | [ ] | |
| **2.5** | **Cetak Dokumen BAST Resmi**<br>Buka salah satu detail SPK yang selesai, klik *Cetak BAST*. | Unduhan berkas PDF resmi Berita Acara Serah Terima A4 ber-KOP BKS dengan klausul serah terima fisik. | [ ] | |
| **2.6** | **Unduh Laporan Keuangan Format Perusahaan**<br>Buka menu *Laporan*, unduh spreadsheet *Buku Kas* atau *Buku Bank* (`.xlsx`). | Format kolom Excel persis arsip kantor (`TANGGAL, REF, KETERANGAN, PEMASUKAN, PENGELUARAN, SALDO`) ber-KOP formal. | [ ] | |
| **2.7** | **Unduh Bundel Seluruh Laporan (ZIP)**<br>Klik tombol *Unduh Bundel Laporan (ZIP)*. | Berkas ZIP terunduh berisi 5 spreadsheet laporan terstruktur periode berjalan. | [ ] | |
| **2.8** | **Manajemen Akun Pengguna**<br>Buka menu *Master Data → Manajemen Akun* (`/panel/users`). | Daftar akun staf tampil, Direktur dapat menambah pengguna baru atau menonaktifkan akun staf yang mutasi. | [ ] | |
| **2.9** | **Cadangan Basis Data (Backup)**<br>Buka menu *Sistem → Backup Database*, klik *Buat Backup Sekarang*. | Berkas cadangan `.zip` (berisi `.sql`) terbuat dan dapat diunduh langsung untuk arsip keamanan luar PC. | [ ] | |

---

## 4. Format Catatan & Evaluasi Pasca-Demo

Gunakan tabel ini untuk mencatat masukan langsung dari user saat sesi pertemuan:

```
Tanggal Demo   : ....................................................
Tempat / Ruang : Kantor PT Barelang Kontraktor Sarana, Batam
Penguji        : [ ] Direktur Utama    [ ] Admin Keuangan

Masukan Alur / Bisnis:
1. ............................................................................................
2. ............................................................................................

Masukan Tampilan / Antarmuka:
1. ............................................................................................
2. ............................................................................................

Persetujuan Lanjut:
[ ] Siap Digunakan Operasional Penuh
[ ] Perlu Penyesuaian Minor (Catatan di atas)
[ ] Jadwalkan Uji Ulang
```
