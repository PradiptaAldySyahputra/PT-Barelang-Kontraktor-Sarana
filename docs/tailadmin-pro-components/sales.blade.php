<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 sm:p-6 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3 col-span-12"><div class="mb-5 flex flex-col justify-between gap-5 sm:flex-row">
    <div>
        <h2 class="mb-1 text-xl font-semibold text-gray-800 dark:text-white/90">
            Panel de ventas
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Rastree los ingresos, el rendimiento y el crecimiento de las ventas en tiempo real
        </p>
    </div>

    <div class="flex items-center gap-3 lg:flex-row">
        <!-- Date input -->
        <div
            x-data="{
                init() {
                    const today = new Date();
                    const sevenDaysAgo = new Date();
                    sevenDaysAgo.setDate(today.getDate() - 6);
                    flatpickr(this.$refs.datepicker, {
                        mode: 'range',
                        static: true,
                        monthSelectorType: 'static',
                        dateFormat: 'M d',
                        defaultDate: [sevenDaysAgo, today],
                        clickOpens: true,
                        prevArrow: '<svg class=\'stroke-current\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M12.5 15L7.5 10L12.5 5\' stroke=\'\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>',
                        nextArrow: '<svg class=\'stroke-current\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7.5 15L12.5 10L7.5 5\' stroke=\'\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>',
                    });
                }
            }"
            class="relative hidden items-center xl:inline-flex"
        >
            <svg class="pointer-events-none absolute start-1/2 top-1/2 z-10 -translate-x-1/2 -translate-y-1/2 text-gray-500 lg:start-3 lg:top-1/2 lg:translate-x-0 lg:-translate-y-1/2 rtl:translate-x-1/2 lg:rtl:translate-x-0 dark:text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            <input
                x-ref="datepicker"
                class="h-11 w-11 cursor-pointer rounded-lg border border-gray-300 bg-white text-sm font-medium text-transparent outline-none lg:h-auto lg:w-40 lg:py-2 lg:ps-10 lg:pe-3 lg:text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:lg:text-gray-300"
                placeholder="Seleccionar rango de fechas"
            />
        </div>

        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" >
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Filtrar</button>

        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg  xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <path
      d="M15 11.25a.75.75 0 01.75.75v1.5a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V12a.75.75 0 011.5 0v1.5c0 .414.335.75.75.75h9a.75.75 0 00.75-.75V12a.75.75 0 01.75-.75zm-5.998-9a.744.744 0 01.547.241L13 5.937A.75.75 0 0111.938 7L9.752 4.813V12a.75.75 0 01-1.5 0V4.809l-2.19 2.19A.75.75 0 015 5.938l3.468-3.466a.745.745 0 01.532-.222z"
      fill="currentColor"
    />
  </svg>
            Exportar</button>
    </div>
</div>

    <div class="rounded-2xl bg-gray-100 p-1 dark:bg-white/3">
        <div class="grid grid-cols-1 gap-1 sm:grid-cols-2 xl:grid-cols-4">
                            <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-xl border-0 border-none border-transparent bg-white p-5 sm:p-5 dark:border-transparent dark:bg-gray-900"><div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-400">
                Ingresos totales
            </h3>
            <div class="mt-1.5 flex gap-1.5">
                                                            <p class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                                        32%
                        </p>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        frente al mes pasado
                    </p>
                            </div>
        </div>
                    <span><svg class="size-6 text-[#12B76A]" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M15.484 7.72311C15.484 6.2798 14.314 5.10976 12.8707 5.10976H11.8138C9.99228 5.10976 8.51562 6.58641 8.51562 8.40795C8.51562 9.78276 9.36841 11.0134 10.6557 11.4961L13.344 12.5043C14.6312 12.9871 15.484 14.2177 15.484 15.5925C15.484 17.414 14.0074 18.8907 12.1858 18.8907H11.129C9.68566 18.8907 8.51562 17.7206 8.51562 16.2773M11.9996 19.2829L11.9996 21.2083M11.9996 2.79175L11.9996 4.7171"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></span>
            </div>

    <div class="flex items-end justify-between">
        <h2 class="w-1/2 text-3xl font-semibold text-gray-800 dark:text-white/90">
            $10,590
        </h2>
                    <div class="h-11 w-1/2">
                <div data-dashboard-chart="sales-stat" data-config="{&quot;color&quot;:&quot;#12B76A&quot;,&quot;seriesName&quot;:&quot;Nuevas ventas&quot;,&quot;data&quot;:[300,350,310,370,248,187,295,191,269,201,185,252,151],&quot;categories&quot;:[&quot;2018-09-19T00:00:00.000Z&quot;,&quot;2018-09-19T01:30:00.000Z&quot;,&quot;2018-09-19T02:30:00.000Z&quot;,&quot;2018-09-19T03:30:00.000Z&quot;,&quot;2018-09-19T04:30:00.000Z&quot;,&quot;2018-09-19T05:30:00.000Z&quot;,&quot;2018-09-19T06:30:00.000Z&quot;,&quot;2018-09-19T07:30:00.000Z&quot;,&quot;2018-09-19T08:30:00.000Z&quot;,&quot;2018-09-19T09:30:00.000Z&quot;,&quot;2018-09-19T10:30:00.000Z&quot;,&quot;2018-09-19T11:30:00.000Z&quot;,&quot;2018-09-19T12:30:00.000Z&quot;]}"></div>
            </div>
            </div></div>
                            <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-xl border-0 border-none border-transparent bg-white p-5 sm:p-5 dark:border-transparent dark:bg-gray-900"><div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-400">
                Ventas totales
            </h3>
            <div class="mt-1.5 flex gap-1.5">
                                                            <p class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                                        32%
                        </p>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        frente al mes pasado
                    </p>
                            </div>
        </div>
                    <span><svg width="29" height="28" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-6 text-[#7C3AED]">
  <path
    d="M5.625 9.333H3M4.75 14H3m.875 4.667H3m6.902 3.645h13.105a1.75 1.75 0 001.74-1.567L26.13 7.62a1.75 1.75 0 00-1.74-1.934H11.284a1.75 1.75 0 00-1.74 1.567L8.161 20.378a1.75 1.75 0 001.74 1.934zm6.56-16.625h3.117l-.875 5.821h-3.117l.875-5.82z"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  />
</svg></span>
            </div>

    <div class="flex items-end justify-between">
        <h2 class="w-1/2 text-3xl font-semibold text-gray-800 dark:text-white/90">
            1,320
        </h2>
                    <div class="h-11 w-1/2">
                <div data-dashboard-chart="sales-stat" data-config="{&quot;color&quot;:&quot;#7C3AED&quot;,&quot;seriesName&quot;:&quot;Nuevas ventas&quot;,&quot;data&quot;:[300,350,310,370,248,187,295,191,269,201,185,252,151],&quot;categories&quot;:[&quot;2018-09-19T00:00:00.000Z&quot;,&quot;2018-09-19T01:30:00.000Z&quot;,&quot;2018-09-19T02:30:00.000Z&quot;,&quot;2018-09-19T03:30:00.000Z&quot;,&quot;2018-09-19T04:30:00.000Z&quot;,&quot;2018-09-19T05:30:00.000Z&quot;,&quot;2018-09-19T06:30:00.000Z&quot;,&quot;2018-09-19T07:30:00.000Z&quot;,&quot;2018-09-19T08:30:00.000Z&quot;,&quot;2018-09-19T09:30:00.000Z&quot;,&quot;2018-09-19T10:30:00.000Z&quot;,&quot;2018-09-19T11:30:00.000Z&quot;,&quot;2018-09-19T12:30:00.000Z&quot;]}"></div>
            </div>
            </div></div>
                            <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-xl border-0 border-none border-transparent bg-white p-5 sm:p-5 dark:border-transparent dark:bg-gray-900"><div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-400">
                Tasa de conversión
            </h3>
            <div class="mt-1.5 flex gap-1.5">
                                                            <p class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                                        32%
                        </p>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        frente al mes pasado
                    </p>
                            </div>
        </div>
                    <span><svg class="size-6 text-[#38BDF8]" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M18.752 7.37695H5.25196M15.3773 4.00098L18.75 7.37587L15.3773 10.751M5.25 16.625H18.75M8.62471 20.001L5.25196 16.6261L8.62471 13.251"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></span>
            </div>

    <div class="flex items-end justify-between">
        <h2 class="w-1/2 text-3xl font-semibold text-gray-800 dark:text-white/90">
            4.38%
        </h2>
                    <div class="h-11 w-1/2">
                <div data-dashboard-chart="sales-stat" data-config="{&quot;color&quot;:&quot;#38BDF8&quot;,&quot;seriesName&quot;:&quot;Nuevas ventas&quot;,&quot;data&quot;:[300,350,310,370,248,187,295,191,269,201,185,252,151],&quot;categories&quot;:[&quot;2018-09-19T00:00:00.000Z&quot;,&quot;2018-09-19T01:30:00.000Z&quot;,&quot;2018-09-19T02:30:00.000Z&quot;,&quot;2018-09-19T03:30:00.000Z&quot;,&quot;2018-09-19T04:30:00.000Z&quot;,&quot;2018-09-19T05:30:00.000Z&quot;,&quot;2018-09-19T06:30:00.000Z&quot;,&quot;2018-09-19T07:30:00.000Z&quot;,&quot;2018-09-19T08:30:00.000Z&quot;,&quot;2018-09-19T09:30:00.000Z&quot;,&quot;2018-09-19T10:30:00.000Z&quot;,&quot;2018-09-19T11:30:00.000Z&quot;,&quot;2018-09-19T12:30:00.000Z&quot;]}"></div>
            </div>
            </div></div>
                            <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 rounded-xl border-0 border-none border-transparent bg-white p-5 sm:p-5 dark:border-transparent dark:bg-gray-900"><div class="flex items-center justify-between">
        <div>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-400">
                Tasa de reembolso
            </h3>
            <div class="mt-1.5 flex gap-1.5">
                                                            <p class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                                        32%
                        </p>
                                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                        frente al mes pasado
                    </p>
                            </div>
        </div>
                    <span><svg class="size-6 text-[#F04438]" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M20.6389 10.8655V8.16168C20.6389 7.3664 19.9942 6.72168 19.1989 6.72168H4.31891C3.52361 6.72168 2.87891 7.3664 2.87891 8.16168V16.3217C2.87891 17.117 3.52361 17.7617 4.31891 17.7617H8.96575M12.7199 10.2372C12.429 10.0976 12.1032 10.0193 11.759 10.0193C10.5315 10.0193 9.53656 11.0144 9.53656 12.2417C9.53656 12.587 9.61532 12.914 9.75587 13.2056M11.7589 15.1717H18.1689C19.5331 15.1717 20.6389 16.2776 20.6389 17.6417C20.6389 19.0058 19.5331 20.1116 18.1689 20.1116H14.2357M11.7589 15.1717L13.6777 13.2517M11.7589 15.1717L13.6777 17.0917"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M6.20312 12.2422H6.21312"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></span>
            </div>

    <div class="flex items-end justify-between">
        <h2 class="w-1/2 text-3xl font-semibold text-gray-800 dark:text-white/90">
            1.2%
        </h2>
                    <div class="h-11 w-1/2">
                <div data-dashboard-chart="sales-stat" data-config="{&quot;color&quot;:&quot;#F04438&quot;,&quot;seriesName&quot;:&quot;Nuevas ventas&quot;,&quot;data&quot;:[300,350,310,370,248,187,295,191,269,201,185,252,151],&quot;categories&quot;:[&quot;2018-09-19T00:00:00.000Z&quot;,&quot;2018-09-19T01:30:00.000Z&quot;,&quot;2018-09-19T02:30:00.000Z&quot;,&quot;2018-09-19T03:30:00.000Z&quot;,&quot;2018-09-19T04:30:00.000Z&quot;,&quot;2018-09-19T05:30:00.000Z&quot;,&quot;2018-09-19T06:30:00.000Z&quot;,&quot;2018-09-19T07:30:00.000Z&quot;,&quot;2018-09-19T08:30:00.000Z&quot;,&quot;2018-09-19T09:30:00.000Z&quot;,&quot;2018-09-19T10:30:00.000Z&quot;,&quot;2018-09-19T11:30:00.000Z&quot;,&quot;2018-09-19T12:30:00.000Z&quot;]}"></div>
            </div>
            </div></div>
                    </div>
    </div></div>

        <div
    x-data="{
        selectedTab: 'daily',
        setTab(tab) {
            this.selectedTab = tab;
            $el.querySelector('[data-dashboard-chart]').dispatchEvent(new CustomEvent('chart-update', { detail: { tab } }));
        }
    }"
    class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3 col-span-12"
>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Desglose de ingresos
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Información sobre ingresos y descripción general del rendimiento
        </p>
    </div>

    <div role="group" data-slot="button-group" data-orientation="horizontal"  class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-e-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-s-none [&amp;&gt;[data-slot]~[data-slot]]:border-s-0 gap-0.5 rounded-lg bg-gray-100 p-0.5 *:data-slot:rounded-md! dark:bg-gray-900"><button
                type="button"
                data-slot="button"
                :class="selectedTab === 'daily' ? 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white' : 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
                x-on:click="setTab('daily')"
            >
                Diario
            </button>
                    <button
                type="button"
                data-slot="button"
                :class="selectedTab === 'weekly' ? 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white' : 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
                x-on:click="setTab('weekly')"
            >
                Semanal
            </button>
                    <button
                type="button"
                data-slot="button"
                :class="selectedTab === 'monthly' ? 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-800 dark:hover:text-white' : 'group\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\/20 dark:aria-invalid:border-red-500\/50 dark:aria-invalid:ring-red-500\/40 [\u0026_svg]:pointer-events-none [\u0026_svg]:shrink-0 [\u0026_svg:not([class*=\u0027size-\u0027])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [\u0026:has(\u003Esvg:first-child)]:ps-3 [\u0026:has(\u003Esvg:last-child)]:pe-3 h-8 px-3 text-sm font-medium transition-colors text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'"
                x-on:click="setTab('monthly')"
            >
                Mensual
            </button></div>
</div>

    <div class="mt-6 mb-2 flex items-center gap-5">
    <div class="flex items-center gap-1.5">
        <span class="size-2.5 rounded-full bg-brand-500"></span>
        <span class="text-sm text-gray-700 dark:text-gray-400">
            En línea
        </span>
    </div>
    <div class="flex items-center gap-1.5">
        <span class="size-2.5 rounded-full bg-[#00BCFF]"></span>
        <span class="text-sm text-gray-700 dark:text-gray-400">
            Fuera de línea
        </span>
    </div>
</div>

    <div data-slot="scroll-area"  class="relative max-w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1">
        <div class="min-w-0"><div class="-ms-4 min-w-162.5 ps-2 xl:min-w-full">
            <div data-dashboard-chart="sales-revenue" data-config="{&quot;tabs&quot;:{&quot;daily&quot;:{&quot;categories&quot;:[&quot;00:00&quot;,&quot;01:00&quot;,&quot;02:00&quot;,&quot;04:00&quot;,&quot;05:00&quot;,&quot;06:00&quot;,&quot;07:00&quot;,&quot;08:00&quot;],&quot;series&quot;:[{&quot;name&quot;:&quot;En l\u00ednea&quot;,&quot;data&quot;:[16500,17500,19800,15600,22400,20100,37200,35400]},{&quot;name&quot;:&quot;Fuera de l\u00ednea&quot;,&quot;data&quot;:[19200,23100,28400,29800,25200,24800,31500,28100]}],&quot;maxY&quot;:40000,&quot;tickAmount&quot;:4},&quot;weekly&quot;:{&quot;categories&quot;:[&quot;Mon&quot;,&quot;Tue&quot;,&quot;Wed&quot;,&quot;Thu&quot;,&quot;Fri&quot;,&quot;Sat&quot;,&quot;Sun&quot;],&quot;series&quot;:[{&quot;name&quot;:&quot;En l\u00ednea&quot;,&quot;data&quot;:[18500,22400,21200,26800,24500,31200,33500]},{&quot;name&quot;:&quot;Fuera de l\u00ednea&quot;,&quot;data&quot;:[14200,16800,19400,22100,20800,25400,27600]}],&quot;maxY&quot;:40000,&quot;tickAmount&quot;:4},&quot;monthly&quot;:{&quot;categories&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],&quot;series&quot;:[{&quot;name&quot;:&quot;En l\u00ednea&quot;,&quot;data&quot;:[13000,13800,13200,14200,13900,15240,15600,17000,16500,17500,17200,18000]},{&quot;name&quot;:&quot;Fuera de l\u00ednea&quot;,&quot;data&quot;:[8500,9200,8800,9800,9400,10490,10800,11500,10800,11800,11200,11800]}],&quot;maxY&quot;:20000,&quot;tickAmount&quot;:4}},&quot;tab&quot;:&quot;daily&quot;}"></div>
        </div></div>
    </div>
</div>
</div>

        <div class="col-span-12 grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-start justify-between gap-4">
    <div>
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Retención de usuarios
        </h3>
        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
            Interacción de los usuarios a lo largo del tiempo
        </p>
    </div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
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
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Ver más</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Eliminar</div></div>
    </div>
</template></div>
</div>
    <div class="mt-4 mb-5 flex items-baseline gap-2">
    <h4 class="text-3xl font-medium text-gray-800 dark:text-white/90">
        24%
    </h4>
    <div class="flex items-center gap-1.5">
        <span class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5 rotate-45 rtl:-rotate-45">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
            3.2%
        </span>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            Incremento frente a la semana pasada
        </span>
    </div>
</div>
    <div class="custom-scrollbar overflow-x-auto">
    <div
        class="hm-wrapper relative min-w-70 select-none"
        x-data="{
            tooltip: null,
            show(e, value, col) {
                if (value === 0) return;
                const target = e.currentTarget;
                const rect = target.getBoundingClientRect();
                const wrapper = target.closest('.hm-wrapper');
                const wRect = wrapper ? wrapper.getBoundingClientRect() : null;
                const rawX = rect.left - (wRect ? wRect.left : 0) + rect.width / 2;
                const wrapperWidth = wRect ? wRect.width : 280;
                const clampedX = Math.max(36, Math.min(wrapperWidth - 36, rawX));
                const yOffset = rect.top - (wRect ? wRect.top : 0);
                const placement = yOffset < 32 ? 'bottom' : 'top';
                this.tooltip = {
                    col,
                    value,
                    x: clampedX,
                    y: placement === 'bottom' ? yOffset + rect.height + 6 : yOffset - 6,
                    placement,
                };
            },
        }"
        @mouseleave="tooltip = null"
    >
        <!-- Hover Tooltip -->
        <template x-if="tooltip">
            <div
                class="pointer-events-none absolute z-10 -translate-x-1/2 rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium whitespace-nowrap text-gray-700 shadow-theme-xs dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
                :class="tooltip.placement === 'top' ? '-translate-y-full' : 'translate-y-0'"
                :style="{ left: tooltip.x + 'px', top: tooltip.y + 'px' }"
            >
                <span x-text="tooltip.col + 1"></span>: <span x-text="tooltip.value"></span>%
            </div>
        </template>

        <!-- Heatmap Matrix -->
        <div class="flex flex-col gap-0.5">
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 86, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 63, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 54, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 47, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 42, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 39, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 36, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 33, 7)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 31, 8)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 29, 9)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 27, 10)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-100 dark:bg-brand-500/20"
                                    @mouseenter="show($event, 25, 11)"
                                ></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 81, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 58, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 49, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 42, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 37, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 34, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 31, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 28, 7)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 26, 8)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-100 dark:bg-brand-500/20"
                                    @mouseenter="show($event, 24, 9)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-100 dark:bg-brand-500/20"
                                    @mouseenter="show($event, 22, 10)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 89, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 66, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 57, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 50, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 45, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 42, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 39, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 36, 7)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 34, 8)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 32, 9)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 83, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 60, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 51, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 44, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 39, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 36, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 33, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 30, 7)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 28, 8)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 91, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 68, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 59, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 52, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 47, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 44, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 41, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 38, 7)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 79, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 56, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 47, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 40, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 35, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 32, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 29, 6)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 87, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 64, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 55, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 48, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 43, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 40, 5)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 82, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 59, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 50, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 43, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 38, 4)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 90, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 67, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 58, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 51, 3)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 81, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 58, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-300 dark:bg-brand-500/40"
                                    @mouseenter="show($event, 49, 2)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 88, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-400 dark:bg-brand-500/70"
                                    @mouseenter="show($event, 65, 1)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                            <div class="flex gap-0.5">
                                            <div class="flex-1">
                                                            <div
                                    class="h-4.25 w-full cursor-pointer rounded-xs transition-opacity hover:opacity-80 bg-brand-500"
                                    @mouseenter="show($event, 84, 0)"
                                ></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                            <div class="flex-1">
                                                            <div class="h-4.25 w-full bg-transparent"></div>
                                                    </div>
                                    </div>
                    </div>

        <!-- X-axis Labels -->
        <div class="mt-4 flex gap-0.5 text-center text-xs text-gray-400 dark:text-gray-500">
                            <span class="flex-1">
                    1
                </span>
                            <span class="flex-1">
                    2
                </span>
                            <span class="flex-1">
                    3
                </span>
                            <span class="flex-1">
                    4
                </span>
                            <span class="flex-1">
                    5
                </span>
                            <span class="flex-1">
                    6
                </span>
                            <span class="flex-1">
                    7
                </span>
                            <span class="flex-1">
                    8
                </span>
                            <span class="flex-1">
                    9
                </span>
                            <span class="flex-1">
                    10
                </span>
                            <span class="flex-1">
                    11
                </span>
                            <span class="flex-1">
                    12
                </span>
                    </div>
    </div>
</div>
</div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-start justify-between gap-4">
    <div>
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Ventas por canal
        </h3>
        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
            Resumen del rendimiento del canal
        </p>
    </div>

    <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
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
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Ver más</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Eliminar</div></div>
    </div>
</template></div>
</div>
    <div class="mt-4 mb-6 flex items-baseline gap-2">
    <h4 class="text-3xl font-medium text-gray-800 dark:text-white/90">
        75
    </h4>
    <div class="flex items-center gap-1.5">
        <span class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5 rotate-45 rtl:-rotate-45">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
            
            3.2%
        </span>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            Incremento frente a la semana pasada
        </span>
    </div>
</div>
    <div class="flex h-8 w-full items-center justify-between px-0.5">
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-brand-500"></div>
                <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-[#00BCFF]"></div>
                <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
            <div class="h-full w-1 shrink-0 rounded-[1px] bg-gray-200 dark:bg-gray-700"></div>
    </div>
    <div class="mt-5 rounded-xl border border-gray-100 dark:border-gray-800">
    <!-- Legend / Indicators -->
    <div class="flex flex-wrap items-center gap-6 border-b border-gray-100 px-4 py-3 dark:border-gray-800">
                    <div class="flex items-center gap-1.5">
                <span class="inline-block size-2 rounded-full bg-brand-500"></span>
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Sitio web
                </span>
            </div>
                    <div class="flex items-center gap-1.5">
                <span class="inline-block size-2 rounded-full bg-[#00BCFF]"></span>
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Correo electrónico
                </span>
            </div>
                    <div class="flex items-center gap-1.5">
                <span class="inline-block size-2 rounded-full bg-gray-300 dark:bg-gray-600"></span>
                <span class="text-sm text-gray-700 dark:text-gray-400">
                    Redes sociales
                </span>
            </div>
            </div>

    <!-- Metrics Table -->
    <div class="p-4">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="pb-2 text-start text-sm font-normal text-gray-400 dark:text-gray-500">
                        Canales
                    </th>
                    <th class="pb-2 text-start text-sm font-normal text-gray-400 dark:text-gray-500">
                        Métrica
                    </th>
                    <th class="pb-2 text-end text-sm font-normal text-gray-400 dark:text-gray-500">
                        Total
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-transparent">
                                    <tr>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            Sitio web
                        </td>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            35
                        </td>
                        <td class="py-2 text-end text-sm">
                            <div class="flex items-center justify-end gap-1">
                                                                    <span class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                        <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5 rotate-45 rtl:-rotate-45">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                        5.2%
                                    </span>
                                                            </div>
                        </td>
                    </tr>
                                    <tr>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            Correo electrónico
                        </td>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            25
                        </td>
                        <td class="py-2 text-end text-sm">
                            <div class="flex items-center justify-end gap-1">
                                                                    <span class="flex items-center gap-1 text-sm font-medium text-red-600 dark:text-red-500">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5 rotate-45 rtl:-rotate-45">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M5.315 10.376c.137.153.336.25.558.25h.001a.748.748 0 00.531-.22l3-2.998a.75.75 0 10-1.06-1.06l-1.722 1.72V1.875a.75.75 0 10-1.5 0v6.19L3.405 6.346a.75.75 0 00-1.06 1.061l2.97 2.968z"
      fill="currentColor"
    />
  </svg>
                                        2.8%
                                    </span>
                                                            </div>
                        </td>
                    </tr>
                                    <tr>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            Redes sociales
                        </td>
                        <td class="py-2 text-start text-sm text-gray-700 dark:text-gray-400">
                            59
                        </td>
                        <td class="py-2 text-end text-sm">
                            <div class="flex items-center justify-end gap-1">
                                                                    <span class="flex items-center gap-1 text-sm font-medium text-green-600 dark:text-green-500">
                                        <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-3.5 rotate-45 rtl:-rotate-45">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.065 1.624a.748.748 0 01.558-.25h.001c.192 0 .384.073.531.22l3 2.998a.75.75 0 11-1.06 1.06l-1.722-1.72v6.193a.75.75 0 01-1.5 0v-6.19L4.155 5.654a.75.75 0 01-1.06-1.061l2.97-2.968z"
      fill="currentColor"
    />
  </svg>
                                        4.5%
                                    </span>
                                                            </div>
                        </td>
                    </tr>
                            </tbody>
        </table>
    </div>
</div>
</div>
            <div class="flex flex-col justify-between rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/3">
    <div class="flex items-start justify-between gap-4">
    <div>
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Ventas por país
        </h3>
        <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
            Resumen de ventas por país
        </p>
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
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Ver más</div>
            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Eliminar</div></div>
    </div>
</template></div>
</div>
    <div class="my-4">
        <div id="mapTwo" class="mapTwo relative h-40.5 w-full overflow-hidden bg-transparent">
    <div data-dashboard-chart="sales-country-map" data-config="{&quot;markers&quot;:[{&quot;latLng&quot;:[37.7749,-122.4194],&quot;name&quot;:&quot;United States (West)&quot;,&quot;style&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;,&quot;borderWidth&quot;:2,&quot;borderColor&quot;:&quot;#ffffff&quot;}},{&quot;latLng&quot;:[40.7128,-74.006],&quot;name&quot;:&quot;United States (East)&quot;,&quot;style&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;,&quot;borderWidth&quot;:1.5,&quot;borderColor&quot;:&quot;#ffffff&quot;}},{&quot;latLng&quot;:[1.3521,103.8198],&quot;name&quot;:&quot;Singapore&quot;,&quot;style&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;,&quot;borderWidth&quot;:1.5,&quot;borderColor&quot;:&quot;#ffffff&quot;}},{&quot;latLng&quot;:[-33.8688,151.2093],&quot;name&quot;:&quot;Australia&quot;,&quot;style&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;,&quot;borderWidth&quot;:1.5,&quot;borderColor&quot;:&quot;#ffffff&quot;}}]}" style="width: 100%; height: 100%"></div>
</div>
    </div>
    <ul class="space-y-4">
            <li class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img
                    src="/assets/images/country/country-01.svg"
                    alt="EE. UU."
                    width="16"
                    height="16"
                    class="size-4 rounded-full object-cover"
                />
                <span class="text-sm font-normal text-gray-800 dark:text-white/90">
                    EE. UU.
                </span>
            </div>

            <div class="flex items-center gap-10">
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    $20.594
                </span>
                <span class="w-8 text-end text-sm font-normal text-gray-700 dark:text-gray-400">
                    79%
                </span>
            </div>
        </li>
            <li class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img
                    src="/assets/images/country/country-02.svg"
                    alt="Francia"
                    width="16"
                    height="16"
                    class="size-4 rounded-full object-cover"
                />
                <span class="text-sm font-normal text-gray-800 dark:text-white/90">
                    Francia
                </span>
            </div>

            <div class="flex items-center gap-10">
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    $20.594
                </span>
                <span class="w-8 text-end text-sm font-normal text-gray-700 dark:text-gray-400">
                    79%
                </span>
            </div>
        </li>
            <li class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img
                    src="/assets/images/country/country-05.svg"
                    alt="Egipto"
                    width="16"
                    height="16"
                    class="size-4 rounded-full object-cover"
                />
                <span class="text-sm font-normal text-gray-800 dark:text-white/90">
                    Egipto
                </span>
            </div>

            <div class="flex items-center gap-10">
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    $15.230
                </span>
                <span class="w-8 text-end text-sm font-normal text-gray-700 dark:text-gray-400">
                    68%
                </span>
            </div>
        </li>
            <li class="flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img
                    src="/assets/images/country/country-07.svg"
                    alt="Alemania"
                    width="16"
                    height="16"
                    class="size-4 rounded-full object-cover"
                />
                <span class="text-sm font-normal text-gray-800 dark:text-white/90">
                    Alemania
                </span>
            </div>

            <div class="flex items-center gap-10">
                <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
                    $16.450
                </span>
                <span class="w-8 text-end text-sm font-normal text-gray-700 dark:text-gray-400">
                    72%
                </span>
            </div>
        </li>
    </ul>
</div>
        </div>

        <div class="col-span-12">
            <div
    x-data="{
        products: JSON.parse('[{\u0022id\u0022:1,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product-01\\\/product-01.jpg\u0022,\u0022name\u0022:\u0022Chaqueta vaquera cl\\u00e1sica\u0022,\u0022variant\u0022:\u00223 tallas\u0022,\u0022category\u0022:\u0022Chaqueta\u0022,\u0022sales\u0022:500,\u0022earnings\u0022:\u0022$89.99\u0022,\u0022stocks\u0022:100,\u0022statusLabel\u0022:\u0022En stock\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022chaqueta vaquera cl\\u00e1sica|chaqueta\u0022},{\u0022id\u0022:2,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product-01\\\/product-02.jpg\u0022,\u0022name\u0022:\u0022Pantalones chinos slim fit\u0022,\u0022variant\u0022:\u00224 colores\u0022,\u0022category\u0022:\u0022Pantalones\u0022,\u0022sales\u0022:300,\u0022earnings\u0022:\u0022$49.99\u0022,\u0022stocks\u0022:80,\u0022statusLabel\u0022:\u0022En stock\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022pantalones chinos slim fit|pantalones\u0022},{\u0022id\u0022:3,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product-01\\\/product-03.jpg\u0022,\u0022name\u0022:\u0022Camiseta de algod\\u00f3n org\\u00e1nico\u0022,\u0022variant\u0022:\u00225 colores\u0022,\u0022category\u0022:\u0022Camiseta\u0022,\u0022sales\u0022:220,\u0022earnings\u0022:\u0022$25.00\u0022,\u0022stocks\u0022:30,\u0022statusLabel\u0022:\u0022Poco stock\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022,\u0022search\u0022:\u0022camiseta de algod\\u00f3n org\\u00e1nico|camiseta\u0022},{\u0022id\u0022:4,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product-01\\\/product-04.jpg\u0022,\u0022name\u0022:\u0022Botines de cuero\u0022,\u0022variant\u0022:\u00226 tallas\u0022,\u0022category\u0022:\u0022Calzado\u0022,\u0022sales\u0022:875,\u0022earnings\u0022:\u0022$120.00\u0022,\u0022stocks\u0022:120,\u0022statusLabel\u0022:\u0022Poco stock\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022,\u0022search\u0022:\u0022botines de cuero|calzado\u0022},{\u0022id\u0022:5,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product-01\\\/product-05.jpg\u0022,\u0022name\u0022:\u0022Bufanda de mezcla de lana\u0022,\u0022variant\u0022:\u00222 colores\u0022,\u0022category\u0022:\u0022Accesorio\u0022,\u0022sales\u0022:359,\u0022earnings\u0022:\u0022$35.50\u0022,\u0022stocks\u0022:200,\u0022statusLabel\u0022:\u0022En stock\u0022,\u0022badgeClasses\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022search\u0022:\u0022bufanda de mezcla de lana|accesorio\u0022}]'),
        searchQuery: '',
        get filteredData() {
            const query = this.searchQuery.trim().toLowerCase();
            if (!query) return this.products;
            return this.products.filter((item) => {
                const [name, category] = item.search.split('|');
                return name.includes(query) || category.includes(query);
            });
        },
    }"
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"
>
    <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Productos destacados
        </h3>
    </div>

    <div class="flex items-center gap-3">
        <input data-slot="input" type="text" x-model="searchQuery" placeholder="Buscar..." class="min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-10 w-full sm:w-55" />

        <button data-slot="button" type="button"  class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 shrink-0 font-medium">Ver todo</button>
    </div>
</div>

    <div class="px-5 pb-5">
        <div data-slot="scroll-area"  class="relative max-w-full overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1">
        <div class="min-w-0"><table class="min-w-full">
                <thead class="border-b border-gray-100 dark:border-gray-800">
                    <tr class="h-11">
                                                    <th class="px-5 py-3 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Nombre del producto
                                </p>
                            </th>
                                                    <th class="px-6 py-3 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    ID del producto
                                </p>
                            </th>
                                                    <th class="px-6 py-3 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Ventas
                                </p>
                            </th>
                                                    <th class="px-6 py-3 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Ganancias
                                </p>
                            </th>
                                                    <th class="px-6 py-3 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Existencias
                                </p>
                            </th>
                                                    <th class="py-3 ps-6 pe-5 text-start whitespace-nowrap">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                    Estado
                                </p>
                            </th>
                                            </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
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
                                    No se encontraron productos
                                </h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Intente cambiar su término de búsqueda.
                                </p>
                            </div>
                        </td>
                    </tr>
                    <template x-for="product in filteredData" :key="product.id">
                        <tr class="h-16.5 border-b border-gray-100 last:border-b-0 dark:border-gray-800">
    <td class="px-5 py-2 text-start whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="relative size-12.5 shrink-0 overflow-hidden rounded-md bg-gray-100 dark:bg-gray-800">
                <img
                    :src="product.image"
                    :alt="product.name"
                    width="50"
                    height="50"
                    class="size-full object-cover"
                />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="product.name"></p>
                <span class="text-xs font-normal text-gray-500 dark:text-gray-400" x-text="product.variant"></span>
            </div>
        </div>
    </td>

    <td class="px-6 py-3 text-start whitespace-nowrap">
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400" x-text="product.category"></p>
    </td>

    <td class="px-6 py-3 text-start whitespace-nowrap">
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400" x-text="product.sales"></p>
    </td>

    <td class="px-6 py-3 text-start whitespace-nowrap">
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400" x-text="product.earnings"></p>
    </td>

    <td class="px-6 py-3 text-start whitespace-nowrap">
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400" x-text="product.stocks"></p>
    </td>

    <td class="py-3 ps-6 pe-5 text-start whitespace-nowrap">
        <span data-slot="badge" :class="product.badgeClasses" x-text="product.statusLabel"></span>
    </td>
</tr>
                    </template>
                </tbody>
            </table></div>
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
