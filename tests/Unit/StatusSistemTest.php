<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\StatusSistem;
use Tests\TestCase;

class StatusSistemTest extends TestCase
{
    public function test_status_sistem_mengembalikan_semua_indikator_diagnostik(): void
    {
        $status = StatusSistem::semua();

        $this->assertIsArray($status);
        $this->assertNotEmpty($status);

        $kunciList = array_column($status, 'kunci');

        $this->assertContains('database', $kunciList);
        $this->assertContains('queue', $kunciList);
        $this->assertContains('ocr', $kunciList);
        $this->assertContains('backup', $kunciList);
        $this->assertContains('penyimpanan', $kunciList);
        $this->assertContains('email', $kunciList);
        $this->assertContains('aplikasi', $kunciList);

        foreach ($status as $item) {
            $this->assertArrayHasKey('kunci', $item);
            $this->assertArrayHasKey('label', $item);
            $this->assertArrayHasKey('nilai', $item);
            $this->assertArrayHasKey('keterangan', $item);
            $this->assertArrayHasKey('sehat', $item);
        }
    }
}
