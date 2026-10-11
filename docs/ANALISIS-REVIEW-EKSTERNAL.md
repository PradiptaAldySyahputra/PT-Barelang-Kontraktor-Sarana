# ANALISIS REVIEW EKSTERNAL — Penilaian & Rencana Tindak Lanjut

> **Tanggal:** 10 Oktober 2026
> **Sifat:** dokumen analisis — **TIDAK mengubah kode** (diminta user).
> **Masukan yang dianalisis:** review eksternal atas commit `1473a5c`
> ("Verdict produksi: belum siap").
> **Metode:** setiap klaim diperiksa langsung ke repo (git show, grep, wc, ls) —
> bukan dari ingatan.

---

## 0. RINGKASAN EKSEKUTIF

Penilaian reviewer **akurat dan jujur**. Dari 12 klaim faktual, **10 terbukti
benar persis**, 1 perlu koreksi, 1 tidak dapat diverifikasi. Diagnosisnya tepat:
masalahnya bukan arsitektur (yang sudah sehat), tetapi **kelengkapan lapisan
produksi** (hardening, queue, deploy) dan **disiplin** (logika menumpuk di form).

⚠️ **CATATAN PENTING:** reviewer menilai **commit `1473a5c`**, sedangkan working
tree saat ini sudah punya **75 file perubahan belum di-commit** yang **menutup
sebagian kritik**. Lihat §3.

**Rekomendasi utama kami: JANGAN rewrite total, JANGAN pindah repo.** Tambahkan
lapisan yang kurang secara **incremental** ke repo yang ada.

---

## 1. VERIFIKASI KLAIM REVIEWER (bukti langsung)

| # | Klaim | Bukti | Vonis |
|:-:|:------|:------|:-----:|
| 1 | Laravel 13 + Filament 5, panel `/admin`, 5 tabel domain, 2 role | `composer.json`; migrasi `pengguna/mitra/spk/uang_masuk/uang_keluar`; `Peran.php` | ✅ |
| 2 | Model `Spk` kaya behavior, Enum, observer, OCR service | `Spk::piutang()/tenggatEfektif()`; `app/Enums/`; `SinkronStatusTagihanObserver`; `PembacaNota` | ✅ |
| 3 | ~11.500 baris kode | `app/` di commit = **11.462 baris** | ✅ |
| 4 | 74 file test, ~616 hijau | `git ls-tree 1473a5c tests/` = **74** file | ✅ |
| 5 | `.env.example` masih `APP_DEBUG=true` | `git show 1473a5c:.env.example` → **baris 4: `APP_DEBUG=true`** | ✅ |
| 6 | `SESSION_ENCRYPT=false`, secure cookie tak diset | commit → `SESSION_ENCRYPT=false`; tak ada `SESSION_SECURE_COOKIE` | ✅ |
| 7 | Seeder tanam `admin@bks.test`/`password` di repo publik | `DatabaseSeeder.php:34-44` | ✅ |
| 8 | `UangKeluarForm` 1.516 baris | `git show 1473a5c:...UangKeluarForm.php \| wc -l` = **1.516** | ✅ |
| 9 | Backup terjadwal belum pernah hasilkan file | `storage/app/backup/` **kosong** (0 berkas) | ✅ |
| 10 | Keputusan bisnis "❌ Docker untuk produksi" | `AGENTS.md:49` | ✅ |
| 11 | Desain intranet (PC Direktur = server) | `AGENTS.md:17` | ✅ |
| 12 | "Job queue async OCR ada di VPS, belum di-commit" | **KOREKSI** — lihat bawah | ❌ |

### Koreksi klaim #12 (penting)

Reviewer menulis *"Job queue async OCR cuma ada di VPS, belum di-commit — deploy
berikutnya menghapusnya."* **Fakta di repo:**

- **Tidak ada** folder `app/Jobs/` sama sekali.
- OCR dijalankan **SINKRON**: `PembacaNota::baca()` memanggil
  `Process::timeout()->run([...])` dan dipanggil **langsung** dari
  `UangKeluarForm` (baris 799) di dalam request web.
- Bahkan `set_time_limit(0)` dipanggil (baris 203) — mengonfirmasi ini memang
  blocking.

**Artinya:** bukan "job ada di VPS lalu hilang saat deploy". Pekerjaan queue
**belum pernah dibuat** sebagai bagian arsitektur. Klaim soal VPS tidak dapat
kami verifikasi (aturan proyek: audit kode saja), tetapi kesimpulan reviewer
**tetap benar** — OCR belum async. Jadi ini kekeliruan pada **mekanisme**, bukan
pada **kesimpulan**.

---

## 2. ANALISIS MUTU REKOMENDASI

| Rekomendasi reviewer | Penilaian kami | Catatan |
|:---------------------|:--------------:|:--------|
| Tetap di stack sama (Laravel+Filament+MySQL) | ✅ **Setuju kuat** | Ganti framework = mindahin masalah. Benar. |
| Domain di model, **form kurus** → `Services/Actions` | ✅ **Setuju — prioritas #1** | `UangKeluarForm` = 1.620 baris, **32 method** di working tree. Utang teknis nyata. |
| API-first + Sanctum | ⚠️ **Bersyarat** | Berguna HANYA bila app Flutter benar dibuat. **User: belum pasti → TUNDA.** |
| Semua kerja berat = queue job | ✅ **Setuju** | OCR memblokir request (bahkan `set_time_limit(0)`). Risiko nyata. |
| Hardening sejak awal | ✅ **Setuju** | Sebagian sudah dikerjakan (belum commit) — §3. |
| Deploy = Docker Compose | ⚠️ **Perlu keputusan bisnis** | Membalik `AGENTS.md:49` (❌ Docker). Bukan murni teknis. |
| Pertahankan test/enum/docs | ✅ Setuju | Aset terverifikasi, jangan dibuang. |
| Rewrite mahal → "restart terarah" | ✅ Setuju kehati-hatiannya | Tapi lihat §5 — kami **tidak menyarankan** repo baru. |

---

## 3. HAL YANG REVIEWER LEWATKAN

Reviewer menilai commit `1473a5c`. Working tree saat ini (belum commit, **75
file**) sudah menutup sebagian kritik:

| Kritik reviewer | Status di working tree SEKARANG |
|:----------------|:-------------------------------|
| `APP_DEBUG=true` di `.env.example` | ✅ **Sudah `false`** |
| `SESSION_SECURE_COOKIE` tak diset | ✅ **Sudah didokumentasikan** |
| 616 test | ✅ **740 test hijau · 2.007 assertions** |
| (tak disebut) bug logika | ✅ 4 bug nyata diperbaiki: `aturanJumlah` double-count, password policy, guard SPK Dibatalkan, tombol Tambah Pengguna |
| (tak disebut) fitur | ✅ Tanda tangan PDF, Profil lengkap, Saldo Kas/Bank |

⚠️ **Kesimpulan:** repo yang di-review **≠ repo terkini**. Beberapa gap sudah
tertutup, hanya belum di-commit. **Commit dulu** sebelum menilai ulang.

**Yang BELUM tertutup (tetap valid):**
- 🔴 Seeder masih menanam `password` polos (perlu setup interaktif).
- 🔴 OCR masih sinkron (belum queue job).
- 🔴 `UangKeluarForm` masih 1.620 baris (belum dipecah).
- 🔴 Backup masih 0 berkas (belum pernah jalan).
- 🟡 Docker/keputusan deploy belum final.

---

## 4. KETEGANGAN DASAR (akar masalah)

Ada **kontradiksi** yang reviewer tidak sebut eksplisit:

> Dokumen bilang **intranet** (`AGENTS.md:17`), tetapi kenyataan jalan di **VPS**
> (butuh hardening internet).

Ini **akar** dari hampir semua gap "hardening internet". Jadi pertanyaan
sebenarnya bukan *"siap internet?"* melainkan **"mau deploy ke mana?"**.

**Jawaban user (10 Okt 2026):** *"nanti akan dibeli server atau menggunakan PC
server rakitan."* → **Server on-premise** (dedicated PC), **bukan** VPS publik
(untuk saat ini). Implikasinya:

- **Hardening internet jadi PRIORITAS SEDANG**, bukan tinggi — server on-premise
  biasanya diakses lewat LAN.
- **TAPI** tetap wajib: `APP_DEBUG=false`, tanpa password default, session
  secure **bila** nanti diekspos ke internet.
- **Docker TIDAK wajib** untuk MVP on-premise (bisa manual), tapi **sangat
  membantu** agar deploy konsisten & queue worker jalan otomatis.

---

## 5. PENDAPAT JUJUR KAMI

Reviewer benar pada **diagnosis**. Kami **tidak menyarankan rewrite total** —
itu membuang 740 test hijau + logika domain yang sudah terverifikasi.

**Kami juga TIDAK setuju dengan "harus repo baru":**

> Anda **tidak butuh repo baru** untuk menambah queue, memecah form, atau
> menyiapkan Docker. Semua bisa **ditambahkan incremental** tanpa membuang test.
> "Restart terarah" baru masuk akal kalau **struktur** kodenya kacau — padahal
> arsitektur Anda sudah sehat, hanya **belum lengkap**.

**Perbedaan kunci kami vs reviewer:**

| Aspek | Reviewer | Kami |
|:------|:---------|:-----|
| Repo | Cenderung "repo baru (restart terarah)" | **Tetap repo ini**, tambah incremental |
| API | Siapkan sekarang | **Tunda** (Flutter belum pasti) |
| Docker | Dari awal | **Opsional** untuk on-premise; putuskan nanti |
| Urutan | Blueprint dulu | **Commit dulu**, lalu refactor form, lalu queue |

---

## 6. RENCANA TINDAK LANJUT (usulan, prioritas)

| # | Langkah | Dampak | Risiko | Perlu keputusan? |
|:-:|:--------|:------:|:------:|:----------------:|
| 0 | **Commit pekerjaan sekarang** (75 file) | Tinggi | Rendah | ✅ user commit |
| 1 | **Pecah `UangKeluarForm`** 1.620 baris → `app/Services` & `app/Actions` | Tinggi | **Sedang** | — |
| 2 | **OCR jadi queue job** (`app/Jobs/ProsesOcrNota.php`) + worker | Tinggi | Sedang | — |
| 3 | **Seeder tanpa password polos** → setup interaktif saat install | Tinggi (keamanan) | Rendah | ✅ |
| 4 | **Pastikan backup jalan** (jadwalkan + uji hasil berkas) | Sedang | Rendah | — |
| 5 | **Putuskan target deploy** (server on-premise vs internet) | Tinggi | — | ✅ |
| 6 | (Opsional) Docker Compose + Caddy untuk server | Sedang | Sedang | ✅ |
| 7 | (Tunda) API + Sanctum | — | — | ⏸ user: belum pasti |

### Catatan langkah #1 (refactor form) — cara aman

Pecah **bertahap**, jangan sekali jalan:
1. Pindahkan logika **murni** (perhitungan, aturan) ke `app/Services` — tes lama
   tetap hijau sebagai jaring pengaman.
2. Setelah tiap pemindahan, jalankan **suite penuh** (740 test) — kalau hijau,
   lanjut; kalau merah, batalkan langkah itu.
3. Form Filament tinggal deklarasi UI + `->rule()` validasi.
4. Target: `UangKeluarForm` < 400 baris.

### Catatan langkah #2 (queue OCR) — kenapa penting

Saat ini OCR memblokir request sampai ~38 detik dan menonaktifkan batas waktu
PHP. Di server on-premise yang dipakai beberapa admin, satu OCR panjang =
request menggantung. Job queue memindahkannya ke worker terpisah → UI responsif.

---

## 7. KESIMPULAN

1. **Review eksternal ini bagus** — diagnosis tepat, bukti kuat, tidak
   melebih-lebihkan. Layak dijadikan acuan.
2. **Koreksi satu hal:** OCR bukan "job di VPS yang hilang" — memang belum
   pernah dibuat job. Kesimpulannya (belum async) tetap benar.
3. **Reviewer menilai versi lama** — 75 file perbaikan belum di-commit.
4. **Jangan rewrite total.** Tambahkan lapisan yang kurang, incremental, sambil
   menjaga 740 test hijau.
5. **Urutan terbaik:** commit → pecah form → queue OCR → seeder aman → putuskan
   deploy → (opsional) Docker → (tunda) API.

> ⚠️ Dokumen ini **tidak mengubah kode apa pun** — murni analisis, sesuai
> permintaan. Menunggu keputusan user sebelum eksekusi.
