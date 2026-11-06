<?php

declare(strict_types=1);

use App\Enums\Peran;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashIn\CashInController;
use App\Http\Controllers\CashOut\CashOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Spk\IndexController as SpkIndexController;
use App\Http\Controllers\Spk\MonitoringController as SpkMonitoringController;
use App\Http\Controllers\Spk\SpkCalendarController;
use App\Http\Controllers\Spk\SpkController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\User\UserController;
use App\Models\Export;
use App\Models\Pengguna;
use App\Models\Spk;
use App\Models\UangMasuk;
use App\Services\LaporanEkspor;
use App\Support\ArsipNota;
use App\Support\Format;
use App\Support\Nota;
use App\Support\StatusBackup;
use App\Support\TandaTangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

// =========================================================================
// Rute Panel Utama (/panel) — Blade + Livewire 4 TailAdmin
// =========================================================================

Route::prefix('panel')->name('panel.')->group(function (): void {
    // Tamu
    Route::middleware('guest')->group(function (): void {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.attempt');
    });

    // Sesi Pengguna
    Route::middleware(['auth', 'peran:admin,direktur'])->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        // Profil Pengguna
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // SPK
        Route::get('spk', SpkIndexController::class)->name('spk.index');
        Route::get('spk/calendar', [SpkCalendarController::class, 'index'])->name('spk.calendar');
        Route::get('spk/monitoring/{mode}', SpkMonitoringController::class)->name('spk.monitoring');
        Route::middleware('peran:admin,direktur')->group(function (): void {
            Route::get('spk/create', [SpkController::class, 'create'])->name('spk.create');
            Route::post('spk', [SpkController::class, 'store'])->name('spk.store');
            Route::get('spk/{spk}/edit', [SpkController::class, 'edit'])->name('spk.edit');
            Route::put('spk/{spk}', [SpkController::class, 'update'])->name('spk.update');
            Route::delete('spk/{spk}', [SpkController::class, 'destroy'])->name('spk.destroy');
            Route::get('spk/{spk}/status', [SpkController::class, 'statusForm'])->name('spk.status');
            Route::put('spk/{spk}/status', [SpkController::class, 'statusUpdate'])->name('spk.status.update');
            Route::get('spk/{spk}/billing', [SpkController::class, 'billingForm'])->name('spk.billing');
            Route::put('spk/{spk}/billing', [SpkController::class, 'billingUpdate'])->name('spk.billing.update');
        });
        Route::get('spk/{spk}', [SpkController::class, 'show'])->name('spk.show');
        Route::get('spk/{spk}/termin-drawer', function (Spk $spk) {
            $uangMasuk = $spk->uangMasuk()->orderBy('tanggal', 'asc')->get();

            return response()->json([
                'nomor_spk' => $spk->nomor_spk,
                'pekerjaan' => $spk->nama_pekerjaan,
                'mitra' => $spk->mitra?->nama ?? 'Tanpa Mitra',
                'nilai_spk' => Format::rupiah($spk->nilai_spk),
                'total_masuk' => Format::rupiah((float) $spk->totalPenerimaan()),
                'sisa_piutang' => Format::rupiah((float) $spk->sisaTagih()),
                'status_tagihan' => $spk->status_tagihan?->label() ?? 'Belum Ditagihkan',
                'transaksi' => $uangMasuk->map(fn ($m) => [
                    'id' => $m->id,
                    'tanggal' => $m->tanggal?->format('d/m/Y') ?? '-',
                    'akun' => $m->akun?->label() ?? '-',
                    'keterangan' => $m->keterangan ?: 'Penerimaan Termin',
                    'jumlah' => Format::rupiah($m->jumlah),
                    'kuitansi_url' => route('panel.cash-in.kuitansi', $m),
                ]),
            ]);
        })->name('spk.termin-drawer');

        // Modul Uang Masuk
        Route::get('cash-in', [CashInController::class, 'index'])->name('cash-in.index');
        Route::middleware('peran:admin,direktur')->group(function (): void {
            Route::get('cash-in/create', [CashInController::class, 'create'])->name('cash-in.create');
            Route::post('cash-in', [CashInController::class, 'store'])->name('cash-in.store');
            Route::get('cash-in/{uangMasuk}/edit', [CashInController::class, 'edit'])->name('cash-in.edit');
            Route::put('cash-in/{uangMasuk}', [CashInController::class, 'update'])->name('cash-in.update');
            Route::delete('cash-in/{uangMasuk}', [CashInController::class, 'destroy'])->name('cash-in.destroy');
            Route::post('cash-in/{id}/restore', [CashInController::class, 'restore'])->name('cash-in.restore');
        });

        // Modul Uang Keluar
        Route::get('cash-out', [CashOutController::class, 'index'])->name('cash-out.index');
        Route::middleware('peran:admin,direktur')->group(function (): void {
            Route::get('cash-out/create', [CashOutController::class, 'create'])->name('cash-out.create');
            Route::get('cash-out/{uangKeluar}/edit', [CashOutController::class, 'edit'])->name('cash-out.edit');
            Route::delete('cash-out/{uangKeluar}', [CashOutController::class, 'destroy'])->name('cash-out.destroy');
            Route::post('cash-out/{id}/restore', [CashOutController::class, 'restore'])->name('cash-out.restore');
        });

        // Modul Laporan & Nota
        Route::get('reports', ReportController::class)->name('reports');
        Route::get('receipts', [SystemController::class, 'receipts'])->name('receipts');
        Route::get('receipts/upload', [SystemController::class, 'receiptsUpload'])->middleware('peran:admin,direktur')->name('receipts.upload');
        Route::redirect('exports', '/panel/reports')->name('exports');

        // Master Data Mitra
        Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');
        Route::middleware('peran:admin,direktur')->group(function (): void {
            Route::get('partners/create', [PartnerController::class, 'create'])->name('partners.create');
            Route::post('partners', [PartnerController::class, 'store'])->name('partners.store');
            Route::get('partners/{mitra}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
            Route::put('partners/{mitra}', [PartnerController::class, 'update'])->name('partners.update');
            Route::delete('partners/{mitra}', [PartnerController::class, 'destroy'])->name('partners.destroy');
        });

        // Sistem & Backup
        Route::middleware('peran:admin,direktur')->group(function (): void {
            Route::get('status', [SystemController::class, 'status'])->name('status');
            Route::get('system-status', [SystemController::class, 'status'])->name('system');
            Route::get('backup', [SystemController::class, 'backup'])->name('backup');
            Route::post('backup/run', [SystemController::class, 'backupRun'])->name('backup.run');
            Route::get('import', [SystemController::class, 'import'])->name('import');
            Route::post('import', [SystemController::class, 'importStore'])->name('import.store');
            Route::get('import/template', [SystemController::class, 'template'])->name('import.template');
        });
    });

    // Manajemen Pengguna (Khusus Direktur)
    Route::middleware(['auth', 'peran:direktur'])->group(function (): void {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{pengguna}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{pengguna}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{pengguna}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

// =========================================================================
// RUTE SISTEM INFORMASI SPK & KONTROL KEUANGAN (PT BKS)
// =========================================================================

// --- Pintu Masuk & Pengalihan ---
Route::get('/', fn () => redirect('/panel'))->name('beranda');
Route::redirect('/login', '/panel/login')->name('login');
Route::redirect('/signin', '/panel/login');
Route::redirect('/signup', '/panel/login');
Route::redirect('/profile', '/panel/profile');
Route::redirect('/dashboard', '/panel')->name('dashboard');
Route::redirect('/home', '/panel')->name('home');
Route::redirect('/admin', '/panel');
Route::redirect('/admin/dashboard', '/panel');
Route::redirect('/admin/login', '/panel/login');

// --- Penyaji Berkas Privat ---
Route::get('/admin/nota/{path}', function (string $path) {
    $bersih = str_replace('\\', '/', $path);
    abort_if(str_contains($bersih, '..') || str_starts_with($bersih, '/'), 404, 'Path tidak sah.');
    $disk = Storage::disk('nota');
    abort_unless($disk->exists($bersih), 404);

    return $disk->response($bersih);
})->middleware(['auth', 'peran:admin,direktur'])->where('path', '.*')->name('nota.lihat');

// --- Ekspor & Cetak Dokumen Resmi ---
$handlerEkspor = function (string $jenis, LaporanEkspor $ekspor) {
    abort_unless(in_array($jenis, ['spk', 'masuk', 'keluar', 'tenggat', 'piutang', 'buku-kas', 'buku-bank'], true), 404);
    $format = request()->string('format')->toString();
    $format = in_array($format, ['csv', 'xlsx', 'pdf'], true) ? $format : 'csv';
    $periode = request()->integer('periode', 12);
    $periode = in_array($periode, [1, 3, 12, 0], true) ? $periode : 12;

    return $ekspor->ekspor($jenis, $format, $periode);
};
Route::get('/panel/laporan/ekspor/{jenis}', $handlerEkspor)->middleware(['auth', 'peran:admin,direktur'])->name('laporan.ekspor');
Route::get('/admin/laporan/ekspor/{jenis}', $handlerEkspor)->middleware(['auth', 'peran:admin,direktur']);

$handlerBundel = function (LaporanEkspor $ekspor) {
    $periode = request()->integer('periode', 12);
    $periode = in_array($periode, [1, 3, 12, 0], true) ? $periode : 12;

    return $ekspor->bundelZip($periode);
};
Route::get('/panel/laporan/bundel-zip', $handlerBundel)->middleware(['auth', 'peran:admin,direktur'])->name('laporan.bundel');
Route::get('/admin/laporan/bundel-zip', $handlerBundel)->middleware(['auth', 'peran:admin,direktur']);

Route::get('/panel/spk/{spk}/bast-pdf', function (Spk $spk) {
    $direktur = Pengguna::where('peran', Peran::Direktur)->first();
    $pdf = Pdf::loadView('reports.bast-pdf', [
        'spk' => $spk->load('mitra'),
        'direkturUser' => $direktur,
        'tandaTangan' => TandaTangan::untukPdf(),
    ])->setPaper('a4', 'portrait');

    return $pdf->stream('bast-'.str($spk->nomor_spk)->slug().'.pdf');
})->middleware(['auth', 'peran:admin,direktur'])->name('panel.spk.bast');

Route::get('/panel/cash-in/{uangMasuk}/kuitansi', function (UangMasuk $uangMasuk) {
    $uangMasuk->loadMissing(['spk.mitra', 'spk', 'mitra']);
    $mitraNama = $uangMasuk->spk?->mitra?->nama ?? $uangMasuk->mitra?->nama ?? 'PT PLN Batam';
    $nomorKuitansi = 'KW-'.($uangMasuk->tanggal?->format('Ymd') ?? now()->format('Ymd')).'-'.str_pad((string) $uangMasuk->id, 4, '0', STR_PAD_LEFT);
    $terbilang = Format::terbilang($uangMasuk->jumlah);

    $pdf = Pdf::loadView('reports.kuitansi-pdf', [
        'uangMasuk' => $uangMasuk,
        'spk' => $uangMasuk->spk,
        'mitraNama' => $mitraNama,
        'nomorKuitansi' => $nomorKuitansi,
        'terbilang' => $terbilang,
        'tandaTangan' => TandaTangan::untukPdf(),
    ]);

    return $pdf->download('kuitansi-'.strtolower($nomorKuitansi).'.pdf');
})->middleware(['auth', 'peran:admin,direktur'])->name('panel.cash-in.kuitansi');

// --- Unduh Backup & Arsip Nota ---
$handlerBackup = function (string $nama) {
    abort_unless(in_array(auth()->user()?->peran, [Peran::Admin, Peran::Direktur], true), 403);
    $path = StatusBackup::pathAman($nama);
    abort_if($path === null || ! is_file($path), 404);

    return response()->download($path, basename($path), ['Content-Type' => 'application/zip']);
};
Route::get('/panel/backup/unduh/{nama}', $handlerBackup)->middleware(['auth', 'peran:admin,direktur'])->name('backup.unduh');
Route::get('/admin/backup/unduh/{nama}', $handlerBackup)->middleware(['auth', 'peran:admin,direktur']);

$handlerArsipUnduh = function () {
    $path = base64_decode((string) request('path'), true);
    $nama = (string) request('nama', 'nota');
    abort_if($path === false || blank($path), 404);
    abort_unless(Nota::ada($path), 404);
    $nama = str_replace(['/', '\\', '..'], '', $nama) ?: 'nota';

    return Storage::disk('nota')->download($path, $nama);
};
Route::get('/panel/arsip-nota/unduh', $handlerArsipUnduh)->middleware(['auth', 'peran:admin,direktur'])->name('arsip-nota.unduh');
Route::get('/admin/arsip-nota/unduh', $handlerArsipUnduh)->middleware(['auth', 'peran:admin,direktur']);

$handlerArsipZip = function () {
    $tgl = request()->string('tgl')->toString() ?: request()->string('dari')->toString() ?: null;
    $filter = [
        'tanggal_awal' => $tgl,
        'tanggal_akhir' => $tgl ?: (request()->string('sampai')->toString() ?: null),
        'akun' => request()->string('akun')->toString() ?: null,
        'kategori' => request()->string('kategori')->toString() ?: null,
        'q' => request()->string('q')->toString() ?: null,
    ];
    $arsip = ArsipNota::cari($filter);
    $ukuran = ArsipNota::hitungUkuran($arsip);
    $maksBerkas = (int) config('filesystems.arsip_zip_maks_berkas', 1000);
    $maksByte = (int) config('filesystems.arsip_zip_maks_byte', 500 * 1024 * 1024);

    // Tolak SEBELUM ZIP dibangun: membungkus 1.800 berkas butuh waktu & ruang
    // temp besar, sementara pengguna bisa menyaring dulu.
    if ($ukuran['berkas'] > $maksBerkas || $ukuran['byte'] > $maksByte) {
        return back()->with('gagal', sprintf(
            'Arsip terlalu besar untuk diunduh sekaligus (%s berkas, %s MB). Saring dulu berdasarkan tanggal, akun, atau kata kunci — maksimal %s berkas / %s MB per unduhan.',
            number_format($ukuran['berkas'], 0, ',', '.'),
            number_format($ukuran['byte'] / 1048576, 1, ',', '.'),
            number_format($maksBerkas, 0, ',', '.'),
            number_format($maksByte / 1048576, 0, ',', '.'),
        ));
    }

    $zip = ArsipNota::buatZip($arsip);
    abort_if($zip === null, 404, 'Tidak ada berkas untuk diunduh.');

    return response()->download($zip, 'arsip-nota-'.now()->format('Y-m-d').'.zip', [
        'Content-Type' => 'application/zip',
    ])->deleteFileAfterSend(true);
};
Route::get('/panel/arsip-nota/zip', $handlerArsipZip)->middleware(['auth', 'peran:admin,direktur'])->name('arsip-nota.zip');
Route::get('/admin/arsip-nota/zip', $handlerArsipZip)->middleware(['auth', 'peran:admin,direktur']);

Route::get('/admin/ekspor-unduhan/{ekspor}/unduh', function (int $ekspor) {
    $user = auth()->user();
    $record = Export::findOrFail($ekspor);
    abort_unless($user->peran === Peran::Direktur || (int) $record->user_id === (int) $user->getKey(), 403);
    abort_if($record->completed_at === null || $record->file_name === null, 404, 'Ekspor belum selesai.');
    $path = $record->getFileDirectory().DIRECTORY_SEPARATOR.$record->file_name;
    abort_unless($record->getFileDisk()->exists($path), 404, 'Berkas tidak ditemukan.');

    return $record->getFileDisk()->download($path, $record->file_name);
})->middleware(['auth', 'peran:admin,direktur'])->name('ekspor.unduh');
