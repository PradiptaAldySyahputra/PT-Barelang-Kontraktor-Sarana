#!/usr/bin/env bash
# ==============================================================================
# Skrip Otomasi Deployment Dedicated Server LAN PT Barelang Kontraktor Sarana
# File: scripts/pasang-server-kantor.sh
# ==============================================================================

set -euo pipefail

# 1. Deteksi direktori proyek & direktori eksekusi
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
cd "${PROJECT_DIR}"

echo "=============================================================================="
echo "   PEMASANGAN & DEPLOYMENT SERVER LAN PT BARELANG KONTRAKTOR SARANA           "
echo "=============================================================================="
echo "Direktori Proyek: ${PROJECT_DIR}"

# 2. Deteksi IP address lokal server
IP_LAN=$(hostname -I 2>/dev/null | awk '{print $1}' || echo "127.0.0.1")
if [ -z "${IP_LAN}" ]; then
    IP_LAN="127.0.0.1"
fi
echo "IP LAN Terdeteksi: ${IP_LAN}"
echo "------------------------------------------------------------------------------"

# 3. Periksa ketersediaan dependensi sistem utama
echo "[1/6] Memeriksa dependensi sistem (php, composer, mysql/mariadb)..."

for cmd in php composer; do
    if ! command -v "$cmd" &> /dev/null; then
        echo "ERROR: Perintah '$cmd' tidak ditemukan. Harap pasang $cmd terlebih dahulu." >&2
        exit 1
    fi
done

if ! command -v mysql &> /dev/null && ! command -v mariadb &> /dev/null; then
    echo "PERINGATAN: Klien mysql/mariadb tidak ditemukan di PATH. Pastikan layanan database server aktif." >&2
fi
echo "Dependensi sistem dasar terpenuhi."

# 4. Setup environment aplikasi
echo "[2/6] Menyiapkan environment & direktori penyimpanan aplikasi..."

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        echo "Berkas .env belum ada. Menyalin dari .env.example..."
        cp .env.example .env
        php artisan key:generate --force
    else
        echo "PERINGATAN: Berkas .env dan .env.example tidak ditemukan." >&2
    fi
fi

# Pastikan folder storage dan cache ada
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache

# Izin folder writable
echo "Mengatur izin direktori writable (storage & bootstrap/cache)..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# Storage link
echo "Menghubungkan public storage (storage:link)..."
php artisan storage:link || true

# Migrasi database
MIGRATE_FLAG="${MIGRATE:-1}"
if [ "${MIGRATE_FLAG}" = "1" ]; then
    echo "Menjalankan migrasi database (php artisan migrate --force)..."
    php artisan migrate --force || {
        echo "PERINGATAN: Gagal menjalankan migrasi database otomatis. Periksa konfigurasi DB di .env." >&2
    }
fi

# 5. Konfigurasi Layanan Systemd Pengguna (systemd user units)
echo "[3/6] Mengonfigurasi layanan systemd user (bks-web & bks-queue)..."
SYSTEMD_USER_DIR="${HOME}/.config/systemd/user"
mkdir -p "${SYSTEMD_USER_DIR}"

PHP_BIN="$(command -v php)"

# Unit 1: bks-web.service
cat <<EOF > "${SYSTEMD_USER_DIR}/bks-web.service"
[Unit]
Description=BKS Web Server Lokal (Artisan Serve)
After=network.target

[Service]
Type=simple
WorkingDirectory=${PROJECT_DIR}
ExecStart=${PHP_BIN} artisan serve --host=0.0.0.0 --port=8232
Restart=always
RestartSec=3

[Install]
WantedBy=default.target
EOF

# Unit 2: bks-queue.service
cat <<EOF > "${SYSTEMD_USER_DIR}/bks-queue.service"
[Unit]
Description=BKS Queue Worker Background (OCR & Jobs)
After=network.target

[Service]
Type=simple
WorkingDirectory=${PROJECT_DIR}
ExecStart=${PHP_BIN} artisan queue:work --sleep=3 --tries=3 --max-time=3600
Restart=always
RestartSec=3

[Install]
WantedBy=default.target
EOF

# Muat ulang daemon systemd user dan aktifkan unit jika systemctl tersedia
if command -v systemctl &> /dev/null; then
    echo "Memuat ulang daemon systemd user..."
    systemctl --user daemon-reload || true
    echo "Mengaktifkan dan menjalankan layanan bks-web dan bks-queue..."
    systemctl --user enable --now bks-web bks-queue || {
        echo "Catatan: Gagal menyalakan systemd user otomatis (mungkin session non-interaktif atau tanpa D-Bus)."
    }
fi

# 6. Konfigurasi Crontab Scheduler
echo "[4/6] Mengonfigurasi crontab scheduler pengguna..."
CRON_ENTRY="* * * * * cd \"${PROJECT_DIR}\" && ${PHP_BIN} artisan schedule:run >> /dev/null 2>&1"

EXISTING_CRON=$(crontab -l 2>/dev/null || true)
if echo "${EXISTING_CRON}" | grep -Fq "artisan schedule:run"; then
    echo "Entri crontab scheduler sudah ada."
else
    echo "Menambahkan entri schedule:run ke crontab..."
    (
        echo "${EXISTING_CRON}"
        echo "${CRON_ENTRY}"
    ) | sed '/^$/N;/^\n$/D' | crontab - || {
        echo "PERINGATAN: Gagal memperbarui crontab otomatis. Tambahkan manual: ${CRON_ENTRY}" >&2
    }
fi

# 7. Diagnosa Kesiapan Server
echo "[5/6] Menjalankan diagnosa kesiapan server..."
php artisan bks:cek-server || true

# 8. Banner Ringkasan Akses
echo "[6/6] Selesai!"
cat <<BANNER

==============================================================================
   INSTALASI & KONFIGURASI SERVER LAN BKS SELESAI
==============================================================================
Aplikasi Sistem Informasi SPK & Kontrol Keuangan siap digunakan:

1. Akses Lokal (dari PC Server langsung):
   -> http://localhost:8232/panel
   -> http://127.0.0.1:8232/panel

2. Akses Jaringan Kantor (dari PC lain di LAN / Wi-Fi kantor):
   -> http://${IP_LAN}:8232/panel

Layanan Latar Belakang:
- Web Server   : systemctl --user status bks-web
- Queue OCR    : systemctl --user status bks-queue
- Cek Log OCR  : journalctl --user -u bks-queue -f
- Crontab      : crontab -l (artisan schedule:run tiap menit)

* Pastikan port 8232 tidak diblokir oleh firewall (UFW/iptables/Windows Defender).
* Agar layanan systemd user tetap aktif setelah logout, jalankan:
  loginctl enable-linger \${USER}
==============================================================================
BANNER
