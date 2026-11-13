@use('App\Support\Format')
@use('App\Enums\StatusSpk')

<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    {{-- x-data harus di elemen DALAM layout: atribut pada komponen induk tidak diteruskan. --}}
    <div x-data="{
        modalBuka: false,
        modalTanggal: '',
        modalSpk: [],
        bukaDetailTanggal(tgl, items) {
            this.modalTanggal = tgl;
            this.modalSpk = items;
            this.modalBuka = true;
        }
    }">
    @php
        $kelasSelect = 'h-10 w-full min-w-0 max-w-full rounded-lg border border-gray-300 bg-white px-3 text-xs text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-500 sm:w-auto';
    @endphp

    {{-- Baris Navigasi & Ringkasan Bulan --}}
    <div class="mb-6 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
        <div class="flex min-w-0 flex-wrap items-center gap-3">
            <div class="inline-flex shrink-0 rounded-xl border border-gray-200 bg-white p-1 shadow-theme-xs dark:border-gray-800 dark:bg-white/[0.03]">
                <a href="{{ route('panel.spk.calendar', array_filter(['bulan' => $prevBulan, 'mitra_id' => $mitraId, 'status_spk' => $statusSpk])) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                    title="Bulan sebelumnya" aria-label="Bulan sebelumnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <a href="{{ route('panel.spk.calendar', array_filter(['bulan' => now()->format('Y-m'), 'mitra_id' => $mitraId, 'status_spk' => $statusSpk])) }}"
                    class="inline-flex h-9 items-center px-3 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                    Hari Ini
                </a>
                <a href="{{ route('panel.spk.calendar', array_filter(['bulan' => $nextBulan, 'mitra_id' => $mitraId, 'status_spk' => $statusSpk])) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"
                    title="Bulan berikutnya" aria-label="Bulan berikutnya">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </a>
            </div>
            <h3 class="min-w-0 text-lg font-bold text-gray-900 dark:text-white sm:text-xl">
                {{ $tanggalAktif->translatedFormat('F Y') }}
            </h3>

            {{-- Form Filter Mitra dan Status SPK --}}
            <form method="GET" action="{{ route('panel.spk.calendar') }}" class="flex w-full min-w-0 flex-wrap items-center gap-2 sm:w-auto">
                <input type="hidden" name="bulan" value="{{ $tanggalAktif->format('Y-m') }}">

                <label class="sr-only" for="tanggal">Tanggal Tenggat</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ $tanggalFilter ?? '' }}"
                    onchange="this.form.submit()"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-theme-xs text-gray-800 shadow-theme-xs focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 sm:w-40">

                <label class="sr-only" for="mitra_id">Filter Mitra</label>
                <select id="mitra_id" name="mitra_id" onchange="this.form.submit()" class="{{ $kelasSelect }}">
                    <option value="">Semua Mitra</option>
                    @foreach ($daftarMitra as $m)
                        <option value="{{ $m->id }}" @selected((string) $mitraId === (string) $m->id)>{{ $m->nama }}</option>
                    @endforeach
                </select>

                <label class="sr-only" for="status_spk">Filter Status SPK</label>
                <select id="status_spk" name="status_spk" onchange="this.form.submit()" class="{{ $kelasSelect }}">
                    <option value="">Semua Status</option>
                    @foreach ($opsiStatus as $nilai => $label)
                        <option value="{{ $nilai }}" @selected($statusSpk === $nilai)>{{ $label }}</option>
                    @endforeach
                </select>

                @if ($mitraId || $statusSpk)
                    <a href="{{ route('panel.spk.calendar', ['bulan' => $tanggalAktif->format('Y-m')]) }}"
                        class="inline-flex h-10 items-center px-2.5 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                        title="Reset Filter">
                        Reset
                    </a>
                @endif
            </form>
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
                Selesai: <strong class="font-bold text-success-700 dark:text-success-400">{{ $statistik['selesai'] }}</strong>
            </span>
        </div>
    </div>

    {{-- Grid Kalender --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-theme-xs">
        {{-- Header Hari --}}
        <div class="grid grid-cols-7 border-b border-gray-100 bg-gray-50/70 text-center text-[10px] font-semibold uppercase tracking-normal text-gray-500 sm:text-xs sm:tracking-wider dark:border-gray-800 dark:bg-white/[0.02] dark:text-gray-400">
            <div class="py-2 sm:py-3">Sen</div>
            <div class="py-2 sm:py-3">Sel</div>
            <div class="py-2 sm:py-3">Rab</div>
            <div class="py-2 sm:py-3">Kam</div>
            <div class="py-2 sm:py-3">Jum</div>
            <div class="py-2 sm:py-3">Sab</div>
            <div class="py-2 sm:py-3">Min</div>
        </div>

        {{-- Grid Kotak Tanggal --}}
        <div class="grid grid-cols-7 divide-x divide-y divide-gray-100 dark:divide-gray-800">
            {{-- Kotak Kosong Sebelum Hari Pertama --}}
            @for ($i = 1; $i < $startDayOfWeek; $i++)
                <div class="min-h-[84px] bg-gray-50/30 p-1 sm:min-h-[110px] sm:p-2 dark:bg-white/[0.01]"></div>
            @endfor

            {{-- Tanggal-Tanggal di Bulan Aktif --}}
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $tanggalLoop = $tanggalAktif->copy()->day($day)->toDateString();
                    $isToday = $tanggalLoop === now()->toDateString();
                    $spkHariIni = $spkPerTanggal->get($tanggalLoop, collect());
                @endphp
                <div class="min-h-[84px] min-w-0 overflow-hidden p-1 transition-colors hover:bg-gray-50/50 sm:min-h-[110px] sm:p-2 dark:hover:bg-white/[0.02] {{ $isToday ? 'bg-brand-50/20 dark:bg-brand-500/5' : '' }}">
                    <div class="flex items-center justify-between gap-1">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full text-[11px] font-bold sm:h-6 sm:w-6 sm:text-xs {{ $isToday ? 'bg-brand-500 text-white' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $day }}
                        </span>
                        @if ($spkHariIni->isNotEmpty())
                            <span class="rounded bg-gray-100 px-1 text-[10px] font-semibold text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                {{ $spkHariIni->count() }}
                            </span>
                        @endif
                    </div>

                    {{-- Daftar SPK Tenggat Hari Ini (Maks 2 chip agar simetris) --}}
                    @php
                        $spkPayload = $spkHariIni->map(fn($item) => [
                            'id' => $item->id,
                            'nomor' => $item->nomor_spk,
                            'pekerjaan' => $item->nama_pekerjaan,
                            'mitra' => $item->mitra?->nama ?? '-',
                            'nilai' => Format::rupiah($item->nilai_spk),
                            'status' => $item->status_spk?->label() ?? 'Draft',
                            'url' => route('panel.spk.show', ['spk' => $item, 'asal' => 'calendar']),
                            'is_selesai' => $item->sudahSelesai(),
                            'is_lewat' => $item->tanggal_akhir < now()->startOfDay() && !$item->sudahSelesai(),
                        ])->values();
                    @endphp
                    <div class="mt-1.5 space-y-1">
                        @foreach ($spkHariIni->take(2) as $spk)
                            @php
                                $isSelesai = $spk->sudahSelesai();
                                $isLewat = $spk->tanggal_akhir < now()->startOfDay() && !$isSelesai;
                                $warnaBadge = $isSelesai ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400 border-success-200 dark:border-success-500/30' : ($isLewat ? 'bg-error-50 text-error-700 dark:bg-error-500/20 dark:text-error-400 border-error-200 dark:border-error-500/30' : 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 border-brand-200 dark:border-brand-500/30');
                            @endphp
                            <a href="{{ route('panel.spk.show', ['spk' => $spk, 'asal' => 'calendar']) }}"
                                class="block truncate rounded-md border px-1 py-0.5 text-[10px] font-semibold transition hover:opacity-80 sm:px-1.5 sm:text-[11px] {{ $warnaBadge }}"
                                title="{{ $spk->nomor_spk }} : {{ $spk->nama_pekerjaan }} ({{ Format::rupiah($spk->nilai_spk) }})">
                                {{ $spk->nomor_spk }}
                            </a>
                        @endforeach

                        @if ($spkHariIni->count() > 2)
                            <button type="button"
                                @click="bukaDetailTanggal('{{ \Carbon\Carbon::parse($tanggalLoop)->translatedFormat('d F Y') }}', {{ json_encode($spkPayload) }})"
                                class="w-full text-center block rounded bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 py-0.5 text-[10px] font-bold text-gray-700 dark:text-gray-300 transition">
                                +{{ $spkHariIni->count() - 2 }} lainnya
                            </button>
                        @endif
                    </div>
                </div>
            @endfor

            {{-- Kotak Kosong Setelah Akhir Bulan untuk Mengisi Baris Terakhir --}}
            @php
                $totalCells = ($startDayOfWeek - 1) + $daysInMonth;
                $remainingCells = (7 - ($totalCells % 7)) % 7;
            @endphp
            @for ($i = 0; $i < $remainingCells; $i++)
                <div class="min-h-[84px] bg-gray-50/30 p-1 sm:min-h-[110px] sm:p-2 dark:bg-white/[0.01]"></div>
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
            {{-- Tampilan Kartu (Mobile ≤ md): tanpa scroll horizontal --}}
            <ul class="divide-y divide-gray-100 md:hidden dark:divide-gray-800">
                @foreach ($spkList as $s)
                    @php
                        $lewat = $s->tanggal_akhir < now()->startOfDay() && ! $s->sudahSelesai();
                    @endphp
                    <li class="py-3">
                        <div class="flex min-w-0 items-start justify-between gap-2">
                            <a href="{{ route('panel.spk.show', ['spk' => $s, 'asal' => 'calendar']) }}"
                                class="min-w-0 break-all text-theme-sm font-semibold text-brand-600 hover:underline dark:text-brand-400">
                                {{ $s->nomor_spk }}
                            </a>
                            <span class="inline-flex shrink-0 rounded px-2 py-0.5 text-[11px] font-semibold {{ $s->sudahSelesai() ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                                {{ $s->status_spk?->label() ?? 'Draft' }}
                            </span>
                        </div>
                        <p class="mt-1 break-words text-theme-xs text-gray-700 dark:text-gray-300">{{ $s->nama_pekerjaan }}</p>
                        <p class="mt-1 text-theme-xs text-gray-500 dark:text-gray-400">{{ $s->mitra?->nama ?? '-' }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center justify-between gap-2 text-theme-xs">
                            <span class="font-semibold {{ $lewat ? 'text-error-600 dark:text-error-400' : 'text-gray-700 dark:text-gray-300' }}">
                                Tenggat {{ $s->tanggal_akhir?->format('d/m/Y') }}
                            </span>
                            <span class="angka font-semibold text-gray-900 dark:text-white">{{ Format::rupiah($s->nilai_spk) }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="hidden overflow-x-auto md:block">
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
                                <td class="py-2.5 px-3 min-w-[18rem] whitespace-normal break-words">{{ $s->nama_pekerjaan }}</td>
                                <td class="py-2.5 px-3 whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $s->mitra?->nama ?? '-' }}</td>
                                <td class="py-2.5 px-3 whitespace-nowrap text-right font-semibold angka">{{ Format::rupiah($s->nilai_spk) }}</td>
                                <td class="py-2.5 px-3 whitespace-nowrap text-right">
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

    {{-- Modal Popover / Drawer Ringkas Tanggal --}}
    <div x-show="modalBuka" x-cloak
        class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-xs"
        @keydown.escape.window="modalBuka = false">
        <div class="w-full max-w-lg rounded-2xl border border-gray-200 bg-white p-5 shadow-2xl dark:border-gray-800 dark:bg-gray-900"
            @click.outside="modalBuka = false">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">SPK Jatuh Tempo</h3>
                    <p class="text-theme-xs text-gray-500 dark:text-gray-400" x-text="modalTanggal"></p>
                </div>
                <button @click="modalBuka = false" class="rounded-lg p-1 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:text-gray-500 hover:text-gray-700 dark:hover:bg-gray-800 dark:hover:text-gray-200">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="mt-4 max-h-[60vh] space-y-2.5 overflow-y-auto pr-1">
                <template x-for="item in modalSpk" :key="item.id">
                    <div class="rounded-xl border border-gray-100 bg-gray-50/60 p-3.5 transition hover:border-brand-300 dark:border-gray-800 dark:bg-white/[0.02]">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <a :href="item.url" class="font-bold text-sm text-brand-600 hover:underline dark:text-brand-400" x-text="item.nomor"></a>
                                <p class="text-xs text-gray-700 dark:text-gray-300 mt-0.5 line-clamp-1" x-text="item.pekerjaan"></p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5" x-text="'Mitra: ' + item.mitra"></p>
                            </div>
                            <span class="inline-flex rounded px-2 py-0.5 text-[11px] font-semibold"
                                :class="item.is_selesai ? 'bg-success-50 text-success-700 dark:bg-success-500/20 dark:text-success-400' : (item.is_lewat ? 'bg-error-50 text-error-700 dark:bg-error-500/20 dark:text-error-400' : 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400')"
                                x-text="item.status"></span>
                        </div>
                        <div class="mt-2.5 flex items-center justify-between border-t border-gray-100 pt-2 text-xs dark:border-gray-800">
                            <span class="font-bold text-gray-900 dark:text-white" x-text="item.nilai"></span>
                            <a :href="item.url" class="inline-flex items-center gap-1 font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400">
                                Buka Detail
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    </div>
</x-layouts.app>
