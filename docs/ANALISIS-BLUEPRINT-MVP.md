# ANALISIS BLUEPRINT MVP — `blueprint-mvp-spk-kontrol-keuangan.md`

> **Tanggal:** 11 Oktober 2026
> **Sifat:** dokumen analisis — **TIDAK mengubah kode**.
> **Objek:** `~/Downloads/blueprint-mvp-spk-kontrol-keuangan.md` (v1.0, 218 baris)
> **Metode:** setiap klaim blueprint diperiksa langsung ke repo (git, grep, ls) —
> bukan dari ingatan.

---

## 0. RINGKASAN EKSEKUTIF

Blueprint ini **jauh lebih matang** daripada sekadar review sebelumnya. Isinya
lengkap: scope lock, struktur folder, aturan bisnis, API, queue, hardening,
Docker, testing, strategi migrasi. Sebagai **kontrak arsitektur** ia bagus.

**TAPI ada 3 masalah serius:**

1. 🔴 **Blueprint membawa asumsi yang salah** — §14 menyuruh "membawa 5 file
   async-OCR dari VPS", padahal **file itu tidak pernah ada di repo**. Kalau
   diikuti buta, AI akan **mengarang** file yang tidak pernah ada.
2. 🟠 **Sebagian besar "yang hilang" menurut blueprint SUDAH ADA** di repo
   sekarang (header keamanan, pengaman DB uji, `composer test`, mode nota rinci,
   DECIMAL). Blueprint menilai repo **versi lama**.
3. 🟠 **Rencana "rebuild dari nol" menghancurkan 39 file test yang terikat
   Filament** — ini biaya nyata yang blueprint tidak hitung.

**Vonis kami:** blueprint ini **layak dipakai sebagai acuan disiplin**, tetapi
**TIDAK boleh diikuti sebagai instruksi "hapus dan bangun ulang dari nol"**.
Pakai sebagai **checklist**, bukan **perintah rewrite**.

---

## 1. VERIFIKASI KLAIM BLUEPRINT

| § | Klaim blueprint | Bukti di repo | Vonis |
|:-:|:----------------|:--------------|:-----:|
| 3 | Laravel 13 / Filament 5 / MySQL 8 / dompdf | `composer.json`, `app/Filament` | ✅ |
| 5 | Struktur folder `Actions/Jobs/Services/Support` | `app/` punya `Services/Support/Observers/Enums`, **TIDAK ada `Actions/` atau `Jobs/`** | ⚠️ sebagian |
| 6 | Nominal `DECIMAL(18,2)`, FLOAT dilarang | `decimal('nilai_spk',18,2)`, `decimal('jumlah',18,2)` | ✅ |
| 6 | Kolom uang bernama `nominal` | **Aktual bernama `jumlah`** (`UangMasuk`, `UangKeluar`) | ❌ salah nama |
| 6 | Mode nota total vs rinci | `UangKeluarForm`: mode `'rinci'`/`'total'`, default rinci | ✅ |
| 6 | Soft delete semua tabel domain | Model pakai `SoftDeletes` | ✅ |
| 8 | Tabel `notifications` wajib sejak awal | **Tidak ada** migrasi notifications | ✅ (memang belum ada) |
| 10 | Header keamanan `X-Frame-Options`, `nosniff` | **SUDAH ADA** — `HeaderKeamanan.php`, terdaftar di `bootstrap/app.php:32` | ⚠️ sudah ada |
| 12 | `TestCase` wajib `pastikanDatabaseUji()` | **SUDAH ADA** — `tests/TestCase.php:13,38` (pengaman keras) | ⚠️ sudah ada |
| 12 | `composer test` = `config:clear` lalu `test` | **SUDAH ADA** — `composer.json:49` | ⚠️ sudah ada |
| 14 | Bawa **5 file async-OCR dari VPS** (`app/Jobs/ProsesOcrNota.php` + 4 modifikasi) | **`app/Jobs/` TIDAK PERNAH ADA** (git log `app/Jobs/*` kosong) | ❌ **KELIRU** |
| 14 | Bawa model domain + Enum + `PembacaNota` + `python/ocr_nota.py` | Semua **ada** di repo | ✅ |

### ⚠️ Temuan kritis — klaim §14 soal "5 file async-OCR dari VPS"

Blueprint menulis:

> *"5 file async-OCR dari VPS: `app/Jobs/ProsesOcrNota.php` + 4 modifikasi
> (form dispatch + polling, timeout & `kunciCache()`, streaming per halaman,
> worker `--timeout=600`)"* — daftar "DIBAWA".

**Fakta:**
- `ls app/Jobs/` → **tidak ada folder**.
- `git log --all -- app/Jobs/*` → **kosong** (tidak pernah ada di riwayat mana pun).
- OCR di repo **sinkron**: `PembacaNota` panggil `Process::timeout()->run()` dari
  `UangKeluarForm`.

**Ini kesalahan yang SAMA dengan review sebelumnya** (lihat
`docs/ANALISIS-REVIEW-EKSTERNAL.md` §1 koreksi #12). Reviewer mengira job OCR ada
di VPS; blueprint mengangkat asumsi itu menjadi **instruksi migrasi**.

**Dampak kalau diikuti buta:** AI di repo baru akan **mengarang** file
`app/Jobs/ProsesOcrNota.php` dan 4 modifikasi yang **tidak ada sumbernya** —
hasilnya kode yang tampak masuk akal tapi tidak terverifikasi.

**Koreksi:** job OCR **harus DIBANGUN** (baru), bukan "dibawa". Ini pekerjaan
baru, bukan migrasi.

---

## 2. ANALISIS MUTU BLUEPRINT

### 2.1 Yang BAGUS (pertahankan)

| Bagian | Penilaian |
|:-------|:----------|
| §2 **Scope Lock** (5 tabel, tanpa retensi/laba-rugi/approval) | ✅ Sangat baik — mencegah fitur liar. |
| §4 **Aturan emas** "form/controller tak boleh ada logika bisnis" | ✅ Prinsip inti yang benar. |
| §6 **Aturan bisnis = minimal 1 test** | ✅ Budaya proyek yang sudah terbukti. |
| §8 **Queue untuk kerja berat** | ✅ Menutup risiko blocking OCR. |
| §10 **Checklist hardening** | ✅ Lengkap & terukur. |
| §12 **Pengaman DB uji + `composer test`** | ✅ (sudah ada; bagus dicantumkan). |
| §14 **Daftar "jangan tulis ulang dari nol"** | ✅ Prinsip benar: bawa aset terverifikasi. |
| §15 **Prompt siap tempel** | ✅ Praktis untuk AI agent. |

### 2.2 Yang BERMASALAH (perlu koreksi)

| Bagian | Masalah | Saran |
|:-------|:--------|:------|
| §14 "DIBAWA: 5 file async-OCR dari VPS" | **Sumber tidak ada** (lihat §1) | Ubah jadi **"DIBANGUN"**, bukan "dibawa". |
| §14 "DIBUANG: Form & Table Filament → tulis ulang" | Menghancurkan **39 file test** yang pakai `Livewire::test` | **Pecah bertahap**, jangan tulis ulang. |
| §5 `Actions/` + `Jobs/` belum ada | Memang belum ada | Tambah **incremental**, jangan repo baru. |
| §6 kolom `nominal` | Aktual `jumlah` | Samakan nama agar tidak bikin kolom baru. |
| §7 API + Sanctum | User bilang **Flutter belum pasti** | **Tunda** — jangan over-engineer. |
| §11 Docker wajib | User: **server rakitan/on-premise** | Docker **opsional** untuk MVP; putuskan dulu. |

---

## 3. BIAYA "REBUILD DARI NOL" YANG TIDAK DIHITUNG

Blueprint §14 menyarankan **tulis ulang Form & Table Filament**. Yang blueprint
tidak sebut: **39 dari 94 file test memakai `Livewire::test`** (terikat langsung
ke Filament). Menulis ulang lapisan Filament berarti:

| Yang hilang | Bukti |
|:------------|:------|
| 39 file test Livewire/Filament | `grep -rl 'Livewire::test' tests/` = 39 |
| 68 file test menyentuh Filament | `grep -rl 'Filament' tests/` = 68 |
| 740 test hijau | suite saat ini |
| Logika domain terverifikasi browser | SPK, uang masuk/keluar, OCR, ekspor |

**Kesimpulan:** "rebuild dari nol" = membuang **±74% cakupan test** dan menulis
ulang UI yang **sudah berfungsi & terverifikasi**. Itu **bukan MVP tercepat** —
itu kemunduran.

---

## 4. KONTRADIKSI YANG PERLU DIPUTUSKAN

| # | Kontradiksi | Pilihan |
|:-:|:------------|:--------|
| 1 | Blueprint §11: Docker **wajib**. User: server rakitan on-premise. | Docker opsional? |
| 2 | Blueprint §7: API+Sanctum sekarang. User: Flutter **belum pasti**. | Tunda? |
| 3 | Blueprint §14: tulis ulang Filament. Repo: 39 test terikat Filament. | Pecah bertahap? |
| 4 | Blueprint: repo baru. Kami: repo ini cukup. | Repo baru atau incremental? |

---

## 5. REKOMENDASI KAMI

### 5.1 Pakai blueprint sebagai CHECKLIST, bukan PERINTAH

Blueprint ini **nilainya tinggi sebagai standar disiplin** (scope lock, aturan
emas, test per aturan, hardening). **Jangan** dipakai sebagai alasan membuang
repo yang sudah 740 test hijau.

### 5.2 Lakukan INCREMENTAL di repo yang ada

| # | Langkah | Dari blueprint | Kenapa incremental lebih baik |
|:-:|:--------|:---------------|:------------------------------|
| 0 | **Commit** 75 file sekarang | — | Blueprint menilai versi lama. |
| 1 | Buat `app/Actions/` + pindahkan logika `UangKeluarForm` | §4, §5 | Test lama jadi jaring pengaman. |
| 2 | Buat `app/Jobs/ProsesOcrNota.php` **(BANGUN, bukan bawa)** | §8 | Tutup risiko blocking. |
| 3 | Seeder aman + `app:buat-admin` interaktif | §10 | Keamanan. |
| 4 | Tambah tabel `notifications` | §8 | Prasyarat job ekspor. |
| 5 | Perbaiki `bks:backup` agar benar-benar hasilkan file | §8 | Backup 0 berkas = risiko. |
| 6 | Putuskan Docker (on-premise?) | §11 | Keputusan bisnis. |
| 7 | (Tunda) API + Sanctum | §7 | Flutter belum pasti. |

### 5.3 Perbaiki blueprint-nya (3 suntingan kecil)

1. §14: ubah **"5 file async-OCR dari VPS"** → **"job OCR DIBANGUN baru"**.
2. §14: ubah **"Form/Table ditulis ulang"** → **"dipecah bertahap, test dijaga"**.
3. §6: samakan **`nominal`** → **`jumlah`** (nama kolom aktual).

---

## 6. KESIMPULAN

1. **Blueprint bagus sebagai kontrak disiplin**, lemah sebagai perintah rebuild.
2. **1 kesalahan faktual serius** (§14: file async-OCR yang tidak pernah ada) —
   harus dikoreksi sebelum dipakai AI, atau AI akan mengarang.
3. **Sebagian besar "kekurangan" sudah ada** di repo (header keamanan, pengaman
   DB uji, `composer test`) — blueprint menilai versi lama.
4. **Rebuild dari nol = membuang 39 file test Filament** — bukan MVP tercepat.
5. **Jalan terbaik:** incremental di repo ini, pakai blueprint sebagai checklist,
   perbaiki 3 suntingan di §5.3.

> ⚠️ Dokumen ini **tidak mengubah kode apa pun**. Menunggu keputusan user.
