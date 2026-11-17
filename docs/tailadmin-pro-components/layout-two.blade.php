<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs">

    <title>Layout Two | TailAdmin - Laravel Admin Dashboard Template</title>
<meta name="description" content="This is Layout Two for TailAdmin - Laravel Tailwind CSS Admin Dashboard Template">

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
            <div class="shrink-0 transition-[width] duration-300 ease-in-out max-xl:w-0" :class="$store.sidebar.isExpanded ? 'xl:w-72.5' : 'xl:w-22.5'">
    <aside
        data-slot="sidebar"
        x-data="{
            selectedKey: 'dashboard',
            openKeys: ['dashboard'],
            get showContent() { return $store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen; },
            toggle(key) { this.openKeys = this.openKeys.includes(key) ? this.openKeys.filter((k) => k !== key) : [...this.openKeys, key]; },
            hasActiveChild(keys) { return keys.includes(this.selectedKey); },
        }"
        @mouseenter="$store.sidebar.setHovered(true)" @mouseleave="$store.sidebar.setHovered(false)"
        class="fixed inset-y-0 start-0 z-101 flex h-svh w-72.5 flex-col border-e border-gray-200 bg-gray-50 text-gray-900 transition-[transform,width] duration-300 ease-in-out max-xl:shadow-theme-lg xl:z-50 dark:border-gray-800 dark:bg-gray-900"
        :class="[$store.sidebar.isMobileOpen ? 'translate-x-0' : 'max-xl:-translate-x-full max-xl:rtl:translate-x-full', ($store.sidebar.isExpanded || $store.sidebar.isHovered) ? '' : 'xl:w-22.5']">
        <div data-slot="sidebar-header" data-sidebar="header" class="flex flex-col gap-2 px-5 pt-5 pb-7">
            <a href="/" aria-label="Go to dashboard" class="flex items-center" :class="showContent ? 'justify-start' : 'justify-center'">
                <template x-if="showContent">
                    <span>
                        <img class="h-8 w-40 dark:hidden" src="/assets/images/logo/logo.svg" alt="Logo" />
                        <img class="hidden h-8 w-40 dark:block" src="/assets/images/logo/logo-dark.svg" alt="Logo" />
                    </span>
                </template>
                <img x-show="!showContent" src="/assets/images/logo/logo-icon.svg" alt="Logo" class="mx-auto size-8" />
            </a>
        </div>

        <div data-slot="sidebar-content" data-sidebar="content" class="no-scrollbar flex min-h-0 flex-1 flex-col gap-0 overflow-y-auto px-5 duration-300 ease-linear">
            <nav class="mb-6 flex flex-col gap-6">
                                    <div data-slot="sidebar-group" data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-0">
                        <div data-slot="sidebar-group-label" data-sidebar="group-label" class="mb-3 flex h-auto shrink-0 items-center rounded-md p-0 text-xs leading-5 font-medium text-gray-500 uppercase outline-hidden dark:text-gray-400"
                            :class="!showContent ? 'justify-center' : 'justify-start ps-3'">
                            <span x-show="showContent">General</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!showContent" class="size-6">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
                        </div>
                        <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex w-full min-w-0 flex-col gap-1">
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                                                                    <div>
                                            <button type="button" @click="toggle('dashboard')"
                                                class="flex w-full cursor-pointer items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                                :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', (openKeys.includes('dashboard') || selectedKey === 'dashboard' || hasActiveChild([&quot;inventoryManagement&quot;,&quot;productDevelopment&quot;,&quot;finance&quot;,&quot;humanResources&quot;,&quot;supplyChain&quot;])) ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                                    <svg class="size-5 shrink-0 stroke-[1.2px] transition-colors" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M3.333 4.583c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V4.583zM3.333 12.5c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V12.5zM11.25 4.583c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V4.583zM11.25 12.5c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V12.5z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                                <span x-show="showContent" class="min-w-0 truncate">Dashboard</span>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="showContent" class="ms-auto size-5 shrink-0 transition-transform duration-200" :class="openKeys.includes('dashboard') && 'rotate-180'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                            </button>
                                            <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('dashboard')) && 'open'" :inert="!(showContent && openKeys.includes('dashboard'))">
                                                <div>
                                                    <ul class="ms-8 mt-2 flex flex-col space-y-1 border-s border-gray-200 ps-4 dark:border-gray-800">
                                                                                                                    <li>
                                                                <a href="#" @click="selectedKey = 'inventoryManagement'" class="block rounded-lg px-3 py-1.5 text-sm transition-colors"
                                                                    :class="selectedKey === 'inventoryManagement' ? 'font-medium text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90'">Inventory Management</a>
                                                            </li>
                                                                                                                    <li>
                                                                <a href="#" @click="selectedKey = 'productDevelopment'" class="block rounded-lg px-3 py-1.5 text-sm transition-colors"
                                                                    :class="selectedKey === 'productDevelopment' ? 'font-medium text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90'">Product Development</a>
                                                            </li>
                                                                                                                    <li>
                                                                <a href="#" @click="selectedKey = 'finance'" class="block rounded-lg px-3 py-1.5 text-sm transition-colors"
                                                                    :class="selectedKey === 'finance' ? 'font-medium text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90'">Finance</a>
                                                            </li>
                                                                                                                    <li>
                                                                <a href="#" @click="selectedKey = 'humanResources'" class="block rounded-lg px-3 py-1.5 text-sm transition-colors"
                                                                    :class="selectedKey === 'humanResources' ? 'font-medium text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90'">Human Resources</a>
                                                            </li>
                                                                                                                    <li>
                                                                <a href="#" @click="selectedKey = 'supplyChain'" class="block rounded-lg px-3 py-1.5 text-sm transition-colors"
                                                                    :class="selectedKey === 'supplyChain' ? 'font-medium text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white/90'">Supply Chain</a>
                                                            </li>
                                                                                                            </ul>
                                                </div>
                                            </div>
                                        </div>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'profile'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'profile' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg class="size-5 shrink-0 stroke-[1.2px] transition-colors" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.25 16.199s.105-5.417-6.25-5.417S3.75 16.2 3.75 16.2m9.302-10.912a2.995 2.995 0 11-5.991 0 2.995 2.995 0 015.99 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Public Profiles</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'settings'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'settings' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg class="size-5 shrink-0 stroke-[1.2px] transition-colors" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M9.375 2.46a1.25 1.25 0 011.25 0l5.592 3.229c.387.223.625.636.625 1.082v6.458c0 .446-.238.859-.625 1.082l-5.592 3.229a1.25 1.25 0 01-1.25 0L3.783 14.31a1.25 1.25 0 01-.625-1.082V6.77c0-.446.238-.859.625-1.082L9.375 2.46z"
      stroke="currentColor"
      stroke-width="1.2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M12.57 10a2.57 2.57 0 11-5.142 0 2.57 2.57 0 015.142 0z"
      stroke="currentColor"
      stroke-width="1.2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Settings</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'notifications'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'notifications' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5 shrink-0 stroke-[1.2px] transition-colors">
    <path
      d="M9.861 1.876v1.25m0 0a5.625 5.625 0 015.625 5.625v6.041H4.236V8.751a5.625 5.625 0 015.625-5.625zm-1.25 14.166h2.5m-7.917-2.5h13.334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Notifications</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'analytics'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'analytics' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg class="size-5 shrink-0 stroke-[1.2px] transition-colors" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M9.85954 4.0835C9.5834 4.0835 9.35954 4.30735 9.35954 4.5835V15.4161C9.35954 15.6922 9.5834 15.9161 9.85954 15.9161H10.1373C10.4135 15.9161 10.6373 15.6922 10.6373 15.4161V4.5835C10.6373 4.30735 10.4135 4.0835 10.1373 4.0835H9.85954ZM7.85954 4.5835C7.85954 3.47893 8.75497 2.5835 9.85954 2.5835H10.1373C11.2419 2.5835 12.1373 3.47893 12.1373 4.5835V15.4161C12.1373 16.5206 11.2419 17.4161 10.1373 17.4161H9.85954C8.75497 17.4161 7.85954 16.5206 7.85954 15.4161V4.5835ZM4.58203 8.9598C4.30589 8.9598 4.08203 9.18366 4.08203 9.4598V15.4168C4.08203 15.693 4.30589 15.9168 4.58203 15.9168H4.85981C5.13595 15.9168 5.35981 15.693 5.35981 15.4168V9.4598C5.35981 9.18366 5.13595 8.9598 4.85981 8.9598H4.58203ZM2.58203 9.4598C2.58203 8.35523 3.47746 7.4598 4.58203 7.4598H4.85981C5.96438 7.4598 6.85981 8.35523 6.85981 9.4598V15.4168C6.85981 16.5214 5.96438 17.4168 4.85981 17.4168H4.58203C3.47746 17.4168 2.58203 16.5214 2.58203 15.4168V9.4598ZM14.637 12.435C14.637 12.1589 14.8609 11.935 15.137 11.935H15.4148C15.691 11.935 15.9148 12.1589 15.9148 12.435V15.4168C15.9148 15.693 15.691 15.9168 15.4148 15.9168H15.137C14.8609 15.9168 14.637 15.693 14.637 15.4168V12.435ZM15.137 10.435C14.0325 10.435 13.137 11.3304 13.137 12.435V15.4168C13.137 16.5214 14.0325 17.4168 15.137 17.4168H15.4148C16.5194 17.4168 17.4148 16.5214 17.4148 15.4168V12.435C17.4148 11.3304 16.5194 10.435 15.4148 10.435H15.137Z"
      fill="currentColor"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">User Analytics</span>
                                        </a>
                                                                    </li>
                                                    </ul>
                    </div>
                                    <div data-slot="sidebar-group" data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-0">
                        <div data-slot="sidebar-group-label" data-sidebar="group-label" class="mb-3 flex h-auto shrink-0 items-center rounded-md p-0 text-xs leading-5 font-medium text-gray-500 uppercase outline-hidden dark:text-gray-400"
                            :class="!showContent ? 'justify-center' : 'justify-start ps-3'">
                            <span x-show="showContent">Projects</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!showContent" class="size-6">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
                        </div>
                        <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex w-full min-w-0 flex-col gap-1">
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'designEngineering'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'designEngineering' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 stroke-[1.2px] transition-colors">
    <path
      d="M10.678 2.292l-6.69 9.404h5.334v6.012l6.69-9.404h-5.334V2.292z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Design Engineering</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'marketing'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'marketing' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg class="size-5 shrink-0 stroke-[1.2px] transition-colors" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M12 2C11.5858 2 11.25 2.33579 11.25 2.75V12C11.25 12.4142 11.5858 12.75 12 12.75H21.25C21.6642 12.75 22 12.4142 22 12C22 6.47715 17.5228 2 12 2ZM12.75 11.25V3.53263C13.2645 3.57761 13.7659 3.66843 14.25 3.80098V3.80099C15.6929 4.19606 16.9827 4.96184 18.0104 5.98959C19.0382 7.01734 19.8039 8.30707 20.199 9.75C20.3316 10.2341 20.4224 10.7355 20.4674 11.25H12.75ZM2 12C2 7.25083 5.31065 3.27489 9.75 2.25415V3.80099C6.14748 4.78734 3.5 8.0845 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C15.9155 20.5 19.2127 17.8525 20.199 14.25H21.7459C20.7251 18.6894 16.7492 22 12 22C6.47715 22 2 17.5229 2 12Z"
      fill="currentColor"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Sales &amp; Marketing</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'saas'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'saas' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-5 shrink-0 stroke-[1.2px] transition-colors">
    <path
      d="M12 21.072V11.029m0 0c-.23 0-.46-.053-.67-.159m.67.159c.23 0 .46-.053.671-.159m0 0a1.5 1.5 0 01-1.341 0m1.341 0l7.55-3.774M11.33 10.87L3.78 7.096m16.441 0a1.499 1.499 0 00-.592-.533L12.67 3.084a1.5 1.5 0 00-1.341 0L4.372 6.563c-.247.123-.45.309-.592.533m16.441 0a1.5 1.5 0 01.237.808v8.19a1.5 1.5 0 01-.83 1.341l-6.957 3.479a1.5 1.5 0 01-1.341 0l-6.958-3.479a1.5 1.5 0 01-.829-1.342V7.904c0-.292.085-.571.237-.808"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                                                        <span x-show="showContent" class="min-w-0 truncate">SaaS</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'customerSupport'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'customerSupport' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5 shrink-0 stroke-[1.2px] transition-colors">
  <path
    d="M20 17.052V12a8 8 0 10-16 0v5.052m16-3.011v5.709a1.5 1.5 0 01-1.5 1.5H14m-7.5-2.5h-1a1.5 1.5 0 01-1.5-1.5v-3.5a1.5 1.5 0 011.5-1.5h1a1.5 1.5 0 011.5 1.5v3.5a1.5 1.5 0 01-1.5 1.5zm11 0h1a1.5 1.5 0 001.5-1.5v-3.5a1.5 1.5 0 00-1.5-1.5h-1a1.5 1.5 0 00-1.5 1.5v3.5a1.5 1.5 0 001.5 1.5z"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  />
</svg>                                                                                        <span x-show="showContent" class="min-w-0 truncate">Customer Support</span>
                                        </a>
                                                                    </li>
                                                    </ul>
                    </div>
                                    <div data-slot="sidebar-group" data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-0">
                        <div data-slot="sidebar-group-label" data-sidebar="group-label" class="mb-3 flex h-auto shrink-0 items-center rounded-md p-0 text-xs leading-5 font-medium text-gray-500 uppercase outline-hidden dark:text-gray-400"
                            :class="!showContent ? 'justify-center' : 'justify-start ps-3'">
                            <span x-show="showContent">API Reference</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!showContent" class="size-6">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
                        </div>
                        <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex w-full min-w-0 flex-col gap-1">
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'fileConventions'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'fileConventions' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                        <span x-show="showContent" class="min-w-0 truncate">File Conventions</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'versionControl'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'versionControl' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Version Control</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'fileOrganization'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'fileOrganization' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                        <span x-show="showContent" class="min-w-0 truncate">File Organization</span>
                                        </a>
                                                                    </li>
                                                                                            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                                                                            <a href="#" @click="selectedKey = 'backupProcedures'"
                                            class="flex w-full items-center gap-2 rounded-full text-sm font-normal transition-colors"
                                            :class="[showContent ? 'px-3 py-2' : 'mx-auto size-10 justify-center px-0', selectedKey === 'backupProcedures' ? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-white/90' : 'bg-transparent text-gray-500 hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white/90']">
                                                                                        <span x-show="showContent" class="min-w-0 truncate">Backup Procedures</span>
                                        </a>
                                                                    </li>
                                                    </ul>
                    </div>
                            </nav>
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
            <button data-slot="button" type="button" aria-label="Toggle application menu" @click="toggleApplicationMenu()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-gray-700 xl:hidden dark:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
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
            class="w-full items-center justify-between gap-4 px-5 py-4 shadow-theme-md xl:flex xl:justify-end xl:px-0 xl:shadow-none">
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

                                    <div class="contents" x-data="{ notifying: true }">
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-11 rounded-[10px] relative" type="button" aria-label="Toggle notifications" x-on:click.capture="notifying = false"><span x-bind:class="notifying ? 'flex' : 'hidden'" class="absolute end-0 -top-0.5 z-10 h-2 w-2 translate-x-1/2 rounded-full bg-orange-400 rtl:-translate-x-1/2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"></span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-auto!">
    <path
      d="M9.861 1.876v1.25m0 0a5.625 5.625 0 015.625 5.625v6.041H4.236V8.751a5.625 5.625 0 015.625-5.625zm-1.25 14.166h2.5m-7.917-2.5h13.334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:12,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 w-87.5 overflow-hidden p-3 sm:w-90.25 dark:bg-[#1E2635]"><div class="flex items-center justify-between pb-3">
                <h5 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Notification</h5>
                <button data-slot="button" type="button" aria-label="Close notifications" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M18 6L6 18M6 6l12 12" />
  </svg></button>
            </div>

            <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px bg-gray-100 dark:bg-gray-700 my-0"></div>

            <div
    data-slot="scroll-area"
    x-data="{
        show: false,
        thumbHeight: 0,
        thumbTop: 0,
        update() {
            const el = this.$refs.viewport;
            if (!el) return;
            const { scrollTop, scrollHeight, clientHeight } = el;
            this.show = scrollHeight > clientHeight + 1;
            if (!this.show) return;
            const trackHeight = clientHeight;
            this.thumbHeight = Math.max(18, (clientHeight / scrollHeight) * trackHeight);
            this.thumbTop = (scrollTop / (scrollHeight - clientHeight)) * (trackHeight - this.thumbHeight);
        },
        startDrag(e) {
            const el = this.$refs.viewport;
            const startY = e.clientY;
            const startScroll = el.scrollTop;
            const ratio = (el.scrollHeight - el.clientHeight) / (el.clientHeight - this.thumbHeight);
            const move = (ev) => { el.scrollTop = startScroll + (ev.clientY - startY) * ratio; };
            const up = () => { window.removeEventListener('pointermove', move); window.removeEventListener('pointerup', up); };
            window.addEventListener('pointermove', move);
            window.addEventListener('pointerup', up);
        },
    }"
    x-init="$nextTick(() => update()); new ResizeObserver(() => update()).observe($refs.viewport); new ResizeObserver(() => update()).observe($refs.content)"
    
    class="relative h-96"
>
    <div data-slot="scroll-area-viewport" x-ref="viewport" @scroll.passive="update()" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 [scrollbar-width:none] [&amp;::-webkit-scrollbar]:hidden!">
        <div class="min-w-0" x-ref="content"><div class="flex flex-col pe-2">
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-02.jpg" alt="Terry Franci" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">TF</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Terry Franci</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>5 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-03.jpg" alt="Alena Franci" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">AF</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Alena Franci</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>8 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-04.jpg" alt="Jocelyn Kenter" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">JK</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Jocelyn Kenter</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>15 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-05.jpg" alt="Brandon Philips" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">BP</span>
</template>
                                <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Brandon Philips</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>1 hr ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-02.jpg" alt="Terry Franci" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">TF</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Terry Franci</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>5 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-03.jpg" alt="Alena Franci" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">AF</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Alena Franci</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>8 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-04.jpg" alt="Jocelyn Kenter" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">JK</span>
</template>
                                <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Jocelyn Kenter</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>15 min ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-start gap-3 rounded-lg p-3 hover:bg-gray-100 dark:hover:bg-white/5"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-05.jpg" alt="Brandon Philips" class="aspect-square size-full rounded-full object-cover">
                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">BP</span>
</template>
                                <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
                            <span class="block flex-1 text-start">
                                <span class="mb-1.5 block space-x-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-gray-800 dark:text-white/90">Brandon Philips</span>
                                    <span>requests permission to change</span>
                                    <span class="font-medium text-gray-800 dark:text-white/90">Project - Nganter App</span>
                                </span>
                                <span class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span>Project</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-2 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="1" />
  </svg>
                                    <span>1 hr ago</span>
                                </span>
                            </span></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px my-0.5 bg-gray-100 last-of-type:hidden dark:bg-gray-700"></div>
                                    </div></div>
    </div>
    <div
        data-slot="scroll-area-scrollbar"
        data-orientation="vertical"
        x-show="show"
        style="display: none;"
        class="absolute end-0 top-0 flex h-full w-1.5 touch-none rounded-full bg-gray-100 transition-colors select-none dark:bg-gray-800"
    >
        <div
            data-slot="scroll-area-thumb"
            class="absolute start-0 w-full! rounded-full bg-gray-300 transition-colors hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500"
            x-bind:style="`height: ${thumbHeight}px; top: ${thumbTop}px`"
            @pointerdown.prevent="startDrag($event)"
        ></div>
    </div>
</div>

            <a data-slot="button" href="/" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 mt-3 w-full">View All Notifications</a></div>
    </div>
</template></div>
</div>
                                            </div>
                            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="dropdown-toggle flex items-center text-gray-700 dark:text-gray-400" ><span class="me-3 h-11 w-11 overflow-hidden rounded-lg">
            <img width="44" height="44" src="/assets/images/user/owner.png" alt="User" />
        </span>

        <span class="me-1 block text-sm font-medium">Musharof</span>

        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-500 duration-200 dark:text-gray-400" x-bind:class="open ? 'rotate-180' : 'rotate-0'">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

    <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:12,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-65 p-3"><div class="px-3 py-2">
            <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">Musharof Chowdhury</span>
            <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">randomuser@pimjo.com</span>
        </div>

        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 my-1.5 h-px bg-gray-100 dark:bg-gray-700"></div>

        <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="/profile"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path
      d="M17.775 19.107v-.261a4.5 4.5 0 00-4.5-4.5h-2.55a4.5 4.5 0 00-4.5 4.5v.261M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0zm-6.483-2.732a2.768 2.768 0 11-5.536 0 2.768 2.768 0 015.536 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Edit profile</a>

        <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="/profile"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path
      d="M6.775 5.52a1.484 1.484 0 00-2.028.542L3.231 8.688c-.41.71-.166 1.617.543 2.027.99.571.99 1.999 0 2.57a1.484 1.484 0 00-.543 2.027l1.516 2.626c.41.71 1.318.953 2.028.543A1.484 1.484 0 019 19.766c0 .82.664 1.484 1.484 1.484h3.032c.82 0 1.484-.664 1.484-1.484a1.484 1.484 0 012.225-1.285c.71.41 1.617.167 2.027-.543l1.516-2.626c.41-.71.167-1.617-.543-2.027a1.484 1.484 0 010-2.57c.71-.41.953-1.317.543-2.027l-1.516-2.626a1.484 1.484 0 00-2.027-.543 1.483 1.483 0 01-2.225-1.285c0-.82-.664-1.484-1.484-1.484h-3.032c-.82 0-1.484.664-1.484 1.484a1.484 1.484 0 01-2.226 1.285z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M15.085 12a3.085 3.085 0 11-6.17 0 3.085 3.085 0 016.17 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Account settings</a>

        <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="/profile"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Support</a>

        <div data-slot="dropdown-menu-sub" data-ui-root x-data="uiDropdown({ sub: true })" class="contents"><div role="menuitem" tabindex="-1" aria-haspopup="menu" aria-expanded="false" data-state="closed" data-orientation="vertical" data-slot="dropdown-menu-sub-trigger"     x-ref="trigger" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-on:pointermove="highlight($el); show()" x-on:click="show(true)" x-on:keydown="onSubTriggerKeydown($event)"
     class="group/dropdown-menu-sub-trigger relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-open:bg-gray-100 data-open:text-gray-700 data-popup-open:bg-gray-100 data-popup-open:text-gray-700 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-open:bg-white/5 dark:data-open:text-gray-300 dark:data-popup-open:bg-white/5 dark:data-popup-open:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-sub-trigger:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-sub-trigger:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path
      d="M12.001 2.75a9.25 9.25 0 019.25 9.25A9.25 9.25 0 0112 21.25m0-18.5A9.25 9.25 0 002.751 12a9.25 9.25 0 009.25 9.25m0-18.5c2.209 0 4 4.141 4 9.25 0 5.107-1.791 9.25-4 9.25m0-18.5c-2.209 0-3.999 4.141-3.999 9.25 0 5.107 1.79 9.25 3.999 9.25M3.246 9h17.508M3.246 15h17.508"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                <span>Language</span>
                <span data-slot="badge" data-variant="light" data-color="gray" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 [text-shadow:0_4px_4px_var(--color-gray-300)] dark:[text-shadow:0_4px_4px_rgba(255,255,255,0.10)] ms-auto me-1 h-auto gap-1.5 border border-gray-200 bg-gray-50 px-2 py-1 text-xs font-medium text-shadow-none dark:border-gray-800 dark:bg-white/3 dark:text-shadow-none [&amp;&gt;img]:size-3.5"><span>English</span>
                    <img src="/assets/images/icons/flag-us.svg" alt="English" class="size-3.5 shrink-0 overflow-hidden rounded-full" /></span>
    </div>

            <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="right" data-align="start"
            data-slot="dropdown-menu-sub-content" data-options="{&quot;side&quot;:&quot;inline-end&quot;,&quot;sideOffset&quot;:4,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:-3}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] min-w-48 w-56 p-2"><a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="https://laravel-demo.tailadmin.com/locale/en"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer rounded-lg px-3 py-2.5 text-sm font-medium outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between gap-2 bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-400"><span class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full transition-opacity bg-brand-500 opacity-100 dark:bg-brand-400"></span>
                            <img src="/assets/images/icons/flag-us.svg" alt="English" class="size-5 shrink-0 overflow-hidden rounded-full" />
                            <span class="truncate">English</span>
                        </span></a>
                                    <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="https://laravel-demo.tailadmin.com/locale/ar"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between gap-2"><span class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full transition-opacity opacity-0"></span>
                            <img src="/assets/images/icons/flag-sa.svg" alt="Arabic (Saudi)" class="size-5 shrink-0 overflow-hidden rounded-full" />
                            <span class="truncate">Arabic (Saudi)</span>
                        </span>

                                                    <span data-slot="badge" data-variant="light" data-color="warning" data-size="default"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-6 px-2.5 py-0.5 [&amp;:has(&gt;svg:first-child)]:ps-2 [&amp;:has(&gt;svg:last-child)]:pe-2 [&amp;&gt;svg]:size-3.5 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)] rounded text-xs">RTL</span></a>
                                    <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="https://laravel-demo.tailadmin.com/locale/es"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between gap-2"><span class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full transition-opacity opacity-0"></span>
                            <img src="/assets/images/icons/flag-es.svg" alt="Español" class="size-5 shrink-0 overflow-hidden rounded-full" />
                            <span class="truncate">Español</span>
                        </span></a>
                                    <a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="https://laravel-demo.tailadmin.com/locale/de"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between gap-2"><span class="flex items-center gap-2">
                            <span class="size-1.5 shrink-0 rounded-full transition-opacity opacity-0"></span>
                            <img src="/assets/images/icons/flag-de.svg" alt="Deutsch" class="size-5 shrink-0 overflow-hidden rounded-full" />
                            <span class="truncate">Deutsch</span>
                        </span></a></div>
    </div>
</template></div>

        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 my-1.5 h-px bg-gray-100 dark:bg-gray-700"></div>

        <form id="logout-form" method="POST" action="https://laravel-demo.tailadmin.com/logout" class="hidden"><input type="hidden" name="_token" value="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs" autocomplete="off"></form>
        <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="document.getElementById('logout-form').submit()" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" >
    <path
      d="M4 12h7.75M8 8l-3.998 4 3.997 4M9.75 4.996V4.25a1.5 1.5 0 011.5-1.5h6a1.5 1.5 0 011.5 1.5v15.5a1.5 1.5 0 01-1.5 1.5h-6a1.5 1.5 0 01-1.5-1.5V19"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Sign out</div></div>
    </div>
</template></div>
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
        <div class="grid auto-rows-min gap-6 sm:grid-cols-2 xl:grid-cols-3">
            <div class="min-h-dvh rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="min-h-dvh rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="min-h-dvh rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
        </div>
    </div>
                </main>
            </div>
        </div>
    </div>
</body>


</html>
