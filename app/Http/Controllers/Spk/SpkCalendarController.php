<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spk;

use App\Enums\StatusSpk;
use App\Models\Mitra;
use App\Models\Spk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class SpkCalendarController
{
    public function index(Request $request): View
    {
        $bulanParam = $request->query('bulan');
        $mitraId = $request->query('mitra_id');
        $statusSpk = $request->query('status_spk');
        $tanggalParam = $request->query('tanggal');

        // Satu tanggal (bukan rentang): lompat ke bulan tanggal itu sekaligus
        // menyaring pekerjaan yang jatuh tempo tepat pada tanggal tersebut.
        $tanggalFilter = null;
        if (is_string($tanggalParam) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggalParam)) {
            try {
                $tanggalFilter = Carbon::parse($tanggalParam)->startOfDay();
            } catch (\Throwable) {
                $tanggalFilter = null;
            }
        }

        // Validasi regex YYYY-MM dan try-catch fallback aman ke now()->startOfMonth()
        $tanggalAktif = now()->startOfMonth();
        if (is_string($bulanParam) && preg_match('/^\d{4}-\d{2}$/', $bulanParam)) {
            try {
                $tanggalAktif = Carbon::parse($bulanParam.'-01')->startOfMonth();
            } catch (\Throwable) {
                $tanggalAktif = now()->startOfMonth();
            }
        }

        if ($tanggalFilter !== null) {
            $tanggalAktif = $tanggalFilter->copy()->startOfMonth();
        }

        $awalBulan = $tanggalAktif->copy()->startOfMonth();
        $akhirBulan = $tanggalAktif->copy()->endOfMonth();

        // Ambil semua SPK yang tenggatnya jatuh pada bulan ini sesuai filter
        $spkList = Spk::query()
            ->with(['mitra:id,nama'])
            ->whereNotNull('tanggal_akhir')
            ->whereBetween('tanggal_akhir', [$awalBulan->toDateString(), $akhirBulan->toDateString()])
            ->when($mitraId, fn ($q) => $q->where('mitra_id', $mitraId))
            ->when($statusSpk, fn ($q) => $q->where('status_spk', $statusSpk))
            ->when($tanggalFilter !== null, fn ($q) => $q->whereDate('tanggal_akhir', $tanggalFilter->toDateString()))
            ->orderBy('tanggal_akhir', 'asc')
            ->get();

        // Kelompokkan per tanggal: 'YYYY-MM-DD' => Collection<Spk>
        $spkPerTanggal = $spkList->groupBy(fn (Spk $s) => $s->tanggal_akhir?->toDateString());

        // Statistik bulan ini
        $totalSpk = $spkList->count();
        $totalNilai = (float) $spkList->sum('nilai_spk');
        $lewatCount = $spkList->filter(fn (Spk $s) => $s->tanggal_akhir < now()->startOfDay() && ! $s->sudahSelesai())->count();
        $selesaiCount = $spkList->filter(fn (Spk $s) => $s->sudahSelesai())->count();

        // Hitung grid kalender (hari pertama mulai Senin)
        $startDayOfWeek = $awalBulan->dayOfWeekIso; // 1 (Senin) .. 7 (Minggu)
        $daysInMonth = $awalBulan->daysInMonth;

        return view('spk.calendar', [
            'judul' => 'Kalender Tenggat SPK',
            'keterangan' => 'Visualisasi batas waktu dan penyelesaian pekerjaan bulanan',
            'tanggalAktif' => $tanggalAktif,
            'awalBulan' => $awalBulan,
            'akhirBulan' => $akhirBulan,
            'startDayOfWeek' => $startDayOfWeek,
            'daysInMonth' => $daysInMonth,
            'spkPerTanggal' => $spkPerTanggal,
            'spkList' => $spkList,
            'statistik' => [
                'total' => $totalSpk,
                'nilai' => $totalNilai,
                'lewat' => $lewatCount,
                'selesai' => $selesaiCount,
            ],
            'prevBulan' => $tanggalAktif->copy()->subMonth()->format('Y-m'),
            'nextBulan' => $tanggalAktif->copy()->addMonth()->format('Y-m'),
            'mitraId' => $mitraId,
            'statusSpk' => $statusSpk,
            'tanggalFilter' => $tanggalFilter?->toDateString(),
            'daftarMitra' => Mitra::orderBy('nama')->get(['id', 'nama']),
            'opsiStatus' => StatusSpk::opsiProgres(),
        ]);
    }
}
