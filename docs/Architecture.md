# Architecture — Sistem Informasi SPK & Kontrol Keuangan
## PT Barelang Kontraktor Sarana

> **Versi:** 3.1 — **5 tabel** (sesuai `db.txt`)
> **Tanggal:** 19 September 2026
> **Menggantikan:** `docs-backup-29agu/Architecture.md` (v1.0) dan draf v2.x
> **Perubahan utama:** **deployment lokal 2 PC** · **Laravel + Blade** · **tanpa approval** · **SPK entitas inti** · **5 tabel + PHP Enum**

---

## 1. Prinsip Arsitektur

1. **Monolitik** — sederhana, mudah dirawat tim kecil (1–3 developer).
2. **Tidak menggunakan microservices**, message queue, atau container orchestration.
3. **Server-rendered** dengan Blade Template — tanpa build pipeline berlebihan.
4. **On-premise / lokal** — berjalan di jaringan kantor, bukan cloud.
5. **Satu sumber data** — database hanya di satu PC (server), mencegah data terpecah.
6. **SPK sebagai entitas inti** — tidak ada entitas PROYEK (keputusan #1).
7. **Tanpa alur approval** — Admin langsung mencatat transaksi (keputusan #2 & #4).
8. **Fleksibel pada bagian keuangan** — struktur disiapkan longgar karena contoh data final
   dari Admin/keuangan belum diterima.

> ⚠️ **Keputusan deployment belum dikunci:** pilihan **lokal / cloud / hybrid** masih menunggu
> keputusan atasan. Dokumen ini mengasumsikan **lokal** karena itulah yang dijelaskan di BAB VI
> SRS, tetapi dokumen sumber masih tidak konsisten. Lihat §11.

## 2. Tech Stack

| Layer | Teknologi | Alasan |
|---|---|---|
| Backend Framework | **Laravel 13** (full Laravel) | Matang, dokumentasi lengkap, cocok CRUD & laporan |
| Bahasa | PHP 8.3+ | Kebutuhan minimum Laravel modern |
| Database | **MySQL / MariaDB** | Relasional, stabil, gratis |
| ORM | Eloquent ORM | Relasi eksplisit, query aggregate |
| Validasi Enum | **PHP Enum + `Rule::enum()`** | ⭐ Pengganti tabel master (lihat `Schema.md` §7) |
| **Frontend / Admin Panel** | **Filament 5** (`/admin`) | ⚠️ **MENYIMPANG dari SRS** — lihat catatan di bawah |
| Tema Tampilan | **Clean Minimalist Enterprise** (Vercel/Linear) — CSS tema Filament | Monokrom, border tipis, font sistem |
| Authentication | Filament Login + Laravel Auth | Login, logout, session, password hashing |
| Authorization | `canAccessPanel()` + `canCreate/canEdit/canDelete` + trait `BolehUbahData` | Batasi akses Admin/Direktur |
| File Storage | Laravel Storage | Simpan bukti transaksi (uang masuk & keluar) |
| Grafik | Chart.js (bawaan Filament ChartWidget) | Grafik arus kas, status SPK, kategori |
| Export Laporan | **CSV** (bawaan, tanpa paket) | Bisa dibuka di Excel — aplikasi yang dipakai perusahaan |
| **Deployment** | **Lokal di PC Direktur (jaringan kantor)** | Biaya rendah, data tetap di perusahaan |
| Web Server Lokal | Apache/Nginx (via Laragon/XAMPP) | Menjalankan aplikasi di port lokal |
| Backup | `php artisan bks:backup` + Laravel Scheduler | Dump harian `.sql.gz`, retensi 30 hari |

> ⚠️ **PERUBAHAN PENTING dari v1.0 — Frontend BUKAN Blade lagi:**
>
> SRS mengunci frontend ke **Blade Template**, tetapi implementasi memakai
> **Filament 5** (panel admin di `/admin`). Alasannya:
> - 5 modul CRUD (SPK, Mitra, Uang Masuk, Uang Keluar, Pengguna) + laporan
>   dikerjakan jauh lebih cepat, dengan tabel/filter/pencarian/upload bawaan.
> - Menghemat waktu pengerjaan magang secara signifikan.
> - Model, migration, Enum, dan seluruh logika bisnis **tetap sama** —
>   Filament bekerja di atas Eloquent yang sudah ada.
>
> **Konsekuensi:** dokumen SRS menyebut Blade → **tidak sinkron**. Perubahan ini
> dicatat di `CHANGELOG.md` v3.3 beserta alasan lengkapnya.
>
> **Catatan:** halaman Blade lama (dashboard & login) sudah **dihapus** di v3.5
> dan digantikan Filament sepenuhnya.

> ✅ **Perubahan dari v1.0:** *Hosting VPS DigitalOcean/Niagahoster* **dihapus** → **deployment lokal**.

## 3. Struktur Modul Aplikasi

```
app/
├── Auth/                  # Login, logout, session, middleware role
├── Dashboard/             # Ringkasan SPK, cashflow, saldo, laba-rugi
├── Enums/                 # ⭐ PHP Enum: StatusSpk, StatusTagihan, KategoriPengeluaran, Peran
├── Mitra/                 # CRUD mitra (PLN, vendor, subkon, pelanggan)
├── Transaksi/
│   ├── Spk/               # ⭐ SPK (PLN & subkon/vendor) — entitas inti
│   ├── UangMasuk/         # Uang masuk (2 mode: dari SPK / manual)
│   └── UangKeluar/        # Uang keluar
└── Laporan/
    ├── LaporanSpk/
    ├── LaporanCashflow/
    └── LaporanLabaRugi/   # ⭐ Laba-rugi per SPK
```

> 📌 **Karena schema hanya 5 tabel** (`db.txt`), status & kategori **tidak** punya tabel master.
> Nilainya dikelola lewat **PHP Enum** di folder `app/Enums/` dan divalidasi dengan
> `Rule::enum()`. Ini wajib — lihat `Schema.md` §8 untuk bukti risikonya.

> ❌ **Modul yang TIDAK ada** (keputusan user):
> `Proyek/` — tidak ada entitas PROYEK · `PengajuanDana/` — tidak ada pengajuan dana ·
> `Approval/` — tidak ada approval Direktur · `Bukti/` — bukti jadi kolom di tabel transaksi ·
> `MasterData/` — status & kategori pakai Enum, bukan tabel master

## 4. Alur Data Tingkat Tinggi

```
[Admin Input]
     │
     ├──► Master Data ──► partner, status, kategori
     │
     ├──► SPK ──► validasi ──► simpan
     │             └──► hitung retensi 5% (jika subkon/vendor)
     │
     ├──► Uang Masuk
     │      ├── Mode 1: pilih SPK  ──► spk_id terisi
     │      └── Mode 2: manual     ──► spk_id NULL
     │      └──► upload bukti
     │
     └──► Uang Keluar
            ├── kategori pengeluaran
            ├── relasi SPK (opsional) ──► spk_id terisi / NULL
            └──► upload bukti (jumlah file bebas)
                    │
                    ▼
        [Dashboard & Laporan membaca agregat]
                    │
                    ▼
   Saldo · Piutang per SPK · Laba-rugi per SPK
```

> ⚠️ **Tidak ada langkah approval.** Transaksi langsung tercatat saat Admin menyimpan.
> Karena itu, **tidak ada** `DB::transaction` untuk alur approval.

## 5. Keamanan & Integritas Data

1. **Password** di-hash Laravel (Bcrypt/Argon2) — tidak pernah plain text, tidak pernah di-log.
2. **Authorization** memakai middleware role — **bukan** hanya menyembunyikan menu.
3. **Nominal rupiah** disimpan `DECIMAL(18,2)` — **bukan** `FLOAT`, mencegah galat presisi.
4. **Foreign key constraint** pada semua relasi.
5. **Audit log** mencatat: user, aksi, tabel, ID record, nilai lama, nilai baru, waktu.
6. **Upload bukti** divalidasi MIME type, ukuran maksimal (5–10 MB), nama file unik
   (timestamp/UUID), hanya dapat diakses user yang sudah login.
7. **Tidak ada penghapusan permanen** — gunakan soft delete dengan jejak audit.
8. **Rahasia & kredensial** hanya melalui `.env` — tidak boleh ter-commit ke Git.
9. **Batasi akses folder upload dan database** agar tidak diubah di luar aplikasi.

## 6. Kebutuhan Non-Fungsional

| Aspek | Target |
|---|---|
| Pengguna bersamaan | Skala internal kecil (perkiraan < 10 pengguna aktif) |
| Waktu respons laporan | < 3 detik untuk data 1 tahun berjalan |
| Backup | Harian/mingguan — data keuangan kritikal |
| Ketersediaan | Selama PC server menyala (jam kerja) |

> ⚠️ **Koreksi dari v1.0:** dokumen lama menulis *"~20-30 pengguna bersamaan"*.
> Untuk skenario 2 PC, angka itu tidak realistis dan sudah dikoreksi.

---

## 7. DEPLOYMENT LOKAL — Topologi 2 PC

Bagian ini **tidak ada di v1.0**. Sesuai BAB VI SRS.

### 7.1 Topologi

```
        ┌──────────────────────────────────────────────┐
        │         ROUTER / SWITCH LAN KANTOR            │
        └───────┬──────────────────────────┬────────────┘
                │                          │
                ▼                          ▼
    ┌────────────────────────┐   ┌────────────────────────┐
    │  PC DIREKTUR           │   │  PC ADMIN              │
    │  = SERVER LOKAL        │   │  = CLIENT              │
    │  + client Direktur     │   │                        │
    │                        │   │                        │
    │  • Laravel             │   │  • Browser saja        │
    │  • MySQL/MariaDB       │   │  • Akses:              │
    │  • Apache/Nginx        │   │    http://192.168.1.10 │
    │  • Dashboard Direktur  │   │                        │
    │                        │   │                        │
    │  IP statis:            │   │                        │
    │  192.168.1.10          │   │                        │
    └────────────────────────┘   └────────────────────────┘
```

### 7.2 Peran Perangkat

| Perangkat | Fungsi | Keterangan |
|---|---|---|
| **PC Direktur** | Server lokal **dan** client Direktur | Menjalankan Laravel, MySQL/MariaDB, web server; **tetap dipakai untuk pekerjaan harian Direktur** |
| **PC Admin** | Client pengguna Admin | Akses via browser memakai IP lokal PC Direktur |
| **Jaringan LAN/Wi-Fi Kantor** | Media komunikasi | Kedua PC harus di jaringan lokal yang sama |

> ✅ **Keputusan user:** PC Direktur **boleh dipakai untuk kerja lain** (tidak dedicated server).
> Karena itu, langkah mitigasi berikut **wajib** agar aplikasi tidak mengganggu pekerjaan Direktur:
>
> | Mitigasi | Alasan |
> |---|---|
> | **Auto-start service** (§7.6) | Aplikasi hidup sendiri tanpa perlu buka terminal/CMD |
> | **Batasi resource MySQL** | Set `innodb_buffer_pool_size` wajar (mis. 512MB–1GB) agar tidak menghabiskan RAM |
> | **Jadwalkan backup di luar jam kerja** | `mysqldump` berat — jalankan malam/siang istirahat |
> | **Monitoring kapasitas** | Cek RAM/disk berkala; kalau sudah berat, pertimbangkan mini server/NAS |
> | **UPS** (§7.9) | Melindungi PC kerja Direktur **dan** data keuangan sekaligus |
>
> ⚠️ **Risiko yang diterima:** karena PC ini dipakai kerja lain, aplikasi bisa melambat saat
> Direktur membuka banyak program. Ini sudah disadari dan diterima sebagai konsekuensi
> keputusan "tidak beli PC khusus server".

### 7.3 Alur Akses Sistem

1. Aplikasi Laravel dipasang pada **PC Direktur**.
2. Database MySQL/MariaDB berjalan pada PC Direktur.
3. Web server lokal (Apache/Nginx/Laragon/XAMPP) menjalankan aplikasi pada port tertentu.
4. PC Direktur membuka sistem via `http://localhost` atau alamat lokal.
5. PC Admin membuka via browser memakai IP PC Direktur, mis. `http://192.168.1.10`.
6. Admin melakukan input SPK, uang masuk, uang keluar, dan upload bukti.
7. Direktur membuka dashboard pada PC Direktur untuk memantau.
8. Seluruh data tersimpan di database lokal pada PC Direktur.

### 7.4 Rekomendasi Konfigurasi Teknis

| Komponen | Rekomendasi | Catatan |
|---|---|---|
| Web Server Lokal | Apache/Nginx via **Laragon** atau XAMPP | Laragon disarankan untuk kemudahan di Windows |
| Database | MySQL atau MariaDB | Di PC Direktur sebagai sumber data utama |
| IP PC Direktur | **Static IP lokal** | Agar PC Admin tidak perlu ganti alamat akses |
| Firewall | Allow port web server (80/8080/8000) | Agar PC Admin dapat mengakses |
| Storage Upload | Folder `storage` Laravel | Menyimpan bukti transaksi |
| Backup | Database harian/mingguan | Ke flashdisk, HDD eksternal, atau cloud manual |

> ⚠️ **Jangan gunakan `php artisan serve` untuk pemakaian harian** — hanya untuk development.
> Gunakan web server proper (Apache/Nginx).

### 7.5 Spesifikasi PC Direktur

| Komponen | Minimum | Disarankan |
|---|---|---|
| CPU | Dual-core | Quad-core |
| RAM | 4 GB | 8 GB |
| Storage | 128 GB SSD | 256 GB SSD |
| Jaringan | Ethernet (kabel) | Ethernet + IP statis |
| Listrik | — | **UPS** (sangat disarankan) |

### 7.6 Auto-start Service

- **Windows:** Laragon sudah auto-start; atau gunakan NSSM untuk web server & MariaDB
  sebagai Windows Service.
- **Linux:** daftarkan Nginx, PHP-FPM, dan MariaDB sebagai `systemd` service (`systemctl enable`).

### 7.7 Backup (WAJIB)

Data keuangan kritikal — backup tidak boleh mengandalkan disiplin manual.

**✅ SUDAH DIIMPLEMENTASI:** `php artisan bks:backup`

| Aspek | Implementasi |
|---|---|
| Perintah | `php artisan bks:backup` |
| Hasil | `storage/app/backup/bks-YYYY-MM-DD-HHMMSS.sql.gz` |
| Kompresi | `gzencode` PHP (tidak butuh binary `gzip`) |
| Retensi | Otomatis hapus backup > 30 hari (`--hari=N` untuk mengubah) |
| Jadwal | **Harian 23:00** via Laravel Scheduler (`routes/console.php`) |
| Isi | `mysqldump --single-transaction --routines --triggers` (13 tabel) |
| Sudah diuji | ✅ Dump 11 KB, **restore berhasil** (4 SPK, 2 pengguna terbaca) |

**⚠️ WAJIB dijalankan agar jadwal bekerja** (pilih salah satu):

```bash
# Linux/macOS — crontab -e
* * * * * cd /path/ke/proyek && php artisan schedule:run >> /dev/null 2>&1

# Windows — Task Scheduler
# Buat tugas harian yang menjalankan:
#   php artisan schedule:run
```

Cek jadwal terdaftar:
```bash
php artisan schedule:list
```

**⚠️ Yang MASIH perlu dilakukan manual** (belum bisa diotomatiskan):

| Strategi | Frekuensi | Simpan di |
|---|---|---|
| Salin hasil dump ke media eksternal | Harian/mingguan | Flashdisk / HDD eksternal |
| Salin ke lokasi kedua | Mingguan | Cloud (terenkripsi) |

> Backup yang tersimpan di **komputer yang sama** tidak melindungi dari
> kerusakan hardisk. **Salin keluar dari PC Direktur.**

Saran konkret:
- Rotasi **7 backup harian + 4 mingguan + 12 bulanan** (otomatis: 30 hari).
- **Uji restore** minimal sekali sebelum sistem dipakai penuh.
- Backup juga `storage/app` (folder bukti) — bagian dari audit trail.

### 7.8 Catatan Risiko Deployment Lokal

| Risiko | Mitigasi |
|---|---|
| PC Direktur mati → PC Admin tidak dapat mengakses | UPS, auto-start service, pertimbangkan mini server/NAS jika pemakaian meningkat |
| IP PC Direktur berubah → alamat akses harus diperbarui | **Static IP** atau reservasi DHCP di router |
| Tanpa backup rutin → data berisiko hilang | Backup otomatis + uji restore berkala |
| PC Direktur tetap dipakai kerja harian → performa dapat mengganggu aktivitas Direktur | Monitoring kapasitas, batasi aplikasi berat |
| Folder upload & database bisa diubah di luar aplikasi | Batasi permission folder, akun OS khusus service |

### 7.9 Antisipasi Mati Listrik

- **UPS** untuk PC Direktur dan router — minimal tahan 15 menit agar shutdown rapi.
- Aktifkan auto-shutdown saat daya UPS lemah.
- Hindari menyalakan PC server tanpa UPS.

### 7.10 Akses dari Luar Kantor (Fase 2 — Opsional)

| Cara | Kelebihan | Kekurangan |
|---|---|---|
| **Tailscale** (VPN mesh) | Aman, tidak perlu buka port, gratis skala kecil | Perlu install di tiap perangkat |
| **Cloudflare Tunnel** | Tidak perlu IP publik | Tergantung pihak ketiga |
| Port forwarding router | Tanpa software tambahan | ⚠️ **Berisiko** — tidak disarankan |

**Rekomendasi:** Tailscale. **Jangan** buka aplikasi langsung ke internet.

---

## 8. Diagram Konseptual

```mermaid
flowchart LR
    A[Admin - PC Admin] -->|browser, IP lokal| S[PC Direktur - Server Lokal]
    D[Direktur - PC Direktur] --> S
    S --> L[Laravel + Blade]
    L --> DB[(MySQL / MariaDB)]
    L --> ST[Storage - Bukti Upload]
    L --> CH[Chart.js / ApexCharts]
    L --> EX[Export PDF / Excel]
```

## 9. Persyaratan Serah Terima

| No | Luaran | Format |
|---|---|---|
| 1 | Source Code GitHub | Repository (Laravel, Blade, controller, model, migration, middleware) |
| 2 | Database Migration | Laravel Migration |
| 3 | Database Production | MySQL / MariaDB |
| 4 | Hak Akses Akun Server | Credential tertutup |
| 5 | Akun Admin Sistem | Credential tertutup |
| 6 | Akun Direktur Sistem | Credential tertutup |
| 7 | Buku Panduan Admin | PDF / DOCX |
| 8 | Buku Panduan Direktur | PDF / DOCX |
| 9 | Dokumen SRS | PDF / Markdown |
| 10 | Dokumen ERD | PNG / PDF / Markdown |
| 11 | Dokumen Flowchart | PNG / PDF / Link |
| 12 | Dokumen Test Case | Excel / PDF / Markdown |
| 13 | Bug Report | Excel / PDF |
| 14 | Berita Acara Serah Terima | PDF / DOCX |

## 10. Checklist Final Deployment

- [ ] Repository GitHub sudah final
- [ ] File `.env` lokal dikonfigurasi untuk jaringan kantor
- [ ] Database lokal sudah dibuat di PC Direktur
- [ ] Migration berhasil dijalankan
- [ ] Storage link & permission folder upload benar
- [ ] Akun Admin dan Direktur sudah dibuat
- [ ] Role middleware sudah diuji
- [ ] Form SPK berjalan
- [ ] Retensi 5% dihitung dengan benar
- [ ] Form uang masuk (2 mode) berjalan
- [ ] Form uang keluar berjalan
- [ ] Upload bukti berjalan
- [ ] Perhitungan saldo, piutang, laba-rugi akurat
- [ ] Dashboard menampilkan data yang benar
- [ ] Black-box testing selesai
- [ ] Bug prioritas tinggi sudah diperbaiki
- [ ] Manual book Admin dan Direktur tersedia
- [ ] Sistem terpasang di PC Direktur sebagai server lokal
- [ ] PC Admin berhasil mengakses via jaringan lokal
- [ ] Backup database lokal sudah disiapkan
- [ ] Berita acara serah terima disiapkan

## 11. ⚠️ Inkonsistensi yang Belum Terselesaikan

| No | Inkonsistensi | Status |
|---|---|---|
| 1 | **Deployment:** sebagian dokumen menyebut *cloud production*, BAB VI menetapkan *PC Direktur sebagai server lokal* | ⏳ Menunggu keputusan atasan |
| 2 | **ERD bergambar pada SRS** masih memuat `projects`, `subcon_spks`, `cash_requests`, `attachments` | ⚠️ Gambar perlu diperbarui agar sesuai schema final (**5 tabel**) |
| 3 | **Kolom `keterangan` pada SPK** — `db.txt` hapus, SRS wajibkan | ⏳ Menunggu keputusan |
| 4 | **Dokumen SPK** tidak punya tempat penyimpanan setelah tabel bukti dihapus | ⏳ Menunggu keputusan |

> ✅ **Sudah diselesaikan** (keputusan user 19 Sep 2026): entitas PROYEK dihapus · pengajuan dana
> & approval dihapus · SPK subkon dilebur ke tabel `spk` · approval uang keluar dihapus ·
> tabel bukti dihapus (bukti jadi kolom).

---

*Architecture v2.1 — keputusan user 19 September 2026 sudah diterapkan.
Dokumen v1.0 tersimpan di `docs-backup-29agu/Architecture.md`.*
