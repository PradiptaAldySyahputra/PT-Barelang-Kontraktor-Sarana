<?php

$root = dirname(__DIR__);
require $root.'/vendor/autoload.php';
$app = require_once $root.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\Pengguna;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
Auth::login(Pengguna::where('email', 'admin@bks.test')->first());

$h = (string) $kernel->handle(Request::create('/admin', 'GET'))->getContent();

// Cari elemen topbar & sidebar
foreach (['fi-topbar', 'fi-sidebar-header', 'fi-logo', 'collapse-sidebar', 'fi-sidebar-open', 'fi-sidebar-close'] as $k) {
    $n = substr_count($h, $k);
    printf("%-24s muncul %d kali\n", $k, $n);
}

echo "\n=== potongan HTML topbar ===\n";
$i = strpos($h, 'fi-topbar');
if ($i !== false) {
    $potong = substr($h, $i - 200, 2500);
    // Rapikan
    $potong = preg_replace('/\s+/', ' ', $potong);
    echo wordwrap($potong, 150, "\n", true)."\n";
}

echo "\n=== potongan HTML sidebar header ===\n";
$i = strpos($h, 'fi-sidebar-header');
if ($i !== false) {
    $potong = substr($h, $i - 100, 1500);
    $potong = preg_replace('/\s+/', ' ', $potong);
    echo wordwrap($potong, 150, "\n", true)."\n";
}
