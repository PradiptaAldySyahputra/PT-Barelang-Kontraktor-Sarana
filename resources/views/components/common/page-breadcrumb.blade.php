@props(['pageTitle' => 'Page', 'kembali' => null])

@php
    // Tombol Back HANYA tampil di halaman detail/preview dan form (create/edit/status/billing),
    // TIDAK tampil di menu list/tabel utama seperti List SPK, List Uang Masuk, dsb.
    $isChildPage = !empty($kembali) || request()->routeIs([
        '*.show',
        '*.create',
        '*.edit',
        'panel.spk.status',
        'panel.spk.billing',
        'panel.receipts.upload',
    ]);

    // Deteksi konteks parent menu untuk breadcrumb yang akurat
    $parentNama = 'Dashboard';
    $parentUrl = route('panel.dashboard');
    $asalParam = request()->string('asal')->toString();

    if (request()->routeIs(['panel.spk.status'])) {
        $parentNama = $asalParam === 'show' ? 'Detail SPK' : 'Status SPK';
        $parentUrl = $kembali ?? route('panel.spk.monitoring', 'status');
    } elseif (request()->routeIs(['panel.spk.billing'])) {
        $parentNama = $asalParam === 'show' ? 'Detail SPK' : 'Tagihan SPK';
        $parentUrl = $kembali ?? route('panel.spk.monitoring', 'billing');
    } elseif (request()->routeIs(['panel.spk.*', 'spk.*'])) {
        $parentNama = match ($asalParam) {
            'status-spk' => 'Status SPK',
            'tagihan-spk' => 'Tagihan SPK',
            'tagihan-selesai' => 'Tagihan Selesai SPK',
            'calendar' => 'Kalender Tenggat',
            default => 'SPK',
        };
        $parentUrl = $kembali ?? route('panel.spk.index');
    } elseif (request()->routeIs(['panel.cash-in.*', 'cash-in.*'])) {
        $parentNama = 'Uang Masuk';
        $parentUrl = route('panel.cash-in.index');
    } elseif (request()->routeIs(['panel.cash-out.*', 'cash-out.*'])) {
        $parentNama = 'Uang Keluar';
        $parentUrl = route('panel.cash-out.index');
    } elseif (request()->routeIs(['panel.partners.*', 'partners.*'])) {
        $parentNama = 'Mitra';
        $parentUrl = route('panel.partners.index');
    } elseif (request()->routeIs(['panel.users.*', 'users.*'])) {
        $parentNama = 'Pengguna';
        $parentUrl = route('panel.users.index');
    } elseif (request()->routeIs(['panel.reports', 'reports.*'])) {
        $parentNama = 'Laporan';
        $parentUrl = route('panel.reports');
    } elseif (request()->routeIs(['panel.status', 'panel.backup', 'panel.import'])) {
        $parentNama = 'Sistem';
        $parentUrl = route('panel.status');
    } elseif (request()->routeIs(['panel.receipts*', 'receipts.*'])) {
        $parentNama = 'Nota & Bukti';
        $parentUrl = route('panel.receipts');
    }
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        @if ($isChildPage)
            <a
                href="{{ $kembali ?? url()->previous() }}"
                class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-900 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.06] dark:hover:text-white transition-colors"
                title="Kembali ke halaman sebelumnya"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
        @endif
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            {{ $pageTitle }}
        </h2>
    </div>
            <nav aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5 text-xs sm:text-sm">
                    <li>
                        <a href="{{ $parentUrl }}" class="text-gray-500 dark:text-gray-400 hover:text-brand-500 transition-colors">
                            {{ $parentNama }}
                        </a>
                    </li>
                    <li class="flex items-center gap-1.5 text-gray-800 dark:text-white/90 font-medium">
                        <svg class="stroke-current rtl:rotate-180 text-gray-400" width="14" height="14" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>{{ $pageTitle }}</span>
                    </li>
                </ol>
            </nav>
</div>
