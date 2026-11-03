<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spk;

use App\Models\Spk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class SpkCalendarController
{
    public function index(Request $request): View
    {
        $bulanParam = $request->query('bulan');
        // Gunakan '-01' untuk mencegah overflow hari pada bulan yang memiliki < 31 hari
        $tanggalAktif = $bulanParam ? Carbon::parse($bulanParam . '-01')->startOfMonth() : now()->startOfMonth();

        $awalBulan = $tanggalAktif->copy()->startOfMonth();
        $akhirBulan = $tanggalAktif->copy()->endOfMonth();

        // Ambil semua SPK yang tenggatnya jatuh pada bulan ini
        $spkList = Spk::query()
            ->with(['mitra:id,nama'])
            ->whereNotNull('tanggal_akhir')
            ->whereBetween('tanggal_akhir', [$awalBulan->toDateString(), $akhirBulan->toDateString()])
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
        ]);
    }
}
