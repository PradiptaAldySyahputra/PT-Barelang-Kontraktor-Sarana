<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="KCl8Hc8wJWtMiUQ7IJwhj4Hp2sCgzgk18JKb9ln8">

    <title>Laravel AI Account Settings | TailAdmin - Laravel Dashboard Template</title>
<meta name="description" content="This is AI Account Settings page for TailAdmin">

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

<body>

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

    <div class="h-svh overflow-hidden xl:flex sidebar-expanded" x-data :class="{ 'sidebar-expanded': $store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen }">
        <aside id="sidebar"
    class="fixed flex flex-col mt-0 top-0 px-5 start-0 bg-white dark:bg-gray-900 dark:border-gray-800 text-gray-900 h-screen transition-all duration-300 ease-in-out max-xl:duration-200 max-xl:w-[290px] z-50 max-xl:z-101 ltr:border-r rtl:border-l border-gray-200 w-[90px] [.sidebar-expanded_&]:min-w-[290px]"
    x-data="{
        openSubmenus: {},
        init() {
            // Auto-open Dashboard menu on page load
            this.initializeActiveMenus();
        },
        initializeActiveMenus() {
            const currentPath = 'ai-settings/account';

                                                                        // Check if any submenu item matches current path
                                                    if (currentPath === 'ecommerce' ||
                                window.location.pathname === '/ecommerce' ||
                                ('/ecommerce' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'analytics' ||
                                window.location.pathname === '/analytics' ||
                                ('/analytics' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'marketing' ||
                                window.location.pathname === '/marketing' ||
                                ('/marketing' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'crm' ||
                                window.location.pathname === '/crm' ||
                                ('/crm' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'stocks' ||
                                window.location.pathname === '/stocks' ||
                                ('/stocks' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'saas' ||
                                window.location.pathname === '/saas' ||
                                ('/saas' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'logistics' ||
                                window.location.pathname === '/logistics' ||
                                ('/logistics' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'ai' ||
                                window.location.pathname === '/ai' ||
                                ('/ai' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'sales' ||
                                window.location.pathname === '/sales' ||
                                ('/sales' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'finance' ||
                                window.location.pathname === '/finance' ||
                                ('/finance' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                             if (currentPath === 'hr' ||
                                window.location.pathname === '/hr' ||
                                ('/hr' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-0'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'ai-chat/text' ||
                                window.location.pathname === '/ai-chat/text' ||
                                ('/ai-chat/text' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-1'] = true;
                            }                             if (currentPath === 'ai-chat/image' ||
                                window.location.pathname === '/ai-chat/image' ||
                                ('/ai-chat/image' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-1'] = true;
                            }                             if (currentPath === 'ai-chat/code' ||
                                window.location.pathname === '/ai-chat/code' ||
                                ('/ai-chat/code' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-1'] = true;
                            }                             if (currentPath === 'ai-chat/video' ||
                                window.location.pathname === '/ai-chat/video' ||
                                ('/ai-chat/video' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-1'] = true;
                            }                             if (currentPath === 'ai-settings' ||
                                window.location.pathname === '/ai-settings' ||
                                ('/ai-settings' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-1'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'products-list' ||
                                window.location.pathname === '/products-list' ||
                                ('/products-list' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'add-product' ||
                                window.location.pathname === '/add-product' ||
                                ('/add-product' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'billing' ||
                                window.location.pathname === '/billing' ||
                                ('/billing' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'invoices' ||
                                window.location.pathname === '/invoices' ||
                                ('/invoices' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'single-invoice' ||
                                window.location.pathname === '/single-invoice' ||
                                ('/single-invoice' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'create-invoice' ||
                                window.location.pathname === '/create-invoice' ||
                                ('/create-invoice' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'transactions' ||
                                window.location.pathname === '/transactions' ||
                                ('/transactions' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                             if (currentPath === 'single-transaction' ||
                                window.location.pathname === '/single-transaction' ||
                                ('/single-transaction' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-2'] = true;
                            }                                                                                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'task-list' ||
                                window.location.pathname === '/task-list' ||
                                ('/task-list' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-5'] = true;
                            }                             if (currentPath === 'task-kanban' ||
                                window.location.pathname === '/task-kanban' ||
                                ('/task-kanban' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-5'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'form-elements' ||
                                window.location.pathname === '/form-elements' ||
                                ('/form-elements' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-6'] = true;
                            }                             if (currentPath === 'form-layout' ||
                                window.location.pathname === '/form-layout' ||
                                ('/form-layout' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-6'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'basic-tables' ||
                                window.location.pathname === '/basic-tables' ||
                                ('/basic-tables' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-7'] = true;
                            }                             if (currentPath === 'data-tables' ||
                                window.location.pathname === '/data-tables' ||
                                ('/data-tables' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-7'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'file-manager' ||
                                window.location.pathname === '/file-manager' ||
                                ('/file-manager' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'pricing-tables' ||
                                window.location.pathname === '/pricing-tables' ||
                                ('/pricing-tables' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'faq' ||
                                window.location.pathname === '/faq' ||
                                ('/faq' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'api-keys' ||
                                window.location.pathname === '/api-keys' ||
                                ('/api-keys' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'integrations' ||
                                window.location.pathname === '/integrations' ||
                                ('/integrations' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'blank' ||
                                window.location.pathname === '/blank' ||
                                ('/blank' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'error-404' ||
                                window.location.pathname === '/error-404' ||
                                ('/error-404' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'error-500' ||
                                window.location.pathname === '/error-500' ||
                                ('/error-500' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'error-503' ||
                                window.location.pathname === '/error-503' ||
                                ('/error-503' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'coming-soon' ||
                                window.location.pathname === '/coming-soon' ||
                                ('/coming-soon' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'maintenance' ||
                                window.location.pathname === '/maintenance' ||
                                ('/maintenance' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                             if (currentPath === 'success' ||
                                window.location.pathname === '/success' ||
                                ('/success' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-8'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'layout-one' ||
                                window.location.pathname === '/layout-one' ||
                                ('/layout-one' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                             if (currentPath === 'layout-two' ||
                                window.location.pathname === '/layout-two' ||
                                ('/layout-two' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                             if (currentPath === 'layout-three' ||
                                window.location.pathname === '/layout-three' ||
                                ('/layout-three' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                             if (currentPath === 'layout-four' ||
                                window.location.pathname === '/layout-four' ||
                                ('/layout-four' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                             if (currentPath === 'layout-five' ||
                                window.location.pathname === '/layout-five' ||
                                ('/layout-five' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                             if (currentPath === 'layout-six' ||
                                window.location.pathname === '/layout-six' ||
                                ('/layout-six' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-9'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'empty-state-one' ||
                                window.location.pathname === '/empty-state-one' ||
                                ('/empty-state-one' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-10'] = true;
                            }                             if (currentPath === 'empty-state-two' ||
                                window.location.pathname === '/empty-state-two' ||
                                ('/empty-state-two' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-10'] = true;
                            }                             if (currentPath === 'empty-state-three' ||
                                window.location.pathname === '/empty-state-three' ||
                                ('/empty-state-three' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-10'] = true;
                            }                             if (currentPath === 'empty-state-four' ||
                                window.location.pathname === '/empty-state-four' ||
                                ('/empty-state-four' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-10'] = true;
                            }                             if (currentPath === 'empty-state-five' ||
                                window.location.pathname === '/empty-state-five' ||
                                ('/empty-state-five' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['0-10'] = true;
                            }                                                                                                                                 // Check if any submenu item matches current path
                                                    if (currentPath === 'support-tickets' ||
                                window.location.pathname === '/support-tickets' ||
                                ('/support-tickets' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['1-1'] = true;
                            }                             if (currentPath === 'support-ticket-reply' ||
                                window.location.pathname === '/support-ticket-reply' ||
                                ('/support-ticket-reply' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['1-1'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'inbox' ||
                                window.location.pathname === '/inbox' ||
                                ('/inbox' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['1-2'] = true;
                            }                             if (currentPath === 'inbox-details' ||
                                window.location.pathname === '/inbox-details' ||
                                ('/inbox-details' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['1-2'] = true;
                            }                                                                                                 // Check if any submenu item matches current path
                                                    if (currentPath === 'line-chart' ||
                                window.location.pathname === '/line-chart' ||
                                ('/line-chart' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-0'] = true;
                            }                             if (currentPath === 'bar-chart' ||
                                window.location.pathname === '/bar-chart' ||
                                ('/bar-chart' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-0'] = true;
                            }                             if (currentPath === 'pie-chart' ||
                                window.location.pathname === '/pie-chart' ||
                                ('/pie-chart' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-0'] = true;
                            }                             if (currentPath === 'radar-chart' ||
                                window.location.pathname === '/radar-chart' ||
                                ('/radar-chart' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-0'] = true;
                            }                             if (currentPath === 'radial-chart' ||
                                window.location.pathname === '/radial-chart' ||
                                ('/radial-chart' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-0'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'maps' ||
                                window.location.pathname === '/maps' ||
                                ('/maps' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-1'] = true;
                            }                             if (currentPath === 'vector-maps' ||
                                window.location.pathname === '/vector-maps' ||
                                ('/vector-maps' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-1'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'alerts' ||
                                window.location.pathname === '/alerts' ||
                                ('/alerts' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'avatars' ||
                                window.location.pathname === '/avatars' ||
                                ('/avatars' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'badge' ||
                                window.location.pathname === '/badge' ||
                                ('/badge' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'breadcrumb' ||
                                window.location.pathname === '/breadcrumb' ||
                                ('/breadcrumb' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'buttons' ||
                                window.location.pathname === '/buttons' ||
                                ('/buttons' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'cards' ||
                                window.location.pathname === '/cards' ||
                                ('/cards' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'carousel' ||
                                window.location.pathname === '/carousel' ||
                                ('/carousel' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'dropdowns' ||
                                window.location.pathname === '/dropdowns' ||
                                ('/dropdowns' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'images' ||
                                window.location.pathname === '/images' ||
                                ('/images' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'links' ||
                                window.location.pathname === '/links' ||
                                ('/links' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'list' ||
                                window.location.pathname === '/list' ||
                                ('/list' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'dialogs' ||
                                window.location.pathname === '/dialogs' ||
                                ('/dialogs' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'notifications' ||
                                window.location.pathname === '/notifications' ||
                                ('/notifications' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'pagination' ||
                                window.location.pathname === '/pagination' ||
                                ('/pagination' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'popovers' ||
                                window.location.pathname === '/popovers' ||
                                ('/popovers' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'progress-bar' ||
                                window.location.pathname === '/progress-bar' ||
                                ('/progress-bar' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'ribbons' ||
                                window.location.pathname === '/ribbons' ||
                                ('/ribbons' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'spinners' ||
                                window.location.pathname === '/spinners' ||
                                ('/spinners' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'tabs' ||
                                window.location.pathname === '/tabs' ||
                                ('/tabs' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'tooltips' ||
                                window.location.pathname === '/tooltips' ||
                                ('/tooltips' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                             if (currentPath === 'videos' ||
                                window.location.pathname === '/videos' ||
                                ('/videos' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-2'] = true;
                            }                                                                     // Check if any submenu item matches current path
                                                    if (currentPath === 'signin' ||
                                window.location.pathname === '/signin' ||
                                ('/signin' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-3'] = true;
                            }                             if (currentPath === 'signup' ||
                                window.location.pathname === '/signup' ||
                                ('/signup' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-3'] = true;
                            }                             if (currentPath === 'reset-password' ||
                                window.location.pathname === '/reset-password' ||
                                ('/reset-password' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-3'] = true;
                            }                             if (currentPath === 'two-step-verification' ||
                                window.location.pathname === '/two-step-verification' ||
                                ('/two-step-verification' === '/ai-settings' && window.location.pathname.startsWith('/ai-settings'))) {
                                this.openSubmenus['2-3'] = true;
                            }                                             },
        toggleSubmenu(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            const newState = !this.openSubmenus[key];

            // Close all other submenus when opening a new one
            if (newState) {
                this.openSubmenus = {};
            }

            this.openSubmenus[key] = newState;
        },
        isSubmenuOpen(groupIndex, itemIndex) {
            const key = groupIndex + '-' + itemIndex;
            return this.openSubmenus[key] || false;
        },
        isActive(path) {
            return window.location.pathname === path || (path === '/ai-settings' && window.location.pathname.startsWith('/ai-settings')) || 'ai-settings/account' === path.replace(/^\//, '');
        }
    }"
    :class="{
        'translate-x-0': $store.sidebar.isMobileOpen,
        'max-xl:-translate-x-full max-xl:rtl:translate-x-full': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)">
    <!-- Logo Section -->
    <div class="flex flex-col gap-2 pt-5 pb-8">
        <a href="/" class="flex items-center"
            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ? 'justify-center' : 'justify-start'">
            <div class="hidden [.sidebar-expanded_&]:block">
                <img class="h-10 w-37.5 dark:hidden" src="/assets/images/logo/logo.svg" alt="Logo" />
                <img class="hidden h-10 w-37.5 dark:block" src="/assets/images/logo/logo-dark.svg" alt="Logo" />
            </div>
            <img class="block size-8 [.sidebar-expanded_&]:hidden" src="/assets/images/logo/logo-icon.svg" alt="Logo" />
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <nav class="mb-6">
            <div class="flex flex-col gap-4">
                                    <div>
                        <!-- Menu Group Title -->
                        <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                            'lg:justify-center' : 'justify-start'">
                            <template
                                x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>Menu</span>
                            </template>
                            <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="currentColor"/>
                                </svg>
                            </template>
                        </h2>

                        <!-- Menu Items -->
                        <ul class="flex flex-col gap-1">
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 0)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 0) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 0) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V8.99998C3.25 10.2426 4.25736 11.25 5.5 11.25H9C10.2426 11.25 11.25 10.2426 11.25 8.99998V5.5C11.25 4.25736 10.2426 3.25 9 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H9C9.41421 4.75 9.75 5.08579 9.75 5.5V8.99998C9.75 9.41419 9.41421 9.74998 9 9.74998H5.5C5.08579 9.74998 4.75 9.41419 4.75 8.99998V5.5ZM5.5 12.75C4.25736 12.75 3.25 13.7574 3.25 15V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H9C10.2426 20.75 11.25 19.7427 11.25 18.5V15C11.25 13.7574 10.2426 12.75 9 12.75H5.5ZM4.75 15C4.75 14.5858 5.08579 14.25 5.5 14.25H9C9.41421 14.25 9.75 14.5858 9.75 15V18.5C9.75 18.9142 9.41421 19.25 9 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V15ZM12.75 5.5C12.75 4.25736 13.7574 3.25 15 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V8.99998C20.75 10.2426 19.7426 11.25 18.5 11.25H15C13.7574 11.25 12.75 10.2426 12.75 8.99998V5.5ZM15 4.75C14.5858 4.75 14.25 5.08579 14.25 5.5V8.99998C14.25 9.41419 14.5858 9.74998 15 9.74998H18.5C18.9142 9.74998 19.25 9.41419 19.25 8.99998V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H15ZM15 12.75C13.7574 12.75 12.75 13.7574 12.75 15V18.5C12.75 19.7426 13.7574 20.75 15 20.75H18.5C19.7426 20.75 20.75 19.7427 20.75 18.5V15C20.75 13.7574 19.7426 12.75 18.5 12.75H15ZM14.25 15C14.25 14.5858 14.5858 14.25 15 14.25H18.5C18.9142 14.25 19.25 14.5858 19.25 15V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15C14.5858 19.25 14.25 18.9142 14.25 18.5V15Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Dashboard
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 0) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 0) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 0) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/ecommerce"  class="menu-dropdown-item"
                                                                :class="isActive('/ecommerce') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Ecommerce
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/analytics"  class="menu-dropdown-item"
                                                                :class="isActive('/analytics') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Analytics
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/marketing"  class="menu-dropdown-item"
                                                                :class="isActive('/marketing') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Marketing
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/crm"  class="menu-dropdown-item"
                                                                :class="isActive('/crm') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                CRM
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/stocks"  class="menu-dropdown-item"
                                                                :class="isActive('/stocks') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Stocks
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/saas"  class="menu-dropdown-item"
                                                                :class="isActive('/saas') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                SaaS
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/logistics"  class="menu-dropdown-item"
                                                                :class="isActive('/logistics') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Logistics
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ai"  class="menu-dropdown-item"
                                                                :class="isActive('/ai') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                AI
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/ai') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/sales"  class="menu-dropdown-item"
                                                                :class="isActive('/sales') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Sales
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/sales') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/finance"  class="menu-dropdown-item"
                                                                :class="isActive('/finance') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Finance
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/finance') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/hr"  class="menu-dropdown-item"
                                                                :class="isActive('/hr') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                HR
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/hr') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 1)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 1) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 1) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.75 2.42969V7.70424M9.42261 13.673C10.0259 14.4307 10.9562 14.9164 12 14.9164C13.0438 14.9164 13.9742 14.4307 14.5775 13.673M20 12V18.5C20 19.3284 19.3284 20 18.5 20H5.5C4.67157 20 4 19.3284 4 18.5V12C4 7.58172 7.58172 4 12 4C16.4183 4 20 7.58172 20 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M18.75 2.42969V2.43969M9.50391 9.875L9.50391 9.885M14.4961 9.875V9.885" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                AI Assistant
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 1) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/ai-chat/text"  class="menu-dropdown-item"
                                                                :class="isActive('/ai-chat/text') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Text Generator
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ai-chat/image"  class="menu-dropdown-item"
                                                                :class="isActive('/ai-chat/image') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Image Generator
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ai-chat/code"  class="menu-dropdown-item"
                                                                :class="isActive('/ai-chat/code') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Code Generator
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ai-chat/video"  class="menu-dropdown-item"
                                                                :class="isActive('/ai-chat/video') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Video Generator
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ai-settings"  class="menu-dropdown-item"
                                                                :class="isActive('/ai-settings') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                AI Settings
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 2)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 2) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 2) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.31641 4H3.49696C4.24468 4 4.87822 4.55068 4.98234 5.29112L5.13429 6.37161M5.13429 6.37161L6.23641 14.2089C6.34053 14.9493 6.97407 15.5 7.72179 15.5L17.0833 15.5C17.6803 15.5 18.2205 15.146 18.4587 14.5986L21.126 8.47023C21.5572 7.4795 20.8312 6.37161 19.7507 6.37161H5.13429Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.7832 19.5H7.7932M16.3203 19.5H16.3303" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                E-commerce
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 2) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/products-list"  class="menu-dropdown-item"
                                                                :class="isActive('/products-list') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Products
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/add-product"  class="menu-dropdown-item"
                                                                :class="isActive('/add-product') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Add Product
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/billing"  class="menu-dropdown-item"
                                                                :class="isActive('/billing') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Billing
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/invoices"  class="menu-dropdown-item"
                                                                :class="isActive('/invoices') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Invoices
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/single-invoice"  class="menu-dropdown-item"
                                                                :class="isActive('/single-invoice') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Single Invoice
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/create-invoice"  class="menu-dropdown-item"
                                                                :class="isActive('/create-invoice') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Create Invoice
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/transactions"  class="menu-dropdown-item"
                                                                :class="isActive('/transactions') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Transactions
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/single-transaction"  class="menu-dropdown-item"
                                                                :class="isActive('/single-transaction') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Single Transaction
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Simple Menu Item -->
                                        <a href="/calendar"  class="menu-item group"
                                            :class="[
                                                isActive('/calendar') ? 'menu-item-active' :
                                                'menu-item-inactive',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                                                'xl:justify-center' :
                                                'justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span
                                                :class="isActive('/calendar') ? 'menu-item-icon-active' :
                                                    'menu-item-icon-inactive'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M8 2C8.41421 2 8.75 2.33579 8.75 2.75V3.75H15.25V2.75C15.25 2.33579 15.5858 2 16 2C16.4142 2 16.75 2.33579 16.75 2.75V3.75H18.5C19.7426 3.75 20.75 4.75736 20.75 6V9V19C20.75 20.2426 19.7426 21.25 18.5 21.25H5.5C4.25736 21.25 3.25 20.2426 3.25 19V9V6C3.25 4.75736 4.25736 3.75 5.5 3.75H7.25V2.75C7.25 2.33579 7.58579 2 8 2ZM8 5.25H5.5C5.08579 5.25 4.75 5.58579 4.75 6V8.25H19.25V6C19.25 5.58579 18.9142 5.25 18.5 5.25H16H8ZM19.25 9.75H4.75V19C4.75 19.4142 5.08579 19.75 5.5 19.75H18.5C18.9142 19.75 19.25 19.4142 19.25 19V9.75Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Calendar
                                                                                            </span>
                                        </a>
                                                                    </li>
                                                            <li>
                                                                            <!-- Simple Menu Item -->
                                        <a href="/profile"  class="menu-item group"
                                            :class="[
                                                isActive('/profile') ? 'menu-item-active' :
                                                'menu-item-inactive',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                                                'xl:justify-center' :
                                                'justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span
                                                :class="isActive('/profile') ? 'menu-item-icon-active' :
                                                    'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 14.1526 4.3002 16.1184 5.61936 17.616C6.17279 15.3096 8.24852 13.5955 10.7246 13.5955H13.2746C15.7509 13.5955 17.8268 15.31 18.38 17.6167C19.6996 16.119 20.5 14.153 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM17.0246 18.8566V18.8455C17.0246 16.7744 15.3457 15.0955 13.2746 15.0955H10.7246C8.65354 15.0955 6.97461 16.7744 6.97461 18.8455V18.856C8.38223 19.8895 10.1198 20.5 12 20.5C13.8798 20.5 15.6171 19.8898 17.0246 18.8566ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9991 7.25C10.8847 7.25 9.98126 8.15342 9.98126 9.26784C9.98126 10.3823 10.8847 11.2857 11.9991 11.2857C13.1135 11.2857 14.0169 10.3823 14.0169 9.26784C14.0169 8.15342 13.1135 7.25 11.9991 7.25ZM8.48126 9.26784C8.48126 7.32499 10.0563 5.75 11.9991 5.75C13.9419 5.75 15.5169 7.32499 15.5169 9.26784C15.5169 11.2107 13.9419 12.7857 11.9991 12.7857C10.0563 12.7857 8.48126 11.2107 8.48126 9.26784Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                User Profile
                                                                                            </span>
                                        </a>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 5)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 5) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 5) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.75586 5.50098C7.75586 5.08676 8.09165 4.75098 8.50586 4.75098H18.4985C18.9127 4.75098 19.2485 5.08676 19.2485 5.50098L19.2485 15.4956C19.2485 15.9098 18.9127 16.2456 18.4985 16.2456H8.50586C8.09165 16.2456 7.75586 15.9098 7.75586 15.4956V5.50098ZM8.50586 3.25098C7.26322 3.25098 6.25586 4.25834 6.25586 5.50098V6.26318H5.50195C4.25931 6.26318 3.25195 7.27054 3.25195 8.51318V18.4995C3.25195 19.7422 4.25931 20.7495 5.50195 20.7495H15.4883C16.7309 20.7495 17.7383 19.7421 17.7383 18.4995L17.7383 17.7456H18.4985C19.7411 17.7456 20.7485 16.7382 20.7485 15.4956L20.7485 5.50097C20.7485 4.25833 19.7411 3.25098 18.4985 3.25098H8.50586ZM16.2383 17.7456H8.50586C7.26322 17.7456 6.25586 16.7382 6.25586 15.4956V7.76318H5.50195C5.08774 7.76318 4.75195 8.09897 4.75195 8.51318V18.4995C4.75195 18.9137 5.08774 19.2495 5.50195 19.2495H15.4883C15.9025 19.2495 16.2383 18.9137 16.2383 18.4995L16.2383 17.7456Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Task
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 5) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 5) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 5) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/task-list"  class="menu-dropdown-item"
                                                                :class="isActive('/task-list') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                List
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/task-kanban"  class="menu-dropdown-item"
                                                                :class="isActive('/task-kanban') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Kanban
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 6)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 6) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 6) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 3.25C4.25736 3.25 3.25 4.25736 3.25 5.5V18.5C3.25 19.7426 4.25736 20.75 5.5 20.75H18.5001C19.7427 20.75 20.7501 19.7426 20.7501 18.5V5.5C20.7501 4.25736 19.7427 3.25 18.5001 3.25H5.5ZM4.75 5.5C4.75 5.08579 5.08579 4.75 5.5 4.75H18.5001C18.9143 4.75 19.2501 5.08579 19.2501 5.5V18.5C19.2501 18.9142 18.9143 19.25 18.5001 19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5V5.5ZM6.25005 9.7143C6.25005 9.30008 6.58583 8.9643 7.00005 8.9643L17 8.96429C17.4143 8.96429 17.75 9.30008 17.75 9.71429C17.75 10.1285 17.4143 10.4643 17 10.4643L7.00005 10.4643C6.58583 10.4643 6.25005 10.1285 6.25005 9.7143ZM6.25005 14.2857C6.25005 13.8715 6.58583 13.5357 7.00005 13.5357H17C17.4143 13.5357 17.75 13.8715 17.75 14.2857C17.75 14.6999 17.4143 15.0357 17 15.0357H7.00005C6.58583 15.0357 6.25005 14.6999 6.25005 14.2857Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Forms
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 6) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 6) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 6) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/form-elements"  class="menu-dropdown-item"
                                                                :class="isActive('/form-elements') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Form Elements
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/form-layout"  class="menu-dropdown-item"
                                                                :class="isActive('/form-layout') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Form Layout
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 7)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 7) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 7) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Tables
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 7) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 7) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 7) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/basic-tables"  class="menu-dropdown-item"
                                                                :class="isActive('/basic-tables') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Basic Tables
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/data-tables"  class="menu-dropdown-item"
                                                                :class="isActive('/data-tables') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Data Tables
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 8)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 8) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 8) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M8.50391 4.25C8.50391 3.83579 8.83969 3.5 9.25391 3.5H15.2777C15.4766 3.5 15.6674 3.57902 15.8081 3.71967L18.2807 6.19234C18.4214 6.333 18.5004 6.52376 18.5004 6.72268V16.75C18.5004 17.1642 18.1646 17.5 17.7504 17.5H16.248V17.4993H14.748V17.5H9.25391C8.83969 17.5 8.50391 17.1642 8.50391 16.75V4.25ZM14.748 19H9.25391C8.01126 19 7.00391 17.9926 7.00391 16.75V6.49854H6.24805C5.83383 6.49854 5.49805 6.83432 5.49805 7.24854V19.75C5.49805 20.1642 5.83383 20.5 6.24805 20.5H13.998C14.4123 20.5 14.748 20.1642 14.748 19.75L14.748 19ZM7.00391 4.99854V4.25C7.00391 3.00736 8.01127 2 9.25391 2H15.2777C15.8745 2 16.4468 2.23705 16.8687 2.659L19.3414 5.13168C19.7634 5.55364 20.0004 6.12594 20.0004 6.72268V16.75C20.0004 17.9926 18.9931 19 17.7504 19H16.248L16.248 19.75C16.248 20.9926 15.2407 22 13.998 22H6.24805C5.00541 22 3.99805 20.9926 3.99805 19.75V7.24854C3.99805 6.00589 5.00541 4.99854 6.24805 4.99854H7.00391Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Pages
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 8) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 8) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 8) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/file-manager"  class="menu-dropdown-item"
                                                                :class="isActive('/file-manager') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                File Manager
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/pricing-tables"  class="menu-dropdown-item"
                                                                :class="isActive('/pricing-tables') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Pricing Tables
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/faq"  class="menu-dropdown-item"
                                                                :class="isActive('/faq') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Faqs
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/api-keys"  class="menu-dropdown-item"
                                                                :class="isActive('/api-keys') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                API Keys
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/api-keys') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/integrations"  class="menu-dropdown-item"
                                                                :class="isActive('/integrations') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Integrations
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                            <span
                                                                            :class="isActive('/integrations') ?
                                                                                'menu-dropdown-badge menu-dropdown-badge-active' :
                                                                                'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                                            new
                                                                        </span>
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/blank"  class="menu-dropdown-item"
                                                                :class="isActive('/blank') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Blank Page
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/error-404"  class="menu-dropdown-item"
                                                                :class="isActive('/error-404') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                404 Error
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/error-500"  class="menu-dropdown-item"
                                                                :class="isActive('/error-500') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                500 Error
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/error-503"  class="menu-dropdown-item"
                                                                :class="isActive('/error-503') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                503 Error
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/coming-soon"  class="menu-dropdown-item"
                                                                :class="isActive('/coming-soon') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Coming Soon
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/maintenance"  class="menu-dropdown-item"
                                                                :class="isActive('/maintenance') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Maintenance
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/success"  class="menu-dropdown-item"
                                                                :class="isActive('/success') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Success
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 9)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 9) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 9) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.33301 9.33301V19.9998M20 9.33301H4M5.5 20H18.5C19.3284 20 20 19.3284 20 18.5V5.5C20 4.67157 19.3284 4 18.5 4H5.5C4.67157 4 4 4.67157 4 5.5V18.5C4 19.3284 4.67157 20 5.5 20Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Layouts
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 9) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 9) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 9) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/layout-one"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-one') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout One
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/layout-two"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-two') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout Two
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/layout-three"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-three') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout Three
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/layout-four"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-four') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout Four
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/layout-five"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-five') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout Five
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/layout-six"  target="_blank"  class="menu-dropdown-item"
                                                                :class="isActive('/layout-six') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Layout Six
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(0, 10)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(0, 10) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(0, 10) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> <path d="M11.041 7.656l3.536-3.535m.353 3.889l1.768-1.768M15.107 18.44L5.561 8.894m-1.59 3.712l7.424 7.425a1.5 1.5 0 002.121 0l7.425-7.425a1.5 1.5 0 000-2.121L13.516 3.06a1.5 1.5 0 00-2.12 0L3.97 10.485a1.5 1.5 0 000 2.121zm2.65 2.652l2.122 2.12-2.475 2.476a1.5 1.5 0 11-2.121-2.121l2.475-2.475z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor" /> </svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Empty State
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(0, 10) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(0, 10) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(0, 10) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/empty-state-one"  class="menu-dropdown-item"
                                                                :class="isActive('/empty-state-one') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Variants 01
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/empty-state-two"  class="menu-dropdown-item"
                                                                :class="isActive('/empty-state-two') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Variants 02
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/empty-state-three"  class="menu-dropdown-item"
                                                                :class="isActive('/empty-state-three') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Variants 03
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/empty-state-four"  class="menu-dropdown-item"
                                                                :class="isActive('/empty-state-four') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Variants 04
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/empty-state-five"  class="menu-dropdown-item"
                                                                :class="isActive('/empty-state-five') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Variants 05
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                    </ul>
                    </div>
                                    <div>
                        <!-- Menu Group Title -->
                        <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                            'lg:justify-center' : 'justify-start'">
                            <template
                                x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>Support</span>
                            </template>
                            <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="currentColor"/>
                                </svg>
                            </template>
                        </h2>

                        <!-- Menu Items -->
                        <ul class="flex flex-col gap-1">
                                                            <li>
                                                                            <!-- Simple Menu Item -->
                                        <a href="/chat"  class="menu-item group"
                                            :class="[
                                                isActive('/chat') ? 'menu-item-active' :
                                                'menu-item-inactive',
                                                (!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                                                'xl:justify-center' :
                                                'justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span
                                                :class="isActive('/chat') ? 'menu-item-icon-active' :
                                                    'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.00002 12.0957C4.00002 7.67742 7.58174 4.0957 12 4.0957C16.4183 4.0957 20 7.67742 20 12.0957C20 16.514 16.4183 20.0957 12 20.0957H5.06068L6.34317 18.8132C6.48382 18.6726 6.56284 18.4818 6.56284 18.2829C6.56284 18.084 6.48382 17.8932 6.34317 17.7526C4.89463 16.304 4.00002 14.305 4.00002 12.0957ZM12 2.5957C6.75332 2.5957 2.50002 6.849 2.50002 12.0957C2.50002 14.4488 3.35633 16.603 4.77303 18.262L2.71969 20.3154C2.50519 20.5299 2.44103 20.8525 2.55711 21.1327C2.6732 21.413 2.94668 21.5957 3.25002 21.5957H12C17.2467 21.5957 21.5 17.3424 21.5 12.0957C21.5 6.849 17.2467 2.5957 12 2.5957ZM7.62502 10.8467C6.93467 10.8467 6.37502 11.4063 6.37502 12.0967C6.37502 12.787 6.93467 13.3467 7.62502 13.3467H7.62512C8.31548 13.3467 8.87512 12.787 8.87512 12.0967C8.87512 11.4063 8.31548 10.8467 7.62512 10.8467H7.62502ZM10.75 12.0967C10.75 11.4063 11.3097 10.8467 12 10.8467H12.0001C12.6905 10.8467 13.2501 11.4063 13.2501 12.0967C13.2501 12.787 12.6905 13.3467 12.0001 13.3467H12C11.3097 13.3467 10.75 12.787 10.75 12.0967ZM16.375 10.8467C15.6847 10.8467 15.125 11.4063 15.125 12.0967C15.125 12.787 15.6847 13.3467 16.375 13.3467H16.3751C17.0655 13.3467 17.6251 12.787 17.6251 12.0967C17.6251 11.4063 17.0655 10.8467 16.3751 10.8467H16.375Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Chat
                                                                                            </span>
                                        </a>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(1, 1)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(1, 1) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(1, 1) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 17.0518V12C20 7.58174 16.4183 4 12 4C7.58168 4 3.99994 7.58174 3.99994 12V17.0518M19.9998 14.041V19.75C19.9998 20.5784 19.3282 21.25 18.4998 21.25H13.9998M6.5 18.75H5.5C4.67157 18.75 4 18.0784 4 17.25V13.75C4 12.9216 4.67157 12.25 5.5 12.25H6.5C7.32843 12.25 8 12.9216 8 13.75V17.25C8 18.0784 7.32843 18.75 6.5 18.75ZM17.4999 18.75H18.4999C19.3284 18.75 19.9999 18.0784 19.9999 17.25V13.75C19.9999 12.9216 19.3284 12.25 18.4999 12.25H17.4999C16.6715 12.25 15.9999 12.9216 15.9999 13.75V17.25C15.9999 18.0784 16.6715 18.75 17.4999 18.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Support Ticket
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(1, 1) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(1, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(1, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/support-tickets"  class="menu-dropdown-item"
                                                                :class="isActive('/support-tickets') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Ticket List
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/support-ticket-reply"  class="menu-dropdown-item"
                                                                :class="isActive('/support-ticket-reply') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Ticket Reply
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(1, 2)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(1, 2) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(1, 2) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.5 8.187V17.25C3.5 17.6642 3.83579 18 4.25 18H19.75C20.1642 18 20.5 17.6642 20.5 17.25V8.18747L13.2873 13.2171C12.5141 13.7563 11.4866 13.7563 10.7134 13.2171L3.5 8.187ZM20.5 6.2286C20.5 6.23039 20.5 6.23218 20.5 6.23398V6.24336C20.4976 6.31753 20.4604 6.38643 20.3992 6.42905L12.4293 11.9867C12.1716 12.1664 11.8291 12.1664 11.5713 11.9867L3.60116 6.42885C3.538 6.38481 3.50035 6.31268 3.50032 6.23568C3.50028 6.10553 3.60577 6 3.73592 6H20.2644C20.3922 6 20.4963 6.10171 20.5 6.2286ZM22 6.25648V17.25C22 18.4926 20.9926 19.5 19.75 19.5H4.25C3.00736 19.5 2 18.4926 2 17.25V6.23398C2 6.22371 2.00021 6.2135 2.00061 6.20333C2.01781 5.25971 2.78812 4.5 3.73592 4.5H20.2644C21.2229 4.5 22 5.27697 22.0001 6.23549C22.0001 6.24249 22.0001 6.24949 22 6.25648Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Email
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(1, 2) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(1, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(1, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/inbox"  class="menu-dropdown-item"
                                                                :class="isActive('/inbox') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Inbox
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/inbox-details"  class="menu-dropdown-item"
                                                                :class="isActive('/inbox-details') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Details
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                    </ul>
                    </div>
                                    <div>
                        <!-- Menu Group Title -->
                        <h2 class="mb-4 text-xs uppercase flex leading-[20px] text-gray-400"
                            :class="(!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen) ?
                            'lg:justify-center' : 'justify-start'">
                            <template
                                x-if="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                                <span>Others</span>
                            </template>
                            <template x-if="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z" fill="currentColor"/>
                                </svg>
                            </template>
                        </h2>

                        <!-- Menu Items -->
                        <ul class="flex flex-col gap-1">
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(2, 0)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(2, 0) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(2, 0) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C11.5858 2 11.25 2.33579 11.25 2.75V12C11.25 12.4142 11.5858 12.75 12 12.75H21.25C21.6642 12.75 22 12.4142 22 12C22 6.47715 17.5228 2 12 2ZM12.75 11.25V3.53263C13.2645 3.57761 13.7659 3.66843 14.25 3.80098V3.80099C15.6929 4.19606 16.9827 4.96184 18.0104 5.98959C19.0382 7.01734 19.8039 8.30707 20.199 9.75C20.3316 10.2341 20.4224 10.7355 20.4674 11.25H12.75ZM2 12C2 7.25083 5.31065 3.27489 9.75 2.25415V3.80099C6.14748 4.78734 3.5 8.0845 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C15.9155 20.5 19.2127 17.8525 20.199 14.25H21.7459C20.7251 18.6894 16.7492 22 12 22C6.47715 22 2 17.5229 2 12Z" fill="currentColor" /> </svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Charts
                                                                                                    <span class="absolute ltr:right-10 rtl:left-10"
                                                        :class="isActive('') ?
                                                            'menu-dropdown-badge menu-dropdown-badge-active' :
                                                            'menu-dropdown-badge menu-dropdown-badge-inactive'">
                                                        new
                                                    </span>
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(2, 0) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(2, 0) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(2, 0) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/line-chart"  class="menu-dropdown-item"
                                                                :class="isActive('/line-chart') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Line Chart
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/bar-chart"  class="menu-dropdown-item"
                                                                :class="isActive('/bar-chart') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Bar Chart
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/pie-chart"  class="menu-dropdown-item"
                                                                :class="isActive('/pie-chart') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Pie Chart
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/radar-chart"  class="menu-dropdown-item"
                                                                :class="isActive('/radar-chart') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Radar Chart
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/radial-chart"  class="menu-dropdown-item"
                                                                :class="isActive('/radial-chart') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Radial Chart
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(2, 1)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(2, 1) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(2, 1) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M8.87646 19.4561C8.99463 19.4563 9.11281 19.4425 9.22852 19.4147L14.771 18.0845C14.889 18.0561 15.0095 18.0423 15.13 18.0431C15.2468 18.0438 15.3636 18.0581 15.4779 18.0861L19.3927 19.0448C20.3377 19.2763 21.2495 18.5608 21.2495 17.5879V7.17656C21.2495 6.48557 20.7775 5.88398 20.1063 5.71961L18.2299 5.26008M15.13 18.0431V13.158M8.87646 19.4561C8.75732 19.456 8.63819 19.4416 8.52164 19.4131L3.89319 18.2796C3.22203 18.1152 2.75 17.5136 2.75 16.8226V6.41127C2.75 5.43838 3.66185 4.7229 4.60681 4.95432L5.76839 5.2388M8.87646 19.4561V13.1446M15.2819 6.03146C15.2819 9.34375 12.0091 11.9984 12.0091 11.9984C12.0091 11.9984 8.71896 9.34375 8.71896 6.03146C8.71896 4.21916 10.1881 2.75 12.0004 2.75C13.8127 2.75 15.2819 4.21916 15.2819 6.03146Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 6.03125H12.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Maps
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(2, 1) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(2, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(2, 1) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/maps"  class="menu-dropdown-item"
                                                                :class="isActive('/maps') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Map
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/vector-maps"  class="menu-dropdown-item"
                                                                :class="isActive('/vector-maps') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Vector Map
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(2, 2)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(2, 2) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(2, 2) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.665 3.75618C11.8762 3.65061 12.1247 3.65061 12.3358 3.75618L18.7807 6.97853L12.3358 10.2009C12.1247 10.3064 11.8762 10.3064 11.665 10.2009L5.22014 6.97853L11.665 3.75618ZM4.29297 8.19199V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0365V11.6512C11.1631 11.6205 11.0777 11.5843 10.9942 11.5425L4.29297 8.19199ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19199L13.0066 11.5425C12.9229 11.5844 12.8372 11.6207 12.75 11.6515V20.037ZM13.0066 2.41453C12.3732 2.09783 11.6277 2.09783 10.9942 2.41453L4.03676 5.89316C3.27449 6.27429 2.79297 7.05339 2.79297 7.90563V16.0946C2.79297 16.9468 3.27448 17.7259 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149L10.9942 21.5857C11.6277 21.9024 12.3732 21.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.7259 21.2079 16.9468 21.2079 16.0946V7.90563C21.2079 7.05339 20.7264 6.27429 19.9641 5.89316L13.0066 2.41453Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                UI Elements
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(2, 2) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(2, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(2, 2) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/alerts"  class="menu-dropdown-item"
                                                                :class="isActive('/alerts') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Alerts
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/avatars"  class="menu-dropdown-item"
                                                                :class="isActive('/avatars') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Avatar
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/badge"  class="menu-dropdown-item"
                                                                :class="isActive('/badge') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Badge
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/breadcrumb"  class="menu-dropdown-item"
                                                                :class="isActive('/breadcrumb') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Breadcrumb
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/buttons"  class="menu-dropdown-item"
                                                                :class="isActive('/buttons') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Buttons
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/cards"  class="menu-dropdown-item"
                                                                :class="isActive('/cards') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Cards
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/carousel"  class="menu-dropdown-item"
                                                                :class="isActive('/carousel') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Carousel
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/dropdowns"  class="menu-dropdown-item"
                                                                :class="isActive('/dropdowns') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Dropdowns
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/images"  class="menu-dropdown-item"
                                                                :class="isActive('/images') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Images
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/links"  class="menu-dropdown-item"
                                                                :class="isActive('/links') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Links
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/list"  class="menu-dropdown-item"
                                                                :class="isActive('/list') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                List
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/dialogs"  class="menu-dropdown-item"
                                                                :class="isActive('/dialogs') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Dialogs
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/notifications"  class="menu-dropdown-item"
                                                                :class="isActive('/notifications') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Notification
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/pagination"  class="menu-dropdown-item"
                                                                :class="isActive('/pagination') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Pagination
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/popovers"  class="menu-dropdown-item"
                                                                :class="isActive('/popovers') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Popovers
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/progress-bar"  class="menu-dropdown-item"
                                                                :class="isActive('/progress-bar') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Progressbar
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/ribbons"  class="menu-dropdown-item"
                                                                :class="isActive('/ribbons') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Ribbons
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/spinners"  class="menu-dropdown-item"
                                                                :class="isActive('/spinners') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Spinners
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/tabs"  class="menu-dropdown-item"
                                                                :class="isActive('/tabs') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Tabs
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/tooltips"  class="menu-dropdown-item"
                                                                :class="isActive('/tooltips') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Tooltips
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/videos"  class="menu-dropdown-item"
                                                                :class="isActive('/videos') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Videos
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                            <li>
                                                                            <!-- Menu Item with Submenu -->
                                        <button @click="toggleSubmenu(2, 3)"
                                            class="menu-item group w-full"
                                            :class="[
                                                isSubmenuOpen(2, 3) ?
                                                'menu-item-active' : 'menu-item-inactive',
                                                !$store.sidebar.isExpanded && !$store.sidebar.isHovered ?
                                                'xl:justify-center' : 'xl:justify-start'
                                            ]">

                                            <!-- Icon -->
                                            <span :class="isSubmenuOpen(2, 3) ?
                                                    'menu-item-icon-active' : 'menu-item-icon-inactive'">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14 2.75C14 2.33579 14.3358 2 14.75 2C15.1642 2 15.5 2.33579 15.5 2.75V5.73291L17.75 5.73291H19C19.4142 5.73291 19.75 6.0687 19.75 6.48291C19.75 6.89712 19.4142 7.23291 19 7.23291H18.5L18.5 12.2329C18.5 15.5691 15.9866 18.3183 12.75 18.6901V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V18.6901C8.01342 18.3183 5.5 15.5691 5.5 12.2329L5.5 7.23291H5C4.58579 7.23291 4.25 6.89712 4.25 6.48291C4.25 6.0687 4.58579 5.73291 5 5.73291L6.25 5.73291L8.5 5.73291L8.5 2.75C8.5 2.33579 8.83579 2 9.25 2C9.66421 2 10 2.33579 10 2.75L10 5.73291L14 5.73291V2.75ZM7 7.23291L7 12.2329C7 14.9943 9.23858 17.2329 12 17.2329C14.7614 17.2329 17 14.9943 17 12.2329L17 7.23291L7 7.23291Z" fill="currentColor"></path></svg>
                                            </span>

                                            <!-- Text -->
                                            <span
                                                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                                                class="menu-item-text flex items-center gap-2">
                                                Authentication
                                                                                            </span>

                                            <!-- Chevron Down Icon -->
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" class="ms-auto h-5 w-5 transition-transform duration-200" x-bind:class="{ 'rotate-180 text-brand-500': isSubmenuOpen(2, 3) }">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        </button>

                                        <!-- Submenu -->
                                        <div class="menu-accordion" :class="(isSubmenuOpen(2, 3) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)) && 'open'" :inert="!(isSubmenuOpen(2, 3) && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen))">
                                            <div>
                                                <ul class="mt-2 space-y-1 ltr:ml-9 rtl:mr-9">
                                                                                                            <li>
                                                            <a href="/signin"  class="menu-dropdown-item"
                                                                :class="isActive('/signin') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Sign In
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/signup"  class="menu-dropdown-item"
                                                                :class="isActive('/signup') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Sign Up
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/reset-password"  class="menu-dropdown-item"
                                                                :class="isActive('/reset-password') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Reset Password
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                            <li>
                                                            <a href="/two-step-verification"  class="menu-dropdown-item"
                                                                :class="isActive('/two-step-verification') ?
                                                                    'menu-dropdown-item-active' :
                                                                    'menu-dropdown-item-inactive'">
                                                                Two Step Verification
                                                                <span class="flex items-center gap-1 ltr:ml-auto rtl:mr-auto">
                                                                                                                                                                                                        </span>
                                                            </a>
                                                        </li>
                                                                                                    </ul>
                                            </div>
                                        </div>
                                                                    </li>
                                                    </ul>
                    </div>
                            </div>
        </nav>

        <!-- Sidebar Widget -->
        <div x-data x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen" x-transition class="mt-auto">
            <div class="mb-4">
    <div class="mx-auto rounded-2xl bg-gray-50 px-4 py-5 text-center dark:bg-white/3">
        <h3 class="mb-2 font-semibold text-gray-900 dark:text-white">
            #1 Tailwind CSS Dashboard
        </h3>
        <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
            Leading Tailwind CSS Admin Template with 500+ UI Component and Pages.
        </p>
        <a href="https://tailadmin.com/pricing" target="_blank" rel="nofollow"
            class="flex items-center justify-center rounded-lg bg-brand-500 p-3 text-sm font-medium text-white hover:bg-brand-600">
            Purchase Now
        </a>
    </div>
</div>
        </div>

    </div>
</aside>
        <div x-show="$store.sidebar.isMobileOpen" @click="$store.sidebar.setMobileOpen(false)"
    x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:leave="transition-opacity duration-200" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-100 bg-black/50 supports-backdrop-filter:backdrop-blur-xs xl:hidden dark:bg-black/70" x-cloak></div>

<style>
  [x-cloak] {
    display: none;
  }
</style>

        <div class="flex h-svh min-w-0 flex-1 flex-col overflow-hidden ml-0 ltr:xl:ml-[90px] rtl:xl:ml-0 rtl:xl:mr-[90px] [.sidebar-expanded_&]:ltr:xl:ml-[290px] [.sidebar-expanded_&]:rtl:xl:ml-0 [.sidebar-expanded_&]:rtl:xl:mr-[290px] transition-all duration-300 ease-in-out">
            <!-- app header start -->
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

        <form id="logout-form" method="POST" action="https://laravel-demo.tailadmin.com/logout" class="hidden"><input type="hidden" name="_token" value="KCl8Hc8wJWtMiUQ7IJwhj4Hp2sCgzgk18JKb9ln8" autocomplete="off"></form>
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
            <!-- app header end -->
            <div class="flex min-h-0 flex-1 flex-col">
                    <div
    x-data="{ settingsNavOpen: false }"
    class="relative flex h-full min-h-0 flex-1 flex-col overflow-hidden bg-white p-5 xl:flex-row xl:p-0 dark:border-gray-800 dark:bg-gray-900"
>
    <div class="mt-4 flex shrink-0 items-center justify-between rounded-2xl border border-gray-200 bg-white p-3 ps-5 xl:hidden dark:border-gray-800 dark:bg-white/3">
    <span class="text-lg font-medium text-gray-800 dark:text-white/90">
        Account
    </span>

    <button data-slot="button" type="button" aria-label="Open settings menu" @click="settingsNavOpen = true" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-11 rounded-[10px]"><svg class="size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path
      d="M4 6h16M4 18h16M4 12h16"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
    />
  </svg></button>
</div>

    <!-- Desktop Sidebar: in-flow right sidebar, width 250px (w-62.5 / w-[250px]) -->
<aside
    data-slot="sidebar"
    class="hidden h-full w-62.5 shrink-0 flex-col border-e border-gray-200 bg-white text-gray-900 xl:flex dark:border-gray-800 dark:bg-gray-900"
    x-data="{ selectedWorkspaceId: 1 }"
>
    <div class="p-3 pb-0">
    <!-- Workspace Dropdown -->
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Switch workspace"   class="flex w-full items-center justify-between rounded-lg border border-gray-100 bg-gray-50 p-3 text-start outline-hidden transition hover:bg-gray-100/80 dark:border-gray-800 dark:bg-white/3 dark:hover:bg-white/5" ><div class="flex items-center gap-2.5" x-show="selectedWorkspaceId === 1" >
                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/owner.png" alt="Musharof Chy" class="aspect-square size-full rounded-full object-cover">
                                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-brand-400">M</span>
</template></span>
                    <div class="text-start">
                        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                            Musharof Chy
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Personal</p>
                    </div>
                </div>
                            <div class="flex items-center gap-2.5" x-show="selectedWorkspaceId === 2"  style="display: none;" >
                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-amber-400">L</span>
</template></span>
                    <div class="text-start">
                        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                            Leonardo Dicaprio
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Business</p>
                    </div>
                </div>
                        <svg class="size-5 shrink-0 text-gray-500 **:stroke-[1.3px] dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
      d="M12.167 6.242L8 2.076 3.833 6.242m0 3.515L8 13.924l4.167-4.167"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-58 min-w-56.5 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="selectedWorkspaceId = 1" class="group/dropdown-menu-item relative cursor-pointer gap-3 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center justify-between rounded-lg px-2 py-2 hover:bg-gray-50 dark:hover:bg-white/5"><div class="flex items-center gap-2.5">
                        <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/owner.png" alt="Musharof Chy" class="aspect-square size-full rounded-full object-cover">
                                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-brand-400">M</span>
</template></span>
                        <div class="text-start">
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Musharof Chy
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Personal</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedWorkspaceId === 1" class="size-5 text-gray-700 **:stroke-[1.3px] dark:text-gray-400">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="selectedWorkspaceId = 2" class="group/dropdown-menu-item relative cursor-pointer gap-3 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center justify-between rounded-lg px-2 py-2 hover:bg-gray-50 dark:hover:bg-white/5"><div class="flex items-center gap-2.5">
                        <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-amber-400">L</span>
</template></span>
                        <div class="text-start">
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Leonardo Dicaprio
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Business</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedWorkspaceId === 2" class="size-5 text-gray-700 **:stroke-[1.3px] dark:text-gray-400">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px bg-gray-100 dark:bg-gray-700 my-1 border-t border-gray-100 dark:border-gray-800"></div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center gap-2.5 rounded-lg px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 **:stroke-[1.3px]">
    <path d="M5 12h14M12 5v14" />
  </svg>
                <span>Create Workspace</span></div></div>
    </div>
</template></div>
</div>
    <div data-slot="sidebar-content" class="no-scrollbar flex min-h-0 flex-1 flex-col gap-4 overflow-auto p-3">
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                Account
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/account"
                                 aria-current="page"                                 class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] bg-gray-100 font-medium text-gray-800 dark:bg-white/5 dark:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.25 16.199s.105-5.417-6.25-5.417S3.75 16.2 3.75 16.2m9.302-10.912a2.995 2.995 0 11-5.991 0 2.995 2.995 0 015.99 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Account</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/general"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5 shrink-0 **:stroke-[1.3px]">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">General</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/billing"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M15.511 3.587c.142.426.476.76.902.902l.474.158-.474.157c-.426.142-.76.476-.902.902l-.157.474-.158-.474a1.423 1.423 0 00-.902-.902l-.474-.157.474-.158c.426-.142.76-.476.902-.902l.158-.474.157.474zM10.102 6.457a5.435 5.435 0 003.442 3.441l1.81.603-1.81.603a5.435 5.435 0 00-3.442 3.44l-.602 1.81-.603-1.81a5.435 5.435 0 00-3.441-3.44l-1.81-.603 1.81-.603a5.435 5.435 0 003.441-3.441l.603-1.81.602 1.81z"
      stroke="currentColor"
      stroke-width="1.5"
    />
  </svg>
                                <span class="truncate">Credit and Billing</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/personalization"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <span class="truncate">Personalization</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                Features
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/memory"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.507a1.897 1.897 0 013.73-.5h.162a2.5 2.5 0 012.5 2.5v.331a2.993 2.993 0 011.316 2.481 2.993 2.993 0 01-1.316 2.482v1.01a2.5 2.5 0 01-2.5 2.5h-.096v.18a1.897 1.897 0 01-3.795 0m-6.393-2.679v-1.01A2.993 2.993 0 012.292 9.32c0-1.032.522-1.942 1.316-2.481v-.33a2.5 2.5 0 012.5-2.5h.163a1.898 1.898 0 013.728.5v10.984a1.897 1.897 0 01-3.794 0v-.18h-.097a2.5 2.5 0 01-2.5-2.5z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Memory</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/file-media"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M9.375 6.667H5.833m8.334 3.334H5.833m5.209 3.333H5.833m-1.25-10h10.834c.69 0 1.25.56 1.25 1.25v10.833c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V4.584c0-.69.56-1.25 1.25-1.25z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">File &amp; media</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/models"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.667 2.291v2.083m-4.375 8.959h2.083m2.292 2.291v2.084m8.958-4.375h2.083M10 2.29v2.083M2.292 10h2.083M10 15.624v2.084m5.625-7.709h2.083m-4.375-7.708v2.083M2.292 6.666h2.083m8.958 8.958v2.084m2.292-11.042h2.083M5.625 15.624h8.75c.69 0 1.25-.56 1.25-1.25v-8.75c0-.69-.56-1.25-1.25-1.25h-8.75c-.69 0-1.25.56-1.25 1.25v8.75c0 .69.56 1.25 1.25 1.25z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Models</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                System
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/connector"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M14 2.75a.75.75 0 011.5 0v2.983H19a.75.75 0 010 1.5h-.5v5a6.501 6.501 0 01-5.75 6.457v2.56a.75.75 0 01-1.5 0v-2.56a6.501 6.501 0 01-5.75-6.457v-5H5a.75.75 0 010-1.5h3.5V2.75a.75.75 0 011.5 0v2.983h4V2.75zM7 7.233v5a5 5 0 0010 0v-5H7z"
      fill="currentColor"
    />
  </svg>
                                <span class="truncate">Connector</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/data-control"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.667 5.209c0 1.38-2.985 2.5-6.667 2.5s-6.667-1.12-6.667-2.5m13.334 0c0-1.38-2.985-2.5-6.667-2.5s-6.667 1.12-6.667 2.5m13.334 0v2.946M3.333 5.209v8.338c0 1.097 1.884 2.026 4.505 2.361M3.333 9.377c0 1.1 1.894 2.033 4.525 2.368m2.497.812v2.598c0 .447.238.86.625 1.082l2.25 1.3a1.25 1.25 0 001.25 0l2.25-1.3a1.25 1.25 0 00.625-1.082v-2.598c0-.447-.238-.86-.625-1.083l-2.25-1.299a1.25 1.25 0 00-1.25 0l-2.25 1.3a1.25 1.25 0 00-.625 1.082z"
      stroke="currentColor"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M13.856 13.254a.6.6 0 110 1.198.6.6 0 010-1.198z"
      stroke="currentColor"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Data Control</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Drawer (Sheet): slides from right -->
<template x-teleport="body">
    <div x-show="settingsNavOpen" style="display: none;" @keydown.escape.window="settingsNavOpen = false">
        <div
            data-slot="sheet-overlay"
            class="fixed inset-0 isolate z-100 bg-black/50 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70"
            x-show="settingsNavOpen"
            x-transition.opacity.duration.200ms
            @click="settingsNavOpen = false"
        ></div>
        <div
            data-slot="sheet-content"
            role="dialog"
            aria-label="AI Settings Navigation"
            class="fixed inset-y-0 end-0 z-100 flex h-full w-62.5 flex-col border-s border-gray-200 bg-white p-0 text-gray-900 shadow-theme-lg dark:border-gray-800 dark:bg-gray-900"
            x-data="{ selectedWorkspaceId: 1 }"
            x-show="settingsNavOpen"
            x-transition:enter="transition-transform duration-200 ease-in-out"
            x-transition:enter-start="ltr:translate-x-full rtl:-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition-transform duration-200 ease-in-out"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="ltr:translate-x-full rtl:-translate-x-full"
        >
            <!-- Floating close button outside drawer -->
            <button data-slot="button" type="button" aria-label="Close settings menu" @click="settingsNavOpen = false" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-11 absolute -start-13 top-2 rounded-full bg-white text-gray-700 shadow-theme-md transition hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 **:stroke-[1.5px]">
    <path d="M18 6L6 18M6 6l12 12" />
  </svg></button>

            <div class="p-3 pb-0">
    <!-- Workspace Dropdown -->
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Switch workspace"   class="flex w-full items-center justify-between rounded-lg border border-gray-100 bg-gray-50 p-3 text-start outline-hidden transition hover:bg-gray-100/80 dark:border-gray-800 dark:bg-white/3 dark:hover:bg-white/5" ><div class="flex items-center gap-2.5" x-show="selectedWorkspaceId === 1" >
                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/owner.png" alt="Musharof Chy" class="aspect-square size-full rounded-full object-cover">
                                                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-brand-400">M</span>
</template></span>
                    <div class="text-start">
                        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                            Musharof Chy
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Personal</p>
                    </div>
                </div>
                            <div class="flex items-center gap-2.5" x-show="selectedWorkspaceId === 2"  style="display: none;" >
                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-amber-400">L</span>
</template></span>
                    <div class="text-start">
                        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                            Leonardo Dicaprio
                        </h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Business</p>
                    </div>
                </div>
                        <svg class="size-5 shrink-0 text-gray-500 **:stroke-[1.3px] dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
      d="M12.167 6.242L8 2.076 3.833 6.242m0 3.515L8 13.924l4.167-4.167"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-58 min-w-56.5 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="selectedWorkspaceId = 1" class="group/dropdown-menu-item relative cursor-pointer gap-3 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center justify-between rounded-lg px-2 py-2 hover:bg-gray-50 dark:hover:bg-white/5"><div class="flex items-center gap-2.5">
                        <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/owner.png" alt="Musharof Chy" class="aspect-square size-full rounded-full object-cover">
                                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-brand-400">M</span>
</template></span>
                        <div class="text-start">
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Musharof Chy
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Personal</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedWorkspaceId === 1" class="size-5 text-gray-700 **:stroke-[1.3px] dark:text-gray-400">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="selectedWorkspaceId = 2" class="group/dropdown-menu-item relative cursor-pointer gap-3 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center justify-between rounded-lg px-2 py-2 hover:bg-gray-50 dark:hover:bg-white/5"><div class="flex items-center gap-2.5">
                        <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-9 shrink-0"><template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 text-sm font-medium text-white bg-amber-400">L</span>
</template></span>
                        <div class="text-start">
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">
                                Leonardo Dicaprio
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Business</p>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedWorkspaceId === 2" class="size-5 text-gray-700 **:stroke-[1.3px] dark:text-gray-400">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
                        <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 h-px bg-gray-100 dark:bg-gray-700 my-1 border-t border-gray-100 dark:border-gray-800"></div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full items-center gap-2.5 rounded-lg px-2 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 **:stroke-[1.3px]">
    <path d="M5 12h14M12 5v14" />
  </svg>
                <span>Create Workspace</span></div></div>
    </div>
</template></div>
</div>
            <div data-slot="sidebar-content" class="no-scrollbar flex min-h-0 flex-1 flex-col gap-4 overflow-auto p-3">
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                Account
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/account"
                                 aria-current="page"                                 class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] bg-gray-100 font-medium text-gray-800 dark:bg-white/5 dark:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.25 16.199s.105-5.417-6.25-5.417S3.75 16.2 3.75 16.2m9.302-10.912a2.995 2.995 0 11-5.991 0 2.995 2.995 0 015.99 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Account</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/general"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5 shrink-0 **:stroke-[1.3px]">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">General</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/billing"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M15.511 3.587c.142.426.476.76.902.902l.474.158-.474.157c-.426.142-.76.476-.902.902l-.157.474-.158-.474a1.423 1.423 0 00-.902-.902l-.474-.157.474-.158c.426-.142.76-.476.902-.902l.158-.474.157.474zM10.102 6.457a5.435 5.435 0 003.442 3.441l1.81.603-1.81.603a5.435 5.435 0 00-3.442 3.44l-.602 1.81-.603-1.81a5.435 5.435 0 00-3.441-3.44l-1.81-.603 1.81-.603a5.435 5.435 0 003.441-3.441l.603-1.81.602 1.81z"
      stroke="currentColor"
      stroke-width="1.5"
    />
  </svg>
                                <span class="truncate">Credit and Billing</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/personalization"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                <span class="truncate">Personalization</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                Features
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/memory"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.507a1.897 1.897 0 013.73-.5h.162a2.5 2.5 0 012.5 2.5v.331a2.993 2.993 0 011.316 2.481 2.993 2.993 0 01-1.316 2.482v1.01a2.5 2.5 0 01-2.5 2.5h-.096v.18a1.897 1.897 0 01-3.795 0m-6.393-2.679v-1.01A2.993 2.993 0 012.292 9.32c0-1.032.522-1.942 1.316-2.481v-.33a2.5 2.5 0 012.5-2.5h.163a1.898 1.898 0 013.728.5v10.984a1.897 1.897 0 01-3.794 0v-.18h-.097a2.5 2.5 0 01-2.5-2.5z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Memory</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/file-media"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M9.375 6.667H5.833m8.334 3.334H5.833m5.209 3.333H5.833m-1.25-10h10.834c.69 0 1.25.56 1.25 1.25v10.833c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V4.584c0-.69.56-1.25 1.25-1.25z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">File &amp; media</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/models"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.667 2.291v2.083m-4.375 8.959h2.083m2.292 2.291v2.084m8.958-4.375h2.083M10 2.29v2.083M2.292 10h2.083M10 15.624v2.084m5.625-7.709h2.083m-4.375-7.708v2.083M2.292 6.666h2.083m8.958 8.958v2.084m2.292-11.042h2.083M5.625 15.624h8.75c.69 0 1.25-.56 1.25-1.25v-8.75c0-.69-.56-1.25-1.25-1.25h-8.75c-.69 0-1.25.56-1.25 1.25v8.75c0 .69.56 1.25 1.25 1.25z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Models</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
            <div class="relative flex w-full min-w-0 flex-col p-0">
            <div class="flex h-auto shrink-0 items-center rounded-md px-3 py-1 text-xs font-normal text-gray-400 outline-hidden dark:text-gray-500">
                System
            </div>
            <div class="w-full text-sm">
                <ul class="flex w-full min-w-0 flex-col gap-0.5">
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/connector"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M14 2.75a.75.75 0 011.5 0v2.983H19a.75.75 0 010 1.5h-.5v5a6.501 6.501 0 01-5.75 6.457v2.56a.75.75 0 01-1.5 0v-2.56a6.501 6.501 0 01-5.75-6.457v-5H5a.75.75 0 010-1.5h3.5V2.75a.75.75 0 011.5 0v2.983h4V2.75zM7 7.233v5a5 5 0 0010 0v-5H7z"
      fill="currentColor"
    />
  </svg>
                                <span class="truncate">Connector</span>
                            </a>
                        </li>
                                                                    <li class="group/menu-item relative">
                            <a
                                href="https://laravel-demo.tailadmin.com/ai-settings/data-control"
                                                                class="flex h-9 w-full items-center gap-2 rounded-lg px-3 py-2 text-start text-sm transition [&_path]:stroke-[1.3px] [&_svg]:size-5 [&_svg_*]:stroke-[1.3px] font-normal text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5 [&amp;_svg]:text-[#6A7282] hover:[&amp;_svg]:text-gray-700 dark:hover:[&amp;_svg]:text-white/90"
                                @click="settingsNavOpen = false"
                            >
                                <svg class="size-5 shrink-0 **:stroke-[1.3px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.667 5.209c0 1.38-2.985 2.5-6.667 2.5s-6.667-1.12-6.667-2.5m13.334 0c0-1.38-2.985-2.5-6.667-2.5s-6.667 1.12-6.667 2.5m13.334 0v2.946M3.333 5.209v8.338c0 1.097 1.884 2.026 4.505 2.361M3.333 9.377c0 1.1 1.894 2.033 4.525 2.368m2.497.812v2.598c0 .447.238.86.625 1.082l2.25 1.3a1.25 1.25 0 001.25 0l2.25-1.3a1.25 1.25 0 00.625-1.082v-2.598c0-.447-.238-.86-.625-1.083l-2.25-1.299a1.25 1.25 0 00-1.25 0l-2.25 1.3a1.25 1.25 0 00-.625 1.082z"
      stroke="currentColor"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M13.856 13.254a.6.6 0 110 1.198.6.6 0 010-1.198z"
      stroke="currentColor"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span class="truncate">Data Control</span>
                            </a>
                        </li>
                                    </ul>
            </div>
        </div>
    </div>
        </div>
    </div>
</template>

    <main class="no-scrollbar h-full w-full overflow-y-auto xl:mx-auto xl:max-w-228.75 xl:p-8">
        <div class="w-full">
            <!-- Page Header -->
            <div class="hidden border-b border-gray-200 pt-1 pb-4 sm:pb-5 xl:block dark:border-gray-800">
                <h1 class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">Account</h1>
            </div>

            <!-- Sections Container -->
            <div class="flex flex-col gap-6 pt-6">
                <section class="flex flex-col gap-2">
    <h2 class="text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
        Profile info
    </h2>

    <form
        class="overflow-hidden rounded-2xl border border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-900"
        x-data="{
            avatarUrl: '/assets/images/user/owner.png',
            fullName: 'Musharof Chowdhory',
            email: 'randomuser@pimjo.com',
            workspaceName: 'Pimjo',
            isSaved: false,
            handleImageChange(e) {
                const file = e.target.files && e.target.files[0];
                if (file) this.avatarUrl = URL.createObjectURL(file);
            },
            handleSubmit() {
                this.isSaved = true;
                setTimeout(() => { this.isSaved = false }, 2000);
            },
            initialLetter() {
                return this.fullName.trim() ? this.fullName.trim()[0].toUpperCase() : 'M';
            },
        }"
        @submit.prevent="handleSubmit()"
    >
        <!-- Avatar Row -->
        <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-15 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="avatarUrl || '/assets/images/user/owner.png'" x-bind:alt="fullName || 'Avatar'" class="aspect-square size-full rounded-full object-cover">
                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs bg-brand-400 text-2xl font-medium text-white dark:bg-brand-400 dark:text-white"><span x-text="initialLetter()"></span></span>
</template></span>

            <div class="flex flex-col items-start gap-1.5">
                <input
                    id="avatar-file-input"
                    x-ref="fileInput"
                    type="file"
                    accept="image/png,image/jpeg,image/webp"
                    class="hidden"
                    @change="handleImageChange($event)"
                />
                <button data-slot="button" type="button" @click="$refs.fileInput.click()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg px-3 py-1.5 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-2.5 [&amp;:has(&gt;svg:last-child)]:pe-2.5 h-8">Upload avatar</button>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Min 400x400px, PNG or JPEG formats.
                </p>
            </div>
        </div>

        <!-- Full Name Field -->
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div role="group" data-slot="field" data-orientation="vertical"  class="group/field w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 *:w-full [&amp;&gt;.sr-only]:w-auto flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-800 dark:text-white/90">Full Name</label>
                <div class="w-full sm:w-70">
                    <input data-slot="input" x-model="fullName" type="text" placeholder="Musharof Chowdhory" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                </div></div>
        </div>

        <!-- Email Field -->
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div role="group" data-slot="field" data-orientation="vertical"  class="group/field w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 *:w-full [&amp;&gt;.sr-only]:w-auto flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-800 dark:text-white/90">Email</label>
                <div class="w-full sm:w-70">
                    <input data-slot="input" x-model="email" type="email" placeholder="randomuser@pimjo.com" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                </div></div>
        </div>

        <!-- Workspace Name Field -->
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <div role="group" data-slot="field" data-orientation="vertical"  class="group/field w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 *:w-full [&amp;&gt;.sr-only]:w-auto flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-800 dark:text-white/90">Workspace Name</label>
                <div class="w-full sm:w-70">
                    <input data-slot="input" x-model="workspaceName" type="text" placeholder="Pimjo" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                </div></div>
        </div>

        <!-- Save Changes Footer -->
        <div class="flex items-center justify-end px-5 py-4">
            <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><span x-text="isSaved ? 'Saved!' : 'Save Changes'">Save Changes</span></button>
        </div>
    </form>
</section>
                <section class="flex flex-col gap-2">
    <h2 class="text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
        Security
    </h2>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-900" x-data="{ twoFactorEnabled: false }">
        <!-- Change password -->
        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
            <div class="flex flex-col gap-0.5 text-start">
                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">Change password</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Last updated 2 months ago</p>
            </div>

            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Update password</button>
        </div>

        <!-- Two-Factor Authentication -->
        <div class="flex justify-between gap-3 border-b border-gray-100 px-5 py-4 sm:items-center dark:border-gray-800">
            <div class="flex flex-col gap-0.5 text-start">
                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                    Two-Factor Authentication
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Add an extra layer of security</p>
            </div>

            <button
    type="button"
    role="switch"
    data-slot="switch"
    data-size="sm"
            x-bind:aria-checked="twoFactorEnabled ? 'true' : 'false'"
    x-bind:data-state="twoFactorEnabled ? 'checked' : 'unchecked'"
    x-bind:data-checked="twoFactorEnabled ? '' : null"
    x-bind:data-unchecked="twoFactorEnabled ? null : ''"
     x-on:click="twoFactorEnabled = !twoFactorEnabled"     aria-label="Two-Factor Authentication"
    class="peer relative inline-flex shrink-0 cursor-pointer items-center rounded-full transition-colors outline-hidden select-none focus-visible:ring-2 focus-visible:ring-brand-500/20 focus-visible:outline-hidden dark:focus-visible:ring-brand-500/30 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 data-checked:bg-brand-500 data-checked:hover:bg-brand-600 dark:data-checked:bg-brand-500 dark:data-checked:hover:bg-brand-600 data-disabled:cursor-not-allowed data-disabled:bg-gray-100 data-disabled:hover:bg-gray-100 dark:data-disabled:bg-gray-800 dark:data-disabled:hover:bg-gray-800 data-disabled:data-checked:bg-gray-100 data-disabled:data-checked:hover:bg-gray-100 dark:data-disabled:data-checked:bg-gray-800 dark:data-disabled:data-checked:hover:bg-gray-800 group-has-focus-visible/field-label:ring-0 after:absolute after:-inset-x-3 after:-inset-y-2 aria-invalid:ring-3 aria-invalid:ring-error-500/20 dark:aria-invalid:ring-error-500/40 h-5 w-11 p-[1.5px]"
>
    <span
        data-slot="switch-thumb"
        x-bind:data-checked="twoFactorEnabled ? '' : null"
        x-bind:data-unchecked="twoFactorEnabled ? null : ''"
        class="pointer-events-none block shrink-0 rounded-full bg-white shadow-theme-sm ring-0 transition-transform duration-150 ease-linear data-unchecked:translate-x-0 rtl:data-unchecked:translate-x-0 h-[17px] w-[26px] data-checked:translate-x-[15px] rtl:data-checked:-translate-x-[15px]"
    ></span>
</button>
        </div>

        <!-- Active sessions -->
        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-col gap-0.5 text-start">
                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">Active sessions</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">3 devices currently signed in</p>
            </div>

            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Manage</button>
        </div>
    </div>
</section>
                <section class="flex flex-col gap-2">
    <h2 class="text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400">
        Danger Zone
    </h2>

    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-900">
        <!-- Logout all devices -->
        <div class="flex flex-col gap-3 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
            <div class="flex flex-col gap-0.5 text-start">
                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">Logout all devices</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Sign out from every active session.
                </p>
            </div>

            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-5 rtl:rotate-180">
    <path
      d="M4 12h7.75M8 8l-3.998 4 3.997 4M9.75 4.996V4.25a1.5 1.5 0 011.5-1.5h6a1.5 1.5 0 011.5 1.5v15.5a1.5 1.5 0 01-1.5 1.5h-6a1.5 1.5 0 01-1.5-1.5V19"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                <span>Logout All</span></button>
        </div>

        <!-- Delete account -->
        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-col gap-0.5 text-start">
                <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">Delete account</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Permanently remove your account and all data.
                </p>
            </div>

            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 border-red-300 text-red-500 shadow-theme-xs hover:bg-red-50 hover:text-red-600 dark:border-red-500/40 dark:text-red-400 dark:hover:bg-red-500/10"><svg class="size-5 text-red-500 dark:text-red-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                <span>Delete</span></button>
        </div>
    </div>
</section>
            </div>
        </div>
    </main>
</div>
            </div>
        </div>
    </div>

</body>


</html>
