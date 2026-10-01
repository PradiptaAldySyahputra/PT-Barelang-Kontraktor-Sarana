# KONTEKS & STATUS PROYEK — PT Barelang Kontraktor Sarana

> **Berkas ini adalah jangkar konteks.** Dibaca pertama sebelum bertanya apa pun.
> Dirujuk dari memori agent: *"Baca dulu docs/STATUS-PENGERJAAN.md + PRD.md + Rules.md."*
>
> **Terakhir diperbarui:** 29 September 2026

---

## 1. Identitas Proyek

| Item | Nilai |
|:-----|:------|
| Proyek | **Sistem Informasi SPK & Kontrol Keuangan** |
| Perusahaan | PT Barelang Kontraktor Sarana (Batam) — subkontraktor PT PLN Batam |
| Sifat | Sistem internal perusahaan — **tugas magang** Pradipta Aldy Syahputra |
| Stack | Laravel 13.17 + Filament 5.0 + MySQL (`bks`) + PHP 8.5 |
| Skema | **5 tabel domain**: `mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna` |
| Role | **2 saja**: Admin (input) · Direktur (monitor) |
| Deploy | **Lokal intranet 2 PC** — PC Direktur = server (Windows) |
| Repo | https://github.com/PradiptaAldySyahputra/PT-Barelang-Kontraktor-Sarana (private) |
| Tes | **535 lulus · 1.462 assertion** · 59 berkas |

### Dokumen proyek

| Berkas | Isi |
|:-------|:----|
| `docs/PRD.md` | Kebutuhan fitur & ruang lingkup |
| `docs/Rules.md` | **Aturan bisnis — WAJIB DIPATUHI** |
| `docs/Architecture.md` | Struktur teknis & deployment |
| `docs/Schema.md` | Struktur database |
| `docs/MANUAL-BOOK.md` | Panduan Admin & Direktur |
| `docs/AUDIT-MENU-DAN-ALUR.md` | Temuan celah alur bisnis |
| `docs/CHANGELOG.md` | Riwayat perubahan |
| `docs/superpowers/specs/` | Spec & rencana |
| `docs/STATUS-PENGERJAAN.md` | **⭐ berkas ini** — status tahap terkini |

---

## 2. ATURAN KERAS (jangan dilanggar)

| # | Aturan |
|:-:|:-------|
| 1 | **Git: pengguna melakukan SEMUA commit/push.** Agent DILARANG commit, push, buat PR, atau ubah history. Tinggalkan di working tree + beri tahu pengguna. |
| 2 | **Jangan menebak keputusan bisnis.** Tanya. Perubahan alur bisnis = keputusan perusahaan. |
| 3 | **Jangan tambah tabel ke-6.** Skema tetap 5 tabel domain. Tambahan lewat kolom/JSON + PHP Enum. (Tabel infrastruktur: `jobs`, `cache`, `sessions`, `exports` boleh.) |
| 4 | **Balas bahasa Indonesia.** |
| 5 | **Verifikasi sebelum menulis.** Jangan tulis angka/nama dari ingatan — jalankan perintah dulu. |
| 6 | **Data perusahaan TIDAK BOLEH bocor** ke GitHub. Data asli di `~/data-perusahaan-bks/`. |
| 7 | **Backup dulu** sebelum mengubah file besar/dokumen. |
| 8 | **Uji di browser sungguhan** sebelum bilang "selesai" — tes unit tidak menangkap masalah tata letak. |

---

## 3. Keputusan Bisnis FINAL (jangan ditanyakan lagi)

| Hal | Keputusan | Tanggal |
|:----|:----------|:--------|
| **Retensi 5%** | ❌ **TIDAK DIPAKAI** — klien bayar 100%. Kolomnya sudah dihapus. | 19 & 26 Sep 2026 |
| **Laba-rugi per SPK** | ❌ **TIDAK DIHITUNG** — sistem murni mencatat | 19 Sep 2026 |
| **Pajak (PPN/PPh)** | ❌ **Di luar scope** — ditangani bagian lain perusahaan | 19 & 26 Sep 2026 |
| **Approval Direktur** | ❌ Tidak ada — admin langsung mencatat | 19 Sep 2026 |
| **Audit log** | ❌ Dihapus (menyimpang dari SRS NFR-SEC-004) | 19 Sep 2026 |
| **Entitas PROYEK** | ❌ Tidak ada — **SPK adalah entitas inti** | 19 Sep 2026 |
| **Kategori mitra** | ✅ Hanya **2**: PLN (pemberi kerja) & Subkon/Vendor | 19 Sep 2026 |
| **Menu Buku Kas & Bank** | ❌ **Dihapus** — diganti filter periode + kolom `akun` | 26 Sep 2026 |
| **Akun Kas/Bank** | ✅ Kolom manual, admin pilih sendiri (sistem tidak menebak) | 26 Sep 2026 |
| **REF di Excel** | ✅ Tidak dibuat sebagai kolom, tapi dicetak kosong di ekspor | 26 Sep 2026 |
| **Mode nota** | ✅ `total` (default) vs `rinci` | 25 Sep 2026 |
| **Docker untuk produksi** | ❌ **TIDAK** — admin kantor yang merawat; pakai native Windows (Laragon/XAMPP) | 29 Sep 2026 |
| **OS PC server** | **Windows** — Laragon/XAMPP + NSSM + Task Scheduler | 29 Sep 2026 |
| **PDF library** | ✅ `barryvdh/laravel-dompdf` | 29 Sep 2026 |

### ⚠️ Aturan bisnis yang WAJIB dijalankan kode

| Aturan | Bukti |
|:-------|:------|
| `piutang = nilai_spk − sudah_diterima` (TANPA retensi) | `tests/Unit/RumusPiutangTest.php` |
| SPK `Dibatalkan` **tidak menerima transaksi baru** | `tests/Feature/SpkDibatalkanTidakTerimaTransaksiTest.php` |
| Uang masuk **tidak boleh melebihi** piutang SPK | `tests/Feature/BatasUangMasukTest.php` |
| Status tagihan **disinkron otomatis** dari pembayaran | `tests/Feature/SinkronStatusTagihanTest.php` |
| Tanggal transaksi **tidak boleh > hari ini** | `tests/Feature/ValidasiTanggalTransaksiTest.php` |
| Status/kategori **wajib PHP Enum + dropdown** | `tests/Unit/EnumTest.php` |
| Nominal `DECIMAL(18,2)` — **dilarang FLOAT** | `docs/Schema.md` |
| Soft delete (tidak hapus permanen) | `SoftDeletes` di 3 model |

---

## 4. Status Tahap Terkini (29 Sep 2026)

### ✅ Sudah selesai

**5 Poin (diputuskan 26 Sep 2026)** — poin 5 (pajak) **ditolak pengguna**:

| # | Poin | Bukti |
|:-:|:-----|:------|
| 1 | Upload dokumen SPK (BAST, scan, kuitansi) | kolom `spk.dokumen` (JSON) · `DokumenSpkTest` |
| 2 | Keterangan pengantaran SPK | `App\Enums\StatusAntar` (3 nilai) · `StatusAntarTest` |
| 3 | Ekspor Excel **&** PDF | `?format=xlsx` / `?format=pdf` |
| 4 | Laporan Piutang | `Laporan::ekspor('piutang')` · `LaporanPiutangTest` |
| 5 | ~~Pajak~~ | ⛔ ditolak — bukan pekerjaan perusahaan |

**Celah PRD/Rules (29 Sep 2026):**

| # | Celah | Bukti |
|:-:|:------|:------|
| 1 | Ekspor Excel di halaman Laporan | `EksporLaporanXlsxTest` (4 tes) |
| 1b | Ekspor PDF (dompdf) | `EksporLaporanPdfTest` (5 tes) + `laporan-pdf.blade.php` |
| 2 | Validasi tanggal transaksi ≤ hari ini | `ValidasiTanggalTransaksiTest` (5 tes) |
| 3 | Filter SPK di uang masuk/keluar | `FilterSpkUangTest` (3 tes) |
| 4 | Manual book Admin & Direktur | `docs/MANUAL-BOOK.md` |
| 5 | Rapikan dokumen drift | PRD, Rules §14, Architecture checklist |

**Perbaikan UI Kelompok A (29 Sep 2026):**

| # | Perbaikan | Bukti |
|:-:|:----------|:------|
| A1 | Laporan: 3 dropdown → **1 tombol "Ekspor"** (format jadi pilihan di dalam) | 15 link, 3 format, diverifikasi browser |
| A2 | Gabung "Catat Pembayaran" + "Ubah Status" → **1 menu** `ActionGroup` | "Kelola SPK" / "Kelola Tagihan" |
| A3 | Label ekspor konsisten di **8 menu** | "Ekspor Excel" + ikon |

**Perbaikan UI Kelompok A dan Kas/Bank Kelompok B (29-30 Sep 2026):**

| # | Perbaikan | Bukti |
|:-:|:----------|:------|
| A1 | Laporan: 3 dropdown -> **1 tombol "Ekspor"** (format jadi pilihan di dalam) | 15 link, 3 format, diverifikasi browser |
| A2 | Gabung "Catat Pembayaran" + "Ubah Status" -> **1 menu** `ActionGroup` | "Kelola SPK" / "Kelola Tagihan" |
| A3 | Label ekspor konsisten di **8 menu** | "Ekspor Excel" + ikon |
| **B2** | **Ringkasan total** di tabel uang masuk/keluar | `RingkasanTotalUangTest` (8 tes) |
| **B3** | **Tombol "Lihat Bukti"** (modal pratinjau gambar/PDF) | `BukaBuktiTest` (6 tes) |

> 📌 **B2:** baris "Rangkuman" menampilkan *Halaman ini* + *Semua*. Dihitung
> database dan **mengikuti filter aktif** (menyaring "Kas" -> total hanya Kas).
>
> 📌 **B3:** membuka berkas lewat rute ber-otentikasi `/admin/nota/{path}`
> (disk privat). Berkas tak ada -> 404; path traversal -> 404.

**Testing & kualitas:**

| Item | Bukti |
|:-----|:------|
| `tests/Unit/` terisi (dulu KOSONG) — 43 tes | `RumusPiutangTest` (7), `TenggatSpkTest` (23), `EnumTest` (13) |
| Bug factory **flaky** diperbaiki | status acak → deterministik (`StatusSpk::Berjalan`); suite 3× stabil |
| Spec strategi pengujian | `docs/superpowers/specs/2026-09-29-strategi-pengujian-design.md` |

### ⏳ Belum dikerjakan

**B — Kas & Bank (INTI KELUHAN PENGGUNA 29 Sep 2026):**

> Pengguna: *"uang masuk dan keluar itukan berdasarkan kas/bank atau dari file excel...
> admin perlu itu kemudahan untuk mengelolanya, mencari bukti dari uang tersebut,
> dan kebutuhan data lainnya"*

| # | Yang kurang | Bukti |
|:-:|:------------|:------|
| B1 | **Kolom SALDO berjalan** di tabel uang masuk/keluar | 🔴 **TERBLOKIR — butuh keputusan pengguna** (lihat catatan di bawah) |
| B2 | ~~Ringkasan total~~ ✅ **SELESAI 30 Sep 2026** | `RingkasanTotalUangTest` (8 tes) — baris "Rangkuman": Halaman ini + Semua |
| B3 | ~~Tombol buka bukti dari tabel~~ ✅ **SELESAI 30 Sep 2026** | `BukaBuktiTest` (6 tes) + `daftar-bukti.blade.php` |
| B4 | **Ekspor format Excel perusahaan** (kop, `PEMASUKAN`/`PENGELUARAN`/`SALDO`, baris `T O T A L`) | `ExportAction` biasa |

> ⚠️ **CATATAN PENTING soal B1 (saldo berjalan):**
> Spec 26 Sep (`docs/superpowers/specs/2026-09-26-kas-bank-dan-spk-design.md` §4.3)
> sudah merancang halaman **"Buku Kas & Bank"**: tabel `TANGGAL | REF | KETERANGAN |
> PEMASUKAN | PENGELUARAN | SALDO` + saldo berjalan + ringkasan + ekspor format Excel.
>
> **Tetapi pengguna menghapus menu itu (26 Sep 2026)**, diganti filter periode +
> kolom `akun` di Uang Masuk/Keluar.
>
> **Masalahnya:** SALDO berjalan **tidak bisa** hidup di Uang Masuk saja (uang
> keluar tidak ikut dihitung → angka salah) atau di keduanya (dua saldo berbeda →
> membingungkan). Saldo butuh **kedua sisi digabung** dalam satu urutan tanggal.
>
> **Butuh keputusan pengguna** sebelum dikerjakan. Opsi: (a) buat ulang halaman
> Buku Kas & Bank sesuai spec, (b) tab "Buku Kas"/"Buku Bank" di menu Keuangan,
> (c) cukup ringkasan total saja tanpa saldo berjalan per baris.

> ✅ **B3 sudah selesai** — tombol "Lihat Bukti" di tiap baris Uang Masuk & Uang
> Keluar, membuka modal berisi pratinjau gambar/PDF. Terverifikasi browser:
> gambar termuat (`naturalWidth 420`), berkas tak ada → 404, path traversal → 404.
>
> 📌 **Temuan saat verifikasi:** data demo di DB menunjuk `uang_keluar/nota-contoh.jpg`
> yang **tidak ada di disk** → gambar rusak. Ini masalah **data seeder**, bukan kode.
> Berkas nyata yang ada: `uang_masuk/nota-contoh.pdf` dan UUID di `uang_keluar/`.

> Excel asli perusahaan: `BKS - Format Kas & Bank <thn> (<BLN>).xlsx`,
> sheet **KAS + BANK**, kolom `TANGGAL | REF | KETERANGAN | PEMASUKAN | PENGELUARAN | SALDO`.

**C — UX/UI & menu:**

| # | Yang kurang |
|:-:|:------------|
| C1 | Navigasi kurang tegas, UI masih polos |
| C2 | **Detail SPK (FR-SPK-005, prioritas High)** — belum ada halaman/panel yang menampilkan uang masuk & keluar **per SPK** |
| C3 | **Menu baru** — pengguna belum menyebutkan daftarnya |

**Testing (7 dari 10 celah):** coverage (butuh `sudo pacman -S php-pcov`),
CI, PHPStan, E2E, performa, keamanan, UAT.

---

## 5. Peta Menu Saat Ini

```
Dashboard (-10)
SPK         : List SPK (1) → Status SPK (2) → Tagihan SPK (3) → Tagihan Selesai SPK (4)
Keuangan    : Uang Masuk (11) → Uang Keluar (12)
Master Data : Mitra (21) → Pengguna (22)
Laporan     (31)
```

**Alur bisnis:** login → master data → buat SPK → uang masuk → uang keluar → sistem hitung piutang → direktur pantau.

**Siklus status SPK:** `Draft → Terbit → Berjalan → Selesai → Sudah Ditagihkan` (⇢ `Dibatalkan`)
**Siklus status tagihan:** `Belum Ditagihkan → Sudah Ditagihkan → Revisi Dokumen → Menunggu Pembayaran → Dibayar`

**Halaman aksi khusus SPK:** `UbahStatusSpk`, `UbahStatusTagihan` (form terpisah, sesuai permintaan pengguna).

---

## 6. Cara Menjalankan

```bash
cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"

php artisan test          # 535 tes
php artisan serve         # http://127.0.0.1:8000/admin
./vendor/bin/pint         # formatter

# Akun: admin@bks.test / password  ·  direktur@bks.test / password
```

| Item | Nilai |
|:-----|:------|
| DB aplikasi | MySQL `bks` |
| DB test | MySQL `bks_test` (kredensial di `.env.testing`, TIDAK ditulis di dokumen) |
| OCR | venv `ocr-venv` (456 MB) — rapidocr, **hanya hitung jumlah nota**, TIDAK baca nominal |
| Nota | disk privat, rute `/admin/nota/{path}` (butuh login) |
| `.env` | `APP_ENV=local`, `APP_DEBUG=true` → **wajib diubah sebelum produksi** |

---

## 7. Jebakan yang Sudah Diketahui (jangan ulangi)

| Jebakan | Cara menghindari |
|:--------|:-----------------|
| **Menulis angka/nama dari ingatan** | Jalankan `ls`/`grep` dulu. Pernah menulis 3 nama tes & 1 nama method yang **tidak ada**. |
| **`terminal.cwd` menunjuk folder lain** | Periksa `pwd`; jangan percaya cwd sebagai bukti proyek |
| **Factory Spk status acak** | Sudah diperbaiki. Tes yang butuh status tertentu pakai `->berjalan()` / `->lunas()` |
| **Dropdown tidak terpicu via JS** | Playwright: `page.get_by_role(...).click()` — **bukan** `element.click()` di JS (Alpine tidak jalan) |
| **Validasi di dalam `when($wajib)`** | Repeater uang keluar pakai `fieldInti(false)` → aturan di dalam `when()` **tidak dijalankan**. Taruh di luar. |
| **Tes lulus ≠ suite hijau** | Selalu jalankan `php artisan test` penuh |
| **Dokumen drift** | 🔴 `SETUP-SERVER.md` masih Linux/nginx, padahal PC server **Windows** → harus ditulis ulang sebelum pindah |
| **`AGENTS.md` = template Laravel Boost** | Belum diperbarui jadi konteks proyek (butuh persetujuan pengguna) |

---

## 8. Preferensi Pengguna (UX & kerja)

- Menolak tampilan templated/AI-slop — UI harus punya identitas
- **≤5–6 filter per tabel**; satu kontrol per sumbu (jangan tab + dropdown untuk hal sama)
- `navigationSort` tiap menu harus berbeda
- Grafik harus sejajar
- Bukti lebih penting dari klaim — sebutkan yang **tidak bisa** diverifikasi
- Sering mengabaikan pertanyaan klarifikasi (timeout) → kerjakan yang aman & bukan keputusan bisnis dulu
- Bahasa Indonesia
- Fokus alur bisnis perusahaan, bukan hal teknis yang tidak diminta

---


### Riwayat Push Terakhir — 30 Sep 2026

✅ **SUDAH DI-PUSH** oleh agent atas **permintaan eksplisit pengguna**
("push saja ke github semua perubahan") — menimpa aturan lama.

| | |
|:--|:--|
| Commit | `0eaa8d5` (HEAD) — 8 commit baru dari `9447e6f` |
| Remote | `origin/main` — **terverifikasi sinkron** |
| Tes saat push | **535 lulus · 1.462 assertion** · Pint lolos |
| Pemeriksaan sebelum push | rahasia/kredensial/nilai keuangan → **BERSIH** |

⚠️ **Aturan git tetap berlaku:** agent DILARANG commit/push **kecuali** pengguna
meminta eksplisit seperti di atas.

## 9. CARA MELANJUTKAN DI SESI BARU

### Langkah termudah

Buka sesi baru, lalu tulis salah satu:

```
lanjutkan proyek BKS
```
```
lanjutkan PT Barelang
```

Agent akan membaca berkas ini lebih dulu, lalu melanjutkan dari status di §4.

### Sesi terkait (untuk dibuka kembali)

| Sesi | Isi |
|:-----|:----|
| `@session:default/20260929_004403_6c490e` | **Sesi 30 Sep (terakhir)**: Kelompok A (bug UI), B2 (ringkasan total), B3 (buka bukti), unit test, perbaikan alur, push ke GitHub |
| `@session:default/20260930_185715_0d006f` | Uji konteks sesi baru (535 tes, B1 terblokir) |
| `@session:default/20260926_025814_1076ed` | **Kas & Bank**: halaman Buku Kas & Bank PERNAH dibuat, lalu dilebur ke Uang Masuk/Keluar atas permintaan pengguna |
| `@session:default/20260929_032741_e5aa11` | Kerja 29 Sep: 5 celah PRD/Rules, Kelompok A, unit test |

### Aturan memori

- Memori agent **hanya memuat penunjuk** ke berkas ini (kuota memori terbatas).
- **Jangan percaya `terminal.cwd`** sebagai bukti proyek — identifikasi lewat `pwd` + berkas di folder.
- `AGENTS.md` proyek **tidak** dipasang (pengguna menolak). Isi siap-pakai ada di
  `docs/AGENTS-CONTENT.md` — pasang dengan: `cat docs/AGENTS-CONTENT.md >> AGENTS.md`

---

## 10. TEMUAN PENTING: Halaman "Buku Kas & Bank" PERNAH Dibuat

⚠️ **Ini menjawab kenapa B1 terasa "hilang".** Dari riwayat sesi
(`@session:default/20260926_025814_1076ed`), pada **26 Sep 2026** halaman ini
**sudah selesai dan berfungsi**:

```
PT. <NAMA PERUSAHAAN>
ACCOUNT : KAS              Periode: AGUSTUS 2026
TANGGAL | REF | KETERANGAN | PEMASUKAN | PENGELUARAN | SALDO
...
T O T A L | <total masuk> | <total keluar> | <saldo akhir>
```

Kelengkapannya saat itu:

| Fitur | Status waktu itu |
|:------|:-----------------|
| Saldo berjalan (TANGGAL + REF + PEMASUKAN + PENGELUARAN + SALDO) | ✅ ada |
| Ringkasan atas + baris `T O T A L` | ✅ ada |
| Ekspor Excel menyerupai Excel perusahaan (kop, ACCOUNT, Periode) | ✅ ada |
| Tautan "Lihat bukti ↗" per baris | ✅ ada |
| Tautan "Ubah (Uang Masuk/Keluar) →" per baris | ✅ ada |
| Tombol langsung ke input Uang Masuk & Uang Keluar | ✅ ada |

**Lalu pengguna meminta (26 Sep) meleburnya** ke menu Uang Masuk/Keluar:

> *"bagian keuangan menu kas/bank tersebut tidak perlu sebenarnya karna itu adalah
> pecahan dari menu uang masuk dan keluar, jadi tinggal ditambah kategori saja di
> kedua menu tersebut apakah ini kas/bank ... jadi menu kas/bank tadi tidak
> digunakan tetapi dilebur atau disatukan ke menu uang masuk dan uang keluar"*

**Akibatnya:** halaman, Service `BukuKasBank`, dan tesnya **dihapus**. Karena
belum di-commit (aturan: pengguna yang commit), kode itu **hilang permanen** —
`find` dan `git log` tidak menemukannya lagi.

**Konsekuensi sekarang:** kolom `akun` (Kas/Bank) **sudah** ada di kedua menu,
tetapi **saldo berjalan belum** — dan saldo butuh kedua sisi digabung.

> 📌 **Jadi opsi B1 (a) "buat ulang halaman Buku Kas & Bank" bukan pekerjaan baru
> dari nol** — desainnya sudah terbukti pernah jalan dan persis menyerupai Excel
> perusahaan. Yang perlu dikerjakan adalah membuatnya kembali.

---

## 11. RINGKASAN SESI 30 Sep 2026 (sesi terakhir)

### Yang SELESAI di sesi ini

| # | Pekerjaan | Bukti |
|:-:|:----------|:------|
| A1 | Laporan: 3 dropdown -> **1 tombol Ekspor** (Excel/PDF/CSV di dalamnya) | `laporan.blade.php`, 15 link, panel 224x789px |
| A2 | Gabung **"Catat Pembayaran" + "Ubah Status"** jadi 1 menu aksi | `ActionGroup` di StatusSpk & TagihanSpk |
| A3 | Label & ikon ekspor **konsisten di 8 menu** | `ExportAction` |
| B2 | **Ringkasan total** di tabel uang masuk/keluar (ikut filter) | `Sum` summarizer, "Total 970.362.072" |
| B3 | **Tombol "Lihat Bukti"** -> modal pratinjau gambar/PDF | `daftar-bukti.blade.php`, 6 tes |
| — | **Unit test** (tests/Unit sebelumnya KOSONG) | RumusPiutangTest, TenggatSpkTest, EnumTest |
| — | **Perbaikan alur**: validasi tanggal, filter SPK, SPK Dibatalkan | 16 tes baru |
| — | **Factory deterministik** (SpkFactory status acak -> tetap) | cegah tes flaky, stabil 3x jalan |
| — | **Dokumen**: manual book, audit menu, status proyek | `docs/*.md` |

**Tes akhir: 535 lulus · 1.462 assertion · Pint lolos**
**Git: sudah di-push ke `origin/main` (commit `0eaa8d5`)**

### Kesalahan yang terjadi di sesi ini (jangan ulangi)

1. **Salah proyek di awal** — mengaudit "Siakad" karena `terminal.cwd` saat itu
   menunjuk ke folder salah. **Pelajaran: identifikasi proyek dari `pwd` + berkas,
   bukan dari asumsi.**
2. **Menulis kredensial & nilai keuangan ke dokumen** yang akan di-push
   (`root/penyalai`, angka `869.204.578`). Sudah dibersihkan sebelum push.
   **Pelajaran: repo ini pernah dibersihkan agar publik-aman — SELALU periksa
   rahasia sebelum commit.**
3. **Klaim palsu di dokumen** — menyebut 3 nama tes yang tidak ada
   (`BukuKasBankTest` dll). Sudah dikoreksi.
   **Pelajaran: verifikasi dengan `ls`/`grep` sebelum menulis nama berkas/angka.**
4. **Tes yang tidak berguna** — tes B2 awal hanya memanggil `Model::sum()`,
   lulus meski fitur belum ada. Ditulis ulang agar memeriksa konfigurasi tabel.
5. **Hampir melaporkan bug palsu** — dropdown tampak 0x0 px karena diklik via JS
   (tidak memicu Alpine). **Pelajaran: untuk dropdown, klik lewat Playwright
   (`page.get_by_role(...).click()`), bukan `element.click()` via JS.**

### Keputusan pengguna di sesi ini

| Pertanyaan | Jawaban |
|:-----------|:--------|
| Docker untuk produksi? | ❌ **TIDAK** — admin kantor yang merawat, PC Windows merangkap PC kerja harian |
| Pemasangan `AGENTS.md`? | ❌ **ditolak** — cukup pakai `docs/STATUS-PENGERJAAN.md` + memori |
| Push ke GitHub? | ✅ diminta eksplisit (*"push saja ke github semua perubahan"*) |

### Yang BELUM & menunggu

| # | Item | Blocker |
|:-:|:-----|:--------|
| B1 | Saldo berjalan di Kas & Bank | 🔴 butuh keputusan (3 opsi di §10) |
| B4 | Ekspor Excel format perusahaan (kop, PEMASUKAN/PENGELUARAN/SALDO, T O T A L) | siap, tidak butuh keputusan |
| C1 | Navigasi lebih tegas + UI tidak polos | siap |
| C2 | Detail SPK (uang masuk/keluar per SPK) — FR-SPK-005 | siap |
| C3 | Menu baru | ⏳ butuh daftar dari pengguna |

### Keluhan pengguna yang BELUM tuntas

Dari 30 Sep (masih relevan untuk sesi berikutnya):

> *"ui masih polos dan ux kurang tegas navigasinya"* -> C1
> *"banyak lagi bagian yang belum dan perlu pembaruan untuk alur bisnisnya,
> terutama pada uang masuk dan keluar... admin perlu itu kemudahan untuk
> mengelolanya, mencari bukti dari uang tersebut, dan kebutuhan data lainnya"*
> -> B1/B4/C2

