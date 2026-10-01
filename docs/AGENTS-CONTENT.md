# KONTEKS AGENT — PT Barelang Kontraktor Sarana

> ⚠️ **Cara memasang berkas ini:** jalankan di folder proyek
>
> ```bash
> cd "/home/pradipta/Project/PT Barelang Kontraktor Sarana"
> cp docs/AGENTS-CONTENT.md AGENTS.md
> ```
>
> Setelah itu `AGENTS.md` akan **dimuat otomatis** setiap agent dijalankan dari
> folder proyek ini — jadi agent tidak perlu ditanya dan tidak akan "halu".

---

## Proyek Ini: Sistem Informasi SPK & Kontrol Keuangan

**PT Barelang Kontraktor Sarana** (Batam) — subkontraktor PT PLN Batam.
Sistem internal perusahaan. **Tugas magang** Pradipta Aldy Syahputra.

Stack: Laravel 13.17 + Filament 5.0 + MySQL (`bks`) + PHP 8.5.
Skema: **5 tabel domain** (`mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna`).
Role: **2** — Admin (input) · Direktur (monitor).
Deploy: lokal intranet 2 PC — PC Direktur = server (**Windows**).

---

## ⭐ WAJIB DIBACA PERTAMA

**`docs/STATUS-PENGERJAAN.md`** — berisi:

1. Identitas proyek & daftar dokumen
2. **Aturan keras** (8 butir — jangan dilanggar)
3. **Keputusan bisnis FINAL** (jangan ditanyakan lagi)
4. **Status tahap terkini** (apa yang sudah & belum dikerjakan)
5. Peta menu & alur bisnis
6. Cara menjalankan
7. **Jebakan yang sudah diketahui** (jangan ulangi)
8. Preferensi pengguna

Lalu baca `docs/PRD.md` dan **`docs/Rules.md`** (aturan bisnis WAJIB DIPATUHI).

**Jangan bertanya hal yang jawabannya sudah ada di `docs/`.**

---

## Aturan Keras (ringkas)

| # | Aturan |
|:-:|:-------|
| 1 | **Pengguna melakukan SEMUA commit/push.** Agent DILARANG commit/push/ubah history — tinggalkan di working tree. |
| 2 | **Jangan menebak keputusan bisnis** — tanya. |
| 3 | **Jangan tambah tabel ke-6.** Tambahan lewat kolom/JSON + PHP Enum. |
| 4 | Balas **bahasa Indonesia**. |
| 5 | **Verifikasi sebelum menulis** — jangan tulis angka/nama dari ingatan. |
| 6 | **Data perusahaan tidak boleh bocor** ke GitHub (`~/data-perusahaan-bks/`). |
| 7 | **Backup dulu** sebelum ubah berkas besar. |
| 8 | **Uji di browser sungguhan** sebelum bilang "selesai". |

---

## Yang TIDAK dipakai (keputusan final — jangan usulkan lagi)

- ❌ Retensi 5% · ❌ Laba-rugi per SPK · ❌ Pajak PPN/PPh (di luar scope)
- ❌ Approval Direktur · ❌ Audit log · ❌ Entitas PROYEK (SPK = entitas inti)
- ❌ Menu Buku Kas & Bank (diganti filter periode + kolom `akun`)
- ❌ **Docker untuk produksi** (admin kantor yang merawat → pakai native Windows)

---

## Perintah Penting

```bash
php artisan test     # 521 tes lulus
php artisan serve    # http://127.0.0.1:8000/admin
./vendor/bin/pint    # formatter
```

Akun: `admin@bks.test` / `password` · `direktur@bks.test` / `password`

---

## Preferensi Pengguna

- Menolak UI templated/AI-slop
- ≤5–6 filter per tabel; satu kontrol per sumbu
- Bukti lebih penting dari klaim — sebutkan yang **tidak bisa** diverifikasi
- Sering mengabaikan pertanyaan klarifikasi (timeout) → kerjakan yang aman dulu
- Bahasa Indonesia
