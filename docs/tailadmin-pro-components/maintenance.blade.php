<!DOCTYPE html>
<html lang="de" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs">

    <title>Laravel Maintenance Page | TailAdmin - Laravel Dashboard Template</title>
<meta name="description" content="This is Laravel Maintenance page for TailAdmin - Laravel Tailwind CSS Admin Dashboard Template">

    <!-- Scripts -->
    <link rel="preload" as="style" href="https://laravel-demo.tailadmin.com/build/assets/app-DZMEfgUJ.css" /><link rel="preload" as="style" href="https://laravel-demo.tailadmin.com/build/assets/app-BxZQYbRh.css" /><link rel="modulepreload" as="script" href="https://laravel-demo.tailadmin.com/build/assets/app-BJ-40FlN.js" /><link rel="stylesheet" href="https://laravel-demo.tailadmin.com/build/assets/app-DZMEfgUJ.css" /><link rel="stylesheet" href="https://laravel-demo.tailadmin.com/build/assets/app-BxZQYbRh.css" /><script type="module" src="https://laravel-demo.tailadmin.com/build/assets/app-BJ-40FlN.js"></script>

    <!-- Theme Store -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    this.theme = savedTheme === 'dark' ? 'dark' : 'light';
                    this.updateTheme();
                },
                theme: 'light',
                resolvedTheme: 'light',
                set(value) {
                    value = value === 'dark' ? 'dark' : 'light';
                    this.theme = value;
                    localStorage.setItem('theme', value);
                    this.updateTheme();
                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: value }));
                },
                toggle() {
                    this.set(this.resolvedTheme === 'dark' ? 'light' : 'dark');
                },
                updateTheme() {
                    const html = document.documentElement;
                    const isDark = this.theme === 'dark';
                    if (isDark) {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }

                    this.resolvedTheme = isDark ? 'dark' : 'light';
                    html.dataset['theme'] = this.resolvedTheme;
                    html.style.colorScheme = this.resolvedTheme;
                    if (document.body) {
                        document.body.dataset['theme'] = this.resolvedTheme;
                        document.body.style.colorScheme = this.resolvedTheme;
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: false,
                isMobileOpen: false,
                isHovered: false,

                init() {
                    const savedState = localStorage.getItem('sidebarExpanded');
                    if (window.innerWidth >= 1280) {
                        this.isExpanded = savedState === null ? true : savedState === 'true';
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
                        if (this.isMobileOpen) {
                             this.isMobileOpen = false;
                        }
                    } else {
                        this.isMobileOpen = false;
                        const savedState = localStorage.getItem('sidebarExpanded');
                        this.isExpanded = savedState === null ? true : savedState === 'true';
                    }
                },

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                    
                    if (window.innerWidth >= 1280) {
                        localStorage.setItem('sidebarExpanded', this.isExpanded);
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
                }
            });
        });
    </script>

    <!-- Apply dark mode immediately to prevent flash -->

</head>

<body x-data>

    <!-- Apply dark mode immediately to prevent flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const isDark = savedTheme === 'dark';
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

        <div class="relative z-1 flex min-h-screen flex-col items-center justify-center overflow-hidden p-6">
    <div>
    <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
    <div class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
</div>

    <div>
        <div class="mx-auto w-full max-w-68.5 text-center sm:max-w-138.75">
            <div class="mx-auto mb-10 w-full max-w-38.75 text-center sm:max-w-51">
                <img src="/assets/images/error/maintenance.svg" alt="maintenance" class="dark:hidden" width="205" height="205" />
                <img src="/assets/images/error/maintenance-dark.svg" alt="maintenance" class="hidden dark:block" width="205" height="205" />
            </div>

            <h1 class="mb-2 text-2xl font-bold text-gray-800 xl:text-[64px] dark:text-white/90">MAINTENANCE</h1>

            <p class="mt-6 mb-6 text-base text-gray-700 sm:text-lg dark:text-gray-400">Our Site is Currently under maintenance We will be back Shortly Thank You For Patience</p>

            <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 h-12.5 bg-white" href="/">Back to Home Page</a>
        </div>

        <p class="absolute start-1/2 bottom-6 -translate-x-1/2 text-center text-sm text-gray-500 rtl:translate-x-1/2 dark:text-gray-400">&copy; 2026 - TailAdmin</p>
    </div>
</div>

</body>


</html>
