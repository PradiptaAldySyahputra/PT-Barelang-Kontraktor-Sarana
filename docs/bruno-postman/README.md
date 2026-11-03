# Panduan Pengujian API BKS via Postman / Bruno

Koleksi endpoint HTTP/API sistem PT Barelang Kontraktor Sarana dapat diimpor ke **Postman** atau **Bruno**.

## 1. Lokasi Berkas Koleksi
Berkas koleksi JSON standar:
```
docs/bruno-postman/bks-api-collection.json
```

## 2. Cara Impor ke Bruno / Postman
1. Buka aplikasi **Bruno** atau **Postman**.
2. Klik tombol **Import** &rarr; pilih berkas `docs/bruno-postman/bks-api-collection.json`.
3. Impor juga environment `docs/bruno-postman/bks-environment.json` (atau buat environment baru dengan variabel `baseUrl`, `spkId`, dan `uangMasukId`).
4. Pastikan `baseUrl` mengarah ke dev server Anda (misal `http://127.0.0.1:8232` atau `http://127.0.0.1:8000`).

## 3. Daftar Endpoint yang Tersedia
| No | Nama Permintaan | Metode | URL Endpoint | Keterangan |
|:---|:---|:---:|:---|:---|
| 01 | Login Admin | POST | `/panel/login` | Mendapatkan cookie session Admin |
| 02 | Login Direktur | POST | `/panel/login` | Mendapatkan cookie session Direktur |
| 03 | Riwayat Termin Drawer | GET | `/panel/spk/{spk}/termin-drawer` | JSON payload termin uang masuk SPK |
| 04 | Cetak Kuitansi PDF | GET | `/panel/cash-in/{uangMasuk}/kuitansi` | Unduhan berkas PDF resmi kuitansi |
| 04b | Cetak BAST Resmi PDF | GET | `/panel/spk/{spk}/bast-pdf` | Unduhan berkas PDF resmi Berita Acara Serah Terima |
| 05 | Bundel Laporan ZIP | GET | `/admin/laporan/bundel-zip` | Unduh 5 spreadsheet laporan sekaligus |
| 06 | Ekspor Buku Kas XLSX | GET | `/admin/laporan/ekspor/buku-kas?format=xlsx` | Unduh Excel Buku Kas ber-KOP |
| 07 | Ekspor Piutang PDF | GET | `/admin/laporan/ekspor/piutang?format=pdf` | Dokumen PDF resmi piutang SPK |
| 08 | Arsip Nota ZIP | GET | `/admin/arsip-nota/zip` | Kompresi seluruh foto nota transaksi |
| 09 | Buat Backup Database | POST | `/panel/backup/run` | Memicu pencadangan database MySQL |
| 10 | Unduh Template CSV | GET | `/panel/import/template` | Format CSV impor uang masuk/keluar |
