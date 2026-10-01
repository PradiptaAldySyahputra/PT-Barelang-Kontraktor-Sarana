<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Filament\Widgets\GrafikArusKas;
use App\Filament\Widgets\RingkasanKeuangan;
use App\Filament\Widgets\SpkBerjalan;
use App\Filament\Widgets\SpkPerStatus;
use App\Filament\Widgets\StatusTagihanChart;
use Tests\TestCase;

/**
 * URUTAN WIDGET DASHBOARD harus PASTI.
 *
 * ⚠️ TEMUAN (26 Sep 2026): `SpkPerStatus` dan `StatusTagihanChart` sama-sama
 * memakai `$sort = 3`. Kalau dua widget berbagi nomor urut yang sama, urutan
 * tampilnya tidak ditentukan aplikasi — bisa berubah sendiri dan membuat
 * dashboard terlihat "loncat-loncat". Ini masalah yang SAMA seperti navigasi
 * yang baru diperbaiki.
 *
 * Urutan yang diinginkan (dari atas ke bawah):
 *   1. Ringkasan Keuangan (angka utama)
 *   2. Grafik Arus Kas
 *   3. SPK per Status
 *   4. Status Tagihan
 *   5. SPK Berjalan (tabel)
 */
class UrutanWidgetTest extends TestCase
{
    /** @return array<class-string, int> */
    private function urutan(): array
    {
        return [
            RingkasanKeuangan::class => RingkasanKeuangan::getSort(),
            GrafikArusKas::class => GrafikArusKas::getSort(),
            SpkPerStatus::class => SpkPerStatus::getSort(),
            StatusTagihanChart::class => StatusTagihanChart::getSort(),
            SpkBerjalan::class => SpkBerjalan::getSort(),
        ];
    }

    public function test_tidak_ada_widget_dengan_urutan_sama(): void
    {
        $nilai = array_values($this->urutan());

        $this->assertSame(
            count($nilai),
            count(array_unique($nilai)),
            'Ada widget dengan $sort SAMA — urutannya jadi tidak pasti. Nilai: '.json_encode($nilai),
        );
    }

    public function test_urutan_widget_sesuai_prioritas(): void
    {
        $u = $this->urutan();

        $this->assertLessThan($u[GrafikArusKas::class], $u[RingkasanKeuangan::class], 'Ringkasan harus paling atas.');
        $this->assertLessThan($u[SpkPerStatus::class], $u[GrafikArusKas::class], 'Arus kas di atas SPK per status.');
        $this->assertLessThan($u[StatusTagihanChart::class], $u[SpkPerStatus::class], 'SPK per status di atas Status Tagihan.');
        $this->assertLessThan($u[SpkBerjalan::class], $u[StatusTagihanChart::class], 'Tabel SPK berjalan paling bawah.');
    }

    /**
     * Ambil nilai `$columnSpan` dari instance widget (propertinya protected).
     */
    private function columnSpan(string $widget): int|string|array
    {
        $instance = app($widget);
        $prop = (new \ReflectionClass($instance))->getProperty('columnSpan');
        $prop->setAccessible(true);

        return $prop->getValue($instance);
    }

    /**
     * ⚠️ TEMUAN TATA LETAK (26 Sep 2026) — keluhan pengguna "chart sejajar":
     *
     * Dashboard memakai grid 2 kolom. Dulu ada TIGA chart yang masing-masing
     * memakan 1 kolom → baris terakhir menyisakan 1 SLOT KOSONG, sehingga
     * dashboard terlihat "pincang" (ada ruang kosong besar di samping chart).
     *
     * Perbaikan: bar chart Arus Kas dibuat LEBAR PENUH (butuh ruang untuk
     * 6 bulan), sedangkan dua donut (SPK per Status & Status Tagihan)
     * berbagi satu baris — jadi tidak ada slot kosong.
     */
    public function test_tata_letak_chart_tidak_menyisakan_slot_kosong(): void
    {
        // Bar chart arus kas harus lebar penuh.
        $this->assertSame(
            'full',
            $this->columnSpan(GrafikArusKas::class),
            'Arus Kas harus lebar penuh — kalau tidak, ada slot kosong di barisnya.',
        );

        // Dua donut harus masing-masing 1 kolom (berdampingan dalam grid 2 kolom).
        $this->assertSame(1, $this->columnSpan(SpkPerStatus::class), 'SPK per Status harus 1 kolom.');
        $this->assertSame(1, $this->columnSpan(StatusTagihanChart::class), 'Status Tagihan harus 1 kolom.');

        // Ringkasan & tabel tetap lebar penuh.
        $this->assertSame('full', $this->columnSpan(RingkasanKeuangan::class));
        $this->assertSame('full', $this->columnSpan(SpkBerjalan::class));
    }
}
