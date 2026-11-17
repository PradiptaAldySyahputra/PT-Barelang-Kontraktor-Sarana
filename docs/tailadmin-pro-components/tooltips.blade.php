<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Tooltip
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
                Tooltip
            </li>
        </ol>
    </nav>
</div>
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Default Tooltip
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div>
    <div data-slot="tooltip" data-ui-root x-data="uiTooltip(JSON.parse('{\u0022delay\u0022:0}'))" class="contents"><button data-slot="tooltip-trigger" data-state="closed" data-grace-area-trigger x-ref="trigger" x-bind:data-state="state" x-bind:aria-describedby="open ? contentId : null" x-on:mouseenter="show()" x-on:mouseleave="hide()" x-on:focus="show()" x-on:blur="hide()" x-on:click="hide()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Tooltip Top</button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" data-slot="tooltip-content" data-options="{&quot;side&quot;:&quot;top&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0,&quot;arrowPadding&quot;:8}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="top" data-align="center" dir="ltr"  class="z-50 inline-flex w-fit max-w-xs origin-(--reka-tooltip-content-transform-origin) items-center gap-1.5 rounded-lg px-3.5 py-1.5 font-outfit text-xs font-medium whitespace-nowrap shadow-tooltip transition-opacity duration-150 outline-none select-none bg-gray-900 text-white dark:bg-gray-800 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-1 data-[side=left]:slide-in-from-right-1 data-[side=right]:slide-in-from-left-1 data-[side=top]:slide-in-from-bottom-1 data-[side=inline-end]:-start-2.25 data-[side=inline-end]:-rotate-90 rtl:data-[side=inline-end]:rotate-90 data-[side=inline-end]:slide-in-from-left-1 data-[side=inline-start]:slide-in-from-right-1">
            This is a tooltip
                            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="tooltip-arrow" style="display: block;"  class="fill-gray-900 dark:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                        <span x-bind:id="contentId" role="tooltip" style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); white-space: nowrap; overflow-wrap: normal; top: -1px; left: -1px;">This is a tooltip</span>
        </div>
    </div>
</template></div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Tooltip Placement
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-col items-center gap-10 sm:flex-row">
    <div data-slot="tooltip" data-ui-root x-data="uiTooltip(JSON.parse('{\u0022delay\u0022:0}'))" class="contents"><button data-slot="tooltip-trigger" data-state="closed" data-grace-area-trigger x-ref="trigger" x-bind:data-state="state" x-bind:aria-describedby="open ? contentId : null" x-on:mouseenter="show()" x-on:mouseleave="hide()" x-on:focus="show()" x-on:blur="hide()" x-on:click="hide()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Tooltip Top</button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" data-slot="tooltip-content" data-options="{&quot;side&quot;:&quot;top&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0,&quot;arrowPadding&quot;:8}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="top" data-align="center" dir="ltr"  class="z-50 inline-flex w-fit max-w-xs origin-(--reka-tooltip-content-transform-origin) items-center gap-1.5 rounded-lg px-3.5 py-1.5 font-outfit text-xs font-medium whitespace-nowrap shadow-tooltip transition-opacity duration-150 outline-none select-none bg-gray-900 text-white dark:bg-gray-800 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-1 data-[side=left]:slide-in-from-right-1 data-[side=right]:slide-in-from-left-1 data-[side=top]:slide-in-from-bottom-1 data-[side=inline-end]:-start-2.25 data-[side=inline-end]:-rotate-90 rtl:data-[side=inline-end]:rotate-90 data-[side=inline-end]:slide-in-from-left-1 data-[side=inline-start]:slide-in-from-right-1">
            This is a tooltip
                            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="tooltip-arrow" style="display: block;"  class="fill-gray-900 dark:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                        <span x-bind:id="contentId" role="tooltip" style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); white-space: nowrap; overflow-wrap: normal; top: -1px; left: -1px;">This is a tooltip</span>
        </div>
    </div>
</template></div>
    <div data-slot="tooltip" data-ui-root x-data="uiTooltip(JSON.parse('{\u0022delay\u0022:0}'))" class="contents"><button data-slot="tooltip-trigger" data-state="closed" data-grace-area-trigger x-ref="trigger" x-bind:data-state="state" x-bind:aria-describedby="open ? contentId : null" x-on:mouseenter="show()" x-on:mouseleave="hide()" x-on:focus="show()" x-on:blur="hide()" x-on:click="hide()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Tooltip Right</button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" data-slot="tooltip-content" data-options="{&quot;side&quot;:&quot;right&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0,&quot;arrowPadding&quot;:8}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="right" data-align="center" dir="ltr"  class="z-50 inline-flex w-fit max-w-xs origin-(--reka-tooltip-content-transform-origin) items-center gap-1.5 rounded-lg px-3.5 py-1.5 font-outfit text-xs font-medium whitespace-nowrap shadow-tooltip transition-opacity duration-150 outline-none select-none bg-gray-900 text-white dark:bg-gray-800 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-1 data-[side=left]:slide-in-from-right-1 data-[side=right]:slide-in-from-left-1 data-[side=top]:slide-in-from-bottom-1 data-[side=inline-end]:-start-2.25 data-[side=inline-end]:-rotate-90 rtl:data-[side=inline-end]:rotate-90 data-[side=inline-end]:slide-in-from-left-1 data-[side=inline-start]:slide-in-from-right-1">
            This is a tooltip
                            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="tooltip-arrow" style="display: block;"  class="fill-gray-900 dark:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                        <span x-bind:id="contentId" role="tooltip" style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); white-space: nowrap; overflow-wrap: normal; top: -1px; left: -1px;">This is a tooltip</span>
        </div>
    </div>
</template></div>
    <div data-slot="tooltip" data-ui-root x-data="uiTooltip(JSON.parse('{\u0022delay\u0022:0}'))" class="contents"><button data-slot="tooltip-trigger" data-state="closed" data-grace-area-trigger x-ref="trigger" x-bind:data-state="state" x-bind:aria-describedby="open ? contentId : null" x-on:mouseenter="show()" x-on:mouseleave="hide()" x-on:focus="show()" x-on:blur="hide()" x-on:click="hide()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Tooltip Left</button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" data-slot="tooltip-content" data-options="{&quot;side&quot;:&quot;left&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0,&quot;arrowPadding&quot;:8}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="left" data-align="center" dir="ltr"  class="z-50 inline-flex w-fit max-w-xs origin-(--reka-tooltip-content-transform-origin) items-center gap-1.5 rounded-lg px-3.5 py-1.5 font-outfit text-xs font-medium whitespace-nowrap shadow-tooltip transition-opacity duration-150 outline-none select-none bg-gray-900 text-white dark:bg-gray-800 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-1 data-[side=left]:slide-in-from-right-1 data-[side=right]:slide-in-from-left-1 data-[side=top]:slide-in-from-bottom-1 data-[side=inline-end]:-start-2.25 data-[side=inline-end]:-rotate-90 rtl:data-[side=inline-end]:rotate-90 data-[side=inline-end]:slide-in-from-left-1 data-[side=inline-start]:slide-in-from-right-1">
            This is a tooltip
                            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="tooltip-arrow" style="display: block;"  class="fill-gray-900 dark:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                        <span x-bind:id="contentId" role="tooltip" style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); white-space: nowrap; overflow-wrap: normal; top: -1px; left: -1px;">This is a tooltip</span>
        </div>
    </div>
</template></div>
    <div data-slot="tooltip" data-ui-root x-data="uiTooltip(JSON.parse('{\u0022delay\u0022:0}'))" class="contents"><button data-slot="tooltip-trigger" data-state="closed" data-grace-area-trigger x-ref="trigger" x-bind:data-state="state" x-bind:aria-describedby="open ? contentId : null" x-on:mouseenter="show()" x-on:mouseleave="hide()" x-on:focus="show()" x-on:blur="hide()" x-on:click="hide()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Tooltip Bottom</button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" data-slot="tooltip-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:6,&quot;align&quot;:&quot;center&quot;,&quot;alignOffset&quot;:0,&quot;arrowPadding&quot;:8}" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="center" dir="ltr"  class="z-50 inline-flex w-fit max-w-xs origin-(--reka-tooltip-content-transform-origin) items-center gap-1.5 rounded-lg px-3.5 py-1.5 font-outfit text-xs font-medium whitespace-nowrap shadow-tooltip transition-opacity duration-150 outline-none select-none bg-gray-900 text-white dark:bg-gray-800 data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-1 data-[side=left]:slide-in-from-right-1 data-[side=right]:slide-in-from-left-1 data-[side=top]:slide-in-from-bottom-1 data-[side=inline-end]:-start-2.25 data-[side=inline-end]:-rotate-90 rtl:data-[side=inline-end]:rotate-90 data-[side=inline-end]:slide-in-from-left-1 data-[side=inline-start]:slide-in-from-right-1">
            This is a tooltip
                            <span x-ref="arrow" style="position: absolute;"><svg width="12" height="6" rounded="false" viewBox="0 0 12 6" preserveAspectRatio="none" data-slot="tooltip-arrow" style="display: block;"  class="fill-gray-900 dark:fill-gray-800"><path d="M0 0L6 6L12 0"></path></svg></span>
                        <span x-bind:id="contentId" role="tooltip" style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); clip-path: inset(50%); white-space: nowrap; overflow-wrap: normal; top: -1px; left: -1px;">This is a tooltip</span>
        </div>
    </div>
</template></div>
</div>
        </div>
    </div>
</div>    </div>

            </div>
        </div>

    </div>

</body>


</html>
