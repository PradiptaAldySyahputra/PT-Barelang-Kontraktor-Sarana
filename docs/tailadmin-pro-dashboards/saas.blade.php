<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="space-y-6">
        <div
    x-data="{
        timeframe: 'weekly',
        data: {&quot;weekly&quot;:[{&quot;id&quot;:&quot;revenue&quot;,&quot;title&quot;:&quot;Total Revenue&quot;,&quot;value&quot;:&quot;$200,425.87&quot;,&quot;change&quot;:&quot;+ 2.5%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;users&quot;,&quot;title&quot;:&quot;Active Users&quot;,&quot;value&quot;:&quot;9,528&quot;,&quot;change&quot;:&quot;+ 9.5%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;clv&quot;,&quot;title&quot;:&quot;Customer Lifetime Value&quot;,&quot;value&quot;:&quot;$849.54&quot;,&quot;change&quot;:&quot;- 1.6%&quot;,&quot;direction&quot;:&quot;down&quot;},{&quot;id&quot;:&quot;cac&quot;,&quot;title&quot;:&quot;Customer Acquisition Cost&quot;,&quot;value&quot;:&quot;9,528&quot;,&quot;change&quot;:&quot;+ 3.5%&quot;,&quot;direction&quot;:&quot;up&quot;}],&quot;monthly&quot;:[{&quot;id&quot;:&quot;revenue&quot;,&quot;title&quot;:&quot;Total Revenue&quot;,&quot;value&quot;:&quot;$845,630.00&quot;,&quot;change&quot;:&quot;+ 8.2%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;users&quot;,&quot;title&quot;:&quot;Active Users&quot;,&quot;value&quot;:&quot;38,420&quot;,&quot;change&quot;:&quot;+ 12.4%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;clv&quot;,&quot;title&quot;:&quot;Customer Lifetime Value&quot;,&quot;value&quot;:&quot;$890.15&quot;,&quot;change&quot;:&quot;+ 3.8%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;cac&quot;,&quot;title&quot;:&quot;Customer Acquisition Cost&quot;,&quot;value&quot;:&quot;8,410&quot;,&quot;change&quot;:&quot;- 2.1%&quot;,&quot;direction&quot;:&quot;down&quot;}],&quot;yearly&quot;:[{&quot;id&quot;:&quot;revenue&quot;,&quot;title&quot;:&quot;Total Revenue&quot;,&quot;value&quot;:&quot;$9,842,500.00&quot;,&quot;change&quot;:&quot;+ 24.5%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;users&quot;,&quot;title&quot;:&quot;Active Users&quot;,&quot;value&quot;:&quot;420,500&quot;,&quot;change&quot;:&quot;+ 35.0%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;clv&quot;,&quot;title&quot;:&quot;Customer Lifetime Value&quot;,&quot;value&quot;:&quot;$1,240.50&quot;,&quot;change&quot;:&quot;+ 15.3%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;cac&quot;,&quot;title&quot;:&quot;Customer Acquisition Cost&quot;,&quot;value&quot;:&quot;7,200&quot;,&quot;change&quot;:&quot;- 8.4%&quot;,&quot;direction&quot;:&quot;down&quot;}]},
        items: [{&quot;id&quot;:&quot;revenue&quot;,&quot;title&quot;:&quot;Total Revenue&quot;,&quot;value&quot;:&quot;$200,425.87&quot;,&quot;change&quot;:&quot;+ 2.5%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;users&quot;,&quot;title&quot;:&quot;Active Users&quot;,&quot;value&quot;:&quot;9,528&quot;,&quot;change&quot;:&quot;+ 9.5%&quot;,&quot;direction&quot;:&quot;up&quot;},{&quot;id&quot;:&quot;clv&quot;,&quot;title&quot;:&quot;Customer Lifetime Value&quot;,&quot;value&quot;:&quot;$849.54&quot;,&quot;change&quot;:&quot;- 1.6%&quot;,&quot;direction&quot;:&quot;down&quot;},{&quot;id&quot;:&quot;cac&quot;,&quot;title&quot;:&quot;Customer Acquisition Cost&quot;,&quot;value&quot;:&quot;9,528&quot;,&quot;change&quot;:&quot;+ 3.5%&quot;,&quot;direction&quot;:&quot;up&quot;}],
        updateItems() {
            this.items = this.data[this.timeframe] || this.data.weekly;
        }
    }"
    class="flex flex-col gap-6 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Overview
        </h3>
    </div>

    <div class="flex flex-col items-stretch gap-3 sm:flex-row sm:items-center">
        <div class="inline-flex h-10 w-full items-center rounded-[10px] bg-gray-100 p-0.5 sm:w-auto dark:bg-gray-800">
                            <button
                    type="button"
                    @click="timeframe = 'weekly'; updateItems()"
                    :class="timeframe === 'weekly'
                        ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-900 dark:text-white'
                        : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'"
                    class="inline-flex h-full flex-1 items-center justify-center rounded-lg px-3 py-2 text-sm font-medium transition-colors select-none sm:flex-auto">
                    Weekly
                </button>
                            <button
                    type="button"
                    @click="timeframe = 'monthly'; updateItems()"
                    :class="timeframe === 'monthly'
                        ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-900 dark:text-white'
                        : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'"
                    class="inline-flex h-full flex-1 items-center justify-center rounded-lg px-3 py-2 text-sm font-medium transition-colors select-none sm:flex-auto">
                    Monthly
                </button>
                            <button
                    type="button"
                    @click="timeframe = 'yearly'; updateItems()"
                    :class="timeframe === 'yearly'
                        ? 'bg-white text-gray-900 shadow-theme-xs dark:bg-gray-900 dark:text-white'
                        : 'text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white'"
                    class="inline-flex h-full flex-1 items-center justify-center rounded-lg px-3 py-2 text-sm font-medium transition-colors select-none sm:flex-auto">
                    Yearly
                </button>
                    </div>

        <button
            type="button"
            class="inline-flex h-10 items-center justify-center gap-2 rounded-[10px] border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-300 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5 text-gray-500 dark:text-gray-400">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            <span>Filter</span>
        </button>
    </div>
</div>

    <div class="grid grid-cols-1 rounded-xl border border-gray-200 bg-white sm:grid-cols-2 xl:grid-cols-4 dark:border-gray-800 dark:bg-gray-900">
    <div class="flex flex-col gap-2 px-6 py-5 border-b border-gray-200 dark:border-gray-800 sm:border-e xl:border-b-0">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    <span x-text="items[0]?.title">Total Revenue</span>
            </span>

    <div class="flex items-center gap-3">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            <span x-text="items[0]?.value">$200,425.87</span>
                    </h4>

                    <span data-slot="badge" data-variant="light"
                :data-color="items[0]?.direction === 'up' ? 'success' : 'error'"
                data-size="sm"
                :class="items[0]?.direction === 'up' ? 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
                class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">
                <span x-text="items[0]?.change">+ 2.5%</span>
            </span>
            </div>
</div>
                    <div class="flex flex-col gap-2 px-6 py-5 border-b border-gray-200 dark:border-gray-800 xl:border-e xl:border-b-0">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    <span x-text="items[1]?.title">Active Users</span>
            </span>

    <div class="flex items-center gap-3">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            <span x-text="items[1]?.value">9,528</span>
                    </h4>

                    <span data-slot="badge" data-variant="light"
                :data-color="items[1]?.direction === 'up' ? 'success' : 'error'"
                data-size="sm"
                :class="items[1]?.direction === 'up' ? 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
                class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">
                <span x-text="items[1]?.change">+ 9.5%</span>
            </span>
            </div>
</div>
                    <div class="flex flex-col gap-2 px-6 py-5 border-b border-gray-200 dark:border-gray-800 sm:border-e sm:border-b-0 xl:border-e">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    <span x-text="items[2]?.title">Customer Lifetime Value</span>
            </span>

    <div class="flex items-center gap-3">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            <span x-text="items[2]?.value">$849.54</span>
                    </h4>

                    <span data-slot="badge" data-variant="light"
                :data-color="items[2]?.direction === 'up' ? 'success' : 'error'"
                data-size="sm"
                :class="items[2]?.direction === 'up' ? 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
                class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">
                <span x-text="items[2]?.change">- 1.6%</span>
            </span>
            </div>
</div>
                    <div class="flex flex-col gap-2 px-6 py-5">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    <span x-text="items[3]?.title">Customer Acquisition Cost</span>
            </span>

    <div class="flex items-center gap-3">
        <h4 class="text-2xl font-bold text-gray-800 dark:text-white/90">
                            <span x-text="items[3]?.value">9,528</span>
                    </h4>

                    <span data-slot="badge" data-variant="light"
                :data-color="items[3]?.direction === 'up' ? 'success' : 'error'"
                data-size="sm"
                :class="items[3]?.direction === 'up' ? 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
                class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">
                <span x-text="items[3]?.change">+ 3.5%</span>
            </span>
            </div>
</div>
</div>
</div>

        <div class="gap-6 space-y-5 sm:space-y-6 xl:grid xl:grid-cols-12 xl:space-y-0">
            <div class="space-y-5 sm:space-y-6 xl:col-span-7 2xl:col-span-8">
                <div class="grid gap-5 sm:gap-6 lg:grid-cols-2">
                    <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div class="flex items-start justify-between">
    <div>
        <div data-slot="card-title"  class="group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 mb-0 text-title-sm font-medium text-gray-800 dark:text-white/90">Churn Rate</div>
        <div data-slot="card-description"  class="mt-0.5 text-sm font-normal text-gray-500 dark:text-gray-400">Downgrade to Free plan</div>
    </div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg 
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <circle cx="12" cy="12" r="1" />
    <circle cx="12" cy="5" r="1" />
    <circle cx="12" cy="19" r="1" />
  </svg></button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
</div>

    <div class="flex items-end justify-between">
        <div>
            <h4 class="text-heading-six font-semibold text-gray-800 dark:text-white/90">4.26%</h4>
            <p class="mt-1 flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                <span class="font-medium text-error-500 dark:text-error-400">0.31%</span>
                <span>than last Week</span>
            </p>
        </div>

        <div class="h-10.5 w-25">
    <div data-dashboard-chart="saas-churn-rate" data-config='{"data":[28,27,20,18,22,24,18],"name":"Churn Rate"}'></div>
</div>
    </div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div class="flex items-start justify-between">
    <div>
        <div data-slot="card-title"  class="group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 mb-0 text-title-sm font-medium text-gray-800 dark:text-white/90">User Growth</div>
        <div data-slot="card-description"  class="mt-0.5 text-sm font-normal text-gray-500 dark:text-gray-400">New signups website + mobile</div>
    </div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg 
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <circle cx="12" cy="12" r="1" />
    <circle cx="12" cy="5" r="1" />
    <circle cx="12" cy="19" r="1" />
  </svg></button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
</div>

    <div class="flex items-end justify-between">
        <div>
            <h4 class="text-heading-six font-semibold text-gray-800 dark:text-white/90">3,768</h4>
            <p class="mt-1 flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                <span class="font-medium text-success-600 dark:text-success-500">+3.85%</span>
                <span>than last Week</span>
            </p>
        </div>

        <div class="h-10.5 w-25">
    <div data-dashboard-chart="saas-growth-rate" data-config='{"data":[12,17,16,26,32,33],"name":"Revenue"}'></div>
</div>
    </div></div>
                </div>

                <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
        Conversion Funnel
    </h3>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg 
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <circle cx="12" cy="12" r="1" />
    <circle cx="12" cy="5" r="1" />
    <circle cx="12" cy="19" r="1" />
  </svg></button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
</div>

    <div class="mt-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
    <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                    <div class="flex items-center gap-2">
                <span class="size-2.5 rounded-full" style="background-color: #7592FF;"></span>
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    Ad Impression
                </span>
            </div>
                    <div class="flex items-center gap-2">
                <span class="size-2.5 rounded-full" style="background-color: #BDB4FE;"></span>
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    Website Session
                </span>
            </div>
                    <div class="flex items-center gap-2">
                <span class="size-2.5 rounded-full" style="background-color: #7CD4FD;"></span>
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    New Users
                </span>
            </div>
            </div>

    <div class="text-base font-medium text-gray-800 dark:text-white/90">
        Total: 120k
    </div>
</div>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
        <div class="-ms-4 min-w-130 xl:min-w-full">
            <div data-dashboard-chart="saas-conversion-funnel" data-config="{&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;],&quot;series&quot;:[{&quot;name&quot;:&quot;New Users&quot;,&quot;data&quot;:[28,35,18,68,24,28,28]},{&quot;name&quot;:&quot;Website Session&quot;,&quot;data&quot;:[28,30,34,15,25,28,28]},{&quot;name&quot;:&quot;Ad Impression&quot;,&quot;data&quot;:[48,30,62,22,36,48,48]}],&quot;colors&quot;:[&quot;#7CD4FD&quot;,&quot;#BDB4FE&quot;,&quot;#7592FF&quot;]}"></div>
        </div>
    </div>
</div>

                <div class="w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3">
    <div class="px-6 py-4">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Recent Invoices
        </h3>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-y border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                <tr>
                                            <th class="px-6 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Serial No:
                        </th>
                                            <th class="px-6 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Close Date
                        </th>
                                            <th class="px-6 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-500 dark:text-gray-400">
                            User
                        </th>
                                            <th class="px-6 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Amount
                        </th>
                                            <th class="px-6 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Status
                        </th>
                                    </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <tr class="border-b border-gray-100 transition-colors dark:border-gray-800">
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        #DF429
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        April 28, 2016
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        Jenny Wilson
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        $473.85
    </td>
    <td class="px-6 py-4 text-start whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Complete</span>
    </td>
</tr>
                                    <tr class="border-b border-gray-100 transition-colors dark:border-gray-800">
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        #HTY274
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        October 30, 2017
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        Wade Warren
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        $293.01
    </td>
    <td class="px-6 py-4 text-start whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Complete</span>
    </td>
</tr>
                                    <tr class="border-b border-gray-100 transition-colors dark:border-gray-800">
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        #LKE600
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        May 29, 2017
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        Darlene Robertson
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        $782.01
    </td>
    <td class="px-6 py-4 text-start whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="warning" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]">Pending</span>
    </td>
</tr>
                                    <tr class="border-b border-gray-100 transition-colors dark:border-gray-800">
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        #HRP447
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        May 20, 2015
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        Arlene McCoy
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        $202.87
    </td>
    <td class="px-6 py-4 text-start whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">Cancelled</span>
    </td>
</tr>
                                    <tr class="border-b border-gray-100 transition-colors dark:border-gray-800">
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        #WRH647
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        March 13, 2014
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        Bessie Cooper
    </td>
    <td class="px-6 py-4 text-start text-sm font-normal whitespace-nowrap text-gray-700 dark:text-gray-300">
        $490.51
    </td>
    <td class="px-6 py-4 text-start whitespace-nowrap">
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Complete</span>
    </td>
</tr>
                            </tbody>
        </table>
    </div>
</div>
            </div>

            <div class="space-y-5 sm:space-y-6 xl:col-span-5 2xl:col-span-4">
                <div data-slot="card" data-size="default" x-data="{
        selectedTab: 'daily',
        data: {&quot;daily&quot;:{&quot;digitalProduct&quot;:{&quot;value&quot;:&quot;790&quot;,&quot;isPositive&quot;:true},&quot;physicalProduct&quot;:{&quot;value&quot;:&quot;572&quot;,&quot;isPositive&quot;:false},&quot;mainStat&quot;:{&quot;title&quot;:&quot;Average Daily Sales&quot;,&quot;value&quot;:&quot;$2,950&quot;,&quot;change&quot;:&quot;0.52%&quot;,&quot;isPositive&quot;:false},&quot;chartData&quot;:[2.3,3.1,2.7,3.9,2.1,1.7,1.7],&quot;categories&quot;:[&quot;Sat&quot;,&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;]},&quot;online&quot;:{&quot;digitalProduct&quot;:{&quot;value&quot;:&quot;8,490&quot;,&quot;isPositive&quot;:true},&quot;physicalProduct&quot;:{&quot;value&quot;:&quot;950&quot;,&quot;isPositive&quot;:false},&quot;mainStat&quot;:{&quot;title&quot;:&quot;Total Online Sales&quot;,&quot;value&quot;:&quot;$59,410&quot;,&quot;change&quot;:&quot;0.52%&quot;,&quot;isPositive&quot;:true},&quot;chartData&quot;:[3.2,4,3.5,5.2,4.1,2.8,3.6],&quot;categories&quot;:[&quot;Sat&quot;,&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;]},&quot;new&quot;:{&quot;digitalProduct&quot;:{&quot;value&quot;:&quot;1,240&quot;,&quot;isPositive&quot;:true},&quot;physicalProduct&quot;:{&quot;value&quot;:&quot;680&quot;,&quot;isPositive&quot;:true},&quot;mainStat&quot;:{&quot;title&quot;:&quot;Total New Users&quot;,&quot;value&quot;:&quot;5.9K&quot;,&quot;change&quot;:&quot;1.45%&quot;,&quot;isPositive&quot;:true},&quot;chartData&quot;:[1.8,2.4,3.1,4.5,3.2,2.9,3.4],&quot;categories&quot;:[&quot;Sat&quot;,&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;]}},
        switchTab(tab) {
            this.selectedTab = tab;
            const target = this.data[tab];
            if (target && this.$refs.chart) {
                this.$refs.chart.dispatchEvent(new CustomEvent('chart-update', {
                    detail: {
                        data: target.chartData,
                        categories: target.categories
                    }
                }));
            }
        }
    }" class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div class="flex items-center justify-between">
    <div data-slot="card-title"  class="group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Product Performance</div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg 
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <circle cx="12" cy="12" r="1" />
    <circle cx="12" cy="5" r="1" />
    <circle cx="12" cy="19" r="1" />
  </svg></button>
        <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">View More</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
</div>

    <div class="mt-1 w-full gap-0.5 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900 flex">
            <button
            type="button"
            @click="switchTab('daily')"
            :class="selectedTab === 'daily'
                ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white'
                : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
            class="h-9 flex-1 rounded-md text-sm font-medium transition-colors">
            Daily Sales
        </button>
            <button
            type="button"
            @click="switchTab('online')"
            :class="selectedTab === 'online'
                ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white'
                : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
            class="h-9 flex-1 rounded-md text-sm font-medium transition-colors">
            Online Sales
        </button>
            <button
            type="button"
            @click="switchTab('new')"
            :class="selectedTab === 'new'
                ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white'
                : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
            class="h-9 flex-1 rounded-md text-sm font-medium transition-colors">
            New Users
        </button>
    </div>

    <div class="mt-0.5 space-y-4">
        <div class="flex items-center justify-between rounded-xl border border-gray-100 bg-white px-5 py-4 dark:border-gray-800 dark:bg-white/3">
    <!-- Digital Product -->
    <div class="flex flex-col gap-1">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Digital Product
        </span>
        <div class="flex items-center gap-1.5">
            <span
                :class="data[selectedTab]?.digitalProduct?.isPositive
                    ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
                    : 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500'"
                class="flex size-5 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500">
                <template x-if="data[selectedTab]?.digitalProduct?.isPositive">
                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                </template>
                <template x-if="!data[selectedTab]?.digitalProduct?.isPositive">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                </template>
            </span>
            <span class="text-xl font-bold text-gray-800 dark:text-white/90" x-text="data[selectedTab]?.digitalProduct?.value">
                790
            </span>
        </div>
    </div>

    <!-- Center Divider -->
    <div role="none" data-slot="separator" data-orientation="vertical" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch dark:bg-gray-700"></div>

    <!-- Physical Product -->
    <div class="flex flex-col gap-1">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Physical Product
        </span>
        <div class="flex items-center gap-1.5">
            <span
                :class="data[selectedTab]?.physicalProduct?.isPositive
                    ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-500'
                    : 'bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500'"
                class="flex size-5 items-center justify-center rounded-full bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-500">
                <template x-if="data[selectedTab]?.physicalProduct?.isPositive">
                    <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                </template>
                <template x-if="!data[selectedTab]?.physicalProduct?.isPositive">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                </template>
            </span>
            <span class="text-xl font-bold text-gray-800 dark:text-white/90" x-text="data[selectedTab]?.physicalProduct?.value">
                572
            </span>
        </div>
    </div>
</div>
        <div class="rounded-xl border border-gray-100 p-5 dark:border-gray-800">
    <div class="flex items-start justify-between">
        <div>
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400" x-text="data[selectedTab]?.mainStat?.title">
                Average Daily Sales
            </span>
            <h4 class="mt-1 text-3xl font-bold text-gray-800 dark:text-white/90" x-text="data[selectedTab]?.mainStat?.value">
                $2,950
            </h4>
        </div>

        <span data-slot="badge" data-variant="light"
            :data-color="data[selectedTab]?.mainStat?.isPositive ? 'success' : 'error'"
            data-size="default"
            :class="data[selectedTab]?.mainStat?.isPositive ? 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-6 rounded-lg px-2.5 py-0.5 text-sm [&amp;:has(&gt;svg:first-child)]:ps-2 [&amp;:has(&gt;svg:last-child)]:pe-2 [&amp;&gt;svg]:size-3.5 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-6 rounded-lg px-2.5 py-0.5 text-sm [&amp;:has(&gt;svg:first-child)]:ps-2 [&amp;:has(&gt;svg:last-child)]:pe-2 [&amp;&gt;svg]:size-3.5 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
            class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-6 rounded-lg px-2.5 py-0.5 text-sm [&amp;:has(&gt;svg:first-child)]:ps-2 [&amp;:has(&gt;svg:last-child)]:pe-2 [&amp;&gt;svg]:size-3.5 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">
            <template x-if="data[selectedTab]?.mainStat?.isPositive">
                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
            </template>
            <template x-if="!data[selectedTab]?.mainStat?.isPositive">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
            </template>
            <span x-text="data[selectedTab]?.mainStat?.change">0.52%</span>
        </span>
    </div>

    <div class="mt-4">
        <div class="custom-scrollbar max-w-full overflow-x-auto">
    <div class="min-w-65">
        <div x-ref="chart" data-dashboard-chart="saas-performance-chart" data-config="{&quot;data&quot;:[2.3,3.1,2.7,3.9,2.1,1.7,1.7],&quot;categories&quot;:[&quot;Sat&quot;,&quot;Sun&quot;,&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;],&quot;seriesName&quot;:&quot;Sales&quot;}"></div>
    </div>
</div>
    </div>
</div>
    </div></div>

                <div class="flex flex-col gap-6 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
        Activities
    </h3>
    </div>

    <div class="flex flex-col gap-6">
                    <div class="relative flex items-start gap-5.5">
    <!-- Timeline connector line -->
            <span class="absolute start-5 top-13 -bottom-3 w-px -translate-x-1/2 bg-gray-200 dark:bg-gray-800" aria-hidden="true"></span>
    
    <!-- Avatar -->
    <div class="relative z-10 size-10 shrink-0 overflow-hidden rounded-full">
        <img class="size-full object-cover" src="/assets/images/user/user-01.jpg" alt="Francisco Grbbs" />
    </div>

    <!-- Content -->
    <div class="flex min-w-0 flex-1 flex-col gap-2">
        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-1 text-green-500 dark:text-green-400">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" class="size-4.5 shrink-0 text-gray-700 dark:text-gray-300">
  <path
    d="M9 5.063h5.063l-1.48 3.288c-.132.293-.132.63 0 .923l1.48 3.289h-3.938A1.125 1.125 0 019 11.437v-.562m-5.063 0H9m-5.063-7.5h3.938C8.496 3.375 9 3.879 9 4.5v6.375m-5.063 5.063V2.062"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  />
</svg>
    <span class="text-xs leading-4.5 font-medium">
        New invoice
    </span>
</div>
                        <p class="text-sm leading-5 font-medium text-gray-800 dark:text-white/90">
                <span>Francisco Grbbs </span>
                <span class="font-normal text-gray-500 dark:text-gray-400">
                    created invoice PQ-4491C
                </span>
            </p>
        </div>
        <p class="text-xs leading-4.5 font-normal text-gray-400 dark:text-gray-500">
            Just Now
        </p>
    </div>
</div>
                    <div class="relative flex items-start gap-5.5">
    <!-- Timeline connector line -->
            <span class="absolute start-5 top-13 -bottom-3 w-px -translate-x-1/2 bg-gray-200 dark:bg-gray-800" aria-hidden="true"></span>
    
    <!-- Avatar -->
    <div class="relative z-10 size-10 shrink-0 overflow-hidden rounded-full">
        <img class="size-full object-cover" src="/assets/images/user/user-03.jpg" alt="Courtney Henry" />
    </div>

    <!-- Content -->
    <div class="flex min-w-0 flex-1 flex-col gap-2">
        <div class="flex flex-col gap-2">
                        <p class="text-sm leading-5 font-medium text-gray-800 dark:text-white/90">
                <span>Courtney Henry </span>
                <span class="font-normal text-gray-500 dark:text-gray-400">
                    created invoice HK-234G
                </span>
            </p>
        </div>
        <p class="text-xs leading-4.5 font-normal text-gray-400 dark:text-gray-500">
            15 minutes ago
        </p>
    </div>
</div>
                    <div class="relative flex items-start gap-5.5">
    <!-- Timeline connector line -->
            <span class="absolute start-5 top-13 -bottom-3 w-px -translate-x-1/2 bg-gray-200 dark:bg-gray-800" aria-hidden="true"></span>
    
    <!-- Avatar -->
    <div class="relative z-10 size-10 shrink-0 overflow-hidden rounded-full">
        <img class="size-full object-cover" src="/assets/images/user/user-04.jpg" alt="Bessie Cooper" />
    </div>

    <!-- Content -->
    <div class="flex min-w-0 flex-1 flex-col gap-2">
        <div class="flex flex-col gap-2">
                        <p class="text-sm leading-5 font-medium text-gray-800 dark:text-white/90">
                <span>Bessie Cooper </span>
                <span class="font-normal text-gray-500 dark:text-gray-400">
                    created invoice LH-2891C
                </span>
            </p>
        </div>
        <p class="text-xs leading-4.5 font-normal text-gray-400 dark:text-gray-500">
            5 months ago
        </p>
    </div>
</div>
                    <div class="relative flex items-start gap-5.5">
    <!-- Timeline connector line -->
    
    <!-- Avatar -->
    <div class="relative z-10 size-10 shrink-0 overflow-hidden rounded-full">
        <img class="size-full object-cover" src="/assets/images/user/user-05.jpg" alt="Theresa Web" />
    </div>

    <!-- Content -->
    <div class="flex min-w-0 flex-1 flex-col gap-2">
        <div class="flex flex-col gap-2">
                        <p class="text-sm leading-5 font-medium text-gray-800 dark:text-white/90">
                <span>Theresa Web </span>
                <span class="font-normal text-gray-500 dark:text-gray-400">
                    created invoice CK-125NH
                </span>
            </p>
        </div>
        <p class="text-xs leading-4.5 font-normal text-gray-400 dark:text-gray-500">
            2 week ago
        </p>
    </div>
</div>
            </div>
</div>
            </div>
        </div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
