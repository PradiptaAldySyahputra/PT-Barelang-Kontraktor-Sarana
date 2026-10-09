#!/usr/bin/env python3
"""
Pembaca nota — deteksi JUMLAH NOTA dan POSISINYA dalam satu berkas.

KENAPA SKRIP INI ADA
--------------------
Satu berkas (PDF/gambar) bisa berisi BEBERAPA nota. Contoh nyata di proyek
PT Barelang Kontraktor Sarana: 1 halaman A4 berisi 4 form "NOTA NO." sekaligus.

Sebelumnya admin harus menghitung manual dan mengetik jumlahnya. Skrip ini
menghitungnya otomatis, dan sekaligus memberi tahu POSISI tiap nota sehingga
pratinjau bisa dipotong per nota (bukan menampilkan gambar penuh berulang).

PEMBAGIAN TANGGUNG JAWAB (penting)
----------------------------------
Skrip ini HANYA mendeteksi jumlah & posisi nota. Skrip ini TIDAK membaca
nominal rupiah, dan TIDAK menyimpan apa pun. Angka rupiah tetap diisi admin.

Alasannya: salah hitung jumlah nota = admin tinggal ubah angka di form.
Sedangkan salah baca nominal rupiah bisa langsung masuk laporan keuangan.

CARA PAKAI
----------
    python3 ocr_nota.py /path/ke/nota.pdf

Keluaran: JSON ke stdout.

    {
      "ok": true,
      "jumlah_nota": 4,
      "lebar": 1241,
      "tinggi": 1754,
      "metode": "ocr",
      "nota": [
        {"ke": 1, "kotak": [43, 151, 663, 1029], "potongan": "/tmp/.../nota_1.png"},
        ...
      ]
    }

Kalau gagal (berkas rusak, tidak ada teks, dsb):
    {"ok": false, "alasan": "..."}

Skrip ini SENGAJA tidak pernah melempar exception ke luar — selalu keluarkan
JSON, supaya sisi PHP tidak perlu menebak-nebak bentuk keluarannya.
"""

import json
import os
import sys
import tempfile
from typing import Any


def keluaran(data: dict[str, Any]) -> None:
    """Cetak JSON lalu keluar. Dipakai untuk SEMUA jalur keluar."""
    print(json.dumps(data, ensure_ascii=False))
    sys.exit(0)


def gagal(alasan: str) -> None:
    keluaran({"ok": False, "alasan": alasan})


def render_semua_halaman(path: str) -> list[Any]:
    """
    Render SEMUA halaman PDF menjadi gambar.

    ⚠️ PENTING — jangan hanya ambil halaman pertama.

    Admin proyek ini MENGGABUNG nota selama sebulan jadi satu PDF. Contoh
    nyata: "(12) nota simada bulan ags 26.pdf" = 15 halaman × 4 nota = 57 nota.
    Kalau hanya halaman 1 yang dibaca, jumlah nota yang dilaporkan salah
    (dilaporkan 4, padahal 57) — dan itu menyesatkan admin.

    Return: daftar (gambar, nomor_halaman). Nomor halaman mulai dari 1.
    """
    import pymupdf  # type: ignore
    import numpy as np

    dokumen = pymupdf.open(path)

    if dokumen.page_count < 1:
        raise ValueError("PDF tidak punya halaman")

    # 200 DPI: cukup tajam untuk OCR, tapi tidak berat.
    zoom = 200 / 72
    matriks = pymupdf.Matrix(zoom, zoom)

    halaman_gambar = []

    for nomor in range(dokumen.page_count):
        halaman = dokumen.load_page(nomor)
        piksel = halaman.get_pixmap(matrix=matriks)

        gambar = np.frombuffer(piksel.samples, dtype=np.uint8)
        gambar = gambar.reshape(piksel.height, piksel.width, piksel.n)
        gambar = gambar[:, :, :3]  # buang alpha kalau ada

        halaman_gambar.append((gambar, nomor + 1))

    dokumen.close()

    return halaman_gambar


def render_pdf(path: str) -> tuple[Any, float]:
    """Render halaman PERTAMA PDF. Dipertahankan untuk kompatibilitas."""
    gambar, _ = render_semua_halaman(path)[0]

    return gambar, 200 / 72


def muat_gambar(path: str) -> tuple[Any, float]:
    """Muat gambar (JPG/PNG/WEBP) jadi numpy array."""
    from PIL import Image
    import numpy as np

    gambar = Image.open(path).convert("RGB")

    # Batasi sisi terpanjang ke 2400px: mempercepat OCR tanpa mengorbankan
    # keterbacaan teks ukuran nota.
    maks = 2400
    if max(gambar.size) > maks:
        rasio = maks / max(gambar.size)
        gambar = gambar.resize((int(gambar.width * rasio), int(gambar.height * rasio)))

    return np.array(gambar), 1.0


def cari_anchor(hasil_ocr: list[Any]) -> list[tuple[float, float, float, float]]:
    """
    Cari blok teks yang menandai AWAL sebuah nota.

    Nota kuitansi proyek ini punya teks "NOTA NO." di tiap form. Kita cari
    kata "NOTA" (tanpa harus persis "NOTA NO.") supaya tahan terhadap salah
    baca OCR.

    Mengembalikan daftar kotak (x1, y1, x2, y2) — koordinat kiri-atas &
    kanan-bawah tiap anchor.
    """
    anchor = []

    for item in hasil_ocr:
        kotak, teks = item[0], str(item[1])
        bersih = teks.upper().replace(" ", "")

        # "NOTA NO." bisa terbaca "NOTANO.", "NOTA NO", dsb.
        if "NOTA" not in bersih:
            continue

        # Buang baris yang bukan judul nota, mis. "Jumlah Rp." atau
        # "Tanda Terima". Judul nota bentuknya pendek.
        if len(bersih) > 12:
            continue

        xs = [p[0] for p in kotak]
        ys = [p[1] for p in kotak]

        anchor.append((min(xs), min(ys), max(xs), max(ys)))

    return anchor


def kelompuk_baris(anchor: list[tuple[float, float, float, float]], toleransi: float) -> list[list[tuple[float, float, float, float]]]:
    """
    Susun anchor jadi baris-baris (grid).

    Nota di satu lembar biasanya tersusun rapi: 2 kolom x 2 baris. Fungsi ini
    mengelompokkan anchor yang tinggi (y) nya berdekatan jadi satu baris,
    lalu mengurutkan tiap baris dari kiri ke kanan.
    """
    if not anchor:
        return []

    urut = sorted(anchor, key=lambda k: k[1])
    baris: list[list[tuple[float, float, float, float]]] = []

    for kotak in urut:
        if baris and abs(kotak[1] - baris[-1][0][1]) <= toleransi:
            baris[-1].append(kotak)
        else:
            baris.append([kotak])

    for isi in baris:
        isi.sort(key=lambda k: k[0])

    return baris


def hitung_potongan(
    baris: list[list[tuple[float, float, float, float]]],
    lebar: int,
    tinggi: int,
) -> list[tuple[float, float, float, float]]:
    """
    Tentukan kotak potong untuk TIAP nota.

    Cara: bagi halaman jadi grid sesuai susunan anchor. Tiap sel grid jadi
    satu potongan. Ini bekerja untuk 2 nota (1x2), 3 nota, 4 nota (2x2),
    bahkan 8 nota — tanpa mengasumsikan jumlahnya.

    Kalau susunannya tidak beraturan, potongan tetap dibuat tapi mungkin
    kurang pas — admin tetap bisa melihat berkas utuhnya.
    """
    if not baris:
        return []

    jumlah_baris = len(baris)
    tinggi_sel = tinggi / jumlah_baris

    potongan = []

    for i, isi in enumerate(baris):
        jumlah_kolom = len(isi)
        lebar_sel = lebar / jumlah_kolom

        for j, (ax1, ay1, _ax2, _ay2) in enumerate(isi):
            # Mulai dari anchor (judul nota), tapi jangan sampai keluar batas.
            y1 = max(0.0, min(ay1 - 10, i * tinggi_sel))
            y2 = min(float(tinggi), (i + 1) * tinggi_sel)

            # Kalau anchor ada di kolom yang jelas, pakai batas kolom.
            # Kalau tidak, pakai lebar sel.
            kolom = j
            if ax1 > (j + 0.5) * lebar_sel and j + 1 < jumlah_kolom:
                kolom = j + 1

            x1 = max(0.0, kolom * lebar_sel)
            x2 = min(float(lebar), (kolom + 1) * lebar_sel)

            # Sedikit ruang atas supaya judul nota tidak terpotong.
            y1 = max(0.0, y1)

            potongan.append((x1, y1, x2, y2))

    return potongan


def teks_per_kotak(
    hasil_ocr: list[Any],
    kotak: list[tuple[float, float, float, float]],
) -> list[list[dict[str, Any]]]:
    """
    Kelompokkan teks OCR ke dalam tiap kotak nota.

    KENAPA DI SINI (bukan di PHP)
    -----------------------------
    Skrip ini sudah memegang koordinat tiap kotak. Mengelompokkan teks ke
    kotak paling akurat dilakukan di sini (sekali jalan), lalu PHP hanya perlu
    mengurai teks yang sudah terpisah rapi per nota — tanpa tahu soal piksel.

    Tiap teks diletakkan ke kotak yang memuat TITIK TENGAHNYA. Kalau tidak ada
    (mis. teks di tepi), dipakai kotak terdekat supaya tidak ada teks hilang.

    Return: untuk tiap kotak, daftar {"teks": str, "x": float, "y": float}
    yang sudah diurutkan atas->bawah lalu kiri->kanan (urutan baca manusia).
    """
    sel: list[list[dict[str, Any]]] = [[] for _ in kotak]

    if not kotak:
        return sel

    for item in hasil_ocr:
        box, teks = item[0], str(item[1])

        if not teks.strip():
            continue

        xs = [p[0] for p in box]
        ys = [p[1] for p in box]
        cx = (min(xs) + max(xs)) / 2
        cy = (min(ys) + max(ys)) / 2

        idx = None

        for i, (x1, y1, x2, y2) in enumerate(kotak):
            if x1 <= cx < x2 and y1 <= cy < y2:
                idx = i
                break

        if idx is None:
            idx = min(
                range(len(kotak)),
                key=lambda i: abs((kotak[i][0] + kotak[i][2]) / 2 - cx)
                + abs((kotak[i][1] + kotak[i][3]) / 2 - cy),
            )

        sel[idx].append({"teks": teks, "x": float(min(xs)), "y": float(min(ys))})

    for isi in sel:
        isi.sort(key=lambda b: (b["y"], b["x"]))

    return sel


def simpan_potongan(
    gambar: Any,
    kotak: list[tuple[float, float, float, float]],
    dir_keluar: str,
    mulai_dari: int = 0,
) -> list[str | None]:
    """
    Potong gambar sesuai kotak, simpan sebagai PNG. Kembalikan daftar path.

    `mulai_dari` dipakai saat memproses PDF multi-halaman: nomor berkas
    dilanjutkan dari halaman sebelumnya supaya tidak ada nama yang bentrok
    (nota_1.png dari halaman 1 tidak tertimpa nota_1.png dari halaman 2).
    """
    from PIL import Image

    hasil: list[str | None] = []
    asli = Image.fromarray(gambar)

    for i, (x1, y1, x2, y2) in enumerate(kotak, start=mulai_dari + 1):
        try:
            kiri, atas = int(max(0, x1)), int(max(0, y1))
            kanan, bawah = int(min(asli.width, x2)), int(min(asli.height, y2))

            if kanan - kiri < 20 or bawah - atas < 20:
                hasil.append(None)
                continue

            bagian = asli.crop((kiri, atas, kanan, bawah))

            # Perbesar 1.5x supaya teks tulisan tangan lebih mudah dibaca
            # saat ditampilkan di form.
            bagian = bagian.resize((int(bagian.width * 1.5), int(bagian.height * 1.5)))

            path = os.path.join(dir_keluar, f"nota_{i}.png")
            bagian.save(path, "PNG", optimize=True)
            hasil.append(path)
        except Exception:
            hasil.append(None)

    return hasil


def main() -> None:
    if len(sys.argv) < 2:
        gagal("Tidak ada berkas yang diberikan")

    path = sys.argv[1]

    # Argumen kedua (opsional): folder untuk menyimpan potongan.
    # PHP mengirim folder di dalam storage supaya potongan bisa ditampilkan
    # di form. Kalau tidak dikirim, pakai folder sementara.
    dir_keluar = sys.argv[2] if len(sys.argv) > 2 else tempfile.mkdtemp(prefix="nota_")

    if not os.path.isfile(path):
        gagal(f"Berkas tidak ditemukan: {path}")

    try:
        os.makedirs(dir_keluar, exist_ok=True)
    except Exception as e:  # noqa: BLE001
        gagal(f"Tidak bisa membuat folder potongan: {e}")

    try:
        from rapidocr_onnxruntime import RapidOCR
    except ImportError:
        gagal("Library OCR belum terpasang (rapidocr-onnxruntime)")

    try:
        ekstensi = os.path.splitext(path)[1].lower()

        if ekstensi == ".pdf":
            daftar_halaman = render_semua_halaman(path)
        else:
            gambar, _ = muat_gambar(path)
            daftar_halaman = [(gambar, 1)]

        ocr = RapidOCR()

        # Semua nota dari SEMUA halaman dikumpulkan di sini.
        semua_nota: list[dict[str, Any]] = []
        metode = "ocr"
        ada_teks = False
        ada_penanda = False
        nomor_potongan = 0
        lebar = tinggi = 0

        for gambar, nomor_halaman in daftar_halaman:
            tinggi, lebar = gambar.shape[0], gambar.shape[1]

            hasil, _ = ocr(gambar)

            if not hasil:
                continue

            ada_teks = True

            anchor = cari_anchor(hasil)

            if anchor:
                # Susunan nota dikenali dari penanda "NOTA NO.".
                # Toleransi baris: 6% tinggi halaman.
                toleransi = tinggi * 0.06
                baris = kelompuk_baris(anchor, toleransi)
                kotak = hitung_potongan(baris, lebar, tinggi)
            else:
                # ⚠️ TIDAK ADA PENANDA "NOTA" (nota satuan, nota tipe lain,
                # atau judul yang kurang jelas terbaca).
                #
                # Dulu halaman ini DILEWATI → hasilnya `nota: []` → admin
                # melihat "OCR tidak bisa membaca" PADAHAL teksnya terbaca.
                # Itulah bug "nota satuan tidak terbaca OCR".
                #
                # Sekarang SELURUH halaman diperlakukan sebagai SATU nota:
                # potongan = seluruh gambar, teks = semua teks halaman.
                # Dengan begitu nota satuan tetap bisa dibaca isinya dan
                # tetap punya pratinjau.
                ada_penanda = True
                metode = "halaman_penuh"
                kotak = [(0.0, 0.0, float(lebar), float(tinggi))]

            potongan = simpan_potongan(
                gambar, kotak, dir_keluar, mulai_dari=nomor_potongan
            )

            # Teks OCR tiap nota — dikelompokkan ke kotak nota masing-masing.
            # PHP memakai ini untuk membaca isi nota (nominal, tanggal, dst).
            teks_kotak = teks_per_kotak(hasil, kotak)

            for i in range(len(kotak)):
                nomor_potongan += 1
                semua_nota.append({
                    "ke": nomor_potongan,
                    "halaman": nomor_halaman,
                    "kotak": [round(v, 1) for v in kotak[i]],
                    "potongan": potongan[i],
                    # Daftar {"teks": str, "x": float, "y": float} terurut baca.
                    "teks": teks_kotak[i] if i < len(teks_kotak) else [],
                })

        # Tidak ada teks SAMA SEKALI (mis. foto gelap / scan kosong).
        # Tetap kembalikan SATU nota = SELURUH berkas, supaya admin bisa
        # melihat berkasnya & mengisi jumlah manual — bukan `nota: []`.
        if not ada_teks and daftar_halaman:
            gambar_pertama = daftar_halaman[0][0]
            lebar = gambar_pertama.shape[1]
            tinggi = gambar_pertama.shape[0]
            kotak = [(0.0, 0.0, float(lebar), float(tinggi))]
            potongan = simpan_potongan(gambar_pertama, kotak, dir_keluar)
            semua_nota.append({
                "ke": 1,
                "halaman": 1,
                "kotak": [0.0, 0.0, float(lebar), float(tinggi)],
                "potongan": potongan[0] if potongan else None,
                "teks": [],
            })
            metode = "tidak_ada_teks"

        keluaran({
            "ok": True,
            "jumlah_nota": len(semua_nota),
            "halaman_diproses": len(daftar_halaman),
            "lebar": lebar,
            "tinggi": tinggi,
            "metode": metode,
            "nota": semua_nota,
        })

    except Exception as e:  # noqa: BLE001 — sengaja tangkap semua
        gagal(f"{type(e).__name__}: {e}")


if __name__ == "__main__":
    main()
