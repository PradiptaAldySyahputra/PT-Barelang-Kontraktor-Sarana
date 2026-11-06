# Design — UI/UX & Design Guidelines
## Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana

> Panel admin TailAdmin (`/panel`). Role 2 · tanpa halaman approval · tanpa menu
> Proyek/Master Data · form uang masuk 2 mode · Direktur memiliki hak Super Admin.

---

## 1. Prinsip Desain UI/UX

1. **Dashboard admin sederhana dan bersih** — fokus pada angka, tindakan yang perlu ditindaklanjuti, dan tabel.
2. **Kejelasan data finansial** — biru menjadi aksen antarmuka; hijau/merah hanya untuk makna finansial atau peringatan,
   selalu disertai label teks.
3. **Navigasi sidebar tetap**, mengikuti modul utama: **Dashboard, Master Data, Transaksi, Laporan**.
4. **Mobile-friendly** untuk halaman input transaksi — Admin sering input dari lokasi pekerjaan.
5. **Istilah operasional perusahaan** — form memakai istilah sehari-hari (SPK, termin,
   BAST) agar Admin tidak perlu pelatihan kompleks.
6. **Selalu sediakan kolom Keterangan** pada setiap form transaksi agar konteks tidak hilang.

## 2. Design System

| Aspek | Ketentuan |
|---|---|
| **Primary color** | **Biru enterprise `#2563eb`** (blue-600) — tombol utama, menu aktif, link. SATU aksen saja, jangan warna-warni (sistem desain v1.1, 11 Okt 2026) |
| **Warna semantik** | Hijau = pemasukan/untung; Merah = pengeluaran/rugi; Abu = arsip/dibatalkan |
| **Warna netral** | `zinc` untuk teks dan elemen netral; putih untuk permukaan utama |
| **Mode gelap** | Aktif (bawaan panel Blade + TailAdmin, `class="dark"` + CSS variables). Latar `#09090b`, teks `#fafafa`, aksen biru terang `#60a5fa` |
| **Typography** | Font sistem (`system-ui`, `-apple-system`, …) — benar-benar dimuat, bukan Inter. Diperbaiki 12 Okt 2026 (lihat §14) |
| **Komponen** | Kartu radius moderat, whitespace cukup, ikon sederhana, hierarki heading konsisten |
| **Prinsip** | Mobile-first, jelas, ramah pengguna, konsisten, aksesibel |

> ⚠️ **Jangan mengandalkan warna saja** untuk menyampaikan status — sertakan label teks/ikon.

## 3. Struktur Navigasi Sidebar

> ⚠️ **SUDAH DIIMPLEMENTASI di panel Blade + Livewire (`/panel`).** Sidebar bisa
> **ditutup/dibuka** (`sidebarFullyCollapsibleOnDesktop`) dan **grup menu bisa
> dilipat** (`collapsibleNavigationGroups`). Tema: **Clean Minimalist Enterprise**
> (monokrom, border tipis, font sistem).

```
Dashboard
    └── Kartu ringkasan · Grafik arus kas · SPK per status
        · Pengeluaran per kategori · Tabel SPK berjalan

Data Mitra
    └── Mitra               (PLN, vendor, subkon, pelanggan)

Transaksi
    ├── SPK                 ⭐ entitas inti
    ├── Uang Masuk          (2 mode: dari SPK / manual)
    └── Uang Keluar

Laporan
    └── Laporan             (satu halaman dengan ringkasan, tindakan, transaksi, SPK, tenggat, saldo, dan ekspor per jenis data)

Pengaturan
    └── Pengguna
```

**Isi halaman Laporan** (satu halaman, bukan banyak menu):

| Bagian | Isi |
|---|---|
| Ringkasan | Nilai SPK, uang masuk, uang keluar, saldo, dan konteks jumlah data |
| Perlu Perhatian | Jumlah SPK lewat tenggat, mendekati tenggat, dan belum lunas |
| Arus Kas per Bulan | Masuk, keluar, selisih, serta bulan yang hanya memiliki satu jenis transaksi |
| Pengeluaran per Kategori | Total pengeluaran menurut kategori |
| Piutang SPK | Nilai SPK, penerimaan, dan sisa piutang |
| Daftar SPK | Nilai, penerimaan, sisa piutang, dan status |
| Tenggat SPK | SPK lewat atau mendekati tenggat |

Filter periode hanya memengaruhi transaksi uang masuk dan uang keluar. Nilai SPK,
piutang, saldo, daftar SPK, dan tenggat menunjukkan posisi saat ini.

Ekspor tersedia per bagian laporan dalam format CSV, Excel, atau PDF sesuai kebutuhan.

> 📌 **Tidak ada menu Master Data** untuk Status SPK / Status Tagihan / Kategori Pengeluaran.
> Karena schema hanya 5 tabel, nilainya dikelola lewat **PHP Enum** dan muncul sebagai
> **dropdown** di form — bukan halaman CRUD terpisah.

> ❌ **Menu yang TIDAK ada** (keputusan user):
> **Proyek** (tidak ada entitas PROYEK) · **Pengajuan Dana** (modul dihapus) ·
> **Verifikasi/Approval Direktur** (tidak ada approval) · **Bukti & Dokumen** (bukti jadi
> kolom di form uang masuk & uang keluar)

## 4. Daftar Halaman

| Halaman | Modul | Deskripsi Singkat |
|---|---|---|
| Login | Auth | Form login dengan redirect berdasarkan role |
| Dashboard | Dashboard | Kartu ringkasan, grafik, tabel SPK berjalan |
| Daftar SPK | Transaksi | ⭐ Tabel SPK + filter + board status |
| Detail SPK | Transaksi | Data lengkap, uang masuk terkait, pengeluaran terkait |
| Input SPK | Transaksi | Form tambah/edit SPK |
| Daftar Uang Masuk | Transaksi | Tabel penerimaan + filter periode/SPK |
| Input Uang Masuk | Transaksi | Form 2 mode (dari SPK / manual) + upload bukti |
| Daftar Uang Keluar | Transaksi | Tabel pengeluaran + filter periode/kategori/SPK |
| Input Uang Keluar | Transaksi | Form pengeluaran + upload bukti |
| Master Mitra | Master Data | Tabel + form mitra sesuai enum kategori |
| Kelola Pengguna | Master Data | Akun Admin dan Direktur |
| Laporan | Laporan | Ringkasan, tindakan, transaksi, piutang, SPK, tenggat, kas/bank; ekspor per jenis data |

## 5. Halaman SPK (Entitas Inti)

### 5.1 Form Input SPK

| Field | Tipe Input | Keterangan | Status |
|---|---|---|---|
| Nomor SPK | Text | Nomor unik. Jika belum ada, tandai sebagai draft/tanpa SPK | Wajib jika SPK sudah terbit |
| Tanggal SPK | Date | Tanggal penerbitan | Opsional saat draft, wajib saat terbit |
| **Tanggal Akhir SPK** | Date | Batas akhir pekerjaan | Opsional |
| Nama Pekerjaan | Text | Nama pekerjaan sesuai dokumen SPK | Wajib |
| Lokasi | Text | Lokasi pekerjaan | Wajib jika tersedia |
| Nilai SPK | Currency/Decimal | Nilai pekerjaan dalam rupiah | Wajib |
| Mitra | Select | PLN / pelanggan / vendor / subkon | Disarankan |
| Sumber / Sheet Lama | Select | Asal pengelompokan data lama (referensi migrasi) | Opsional |
| Status SPK | Select (Enum) | Draft, Terbit, Berjalan, Selesai, Sudah Ditagihkan, Dibatalkan | Wajib |
| Status Tagihan | Select (Enum) | Belum Ditagihkan, Sudah Ditagihkan, Revisi Dokumen, Menunggu Pembayaran, Dibayar | Disarankan |

> 📌 **Keputusan user:** field **PIC** dan **Keterangan** **tidak ada** di form SPK.
>
> ⚠️ **Konsekuensi:** catatan follow-up dari Excel (`sudah diantar ke imperium`, `ada denda`,
> `PAKAI PT BKS`) tidak punya tempat di sistem. Lihat `Schema.md` §5.

### 5.2 Tampilan Modul SPK

| Tampilan | Isi |
|---|---|
| **Table View** | Daftar seluruh SPK, filter nomor/tanggal/lokasi/nilai/status |
| **Board Status SPK** | Kartu SPK dikelompokkan per status: Draft, Terbit, Berjalan, Selesai, Sudah Ditagihkan |
| **Detail SPK** | Data SPK + uang masuk terkait + pengeluaran terkait; tidak menghitung laba-rugi |
| **Filter Tagihan** | Belum ditagihkan, sudah ditagihkan, revisi dokumen, menunggu pembayaran |
| **Dashboard Ringkas** | Total nilai SPK, jumlah per status, nilai sudah ditagihkan, dibayar, outstanding |

## 6. Desain Form Transaksi

### 6.1 Form Uang Masuk — 2 Mode ⭐

Form memiliki **pilihan mode** di bagian atas:

**Mode 1 — Berdasarkan SPK:**

| Field | Tipe | Keterangan |
|---|---|---|
| Pilih SPK | Searchable Select | Dropdown list SPK |
| Tanggal | Date | Default hari ini |
| Nominal | Currency | Format rupiah otomatis |
| Keterangan | Textarea | Catatan pembayaran |
| Bukti | File Upload | TF, gambar, PDF |

**Mode 2 — Manual:**

| Field | Tipe | Keterangan |
|---|---|---|
| Nama Pekerjaan | Text | Input bebas |
| Nomor SPK | Text | Opsional |
| Tanggal | Date | Default hari ini |
| Nominal | Currency | Format rupiah otomatis |
| Keterangan | Textarea | Catatan pembayaran |
| Bukti | File Upload | TF, gambar, PDF |

> **Perilaku:** memilih mode menampilkan field yang sesuai. Mode 1 mengisi `spk_id`
> secara otomatis; Mode 2 membiarkan `spk_id` kosong (uang masuk dari luar SPK).

### 6.2 Form Uang Keluar

| Urutan | Field | Catatan |
|---|---|---|
| 1 | Tanggal Keluar | Default hari ini |
| 2 | Kategori Pengeluaran | Subkon/vendor, material, operasional, upah, transportasi, lainnya |
| 3 | Relasi SPK | Searchable, **opsional** — kosongkan untuk pengeluaran umum |
| 4 | Nominal | Format rupiah otomatis |
| 5 | Penerima | Nama vendor/subkon/staf |
| 6 | Keterangan | Catatan kebutuhan biaya, nomor nota |
| 7 | Bukti | Upload (TF, gambar, PDF) |
| 8 | Tombol Simpan | Konfirmasi sebelum submit untuk nilai besar |

> ⚠️ **Tidak ada field approval.** Uang keluar langsung tercatat saat disimpan
> (keputusan #4 — tidak ada persetujuan Direktur).

## 7. Desain Dashboard

### 7.1 Kartu Ringkasan

| Kartu | Sumber |
|---|---|
| Total Nilai SPK | `SUM(spk.nilai_spk)` |
| Total Uang Masuk | `SUM(uang_masuk.jumlah)` |
| Total Uang Keluar | `SUM(uang_keluar.jumlah)` |
| Total Saldo | Saldo kas + saldo bank, ditampilkan pada widget sesuai peran |

### 7.2 Grafik

Dashboard Admin menampilkan arus kas per bulan, status SPK, dan pengeluaran menurut kategori. Dashboard Direktur berfokus pada indikator ringkas tanpa grafik.

### 7.3 Tabel

Dashboard Admin menampilkan aktivitas terbaru dan SPK berjalan. Data ditarik dari transaksi/SPK aktual, bukan angka contoh.

### 7.4 Rumus Dashboard (dipakai sesuai peran)

| Komponen | Sumber | Rumus |
|---|---|---|
| Total Nilai SPK | `spk` | `SUM(nilai_spk)` |
| Total SPK per Status | `spk` | `COUNT` GROUP BY `status_spk` |
| Total Uang Masuk | `uang_masuk` | `SUM(jumlah)` |
| Uang Masuk dari SPK | `uang_masuk` | `SUM(jumlah) WHERE spk_id IS NOT NULL` |
| Uang Masuk dari Luar | `uang_masuk` | `SUM(jumlah) WHERE spk_id IS NULL` |
| Total Uang Keluar | `uang_keluar` | `SUM(jumlah)` |
| Pengeluaran per Kategori | `uang_keluar` | `SUM(jumlah)` GROUP BY `kategori` |
| Total Saldo | `uang_masuk` + `uang_keluar` | Saldo kas + saldo bank, tanpa membatasi periode |

## 8. Desain Laporan

> Implementasi saat ini berada di `/admin/laporan`; bagian dan ekspor mengikuti tabel di bawah.

- Filter yang tersedia: Bulan Ini, 3 Bulan, 12 Bulan, dan Semua. Ringkasan arus transaksi mengikuti periode; nilai SPK, piutang, saldo, serta daftar SPK menunjukkan posisi saat ini.
- Urutan halaman: pemilih periode, Ringkasan, Perlu Perhatian, arus kas bulanan, tren arus kas, kategori pengeluaran, piutang, daftar SPK, tenggat, buku kas, dan buku bank.
- Piutang memakai rumus `nilai SPK − penerimaan yang terkait SPK`. Uang masuk luar SPK tidak mengurangi piutang.
- Tidak ada laporan laba-rugi, retensi, atau umur piutang.
- Format ekspor per bagian tersedia dalam CSV, XLSX, dan PDF.

| Ekspor | Kolom yang disertakan |
|---|---|
| Uang masuk | Tanggal, nomor SPK, pekerjaan, sumber (SPK/luar SPK), akun, jumlah, keterangan |
| Uang keluar | Tanggal, nomor SPK, pekerjaan, kategori, penerima, akun, jumlah, keterangan |
| Pengeluaran per kategori | Kategori, jumlah transaksi, total |
| Daftar SPK | Nomor SPK, pekerjaan, mitra, tanggal, nilai, diterima, belum diterima, status SPK, status tagihan |
| Piutang | Nomor SPK, pekerjaan, mitra, nilai SPK, diterima, belum diterima, status tagihan, tenggat |
| Tenggat | Nomor SPK, pekerjaan, mitra, tenggat, sisa hari, keterangan tenggat, nilai SPK |
| Buku kas/bank | Tanggal, referensi, keterangan, debet, kredit, saldo berjalan; termasuk saldo awal dan total |
| Arus kas bulanan | Bulan, jumlah transaksi masuk, total masuk, total keluar, selisih |

- Semua ekspor mengikuti filter periode transaksi; daftar SPK/piutang/tenggat memakai posisi terkini sesuai makna datanya.
- Format rupiah di UI/ekspor tidak mengubah nominal tersimpan.
- Tabel panjang dapat digulir horizontal pada layar sempit; seluruh isi tetap tersedia.
- Tampilan harus diuji pada desktop, tablet, mobile, tema terang/gelap, serta keadaan kosong.

## 9. Desain Upload Bukti

Karena bukti disimpan sebagai kolom di tabel transaksi (bukan tabel terpisah):

| Field | Tipe | Deskripsi | Validasi |
|---|---|---|---|
| Bukti | File Upload | Bukti transfer, gambar, PDF | MIME yang diizinkan form, batas ukuran sesuai konfigurasi form |
| **Jumlah file** | Repeater/multi-upload | Satu atau lebih file sesuai mode input | Tidak ada batas jumlah tetap |
| Preview | Thumbnail/tautan privat | Pratinjau gambar dan akses PDF | Login diperlukan |
| Hapus | Tombol | Menghapus berkas yang dipilih | Aksi terautorisasi |

**Ketentuan penyimpanan:**
- Bukti transaksi, dokumen SPK, avatar, dan tanda tangan berada pada disk privat.
- File dilayani melalui route yang memerlukan autentikasi; jangan gunakan URL disk publik.
- Kolom `bukti` dan `dokumen` menyimpan path sebagai JSON array.
- Format nama/folder mengikuti `PenyimpanBerkas`; jangan mengasumsikan `storage/app/public`.

## 10. State yang Wajib Dirancang

| State | Ketentuan |
|---|---|
| **Loading** | Skeleton loader pada tabel & dashboard |
| **Empty** | Pesan jelas + CTA untuk menambah data |
| **Error** | Pesan mudah dipahami, tanpa stack trace di production |
| **Success** | Toast/notifikasi setelah simpan/upload |
| **Terhapus** | Badge abu-abu untuk data soft-deleted |

## 11. Responsive & Accessibility

- Target utama: **mobile, tablet, desktop**.
- Kontras warna memadai.
- Navigasi dapat digunakan dengan **keyboard**.
- Semua field punya **label** yang dapat dibaca screen reader.
- **Jangan** mengandalkan warna saja untuk menyampaikan status.
- Ukuran tombol dan area sentuh nyaman di mobile.
- Halaman input transaksi dioptimalkan untuk input dari HP.

## 12. Visual Language

Kartu dengan radius moderat, whitespace cukup, ikon sederhana, hierarki heading konsisten.
**Hindari dashboard yang padat** atau dekorasi yang mengganggu tugas utama.

> 📌 **Catatan:** bagian *Website Publik*, *Hero section*, *Peta Leaflet/OpenStreetMap*,
> dan *PWA* **tidak berlaku** — sistem murni internal.

## 13. Item Desain yang Menunggu Keputusan

| No | Item | Menunggu |
|---|---|---|
| 1 | **Upload dokumen SPK** (BAST, kuitansi, scan) | ✅ Selesai — kolom `spk.dokumen` (JSON), lihat `Schema.md` |
| 2 | **Rekening Koran** sebagai menu tersendiri | Format file belum ada |
| 3 | **To-Do List** sebagai modul aplikasi | Opsional |

---

*Keputusan user 19 September 2026 sudah diterapkan.*
