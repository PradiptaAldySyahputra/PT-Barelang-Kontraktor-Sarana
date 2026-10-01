<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OCR NOTA — BANTUAN, BUKAN PENENTU
    |--------------------------------------------------------------------------
    |
    | OCR dipakai HANYA untuk dua hal:
    |   1. Menghitung jumlah nota di dalam satu berkas.
    |   2. Menentukan posisi tiap nota (untuk memotong pratinjau).
    |
    | OCR TIDAK membaca nominal rupiah. Angka tetap diisi admin, karena salah
    | baca nominal bisa langsung masuk laporan keuangan. Salah hitung jumlah
    | nota jauh lebih ringan — admin tinggal ubah angkanya di form.
    |
    */

    /*
    | Aktifkan OCR. Kalau false, form tetap jalan normal: admin mengisi
    | jumlah nota manual seperti sebelumnya.
    |
    | SENGAJA default false supaya sistem tidak error di server yang belum
    | dipasangi Python. Nyalakan lewat .env: OCR_NOTA=true
    */
    'aktif' => env('OCR_NOTA', false),

    /*
    | Perintah Python. Di server bisa diisi path lengkap venv, mis.
    |   OCR_NOTA_PYTHON=/opt/ocr/bin/python3
    */
    'python' => env('OCR_NOTA_PYTHON', 'python3'),

    /*
    | Path skrip pembaca nota.
    */
    'skrip' => base_path('python/ocr_nota.py'),

    /*
    | Batas waktu (detik). Nota 4 halaman biasanya < 2 detik; 60 detik
    | memberi ruang untuk server yang sedang sibuk.
    */
    'timeout' => (int) env('OCR_NOTA_TIMEOUT', 60),

];
