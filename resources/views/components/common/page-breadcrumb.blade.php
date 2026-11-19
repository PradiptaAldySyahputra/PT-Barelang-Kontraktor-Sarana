@props(['pageTitle' => 'Page', 'kembali' => null])

@php
    use Illuminate\Support\Str;

    $namaRute = request()->route()?->getName() ?? '';
    $kodeAsal = request()->string('asal')->toString();
    $spk = request()->route('spk');

    // Peta kode ?asal= yang dikenal. Kode di luar peta DIABAIKAN — nilai asal
    // tidak pernah dipakai mentah sebagai URL (cegah open redirect).
    $petaAsal = [
        'list' => ['List SPK', route('panel.spk.index')],
        'calendar' => ['Kalender Tenggat', route('panel.spk.calendar')],
        'status-spk' => ['Status SPK', route('panel.spk.monitoring', 'status')],
        'tagihan-spk' => ['Tagihan SPK', route('panel.spk.monitoring', 'billing')],
        'tagihan-selesai' => ['Tagihan Selesai SPK', route('panel.spk.monitoring', 'completed')],
    ];

    if ($spk !== null) {
        $petaAsal['show'] = ['Detail SPK', route('panel.spk.show', $spk)];
    }

    $asal = $petaAsal[$kodeAsal] ?? null;

    // Induk breadcrumb per modul (peta menu AGENTS.md §5), bukan default "Dashboard".
    // Halaman tunggal (dashboard, laporan, profil) tampil satu tingkat saja.
    $induk = null;

    if ($namaRute === 'panel.dashboard' || $namaRute === 'panel.reports' || $namaRute === 'panel.profile') {
        $induk = null;
    } elseif (str_starts_with($namaRute, 'panel.spk.monitoring')) {
        $induk = ['Monitoring SPK', route('panel.spk.monitoring', 'status')];
    } elseif (str_starts_with($namaRute, 'panel.spk.status')) {
        $induk = ($kodeAsal === 'show' && $asal !== null)
            ? $asal
            : ['Status SPK', route('panel.spk.monitoring', 'status')];
    } elseif (str_starts_with($namaRute, 'panel.spk.billing')) {
        $induk = ($kodeAsal === 'show' && $asal !== null)
            ? $asal
            : ['Tagihan SPK', route('panel.spk.monitoring', 'billing')];
    } elseif (str_starts_with($namaRute, 'panel.spk')) {
        $induk = in_array($namaRute, ['panel.spk.index', 'panel.spk.calendar'], true)
            ? ['SPK', route('panel.spk.index')]
            : ($asal ?? ['SPK', route('panel.spk.index')]);
    } elseif (str_starts_with($namaRute, 'panel.cash-in')) {
        $induk = $namaRute === 'panel.cash-in.index'
            ? ['Keuangan', route('panel.cash-in.index')]
            : ['Uang Masuk', route('panel.cash-in.index')];
    } elseif (str_starts_with($namaRute, 'panel.cash-out')) {
        $induk = $namaRute === 'panel.cash-out.index'
            ? ['Keuangan', route('panel.cash-in.index')]
            : ['Uang Keluar', route('panel.cash-out.index')];
    } elseif (str_starts_with($namaRute, 'panel.partners')) {
        $induk = $namaRute === 'panel.partners.index'
            ? ['Master Data', route('panel.partners.index')]
            : ['Mitra', route('panel.partners.index')];
    } elseif (str_starts_with($namaRute, 'panel.users')) {
        $induk = ['Pengguna', route('panel.users.index')];
    } elseif (str_starts_with($namaRute, 'panel.receipts')) {
        $induk = ['Nota & Bukti', route('panel.receipts')];
    } elseif (in_array($namaRute, ['panel.status', 'panel.system'], true)
        || str_starts_with($namaRute, 'panel.backup')) {
        $induk = ['Sistem', route('panel.status')];
    }

    // Jangan menduplikasi judul halaman pada breadcrumb.
    if ($induk !== null && $induk[0] === $pageTitle) {
        $induk = null;
    }

    // Tombol Kembali HANYA di halaman anak (detail/form/aksi), tidak pernah di halaman list.
    $ruteAnak = [
        'panel.spk.show', 'panel.spk.create', 'panel.spk.edit',
        'panel.spk.status', 'panel.spk.billing',
        'panel.cash-in.create', 'panel.cash-in.edit',
        'panel.cash-out.create', 'panel.cash-out.edit',
        'panel.partners.create', 'panel.partners.edit',
        'panel.users.create', 'panel.users.edit',
        'panel.receipts.upload',
    ];

    $tujuanKembali = null;

    if (in_array($namaRute, $ruteAnak, true)) {
        // 1) Tujuan dari controller, hanya bila URL internal panel.
        $calon = is_string($kembali) ? $kembali : '';
        $sah = $calon !== ''
            && ! Str::startsWith($calon, '//')
            && (Str::startsWith($calon, '/') || Str::startsWith($calon, url('/').'/'));

        if ($sah) {
            $tujuanKembali = $calon;
        }

        // 2) Peta ?asal= yang dikenal.
        if ($tujuanKembali === null && $asal !== null) {
            $tujuanKembali = $asal[1];
        }

        // 3) Path panel eksplisit (form mitra/pengguna).
        if ($tujuanKembali === null && Str::startsWith($kodeAsal, '/panel/') && ! Str::startsWith($kodeAsal, '//')) {
            $tujuanKembali = url($kodeAsal);
        }

        // 4) Halaman induk bawaan per modul.
        $tujuanKembali ??= match (true) {
            $namaRute === 'panel.spk.status' => route('panel.spk.monitoring', 'status'),
            $namaRute === 'panel.spk.billing' => route('panel.spk.monitoring', 'billing'),
            str_starts_with($namaRute, 'panel.spk') => route('panel.spk.index'),
            str_starts_with($namaRute, 'panel.cash-in') => route('panel.cash-in.index'),
            str_starts_with($namaRute, 'panel.cash-out') => route('panel.cash-out.index'),
            str_starts_with($namaRute, 'panel.partners') => route('panel.partners.index'),
            str_starts_with($namaRute, 'panel.users') => route('panel.users.index'),
            default => route('panel.receipts'),
        };
    }
@endphp

<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div class="flex items-center gap-3">
        @if ($tujuanKembali)
            <a
                href="{{ $tujuanKembali }}"
                data-nav-kembali
                class="inline-flex items-center gap-1.5 rounded-xl border border-gray-200 bg-white px-3.5 py-2 text-xs font-semibold text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-900 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-300 dark:hover:bg-white/[0.06] dark:hover:text-white transition-colors"
                title="Kembali"
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
    @if ($induk !== null)
        <nav data-nav-breadcrumb aria-label="Breadcrumb">
            <ol class="flex items-center gap-1.5 text-xs sm:text-sm">
                <li>
                    <a data-nav-induk href="{{ $induk[1] }}" class="text-gray-500 dark:text-gray-400 hover:text-brand-500 transition-colors">
                        {{ $induk[0] }}
                    </a>
                </li>
                <li class="flex items-center gap-1.5 text-gray-800 dark:text-white/90 font-medium">
                    <svg class="stroke-current rtl:rotate-180 text-gray-500 dark:text-gray-400" width="14" height="14" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span data-nav-halaman class="truncate max-w-[200px] sm:max-w-xs md:max-w-md lg:max-w-none">{{ $pageTitle }}</span>
                </li>
            </ol>
        </nav>
    @endif
</div>