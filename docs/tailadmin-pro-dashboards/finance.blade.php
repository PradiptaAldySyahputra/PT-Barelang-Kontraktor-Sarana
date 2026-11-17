<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="space-y-5">
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <div
    x-data="{
        currencies: JSON.parse('[{\u0022name\u0022:\u0022USD\u0022,\u0022flag\u0022:\u0022\\\/assets\\\/images\\\/country\\\/country-01.svg\u0022},{\u0022name\u0022:\u0022EUR\u0022,\u0022flag\u0022:\u0022\\\/assets\\\/images\\\/country\\\/country-02.svg\u0022},{\u0022name\u0022:\u0022GBP\u0022,\u0022flag\u0022:\u0022\\\/assets\\\/images\\\/country\\\/country-03.svg\u0022},{\u0022name\u0022:\u0022JPY\u0022,\u0022flag\u0022:\u0022\\\/assets\\\/images\\\/flag\\\/japan.png\u0022}]'),
        periods: JSON.parse('[\u0022June 2025\u0022,\u0022May 2025\u0022,\u0022Apr 2025\u0022,\u0022Q1 2025\u0022,\u0022Last 30 Days\u0022,\u0022Last 7 Days\u0022]'),
        balanceOverviewData: JSON.parse('{\u0022USD\u0022:{\u0022June 2025\u0022:{\u0022amount\u0022:\u0022$19,857.00\u0022,\u0022percentage\u0022:\u00223.2%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[20,24,23,25,30,35,40,30,32,33,29,28,27,29,45,58,70,80,72,68,85,79,77,75],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022},\u0022May 2025\u0022:{\u0022amount\u0022:\u0022$17,420.00\u0022,\u0022percentage\u0022:\u00221.8%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[68,65,62,58,55,60,52,48,50,47,44,46,42,39,41,38,35,33,30,32,28,26,25,20],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022},\u0022Apr 2025\u0022:{\u0022amount\u0022:\u0022$18,950.00\u0022,\u0022percentage\u0022:\u00224.6%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[25,28,32,30,36,42,45,40,48,52,55,50,58,62,65,68,70,66,72,75,78,80,82,85],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022},\u0022Q1 2025\u0022:{\u0022amount\u0022:\u0022$54,120.00\u0022,\u0022percentage\u0022:\u00228.1%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[18,24,28,35,42,48,55,60,68,74,80,88],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022},\u0022Last 30 Days\u0022:{\u0022amount\u0022:\u0022$19,857.00\u0022,\u0022percentage\u0022:\u00220.9%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[55,58,54,52,50,48,46,49,47,45,42,40,38,36,35,37,34,32,30,28,26,25,24,22],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022},\u0022Last 7 Days\u0022:{\u0022amount\u0022:\u0022$19,857.00\u0022,\u0022percentage\u0022:\u00222.3%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[30,35,32,45,42,50,58],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022}},\u0022EUR\u0022:{\u0022June 2025\u0022:{\u0022amount\u0022:\u0022\\u20ac18,240.50\u0022,\u0022percentage\u0022:\u00222.8%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[22,26,25,28,32,38,42,35,36,38,32,30,31,34,48,60,72,78,74,70,82,77,75,73],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022},\u0022May 2025\u0022:{\u0022amount\u0022:\u0022\\u20ac16,110.00\u0022,\u0022percentage\u0022:\u00222.1%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[72,69,64,60,58,62,54,50,52,48,45,47,43,40,42,39,36,34,31,33,29,27,24,22],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022},\u0022Apr 2025\u0022:{\u0022amount\u0022:\u0022\\u20ac17,450.00\u0022,\u0022percentage\u0022:\u00223.9%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[28,30,34,32,38,44,48,42,50,54,58,52,60,64,68,70,72,68,74,78,80,82,84,86],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022},\u0022Q1 2025\u0022:{\u0022amount\u0022:\u0022\\u20ac49,800.00\u0022,\u0022percentage\u0022:\u00227.4%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[20,26,30,38,44,50,58,62,70,76,82,90],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022},\u0022Last 30 Days\u0022:{\u0022amount\u0022:\u0022\\u20ac18,240.50\u0022,\u0022percentage\u0022:\u00221.2%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[58,60,56,54,52,50,48,51,49,47,44,42,40,38,37,39,36,34,32,30,28,27,25,23],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022},\u0022Last 7 Days\u0022:{\u0022amount\u0022:\u0022\\u20ac18,240.50\u0022,\u0022percentage\u0022:\u00221.9%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[32,38,34,48,44,52,60],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 8421\u0022}},\u0022GBP\u0022:{\u0022June 2025\u0022:{\u0022amount\u0022:\u0022\\u00a315,620.00\u0022,\u0022percentage\u0022:\u00223.5%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[18,22,21,24,28,33,38,32,34,35,30,29,28,31,44,55,68,75,70,66,80,76,74,72],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022},\u0022May 2025\u0022:{\u0022amount\u0022:\u0022\\u00a314,180.00\u0022,\u0022percentage\u0022:\u00221.4%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[64,60,56,52,56,50,46,48,45,42,44,40,37,39,36,33,31,28,30,26,24,22,20,18],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022},\u0022Apr 2025\u0022:{\u0022amount\u0022:\u0022\\u00a314,920.00\u0022,\u0022percentage\u0022:\u00224.1%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[22,25,29,27,33,39,42,38,45,49,52,48,55,59,62,65,67,64,69,72,75,77,79,82],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022},\u0022Q1 2025\u0022:{\u0022amount\u0022:\u0022\\u00a342,500.00\u0022,\u0022percentage\u0022:\u00226.8%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[16,22,26,32,38,44,52,56,64,70,76,84],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022},\u0022Last 30 Days\u0022:{\u0022amount\u0022:\u0022\\u00a315,620.00\u0022,\u0022percentage\u0022:\u00220.8%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[52,55,51,49,47,45,43,46,44,42,39,37,35,33,32,34,31,29,27,25,23,22,21,19],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022},\u0022Last 7 Days\u0022:{\u0022amount\u0022:\u0022\\u00a315,620.00\u0022,\u0022percentage\u0022:\u00222.5%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[28,32,30,42,40,48,55],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3914\u0022}},\u0022JPY\u0022:{\u0022June 2025\u0022:{\u0022amount\u0022:\u0022\\u00a52,950,000\u0022,\u0022percentage\u0022:\u00221.7%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[60,58,55,52,54,49,46,47,44,42,43,40,38,39,36,34,32,30,31,28,26,24,22,20],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022},\u0022May 2025\u0022:{\u0022amount\u0022:\u0022\\u00a52,680,000\u0022,\u0022percentage\u0022:\u00223.1%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[22,26,28,30,35,40,44,38,46,50,54,49,56,60,64,67,69,65,71,74,77,79,81,84],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022},\u0022Apr 2025\u0022:{\u0022amount\u0022:\u0022\\u00a52,490,000\u0022,\u0022percentage\u0022:\u00222.2%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[58,55,52,49,51,47,44,45,42,40,41,38,36,37,34,32,30,28,29,26,24,22,20,18],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022},\u0022Q1 2025\u0022:{\u0022amount\u0022:\u0022\\u00a57,820,000\u0022,\u0022percentage\u0022:\u00225.5%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[18,24,28,34,40,46,54,58,66,72,78,86],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022},\u0022Last 30 Days\u0022:{\u0022amount\u0022:\u0022\\u00a52,950,000\u0022,\u0022percentage\u0022:\u00221.5%\u0022,\u0022isPositive\u0022:false,\u0022chartData\u0022:[56,58,54,52,50,48,46,49,47,45,42,40,38,36,35,37,34,32,30,28,26,25,24,21],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022},\u0022Last 7 Days\u0022:{\u0022amount\u0022:\u0022\\u00a52,950,000\u0022,\u0022percentage\u0022:\u00223.4%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[26,31,29,40,38,46,54],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 9062\u0022}}}'),
        defaultData: JSON.parse('{\u0022amount\u0022:\u0022$19,857.00\u0022,\u0022percentage\u0022:\u00223.2%\u0022,\u0022isPositive\u0022:true,\u0022chartData\u0022:[20,24,23,25,30,35,40,30,32,33,29,28,27,29,45,58,70,80,72,68,85,79,77,75],\u0022accountNumber\u0022:\u0022\\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 5332\u0022}'),
        selectedCurrency: JSON.parse('{\u0022name\u0022:\u0022USD\u0022,\u0022flag\u0022:\u0022\\\/assets\\\/images\\\/country\\\/country-01.svg\u0022}'),
        selectedPeriod: 'June 2025',
        get overviewData() {
            return (this.balanceOverviewData[this.selectedCurrency.name] && this.balanceOverviewData[this.selectedCurrency.name][this.selectedPeriod])
                ?? (this.balanceOverviewData[this.selectedCurrency.name] && this.balanceOverviewData[this.selectedCurrency.name]['June 2025'])
                ?? this.defaultData;
        },
        setCurrency(currency) {
            this.selectedCurrency = currency;
            this.refreshChart();
        },
        setPeriod(period) {
            this.selectedPeriod = period;
            this.refreshChart();
        },
        refreshChart() {
            $el.querySelector('[data-dashboard-chart]').dispatchEvent(new CustomEvent('chart-update', { detail: { data: this.overviewData.chartData } }));
        },
    }"
    class="rounded-[18px] border border-gray-200 bg-gray-100 p-1.5 dark:border-gray-800 dark:bg-white/3 xl:col-span-6 2xl:col-span-5"
>
    <div data-slot="card" data-size="default"  class="group/card flex flex-col border border-gray-200 data-[size=sm]:p-4 dark:border-gray-800 gap-0 rounded-xl border-none bg-white p-6 pb-8 shadow-none sm:p-6 sm:pb-8 dark:bg-gray-900"><div data-slot="card-header"  class="flex group-data-[size=sm]/card:gap-1 mb-10 flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"><div>
        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-base font-medium text-gray-800 dark:text-white/90">Total Balance</div>
        <div data-slot="card-description"  class="text-sm text-gray-500 dark:text-gray-400">Overview of your current funds</div>
    </div>

    <div data-slot="card-action"  class="col-start-2 row-span-2 row-start-1 col-auto row-auto flex shrink-0 items-center gap-2 self-auto justify-self-auto"><!-- Currency Dropdown -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" ><img
                        :src="selectedCurrency.flag"
                        :alt="selectedCurrency.name"
                        width="16"
                        height="16"
                        class="size-4 rounded-full object-cover"
                    />
                    <span x-text="selectedCurrency.name"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-0 p-1.5"><template x-for="currency in currencies" :key="currency.name">
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedCurrency.name === currency.name && 'bg-gray-100 font-medium dark:bg-white/5'" @click="setCurrency(currency)" class="group/dropdown-menu-item relative cursor-pointer font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center gap-2.5 rounded-lg px-2.5 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"><img
                            :src="currency.flag"
                            :alt="currency.name"
                            width="16"
                            height="16"
                            class="size-4 rounded-full object-cover"
                        />
                        <span x-text="currency.name"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedCurrency.name === currency.name" class="ms-auto size-3.5 text-brand-500">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
                </template></div>
    </div>
</template></div>

        <!-- Date / Period Dropdown -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" ><span x-text="selectedPeriod"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-38 min-w-0 p-1.5"><template x-for="period in periods" :key="period">
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedPeriod === period && 'bg-gray-100 font-medium dark:bg-white/5'" @click="setPeriod(period)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 rounded-lg px-2.5 py-2 text-start text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"><span x-text="period"></span></div>
                </template></div>
    </div>
</template></div></div></div>
        <div data-slot="card-content"  class="p-0"><div class="flex items-end border-b border-dashed border-gray-200 pb-7 dark:border-gray-800">
    <div>
        <h3 class="mb-2 text-3xl font-medium text-gray-800 dark:text-white/90" x-text="overviewData.amount"></h3>
        <p class="flex items-center gap-1.5 text-sm font-normal text-gray-500 dark:text-gray-400">
            <span
                class="flex items-center gap-1 font-medium"
                :class="overviewData.isPositive ? 'text-green-600 dark:text-green-500' : 'text-red-600 dark:text-red-500'"
            >
                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5" x-show="overviewData.isPositive">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5" x-show="!overviewData.isPositive">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                <span x-text="overviewData.percentage"></span>
            </span>
            than last month
        </p>
    </div>

    <div class="ms-auto w-25 sm:w-37.5">
    <div data-dashboard-chart="finance-balance" data-config="{&quot;seriesName&quot;:&quot;Balance&quot;,&quot;data&quot;:[20,24,23,25,30,35,40,30,32,33,29,28,27,29,45,58,70,80,72,68,85,79,77,75]}"></div>
</div>
</div>
            <div class="pt-7.5" x-data="{ isCopied: false, copy() { navigator.clipboard.writeText(overviewData.accountNumber); this.isCopied = true; setTimeout(() => (this.isCopied = false), 2000); } }">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        <p class="shrink-0 text-sm text-gray-700 dark:text-gray-400">
            Primary Account:
        </p>
        <div class="flex items-center gap-2">
            <p class="shrink-0 text-lg font-medium text-gray-700 dark:text-gray-400" x-text="overviewData.accountNumber"></p>

            <!-- Copy Button -->
            <button data-slot="button" type="button" aria-label="Copy account number" @click="copy()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-lg in-data-[slot=button-group]:rounded-lg size-8 shadow-xs hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="isCopied" class="size-4 text-green-500">
    <path d="M20 6L9 17l-5-5" />
  </svg>
                <svg x-show="!isCopied" class="size-4" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.588 4.584a.5.5 0 01.5-.5h8.327a.5.5 0 01.5.5v8.329a.5.5 0 01-.5.5H7.088a.5.5 0 01-.5-.5V4.584zm.5-2a2 2 0 00-2 2v.51h-.503a2 2 0 00-2 2v8.322a2 2 0 002 2h8.322a2 2 0 002-2v-.503h.508a2 2 0 002-2V4.584a2 2 0 00-2-2H7.088zm6.319 12.329H7.088a2 2 0 01-2-2V6.594h-.503a.5.5 0 00-.5.5v8.322a.5.5 0 00.5.5h8.322a.5.5 0 00.5-.5v-.503z"
      fill="currentColor"
    />
  </svg></button>

            <!-- Details Button -->
            <button data-slot="button" type="button"  class="group/button inline-flex items-center justify-center border bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-1.5 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-2.5 [&amp;:has(&gt;svg:last-child)]:pe-2.5 h-8 shrink-0 px-3 text-sm shadow-xs hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900">See Details</button>
        </div>
    </div>
</div></div></div>
    <div data-slot="card-footer"  class="border-t border-gray-100 dark:border-gray-800 flex items-center gap-3 border-none p-0 px-3.5 pt-5 pb-4"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 h-11 flex-1 gap-2 rounded-lg text-sm font-medium"><svg class="size-5 rtl:-scale-x-100" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M14.9968 5.00356L5 15.0003M14.9977 12.4949L14.9953 5.00214L7.49917 4.99951"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Transfer</span></button>

    <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 h-11 flex-1 gap-2 rounded-lg border-gray-300 bg-white text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg class="size-5 rtl:-scale-x-100" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M5.00095 14.9963L14.9977 4.99954M5 7.50539L5.00238 14.9981L12.4985 15.0007"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Received</span></button>

    <button data-slot="button" type="button" aria-label="Add" class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-11 shrink-0 rounded-lg border-gray-300 bg-white text-gray-700 shadow-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M5 12h14M12 5v14" />
  </svg></button></div>
</div>

            <div class="h-full rounded-[18px] border border-gray-200 bg-gray-100 p-1.5 dark:border-gray-800 dark:bg-white/3 xl:col-span-6 2xl:col-span-7">
    <div class="grid h-full grid-cols-1 gap-1.5 sm:grid-cols-2">
                    <div data-slot="card" data-size="default"  class="group/card gap-5 border border-gray-200 data-[size=sm]:p-4 sm:p-6 dark:border-gray-800 flex flex-col justify-between rounded-xl border-none bg-white p-6 shadow-none dark:border-none dark:bg-gray-900"><div>
        <div class="mb-1.5 flex items-center justify-between">
            <p class="text-base text-gray-500 dark:text-gray-400">Total Balance</p>
                            <span><span class="inline-flex size-9 items-center justify-center rounded-lg bg-brand-500/10">
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4 8H18.5C19.3284 8 20 8.67157 20 9.5V18.5C20 19.3284 19.3284 20 18.5 20H5.5C4.67157 20 4 19.3284 4 18.5V8ZM4 8V5.5C4 4.67157 4.67157 4 5.5 4H16C16.8284 4 17.5 4.67157 17.5 5.5V8M20 12H16.75C15.9216 12 15.25 12.6716 15.25 13.5V14.5C15.25 15.3284 15.9216 16 16.75 16H20"
      stroke="#465FFF"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </span></span>
                    </div>
        <h2 class="text-3xl font-medium text-gray-700 dark:text-white/90">
            $24,830
        </h2>
    </div>

    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400 gap-1.5">
                                    <span class="flex items-center gap-1 font-medium text-green-600">
                                            <svg class="rotate-45" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M7.9974 2.66602L7.9974 13.3336M4 6.66334L7.99987 2.66602L12 6.66334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        3.2%
                </span>
                                        <span>than last month</span>
            </p></div>
                    <div data-slot="card" data-size="default"  class="group/card gap-5 border border-gray-200 data-[size=sm]:p-4 sm:p-6 dark:border-gray-800 flex flex-col justify-between rounded-xl border-none bg-white p-6 shadow-none dark:border-none dark:bg-gray-900"><div>
        <div class="mb-1.5 flex items-center justify-between">
            <p class="text-base text-gray-500 dark:text-gray-400">Monthly Income</p>
                            <span><span class="inline-flex size-9 items-center justify-center rounded-lg bg-green-500/10">
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M20.0005 20H5.5C4.67157 20 4 19.3284 4 18.5V4M4 15.4191L9.19963 10.2195L13.1523 14.1722L18.7431 8.58135M18.7431 8.58135L18.7471 12.1162M18.7431 8.58135L15.2115 8.58067"
      stroke="#12B76A"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </span></span>
                    </div>
        <h2 class="text-3xl font-medium text-gray-700 dark:text-white/90">
            $5,200
        </h2>
    </div>

    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400 gap-1.5">
                                    <span class="flex items-center gap-1 font-medium text-red-600">
                                            <svg class="rotate-45" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M7.9974 13.3338L7.9974 2.66626M4 9.33644L7.99987 13.3338L12 9.33644"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        3.2%
                </span>
                                        <span>than last month</span>
            </p></div>
                    <div data-slot="card" data-size="default"  class="group/card gap-5 border border-gray-200 data-[size=sm]:p-4 sm:p-6 dark:border-gray-800 flex flex-col justify-between rounded-xl border-none bg-white p-6 shadow-none dark:border-none dark:bg-gray-900"><div>
        <div class="mb-1.5 flex items-center justify-between">
            <p class="text-base text-gray-500 dark:text-gray-400">Total Spent</p>
                            <span><span class="inline-flex size-9 items-center justify-center rounded-lg bg-orange-500/10">
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.75 10.5V17.25C2.75 18.0784 3.42157 18.75 4.25 18.75H9.30078M2.75 10.5V9M2.75 10.5H12.082C12.082 10.5 13.7908 9.00694 16.6263 9M2.75 9V6.75C2.75 5.92157 3.42157 5.25 4.25 5.25H19.75C20.5784 5.25 21.25 5.92157 21.25 6.75V9M2.75 9H16.6263M21.25 9V10.5625C21.25 10.5625 19.532 9.00701 16.666 9M21.25 9H16.666M16.6263 9C16.6395 8.99997 16.6528 8.99997 16.666 9M16.6263 9H16.666M18.375 14.4768C18.375 13.7519 17.7873 13.1642 17.0624 13.1642H16.375C15.5466 13.1642 14.875 13.8358 14.875 14.6642V14.9293C14.875 15.5546 15.2628 16.1142 15.8483 16.3338L17.4017 16.9164C17.9872 17.1359 18.375 17.6956 18.375 18.3209V18.5859C18.375 19.4144 17.7034 20.0859 16.875 20.0859H16.1876C15.4627 20.0859 14.875 19.4983 14.875 18.7733M16.625 20.0859V21.25M16.625 12V13.1642"
      stroke="#FB6514"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </span></span>
                    </div>
        <h2 class="text-3xl font-medium text-gray-700 dark:text-white/90">
            $3,831
        </h2>
    </div>

    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400 gap-1.5">
                                    <span class="flex items-center gap-1 font-medium text-green-600">
                                            <svg class="rotate-45" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M7.9974 2.66602L7.9974 13.3336M4 6.66334L7.99987 2.66602L12 6.66334"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                        295
                </span>
                                        <span>than last month</span>
            </p></div>
                    <div data-slot="card" data-size="default"  class="group/card gap-5 border border-gray-200 data-[size=sm]:p-4 sm:p-6 dark:border-gray-800 flex flex-col justify-between rounded-xl border-none bg-white p-6 shadow-none dark:border-none dark:bg-gray-900"><div>
        <div class="mb-1.5 flex items-center justify-between">
            <p class="text-base text-gray-500 dark:text-gray-400">Saving Rate</p>
                            <span><span class="inline-flex size-9 items-center justify-center rounded-lg bg-pink-500/10">
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M11.999 15.4605H11.5616C10.8367 15.4605 10.249 14.8728 10.249 14.1479M11.999 15.4605H12.249C13.0775 15.4605 13.749 14.7889 13.749 13.9605V13.6954C13.749 13.0701 13.3612 12.5105 12.7757 12.2909L11.2223 11.7083C10.6369 11.4888 10.249 10.9291 10.249 10.3038V10.0388C10.249 9.21034 10.9206 8.53876 11.749 8.53876H11.999M11.999 15.4605V16.6245M11.999 8.53876H12.4364C13.1614 8.53876 13.749 9.12643 13.749 9.85136M11.999 8.53876V7.37452M19.9994 7.76672V12.7605C19.9994 14.782 18.9814 16.6676 17.2914 17.7767L12.8227 20.7094C12.323 21.0373 11.6763 21.0373 11.1767 20.7094L6.70797 17.7767C5.01792 16.6676 4 14.782 4 12.7605V7.76672C4 7.035 4.52576 6.40446 5.23056 6.20778C6.65684 5.80977 9.09916 4.94592 11.3415 3.27064C11.7304 2.9801 12.269 2.9801 12.6578 3.27064C14.9002 4.94592 17.3425 5.80977 18.7688 6.20778C19.4736 6.40446 19.9994 7.035 19.9994 7.76672Z"
      stroke="#EE46BC"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </span></span>
                    </div>
        <h2 class="text-3xl font-medium text-gray-700 dark:text-white/90">
            26.1%
        </h2>
    </div>

    <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400 gap-2.5">
                    <span><svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle
      class="stroke-gray-300 dark:stroke-gray-700"
      cx="12"
      cy="12"
      r="10.75"
      stroke="currentColor"
      stroke-width="2.5"
    />
    <mask id="svgyh9BBOg3-path-2-inside-1_finance_goal_progress" fill="white">
      <path
        d="M12 0C14.3225 2.76958e-08 16.5951 0.673978 18.5422 1.94017C20.4892 3.20636 22.0269 5.01036 22.9688 7.13331C23.9108 9.25625 24.2164 11.6069 23.8486 13.9001C23.4808 16.1934 22.4555 18.3306 20.897 20.0525L19.0444 18.3758C20.2784 17.0124 21.0902 15.3202 21.3814 13.5045C21.6725 11.6888 21.4306 9.82759 20.6848 8.1467C19.939 6.46581 18.7215 5.03747 17.1799 4.03493C15.6383 3.0324 13.8389 2.49876 12 2.49876V0Z"
      />
    </mask>
    <path
      d="M12 0C14.3225 2.76958e-08 16.5951 0.673978 18.5422 1.94017C20.4892 3.20636 22.0269 5.01036 22.9688 7.13331C23.9108 9.25625 24.2164 11.6069 23.8486 13.9001C23.4808 16.1934 22.4555 18.3306 20.897 20.0525L19.0444 18.3758C20.2784 17.0124 21.0902 15.3202 21.3814 13.5045C21.6725 11.6888 21.4306 9.82759 20.6848 8.1467C19.939 6.46581 18.7215 5.03747 17.1799 4.03493C15.6383 3.0324 13.8389 2.49876 12 2.49876V0Z"
      stroke="#465FFF"
      stroke-width="4"
      mask="url(#svgyh9BBOg3-path-2-inside-1_finance_goal_progress)"
    />
  </svg>
</span>
                            <span>Goal: 30% - 3.9% to go</span>
            </p></div>
            </div>
</div>
        </div>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <div class="col-span-12 space-y-5 xl:col-span-8">
                <div data-slot="card" data-size="default" x-data="{
        datasets: JSON.parse('{\u00222024\u0022:{\u002212 Months\u0022:{\u0022revenue\u0022:\u0022$5,610.00\u0022,\u0022growth\u0022:\u0022+1.85%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022,\u0022Jul\u0022,\u0022Aug\u0022,\u0022Sep\u0022,\u0022Oct\u0022,\u0022Nov\u0022,\u0022Dec\u0022],\u0022expense\u0022:[6800,4300,3100,9200,2900,4400,5600,3500,4200,5200,3500,4000],\u0022income\u0022:[6400,3900,10200,2900,4400,6300,6200,6300,5700,7300,5900,6700]},\u00226 Months\u0022:{\u0022revenue\u0022:\u0022$3,040.00\u0022,\u0022growth\u0022:\u0022+1.50%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022],\u0022expense\u0022:[6800,4300,3100,9200,2900,4400],\u0022income\u0022:[6400,3900,10200,2900,4400,6300]},\u00223 Months\u0022:{\u0022revenue\u0022:\u0022$1,590.00\u0022,\u0022growth\u0022:\u0022+0.85%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022],\u0022expense\u0022:[6800,4300,3100],\u0022income\u0022:[6400,3900,10200]},\u002230 Days\u0022:{\u0022revenue\u0022:\u0022$650.00\u0022,\u0022growth\u0022:\u0022+0.50%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Week 1\u0022,\u0022Week 2\u0022,\u0022Week 3\u0022,\u0022Week 4\u0022],\u0022expense\u0022:[1500,1100,1900,1300],\u0022income\u0022:[2000,1800,2400,1700]}},\u00222025\u0022:{\u002212 Months\u0022:{\u0022revenue\u0022:\u0022$6,450.00\u0022,\u0022growth\u0022:\u0022-2.14%\u0022,\u0022isPositive\u0022:false,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022,\u0022Jul\u0022,\u0022Aug\u0022,\u0022Sep\u0022,\u0022Oct\u0022,\u0022Nov\u0022,\u0022Dec\u0022],\u0022expense\u0022:[7500,4800,3500,10200,3200,4900,6200,3900,4700,5800,3900,4500],\u0022income\u0022:[7100,4300,11400,3200,4900,7000,6900,7000,6300,8100,6600,7500]},\u00226 Months\u0022:{\u0022revenue\u0022:\u0022$3,480.00\u0022,\u0022growth\u0022:\u0022-1.80%\u0022,\u0022isPositive\u0022:false,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022],\u0022expense\u0022:[7500,4800,3500,10200,3200,4900],\u0022income\u0022:[7100,4300,11400,3200,4900,7000]},\u00223 Months\u0022:{\u0022revenue\u0022:\u0022$1,820.00\u0022,\u0022growth\u0022:\u0022-0.95%\u0022,\u0022isPositive\u0022:false,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022],\u0022expense\u0022:[7500,4800,3500],\u0022income\u0022:[7100,4300,11400]},\u002230 Days\u0022:{\u0022revenue\u0022:\u0022$740.00\u0022,\u0022growth\u0022:\u0022-0.65%\u0022,\u0022isPositive\u0022:false,\u0022categories\u0022:[\u0022Week 1\u0022,\u0022Week 2\u0022,\u0022Week 3\u0022,\u0022Week 4\u0022],\u0022expense\u0022:[1700,1300,2100,1500],\u0022income\u0022:[2200,2000,2700,1900]}},\u00222026\u0022:{\u002212 Months\u0022:{\u0022revenue\u0022:\u0022$7,820.00\u0022,\u0022growth\u0022:\u0022+4.35%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022,\u0022Jul\u0022,\u0022Aug\u0022,\u0022Sep\u0022,\u0022Oct\u0022,\u0022Nov\u0022,\u0022Dec\u0022],\u0022expense\u0022:[8200,5100,3800,11500,3600,5500,6900,4400,5200,6400,4400,5000],\u0022income\u0022:[7900,4800,12800,3600,5500,7900,7800,7900,7100,9100,7400,8400]},\u00226 Months\u0022:{\u0022revenue\u0022:\u0022$4,210.00\u0022,\u0022growth\u0022:\u0022+3.85%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022],\u0022expense\u0022:[8200,5100,3800,11500,3600,5500],\u0022income\u0022:[7900,4800,12800,3600,5500,7900]},\u00223 Months\u0022:{\u0022revenue\u0022:\u0022$2,150.00\u0022,\u0022growth\u0022:\u0022+2.10%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022],\u0022expense\u0022:[8200,5100,3800],\u0022income\u0022:[7900,4800,12800]},\u002230 Days\u0022:{\u0022revenue\u0022:\u0022$860.00\u0022,\u0022growth\u0022:\u0022+1.40%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Week 1\u0022,\u0022Week 2\u0022,\u0022Week 3\u0022,\u0022Week 4\u0022],\u0022expense\u0022:[1900,1400,2400,1700],\u0022income\u0022:[2500,2300,3000,2100]}},\u00222027\u0022:{\u002212 Months\u0022:{\u0022revenue\u0022:\u0022$8,940.00\u0022,\u0022growth\u0022:\u0022+6.12%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022,\u0022Jul\u0022,\u0022Aug\u0022,\u0022Sep\u0022,\u0022Oct\u0022,\u0022Nov\u0022,\u0022Dec\u0022],\u0022expense\u0022:[9100,5800,4200,13100,3900,6100,7800,4900,5800,7100,4900,5600],\u0022income\u0022:[8800,5400,14200,4100,6200,8900,8700,8900,7900,10100,8200,9400]},\u00226 Months\u0022:{\u0022revenue\u0022:\u0022$4,850.00\u0022,\u0022growth\u0022:\u0022+4.90%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022],\u0022expense\u0022:[9100,5800,4200,13100,3900,6100],\u0022income\u0022:[8800,5400,14200,4100,6200,8900]},\u00223 Months\u0022:{\u0022revenue\u0022:\u0022$2,480.00\u0022,\u0022growth\u0022:\u0022+2.75%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022],\u0022expense\u0022:[9100,5800,4200],\u0022income\u0022:[8800,5400,14200]},\u002230 Days\u0022:{\u0022revenue\u0022:\u0022$980.00\u0022,\u0022growth\u0022:\u0022+1.95%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Week 1\u0022,\u0022Week 2\u0022,\u0022Week 3\u0022,\u0022Week 4\u0022],\u0022expense\u0022:[2100,1600,2700,1900],\u0022income\u0022:[2800,2600,3400,2400]}},\u00222028\u0022:{\u002212 Months\u0022:{\u0022revenue\u0022:\u0022$9,758.00\u0022,\u0022growth\u0022:\u0022+7.96%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022,\u0022Jul\u0022,\u0022Aug\u0022,\u0022Sep\u0022,\u0022Oct\u0022,\u0022Nov\u0022,\u0022Dec\u0022],\u0022expense\u0022:[10300,6400,3000,14900,4300,6900,8900,5200,6200,7800,5400,6100],\u0022income\u0022:[9700,6000,16300,4400,7000,9700,9700,9700,8500,11200,9100,10500]},\u00226 Months\u0022:{\u0022revenue\u0022:\u0022$5,380.00\u0022,\u0022growth\u0022:\u0022+5.42%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022,\u0022Apr\u0022,\u0022May\u0022,\u0022Jun\u0022],\u0022expense\u0022:[10300,6400,3000,14900,4300,6900],\u0022income\u0022:[9700,6000,16300,4400,7000,9700]},\u00223 Months\u0022:{\u0022revenue\u0022:\u0022$2,890.00\u0022,\u0022growth\u0022:\u0022+3.15%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Jan\u0022,\u0022Feb\u0022,\u0022Mar\u0022],\u0022expense\u0022:[10300,6400,3000],\u0022income\u0022:[9700,6000,16300]},\u002230 Days\u0022:{\u0022revenue\u0022:\u0022$1,150.00\u0022,\u0022growth\u0022:\u0022+2.80%\u0022,\u0022isPositive\u0022:true,\u0022categories\u0022:[\u0022Week 1\u0022,\u0022Week 2\u0022,\u0022Week 3\u0022,\u0022Week 4\u0022],\u0022expense\u0022:[2400,1800,3100,2200],\u0022income\u0022:[3200,2900,3800,2700]}}}'),
        years: JSON.parse('[\u00222028\u0022,\u00222027\u0022,\u00222026\u0022,\u00222025\u0022,\u00222024\u0022]'),
        timeframes: JSON.parse('[\u002212 Months\u0022,\u00226 Months\u0022,\u00223 Months\u0022,\u002230 Days\u0022]'),
        selectedYear: '2028',
        selectedTimeframe: '12 Months',
        get currentDataset() {
            return this.datasets[this.selectedYear][this.selectedTimeframe];
        },
        select(year, timeframe) {
            this.selectedYear = year;
            this.selectedTimeframe = timeframe;
            $el.querySelector('[data-dashboard-chart]').dispatchEvent(new CustomEvent('chart-update', { detail: { year, timeframe } }));
        },
    }" class="group/card flex flex-col data-[size=sm]:p-4 gap-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <div data-slot="card-title"  class="group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 mb-0 text-title-sm font-semibold text-gray-800 dark:text-white/90">Cashflow Overview</div>
    </div>

    <div class="flex items-center gap-2">
        <!-- Year Dropdown -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" ><span x-text="selectedYear"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32 min-w-32 p-1.5"><template x-for="year in years" :key="year">
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedYear === year && 'bg-gray-100 font-medium dark:bg-white/5'" @click="select(year, selectedTimeframe)" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer text-sm"><span x-text="year"></span></div>
                </template></div>
    </div>
</template></div>

        <!-- Timeframe Dropdown -->
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" ><span x-text="selectedTimeframe"></span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1.5"><template x-for="tf in timeframes" :key="tf">
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedTimeframe === tf && 'bg-gray-100 font-medium dark:bg-white/5'" @click="select(selectedYear, tf)" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer text-sm"><span x-text="tf"></span></div>
                </template></div>
    </div>
</template></div>
    </div>
</div>

    <div class="flex flex-wrap items-end justify-between gap-4">
    <!-- Total Revenue & Badge -->
    <div>
        <p class="mb-0.5 text-xs text-gray-500 dark:text-gray-400">
            Total Revenue
        </p>
        <div class="flex items-center gap-2">
            <h4 class="text-heading-five font-medium text-gray-800 dark:text-white/90" x-text="currentDataset.revenue"></h4>
            <span
                data-slot="badge"
                :class="currentDataset.isPositive ? 'group\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\u0026\u003Esvg]:pointer-events-none [\u0026\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\u0026:has(\u003Esvg:first-child)]:ps-1.5 [\u0026:has(\u003Esvg:last-child)]:pe-1.5 [\u0026\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\u0026\u003Esvg]:pointer-events-none [\u0026\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\u0026:has(\u003Esvg:first-child)]:ps-1.5 [\u0026:has(\u003Esvg:last-child)]:pe-1.5 [\u0026\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]'"
                x-text="currentDataset.growth"
            ></span>
        </div>
    </div>

    <!-- Income & Expense Toggles -->
    <div class="flex items-center gap-5">
        <span class="flex items-center gap-2">
            <span class="block size-2.5 rounded-full bg-brand-500"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Income
            </span>
        </span>

        <span class="flex items-center gap-2">
            <span class="block size-2.5 rounded-full bg-[#7CD4FD]"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Expense
            </span>
        </span>
    </div>
</div>

    <div data-slot="scroll-area"  class="relative max-w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1">
        <div class="min-w-0"><div class="-ms-4 min-w-130 xl:min-w-full [&>div]:max-h-55!">
            <div data-dashboard-chart="finance-cashflow" data-config="{&quot;datasets&quot;:{&quot;2024&quot;:{&quot;12 Months&quot;:{&quot;revenue&quot;:&quot;$5,610.00&quot;,&quot;growth&quot;:&quot;+1.85%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;expense&quot;:[6800,4300,3100,9200,2900,4400,5600,3500,4200,5200,3500,4000],&quot;income&quot;:[6400,3900,10200,2900,4400,6300,6200,6300,5700,7300,5900,6700]},&quot;6 Months&quot;:{&quot;revenue&quot;:&quot;$3,040.00&quot;,&quot;growth&quot;:&quot;+1.50%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;],&quot;expense&quot;:[6800,4300,3100,9200,2900,4400],&quot;income&quot;:[6400,3900,10200,2900,4400,6300]},&quot;3 Months&quot;:{&quot;revenue&quot;:&quot;$1,590.00&quot;,&quot;growth&quot;:&quot;+0.85%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;],&quot;expense&quot;:[6800,4300,3100],&quot;income&quot;:[6400,3900,10200]},&quot;30 Days&quot;:{&quot;revenue&quot;:&quot;$650.00&quot;,&quot;growth&quot;:&quot;+0.50%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Week 1&quot;,&quot;Week 2&quot;,&quot;Week 3&quot;,&quot;Week 4&quot;],&quot;expense&quot;:[1500,1100,1900,1300],&quot;income&quot;:[2000,1800,2400,1700]}},&quot;2025&quot;:{&quot;12 Months&quot;:{&quot;revenue&quot;:&quot;$6,450.00&quot;,&quot;growth&quot;:&quot;-2.14%&quot;,&quot;isPositive&quot;:false,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;expense&quot;:[7500,4800,3500,10200,3200,4900,6200,3900,4700,5800,3900,4500],&quot;income&quot;:[7100,4300,11400,3200,4900,7000,6900,7000,6300,8100,6600,7500]},&quot;6 Months&quot;:{&quot;revenue&quot;:&quot;$3,480.00&quot;,&quot;growth&quot;:&quot;-1.80%&quot;,&quot;isPositive&quot;:false,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;],&quot;expense&quot;:[7500,4800,3500,10200,3200,4900],&quot;income&quot;:[7100,4300,11400,3200,4900,7000]},&quot;3 Months&quot;:{&quot;revenue&quot;:&quot;$1,820.00&quot;,&quot;growth&quot;:&quot;-0.95%&quot;,&quot;isPositive&quot;:false,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;],&quot;expense&quot;:[7500,4800,3500],&quot;income&quot;:[7100,4300,11400]},&quot;30 Days&quot;:{&quot;revenue&quot;:&quot;$740.00&quot;,&quot;growth&quot;:&quot;-0.65%&quot;,&quot;isPositive&quot;:false,&quot;categories&quot;:[&quot;Week 1&quot;,&quot;Week 2&quot;,&quot;Week 3&quot;,&quot;Week 4&quot;],&quot;expense&quot;:[1700,1300,2100,1500],&quot;income&quot;:[2200,2000,2700,1900]}},&quot;2026&quot;:{&quot;12 Months&quot;:{&quot;revenue&quot;:&quot;$7,820.00&quot;,&quot;growth&quot;:&quot;+4.35%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;expense&quot;:[8200,5100,3800,11500,3600,5500,6900,4400,5200,6400,4400,5000],&quot;income&quot;:[7900,4800,12800,3600,5500,7900,7800,7900,7100,9100,7400,8400]},&quot;6 Months&quot;:{&quot;revenue&quot;:&quot;$4,210.00&quot;,&quot;growth&quot;:&quot;+3.85%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;],&quot;expense&quot;:[8200,5100,3800,11500,3600,5500],&quot;income&quot;:[7900,4800,12800,3600,5500,7900]},&quot;3 Months&quot;:{&quot;revenue&quot;:&quot;$2,150.00&quot;,&quot;growth&quot;:&quot;+2.10%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;],&quot;expense&quot;:[8200,5100,3800],&quot;income&quot;:[7900,4800,12800]},&quot;30 Days&quot;:{&quot;revenue&quot;:&quot;$860.00&quot;,&quot;growth&quot;:&quot;+1.40%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Week 1&quot;,&quot;Week 2&quot;,&quot;Week 3&quot;,&quot;Week 4&quot;],&quot;expense&quot;:[1900,1400,2400,1700],&quot;income&quot;:[2500,2300,3000,2100]}},&quot;2027&quot;:{&quot;12 Months&quot;:{&quot;revenue&quot;:&quot;$8,940.00&quot;,&quot;growth&quot;:&quot;+6.12%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;expense&quot;:[9100,5800,4200,13100,3900,6100,7800,4900,5800,7100,4900,5600],&quot;income&quot;:[8800,5400,14200,4100,6200,8900,8700,8900,7900,10100,8200,9400]},&quot;6 Months&quot;:{&quot;revenue&quot;:&quot;$4,850.00&quot;,&quot;growth&quot;:&quot;+4.90%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;],&quot;expense&quot;:[9100,5800,4200,13100,3900,6100],&quot;income&quot;:[8800,5400,14200,4100,6200,8900]},&quot;3 Months&quot;:{&quot;revenue&quot;:&quot;$2,480.00&quot;,&quot;growth&quot;:&quot;+2.75%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;],&quot;expense&quot;:[9100,5800,4200],&quot;income&quot;:[8800,5400,14200]},&quot;30 Days&quot;:{&quot;revenue&quot;:&quot;$980.00&quot;,&quot;growth&quot;:&quot;+1.95%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Week 1&quot;,&quot;Week 2&quot;,&quot;Week 3&quot;,&quot;Week 4&quot;],&quot;expense&quot;:[2100,1600,2700,1900],&quot;income&quot;:[2800,2600,3400,2400]}},&quot;2028&quot;:{&quot;12 Months&quot;:{&quot;revenue&quot;:&quot;$9,758.00&quot;,&quot;growth&quot;:&quot;+7.96%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;expense&quot;:[10300,6400,3000,14900,4300,6900,8900,5200,6200,7800,5400,6100],&quot;income&quot;:[9700,6000,16300,4400,7000,9700,9700,9700,8500,11200,9100,10500]},&quot;6 Months&quot;:{&quot;revenue&quot;:&quot;$5,380.00&quot;,&quot;growth&quot;:&quot;+5.42%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;],&quot;expense&quot;:[10300,6400,3000,14900,4300,6900],&quot;income&quot;:[9700,6000,16300,4400,7000,9700]},&quot;3 Months&quot;:{&quot;revenue&quot;:&quot;$2,890.00&quot;,&quot;growth&quot;:&quot;+3.15%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;],&quot;expense&quot;:[10300,6400,3000],&quot;income&quot;:[9700,6000,16300]},&quot;30 Days&quot;:{&quot;revenue&quot;:&quot;$1,150.00&quot;,&quot;growth&quot;:&quot;+2.80%&quot;,&quot;isPositive&quot;:true,&quot;categories&quot;:[&quot;Week 1&quot;,&quot;Week 2&quot;,&quot;Week 3&quot;,&quot;Week 4&quot;],&quot;expense&quot;:[2400,1800,3100,2200],&quot;income&quot;:[3200,2900,3800,2700]}}},&quot;year&quot;:&quot;2028&quot;,&quot;timeframe&quot;:&quot;12 Months&quot;,&quot;seriesNames&quot;:{&quot;expense&quot;:&quot;Expense&quot;,&quot;income&quot;:&quot;Income&quot;},&quot;colors&quot;:{&quot;expense&quot;:&quot;#7CD4FD&quot;,&quot;income&quot;:&quot;#7592FF&quot;}}"></div>
        </div></div>
    </div>
</div></div>

                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <div data-slot="card" data-size="default" x-data="{
        datasets: JSON.parse('{\u0022Yearly\u0022:{\u0022total\u0022:\u0022$10,758\u0022,\u0022series\u0022:[{\u0022name\u0022:\u0022Activity\u0022,\u0022data\u0022:[45]},{\u0022name\u0022:\u0022Online Purchases\u0022,\u0022data\u0022:[25]},{\u0022name\u0022:\u0022Groceries\u0022,\u0022data\u0022:[15]},{\u0022name\u0022:\u0022Digital Goods\u0022,\u0022data\u0022:[20]},{\u0022name\u0022:\u0022Stationery\u0022,\u0022data\u0022:[10]},{\u0022name\u0022:\u0022Others\u0022,\u0022data\u0022:[30]}]},\u0022Monthly\u0022:{\u0022total\u0022:\u0022$1,248\u0022,\u0022series\u0022:[{\u0022name\u0022:\u0022Activity\u0022,\u0022data\u0022:[38]},{\u0022name\u0022:\u0022Online Purchases\u0022,\u0022data\u0022:[22]},{\u0022name\u0022:\u0022Groceries\u0022,\u0022data\u0022:[18]},{\u0022name\u0022:\u0022Digital Goods\u0022,\u0022data\u0022:[14]},{\u0022name\u0022:\u0022Stationery\u0022,\u0022data\u0022:[8]},{\u0022name\u0022:\u0022Others\u0022,\u0022data\u0022:[20]}]}}'),
        selectedTimeframe: 'Yearly',
        get currentDataset() {
            return this.datasets[this.selectedTimeframe];
        },
        selectTimeframe(tf) {
            this.selectedTimeframe = tf;
            $el.querySelector('[data-dashboard-chart]').dispatchEvent(new CustomEvent('chart-update', { detail: { timeframe: tf } }));
        },
    }" class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div class="flex items-center justify-between gap-4">
    <div>
        <div data-slot="card-title"  class="group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 mb-0 text-title-sm font-semibold text-gray-800 dark:text-white/90">Spending</div>
    </div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" ><span x-text="selectedTimeframe === 'Yearly' ? 'Yearly' : 'Monthly'"></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-32 min-w-32 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedTimeframe === 'Yearly' && 'bg-gray-100 font-medium dark:bg-white/5'" @click="selectTimeframe('Yearly')" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer text-sm">Yearly</div>
                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedTimeframe === 'Monthly' && 'bg-gray-100 font-medium dark:bg-white/5'" @click="selectTimeframe('Monthly')" class="group/dropdown-menu-item relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer text-sm">Monthly</div></div>
    </div>
</template></div>
</div>

    <div class="mt-6 flex flex-col gap-5">
        <div>
            <p class="mb-0.5 text-xs text-gray-500 dark:text-gray-400">
                Total
            </p>
            <h4 class="text-3xl leading-10 font-medium text-gray-800 dark:text-white/90" x-text="currentDataset.total"></h4>
        </div>

        <div class="-ms-1 w-full">
    <div data-dashboard-chart="finance-spending" data-config="{&quot;datasets&quot;:{&quot;Yearly&quot;:{&quot;total&quot;:&quot;$10,758&quot;,&quot;series&quot;:[{&quot;name&quot;:&quot;Activity&quot;,&quot;data&quot;:[45]},{&quot;name&quot;:&quot;Online Purchases&quot;,&quot;data&quot;:[25]},{&quot;name&quot;:&quot;Groceries&quot;,&quot;data&quot;:[15]},{&quot;name&quot;:&quot;Digital Goods&quot;,&quot;data&quot;:[20]},{&quot;name&quot;:&quot;Stationery&quot;,&quot;data&quot;:[10]},{&quot;name&quot;:&quot;Others&quot;,&quot;data&quot;:[30]}]},&quot;Monthly&quot;:{&quot;total&quot;:&quot;$1,248&quot;,&quot;series&quot;:[{&quot;name&quot;:&quot;Activity&quot;,&quot;data&quot;:[38]},{&quot;name&quot;:&quot;Online Purchases&quot;,&quot;data&quot;:[22]},{&quot;name&quot;:&quot;Groceries&quot;,&quot;data&quot;:[18]},{&quot;name&quot;:&quot;Digital Goods&quot;,&quot;data&quot;:[14]},{&quot;name&quot;:&quot;Stationery&quot;,&quot;data&quot;:[8]},{&quot;name&quot;:&quot;Others&quot;,&quot;data&quot;:[20]}]}},&quot;timeframe&quot;:&quot;Yearly&quot;,&quot;colors&quot;:[&quot;#7592FF&quot;,&quot;#7CD4FD&quot;,&quot;#BDB4FE&quot;,&quot;#FE9EFE&quot;,&quot;#6FEAA6&quot;,&quot;#D0D5DD&quot;]}"></div>
</div>

        <div class="grid grid-cols-2 gap-3">
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #7592FF"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Activity
            </span>
        </div>
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #7CD4FD"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Online Purchases
            </span>
        </div>
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #BDB4FE"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Groceries
            </span>
        </div>
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #FE9EFE"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Digital Goods
            </span>
        </div>
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #6FEAA6"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Stationery
            </span>
        </div>
            <div class="flex items-center gap-2">
            <span class="size-2.5 shrink-0 rounded-full" style="background-color: #D0D5DD"></span>
            <span class="text-sm font-normal text-gray-700 dark:text-gray-300">
                Others
            </span>
        </div>
    </div>
    </div></div>
                    <div data-slot="card" data-size="default" x-data="{
        recipients: JSON.parse('[{\u0022id\u0022:17,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022name\u0022:\u0022Alex Morgan\u0022},{\u0022id\u0022:18,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022name\u0022:\u0022Sophia Davis\u0022},{\u0022id\u0022:19,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022name\u0022:\u0022Emma Watson\u0022},{\u0022id\u0022:20,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022name\u0022:\u0022James Wilson\u0022},{\u0022id\u0022:21,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-21.jpg\u0022,\u0022name\u0022:\u0022Michael Brown\u0022},{\u0022id\u0022:22,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-22.jpg\u0022,\u0022name\u0022:\u0022Olivia Taylor\u0022},{\u0022id\u0022:23,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-23.jpg\u0022,\u0022name\u0022:\u0022Daniel Martinez\u0022},{\u0022id\u0022:24,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-24.jpg\u0022,\u0022name\u0022:\u0022Emily Clark\u0022},{\u0022id\u0022:25,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-25.jpg\u0022,\u0022name\u0022:\u0022David Anderson\u0022},{\u0022id\u0022:26,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-26.jpg\u0022,\u0022name\u0022:\u0022Jessica White\u0022}]'),
        paymentMethods: JSON.parse('[{\u0022id\u0022:\u0022visa-3657\u0022,\u0022label\u0022:\u0022Visa \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3657\u0022},{\u0022id\u0022:\u0022master-4912\u0022,\u0022label\u0022:\u0022Master \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 4912\u0022}]'),
        currencies: JSON.parse('[{\u0022code\u0022:\u0022USD\u0022,\u0022label\u0022:\u0022$ USD\u0022},{\u0022code\u0022:\u0022EUR\u0022,\u0022label\u0022:\u0022\\u20ac EUR\u0022},{\u0022code\u0022:\u0022GBP\u0022,\u0022label\u0022:\u0022\\u00a3 GBP\u0022}]'),
        selectedRecipientId: 17,
        selectedPaymentMethod: JSON.parse('{\u0022id\u0022:\u0022visa-3657\u0022,\u0022label\u0022:\u0022Visa \\u2022\\u2022\\u2022\\u2022 \\u2022\\u2022\\u2022\\u2022 3657\u0022}'),
        selectedCurrency: JSON.parse('{\u0022code\u0022:\u0022USD\u0022,\u0022label\u0022:\u0022$ USD\u0022}'),
        amount: '',
    }" class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col gap-2 group-data-[size=sm]/card:gap-1 p-0"><div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Quick send</div></div>
    <div data-slot="card-content"  class="flex flex-col gap-3.5 p-0"><div
    class="flex items-center gap-1.5 sm:gap-2"
    x-data="{
        canScrollPrev: false,
        canScrollNext: true,
        checkScroll() {
            const el = this.$refs.scroll;
            if (!el) return;
            const { scrollLeft, scrollWidth, clientWidth } = el;
            const isRtl = document.documentElement.dir === 'rtl';
            if (isRtl) {
                const maxScroll = scrollWidth - clientWidth;
                const currentScroll = Math.abs(scrollLeft);
                this.canScrollPrev = currentScroll > 5;
                this.canScrollNext = currentScroll < maxScroll - 5;
            } else {
                this.canScrollPrev = scrollLeft > 5;
                this.canScrollNext = scrollLeft + clientWidth < scrollWidth - 5;
            }
        },
        scrollPrev() {
            const isRtl = document.documentElement.dir === 'rtl';
            this.$refs.scroll.scrollBy({ left: isRtl ? 120 : -120, behavior: 'smooth' });
        },
        scrollNext() {
            const isRtl = document.documentElement.dir === 'rtl';
            this.$refs.scroll.scrollBy({ left: isRtl ? -120 : 120, behavior: 'smooth' });
        },
    }"
    x-init="$nextTick(() => checkScroll()); setTimeout(() => checkScroll(), 300)"
    @load.window="checkScroll()"
    @resize.window="checkScroll()"
>
    <button
        type="button"
        :disabled="!canScrollPrev"
        aria-label="Previous recipients"
        class="flex size-7 shrink-0 items-center justify-center rounded-full text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800 disabled:pointer-events-none disabled:opacity-30 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click="scrollPrev()"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
    </button>

    <div
        x-ref="scroll"
        @load.capture="checkScroll()"
        class="no-scrollbar flex flex-1 items-center gap-2 overflow-x-auto scroll-smooth py-1 sm:gap-2.5"
        @scroll="checkScroll()"
    >
        <template x-for="recipient in recipients" :key="recipient.id">
            <button
                type="button"
                :aria-label="recipient.name || `User ${recipient.id}`"
                class="relative flex shrink-0 items-center justify-center rounded-full p-0.75 transition-all"
                :class="selectedRecipientId === recipient.id
                    ? 'border border-brand-500'
                    : 'border border-transparent hover:border-gray-300 dark:hover:border-gray-700'"
                @click="selectedRecipientId = recipient.id"
            >
                <img
                    :src="recipient.avatar"
                    :alt="recipient.name || `User ${recipient.id}`"
                    width="40"
                    height="40"
                    class="size-10 rounded-full object-cover"
                />
            </button>
        </template>
    </div>

    <button
        type="button"
        :disabled="!canScrollNext"
        aria-label="Next recipients"
        class="flex size-7 shrink-0 items-center justify-center rounded-full text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800 disabled:pointer-events-none disabled:opacity-30 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        @click="scrollNext()"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
    </button>
</div>
        <form class="flex flex-col gap-3.5" @submit.prevent>
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-700 dark:text-gray-300">Send From</label>
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full justify-between rounded-[10px] border-gray-300 bg-white px-4 text-sm font-normal text-gray-800 shadow-theme-xs hover:bg-gray-50/50 hover:text-gray-800 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800" type="button" ><span x-text="selectedPaymentMethod.label"></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-72 min-w-0 p-1.5 sm:w-80"><template x-for="method in paymentMethods" :key="method.id">
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedPaymentMethod.id === method.id && 'bg-gray-100 font-medium dark:bg-white/5'" @click="selectedPaymentMethod = method" class="group/dropdown-menu-item relative cursor-pointer gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"><span x-text="method.label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedPaymentMethod.id === method.id" class="size-3.5 text-brand-500">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
            </template></div>
    </div>
</template></div></div>

    <div class="grid grid-cols-2 gap-3">
        <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-700 dark:text-gray-300">Currency</label>
    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full justify-between rounded-[10px] border-gray-300 bg-white px-4 text-sm font-normal text-gray-800 shadow-theme-xs hover:bg-gray-50/50 hover:text-gray-800 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-gray-800" type="button" ><span x-text="selectedCurrency.label"></span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-gray-500 dark:text-gray-400">
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
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-0 p-1.5"><template x-for="curr in currencies" :key="curr.code">
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="selectedCurrency.code === curr.code && 'bg-gray-100 font-medium dark:bg-white/5'" @click="selectedCurrency = curr" class="group/dropdown-menu-item relative cursor-pointer gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex items-center justify-between rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5"><span x-text="curr.label"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" x-show="selectedCurrency.code === curr.code" class="size-3.5 text-brand-500">
    <path d="M20 6L9 17l-5-5" />
  </svg></div>
            </template></div>
    </div>
</template></div></div>
        <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 select-none group-data-[disabled=true]/field:opacity-50 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
    <input data-slot="input" x-model="amount" type="text" inputmode="decimal" placeholder="0.00" class="w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11" /></div>
    </div>

    <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 mt-1 h-10 w-full rounded-[10px] bg-brand-500 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 sm:h-11">Send Money</button>
</form></div></div>
                </div>
            </div>

            <div data-slot="card" data-size="default"  class="group/card flex flex-col border data-[size=sm]:p-4 sm:p-6 gap-0 rounded-2xl border-gray-200 bg-white p-6 shadow-none dark:border-gray-800 dark:bg-white/3 col-span-12 xl:col-span-4"><div data-slot="card-header"  class="flex group-data-[size=sm]/card:gap-1 mb-6 flex-row items-center justify-between gap-2"><div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">My Cards</div>
    <div data-slot="card-action"  class="col-start-2 row-span-2 row-start-1 col-auto row-auto self-auto justify-self-auto"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-9 gap-1.5 rounded-lg border-gray-300 px-3 text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
            <span>Add Card</span></button></div></div>
    <div data-slot="card-content"  class="flex h-full flex-col justify-between p-0"><div class="w-full">
    <swiper-container
        class="w-full"
        slides-per-view="1"
        space-between="0"
        effect="fade"
        navigation-prev-el="#card-slider-prev"
        navigation-next-el="#card-slider-next"
    >
                    <swiper-slide>
                <div class="relative flex flex-col gap-7 overflow-hidden rounded-[14px] bg-gray-900 p-6 select-none dark:bg-gray-950">
            <img
            src="/assets/images/payment-gateway/card-vector.png"
            alt="Card Vector"
            width="122"
            height="95"
            class="pointer-events-none absolute end-0 top-0 rtl:-scale-x-100"
        />
    
    <div class="relative z-1 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <svg class="text-white" width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.27887 16.1701C10.2976 12.1513 10.2976 5.63571 6.27887 1.61701L7.89586 0C12.8075 4.91175 12.8075 12.8753 7.89586 17.7871L6.27887 16.1701ZM3.04479 12.9359C5.27749 10.7033 5.27749 7.08352 3.04479 4.85088L4.66177 3.23388C7.78747 6.35954 7.78747 11.4273 4.66177 14.5528L3.04479 12.9359Z"
      fill="currentColor"
    />
    <path
      d="M0 7.49219C0.681044 8.04224 0.788117 9.70961 0 10.3699L1.57669 11.5741C3.05722 10.0936 3.05722 7.69324 1.57669 6.21274L0 7.49219Z"
      fill="currentColor"
    />
  </svg>
            <span class="flex h-6 shrink-0 items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize bg-green-500/10 text-green-500">
                active
            </span>
        </div>
                    <div>
                <img
                    src="/assets/images/payment-gateway/mastercard.png"
                    alt="Brand Logo"
                    width="48"
                    height="30"
                    class="h-auto w-auto object-contain"
                />
            </div>
            </div>

    <div class="relative z-1">
        <h4 class="text-base font-normal text-white">Musharof Chy</h4>
    </div>

    <div class="relative z-1 flex justify-between gap-5 sm:gap-10">
        <div class="flex-1">
            <p class="text-xs text-white/80">Card Number</p>
            <p class="text-base font-normal text-white">•••• •••• •••• 4983</p>
        </div>
        <div>
            <p class="text-xs text-white/80">EXP</p>
            <p class="text-base font-normal text-white">09/29</p>
        </div>
        <div>
            <p class="text-xs text-white/80">CVC</p>
            <p class="text-base font-normal text-white">659</p>
        </div>
    </div>
</div>
            </swiper-slide>
                    <swiper-slide>
                <div class="relative flex flex-col gap-7 overflow-hidden rounded-[14px] bg-gray-900 p-6 select-none dark:bg-gray-950">
            <img
            src="/assets/images/payment-gateway/card-vector.png"
            alt="Card Vector"
            width="122"
            height="95"
            class="pointer-events-none absolute end-0 top-0 rtl:-scale-x-100"
        />
    
    <div class="relative z-1 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <svg class="text-white" width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.27887 16.1701C10.2976 12.1513 10.2976 5.63571 6.27887 1.61701L7.89586 0C12.8075 4.91175 12.8075 12.8753 7.89586 17.7871L6.27887 16.1701ZM3.04479 12.9359C5.27749 10.7033 5.27749 7.08352 3.04479 4.85088L4.66177 3.23388C7.78747 6.35954 7.78747 11.4273 4.66177 14.5528L3.04479 12.9359Z"
      fill="currentColor"
    />
    <path
      d="M0 7.49219C0.681044 8.04224 0.788117 9.70961 0 10.3699L1.57669 11.5741C3.05722 10.0936 3.05722 7.69324 1.57669 6.21274L0 7.49219Z"
      fill="currentColor"
    />
  </svg>
            <span class="flex h-6 shrink-0 items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize bg-green-500/10 text-green-500">
                active
            </span>
        </div>
                    <div>
                <img
                    src="/assets/images/payment-gateway/mastercard.png"
                    alt="Brand Logo"
                    width="48"
                    height="30"
                    class="h-auto w-auto object-contain"
                />
            </div>
            </div>

    <div class="relative z-1">
        <h4 class="text-base font-normal text-white">John Adward</h4>
    </div>

    <div class="relative z-1 flex justify-between gap-5 sm:gap-10">
        <div class="flex-1">
            <p class="text-xs text-white/80">Card Number</p>
            <p class="text-base font-normal text-white">•••• •••• •••• 1234</p>
        </div>
        <div>
            <p class="text-xs text-white/80">EXP</p>
            <p class="text-base font-normal text-white">12/28</p>
        </div>
        <div>
            <p class="text-xs text-white/80">CVC</p>
            <p class="text-base font-normal text-white">123</p>
        </div>
    </div>
</div>
            </swiper-slide>
                    <swiper-slide>
                <div class="relative flex flex-col gap-7 overflow-hidden rounded-[14px] bg-gray-900 p-6 select-none dark:bg-gray-950">
            <img
            src="/assets/images/payment-gateway/card-vector.png"
            alt="Card Vector"
            width="122"
            height="95"
            class="pointer-events-none absolute end-0 top-0 rtl:-scale-x-100"
        />
    
    <div class="relative z-1 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <svg class="text-white" width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.27887 16.1701C10.2976 12.1513 10.2976 5.63571 6.27887 1.61701L7.89586 0C12.8075 4.91175 12.8075 12.8753 7.89586 17.7871L6.27887 16.1701ZM3.04479 12.9359C5.27749 10.7033 5.27749 7.08352 3.04479 4.85088L4.66177 3.23388C7.78747 6.35954 7.78747 11.4273 4.66177 14.5528L3.04479 12.9359Z"
      fill="currentColor"
    />
    <path
      d="M0 7.49219C0.681044 8.04224 0.788117 9.70961 0 10.3699L1.57669 11.5741C3.05722 10.0936 3.05722 7.69324 1.57669 6.21274L0 7.49219Z"
      fill="currentColor"
    />
  </svg>
            <span class="flex h-6 shrink-0 items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize bg-white/10 text-gray-400 dark:text-white/90">
                inactive
            </span>
        </div>
                    <div>
                <img
                    src="/assets/images/payment-gateway/mastercard.png"
                    alt="Brand Logo"
                    width="48"
                    height="30"
                    class="h-auto w-auto object-contain"
                />
            </div>
            </div>

    <div class="relative z-1">
        <h4 class="text-base font-normal text-white">John Wick</h4>
    </div>

    <div class="relative z-1 flex justify-between gap-5 sm:gap-10">
        <div class="flex-1">
            <p class="text-xs text-white/80">Card Number</p>
            <p class="text-base font-normal text-white">•••• •••• •••• 5678</p>
        </div>
        <div>
            <p class="text-xs text-white/80">EXP</p>
            <p class="text-base font-normal text-white">10/27</p>
        </div>
        <div>
            <p class="text-xs text-white/80">CVC</p>
            <p class="text-base font-normal text-white">987</p>
        </div>
    </div>
</div>
            </swiper-slide>
            </swiper-container>
</div>
        <div class="border-b border-dashed border-gray-200 pt-4 pb-6 dark:border-gray-800">
            <div class="flex items-center justify-between">
    <h4 class="text-base font-medium text-gray-800 dark:text-white/90">
        Virtual Card
    </h4>
    <div class="flex items-center gap-1.5">
        <button data-slot="button" type="button" id="card-slider-prev" aria-label="Previous card" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 in-data-[slot=button-group]:rounded-lg size-8 rounded-lg border-gray-200 text-gray-700 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></button>
        <button data-slot="button" type="button" id="card-slider-next" aria-label="Next card" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 in-data-[slot=button-group]:rounded-lg size-8 rounded-lg border-gray-200 text-gray-700 hover:bg-gray-100 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-900"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg></button>
    </div>
</div>
        </div>

        <div class="pt-6">
    <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">
        Recent Transactions
    </p>
    <ul class="space-y-1">
                    <li>
    <a
        href="#"
        class="group/transaction -mx-2 flex cursor-pointer items-center justify-between gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-gray-100/70 dark:hover:bg-gray-800"
    >
        <div class="flex min-w-0 items-center gap-3">
            <div class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-200 shadow-xs duration-200 dark:border-gray-800 group-hover/transaction:dark:border-gray-700">
                                    <img
                        src="/assets/images/payment-gateway/payment-1.svg"
                        width="20"
                        height="20"
                        class="block size-5 dark:hidden"
                        alt="Payment Received"
                    />
                    <img
                        src="/assets/images/payment-gateway/payment-1-dark.svg"
                        width="20"
                        height="20"
                        class="hidden size-5 dark:block"
                        alt="Payment Received"
                    />
                            </div>
            <div class="min-w-0">
                <h5 class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                    Payment Received
                </h5>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    Cashback from Stellar Rewards
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center justify-end gap-3 text-end">
            <div>
                <p class="text-sm font-medium text-green-600 dark:text-green-500">
                    +$139.50
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Mar 20
                </p>
            </div>
            <div class="text-gray-400 group-hover/transaction:text-gray-600 dark:group-hover/transaction:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </div>
        </div>
    </a>
</li>
                    <li>
    <a
        href="#"
        class="group/transaction -mx-2 flex cursor-pointer items-center justify-between gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-gray-100/70 dark:hover:bg-gray-800"
    >
        <div class="flex min-w-0 items-center gap-3">
            <div class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-200 shadow-xs duration-200 dark:border-gray-800 group-hover/transaction:dark:border-gray-700">
                                    <img src="/assets/images/payment-gateway/payment-2.svg" width="20" height="20" class="size-5" alt="Netflix Subscription" />
                            </div>
            <div class="min-w-0">
                <h5 class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                    Netflix Subscription
                </h5>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    September subscription charge
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center justify-end gap-3 text-end">
            <div>
                <p class="text-sm font-medium text-red-600 dark:text-red-500">
                    -$36.24
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Sep 18
                </p>
            </div>
            <div class="text-gray-400 group-hover/transaction:text-gray-600 dark:group-hover/transaction:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </div>
        </div>
    </a>
</li>
                    <li>
    <a
        href="#"
        class="group/transaction -mx-2 flex cursor-pointer items-center justify-between gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-gray-100/70 dark:hover:bg-gray-800"
    >
        <div class="flex min-w-0 items-center gap-3">
            <div class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-200 shadow-xs duration-200 dark:border-gray-800 group-hover/transaction:dark:border-gray-700">
                                    <img src="/assets/images/payment-gateway/payment-3.svg" width="20" height="20" class="size-5" alt="Money received" />
                            </div>
            <div class="min-w-0">
                <h5 class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                    Money received
                </h5>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    Payment received via PayPal
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center justify-end gap-3 text-end">
            <div>
                <p class="text-sm font-medium text-green-600 dark:text-green-500">
                    +$590
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Feb 12
                </p>
            </div>
            <div class="text-gray-400 group-hover/transaction:text-gray-600 dark:group-hover/transaction:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </div>
        </div>
    </a>
</li>
                    <li>
    <a
        href="#"
        class="group/transaction -mx-2 flex cursor-pointer items-center justify-between gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-gray-100/70 dark:hover:bg-gray-800"
    >
        <div class="flex min-w-0 items-center gap-3">
            <div class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-200 shadow-xs duration-200 dark:border-gray-800 group-hover/transaction:dark:border-gray-700">
                                    <img src="/assets/images/payment-gateway/payment-4.svg" width="20" height="20" class="size-5" alt="Google Ads" />
                            </div>
            <div class="min-w-0">
                <h5 class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                    Google Ads
                </h5>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    Payment received form google ads
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center justify-end gap-3 text-end">
            <div>
                <p class="text-sm font-medium text-green-600 dark:text-green-500">
                    +$236.24
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Jan 28
                </p>
            </div>
            <div class="text-gray-400 group-hover/transaction:text-gray-600 dark:group-hover/transaction:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </div>
        </div>
    </a>
</li>
                    <li>
    <a
        href="#"
        class="group/transaction -mx-2 flex cursor-pointer items-center justify-between gap-3 rounded-lg px-2 py-2 transition-colors hover:bg-gray-100/70 dark:hover:bg-gray-800"
    >
        <div class="flex min-w-0 items-center gap-3">
            <div class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-gray-200 shadow-xs duration-200 dark:border-gray-800 group-hover/transaction:dark:border-gray-700">
                                    <img src="/assets/images/payment-gateway/payment-3.svg" width="20" height="20" class="size-5" alt="Money received" />
                            </div>
            <div class="min-w-0">
                <h5 class="truncate text-sm font-medium text-gray-800 dark:text-white/90">
                    Money received
                </h5>
                <p class="truncate text-xs text-gray-500 dark:text-gray-400">
                    Payment received via PayPal
                </p>
            </div>
        </div>
        <div class="flex shrink-0 items-center justify-end gap-3 text-end">
            <div>
                <p class="text-sm font-medium text-green-600 dark:text-green-500">
                    +$1,093
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Jan 10
                </p>
            </div>
            <div class="text-gray-400 group-hover/transaction:text-gray-600 dark:group-hover/transaction:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </div>
        </div>
    </a>
</li>
            </ul>

    <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-11 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 mt-3 w-full">See All Transactions</button>
</div></div></div>
        </div>

        <div data-slot="card" data-size="default" x-data="{
        transactions: JSON.parse('[{\u0022id\u0022:\u0022NIV_034834\u0022,\u0022orderId\u0022:\u0022NIV_034834\u0022,\u0022activity\u0022:\u0022Hotel Booking\u0022,\u0022price\u0022:\u0022$9,234.87\u0022,\u0022date\u0022:\u002215 Mar, 2028 08:22 AM\u0022,\u0022status\u0022:\u0022Completed\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022niv_034834|hotel booking|$9,234.87|15 mar, 2028 08:22 am|completed\u0022},{\u0022id\u0022:\u0022NIV_034345\u0022,\u0022orderId\u0022:\u0022NIV_034345\u0022,\u0022activity\u0022:\u0022Online Shopping\u0022,\u0022price\u0022:\u0022$4,567.23\u0022,\u0022date\u0022:\u002228 Feb, 2028 09:15 AM\u0022,\u0022status\u0022:\u0022Completed\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022niv_034345|online shopping|$4,567.23|28 feb, 2028 09:15 am|completed\u0022},{\u0022id\u0022:\u0022NIV_093854\u0022,\u0022orderId\u0022:\u0022NIV_093854\u0022,\u0022activity\u0022:\u0022Game Purchase\u0022,\u0022price\u0022:\u0022$22,101.76\u0022,\u0022date\u0022:\u002214 Feb, 2028 02:55 PM\u0022,\u0022status\u0022:\u0022In Progress\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500\\\/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]\u0022,\u0022search\u0022:\u0022niv_093854|game purchase|$22,101.76|14 feb, 2028 02:55 pm|in progress\u0022},{\u0022id\u0022:\u0022NIV_005378\u0022,\u0022orderId\u0022:\u0022NIV_005378\u0022,\u0022activity\u0022:\u0022Utility Bill Payment\u0022,\u0022price\u0022:\u0022$7,890.45\u0022,\u0022date\u0022:\u002202 Feb, 2028 06:30 PM\u0022,\u0022status\u0022:\u0022Completed\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022niv_005378|utility bill payment|$7,890.45|02 feb, 2028 06:30 pm|completed\u0022},{\u0022id\u0022:\u0022NIV_823930\u0022,\u0022orderId\u0022:\u0022NIV_823930\u0022,\u0022activity\u0022:\u0022Online Course Enrollment\u0022,\u0022price\u0022:\u0022$11,223.90\u0022,\u0022date\u0022:\u002222 Jan, 2028 11:02 AM\u0022,\u0022status\u0022:\u0022Completed\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022niv_823930|online course enrollment|$11,223.90|22 jan, 2028 11:02 am|completed\u0022}]'),
        deletedIds: [],
        selectedIds: [],
        searchQuery: '',
        handleDelete(transaction) {
            this.deletedIds = [...this.deletedIds, transaction.id];
            this.selectedIds = this.selectedIds.filter((id) => id !== transaction.id);
        },
        get filteredData() {
            const activeData = this.transactions.filter((item) => !this.deletedIds.includes(item.id));
            const query = this.searchQuery.trim().toLowerCase();
            if (!query) return activeData;
            return activeData.filter((item) => item.search.includes(query));
        },
        get isAllSelected() {
            return this.filteredData.length > 0 && this.filteredData.every((item) => this.selectedIds.includes(item.id));
        },
        handleToggleAll() {
            if (this.isAllSelected) {
                const visibleIds = new Set(this.filteredData.map((item) => item.id));
                this.selectedIds = this.selectedIds.filter((id) => !visibleIds.has(id));
            } else {
                const visibleIds = this.filteredData.map((item) => item.id);
                this.selectedIds = Array.from(new Set([...this.selectedIds, ...visibleIds]));
            }
        },
        handleToggleSelect(id) {
            this.selectedIds = this.selectedIds.includes(id)
                ? this.selectedIds.filter((itemId) => itemId !== id)
                : [...this.selectedIds, id];
        },
    }" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Header Controls -->
    <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <div>
        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Recent Transactions</div>
    </div>

    <div class="flex w-full items-center gap-3 sm:w-auto">
        <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 flex-1 sm:w-80 sm:flex-initial"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first ps-3.5 has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5"><svg class="size-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
            <input type="text" data-slot="input-group-control" x-model="searchQuery" placeholder="Search..." class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div>

        <button data-slot="button" type="button"  class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-[10px] [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 shrink-0 gap-2 px-4 py-2.5 text-gray-700 dark:text-gray-400"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            <span>Filter</span></button>
    </div>
</div>

    <!-- Table Content -->
    <div data-slot="card-content"  class="p-0"><div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-full">
                <thead class="border-y border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-800/40">
                    <tr>
                        <th class="h-11 min-w-44 py-3 ps-6 pe-4 text-start whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllSelected) })"
        aria-label="Order ID" @change="handleToggleAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                    Order ID
                                </span>
                            </div>
                        </th>
                        <th class="h-11 min-w-48 px-6 py-3 text-start text-sm font-normal whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Activity
                        </th>
                        <th class="h-11 min-w-36 px-6 py-3 text-start text-sm font-normal whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Price
                        </th>
                        <th class="h-11 min-w-52 px-6 py-3 text-start text-sm font-normal whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Date
                        </th>
                        <th class="h-11 min-w-32 px-6 py-3 text-start text-sm font-normal whitespace-nowrap text-gray-500 dark:text-gray-400">
                            Status
                        </th>
                        <th class="h-11 min-w-16 py-3 ps-4 pe-6 text-end whitespace-nowrap"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <template x-for="transaction in filteredData" :key="transaction.id">
                        <tr class="h-18 border-b border-gray-100 dark:border-gray-800">
    <td class="py-4 ps-6 pe-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(selectedIds.includes(transaction.id)) ? 'true' : 'false'"
    x-bind:data-state="Boolean(selectedIds.includes(transaction.id)) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(selectedIds.includes(transaction.id)) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(selectedIds.includes(transaction.id)) })"
        @change="handleToggleSelect(transaction.id)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(selectedIds.includes(transaction.id))"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
            <span class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="transaction.orderId"></span>
        </div>
    </td>
    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90" x-text="transaction.activity"></td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400" x-text="transaction.price"></td>
    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400" x-text="transaction.date"></td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span data-slot="badge" :class="transaction.badgeClasses" x-text="transaction.status"></span>
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
    @click="handleDelete(transaction)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                    </template>
                    <tr x-show="filteredData.length === 0">
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
                                    No transactions found
                                </h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Try adjusting your search criteria.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table></div>
    </div>
</div></div></div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
