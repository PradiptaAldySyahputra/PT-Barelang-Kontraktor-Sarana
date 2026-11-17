<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs">

    <title>Layout Four | TailAdmin - Laravel Admin Dashboard Template</title>
<meta name="description" content="This is Layout Four for TailAdmin - Laravel Tailwind CSS Admin Dashboard Template">

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
                    html.setAttribute('data-color-scheme', this.resolvedTheme);
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
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const isDark = savedTheme === 'dark';
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-color-scheme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-color-scheme', 'light');
            }
        })();
    </script>
</head>

<body x-data>
    <div class="flex min-h-svh w-full">
            <div class="shrink-0 transition-[width] duration-300 ease-in-out max-xl:w-0" :class="$store.sidebar.isExpanded ? 'xl:w-72.5' : 'xl:w-0'">
    <aside data-slot="sidebar"
        x-data="{
            activeVersion: 'v2.0.8-alpha',
            selected: 'InstallationGuide',
            searchQuery: '',
            openSections: JSON.parse('{\u0022GetStarted\u0022:true,\u0022DeveloperFeatures\u0022:true,\u0022SDKDocumentation\u0022:true,\u0022APIReference\u0022:true,\u0022IntegrationGuides\u0022:true,\u0022TutorialsSection\u0022:true,\u0022ReleaseNotes\u0022:true}'),
            handleSelect(id) { this.selected = id; if ($store.sidebar.isMobileOpen) $store.sidebar.isMobileOpen = false; },
            matches(label) { return !this.searchQuery.trim() || label.toLowerCase().includes(this.searchQuery.toLowerCase()); },
            isOpen(id) { return this.searchQuery.trim() ? true : (this.openSections[id] ?? true); },
            toggleSection(id) { this.openSections = { ...this.openSections, [id]: !this.isOpen(id) }; },
        }"
        class="fixed inset-y-0 z-101 flex h-svh w-72.5 flex-col border-e border-gray-200 bg-white text-gray-900 transition-[transform,inset] duration-300 ease-in-out max-xl:shadow-theme-lg xl:z-50 dark:border-gray-800 dark:bg-gray-900"
        :class="$store.sidebar.isMobileOpen ? 'start-0 translate-x-0' : ($store.sidebar.isExpanded ? 'start-0 max-xl:-translate-x-full max-xl:rtl:translate-x-full' : '-start-72.5 max-xl:start-0 max-xl:-translate-x-full max-xl:rtl:translate-x-full')">
        <div data-slot="sidebar-header" data-sidebar="header" class="flex flex-col gap-2 p-0">
    <div class="px-5 py-5">
        <div class="relative flex items-center justify-between gap-2.5">
            <div class="flex items-center gap-3">
                <a href="/" class="shrink-0" aria-label="Go to homepage">
                    <img src="/assets/images/logo/logo-icon.svg" alt="Logo" width="32" height="32" class="size-8" style="width: auto; height: auto;" />
                </a>
                <div>
                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">TailAdmin Docs</span>
                    <span class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400" x-text="activeVersion"></span>
                </div>
            </div>

            <div class="ms-auto">
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="inline-flex size-5 items-center justify-center rounded-md border border-gray-200 text-gray-800 transition-colors hover:bg-gray-100 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-gray-800" type="button" aria-label="Toggle version selection"
               >
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
      d="M12.167 6.242L8 2.076 3.833 6.242m0 3.515L8 13.924l4.167-4.167"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>

        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-56 min-w-0 p-1.5"><div role="menuitemcheckbox" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-checkbox-item"
            aria-checked="false" data-state="unchecked"
     x-data="{ get checked() { return activeVersion === &#039;v1.0.1&#039; } }"     x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)"
     x-on:click="activeVersion = &#039;v1.0.1&#039;; $el.dispatchEvent(new CustomEvent('change', { detail: { checked }, bubbles: true })); closeAll()"      class="relative flex cursor-pointer items-center gap-3 rounded-lg ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-5 py-2">
    <span class="pointer-events-none absolute end-3 flex items-center justify-center dark:text-brand-400"
        data-slot="dropdown-menu-checkbox-item-indicator">
        <span data-state="checked" x-show="checked"
             style="display: none;" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
    v1.0.1
</div>
                            <div role="menuitemcheckbox" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-checkbox-item"
            aria-checked="false" data-state="unchecked"
     x-data="{ get checked() { return activeVersion === &#039;v2.0.8-alpha&#039; } }"     x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)"
     x-on:click="activeVersion = &#039;v2.0.8-alpha&#039;; $el.dispatchEvent(new CustomEvent('change', { detail: { checked }, bubbles: true })); closeAll()"      class="relative flex cursor-pointer items-center gap-3 rounded-lg ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-5 py-2">
    <span class="pointer-events-none absolute end-3 flex items-center justify-center dark:text-brand-400"
        data-slot="dropdown-menu-checkbox-item-indicator">
        <span data-state="checked" x-show="checked"
             style="display: none;" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
    v2.0.8-alpha
</div>
                            <div role="menuitemcheckbox" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-checkbox-item"
            aria-checked="false" data-state="unchecked"
     x-data="{ get checked() { return activeVersion === &#039;V3.0.9-beta1&#039; } }"     x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)"
     x-on:click="activeVersion = &#039;V3.0.9-beta1&#039;; $el.dispatchEvent(new CustomEvent('change', { detail: { checked }, bubbles: true })); closeAll()"      class="relative flex cursor-pointer items-center gap-3 rounded-lg ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-5 py-2">
    <span class="pointer-events-none absolute end-3 flex items-center justify-center dark:text-brand-400"
        data-slot="dropdown-menu-checkbox-item-indicator">
        <span data-state="checked" x-show="checked"
             style="display: none;" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
    V3.0.9-beta1
</div></div>
    </div>
</template></div>
</div>
        </div>
    </div>
    <div class="px-5 pb-4">
                <div class="relative">
                    <span class="pointer-events-none absolute start-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="size-4.5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                    </span>
                    <input x-model="searchQuery" type="text" placeholder="Search the docs"
                        class="h-9 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 ps-9 pe-3 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-800 dark:bg-white/3 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
                </div>
            </div>
</div>

        <div data-slot="sidebar-content" data-sidebar="content" class="no-scrollbar flex min-h-0 flex-1 flex-col gap-0 overflow-hidden p-0 pe-px duration-300 ease-linear">
            <div data-slot="scroll-area"  class="relative h-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1">
        <div class="min-w-0"><nav class="mb-6 flex flex-col gap-1 px-5">
                                            <div class="w-full" x-show="JSON.parse('[\u0022Quick Start\u0022,\u0022Installation Guide\u0022,\u0022Tutorials\u0022,\u0022Configuration\u0022,\u0022Best Practices\u0022,\u0022FAQ\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('GetStarted')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>Get Started</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('GetStarted') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('GetStarted')) && 'open'" :inert="!(isOpen('GetStarted'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Quick Start')">
                                                <a href="#" @click.prevent="handleSelect('QuickStart')" class="block text-sm transition-colors"
                                                    :class="selected === 'QuickStart' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Quick Start</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Installation Guide')">
                                                <a href="#" @click.prevent="handleSelect('InstallationGuide')" class="block text-sm transition-colors"
                                                    :class="selected === 'InstallationGuide' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Installation Guide</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Tutorials')">
                                                <a href="#" @click.prevent="handleSelect('Tutorials')" class="block text-sm transition-colors"
                                                    :class="selected === 'Tutorials' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Tutorials</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Configuration')">
                                                <a href="#" @click.prevent="handleSelect('Configuration')" class="block text-sm transition-colors"
                                                    :class="selected === 'Configuration' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Configuration</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Best Practices')">
                                                <a href="#" @click.prevent="handleSelect('BestPractices')" class="block text-sm transition-colors"
                                                    :class="selected === 'BestPractices' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Best Practices</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('FAQ')">
                                                <a href="#" @click.prevent="handleSelect('FAQ')" class="block text-sm transition-colors"
                                                    :class="selected === 'FAQ' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">FAQ</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022Plugins\u0022,\u0022Custom Hooks\u0022,\u0022State Management\u0022,\u0022Performance Tips\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('DeveloperFeatures')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>Developer Features</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('DeveloperFeatures') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('DeveloperFeatures')) && 'open'" :inert="!(isOpen('DeveloperFeatures'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Plugins')">
                                                <a href="#" @click.prevent="handleSelect('Plugins')" class="block text-sm transition-colors"
                                                    :class="selected === 'Plugins' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Plugins</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Custom Hooks')">
                                                <a href="#" @click.prevent="handleSelect('CustomHooks')" class="block text-sm transition-colors"
                                                    :class="selected === 'CustomHooks' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Custom Hooks</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('State Management')">
                                                <a href="#" @click.prevent="handleSelect('StateManagement')" class="block text-sm transition-colors"
                                                    :class="selected === 'StateManagement' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">State Management</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Performance Tips')">
                                                <a href="#" @click.prevent="handleSelect('PerformanceTips')" class="block text-sm transition-colors"
                                                    :class="selected === 'PerformanceTips' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Performance Tips</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022Getting Started\u0022,\u0022Authentication\u0022,\u0022Error Handling\u0022,\u0022Rate Limits\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('SDKDocumentation')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>SDK Documentation</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('SDKDocumentation') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('SDKDocumentation')) && 'open'" :inert="!(isOpen('SDKDocumentation'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Getting Started')">
                                                <a href="#" @click.prevent="handleSelect('SDKGettingStarted')" class="block text-sm transition-colors"
                                                    :class="selected === 'SDKGettingStarted' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Getting Started</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Authentication')">
                                                <a href="#" @click.prevent="handleSelect('SDKAuthentication')" class="block text-sm transition-colors"
                                                    :class="selected === 'SDKAuthentication' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Authentication</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Error Handling')">
                                                <a href="#" @click.prevent="handleSelect('ErrorHandling')" class="block text-sm transition-colors"
                                                    :class="selected === 'ErrorHandling' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Error Handling</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Rate Limits')">
                                                <a href="#" @click.prevent="handleSelect('RateLimits')" class="block text-sm transition-colors"
                                                    :class="selected === 'RateLimits' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Rate Limits</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022REST API\u0022,\u0022GraphQL\u0022,\u0022Webhooks\u0022,\u0022SDK Methods\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('APIReference')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>API Reference</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('APIReference') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('APIReference')) && 'open'" :inert="!(isOpen('APIReference'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('REST API')">
                                                <a href="#" @click.prevent="handleSelect('RESTAPI')" class="block text-sm transition-colors"
                                                    :class="selected === 'RESTAPI' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">REST API</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('GraphQL')">
                                                <a href="#" @click.prevent="handleSelect('GraphQL')" class="block text-sm transition-colors"
                                                    :class="selected === 'GraphQL' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">GraphQL</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Webhooks')">
                                                <a href="#" @click.prevent="handleSelect('Webhooks')" class="block text-sm transition-colors"
                                                    :class="selected === 'Webhooks' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Webhooks</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('SDK Methods')">
                                                <a href="#" @click.prevent="handleSelect('SDKMethods')" class="block text-sm transition-colors"
                                                    :class="selected === 'SDKMethods' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">SDK Methods</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022OAuth Setup\u0022,\u0022Third-party Services\u0022,\u0022Database Integration\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('IntegrationGuides')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>Integration Guides</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('IntegrationGuides') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('IntegrationGuides')) && 'open'" :inert="!(isOpen('IntegrationGuides'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('OAuth Setup')">
                                                <a href="#" @click.prevent="handleSelect('OAuthSetup')" class="block text-sm transition-colors"
                                                    :class="selected === 'OAuthSetup' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">OAuth Setup</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Third-party Services')">
                                                <a href="#" @click.prevent="handleSelect('ThirdPartyServices')" class="block text-sm transition-colors"
                                                    :class="selected === 'ThirdPartyServices' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Third-party Services</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Database Integration')">
                                                <a href="#" @click.prevent="handleSelect('DatabaseIntegration')" class="block text-sm transition-colors"
                                                    :class="selected === 'DatabaseIntegration' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Database Integration</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022Building a Dashboard\u0022,\u0022CRUD Operations\u0022,\u0022Authentication Flow\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('TutorialsSection')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>Tutorials</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('TutorialsSection') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('TutorialsSection')) && 'open'" :inert="!(isOpen('TutorialsSection'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Building a Dashboard')">
                                                <a href="#" @click.prevent="handleSelect('BuildingDashboard')" class="block text-sm transition-colors"
                                                    :class="selected === 'BuildingDashboard' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Building a Dashboard</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('CRUD Operations')">
                                                <a href="#" @click.prevent="handleSelect('CRUDOperations')" class="block text-sm transition-colors"
                                                    :class="selected === 'CRUDOperations' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">CRUD Operations</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('Authentication Flow')">
                                                <a href="#" @click.prevent="handleSelect('AuthFlow')" class="block text-sm transition-colors"
                                                    :class="selected === 'AuthFlow' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">Authentication Flow</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                            <div class="w-full" x-show="JSON.parse('[\u0022v2.0.0\u0022,\u0022v1.5.0\u0022,\u0022v1.0.0\u0022]').some((label) => matches(label))">
                            <button type="button" @click="toggleSection('ReleaseNotes')"
                                class="flex w-full cursor-pointer items-center justify-between rounded-lg px-3 py-1.5 text-sm font-normal text-gray-800 transition-colors hover:bg-gray-100 dark:text-white/90 dark:hover:bg-gray-800">
                                <span>Release Notes</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 dark:text-gray-400" :class="isOpen('ReleaseNotes') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </button>
                            <div class="menu-accordion" :class="(isOpen('ReleaseNotes')) && 'open'" :inert="!(isOpen('ReleaseNotes'))">
                                <div>
                                    <ul class="flex flex-col py-2">
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('v2.0.0')">
                                                <a href="#" @click.prevent="handleSelect('v200')" class="block text-sm transition-colors"
                                                    :class="selected === 'v200' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">v2.0.0</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('v1.5.0')">
                                                <a href="#" @click.prevent="handleSelect('v150')" class="block text-sm transition-colors"
                                                    :class="selected === 'v150' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">v1.5.0</a>
                                            </li>
                                                                                    <li class="rounded-lg px-5 py-1.5 hover:bg-gray-100 dark:hover:bg-gray-800" x-show="matches('v1.0.0')">
                                                <a href="#" @click.prevent="handleSelect('v100')" class="block text-sm transition-colors"
                                                    :class="selected === 'v100' ? 'font-medium text-brand-500' : 'text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400'">v1.0.0</a>
                                            </li>
                                                                            </ul>
                                </div>
                            </div>
                        </div>
                                    </nav></div>
    </div>
</div>
        </div>
    </aside>
</div>

        <!-- Small device overlay -->
        <div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.isMobileOpen = false"
    x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:leave="transition-opacity duration-200" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-100 bg-black/50 supports-backdrop-filter:backdrop-blur-xs xl:hidden dark:bg-black/70" x-cloak></div>

        <div class="min-h-screen w-full min-w-0 bg-white xl:flex dark:bg-black">
            <div class="min-w-0 grow transition-all duration-300 ease-in-out">
                    <header
    class="sticky top-0 z-50 flex w-full shrink-0 border-gray-200 bg-white xl:border-b dark:border-gray-800 dark:bg-gray-900"
    x-data="{
        isApplicationMenuOpen: false,
        toggleApplicationMenu() {
            this.isApplicationMenuOpen = !this.isApplicationMenuOpen;
        }
    }">
    <div class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6">
        <!-- Left side content -->
        <div
            class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 xl:justify-normal xl:border-b-0 xl:px-0 xl:py-4 dark:border-gray-800">

            <!-- Desktop sidebar toggle (xl and up) -->
            <button data-slot="button" type="button" aria-label="Toggle Sidebar" @click.stop="$store.sidebar.toggleExpanded()" class="group/button shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] hidden text-gray-500 xl:inline-flex lg:size-11 dark:text-gray-400"><svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-auto! rtl:-scale-x-100">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
      fill="currentColor"
    />
  </svg></button>

            <!-- Mobile sidebar toggle (below xl) -->
            <button data-slot="button" type="button" aria-label="Toggle Sidebar" @click.stop="$store.sidebar.toggleMobileOpen()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-500 xl:hidden lg:size-11 dark:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="$store.sidebar.isMobileOpen" class="size-6">
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="!$store.sidebar.isMobileOpen" class="size-auto! rtl:-scale-x-100">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
      fill="currentColor"
    />
  </svg></button>

            <!-- Logo (mobile only) -->
            <a href="/" class="xl:hidden">
                <img class="h-8 w-38.5 dark:hidden" src="/assets/images/logo/logo.svg" alt="Logo" />
                <img class="hidden h-8 w-38.5 dark:block" src="/assets/images/logo/logo-dark.svg" alt="Logo" />
            </a>

            <!-- Application menu toggle (mobile only) -->
            <button data-slot="button" type="button" aria-label="Toggle application menu" @click="toggleApplicationMenu()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-700 xl:hidden dark:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>

            <!-- Search (desktop only) -->
            <div class="hidden xl:block" x-data="{}"
                @keydown.window="if (($event.metaKey || $event.ctrlKey) && $event.key.toLowerCase() === 'k') { $event.preventDefault(); $refs.searchInput?.focus(); }">
                <form @submit.prevent>
                    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto xl:w-107.5"><div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 w-full min-w-0 items-center rounded-[10px] border shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 border-gray-200 bg-transparent dark:border-gray-800 dark:bg-white/3"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first ps-3.5 has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5"><svg class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                            <input type="text" data-slot="input-group-control" x-ref="searchInput" placeholder="Search or type command..." class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-gray-800 placeholder:text-gray-400 dark:text-white/90 dark:placeholder:text-white/30">
                            <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last pe-3.5 has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5"><span data-slot="badge" data-variant="light" data-color="gray" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 [text-shadow:0_4px_4px_var(--color-gray-300)] dark:[text-shadow:0_4px_4px_rgba(255,255,255,0.10)] cursor-pointer gap-0.5 rounded-lg border border-gray-200 bg-gray-50 px-1.75 py-[4.5px] text-xs tracking-[-0.2px] text-gray-500 shadow-none dark:border-gray-800 dark:bg-white/3 dark:text-gray-400"><span>⌘</span>
                                    <span>K</span></span></div></div></div>
                </form>
            </div>
        </div>

        <!-- Right side content -->
        <div :class="isApplicationMenuOpen ? 'flex' : 'hidden'"
            class="w-full items-center justify-between gap-4 px-3 py-4 shadow-theme-md xl:flex xl:justify-end xl:px-0 xl:shadow-none">
            <div class="2xsm:gap-3 flex items-center gap-2">
                <!-- Theme toggler -->
                <button data-slot="button" type="button" aria-label="Toggle theme" @click="$store.theme.toggle()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-11 rounded-[10px] relative"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" x-show="$store.theme.resolvedTheme === 'dark'">
    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
    <path
      d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
    />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" x-show="$store.theme.resolvedTheme !== 'dark'">
    <path
      d="M6.247 6.668a6.668 6.668 0 0011.207 4.885A7.708 7.708 0 118.03 2.129a6.645 6.645 0 00-1.783 4.54z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

                                                    <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-11 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4" href="#">Get Started</a>
                            </div>
                    </div>
    </div>
</header>
                <main class="mx-auto w-full max-w-screen-2xl flex-1 p-4 pb-20 md:p-6">
                    <!-- Page content goes here -->
                        <div class="space-y-6">
        <div class="grid auto-rows-min gap-6 sm:grid-cols-2 xl:grid-cols-4">
            <div class="h-40 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="h-40 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="h-40 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="h-40 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
        </div>
        <div class="grid auto-rows-min gap-6 lg:grid-cols-3">
            <div class="min-h-dvh lg:col-span-1 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="min-h-dvh lg:col-span-1 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="min-h-dvh lg:col-span-1 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
        </div>
    </div>
                </main>
            </div>
        </div>
    </div>
</body>


</html>
