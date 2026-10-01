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
