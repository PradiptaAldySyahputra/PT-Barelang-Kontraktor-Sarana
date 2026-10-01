# Spec — Strategi Pengujian Menuju Produksi

> **Proyek:** Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana
> **Tanggal:** 29 September 2026
> **Status:** Menunggu review pengguna
> **Ruang lingkup:** Seluruh sistem (10 celah pengujian)
> **Konteks:** Pengguna meminta *"menyusun bagian testing baik automation testing dan
> testing lainnya sebelum ke tahap produksi"* (29 Sep 2026), memilih **opsi menyeluruh**.

---

## 1. Latar Belakang

### 1.1 Kondisi pengujian sekarang

Proyek ini **sudah kuat** di pengujian otomatis:

```
✓ 473 tes lulus · 1.302 assertion · PHPUnit 12.5 · 53 file tes
✓ Fixtures nota nyata: nota-4nota.pdf, nota-contoh.jpg, nota-template-kosong.pdf
✓ DB test terpisah (bks_test) — data asli tidak pernah tersentuh
✓ docs/PENGUJIAN-VISUAL.md — panduan uji browser manual
✓ Uji keamanan sudah ada: AuditKeamananTest (24 tes), NotaTidakPublikTest (7 tes),
  HeaderKeamananTest (1 tes)
```

Yang **belum ada** — 10 celah yang membuat sistem belum siap produksi.

### 1.2 Kenapa ini penting

Sistem ini menangani **data keuangan perusahaan**. Risiko nyata:

| Risiko | Dampak |
|:-------|:-------|
| Kode tidak teruji tersentuh perubahan | Fitur yang jalan bisa rusak diam-diam |
| Tidak tahu **berapa persen** kode teruji | Tidak bisa bilang "sudah aman" dengan dasar |
| Tidak ada CI | Tes hanya jalan kalau ada yang ingat menjalankan |
| Tidak ada E2E otomatis | Bug tata letak/alur hanya ketemu manual |
| Belum ada UAT formal | Admin & Direktur belum pernah menguji sendiri |
| Belum ada manual book teruji | Pengguna baru tidak bisa memakai tanpa dibantu |

### 1.3 Acuan yang mengikat

Pengujian ini harus memenuhi aturan yang **sudah ada di dokumen proyek**:

| Sumber | Isi |
|:-------|:----|
| `PRD.md` §11 | Tahap **Verification**: *"Test case, hasil black-box, bug report"* |
| `PRD.md` §8 | Kriteria sukses: laporan bisa diekspor, manual book tersedia |
| `Rules.md` §7 | *"Tambahkan automated tests untuk authorization, validasi, relasi penting, dan akurasi rupiah"* |
| `Rules.md` §12 | *"Jalankan formatter, static analysis, dan test sebelum merge"* |
| `Rules.md` §11 | *"Uji restore minimal sekali sebelum sistem dipakai penuh"* |
| `Architecture.md` | Checklist: Black-box testing, bug prioritas tinggi, manual book |
| NFR-PERF-001/002 | Performa: eager loading, pagination, waktu respons wajar |
| NFR-SEC-001..003 | Keamanan: hashing, middleware role, DECIMAL bukan FLOAT |
| NFR-DEP-002 | Backup: data dapat dipulihkan |

> 📌 **Catatan metodologi:** proyek memakai **Fast-Track Waterfall**. Pengujian
> masuk tahap *Verification* (Bulan 4 Minggu 1–2). Rencana ini mengikuti bentuk
> keluaran yang sudah ditetapkan: **test case, hasil black-box, bug report**.

---

## 2. Tujuan

1. **Tahu pasti** berapa bagian kode yang teruji (bukan menebak).
2. **Otomatis** menjalankan pemeriksaan setiap ada perubahan.
3. **Membuktikan** kebutuhan non-fungsional (performa, keamanan, backup).
4. **Menyerahkan** bukti pengujian yang bisa ditunjukkan ke pembimbing/penguji.
5. **Membekali** Admin & Direktur agar bisa menguji & memakai sendiri.

## 3. Bukan Tujuan (YAGNI)

- ❌ Bukan menulis ulang 473 tes yang sudah ada — yang ada **dipertahankan**.
- ❌ Bukan mencapai 100% coverage — target **realistis** (lihat §5).
- ❌ Bukan pengujian beban berskala besar (sistem internal, 2 PC, ±10 pengguna).
- ❌ Bukan penetration test profesional.
- ❌ Bukan pengujian di cloud/CI berbayar.

---

## 4. Ruang Lingkup — 10 Celah

| # | Celah | Kelompok |
|:-:|:------|:---------|
| 1 | ~~`tests/Unit/` kosong~~ ✅ **SELESAI 29 Sep** — 3 berkas, 43 tes | A |
| 2 | Tidak ada **coverage** (pcov belum terpasang — butuh sudo) | A |
| 3 | Tidak ada **CI** (`.github/workflows`) | B |
| 4 | Tidak ada **analisis statis** (PHPStan/Larastan) | B |
| 5 | Tidak ada **mutation testing** | B |
| 6 | Tidak ada **E2E otomatis** (Dusk/Playwright) | B |
| 7 | Tidak ada **uji performa/beban** | C |
| 8 | Tidak ada **uji keamanan terstruktur** | C |
| 9 | Tidak ada **UAT formal** | D |
| 10 | ~~Belum ada manual book~~ ✅ **SELESAI 29 Sep** — `docs/MANUAL-BOOK.md` | D |

> 📌 **Kemajuan 29 Sep 2026:** celah #1 & #10 selesai. Total tes naik
> **473 → 516** (+43 unit test), assertion **1.302 → 1.412**.

### Hasil `tests/Unit/` yang sudah dibuat

| Berkas | Tes | Yang dikunci |
|:-------|:---:|:-------------|
| `RumusPiutangTest.php` | 7 | **Rumus piutang** = nilai − diterima, **anti-retensi 5%** |
| `TenggatSpkTest.php` | 23 | Perhitungan tenggat, ambang 14 hari, label Indonesia, **waktu dikunci** |
| `EnumTest.php` | 13 | **Nilai enum terkunci** (data lama bergantung padanya), label, opsi, warna, logika turunan |

> ⚠️ **Catatan teknis:** `tests/Unit/RumusPiutangTest.php` memakai
> `PHPUnit\Framework\TestCase` (murni, tanpa Laravel). `TenggatSpkTest` dan
> `EnumTest` memakai `Tests\TestCase` karena cast tanggal Enum butuh container
> Laravel — **tetap tidak menyentuh database** (tanpa `RefreshDatabase`).

---

## 5. Rancangan — 4 Kelompok Pengujian

### Kelompok A — UKUR (mengukur apa yang sudah ada)

**Tujuan:** tahu kondisi nyata sebelum menambah apa pun.

| Langkah | Isi | Keluaran |
|:--------|:----|:---------|
| A1 | Pasang **pcov** (ekstensi PHP untuk coverage) | — |
| A2 | Ukur coverage sekarang, tanpa ubah kode | `docs/pengujian/COVERAGE.md` |
| A3 | Isi `tests/Unit/` — unit test murni untuk logika tanpa DB | tes baru |
| A4 | Tulis **test case formal** dari `PRD.md` (FR-xxx) | `docs/pengujian/TEST-CASE.md` |

**Kandidat unit test murni** (logika tanpa DB — paling cocok untuk `tests/Unit/`,
semua sudah diverifikasi ada di kode):

| Method | Berkas | Yang diuji |
|:-------|:-------|:-----------|
| `piutang()`, `piutangDari()`, `sisaTagih()`, `totalPenerimaan()` | `app/Models/Spk.php` | **Rumus piutang** — inti keuangan |
| `sisaTenggatHari()`, `labelTenggat()`, `tenggatEfektif()`, `sudahLewatTenggat()`, `isMendekatiTenggat()` | `app/Models/Spk.php` | Perhitungan tenggat |
| `sudahLunas()`, `sudahSelesai()`, `isDisubkonkan()`, `pernahDiperpanjang()`, `jumlahDokumen()`, `jumlahPerpanjangan()` | `app/Models/Spk.php` | Status turunan |
| `StatusSpk`, `StatusTagihan`, `KategoriPengeluaran`, `AkunKas`, `StatusAntar` | `app/Enums/` | Enum: nilai, label, warna, opsi |
| `amanCsv()` | `app/Filament/Pages/Laporan.php` | Netralisasi CSV injection |

> ⚠️ **Catatan jujur:** `Spk::kategoriUmur()` **TIDAK ADA** di kode (sempat saya
> sebut di draf awal — sudah dikoreksi). Kelompok umur piutang saat ini dihitung
> di tempat lain, bukan sebagai method model.

> ⚠️ **Target coverage realistis:** **bukan** 100%. Saya usulkan **≥80% baris**
> untuk `app/Models`, `app/Enums`, `app/Services` — bagian yang menghitung uang.
> Untuk `app/Filament` (tampilan) target lebih rendah karena sudah ditutup tes Feature.

### Kelompok B — OTOMASI (supaya tidak bergantung ingatan)

| Langkah | Isi | Catatan |
|:--------|:----|:--------|
| B1 | **CI GitHub Actions**: jalankan `php artisan test` + Pint tiap push/PR | Repo private, GitHub Actions gratis |
| B2 | **PHPStan/Larastan** level bertahap (mulai level 5) | `Rules.md` §12 mewajibkannya |
| B3 | **Laravel Dusk** untuk E2E alur kritis | Butuh Chrome; alternatif: lanjutkan Playwright |
| B4 | **Mutation testing** (`infection/infection`) — terbatas | Opsional, hanya untuk Model/Enum |

**Alur kritis yang wajib E2E** (bukan semua halaman):

1. Login → Dashboard tampil
2. Buat SPK → muncul di List SPK
3. Input uang masuk → status tagihan berubah otomatis
4. Input uang keluar multi-nota → tersimpan beberapa baris
5. Laporan → ekspor Excel/PDF/CSV berhasil terunduh
6. Direktur login → tombol input **tidak ada**

> ⚠️ **Keputusan yang perlu diambil:** Dusk (native Laravel, PHP) atau
> Playwright (Python, sudah dipakai manual)? Dusk lebih rapi untuk CI;
> Playwright sudah terbukti jalan di mesin ini.

### Kelompok C — NON-FUNGSIONAL

**C1. Performa** (NFR-PERF-001, NFR-PERF-002)

| Uji | Cara | Ambang |
|:----|:-----|:-------|
| Waktu respons halaman utama | Ukur `ms` tiap halaman | < 2000 ms |
| N+1 query | Hitung query per halaman | tidak ada ledakan query |
| Pagination daftar | Isi 1000+ baris, buka daftar | tetap < 2000 ms |
| Dashboard dengan data penuh | 90 SPK + 292 transaksi nyata | < 2000 ms |

**C2. Keamanan** (NFR-SEC-001..003 + `Rules.md` §9)

| Uji | Isi | Status |
|:----|:----|:-------|
| Hashing password | Bcrypt/Argon2, bukan plain text | sudah ada (`AuthTest`) |
| Middleware role | Direktur ditolak saat buka halaman input | sudah ada (`AuditKeamananTest`) |
| **DECIMAL bukan FLOAT** | Periksa tipe kolom di schema | ⚠️ **belum** |
| File bukti tidak publik | Rute nota butuh login | sudah ada (`NotaTidakPublikTest`) |
| CSV injection | Netralisasi `= + - @` | sudah ada |
| Header keamanan | X-Frame-Options, dll. | sudah ada (`HeaderKeamananTest`) |
| Path traversal | Rute nota tolak `../` | sudah ada |
| `.env` tidak ter-commit | Periksa Git | ⚠️ perlu ditambah |

**C3. Backup & Pemulihan** (`Rules.md` §11 butir 4, NFR-DEP-002)

| Langkah | Isi |
|:--------|:----|
| C3.1 | Jalankan `php artisan bks:backup` — periksa berkas terbentuk |
| C3.2 | **Uji restore ke database lain** — pulihkan, bandingkan jumlah baris |
| C3.3 | Dokumentasikan hasil di `docs/pengujian/UJI-RESTORE.md` |

> 🔴 **Ini yang paling sering dilewati.** Backup yang belum pernah diuji restore
> **belum terbukti bisa dipulihkan**. `Rules.md` mewajibkannya minimal sekali.

### Kelompok D — PENERIMAAN (UAT)

| Langkah | Isi | Keluaran |
|:--------|:----|:---------|
| D1 | **Black-box test case** per fitur (langkah + hasil diharapkan) | `docs/pengujian/BLACK-BOX.md` |
| D2 | **Naskah UAT** untuk Admin (skenario kerja nyata) | `docs/pengujian/UAT-ADMIN.md` |
| D3 | **Naskah UAT** untuk Direktur | `docs/pengujian/UAT-DIREKTUR.md` |
| D4 | **Form bug report** + cara melaporkan | `docs/pengujian/BUG-REPORT.md` |
| D5 | **Laporan hasil pengujian** (ringkasan untuk pembimbing) | `docs/pengujian/HASIL-PENGUJIAN.md` |

> 📌 Manual book **sudah ada** (`docs/MANUAL-BOOK.md`) dan sudah diverifikasi
> setiap menu/tombolnya benar-benar ada di aplikasi.

---

## 6. Urutan Pelaksanaan

```
TAHAP 1 — UKUR (fondasi)
  1. Pasang pcov → ukur coverage awal
  2. Isi tests/Unit/
  3. Tulis test case formal dari PRD
        ↓
TAHAP 2 — OTOMASI
  4. CI GitHub Actions (test + Pint)
  5. PHPStan/Larastan
  6. E2E alur kritis
        ↓
TAHAP 3 — NON-FUNGSIONAL
  7. Uji performa
  8. Uji keamanan yang belum ada
  9. Uji restore backup   ← jangan dilewati
        ↓
TAHAP 4 — PENERIMAAN
 10. Black-box test case
 11. Naskah UAT Admin & Direktur
 12. Form bug report
 13. Laporan hasil pengujian
        ↓
SIAP PRODUKSI
```

**Alasan urutan ini:** mengukur dulu sebelum menambah; otomasi sebelum
non-fungsional (supaya temuan cepat ditangkap); penerimaan terakhir karena
harus dilakukan setelah sistem stabil.

---

## 7. Risiko & Mitigasi

| Risiko | Mitigasi |
|:-------|:---------|
| Coverage rendah → banyak kerja | Target realistis ≥80% hanya untuk kode perhitungan uang |
| CI butuh repo publik/pengaturan | GitHub Actions gratis untuk repo private |
| Dusk butuh Chrome headless | Sudah terbukti jalan (Playwright + CDP); Dusk opsional |
| Mutation testing lambat | Batasi hanya Model/Enum, jalankan manual |
| UAT butuh waktu Admin/Direktur | Siapkan naskah singkat (15–30 menit) |
| Uji restore berisiko menimpa data asli | **Restore ke database LAIN**, bukan `bks` |

---

## 8. Berkas yang Akan Dihasilkan

```
docs/pengujian/
├── COVERAGE.md          — hasil ukur coverage
├── TEST-CASE.md         — test case formal dari PRD
├── BLACK-BOX.md         — hasil uji black-box
├── UAT-ADMIN.md         — naskah UAT admin
├── UAT-DIREKTUR.md      — naskah UAT direktur
├── BUG-REPORT.md        — format & catatan bug
├── UJI-RESTORE.md       — bukti uji restore backup
└── HASIL-PENGUJIAN.md   — ringkasan untuk pembimbing

.github/workflows/
└── test.yml             — CI

tests/Unit/              — unit test murni (sekarang KOSONG)
```

---

## 9. Kriteria Selesai

Pengujian dianggap selesai bila **semua** terpenuhi:

- [ ] Coverage terukur & tercatat (`COVERAGE.md`)
- [ ] `tests/Unit/` terisi; seluruh tes lulus
- [ ] CI jalan otomatis tiap push (terbukti dengan 1 push uji)
- [ ] PHPStan/Larastan lolos tanpa error level yang disepakati
- [ ] E2E 6 alur kritis lulus
- [ ] Uji performa: semua halaman < 2000 ms
- [ ] Uji keamanan: DECIMAL & `.env` terverifikasi
- [ ] **Uji restore backup berhasil** (dibuktikan dengan jumlah baris cocok)
- [ ] Test case formal tersedia untuk seluruh FR prioritas High
- [ ] Naskah UAT Admin & Direktur siap dipakai
- [ ] Laporan hasil pengujian tersedia

---

## 10. Keputusan yang Dibutuhkan

| # | Pertanyaan | Opsi |
|:-:|:-----------|:-----|
| 1 | E2E pakai apa? | **A.** Laravel Dusk (PHP, rapi untuk CI) · **B.** Playwright (Python, sudah terbukti di mesin ini) |
| 2 | Target coverage | **A.** ≥80% untuk Models/Enums/Services · **B.** lebih rendah · **C.** tanpa target angka |
| 3 | PHPStan level | **A.** mulai level 5 (seimbang) · **B.** level 8 (ketat) · **C.** level 0–3 (longgar) |
| 4 | Mutation testing | **A.** ikutkan (Model/Enum saja) · **B.** lewati dulu |
| 5 | UAT | **A.** saya siapkan naskah, pengguna yang menjalankan · **B.** saya jalankan sendiri lewat browser otomatis |

---

*Spec ini mengikuti bentuk keluaran yang sudah ditetapkan di `PRD.md` §11
(Fast-Track Waterfall, tahap Verification): test case, hasil black-box, bug report.*
