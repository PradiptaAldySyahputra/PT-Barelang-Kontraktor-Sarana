@php
    $notif = \App\Support\NotifikasiOperasional::ambil();
    $total = $notif['total'];
    $jumlah = $notif['jumlah'];
    $daftar = $notif['daftar'];
@endphp

{{--
    Panel Notifikasi Header - TailAdmin Pro Exact Native Component
    Lebar leluasa (sm:w-[480px] md:w-[540px]), teks terbaca utuh, informatif, dan sangat user-friendly.
--}}
<div class="relative" x-data="{
        isOpen: false,
        tab: 'semua',
        hoverTimeout: null,
        readNotifs: JSON.parse(localStorage.getItem('bks_read_notifs') || '[]'),
        allNotifs: @js($daftar),
        totalAwal: {{ $total }},
        isRead(id) {
            return this.readNotifs.includes(id);
        },
        tandaiDibaca(id) {
            if (!this.readNotifs.includes(id)) {
                this.readNotifs.push(id);
                this.simpan();
            }
        },
        tandaiKategoriDibaca(grup) {
            const targetIds = this.allNotifs
                .filter(n => grup === 'semua' || n.grup === grup)
                .map(n => n.id);
            this.readNotifs = Array.from(new Set([...this.readNotifs, ...targetIds]));
            this.simpan();
        },
        tandaiSemuaDibaca() {
            const allIds = this.allNotifs.map(n => n.id);
            this.readNotifs = Array.from(new Set([...this.readNotifs, ...allIds]));
            this.simpan();
        },
        pulihkanNotifikasi() {
            this.readNotifs = [];
            this.simpan();
        },
        simpan() {
            localStorage.setItem('bks_read_notifs', JSON.stringify(this.readNotifs));
        },
        bukaNotif(id, url) {
            this.tandaiDibaca(id);
            this.closePanel();
            window.location.href = url;
        },
        get hitungSisa() {
            const dibaca = this.allNotifs.filter(n => this.readNotifs.includes(n.id)).length;
            return Math.max(0, this.totalAwal - dibaca);
        },
        hitungSisaGrup(grup) {
            if (grup === 'semua') {
                return this.hitungSisa;
            }
            const itemGrup = this.allNotifs.filter(n => n.grup === grup);
            const totalGrup = itemGrup.length;
            const dibaca = itemGrup.filter(n => this.readNotifs.includes(n.id)).length;
            return Math.max(0, totalGrup - dibaca);
        },
        init() {
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
            }, 300);
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

    {{-- Tombol Lonceng Notifikasi dengan Badge Merah & Kuantiti Menyatu --}}
    <button type="button" @click="togglePanel()"
        class="relative flex items-center justify-center h-11 w-11 rounded-full border border-gray-200 bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        :aria-expanded="isOpen ? 'true' : 'false'"
        aria-label="Pusat Notifikasi Operasional"
        :title="'Pusat Notifikasi (' + hitungSisa + ' baru)'">

        {{-- Badge Merah + Angka Kuantiti Notifikasi Terpadu --}}
        <template x-if="hitungSisa > 0">
            <span class="absolute -top-1 -right-1 z-20 flex items-center justify-center">
                {{-- Efek Radar Ping Pulse --}}
                <span class="absolute inline-flex h-full w-full rounded-full bg-error-400 opacity-60 animate-ping"></span>
                {{-- Kuantiti Angka Merah Berkilau --}}
                <span x-text="hitungSisa > 99 ? '99+' : hitungSisa"
                    class="relative inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-error-500 px-1.5 text-[10px] font-extrabold text-white shadow-xs ring-2 ring-white dark:ring-gray-900">
                </span>
            </span>
        </template>

        {{-- TailAdmin Pro Bell SVG Icon --}}
        <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" />
        </svg>
    </button>

    {{-- Dropdown Container: Didesain Luas (540px di desktop) & Sangat Ramah Pengguna --}}
    <div x-show="isOpen" x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="transform opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 scale-95 -translate-y-1"
        class="absolute right-0 mt-[17px] flex w-[370px] sm:w-[480px] md:w-[540px] max-w-[calc(100vw-1rem)] z-50 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-theme-xl dark:border-gray-800 dark:bg-gray-900">

        {{-- Dropdown Header --}}
        <div class="border-b border-gray-100 bg-white p-4 sm:p-5 dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-start gap-3 min-w-0">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400 shadow-theme-xs">
                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h5 class="text-sm font-bold text-gray-900 dark:text-white">Pusat Notifikasi Operasional</h5>
                            <template x-if="hitungSisa > 0">
                                <span class="inline-flex items-center rounded-full bg-error-50 px-2 py-0.5 text-[10px] font-bold text-error-600 dark:bg-error-500/15 dark:text-error-400"
                                    x-text="hitungSisa + ' Perlu Tindakan'">
                                </span>
                            </template>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                            Peringatan tenggat pekerjaan, siklus penagihan & arus kas
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button" @click="closePanel()"
                        class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300 transition"
                        aria-label="Tutup notifikasi">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Tombol Aksi Massal: Terstruktur di Baris Khusus Rapi --}}
            <div class="mt-3 flex items-center justify-between border-t border-gray-100 pt-2.5 dark:border-gray-800">
                <span class="text-[11px] font-medium text-gray-400 dark:text-gray-500">
                    <span x-text="hitungSisa"></span> dari <span x-text="allNotifs.length"></span> notifikasi belum dibaca
                </span>

                <div>
                    <template x-if="hitungSisa > 0">
                        <button type="button" @click="tandaiSemuaDibaca()"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                            title="Tandai semua notifikasi sudah dibaca">
                            <span>✓</span>
                            <span>Tandai Semua Dibaca</span>
                        </button>
                    </template>

                    <template x-if="readNotifs.length > 0 && hitungSisa === 0">
                        <button type="button" @click="pulihkanNotifikasi()"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 hover:bg-emerald-100 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-400 transition"
                            title="Tampilkan kembali notifikasi yang sudah dibaca">
                            <span>↺</span>
                            <span>Pulihkan Semua</span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        {{-- Tab Segmented Filter TailAdmin Pro: Grid Responsif Tanpa Scroll Samping --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5 p-3 bg-gray-50/70 border-b border-gray-100 dark:bg-gray-800/40 dark:border-gray-800">
            @foreach ([
                'semua' => ['label' => 'Semua', 'sub' => 'Notifikasi'],
                'pekerjaan' => ['label' => 'Tenggat', 'sub' => 'SPK'],
                'tagihan' => ['label' => 'Tagihan', 'sub' => 'Siklus'],
                'keuangan' => ['label' => 'Keuangan', 'sub' => 'Arus Kas']
            ] as $kunci => $info)
                <button type="button" @click="tab = '{{ $kunci }}'"
                    :class="tab === '{{ $kunci }}'
                        ? 'bg-brand-500 text-white shadow-theme-xs font-bold'
                        : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/80 dark:border-gray-700/60 dark:bg-gray-900/60 dark:text-gray-300 dark:hover:bg-gray-800 font-medium'"
                    class="flex items-center justify-between gap-1.5 rounded-xl px-2.5 py-1.5 text-xs transition-all duration-150">
                    <span class="truncate text-left leading-tight">
                        <span class="block font-semibold">{{ $info['label'] }}</span>
                        <span class="block text-[10px] opacity-75 font-normal">{{ $info['sub'] }}</span>
                    </span>
                    <span :class="tab === '{{ $kunci }}' ? 'bg-white/25 text-white' : 'bg-gray-100 text-gray-700 dark:bg-white/10 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                        class="rounded-full px-1.5 py-0.5 text-[10px] font-bold shrink-0 min-w-[20px] text-center"
                        x-text="hitungSisaGrup('{{ $kunci }}')">
                    </span>
                </button>
            @endforeach
        </div>

        {{-- Baris Info Kategori Tertentu (Filter Aktif) --}}
        <div x-show="tab !== 'semua' && hitungSisaGrup(tab) > 0"
            class="flex items-center justify-between px-5 py-2 bg-brand-50/40 dark:bg-brand-500/5 text-xs border-b border-gray-100 dark:border-gray-800">
            <span class="text-gray-500 dark:text-gray-400">
                Menyaring kategori: <strong class="text-brand-700 dark:text-brand-300 capitalize" x-text="tab"></strong>
            </span>
            <button type="button" @click="tandaiKategoriDibaca(tab)"
                class="font-semibold text-brand-600 hover:underline dark:text-brand-400">
                ✓ Tandai Kategori Ini Dibaca
            </button>
        </div>

        {{-- Daftar Kartu Notifikasi: Lapang, Teks Lengkap, dan User Friendly --}}
        <ul class="flex flex-col max-h-[440px] overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800/80 p-3 custom-scrollbar" role="list">
            @forelse ($daftar as $n)
                @php
                    $ikonConfig = match ($n['grup']) {
                        'pekerjaan' => [
                            'bg' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400',
                            'svg' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                        ],
                        'tagihan' => [
                            'bg' => 'bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400',
                            'svg' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'
                        ],
                        'keuangan' => [
                            'bg' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400',
                            'svg' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                        ],
                        default => [
                            'bg' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
                            'svg' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                        ]
                    };
                @endphp
                <li x-show="(tab === 'semua' || tab === '{{ $n['grup'] }}') && !isRead('{{ $n['id'] }}')" x-cloak>
                    <div class="group relative flex flex-col gap-2.5 rounded-2xl p-4 border border-gray-100 dark:border-gray-800/70 bg-white dark:bg-white/[0.02] hover:border-brand-300 dark:hover:border-brand-500/40 hover:bg-gray-50/60 dark:hover:bg-white/[0.04] shadow-xs transition-all duration-200">

                        {{-- Baris 1: Kategori, Ikon, Detail Waktu, dan Tombol Centang Dibaca --}}
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg {{ $ikonConfig['bg'] }} shadow-xs">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikonConfig['svg'] }}" />
                                    </svg>
                                </span>
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-bold uppercase tracking-wider {{ match($n['tingkat']) {
                                    'error' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400',
                                    'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400',
                                    'sukses' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400',
                                    default => 'bg-brand-50 text-brand-700 dark:bg-brand-500/15 dark:text-brand-400'
                                } }}">
                                    {{ $n['kategori'] }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    {{ $n['detail_waktu'] ?? '' }}
                                </span>
                                <button type="button" @click.stop="tandaiDibaca('{{ $n['id'] }}')"
                                    title="Tandai notifikasi ini sudah dibaca"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 dark:hover:bg-emerald-500/15 dark:hover:text-emerald-400 transition"
                                    aria-label="Tandai dibaca">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Baris 2: Judul Masalah & Nomor Dokumen/SPK --}}
                        <div>
                            @if (!empty($n['nomor']))
                                <p class="text-xs font-bold text-brand-600 dark:text-brand-400 select-all">
                                    {{ $n['nomor'] }}
                                </p>
                            @endif
                            <h6 class="text-sm font-semibold text-gray-900 dark:text-white mt-1">
                                {{ $n['judul'] }}
                            </h6>
                            {{-- Penjelasan Lengkap (Tanpa truncate yang memotong teks) --}}
                            <p class="text-xs text-gray-600 dark:text-gray-300 mt-1 leading-relaxed">
                                {{ $n['keterangan'] }}
                            </p>
                        </div>

                        {{-- Baris 3: Status Badge & Tombol Aksi Langsung ke Dokumen --}}
                        <div class="mt-1 flex flex-wrap items-center justify-between gap-2 pt-2.5 border-t border-gray-100 dark:border-gray-800">
                            @if (!empty($n['badge']))
                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold {{ match($n['tingkat']) {
                                    'error' => 'bg-error-50 text-error-700 dark:bg-error-500/10 dark:text-error-400',
                                    'warning' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/10 dark:text-warning-400',
                                    'sukses' => 'bg-success-50 text-success-700 dark:bg-success-500/10 dark:text-success-400',
                                    default => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'
                                } }}">
                                    {{ $n['badge'] }}
                                </span>
                            @else
                                <span></span>
                            @endif

                            <button type="button" @click="bukaNotif('{{ $n['id'] }}', '{{ $n['url'] }}')"
                                class="inline-flex items-center gap-1.5 rounded-xl border border-brand-200 bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700 hover:bg-brand-100 dark:border-brand-500/30 dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 transition shadow-xs">
                                <span>Tinjau & Proses</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="py-12 text-center text-xs text-gray-500 dark:text-gray-400">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 mb-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    Tidak ada notifikasi aktif saat ini.
                </li>
            @endforelse

            {{-- Keadaan Saat Semua Notifikasi Selesai Dibaca --}}
            <li x-show="hitungSisa === 0 && allNotifs.length > 0" class="py-10 px-4 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 mb-2.5 shadow-xs">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h6 class="text-sm font-bold text-gray-900 dark:text-white">Semua Notifikasi Operasional Telah Ditinjau</h6>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Seluruh operasional berjalan lancar tanpa peringatan tenggat aktif.</p>
                <button type="button" @click="pulihkanNotifikasi()"
                    class="mt-4 inline-flex items-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3.5 py-1.5 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition shadow-xs">
                    ↺ Tampilkan Kembali Notifikasi
                </button>
            </li>
        </ul>

        {{-- Dropdown Footer dengan Navigasi Cepat --}}
        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 bg-gray-50/70 px-5 py-3.5 dark:border-gray-800 dark:bg-gray-800/40 text-xs">
            <a href="{{ route('panel.spk.calendar') }}" @click="closePanel()"
                class="font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 flex items-center gap-1.5">
                <span>📅 Buka Kalender Tenggat</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('panel.spk.monitoring', 'billing') }}" @click="closePanel()"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                    Antrean Tagihan
                </a>
                <a href="{{ route('panel.spk.monitoring', 'status') }}" @click="closePanel()"
                    class="font-bold text-gray-700 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white">
                    Monitoring SPK &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
