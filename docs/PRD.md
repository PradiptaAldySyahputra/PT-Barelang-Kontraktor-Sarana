# PRD — Sistem Informasi SPK & Kontrol Keuangan
## PT Barelang Kontraktor Sarana

> **Inti proyek.** Kebutuhan fitur & ruang lingkup.
> **Keputusan kunci:** MySQL + full Laravel · schema **5 tabel** · status & kategori pakai **PHP Enum**.

---

## 1. Latar Belakang

PT Barelang Kontraktor Sarana adalah perusahaan kontraktor di Batam yang menjalankan pekerjaan
berbasis proyek, melayani **mitra PLN Batam** serta **proyek eksternal**. Perusahaan juga
menerbitkan **SPK kepada subkon/vendor** untuk pelaksanaan pekerjaan.

Saat ini pengelolaan data masih manual dan tersebar: dokumen fisik, file Excel dengan banyak
sheet, catatan terpisah, dan arsip bukti transaksi. Kondisi tersebut menimbulkan masalah:

1. Data SPK dan pekerjaan sulit dipantau dalam satu tempat.
2. SPK subkon/vendor belum terhubung dengan nilai pekerjaan induk.
3. Risiko selisih angka rupiah karena pencatatan tersebar di banyak file.
4. Bukti nota, invoice, dan dokumen pendukung sulit ditelusuri saat pemeriksaan.
5. Sulit melihat posisi penerimaan, saldo kas/bank, serta SPK yang perlu ditindaklanjuti.

> **Catatan penting:** file Excel SPK milik perusahaan (tidak disertakan di repo) diposisikan
> sebagai **bahan analisis kebutuhan dan referensi desain**, **bukan** database operasional
> final. Tujuannya memahami pola input SPK, banyaknya sheet, kolom yang berulang, alur tagihan,
> dan kebutuhan tampilan/form.

## 2. Tujuan Produk

1. Memusatkan data SPK dalam satu sistem web internal.
2. Menyimpan SPK subkon/vendor beserta nilai borongan tanpa komponen retensi.
3. Mencatat uang masuk dan uang keluar beserta bukti pendukungnya.
4. Menyajikan piutang, saldo per akun, arus kas, dan tenggat SPK.
5. Menyajikan dashboard serta laporan operasional dan keuangan yang akurat.
6. Menjaga jejak audit atas perubahan data.

Laporan laba-rugi, margin, retensi, dan umur piutang berada di luar cakupan sistem.

## 3. Target Pengguna & Hak Akses

Sistem ini **hanya memiliki 2 role**:

| Role | Deskripsi | Fokus Aktivitas |
|---|---|---|
| **Admin** | Pengguna operasional yang memasukkan dan mengelola data | Input SPK, uang masuk, uang keluar, upload bukti, kelola master data |
| **Direktur** | Pemantau kondisi keuangan | Monitoring dashboard, lihat laporan, ekspor laporan |

### Matriks Hak Akses

| Fitur | Admin | Direktur (Super Admin) |
|---|---|---|
| Login dan logout | Ya | Ya |
| CRUD data SPK | Ya | Ya |
| Input & Kelola uang masuk | Ya | Ya |
| Input & Kelola uang keluar | Ya | Ya |
| Upload & ekstraksi bukti nota | Ya | Ya |
| Kelola master data Mitra | Ya | Ya |
| Melihat dashboard | Ya | Ya |
| Ekspor laporan | Ya | Ya |
| Manajemen user pengguna | Tidak (Khusus Direktur) | Ya (Penuh) |
| Backup, Impor & Status Sistem | Ya | Ya |

> ⚠️ **Perubahan dari versi 1.0:** role `Staf Keuangan` dan `Pengawas Lapangan` **dihapus**.
>
> ⚠️ **Perubahan dari draf v2.0:** **TIDAK ADA approval Direktur.** Direktur hanya memantau
> dan melihat laporan. Admin tidak memerlukan persetujuan untuk mencatat transaksi.

## 4. Ruang Lingkup MVP

### 4.1 Modul yang Termasuk MVP

| Modul | Ruang Lingkup | Output |
|---|---|---|
| **Autentikasi & Hak Akses** | Login, logout, session, pembatasan akses role Admin/Direktur | User hanya mengakses fitur sesuai haknya |
| **Data Mitra** | CRUD mitra: PLN, pelanggan, vendor, subkon | Fondasi data referensi |
| **SPK** | CRUD SPK (PLN & subkon/vendor), nilai borongan, status SPK, status tagihan | Entitas inti sistem |
| **Uang Masuk** | Pencatatan penerimaan dari SPK atau luar SPK, upload bukti | Penerimaan terekam, terelasi ke SPK bila relevan |
| **Uang Keluar** | Pencatatan pengeluaran per kategori, relasi ke SPK (opsional), upload bukti | Pengeluaran terekam |
| **Dashboard** | Nilai SPK, penerimaan dari SPK, pengeluaran, piutang, saldo kas/bank, dan tenggat | Pemantauan posisi serta tindak lanjut |
| **Laporan** | Ringkasan, arus kas per bulan, transaksi masuk/keluar, kategori, piutang, daftar SPK, tenggat, buku kas/bank | Laporan dan ekspor CSV/XLSX/PDF |

> 📌 **Audit log dihapus** (keputusan user 19 Sep 2026). Konsekuensinya: tidak ada jejak
> siapa mengubah nominal. Ini **menyimpang dari SRS NFR-SEC-004** — lihat `Schema.md` §8.

### 4.2 Modul yang TIDAK Termasuk (Keputusan Final)

| Modul | Alasan |
|---|---|
| ❌ **Manajemen Proyek** | Keputusan #1 — *SPK adalah entitas inti. Tidak ada entitas PROYEK.* |
| ❌ **Pengajuan Dana** | Keputusan #2 — tidak digunakan |
| ❌ **Approval Direktur** | Keputusan #2 & #4 — tidak ada approval sama sekali |
| ❌ Integrasi otomatis dengan sistem PLN | Di luar scope |
| ❌ Integrasi bank otomatis | Di luar scope |
| ❌ Payroll karyawan | Di luar scope |
| ❌ Mobile app native | Di luar scope |
| ❌ Approval multi-level | Di luar scope |
| ❌ Sistem pajak otomatis | Di luar scope |
| ❌ Forecasting keuangan lanjutan | Di luar scope |
| ❌ Manajemen inventori/stok gudang | Di luar scope |
| ❌ Multi-tenant / SaaS | Di luar scope |

### 4.3 Fitur Calon (Perlu Konfirmasi)

| Fitur | Status | Catatan |
|---|---|---|
| **Rekening Koran** | Belum pasti | Kemungkinan jadi sumber validasi/rekonsiliasi |
| **To-Do List Sistem** | Opsional | Belum tentu masuk MVP |

## 5. Kebutuhan Fungsional

### 5.1 Data Mitra & Master Internal

> 📌 **Catatan:** schema memakai **5 tabel**. Status & kategori **bukan** tabel
> master — nilainya dikelola lewat **PHP Enum** di aplikasi (lihat `Schema.md` §8).

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-MST-001 | Kelola Mitra: **PLN (pemberi kerja)** & **Subkon/Vendor** — 2 kategori sesuai keputusan pengguna 19 Sep 2026 | High |
| FR-MST-002 | Daftar Status SPK (Enum): Draft, Terbit, Berjalan, Selesai, Sudah Ditagihkan, Dibatalkan | High |
| FR-MST-003 | Daftar Status Tagihan (Enum): Belum Ditagihkan, Sudah Ditagihkan, Revisi Dokumen, Menunggu Pembayaran, Dibayar | High |
| FR-MST-004 | Daftar Kategori Pengeluaran (Enum): material, upah, operasional, gaji, nota, transportasi, lainnya | High |
| FR-MST-005 | Kelola Pengguna (Admin, Direktur) | High |

> ⚠️ **Risiko yang harus dimitigasi:** karena status & kategori disimpan sebagai kolom teks,
> **wajib** divalidasi dengan PHP Enum + dropdown di form. Tanpa itu, laporan akan terpecah
> (lihat bukti uji di `Schema.md` §8).

### 5.2 SPK (Entitas Inti)

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-SPK-001 | Admin membuat SPK baru (nomor, tanggal, tanggal akhir, nama pekerjaan, lokasi, nilai, status) | High |
| FR-SPK-002 | Admin mengubah data SPK | High |
| FR-SPK-003 | Status tagihan SPK dapat dicatat dan ditampilkan; tidak ada komponen retensi | High |
| FR-SPK-004 | Admin mengubah status SPK & status tagihan | High |
| FR-SPK-005 | Sistem menampilkan detail SPK: data lengkap, uang masuk terkait, pengeluaran terkait | High |
| FR-SPK-006 | Filter SPK: nomor, tanggal, lokasi, nilai, status, sumber/sheet lama | Medium |
| FR-SPK-007 | Upload dokumen SPK | ✅ **SELESAI** (29 Sep 2026) — kolom `spk.dokumen` (JSON), banyak berkas per SPK |

### 5.3 Uang Masuk

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-IN-001 | **Mode 1 — Berdasarkan SPK:** pilih SPK dari dropdown, isi tanggal & nominal | High |
| FR-IN-002 | **Mode 2 — Manual:** input nama pekerjaan & nomor SPK bebas | High |
| FR-IN-003 | Upload bukti (transfer, gambar, PDF) | High |
| FR-IN-004 | Filter & pencarian uang masuk per periode/SPK | Medium |

### 5.4 Uang Keluar

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-OUT-001 | Input pengeluaran: tanggal, kategori, nominal, penerima, keterangan | High |
| FR-OUT-002 | Relasi ke SPK (opsional) — untuk pengeluaran terkait SPK tertentu | High |
| FR-OUT-003 | Upload bukti (transfer, gambar, PDF) | High |
| FR-OUT-004 | Filter & pencarian uang keluar per periode/kategori/SPK | Medium |

### 5.5 Dashboard & Laporan

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-DASH-001 | Ringkasan posisi: nilai SPK, penerimaan SPK/luar SPK, pengeluaran, piutang, saldo kas/bank, dan tenggat | High |
| FR-DASH-002 | Tren penerimaan dan pengeluaran bulanan berbasis agregasi transaksi | High |
| FR-DASH-003 | Daftar SPK berjalan dan aktivitas terbaru untuk tindak lanjut Admin | High |
| FR-RPT-001 | Ringkasan laporan mengikuti periode; posisi SPK/piutang/saldo diberi label sebagai posisi saat ini | High |
| FR-RPT-002 | Rincian arus kas bulanan, termasuk bulan yang hanya memiliki transaksi keluar | High |
| FR-RPT-003 | Rincian kategori pengeluaran, piutang, daftar SPK, tenggat, dan buku kas/bank | High |
| FR-RPT-004 | Ekspor CSV, XLSX, dan PDF tersedia pada bagian laporan yang relevan | High |
| FR-RPT-005 | Piutang per SPK memakai nilai SPK dikurangi penerimaan terkait SPK; transaksi luar SPK tidak mengurangi piutang | High |

## 6. Kebutuhan Non-Fungsional

| Kode | Kategori | Kebutuhan | Indikator |
|---|---|---|---|
| NFR-SEC-001 | Keamanan | Password disimpan dengan hashing Laravel (Bcrypt/Argon2) | Tidak ada password plain text |
| NFR-SEC-002 | Keamanan | Akses dibatasi middleware berdasarkan role | User tidak bisa buka halaman di luar kewenangan |
| NFR-SEC-003 | Keamanan Angka Rupiah | Nominal disimpan `DECIMAL(18,2)`, **bukan** `FLOAT` | Perhitungan akurat, tanpa galat presisi |
| NFR-SEC-004 | ~~Keamanan Data~~ | ❌ **DIHAPUS** — keputusan user: audit log tidak perlu. Menyimpang dari SRS | — |
| NFR-PERF-001 | Performa | Dashboard pakai eager loading, aggregate query, indexing | Waktu respons wajar |
| NFR-PERF-002 | Performa | Daftar SPK & transaksi pakai pagination | Tabel tetap ringan |
| NFR-DB-001 | Integritas Data | Relasi pakai foreign key + validasi transaksi database | Tidak ada transaksi tanpa referensi valid |
| NFR-UI-001 | Usability | Form sederhana, sesuai istilah operasional perusahaan | Admin dapat input tanpa pelatihan kompleks |
| NFR-DEP-001 | Deployment | Berjalan **lokal** di jaringan kantor | PC Admin dapat akses PC Direktur |
| NFR-DEP-002 | Backup | Backup database & folder upload terjadwal | Data dapat dipulihkan |

## 7. Alur Proses Utama

### 7.1 Alur Pencatatan

```
1. Admin login ke sistem.
2. Admin mengelola master mitra dan membuat SPK.
3. Admin mencatat uang masuk, terkait ke SPK bila penerimaan berasal dari SPK, atau sebagai penerimaan luar SPK.
4. Admin mencatat uang keluar, memilih kategori dan mengaitkan SPK bila relevan.
5. Sistem menyajikan saldo per akun dan piutang dari penerimaan terkait SPK.
6. Admin dan Direktur membuka Dashboard/Laporan sesuai hak akses; laporan transaksi dapat diekspor ke CSV, XLSX, atau PDF.
```

> ⚠️ **Tidak ada langkah approval.** Transaksi langsung tercatat saat Admin menyimpan.

### 7.2 Siklus Status SPK

```
Draft ──► Terbit ──► Berjalan ──► Selesai ──► Sudah Ditagihkan
  │          │           │            │
  └──────────┴───────────┴────────────┴──► Dibatalkan
```

| Status | Makna | Kondisi Pemicu | Aksi Berikutnya |
|---|---|---|---|
| **Draft** | SPK dibuat, belum resmi | Admin menyimpan sebagai draft | Lengkapi data, ubah ke Terbit |
| **Terbit** | SPK resmi bernomor, pekerjaan belum mulai | Admin simpan SPK final | Mulai pekerjaan, ubah ke Berjalan |
| **Berjalan** | Pekerjaan sedang berlangsung | Admin memperbarui saat pekerjaan dimulai | Input progres, catat transaksi |
| **Selesai** | Selesai administratif & operasional | Admin menandai selesai | Arsipkan |
| **Sudah Ditagihkan** | Tagihan sudah diajukan | Admin mencatat penagihan | Pantau pembayaran |
| **Dibatalkan** | SPK tidak dilanjutkan | Admin membatalkan | Simpan alasan |

### 7.3 Siklus Status Tagihan

`Belum Ditagihkan` → `Sudah Ditagihkan` → `Revisi Dokumen` → `Menunggu Pembayaran` → `Dibayar`

## 8. Kriteria Sukses

1. Sistem mencatat seluruh SPK secara terpusat.
2. Sistem mencatat uang masuk dan uang keluar beserta bukti.
3. Sistem menyajikan nilai SPK, penerimaan terkait, dan piutang per SPK.
4. Sistem menyajikan saldo per akun dari transaksi masuk dan keluar.
5. Dashboard membedakan angka periode dan posisi saat ini.
6. Laporan dapat diekspor ke CSV, XLSX, dan PDF sesuai jenis data.
7. Manual book dan dokumen serah terima tersedia.

Sistem tidak menghitung laba-rugi, margin, retensi, atau umur piutang.

## 9. ⚠️ Hal yang Masih Perlu Konfirmasi

| No | Hal | Pertanyaan |
|---|---|---|
| 1 | **Kolom `keterangan` pada SPK** | ✅ **Dihapus** (keputusan user) |
| 2 | **Upload dokumen SPK** | Selesai. Kolom `spk.dokumen` menyimpan path berkas secara privat. |
| 3 | **Format bukti** | Selesai. Bukti transaksi dapat berisi banyak file sesuai validasi form. |
| 4 | **Rekening Koran** | Format file & perannya (validasi vs pencatatan)? |
| 5 | **Data keuangan final dari Admin** | Belum diterima |
| 6 | **Pilihan deployment** | Lokal / cloud / hybrid — dokumen sumber masih tidak konsisten |
| 7 | **Data lama 2024–2026** | Di-import atau mulai dari nol? |
| 8 | **Pajak (PPN/PPh)** | Perlu dihitung atau tidak? |

## 10. Risiko & Catatan

- **Data keuangan kritikal** — wajib backup rutin dan uji restore (lihat `Architecture.md` §7).
- **Data referensi SPK belum bersih** — 14 record tanpa nomor SPK, 14 tanpa tanggal,
  91 record tanpa dokumen, dan nomor SPK duplikat. Wajib *cleansing* sebelum migrasi.
- **PC Direktur merangkap server & perangkat kerja harian** — berisiko *single point of failure*.
- **Data keuangan final belum diterima** — struktur keuangan masih fleksibel.
- **ERD bergambar pada SRS perlu diperbarui** — masih memuat `projects`, `subcon_spks`,
  `cash_requests`, dan `attachments` yang sudah dihapus.
- **WBS 4 bulan** sedangkan properti pelaporan hanya sampai Minggu 8 — perlu diperluas.

## 11. Metodologi & Linimasa

**Metode:** Fast-Track Waterfall — analisis & desain dipadatkan pada awal proyek sehingga
implementasi dapat dimulai pada Bulan 1 Minggu 3.

| Tahapan | Periode | Fokus | Output Utama |
|---|---|---|---|
| Requirements & Design | Bulan 1 Minggu 1–2 | Analisis kebutuhan, desain DB, form | SRS, ERD, flowchart, layout, hak akses |
| Implementation | Bulan 1 Minggu 3 – Bulan 3 | Coding Laravel, Blade, form, dashboard | Modul SPK, uang masuk/keluar, dashboard |
| Verification | Bulan 4 Minggu 1–2 | Pengujian fitur & validasi rupiah | Test case, hasil black-box, bug report |
| Deployment | Bulan 4 Minggu 3–4 | Instalasi lokal, pelatihan, serah terima | Sistem, manual book, source code, BAST |

### Justifikasi Fast-Track Waterfall

1. Alur bisnis relatif jelas: input Admin → pencatatan transaksi → monitoring Direktur.
2. Batasan role sederhana: hanya Admin dan Direktur.
3. Modul prioritas dapat didefinisikan sejak awal sebagai MVP.
4. Dokumentasi SRS dibutuhkan sebagai dasar implementasi dan serah terima.
5. Coding dapat dimulai lebih cepat setelah ERD, flowchart, dan layout disepakati.
6. Verifikasi difokuskan pada validasi input dan akurasi perhitungan rupiah.

## 12. Referensi Silang

- Struktur teknis & deployment lokal: **Architecture.md**
- Struktur database: **Schema.md**
- Tampilan & alur UI: **Design.md**
- Aturan bisnis & konvensi: **Rules.md**

---

*Keputusan user 19 September 2026 sudah diterapkan.*
