# PRD — Sistem Informasi SPK & Kontrol Keuangan
## PT Barelang Kontraktor Sarana

> **Versi:** 3.1 — **5 tabel** (sesuai `db.txt`)
> **Tanggal:** 19 September 2026
> **Menggantikan:** `docs-backup-29agu/PRD.md` (v1.0) dan draf v2.x
> **Sumber:** `Project Hub...` (SRS) + `db.txt` + keputusan user
> **Keputusan user:** MySQL + **full Laravel**; **schema 5 tabel**; status & kategori pakai **PHP Enum**
> **Status:** Siap untuk desain & implementasi

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
5. Sulit mengetahui laba-rugi per pekerjaan.

> **Catatan penting:** file Excel SPK milik perusahaan (tidak disertakan di repo) diposisikan
> sebagai **bahan analisis kebutuhan dan referensi desain**, **bukan** database operasional
> final. Tujuannya memahami pola input SPK, banyaknya sheet, kolom yang berulang, alur tagihan,
> dan kebutuhan tampilan/form.

## 2. Tujuan Produk

1. Memusatkan data SPK dalam satu sistem web internal.
2. Menyimpan SPK subkon/vendor beserta nilai borongan dan retensi 5%.
3. Mencatat uang masuk dan uang keluar beserta bukti pendukungnya.
4. Menghitung **laba-rugi per SPK** secara otomatis.
5. Menyajikan dashboard dan laporan keuangan yang akurat.
6. Menjaga jejak audit atas perubahan data.

## 3. Target Pengguna & Hak Akses

Sistem ini **hanya memiliki 2 role**:

| Role | Deskripsi | Fokus Aktivitas |
|---|---|---|
| **Admin** | Pengguna operasional yang memasukkan dan mengelola data | Input SPK, uang masuk, uang keluar, upload bukti, kelola master data |
| **Direktur** | Pemantau kondisi keuangan | Monitoring dashboard, lihat laporan, ekspor laporan |

### Matriks Hak Akses

| Fitur | Admin | Direktur |
|---|---|---|
| Login dan logout | Ya | Ya |
| CRUD data SPK | Ya | Lihat saja |
| Input uang masuk | Ya | Lihat saja |
| Input uang keluar | Ya | Lihat saja |
| Upload bukti transaksi | Ya | Lihat saja |
| Kelola master data | Ya | Lihat saja |
| Melihat dashboard | Ya | Ya |
| Ekspor laporan | Ya | Ya |
| Manajemen user | Ya, jika diberi kewenangan | Opsional |

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
| **SPK** ⭐ | CRUD SPK (PLN & subkon/vendor), nilai borongan, **retensi 5%**, status SPK, status tagihan | Entitas inti sistem |
| **Uang Masuk** | Pencatatan penerimaan dari SPK atau luar SPK, upload bukti | Penerimaan terekam, terelasi ke SPK bila relevan |
| **Uang Keluar** | Pencatatan pengeluaran per kategori, relasi ke SPK (opsional), upload bukti | Pengeluaran terekam |
| **Dashboard** | Ringkasan nilai SPK, uang masuk, uang keluar, saldo, piutang, estimasi laba-rugi | Pemantauan kondisi keuangan |
| **Laporan** | Laporan SPK, Uang Masuk, Uang Keluar, Cashflow, SPK Belum Dibayar, Laba-Rugi per SPK | Laporan + export PDF/Excel |

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

> 📌 **Catatan:** schema memakai **5 tabel** sesuai `db.txt`. Status & kategori **bukan** tabel
> master — nilainya dikelola lewat **PHP Enum** di aplikasi (lihat `Schema.md` §8).

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| FR-MST-001 | Kelola Mitra: PLN, pelanggan, vendor, subkon | High |
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
| FR-SPK-003 | Sistem menghitung **retensi 5%** dari nilai SPK | High |
| FR-SPK-004 | Admin mengubah status SPK & status tagihan | High |
| FR-SPK-005 | Sistem menampilkan detail SPK: data lengkap, uang masuk terkait, pengeluaran terkait | High |
| FR-SPK-006 | Filter SPK: nomor, tanggal, lokasi, nilai, status, sumber/sheet lama | Medium |
| FR-SPK-007 | Upload dokumen SPK | ⚠️ Menunggu keputusan (lihat §9) |

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
| FR-DASH-001 | Kartu ringkasan: total nilai SPK, total uang masuk, total uang keluar, saldo bersih | High |
| FR-DASH-002 | Grafik uang masuk vs uang keluar per bulan | High |
| FR-DASH-003 | Grafik perbandingan nilai SPK, penerimaan, biaya, estimasi margin | Medium |
| FR-DASH-004 | Tabel SPK berjalan beserta status tagihan | High |
| FR-RPT-001 | Laporan SPK | High |
| FR-RPT-002 | Laporan Uang Masuk | High |
| FR-RPT-003 | Laporan Uang Keluar | High |
| FR-RPT-004 | Laporan Cashflow (masuk vs keluar per periode) | High |
| FR-RPT-005 | Laporan SPK Belum Dibayar (piutang) | High |
| FR-RPT-006 | **Laporan Laba-Rugi per SPK** ⭐ | High |
| FR-RPT-007 | Export PDF & Excel di setiap laporan | Medium |

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
2. Admin mengelola master data (partner, status, kategori).
3. Admin membuat data SPK (nomor, tanggal, pekerjaan, nilai, status).
   → Sistem menghitung retensi 5% jika SPK subkon/vendor.
4. Admin mencatat UANG MASUK:
   - Mode 1: pilih SPK dari dropdown → isi tanggal & nominal
   - Mode 2: input manual (nama pekerjaan + nomor SPK bebas)
   - Upload bukti
5. Admin mencatat UANG KELUAR:
   - Pilih kategori pengeluaran
   - Relasi ke SPK (opsional)
   - Isi nominal, penerima, keterangan
   - Upload bukti
6. Sistem menghitung otomatis: saldo, piutang, laba-rugi per SPK.
7. Direktur membuka dashboard & laporan untuk memantau.
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
2. Sistem menyimpan SPK subkon/vendor beserta retensi 5%.
3. Sistem mencatat uang masuk dan uang keluar beserta bukti.
4. Sistem menghitung **laba-rugi per SPK** tanpa rekap manual tambahan.
5. Saldo dan piutang dihitung otomatis dari akumulasi transaksi.
6. Dashboard menampilkan ringkasan keuangan yang akurat.
7. Laporan dapat diekspor ke PDF/Excel.
8. Manual book dan dokumen serah terima tersedia.

## 9. ⚠️ Hal yang Masih Perlu Konfirmasi

| No | Hal | Pertanyaan |
|---|---|---|
| 1 | **Kolom `keterangan` pada SPK** | `db.txt` bilang tidak digunakan, tetapi SRS bilang wajib ada dan setiap baris Excel punya catatan follow-up. Hapus atau pertahankan? |
| 2 | **Upload dokumen SPK** | Karena tabel bukti dihapus & bukti hanya di uang masuk/keluar, dokumen SPK (BAST, kuitansi, scan SPK) tidak punya tempat. Tambahkan kolom `dokumen` pada `spk`? |
| 3 | **Format bukti** | Satu file per transaksi, atau banyak file? |
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
- Riwayat perubahan: **CHANGELOG.md**

---

*PRD v2.1 — keputusan user 19 September 2026 sudah diterapkan.
Dokumen v1.0 tersimpan di `docs-backup-29agu/PRD.md`.*
