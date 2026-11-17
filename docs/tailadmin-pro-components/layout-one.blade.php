<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs">

    <title>Layout One | TailAdmin - Laravel Admin Dashboard Template</title>
<meta name="description" content="This is Layout One for TailAdmin - Laravel Tailwind CSS Admin Dashboard Template">

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
            openKeys: ['dashboard'],
            get showContent() { return $store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen; },
            toggle(key) { this.openKeys = this.openKeys.includes(key) ? this.openKeys.filter((k) => k !== key) : [...this.openKeys, key]; },
        }"
        @mouseenter="$store.sidebar.setHovered(true)" @mouseleave="$store.sidebar.setHovered(false)"
        class="fixed inset-y-0 start-0 z-101 flex h-svh w-72.5 flex-col border-e border-gray-200 bg-white text-gray-900 transition-[transform,width] duration-300 ease-in-out max-xl:shadow-theme-lg xl:z-50 dark:border-gray-800 dark:bg-gray-900"
        :class="[$store.sidebar.isMobileOpen ? 'translate-x-0' : 'max-xl:-translate-x-full max-xl:rtl:translate-x-full', ($store.sidebar.isExpanded || $store.sidebar.isHovered) ? '' : 'xl:w-22.5']">
        <div data-slot="sidebar-header" data-sidebar="header" class="flex flex-col gap-2 px-5 pt-5 pb-7">
            <a href="/" aria-label="Go to dashboard" class="flex items-center" :class="showContent ? 'justify-start' : 'justify-center'">
                <template x-if="showContent">
                    <span>
                        <img class="h-8 w-38.5 dark:hidden" src="/assets/images/logo/logo.svg" alt="Logo" />
                        <img class="hidden h-8 w-38.5 dark:block" src="/assets/images/logo/logo-dark.svg" alt="Logo" />
                    </span>
                </template>
                <img x-show="!showContent" src="/assets/images/logo/logo-icon.svg" alt="Logo" class="size-8" />
            </a>
        </div>

        <div data-slot="sidebar-content" data-sidebar="content" class="no-scrollbar flex min-h-0 flex-1 flex-col gap-0 overflow-y-auto px-5 duration-300 ease-linear">
            <nav class="mb-6">
                <div data-slot="sidebar-group" data-sidebar="group" class="relative flex w-full min-w-0 flex-col p-0">
                    <div data-slot="sidebar-group-label" data-sidebar="group-label" class="mb-4 flex h-auto shrink-0 items-center rounded-md p-0 text-xs leading-5 font-medium text-gray-400 uppercase outline-hidden"
                        :class="!showContent ? 'justify-center' : 'justify-start'">
                        <span x-show="showContent">MENU</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!showContent" class="size-6">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
                    </div>
                    <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1 w-full ">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('dashboard')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('dashboard') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M3.333 4.583c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V4.583zM3.333 12.5c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V12.5zM11.25 4.583c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V4.583zM11.25 12.5c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V12.5z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Dashboard</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('dashboard')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('dashboard')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('dashboard')) && 'open'" :inert="!(showContent && openKeys.includes('dashboard'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Ecommerce</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Analytics</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Marketing</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('crm')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('crm') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">CRM</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('crm')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('crm')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('crm')) && 'open'" :inert="!(showContent && openKeys.includes('crm'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Inventory Management</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Product Development</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Finance</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Human Resources</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Supply Chain</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Stocks</span>
                                            <span x-show="showContent" class="ms-auto menu-dropdown-badge shrink-0 menu-dropdown-badge-inactive whitespace-nowrap">New</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">SaaS</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Logistics</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="/sales"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Sales</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="/ai"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">AI</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('ai')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('ai') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M18.75 2.43v5.274m-9.327 5.969A3.287 3.287 0 0012 14.916a3.287 3.287 0 002.578-1.243M20 12v6.5a1.5 1.5 0 01-1.5 1.5h-13A1.5 1.5 0 014 18.5V12a8 8 0 1116 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M18.75 2.43v.01M9.504 9.875v.01m4.992-.01v.01"
      stroke="currentColor"
      stroke-width="2.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">AI Assistant</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('ai')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('ai')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('ai')) && 'open'" :inert="!(showContent && openKeys.includes('ai'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Text Generator</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Image Generator</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Code Generator</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Video Generator</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('ecommerceMenu')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('ecommerceMenu') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.316 4h1.181a1.5 1.5 0 011.485 1.291l.152 1.08m0 0l1.102 7.838A1.5 1.5 0 007.722 15.5h9.361a1.5 1.5 0 001.376-.901l2.667-6.129a1.5 1.5 0 00-1.375-2.098H5.134z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M7.783 19.5h.01m8.527 0h.01"
      stroke="currentColor"
      stroke-width="3.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">E-commerce</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('ecommerceMenu')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('ecommerceMenu')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('ecommerceMenu')) && 'open'" :inert="!(showContent && openKeys.includes('ecommerceMenu'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Products</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Add Product</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Billing</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('invoices')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('invoices') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Invoices</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('invoices')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('invoices')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('invoices')) && 'open'" :inert="!(showContent && openKeys.includes('invoices'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Invoices List</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Single Invoice</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Create Invoice</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Transactions</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Single Transaction</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive menu-item menu-item-inactive">
                                            <svg width="24" height="24" class="menu-item-icon-inactive" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
                                        <span x-show="showContent" class="min-w-0 truncate menu-item-text">Calendar</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive menu-item menu-item-inactive">
                                            <svg width="24" height="24" class="menu-item-icon-inactive" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path
      d="M17.775 19.107v-.261a4.5 4.5 0 00-4.5-4.5h-2.55a4.5 4.5 0 00-4.5 4.5v.261M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0zm-6.483-2.732a2.768 2.768 0 11-5.536 0 2.768 2.768 0 015.536 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        <span x-show="showContent" class="min-w-0 truncate menu-item-text">User Profile</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('task')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('task') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M7.75586 5.50098C7.75586 5.08676 8.09165 4.75098 8.50586 4.75098H18.4985C18.9127 4.75098 19.2485 5.08676 19.2485 5.50098L19.2485 15.4956C19.2485 15.9098 18.9127 16.2456 18.4985 16.2456H8.50586C8.09165 16.2456 7.75586 15.9098 7.75586 15.4956V5.50098ZM8.50586 3.25098C7.26322 3.25098 6.25586 4.25834 6.25586 5.50098V6.26318H5.50195C4.25931 6.26318 3.25195 7.27054 3.25195 8.51318V18.4995C3.25195 19.7422 4.25931 20.7495 5.50195 20.7495H15.4883C16.7309 20.7495 17.7383 19.7421 17.7383 18.4995L17.7383 17.7456H18.4985C19.7411 17.7456 20.7485 16.7382 20.7485 15.4956L20.7485 5.50097C20.7485 4.25833 19.7411 3.25098 18.4985 3.25098H8.50586ZM16.2383 17.7456H8.50586C7.26322 17.7456 6.25586 16.7382 6.25586 15.4956V7.76318H5.50195C5.08774 7.76318 4.75195 8.09897 4.75195 8.51318V18.4995C4.75195 18.9137 5.08774 19.2495 5.50195 19.2495H15.4883C15.9025 19.2495 16.2383 18.9137 16.2383 18.4995L16.2383 17.7456Z"
      fill="currentColor"
    ></path>
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Task</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('task')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('task')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('task')) && 'open'" :inert="!(showContent && openKeys.includes('task'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">List</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Kanban</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('forms')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('forms') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.5 3.25A2.25 2.25 0 003.25 5.5v13a2.25 2.25 0 002.25 2.25h13a2.25 2.25 0 002.25-2.25v-13a2.25 2.25 0 00-2.25-2.25h-13zM4.75 5.5a.75.75 0 01.75-.75h13a.75.75 0 01.75.75v13a.75.75 0 01-.75.75h-13a.75.75 0 01-.75-.75v-13zm1.5 4.214a.75.75 0 01.75-.75h10a.75.75 0 110 1.5H7a.75.75 0 01-.75-.75zm0 4.572a.75.75 0 01.75-.75h10a.75.75 0 110 1.5H7a.75.75 0 01-.75-.75z"
      fill="currentColor"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Forms</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('forms')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('forms')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('forms')) && 'open'" :inert="!(showContent && openKeys.includes('forms'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Form Elements</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Form Layout</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('tables')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('tables') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z"
      fill="currentColor"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Tables</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('tables')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('tables')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('tables')) && 'open'" :inert="!(showContent && openKeys.includes('tables'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Basic Tables</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Data Tables</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('pages')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('pages') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                    <svg width="24" height="24" :class="$class" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z"
      fill="currentColor"
    />
  </svg>
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Pages</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('pages')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('pages')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('pages')) && 'open'" :inert="!(showContent && openKeys.includes('pages'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">File Manager</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Pricing Tables</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">FAQ</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">API Keys</span>
                                            <span x-show="showContent" class="ms-auto menu-dropdown-badge shrink-0 menu-dropdown-badge-inactive whitespace-nowrap">New</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Integrations</span>
                                            <span x-show="showContent" class="ms-auto menu-dropdown-badge shrink-0 menu-dropdown-badge-inactive whitespace-nowrap">New</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Blank Page</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <div class="w-full min-w-0">
                    <button type="button" @click="toggle('errorPages')"
                        class="group menu-item w-full min-w-0 cursor-pointer"
                        :class="[openKeys.includes('errorPages') ? 'menu-item-active' : 'menu-item-inactive', !showContent && 'justify-center']">
                                                <span x-show="showContent" class="menu-item-text min-w-0 truncate">Error Pages</span>
                                                <template x-if="showContent">
                            <span class="ms-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="openKeys.includes('errorPages')" class="h-5 w-5 text-brand-500">
    <path d="M5 12h14" />
  </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="!openKeys.includes('errorPages')" class="h-5 w-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                            </span>
                        </template>
                    </button>
                    <div class="menu-accordion w-full min-w-0" :class="(showContent && openKeys.includes('errorPages')) && 'open'" :inert="!(showContent && openKeys.includes('errorPages'))">
                        <div>
                            <ul data-slot="sidebar-menu" data-sidebar="menu" class="flex min-w-0 flex-col gap-1  ms-6 mt-2 w-auto border-s border-gray-200 ps-4 dark:border-gray-800">
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">404 Error</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">500 Error</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">503 Error</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Coming Soon</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Maintenance</span>
                                    </a>
                    </li>
            <li data-slot="sidebar-menu-item" data-sidebar="menu-item" class="group/menu-item relative">
                            <a href="#"
                    class="group menu-dropdown-item w-full min-w-0 menu-dropdown-item-inactive ">
                                        <span x-show="showContent" class="min-w-0 truncate ">Success</span>
                                    </a>
                    </li>
    </ul>
                        </div>
                    </div>
                </div>
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
            <div class="col-span-2 min-h-dvh rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
            <div class="col-span-1 min-h-dvh rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-white/3"></div>
        </div>
    </div>
                </main>
            </div>
        </div>
    </div>
</body>


</html>
