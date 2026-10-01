# Design — UI/UX & Design Guidelines
## Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana

> Panel admin Filament (`/admin`). Role 2 · tanpa halaman approval · tanpa menu
> Proyek/Master Data · form uang masuk 2 mode.

---

## 1. Prinsip Desain UI/UX

1. **Dashboard admin sederhana dan bersih** — fokus pada angka dan tabel.
2. **Kejelasan data finansial** — **hijau = pemasukan/untung**, **merah = pengeluaran/rugi**,
   konsisten di seluruh aplikasi.
3. **Navigasi sidebar tetap**, mengikuti modul utama: **Dashboard, Master Data, Transaksi, Laporan**.
4. **Mobile-friendly** untuk halaman input transaksi — Admin sering input dari lokasi pekerjaan.
5. **Istilah operasional perusahaan** — form memakai istilah sehari-hari (SPK, termin, retensi,
   BAST) agar Admin tidak perlu pelatihan kompleks.
6. **Selalu sediakan kolom Keterangan** pada setiap form transaksi agar konteks tidak hilang.

## 2. Design System

| Aspek | Ketentuan |
|---|---|
| **Primary color** | Blue-700 atau token warna institusi yang disepakati |
| **Warna semantik** | Hijau = pemasukan/untung; Merah = pengeluaran/rugi; Abu = arsip/dibatalkan |
| **Warna netral** | `slate` untuk teks dan elemen netral; putih untuk permukaan utama |
| **Typography** | Inter atau Poppins dengan fallback sans-serif |
| **Komponen** | Kartu radius moderat, whitespace cukup, ikon sederhana, hierarki heading konsisten |
| **Prinsip** | Mobile-first, jelas, ramah pengguna, konsisten, aksesibel |

> ⚠️ **Jangan mengandalkan warna saja** untuk menyampaikan status — sertakan label teks/ikon.

## 3. Struktur Navigasi Sidebar

> ⚠️ **SUDAH DIIMPLEMENTASI di Filament** (`/admin`). Sidebar bisa
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
    └── Laporan Keuangan    (satu halaman, 7 bagian + 7 ekspor CSV)

Pengaturan
    └── Pengguna
```

**Isi halaman Laporan** (satu halaman, bukan banyak menu):

| Bagian | Isi |
|---|---|
| Ringkasan | Uang masuk · keluar · saldo · **piutang lancar** · retensi ditahan |
| Peringatan Tenggat | SPK lewat tenggat & mendekati tenggat |
| **Umur Piutang (Aging)** | 0-30 · 31-60 · 61-90 · >90 · tanpa tanggal |
| Arus Kas per Bulan | Masuk, keluar, selisih |
| Laba-Rugi per SPK | Penerimaan − biaya, + piutang lancar & retensi |
| Pengeluaran per Kategori | Total + bar proporsi |
| Piutang SPK | Umur hari, retensi, diterima, piutang lancar |

**Ekspor CSV (7 jenis):** Daftar SPK · Laba-Rugi · Piutang · **Aging** ·
**Tenggat** · Arus Kas · Kategori.

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
| Master Mitra | Data Mitra | Tabel + form mitra (PLN, vendor, subkon, pelanggan) |
| Laporan SPK | Laporan | Daftar SPK + filter + total |
| Laporan Cashflow | Laporan | Perbandingan uang masuk vs keluar per periode |
| Laporan SPK Belum Dibayar | Laporan | Piutang per SPK + umur piutang |
| Laporan Laba-Rugi per SPK | Laporan | Penerimaan − biaya per SPK |

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
| **Retensi (%)** | Number | Default 5% untuk SPK subkon/vendor | Opsional |
| **Nilai Retensi** | Currency | Terhitung otomatis dari nilai SPK × persentase | Read-only |

> 📌 **Keputusan user:** field **PIC** dan **Keterangan** **tidak ada** di form SPK.
>
> ⚠️ **Konsekuensi:** catatan follow-up dari Excel (`sudah diantar ke imperium`, `ada denda`,
> `PAKAI PT BKS`) tidak punya tempat di sistem. Lihat `Schema.md` §5.

### 5.2 Tampilan Modul SPK

| Tampilan | Isi |
|---|---|
| **Table View** | Daftar seluruh SPK, filter nomor/tanggal/lokasi/nilai/status |
| **Board Status SPK** | Kartu SPK dikelompokkan per status: Draft, Terbit, Berjalan, Selesai, Sudah Ditagihkan |
| **Detail SPK** | Data lengkap + uang masuk terkait + pengeluaran terkait + perhitungan laba-rugi |
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
| Saldo Bersih | Uang masuk − uang keluar |
| Total Piutang SPK | Nilai SPK − penerimaan |

### 7.2 Grafik

- **Line/Bar:** Uang masuk vs uang keluar per bulan (6–12 bulan terakhir).
- **Bar:** Perbandingan nilai SPK, penerimaan, biaya, estimasi margin.

### 7.3 Tabel

- Daftar SPK berjalan beserta status tagihan, penerimaan, biaya, estimasi laba/rugi.

### 7.4 Rumus Dashboard

| Komponen | Sumber | Rumus |
|---|---|---|
| Total Nilai SPK | `spk` | `SUM(nilai_spk)` |
| Total SPK per Status | `spk` | `COUNT` GROUP BY `status_spk` |
| Total Uang Masuk | `uang_masuk` | `SUM(jumlah)` |
| Uang Masuk dari SPK | `uang_masuk` | `SUM(jumlah) WHERE spk_id IS NOT NULL` |
| Uang Masuk dari Luar | `uang_masuk` | `SUM(jumlah) WHERE spk_id IS NULL` |
| Total Uang Keluar | `uang_keluar` | `SUM(jumlah)` |
| Pengeluaran per Kategori | `uang_keluar` | `SUM(jumlah)` GROUP BY `kategori` |
| Saldo Bersih | keduanya | Uang masuk − uang keluar |
| Piutang per SPK | `spk` + `uang_masuk` | `nilai_spk` − penerimaan SPK tsb |
| Laba-Rugi per SPK | `uang_masuk` + `uang_keluar` | Penerimaan − Biaya SPK tsb |

## 8. Desain Laporan

> ✅ **SUDAH DIIMPLEMENTASI** di `/admin/laporan` (satu halaman, 7 bagian).

- Semua laporan memiliki **filter periode**: Bulan Ini · 3 Bulan · 12 Bulan · Semua.
- **Ekspor CSV** (7 jenis) lewat dropdown — bukan tombol PDF/Excel terpisah.
  CSV dipilih karena bisa langsung dibuka di **Excel**, aplikasi yang selama ini
  dipakai perusahaan. Pemisah `;` + BOM UTF-8 agar Excel membaca karakter benar.
- **Laporan Piutang** — memakai **piutang LANCAR** (retensi ditahan dikurangi),
  dilengkapi **umur piutang (aging)**: 0-30 · 31-60 · 61-90 · >90 hari.
- **Peringatan Tenggat** — SPK lewat tenggat (merah) & mendekati tenggat (kuning).
- **Laporan Cashflow** — perbandingan uang masuk vs keluar per bulan.
- **Laporan Laba-Rugi per SPK** — Penerimaan − Pengeluaran = Estimasi Laba/Rugi,
  plus kolom **Piutang Lancar** dan **Retensi Ditahan**.
- Format tampilan rupiah **tidak boleh** mengubah nilai asli di database.
- **Responsif**: kartu 1→2→4 kolom; tabel punya **versi kartu** untuk layar kecil.
- Angka memakai **tabular-nums** agar mudah dibandingkan; selisih/laba bertanda **+ / −**.

## 9. Desain Upload Bukti

Karena bukti disimpan sebagai kolom di tabel transaksi (bukan tabel terpisah):

| Field | Tipe | Deskripsi | Validasi |
|---|---|---|---|
| Bukti | File Upload | Transfer (TF), gambar, PDF | JPG/PNG/PDF; maks 10 MB per file |
| **Jumlah file** | — | ✅ **BEBAS** — bisa 1, bisa banyak sesuai kebutuhan | Tidak dibatasi |
| Preview | Thumbnail | Pratinjau gambar setelah upload | — |
| Hapus | Tombol | Hapus file yang salah upload | Konfirmasi modal |

**Ketentuan penyimpanan:**
- Folder terstruktur: `storage/app/public/uang_masuk/`, `storage/app/public/uang_keluar/`.
- Nama file unik (timestamp/UUID).
- File hanya dapat diakses user yang sudah login.
- Disimpan sebagai **JSON array** di kolom `bukti` — jumlah file bebas.

> ⚠️ **Menunggu keputusan:** apakah dokumen SPK (BAST, kuitansi, scan) disimpan di sistem (§13).

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
