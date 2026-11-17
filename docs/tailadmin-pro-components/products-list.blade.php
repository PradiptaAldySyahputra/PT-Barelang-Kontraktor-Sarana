<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Productos
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
                Productos
            </li>
        </ol>
    </nav>
</div>
        <div
    x-data="tanstackTable('product-list', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:1,\u0022name\u0022:\u0022Macbook pro M4\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-01.jpg\u0022,\u0022category\u0022:\u0022Laptop\u0022,\u0022brand\u0022:\u0022Apple\u0022,\u0022price\u0022:\u0022$1,950\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002212 Feb, 2027\u0022},{\u0022id\u0022:2,\u0022name\u0022:\u0022Apple Watch Ultra\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-02.jpg\u0022,\u0022category\u0022:\u0022Watch\u0022,\u0022brand\u0022:\u0022Apple\u0022,\u0022price\u0022:\u0022$1,579\u0022,\u0022stock\u0022:\u0022Out of Stock\u0022,\u0022createdAt\u0022:\u002213 Mar, 2027\u0022},{\u0022id\u0022:3,\u0022name\u0022:\u0022iPhone 15 Pro Max\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-03.jpg\u0022,\u0022category\u0022:\u0022Phone\u0022,\u0022brand\u0022:\u0022Apple\u0022,\u0022price\u0022:\u0022$1,039\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002219 Mar, 2027\u0022},{\u0022id\u0022:4,\u0022name\u0022:\u0022iPad Pro 3rd Gen\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-04.jpg\u0022,\u0022category\u0022:\u0022Electronics\u0022,\u0022brand\u0022:\u0022Apple\u0022,\u0022price\u0022:\u0022$43,999\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002225 Apr, 2027\u0022},{\u0022id\u0022:5,\u0022name\u0022:\u0022Samsung Galaxy S24 Ultra\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-05.jpg\u0022,\u0022category\u0022:\u0022Phone\u0022,\u0022brand\u0022:\u0022Samsung\u0022,\u0022price\u0022:\u0022$919\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002211 May, 2027\u0022},{\u0022id\u0022:6,\u0022name\u0022:\u0022Airpods Pro 2nd Gen\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-01.jpg\u0022,\u0022category\u0022:\u0022Accessories\u0022,\u0022brand\u0022:\u0022Apple\u0022,\u0022price\u0022:\u0022$839\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002229 Jun, 2027\u0022},{\u0022id\u0022:7,\u0022name\u0022:\u0022LG OLED \\u0026 4K Smart TV\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-02.jpg\u0022,\u0022category\u0022:\u0022Electronics\u0022,\u0022brand\u0022:\u0022LG\u0022,\u0022price\u0022:\u0022$1,769\u0022,\u0022stock\u0022:\u0022Out of Stock\u0022,\u0022createdAt\u0022:\u002222 Jul, 2027\u0022},{\u0022id\u0022:8,\u0022name\u0022:\u0022Sony WH-1000XM5 Headphones\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-03.jpg\u0022,\u0022category\u0022:\u0022Audio\u0022,\u0022brand\u0022:\u0022Sony\u0022,\u0022price\u0022:\u0022$399\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002205 Aug, 2027\u0022},{\u0022id\u0022:9,\u0022name\u0022:\u0022Dell XPS 13 Laptop\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-04.jpg\u0022,\u0022category\u0022:\u0022Laptop\u0022,\u0022brand\u0022:\u0022Dell\u0022,\u0022price\u0022:\u0022$1,299\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002218 Aug, 2027\u0022},{\u0022id\u0022:10,\u0022name\u0022:\u0022Google Pixel 8 Pro\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-05.jpg\u0022,\u0022category\u0022:\u0022Phone\u0022,\u0022brand\u0022:\u0022Google\u0022,\u0022price\u0022:\u0022$899\u0022,\u0022stock\u0022:\u0022Out of Stock\u0022,\u0022createdAt\u0022:\u002202 Sep, 2027\u0022},{\u0022id\u0022:11,\u0022name\u0022:\u0022Microsoft Surface Pro 9\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-01.jpg\u0022,\u0022category\u0022:\u0022Tablet\u0022,\u0022brand\u0022:\u0022Microsoft\u0022,\u0022price\u0022:\u0022$1,099\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002215 Sep, 2027\u0022},{\u0022id\u0022:12,\u0022name\u0022:\u0022Canon EOS R5 Camera\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-02.jpg\u0022,\u0022category\u0022:\u0022Camera\u0022,\u0022brand\u0022:\u0022Canon\u0022,\u0022price\u0022:\u0022$3,899\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002228 Sep, 2027\u0022},{\u0022id\u0022:13,\u0022name\u0022:\u0022Nintendo Switch OLED\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-03.jpg\u0022,\u0022category\u0022:\u0022Gaming\u0022,\u0022brand\u0022:\u0022Nintendo\u0022,\u0022price\u0022:\u0022$349\u0022,\u0022stock\u0022:\u0022Out of Stock\u0022,\u0022createdAt\u0022:\u002210 Oct, 2027\u0022},{\u0022id\u0022:14,\u0022name\u0022:\u0022Razer DeathAdder V3 Mouse\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-04.jpg\u0022,\u0022category\u0022:\u0022Accessories\u0022,\u0022brand\u0022:\u0022Razer\u0022,\u0022price\u0022:\u0022$89\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002223 Oct, 2027\u0022},{\u0022id\u0022:15,\u0022name\u0022:\u0022HP Envy 34 Monitor\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-05.jpg\u0022,\u0022category\u0022:\u0022Monitor\u0022,\u0022brand\u0022:\u0022HP\u0022,\u0022price\u0022:\u0022$799\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002205 Nov, 2027\u0022},{\u0022id\u0022:16,\u0022name\u0022:\u0022Bose QuietComfort Earbuds\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-01.jpg\u0022,\u0022category\u0022:\u0022Audio\u0022,\u0022brand\u0022:\u0022Bose\u0022,\u0022price\u0022:\u0022$279\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002218 Nov, 2027\u0022},{\u0022id\u0022:17,\u0022name\u0022:\u0022ASUS ROG Gaming Laptop\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-03.jpg\u0022,\u0022category\u0022:\u0022Laptop\u0022,\u0022brand\u0022:\u0022ASUS\u0022,\u0022price\u0022:\u0022$2,199\u0022,\u0022stock\u0022:\u0022Out of Stock\u0022,\u0022createdAt\u0022:\u002201 Dec, 2027\u0022},{\u0022id\u0022:18,\u0022name\u0022:\u0022Logitech MX Master 3S\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-04.jpg\u0022,\u0022category\u0022:\u0022Accessories\u0022,\u0022brand\u0022:\u0022Logitech\u0022,\u0022price\u0022:\u0022$119\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002214 Dec, 2027\u0022},{\u0022id\u0022:19,\u0022name\u0022:\u0022Steam Deck OLED\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-02.jpg\u0022,\u0022category\u0022:\u0022Gaming\u0022,\u0022brand\u0022:\u0022Valve\u0022,\u0022price\u0022:\u0022$649\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002227 Dec, 2027\u0022},{\u0022id\u0022:20,\u0022name\u0022:\u0022Samsung 980 Pro SSD 2TB\u0022,\u0022image\u0022:\u0022\\\/assets\\\/images\\\/product\\\/product-03.jpg\u0022,\u0022category\u0022:\u0022Storage\u0022,\u0022brand\u0022:\u0022Samsung\u0022,\u0022price\u0022:\u0022$299\u0022,\u0022stock\u0022:\u0022In Stock\u0022,\u0022createdAt\u0022:\u002209 Jan, 2028\u0022}],\u0022pageSize\u0022:7,\u0022extra\u0022:{\u0022categories\u0022:[\u0022Laptop\u0022,\u0022Watch\u0022,\u0022Phone\u0022,\u0022Electronics\u0022,\u0022Accessories\u0022,\u0022Audio\u0022,\u0022Tablet\u0022,\u0022Camera\u0022,\u0022Gaming\u0022,\u0022Monitor\u0022,\u0022Storage\u0022],\u0022badgeClasses\u0022:{\u0022In Stock\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022other\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022},\u0022paginationClasses\u0022:{\u0022link\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent shadow-theme-xs hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-lg text-sm font-medium border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white\\\/5\u0022,\u0022linkActive\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500\\\/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-10 rounded-lg text-sm font-medium bg-brand-500 text-white\u0022,\u0022prev\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-lg border-gray-300 dark:border-gray-700\u0022,\u0022prevDisabled\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-lg border-gray-300 dark:border-gray-700 pointer-events-none cursor-not-allowed opacity-50\u0022,\u0022next\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-lg border-gray-300 dark:border-gray-700\u0022,\u0022nextDisabled\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-lg border-gray-300 dark:border-gray-700 pointer-events-none cursor-not-allowed opacity-50\u0022}}}'))"
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"
>
    <!-- Header -->
    <div class="flex flex-col justify-between gap-4 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center dark:border-gray-800">
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Products List
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Track your store&#039;s progress to boost your sales.</p>
    </div>

    <div class="flex items-center gap-3">
        <button data-slot="button" type="button" @click="handleExport()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><span>Export</span>
            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <path
      d="M15 12v1.875c0 .621-.503 1.125-1.125 1.125h-9.75A1.125 1.125 0 013 13.875V12M9 12V3m-3.47 5.532L9 11.998l3.468-3.466"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

        <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" href="/add-product">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                <span>Add Product</span>
            </a>
    </div>
</div>

    <!-- Filter Section -->
    <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800">
    <div class="w-full sm:max-w-xs">
        <div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 w-full"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first ps-3.5 has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5"><svg class="size-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
            <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchTerm" @input="currentPage = 1" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div>
    </div>

    <div class="relative" @mousedown.outside="showFilterDropdown = false">
        <button data-slot="button" type="button" :class="hasActiveFilters ? 'border-brand-500 text-brand-500 dark:border-brand-400 dark:text-brand-400' : ''" @click="showFilterDropdown = !showFilterDropdown" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            Filter
            <span x-show="hasActiveFilters" style="display: none;" class="flex size-2 rounded-full bg-brand-500"></span></button>

        <div
            x-show="showFilterDropdown"
            style="display: none;"
            class="absolute end-0 z-99 mt-2 w-64 rounded-xl border border-gray-200 bg-white p-4 shadow-theme-lg dark:border-gray-700 dark:bg-gray-900"
        >
            <div class="mb-4">
                <label class="mb-1.5 block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Category
                </label>
                <select
                    x-model="selectedCategory"
                    @change="currentPage = 1"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 outline-hidden transition focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90"
                >
                    <option value="all">All Categories</option>
                    <template x-for="cat in categories" :key="cat">
                        <option :value="cat" x-text="cat"></option>
                    </template>
                </select>
            </div>

            <div class="mb-4">
                <label class="mb-1.5 block text-xs font-medium text-gray-700 dark:text-gray-300">
                    Stock Status
                </label>
                <select
                    x-model="selectedStock"
                    @change="currentPage = 1"
                    class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 outline-hidden transition focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90"
                >
                    <option value="all">All Status</option>
                    <option value="In Stock">In Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button data-slot="button" type="button" @click="handleResetFilters(); showFilterDropdown = false" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-8 gap-1.5 rounded-lg px-3 py-1.5 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-2.5 [&amp;:has(&gt;svg:last-child)]:pe-2.5 flex-1">Reset</button>
                <button data-slot="button" type="button" @click="showFilterDropdown = false" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-8 gap-1.5 rounded-lg px-3 py-1.5 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-2.5 [&amp;:has(&gt;svg:last-child)]:pe-2.5 flex-1">Apply</button>
            </div>
        </div>
    </div>
</div>

    <!-- Table -->
    <div data-slot="scroll-area"  class="relative max-w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-full">
            <thead class="border-b border-gray-100 dark:border-gray-800">
                <tr>
                    <th class="w-14 px-5 py-3 text-start">
                        <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllSelected) })"
        aria-label="Select all products" @change="handleToggleSelectAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                    </th>
                    <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">
                        Products
                    </th>
                                            <th
                            class="cursor-pointer px-5 py-3 text-start text-xs font-medium text-gray-500 select-none dark:text-gray-400"
                            @click="handleSort('category')"
                        >
                            <div class="flex items-center gap-1">
                                Category
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
        d="M8.40962 13.4148C8.21057 13.6992 7.78943 13.6992 7.59038 13.4148L5.05071 9.78673C4.81874 9.45534 5.05582 9 5.46033 9H10.5397C10.9442 9 11.1813 9.45534 10.9493 9.78673L8.40962 13.4148Z"
        :class="sortKey === 'category' && sortDirection === 'desc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
    <path
        d="M8.40962 2.58517C8.21057 2.30081 7.78943 2.30081 7.59038 2.58517L5.05071 6.21327C4.81874 6.54466 5.05582 7 5.46033 7H10.5397C10.9442 7 11.1813 6.54466 10.9493 6.21327L8.40962 2.58517Z"
        :class="sortKey === 'category' && sortDirection === 'asc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
</svg>
                            </div>
                        </th>
                                            <th
                            class="cursor-pointer px-5 py-3 text-start text-xs font-medium text-gray-500 select-none dark:text-gray-400"
                            @click="handleSort('brand')"
                        >
                            <div class="flex items-center gap-1">
                                Brand
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
        d="M8.40962 13.4148C8.21057 13.6992 7.78943 13.6992 7.59038 13.4148L5.05071 9.78673C4.81874 9.45534 5.05582 9 5.46033 9H10.5397C10.9442 9 11.1813 9.45534 10.9493 9.78673L8.40962 13.4148Z"
        :class="sortKey === 'brand' && sortDirection === 'desc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
    <path
        d="M8.40962 2.58517C8.21057 2.30081 7.78943 2.30081 7.59038 2.58517L5.05071 6.21327C4.81874 6.54466 5.05582 7 5.46033 7H10.5397C10.9442 7 11.1813 6.54466 10.9493 6.21327L8.40962 2.58517Z"
        :class="sortKey === 'brand' && sortDirection === 'asc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
</svg>
                            </div>
                        </th>
                                            <th
                            class="cursor-pointer px-5 py-3 text-start text-xs font-medium text-gray-500 select-none dark:text-gray-400"
                            @click="handleSort('price')"
                        >
                            <div class="flex items-center gap-1">
                                Price
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
        d="M8.40962 13.4148C8.21057 13.6992 7.78943 13.6992 7.59038 13.4148L5.05071 9.78673C4.81874 9.45534 5.05582 9 5.46033 9H10.5397C10.9442 9 11.1813 9.45534 10.9493 9.78673L8.40962 13.4148Z"
        :class="sortKey === 'price' && sortDirection === 'desc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
    <path
        d="M8.40962 2.58517C8.21057 2.30081 7.78943 2.30081 7.59038 2.58517L5.05071 6.21327C4.81874 6.54466 5.05582 7 5.46033 7H10.5397C10.9442 7 11.1813 6.54466 10.9493 6.21327L8.40962 2.58517Z"
        :class="sortKey === 'price' && sortDirection === 'asc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
</svg>
                            </div>
                        </th>
                                        <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">
                        Stock
                    </th>
                    <th
                        class="cursor-pointer px-5 py-3 text-start text-xs font-medium text-gray-500 select-none dark:text-gray-400"
                        @click="handleSort('createdAt')"
                    >
                        <div class="flex items-center gap-1">
                            Created
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
        d="M8.40962 13.4148C8.21057 13.6992 7.78943 13.6992 7.59038 13.4148L5.05071 9.78673C4.81874 9.45534 5.05582 9 5.46033 9H10.5397C10.9442 9 11.1813 9.45534 10.9493 9.78673L8.40962 13.4148Z"
        :class="sortKey === 'createdAt' && sortDirection === 'desc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
    <path
        d="M8.40962 2.58517C8.21057 2.30081 7.78943 2.30081 7.59038 2.58517L5.05071 6.21327C4.81874 6.54466 5.05582 7 5.46033 7H10.5397C10.9442 7 11.1813 6.54466 10.9493 6.21327L8.40962 2.58517Z"
        :class="sortKey === 'createdAt' && sortDirection === 'asc' ? 'fill-gray-500 dark:fill-gray-400' : 'fill-gray-300 dark:fill-gray-700'"
    />
</svg>
                        </div>
                    </th>
                    <th class="w-14 px-5 py-3 text-end text-xs font-medium text-gray-500 dark:text-gray-400">
                        <span class="sr-only">Action</span>
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <tr x-show="paginatedProducts.length === 0" style="display: none;">
                    <td colspan="8" class="py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                        No products found.
                    </td>
                </tr>
                <template x-for="product in paginatedProducts" :key="product.id">
                    <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
    <td class="w-14 px-5 py-4 whitespace-nowrap">
        <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(selectedIds.includes(product.id)) ? 'true' : 'false'"
    x-bind:data-state="Boolean(selectedIds.includes(product.id)) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(selectedIds.includes(product.id)) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(selectedIds.includes(product.id)) })"
        x-bind:aria-label="`Select ${product.name}`" @change="handleToggleSelect(product.id)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(selectedIds.includes(product.id))"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
    </td>
    <td class="px-5 py-4 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <div class="size-12 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-800">
                <img width="48" height="48" :src="product.image" :alt="product.name" class="size-12 rounded-lg object-cover" />
            </div>
            <span class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="product.name"></span>
        </div>
    </td>
    <td class="px-5 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="product.category"></td>
    <td class="px-5 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="product.brand"></td>
    <td class="px-5 py-4 text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90" x-text="product.price"></td>
    <td class="px-5 py-4 whitespace-nowrap">
        <span data-slot="badge" :class="product.stock === 'In Stock' ? badgeClasses['In Stock'] : badgeClasses.other" x-text="product.stock"></span>
    </td>
    <td class="px-5 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="product.createdAt"></td>
    <td class="w-14 px-5 py-4 text-end whitespace-nowrap">
        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-gray-300" type="button" aria-label="Product actions"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
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
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Edit</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleDuplicate(product)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Duplicate</div>
                <div role="separator" aria-orientation="horizontal" data-slot="dropdown-menu-separator"  class="-mx-3 my-1.5 h-px bg-gray-100 dark:bg-gray-700"></div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleDelete(product.id)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
    </td>
</tr>
                </template>
            </tbody>
        </table></div>
    </div>
</div>

    <!-- Pagination -->
    <div
    x-show="totalPages > 0"
    class="flex flex-col items-center justify-between gap-4 border-t border-gray-200 px-5 py-4 sm:flex-row dark:border-gray-800"
>
    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
        Showing
        <span class="text-gray-800 dark:text-white/90"><span x-text="startItem"></span> to <span x-text="endItem"></span></span>
        of
        <span class="text-gray-800 dark:text-white/90" x-text="sortedProducts.length"></span>
    </div>

    <nav role="navigation" aria-label="pagination" data-slot="pagination"  class="flex mx-0 w-auto justify-end"><ul data-slot="pagination-content"  class="flex items-center gap-1.5"><li data-slot="pagination-item"><a
                    href="#"
                    aria-label="Previous page"
                    data-slot="pagination-link"
                    :class="prevClass()"
                    :aria-disabled="currentPage <= 1 ? 'true' : null"
                    @click.prevent="goPrevious()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
                </a></li>

            <template x-for="(item, index) in pages" :key="`${item}-${index}`">
                <li data-slot="pagination-item"><template x-if="typeof item === 'string'">
                        <span aria-hidden="true" data-slot="pagination-ellipsis"  class="flex items-center justify-center dark:text-white/90 [&amp;_svg:not([class*=size-])]:size-4 size-10"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
<span class="sr-only">More pages</span></span>
                    </template>
                    <template x-if="typeof item !== 'string'">
                        <a
                            href="#"
                            data-slot="pagination-link"
                            :data-active="currentPage === item ? 'true' : 'false'"
                            :aria-current="currentPage === item ? 'page' : null"
                            :class="linkClass(item)"
                            @click.prevent="goTo(item)"
                            x-text="item"
                        ></a>
                    </template></li>
            </template>

            <li data-slot="pagination-item"><a
                    href="#"
                    aria-label="Next page"
                    data-slot="pagination-link"
                    :class="nextClass()"
                    :aria-disabled="currentPage >= totalPages ? 'true' : null"
                    @click.prevent="goNext()"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
                </a></li></ul></nav>
</div>
</div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
