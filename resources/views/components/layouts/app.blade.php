<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.ico" sizes="48x48">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#0F4C81">

    <title>{{ $judul ?? 'Panel' }} · BKS</title>

    @livewireStyles
    @vite(['resources/css/panel.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <script>
        // Terapkan tema tersimpan SEBELUM halaman digambar supaya tidak berkedip
        (function() {
            const savedTheme = localStorage.getItem('bks-tema') || localStorage.getItem('theme');
            const isDark = savedTheme === 'gelap' || savedTheme === 'dark';
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        })();

        document.addEventListener('alpine:init', function() {
            Alpine.store('theme', {
                init() {
                    const saved = localStorage.getItem('bks-tema') || localStorage.getItem('theme');
                    this.theme = (saved === 'gelap' || saved === 'dark') ? 'dark' : 'light';
                    this.updateTheme();
                },
                theme: 'light',
                resolvedTheme: 'light',
                set(value) {
                    const isDark = value === 'dark' || value === 'gelap';
                    this.theme = isDark ? 'dark' : 'light';
                    localStorage.setItem('bks-tema', isDark ? 'gelap' : 'terang');
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                toggle() {
                    this.set(this.resolvedTheme === 'dark' ? 'light' : 'dark');
                },
                updateTheme() {
                    const html = document.documentElement;
                    const isDark = this.theme === 'dark';
                    html.classList.toggle('dark', isDark);
                    this.resolvedTheme = isDark ? 'dark' : 'light';
                    html.setAttribute('data-color-scheme', this.resolvedTheme);
                    html.dataset['theme'] = this.resolvedTheme;
                    html.style.colorScheme = this.resolvedTheme;
                }
            });

            // Kompatibilitas alias untuk tema lama
            Alpine.store('tema', {
                get gelap() {
                    return Alpine.store('theme').resolvedTheme === 'dark';
                },
                balik() {
                    Alpine.store('theme').toggle();
                },
                set(nilai) {
                    Alpine.store('theme').set(nilai);
                }
            });

            Alpine.store('sidebar', {
                isExpanded: true,
                isMobileOpen: false,
                isHovered: false,

                init() {
                    const savedState = localStorage.getItem('bks-sidebar') || localStorage.getItem('sidebarExpanded');
                    if (window.innerWidth >= 1280) {
                        this.isExpanded = savedState === null ? true : (savedState === 'lebar' || savedState === 'true');
                    } else {
                        this.isExpanded = false;
                    }
                    this.isMobileOpen = false;

                    window.addEventListener('resize', () => {
                        this.handleResize();
                    });
                },

                handleResize() {
                    if (window.innerWidth < 1280) {
                        this.isMobileOpen = false;
                    } else {
                        this.isMobileOpen = false;
                        const savedState = localStorage.getItem('bks-sidebar') || localStorage.getItem('sidebarExpanded');
                        this.isExpanded = savedState === null ? true : (savedState === 'lebar' || savedState === 'true');
                    }
                },

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                    if (window.innerWidth >= 1280) {
                        localStorage.setItem('bks-sidebar', this.isExpanded ? 'lebar' : 'sempit');
                        localStorage.setItem('sidebarExpanded', this.isExpanded ? 'true' : 'false');
                    }
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                },

                // Aliases untuk backward compatibility
                get lebar() {
                    return this.isExpanded || this.isHovered;
                },
                get laci() {
                    return this.isMobileOpen;
                },
                balik() {
                    this.toggleExpanded();
                },
                bukaLaci() {
                    this.setMobileOpen(true);
                },
                tutupLaci() {
                    this.setMobileOpen(false);
                }
            });
        });
    </script>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100 font-outfit">

    <div class="min-h-screen xl:flex sidebar-expanded" x-data :class="{ 'sidebar-expanded': $store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen }">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 min-w-0 ml-0 ltr:xl:ml-[90px] rtl:xl:ml-0 rtl:xl:mr-[90px] [.sidebar-expanded_&]:ltr:xl:ml-[290px] [.sidebar-expanded_&]:rtl:xl:ml-0 [.sidebar-expanded_&]:rtl:xl:mr-[290px] transition-all duration-300 ease-in-out flex flex-col min-h-screen">
            @include('layouts.app-header')

            <main class="p-4 mx-auto w-full max-w-(--breakpoint-2xl) md:p-6 grow min-w-0">
                @if (isset($judul))
                    <x-common.page-breadcrumb :pageTitle="$judul" :kembali="$kembali ?? null" />
                @endif
                @if (session('berhasil'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-success-500/20 bg-success-500/10 p-4 text-sm text-success-700 dark:text-success-400">
                        <span class="mt-0.5 font-bold">✓</span>
                        <div class="flex flex-1 flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <p>{{ session('berhasil') }}</p>
                            @if (session('backup_baru'))
                                <a href="{{ route('backup.unduh', session('backup_baru')) }}"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-success-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-success-700 transition shadow-xs shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Unduh ke Flashdisk Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                @if (session('gagal'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border border-error-500/20 bg-error-500/10 p-4 text-sm text-error-700 dark:text-error-400">
                        <span class="mt-0.5 font-bold">!</span>
                        <p>{{ session('gagal') }}</p>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Modal Konfirmasi TailAdmin --}}
    <x-common.confirm-modal />

    <script>
        function konfirmasiAksi(formOrOptions, pesan) {
            let options = {};
            if (formOrOptions instanceof HTMLFormElement) {
                options = {
                    form: formOrOptions,
                    title: 'Konfirmasi Tindakan',
                    message: pesan || 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
                    confirmText: 'Ya, Lanjutkan',
                    isDanger: true
                };
            } else if (typeof formOrOptions === 'object') {
                options = formOrOptions;
            } else if (typeof formOrOptions === 'string') {
                options = { message: formOrOptions };
            }
            window.dispatchEvent(new CustomEvent('bks-confirm', { detail: options }));
            return false;
        }
    </script>

    @livewireScripts
    @stack('skrip')
    @stack('scripts')
</body>

</html>
