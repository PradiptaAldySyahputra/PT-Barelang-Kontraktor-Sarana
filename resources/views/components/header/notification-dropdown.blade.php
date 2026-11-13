@php
    $notif = \App\Support\NotifikasiOperasional::ambil();
    $total = $notif['total'];
    $jumlah = $notif['jumlah'];
    $daftar = $notif['daftar'];
@endphp

{{--
    Notifikasi lintas modul: pekerjaan, tagihan, keuangan.
    Hanya satu panel header yang boleh terbuka (lihat Alpine.store('panelMenu') di app-header),
    supaya panel notifikasi dan menu profil tidak terbuka bersamaan saat kursor lewat.
--}}
<div class="relative" x-data="{
        isOpen: false,
        tab: 'semua',
        hoverTimeout: null,
        init() {
            // Panel lain yang dibuka (mis. profil) menutup panel ini.
            this.$watch(() => Alpine.store('panelMenu')?.aktif, (aktif) => {
                if (aktif && aktif !== 'notif') { clearTimeout(this.hoverTimeout); this.isOpen = false; }
            });
        },
        openMenu() {
            clearTimeout(this.hoverTimeout);
            this.isOpen = true;
            const store = Alpine.store('panelMenu');
            if (store) { store.aktif = 'notif'; }
        },
        closeMenuWithDelay() {
            this.hoverTimeout = setTimeout(() => {
                this.isOpen = false;
                const store = Alpine.store('panelMenu');
                if (store && store.aktif === 'notif') { store.aktif = null; }
            }, 250);
        },
        togglePanel() {
            this.isOpen = !this.isOpen;
            const store = Alpine.store('panelMenu');
            if (this.isOpen && store) { store.aktif = 'notif'; }
            if (!this.isOpen && store && store.aktif === 'notif') { store.aktif = null; }
        },
        closePanel() {
            clearTimeout(this.hoverTimeout);
            this.isOpen = false;
            const store = Alpine.store('panelMenu');
            if (store && store.aktif === 'notif') { store.aktif = null; }
        }
    }"
    @mouseenter="openMenu()" @mouseleave="closeMenuWithDelay()" @click.outside="closePanel()"
    @keydown.escape.window="closePanel()">

    <button type="button" @click="togglePanel()"
        class="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full hover:bg-gray-100 hover:text-gray-700 h-11 w-11 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        :aria-expanded="isOpen ? 'true' : 'false'"
        aria-label="Notifikasi operasional">
        <span class="absolute -top-1 -right-1 {{ $total > 0 ? '' : 'hidden' }} flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-error-500 px-1 text-[10px] font-semibold text-white">
            {{ $total > 99 ? '99+' : $total }}
        </span>
        <svg class="fill-current" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M12 3.25a5.75 5.75 0 0 0-5.75 5.75v2.19c0 .53-.18 1.04-.5 1.45l-1.2 1.53c-.5.64-.05 1.58.76 1.58h13.38c.81 0 1.26-.94.76-1.58l-1.2-1.53a2.3 2.3 0 0 1-.5-1.45V9A5.75 5.75 0 0 0 12 3.25ZM4.75 9a7.25 7.25 0 0 1 14.5 0v2.19c0 .2.07.4.19.56l1.2 1.53c1.18 1.5.11 3.72-1.8 3.72H5.16c-1.91 0-2.98-2.22-1.8-3.72l1.2-1.53a.8.8 0 0 0 .19-.56V9Zm4.5 10.25a.75.75 0 0 1 .75-.75h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z"
                fill="currentColor" />
        </svg>
    </button>

    <div x-show="isOpen" x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="transform opacity-0 translate-y-1"
        x-transition:enter-end="transform opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="transform opacity-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 translate-y-1"
        class="absolute ltr:right-0 rtl:left-0 z-50 mt-[17px] flex w-[340px] max-w-[calc(100vw-2rem)] flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-lg dark:border-gray-800 dark:bg-gray-900">

        {{-- Kepala --}}
        <div class="flex items-start justify-between gap-3 border-b border-gray-100 px-4 py-3 dark:border-gray-800">
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">Notifikasi</p>
                <p class="mt-0.5 text-theme-xs text-gray-500 dark:text-gray-400">
                    {{ $total > 0 ? $total.' hal perlu ditindak' : 'Tidak ada yang mendesak' }}
                </p>
            </div>
            <span class="mt-0.5 inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-600 dark:bg-white/5 dark:text-gray-300">
                <span class="h-1.5 w-1.5 rounded-full bg-success-500"></span> 60 dtk
            </span>
        </div>

        {{-- Tab kelompok --}}
        <div class="flex gap-1 border-b border-gray-100 px-3 py-2 dark:border-gray-800" role="tablist" aria-label="Kelompok notifikasi">
            @foreach (['semua' => 'Semua', 'pekerjaan' => 'Pekerjaan', 'tagihan' => 'Tagihan', 'keuangan' => 'Keuangan'] as $kunci => $label)
                <button type="button" role="tab" @click="tab = '{{ $kunci }}'"
                    :aria-selected="tab === '{{ $kunci }}' ? 'true' : 'false'"
                    :class="tab === '{{ $kunci }}'
                        ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-300'
                        : 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5'"
                    class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-theme-xs font-semibold transition-colors">
                    {{ $label }}
                    @php $n = $kunci === 'semua' ? $total : ($jumlah[$kunci] ?? 0); @endphp
                    @if ($n > 0)
                        <span class="rounded-full bg-white/70 px-1.5 text-[10px] font-bold text-gray-700 dark:bg-white/10 dark:text-gray-200">{{ $n }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- Daftar --}}
        <ul class="max-h-[340px] divide-y divide-gray-100 overflow-y-auto dark:divide-gray-800" role="list">
            @forelse ($daftar as $n)
                <li x-show="tab === 'semua' || tab === '{{ $n['grup'] }}'" x-cloak>
                    <a href="{{ $n['url'] }}" class="flex items-start gap-3 px-4 py-3 transition-colors hover:bg-gray-50 dark:hover:bg-white/[0.03]">
                        <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full
                            {{ ['error' => 'bg-error-500', 'warning' => 'bg-warning-500', 'info' => 'bg-brand-500', 'sukses' => 'bg-success-500'][$n['tingkat']] ?? 'bg-gray-400' }}"></span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-[10px] font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 dark:text-gray-500">{{ $n['kategori'] }}</span>
                            <span class="mt-0.5 block truncate text-theme-sm font-semibold text-gray-800 dark:text-white/90">{{ $n['judul'] }}</span>
                            <span class="mt-0.5 block truncate text-theme-xs text-gray-500 dark:text-gray-400">{{ $n['keterangan'] }}</span>
                        </span>
                        <svg class="mt-2 h-4 w-4 shrink-0 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            @empty
                <li class="px-4 py-8 text-center text-theme-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi saat ini.</li>
            @endforelse
        </ul>

        {{-- Kaki --}}
        <div class="flex items-center justify-between gap-2 border-t border-gray-100 px-4 py-2.5 dark:border-gray-800">
            <a href="{{ route('panel.spk.calendar') }}" class="text-theme-xs font-semibold text-brand-600 hover:underline dark:text-brand-400">Kalender tenggat</a>
            <a href="{{ route('panel.spk.monitoring', 'status') }}" class="text-theme-xs font-semibold text-gray-600 hover:underline dark:text-gray-300">Monitoring SPK</a>
        </div>
    </div>
</div>
