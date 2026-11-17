<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="space-y-4 md:space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            HR Dashboard
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Here&#039;s what&#039;s happening across your team.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 border-gray-300 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50"><svg class="size-5 text-gray-500 dark:text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            <span>Aug 16, 2028 - Sep 16, 2028</span></button>

        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 shadow-theme-xs"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
            <span>Add Member</span></button>
    </div>
</div>

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-4 md:space-y-6 xl:col-span-7">
            <div x-data="{ period: 'monthly', labels: JSON.parse('{\u0022monthly\u0022:\u0022Monthly\u0022,\u0022weekly\u0022:\u0022Weekly\u0022,\u0022yearly\u0022:\u0022Yearly\u0022}') }"
    class="rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800 dark:bg-white/3">
    <div class="mb-2 flex items-center justify-between p-4">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
            Quick stats
        </h3>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-1 border-gray-300 bg-white px-3 text-xs text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50" type="button" ><span x-text="labels[period]"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'monthly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Monthly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'weekly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Weekly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'yearly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Yearly</div></div>
    </div>
</template></div>
    </div>

            <div x-show="period === 'monthly'"  class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Employee
            </span>
            <div class="size-6 text-brand-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path
      d="M14.109 5.104a2.947 2.947 0 11.001 5.39m1.687 2.727c3.802.224 5.024 2.788 5.416 4.47.186.797-.47 1.458-1.289 1.458H17.59m-5.839-11.35a2.947 2.947 0 11-5.894 0 2.947 2.947 0 015.894 0zM8.75 13.205c4.234 0 5.554 2.726 5.964 4.486.186.797-.47 1.458-1.29 1.458H4.076c-.818 0-1.475-.662-1.29-1.458.411-1.76 1.73-4.486 5.964-4.486z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,248
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>3.2%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last month
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Active Employee
            </span>
            <div class="size-6 text-green-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M20.625 13.9297L15.2341 19.3206L12.625 16.7116M9.92236 20.25H5.93164C5.10321 20.25 4.43164 19.5784 4.43164 18.75V17.439C4.43164 14.9537 6.44636 12.939 8.93164 12.939H9.94922M15.5935 6.34459C15.5935 8.32983 13.9841 9.93918 11.9989 9.93918C10.0137 9.93918 8.4043 8.32983 8.4043 6.34459C8.4043 4.35935 10.0137 2.75 11.9989 2.75C13.9841 2.75 15.5935 4.35935 15.5935 6.34459Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,156
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>9.2%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last month
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                On Leave
            </span>
            <div class="size-6 text-orange-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            96
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>1.8%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last month
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Payroll
            </span>
            <div class="size-6 text-pink-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M11.999 15.4605H11.5616C10.8367 15.4605 10.249 14.8728 10.249 14.1479M11.999 15.4605H12.249C13.0775 15.4605 13.749 14.7889 13.749 13.9605V13.6954C13.749 13.0701 13.3612 12.5105 12.7757 12.2909L11.2223 11.7083C10.6369 11.4888 10.249 10.9291 10.249 10.3038V10.0388C10.249 9.21034 10.9206 8.53876 11.749 8.53876H11.999M11.999 15.4605V16.6245M11.999 8.53876H12.4364C13.1614 8.53876 13.749 9.12643 13.749 9.85136M11.999 8.53876V7.37452M19.9994 7.76672V12.7605C19.9994 14.782 18.9814 16.6676 17.2914 17.7767L12.8227 20.7094C12.323 21.0373 11.6763 21.0373 11.1767 20.7094L6.70797 17.7767C5.01792 16.6676 4 14.782 4 12.7605V7.76672C4 7.035 4.52576 6.40446 5.23056 6.20778C6.65684 5.80977 9.09916 4.94592 11.3415 3.27064C11.7304 2.9801 12.269 2.9801 12.6578 3.27064C14.9002 4.94592 17.3425 5.80977 18.7688 6.20778C19.4736 6.40446 19.9994 7.035 19.9994 7.76672Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            $244.8k
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>4.0%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last month
        </span>
    </div>
</div>
                    </div>
            <div x-show="period === 'weekly'"  style="display: none;"  class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Employee
            </span>
            <div class="size-6 text-brand-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path
      d="M14.109 5.104a2.947 2.947 0 11.001 5.39m1.687 2.727c3.802.224 5.024 2.788 5.416 4.47.186.797-.47 1.458-1.289 1.458H17.59m-5.839-11.35a2.947 2.947 0 11-5.894 0 2.947 2.947 0 015.894 0zM8.75 13.205c4.234 0 5.554 2.726 5.964 4.486.186.797-.47 1.458-1.29 1.458H4.076c-.818 0-1.475-.662-1.29-1.458.411-1.76 1.73-4.486 5.964-4.486z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,248
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>0.8%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last week
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Active Employee
            </span>
            <div class="size-6 text-green-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M20.625 13.9297L15.2341 19.3206L12.625 16.7116M9.92236 20.25H5.93164C5.10321 20.25 4.43164 19.5784 4.43164 18.75V17.439C4.43164 14.9537 6.44636 12.939 8.93164 12.939H9.94922M15.5935 6.34459C15.5935 8.32983 13.9841 9.93918 11.9989 9.93918C10.0137 9.93918 8.4043 8.32983 8.4043 6.34459C8.4043 4.35935 10.0137 2.75 11.9989 2.75C13.9841 2.75 15.5935 4.35935 15.5935 6.34459Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,180
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>2.4%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last week
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                On Leave
            </span>
            <div class="size-6 text-orange-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            68
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>4.2%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last week
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Payroll
            </span>
            <div class="size-6 text-pink-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M11.999 15.4605H11.5616C10.8367 15.4605 10.249 14.8728 10.249 14.1479M11.999 15.4605H12.249C13.0775 15.4605 13.749 14.7889 13.749 13.9605V13.6954C13.749 13.0701 13.3612 12.5105 12.7757 12.2909L11.2223 11.7083C10.6369 11.4888 10.249 10.9291 10.249 10.3038V10.0388C10.249 9.21034 10.9206 8.53876 11.749 8.53876H11.999M11.999 15.4605V16.6245M11.999 8.53876H12.4364C13.1614 8.53876 13.749 9.12643 13.749 9.85136M11.999 8.53876V7.37452M19.9994 7.76672V12.7605C19.9994 14.782 18.9814 16.6676 17.2914 17.7767L12.8227 20.7094C12.323 21.0373 11.6763 21.0373 11.1767 20.7094L6.70797 17.7767C5.01792 16.6676 4 14.782 4 12.7605V7.76672C4 7.035 4.52576 6.40446 5.23056 6.20778C6.65684 5.80977 9.09916 4.94592 11.3415 3.27064C11.7304 2.9801 12.269 2.9801 12.6578 3.27064C14.9002 4.94592 17.3425 5.80977 18.7688 6.20778C19.4736 6.40446 19.9994 7.035 19.9994 7.76672Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            $58.2k
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>1.5%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last week
        </span>
    </div>
</div>
                    </div>
            <div x-show="period === 'yearly'"  style="display: none;"  class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Employee
            </span>
            <div class="size-6 text-brand-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path
      d="M14.109 5.104a2.947 2.947 0 11.001 5.39m1.687 2.727c3.802.224 5.024 2.788 5.416 4.47.186.797-.47 1.458-1.289 1.458H17.59m-5.839-11.35a2.947 2.947 0 11-5.894 0 2.947 2.947 0 015.894 0zM8.75 13.205c4.234 0 5.554 2.726 5.964 4.486.186.797-.47 1.458-1.29 1.458H4.076c-.818 0-1.475-.662-1.29-1.458.411-1.76 1.73-4.486 5.964-4.486z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,248
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>14.5%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last year
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Active Employee
            </span>
            <div class="size-6 text-green-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M20.625 13.9297L15.2341 19.3206L12.625 16.7116M9.92236 20.25H5.93164C5.10321 20.25 4.43164 19.5784 4.43164 18.75V17.439C4.43164 14.9537 6.44636 12.939 8.93164 12.939H9.94922M15.5935 6.34459C15.5935 8.32983 13.9841 9.93918 11.9989 9.93918C10.0137 9.93918 8.4043 8.32983 8.4043 6.34459C8.4043 4.35935 10.0137 2.75 11.9989 2.75C13.9841 2.75 15.5935 4.35935 15.5935 6.34459Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            1,156
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>18.2%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last year
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                On Leave
            </span>
            <div class="size-6 text-orange-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            96
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>5.0%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last year
        </span>
    </div>
</div>
                            <div class="flex flex-col justify-between rounded-xl border border-gray-100 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div>
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                Total Payroll
            </span>
            <div class="size-6 text-pink-500">
                <svg class="size-6" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M11.999 15.4605H11.5616C10.8367 15.4605 10.249 14.8728 10.249 14.1479M11.999 15.4605H12.249C13.0775 15.4605 13.749 14.7889 13.749 13.9605V13.6954C13.749 13.0701 13.3612 12.5105 12.7757 12.2909L11.2223 11.7083C10.6369 11.4888 10.249 10.9291 10.249 10.3038V10.0388C10.249 9.21034 10.9206 8.53876 11.749 8.53876H11.999M11.999 15.4605V16.6245M11.999 8.53876H12.4364C13.1614 8.53876 13.749 9.12643 13.749 9.85136M11.999 8.53876V7.37452M19.9994 7.76672V12.7605C19.9994 14.782 18.9814 16.6676 17.2914 17.7767L12.8227 20.7094C12.323 21.0373 11.6763 21.0373 11.1767 20.7094L6.70797 17.7767C5.01792 16.6676 4 14.782 4 12.7605V7.76672C4 7.035 4.52576 6.40446 5.23056 6.20778C6.65684 5.80977 9.09916 4.94592 11.3415 3.27064C11.7304 2.9801 12.269 2.9801 12.6578 3.27064C14.9002 4.94592 17.3425 5.80977 18.7688 6.20778C19.4736 6.40446 19.9994 7.035 19.9994 7.76672Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>            </div>
        </div>

        <h3 class="mt-2 text-2xl font-semibold text-gray-800 sm:text-3xl dark:text-white/90">
            $2.94M
        </h3>
    </div>

    <div class="mt-5 flex items-center gap-1.5">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                        <span>12.8%</span></span>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            than last year
        </span>
    </div>
</div>
                    </div>
    </div>
            <div x-data="{ period: 'monthly', labels: JSON.parse('{\u0022monthly\u0022:\u0022Monthly\u0022,\u0022weekly\u0022:\u0022Weekly\u0022,\u0022yearly\u0022:\u0022Yearly\u0022}') }"
    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <div class="mb-6 flex items-center justify-between">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
        Attendance overview
    </h3>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-1 border-gray-300 bg-white px-3 text-xs text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50" type="button" ><span x-text="labels[period]"></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-bind:class="period === 'monthly' && 'bg-gray-100 font-medium dark:bg-white/5'" x-on:click.capture="period = 'monthly'" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer">Monthly</div>
                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-bind:class="period === 'weekly' && 'bg-gray-100 font-medium dark:bg-white/5'" x-on:click.capture="period = 'weekly'" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer">Weekly</div>
                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-bind:class="period === 'yearly' && 'bg-gray-100 font-medium dark:bg-white/5'" x-on:click.capture="period = 'yearly'" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer">Yearly</div></div>
    </div>
</template></div>
</div>
            <div x-show="period === 'monthly'" >
            <div class="custom-scrollbar overflow-x-auto">
    <div class="hm-wrapper relative min-w-105 select-none"
        x-data="{
            tooltip: null,
            enter(e, day, time) {
                const rect = e.currentTarget.getBoundingClientRect();
                const wrapper = e.currentTarget.closest('.hm-wrapper');
                const wRect = wrapper.getBoundingClientRect();
                const cellLeft = rect.left - wRect.left;
                const cellRight = rect.right - wRect.left;
                const cellCenter = cellLeft + rect.width / 2;
                const wrapperWidth = wRect.width;
                let x, align;
                if (cellCenter < 80) { x = Math.max(2, cellLeft); align = 'left'; }
                else if (wrapperWidth - cellCenter < 80) { x = Math.min(wrapperWidth - 2, cellRight); align = 'right'; }
                else { x = cellCenter; align = 'center'; }
                const yOffset = rect.top - wRect.top;
                const placement = yOffset < 36 ? 'bottom' : 'top';
                this.tooltip = { day, time, x, y: placement === 'bottom' ? yOffset + rect.height + 6 : yOffset - 6, placement, align };
            },
        }"
        @mouseleave="tooltip = null">
        <!-- Hover Tooltip -->
        <div x-show="tooltip" style="display: none;"
            class="pointer-events-none absolute z-10 rounded-md border border-gray-200 bg-white px-2.5 py-1 text-xs font-medium whitespace-nowrap text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
            :class="[
                tooltip?.placement === 'top' ? '-translate-y-full' : 'translate-y-0',
                tooltip?.align === 'left' && 'translate-x-0',
                tooltip?.align === 'right' && '-translate-x-full',
                (!tooltip?.align || tooltip?.align === 'center') && '-translate-x-1/2',
            ]"
            :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y}px` : ''">
            <span class="font-semibold text-gray-800 dark:text-gray-100" x-text="tooltip?.day"></span>
            <span class="mx-1 text-gray-400 dark:text-gray-500">·</span>
            <span x-text="tooltip?.time"></span>
        </div>

        <div class="flex gap-4">
            <!-- Y-axis Time Labels -->
            <div class="flex flex-col gap-2 text-xs text-gray-500 select-none dark:text-gray-400">
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        01:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        12:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        11:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        10:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        09:00 AM
                    </div>
                            </div>

            <!-- Heatmap Matrix & X-axis Day Labels -->
            <div class="flex flex-1 flex-col">
                <!-- Heatmap Matrix -->
                <div class="flex flex-col gap-1">
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Mon', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Tue', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Wed', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Thu', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Fri', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sun', '01:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Mon', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Tue', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Wed', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Thu', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Fri', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Sun', '12:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Mon', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Tue', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Wed', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Thu', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Fri', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Sat', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Sun', '11:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Mon', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Tue', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Wed', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Fri', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Sat', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Sun', '10:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Mon', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Tue', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Wed', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Thu', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Sat', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Sun', '09:00 AM')"></div>
                                </div>
                                                    </div>
                                    </div>

                <!-- X-axis Day Labels -->
                <div class="mt-4 flex gap-2 text-center text-xs font-normal text-gray-500 dark:text-gray-400">
                                            <span class="flex-1">Mon</span>
                                            <span class="flex-1">Tue</span>
                                            <span class="flex-1">Wed</span>
                                            <span class="flex-1">Thu</span>
                                            <span class="flex-1">Fri</span>
                                            <span class="flex-1">Sat</span>
                                            <span class="flex-1">Sun</span>
                                    </div>
            </div>
        </div>
    </div>
</div>
        </div>
            <div x-show="period === 'weekly'"  style="display: none;" >
            <div class="custom-scrollbar overflow-x-auto">
    <div class="hm-wrapper relative min-w-105 select-none"
        x-data="{
            tooltip: null,
            enter(e, day, time) {
                const rect = e.currentTarget.getBoundingClientRect();
                const wrapper = e.currentTarget.closest('.hm-wrapper');
                const wRect = wrapper.getBoundingClientRect();
                const cellLeft = rect.left - wRect.left;
                const cellRight = rect.right - wRect.left;
                const cellCenter = cellLeft + rect.width / 2;
                const wrapperWidth = wRect.width;
                let x, align;
                if (cellCenter < 80) { x = Math.max(2, cellLeft); align = 'left'; }
                else if (wrapperWidth - cellCenter < 80) { x = Math.min(wrapperWidth - 2, cellRight); align = 'right'; }
                else { x = cellCenter; align = 'center'; }
                const yOffset = rect.top - wRect.top;
                const placement = yOffset < 36 ? 'bottom' : 'top';
                this.tooltip = { day, time, x, y: placement === 'bottom' ? yOffset + rect.height + 6 : yOffset - 6, placement, align };
            },
        }"
        @mouseleave="tooltip = null">
        <!-- Hover Tooltip -->
        <div x-show="tooltip" style="display: none;"
            class="pointer-events-none absolute z-10 rounded-md border border-gray-200 bg-white px-2.5 py-1 text-xs font-medium whitespace-nowrap text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
            :class="[
                tooltip?.placement === 'top' ? '-translate-y-full' : 'translate-y-0',
                tooltip?.align === 'left' && 'translate-x-0',
                tooltip?.align === 'right' && '-translate-x-full',
                (!tooltip?.align || tooltip?.align === 'center') && '-translate-x-1/2',
            ]"
            :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y}px` : ''">
            <span class="font-semibold text-gray-800 dark:text-gray-100" x-text="tooltip?.day"></span>
            <span class="mx-1 text-gray-400 dark:text-gray-500">·</span>
            <span x-text="tooltip?.time"></span>
        </div>

        <div class="flex gap-4">
            <!-- Y-axis Time Labels -->
            <div class="flex flex-col gap-2 text-xs text-gray-500 select-none dark:text-gray-400">
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        01:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        12:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        11:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        10:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        09:00 AM
                    </div>
                            </div>

            <!-- Heatmap Matrix & X-axis Day Labels -->
            <div class="flex flex-1 flex-col">
                <!-- Heatmap Matrix -->
                <div class="flex flex-col gap-1">
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Mon', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Tue', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Wed', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Thu', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Fri', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Sat', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Sun', '01:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Mon', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Tue', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Wed', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Thu', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Sun', '12:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Mon', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Tue', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Wed', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sun', '11:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Mon', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Tue', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Wed', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Thu', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Fri', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Sat', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sun', '10:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Mon', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Tue', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Wed', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Fri', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-gray-100 dark:bg-gray-800"
                                        @mouseenter="enter($event, 'Sun', '09:00 AM')"></div>
                                </div>
                                                    </div>
                                    </div>

                <!-- X-axis Day Labels -->
                <div class="mt-4 flex gap-2 text-center text-xs font-normal text-gray-500 dark:text-gray-400">
                                            <span class="flex-1">Mon</span>
                                            <span class="flex-1">Tue</span>
                                            <span class="flex-1">Wed</span>
                                            <span class="flex-1">Thu</span>
                                            <span class="flex-1">Fri</span>
                                            <span class="flex-1">Sat</span>
                                            <span class="flex-1">Sun</span>
                                    </div>
            </div>
        </div>
    </div>
</div>
        </div>
            <div x-show="period === 'yearly'"  style="display: none;" >
            <div class="custom-scrollbar overflow-x-auto">
    <div class="hm-wrapper relative min-w-105 select-none"
        x-data="{
            tooltip: null,
            enter(e, day, time) {
                const rect = e.currentTarget.getBoundingClientRect();
                const wrapper = e.currentTarget.closest('.hm-wrapper');
                const wRect = wrapper.getBoundingClientRect();
                const cellLeft = rect.left - wRect.left;
                const cellRight = rect.right - wRect.left;
                const cellCenter = cellLeft + rect.width / 2;
                const wrapperWidth = wRect.width;
                let x, align;
                if (cellCenter < 80) { x = Math.max(2, cellLeft); align = 'left'; }
                else if (wrapperWidth - cellCenter < 80) { x = Math.min(wrapperWidth - 2, cellRight); align = 'right'; }
                else { x = cellCenter; align = 'center'; }
                const yOffset = rect.top - wRect.top;
                const placement = yOffset < 36 ? 'bottom' : 'top';
                this.tooltip = { day, time, x, y: placement === 'bottom' ? yOffset + rect.height + 6 : yOffset - 6, placement, align };
            },
        }"
        @mouseleave="tooltip = null">
        <!-- Hover Tooltip -->
        <div x-show="tooltip" style="display: none;"
            class="pointer-events-none absolute z-10 rounded-md border border-gray-200 bg-white px-2.5 py-1 text-xs font-medium whitespace-nowrap text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
            :class="[
                tooltip?.placement === 'top' ? '-translate-y-full' : 'translate-y-0',
                tooltip?.align === 'left' && 'translate-x-0',
                tooltip?.align === 'right' && '-translate-x-full',
                (!tooltip?.align || tooltip?.align === 'center') && '-translate-x-1/2',
            ]"
            :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y}px` : ''">
            <span class="font-semibold text-gray-800 dark:text-gray-100" x-text="tooltip?.day"></span>
            <span class="mx-1 text-gray-400 dark:text-gray-500">·</span>
            <span x-text="tooltip?.time"></span>
        </div>

        <div class="flex gap-4">
            <!-- Y-axis Time Labels -->
            <div class="flex flex-col gap-2 text-xs text-gray-500 select-none dark:text-gray-400">
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        01:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        12:00 PM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        11:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        10:00 AM
                    </div>
                                    <div class="flex h-8 items-center leading-none whitespace-nowrap sm:h-9">
                        09:00 AM
                    </div>
                            </div>

            <!-- Heatmap Matrix & X-axis Day Labels -->
            <div class="flex flex-1 flex-col">
                <!-- Heatmap Matrix -->
                <div class="flex flex-col gap-1">
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Mon', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Tue', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Wed', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Thu', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Fri', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sat', '01:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sun', '01:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Mon', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Tue', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Wed', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Sat', '12:00 PM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-100 dark:bg-brand-950/60"
                                        @mouseenter="enter($event, 'Sun', '12:00 PM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Mon', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Tue', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Wed', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Thu', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Sat', '11:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Sun', '11:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Mon', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Tue', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-200 dark:bg-brand-900/60"
                                        @mouseenter="enter($event, 'Wed', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Fri', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Sat', '10:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Sun', '10:00 AM')"></div>
                                </div>
                                                    </div>
                                            <div class="flex gap-2">
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Mon', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Tue', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-500 dark:bg-brand-500"
                                        @mouseenter="enter($event, 'Wed', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Thu', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-400 dark:bg-brand-600/70"
                                        @mouseenter="enter($event, 'Fri', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Sat', '09:00 AM')"></div>
                                </div>
                                                            <div class="flex-1">
                                    <div class="h-8 w-full cursor-pointer rounded-lg transition-all duration-200 hover:opacity-80 sm:h-9 bg-brand-300 dark:bg-brand-700/60"
                                        @mouseenter="enter($event, 'Sun', '09:00 AM')"></div>
                                </div>
                                                    </div>
                                    </div>

                <!-- X-axis Day Labels -->
                <div class="mt-4 flex gap-2 text-center text-xs font-normal text-gray-500 dark:text-gray-400">
                                            <span class="flex-1">Mon</span>
                                            <span class="flex-1">Tue</span>
                                            <span class="flex-1">Wed</span>
                                            <span class="flex-1">Thu</span>
                                            <span class="flex-1">Fri</span>
                                            <span class="flex-1">Sat</span>
                                            <span class="flex-1">Sun</span>
                                    </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-2 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-center justify-between ps-4">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
            Employee by Department
        </h3>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
            <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View Details</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Export Data</div></div>
    </div>
</template></div>
    </div>

    <div class="mt-5 flex items-end gap-3 ps-4">
        <span class="text-3xl font-semibold text-gray-800 dark:text-white/90">1,248</span>
        <div class="mb-1 flex items-center gap-1.5">
            <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"><svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                <span>3.2%</span></span>
            <span class="text-xs text-gray-500 dark:text-gray-400">
                than last month
            </span>
        </div>
    </div>

    <!-- Segmented Progress Bar -->
    <div class="mt-4 flex h-10 w-full items-center gap-1 rounded-xl bg-gray-100 p-1 dark:bg-gray-800">
                    <div class="h-full transition-all rounded-s-lg"
                style="width: 48%; background-color: #9B8AFB"
                title="Engineering: 48% (599)"></div>
                    <div class="h-full transition-all rounded-sm"
                style="width: 22%; background-color: #7CD4FD"
                title="Marketing: 22% (275)"></div>
                    <div class="h-full transition-all rounded-sm"
                style="width: 11%; background-color: #FDA29B"
                title="Sales: 11% (137)"></div>
                    <div class="h-full transition-all rounded-sm"
                style="width: 9%; background-color: #FFB1CE"
                title="Human Resources: 9% (112)"></div>
                    <div class="h-full transition-all rounded-sm"
                style="width: 5%; background-color: #9DB3B6"
                title="Finance: 5% (63)"></div>
                    <div class="h-full transition-all rounded-e-lg"
                style="width: 5%; background-color: #E4E7EC"
                title="Others: 5% (63)"></div>
            </div>

    <!-- Departments List Table -->
    <div class="mt-5 divide-y divide-gray-100 rounded-xl border border-gray-100 dark:divide-gray-800 dark:border-gray-800">
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #9B8AFB"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Engineering
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">48%</span>
                    <span class="text-gray-500 dark:text-gray-400">(599)</span>
                </div>
            </div>
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #7CD4FD"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Marketing
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">22%</span>
                    <span class="text-gray-500 dark:text-gray-400">(275)</span>
                </div>
            </div>
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #FDA29B"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Sales
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">11%</span>
                    <span class="text-gray-500 dark:text-gray-400">(137)</span>
                </div>
            </div>
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #FFB1CE"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Human Resources
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">9%</span>
                    <span class="text-gray-500 dark:text-gray-400">(112)</span>
                </div>
            </div>
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #9DB3B6"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Finance
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">5%</span>
                    <span class="text-gray-500 dark:text-gray-400">(63)</span>
                </div>
            </div>
                    <div class="flex items-center justify-between px-3.5 py-3">
                <div class="flex items-center gap-2">
                    <span class="size-2.5 rounded-full" style="background-color: #E4E7EC"></span>
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Others
                    </span>
                </div>
                <div class="flex items-center gap-2 text-sm font-medium">
                    <span class="text-gray-800 dark:text-white/90">5%</span>
                    <span class="text-gray-500 dark:text-gray-400">(63)</span>
                </div>
            </div>
            </div>
</div>
        </div>

        <div class="col-span-12 space-y-4 md:space-y-6 xl:col-span-5">
            <div x-data="{ activeDay: 21, meetings: JSON.parse('[{\u0022id\u0022:\u0022meeting-1\u0022,\u0022key\u0022:\u0022productSync\u0022,\u0022title\u0022:\u0022Product Team Sync\u0022,\u0022time\u0022:\u002210:00 PM - 12:00 PM\u0022,\u0022participants\u0022:[{\u0022name\u0022:\u0022Alex\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022},{\u0022name\u0022:\u0022Sarah\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022},{\u0022name\u0022:\u0022David\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022},{\u0022name\u0022:\u0022Emily\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022},{\u0022name\u0022:\u0022Michael\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022}],\u0022extraParticipantsCount\u0022:2,\u0022date\u0022:21},{\u0022id\u0022:\u0022meeting-2\u0022,\u0022key\u0022:\u0022frontendInterview\u0022,\u0022title\u0022:\u0022Interview Candidates - Frontend Developer\u0022,\u0022time\u0022:\u002201:00 PM - 02:00 PM\u0022,\u0022participants\u0022:[{\u0022name\u0022:\u0022John\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-06.jpg\u0022},{\u0022name\u0022:\u0022Lisa\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-07.jpg\u0022},{\u0022name\u0022:\u0022James\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-08.jpg\u0022},{\u0022name\u0022:\u0022Emma\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-09.jpg\u0022},{\u0022name\u0022:\u0022Daniel\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-10.jpg\u0022}],\u0022extraParticipantsCount\u0022:1,\u0022date\u0022:21}]'), days: JSON.parse('[19,20,21,22,23,24,25]'),
        prevDate() {
            const idx = this.days.indexOf(this.activeDay);
            this.activeDay = idx <= 0 ? this.days[this.days.length - 1] : this.days[idx - 1];
        },
        nextDate() {
            const idx = this.days.indexOf(this.activeDay);
            this.activeDay = idx === -1 || idx >= this.days.length - 1 ? this.days[0] : this.days[idx + 1];
        } }"
    x-on:hr-add-meeting.window="meetings = [$event.detail, ...meetings]"
    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents"><!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
                Interview and Meetings
            </h3>

            <button data-slot="dialog-trigger" aria-haspopup="dialog" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:aria-controls="open ? id : null" x-bind:data-state="state" x-on:click="show()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50" type="button" aria-label="Add meeting"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M5 12h14M12 5v14" />
  </svg></button>
        </div>

        <!-- Mini Schedule Calendar -->
        <div class="mt-5 border-b border-gray-200 pb-5 dark:border-gray-800">
            <!-- Month Navigator -->
            <div class="flex items-center justify-between rounded-xl bg-gray-50 px-3 py-2 dark:bg-white/3">
                <button data-slot="button" type="button" aria-label="Previous date" x-on:click="prevDate()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-lg in-data-[slot=button-group]:rounded-lg size-7 bg-white dark:border-gray-700 dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></button>

                <span class="text-sm font-medium text-gray-800 dark:text-white/90">January 2027</span>

                <button data-slot="button" type="button" aria-label="Next date" x-on:click="nextDate()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-lg in-data-[slot=button-group]:rounded-lg size-7 bg-white dark:border-gray-700 dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg></button>
            </div>

            <!-- Days Row -->
            <div class="mt-3 flex items-center justify-between gap-1 sm:gap-2">
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 19">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Mon
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 19
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                19
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 20">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Tue
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 20
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                20
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 21">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Wed
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 21
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                21
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 22">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Thu
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 22
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                22
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 23">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Fri
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 23
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                23
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 24">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Sat
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 24
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                24
            </span>
        </button>
            <button type="button" class="flex cursor-pointer flex-col items-center gap-1.5 focus:outline-none" @click="activeDay = 25">
            <span class="text-xs text-gray-500 dark:text-gray-400">
                Sun
            </span>
            <span class="flex size-8 items-center justify-center rounded-full text-xs font-medium transition-colors sm:size-9 sm:text-sm"
                :class="activeDay === 25
                    ? 'bg-brand-500 text-white shadow-sm ring-2 ring-brand-500/30'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'">
                25
            </span>
        </button>
    </div>
        </div>

        <!-- Meeting Cards List wrapped with ScrollArea -->
        <div data-slot="scroll-area"  class="relative mt-5 max-h-75 pe-1">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 max-h-[300px]">
        <div class="min-w-0"><div class="space-y-3">
                <template x-for="meeting in meetings" x-bind:key="meeting.id">
                    <div class="rounded-xl bg-gray-50 p-4 transition-colors dark:bg-white/3">
    <div>
        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="meeting.title ?? 'Meeting'"></h4>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="meeting.time"></p>
    </div>

    <div class="my-3.5 border-b border-dashed border-gray-200 dark:border-gray-800"></div>

    <div class="flex items-center justify-between">
        <!-- Avatars Stack -->
        <div data-slot="avatar-group"  class="group/avatar-group flex -space-x-2 *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! rtl:space-x-reverse"><template x-for="(p, idx) in meeting.participants.slice(0, 5)" x-bind:key="idx">
                <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="p.avatar" x-bind:alt="p.name" class="aspect-square size-full rounded-full object-cover">
                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"><span x-text="p.name.slice(0, 2).toUpperCase()"></span></span>
</template></span>
            </template>
            <template x-if="meeting.extraParticipantsCount">
                <div data-slot="avatar-group-count"  class="relative flex size-10 shrink-0 items-center justify-center rounded-full bg-[#F3F4F6] text-gray-700 ring-2 ring-white group-has-data-[size=lg]/avatar-group:size-12 group-has-data-[size=sm]/avatar-group:size-8 group-has-data-[size=xl]/avatar-group:size-14 group-has-data-[size=xs]/avatar-group:size-6 dark:bg-[#192130] dark:text-gray-400 dark:ring-gray-800 [&amp;&gt;svg]:size-4 group-has-data-[size=lg]/avatar-group:[&amp;&gt;svg]:size-5 group-has-data-[size=sm]/avatar-group:[&amp;&gt;svg]:size-3 text-[10px] font-medium">+<span x-text="meeting.extraParticipantsCount"></span></div>
            </template></div>

        <!-- Join Now Button -->
        <button type="button"
            class="cursor-pointer rounded-md border border-brand-500 px-2.5 py-1 text-xs font-medium text-brand-500 transition-colors hover:bg-brand-500 hover:text-white dark:hover:bg-brand-500">
            Join Now
        </button>
    </div>
</div>
                </template>
            </div></div>
    </div>
</div>

        <!-- Add Meeting Dialog -->
        <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 rounded-2xl border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 sm:max-w-lg rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-w-140 p-6">
            <div data-slot="dialog-header"  class="flex flex-col gap-2"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-lg font-semibold text-gray-800 dark:text-white/90">Add New Meeting</h2>
        <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm text-gray-500 dark:text-gray-400">Schedule an interview or team discussion for your HR calendar.</p></div>

    <form class="mt-4 space-y-4"
        x-data="{
            title: '',
            meetingType: 'interview',
            format: 'online',
            time: '10:00 AM - 11:30 AM',
            available: JSON.parse('[{\u0022name\u0022:\u0022Alex Morgan\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022},{\u0022name\u0022:\u0022Sarah Connor\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-02.jpg\u0022},{\u0022name\u0022:\u0022David Miller\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-03.jpg\u0022},{\u0022name\u0022:\u0022Emily Blunt\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-04.jpg\u0022},{\u0022name\u0022:\u0022Michael Chang\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022}]'),
            selected: ['Alex Morgan', 'Sarah Connor'],
            notify: true,
            toggle(name, checked) {
                this.selected = checked ? [...new Set([...this.selected, name])] : this.selected.filter((p) => p !== name);
            },
            submit() {
                if (!this.title.trim()) return;
                const chosen = this.available.filter((p) => this.selected.includes(p.name));
                window.dispatchEvent(new CustomEvent('hr-add-meeting', { detail: {
                    id: `meeting-${Date.now()}`,
                    title: this.title.trim(),
                    time: this.time.trim() || '10:00 AM - 11:00 AM',
                    participants: chosen.length > 0 ? chosen : [this.available[0]],
                    extraParticipantsCount: chosen.length > 5 ? chosen.length - 5 : undefined,
                    date: activeDay,
                    format: this.format,
                    category: this.meetingType,
                } }));
                this.title = '';
                this.time = '10:00 AM - 11:30 AM';
                close();
            },
        }"
        x-on:submit.prevent="submit()">
        <!-- Meeting Title -->
        <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Meeting Title</label>
            <input data-slot="input" x-model="title" type="text" placeholder="e.g. Senior Frontend Engineer Interview" required="required" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>

        <!-- Meeting Type & Format -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Meeting Type</label>
                <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u0022interview\u0022,\u0022multiple\u0022:false}'))" class="contents" x-on:change="meetingType = $event.detail.value"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="default" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
     class="group/select-trigger flex w-full min-w-0 items-center justify-between gap-2 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-3.5 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-all duration-200 select-none hover:border-gray-400 hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:border-gray-600 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? 'Select type'">Select type</span>
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 transition-transform duration-200 group-hover/select-trigger:text-gray-700 group-data-popup-open/select-trigger:rotate-180 dark:text-gray-400 dark:group-hover/select-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
</button>
                    <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="listbox" tabindex="-1" style="outline: none;" x-bind:id="id" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="select-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-select-content-available-height) min-w-(--reka-select-trigger-width) origin-(--reka-select-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635]">
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="interview"     x-init="register('interview', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('interview') ? 'true' : 'false'" x-bind:data-state="isSelected('interview') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('interview')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Candidate Interview</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('interview')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                        <div role="option" tabindex="-1" data-slot="select-item" data-value="sync"     x-init="register('sync', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('sync') ? 'true' : 'false'" x-bind:data-state="isSelected('sync') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('sync')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Team Sync</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('sync')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                        <div role="option" tabindex="-1" data-slot="select-item" data-value="evaluation"     x-init="register('evaluation', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('evaluation') ? 'true' : 'false'" x-bind:data-state="isSelected('evaluation') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('evaluation')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Performance Evaluation</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('evaluation')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                        <div role="option" tabindex="-1" data-slot="select-item" data-value="onboarding"     x-init="register('onboarding', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('onboarding') ? 'true' : 'false'" x-bind:data-state="isSelected('onboarding') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('onboarding')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">New Hire Onboarding</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('onboarding')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div></div>

            <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Meeting Format</label>
                <div role="radiogroup" dir="ltr" data-slot="radio-group" style="outline: none;"
    x-data="{ value: 'online' }" x-init="$watch('value', (v) => format = v)" class="w-full flex items-center gap-4 pt-2.5"><div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px w-auto gap-2"><button type="button" role="radio" data-slot="radio-group-item" value="online"  id="format-online"      aria-checked="true" data-state="checked"  data-checked=""  tabindex="0"
    x-bind:aria-checked="value === 'online' ? 'true' : 'false'" x-bind:data-state="value === 'online' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'online' ? '' : null"
    x-bind:tabindex="value === 'online' ? 0 : -1" x-on:click="value = 'online'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'online'"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                        <label data-slot="label" for="format-online" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-300">Online</label></div>
                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px w-auto gap-2"><button type="button" role="radio" data-slot="radio-group-item" value="in-person"  id="format-in-person"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'in-person' ? 'true' : 'false'" x-bind:data-state="value === 'in-person' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'in-person' ? '' : null"
    x-bind:tabindex="value === 'in-person' ? 0 : -1" x-on:click="value = 'in-person'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'in-person'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                        <label data-slot="label" for="format-in-person" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-300">In-person</label></div></div></div>
        </div>

        <!-- Meeting Time -->
        <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Meeting Time</label>
            <div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first ps-3.5 has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 20" fill="none" class="size-4">
    <path
      d="M13.333 10H10V5.415m7.708 4.583a7.708 7.708 0 11-15.416 0 7.708 7.708 0 0115.416 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                <input type="text" data-slot="input-group-control" x-model="time" placeholder="e.g. 11:00 AM - 12:30 PM" required="required" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div></div>

        <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch dark:bg-gray-700 my-2"></div>

        <!-- Attendees Selection -->
        <div>
            <label data-slot="label"  class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-2.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Select Attendees</label>
            <div class="grid max-h-36 grid-cols-1 gap-2.5 overflow-y-auto pe-1 sm:grid-cols-2">
                                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px cursor-pointer rounded-lg border border-gray-200 p-2 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="participant-0"       aria-checked="true" data-state="checked"  data-checked=""      x-data="{ checked: true }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="toggle('Alex Morgan', $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                        <label data-slot="label" for="participant-0" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">Alex Morgan</label></div>
                                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px cursor-pointer rounded-lg border border-gray-200 p-2 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="participant-1"       aria-checked="true" data-state="checked"  data-checked=""      x-data="{ checked: true }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="toggle('Sarah Connor', $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                        <label data-slot="label" for="participant-1" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">Sarah Connor</label></div>
                                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px cursor-pointer rounded-lg border border-gray-200 p-2 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="participant-2"       aria-checked="false" data-state="unchecked"      x-data="{ checked: false }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="toggle('David Miller', $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  style="display: none;"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                        <label data-slot="label" for="participant-2" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">David Miller</label></div>
                                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px cursor-pointer rounded-lg border border-gray-200 p-2 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="participant-3"       aria-checked="false" data-state="unchecked"      x-data="{ checked: false }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="toggle('Emily Blunt', $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  style="display: none;"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                        <label data-slot="label" for="participant-3" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">Emily Blunt</label></div>
                                    <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px cursor-pointer rounded-lg border border-gray-200 p-2 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/3"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="participant-4"       aria-checked="false" data-state="unchecked"      x-data="{ checked: false }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="toggle('Michael Chang', $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  style="display: none;"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                        <label data-slot="label" for="participant-4" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-medium text-gray-700 dark:text-gray-300">Michael Chang</label></div>
                            </div>
        </div>

        <!-- Notifications Checkbox -->
        <div class="pt-1">
            <div role="group" data-slot="field" data-orientation="horizontal"  class="group/field flex data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-row items-center has-[&gt;[data-slot=field-content]]:items-start *:data-[slot=field-label]:flex-auto has-[&gt;[data-slot=field-content]]:[&amp;&gt;[role=checkbox],[role=radio]]:mt-px w-auto gap-2.5"><button type="button" role="checkbox" data-slot="checkbox" value="on"
     id="notify-attendees"       aria-checked="true" data-state="checked"  data-checked=""      x-data="{ checked: true }"
    x-bind:aria-checked="checked ? 'true' : 'false'" x-bind:data-state="checked ? 'checked' : 'unchecked'" x-bind:data-checked="checked ? '' : null"
    x-on:click="checked = !checked; $dispatch('change', { checked })"
    x-on:change="notify = $event.detail.checked" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator" x-show="checked"  class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
</button>
                <label data-slot="label" for="notify-attendees" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-xs font-normal text-gray-600 dark:text-gray-400">Send calendar invitation and email notifications to attendees</label></div>
        </div>

        <div data-slot="dialog-footer"  class="-mx-6 -mb-6 rounded-b-2xl p-4 mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
    <button data-slot="button" type="button" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Cancel</button>
            <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 bg-brand-500 text-white hover:bg-brand-600">Schedule Meeting</button>
    </div>
    </form>
                            <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 in-data-[slot=button-group]:rounded-lg rounded-full text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white absolute end-3 top-3" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                        <span class="sr-only">Close</span></button>
                    </div>
    </div>
</template></div>
</div>
            <div x-data="{ period: 'monthly', labels: JSON.parse('{\u0022monthly\u0022:\u0022Monthly\u0022,\u0022weekly\u0022:\u0022Weekly\u0022,\u0022yearly\u0022:\u0022Yearly\u0022}') }"
    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h3 class="font-outfit text-lg font-semibold text-gray-800 dark:text-white/90">
            Job Statistics
        </h3>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 px-4 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-9 rounded-[10px] border-gray-300 bg-white py-2 ps-3 pe-2 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50" type="button" ><span x-text="labels[period]"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="ms-1 size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'monthly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Monthly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'weekly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Weekly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'yearly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Yearly</div></div>
    </div>
</template></div>
    </div>

            <div x-show="period === 'monthly'" >
            <!-- Chart -->
            <div class="my-5 flex items-center justify-center sm:my-6">
                <div x-data="{
        tooltip: null,
        move(e, label, value, color) {
            const rect = this.$root.getBoundingClientRect();
            this.tooltip = { label, value, color, x: e.clientX - rect.left, y: e.clientY - rect.top };
        },
        leave() { this.tooltip = null; },
    }"
    class="relative mx-auto flex h-35 w-70 items-end justify-center">
    <svg class="overflow-visible" width="278" height="140" viewBox="0 0 277.734 138.923" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- Container clip path: start and end have border radius and overflow is hidden -->
            <clipPath id="job-stats-clip-5RjWEy">
                <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" />
            </clipPath>
        </defs>

        <!-- Clipped container holding all slices -->
        <g clip-path="url(#job-stats-clip-5RjWEy)">
            <!-- Background Container Track (Hired / Remainder) -->
            <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" x-bind:fill="$store.theme.resolvedTheme === 'dark' ? '#1E2640' : '#F3F4F6'" fill="#F3F4F6"
                class="cursor-pointer transition-colors duration-300 hover:opacity-90"
                @mousemove="move($event, 'Hired', 32, $store.theme.resolvedTheme === 'dark' ? '#4B5563' : '#D1D5DC')"
                @mouseleave="leave()" />

            <!-- Interview Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 239.35 43.06 A 4 4 0 0 1 239.10 48.67 L 219.23 66.56 A 4 4 0 0 1 213.53 66.32 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#9CB9FF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Interview', 28, '#9CB9FF')"
                @mouseleave="leave()" />

            <!-- Active Job Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 149.40 0.45 A 4 4 0 0 1 152.97 4.79 L 150.17 31.37 A 4 4 0 0 1 145.77 35.01 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#465FFF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Active Job', 64, '#465FFF')"
                @mouseleave="leave()" />
        </g>
    </svg>

    <!-- Floating Tooltip -->
    <div x-show="tooltip" style="display: none;"
        class="pointer-events-none absolute z-20 -translate-x-1/2 -translate-y-full transform rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800"
        :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y - 8}px` : ''">
        <div class="flex items-center gap-1.5 text-xs">
            <span class="size-2 shrink-0 rounded-full" :style="tooltip ? `background-color: ${tooltip.color}` : ''"></span>
            <span class="text-gray-600 dark:text-gray-400"><span x-text="tooltip?.label"></span>:</span>
            <span class="font-semibold text-gray-900 dark:text-white" x-text="tooltip?.value"></span>
        </div>
    </div>

    <!-- Center Label -->
    <div class="pointer-events-none absolute inset-x-0 bottom-0 flex flex-col items-center justify-center text-center">
        <p class="font-outfit text-3xl leading-tight font-semibold text-gray-800 dark:text-white/90">120</p>
        <p class="font-outfit text-sm font-normal text-gray-500 dark:text-gray-400">Total Job</p>
    </div>
</div>
            </div>

            <!-- Metrics Row (Job Status Card) -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 rounded-xl border border-gray-100 bg-white rtl:divide-x-reverse dark:divide-gray-800 dark:border-gray-800 dark:bg-white/3">
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">64</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Active Job">
                            Active Job
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#9CB9FF]"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">28</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Interview">
                            Interview
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#D9D9D9] dark:bg-gray-600"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">32</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Hired">
                            Hired
                        </span>
                    </div>
                            </div>
        </div>
            <div x-show="period === 'weekly'"  style="display: none;" >
            <!-- Chart -->
            <div class="my-5 flex items-center justify-center sm:my-6">
                <div x-data="{
        tooltip: null,
        move(e, label, value, color) {
            const rect = this.$root.getBoundingClientRect();
            this.tooltip = { label, value, color, x: e.clientX - rect.left, y: e.clientY - rect.top };
        },
        leave() { this.tooltip = null; },
    }"
    class="relative mx-auto flex h-35 w-70 items-end justify-center">
    <svg class="overflow-visible" width="278" height="140" viewBox="0 0 277.734 138.923" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- Container clip path: start and end have border radius and overflow is hidden -->
            <clipPath id="job-stats-clip-VCW9kF">
                <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" />
            </clipPath>
        </defs>

        <!-- Clipped container holding all slices -->
        <g clip-path="url(#job-stats-clip-VCW9kF)">
            <!-- Background Container Track (Hired / Remainder) -->
            <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" x-bind:fill="$store.theme.resolvedTheme === 'dark' ? '#1E2640' : '#F3F4F6'" fill="#F3F4F6"
                class="cursor-pointer transition-colors duration-300 hover:opacity-90"
                @mousemove="move($event, 'Hired', 8, $store.theme.resolvedTheme === 'dark' ? '#4B5563' : '#D1D5DC')"
                @mouseleave="leave()" />

            <!-- Interview Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 245.96 50.50 A 4 4 0 0 1 245.30 56.08 L 224.21 72.50 A 4 4 0 0 1 218.53 71.85 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#9CB9FF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Interview', 12, '#9CB9FF')"
                @mouseleave="leave()" />

            <!-- Active Job Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 123.42 0.91 A 4 4 0 0 1 127.73 4.51 L 129.94 31.15 A 4 4 0 0 1 126.29 35.54 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#465FFF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Active Job', 18, '#465FFF')"
                @mouseleave="leave()" />
        </g>
    </svg>

    <!-- Floating Tooltip -->
    <div x-show="tooltip" style="display: none;"
        class="pointer-events-none absolute z-20 -translate-x-1/2 -translate-y-full transform rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800"
        :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y - 8}px` : ''">
        <div class="flex items-center gap-1.5 text-xs">
            <span class="size-2 shrink-0 rounded-full" :style="tooltip ? `background-color: ${tooltip.color}` : ''"></span>
            <span class="text-gray-600 dark:text-gray-400"><span x-text="tooltip?.label"></span>:</span>
            <span class="font-semibold text-gray-900 dark:text-white" x-text="tooltip?.value"></span>
        </div>
    </div>

    <!-- Center Label -->
    <div class="pointer-events-none absolute inset-x-0 bottom-0 flex flex-col items-center justify-center text-center">
        <p class="font-outfit text-3xl leading-tight font-semibold text-gray-800 dark:text-white/90">38</p>
        <p class="font-outfit text-sm font-normal text-gray-500 dark:text-gray-400">Total Job</p>
    </div>
</div>
            </div>

            <!-- Metrics Row (Job Status Card) -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 rounded-xl border border-gray-100 bg-white rtl:divide-x-reverse dark:divide-gray-800 dark:border-gray-800 dark:bg-white/3">
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">18</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Active Job">
                            Active Job
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#9CB9FF]"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">12</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Interview">
                            Interview
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#D9D9D9] dark:bg-gray-600"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">8</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Hired">
                            Hired
                        </span>
                    </div>
                            </div>
        </div>
            <div x-show="period === 'yearly'"  style="display: none;" >
            <!-- Chart -->
            <div class="my-5 flex items-center justify-center sm:my-6">
                <div x-data="{
        tooltip: null,
        move(e, label, value, color) {
            const rect = this.$root.getBoundingClientRect();
            this.tooltip = { label, value, color, x: e.clientX - rect.left, y: e.clientY - rect.top };
        },
        leave() { this.tooltip = null; },
    }"
    class="relative mx-auto flex h-35 w-70 items-end justify-center">
    <svg class="overflow-visible" width="278" height="140" viewBox="0 0 277.734 138.923" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- Container clip path: start and end have border radius and overflow is hidden -->
            <clipPath id="job-stats-clip-97j5Ch">
                <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" />
            </clipPath>
        </defs>

        <!-- Clipped container holding all slices -->
        <g clip-path="url(#job-stats-clip-97j5Ch)">
            <!-- Background Container Track (Hired / Remainder) -->
            <path d="M 30.73 138.92 L 4.00 138.92 A 4 4 0 0 1 0.06 134.92 A 138.87 138.87 0 0 1 277.68 134.92 A 4 4 0 0 1 273.74 138.92 L 247.01 138.92 A 4 4 0 0 1 242.93 134.92 A 104.14 104.14 0 0 0 34.81 134.92 A 4 4 0 0 1 30.73 138.92 Z" x-bind:fill="$store.theme.resolvedTheme === 'dark' ? '#1E2640' : '#F3F4F6'" fill="#F3F4F6"
                class="cursor-pointer transition-colors duration-300 hover:opacity-90"
                @mousemove="move($event, 'Hired', 110, $store.theme.resolvedTheme === 'dark' ? '#4B5563' : '#D1D5DC')"
                @mouseleave="leave()" />

            <!-- Interview Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 240.60 44.39 A 4 4 0 0 1 240.27 49.99 L 220.17 67.62 A 4 4 0 0 1 214.47 67.30 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#9CB9FF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Interview', 130, '#9CB9FF')"
                @mouseleave="leave()" />

            <!-- Active Job Slice -->
            <path d="M 34.73 138.92 L 0.00 138.92 A 138.87 138.87 0 0 1 134.87 0.11 A 4 4 0 0 1 138.87 4.05 L 138.87 30.78 A 4 4 0 0 1 134.87 34.86 A 104.14 104.14 0 0 0 34.73 138.92 Z" fill="#465FFF" class="cursor-pointer transition-all duration-200 hover:brightness-105"
                @mousemove="move($event, 'Active Job', 240, '#465FFF')"
                @mouseleave="leave()" />
        </g>
    </svg>

    <!-- Floating Tooltip -->
    <div x-show="tooltip" style="display: none;"
        class="pointer-events-none absolute z-20 -translate-x-1/2 -translate-y-full transform rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 shadow-theme-xs dark:border-gray-700 dark:bg-gray-800"
        :style="tooltip ? `left: ${tooltip.x}px; top: ${tooltip.y - 8}px` : ''">
        <div class="flex items-center gap-1.5 text-xs">
            <span class="size-2 shrink-0 rounded-full" :style="tooltip ? `background-color: ${tooltip.color}` : ''"></span>
            <span class="text-gray-600 dark:text-gray-400"><span x-text="tooltip?.label"></span>:</span>
            <span class="font-semibold text-gray-900 dark:text-white" x-text="tooltip?.value"></span>
        </div>
    </div>

    <!-- Center Label -->
    <div class="pointer-events-none absolute inset-x-0 bottom-0 flex flex-col items-center justify-center text-center">
        <p class="font-outfit text-3xl leading-tight font-semibold text-gray-800 dark:text-white/90">480</p>
        <p class="font-outfit text-sm font-normal text-gray-500 dark:text-gray-400">Total Job</p>
    </div>
</div>
            </div>

            <!-- Metrics Row (Job Status Card) -->
            <div class="grid grid-cols-3 divide-x divide-gray-100 rounded-xl border border-gray-100 bg-white rtl:divide-x-reverse dark:divide-gray-800 dark:border-gray-800 dark:bg-white/3">
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">240</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Active Job">
                            Active Job
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#9CB9FF]"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">130</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Interview">
                            Interview
                        </span>
                    </div>
                                    <div class="flex min-w-0 items-center justify-start gap-1.5 px-2.5 py-3 sm:gap-2 sm:px-4 sm:py-3.5">
                        <div class="flex shrink-0 items-center gap-1.5 sm:gap-2">
                            <span class="h-4.5 w-1.5 shrink-0 rounded-full bg-[#D9D9D9] dark:bg-gray-600"></span>
                            <span class="font-outfit text-base font-bold text-gray-800 sm:text-lg dark:text-white/90">110</span>
                        </div>
                        <span class="truncate text-xs font-medium whitespace-nowrap text-gray-500 sm:text-sm dark:text-gray-400" title="Hired">
                            Hired
                        </span>
                    </div>
                            </div>
        </div>
    </div>
            <div x-data="{ period: 'weekly', labels: JSON.parse('{\u0022weekly\u0022:\u0022Weekly\u0022,\u0022monthly\u0022:\u0022Monthly\u0022,\u0022yearly\u0022:\u0022Yearly\u0022}') }"
    class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">
            Employee Growth
        </h3>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-1 border-gray-300 bg-white px-3 text-xs text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50" type="button" ><span x-text="labels[period]"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'weekly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Weekly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'monthly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Monthly</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="period = 'yearly'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Yearly</div></div>
    </div>
</template></div>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
    <div class="-ms-4 min-w-70 sm:min-w-full">
        <div data-dashboard-chart="hr-employee-growth" data-config="{&quot;categories&quot;:[&quot;Sat&quot;,&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;],&quot;data&quot;:[210,180,240,280,480,290,390],&quot;seriesName&quot;:&quot;Employees&quot;}"></div>
    </div>
</div>
</div>
        </div>
    </div>

    <div data-slot="card" data-size="default" x-data="tanstackTable('employee-directory', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:\u0022emp-1\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022john doe|johndeo@gmail.com|engineering|senior developer|active|28 feb, 2020\u0022},{\u0022id\u0022:\u0022emp-2\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022onboarding\u0022,\u0022text\u0022:\u0022kierra franci|kierra@gmail.com|engineering|junior developer|onboarding|28 jan, 2020\u0022},{\u0022id\u0022:\u0022emp-3\u0022,\u0022departmentKey\u0022:\u0022hr\u0022,\u0022statusKey\u0022:\u0022onLeave\u0022,\u0022text\u0022:\u0022emerson workman|emerson@gmail.com|hr|hr specialist|on leave|5 jan, 2021\u0022},{\u0022id\u0022:\u0022emp-4\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022chance philips|chance@gmail.com|engineering|senior developer|active|12 dec, 2024\u0022},{\u0022id\u0022:\u0022emp-5\u0022,\u0022departmentKey\u0022:\u0022sales\u0022,\u0022statusKey\u0022:\u0022onLeave\u0022,\u0022text\u0022:\u0022terry geidt|terry@gmail.com|sales|account executive|on leave|25 nov, 2020\u0022},{\u0022id\u0022:\u0022emp-6\u0022,\u0022departmentKey\u0022:\u0022marketing\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022alice smith|alice@gmail.com|marketing|account executive|active|10 nov, 2021\u0022},{\u0022id\u0022:\u0022emp-7\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022bob brown|bob@gmail.com|engineering|junior developer|active|15 oct, 2022\u0022},{\u0022id\u0022:\u0022emp-8\u0022,\u0022departmentKey\u0022:\u0022finance\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022charlie davis|charlie@gmail.com|finance|account executive|active|20 sep, 2021\u0022},{\u0022id\u0022:\u0022emp-9\u0022,\u0022departmentKey\u0022:\u0022hr\u0022,\u0022statusKey\u0022:\u0022onboarding\u0022,\u0022text\u0022:\u0022david wilson|david@gmail.com|hr|hr specialist|onboarding|25 aug, 2023\u0022},{\u0022id\u0022:\u0022emp-10\u0022,\u0022departmentKey\u0022:\u0022sales\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022eve evans|eve@gmail.com|sales|account executive|active|30 jul, 2022\u0022},{\u0022id\u0022:\u0022emp-11\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022frank wright|frank@gmail.com|engineering|senior developer|active|05 jul, 2019\u0022},{\u0022id\u0022:\u0022emp-12\u0022,\u0022departmentKey\u0022:\u0022marketing\u0022,\u0022statusKey\u0022:\u0022onLeave\u0022,\u0022text\u0022:\u0022grace hall|grace@gmail.com|marketing|account executive|on leave|10 jun, 2023\u0022},{\u0022id\u0022:\u0022emp-13\u0022,\u0022departmentKey\u0022:\u0022finance\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022henry ford|henry@gmail.com|finance|account executive|active|15 may, 2021\u0022},{\u0022id\u0022:\u0022emp-14\u0022,\u0022departmentKey\u0022:\u0022engineering\u0022,\u0022statusKey\u0022:\u0022onboarding\u0022,\u0022text\u0022:\u0022ivy league|ivy@gmail.com|engineering|junior developer|onboarding|20 apr, 2024\u0022},{\u0022id\u0022:\u0022emp-15\u0022,\u0022departmentKey\u0022:\u0022hr\u0022,\u0022statusKey\u0022:\u0022active\u0022,\u0022text\u0022:\u0022jack black|jack@gmail.com|hr|hr specialist|active|25 mar, 2022\u0022}],\u0022pageSize\u0022:5}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Header Controls -->
    <div x-data="{ deptLabels: JSON.parse('{\u0022all\u0022:\u0022All Department\u0022,\u0022engineering\u0022:\u0022Engineering\u0022,\u0022hr\u0022:\u0022HR\u0022,\u0022sales\u0022:\u0022Sales\u0022,\u0022marketing\u0022:\u0022Marketing\u0022,\u0022finance\u0022:\u0022Finance\u0022}'), statusLabels: JSON.parse('{\u0022all\u0022:\u0022Status\u0022,\u0022active\u0022:\u0022Active\u0022,\u0022onboarding\u0022:\u0022Onboarding\u0022,\u0022onLeave\u0022:\u0022On Leave\u0022}') }"
    class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <div>
        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Employee Directory</div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <input data-slot="input" x-model="query" x-on:input="page = 1" type="text" placeholder="Search..." class="min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-10 w-full sm:w-60" />

        <!-- Department Filter -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-[10px] py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 gap-1.5 border-gray-200 bg-white px-3.5 text-sm font-normal text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800" type="button" ><span x-text="deptLabels[dept]"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'all'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">All Department</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'engineering'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Engineering</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'hr'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">HR</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'sales'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Sales</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'marketing'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Marketing</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="dept = 'finance'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Finance</div></div>
    </div>
</template></div>

        <!-- Status Filter -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-[10px] py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 gap-1.5 border-gray-200 bg-white px-3.5 text-sm font-normal text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800" type="button" ><span x-text="statusLabels[status]"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-500 dark:text-gray-400">
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
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="status = 'all'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Status</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="status = 'active'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Active</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="status = 'onboarding'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Onboarding</div>
                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="status = 'onLeave'; page = 1" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">On Leave</div></div>
    </div>
</template></div>
    </div>
</div>

    <!-- Table Content -->
    <div data-slot="card-content"  class="p-0"><div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-full">
                <thead class="border-y border-gray-100 bg-transparent dark:border-gray-800">
                    <tr class="h-11 border-b border-gray-100 dark:border-gray-800">
                                                    <th class="h-11 min-w-56 py-3 ps-6 pe-4 text-start whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Users
                                </span>
                            </th>
                                                    <th class="h-11 min-w-40 px-6 py-3 text-start whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Department
                                </span>
                            </th>
                                                    <th class="h-11 min-w-44 px-6 py-3 text-start whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Role
                                </span>
                            </th>
                                                    <th class="h-11 min-w-32 px-6 py-3 text-start whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Status
                                </span>
                            </th>
                                                    <th class="h-11 min-w-40 px-6 py-3 text-start whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Joined
                                </span>
                            </th>
                                                    <th class="h-11 min-w-16 py-3 ps-4 pe-6 text-end whitespace-nowrap">
                                <span class="text-xs font-medium text-gray-500 uppercase dark:text-gray-400">
                                    Action
                                </span>
                            </th>
                                            </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            <tr x-show="pageIds.includes('emp-1')"     :class="pageIds[pageIds.length - 1] === 'emp-1' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-01.jpg" alt="John Doe" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">John Doe</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">johndeo@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Senior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        28 Feb, 2020
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-1')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-2')"     :class="pageIds[pageIds.length - 1] === 'emp-2' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-02.jpg" alt="Kierra Franci" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Kierra Franci</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">kierra@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Junior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)]">Onboarding</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        28 Jan, 2020
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-2')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-3')"     :class="pageIds[pageIds.length - 1] === 'emp-3' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-03.jpg" alt="Emerson Workman" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Emerson Workman</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">emerson@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR Specialist
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">On Leave</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        5 Jan, 2021
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-3')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-4')"     :class="pageIds[pageIds.length - 1] === 'emp-4' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-04.jpg" alt="Chance Philips" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Chance Philips</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">chance@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Senior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        12 Dec, 2024
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-4')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-5')"     :class="pageIds[pageIds.length - 1] === 'emp-5' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-05.jpg" alt="Terry Geidt" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Terry Geidt</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">terry@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Sales
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">On Leave</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        25 Nov, 2020
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-5')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-6')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-6' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-06.jpg" alt="Alice Smith" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Alice Smith</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">alice@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Marketing
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        10 Nov, 2021
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-6')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-7')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-7' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-07.jpg" alt="Bob Brown" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Bob Brown</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">bob@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Junior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        15 Oct, 2022
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-7')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-8')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-8' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-08.jpg" alt="Charlie Davis" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Charlie Davis</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">charlie@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Finance
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        20 Sep, 2021
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-8')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-9')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-9' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-09.jpg" alt="David Wilson" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">David Wilson</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">david@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR Specialist
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)]">Onboarding</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        25 Aug, 2023
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-9')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-10')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-10' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-10.jpg" alt="Eve Evans" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Eve Evans</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">eve@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Sales
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        30 Jul, 2022
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-10')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-11')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-11' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-11.jpg" alt="Frank Wright" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Frank Wright</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">frank@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Senior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        05 Jul, 2019
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-11')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-12')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-12' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-12.jpg" alt="Grace Hall" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Grace Hall</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">grace@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Marketing
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">On Leave</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        10 Jun, 2023
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-12')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-13')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-13' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-13.jpg" alt="Henry Ford" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Henry Ford</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">henry@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Finance
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Account Executive
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        15 May, 2021
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-13')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-14')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-14' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-14.jpg" alt="Ivy League" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Ivy League</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">ivy@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Engineering
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        Junior Developer
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)]">Onboarding</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        20 Apr, 2024
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-14')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                            <tr x-show="pageIds.includes('emp-15')"  style="display: none;"     :class="pageIds[pageIds.length - 1] === 'emp-15' && 'border-b-0!'"
    class="h-18 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-10 shrink-0 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                <img src="/assets/images/user/user-15.jpg" alt="Jack Black" width="40" height="40" class="size-full object-cover" />
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Jack Black</span>
                <span class="block text-xs text-gray-500 dark:text-gray-400">jack@gmail.com</span>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        HR Specialist
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
    </td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-300">
        25 Mar, 2022
    </td>
    <td class="py-4 ps-4 pe-6 text-end whitespace-nowrap">
        <div class="inline-flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Actions"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    x-on:click.capture="remove('emp-15')" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                                        <tr x-show="pageIds.length === 0" style="display: none;">
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="mb-3 flex size-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6 text-gray-800 dark:text-white/90">
    <path
      d="M12 21.072V11.029m0 0c-.23 0-.46-.053-.67-.159m.67.159c.23 0 .46-.053.671-.159m0 0a1.5 1.5 0 01-1.341 0m1.341 0l7.55-3.774M11.33 10.87L3.78 7.096m16.441 0a1.499 1.499 0 00-.592-.533L12.67 3.084a1.5 1.5 0 00-1.341 0L4.372 6.563c-.247.123-.45.309-.592.533m16.441 0a1.5 1.5 0 01.237.808v8.19a1.5 1.5 0 01-.83 1.341l-6.957 3.479a1.5 1.5 0 01-1.341 0l-6.958-3.479a1.5 1.5 0 01-.829-1.342V7.904c0-.292.085-.571.237-.808"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                </div>
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">
                                    No employees found
                                </h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    No employees found matching the selected criteria.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table></div>
    </div>
</div></div>

    <!-- Table Footer - Pagination -->
    <div class="border-t-0 px-5 py-4 sm:px-6">
    <!-- Mobile Pagination (< sm) -->
    <div class="flex w-full items-center justify-between sm:hidden">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400" x-text="`${safePage}/${totalPages}`"></span>

        <div class="flex items-center gap-2">
            <a   data-slot="pagination-link" data-active="false" aria-label="Go to previous page" href="#" x-on:click.prevent="if (safePage > 1) page = safePage - 1" x-bind:class="safePage <= 1 && 'pointer-events-none cursor-not-allowed opacity-50'" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-start" class="rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></a>
            <a   data-slot="pagination-link" data-active="false" aria-label="Go to next page" href="#" x-on:click.prevent="if (safePage < totalPages) page = safePage + 1" x-bind:class="safePage >= totalPages && 'pointer-events-none cursor-not-allowed opacity-50'" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-end" class="rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg></a>
        </div>
    </div>

    <!-- Desktop Pagination (>= sm) -->
    <div class="hidden sm:flex sm:items-center sm:justify-start">
        <nav role="navigation" aria-label="pagination" data-slot="pagination"  class="flex mx-0 w-auto justify-start"><ul data-slot="pagination-content"  class="flex items-center gap-1.5"><li data-slot="pagination-item"><a   data-slot="pagination-link" data-active="false" aria-label="Go to previous page" href="#" x-on:click.prevent="if (safePage > 1) page = safePage - 1" x-bind:class="safePage <= 1 && 'pointer-events-none cursor-not-allowed opacity-50'" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-start" class="rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></a></li>

                <template x-for="(item, index) in pages" x-bind:key="index">
                    <li data-slot="pagination-item"><template x-if="typeof item !== 'number'">
                            <span aria-hidden="true" data-slot="pagination-ellipsis"  class="flex size-8 items-center justify-center dark:text-white/90 [&amp;_svg:not([class*=size-])]:size-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
<span class="sr-only">More pages</span></span>
                        </template>
                        <template x-if="typeof item === 'number'">
                            <a href="#" data-slot="pagination-link" x-bind:aria-current="item === safePage ? 'page' : null"
                                x-effect="$el.className = item === safePage ? 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500\/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-10 rounded-[10px]' : 'group\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]'"
                                x-on:click.prevent="page = item" x-text="item"></a>
                        </template></li>
                </template>

                <li data-slot="pagination-item"><a   data-slot="pagination-link" data-active="false" aria-label="Go to next page" href="#" x-on:click.prevent="if (safePage < totalPages) page = safePage + 1" x-bind:class="safePage >= totalPages && 'pointer-events-none cursor-not-allowed opacity-50'" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-end" class="rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg></a></li></ul></nav>
    </div>
</div></div>
</div>
            </div>
        </div>

    </div>

</body>


</html>
