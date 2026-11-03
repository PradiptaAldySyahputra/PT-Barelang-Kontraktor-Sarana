# STATUS PENGERJAAN — Titik Lanjut Sesi

> Dibuat agar sesi berikutnya bisa **lanjut tanpa menebak**.
> Bahasa: Indonesia. Verifikasi ulang sebelum menulis angka/nama (aturan AGENTS.md §2.5).
>
> **Terakhir diperbarui:** 11 Oktober 2026
> **Cabang:** `main` · Perubahan sesi ini **belum di-commit** (aturan: user yang commit)

---

## 0u. Sesi 12 Okt 2026 (lanjutan 2) — Perbaikan "AI-Slop" TAMPILAN + BUG komentar bocor

**Mandat user:** "aislop itu ditampilan atau desain... tampilan nya masih
aislop". Fokus: benahi tampilan, bukan kode. Arah disepakati user:
**pertahankan bahasa desain "Clean Minimalist Enterprise"** yang ada,
benahi yang generik/berantakan — bukan ganti tema.

**Dikerjakan lewat tugas Kanban** `t_947f2222` (agent "desain", tampil di
kantor pixel 8791) + dituntaskan asisten. 3 commit agent:
- `19bdc4b` fix(font): font sistem benar-benar dipakai (bukan Inter bawaan
  Filament). Akar: Filament memuat Inter via font provider sendiri.
- `0abe6e5` refactor(dashboard): hilangkan "card soup" 15 kartu seragam ->
  blok logis (UANG / PERLU PERHATIAN / PEKERJAAN & TAGIHAN) + kartu
  "Lewat Tenggat" diberi penanda merah (terang `rgb(255,245,246)`,
  gelap `rgb(28,10,14)` + border rose).
- `72326ec` fix(tabel): kolom rupiah rata kanan + tebal di semua tabel
  keuangan; kotak cari ganda dibedakan (global "Cari di semua data" vs
  tabel "Cari di tabel ini").

**BUG KRITIS (diperkenalkan asisten, ditemukan user):** saat transformasi
anti-slop menghapus banner dekoratif `{{-- ==== ... ==== --}}` di
`resources/views/filament/pages/laporan.blade.php`, baris PEMBUKA `{{--`
ikut terhapus sementara penutup `==== --}}` tertinggal. Akibatnya 9 blok
isi komentar (mis. "PEMILIH PERIODE") BOCOR jadi teks di halaman Laporan -
terlihat berantakan. Diperbaiki: 9 pembuka komentar dipulihkan
(12 `{{--` = 12 `--}}`). Scan menyeluruh: hanya 1 berkas terdampak.

**Pelajaran:** `artisan serve` menyimpan opcache - setelah mengubah berkas
view, server HARUS di-restart, kalau tidak perubahan tidak terlihat
(membingungkan: berkas & compiled view bersih tapi browser masih lama).

**Tes regresi baru:** `tests/Feature/KomentarBladeTest.php` (2 tes) -
setiap Blade wajib punya `{{--` dan `--}}` seimbang + tidak ada baris
banner `====` di luar komentar.

**Verifikasi:** `pint` bersih; **882/882 tes lulus** (2.463 assertions);
browser nyata terang & gelap (sesi uji server-side, DIHAPUS setelahnya).

**Belum di-commit (menunggu user):** perbaikan form Uang Keluar
(`UangKeluarForm.php` - stepper dipendekkan, tombol hapus berlabel),
`docs/Design.md` (agent), `tests/Feature/PerbaikanSlopPanelTest.php`,
`tests/Feature/KomentarBladeTest.php`, dan perbaikan `laporan.blade.php`.
Aturan AGENTS.md §1: user yang commit/push.

---

## 0y. Sesi 12 Okt 2026 (lanjutan 6) — Chart modern (bar & donut)

**Mandat user:** "chartnya bisa diperbarui lebih modern seperti contoh gambar
desain tadi".

**Yang diperbarui:**
- **Bar chart Arus Kas:** batang lebih ramping (`maxBarThickness` 26,
  `barPercentage` 0.62), sudut atas membulat (`borderRadius` 8 +
  `borderSkipped: bottom`), hover lebih pekat, grid halus
  (`rgba(148,163,184,.16)`), legend titik bulat, tooltip radius 10, dan
  **sumbu-Y angka ringkas** (500.000.000 -> "500M").
- **Donut (Status Tagihan & SPK per Status):** celah antar segmen
  (`spacing` 3), sudut membulat (`borderRadius` 6), `hoverOffset` 8, cutout
  lebih besar (68%), legend & tooltip modern.

**BUG KRITIS yang ditemukan & diperbaiki (dan ditangkap tes baru):**
- Awalnya sumbu-Y ringkas dibuat dengan `RawJs` (`ticks.callback`). Ternyata
  **`RawJs` TIDAK terserialisasi** oleh `@js()` di Filament 5.8 -> nilainya
  jadi objek kosong `{}` di JSON -> Chart.js **GAGAL merender SELURUH bar
  chart** (kanvas kosong, terukur `painted: false`).
- Perbaikan: pakai `ticks.format` (opsi Intl bawaan Chart.js, array biasa,
  aman diserialisasi) -> `notation: compact`. Kanvas kembali ter-render
  (`painted: true`).
- Ditambah uji regresi `test_opsi_chart_arus_kas_bisa_diserialisasi_ke_json`.

**Verifikasi:** 3 canvas chart `painted: true`; sumbu-Y "500M"; donut bercelah.
**891/891 tes lulus · 2.480 assertions**; pint bersih.

## 0x. Sesi 12 Okt 2026 (lanjutan 5) — Penyesuaian lanjutan ke referensi Prodex (soft UI)

**Mandat user:** "masih belum mirip dan sudah sesuai, bisa lakukan penyesuaian
kembali?" Setelah mengukur referensi vs BKS, jarak yang diperkecil (warna tetap
satu aksen biru):

| Elemen | Referensi | BKS sebelum | BKS sesudah |
|:--|:--|:--|:--|
| Kanvas halaman | abu `#EEF0F4` | `#fafafa` | `#eef0f4` |
| Radius kartu | 16px | 10px | 16px |
| Padding kartu | 20-24px | 14-16px | 18-22px |
| Ikon KPI | squircle 40px | tanpa ikon | squircle 40px pastel |
| Bayangan | ambient halus | none | `0 1px 2px + 0 6px 16px` |

**Perubahan (theme.css bagian 24 + RingkasanKeuangan.php):**
1. Kanvas abu `#eef0f4` (gelap `#08080a`) supaya app "melayang".
2. Semua kartu/section radius 16px + border `#e6e8ee` + bayangan ambient.
3. Ikon chip squircle 40px pastel biru di SEMUA 12 kartu dashboard.
4. Label kartu Title Case (bukan HURUF BESAR semua), padding section 20-24px.
5. Ikon bermakna per kartu (dokumen, panah, jam, kunci pas, dll).

**Verifikasi (ukur DOM):** `bodyBg` `rgb(238,240,244)`; kartu radius `16px`,
padding `18px 20px`; ikon chip `40x40px` radius `12px` bg `rgb(239,246,255)`;
12/12 kartu dashboard ber-ikon; 7/7 kartu KPI Laporan ber-ikon.
**890/890 tes lulus · 2.478 assertions**; pint bersih.

**Catatan:** lagi-lagi perubahan PHP sempat tidak termuat karena opcache -
restart server + `optimize:clear` (kejadian berulang, sudah dicatat di skill).

## 0w. Sesi 12 Okt 2026 (lanjutan 4) — Adopsi struktur desain referensi (Prodex), warna tetap satu aksen

**Mandat user:** kirim gambar `original-65051695e5b57ea9deae9fac54b6f1e3.webp`
(dashboard "Prodex") dan tanya "seperti desain ini bisa?". User memilih:
**adopsi struktur & komponennya, warna tetap SATU aksen biru** (aturan BKS).

**Yang diadopsi dari referensi (komponen yang belum ada di BKS):**
1. **Donut chart** untuk "Pengeluaran per Kategori" (Laporan) - sebelumnya
   hanya daftar progress bar. Cincin dibuat `conic-gradient` (tanpa library),
   palet SATU aksen biru #2563eb dengan alpha bertingkat (bukan warna-warni),
   total di lubang tengah, daftar + porsi % di samping.
2. **Feed "Aktivitas Terbaru"** (widget dashboard baru) - 6 transaksi terakhir
   (masuk & keluar), terbaru di atas, titik hijau/merah + nominal bertanda.
   Menjawab "apa yang baru terjadi?" yang sebelumnya tidak ada.

**Yang TIDAK diadopsi (sengaja):** gradient warna-warni per metrik - melanggar
aturan "satu warna aksen saja" yang dikunci `DesainBaruTest`.

**Verifikasi (browser + ukur DOM):**
- Donut: `.bks-donut` ada, `conic-gradient(rgb(37,99,235) 0% ...)`; total tengah
  Rp 1.699.557.067; daftar Material 55.1% / Upah 36.1% / dst.
- Feed: 8 heading dashboard termasuk "Aktivitas Terbaru", 6 item; widget
  terdaftar di `Dashboard::getWidgets()` (daftar eksplisit, bukan discover).
- **890/890 tes lulus · 2.478 assertions** (naik dari 885); pint bersih.

**Catatan:** perubahan `Dashboard.php` (daftar widget) sempat tidak termuat
karena **opcache** `artisan serve` - perlu restart + `optimize:clear`.

## 0v. Sesi 12 Okt 2026 (lanjutan 3) — Desain Dashboard & Laporan: animatif, menarik, informatif

**Mandat user:** "lanjut perbaiki desain kembali masih lengket dengan aislop,
gunakan desain yang profesional terutama untuk dashboard dan laporan untuk
card dan bagian lain buat lebih animatif menarik dan informatif untuk menu
bagian lain juga".

**Arah desain (antislop during):** pertahankan bahasa "Clean Minimalist
Enterprise" (satu aksen biru #2563eb), TAMBAH kejelasan & makna.
Prinsip: animasi hanya sebagai pengarah perhatian (bukan loop tanpa henti);
warna tetap satu aksen + semantik (hijau masuk / merah keluar); semua
tambahan MEMBAWA INFORMASI, bukan dekorasi. Hormati `prefers-reduced-motion`.

**Yang dikerjakan (theme.css bagian 23 + widget + blade):**
1. Kartu stat: animasi masuk bertahap (stagger 40-510ms) + hover terangkat.
2. Dashboard: **sparkline tren 6 bulan** di kartu "Sudah Diterima" &
   "Uang Keluar" (satu query agregat, tanpa N+1). Ini informasi arah uang.
3. Laporan: kartu ringkasan jadi kartu KPI ber-ikon bermakna + **progress
   bar % penerimaan** (uang masuk dari SPK vs nilai SPK).
4. Saldo negatif ditandai merah (`bks-kpi-angka--bahaya`) - informasi, bukan hiasan.
5. Transisi halaman halus (`.fi-main`).

**Bug yang ditemukan & diperbaiki saat verifikasi:**
- Sparkline bawaan Filament `position:absolute` di dasar kartu MENIMPA
  deskripsi panjang (terukur tumpang-tindih 20px). Diperbaiki: chart jadi
  baris statis di bawah deskripsi (`position:static` + flex kolom).
- Persentase "Sudah Diterima" meledak jadi "4.000.000.000%" saat nilai SPK = 0
  (bagi dengan max(0,1)). Diperbaiki: tampilkan persen hanya bila SPK > 0.
- Ikon "Belum Diterima" memakai amber `#d97706` - MELANGGAR aturan satu aksen
  (ditangkap `DesainBaruTest`). Diganti netral abu.

**Verifikasi (browser sungguhan + ukur DOM, bukan tebakan):**
- Sparkline: 2 canvas hadir; overlap deskripsi = false; kartu seragam 163px.
- Laporan: 7 kartu KPI, 7 ikon, 1 progress bar, 2 angka negatif merah
  (`rgb(225,29,72)`); ikon "tenggat" netral `rgb(244,244,245)`.
- Mode gelap: angka `rgb(250,250,250)` di latar `rgb(12,12,14)` (kontras ~19:1).
- **885/885 tes lulus · 2.466 assertions**; pint bersih; route sesi uji terhapus.

**Catatan penilaian:** model penglihat 3x salah menilai ("kolom uang tidak
rata kanan", "angka kartu tidak sejajar", "teks gelap di mode gelap") - semua
terbukti keliru lewat pengukuran DOM. Selalu ukur, jangan percaya mata saja.

## 0t. Sesi 12 Okt 2026 (lanjutan) — Refactor Anti-Slop (kode) + Ponytail

User: *"pecahkan saja bagian lain juga yang kalau terlalu panjang codenya
jadi susah untuk di manage... perbaiki dan penulisan code dengan ponytile"*.

Skill aktif: `antislop` (mode DURING) + `antislop-code` + `ponytail`.

**Prinsip yang dipakai (ponytail):** ekstraksi method (bukan menambah layer
abstraksi), DRY pada duplikasi nyata, hapus kode mati. **Tanpa** mengubah
perilaku. Setiap langkah diverifikasi `php -l` + tes terkait.

**File dipecah** (satu method raksasa -> method per bagian):
- `UangMasukForm` (1x293 -> 5 bagian + configure)
- `SpkForm` (1x250 -> 9 bagian)
- `SpksTable` (1x273 -> configure/kolom/filter)
- `UangMasuksTable`, `UangKeluarsTable` (-> kolom/filter/aksi)
- `UangKeluarForm::configureSekaligus` (164 -> langkah1/2/3 + repeaterPengeluaran)
- `Laporan::getViewData` (145 -> 6 method) & `ekspor` (207 -> siapkanDataEkspor + unduhPdf/Xlsx/Csv)
- `RingkasanKeuangan::getStats` (136 -> 5 barisUang/Pekerjaan/Tagihan/Saldo/Master)
- `CatatPembayaran::make` (-> skema + simpan)
- `StatusSpkResource`, `TagihanSpkResource`, `TagihanSelesaiSpkResource::table` (-> kolom/filter)
- `NotaPengeluaran::susunBaris` (148 -> 4 method), `PembacaIsiNota::cariNominal` (82 -> 2)

**DRY (duplikasi nyata dihapus):** 12 method `canCreate/canEdit/canDelete`
identik di 4 Resource -> dipindah ke trait `BolehUbahData` (Resource yang punya
aturan khusus seperti `PenggunasResource`/`MonitoringSpkResource` tetap
menang lewat override).

**Kode mati dihapus:** `UangKeluar::labelKategori()`, `UangKeluar::scopeUmum()`,
`RakitEkspor::susunDari()` (terbukti 0 pemakai).

**Verifikasi:** `pint` bersih; **867/867 tes lulus** (2.426 assertions);
browser nyata (sesi uji server-side, DIHAPUS setelahnya): 13 halaman admin
render 200; otorisasi terbukti (Direktur tanpa tombol Tambah, Admin ada);
ekspor CSV/XLSX/PDF ketiganya HTTP 200 dengan berkas valid (XLSX terbaca
Excel, PDF 3 halaman).

---

## 0s. Sesi 12 Okt 2026 (lanjutan) — Audit Anti-Slop (skill baru user)

User menambah skill **anti-slop** (core + code/ui/copy/human/layoutmobile),
**ponytail** + **ponytail-audit**, dan **Matt Pocock** (code-review,
simplify-code, requesting-code-review, improve-codebase-architecture), lalu
minta kode diperbaiki sesuai skill tersebut.

- **Mode: AFTER** (dipilih user) → audit dulu, temuan bernomor, user pilih.
  Laporan: `anti-slop/audit-001-2026-10-12.md`.
- **Keputusan user:** F-01 + F-02 sekaligus; placeholder `'—'` ikut diganti.
- **Hasil:** 977 em-dash + 464 banner dekoratif + 39 em-dash CSS dibersihkan
  (250 file). **0 perubahan logika** (dibuktikan: kode tanpa komentar &
  baris kosong identik dengan backup `/tmp/bks-backup-antislop-*`).
- **Verifikasi:** `pint` bersih; **867/867 tes lulus** (2.426 assertions);
  halaman login render HTTP 200 di server uji.
- **Temuan bersih (bukti negatif):** emoji komentar 0, TODO/FIXME 0,
  empty catch 0, interface-1-impl 0, a11y (`alt`/`type`/`aria-label`) lengkap.
- **Tidak dikerjakan:** F-03 (pecah `UangKeluarForm.php` 849 baris) — berisiko
  ke banyak tes; menunggu permintaan user.

---

## 0r. Sesi 12 Okt 2026 (lanjutan) — BUG-06 & BUG-07: Foto Profil

Keluhan user: *"avatar tidak berubah ketika kembali atau pada halaman lain"* +
*"tidak dapat menyesuaikan posisi gambar... cuma kepala rambut tidak terlihat."*

### BUG-06 — Foto tidak muncul di topbar (lanjutan BUG-05 yang belum tuntas)

**Akar masalah:** Filament hanya memanggil `getFilamentAvatarUrl()` bila model
`instanceof Filament\Models\Contracts\HasAvatar`:
```php
if ($user instanceof HasAvatar) { $avatar = $user->getFilamentAvatarUrl(); }
```
Model `Pengguna` punya method-nya (BUG-05) tapi **TIDAK implements `HasAvatar`**
→ Filament mengabaikannya & jatuh ke avatar inisial. Tes lama lulus **PALSU**
(hanya menguji method, bukan interface yang benar-benar dibaca Filament).

**Perbaikan:** `class Pengguna implements FilamentUser, HasName, HasAvatar`.

### BUG-07 — Tidak bisa atur posisi foto (kepala terpotong)

**Akar masalah:** `->avatar()` memakai `automaticallyCropImagesToAspectRatio()`
→ memotong otomatis dari **TENGAH** foto. Foto setengah badan/berdiri punya
kepala di ATAS → terpotong.

**Perbaikan:** tambah `->imageEditor()->circleCropper()` pada field avatar.
Pengguna kini bisa **geser, zoom, putar, balik** foto sebelum disimpan
(terverifikasi: editor punya Mode geser/potong, Perbesar/Perkecil, Geser 4 arah,
Putar, Balik). Panduan crop **bulat** sesuai tampilan avatar Filament.

**Terverifikasi browser:** unggah foto potret → crop → simpan → avatar muncul
di topbar Dashboard/SPK/Laporan/Mitra (URL `nota/profil/...`, bukan lagi
`ui-avatars.com`); hapus foto → kembali ke inisial. **Tes:** `ProfilDiperluasTest`
(+4 tes: interface HasAvatar, jalur Filament, image editor, circle cropper).

**⚠️ Pelajaran:** setelah mengubah model/config, **restart `artisan serve`** —
server lama menyimpan opcache sehingga perubahan `implements` tidak terlihat.

**Suite:** 867 lulus · 2.426 assertions · pint bersih.

---

## 0q. Sesi 12 Okt 2026 — Bagian C: Keputusan User + Status Email

Prompt Bagian C minta **keputusan pengguna** dulu. Hasil tanya-jawab:

| Item | Keputusan user | Tindakan |
|:-----|:---------------|:---------|
| **Lupa Password / SMTP** | Siapkan kode + dokumentasi .env SMTP | Dokumentasi + indikator Status Sistem |
| **Aging piutang** | **Tetap dihapus** (hormati keputusan lama) | Tidak diubah |
| **Kolom avatar** | **Biarkan di form** (sesuai tanda ⏸️) | Tidak disentuh |

**Yang dikerjakan (hanya Lupa Password/SMTP):**

1. **Dokumentasi SMTP** di `.env.example` (contoh Gmail & cPanel) dan
   `docs/Architecture.md` §12.2.1.
2. **Indikator Email di Status Sistem** — pengecekan ke-6: `StatusSistem::email()`
   melaporkan mailer aktif/belum. Bila `MAIL_MAILER=log` → kartu MERAH
   "Belum aktif (log)" + saran isi SMTP. Tes: `StatusSistemTest` (2 tes baru).

**Temuan penting (dicatat di docs):**
- ⚠️ Notifikasi `ResetPassword` Filament implements `ShouldQueue`. Dengan
  `QUEUE_CONNECTION=sync` jalan langsung; bila `database`, butuh queue worker.
- ⚠️ `MAIL_MAILER=log` **tidak** menampilkan tautan bila `LOG_LEVEL=error`
  (bawaan server) — mail log ditulis di level `info`. Untuk uji, set
  `LOG_LEVEL=debug`. **Inilah alasan admin butuh indikator Status Sistem**:
  tanpa SMTP + LOG_LEVEL=error, tautan reset praktis tak terlihat.

**Alur lupa password sudah lengkap & teruji** (sebelumnya): anti-enumerasi,
rate limit 5×/menit, token 60 menit. Verifikasi browser: halaman
`/admin/password-reset/request` kirim → token terbuat di
`password_reset_tokens`; halaman reset (URL bertanda tangan) terbuka dengan
2 field kata sandi. **Suite:** 863 lulus · 2.418 assertions · pint bersih.

---

## 0p. Sesi 11 Okt 2026 (lanjutan 9) — A.2 Peta Warna Badge + A.3 Mode Gelap Menyeluruh

**A.2 — Peta warna badge KONSISTEN.** Sebelumnya warna badge ditulis TERPISAH
di tiap tabel (`match` hardcode). Sekarang **semua warna dipusatkan** di method
`warnaBadge()` pada tiap enum (satu sumber kebenaran) — sama seperti StatusSpk.
Enum yang ditambahi: `KategoriPengeluaran`, `DikerjakanOleh`, `KategoriMitra`,
`Peran` (4 enum; 4 enum lain sudah punya). Pemakaian di
`UangKeluarsTable`/`MitrasTable`/`PenggunasTable`/`SpksTable`/`StatusSpkResource`/
`PreviewSpk` diganti ke `->warnaBadge()`. Tes baru `PetaWarnaBadgeTest` (11 tes)
mengunci: tiap enum badge punya `warnaBadge()` + warnanya warna resmi Filament +
tabel tidak lagi menulis peta warna hardcode.

**A.3 — Mode gelap diverifikasi MENYELURUH (16 halaman).** Semua halaman admin
(dashboard, 6 resource, laporan, arsip nota, backup, status sistem, impor, ekspor,
profil, 3 form tambah) berhasil mode gelap: latar `rgb(9,9,11)`, teks terang,
badge kontras. **Temuan penting:** 3 halaman tampak "putih" saat diuji sebagai
Direktur — ternyata itu halaman **403 Forbidden** (Backup/Status Sistem/Impor =
Admin-only), bukan bug tema. Verifikasi harus pakai **Admin**.

**Suite:** 861 lulus · 2.409 assertions · pint bersih · terverifikasi browser.

**Bonus — perbaikan tes FLAKY.** `UangKeluarFactory` mengacak kategori dari
`KategoriPengeluaran::cases()`, termasuk "Lainnya". Sejak kebijakan A.5,
"Lainnya" mewajibkan `detail_kategori`, jadi bila acak mendapat "Lainnya"
tanpa detail, save ditolak → tes gagal **acak** (flaky, kadang hijau kadang
merah). Perbaikan: kategori acak default TIDAK menyertakan "Lainnya"; ditambah
state `lainnya()` untuk tes yang memang butuh. Diverifikasi stabil 3× run.

---

## 0o. Sesi 11 Okt 2026 (lanjutan 8) — Sistem Desain v1.1 (Bagian A)

Implementasi prompt "Desain + Perbaikan Bug" Bagian A. **File acuan desain
(`sistem-desain-spk.md`, `prototipe-desain-spk.html`, `spesifikasi-ui-ux-spk.md`)
TIDAK ADA di filesystem** — dikerjakan dari detail yang tertulis di prompt saja.
BUG-1..5 sudah selesai di §0m.

| # | Item | Perubahan | Bukti |
|:--|:-----|:----------|:------|
| A.1 | Aksen biru `#2563eb` | Panel `primary` Zinc → **Blue**; theme.css `--brand-accent` amber → **biru**; **warna-warni per modul DIHAPUS** (dulu SPK biru/Keuangan hijau/Master violet/Laporan amber = pelangi) → satu aksen biru | `DesainBaruTest`, browser: tombol `rgb(37,99,235)` |
| A.3 | Mode gelap | Sudah aktif (bawaan Filament 5) + dikunci tes. Browser: bg `#09090b`, teks `#fafafa` | `DesainBaruTest::test_mode_gelap_aktif` |
| A.4 | Wizard 3 langkah | Form Tambah Uang Keluar → `Wizard` 3 Step. **Urutan disesuaikan alur nyata**: ① Unggah & OCR → ② Isi Rincian → ③ Review & Simpan (kalau "Data dulu", langkah Data KOSONG karena baris dibuat OCR). Sticky bar tetap | `DesainBaruTest`, browser: 3 step tampil |
| A.5 | Field reaktif | (a) Kategori="Lainnya" → **Detail kategori** muncul & WAJIB (kolom baru `detail_kategori`); (b) pilih SPK → sisa piutang (sudah ada); (c) pilih Kas/Bank → **hint saldo terakhir** (baru) | `FieldReaktifTest` |
| A.7 | Rapikan Profil | 3 **kartu berdampingan** (Foto·Data·Keamanan) + `getMaxWidth(7xl)` → satu layar, tidak memanjang; **field "Tanda Tangan" DIHAPUS** dari form (kolom DB & kode TTD dibiarkan) | `ProfilDiperluasTest`, browser: 3 kartu top=169 (sejajar) |

**Keputusan user:** kolom `detail_kategori` ditambah sebagai **kolom baru** (bukan menumpang `keterangan`); aksen diganti ke biru `#2563eb`.

**Tes lama yang diperbarui (mengunci perilaku lama):** `TemaTest` (monokrom→biru),
`ProfilDiperluasTest` (TTD ada→tidak ada), `TataLetakUangKeluarTest` (Section→Wizard),
`FilamentResourceTest` (kategori Lainnya + detail_kategori).

**Suite:** 850 lulus · 2.362 assertions · pint bersih.

**⚠️ Belum dikerjakan (menunggu keputusan / file acuan):** Bagian A.2 (peta warna
badge konsisten — butuh sistem-desain §2), Bagian C (SMTP lupa password, aging
piutang, kolom avatar). BUG-1..5 selesai (§0m).

---

## 0n. Sesi 11 Okt 2026 (lanjutan 7) — Penataan Menu (keluhan user)

Menindaklanjuti keluhan verbatim user: *"fiturnya banyak berantakan … bagian spk
di list spk masih menampilkan banyak data sampai harus scroll kesamping …
status dan tagihan sudah ada menunya … deskripsi pada setiap menu terlalu
panjang … uang masuk keluar masih ada total"*.

Dikerjakan **tanpa** file acuan desain (belum tersedia) — bagian yang tidak
butuh bahasa visual.

| # | Keluhan | Perbaikan | Bukti |
|:--|:--------|:----------|:------|
| 1 | List SPK lebar → scroll ke samping | Kolom **Status SPK, Status Tagihan, Pengantaran, Sudah Diterima, Belum Diterima** disembunyikan default (`toggleable(isToggledHiddenByDefault: true)`) — bagiannya punya menu sendiri (Status SPK / Tagihan SPK). Kolom tetap ADA, bisa diaktifkan dari tombol **Columns**. | browser: header hanya 8 kolom (`PenataanMenuTest`) |
| 2 | Deskripsi menu kepanjangan | Subjudul `getSubheading()` dipendekkan di List SPK/UangMasuk/UangKeluar/Mitra/Pengguna (≤ 80 karakter) | `PenataanMenuTest::test_subjudul_menu_pendek` |
| 3 | "Uang masuk keluar masih ada total" (ganda) | Total bawaan bawah tabel **dimatikan** (`summaries(pageCondition: false, allTableCondition: false)`); **satu** total tetap di bar atas (`->header()`, filter-aware + rincian kategori) | `RingkasanTotalUangTest`, `TotalTerfilterTest` |

**Catatan teknis:** `summaries(pageCondition: false)` saja TIDAK cukup — harus
`allTableCondition: false` juga, karena keduanya adalah flag terpisah.

**Pelaporan tes `PreviewSpkTest`:** tes lama `assertSee('20.000.000')` dulu lulus
**kebetulan** karena angka itu muncul di kolom tabel yang kini disembunyikan —
bukan dari isi slide-over (Filament 5 merender isi modal secara lazy). Diperbaiki
memakai `assertSchemaComponentStateSet()` sehingga benar-benar menguji isi
preview (`diterima`, `sisa_tagih`, dst.).

**Verifikasi browser (sungguhan):** List SPK 8 kolom tanpa scroll samping; Uang
Keluar menampilkan **satu** bar "TOTAL UANG KELUAR (TERFILTER) Rp 1.699.557.067
dari 31 transaksi"; ringkasan bawah tabel hilang.

**Suite:** 839 lulus · 2.340 assertions · pint bersih.

---

## 0m. Sesi 11 Okt 2026 (lanjutan 6) — Perbaikan 5 BUG (prompt desain+bug)

Perbaikan bug dari prompt "Desain + Perbaikan Bug". TDD: tes gagal-sebelum → hijau.

| # | Bug | Perbaikan | Bukti |
|:--|:----|:----------|:------|
| BUG-1 | Impor O(n²): `sudahAda()` memuat SELURUH tabel per baris | Sidik jari dihitung **sekali** per impor (`sidikTersimpan()`), cek ke himpunan | `test_impor_banyak_baris_cepat_dan_tanpa_duplikat` (500 baris) |
| BUG-2 | Impor melewati aturan bisnis | Tegakkan **(a)** uang masuk ≤ sisa piutang (akumulasi per batch), **(b)** SPK Dibatalkan tolak, **(c)** tanggal ≤ hari ini → masuk daftar `gagal` | 6 tes baru di `ImporTransaksiTest` |
| BUG-3 | ZIP Arsip Nota OOM (`get()` + `addFromString`) | Pakai `$zip->addFile()` (streaming) + try/catch + bersihkan ZIP kosong | `test_buat_zip_tetap_jalan_walau_sebagian_berkas_hilang` |
| BUG-4 | Menu "Backup & Restore" tanpa Restore | **Ganti nama → "Backup"** (keputusan user) | `BackupRestore.php` |
| BUG-5 | Foto profil tak tampil di topbar | Tambah `Pengguna::getFilamentAvatarUrl()` (jembatan ke `urlAvatar()`) | `ProfilDiperluasTest` (2 tes) |

**Bonus — perbaikan backup "error saat diekstrak" (WinRAR):**
Berkas backup dulu `.sql.gz` (gzip mentah). Di Windows, WinRAR/7-Zip sering
melaporkan error karena asosiasi gzip→sql membingungkan. Diubah jadi **`.zip`**
berisi `.sql` — bisa dibuka langsung tanpa aplikasi tambahan. Retensi tetap
mendukung `.sql.gz` lama.

Diverifikasi: `bks:backup` → `.zip` valid (`7z t` = "Everything is Ok"), unduh
HTTP identik; browser: menu "Backup" tampil, "Restore" hilang, halaman render.

**Suite:** 835 lulus · 2.294 assertions · pint bersih.

---

## 0l. Sesi 11 Okt 2026 (lanjutan 5) — Refactor "god class" UangKeluarForm

`UangKeluarForm` dulu **1.620 baris** (god class — keluhan reviewer eksternal
& permintaan user "perbaikan struktur dan penulisan code"). Logika MURNI
(OCR + penyusun baris + salin isian, ± 750 baris) dipindah ke kelas baru
`App\Support\NotaPengeluaran`. Sekarang:

| Berkas | Sebelum | Sesudah | Peran |
|:-------|--------:|--------:|:------|
| `UangKeluarForm.php` | 1.620 | **774** | lapisan skema (tampilan form) |
| `NotaPengeluaran.php` | — | **753** | logika murni (bisa diuji tanpa Livewire) |

⚠️ API publik & konstanta DIPERTAHANKAN sebagai alias (`UangKeluarForm::MAKS_BARIS`
= `NotaPengeluaran::MAKS_BARIS`, dst) supaya 12 file tes + view `progres-pengisian`
tetap jalan tanpa diubah. Method publik (`susunBaris`, `prosesOcr`,
`jalankanOcrPenuh`, `salinIsianKeBarisKosong`, `gabungBaris`) kini mendelegasikan.

**Verifikasi:** 823 tes lulus (termasuk 99 tes Uang Keluar), browser: halaman
Tambah & Ubah render tanpa error `unresolvable`.

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

## 5. Status Item Fitur & Keputusan Sesi Ini

| Kode | Item | Status |
|:-----|:-----|:-------|
| **B1** | Saldo berjalan Kas & Bank | ✅ **Selesai** (`BukuKasBank::susun` + mutasi saldo berjalan di Laporan) |
| **B4** | Ekspor Excel format perusahaan | ✅ **Selesai** (Kop PT BKS, freeze pane, total, dan tanda tangan Direktur & Admin) |
| **C1** | Navigasi/UI lebih tegas | ✅ **Selesai** (Tombol kembali tunggal di atas komponen breadcrumb, tanpa duplikasi di bawah) |
| **C3** | Menu baru: Kalender Tenggat | ✅ **Selesai** (Tampilan kalender bulanan tenggat SPK di `/panel/spk/calendar`) |
| **B3** | Impor data perusahaan | ✅ **Selesai** (`PembacaImpor` toleran kop dan membaca 94 baris kas riil) |

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
