<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Default Tab
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 dark:border-gray-800">
    <div dir="ltr" data-orientation="horizontal" data-slot="tabs" x-data="uiTabs({ value: 'overview', orientation: 'horizontal' })"  class="group/tabs flex gap-4 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row"><div class="border-b border-gray-200 p-3 dark:border-gray-800">
            <div data-slot="tabs-list" data-variant="default" tabindex="0" role="tablist" x-bind:aria-orientation="orientation" x-bind:data-orientation="orientation" x-on:keydown="onKeydown($event)" style="outline: none;"  class="group/tabs-list inline-flex items-center text-gray-500 dark:text-gray-400 rounded-lg bg-gray-100 p-1 group-data-[orientation=horizontal]/tabs:h-11 group-data-[orientation=vertical]/tabs:h-fit group-data-[orientation=vertical]/tabs:flex-col dark:bg-gray-900 w-full sm:w-auto"><button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="true" data-state="active" data-orientation="horizontal"  data-active=""     x-bind:id="triggerId('overview')"
    x-bind:aria-controls="contentId('overview')"
    x-bind:aria-selected="isActive('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('overview') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('overview')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Overview</button>
                                    <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('notification')"
    x-bind:aria-controls="contentId('notification')"
    x-bind:aria-selected="isActive('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('notification') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('notification')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Notification</button>
                                    <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('analytics')"
    x-bind:aria-controls="contentId('analytics')"
    x-bind:aria-selected="isActive('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('analytics') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('analytics')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Analytics</button>
                                    <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('customers')"
    x-bind:aria-controls="contentId('customers')"
    x-bind:aria-selected="isActive('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('customers') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('customers')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Customers</button></div>
        </div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="active" data-orientation="horizontal"     x-bind:id="contentId('overview')"
    x-bind:aria-labelledby="triggerId('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('overview')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400 p-4 pt-0"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Overview
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('notification')"
    x-bind:aria-labelledby="triggerId('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('notification')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400 p-4 pt-0"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Notification
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('analytics')"
    x-bind:aria-labelledby="triggerId('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('analytics')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400 p-4 pt-0"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('customers')"
    x-bind:aria-labelledby="triggerId('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('customers')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400 p-4 pt-0"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Customers
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div></div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Line Variant
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800">
    <div dir="ltr" data-orientation="horizontal" data-slot="tabs" x-data="uiTabs({ value: 'overview', orientation: 'horizontal' })"  class="group/tabs flex gap-4 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row"><div data-slot="tabs-list" data-variant="line" tabindex="0" role="tablist" x-bind:aria-orientation="orientation" x-bind:data-orientation="orientation" x-on:keydown="onKeydown($event)" style="outline: none;"  class="group/tabs-list inline-flex items-center text-gray-500 dark:text-gray-400 w-full justify-start gap-2 border-b border-gray-200 bg-transparent p-0 group-data-[orientation=horizontal]/tabs:h-12 group-data-[orientation=vertical]/tabs:h-fit group-data-[orientation=vertical]/tabs:flex-col group-data-[orientation=vertical]/tabs:gap-1 group-data-[orientation=vertical]/tabs:border-e group-data-[orientation=vertical]/tabs:border-b-0 dark:border-gray-800"><button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="true" data-state="active" data-orientation="horizontal"  data-active=""     x-bind:id="triggerId('overview')"
    x-bind:aria-controls="contentId('overview')"
    x-bind:aria-selected="isActive('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('overview') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('overview')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Overview</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('notification')"
    x-bind:aria-controls="contentId('notification')"
    x-bind:aria-selected="isActive('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('notification') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('notification')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Notification</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('analytics')"
    x-bind:aria-controls="contentId('analytics')"
    x-bind:aria-selected="isActive('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('analytics') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('analytics')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Analytics</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('customers')"
    x-bind:aria-controls="contentId('customers')"
    x-bind:aria-selected="isActive('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('customers') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('customers')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Customers</button></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="active" data-orientation="horizontal"     x-bind:id="contentId('overview')"
    x-bind:aria-labelledby="triggerId('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('overview')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Overview
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('notification')"
    x-bind:aria-labelledby="triggerId('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('notification')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Notification
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('analytics')"
    x-bind:aria-labelledby="triggerId('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('analytics')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('customers')"
    x-bind:aria-labelledby="triggerId('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('customers')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Customers
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div></div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Line Variant with Icon
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800">
    <div dir="ltr" data-orientation="horizontal" data-slot="tabs" x-data="uiTabs({ value: 'overview', orientation: 'horizontal' })"  class="group/tabs flex gap-4 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row"><div data-slot="tabs-list" data-variant="line" tabindex="0" role="tablist" x-bind:aria-orientation="orientation" x-bind:data-orientation="orientation" x-on:keydown="onKeydown($event)" style="outline: none;"  class="group/tabs-list inline-flex items-center text-gray-500 dark:text-gray-400 w-full justify-start gap-2 border-b border-gray-200 bg-transparent p-0 group-data-[orientation=horizontal]/tabs:h-12 group-data-[orientation=vertical]/tabs:h-fit group-data-[orientation=vertical]/tabs:flex-col group-data-[orientation=vertical]/tabs:gap-1 group-data-[orientation=vertical]/tabs:border-e group-data-[orientation=vertical]/tabs:border-b-0 dark:border-gray-800"><button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="true" data-state="active" data-orientation="horizontal"  data-active=""     x-bind:id="triggerId('overview')"
    x-bind:aria-controls="contentId('overview')"
    x-bind:aria-selected="isActive('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('overview') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('overview')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5"><svg  xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M3.333 4.583c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V4.583zM3.333 12.5c0-.69.56-1.25 1.25-1.25H7.5c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H4.583c-.69 0-1.25-.56-1.25-1.25V12.5zM11.25 4.583c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25V7.5c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V4.583zM11.25 12.5c0-.69.56-1.25 1.25-1.25h2.917c.69 0 1.25.56 1.25 1.25v2.917c0 .69-.56 1.25-1.25 1.25H12.5c-.69 0-1.25-.56-1.25-1.25V12.5z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                    Overview</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('notification')"
    x-bind:aria-controls="contentId('notification')"
    x-bind:aria-selected="isActive('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('notification') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('notification')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" >
    <path
      d="M9.861 1.876v1.25m0 0a5.625 5.625 0 015.625 5.625v6.041H4.236V8.751a5.625 5.625 0 015.625-5.625zm-1.25 14.166h2.5m-7.917-2.5h13.334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                    Notification</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('analytics')"
    x-bind:aria-controls="contentId('analytics')"
    x-bind:aria-selected="isActive('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('analytics') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('analytics')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M9.85954 4.0835C9.5834 4.0835 9.35954 4.30735 9.35954 4.5835V15.4161C9.35954 15.6922 9.5834 15.9161 9.85954 15.9161H10.1373C10.4135 15.9161 10.6373 15.6922 10.6373 15.4161V4.5835C10.6373 4.30735 10.4135 4.0835 10.1373 4.0835H9.85954ZM7.85954 4.5835C7.85954 3.47893 8.75497 2.5835 9.85954 2.5835H10.1373C11.2419 2.5835 12.1373 3.47893 12.1373 4.5835V15.4161C12.1373 16.5206 11.2419 17.4161 10.1373 17.4161H9.85954C8.75497 17.4161 7.85954 16.5206 7.85954 15.4161V4.5835ZM4.58203 8.9598C4.30589 8.9598 4.08203 9.18366 4.08203 9.4598V15.4168C4.08203 15.693 4.30589 15.9168 4.58203 15.9168H4.85981C5.13595 15.9168 5.35981 15.693 5.35981 15.4168V9.4598C5.35981 9.18366 5.13595 8.9598 4.85981 8.9598H4.58203ZM2.58203 9.4598C2.58203 8.35523 3.47746 7.4598 4.58203 7.4598H4.85981C5.96438 7.4598 6.85981 8.35523 6.85981 9.4598V15.4168C6.85981 16.5214 5.96438 17.4168 4.85981 17.4168H4.58203C3.47746 17.4168 2.58203 16.5214 2.58203 15.4168V9.4598ZM14.637 12.435C14.637 12.1589 14.8609 11.935 15.137 11.935H15.4148C15.691 11.935 15.9148 12.1589 15.9148 12.435V15.4168C15.9148 15.693 15.691 15.9168 15.4148 15.9168H15.137C14.8609 15.9168 14.637 15.693 14.637 15.4168V12.435ZM15.137 10.435C14.0325 10.435 13.137 11.3304 13.137 12.435V15.4168C13.137 16.5214 14.0325 17.4168 15.137 17.4168H15.4148C16.5194 17.4168 17.4148 16.5214 17.4148 15.4168V12.435C17.4148 11.3304 16.5194 10.435 15.4148 10.435H15.137Z"
      fill="currentColor"
    />
  </svg>
                    Analytics</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('customers')"
    x-bind:aria-controls="contentId('customers')"
    x-bind:aria-selected="isActive('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('customers') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('customers')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" >
    <path
      d="M14.109 5.104a2.947 2.947 0 11.001 5.39m1.687 2.727c3.802.224 5.024 2.788 5.416 4.47.186.797-.47 1.458-1.289 1.458H17.59m-5.839-11.35a2.947 2.947 0 11-5.894 0 2.947 2.947 0 015.894 0zM8.75 13.205c4.234 0 5.554 2.726 5.964 4.486.186.797-.47 1.458-1.29 1.458H4.076c-.818 0-1.475-.662-1.29-1.458.411-1.76 1.73-4.486 5.964-4.486z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                    Customers</button></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="active" data-orientation="horizontal"     x-bind:id="contentId('overview')"
    x-bind:aria-labelledby="triggerId('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('overview')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Overview
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('notification')"
    x-bind:aria-labelledby="triggerId('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('notification')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Notification
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('analytics')"
    x-bind:aria-labelledby="triggerId('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('analytics')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('customers')"
    x-bind:aria-labelledby="triggerId('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('customers')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Customers
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div></div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Tab with badge
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800">
    <div dir="ltr" data-orientation="horizontal" data-slot="tabs" x-data="uiTabs({ value: 'overview', orientation: 'horizontal' })"  class="group/tabs flex gap-4 data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row"><div data-slot="tabs-list" data-variant="line" tabindex="0" role="tablist" x-bind:aria-orientation="orientation" x-bind:data-orientation="orientation" x-on:keydown="onKeydown($event)" style="outline: none;"  class="group/tabs-list inline-flex items-center text-gray-500 dark:text-gray-400 w-full justify-start gap-2 border-b border-gray-200 bg-transparent p-0 group-data-[orientation=horizontal]/tabs:h-12 group-data-[orientation=vertical]/tabs:h-fit group-data-[orientation=vertical]/tabs:flex-col group-data-[orientation=vertical]/tabs:gap-1 group-data-[orientation=vertical]/tabs:border-e group-data-[orientation=vertical]/tabs:border-b-0 dark:border-gray-800"><button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="true" data-state="active" data-orientation="horizontal"  data-active=""     x-bind:id="triggerId('overview')"
    x-bind:aria-controls="contentId('overview')"
    x-bind:aria-selected="isActive('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('overview') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('overview')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Overview
                                            <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)] rounded-full">8</span></button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('notification')"
    x-bind:aria-controls="contentId('notification')"
    x-bind:aria-selected="isActive('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('notification') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('notification')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Notification
                                            <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)] rounded-full">10</span></button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('analytics')"
    x-bind:aria-controls="contentId('analytics')"
    x-bind:aria-selected="isActive('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('analytics') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('analytics')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Analytics
                                            <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)] rounded-full">4</span></button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="horizontal"     x-bind:id="triggerId('customers')"
    x-bind:aria-controls="contentId('customers')"
    x-bind:aria-selected="isActive('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('customers') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('customers')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Customers
                                            <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)] rounded-full">12</span></button></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="active" data-orientation="horizontal"     x-bind:id="contentId('overview')"
    x-bind:aria-labelledby="triggerId('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('overview')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Overview
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('notification')"
    x-bind:aria-labelledby="triggerId('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('notification')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Notification
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('analytics')"
    x-bind:aria-labelledby="triggerId('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('analytics')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="horizontal"  hidden     x-bind:id="contentId('customers')"
    x-bind:aria-labelledby="triggerId('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('customers')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Customers
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div></div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Vertical Tab
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-800">
    <div dir="ltr" data-orientation="vertical" data-slot="tabs" x-data="uiTabs({ value: 'overview', orientation: 'vertical' })"  class="group/tabs flex data-[orientation=horizontal]:flex-col data-[orientation=vertical]:flex-row gap-6 sm:gap-8"><div data-slot="tabs-list" data-variant="default" tabindex="0" role="tablist" x-bind:aria-orientation="orientation" x-bind:data-orientation="orientation" x-on:keydown="onKeydown($event)" style="outline: none;"  class="group/tabs-list inline-flex items-center text-gray-500 dark:text-gray-400 rounded-lg bg-gray-100 p-1 group-data-[orientation=horizontal]/tabs:h-11 group-data-[orientation=vertical]/tabs:h-fit group-data-[orientation=vertical]/tabs:flex-col dark:bg-gray-900 w-40 shrink-0 sm:w-50"><button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="true" data-state="active" data-orientation="vertical"  data-active=""     x-bind:id="triggerId('overview')"
    x-bind:aria-controls="contentId('overview')"
    x-bind:aria-selected="isActive('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('overview') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('overview')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Overview</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="vertical"     x-bind:id="triggerId('notification')"
    x-bind:aria-controls="contentId('notification')"
    x-bind:aria-selected="isActive('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('notification') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('notification')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Notification</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="vertical"     x-bind:id="triggerId('analytics')"
    x-bind:aria-controls="contentId('analytics')"
    x-bind:aria-selected="isActive('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('analytics') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('analytics')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Analytics</button>
                            <button data-slot="tabs-trigger" type="button" role="tab" tabindex="-1" aria-selected="false" data-state="inactive" data-orientation="vertical"     x-bind:id="triggerId('customers')"
    x-bind:aria-controls="contentId('customers')"
    x-bind:aria-selected="isActive('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-active="isActive('customers') ? '' : null"
    x-bind:data-orientation="orientation"
    x-on:click="select('customers')"
        
    class="relative inline-flex cursor-pointer items-center justify-center gap-1.5 font-outfit text-sm font-medium whitespace-nowrap outline-hidden transition-colors duration-200 select-none focus-visible:ring-3 focus-visible:ring-brand-500/20 focus-visible:outline-hidden disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=size-])]:size-4 has-data-[icon=inline-end]:pe-2 has-data-[icon=inline-start]:ps-2 group-data-[variant=default]/tabs-list:h-9 group-data-[variant=default]/tabs-list:rounded-md group-data-[variant=default]/tabs-list:px-3 group-data-[variant=default]/tabs-list:py-2 group-data-[variant=default]/tabs-list:text-gray-500 group-data-[variant=default]/tabs-list:hover:text-gray-900 dark:group-data-[variant=default]/tabs-list:text-gray-400 dark:group-data-[variant=default]/tabs-list:hover:text-white group-data-[variant=default]/tabs-list:data-active:bg-white group-data-[variant=default]/tabs-list:data-active:text-gray-900 group-data-[variant=default]/tabs-list:data-active:shadow-theme-xs dark:group-data-[variant=default]/tabs-list:data-active:bg-white/3 dark:group-data-[variant=default]/tabs-list:data-active:text-white group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=default]/tabs-list:justify-start group-data-[variant=line]/tabs-list:-mb-px group-data-[variant=line]/tabs-list:h-12 group-data-[variant=line]/tabs-list:rounded-none group-data-[variant=line]/tabs-list:border-b-2 group-data-[variant=line]/tabs-list:border-transparent group-data-[variant=line]/tabs-list:px-3 group-data-[variant=line]/tabs-list:text-gray-500 group-data-[variant=line]/tabs-list:hover:text-gray-700 dark:group-data-[variant=line]/tabs-list:text-gray-400 dark:group-data-[variant=line]/tabs-list:hover:text-gray-200 group-data-[variant=line]/tabs-list:data-active:border-brand-500 group-data-[variant=line]/tabs-list:data-active:bg-transparent group-data-[variant=line]/tabs-list:data-active:text-brand-500 group-data-[variant=line]/tabs-list:data-active:shadow-none dark:group-data-[variant=line]/tabs-list:data-active:border-brand-400 dark:group-data-[variant=line]/tabs-list:data-active:text-brand-400 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:-me-px group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:h-auto group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:w-full group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:justify-start group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-e-2 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:border-b-0 group-data-[orientation=vertical]/tabs:group-data-[variant=line]/tabs-list:py-2.5">Customers</button></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="active" data-orientation="vertical"     x-bind:id="contentId('overview')"
    x-bind:aria-labelledby="triggerId('overview')"
    x-bind:data-state="isActive('overview') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('overview')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Overview
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="vertical"  hidden     x-bind:id="contentId('notification')"
    x-bind:aria-labelledby="triggerId('notification')"
    x-bind:data-state="isActive('notification') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('notification')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Notification
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="vertical"  hidden     x-bind:id="contentId('analytics')"
    x-bind:aria-labelledby="triggerId('analytics')"
    x-bind:data-state="isActive('analytics') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('analytics')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Analytics
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div>
                    <div data-slot="tabs-content" role="tabpanel" tabindex="0" data-state="inactive" data-orientation="vertical"  hidden     x-bind:id="contentId('customers')"
    x-bind:aria-labelledby="triggerId('customers')"
    x-bind:data-state="isActive('customers') ? 'active' : 'inactive'"
    x-bind:data-orientation="orientation"
    x-bind:hidden="!isActive('customers')"
    
    class="flex-1 text-sm text-gray-500 outline-none dark:text-gray-400"><h3 class="mb-1 font-medium text-gray-800 dark:text-white/90">
                    Customers
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Lorem ipsum dolor sit amet consectetur. Non vitae facilisis urna tortor placerat egestas donec. Faucibus diam gravida enim elit lacus a. Tincidunt fermentum condimentum quis et a et tempus. Tristique urna nisi nulla elit sit libero scelerisque ante.
                </p></div></div>
</div>
        </div>
    </div>
</div>    </div>

            </div>
        </div>

    </div>

</body>


</html>
