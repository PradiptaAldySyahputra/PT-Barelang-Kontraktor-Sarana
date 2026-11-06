<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Peran;
use App\Support\DashboardSummary;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Dashboard panel (/panel) - satu rute, DUA tampilan per peran
 * (lihat Design.md bagian diferensiasi peran):
 *
 *   Direktur -> director.dashboard : eksekutif, read-only.
 *   Admin    -> admin.dashboard    : operasional, aksi cepat.
 *
 * Semua angka berasal dari App\Support\DashboardSummary, satu sumber yang
 * sama untuk kedua varian dashboard.
 */
final class DashboardController
{
    public function __invoke(Request $request): View
    {
        $isDirector = $request->user()?->peran === Peran::Direktur;

        return view($isDirector ? 'director.dashboard' : 'admin.dashboard', [
            'judul' => $isDirector ? 'Dashboard Direktur' : 'Dashboard Operasional',
            'keterangan' => $isDirector
                ? 'Ringkasan posisi pekerjaan, piutang, dan arus kas'
                : 'Posisi kas hari ini dan pekerjaan yang menunggu',
            'data' => $isDirector
                ? DashboardSummary::eksekutif()
                : DashboardSummary::operasional(),
        ]);
    }
}
