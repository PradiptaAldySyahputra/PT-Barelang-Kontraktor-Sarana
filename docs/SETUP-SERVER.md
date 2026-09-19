# Panduan Setup Server Lokal (1 PC Server + Akses dari PC Lain)

> Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana
>
> **Tujuan:** 1 PC dijadikan **server**, PC/HP lain mengakses lewat **jaringan
> kantor yang sama** (LAN/WiFi). Tetap lokal — data tidak keluar dari perusahaan.

---

## 1. Ringkasan Cara Kerja

```
   ┌─────────────────────────┐
   │  PC SERVER (Direktur)   │
   │                         │
   │  - Database MySQL       │  <-- data disimpan di sini
   │  - Aplikasi Laravel     │
   │  - IP tetap: 192.168.x.x│
   └───────────┬─────────────┘
               │  jaringan kantor (LAN / WiFi)
      ┌────────┼────────┐
      │        │        │
   ┌──▼──┐  ┌──▼──┐  ┌──▼──┐
   │PC   │  │PC   │  │ HP  │
   │Admin│  │lain │  │     │
   └─────┘  └─────┘  └─────┘
   buka browser -> http://192.168.x.x
```

**Penting:** hanya PC Server yang menjalankan aplikasi & database. PC lain
**tidak perlu instal apa pun** — cukup buka browser.

---

## 2. Siapkan PC Server (sekali saja)

### 2.1 Cek IP jaringan

```bash
ip -4 addr show | grep inet
```

Catat IP yang berawalan `192.168.` (mis. `192.168.100.134`). Ini **IP server**.

### 2.2 Set IP tetap (STATIC) — WAJIB

Kalau IP berubah, semua PC lain kehilangan akses. Pilih salah satu:

**Cara A — set di PC (paling mudah, tanpa ubah router):**
Sesuaikan NetworkManager (KDE/GNOME: Pengaturan → Jaringan → IPv4 → Manual):

| Kolom | Isi |
|---|---|
| Address | `192.168.100.134` |
| Netmask | `255.255.255.0` |
| Gateway | `192.168.100.1` (IP router) |
| DNS | `192.168.100.1`, `8.8.8.8` |

**Cara B — reservasi DHCP di router:**
Masuk admin router → DHCP → Reservation → kunci MAC address PC server ke IP
yang diinginkan.

### 2.3 Atur `.env` untuk server

```env
APP_ENV=production
APP_DEBUG=false                      # WAJIB false — jangan tampilkan error ke user
APP_URL=http://192.168.100.134       # ganti dengan IP server

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bks
DB_USERNAME=root
DB_PASSWORD=...

FILESYSTEM_DISK=public               # agar nota/bukti bisa dibuka
SESSION_DRIVER=database
```

> ⚠️ **`APP_DEBUG=false` wajib.** Kalau `true`, pesan error menampilkan
> isi database, password, dan struktur tabel ke siapa pun yang membuka.

Setelah ubah `.env`:

```bash
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2.4 Buat link penyimpanan (kalau belum)

```bash
php artisan storage:link
```

---

## 3. Pilihan Cara Menjalankan

### Opsi A — `php artisan serve` (paling cepat, untuk uji coba)

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Akses dari PC lain: `http://192.168.100.134:8000`

| Kelebihan | Kekurangan |
|---|---|
| Tidak perlu instal apa pun | Hanya untuk **satu** pengguna sekaligus |
| Langsung jalan | Mati kalau terminal ditutup |
| | Kurang cocok untuk dipakai kerja sehari-hari |

> ⚠️ `artisan serve` **tidak cocok untuk pemakaian bersama**. Beberapa orang
> mengakses bersamaan bisa saling menghambat. Pakai Opsi B untuk produksi.

### Opsi B — Nginx + PHP-FPM (untuk pemakaian sehari-hari) ⭐

CachyOS/Arch:

```bash
sudo pacman -S nginx
```

Buat `/etc/nginx/sites-available/bks.conf`:

```nginx
server {
    listen 80;
    server_name 192.168.100.134;

    root /home/pradipta/Project/PT\ Barelang\ Kontraktor\ Sarana/public;
    index index.php;

    # Batas ukuran upload nota (PDF)
    client_max_body_size 50M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php-fpm/php-fpm.sock;
        fastcgi_index index.php;
        include fastcgi.conf;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # Jangan pernah sajikan file tersembunyi
    location ~ /\. {
        deny all;
    }
}
```

Aktifkan & jalankan:

```bash
sudo ln -s /etc/nginx/sites-available/bks.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl enable --now nginx php-fpm
```

Akses dari PC lain: `http://192.168.100.134` (tanpa nomor port)

---

## 4. Izinkan Lewat Firewall

Firewall di lingkungan ini **aktif**, jadi port harus dibuka:

```bash
# Opsi A (artisan serve)
sudo ufw allow 8000/tcp

# Opsi B (nginx)
sudo ufw allow 80/tcp

# Izinkan hanya dari jaringan kantor (lebih aman)
sudo ufw allow from 192.168.100.0/24 to any port 80 proto tcp
```

Cek: `sudo ufw status`

---

## 5. Backup Otomatis (WAJIB)

Backup manual sekali saja tidak cukup. Daftarkan jadwal:

```bash
crontab -e
```

Tambahkan:

```
# Jalankan tugas terjadwal Laravel setiap menit
* * * * * cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana" && php artisan schedule:run >> /dev/null 2>&1
```

Backup akan otomatis dibuat **setiap hari pukul 23:00** ke
`storage/app/backup/`, menyimpan 30 hari terakhir.

Cek jadwal: `php artisan schedule:list`
Uji manual: `php artisan bks:backup`

> ⚠️ **Salin backup ke media lain** (flashdisk / HDD eksternal) minimal
> seminggu sekali. Backup di komputer yang sama **tidak** melindungi dari
> kerusakan hardisk.

---

## 6. Jalankan Otomatis Saat PC Dinyalakan

### Nginx (kalau pakai Opsi B)

```bash
sudo systemctl enable nginx php-fpm
```

### MySQL

```bash
sudo systemctl enable mysqld     # atau mariadb
```

### Artisan serve (kalau pakai Opsi A)

Buat service systemd `/etc/systemd/system/bks.service`:

```ini
[Unit]
Description=Sistem SPK Barelang
After=network.target mysqld.service

[Service]
Type=simple
User=pradipta
WorkingDirectory=/home/pradipta/Project/PT Barelang Kontraktor Sarana
ExecStart=/usr/bin/php artisan serve --host=0.0.0.0 --port=8000
Restart=always

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl daemon-reload
sudo systemctl enable --now bks
```

---

## 7. Dari PC Lain (Client)

**Tidak perlu instal apa pun.** Cukup:

1. Pastikan terhubung **WiFi/LAN yang sama** dengan PC server
2. Buka browser (Chrome/Edge/Firefox)
3. Ketik: `http://192.168.100.134` (atau `:8000` kalau pakai Opsi A)
4. Login dengan akun yang diberikan Admin

**Agar mudah diingat**, buat bookmark atau simpan sebagai ikon di desktop.

---

## 8. Keamanan Internal

| Aspek | Kondisi |
|---|---|
| Akses data | Hanya dari jaringan kantor (tidak dari internet) |
| Login | Wajib — semua halaman dialihkan ke `/admin/login` |
| Brute force | Dibatasi Filament (5 percobaan) |
| Peran | Admin (input) & Direktur (hanya lihat) |
| File bukti | Disimpan di `storage/`, diakses lewat symlink `public/storage` |
| Backup | Harian otomatis, 30 hari terakhir |

### Yang tetap perlu diperhatikan

1. **Jangan pernah** meneruskan port 80/8000 dari router ke internet —
   cukup jaringan internal.
2. **Ganti password default** `admin@bks.test` / `password` sebelum dipakai kerja.
3. **`APP_DEBUG=false`** di PC server.
4. **Nonaktifkan akun** yang sudah tidak dipakai (Master Data → Pengguna).
5. **Catat IP server** di suatu tempat — kalau lupa, tidak ada yang bisa akses.

---

## 9. Daftar Periksa Sebelum Dipakai Kerja

- [ ] IP server sudah **STATIC** (tidak berubah setelah restart)
- [ ] `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL` = IP server
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Firewall mengizinkan port (80 atau 8000)
- [ ] `php artisan schedule:list` menampilkan backup harian 23:00
- [ ] Cron `schedule:run` sudah terdaftar
- [ ] Password default sudah diganti
- [ ] Uji akses dari minimal **1 PC lain** (bukan hanya server)
- [ ] Backup pertama sudah dibuat & **disalin ke media eksternal**
- [ ] UPS tersambung ke PC server (mencegah data rusak saat listrik mati)

---

## 10. Kalau Ada Masalah

| Gejala | Kemungkinan penyebab | Solusi |
|---|---|---|
| PC lain tidak bisa buka | IP salah / beda jaringan | Cek `ip addr` di server, pastikan satu WiFi |
| Halaman putih / error 500 | `APP_DEBUG=false` menyembunyikan detail | Cek `storage/logs/laravel.log` |
| Nota/bukti tidak bisa dibuka | Symlink belum dibuat | `php artisan storage:link` |
| Perubahan tidak muncul | Cache konfigurasi lama | `php artisan config:clear && php artisan config:cache` |
| Backup tidak jalan | Cron belum didaftarkan | `crontab -e`, cek `schedule:list` |
| Login gagal terus | Akun nonaktif / lupa password | Minta Admin lain reset di Master Data → Pengguna |
| IP berubah setelah restart | Belum static | Set static (bagian 2.2) |
