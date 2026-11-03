{{--
    Wadah tiga menu monitoring SPK (Status / Tagihan / Selesai)
--}}
<x-layouts.app :judul="$judul" :keterangan="$keterangan">
    {{-- Tab Segmented Navigasi Monitoring --}}
    <div class="mb-5 flex flex-wrap items-center gap-2 border-b border-gray-200 dark:border-gray-800 pb-3">
        <a href="{{ route('panel.spk.monitoring', 'status') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ $mode === 'status' ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-white/[0.03] dark:border-gray-800 dark:text-gray-300' }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
            </svg>
            Status SPK (Progres Pekerjaan)
        </a>
        <a href="{{ route('panel.spk.monitoring', 'billing') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ $mode === 'billing' ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-white/[0.03] dark:border-gray-800 dark:text-gray-300' }}">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6H2.25m0 0v8.25m0 0a60.073 60.073 0 0 0 15.797 2.101c.727.198 1.453-.342 1.453-1.096V6.75A.75.75 0 0 0 18.75 6H18m-1.5-1.5H3.75" />
            </svg>
            Tagihan SPK (Antrean Penagihan)
        </a>
        <a href="{{ route('panel.spk.monitoring', 'completed') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ $mode === 'completed' ? 'bg-brand-500 text-white shadow-theme-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 dark:bg-white/[0.03] dark:border-gray-800 dark:text-gray-300' }}">
            <svg class="h-4 w-4 text-success-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Tagihan Selesai SPK (Arsip Lunas)
        </a>
    </div>

    <livewire:spk.monitoring-table :mode="$mode" />
</x-layouts.app>
