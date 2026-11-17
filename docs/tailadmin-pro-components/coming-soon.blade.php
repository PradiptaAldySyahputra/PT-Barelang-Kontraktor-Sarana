<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="KCl8Hc8wJWtMiUQ7IJwhj4Hp2sCgzgk18JKb9ln8">

    <title>Laravel Coming Soon Page | TailAdmin - Laravel Dashboard Template</title>
<meta name="description" content="This is Laravel Coming Soon page for TailAdmin - Laravel Tailwind CSS Admin Dashboard Template">

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

        <div class="relative z-1 flex min-h-screen w-full flex-col items-center justify-center overflow-hidden p-6">
    <div>
    <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
    <div class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
</div>

    <div>
        <div class="mx-auto w-full max-w-115 text-center">
            <a href="/" class="mb-6 inline-block">
                <img class="dark:hidden" src="/assets/images/logo/logo.svg" alt="Logo" width="154" height="32" />
                <img class="hidden dark:block" src="/assets/images/logo/logo-dark.svg" alt="Logo" width="154" height="32" />
            </a>

            <h1 class="mb-3 text-2xl font-bold text-gray-800 dark:text-white/90">Coming Soon</h1>

            <p class="mb-9 text-base text-gray-500 dark:text-gray-400">Our website is currently under construction, enter your email id to get latest updates and notifications about the website.</p>

            <div
    class="mb-10"
    x-data="{
        target: Date.now() + 29 * 86400000,
        t: { days: 0, hours: 0, minutes: 0, seconds: 0 },
        init() {
            const tick = () => {
                const d = this.target - Date.now();
                if (d > 0) this.t = { days: Math.floor(d / 86400000), hours: Math.floor((d / 3600000) % 24), minutes: Math.floor((d / 60000) % 60), seconds: Math.floor((d / 1000) % 60) };
            };
            tick();
            setInterval(tick, 1000);
        },
        pad(n) { return String(n).padStart(2, '0'); },
    }"
>
    <div class="mb-2 flex flex-wrap justify-center gap-2 text-3xl font-bold text-brand-500 dark:text-brand-400">
        <div class="timer-box"><span x-text="pad(t.days)">00</span></div>
        :
        <div class="timer-box"><span x-text="pad(t.hours)">00</span></div>
        :
        <div class="timer-box"><span x-text="pad(t.minutes)">00</span></div>
        :
        <div class="timer-box"><span x-text="pad(t.seconds)">00</span></div>
    </div>

    <div class="text-center text-base text-gray-500 dark:text-gray-400">
        <span class="timer-box inline-block"><span class="inline-block" x-text="t.days">0</span></span>
        <span x-text="t.days === 1 ? ' day' : ' days'"> days</span> left
    </div>
</div>

            <p class="mb-5 text-sm text-gray-700 dark:text-gray-400">Don’t want to miss update? Subscribe now</p>

            <form x-data="{ email: '' }" @submit.prevent="if (email.trim()) email = ''">
    <div class="flex flex-col gap-2 sm:flex-row sm:gap-3">
        <div class="w-full sm:w-[320px]">
            <input data-slot="input" x-model="email" type="email" placeholder="Email address" required="required" class="w-full min-w-0 rounded-[10px] border border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11 bg-transparent" />
        </div>

        <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 rounded-[10px] [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full gap-2 px-4 py-3 text-sm font-medium sm:w-auto"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" >
    <path
      d="M9.861 1.876v1.25m0 0a5.625 5.625 0 015.625 5.625v6.041H4.236V8.751a5.625 5.625 0 015.625-5.625zm-1.25 14.166h2.5m-7.917-2.5h13.334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            <span>Notify Me</span></button>
    </div>
</form>
        </div>

        <div class="absolute start-1/2 bottom-6 -translate-x-1/2 rtl:translate-x-1/2">
    <p class="mt-20 mb-6 text-center text-base text-gray-500 dark:text-gray-400">Follow Us On</p>

    <div class="flex items-center justify-center gap-5">
        <a data-slot="button" aria-label="Facebook" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-500" href="#"><svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M11.667 11.25h2.083l.833-3.333h-2.916V6.25c0-.857 0-1.666 1.666-1.666h1.25v-2.8a23.397 23.397 0 00-2.38-.117c-2.263 0-3.87 1.38-3.87 3.916v2.334h-2.5v3.333h2.5v7.084h3.334V11.25z"
      fill="currentColor"
    />
  </svg>
</a>
        <a data-slot="button" aria-label="Twitter" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-500" href="#"><svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.749 3.104l3.424 4.529.37.49.405-.463 3.986-4.556h1.18l-4.757 5.437-.267.306.245.325 5.843 7.723H13.38l-3.805-4.974-.37-.486-.403.46-4.375 5H3.244l5.138-5.872.27-.307-.249-.325-5.572-7.287h3.918zM4.353 4.331l9.076 11.866.15.197h2.643l-.607-.802L6.641 3.726l-.15-.199H3.736l.616.804z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
</a>
        <a data-slot="button" aria-label="LinkedIn" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-500" href="#"><svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M12.969 7.523a4.14 4.14 0 012.167-.226c.726.124 1.393.454 1.878 1.018.482.56.82 1.39.82 2.577V17h-2.292v-4.975c0-.934-.28-1.673-.758-2.178a2.276 2.276 0 00-1.748-.716c-1.282.046-2.468 1.12-2.469 2.894V17H8.283V7.567h2.306l-.022.887.939.253c.276-.503.796-.923 1.463-1.184zm-7.635.044V17H3V7.567h2.334zM4.152 3a1.166 1.166 0 11-.07 2.331 1.166 1.166 0 01.07-2.33z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
</a>
        <a data-slot="button" aria-label="Instagram" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-500" href="#"><svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.857 1.667c.938.002 1.413.007 1.824.019l.161.005.594.025c.886.041 1.491.182 2.023.388a4.06 4.06 0 011.476.961c.462.463.749.928.961 1.476.206.531.346 1.137.388 2.023.01.223.018.407.024.594l.005.161c.013.411.018.886.02 1.824v1.713a65.505 65.505 0 01-.019 1.824l-.005.162-.025.593c-.041.887-.182 1.492-.388 2.023a4.07 4.07 0 01-.961 1.476c-.463.463-.93.75-1.476.961-.532.206-1.137.346-2.023.388l-.594.025-.162.005c-.41.012-.885.018-1.823.02H9.144a65.1 65.1 0 01-1.824-.02l-.162-.005a53.705 53.705 0 01-.593-.025c-.887-.04-1.491-.182-2.023-.388a4.073 4.073 0 01-1.476-.96 4.086 4.086 0 01-.962-1.477c-.206-.531-.345-1.136-.387-2.023l-.025-.593-.005-.162c-.012-.41-.018-.886-.02-1.824V9.143c.002-.938.007-1.413.02-1.824l.005-.161c.006-.187.014-.371.025-.594.04-.887.181-1.491.387-2.023a4.066 4.066 0 01.962-1.476 4.08 4.08 0 011.476-.961c.531-.206 1.135-.346 2.023-.388.222-.01.406-.018.593-.024l.162-.005c.41-.013.886-.018 1.824-.02h1.713zM10 5.833a4.166 4.166 0 100 8.333 4.166 4.166 0 000-8.333zM10 7.5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm4.375-2.917a1.042 1.042 0 10.001 2.084 1.042 1.042 0 000-2.084z"
      fill="currentColor"
    />
  </svg>
</a>
    </div>
</div>
    </div>
</div>

</body>


</html>
