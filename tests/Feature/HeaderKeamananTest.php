<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Header keamanan HTTP.
 *
 * ⚠️ TEMUAN AUDIT (26 Sep 2026): aplikasi tidak mengirim satu pun header
 * keamanan → halaman admin bisa dimuat dalam <iframe> situs lain
 * (clickjacking), dan browser boleh menebak tipe berkas.
 */
class HeaderKeamananTest extends TestCase
{
    public function test_halaman_mengirim_header_keamanan(): void
    {
        $respons = $this->get('/admin/login');

        $respons->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $respons->assertHeader('X-Content-Type-Options', 'nosniff');
        $respons->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }
}
