# Checklist Setup Server `bks-server` — PASTIKAN SAAT DI KANTOR

> Target: Ubuntu Server (bks-server), LAN `192.168.100.10:8232`, Tailscale `100.111.175.26`, user `sysbks`.
> Semua langkah **server-side**, tidak bisa diverifikasi dari mesin dev. Bawa file ini saat akses.

## 1. Backup & Storage (KRITIS — O-K1)
- [ ] Buat direktori HDD: `sudo mkdir -p /data/backup-bks && sudo chown sysbks:sysbks /data/backup-bks`
- [ ] Set di `.env` produksi: `STORAGE_BACKUP_PATH=/data/backup-bks`
- [ ] Verifikasi: jalankan `php artisan backup:database` lalu cek file muncul di `/data/backup-bks` (BUKAN `storage/app/backup`)

## 2. Environment Produksi (O-S3)
- [ ] `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=http://192.168.100.10:8232`, `APP_TIMEZONE=Asia/Jakarta` (WIB — penting untuk validasi tanggal nota)
- [ ] `APP_KEY` valid (jangan pakai key dev); regenerasi bila ragu: `php artisan key:generate` (hapus cache sesudahnya)
- [ ] `QUEUE_CONNECTION=database` (sudah; pastikan worker hidup)

## 3. Cache Optimasi (O-T1)
- [ ] `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Verifikasi: `ls bootstrap/cache/` harus ada `config.php`, `routes-v7.php`, `packages.php` dll.
- [ ] Setelah setiap deploy, ulangi perintah di atas.

## 4. Cron & Backup Terjadwal (O-T2)
- [ ] `crontab -e` (user `sysbks`):
  ```
  0 23 * * * cd /rute/proyek && php artisan backup:database >> /dev/null 2>&1
  0 0 1 * * cd /rute/proyek && php artisan bks:verifikasi-backup >> /dev/null 2>&1
  ```
- [ ] Pastikan perintah cron ada (atau buat) sebelum dipasang.

## 5. Rotasi Log
- [ ] `.env`: `LOG_STACK=daily` (atau `LOG_CHANNEL=daily`); `LOG_DAILY_DAYS=14`
- [ ] Verifikasi: `storage/logs/laravel-YYYY-MM-DD.log` terpisah per hari.

## 6. Queue Worker (retry + hidup)
- [ ] Unit systemd `bks-queue.service`: ganti `--tries=1` → `--tries=3` (retry antrean OCR/gagal sementara)
- [ ] Pastikan worker start otomatis: `systemctl --user enable --now bks-queue` (atau setara)
- [ ] Health-check worker mati = halaman Unggah Nota berhenti di "menunggu".

## 7. Keamanan Sesi
- [ ] `.env`: `SESSION_SECURE_COOKIE=true` (wajib karena HTTP intranet; tanpa ini cookie bisa bocor di jaringan)
- [ ] Setelah set, uji login ulang (satu browser bersih).

## 8. Batas Unggah & Livewire
- [ ] Cek `upload_max_filesize`/`post_max_size` PHP CLI dan FPM ≥ 30M
- [ ] `config/livewire.php` `max_calls` → 200 (dari 1000) bila profil lalu lintas normal < 200 panggilan/aksi.

## 9. Backup & Deploy
- [ ] Sebelum deploy, backup DB dulu: `php artisan backup:database`
- [ ] Pull code + `composer install --no-dev --optimize-autoloader`, `npm ci && npm run build` (atau pakai build artifact)
- [ ] Ulangi Langkah 3 (cache) & restart queue worker.

---
**Catatan**: setelah semua item, jalankan `bks:cek-server` → harap `siap_operasional=true`.
