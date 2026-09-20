# Panduan Pengujian Visual (Browser)

> Sistem Informasi SPK & Kontrol Keuangan — PT Barelang Kontraktor Sarana

## Kenapa perlu?

**Unit test tidak menangkap masalah tata letak.**

Contoh nyata: 281 test lulus, tapi dua bug berikut tetap lolos:

| Bug | Kenapa lolos unit test |
|---|---|
| Nama bulan tampil bahasa Inggris ("August 2026") | Nilai data benar; hanya **tampilan** yang salah |
| Form uang keluar tampil berdampingan (bukan atas-bawah) | HTML valid; hanya **posisi elemen** yang salah |

Keduanya hanya terlihat saat halaman benar-benar **dirender dan diukur**.

---

## Urutan pengujian yang disarankan

```bash
# 1. Logika & otorisasi
php artisan test

# 2. Route & error 500
for u in /admin /admin/spks /admin/laporan; do
  curl -s -o /dev/null -w "$u -> %{http_code}\n" http://127.0.0.1:8000$u
done

# 3. Tata letak (browser) <- sering terlewat
```

---

## Menyiapkan browser

### 1. Aktifkan remote debugging pada profil Chrome

Chrome modern memerlukan izin eksplisit. Pada
`~/.config/google-chrome/Local State`, pastikan:

```json
{ "devtools": { "remote_debugging": { "user-enabled": true } } }
```

Bisa juga lewat UI: buka `chrome://inspect/#devices` → centang
**"Enable remote debugging"**.

### 2. Jalankan Chrome dengan CDP

```bash
google-chrome-stable --headless=new --no-sandbox \
  --remote-debugging-port=9222 --remote-allow-origins=* \
  --user-data-dir=/tmp/chrome-agent \
  --window-size=1600,1000 about:blank
```

Verifikasi:

```bash
curl -s http://127.0.0.1:9222/json/version
```

> ⚠️ Kalau ada **dua** Chrome dengan port sama, `/json/version` bisa
> mengembalikan **404**. Pastikan hanya satu yang berjalan.

### 3. Pasang Playwright

```bash
python3 -m venv /tmp/pwvenv
/tmp/pwvenv/bin/pip install playwright
```

---

## Skrip tangkap layar

```python
from playwright.sync_api import sync_playwright

BASE = "http://127.0.0.1:8000"

with sync_playwright() as p:
    b = p.chromium.connect_over_cdp("http://127.0.0.1:9222")
    ctx = b.contexts[0] if b.contexts else b.new_context()
    page = ctx.new_page()
    page.set_viewport_size({"width": 1600, "height": 1000})

    # Login
    page.goto(BASE + "/admin/login", wait_until="domcontentloaded")
    page.wait_for_timeout(1000)
    if "/login" in page.url:
        page.fill('input[type="email"]', "admin@bks.test")
        page.fill('input[type="password"]', "password")
        page.click('button[type="submit"]')
        page.wait_for_timeout(4000)

    # Halaman tujuan
    page.goto(BASE + "/admin", wait_until="domcontentloaded")
    page.wait_for_timeout(3000)

    page.screenshot(path="/tmp/tangkapan/dashboard.png", full_page=True)
    page.close(); b.close()
```

---

## Mengukur posisi elemen (bukan menebak dari gambar)

Untuk memastikan tata letak — mis. "apakah dua bagian bertumpuk atau
berdampingan" — **ukur dari DOM**, jangan mengandalkan pembacaan gambar:

```python
data = page.evaluate("""() => {
    const out = [];
    document.querySelectorAll('.fi-section').forEach(el => {
        const r = el.getBoundingClientRect();
        out.push({
            judul: el.querySelector('.fi-section-header-heading')?.innerText?.trim(),
            x: Math.round(r.x), y: Math.round(r.y), w: Math.round(r.width),
        });
    });
    return out;
}""")

for d in data:
    print(f"x={d['x']} y={d['y']} lebar={d['w']}  {d['judul']}")

# Y sama  -> BERDAMPINGAN
# Y beda  -> BERTUMPUK
```

---

## Membaca teks langsung dari DOM

OCR gambar **bisa salah baca**. Contoh nyata: "90 SPK" terbaca "99 SPK".

```python
teks = page.evaluate("""() => {
    return [...document.querySelectorAll('.fi-wi-stats-overview-stat')].map(el => ({
        label: el.querySelector('.fi-wi-stats-overview-stat-label')?.innerText?.trim(),
        nilai: el.querySelector('.fi-wi-stats-overview-stat-value')?.innerText?.trim(),
    }));
}""")
```

**Aturan:** untuk **angka & teks**, selalu ambil dari DOM.
Gambar hanya untuk menilai **tata letak & keterbacaan**.

---

## Yang perlu diperiksa tiap halaman

| Hal | Cara |
|---|---|
| Tidak ada error 500 | HTTP status / teks halaman |
| Tidak ada ruang kosong besar | Perhatikan screenshot |
| Grafik terisi (bukan garis nol) | Perhatikan screenshot |
| Bahasa konsisten Indonesia | Baca teks dari DOM |
| Posisi elemen sesuai maksud | Ukur `getBoundingClientRect()` |
| Teks tidak terpotong | Perhatikan screenshot |

---

## Masalah yang sering muncul

| Gejala | Penyebab | Solusi |
|---|---|---|
| `chrome-not-running` | Toggle remote debugging belum aktif | Set `user-enabled: true` |
| `/json/version` 404 | Dua Chrome berebut port | Matikan semua, jalankan satu |
| `ERR_ABORTED` saat `goto` | Redirect 302 | Pakai `wait_until="domcontentloaded"` + timeout |
| `net::ERR_CONNECTION_REFUSED` | Server Laravel mati | `php artisan serve` |
| Login gagal | Selector berubah | Periksa `input[type="email"]` |
