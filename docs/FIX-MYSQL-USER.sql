-- =========================================================
-- PERBAIKAN USER MYSQL UNTUK LARAVEL — PT Barelang Kontraktor Sarana
-- =========================================================
-- Jalankan file ini di DBeaver / HeidiSQL / terminal mysql
-- SEBAGAI ROOT (bukan sebagai bks).
--
-- Cara lewat terminal:
--   sudo mysql < docs/FIX-MYSQL-USER.sql
--
-- Cara lewat DBeaver:
--   1. Buat koneksi baru sebagai root (localhost, user: root)
--   2. Buka SQL Editor
--   3. Copy-paste seluruh isi file ini
--   4. Execute (Alt+X)
-- =========================================================

-- ---------------------------------------------------------
-- LANGKAH 0: Lihat kondisi saat ini (untuk diagnosa)
-- ---------------------------------------------------------
SELECT '=== USER bks YANG SUDAH ADA ===' AS info;
SELECT User, Host, plugin FROM mysql.user WHERE User = 'bks';

SELECT '=== DATABASE bks ===' AS info;
SHOW DATABASES LIKE 'bks';


-- ---------------------------------------------------------
-- LANGKAH 1: Pastikan database ada
-- ---------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `bks`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;


-- ---------------------------------------------------------
-- LANGKAH 2: Buat user 'bks'
--
-- GANTI 'GantiPasswordIni123!' dengan password pilihan Anda.
-- Password ini harus SAMA dengan DB_PASSWORD di file .env
--
-- Dibuat 3 varian host karena di MariaDB:
--   'bks'@'localhost'  dan  'bks'@'127.0.0.1'  adalah AKUN BERBEDA
-- .env memakai 127.0.0.1, tapi server me-resolve ke localhost.
-- ---------------------------------------------------------
CREATE USER IF NOT EXISTS 'bks'@'localhost' IDENTIFIED BY 'GantiPasswordIni123!';
CREATE USER IF NOT EXISTS 'bks'@'127.0.0.1' IDENTIFIED BY 'GantiPasswordIni123!';
CREATE USER IF NOT EXISTS 'bks'@'%'         IDENTIFIED BY 'GantiPasswordIni123!';

-- Kalau user sudah ada tapi passwordnya lupa, pakai ini (ganti password):
-- ALTER USER 'bks'@'localhost' IDENTIFIED BY 'GantiPasswordIni123!';
-- ALTER USER 'bks'@'127.0.0.1' IDENTIFIED BY 'GantiPasswordIni123!';
-- ALTER USER 'bks'@'%'         IDENTIFIED BY 'GantiPasswordIni123!';


-- ---------------------------------------------------------
-- LANGKAH 3: Beri hak akses ke database bks
-- ---------------------------------------------------------
GRANT ALL PRIVILEGES ON `bks`.* TO 'bks'@'localhost';
GRANT ALL PRIVILEGES ON `bks`.* TO 'bks'@'127.0.0.1';
GRANT ALL PRIVILEGES ON `bks`.* TO 'bks'@'%';

-- Untuk menjalankan PHPUnit, Laravel butuh database testing terpisah
CREATE DATABASE IF NOT EXISTS `bks_test`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON `bks_test`.* TO 'bks'@'localhost';
GRANT ALL PRIVILEGES ON `bks_test`.* TO 'bks'@'127.0.0.1';
GRANT ALL PRIVILEGES ON `bks_test`.* TO 'bks'@'%';

FLUSH PRIVILEGES;


-- ---------------------------------------------------------
-- LANGKAH 4: Verifikasi hasil
-- ---------------------------------------------------------
SELECT '=== HASIL: USER bks ===' AS info;
SELECT User, Host, plugin FROM mysql.user WHERE User = 'bks';

SELECT '=== HASIL: HAK AKSES ===' AS info;
SHOW GRANTS FOR 'bks'@'127.0.0.1';


-- =========================================================
-- SETELAH INI, JALANKAN DI TERMINAL:
--
--   cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
--   php artisan config:clear
--   php artisan migrate
--
-- Dan pastikan .env berisi:
--   DB_CONNECTION=mysql
--   DB_HOST=127.0.0.1
--   DB_PORT=3306
--   DB_DATABASE=bks
--   DB_USERNAME=bks
--   DB_PASSWORD=***
--
-- CATATAN: DB_PASSWORD tidak boleh kosong. Error 1698 yang Anda
-- alami muncul karena password dikosongkan, padahal user bks
-- dibuat dengan password.
-- =========================================================
