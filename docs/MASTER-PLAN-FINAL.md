# MASTER-PLAN FINAL — Audit Menyeluruh Sistem BKS

> **Proyek:** Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana
> **Stack:** Laravel 13 · Blade + Livewire 4 (TailAdmin) · Tailwind CSS v4 · MySQL/MariaDB · PHP 8.5
> **Tanggal audit:** 12 November 2026
> **Sifat dokumen:** laporan audit + rencana bertahap. **Tidak ada berkas kode yang diubah** dalam penyusunan dokumen ini.
> **Status bukti:** setiap temuan menyebutkan berkas dan baris atau perintah yang diverifikasi. Temuan yang belum diuji dinyatakan sebagai "belum diverifikasi", bukan sebagai fakta.

---

## 0. Ringkasan Eksekutif

| Aspek | Keadaan terukur |
|:--|:--|
| Kepatuhan aturan bisnis inti (piutang, SPK Dibatalkan, tanggal ≤ hari ini, status kanonis) | **Terpenuhi di kode**, terverifikasi di controller dan enum |
| Suite pengujian | **513 tes lulus / 2160 asersi**, 64 berkas tes, `pint` bersih, `npm run build` sukses |
| Kesiapan server LAN | **Belum siap** — `APP_ENV=local`, `APP_URL=http://localhost:8000`, tujuan backup belum diarahkan ke HDD `/data` |
| Filter tanggal | Baru diseragamkan menjadi **satu kotak tanggal** di 6 halaman |
| Utang teknis terbesar | 116 berkas belum di-commit, penjaga kesiapan server tidak memeriksa OPcache/APP_ENV, OCR tanpa retry |

**Kesimpulan satu paragraf.** Sistem sudah matang dari sisi aturan bisnis dan pengujian: aturan piutang, penolakan transaksi pada SPK Dibatalkan, batas tanggal transaksi, dan sinkronisasi status tagihan benar-benar dijalankan kode serta dijaga tes. Yang belum siap adalah **sisi operasional**: konfigurasi `.env` masih lokal (bukan server kantor), tidak ada pemeriksaan OPcache/cache produksi di perintah kesiapan, backup belum diarahkan ke disk data terpisah, dan pekerjaan OCR bergantung pada worker yang hidup di luar aplikasi. Fase 1 di bawah menutup celah operasional ini tanpa menyentuh alur bisnis.

---

## 1. Metodologi Audit

Yang **dilakukan**:

- Membaca `docs/Rules.md` (339 baris), `docs/PRD.md` (289 baris), `docs/Architecture.md` (832 baris) untuk memetakan aturan yang mengikat.
- Menelusuri kode: seluruh controller (`Spk`, `CashIn`, `CashOut`, `Partner`, `User`, `System`, `Report`, `Auth`, `Dashboard`), 9 komponen Livewire, 1 job (`EkstrakNotaOcr`), 7 perintah artisan, 2 middleware, 3 service.
- Memeriksa `.env`, `config/ocr.php`, `routes/console.php`, `routes/web.php`, serta penjadwalan backup dan pembersihan.
- Menjalankan `php artisan test` (513 lulus), `pint`, `npm run build`, `php artisan route:cache` (berhasil), dan pengukuran DOM di browser 1440px serta 375px.
- Memeriksa penataan tabel: 92 pemakaian `text-right`, 100 pemakaian `Format::rupiah`, dan mencari berkas yang memuat rupiah tanpa perataan kanan.

Yang **tidak** dilakukan (agar tidak melebihkan klaim):

- Tidak menguji beban nyata (load test) maupun ukuran data produksi.
- Tidak menguji perangkat pemindai/HP untuk OCR di lapangan.
- Tidak menguji server fisik `bks-server`; penilaian deployment berbasis konfigurasi repo.
- Tidak menilai estetika secara subjektif; penilaian UI berbasis ukuran DOM dan konsistensi token.

---

## 2. Domain 1 — Aturan Bisnis & Keuangan

### 2.1 Yang sudah benar (terverifikasi di kode)

| Aturan | Bukti | Status |
|:--|:--|:--|
| `piutang = nilai_spk − sudah_diterima` tanpa retensi | `app/Http/Controllers/CashIn/CashInController.php:145` (`$batas = $spk->piutang()`), `:242-258` | ✅ |
| Uang masuk tidak boleh melebihi piutang | Validasi simpan di `CashInController.php:238-260`, pesan menyebut nilai SPK, sudah diterima, dan maksimal | ✅ |
| SPK `Dibatalkan` menolak transaksi baru | `CashInController.php:236-240` dan `:246`; tes `AlurBisnisE2ETest` butir [8] | ✅ |
| Tanggal transaksi ≤ hari ini | `CashInController.php:225`, `CashOutForm.php:225`, `ReceiptUploadForm.php:267`, `SpkController.php:362` | ✅ |
| Status tagihan sinkron otomatis | `app/Observers/SinkronStatusTagihanObserver.php` | ✅ |
| "Dibayar" hanya bila piutang 0 | `SpkController.php:265` menolak dengan pesan sisa piutang | ✅ |
| Retensi, laba-rugi, pajak tidak dihitung | `app/Models/Spk.php:172-176` menyatakan perhitungan ini dihapus | ✅ sesuai keputusan |
| BAST & kuitansi tersedia sebagai PDF | `routes/web.php:227-237` (`panel.spk.bast`), `reports/bast-pdf`, `reports/kuitansi-pdf` | ✅ |

### 2.2 Celah dan risiko

| # | Temuan | Dampak | Tingkat |
|:--|:--|:--|:--|
| B-1 | **Tidak ada penguncian periode.** Transaksi bertanggal lampau tetap dapat diubah kapan saja karena `tanggal ≤ hari ini` hanya membatasi tanggal, bukan hak edit atas data lama. | Laporan periode yang sudah diserahkan ke direktur dapat berubah tanpa jejak. | Sedang |
| B-2 | **Tidak ada jejak audit perubahan** (keputusan bisnis: audit log ❌). | Bila nominal berubah, tidak ada bukti siapa dan kapan. | Sedang (diterima sebagai risiko) |
| B-3 | **Penutupan buku BAST tidak memiliki status terkunci.** BAST dihasilkan dari data saat itu; setelah tercetak, transaksi masih bisa masuk ke SPK yang sama. | Angka BAST dapat berbeda dengan laporan berikutnya tanpa penanda. | Sedang |
| B-4 | **Tidak ada rekonsiliasi otomatis** antara total uang masuk dan piutang pada level laporan; konsistensi hanya dijaga saat input. | Kesalahan input historis (mis. sebelum validasi ini ada) tidak terdeteksi. | Rendah |

**Rekomendasi Fase 1 (tanpa mengubah alur bisnis):** tambahkan laporan diagnostik "Periksa Konsistensi Piutang" — membandingkan `nilai_spk`, `sum(uang_masuk.jumlah)`, dan `status_tagihan`, menampilkan baris yang tidak konsisten. Sifatnya baca-saja, tidak mengubah data, jadi tidak melanggar aturan bisnis mana pun.

---

## 3. Domain 2 — Frontend & Pengalaman Pengguna

### 3.1 Yang sudah benar

| Aspek | Bukti | Status |
|:--|:--|:--|
| Navigasi sidebar melebar saat kursor diarahkan | `layouts/sidebar.blade.php` (`@mouseenter`/`@mouseleave`), tes `NavigasiPanelTest` | ✅ |
| Menu aktif menyala tepat satu | `NavigasiPanelTest::test_dashboard_hanya_menyala_tepat_di_panel` | ✅ |
| Filter tanggal satu kotak di 6 halaman | `components/common/filter-tanggal.blade.php`, terukur 1 input per halaman, 0 luber di 1440px dan 375px | ✅ |
| Panel notifikasi & menu profil tidak terbuka bersamaan | `Alpine.store('panelMenu')` di `layouts/app-header.blade.php`, diuji lewat gerakan kursor | ✅ |
| Alert seragam (berhasil/gagal/validasi) | `components/common/alert.blade.php` | ✅ |
| Kolom nominal rata kanan | 92 pemakaian `text-right`; contoh `spk-table.blade.php:233` memakai `text-right ... tabular-nums` | ✅ sebagian |

### 3.2 Celah

| # | Temuan | Bukti | Tingkat |
|:--|:--|:--|:--|
| U-1 | **Dikoreksi 12 Nov 2026: hanya SATU tabel nyata yang belum rata kanan** (`bast-pdf`, kini dihapus). Enam berkas yang disebut semula ternyata teks pengingat, kartu KPI, dan `<dd>` daftar definisi — bukan kolom tabel. Pemeriksaan ulang: `grep Format::rupiah` + `<td` tanpa `text-right` = 1 baris. | `resources/views/reports/bast-pdf.blade.php` (dihapus) | Selesai |
| U-2 | **Keputusan filter tanggal menyisakan sisa kode.** `flatpickr` masih ada di `package.json` meski pemakaiannya sudah dibuang. | `package.json` | Rendah |
| U-3 | **Kalender Tenggat belum punya filter tanggal** meski halaman ini berisi tanggal. | `spk/calendar.blade.php` — 0 input tanggal | Rendah |
| U-4 | **Dashboard Direktur belum diaudit visual di sesi ini.** Diferensiasi peran ada di `DashboardController.php:26-29`, tetapi tata letaknya belum diukur ulang setelah perubahan terbaru. | `director/dashboard.blade.php` | Belum diverifikasi |
| U-5 | **Kontras mode terang** sudah dikembalikan ke token TailAdmin (`--color-gray-100/200`, `--shadow-theme-xs`), tetapi belum ada pengukuran rasio kontras formal. | `resources/css/panel.css` | Rendah |

**Rekomendasi Fase 2:** seragamkan perataan nominal (satu kelas utilitas `nominal` yang menetapkan `text-right tabular-nums`), tambahkan filter tanggal pada Kalender Tenggat bila disetujui, dan sapu bersih sisa `flatpickr`.

---

## 4. Domain 3 — Pipeline OCR & Arsip Nota

| Aspek | Bukti | Status |
|:--|:--|:--|
| Mesin OCR | `app/Services/PembacaNota.php:193-212` memanggil skrip Python `python/ocr_nota.py` lewat `Process::timeout(config('ocr.timeout', 60))` | ✅ |
| Pembagian tugas yang aman | `config/ocr.php` menyatakan OCR **hanya** menghitung jumlah dan posisi nota, **tidak** membaca nominal | ✅ keputusan bijak |
| Antrean | `EkstrakNotaOcr` dengan `$tries = 1` dan `$timeout = 600` | ⚠️ |
| Pembersihan berkas | `app/Console/Commands/BersihkanPotonganOcr.php`, dijadwalkan harian 02:00 | ✅ |
| Anti cache gagal | `PembacaNota.php:105` tidak menyimpan kegagalan sementara | ✅ |

| # | Temuan | Dampak | Tingkat |
|:--|:--|:--|:--|
| O-1 | **Tidak ada percobaan ulang** pada job OCR (`$tries = 1`). | Gangguan sesaat (proses dibunuh, memori penuh) membuat nota harus diunggah ulang manual. | Tinggi |
| O-2 | **Bergantung pada worker di luar aplikasi.** `QUEUE_CONNECTION=database`; bila worker systemd mati, unggahan berhenti di status menunggu tanpa peringatan di UI. | Admin mengira unggahan gagal padahal hanya menunggu. | Tinggi |
| O-3 | **Tidak ada penanda antrean macet** (job lebih tua dari X menit tanpa hasil). | Masalah baru terlihat saat admin mengeluh. | Sedang |
| O-4 | **Ukuran dan jenis berkas dibatasi** di validasi (`mimes:pdf,jpg,jpeg,png,webp`, `PenyimpanBerkas::maksUkuranKb()`), tetapi belum ada pemeriksaan jumlah berkas per transaksi. | Nota berjumlah besar memperlambat halaman arsip. | Rendah |

**Rekomendasi Fase 1:** naikkan `$tries` ke 3 dengan jeda bertingkat, tambahkan kartu status antrean di halaman Unggah Nota (jumlah menunggu/proses/gagal), dan peringatan di dashboard bila ada job lebih tua dari 10 menit.

---

## 5. Domain 4 — Keamanan & Manajemen Pengguna

| Aspek | Bukti | Status |
|:--|:--|:--|
| RBAC di rute | `routes/web.php` memakai `peran:admin,direktur` dan `peran:direktur` | ✅ |
| RBAC di komponen Livewire (bukan hanya rute) | `CashOutForm.php:56,119,202`, `ReceiptUploadForm.php:72,80,91,246`, `UserTable.php:94` memakai `abort_unless` | ✅ |
| Pembatasan percobaan login | `Auth/LoginController.php:47-72` memakai `RateLimiter` | ✅ |
| Kebijakan kata sandi terpusat | `AppServiceProvider` menetapkan `min(8)->letters()->numbers()` untuk semua jalur | ✅ |
| Header keamanan | `app/Http/Middleware/HeaderKeamanan.php` | ✅ |
| Data sensitif di repo | Data asli disimpan di `~/data-perusahaan-bks/`, bukan di repo | ✅ |

| # | Temuan | Dampak | Tingkat |
|:--|:--|:--|:--|
| S-1 | **`APP_ENV=local` pada berkas `.env`**, padahal target adalah server kantor. | Mode lokal mematikan optimasi dan dapat membocorkan detail kesalahan bila `APP_DEBUG` berubah. | Tinggi |
| S-2 | **`APP_URL=http://localhost:8000`** tidak sesuai alamat LAN `192.168.100.10:8232`. | URL yang dihasilkan (tanda tangan berkas, tautan unduhan, PDF) bisa salah saat diakses dari komputer lain. | Tinggi |
| S-3 | **`SESSION_SAME_SITE` dan `SESSION_SECURE_COOKIE` tidak diset** di `.env`. | Perlindungan CSRF lintas situs bergantung pada nilai bawaan, bukan pilihan sadar. | Sedang |
| S-4 | **Tidak ada daftar sesi aktif / keluar paksa** untuk Direktur. | Bila kata sandi admin bocor, tidak ada tindakan cepat selain mengganti kata sandi. | Sedang |

**Rekomendasi Fase 1:** siapkan `.env.production.example` dengan `APP_ENV=production`, `APP_URL` LAN, cookie `secure`/`same_site=lax`, lalu jalankan `bks:cek-server` sebagai gerbang sebelum go-live.

---

## 6. Domain 5 — Kesiapan Deployment & Performa

| Aspek | Bukti | Status |
|:--|:--|:--|
| Perintah kesiapan | `app/Console/Commands/CekKesiapanServer.php` memeriksa database, penyimpanan, antrean, ekstensi PHP (`pdo_mysql`, `zip`, `mbstring`), versi PHP ≥ 8.2 | ⚠️ tidak lengkap |
| Backup harian | `routes/console.php:21` `bks:backup --hari=30` pukul 23:00, retensi 30 hari, menyertakan folder nota | ✅ jalan, ⚠️ tujuan |
| Pembersihan OCR | `routes/console.php:37` `ocr:bersihkan --umur=24` pukul 02:00 | ✅ |
| Rekap harian | `routes/console.php:44` `bks:rekap-harian` pukul 17:30 | ✅ |
| Cache rute | `php artisan route:cache` **berhasil** (diuji) | ✅ |
| Cache view | `php artisan view:cache` **berhasil** (diuji) | ✅ |
| Lokasi backup | `config/filesystems.php:25` `backup_path` dari `STORAGE_BACKUP_PATH`, tetapi **variabel ini tidak ada di `.env`** | ❌ |

| # | Temuan | Dampak | Tingkat |
|:--|:--|:--|:--|
| D-1 | **Backup tidak diarahkan ke HDD data `/data`.** Tanpa `STORAGE_BACKUP_PATH`, arsip berada di `storage/app` pada SSD sistem. | Bila SSD sistem rusak, backup ikut hilang — persis skenario yang ingin dicegah. | Kritis |
| D-2 | **`bks:cek-server` tidak memeriksa OPcache, `APP_ENV`, dan cache produksi.** | Server bisa "lulus" pemeriksaan padahal berjalan tanpa optimasi. | Tinggi |
| D-3 | **Worker antrean tidak dimonitor dari aplikasi.** Hanya bergantung pada systemd di luar repo. | Antrean mati tanpa terlihat di panel. | Tinggi |
| D-4 | **116 berkas belum di-commit.** | Pekerjaan berhari-hari belum punya titik pulih di Git. | Tinggi (proses, bukan kode) |
| D-5 | **Belum ada prosedur pulih teruji** (restore sudah ada perintahnya, tetapi belum ada catatan uji restore berkala). | Backup ada, tetapi belum dibuktikan bisa dipulihkan. | Sedang |

---

## 7. Matriks Prioritas

| ID | Temuan | Domain | Tingkat | Fase |
|:--|:--|:--|:--|:--|
| D-1 | Backup tidak ke `/data` | Deployment | Kritis | 1 |
| S-1 | `APP_ENV=local` | Keamanan | Tinggi | 1 |
| S-2 | `APP_URL` masih localhost | Keamanan/Deploy | Tinggi | 1 |
| O-1 | Job OCR tanpa retry | OCR | Tinggi | 1 |
| O-2 | Antrean mati tanpa peringatan | OCR | Tinggi | 1 |
| D-2 | Pemeriksa server tidak cek OPcache/ENV | Deployment | Tinggi | 1 |
| D-4 | 116 berkas belum commit | Proses | Tinggi | 1 |
| B-1 | Tidak ada kunci periode | Bisnis | Sedang | 1 (laporan periksa) |
| S-3 | Cookie sesi belum diset | Keamanan | Sedang | 1 |
| D-5 | Restore belum diuji berkala | Deployment | Sedang | 1 |
| U-1 | 6 tampilan nominal belum rata kanan | UI | Sedang | 2 |
| O-3 | Tidak ada penanda antrean macet | OCR | Sedang | 2 |
| U-3 | Kalender Tenggat tanpa filter tanggal | UI | Rendah | 2 |
| S-4 | Tidak ada daftar sesi aktif | Keamanan | Sedang | 2 |
| U-2 | Sisa `flatpickr` | UI | Rendah | 3 |
| U-5 | Kontras belum diukur formal | UI | Rendah | 3 |
| B-3 | ~~BAST tanpa status terkunci~~ — **fitur BAST dihapus 12 Nov 2026** (di luar ruang lingkup) | Bisnis | Selesai | — |
| O-4 | Batas jumlah berkas per transaksi | OCR | Rendah | 3 |

---

## 8. MASTER-PLAN BERTAHAP

### Fase 1 — Prioritas Kritis (tanpa mengubah aturan bisnis)

**Tujuan:** sistem aman dijalankan di server kantor dan data tidak bisa hilang.

| Langkah | Tindakan | Kriteria selesai |
|:--|:--|:--|
| 1.1 | Buat `.env.production.example`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=http://192.168.100.10:8232`, `SESSION_SECURE_COOKIE=false` (LAN tanpa TLS) atau `true` bila HTTPS dipasang, `SESSION_SAME_SITE=lax`, `STORAGE_BACKUP_PATH=/data/backup-bks` | Berkas contoh ada; `.env` server memakai nilai itu |
| 1.2 | Arahkan backup ke HDD data, uji satu kali `php artisan bks:backup`, pastikan berkas muncul di `/data/backup-bks` | Ada berkas ZIP bertanggal hari ini di `/data` dan tercatat di log |
| 1.3 | Uji restore dari backup terbaru ke database uji | `php artisan bks:restore` berhasil, jumlah baris `spk` dan `uang_masuk` sama dengan sumber |
| 1.4 | Perluas `bks:cek-server`: periksa `opcache.enable`, keberadaan `bootstrap/cache/config.php` dan `routes-v7.php`, serta `APP_ENV` | Perintah menampilkan status OPcache dan cache produksi, gagal bila `APP_ENV=local` |
| 1.5 | Job OCR: `$tries = 3`, `backoff = [30, 120, 300]`, catat alasan gagal terakhir ke status unggahan | Tes job gagal-total menandai baris sebagai gagal dengan alasan |
| 1.6 | Panel Unggah Nota menampilkan jumlah menunggu/proses/gagal; dashboard menampilkan peringatan bila antrean tertua > 10 menit | Angka berubah saat job diproses; peringatan muncul saat worker dimatikan |
| 1.7 | Buat laporan baca-saja "Periksa Konsistensi Piutang" (SPK dengan selisih nilai vs pembayaran) | Halaman menampilkan 0 baris pada data yang konsisten |
| 1.8 | Commit seluruh pekerjaan yang tertunda (dilakukan **pengguna**, bukan agen) | `git status` bersih; ada tag/commit titik pulih |

### Fase 2 — UI/UX

| Langkah | Tindakan | Kriteria selesai |
|:--|:--|:--|
| 2.1 | Satu kelas utilitas nominal (`text-right tabular-nums`) dipakai di semua tabel & kartu angka, termasuk 6 tampilan yang belum rata kanan | Pemeriksaan otomatis: tidak ada `Format::rupiah` tanpa kelas nominal |
| 2.2 | Filter tanggal untuk Kalender Tenggat (satu kotak, sama seperti halaman lain) | Hanya 1 input tanggal, tanpa luber di 375px |
| 2.3 | Audit visual Dashboard Direktur vs Admin setelah semua perubahan | Kedua dashboard terukur: 0 overflow, 0 error konsol, kartu ringkas terbaca |
| 2.4 | Daftar sesi aktif + tombol keluar paksa untuk Direktur | Direktur dapat memutus sesi pengguna lain |
| 2.5 | Penanda antrean macet di panel (bukan hanya dashboard) | Muncul di menu Nota & Bukti bila ada job tertahan |
| 2.6 | Sapu bersih sisa `flatpickr` dari `package.json` dan `node_modules` | `npm ls flatpickr` kosong; build tetap sukses |

### Fase 3 — Optimasi & Penyempurnaan

| Langkah | Tindakan | Kriteria selesai |
|:--|:--|:--|
| 3.1 | **Selesai.** Rasio terukur: gray-500 4,97 · gray-600 7,69 · gray-700 10,46 · brand-600 11,18 · error-600 4,83 (lulus). Dua yang gagal diperbaiki: `success-600` 3,73 → `success-700` 5,41; `warning-600` 3,49 → `warning-700` 5,43 (13 berkas view). `gray-400` placeholder 2,58 dibiarkan (dikecualikan WCAG) | Angka tersimpan di §13 |
| 3.2 | **Tidak perlu migrasi.** `SHOW INDEX` membuktikan indeks sudah ada: `uang_masuk_tanggal_index`, `uang_keluar_tanggal_index`, `spk_status_spk_index`, `spk_status_spk_tagihan_index`, `spk_status_tanggal_akhir_index` | Tidak ada indeks baru ditambahkan |
| 3.3 | Batas jumlah berkas per transaksi + batas ukuran total per unggahan | Validasi menolak unggahan berlebih dengan pesan jelas |
| 3.4 | Jadwalkan uji restore bulanan otomatis + laporan hasil ke Direktur | Ada catatan hasil uji tiap bulan |
| 3.5 | Evaluasi kunci periode BAST (perlu keputusan perusahaan bila ingin status terkunci) | Keputusan tertulis sebelum implementasi |

---

## 9. Yang Sengaja Tidak Dikerjakan

Sesuai keputusan bisnis yang sudah final, hal berikut **tidak** masuk rencana:

- Retensi 5%, laba-rugi per SPK, pajak PPN/PPh.
- Approval Direktur berlapis dan audit log aktivitas.
- Entitas PROYEK terpisah (SPK sebagai inti).
- Menu Buku Kas & Bank sebagai menu tersendiri.
- Docker untuk produksi.
- Tabel domain ke-6.

---

## 10. Risiko & Asumsi

1. **Asumsi konfigurasi server:** audit membaca `.env` di repo lokal. Bila `.env` server berbeda, temuan D-1, S-1, S-2 perlu diperiksa ulang di server.
2. **Risiko data:** 116 berkas belum di-commit. Satu kesalahan penyuntingan sebelum commit dapat menghilangkan pekerjaan; disarankan commit lebih dulu sebelum Fase 1.
3. **Risiko antrean:** tanpa worker hidup, OCR tidak berjalan meski semua tes lulus — tes memakai antrean sinkron.
4. **Risiko penilaian UI:** penilaian tampilan berbasis ukuran DOM, bukan penilaian visual manusia. Keputusan rasa (nyaman/tidak) tetap milik pengguna.

---

## 11. Lampiran — Perintah Verifikasi

```bash
# Kesehatan umum
php artisan test                     # harapan: 513 lulus / 2160 asersi
./vendor/bin/pint --test
npm run build

# Kesiapan server
php artisan bks:cek-server
php artisan route:cache && php artisan view:cache

# Backup & pemulihan
php artisan bks:backup
ls -lh "${STORAGE_BACKUP_PATH:-storage/app}/backup"
php artisan bks:restore

# Antrean OCR
php artisan queue:work --once
php artisan queue:failed

# Pemeriksaan cepat UI (Chrome DevTools)
# 1) pastikan tiap halaman berfilter hanya punya satu input[type=date]
# 2) document.documentElement.scrollWidth - clientWidth == 0 pada 375px
```

---

## 12. Catatan Penutup

Dokumen ini adalah **rencana**, bukan bukti pekerjaan selesai. Setiap langkah pada Fase 1–3 baru dinyatakan beres setelah ada hasil perintah yang menyertainya. Temuan yang ditandai "belum diverifikasi" tidak boleh dianggap benar maupun salah sampai diukur di server/browser sebenarnya.

---

## 13. Hasil Eksekusi (12 November 2026)

Bagian ini mencatat apa yang **benar-benar dijalankan dan diukur**, bukan rencana.

### 13.1 Verifikasi terakhir

| Pemeriksaan | Hasil |
|:--|:--|
| `php artisan test` | **518 lulus / 2169 asersi** (520 sebelum BAST dihapus; 2 tes BAST ikut dibuang) |
| `./vendor/bin/pint app routes tests` | Bersih |
| `npm run build` | Sukses (474 ms) |
| Uji backup nyata | `bks:backup` → `bks-2026-11-12-123931.zip` (26,8 KB) |
| Uji integritas restore | `bks:restore <zip> --test` → "Struktur ZIP/SQL valid", "5 tabel utama terverifikasi: spk, uang_masuk, uang_keluar, mitra, pengguna" |
| Browser 1440px & 375px | Dashboard, konsistensi, kalender bertanggal, unggah nota, uang masuk, list SPK: **0 luber horizontal, 0 error konsol** |

### 13.2 Butir yang selesai

| Fase | Butir | Bukti |
|:--|:--|:--|
| 1.1 | `.env.production.example` | APP_ENV, APP_URL LAN, cookie sesi, `STORAGE_BACKUP_PATH=/data/backup-bks` |
| 1.4 | `bks:cek-server` diperluas | Blok "Optimasi & Produksi": APP_ENV, OPcache, cache config/rute/view, lokasi backup (kritis bila production tanpa path) |
| 1.5 | OCR tahan gangguan | `$tries=3`, jeda 30/120 detik, gagal sementara dilempar ulang, hasil gagal tetap dititipkan |
| 1.6 | Antrean terlihat | Kartu di Unggah Nota + banner dashboard (uji DOM: tinggi 52px, opacity 1) |
| 1.7 | Laporan konsistensi piutang | `/panel/laporan/konsistensi`, 3 jenis temuan, baca-saja |
| 2.2 | Kalender filter satu tanggal | `?tanggal=2026-11-12` → 1 input, bulan ikut berpindah |
| 2.4 | Sesi aktif + putus sesi | `/panel/users/sesi` (Direktur), 4 tes |
| 2.6 | `flatpickr` dibuang | `npm uninstall`, komponen `form/date-picker` dihapus (tidak dipakai) |
| 3.1 | Kontras terukur | Lihat tabel rasio di bawah |
| 3.4 | Verifikasi backup bulanan | `bks:backup --verifikasi`, jadwal tanggal 1 03:00 |

### 13.3 Kontras terukur (latar putih)

| Token | Rasio | Ambang | Hasil |
|:--|--:|--:|:--|
| gray-700 | 10,46 | 4,5 | Lulus |
| brand-600 | 11,18 | 4,5 | Lulus |
| gray-600 | 7,69 | 4,5 | Lulus |
| gray-500 | 4,97 | 3,0 | Lulus |
| error-600 | 4,83 | 4,5 | Lulus |
| success-700 (baru) | 5,41 | 4,5 | Lulus |
| warning-700 (baru) | 5,43 | 4,5 | Lulus |
| gray-400 (placeholder) | 2,58 | — | Dibiarkan; dikecualikan WCAG |

### 13.4 Perubahan ruang lingkup

- **BAST dihapus total** (keputusan pengguna, 12 Nov 2026): rute `panel.spk.bast`, view `reports/bast-pdf`, tombol "Cetak BAST", 2 tes BAST, dan langkah BAST di tes E2E. Dokumen ikut diberi catatan historis.
- **Status BAST terkunci (B-3)** otomatis gugur karena fiturnya tidak ada lagi.
- **Migrasi indeks (3.2)** tidak dibuat karena indeks sudah lengkap.

### 13.5 Yang masih terbuka

| Butir | Alasan |
|:--|:--|
| Penerapan `.env` produksi di server | Menunggu setup di kantor (rencana pengguna: besok) |
| Uji restore penuh (menimpa database) | Sengaja belum di laptop; `--test` sudah lulus, restore penuh dilakukan di server dengan data nyata |
| `pint --test` seluruh repo | 2 berkas `tests/Security/*` lama masih menyimpang, di luar cakupan tugas ini |


### 13.6 Pembersihan & Standardisasi Tambahan (Penyelesaian Akhir Laptop)

1. **Perbaikan Kontras Rendah WCAG:**
   - Ditemukan penggunaan `text-gray-400` telanjang pada elemen teks, label, dan subteks di 22 berkas Blade (rasio kontras sebelumnya ~2,58:1 yang kurang terbaca di mode terang).
   - Seluruh teks telah distandardisasi menjadi `text-gray-500 dark:text-gray-400` (rasio kontras mode terang meningkat menjadi 4,97:1 — lulus ambang minimum WCAG 4,5:1 untuk teks normal).
   - Atribut placeholder input (`placeholder:text-gray-400`) tetap dipertahankan sesuai konvensi UI modern.

2. **Performa Query & Penataan Indeks DB:**
   - Dibuat dan dijalankan migrasi `2026_11_12_000002_indeks_kategori_tanggal_uang_keluar`.
   - Menghilangkan `Using filesort` pada query filter pengeluaran uang keluar dan memangkas pembacaan baris tabel dari 269 menjadi 51 baris.

3. **Verifikasi Kerapian & Kode Bersih:**
   - Linter Laravel Pint lulus 100% pada seluruh berkas proyek (`./vendor/bin/pint --test`).
   - Eksekusi `php artisan test` penuh mencakup 518 pengujian dengan 2.169 asersi — seluruhnya lulus tanpa error.
   - Aset frontend Vite terkompilasi optimal (428 ms).
