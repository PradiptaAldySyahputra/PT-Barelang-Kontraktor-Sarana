# STATUS PENGERJAAN — Titik Lanjut Sesi

> Dibuat agar sesi berikutnya bisa **lanjut tanpa menebak**.
> Bahasa: Indonesia. Verifikasi ulang sebelum menulis angka/nama (aturan AGENTS.md §2.5).
>
> **Terakhir diperbarui:** 11 Oktober 2026
> **Cabang:** `main` · Perubahan sesi ini **belum di-commit** (aturan: user yang commit)

---

## 0k. Sesi 11 Okt 2026 (lanjutan 4) — Struktur folder nota bertanggal (B2-7)

Melengkapi B2-7: berkas nota **BARU** kini disimpan di
`storage/app/nota/{uang_keluar|uang_masuk}/{tahun}/{bulan}/{tanggal}/` sesuai
dokumen. **Berkas LAMA dibiarkan** (jalan tengah — tanpa migrasi berisiko):
Arsip Nota membaca PATH dari kolom `bukti` di DB, jadi kedua struktur hidup
berdampingan.

| Perubahan | Bukti |
|:----------|:------|
| `PenyimpanBerkas::simpanKe(..., ?Carbon $tanggal)` → sub-folder `Y/m/d` | `PenyimpanNotaStrukturTest` (4) |
| **Perbaikan bug**: `ocr:bersihkan` membaca disk `public` (salah) → `nota` | `PerbaikanBugTest` (2) |
| **Perbaikan bug**: pemindaian potongan non-rekursif → `allFiles()` (rekursif) | `test_potongan_nota_bertanggal_tidak_dianggap_yatim` |

⚠️ Dua bug ditemukan saat mengerjakan ini (keduanya pre-existing):
1. `BersihkanPotonganOcr` membaca disk `public` padahal potongan OCR ada di disk
   privat `nota` → perintah **tidak pernah menemukan** potongan apa pun.
2. Pemindaian `files('uang_keluar')` non-rekursif → nota di sub-folder bertanggal
   akan dianggap "yatim" & potongan OCR-nya terhapus. Sudah diperbaiki
   (`allFiles()`).

Diverifikasi: `tinker` → path `uang_keluar/2026/08/01/nota-....png`; browser
Arsip Nota tetap normal (3 nota, 2 thumbnail gambar).

**Suite:** 823 lulus · 2.251 assertions · 0 risky · pint bersih.

---

## 0j. Sesi 11 Okt 2026 (lanjutan 3) — Thumbnail Arsip Nota

Menindaklanjuti inventaris B2-7 (dokumen minta "tiap baris: **thumbnail** + info
transaksi"). Sebelumnya Arsip Nota hanya menampilkan nama berkas.

| Perubahan | Bukti |
|:----------|:------|
| Thumbnail gambar per baris di Arsip Nota | `ArsipNota::gambar()` + kolom "Nota" di view + 4 tes baru |

- Gambar (jpg/jpeg/png/webp/gif/bmp) → `<img>` 48×48 (`loading=lazy`, ring).
- PDF / berkas bukan gambar → ikon dokumen; berkas hilang → ikon peringatan.
- Diverifikasi browser: 2 nota JPG ter-render sebagai `<img>` (naturalWidth=420),
  PDF pakai ikon.

### ⚠️ Keputusan struktur folder nota (B2-7) — TIDAK diubah

Dokumen minta `storage/nota/{tahun}/{bulan}/{tanggal}/`; sekarang
`storage/app/nota/{uang_keluar|uang_masuk}/`. **Keputusan: biarkan struktur
sekarang.** Alasan:
- Arsip Nota memfilter dari kolom `tanggal` **di database**, bukan dari nama
  folder → struktur folder **tidak memengaruhi** fungsi cari/unduh/ZIP.
- Memindah struktur berisiko: perintah `ocr:bersihkan` (`BersihkanPotonganOcr`)
  memindai berkas hanya di `uang_keluar/` (baris 133) → nota di folder bertanggal
  akan dianggap "yatim" dan potongan OCR-nya terhapus. Perlu perbaikan perintah
  itu lebih dulu; manfaatnya hanya kerapian manual → tidak sepadan untuk MVP.

### ⚠️ Restore backup (B1-4) — TIDAK ditambahkan

Dokumen minta "unduh & restore". **Keputusan user: tidak** — restore menimpa
database (berisiko). Halaman Backup tetap menyediakan **unduh** + panduan manual.

### B3-14 Log Aktivitas — DILEWATI

Dokumen menyebut "nanti", tapi bertentangan dengan keputusan final "audit log
DIHAPUS" (Rules §10). **Keputusan user: lewati.**

**Suite:** 818 lulus · 2.241 assertions · 0 risky · pint bersih.

---

## 0i. Sesi 11 Okt 2026 (lanjutan 2) — Menu "Ekspor & Unduhan"

Melanjutkan peta menu bagian C yang belum dibuat: **"Ekspor & Unduhan"**
(riwayat ekspor + notifikasi). B1-2 baru menyediakan tabel `notifications`;
halamannya belum ada.

| Fitur | Status | Bukti |
|:------|:------:|:------|
| Halaman **Ekspor & Unduhan** (riwayat ekspor, grup Laporan) | ✅ | `RiwayatEkspor.php` + `EksporUnduhanPage.php` + `EksporUnduhanTest` (10) |

- Data dari tabel `exports` bawaan Filament — **tanpa tabel baru**.
- Status: **Sedang diproses** / **Selesai** / **Selesai (ada baris gagal)**;
  kolom baris sukses/total + gagal.
- Tombol **Unduh** muncul hanya bila berkas benar-benar ada.
- Route unduh ulang aman: Admin hanya ekspornya sendiri, Direktur semua;
  belum selesai / berkas hilang → 404; path dari DB (bukan input user).
- Diverifikasi di browser: halaman tampil di grup **Laporan** dengan baris
  riwayat nyata dari DB.

**Suite:** 815 lulus · 2.231 assertions · 0 risky · pint bersih.

---

## 0h. Sesi 11 Okt 2026 (lanjutan) — B3 Nice-to-have

User: *"yang ttd jangan dulu karna belum ada permintaan, user yang ditunda jangan
dikerjakan juga, jadi lanjut implementasi."* → TTD (T1) **tidak disentuh**; item
tertunda (T4–T7) **tidak dikerjakan**; lanjut ke **B3 (nice-to-have)**.

| # | Fitur | Status | Bukti |
|:--|:------|:------:|:------|
| B3-12 | **Dashboard khusus Direktur** (ringkas, angka kunci saja) | ✅ | `RingkasanDirektur.php` + trait `HanyaAdmin` + `DashboardDirekturTest` (6) |
| B3-13 | **Impor Excel/CSV** (append-only, cegah duplikat) | ✅ | `ImporTransaksi.php` + `PembacaImpor.php` + `ImporDataPage.php` + 12 tes |
| B3-14 | Log aktivitas penting | ⏭️ **DILEWATI** — bertentangan dengan keputusan final "audit log DIHAPUS" (Rules §10). Jangan diimplementasikan tanpa keputusan user baru. |

**B3-12 — Dashboard per peran:**
- Direktur → **1 widget ringkas** (`RingkasanDirektur`: nilai pekerjaan, masuk,
  keluar, belum diterima, total saldo, lewat tenggat). **0 chart, 0 tabel.**
- Admin → dashboard lengkap seperti sebelumnya (5 widget + ringkasan).
- Mekanisme: `canView()` per widget. Widget rinci pakai trait
  `App\Filament\Widgets\Concerns\HanyaAdmin`.
- Diverifikasi di browser: Direktur hanya 6 kartu angka (0 chart/0 tabel);
  `canView()` dicek via tinker: Admin→RingkasanKeuangan=true, Direktur→RingkasanDirektur=true & sisanya false.

**B3-13 — Impor Excel/CSV:**
- **APPEND-ONLY**: hanya menambah baris, tidak pernah mengubah/menghapus data lama.
- **CEGAH DUPLIKAT**: sidik jari `md5(jenis|tanggal|jumlah|akun|keterangan|spk_id)`
  dihitung on-the-fly (tanpa tabel baru); impor ulang berkas sama → "dilewati".
  Baris ter-soft-delete ikut dihitung (tidak "kembali" saat impor ulang).
- Normalisasi angka Indonesia: `1.500.000`, `2,500,000`, `1500000`, `Rp 1.500.000`.
- Halaman **Impor Data** (grup Sistem, khusus Admin) + unduh template CSV.

**Suite:** 805 lulus · 2.214 assertions · 0 risky · pint bersih.

---

## 0g. Sesi 11 Okt 2026 — Implementasi Inventaris Fitur (B1 + B2)

User memberi **inventaris fitur & menu** (Bagian A = sudah ada, B = perlu ada) dan
minta: *"analisa setelah itu implementasi yang diatas, lakukan juga implementasi
disesuaikan dengan pembaruan ini"*. Diverifikasi dulu terhadap repo, lalu
diimplementasikan dengan TDD. **787 tes lulus · 2.158 assertions · 0 risky · pint bersih.**

### B1 — Wajib (definisi "selesai" MVP)

| # | Fitur | Status | Bukti |
|:--|:------|:------:|:------|
| B1-5 | Perintah `app:buat-admin` (setup interaktif, tanpa akun default) | ✅ | `BuatAdmin.php` + `BuatAdminCommandTest` (4) |
| B1-2 | Tabel `notifications` + notifikasi unduhan | ✅ | migrasi `2026_10_11_000001` + `NotifikasiDatabaseTest` (2) |
| B1-3 | Ekspor SPK end-to-end + notifikasi | ✅ | `EksporSpkEndToEndTest` (3) |
| B1-4 | Backup otomatis + halaman status backup | ✅ | `BackupRestore.php` + `StatusBackup.php` + `BackupRestoreTest` (8) |

### B2 — Penting

| # | Fitur | Status | Bukti |
|:--|:------|:------:|:------|
| B2-7 | **Menu Arsip Nota** (filter periode/akun/kategori/kata kunci → unduh + ZIP) | ✅ | `ArsipNota.php` + `ArsipNotaPage.php` + 15 tes |
| B2-9 | Filter bulan jelas | ✅ | sudah ada: preset periode + filter tanggal Arsip Nota |
| B2-10 | **Halaman Status Sistem** (health check) | ✅ | `StatusSistem.php` + `StatusSistemPage.php` + `StatusSistemTest` (4) |
| B2-11 | **Ekspor Buku Kas/Bank** (format template atasan, saldo berjalan) | ✅ | `BukuKasBank.php` + `BukuKasBankTest` (6) + `BukuKasBankEksporTest` (3) |

### ⚠️ TEMUAN PENTING — notifikasi ekspor butuh QUEUE WORKER

`Filament\Notifications\DatabaseNotification` meng-`implements ShouldQueue`.
Artinya notifikasi unduhan **disimpan oleh worker**, bukan di request. Di
produksi **WAJIB** ada worker berjalan (`php artisan queue:work`) — kalau tidak,
notifikasi tidak pernah muncul. Di `.env` lokal `QUEUE_CONNECTION=sync` (langsung,
tanpa tabel); `.env.example` sudah `database`. Ini didokumentasikan di
halaman **Status Sistem** (kartu "Queue Worker": jumlah menunggu + job gagal).

### Pelajaran baru (masuk skill bks-backend)

- **Migrasi `notifications`** — Filament `DatabaseNotification` implements
  `ShouldQueue`; jangan kira notifikasi gagal kalau queue = sync (memang live).
- **Menu sidebar baru bisa memecahkan tes lama yang mencari string di seluruh
  HTML.** `RevisiMenuSpkTest` mencari kata "Restore" di seluruh halaman →
  tertangkap label menu "Backup & Restore" → gagal palsu. Perbaikan: uji lewat
  daftar AKSI TABEL (`assertTableActionDoesNotExist`), bukan string HTML.
- **Tes tanpa asersi = "risky"** (`KompresiUntukOcrTest::test_gambar_kecil_...`).
  Setiap cabang `if` harus punya asersi eksplisit.
- **Route unduh/ZIP berkas** sebaiknya route biasa (bukan aksi Livewire) agar
  andal mengirim berkas; path dikirim base64 + divalidasi `Nota::ada()` (cegah
  traversal).

### Menu baru (diverifikasi di browser sungguhan, port 8199)

```
Keuangan : Uang Masuk → Uang Keluar → Arsip Nota (BARU)
Sistem   : Backup & Restore (BARU) → Status Sistem (BARU)
```

Semua di grup baru **"Sistem"** (khusus Admin). Struktur menu lama TIDAK diacak.

---

## 0b. Sesi 9 Okt 2026 (lanjutan) — Perburuan Bug Menyeluruh

3 bug NYATA ditemukan lewat TDD (merah → hijau) + verifikasi:

| # | Bug | Bukti merah | Perbaikan |
|:--|:----|:------------|:----------|
| 1 | **Ubah Uang Keluar ditolak palsu** — `aturanJumlah()` menghitung nilai record SENDIRI dua kali (90jt→95jt dilaporkan 185jt) | `BugAturanJumlahUangKeluarTest` | `whereKeyNot($record->id)` |
| 2 | **Password lemah lolos di form Pengguna** — `minLength(8)` sendiri, "12345678" diterima | `KebijakanPasswordPenggunaTest` | `->rule(Password::default())` |
| 3 | **SPK Dibatalkan tetap bisa dibayar** — `CatatPembayaran` buat UangMasuk langsung, lewati validasi | `BugCatatPembayaranSpkDibatalkanTest` | `visible()` + penjaga di `action()` |

Ditambah 1 regression guard: `BugTotalTerfilterSoftDeleteTest` (total header sudah benar mengabaikan data terhapus — dikunci agar tidak rusak).

**Status:** 696 tes lulus · 1.890 assertions · 1 *risky* pra-ada.

---

## 0c. Sesi 10 Okt 2026 — Autentikasi, Kelola Pengguna & Profil

Pertanyaan user: "sistem login/logout serta bagian penting lain? direktur bisa menambah user karna sekarang tidak ada, profile masih sederhana."

**Diverifikasi di browser nyata:**

| Fitur | Status | Bukti |
|:------|:------:|:------|
| Login (email + password, "Lupa kata sandi?", "Ingat saya") | ✅ ada | `/admin/login` render benar |
| Logout (POST `/admin/logout` dari menu pengguna) | ✅ ada | form logout ditemukan & berfungsi |
| Menu pengguna (pojok kanan atas: Profil Saya, Keluar) | ✅ ada | dropdown terbuka |
| Lupa password (anti-enumerasi, token 60 mnt) | ✅ ada | tautan tampil |
| Direktur kelola pengguna | ✅ diperbaiki | **BUG ditemukan & fix** |

**BUG #4 (temuan 10 Okt 2026) — Direktur tak bisa menambah user:**
`ListPenggunas` menyembunyikan tombol "Tambah Pengguna" dengan
`PenggunaResource::bolehUbahData()` (HANYA Admin), padahal `canCreate()` TRUE
untuk Direktur → **kontradiksi**: Direktur bisa buka `/penggunas/create` (200)
tapi tak ada tombol menuju ke sana. Perbaikan: tombol mengikuti
`canCreate()`. Tes: `BugTombolTambahPenggunaTest`, `KelolaPenggunaPeranTest`.

**Profil masih sederhana** (Nama, Email, Password Baru) — belum ada: foto/avatar,
preferensi tema/bahasa, info peran terakhir login. Menunggu keputusan user.

**Status:** 707 tes lulus · 1.909 assertions · 1 *risky* pra-ada.

---

## 0f. Sesi 10 Okt 2026 — Saldo Berjalan Kas/Bank (T2)

Menindaklanjuti item **T2** survei ("Saldo berjalan Kas/Bank" — pernah ditunda).
User minta lanjut **selain** "ganti password paksa" (T6).

- Kelas baru `App\Support\SaldoKas`: `saldo()`, `ringkasan()`, `perBulan()`.
  Rumus: **saldo = Σ uang masuk − Σ uang keluar** per akun (`kas`/`bank`).
- ⚠️ **Tanpa tabel baru** — dihitung on-the-fly dari transaksi (Rules §1). Data
  ter-soft-delete otomatis dikecualikan (model pakai SoftDeletes).
- Saldo **boleh negatif** (sah; menandakan pengeluaran > penerimaan) — sengaja
  tidak dibulatkan ke 0 agar terlihat.
- Muncul di **Dashboard** (3 kartu: Saldo Kas, Saldo Bank, Total Saldo) dan
  **halaman Laporan** (3 kartu di seksi Ringkasan).

**Tes baru:** `SaldoKasTest` (6) · `SaldoKasTampilTest` (2).
**Verifikasi browser:** halaman `/admin/laporan` menampilkan "SALDO KAS Rp -187.297.224", "SALDO BANK Rp 0", "Total Saldo".
(Catatan: kartu widget dashboard di harness headless tampil "Loading..." untuk SEMUA widget — perilaku lazy-load Livewire yang sudah ada sebelumnya, bukan regresi; kode widget diverifikasi lewat tinker: 15 kartu render benar.)

**Status:** 740 tes lulus · 2.007 assertions · 1 *risky* pra-ada.

---

## 0e. Sesi 10 Okt 2026 — Profil Diperluas & Tanda Tangan PDF (U1 + U2)

Menindaklanjuti item **U1** (profil sederhana) & **U2** (tanda tangan PDF kosong).

**U1 — Profil Saya diperluas:**
- Migration `2026_10_10_000001_tambah_profil_ke_pengguna_table` → kolom `avatar`, `tanda_tangan`, `terakhir_masuk` (⚠️ sesuai aturan skema: **tambah kolom, bukan tabel baru**).
- Halaman `ProfilAkun` kini 3 seksi: **Data Akun** (nama, email, peran + login terakhir), **Foto & Tanda Tangan**, **Ubah Password**.
- Berkas disimpan di **disk privat `nota`** (data pribadi — bukan disk publik), pratinjau lewat rute ber-otentikasi.
- `terakhir_masuk` diisi otomatis via listener event `Login` di `AppServiceProvider` (berlaku semua jalur login).

**U2 — Tanda tangan di PDF:**
- Kelas baru `App\Support\TandaTangan::untukPdf()` → ambil tanda tangan Direktur, ubah ke **data URI base64** (dompdf render tanpa sesi, jadi URL ber-otentikasi akan gagal).
- Ditempel di **dua** view PDF: `filament.exports.tabel-pdf` (semua menu) & `filament.pages.laporan-pdf` (menu Laporan).
- Bila Direktur belum unggah → tetap titik-titik (PDF tidak gagal terbit).

**Tes baru:** `ProfilDiperluasTest` (4) · `TandaTanganPdfTest` (4, termasuk **render PDF sungguhan** & cek objek `/Image` tertanam).
**Verifikasi browser:** halaman `/admin/profile` menampilkan "Data Akun / Foto & Tanda Tangan / Ubah Password", "Peran: Admin", "Login terakhir: …".

**Status:** 732 tes lulus · 1.985 assertions · 1 *risky* pra-ada.

---

## 0d. Sesi 10 Okt 2026 — Tindak Lanjut Survei (P1–P5 + tes)

Menindaklanjuti `docs/SURVEI-MENU-FITUR.md`. Semua **P1–P5** dikerjakan + 3 file tes baru.

| # | Item | Tindakan | Tes |
|:-:|:-----|:---------|:----|
| P1 | Hapus permanen transaksi | `ForceDeleteAction` DIBUANG dari EditUangMasuk/Keluar (selaras Rules §2.9) | `TanpaHapusPermanenTransaksiTest` |
| P2 | `bks:backup` nol tes | Refactor ke facade `Process` + tes | `BackupDatabaseTest` (4) |
| P3 | Override SPK Dibatalkan | Rules §5.3 disinkronkan (sistem menolak KETAT) | — |
| P4 | Aging piutang di dokumen | Rules §2.16 ditandai ❌ TIDAK DIPAKAI; docblock `Laporan.php` dibersihkan | — |
| P5 | `nilaiTagih()` di dokumen | Rules §2.15 → `sisaTagih()`/`piutang()` | — |
| + | Tabel peran §4 keliru | Admin TIDAK kelola Pengguna; Direktur ya | — |
| + | CRUD Mitra kurang tes | Tes alur lengkap | `MitraCrudTest` (6) |
| + | Rekonsiliasi angka | Dashboard & laporan == DB; data terhapus tak dihitung | `RekonsiliasiAngkaTest` (4) |

**Verifikasi browser:** halaman Ubah Uang Keluar hanya menampilkan tombol "Hapus"
(soft delete) — "Hapus Permanen" **hilang** ✅.

**Status:** 724 tes lulus · 1.956 assertions · 1 *risky* pra-ada.

**Belum dikerjakan (butuh keputusan bisnis):** U1 profil lebih lengkap,
U2 tanda tangan digital PDF, T2 saldo Kas/Bank, T3 ekspor format perusahaan,
T4 rekening koran, T5 import data lama, T6 ganti password paksa, T7 notifikasi tenggat.

---

## 0. Sesi 9 Oktober 2026 — Audit Keamanan + Manajemen Akun

**Audit keamanan & perburuan bug (read-only) selesai. Temuan & perbaikan:**

| Kode | Item | Tindakan |
|:-----|:-----|:---------|
| **AUD-1** | `league/commonmark` 2.10.1 — CVE HIGH (DoS) + MEDIUM | ✅ **Diperbaiki**: `composer update league/commonmark` → **2.10.3**, `composer audit` bersih |
| **AUD-2** | `nilai_spk` tanpa `maxValue` (SEDANG) | ✅ **Diperbaiki**: `maxValue(BATAS_NOMINAL)` = 10 M + tes `BatasNilaiSpkTest` |
| **AUD-3** | `.env.example` `APP_DEBUG=true` (RENDAH) | ✅ **Diperbaiki**: jadi `false` + komentar |
| **AUD-4** | `SESSION_SECURE_COOKIE` tidak diset (SEDANG) | ✅ **Didokumentasikan** di `.env.example` |
| **AUD-5** | Akun nonaktif masih bisa pakai sesi (RENDAH) | ✅ **KOREKSI — bukan celah**: Filament sudah cek `canAccessPanel()` tiap request → 403. Dikunci tes `AkunNonaktifMiddlewareTest` |
| **AUD-6** | OCR dijalankan sinkron, bukan job antrean (SEDANG) | ⏳ **Belum** — usul: bungkus ke `ShouldQueue` job |
| **AUD-7** | `npm audit` gagal (Node v20 vs npm v12) | ⏳ **Belum** — butuh Node ≥22 |

**Fitur wajib manajemen akun — SELESAI (15 tes, `ManajemenAkunTest`):**
- `app/Filament/Pages/ProfilAkun.php` — lihat/ubah nama & email (validasi unik) + ganti password (verifikasi password lama, min 8 huruf+angka, `logoutOtherDevices` + `regenerate`).
- `app/Filament/Pages/LupaPassword.php` — tautan "Lupa kata sandi?" di login; token kedaluwarsa 60 menit; **anti-enumerasi** (pesan identik).
- Rate limit: login & reset **5×/menit** (bawaan Filament, sudah sesuai).
- Aturan password terpusat di `AppServiceProvider::boot()` → `Password::defaults()`.

**Verifikasi:** 689 tes lulus · 1.865 assertion · `pint` bersih · **uji browser nyata** (profil render, field kondisional muncul, link lupa password, anti-enumerasi, `nilai_spk` 50 M ditolak). Rute sesi sementara sudah dihapus.

**Catatan penting:** `Filament\Http\Middleware\Authenticate` memanggil `canAccessPanel()` **setiap request** — jangan "temukan ulang" sebagai celah. Lihat skill `bks-backend`.

---


## 1. Kondisi Repo Sekarang

| Item | Nilai |
|:-----|:------|
| Tes | **689 lulus · 1.865 assertions** · 1 *risky* (pra-ada: `KompresiUntukOcrTest`) |
| Formatter | `./vendor/bin/pint` bersih |
| `composer audit` | **bersih** (commonmark 2.10.3) |
| Aset | `npm run build` OK |
| Sinkron remote | ⚠️ ada perubahan belum di-commit di working tree |

Jalankan untuk memastikan:
```bash
cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
php artisan test
./vendor/bin/pint --dirty
git rev-list --left-right --count origin/main...HEAD   # harus 0 0
```

---

## 2. Yang Selesai di Sesi Ini (5 commit, sudah di-push)

| Hash | Ringkas |
|:-----|:--------|
| `3d07062` | **fix**: tangani `status_spk`/`status_tagihan` NULL (scope `belumLunas`, `lewatTenggat`, `mendekatiTenggat` + guard form Uang Masuk/Keluar). Tes: `tests/Feature/SpkStatusNullTest.php` |
| `e1730e0` | **feat**: ekspor PDF semua menu + **perbaiki bug ekspor Excel SPK** (`SpkExporter` memakai `ExportColumn` untuk method `totalPenerimaan` → ekspor gagal total; diganti `getStateUsing()`). Tes: `EksporExporterTest`, `EksporPdfMenuTest` |
| `d22ca19` | **feat**: preview SPK **satu jalan masuk** — klik baris membuka **slide-over** (bukan lagi dua jalur: klik baris→halaman, tombol→modal). Tes: `PreviewSpkTest` |
| `0592a0a` | **feat**: rapikan & lengkapi halaman **Laporan** (ekspor per-bagian, bagian Piutang, badge Surplus/Defisit, Tren Arus Uang) |
| `0cd3176` | **docs**: AGENTS.md jadi konteks proyek BKS |

### Akar masalah "dua preview" (penting untuk diingat)
Filament `ListRecords::makeTable()` **otomatis mengisi `recordUrl`** selama Resource punya halaman `view`.
Akibatnya: klik baris → **halaman detail**, sedangkan tombol "Detail" → **modal**. Dua jalur berbeda.
**Solusi:** `->recordUrl(null)` + `->recordAction('view')`; tombol "Detail" di baris dihapus.

⚠️ **Jebakan teknis:** Filament menganggap aksi `hidden()` sebagai `disabled()` juga, sehingga aksi tanpa tombol **tidak bisa di-mount**. Dipakai kelas kecil `app/Filament/Actions/AksiKlikBaris.php` yang menimpa `isDisabled()` agar baris tetap bisa memicu preview. **Kalau Filament naik versi mayor, cek ulang** `tests/Feature/PreviewSpkTest.php` (`test_klik_baris_*`).

---

## 3. Berkas Kunci dari Sesi Ini

Baru:
- `app/Filament/Actions/PreviewSpk.php` — slide-over preview + aksi footer (Ubah/Hapus/Buka Halaman Detail)
- `app/Filament/Actions/AksiKlikBaris.php` — aksi yang dipicu klik baris (tanpa tombol)
- `app/Filament/Actions/EksporPdf.php` + `app/Filament/Exports/RakitEkspor.php` + `resources/views/filament/exports/tabel-pdf.blade.php`
- `resources/views/filament/pages/partials/ekspor-laporan.blade.php`

Diubah penting:
- `app/Filament/Resources/Spks/Tables/SpksTable.php` — `recordUrl(null)` + `recordAction('view')`
- 3 resource monitoring (`StatusSpkResource`, `TagihanSpkResource`, `TagihanSelesaiSpkResource`) — `recordAction('view')`
- `resources/views/filament/pages/laporan.blade.php` — ekspor per-bagian + Tren + badge
- `app/Models/Spk.php` — scope NULL
- `app/Filament/Exports/SpkExporter.php` — `getStateUsing()`

---

## 4. Sesi 7–8 Oktober 2026 (belum di-commit)

### 4a. Bug KRITIS keamanan — diperbaiki & diverifikasi
`UangMasukForm` `FileUpload::make('bukti')` **tidak** memakai `->disk('nota')` → jatuh ke disk `public`, sehingga bukti nota uang masuk bisa diakses **tanpa login** (`GET /storage/uang_masuk/...` → 200). Nota berisi harga material/subkon/gaji.
- Diperbaiki: pakai disk privat `nota` + `PratinjauNotaPrivat`; file lama dipindah; seeder diperbaiki; `livewire-tmp` dipindah ke disk privat `local` (`config/livewire.php`).
- Verifikasi: akses tanpa login kini **403/302**. Tes: `BuktiUangMasukPrivatTest`.

### 4b. OCR membaca ISI tiap nota (bukan hanya jumlahnya)
- `python/ocr_nota.py` — `teks_per_kotak()` mengelompokkan teks OCR per kotak nota; tetap "angka-blind" (mengembalikan `teks` mentah).
- `app/Support/PembacaIsiNota.php` (baru) — parsing `teks` → nominal/tanggal/penerima/kategori-saran/keterangan + confidence. Toleran pemisah tulisan tangan (`80-000` → 80000).
- Hasil OCR = **DRAF** yang harus dikonfirmasi admin; isian admin selalu menang.
- `MAKS_BARIS` 20 → **50**; mode default `total` → **`rinci`**.

### 4c. Bug mode **Rinci** (dilaporkan user) — akar masalah & perbaikan
Gejala: pilih mode Rinci → muncul "OCR tidak bisa membaca berkas ini" + hanya **1** form.
- **Akar masalah nyata (dari log):** `TooManyCallsException: Too many method calls in a single request (74). Maximum allowed is 50`. Form dengan puluhan baris (tiap baris punya field `live()`) melebihi batas `payload.max_calls` Livewire → request ditolak → form jatuh ke 1 baris.
- **Perbaikan:** `config/livewire.php` → `payload.max_calls` 50 → **1000**, `max_size` 1 MB → 4 MB. Diverifikasi: mode Rinci kini membuat 50 baris.

### 4d. Rombak desain — hilangkan "AI slop"
Palet **warna-warni** (badge 8 warna + garis kiri 6px warna per berkas) diganti **monokrom profesional**:
- `penanda-berkas.blade.php` — pembeda berbasis **TEKS** ("Nota 3 / 50") + titik status tipis, bukan warna.
- `theme.css` — border kartu 1px + garis aksen kiri **2px monokrom**; header baris lebih tipis.
- `progres-pengisian.blade.php` — 4 kotak alert menumpuk → **satu** baris status + peringatan hanya bila perlu.
- `info-ocr.blade.php`, `pratinjau-nota.blade.php` — pesan tenang, ikon lebih kecil.
- Judul/deskripsi section dipersingkat.
- ⚠️ Aturan lama yang **dibatalkan user**: dulu dilarang membaca nominal via OCR — kini justru diminta (sebagai draf).

### 4e. Tata letak form sesuai brief UI/UX (8 Okt 2026)
Brief desain "Clean Minimalist Enterprise" — sebagian besar SUDAH sesuai dari sesi sebelumnya. Yang disesuaikan:
- **Uang Masuk**: pemilih mode jadi **horizontal** (`->inline()`, segmented). Field dinamis sudah benar: mode SPK → nomor SPK & nama pekerjaan *read-only*; mode Manual → keduanya bisa diketik & dropdown SPK disembunyikan. Diverifikasi di browser.
- **Uang Keluar**: "Detail Pengeluaran" diubah 2 kolom → **1 kolom penuh** (nyaman di HP). Kategori = dropdown Enum, SPK opsional + clear, penerima teks pendek, keterangan textarea — semua sudah sesuai.
- **SPK**: diubah jadi **grid 2 kolom berbasis kartu**; tanggal terbit & tanggal akhir berdampingan; "Dokumen SPK" jadi area unggah **lebar penuh di paling bawah**. Diverifikasi: 8 section, pasangan kartu sejajar (476px+476px), section penuh 976px.
- **NO RETENTION** ditegaskan di deskripsi Nilai SPK; tidak ada elemen retensi (diverifikasi di browser).
- **Keputusan user (ditanya ulang)**: (1) status SPK **tetap display-only** (ubah lewat menu Status SPK / Tagihan SPK) — brief yang minta dropdown status TIDAK diikuti; (2) batas unggah Uang Keluar **tetap 25 MB** (bukan 10 MB) agar foto HP besar tetap masuk sebelum dikompres.
- Tes baru: `tests/Feature/TataLetakBriefFormTest.php` (6 tes).

### 4f. Halaman Uang Masuk/Keluar — dua baris "Total" (8 Okt 2026)
Keluhan user: *"halaman uang masuk dan keluar kenapa ada total begitu? membuang space"*.
- **Sebab:** bawaan Filament menampilkan blok "Rangkuman" dengan **DUA** baris total — "Halaman ini" (hanya baris halaman aktif) DAN "Semua Uang Masuk/Keluar" (seluruh data terfilter). Dua angka berbeda berlabel "Total" yang sama → membingungkan (tampak seperti bug) + memakan ~190px.
- **Perbaikan:** `->summaries(pageCondition: false)` di `UangMasuksTable` & `UangKeluarsTable` → tinggal SATU total (seluruh data terfilter). Blok menyusut 190px → 77px. Filter tetap dihormati.
- **Keputusan user:** pertahankan satu total (bukan hapus blok) karena angka total memang diminta sebelumnya (29 Sep 2026).
- Tes: `RingkasanTotalUangTest` +2 (total 10).

---

## 5. Belum Selesai / Menunggu Keputusan User

| Kode | Item | Status |
|:-----|:-----|:-------|
| **B1** | Saldo berjalan Kas & Bank | ⏳ **Butuh keputusan user** (opsi a/b/c). Rancangan sudah dilebur ke `docs/Architecture.md` §16 |
| **B4** | Ekspor Excel format perusahaan | ⏳ Terikat B1 |
| **C1** | Navigasi/UI lebih tegas | 🔄 Sebagian (preview & laporan sudah; tinjau menu lain bila perlu) |
| **C3** | Menu baru | ⏳ **Butuh daftar menu** dari user |
| — | Data keuangan final dari Admin | ⏳ Belum diterima (Rules §14) |
| — | Pajak PPN/PPh, data lama 2024–2026 | ⏳ Belum diputuskan (Rules §14) |

---

## 5. Aturan Kerja yang Tetap Berlaku

- **Commit/push:** default-nya **user** yang lakukan (AGENTS.md §2.1). Sesi ini dikecualikan karena user minta eksplisit.
- **Jangan tambah tabel ke-6** — tetap 5 tabel domain; tambahan lewat kolom/JSON + PHP Enum.
- **Jangan bocorkan data perusahaan** ke GitHub. Data asli di `~/data-perusahaan-bks/`.
- **Uji di browser sungguhan** sebelum bilang "selesai" (§2.8).
- **Jangan tebak keputusan bisnis** — tanya.

---

## 6. Cara Verifikasi Cepat di Browser (tanpa mengetik password)

Sesi admin bisa dibuat **server-side** (aturan melarang mengetik password). Catatan format cookie:
- Cookie = `encrypt(session_id)`; jar HttpOnly memakai prefiks `#HttpOnly_`.
- Driver sesi `database`, serialization JSON, cookie `spk-kontrol-keuangan-session`.
- Guard key: `login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d`.

Menu monitoring (slug benar):
- `/admin/monitoring-spk/status-spks`
- `/admin/monitoring-spk/tagihan-spks`
- `/admin/monitoring-spk/tagihan-selesai-spks`

---

*Sesi berikutnya: mulai dari §1 (pastikan repo hijau), lalu §4 (pilih item yang menunggu keputusan user).*
