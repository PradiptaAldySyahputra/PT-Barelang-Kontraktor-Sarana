<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Transacciones
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
                Transacciones
            </li>
        </ol>
    </nav>
</div>
        <div data-slot="card" data-size="default" x-data="{
        transactions: JSON.parse('[{\u0022id\u0022:1,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Lindsey Curtis\u0022,\u0022email\u0022:\u0022lindsey@example.com\u0022,\u0022totalAmount\u0022:\u0022$699\u0022,\u0022dueDate\u0022:\u002212 Feb, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:2,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Kaiya George\u0022,\u0022email\u0022:\u0022kaiya@example.com\u0022,\u0022totalAmount\u0022:\u0022$1,579\u0022,\u0022dueDate\u0022:\u002213 Mar, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:3,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Zain Geidt\u0022,\u0022email\u0022:\u0022zain787@example.com\u0022,\u0022totalAmount\u0022:\u0022$1,039\u0022,\u0022dueDate\u0022:\u002219 Mar, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:4,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Abram Schleifer\u0022,\u0022email\u0022:\u0022abram@example.com\u0022,\u0022totalAmount\u0022:\u0022$43,999\u0022,\u0022dueDate\u0022:\u002225 Apr, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:5,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Carla George\u0022,\u0022email\u0022:\u0022carla65@example.com\u0022,\u0022totalAmount\u0022:\u0022$919\u0022,\u0022dueDate\u0022:\u002211 May, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:6,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Emery Culhane\u0022,\u0022email\u0022:\u0022emery09@example.com\u0022,\u0022totalAmount\u0022:\u0022$839\u0022,\u0022dueDate\u0022:\u002229 Jun, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:7,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Livia Donin\u0022,\u0022email\u0022:\u0022livia343@example.com\u0022,\u0022totalAmount\u0022:\u0022$1,769\u0022,\u0022dueDate\u0022:\u002222 Jul, 2027\u0022,\u0022status\u0022:\u0022Failed\u0022},{\u0022id\u0022:8,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Miracle Bator\u0022,\u0022email\u0022:\u0022miracle@example.com\u0022,\u0022totalAmount\u0022:\u0022$7,349\u0022,\u0022dueDate\u0022:\u002205 Aug, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022},{\u0022id\u0022:9,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Lincoln Herwitz\u0022,\u0022email\u0022:\u0022lincoln@example.com\u0022,\u0022totalAmount\u0022:\u0022$849\u0022,\u0022dueDate\u0022:\u002209 Sep, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:10,\u0022orderId\u0022:\u0022#323534\u0022,\u0022customer\u0022:\u0022Ekstrom Bothman\u0022,\u0022email\u0022:\u0022ekstrom@example.com\u0022,\u0022totalAmount\u0022:\u0022$679\u0022,\u0022dueDate\u0022:\u002215 Nov, 2027\u0022,\u0022status\u0022:\u0022Completed\u0022}]'),
        badgeClasses: JSON.parse('{\u0022Completed\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022,\u0022Pending\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500\\\/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]\u0022,\u0022Failed\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022,\u0022other\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500\\\/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)]\u0022}'),
        paginationClasses: JSON.parse('{\u0022link\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-sm font-medium transition-colors border border-gray-200 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white\u0022,\u0022linkActive\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 border-gray-300 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] text-sm font-medium transition-colors bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 hover:text-white dark:bg-brand-500 dark:text-white dark:hover:bg-brand-600 dark:hover:text-white\u0022,\u0022prev\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] border-gray-300 dark:border-gray-700\u0022,\u0022prevDisabled\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] border-gray-300 dark:border-gray-700 pointer-events-none cursor-not-allowed opacity-50\u0022,\u0022next\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] border-gray-300 dark:border-gray-700\u0022,\u0022nextDisabled\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] border-gray-300 dark:border-gray-700 pointer-events-none cursor-not-allowed opacity-50\u0022}'),
        itemsPerPage: 10,
        currentPage: 1,
        searchQuery: '',
        selectedRange: '7-days',
        selectedIds: [],
        sortField: null,
        sortDirection: 'asc',
        get filteredData() {
            if (!this.searchQuery.trim()) return this.transactions;
            const query = this.searchQuery.toLowerCase();
            return this.transactions.filter((item) =>
                [item.orderId, item.customer, item.email, item.totalAmount, item.dueDate, item.status].some((v) => v.toLowerCase().includes(query)),
            );
        },
        get sortedData() {
            const field = this.sortField;
            if (!field) return this.filteredData;
            return [...this.filteredData].sort((a, b) => {
                let comparison = 0;
                if (field === 'totalAmount') {
                    const numA = parseFloat(String(a[field]).replace(/[^0-9.-]+/g, '')) || 0;
                    const numB = parseFloat(String(b[field]).replace(/[^0-9.-]+/g, '')) || 0;
                    comparison = numA - numB;
                } else {
                    comparison = String(a[field]).localeCompare(String(b[field]));
                }
                return this.sortDirection === 'asc' ? comparison : -comparison;
            });
        },
        get totalItems() { return this.filteredData.length === 0 ? 0 : Math.max(this.filteredData.length, 1000); },
        get totalPages() { return Math.max(1, Math.ceil(this.totalItems / this.itemsPerPage)); },
        get paginatedData() {
            if (this.sortedData.length === 0) return [];
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const pageItems = this.sortedData.slice(startIndex, startIndex + this.itemsPerPage);
            if (pageItems.length === 0 && this.sortedData.length > 0) {
                return this.sortedData.slice(0, this.itemsPerPage).map((item, idx) => ({ ...item, id: startIndex + idx + 1 }));
            }
            return pageItems;
        },
        get startItem() { return this.totalItems === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1; },
        get endItem() { return Math.min(this.currentPage * this.itemsPerPage, this.totalItems); },
        get isAllSelected() {
            return this.paginatedData.length > 0 && this.paginatedData.every((item) => this.selectedIds.includes(item.id));
        },
        get pages() {
            const current = this.currentPage;
            const total = this.totalPages;
            if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
            if (current <= 3) return [1, 2, 3, 'ellipsis-end', total - 2, total - 1, total];
            if (current >= total - 2) return [1, 2, 3, 'ellipsis-start', total - 2, total - 1, total];
            return [1, 'ellipsis-start', current - 1, current, current + 1, 'ellipsis-end', total];
        },
        handleSelectAll() {
            this.selectedIds = this.isAllSelected ? [] : this.paginatedData.map((item) => item.id);
        },
        handleSelectRow(id) {
            this.selectedIds = this.selectedIds.includes(id) ? this.selectedIds.filter((x) => x !== id) : [...this.selectedIds, id];
        },
        handleSort(field) {
            if (this.sortField === field) {
                if (this.sortDirection === 'asc') {
                    this.sortDirection = 'desc';
                } else {
                    this.sortField = null;
                    this.sortDirection = 'asc';
                }
            } else {
                this.sortField = field;
                this.sortDirection = 'asc';
            }
        },
        isAsc(field) { return this.sortField === field && this.sortDirection === 'asc'; },
        isDesc(field) { return this.sortField === field && this.sortDirection === 'desc'; },
        goTo(page) { this.currentPage = page; },
        goPrevious() { if (this.currentPage > 1) this.currentPage -= 1; },
        goNext() { if (this.currentPage < this.totalPages) this.currentPage += 1; },
        linkClass(page) { return this.currentPage === page ? this.paginationClasses.linkActive : this.paginationClasses.link; },
        prevClass() { return this.currentPage <= 1 ? this.paginationClasses.prevDisabled : this.paginationClasses.prev; },
        nextClass() { return this.currentPage >= this.totalPages ? this.paginationClasses.nextDisabled : this.paginationClasses.next; },
    }" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Card Header with Title, Description, Search, Filter & Export -->
    <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
    <div class="flex flex-col gap-0.5">
        <h3 class="text-title-sm font-medium text-gray-800 dark:text-white/90">
            Transactions
        </h3>
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Your most recent transactions list
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <!-- Search Input -->
        <div class="w-full sm:w-64 md:w-72">
            <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center border bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-11 rounded-[10px] border-gray-300 dark:border-gray-700"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium select-none group-data-[disabled=true]/input-group:opacity-50 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 ps-3 text-gray-500 dark:text-gray-400"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" @input="currentPage = 1" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-sm font-normal placeholder:text-gray-400 dark:placeholder:text-gray-500"></div>
        </div>

        <!-- Date Filter Select -->
        <div class="w-36 shrink-0 sm:w-40">
            <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u00227-days\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="selectedRange = $event.detail.value"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="default" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
     class="group/select-trigger flex w-full min-w-0 items-center justify-between gap-2 border bg-white outline-hidden transition-all duration-200 select-none hover:border-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:hover:border-gray-600 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 h-11 rounded-[10px] border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? 'Select range'">Select range</span>
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
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="7-days"     x-init="register('7-days', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('7-days') ? 'true' : 'false'" x-bind:data-state="isSelected('7-days') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('7-days')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Last 7 days</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('7-days')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                    <div role="option" tabindex="-1" data-slot="select-item" data-value="30-days"     x-init="register('30-days', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('30-days') ? 'true' : 'false'" x-bind:data-state="isSelected('30-days') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('30-days')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Last 30 days</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('30-days')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                    <div role="option" tabindex="-1" data-slot="select-item" data-value="3-months"     x-init="register('3-months', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('3-months') ? 'true' : 'false'" x-bind:data-state="isSelected('3-months') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('3-months')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Last 3 months</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('3-months')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                    <div role="option" tabindex="-1" data-slot="select-item" data-value="1-year"     x-init="register('1-year', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('1-year') ? 'true' : 'false'" x-bind:data-state="isSelected('1-year') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('1-year')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Last 1 year</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('1-year')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div>
        </div>

        <!-- Export CSV Button -->
        <button data-slot="button" type="button"  class="group/button inline-flex items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 shrink-0 rounded-[10px] border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <path
      d="M15 11.25a.75.75 0 01.75.75v1.5a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25V12a.75.75 0 011.5 0v1.5c0 .414.335.75.75.75h9a.75.75 0 00.75-.75V12a.75.75 0 01.75-.75zm-5.998-9a.744.744 0 01.547.241L13 5.937A.75.75 0 0111.938 7L9.752 4.813V12a.75.75 0 01-1.5 0V4.809l-2.19 2.19A.75.75 0 015 5.938l3.468-3.466a.745.745 0 01.532-.222z"
      fill="currentColor"
    />
  </svg>
            <span>Export CSV</span></button>
    </div>
</div>

    <!-- Table Content with horizontal ScrollArea -->
    <div data-slot="card-content"  class="p-0"><div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-full">
                <thead class="border-y border-gray-100 dark:border-gray-800">
                    <tr>
                        <!-- Order ID with Select All Checkbox -->
                        <th class="h-11 min-w-36 py-3 ps-5 text-start text-xs font-medium text-gray-500 sm:ps-6 dark:text-gray-400">
                            <div class="flex items-center gap-3">
                                <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllSelected) })"
        aria-label="Select all transactions" @change="handleSelectAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                <span>Order ID</span>
                            </div>
                        </th>

                        <!-- Sortable columns: Customer, Email, Total Amount, Due Date -->
                                                    <th class="h-11 px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 min-w-44">
                                <button
                                    type="button"
                                    class="inline-flex cursor-pointer items-center gap-1.5 font-medium transition-colors hover:text-gray-800 dark:hover:text-white"
                                    @click="handleSort('customer')"
                                >
                                    <span>Customer</span>
                                    <span class="inline-flex flex-col gap-0.5" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isAsc('customer') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isDesc('customer') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>                                    </span>
                                </button>
                            </th>
                                                    <th class="h-11 px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 min-w-56">
                                <button
                                    type="button"
                                    class="inline-flex cursor-pointer items-center gap-1.5 font-medium transition-colors hover:text-gray-800 dark:hover:text-white"
                                    @click="handleSort('email')"
                                >
                                    <span>Email</span>
                                    <span class="inline-flex flex-col gap-0.5" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isAsc('email') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isDesc('email') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>                                    </span>
                                </button>
                            </th>
                                                    <th class="h-11 px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 min-w-32">
                                <button
                                    type="button"
                                    class="inline-flex cursor-pointer items-center gap-1.5 font-medium transition-colors hover:text-gray-800 dark:hover:text-white"
                                    @click="handleSort('totalAmount')"
                                >
                                    <span>Total Amount</span>
                                    <span class="inline-flex flex-col gap-0.5" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isAsc('totalAmount') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isDesc('totalAmount') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>                                    </span>
                                </button>
                            </th>
                                                    <th class="h-11 px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400 min-w-36">
                                <button
                                    type="button"
                                    class="inline-flex cursor-pointer items-center gap-1.5 font-medium transition-colors hover:text-gray-800 dark:hover:text-white"
                                    @click="handleSort('dueDate')"
                                >
                                    <span>Due Date</span>
                                    <span class="inline-flex flex-col gap-0.5" aria-hidden="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isAsc('dueDate') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="isDesc('dueDate') ? 'text-gray-800 dark:text-white' : 'text-gray-400 dark:text-gray-600'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>                                    </span>
                                </button>
                            </th>
                        
                        <!-- Status Column -->
                        <th class="h-11 min-w-28 px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>

                        <!-- Actions Column -->
                        <th class="h-11 min-w-20 py-3 pe-5 text-end text-xs font-medium text-gray-500 sm:pe-6 dark:text-gray-400">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <tr x-show="paginatedData.length === 0" style="display: none;">
                        <td colspan="7" class="py-12 text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                            No Content
                        </td>
                    </tr>
                    <template x-for="transaction in paginatedData" :key="transaction.id">
                        <tr class="h-15 transition-colors" :class="selectedIds.includes(transaction.id) && 'bg-gray-50/50 dark:bg-white/2'">
    <!-- Checkbox + Order ID -->
    <td class="min-w-36 py-3 ps-5 sm:ps-6">
        <div class="flex items-center gap-3">
            <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(selectedIds.includes(transaction.id)) ? 'true' : 'false'"
    x-bind:data-state="Boolean(selectedIds.includes(transaction.id)) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(selectedIds.includes(transaction.id)) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(selectedIds.includes(transaction.id)) })"
        @change="handleSelectRow(transaction.id)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(selectedIds.includes(transaction.id))"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
            <span class="text-sm font-normal text-gray-800 dark:text-white/90" x-text="transaction.orderId"></span>
        </div>
    </td>

    <td class="min-w-44 px-4 py-3 text-start text-sm font-medium text-gray-800 dark:text-white/90" x-text="transaction.customer"></td>
    <td class="min-w-56 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400" x-text="transaction.email"></td>
    <td class="min-w-32 px-4 py-3 text-start text-sm font-normal text-gray-800 dark:text-white/90" x-text="transaction.totalAmount"></td>
    <td class="min-w-36 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400" x-text="transaction.dueDate"></td>

    <!-- Status -->
    <td class="min-w-28 px-4 py-3 text-start">
        <span data-slot="badge" :class="badgeClasses[transaction.status] || badgeClasses.other" x-text="transaction.status"></span>
    </td>

    <!-- Action (HorizontalDots Menu) -->
    <td class="min-w-20 py-3 pe-5 text-end sm:pe-6">
        <div class="flex items-center justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 in-data-[slot=button-group]:rounded-lg size-8 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200" type="button" x-bind:aria-label="`Actions for transaction ${transaction.orderId}`"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-44"><a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="/single-transaction"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.375c-3.34 0-6.218 1.98-7.534 4.833a1.893 1.893 0 000 1.585C3.782 13.646 6.66 15.625 10 15.625s6.218-1.98 7.535-4.832a1.893 1.893 0 000-1.585C16.218 6.354 13.34 4.375 10 4.375zM13.02 10a3.02 3.02 0 11-6.04 0 3.02 3.02 0 016.04 0z"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke="currentColor"
    />
  </svg>
                        <span>View Details</span></a>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <path
      d="M15 12v1.875c0 .621-.503 1.125-1.125 1.125h-9.75A1.125 1.125 0 013 13.875V12M9 12V3m-3.47 5.532L9 11.998l3.468-3.466"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        <span>Download Receipt</span></div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400"><svg class="size-4" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                        <span>Delete</span></div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
                    </template>
                </tbody>
            </table></div>
    </div>
</div></div>

    <!-- Card Footer - Responsive Pagination -->
    <div class="flex flex-col gap-4 border-t border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
    <!-- Items count summary -->
    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
        Showing
        <span class="font-medium text-gray-800 dark:text-white/90"><span x-text="startItem"></span> to <span x-text="endItem"></span></span>
        of
        <span class="font-medium text-gray-800 dark:text-white/90" x-text="totalItems"></span>
    </p>

    <!-- Mobile Pagination (< sm) -->
    <div class="flex w-full items-center justify-between sm:hidden">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400" x-text="`${currentPage}/${totalPages}`"></span>

        <div class="flex items-center gap-2">
            <a href="#" aria-label="Previous page" data-slot="pagination-link" :class="prevClass()" :aria-disabled="currentPage <= 1 ? 'true' : null" @click.prevent="goPrevious()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
            </a>
            <a href="#" aria-label="Next page" data-slot="pagination-link" :class="nextClass()" :aria-disabled="currentPage >= totalPages ? 'true' : null" @click.prevent="goNext()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </a>
        </div>
    </div>

    <!-- Desktop Pagination (>= sm) -->
    <div class="hidden sm:flex sm:items-center sm:justify-end">
        <nav role="navigation" aria-label="pagination" data-slot="pagination"  class="flex mx-0 w-auto justify-end"><ul data-slot="pagination-content"  class="flex items-center gap-1.5"><li data-slot="pagination-item"><a href="#" aria-label="Previous page" data-slot="pagination-link" :class="prevClass()" :aria-disabled="currentPage <= 1 ? 'true' : null" @click.prevent="goPrevious()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
                    </a></li>

                <template x-for="(item, index) in pages" :key="`${item}-${index}`">
                    <li data-slot="pagination-item"><template x-if="typeof item === 'string'">
                            <span aria-hidden="true" class="flex size-10 items-center justify-center rounded-[10px] border border-gray-200 bg-white text-sm font-medium text-gray-700 shadow-theme-xs select-none dark:border-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                ...
                            </span>
                        </template>
                        <template x-if="typeof item !== 'string'">
                            <a href="#" data-slot="pagination-link" :data-active="currentPage === item ? 'true' : 'false'" :aria-current="currentPage === item ? 'page' : null" :class="linkClass(item)" @click.prevent="goTo(item)" x-text="item"></a>
                        </template></li>
                </template>

                <li data-slot="pagination-item"><a href="#" aria-label="Next page" data-slot="pagination-link" :class="nextClass()" :aria-disabled="currentPage >= totalPages ? 'true' : null" @click.prevent="goNext()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
                    </a></li></ul></nav>
    </div>
</div></div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
