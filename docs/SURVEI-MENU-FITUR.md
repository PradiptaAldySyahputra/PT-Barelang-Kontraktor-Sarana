# SURVEI MENU, FITUR & ALUR BISNIS

> **Tujuan:** memetakan kondisi nyata aplikasi, membandingkan dengan dokumen
> kebutuhan (PRD/Rules), dan menyusun daftar **perlu diperbaiki / diperbarui /
> ditambah / diuji**.
>
> **Tanggal survei:** 10 Oktober 2026
> **Metode:** pembacaan kode langsung (bukan ingatan) + suite tes (707 lulus) +
> dokumen PRD.md, Rules.md, Schema.md, Architecture.md.
> **Sifat:** read-only (belum ada perubahan kode dari survei ini).

---

## 1. PETA MENU (kondisi nyata)

| # | Menu | Grup | Resource/Page | Peran lihat | Peran input | Ekspor |
|:-:|:-----|:-----|:--------------|:-----------:|:-----------:|:------:|
| -10 | Dashboard | — | `Dashboard` + 5 widget | Admin, Direktur | — | — |
| 1 | List SPK | SPK | `SpkResource` | ✅ keduanya | Admin | Excel+PDF |
| 2 | Status SPK | SPK | `StatusSpkResource` | ✅ keduanya | Admin (via UbahStatusSpk) | Excel+PDF |
| 3 | Tagihan SPK | SPK | `TagihanSpkResource` | ✅ keduanya | Admin (Catat Pembayaran) | Excel+PDF |
| 4 | Tagihan Selesai SPK | SPK | `TagihanSelesaiSpkResource` | ✅ keduanya | — | Excel+PDF |
| 11 | Uang Masuk | Keuangan | `UangMasukResource` | ✅ keduanya | Admin | Excel+PDF |
| 12 | Uang Keluar | Keuangan | `UangKeluarResource` | ✅ keduanya | Admin | Excel+PDF |
| 21 | Mitra | Master Data | `MitraResource` | ✅ keduanya | Admin | Excel+PDF |
| 22 | Pengguna | Master Data | `PenggunaResource` | **Direktur** | Direktur | Excel+PDF |
| 31 | Laporan | Laporan | `Laporan` | ✅ keduanya | — | Excel+PDF+CSV |
| — | Profil Saya | (menu user) | `ProfilAkun` | ✅ | ✅ | — |
| — | Login / Lupa Password | (auth) | `LupaPassword` | tamu | — | — |

**Catatan menu:** struktur navigasi sudah rapi & sesuai AGENTS.md §5. Tidak ada
menu yatim atau menu tanpa fungsi.

---

## 2. PEMETAAN ALUR BISNIS ↔ KODE

| Alur bisnis | Status | Bukti |
|:------------|:------:|:------|
| Admin buat SPK → status Draft | ✅ | `CreateSpk` + `mutateFormDataBeforeCreate` |
| Ubah status pekerjaan (terpisah) | ✅ | `UbahStatusSpk` |
| Ubah status tagihan (terpisah) | ✅ | `UbahStatusTagihan` |
| Catat pembayaran (sebagian/penuh) | ✅ | `CatatPembayaran` + guard Dibatalkan (fix 10 Okt) |
| Status tagihan sinkron otomatis | ✅ | `SinkronStatusTagihanObserver` |
| Uang masuk ≤ piutang SPK | ✅ | `BatasUangMasukTest` |
| SPK Dibatalkan tolak transaksi baru | ✅ | `SpkDibatalkanTidakTerimaTransaksiTest` |
| Tanggal transaksi ≤ hari ini | ✅ | `ValidasiTanggalTransaksiTest` |
| Soft delete + restore | ✅ | `RestoreAction` |
| Backup harian otomatis | ⚠️ | `bks:backup` + Scheduler — **tanpa tes** |
| OCR nota (bantuan, bukan penentu) | ✅ | `PembacaNota` + cache + fallback |
| Ekspor Excel/PDF/CSV semua menu | ✅ | `Ekspor*Test` |

---

## 3. TEMUAN — PERLU DIPERBAIKI (prioritas)

### 🔴 P1 — `ForceDeleteAction` (hapus permanen) menyalahi Rules §2.9
- **Lokasi:** `EditUangMasuk.php:46`, `EditUangKeluar.php:46`
- **Masalah:** Rules §2.9 berbunyi *"Transaksi tidak boleh dihapus permanen —
  gunakan soft delete dengan jejak audit."* Namun kedua halaman menyediakan
  tombol **"Hapus Permanen"** tanpa pembatasan peran maupun konfirmasi ekstra.
- **Dampak:** data keuangan bisa hilang **tak bisa dipulihkan** — bertentangan
  dengan kebijakan perusahaan dan berisiko saat audit/pajak.
- **BUKTI (tes survei 10 Okt 2026):** Admin berhasil memanggil `forceDelete` dan
  baris `uang_keluar` **hilang dari database** (`assertDatabaseMissing` lulus).
  Jadi bukan sekadar tombol tampil — benar-benar bisa dieksekusi.
- **Rekomendasi:** hapus `ForceDeleteAction` dari kedua halaman (paling aman),
  ATAU batasi hanya Direktur + wajib konfirmasi ketik ulang. Butuh keputusan.
- **Tes:** belum ada (0 tes) — tes bukti survei dijalankan lalu dihapus (read-only).

### 🟠 P2 — `bks:backup` tidak diuji
- **Lokasi:** `app/Console/Commands/BackupDatabase.php`
- **Masalah:** fitur kritikal (backup database harian, retensi 30 hari) **tanpa
  automated test**. Kalau rusak diam-diam, data keuangan tak ter-backup.
- **Rekomendasi:** tambah tes yang menjalankan `bks:backup` (mode kering/uji)
  dan memastikan berkas terbentuk + retensi bekerja.

### 🟠 P3 — Override "SPK Dibatalkan" (Rules §5.3) belum ada jalannya
- **Lokasi:** `UangMasukForm`, `UangKeluarForm`
- **Masalah:** Rules §5.3 menyebut *"...kecuali ada override khusus oleh Admin."*
  Kode **selalu menolak**; tidak ada mekanisme override. Dokumen menjanjikan
  sesuatu yang belum ada.
- **Dampak:** rendah (keamanan lebih ketat dari dokumen) — tapi **dokumen dan
  kode tidak sinkron**. Perlu salah satu: implementasi override, atau perbarui
  Rules agar tidak menjanjikan override.

### 🟡 P4 — Dokumen menyebut fitur yang sudah dihapus
- **Lokasi:** `docs/Rules.md` §2.16 (Aging piutang), `docs/PRD.md` §9 (hal lama)
- **Masalah:** Rules §2.16 masih mendeskripsikan **aging piutang** seolah dipakai,
  padahal user sudah memutuskan **tidak** dipakai dan kode tidak punya
  `kategoriUmur()`. Dokumen menyesatkan pembaca berikutnya.
- **Rekomendasi:** tandai §2.16 sebagai ❌ DIHAPUS (selaras dengan retensi & laba-rugi).

### 🟡 P5 — `nilaiTagih()` dirujuk dokumen tapi tidak ada di kode
- **Lokasi:** `docs/Rules.md` §2.15 menyebut `nilaiTagih()`.
- **Kenyataan:** model memakai `piutang()`/`sisaTagih()`. Nama di dokumen basi.
- **Rekomendasi:** samakan nama di dokumen.

---

## 4. PERLU DIPERBARUI (UI/UX & konsistensi)

| # | Item | Kondisi | Saran |
|:-:|:-----|:--------|:------|
| U1 | Halaman **Profil** masih minimal | Nama, Email, Password saja | Tambah foto/avatar, info peran & login terakhir, preferensi tema |
| U2 | Belum ada **tanda tangan** di blok PDF | Blok "Disetujui oleh" kosong | Tanda tangan Direktur tersimpan per akun |
| U3 | Docblock `Laporan.php` masih menyebut aging | Baris 46 | Hapus baris sisa agar tidak menyesatkan |
| U4 | Judul submenu "Tagihan SPK" pakai badge angka | Sudah ada | Cek konsistensi saat data kosong (0) |

---

## 5. PERLU DITAMBAH (fitur — butuh keputusan bisnis)

| # | Fitur | Alasan | Status |
|:-:|:------|:-------|:-------|
| T1 | **Tanda tangan digital** Direktur → PDF | Blok ttd PDF sudah ada, tinggal sumbernya | ✅ **SELESAI 10 Okt 2026** |
| T2 | **Saldo berjalan Kas/Bank** (B1 lama) | Filter akun ada, saldo kumulatif belum | ✅ **SELESAI 10 Okt 2026** |
| T3 | **Ekspor format perusahaan** (B4 lama) | Terikat T2 | ✅ **SELESAI 11 Okt 2026** — Buku Kas/Bank (B2-11) |
| T4 | **Rekening koran** (PRD §4.3 "fitur calon") | Untuk rekonsiliasi | ⏳ Belum — butuh keputusan |
| T5 | **Import data lama 2024–2026** (PRD §9.7) | Migrasi data historis | ⏳ Belum — butuh data asli |
| T6 | **Ganti password paksa** saat login pertama | Keamanan akun baru | ⏳ Belum — user bilang "lanjutkan selain ini" |
| T7 | **Notifikasi tenggat** (email/WA) | SPK lewat tenggat | ⏳ Belum — butuh keputusan kanal |

> **Sesi 11 Okt 2026 (B1 + B2)** menambah: `app:buat-admin`, tabel `notifications`,
> notifikasi ekspor, halaman Backup & Restore, halaman Status Sistem, **menu Arsip
> Nota** (filter + unduh + ZIP), dan **ekspor Buku Kas/Bank**. Lihat
> `STATUS-PENGERJAAN.md` §0g.

> ⚠️ **JANGAN tambah** yang sudah diputuskan final TIDAK dipakai: aging piutang,
> laba-rugi per SPK, retensi, approval, audit log, entitas PROYEK.

---

## 6. PERLU DIUJI MENYELURUH (celah cakupan tes)

**Suite saat ini:** 707 lulus · 1.909 assertions · 86 file Feature + 3 Unit.

| Area | Cakupan | Celah |
|:-----|:-------:|:------|
| Auth & peran | 🟢 baik | — |
| Uang masuk/keluar (nominal) | 🟢 baik | — |
| SPK & status | 🟢 baik | — |
| Ekspor | 🟢 baik | — |
| OCR | 🟢 baik | — |
| **Backup** | 🔴 **0 tes** | P2 |
| **Hapus permanen** | 🔴 **0 tes** | P1 |
| **Mitra** | 🟡 1 tes | CRUD lengkap belum |
| **Profil/akun** | 🟡 2 tes | belum uji ganti password sungguhan di browser |
| **Dashboard widget** | 🟡 2 tes | angka kartu vs DB belum diuji ketat |
| **Laporan angka** | 🟡 sebagian | rekonsiliasi total vs DB per periode |

---

## 7. RINGKASAN PRIORITAS

| Prioritas | Item | Jenis | Perlu keputusan? |
|:---------:|:-----|:------|:----------------:|
| 1 | Hapus/batasi `ForceDeleteAction` | Perbaiki | ✅ |
| 2 | Tes `bks:backup` | Uji | ❌ |
| 3 | Sinkronkan dokumen (aging, override, `nilaiTagih`) | Perbarui | ❌ |
| 4 | Lengkapi halaman Profil | Perbarui | ✅ |
| 5 | Tanda tangan digital PDF | Tambah | ✅ |
| 6 | Tes CRUD Mitra + dashboard angka | Uji | ❌ |
