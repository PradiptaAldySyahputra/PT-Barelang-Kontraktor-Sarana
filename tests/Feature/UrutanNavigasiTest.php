<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Laporan;
use App\Filament\Resources\Mitras\MitraResource;
use App\Filament\Resources\MonitoringSpk\StatusSpkResource;
use App\Filament\Resources\Penggunas\PenggunaResource;
use App\Filament\Resources\Spks\SpkResource;
use App\Filament\Resources\UangKeluars\UangKeluarResource;
use App\Filament\Resources\UangMasuks\UangMasukResource;
use Tests\TestCase;

/**
 * URUTAN NAVIGASI harus PASTI dan MASUK AKAL.
 *
 * ⚠️ TEMUAN UX (26 Sep 2026 — keluhan pengguna "navigasi berantakan"):
 * Semua grup navigasi memakai `navigationSort = 1` yang SAMA. Akibatnya
 * urutan grup di sidebar tidak ditentukan oleh aplikasi, melainkan oleh
 * urutan pendaftaran resource — yang bisa berubah saat kode ditambah dan
 * membuat admin kebingungan mencari menu.
 *
 * Urutan yang diinginkan (dari atas ke bawah):
 *   Dashboard → SPK → Keuangan → Master Data → Laporan
 *
 * Catatan: Dashboard diatur lewat `navigationSort = -10` (paling atas).
 */
class UrutanNavigasiTest extends TestCase
{
    public function test_urutan_grup_navigasi_naik_dari_dashboard_ke_laporan(): void
    {
        // Dashboard harus paling atas.
        $dashboard = (new \ReflectionClass(Dashboard::class));
        $sortDashboard = $dashboard->getStaticPropertyValue('navigationSort');
        $this->assertLessThan(0, $sortDashboard, 'Dashboard harus punya sort negatif (paling atas).');

        // Grup SPK < Keuangan < Master Data < Laporan.
        $spk = SpkResource::getNavigationSort();
        $keuanganMasuk = UangMasukResource::getNavigationSort();
        $keuanganKeluar = UangKeluarResource::getNavigationSort();
        $mitra = MitraResource::getNavigationSort();
        $pengguna = PenggunaResource::getNavigationSort();
        $laporan = (new \ReflectionClass(Laporan::class))->getStaticPropertyValue('navigationSort');

        $this->assertLessThan($keuanganMasuk, $spk, 'Grup SPK harus di atas Keuangan.');
        $this->assertLessThan($mitra, $keuanganKeluar, 'Grup Keuangan harus di atas Master Data.');
        $this->assertLessThan($laporan, $pengguna, 'Master Data harus di atas Laporan.');
    }

    public function test_urutan_di_dalam_grup_keuangan(): void
    {
        // Uang Masuk sebelum Uang Keluar (sesuai alur uang masuk dulu).
        $this->assertLessThan(
            UangKeluarResource::getNavigationSort(),
            UangMasukResource::getNavigationSort(),
            'Uang Masuk harus di atas Uang Keluar.',
        );
    }

    public function test_urutan_di_dalam_grup_spk(): void
    {
        $this->assertLessThan(
            StatusSpkResource::getNavigationSort(),
            SpkResource::getNavigationSort(),
            'List SPK harus paling atas di grup SPK.',
        );
    }
}
