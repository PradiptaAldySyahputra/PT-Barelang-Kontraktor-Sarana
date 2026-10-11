<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Resources\Penggunas\Pages\ListPenggunas;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * BUG — TOMBOL "TAMBAH PENGGUNA" TIDAK MUNCUL UNTUK DIREKTUR.
 *
 * ⚠️ TEMUAN (10 Okt 2026), dilaporkan pengguna:
 *   "direktur bisa menambah user karna sekarang tidak ada"
 *
 * Akar masalah — KONTRADIKSI hak akses:
 *   - `PenggunaResource::canCreate()`  → TRUE untuk Direktur (otorisasi benar).
 *   - `ListPenggunas::getHeaderActions()` menyembunyikan tombol dengan
 *     `PenggunaResource::bolehUbahData()` → trait ini memakai `bolehInput()`
 *     yang TRUE HANYA untuk Admin.
 *
 * Akibatnya: Direktur bisa membuka /admin/penggunas/create (200 OK), TETAPI
 * tidak ada tombol/menu menuju ke sana — praktis tidak bisa menambah user.
 * Tombol disembunyikan dengan aturan yang SALAH (aturan input-data, bukan
 * aturan kelola-akun).
 *
 * Perbaikan: tombol HARUS mengikuti otorisasi Resource yang sebenarnya
 * (`canCreate()`), supaya tidak ada kontradiksi.
 */
class BugTombolTambahPenggunaTest extends TestCase
{
    use RefreshDatabase;

    public function test_tombol_tambah_pengguna_muncul_untuk_direktur(): void
    {
        $direktur = Pengguna::factory()->direktur()->create(['email' => 'dir-tombol@bks.test']);
        $this->actingAs($direktur);

        // Prasyarat: otorisasi memang membolehkan.
        $this->assertTrue(PenggunaResource::canCreate());

        Livewire::test(ListPenggunas::class)
            ->assertActionVisible('create');
    }

    public function test_tombol_tambah_pengguna_tidak_muncul_untuk_admin(): void
    {
        $admin = Pengguna::factory()->admin()->create(['email' => 'admin-tombol@bks.test']);
        $this->actingAs($admin);

        // Admin bahkan tidak boleh melihat halaman ini.
        $this->assertFalse(PenggunaResource::canCreate());
    }
}
