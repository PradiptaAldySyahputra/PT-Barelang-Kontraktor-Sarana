<!DOCTYPE html>
<html lang="es" dir="ltr" class="h-full bg-gray-50 dark:bg-gray-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs">

    <title>Laravel SignUp Page | TailAdmin - Laravel Dashboard Template</title>
<meta name="description" content="This is Laravel SignUp Page TailAdmin Dashboard Template">

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

        <div class="relative z-1 bg-white p-6 sm:p-0 dark:bg-gray-900">
    <div class="relative flex h-screen w-full flex-col justify-center sm:p-0 lg:flex-row dark:bg-gray-900">
        <div class="no-scrollbar flex w-full flex-1 flex-col overflow-y-auto lg:w-1/2">
    <div class="mx-auto mb-5 w-full max-w-md sm:pt-10">
    <a
        href="/"
        class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        Back to dashboard
    </a>
</div>

    <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
        <div>
            <div class="mb-5 sm:mb-8">
    <h1 class="mb-2 text-title-sm font-semibold text-gray-800 dark:text-white/90">Sign Up</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400">Enter your email and password to sign up!</p>
</div>

            
            <div>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-5">
            <button
            type="button"
            class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 px-7 py-3 text-sm font-normal text-gray-700 transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10"
        >
            <svg class="size-5" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_6739_40671)">
      <path
        d="M17.991 9.168c0-.738-.06-1.276-.193-1.834H9.179v3.329h5.06c-.103.827-.654 2.072-1.878 2.91l-.017.11 2.725 2.063.189.019c1.734-1.565 2.733-3.867 2.733-6.597z"
        fill="#4285F4"
      />
      <path
        d="M9.18 17.937c2.478 0 4.558-.797 6.078-2.172l-2.896-2.193c-.776.529-1.816.897-3.183.897a5.514 5.514 0 01-5.222-3.727l-.107.01-2.834 2.142-.037.1c1.51 2.93 4.61 4.943 8.2 4.943z"
        fill="#34A853"
      />
      <path
        d="M3.957 10.742a5.408 5.408 0 01-.306-1.774c0-.618.112-1.216.296-1.774l-.005-.119-2.869-2.177-.094.044A8.81 8.81 0 000 8.968c0 1.445.357 2.81.98 4.026l2.977-2.252z"
        fill="#FBBC05"
      />
      <path
        d="M9.18 3.468c1.723 0 2.886.728 3.549 1.335l2.59-2.471C13.73.887 11.658 0 9.18 0 5.59 0 2.49 2.013.98 4.943l2.968 2.252A5.537 5.537 0 019.18 3.468z"
        fill="#EB4335"
      />
    </g>
    <defs>
      <clipPath id="clip0_6739_40671">
        <path fill="#fff" d="M0 0H18V18H0z" />
      </clipPath>
    </defs>
  </svg>
            Sign up with Google
        </button>
            <button
            type="button"
            class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 px-7 py-3 text-sm font-normal text-gray-700 transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10"
        >
            <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.749 3.104l3.424 4.529.37.49.405-.463 3.986-4.556h1.18l-4.757 5.437-.267.306.245.325 5.843 7.723H13.38l-3.805-4.974-.37-.486-.403.46-4.375 5H3.244l5.138-5.872.27-.307-.249-.325-5.572-7.287h3.918zM4.353 4.331l9.076 11.866.15.197h2.643l-.607-.802L6.641 3.726l-.15-.199H3.736l.616.804z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
            Sign up with X
        </button>
    </div>
                <div class="relative py-3 sm:py-5">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-200 dark:border-gray-800"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="bg-white p-2 text-gray-400 sm:px-5 sm:py-2 dark:bg-gray-900">Or</span>
    </div>
</div>
                <form
    method="POST"
    action="https://laravel-demo.tailadmin.com/signup"
    class="space-y-5"
    novalidate
    x-data="signUpForm(JSON.parse('{\u0022fname\u0022:\u0022\u0022,\u0022lname\u0022:\u0022\u0022,\u0022email\u0022:\u0022\u0022}'), {})"
    x-on:submit.prevent="submitNative($el)"
>
    <input type="hidden" name="_token" value="dJFVT4mAmdw9yvlH36gZPt6c0WqhUcRR7gJTqXNs" autocomplete="off">    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('fname'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">First Name <span class="text-red-500">*</span></label>
    <input data-slot="input" name="fname" x-model="values.fname" type="text" placeholder="Enter your first name" autocomplete="off" x-bind:aria-invalid="errorOf('fname') ? 'true' : null" x-on:input="clearServerError('fname')" x-on:blur="touch('fname')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
    <div role="alert" data-slot="field-error" x-show="errorOf('fname')" style="display: none;" x-text="errorOf('fname')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('lname'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Last Name <span class="text-red-500">*</span></label>
    <input data-slot="input" name="lname" x-model="values.lname" type="text" placeholder="Enter your last name" autocomplete="off" x-bind:aria-invalid="errorOf('lname') ? 'true' : null" x-on:input="clearServerError('lname')" x-on:blur="touch('lname')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
    <div role="alert" data-slot="field-error" x-show="errorOf('lname')" style="display: none;" x-text="errorOf('lname')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>
    </div>

    <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('email'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Email <span class="text-red-500">*</span></label>
    <input data-slot="input" name="email" x-model="values.email" type="email" placeholder="Enter your email" autocomplete="off" x-bind:aria-invalid="errorOf('email') ? 'true' : null" x-on:input="clearServerError('email')" x-on:blur="touch('email')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
    <div role="alert" data-slot="field-error" x-show="errorOf('email')" style="display: none;" x-text="errorOf('email')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>

    <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('password'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Password <span class="text-red-500">*</span></label>
    <div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40"><input type="text" data-slot="input-group-control" name="password" x-model="values.password" x-bind:type="showPassword ? 'text' : 'password'" placeholder="Enter your password" autocomplete="new-password" x-bind:aria-invalid="errorOf('password') ? 'true' : null" x-on:input="clearServerError('password')" x-on:blur="touch('password')" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0">
        <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last pe-3.5 has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5"><button type="button" data-slot="button" data-size="icon-xs" x-bind:aria-label="showPassword ? 'Hide password' : 'Show password'" x-on:click="showPassword = !showPassword" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center gap-2 text-sm shadow-none size-7 rounded-md p-0 has-[&gt;svg]:p-0 text-gray-500 dark:text-gray-400"><svg x-show="showPassword" class="text-current" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.375c-3.34 0-6.218 1.98-7.534 4.833a1.893 1.893 0 000 1.585C3.782 13.646 6.66 15.625 10 15.625s6.218-1.98 7.535-4.832a1.893 1.893 0 000-1.585C16.218 6.354 13.34 4.375 10 4.375zM13.02 10a3.02 3.02 0 11-6.04 0 3.02 3.02 0 016.04 0z"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke="currentColor"
    />
  </svg>
                <svg x-show="!showPassword" class="text-current"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="currentColor"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.638 3.577a.75.75 0 00-1.06 1.06l1.275 1.277a8.03 8.03 0 00-2.437 3.545.75.75 0 000 .487 8.019 8.019 0 0011.083 4.614l1.864 1.863a.75.75 0 101.06-1.06L4.638 3.576zm7.723 9.844l-1.914-1.913c-.14.034-.289.053-.44.053h-.015a1.858 1.858 0 01-1.803-2.312l-2.27-2.27a6.532 6.532 0 00-1.996 2.723 6.518 6.518 0 008.438 3.72zm3.716-3.719a6.516 6.516 0 01-1.257 2.03l1.061 1.06a8.012 8.012 0 001.704-2.846.75.75 0 000-.487A8.019 8.019 0 007.522 4.433l1.23 1.23a6.519 6.519 0 017.326 4.04z"
    />
  </svg></button></div></div>
    <div role="alert" data-slot="field-error" x-show="errorOf('password')" style="display: none;" x-text="errorOf('password')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>

    <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('confirmPassword'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Confirm Password <span class="text-red-500">*</span></label>
    <div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40"><input type="text" data-slot="input-group-control" name="password_confirmation" x-model="values.confirmPassword" x-bind:type="showConfirmPassword ? 'text' : 'password'" placeholder="Re-enter your password" autocomplete="new-password" x-bind:aria-invalid="errorOf('confirmPassword') ? 'true' : null" x-on:input="clearServerError('confirmPassword')" x-on:blur="touch('confirmPassword')" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0">
        <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last pe-3.5 has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5"><button type="button" data-slot="button" data-size="icon-xs" x-bind:aria-label="showConfirmPassword ? 'Hide confirm password' : 'Show confirm password'" x-on:click="showConfirmPassword = !showConfirmPassword" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center gap-2 text-sm shadow-none size-7 rounded-md p-0 has-[&gt;svg]:p-0 text-gray-500 dark:text-gray-400"><svg x-show="showConfirmPassword" class="text-current" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.375c-3.34 0-6.218 1.98-7.534 4.833a1.893 1.893 0 000 1.585C3.782 13.646 6.66 15.625 10 15.625s6.218-1.98 7.535-4.832a1.893 1.893 0 000-1.585C16.218 6.354 13.34 4.375 10 4.375zM13.02 10a3.02 3.02 0 11-6.04 0 3.02 3.02 0 016.04 0z"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke="currentColor"
    />
  </svg>
                <svg x-show="!showConfirmPassword" class="text-current"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="currentColor"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.638 3.577a.75.75 0 00-1.06 1.06l1.275 1.277a8.03 8.03 0 00-2.437 3.545.75.75 0 000 .487 8.019 8.019 0 0011.083 4.614l1.864 1.863a.75.75 0 101.06-1.06L4.638 3.576zm7.723 9.844l-1.914-1.913c-.14.034-.289.053-.44.053h-.015a1.858 1.858 0 01-1.803-2.312l-2.27-2.27a6.532 6.532 0 00-1.996 2.723 6.518 6.518 0 008.438 3.72zm3.716-3.719a6.516 6.516 0 01-1.257 2.03l1.061 1.06a8.012 8.012 0 001.704-2.846.75.75 0 000-.487A8.019 8.019 0 007.522 4.433l1.23 1.23a6.519 6.519 0 017.326 4.04z"
    />
  </svg></button></div></div>
    <div role="alert" data-slot="field-error" x-show="errorOf('confirmPassword')" style="display: none;" x-text="errorOf('confirmPassword')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>

    <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('captcha'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Enter Code <span class="text-red-500">*</span></label>
        <div class="flex items-center gap-2">
            <img src="/captcha/flat?1794564296" alt="CAPTCHA" class="block h-11 shrink-0 cursor-pointer rounded-[10px] border border-gray-200 dark:border-gray-700" onclick="this.src='/captcha/flat?'+Math.random()">
            <button data-slot="button" type="button" aria-label="Refresh captcha" onclick="const img = this.previousElementSibling; img.src = '/captcha/flat?' + Math.random();" class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2v6h-6"></path><path d="M3 12a9 9 0 0 1 15-6.7L21 8"></path><path d="M3 22v-6h6"></path><path d="M21 12a9 9 0 0 1-15 6.7L3 16"></path></svg></button>
            <input data-slot="input" name="captcha" x-model="values.captcha" type="text" placeholder="Enter the code" autocomplete="off" x-bind:aria-invalid="errorOf('captcha') ? 'true' : null" x-on:input="clearServerError('captcha')" x-on:blur="touch('captcha')" class="h-11 w-full rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 min-w-0 flex-1" />
        </div>
        <div role="alert" data-slot="field-error" x-show="errorOf('captcha')" style="display: none;" x-text="errorOf('captcha')" class="text-sm font-normal text-red-500 dark:text-red-400"></div></div>

    <div role="group" data-slot="field" data-orientation="horizontal" x-bind:data-invalid="Boolean(errorOf('terms'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px items-start gap-3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="terms"       x-bind:aria-checked="Boolean(values.terms) ? 'true' : 'false'"
    x-bind:data-state="Boolean(values.terms) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(values.terms) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(values.terms) })"
        x-bind:aria-invalid="errorOf('terms') ? 'true' : null" x-on:change="values.terms = $event.detail.checked" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600 mt-0.5">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(values.terms)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
        <div class="flex flex-col gap-1">
            <label data-slot="field-label"  for="terms"   class="group/field-label peer/field-label w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 inline-block cursor-pointer text-sm font-normal text-gray-500 dark:text-gray-400">By creating an account means you agree to the
                <span class="text-gray-800 dark:text-white/90">Terms and Conditions,</span>
                and our
                <span class="text-gray-800 dark:text-white">Privacy Policy</span></label>
            <div role="alert" data-slot="field-error" x-show="errorOf('terms')" style="display: none;" x-text="errorOf('terms')" class="text-sm font-normal text-red-500 dark:text-red-400"></div>
        </div></div>

    <div>
        <button data-slot="button" type="submit" x-bind:disabled="isSubmitting" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-11 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 w-full"><span x-text="isSubmitting ? 'Signing Up...' : 'Sign Up'">Sign Up</span></button>
    </div>
</form>

                <div class="mt-5 pb-6">
                    <p class="text-center text-sm font-normal text-gray-700 sm:text-start dark:text-gray-400">
                        Already have an account?
                        <a href="https://laravel-demo.tailadmin.com/signin" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Sign In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
        <div class="relative hidden h-full w-full items-center justify-center bg-brand-950 lg:grid lg:w-1/2 dark:bg-white/5">
            <div class="z-1 flex h-full items-center justify-center">
                <div>
    <div class="absolute right-0 top-0 -z-1 w-full max-w-[250px] xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
    <div class="absolute bottom-0 left-0 -z-1 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
        <img src="/assets/images/shape/grid-01.svg" alt="grid" />
    </div>
</div>

                <div class="flex max-w-xs flex-col items-center">
                    <a href="/" class="mb-4 block">
                        <img width="231" height="48" src="/assets/images/logo/auth-logo.svg" alt="Logo" />
                    </a>
                    <p class="text-center text-gray-400 dark:text-white/60">
                        Free and Open-Source Tailwind CSS Admin Dashboard Template
                    </p>
                </div>
            </div>
        </div>

        <div class="fixed end-6 bottom-6 z-50 hidden sm:block">
            <button data-slot="button" type="button" x-on:click.prevent="$store.theme.toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 size-14 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="block dark:hidden">
    <path
      d="M6.247 6.668a6.668 6.668 0 0011.207 4.885A7.708 7.708 0 118.03 2.129a6.645 6.645 0 00-1.783 4.54z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" class="hidden dark:block">
    <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5" />
    <path
      d="M12 2v2m0 16v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M2 12h2m16 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
    />
  </svg></button>
        </div>
    </div>
</div>

</body>


</html>
