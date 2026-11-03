@use('App\Support\Format')
@use('App\Enums\StatusSpk')

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    {{-- Baris Navigasi & Ringkasan Bulan --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="inline-flex rounded-xl border border-gray-200 bg-white p-1 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
                <a href="{{ route('panel.spk.calendar', ['bulan' => $prevBulan]) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                    title="Bulan sebelumnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <a href="{{ route('panel.spk.calendar', ['bulan' => now()->format('Y-m')]) }}"
                    class="inline-flex h-9 items-center px-3 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                    Hari Ini
                </a>
                <a href="{{ route('panel.spk.calendar', ['bulan' => $nextBulan]) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                    title="Bulan berikutnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ $tanggalAktif->translatedFormat('F Y') }}
            </h3>
        </div>

        {{-- Statistik Bulan Ini --}}
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 shadow-theme-xs">
                <span class="h-2 w-2 rounded-full bg-brand-500"></span>
                Total: <strong class="font-bold text-gray-900 dark:text-white">{{ $statistik['total'] }} SPK</strong>
            </span>
            <span class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 shadow-theme-xs">
                <span class="h-2 w-2 rounded-full bg-error-500"></span>
                Lewat: <strong class="font-bold text-error-600 dark:text-error-400">{{ $statistik['lewat'] }}</strong>
            </span>
            <span class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 shadow-theme-xs">
                <span class="h-2 w-2 rounded-full bg-success-500"></span>
                Selesai: <strong class="font-bold text-success-600 dark:text-success-400">{{ $statistik['selesai'] }}</strong>
            </span>
        </div>
    </div>

    {{-- Grid Kalender --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
        {{-- Header Hari --}}
        <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50/70 text-center text-xs font-semibold uppercase tracking-wider text-gray-500 dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
            <div class="py-3">Sen</div>
            <div class="py-3">Sel</div>
            <div class="py-3">Rab</div>
            <div class="py-3">Kam</div>
            <div class="py-3">Jum</div>
            <div class="py-3">Sab</div>
            <div class="py-3">Min</div>
        </div>

        {{-- Grid Kotak Tanggal --}}
        <div class="grid grid-cols-7 divide-x divide-y divide-gray-100 dark:divide-gray-800">
            {{-- Kotak Kosong Sebelum Hari Pertama --}}
            @for ($i = 1; $i < $startDayOfWeek; $i++)
                <div class="min-h-[110px] bg-gray-50/30 p-2 dark:bg-white/[0.01]"></div>
            @endfor

            {{-- Tanggal-Tanggal di Bulan Aktif --}}
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $tanggalLoop = $tanggalAktif->copy()->day($day)->toDateString();
                    $isToday = $tanggalLoop === now()->toDateString();
                    $spkHariIni = $spkPerTanggal->get($tanggalLoop, collect());
                @endphp
                <div class="min-h-[110px] p-2 hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors {{ $isToday ? 'bg-brand-50/20 dark:bg-brand-500/5' : '' }}">
                    <div class="flex items-center justify-between">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold {{ $isToday ? 'bg-brand-500 text-white' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $day }}
                        </span>
                        @if ($spkHariIni->isNotEmpty())
                            <span class="rounded bg-gray-100 px-1 text-[10px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ $spkHariIni->count() }}
                            </span>
                        @endif
                    </div>

                    {{-- Daftar SPK Tenggat Hari Ini --}}
                    <div class="mt-1.5 space-y-1">
                        @foreach ($spkHariIni as $spk)
                            @php
                                $isSelesai = $spk->sudahSelesai();
                                $isLewat = $spk->tanggal_akhir < now()->startOfDay() && !$isSelesai;
                                $warnaBadge = $isSelesai ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400 border-success-200 dark:border-success-500/30' : ($isLewat ? 'bg-error-50 text-error-700 dark:bg-error-500/20 dark:text-error-400 border-error-200 dark:border-error-500/30' : 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 border-brand-200 dark:border-brand-500/30');
                            @endphp
                            <a href="{{ route('panel.spk.show', ['spk' => $spk, 'asal' => 'calendar']) }}"
                                class="block truncate rounded-md border px-1.5 py-0.5 text-[11px] font-semibold transition hover:opacity-80 {{ $warnaBadge }}"
                                title="{{ $spk->nomor_spk }} — {{ $spk->nama_pekerjaan }} ({{ Format::rupiah($spk->nilai_spk) }})">
                                {{ $spk->nomor_spk }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endfor

            {{-- Kotak Kosong Setelah Akhir Bulan untuk Mengisi Baris Terakhir --}}
            @php
                $totalCells = ($startDayOfWeek - 1) + $daysInMonth;
                $remainingCells = (7 - ($totalCells % 7)) % 7;
            @endphp
            @for ($i = 0; $i < $remainingCells; $i++)
                <div class="min-h-[110px] bg-gray-50/30 p-2 dark:bg-white/[0.01]"></div>
            @endfor
        </div>
    </div>

    {{-- Rincian Daftar SPK Bulan Ini --}}
    <div class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
        <h4 class="text-base font-bold text-gray-900 dark:text-white mb-4">
            Daftar SPK Jatuh Tempo {{ $tanggalAktif->translatedFormat('F Y') }}
        </h4>

        @if ($spkList->isEmpty())
            <p class="py-6 text-center text-xs text-gray-500 dark:text-gray-400">
                Tidak ada SPK yang jatuh tempo pada bulan ini.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-theme-sm">
                    <thead>
                        <tr class="border-b border-gray-100 text-theme-xs uppercase text-gray-500 dark:border-gray-800 dark:text-gray-400">
                            <th class="py-2.5 px-3">Tenggat</th>
                            <th class="py-2.5 px-3">Nomor SPK</th>
                            <th class="py-2.5 px-3">Pekerjaan</th>
                            <th class="py-2.5 px-3">Mitra</th>
                            <th class="py-2.5 px-3 text-right">Nilai SPK</th>
                            <th class="py-2.5 px-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($spkList as $s)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02]">
                                <td class="py-2.5 px-3 whitespace-nowrap font-semibold {{ $s->tanggal_akhir < now()->startOfDay() && ! $s->sudahSelesai() ? 'text-error-600 dark:text-error-400' : 'text-gray-700 dark:text-gray-300' }}">
                                    {{ $s->tanggal_akhir?->format('d/m/Y') }}
                                </td>
                                <td class="py-2.5 px-3">
                                    <a href="{{ route('panel.spk.show', ['spk' => $s, 'asal' => 'calendar']) }}" class="font-medium text-brand-600 hover:underline dark:text-brand-400">
                                        {{ $s->nomor_spk }}
                                    </a>
                                </td>
                                <td class="py-2.5 px-3 line-clamp-1 max-w-xs">{{ $s->nama_pekerjaan }}</td>
                                <td class="py-2.5 px-3 text-gray-500">{{ $s->mitra?->nama ?? '-' }}</td>
                                <td class="py-2.5 px-3 text-right font-semibold angka">{{ Format::rupiah($s->nilai_spk) }}</td>
                                <td class="py-2.5 px-3 text-right">
                                    <span class="inline-flex rounded px-2 py-0.5 text-xs font-semibold {{ $s->sudahSelesai() ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                        {{ $s->status_spk?->label() ?? 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
