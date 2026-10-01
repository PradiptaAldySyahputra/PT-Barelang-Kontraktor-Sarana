# OCR Nota — Panduan Pemasangan

Fitur ini **membantu** admin: menghitung jumlah nota di dalam satu berkas dan
memotong pratinjaunya per nota. **Nominal rupiah tetap diisi admin** — OCR tidak
membaca angka.

---

## 1. Apa yang dilakukan OCR (dan yang TIDAK)

| Tugas | Dikerjakan OCR? |
|---|---|
| Menghitung ada berapa nota di 1 berkas | ✅ Ya |
| Memotong pratinjau per nota | ✅ Ya |
| Membaca nominal rupiah | ❌ **Tidak** — diisi admin |
| Menyimpan data | ❌ Tidak |

**Alasannya:** salah hitung jumlah nota ringan akibatnya — admin tinggal ubah
angkanya di form. Salah baca nominal rupiah bisa langsung masuk laporan
keuangan. Jadi OCR hanya menyentuh bagian yang aman.

---

## 2. Prasyarat di Server

| Kebutuhan | Keterangan |
|---|---|
| Python 3.10+ | Sudah umum ada di Linux/macOS |
| Paket Python | `rapidocr-onnxruntime`, `pymupdf`, `pillow`, `numpy` |
| Ruang disk | ± 300 MB (model OCR hanya 14 MB, sisanya dependensi) |
| RAM saat jalan | ± 500 MB |

**OCR ini jalan offline** — tidak perlu internet, tidak mengirim nota ke mana pun.

---

## 3. Langkah Pemasangan (Linux/macOS)

```bash
cd "/path/ke/project"

# 1. Buat virtualenv khusus OCR
python3 -m venv ocr-venv

# 2. Pasang dependensi
./ocr-venv/bin/pip install rapidocr-onnxruntime pymupdf pillow numpy

# 3. Uji dulu (harus keluar JSON dengan "ok": true)
./ocr-venv/bin/python python/ocr_nota.py storage/app/public/uang_keluar/nota-contoh.jpg
```

Kalau sudah keluar JSON, nyalakan di `.env`:

```env
OCR_NOTA=true
OCR_NOTA_PYTHON=/path/ke/project/ocr-venv/bin/python
```

Lalu bersihkan cache konfigurasi:

```bash
php artisan config:clear
```

---

## 4. Langkah Pemasangan (Windows — server kantor)

```powershell
cd C:\path\ke\project

# 1. Buat virtualenv
python -m venv ocr-venv

# 2. Pasang dependensi
.\ocr-venv\Scripts\pip install rapidocr-onnxruntime pymupdf pillow numpy

# 3. Uji
.\ocr-venv\Scripts\python python\ocr_nota.py storage\app\public\uang_keluar\nota-contoh.jpg
```

Di `.env` (pakai path lengkap, jangan `python3`):

```env
OCR_NOTA=true
OCR_NOTA_PYTHON=C:\path\ke\project\ocr-venv\Scripts\python.exe
```

> **Catatan Windows:** pastikan path ditulis dengan `\` atau `/` yang benar, dan
> tidak ada spasi yang tidak di-escape. Kalau ragu, tes dulu dari Command Prompt.

---

## 5. Kalau OCR Belum Siap

**Sistem tetap jalan normal.** OCR default **mati** (`OCR_NOTA=false`).

Kalau OCR mati atau gagal, yang terjadi:

- Jumlah nota tetap **4** (default) — admin bisa ubah manual.
- Pratinjau menampilkan **berkas utuh** (bukan potongan).
- Admin melihat pesan: *"OCR tidak bisa membaca berkas ini — isi jumlah nota manual."*

Jadi memasang OCR **tidak wajib**. Bisa dinyalakan kapan saja tanpa mengubah data.

---

## 6. Kalau OCR Gagal Terus

Cek berurutan:

```bash
# 1. Python bisa jalan?
OCR_PYTHON -c "print('ok')"

# 2. Paket terpasang?
OCR_PYTHON -c "import rapidocr_onnxruntime, pymupdf, PIL, numpy; print('lengkap')"

# 3. Skrip jalan manual?
OCR_PYTHON python/ocr_nota.py /path/berkas.pdf
```

Lihat juga `storage/logs/laravel.log` — kegagalan OCR dicatat dengan pesan
`OCR nota gagal`.

---

## 7. Batas Kemampuan (Jujur)

Yang **sudah diuji** pada nota proyek ini (template kosong, PDF digital):

| Kondisi | Hasil |
|---|---|
| Asli | 4 nota terdeteksi ✅ |
| Miring 3° / 8° | 4 nota ✅ |
| Buram | 4 nota ✅ |
| Resolusi rendah (⅓) | 4 nota ✅ |
| Kontras rendah | 4 nota ✅ |
| Kombinasi (miring+buram+redup) | 4 nota ✅ |
| Abu-abu + noise 2% | 4 nota ✅ |

Yang **BELUM diuji** dan perlu hati-hati:

- **Nota tulisan tangan** — jumlah nota mungkin terbaca (karena judul "NOTA NO."
  biasanya dicetak), tapi ini belum diuji pada nota asli terisi.
- **Susunan nota tidak beraturan** (bukan grid rapi) — potongan bisa kurang pas.
  Admin tetap bisa melihat berkas utuhnya lewat tautan "Buka di tab baru".
- **Nota lebih dari 1 halaman** — saat ini hanya halaman pertama yang dibaca.

---

## 8. Cara Kerja Singkat

```
Admin unggah nota
        ↓
Python (ocr_nota.py):
   - render PDF/gambar jadi piksel
   - OCR cari penanda "NOTA NO."
   - kelompokkan jadi baris & kolom
   - potong tiap nota, simpan PNG
        ↓
PHP (PembacaNota):
   - baca JSON dari Python
   - isi "jumlah_nota" di form
   - teruskan potongan ke tiap baris
        ↓
Admin: isi nominal sambil melihat potongan notanya sendiri
```

---

## 9. Mengubah Pengaturan

Semua lewat `.env`:

| Variabel | Default | Keterangan |
|---|---|---|
| `OCR_NOTA` | `false` | Nyalakan/matikan OCR |
| `OCR_NOTA_PYTHON` | `python3` | Path Python (pakai venv!) |
| `OCR_NOTA_TIMEOUT` | `60` | Batas waktu detik |

Konfigurasi ada di `config/ocr.php`.
