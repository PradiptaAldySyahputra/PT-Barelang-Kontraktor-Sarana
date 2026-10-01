# AUDIT MENU & ALUR BISNIS

> **Proyek:** Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana
> **Tanggal audit:** 29 September 2026
> **Sifat:** Hasil pemeriksaan kode vs `docs/PRD.md` + `docs/Rules.md`
>
> ⚠️ **Catatan:** dokumen ini **melaporkan temuan**, bukan memutuskan perubahan.
> Perubahan alur bisnis adalah **keputusan perusahaan** — agent tidak menebak.

---

## 1. Peta Menu Saat Ini

| Urutan | Grup | Menu | Sort | Hak |
|:------:|:-----|:-----|:----:|:----|
| 1 | — | Dashboard | -10 | Admin + Direktur |
| 2 | **SPK** | List SPK | 1 | Admin (ubah) · Direktur (lihat) |
| 3 | SPK | Status SPK | 2 | pantau |
| 4 | SPK | Tagihan SPK | 3 | pantau |
| 5 | SPK | Tagihan Selesai SPK | 4 | pantau |
| 6 | **Keuangan** | Uang Masuk | 11 | Admin (ubah) · Direktur (lihat) |
| 7 | Keuangan | Uang Keluar | 12 | Admin (ubah) · Direktur (lihat) |
| 8 | **Master Data** | Mitra | 21 | Admin |
| 9 | Master Data | Pengguna | 22 | Direktur |
| 10 | **Laporan** | Laporan | 31 | Admin + Direktur |

**Halaman aksi khusus SPK:** `UbahStatusSpk`, `UbahStatusTagihan` (form terpisah).

---

## 2. Alur Bisnis yang Berjalan

```
Login
  │
  ├─► Master Data (Mitra)
  │
  ├─► SPK  ────────────┐
  │     List SPK       │  Tambah / Edit / Hapus
  │     Status SPK     │  Ubah Status (form terpisah)
  │     Tagihan SPK    │  Ubah Status Tagihan · Catat Pembayaran
  │     Tagihan Selesai│  Perbaiki Status
  │                    │
  ├─► Keuangan ◄───────┘  (transaksi dikaitkan ke SPK)
  │     Uang Masuk        Mode 1 (pilih SPK) / Mode 2 (manual)
  │     Uang Keluar       Multi-baris + nota (total/rinci)
  │
  ├─► Sistem hitung otomatis: piutang, status tagihan
  │
  └─► Laporan ──► Ekspor Excel / PDF / CSV
```

**Siklus status SPK:**
`Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan` (⇢ `Dibatalkan`)

**Siklus status tagihan:**
`Belum Ditagihkan → Sudah Ditagihkan → Revisi Dokumen → Menunggu Pembayaran → Dibayar`

> 📌 Status tagihan **disinkronkan otomatis** dari pembayaran nyata
> (`SinkronStatusTagihanObserver`) — bukan diubah manual.

---

## 3. Temuan: Celah Alur Bisnis

### 🔴 T-1. Validasi "SPK Dibatalkan tidak menerima transaksi" — ✅ **DIPERBAIKI 29 Sep 2026**

| | |
|:--|:--|
| **Aturan** | `Rules.md` §5 butir 3: *"SPK berstatus `Dibatalkan` tidak menerima transaksi baru kecuali ada override khusus oleh Admin."* |
| **Kenyataan (sebelum)** | `grep` di `UangMasukForm`, `UangKeluarForm` → **tidak ada** pemeriksaan `Dibatalkan` |
| **Dampak** | Transaksi bisa masuk ke SPK yang sudah dibatalkan → laporan piutang salah |
| **Perbaikan** | Validasi `->rules()` di kedua form, memakai `StatusSpk::bolehTransaksiBaru()` yang sudah ada |
| **Bukti** | `tests/Feature/SpkDibatalkanTidakTerimaTransaksiTest.php` (5 tes) |

> ⚠️ **PITFALL yang ditemukan saat memperbaiki:** validasi di `UangKeluarForm`
> awalnya ditaruh di dalam `when($wajib, ...)`. Repeater `pengeluaran` memakai
> `fieldInti(false)`, jadi aturan itu **tidak pernah dijalankan** di halaman
> Tambah. Sudah dipindahkan **ke luar** `when()`.

### 🔴 T-1b. Factory Spk memakai status ACAK → tes FLAKY — ✅ **DIPERBAIKI**

| | |
|:--|:--|
| **Temuan** | `database/factories/SpkFactory.php` memakai `fake()->randomElement(StatusSpk::cases())` |
| **Dampak** | Setelah T-1 ditegakkan, tes lama kadang dapat SPK `Dibatalkan` → **lulus/gagal tanpa perubahan kode** |
| **Bukti flaky** | 2 tes lama gagal (`BatasUangMasukTest`, `FilamentResourceTest`) padahal tidak ada yang salah di kode produksi |
| **Perbaikan** | Default factory → `StatusSpk::Berjalan` (deterministik); tes yang butuh status lain pakai state eksplisit |
| **Verifikasi** | Suite dijalankan **3× berturut-turut**: 521 lulus setiap kali |

> 📌 **Ini temuan penting:** tes flaky berbahaya karena membuat orang tidak
> percaya hasil tes. Sekarang sudah deterministik.

### 🟡 T-2. Halaman DETAIL SPK belum ada (FR-SPK-005)

| | |
|:--|:--|
| **Aturan** | `PRD.md` FR-SPK-005 (prioritas **High**): *"Sistem menampilkan detail SPK: data lengkap, uang masuk terkait, pengeluaran terkait"* |
| **Kenyataan** | Tidak ada `ViewSpk.php`; tidak ada `RelationManager` untuk uang masuk/keluar |
| **Yang ada** | Hanya `withSum('uangMasuk')` di query resource — angka total, bukan daftar transaksi |
| **Dampak** | Admin tidak bisa melihat **transaksi mana saja** milik satu SPK dalam satu halaman. Untuk itu harus membuka menu Uang Masuk lalu memfilter SPK (sudah bisa sejak 29 Sep, tapi tidak dari halaman SPK) |
| **Jenis** | **Fitur kurang** — kebutuhan High yang belum dikerjakan |

### 🟡 T-3. Rekening Koran belum ada (PRD §4.3)

| | |
|:--|:--|
| **Status dokumen** | *"Belum pasti — kemungkinan jadi sumber validasi/rekonsiliasi"* |
| **Kenyataan** | Tidak ada menu/impor |
| **Butuh keputusan** | Format file & perannya (validasi vs pencatatan) — `PRD.md` §9 butir 4 |

### 🟡 T-4. To-Do List / follow-up belum ada (PRD §4.3)

| | |
|:--|:--|
| **Status dokumen** | *"Opsional — belum tentu masuk MVP"* |
| **Terkait** | Kolom `keterangan` pada SPK **sudah dihapus** (keputusan user), padahal setiap baris Excel lama punya catatan follow-up |
| **Butuh keputusan** | Perlu menu baru, atau cukup memakai kolom yang ada? |

---

## 4. Temuan: Alur yang Sudah Baik (tidak perlu diubah)

| Aspek | Bukti |
|:------|:------|
| Status diubah lewat form terpisah (bukan dari edit) | `UbahStatusSpk`, `UbahStatusTagihan` — sesuai permintaan user |
| Status tagihan sinkron otomatis | `SinkronStatusTagihanTest` |
| Uang masuk dibatasi piutang | `BatasUangMasukTest` |
| Nota multi-baris (mode total/rinci) | `NotaSekaligusTest`, `BencanaSatuNotaTest` |
| Filter SPK di uang masuk/keluar | `FilterSpkUangTest` (29 Sep) |
| Validasi tanggal ≤ hari ini | `ValidasiTanggalTransaksiTest` (29 Sep) |
| Ekspor Excel/PDF/CSV | `EksporLaporanXlsxTest`, `EksporLaporanPdfTest` (29 Sep) |

---

## 5. Ringkasan Prioritas (usulan, menunggu keputusan)

| # | Temuan | Jenis | Prioritas usulan |
|:-:|:-------|:------|:-----------------|
| T-1 | Validasi SPK Dibatalkan | **Bug** (aturan tertulis tidak dipakai) | 🔴 **1** |
| T-2 | Detail SPK (FR-SPK-005) | Fitur kurang (High) | 🟡 2 |
| T-3 | Rekening Koran | Fitur baru | ⚪ butuh keputusan |
| T-4 | To-Do List | Fitur baru | ⚪ butuh keputusan |

---

## 6. Yang Perlu Keputusan Pengguna

1. **T-1** — boleh saya perbaiki? (memenuhi `Rules.md` §5 butir 3 yang sudah ada)
2. **T-2** — detail SPK mau seperti apa? Halaman khusus, atau panel di halaman edit?
3. **T-3, T-4** — masuk MVP atau ditunda?
4. **Perubahan/penambahan lain** yang belum tercakup audit ini — mohon disebutkan.

---

*Audit ini memeriksa kode nyata, bukan rencana. Setiap temuan disertai bukti
berkas/baris. Tidak ada perubahan alur bisnis yang dilakukan tanpa persetujuan.*
