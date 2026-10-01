# Buku Kas & Bank — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Admin dapat mencatat transaksi dengan penanda akun (Kas/Bank) dan menyajikan buku Kas & Bank per bulan dengan saldo berjalan — untuk keperluan pajak — serta mengekspor data tiap menu ke Excel.

**Architecture:** Tambah satu kolom `akun` (string, nullable, default `kas`) pada `uang_masuk` dan `uang_keluar`, divalidasi PHP Enum `AkunKas` (pola sama seperti `KategoriPengeluaran`). Saldo berjalan dihitung on-the-fly oleh satu service murni `BukuKasBank` (tanpa tabel ringkasan). Halaman Filament baru menampilkan hasilnya; ekspor memakai `ExportAction` bawaan Filament v5.

**Tech Stack:** Laravel 13, Filament 5.8, MySQL, PHPUnit, `openspout/openspout` v4 (via Filament).

**Spec:** `docs/superpowers/specs/2026-09-26-kas-bank-dan-spk-design.md`

## Global Constraints

- **Skema domain tetap 5 tabel** (`mitra`, `spk`, `uang_masuk`, `uang_keluar`, `pengguna`). Semua tambahan berupa **kolom**, bukan tabel. Tabel infrastruktur (`exports`, `jobs`, `cache`, `sessions`) tidak dihitung sebagai tabel domain.
- **GIT: pengguna melakukan SEMUA commit & push.** JANGAN jalankan `git commit`, `git push`, `git add`, atau mengubah history. Tinggalkan perubahan di working tree dan beri tahu pengguna.
- **Kolom `REF` tidak dibuat di database.** Hanya dicetak kosong pada ekspor buku kas/bank agar bentuknya identik dengan Excel pengguna.
- **Data lama** mendapat nilai `akun` default `kas`.
- **Nilai `akun`**: `kas` | `bank`. Tidak ada nilai lain.
- **Nama file/kelas & pesan dalam Bahasa Indonesia**, mengikuti gaya proyek (docblock penjelas "KENAPA").
- **Jangan pernah menjalankan server pada port 8000** (milik pengguna). Untuk uji manual pakai port lain (mis. 8002) dan matikan setelah selesai.
- Semua tes dijalankan dengan `php artisan test`. Format kode dirapikan dengan `./vendor/bin/pint` (hanya pada file yang disentuh).

## Review Focus

Hal-hal yang mudah membuat fitur ini salah tetapi tidak eksplisit di spec — setiap baris mendapat tesnya di task pemiliknya:

1. **Transaksi ber-tanggal sama** — urutan baris harus stabil (tanggal, lalu id) agar saldo berjalan tidak berubah-ubah setiap kali halaman dibuka.
2. **Transaksi tanpa akun (`akun = null`)** — data lama sebelum migrasi terisi; perhitungan harus memperlakukannya sebagai `kas`, bukan menjatuhkannya dari total.
3. **Periode tanpa transaksi sama sekali** — saldo awal tetap benar, tabel kosong, total 0 (bukan error/`null`).
4. **Nilai transaksi desimal/negatif** — `jumlah` bertipe `decimal:2`; total dan saldo tidak boleh kehilangan presisi atau menghasilkan `-0`.
5. **Nama pekerjaan/keterangan berisi karakter `=`, `+`, `-`, `@`** — pada ekspor CSV tidak boleh menjadi rumus (CSV injection). Untuk ekspor XLSX memakai `ExportAction`, nilai tetap sebagai teks.

---

### Task 1: Enum `AkunKas`

**Files:**
- Create: `app/Enums/AkunKas.php`
- Test: `tests/Feature/AkunKasTest.php`

**Interfaces:**
- Consumes: tidak ada.
- Produces: `App\Enums\AkunKas` dengan case `Kas = 'kas'`, `Bank = 'bank'`; method `label(): string`, `warnaBadge(): string`, `static opsi(): array<string,string>`.

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use Tests\TestCase;

/**
 * Enum akun kas/bank.
 *
 * Dipakai untuk memisahkan buku KAS dan BANK — permintaan pengguna agar
 * laporan keuangan bisa disajikan terpisah seperti Excel perusahaan.
 */
class AkunKasTest extends TestCase
{
    public function test_nilai_enum_hanya_kas_dan_bank(): void
    {
        $this->assertSame(
            ['kas', 'bank'],
            array_map(fn (AkunKas $a): string => $a->value, AkunKas::cases()),
        );
    }

    public function test_label_dan_opsi(): void
    {
        $this->assertSame('Kas', AkunKas::Kas->label());
        $this->assertSame('Bank', AkunKas::Bank->label());

        $this->assertSame(
            ['kas' => 'Kas', 'bank' => 'Bank'],
            AkunKas::opsi(),
        );
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=AkunKasTest`
Expected: FAIL — "Class \"App\\Enums\\AkunKas\" not found".

- [ ] **Step 3: Buat enum**

```php
<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Akun kas/bank.
 *
 * ⚠️ KENAPA INI PERLU (permintaan pengguna 26 Sep 2026):
 * Excel perusahaan ("BKS - Format Kas & Bank") memisahkan dua buku:
 * KAS (operasional harian) dan BANK (transfer, gaji, setoran). Sistem
 * sebelumnya mencampur keduanya, sehingga laporan tidak bisa disajikan
 * per akun saat diminta bagian pajak.
 *
 * Sama seperti KategoriPengeluaran: kolomnya berupa TEKS, divalidasi enum
 * ini + dropdown di form, supaya laporan tidak terpecah.
 */
enum AkunKas: string
{
    case Kas = 'kas';
    case Bank = 'bank';

    public function label(): string
    {
        return match ($this) {
            self::Kas => 'Kas',
            self::Bank => 'Bank',
        };
    }

    /**
     * Warna badge Filament — konsisten di seluruh halaman.
     */
    public function warnaBadge(): string
    {
        return match ($this) {
            self::Kas => 'success',
            self::Bank => 'info',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function opsi(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $a): array => [$a->value => $a->label()])
            ->all();
    }
}
```

- [ ] **Step 4: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=AkunKasTest`
Expected: PASS (2 tes).

- [ ] **Step 5: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Enums/AkunKas.php tests/Feature/AkunKasTest.php`
Expected: "fixed 0 files" atau daftar file yang dirapikan. **JANGAN commit** — pengguna yang melakukan commit.

---

### Task 2: Migrasi kolom `akun`

**Files:**
- Create: `database/migrations/2026_09_26_000001_tambah_akun_ke_uang_masuk_table.php`
- Create: `database/migrations/2026_09_26_000002_tambah_akun_ke_uang_keluar_table.php`
- Test: `tests/Feature/KolomAkunTest.php`

**Interfaces:**
- Consumes: `App\Enums\AkunKas` (Task 1).
- Produces: kolom `akun` (`string(20)`, nullable, default `'kas'`, index) pada tabel `uang_masuk` & `uang_keluar`.

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Kolom `akun` pada uang_masuk & uang_keluar.
 *
 * Memisahkan buku KAS dan BANK. Data lama otomatis menjadi 'kas'.
 *
 * ⚠️ Tes ini sengaja memakai query builder (bukan factory/model) karena
 * cast Enum baru ditambahkan pada task berikutnya. Yang diuji DI SINI
 * hanyalah: kolom ada, dan DEFAULT-nya 'kas'.
 */
class KolomAkunTest extends TestCase
{
    use RefreshDatabase;

    public function test_kolom_akun_ada_di_kedua_tabel(): void
    {
        $this->assertTrue(Schema::hasColumn('uang_masuk', 'akun'));
        $this->assertTrue(Schema::hasColumn('uang_keluar', 'akun'));
    }

    public function test_akun_default_kas_saat_tidak_diisi(): void
    {
        DB::table('uang_masuk')->insert([
            'tanggal' => '2026-08-01',
            'jumlah' => 1000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertSame('kas', DB::table('uang_masuk')->value('akun'));
    }

    public function test_akun_bisa_diisi_bank(): void
    {
        DB::table('uang_keluar')->insert([
            'tanggal' => '2026-08-01',
            'jumlah' => 500,
            'akun' => 'bank',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertSame('bank', DB::table('uang_keluar')->value('akun'));
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=KolomAkunTest`
Expected: FAIL — kolom `akun` belum ada.

- [ ] **Step 3: Buat migrasi `uang_masuk`**

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom `akun` (kas | bank) pada uang_masuk.
 *
 * ⚠️ KENAPA: pengguna meminta laporan kas/bank terpisah seperti Excel
 * perusahaan. Data lama otomatis menjadi 'kas' (keputusan pengguna).
 * Skema tetap 5 tabel — ini hanya KOLOM baru.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->string('akun', 20)->nullable()->default('kas')->after('tanggal')->index();
        });
    }

    public function down(): void
    {
        Schema::table('uang_masuk', function (Blueprint $table): void {
            $table->dropColumn('akun');
        });
    }
};
```

- [ ] **Step 4: Buat migrasi `uang_keluar`**

Isi **sama** dengan Task 2 Step 3, hanya nama tabelnya `uang_keluar`:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom `akun` (kas | bank) pada uang_keluar.
 *
 * Lihat catatan di migrasi uang_masuk — alasan & keputusan sama.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->string('akun', 20)->nullable()->default('kas')->after('tanggal')->index();
        });
    }

    public function down(): void
    {
        Schema::table('uang_keluar', function (Blueprint $table): void {
            $table->dropColumn('akun');
        });
    }
};
```

- [ ] **Step 5: Jalankan migrasi & tes**

Run: `php artisan migrate && php artisan test --filter=KolomAkunTest`
Expected: migrasi OK; tes PASS (3 tes).

Catatan: `RefreshDatabase` menjalankan ulang semua migrasi di database tes, jadi tes ini juga memverifikasi migrasi bersih dari nol.

- [ ] **Step 6: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint database/migrations/2026_09_26_000001_tambah_akun_ke_uang_masuk_table.php database/migrations/2026_09_26_000002_tambah_akun_ke_uang_keluar_table.php tests/Feature/KolomAkunTest.php`
**JANGAN commit.**

---

### Task 3: Model + form (pilih Kas/Bank)

**Files:**
- Modify: `app/Models/UangMasuk.php` (fillable + casts)
- Modify: `app/Models/UangKeluar.php` (fillable + casts)
- Modify: `app/Filament/Resources/UangMasuks/Schemas/UangMasukForm.php`
- Modify: `app/Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php`
- Test: `tests/Feature/FormAkunTest.php`

**Interfaces:**
- Consumes: `App\Enums\AkunKas`, kolom `akun`.
- Produces: `UangMasuk::$akun` dan `UangKeluar::$akun` bertipe `AkunKas|null`; field form `akun` (Select, default Kas, wajib).

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Model & form: pilihan akun Kas/Bank.
 */
class FormAkunTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_mengembalikan_enum(): void
    {
        $masuk = UangMasuk::factory()->create(['akun' => 'bank']);
        $keluar = UangKeluar::factory()->create(['akun' => 'kas']);

        $this->assertSame(AkunKas::Bank, $masuk->fresh()->akun);
        $this->assertSame(AkunKas::Kas, $keluar->fresh()->akun);
    }

    public function test_form_uang_masuk_memuat_pilihan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-masuks/create')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas', $html);
        $this->assertStringContainsString('Bank', $html);
    }

    public function test_form_uang_keluar_memuat_pilihan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-keluars/create')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Kas', $html);
        $this->assertStringContainsString('Bank', $html);
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=FormAkunTest`
Expected: FAIL — `$akun` belum di-cast ke enum (tes 1) dan form belum punya pilihan (tes 2 & 3).

- [ ] **Step 3: Ubah model `UangMasuk`**

Tambahkan `use App\Enums\AkunKas;` pada daftar import, tambahkan `'akun'` ke `$fillable` (setelah `'tanggal'`), dan tambahkan cast:

```php
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jumlah' => 'decimal:2',
            'akun' => AkunKas::class,
            'bukti' => 'array',
        ];
    }
```

Juga tambahkan docblock properti di atas kelas:

```php
 * @property AkunKas|null $akun
```

- [ ] **Step 4: Ubah model `UangKeluar`** — sama seperti Step 3 (`use App\Enums\AkunKas;`, `'akun'` di `$fillable` setelah `'tanggal'`, cast `'akun' => AkunKas::class`, docblock properti).

- [ ] **Step 5: Tambah field di `UangMasukForm`**

Tambahkan import `use App\Enums\AkunKas;`. Pada `Section::make('Sumber Penerimaan')` — setelah komponen `Radio::make('mode')` — tambahkan:

```php
                        Select::make('akun')
                            ->label('Akun')
                            ->options(AkunKas::opsi())
                            ->default(AkunKas::Kas->value)
                            ->required()
                            ->native(false)
                            ->helperText('Kas = operasional harian. Bank = transfer, gaji, setoran.'),
```

(`Select` sudah di-import di file ini.)

- [ ] **Step 6: Tambah field di `UangKeluarForm`**

Tambahkan import `use App\Enums\AkunKas;` bila belum ada. Pada Section pertama (bagian identitas/transaksi), tambahkan komponen:

```php
                        Select::make('akun')
                            ->label('Akun')
                            ->options(AkunKas::opsi())
                            ->default(AkunKas::Kas->value)
                            ->required()
                            ->native(false)
                            ->helperText('Kas = operasional harian. Bank = transfer, gaji, setoran.'),
```

- [ ] **Step 7: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=FormAkunTest`
Expected: PASS (3 tes).

- [ ] **Step 7b: Tambah `akun` ke factory (memudahkan tes berikutnya)**

Pada `database/factories/UangMasukFactory.php` dan `database/factories/UangKeluarFactory.php`, tambahkan satu baris di `definition()` setelah `'tanggal'`:

```php
            'akun' => 'kas',
```

Lalu tambahkan state opsional di masing-masing factory:

```php
    /**
     * Transaksi pada buku BANK.
     */
    public function bank(): static
    {
        return $this->state(fn (array $attributes): array => ['akun' => 'bank']);
    }
```

Run: `php artisan test --filter=FormAkunTest`
Expected: tetap PASS.

- [ ] **Step 8: Jalankan seluruh suite (jaga regresi)**

Run: `php artisan test`
Expected: semua lulus (372 sebelumnya + tes baru).

- [ ] **Step 9: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Models/UangMasuk.php app/Models/UangKeluar.php app/Filament/Resources/UangMasuks/Schemas/UangMasukForm.php app/Filament/Resources/UangKeluars/Schemas/UangKeluarForm.php tests/Feature/FormAkunTest.php`
**JANGAN commit.**

---

### Task 4: Kolom & filter akun di tabel

**Files:**
- Modify: `app/Filament/Resources/UangMasuks/Tables/UangMasuksTable.php`
- Modify: `app/Filament/Resources/UangKeluars/Tables/UangKeluarsTable.php`
- Test: `tests/Feature/TabelAkunTest.php`

**Interfaces:**
- Consumes: `App\Enums\AkunKas`, kolom `akun`.
- Produces: kolom tabel `akun` (badge) + filter `akun` pada kedua tabel.

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tabel uang masuk & keluar menampilkan akun + bisa difilter.
 */
class TabelAkunTest extends TestCase
{
    use RefreshDatabase;

    public function test_tabel_uang_masuk_menampilkan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangMasuk::factory()->create(['akun' => 'bank', 'keterangan' => 'Setoran bank']);
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-masuks')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Akun', $html);
    }

    public function test_tabel_uang_keluar_menampilkan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangKeluar::factory()->create(['akun' => 'kas', 'keterangan' => 'Belanja material']);
        $this->actingAs($admin);

        $html = $this->get('/admin/uang-keluars')->assertSuccessful()->getContent();

        $this->assertStringContainsString('Akun', $html);
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=TabelAkunTest`
Expected: FAIL — label "Akun" belum ada.

- [ ] **Step 3: Tambah kolom & filter di `UangMasuksTable`**

Tambahkan import `use App\Enums\AkunKas;`. Di dalam `->columns([...])`, sisipkan setelah kolom `tanggal`:

```php
                TextColumn::make('akun')
                    ->label('Akun')
                    ->badge()
                    ->formatStateUsing(fn (?AkunKas $state): string => ($state ?? AkunKas::Kas)->label())
                    ->color(fn (?AkunKas $state): string => ($state ?? AkunKas::Kas)->warnaBadge()),
```

Di dalam `->filters([...])`, tambahkan:

```php
                SelectFilter::make('akun')
                    ->label('Akun')
                    ->options(AkunKas::opsi()),
```

(Pastikan `SelectFilter` sudah di-import; bila belum, tambahkan `use Filament\Tables\Filters\SelectFilter;`.)

- [ ] **Step 4: Tambah kolom & filter di `UangKeluarsTable`** — sama seperti Step 3.

- [ ] **Step 5: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=TabelAkunTest`
Expected: PASS (2 tes).

- [ ] **Step 6: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Filament/Resources/UangMasuks/Tables/UangMasuksTable.php app/Filament/Resources/UangKeluars/Tables/UangKeluarsTable.php tests/Feature/TabelAkunTest.php`
**JANGAN commit.**

---

### Task 5: Service `BukuKasBank` (saldo berjalan)

**Files:**
- Create: `app/Services/BukuKasBank.php`
- Test: `tests/Feature/BukuKasBankTest.php`

**Interfaces:**
- Consumes: `App\Enums\AkunKas`, model `UangMasuk`, `UangKeluar`.
- Produces: `BukuKasBank::susun(AkunKas $akun, CarbonInterface $dari, CarbonInterface $sampai): array` yang mengembalikan:

```php
[
  'saldo_awal' => float,     // saldo sebelum $dari
  'saldo_akhir' => float,    // saldo setelah baris terakhir
  'total_masuk' => float,
  'total_keluar' => float,
  'baris' => [
     ['tanggal' => 'Y-m-d', 'keterangan' => string, 'masuk' => float, 'keluar' => float, 'saldo' => float],
     ...
  ],
]
```

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Services\BukuKasBank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Perhitungan saldo berjalan buku kas/bank.
 *
 * ⚠️ Angka acuan diambil dari Excel pengguna "BKS - Format Kas & Bank":
 * urutan tanggal, saldo awal dari transaksi sebelum periode, lalu
 * saldo berjalan = saldo sebelumnya + masuk − keluar.
 */
class BukuKasBankTest extends TestCase
{
    use RefreshDatabase;

    public function test_saldo_berjalan_dan_saldo_awal(): void
    {
        // Sebelum periode (Juli): saldo awal 1.000.000
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-07-01', 'jumlah' => 1_000_000]);

        // Dalam periode (Agustus)
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 500_000, 'keterangan' => 'Terima']);
        UangKeluar::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-06', 'jumlah' => 200_000, 'keterangan' => 'Belanja']);

        $hasil = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(1_000_000.0, $hasil['saldo_awal']);
        $this->assertSame(500_000.0, $hasil['total_masuk']);
        $this->assertSame(200_000.0, $hasil['total_keluar']);
        $this->assertSame(1_300_000.0, $hasil['saldo_akhir']);
        $this->assertCount(2, $hasil['baris']);
        $this->assertSame(1_500_000.0, $hasil['baris'][0]['saldo']);
        $this->assertSame(1_300_000.0, $hasil['baris'][1]['saldo']);
    }

    public function test_hanya_akun_yang_diminta_yang_dihitung(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 100_000]);
        UangMasuk::factory()->create(['akun' => 'bank', 'tanggal' => '2026-08-05', 'jumlah' => 900_000]);

        $hasil = BukuKasBank::susun(AkunKas::Bank, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(0.0, $hasil['saldo_awal']);
        $this->assertSame(900_000.0, $hasil['total_masuk']);
        $this->assertSame(900_000.0, $hasil['saldo_akhir']);
    }

    public function test_transaksi_tanpa_akun_dianggap_kas(): void
    {
        // Data lama: akun NULL harus ikut terhitung sebagai kas.
        UangMasuk::factory()->create(['akun' => null, 'tanggal' => '2026-08-05', 'jumlah' => 250_000]);

        $hasil = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(250_000.0, $hasil['total_masuk']);
    }

    public function test_periode_kosong_tidak_error(): void
    {
        $hasil = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(0.0, $hasil['saldo_awal']);
        $this->assertSame(0.0, $hasil['saldo_akhir']);
        $this->assertSame([], $hasil['baris']);
    }

    public function test_urutan_stabil_saat_tanggal_sama(): void
    {
        $a = UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 100_000, 'keterangan' => 'Pertama']);
        $b = UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 50_000, 'keterangan' => 'Kedua']);

        $hasil = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame('Pertama', $hasil['baris'][0]['keterangan']);
        $this->assertSame('Kedua', $hasil['baris'][1]['keterangan']);
        $this->assertSame(150_000.0, $hasil['baris'][1]['saldo']);
    }

    /**
     * REVIEW FOCUS — nilai desimal tidak boleh kehilangan presisi.
     *
     * `jumlah` bertipe decimal:2 (mis. biaya TF Rp 2.500,50). Kalau perhitungan
     * memakai int, angka di belakang koma hilang dan laporan pajak jadi salah.
     */
    public function test_nilai_desimal_tidak_hilang_presisi(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 1000.55]);
        UangKeluar::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-06', 'jumlah' => 0.55]);

        $hasil = BukuKasBank::susun(AkunKas::Kas, Carbon::parse('2026-08-01'), Carbon::parse('2026-08-31'));

        $this->assertSame(1000.55, $hasil['total_masuk']);
        $this->assertSame(0.55, $hasil['total_keluar']);
        $this->assertSame(1000.0, $hasil['saldo_akhir']);
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=BukuKasBankTest`
Expected: FAIL — class `BukuKasBank` belum ada.

- [ ] **Step 3: Buat service**

```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use Carbon\CarbonInterface;

/**
 * Penyusun buku kas/bank dengan saldo berjalan.
 *
 * ⚠️ KENAPA SERVICE TERPISAH:
 * Perhitungan saldo berjalan dipakai dua tempat (halaman Buku Kas & Bank dan
 * ekspor Excel). Kalau rumusnya ditulis dua kali, cepat atau lambat keduanya
 * berbeda diam-diam. Jadi rumusnya ada di SATU tempat ini, dan diuji langsung
 * terhadap angka Excel pengguna.
 *
 * ATURAN SALDO:
 *   saldo_awal  = Σ masuk − Σ keluar untuk transaksi SEBELUM tanggal awal
 *   saldo baris = saldo sebelumnya + masuk − keluar
 *
 * Data lama dengan `akun = null` diperlakukan sebagai KAS (keputusan pengguna).
 */
final class BukuKasBank
{
    /**
     * @return array{
     *     saldo_awal: float,
     *     saldo_akhir: float,
     *     total_masuk: float,
     *     total_keluar: float,
     *     baris: list<array{tanggal: string, keterangan: string, masuk: float, keluar: float, saldo: float}>
     * }
     */
    public static function susun(AkunKas $akun, CarbonInterface $dari, CarbonInterface $sampai): array
    {
        $nilaiAkun = [$akun->value];

        // Data lama (akun NULL) = kas.
        if ($akun === AkunKas::Kas) {
            $nilaiAkun[] = null;
        }

        // ---------------------------------------------------------
        // SALDO AWAL — semua transaksi sebelum tanggal awal periode
        // ---------------------------------------------------------
        $masukSebelum = (float) UangMasuk::query()
            ->whereIn('akun', $nilaiAkun)
            ->whereDate('tanggal', '<', $dari->toDateString())
            ->sum('jumlah');

        $keluarSebelum = (float) UangKeluar::query()
            ->whereIn('akun', $nilaiAkun)
            ->whereDate('tanggal', '<', $dari->toDateString())
            ->sum('jumlah');

        $saldoAwal = $masukSebelum - $keluarSebelum;

        // ---------------------------------------------------------
        // TRANSAKSI DALAM PERIODE — digabung, urut tanggal lalu id
        // ---------------------------------------------------------
        $masuk = UangMasuk::query()
            ->whereIn('akun', $nilaiAkun)
            ->whereDate('tanggal', '>=', $dari->toDateString())
            ->whereDate('tanggal', '<=', $sampai->toDateString())
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get(['id', 'tanggal', 'keterangan', 'jumlah'])
            ->map(fn (UangMasuk $m): array => [
                'tanggal' => $m->tanggal->toDateString(),
                'keterangan' => (string) ($m->keterangan ?? ''),
                'masuk' => (float) $m->jumlah,
                'keluar' => 0.0,
                'id' => $m->id,
            ]);

        $keluar = UangKeluar::query()
            ->whereIn('akun', $nilaiAkun)
            ->whereDate('tanggal', '>=', $dari->toDateString())
            ->whereDate('tanggal', '<=', $sampai->toDateString())
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get(['id', 'tanggal', 'keterangan', 'jumlah'])
            ->map(fn (UangKeluar $k): array => [
                'tanggal' => $k->tanggal->toDateString(),
                'keterangan' => (string) ($k->keterangan ?? ''),
                'masuk' => 0.0,
                'keluar' => (float) $k->jumlah,
                'id' => $k->id,
            ]);

        $gabung = $masuk->concat($keluar)
            ->sortBy([['tanggal', 'asc'], ['id', 'asc']])
            ->values();

        // ---------------------------------------------------------
        // SALDO BERJALAN
        // ---------------------------------------------------------
        $saldo = $saldoAwal;
        $totalMasuk = 0.0;
        $totalKeluar = 0.0;
        $baris = [];

        foreach ($gabung as $t) {
            $saldo += $t['masuk'] - $t['keluar'];
            $totalMasuk += $t['masuk'];
            $totalKeluar += $t['keluar'];

            $baris[] = [
                'tanggal' => $t['tanggal'],
                'keterangan' => $t['keterangan'],
                'masuk' => $t['masuk'],
                'keluar' => $t['keluar'],
                'saldo' => $saldo,
            ];
        }

        return [
            'saldo_awal' => $saldoAwal,
            'saldo_akhir' => $saldo,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'baris' => $baris,
        ];
    }
}
```

- [ ] **Step 4: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=BukuKasBankTest`
Expected: PASS (5 tes).

- [ ] **Step 5: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Services/BukuKasBank.php tests/Feature/BukuKasBankTest.php`
**JANGAN commit.**

---

### Task 6: Halaman "Buku Kas & Bank"

**Files:**
- Create: `app/Filament/Pages/BukuKasBank.php`
- Create: `resources/views/filament/pages/buku-kas-bank.blade.php`
- Test: `tests/Feature/HalamanBukuKasBankTest.php`

**Interfaces:**
- Consumes: `BukuKasBank::susun()` (Task 5), `AkunKas`.
- Produces: halaman Filament di grup **Keuangan**, rute `/admin/buku-kas-bank`, dengan properti publik `$akun` (string), `$bulan` (string `YYYY-MM`), method `setAkun(string)`, `setBulan(string)`.

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\BukuKasBank;
use App\Models\Pengguna;
use App\Models\UangMasuk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Halaman Buku Kas & Bank — tampilan saldo berjalan untuk bagian pajak.
 */
class HalamanBukuKasBankTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_terbuka_dan_menampilkan_akun(): void
    {
        $admin = Pengguna::factory()->admin()->create();
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => now()->toDateString(), 'jumlah' => 1_234_567]);
        $this->actingAs($admin);

        $this->get(BukuKasBank::getUrl())->assertSuccessful();
    }

    public function test_perhitungan_untuk_bulan_dipilih(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 700_000]);

        $page = new BukuKasBank();
        $page->akun = 'kas';
        $page->bulan = '2026-08';

        $data = $page->dataBuku();

        $this->assertSame(700_000.0, $data['total_masuk']);
        $this->assertSame(700_000.0, $data['saldo_akhir']);
    }
}
```

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=HalamanBukuKasBankTest`
Expected: FAIL — class `BukuKasBank` (Page) belum ada.

- [ ] **Step 3: Buat halaman Filament**

```php
<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\AkunKas;
use App\Services\BukuKasBank as LayananBukuKasBank;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;

/**
 * Halaman "Buku Kas & Bank".
 *
 * ⚠️ KENAPA HALAMAN BARU (permintaan pengguna 26 Sep 2026):
 * "biarkan saja seperti itu" (input tetap di menu Uang Masuk/Keluar) TETAPI
 * "tambah menu baru ... supaya memudahkan admin ... ketika diminta oleh
 * bagian pajak — contohnya tanggal sekian dan bulan sekian."
 *
 * Jadi halaman ini KHUSUS membaca & menyajikan: pilih akun + bulan, lihat
 * saldo berjalan, lalu ekspor. Input tetap di menu lama.
 */
class BukuKasBank extends Page
{
    protected string $view = 'filament.pages.buku-kas-bank';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';

    protected static ?string $navigationLabel = 'Buku Kas & Bank';

    protected static ?string $title = 'Buku Kas & Bank';

    protected static ?int $navigationSort = 3;

    /** Akun yang dipilih: 'kas' | 'bank'. */
    public string $akun = 'kas';

    /** Bulan yang dipilih, format YYYY-MM. */
    public string $bulan = '';

    public function mount(): void
    {
        $this->bulan = now()->format('Y-m');
    }

    public function setAkun(string $akun): void
    {
        $this->akun = $akun;
    }

    public function setBulan(string $bulan): void
    {
        $this->bulan = $bulan;
    }

    /**
     * Susun data buku untuk akun & bulan terpilih.
     *
     * @return array<string, mixed>
     */
    public function dataBuku(): array
    {
        $awal = Carbon::parse($this->bulan.'-01')->startOfMonth();
        $akhir = (clone $awal)->endOfMonth();

        return LayananBukuKasBank::susun(
            AkunKas::from($this->akun),
            $awal,
            $akhir,
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'data' => $this->dataBuku(),
            'daftarAkun' => AkunKas::opsi(),
            'labelBulan' => Carbon::parse($this->bulan.'-01')->translatedFormat('F Y'),
        ];
    }

    public function getSubheading(): ?string
    {
        return 'Pilih akun & bulan, lihat saldo berjalan, lalu unduh Excel untuk bagian pajak.';
    }
}
```

- [ ] **Step 4: Buat view Blade**

`resources/views/filament/pages/buku-kas-bank.blade.php`:

```blade
<x-filament-panels::page>
    <div class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium">Akun</label>
            <div class="mt-1 flex gap-2">
                @foreach ($daftarAkun as $nilai => $label)
                    <button
                        type="button"
                        wire:click="setAkun('{{ $nilai }}')"
                        @class([
                            'rounded-lg px-4 py-2 text-sm font-medium border',
                            'bg-primary-600 text-white border-primary-600' => $akun === $nilai,
                            'bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700' => $akun !== $nilai,
                        ])
                    >{{ $label }}</button>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium">Bulan</label>
            <input
                type="month"
                wire:model.live="bulan"
                class="mt-1 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900"
            >
        </div>
    </div>

    <x-filament::section heading="Ringkasan {{ $labelBulan }}">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <div class="text-sm text-gray-500">Saldo Awal</div>
                <div class="text-lg font-semibold">Rp {{ number_format($data['saldo_awal'], 0, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total Pemasukan</div>
                <div class="text-lg font-semibold text-success-600">Rp {{ number_format($data['total_masuk'], 0, ',', '.') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total Pengeluaran</div>
                <div class="text-lg font-semibold text-danger-600">Rp {{ number_format($data['total_keluar'], 0, ',', '.') }}</div>
            </div>
        </div>
        <div class="mt-4 text-sm">
            <span class="text-gray-500">Saldo Akhir:</span>
            <span class="font-bold">Rp {{ number_format($data['saldo_akhir'], 0, ',', '.') }}</span>
        </div>
    </x-filament::section>

    <x-filament::section heading="Rincian Transaksi">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Keterangan</th>
                        <th class="py-2 text-right">Pemasukan</th>
                        <th class="py-2 text-right">Pengeluaran</th>
                        <th class="py-2 text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data['baris'] as $baris)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="py-2">{{ \Illuminate\Support\Carbon::parse($baris['tanggal'])->format('d/m/Y') }}</td>
                            <td class="py-2">{{ $baris['keterangan'] ?: '—' }}</td>
                            <td class="py-2 text-right">{{ $baris['masuk'] > 0 ? number_format($baris['masuk'], 0, ',', '.') : '' }}</td>
                            <td class="py-2 text-right">{{ $baris['keluar'] > 0 ? number_format($baris['keluar'], 0, ',', '.') : '' }}</td>
                            <td class="py-2 text-right font-medium">{{ number_format($baris['saldo'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>
```

- [ ] **Step 5: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=HalamanBukuKasBankTest`
Expected: PASS (2 tes).

- [ ] **Step 6: Jalankan seluruh suite**

Run: `php artisan test`
Expected: semua lulus.

- [ ] **Step 7: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Filament/Pages/BukuKasBank.php tests/Feature/HalamanBukuKasBankTest.php`
**JANGAN commit.**

---

### Task 7: Ekspor Excel format perusahaan

**Files:**
- Create: `app/Services/EksporBukuKasBank.php`
- Modify: `app/Filament/Pages/BukuKasBank.php` (tambah action unduh)
- Test: `tests/Feature/EksporBukuKasBankTest.php`

**Interfaces:**
- Consumes: `BukuKasBank::susun()`, `AkunKas`.
- Produces: `EksporBukuKasBank::buat(AkunKas $akun, CarbonInterface $dari, CarbonInterface $sampai, string $path): void` — menulis berkas XLSX ke `$path`.

- [ ] **Step 1: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AkunKas;
use App\Models\UangKeluar;
use App\Models\UangMasuk;
use App\Services\EksporBukuKasBank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * Ekspor buku kas/bank ke Excel — bentuknya menyerupai
 * "BKS - Format Kas & Bank" milik pengguna.
 */
class EksporBukuKasBankTest extends TestCase
{
    use RefreshDatabase;

    public function test_berkas_xlsx_terbentuk_dan_berisi_angka(): void
    {
        UangMasuk::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-05', 'jumlah' => 500_000, 'keterangan' => 'Terima']);
        UangKeluar::factory()->create(['akun' => 'kas', 'tanggal' => '2026-08-06', 'jumlah' => 200_000, 'keterangan' => 'Belanja']);

        $path = tempnam(sys_get_temp_dir(), 'buku').'.xlsx';

        EksporBukuKasBank::buat(
            AkunKas::Kas,
            Carbon::parse('2026-08-01'),
            Carbon::parse('2026-08-31'),
            $path,
        );

        $this->assertFileExists($path);
        $this->assertGreaterThan(0, filesize($path));

        // Baca kembali untuk memastikan isinya benar (bukan berkas kosong).
        $reader = new \OpenSpout\Reader\XLSX\Reader();
        $reader->open($path);
        $teks = '';
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $teks .= implode(' | ', array_map(fn ($c) => (string) $c->getValue(), $row->getCells()))."\n";
            }
        }
        $reader->close();

        $this->assertStringContainsString('BARELANG', $teks);
        $this->assertStringContainsString('KAS', $teks);
        $this->assertStringContainsString('Belanja', $teks);
        $this->assertStringContainsString('500000', str_replace([',', '.'], '', $teks));

        @unlink($path);
    }
}
```

Catatan: openspout v4 **tidak** punya `ReaderEntityFactory` (itu API v3). API v4 yang benar: `new \OpenSpout\Reader\XLSX\Reader()`, lalu `->open()`, `->getSheetIterator()`, `->close()`. Sudah diverifikasi terhadap `vendor/openspout/openspout/src/Reader/XLSX/Reader.php`.

- [ ] **Step 2: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=EksporBukuKasBankTest`
Expected: FAIL — class `EksporBukuKasBank` belum ada.

- [ ] **Step 3: Buat service ekspor**

```php
<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AkunKas;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;

/**
 * Ekspor buku kas/bank ke XLSX — menyerupai Excel perusahaan
 * "BKS - Format Kas & Bank".
 *
 * ⚠️ KENAPA BENTUKNYA DIBUAT SAMA:
 * Berkas ini diserahkan ke bagian pajak. Kalau susunannya berbeda dari
 * Excel yang biasa mereka terima, mereka harus menyesuaikan lagi. Jadi
 * header perusahaan, "ACCOUNT : KAS", "Periode: AGUSTUS 2026", kolom REF
 * (dibiarkan kosong), dan baris "T O T A L" dibuat identik.
 */
final class EksporBukuKasBank
{
    public static function buat(
        AkunKas $akun,
        CarbonInterface $dari,
        CarbonInterface $sampai,
        string $path,
    ): void {
        $data = BukuKasBank::susun($akun, $dari, $sampai);

        $writer = new Writer();
        $writer->openToFile($path);
        $sheet = $writer->getCurrentSheet();
        $sheet->setName($akun->label());

        // Header perusahaan
        $writer->addRow(Row::fromValues(['PT. BARELANG KONTRAKTOR SARANA']));
        $writer->addRow(Row::fromValues([
            'ACCOUNT', '', ': '.strtoupper($akun->label()), '',
            'Periode: '.Carbon::parse($dari)->translatedFormat('F Y'),
        ]));
        $writer->addRow(Row::fromValues([
            'TANGGAL', 'REF', 'KETERANGAN', 'PEMASUKAN', 'PENGELUARAN', 'SALDO',
        ]));

        // Saldo awal sebagai baris pertama (bila ada)
        if ($data['saldo_awal'] !== 0.0) {
            $writer->addRow(Row::fromValues([
                $dari->format('d/m/Y'), '', 'Saldo awal periode', '', '', $data['saldo_awal'],
            ]));
        }

        foreach ($data['baris'] as $b) {
            $writer->addRow(Row::fromValues([
                Carbon::parse($b['tanggal'])->format('d/m/Y'),
                '', // REF — sengaja kosong, sama seperti Excel pengguna
                $b['keterangan'],
                $b['masuk'] > 0 ? $b['masuk'] : '',
                $b['keluar'] > 0 ? $b['keluar'] : '',
                $b['saldo'],
            ]));
        }

        // Baris total
        $writer->addRow(Row::fromValues([
            'T O T A L', '', '', $data['total_masuk'], $data['total_keluar'], $data['saldo_akhir'],
        ]));

        $writer->close();
    }
}
```

- [ ] **Step 4: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=EksporBukuKasBankTest`
Expected: PASS.

Bila gagal karena nama kelas openspout berbeda, periksa `ls vendor/openspout/openspout/src/Reader/XLSX/` dan sesuaikan pembaca di tes — **jangan** ubah service untuk mengakomodasi tes; service memakai API yang benar.

- [ ] **Step 5: Tambah tombol "Unduh Excel" di halaman**

Pada `app/Filament/Pages/BukuKasBank.php`, tambahkan import & action:

```php
use Filament\Actions\Action;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
```

Tambahkan method action:

```php
    protected function getHeaderActions(): array
    {
        return [
            Action::make('unduhExcel')
                ->label('Unduh Excel')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(fn (): StreamedResponse => $this->unduhExcel()),
        ];
    }

    protected function unduhExcel(): StreamedResponse
    {
        $awal = Carbon::parse($this->bulan.'-01')->startOfMonth();
        $akhir = (clone $awal)->endOfMonth();
        $nama = 'BKS-Kas-Bank-'.$this->akun.'-'.$this->bulan.'.xlsx';

        return Response::streamDownload(function () use ($awal, $akhir): void {
            $path = tempnam(sys_get_temp_dir(), 'buku').'.xlsx';
            EksporBukuKasBank::buat(AkunKas::from($this->akun), $awal, $akhir, $path);
            readfile($path);
            @unlink($path);
        }, $nama, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
```

Tambahkan `use App\Services\EksporBukuKasBank;` di daftar import.

- [ ] **Step 6: Tambah tes tombol unduh**

Tambahkan ke `tests/Feature/EksporBukuKasBankTest.php`:

```php
    public function test_tombol_unduh_tersedia_di_halaman(): void
    {
        $admin = \App\Models\Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get(\App\Filament\Pages\BukuKasBank::getUrl())->assertSuccessful()->getContent();

        $this->assertStringContainsString('Unduh Excel', $html);
    }
```

- [ ] **Step 7: Jalankan tes**

Run: `php artisan test --filter=EksporBukuKasBankTest`
Expected: PASS (2 tes).

- [ ] **Step 8: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Services/EksporBukuKasBank.php app/Filament/Pages/BukuKasBank.php tests/Feature/EksporBukuKasBankTest.php`
**JANGAN commit.**

---

### Task 8: Ekspor di seluruh menu

**Files:**
- Create: `app/Filament/Exports/` (kelas exporter, 1 per resource yang perlu kolom khusus; sisanya pakai `Exporter` default)
- Modify: `app/Filament/Resources/*/Tables/*.php` (9 tabel)
- Test: `tests/Feature/EksporMenuTest.php`

**Interfaces:**
- Consumes: `Filament\Actions\ExportAction`, `Filament\Actions\Exports\Exporter`.
- Produces: `ExportAction` pada toolbar tabel List SPK, Status SPK, Tagihan SPK, Tagihan Selesai SPK, Uang Masuk, Uang Keluar, Data Mitra, Pengguna (Buku Kas & Bank sudah punya ekspor sendiri di Task 7).

- [ ] **Step 1: Publikasikan migrasi tabel `exports`**

Run: `php artisan vendor:publish --tag=filament-actions-migrations`
Expected: file migrasi `create_exports_table` muncul di `database/migrations/`.

Run: `php artisan migrate`
Expected: tabel `exports` terbentuk.

Catatan: tabel `exports` adalah tabel **infrastruktur** (seperti `jobs`, `cache`), bukan tabel domain — aturan 5 tabel domain tetap dipatuhi. Bila pengguna menolak, ganti pendekatan ke ekspor manual (lihat spec §4.7 alternatif).

- [ ] **Step 2: Tulis tes yang gagal**

```php
<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Setiap menu harus bisa mengekspor datanya (permintaan pengguna).
 *
 * ⚠️ KENAPA PENTING: saat bagian pajak meminta "tanggal sekian, bulan
 * sekian", admin memfilter lalu menekan Ekspor — bukan mencatat manual.
 */
class EksporMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return list<array{0: string}>
     */
    public static function menuProvider(): array
    {
        return [
            ['/admin/spks'],
            ['/admin/monitoring-spk/status-spks'],
            ['/admin/monitoring-spk/tagihan-spks'],
            ['/admin/monitoring-spk/tagihan-selesai-spks'],
            ['/admin/uang-masuks'],
            ['/admin/uang-keluars'],
            ['/admin/mitras'],
            ['/admin/penggunas'],
        ];
    }

    /**
     * @dataProvider menuProvider
     */
    public function test_menu_punya_tombol_ekspor(string $url): void
    {
        $admin = Pengguna::factory()->admin()->create();
        $this->actingAs($admin);

        $html = $this->get($url)->assertSuccessful()->getContent();

        $this->assertStringContainsString('Ekspor', $html, "Menu {$url} harus punya tombol Ekspor.");
    }
}
```

- [ ] **Step 3: Jalankan tes, pastikan GAGAL**

Run: `php artisan test --filter=EksporMenuTest`
Expected: FAIL — tombol "Ekspor" belum ada.

- [ ] **Step 4: Pasang `ExportAction` di tiap tabel**

Pada **setiap** file tabel berikut, tambahkan import dan action:

```php
use Filament\Actions\ExportAction;
```

Lalu di dalam `->toolbarActions([...])`, tambahkan `ExportAction::make()` **di luar** `BulkActionGroup` (sejajar dengannya):

```php
            ->toolbarActions([
                ExportAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])->visible(fn (): bool => XxxResource::bolehUbahData()),
            ]);
```

File yang diubah:
- `app/Filament/Resources/Spks/Tables/SpksTable.php`
- `app/Filament/Resources/MonitoringSpk/` — tabel Status SPK, Tagihan SPK, Tagihan Selesai SPK (sesuai file `StatusSpkResource`/`TagihanSpkResource`/`TagihanSelesaiSpkResource` yang mendefinisikan `table()`)
- `app/Filament/Resources/UangMasuks/Tables/UangMasuksTable.php`
- `app/Filament/Resources/UangKeluars/Tables/UangKeluarsTable.php`
- `app/Filament/Resources/Mitras/Tables/MitrasTable.php`
- `app/Filament/Resources/Penggunas/Tables/PenggunasTable.php`

Catatan: `ExportAction::make()` tanpa `exporter` memakai `Exporter` default yang mengekspor semua kolom tabel. Bila ada kolom yang tidak boleh diekspor (mis. kolom aksi), tambahkan `->exporter(...)` khusus. Mulai dengan default; tambahkan exporter khusus hanya bila hasilnya salah.

- [ ] **Step 5: Jalankan tes, pastikan LULUS**

Run: `php artisan test --filter=EksporMenuTest`
Expected: PASS (8 tes).

- [ ] **Step 6: Jalankan seluruh suite**

Run: `php artisan test`
Expected: semua lulus.

- [ ] **Step 7: Rapikan & tinggalkan di working tree**

Run: `./vendor/bin/pint app/Filament/Resources tests/Feature/EksporMenuTest.php`
**JANGAN commit.**

---

## Verifikasi Akhir (setelah semua task)

- [ ] `php artisan test` → semua lulus, tidak ada regresi.
- [ ] `npm run build` → CSS/JS terbaru (halaman baru butuh aset).
- [ ] Uji manual di browser (port selain 8000):
  - Input uang masuk dengan akun **Bank**, uang keluar dengan akun **Kas**.
  - Buka **Buku Kas & Bank** → pilih akun & bulan → saldo berjalan benar.
  - Tekan **Unduh Excel** → berkas terbuka di LibreOffice/Excel, angkanya cocok.
  - Di tiap menu, tekan **Ekspor** → berkas terunduh & isinya benar.
- [ ] Bandingkan hasil Buku Kas untuk **Agustus 2026** dengan `BKS - Format Kas & Bank 2026 (AGUSTUS).xlsx` — selisih harus dapat dijelaskan (mis. data uji yang belum diinput).
- [ ] Beri tahu pengguna: **perubahan ada di working tree, siap di-commit oleh pengguna.**
