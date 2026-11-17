<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Popovers
    </h2>
    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                    href="https://laravel-demo.tailadmin.com"
                >
                    Inicio
                    <svg
                        class="stroke-current rtl:rotate-180"
                        width="17"
                        height="16"
                        viewBox="0 0 17 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366"
                            stroke=""
                            stroke-width="1.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </a>
            </li>
            <li class="text-sm text-gray-800 dark:text-white/90">
                Popovers
            </li>
        </ol>
    </nav>
</div>
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Default Popover
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="custom-scrollbar max-w-full overflow-auto sm:overflow-visible">
    <div class="flex flex-col flex-wrap items-center gap-4 sm:flex-row sm:gap-5">
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Top</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;top&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="top" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Top Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Bottom</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Bottom Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Right</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;right&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="right" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Right Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Left</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;left&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="left" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Left Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p></div>
        </div>
    </div>
</template></div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Popover With Button
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="custom-scrollbar max-w-full overflow-auto sm:overflow-visible">
    <div class="flex flex-col flex-wrap items-center gap-4 sm:flex-row sm:gap-5">
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Top</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;top&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="top" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Top Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Yes! got it</button>
                            <button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Learn more</button></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Bottom</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Bottom Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Yes! got it</button>
                            <button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Learn more</button></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Right</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;right&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="right" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Right Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Yes! got it</button>
                            <button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Learn more</button></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Left</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;left&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="left" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Left Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Yes! got it</button>
                            <button data-slot="popover-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Learn more</button></div></div>
        </div>
    </div>
</template></div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Popover With Link
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="custom-scrollbar max-w-full overflow-auto sm:overflow-visible">
    <div class="flex flex-col flex-wrap items-center gap-4 sm:flex-row sm:gap-5">
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Top</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;top&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="top" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Top Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><a data-slot="popover-close" x-on:click="close()" class="inline-flex items-center gap-1 text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400" href="#">
                                    Learn More
                                    <svg class="size-4 rtl:rotate-180"
    class="fill-current rtl:rotate-180"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
      fill="currentColor"
    />
  </svg>
                                </a></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Bottom</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Bottom Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><a data-slot="popover-close" x-on:click="close()" class="inline-flex items-center gap-1 text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400" href="#">
                                    Learn More
                                    <svg class="size-4 rtl:rotate-180"
    class="fill-current rtl:rotate-180"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
      fill="currentColor"
    />
  </svg>
                                </a></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Right</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;right&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="right" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Right Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><a data-slot="popover-close" x-on:click="close()" class="inline-flex items-center gap-1 text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400" href="#">
                                    Learn More
                                    <svg class="size-4 rtl:rotate-180"
    class="fill-current rtl:rotate-180"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
      fill="currentColor"
    />
  </svg>
                                </a></div></div>
        </div>
    </div>
</template></div>
        </div>
        <div>
            <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Popover on Left</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;left&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="left" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                    <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Left Popover</h3></div>
                    <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consect adipiscing elit. Mauris facilisis congue
                            exclamate justo nec facilisis.</p>
                        <div data-slot="popover-footer"  class="flex items-center gap-3 pt-1"><a data-slot="popover-close" x-on:click="close()" class="inline-flex items-center gap-1 text-sm font-medium text-brand-500 hover:text-brand-600 dark:text-brand-400" href="#">
                                    Learn More
                                    <svg class="size-4 rtl:rotate-180"
    class="fill-current rtl:rotate-180"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
      fill="currentColor"
    />
  </svg>
                                </a></div></div>
        </div>
    </div>
</template></div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Popover With and Without Arrow
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-wrap items-center gap-4 sm:gap-5">
    <div>
        <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Without Arrow</button>
            <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">Without Arrow</h3></div>
                <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">This popover displays without an arrow indicator pointing to the trigger.</p></div>
        </div>
    </div>
</template></div>
    </div>
    <div>
        <div data-slot="popover" data-ui-root x-data="uiPopover()" class="contents"><button data-slot="popover-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="toggle()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >With Arrow</button>
            <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" data-slot="popover-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:2,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="group/popover-content z-99999 w-full max-w-97.5 origin-(--reka-popover-content-transform-origin) rounded-xl border-none bg-white text-gray-800 shadow-theme-md duration-100 outline-none dark:bg-[#1E2635] dark:text-gray-300 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2">
            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="popover-arrow" style="display: block;"  class="fill-white group-data-[side=bottom]/popover-content:fill-gray-100 dark:fill-[#1E2635] dark:group-data-[side=bottom]/popover-content:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                <div data-slot="popover-header"  class="rounded-t-xl border-b border-gray-200 bg-gray-100 px-5 py-3 dark:border-gray-800 dark:bg-gray-800"><h3 data-slot="popover-title"  class="text-base leading-6 font-semibold text-gray-800 dark:text-white/90">With Arrow</h3></div>
                <div data-slot="popover-body"  class="space-y-3 p-5"><p data-slot="popover-description"  class="text-sm leading-5 text-gray-500 dark:text-gray-400">This popover includes an arrow indicator pointing directly to the trigger button.</p></div>
        </div>
    </div>
</template></div>
    </div>
</div>
        </div>
    </div>
</div>    </div>

            </div>
        </div>

    </div>

</body>


</html>
