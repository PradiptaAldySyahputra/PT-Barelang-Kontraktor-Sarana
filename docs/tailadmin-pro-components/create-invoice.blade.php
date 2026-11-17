<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Create Invoice
    </h2>
    <nav>
        <ol class="flex items-center gap-1.5">
            <li>
                <a
                    class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                    href="https://laravel-demo.tailadmin.com"
                >
                    Home
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
                Create Invoice
            </li>
        </ol>
    </nav>
</div>
        <div
    x-data="{
        details: JSON.parse('{\u0022invoiceNumber\u0022:\u0022WP-3434434\u0022,\u0022customer\u0022:\u0022Jhon Deniyal\u0022,\u0022customerAddress\u0022:\u0022Enter customer address\u0022,\u0022paymentCondition\u0022:\u0022Net 15\u0022,\u0022currency\u0022:\u0022United States Dollar (USD)\u0022,\u0022issueDate\u0022:\u002211 March, 2027\u0022,\u0022dueDate\u0022:\u002216 March, 2027\u0022,\u0022additionalInfo\u0022:\u0022\u0022}'),
        items: JSON.parse('[{\u0022id\u0022:\u00221\u0022,\u0022name\u0022:\u0022Macbook pro 13\\u0022\u0022,\u0022quantity\u0022:1,\u0022unitCost\u0022:1200,\u0022discount\u0022:0,\u0022total\u0022:1200},{\u0022id\u0022:\u00222\u0022,\u0022name\u0022:\u0022Apple Watch Ultra\u0022,\u0022quantity\u0022:1,\u0022unitCost\u0022:300,\u0022discount\u0022:50,\u0022total\u0022:150},{\u0022id\u0022:\u00223\u0022,\u0022name\u0022:\u0022iPhone 15 Pro Max\u0022,\u0022quantity\u0022:2,\u0022unitCost\u0022:800,\u0022discount\u0022:0,\u0022total\u0022:1600},{\u0022id\u0022:\u00224\u0022,\u0022name\u0022:\u0022iPad Pro 3rd Gen\u0022,\u0022quantity\u0022:1,\u0022unitCost\u0022:900,\u0022discount\u0022:0,\u0022total\u0022:900}]'),
        paymentConditions: JSON.parse('[{\u0022value\u0022:\u0022Net 15\u0022,\u0022label\u0022:\u0022Net 15\u0022},{\u0022value\u0022:\u0022Net 30\u0022,\u0022label\u0022:\u0022Net 30\u0022},{\u0022value\u0022:\u0022Net 60\u0022,\u0022label\u0022:\u0022Net 60\u0022},{\u0022value\u0022:\u0022Due on receipt\u0022,\u0022label\u0022:\u0022Due on receipt\u0022}]'),
        currencies: JSON.parse('[{\u0022value\u0022:\u0022United States Dollar (USD)\u0022,\u0022label\u0022:\u0022United States Dollar (USD)\u0022},{\u0022value\u0022:\u0022Euro (EUR)\u0022,\u0022label\u0022:\u0022Euro (EUR)\u0022},{\u0022value\u0022:\u0022British Pound (GBP)\u0022,\u0022label\u0022:\u0022British Pound (GBP)\u0022},{\u0022value\u0022:\u0022Canadian Dollar (CAD)\u0022,\u0022label\u0022:\u0022Canadian Dollar (CAD)\u0022}]'),
        formatCurrency(val) {
            return '$' + Number(val).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
        },
        get subtotal() { return this.items.reduce((acc, item) => acc + item.total, 0); },
        get vat() { return this.subtotal * 0.1; },
        get total() { return this.subtotal + this.vat; },
        handleAddItem(newItem) {
            const rawTotal = newItem.quantity * newItem.unitCost;
            const discountedTotal = rawTotal - (rawTotal * newItem.discount) / 100;
            this.items = [...this.items, { ...newItem, id: Date.now().toString(), total: Math.round(discountedTotal) }];
        },
        handleRemoveItem(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    }"
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"
>
    <!-- Topbar -->
    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
        <h2 class="text-title-sm font-medium text-gray-800 dark:text-white/90">Create Invoice</h2>
    </div>

    <!-- Invoice Meta Section -->
    <div class="space-y-5 p-6 sm:p-8">
    <!-- Row 1: Invoice Number & Customer -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="invoice-number"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Invoice Number</label>
        <input data-slot="input" id="invoice-number" x-model="details.invoiceNumber" placeholder="WP-3434434" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>

    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="customer-name"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Customer</label>
        <input data-slot="input" id="customer-name" x-model="details.customer" placeholder="Jhon Deniyal" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>
</div>

    <!-- Row 2: Customer Address -->
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="customer-address"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Customer Address</label>
    <input data-slot="input" id="customer-address" x-model="details.customerAddress" placeholder="Enter customer address" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>

    <!-- Row 3: Payment Condition & Currency -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Payment Condition</label>
        <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u0022Net 15\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="details.paymentCondition = $event.detail.value"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="default" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
     class="group/select-trigger flex w-full min-w-0 items-center justify-between gap-2 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-3.5 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-all duration-200 select-none hover:border-gray-400 hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:border-gray-600 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? 'Select condition'">Select condition</span>
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
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="Net 15"     x-init="register('Net 15', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Net 15') ? 'true' : 'false'" x-bind:data-state="isSelected('Net 15') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Net 15')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Net 15</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Net 15')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="Net 30"     x-init="register('Net 30', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Net 30') ? 'true' : 'false'" x-bind:data-state="isSelected('Net 30') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Net 30')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Net 30</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Net 30')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="Net 60"     x-init="register('Net 60', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Net 60') ? 'true' : 'false'" x-bind:data-state="isSelected('Net 60') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Net 60')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Net 60</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Net 60')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="Due on receipt"     x-init="register('Due on receipt', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Due on receipt') ? 'true' : 'false'" x-bind:data-state="isSelected('Due on receipt') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Due on receipt')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Due on receipt</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Due on receipt')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div></div>

    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Currency</label>
        <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u0022United States Dollar (USD)\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="details.currency = $event.detail.value"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="default" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
     class="group/select-trigger flex w-full min-w-0 items-center justify-between gap-2 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-3.5 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-all duration-200 select-none hover:border-gray-400 hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:border-gray-600 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? 'Select currency'">Select currency</span>
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
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="United States Dollar (USD)"     x-init="register('United States Dollar (USD)', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('United States Dollar (USD)') ? 'true' : 'false'" x-bind:data-state="isSelected('United States Dollar (USD)') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('United States Dollar (USD)')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">United States Dollar (USD)</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('United States Dollar (USD)')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="Euro (EUR)"     x-init="register('Euro (EUR)', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Euro (EUR)') ? 'true' : 'false'" x-bind:data-state="isSelected('Euro (EUR)') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Euro (EUR)')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Euro (EUR)</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Euro (EUR)')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="British Pound (GBP)"     x-init="register('British Pound (GBP)', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('British Pound (GBP)') ? 'true' : 'false'" x-bind:data-state="isSelected('British Pound (GBP)') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('British Pound (GBP)')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">British Pound (GBP)</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('British Pound (GBP)')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                    <div role="option" tabindex="-1" data-slot="select-item" data-value="Canadian Dollar (CAD)"     x-init="register('Canadian Dollar (CAD)', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('Canadian Dollar (CAD)') ? 'true' : 'false'" x-bind:data-state="isSelected('Canadian Dollar (CAD)') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('Canadian Dollar (CAD)')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">Canadian Dollar (CAD)</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('Canadian Dollar (CAD)')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div></div>
</div>

    <!-- Row 4: Issue Date & Due Date -->
    <div
    class="grid grid-cols-1 gap-5 md:grid-cols-2"
    x-init="
        flatpickr($refs.issueInput, { mode: 'single', dateFormat: 'd F, Y', defaultDate: details.issueDate || undefined, onChange: (_d, str) => (details.issueDate = str) });
        flatpickr($refs.dueInput, { mode: 'single', dateFormat: 'd F, Y', defaultDate: details.dueDate || undefined, onChange: (_d, str) => (details.dueDate = str) });
    "
>
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="issue-date"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Issue Date</label>
        <div class="relative">
            <span class="pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            </span>
            <input data-slot="input" id="issue-date" x-ref="issueInput" value="11 March, 2027" placeholder="Select date" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 ps-11" />
        </div></div>

    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="due-date"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Due Date</label>
        <div class="relative">
            <span class="pointer-events-none absolute start-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                <svg class="size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
            </span>
            <input data-slot="input" id="due-date" x-ref="dueInput" value="16 March, 2027" placeholder="Select date" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 ps-11" />
        </div></div>
</div>

    <!-- Row 5: Additional Info -->
    <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="additional-info"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Additional Info</label>
    <textarea data-slot="textarea" id="additional-info" x-model="details.additionalInfo" placeholder="Receipt Info (optional)" class="flex w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 min-h-24 sm:min-h-32"></textarea></div>
</div>

    <!-- Divider -->
    <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch dark:bg-gray-700"></div>

    <!-- Line Items Table & Add Product -->
    <div class="p-6 sm:p-8">
    <!-- Table Container -->
    <div class="overflow-hidden rounded-xl border border-gray-100 bg-white dark:border-gray-800 dark:bg-transparent">
    <div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="w-full min-w-full text-start">
            <thead class="border-t border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50">
                <tr>
                    <th class="w-16 min-w-16 px-5 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">S.No.</th>
                    <th class="min-w-44 px-5 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Products</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Quantity</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Unit Cost</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Discount</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Total</th>
                    <th class="w-14 min-w-14 px-5 py-3 text-center"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in items" :key="item.id">
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-start text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="index + 1"></td>
                        <td class="px-5 py-4 text-start text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90" x-text="item.name"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="item.quantity"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="formatCurrency(item.unitCost)"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="item.discount + '%'"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="formatCurrency(item.total)"></td>
                        <td class="px-5 py-4 text-center">
                            <button
                                type="button"
                                class="cursor-pointer text-gray-400 transition-colors hover:text-red-500 dark:hover:text-red-400"
                                x-bind:aria-label="`Remove ${item.name}`"
                                @click="handleRemoveItem(item.id)"
                            >
                                <svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="items.length === 0" style="display: none;">
                    <td colspan="7" class="py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                        No items added yet. Fill in the form below to add products.
                    </td>
                </tr>
            </tbody>
        </table></div>
    </div>
</div>
</div>

    <!-- Add Product Form Box -->
    <div class="mt-5 rounded-xl border border-gray-100 bg-gray-50/70 p-5 sm:p-6 dark:border-gray-800 dark:bg-gray-900/40">
    <form
        class="space-y-4"
        x-data="{
            productName: '',
            price: '',
            quantity: 1,
            discount: '0',
            get isDisabled() { return !this.productName.trim() || !this.price; },
            save() {
                if (this.isDisabled) return;
                return {
                    name: this.productName.trim(),
                    quantity: this.quantity,
                    unitCost: parseFloat(String(this.price).replace(/[^0-9.]/g, '')) || 0,
                    discount: parseFloat(this.discount) || 0,
                };
            },
            reset() {
                this.productName = '';
                this.price = '';
                this.quantity = 1;
                this.discount = '0';
            },
        }"
        @submit.prevent="const item = save(); if (item) { handleAddItem(item); reset(); }"
    >
        <div class="grid grid-cols-1 items-end gap-4 sm:grid-cols-2 lg:grid-cols-12">
            <!-- Product Name -->
            <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
                <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="add-product-name"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Product Name</label>
                    <input data-slot="input" id="add-product-name" x-model="productName" placeholder="Enter product name" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>
            </div>

            <!-- Price -->
            <div class="sm:col-span-1 lg:col-span-3 xl:col-span-2">
                <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="add-product-price"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Price</label>
                    <input data-slot="input" id="add-product-price" x-model="price" placeholder="Enter product price" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" /></div>
            </div>

            <!-- Quantity -->
            <div class="sm:col-span-1 lg:col-span-2">
                <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"  for="add-product-quantity"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Quantity</label>
                    <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-11 overflow-hidden"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex cursor-text items-center justify-center gap-2 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 h-full border-e border-gray-300 p-0 dark:border-gray-700"><button type="button" data-slot="button" data-size="icon-sm" aria-label="Decrease quantity" @click="quantity = Math.max(1, quantity - 1)" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center gap-2 text-sm shadow-none p-0 has-[&gt;svg]:p-0 size-11 rounded-none text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M5 12h14" />
  </svg></button></div>

                        <input type="number" data-slot="input-group-control" id="add-product-quantity" min="1" x-model="quantity" @input="quantity = Math.max(1, parseInt(quantity) || 1)" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-center font-medium text-gray-800 [appearance:textfield] dark:text-white [&amp;::-webkit-inner-spin-button]:m-0 [&amp;::-webkit-inner-spin-button]:appearance-none [&amp;::-webkit-outer-spin-button]:m-0 [&amp;::-webkit-outer-spin-button]:appearance-none">

                        <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex cursor-text items-center justify-center gap-2 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5 h-full border-s border-gray-300 p-0 dark:border-gray-700"><button type="button" data-slot="button" data-size="icon-sm" aria-label="Increase quantity" @click="quantity += 1" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center gap-2 text-sm shadow-none p-0 has-[&gt;svg]:p-0 size-11 rounded-none text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M5 12h14M12 5v14" />
  </svg></button></div></div></div>
            </div>

            <!-- Discount -->
            <div class="sm:col-span-1 lg:col-span-2">
                <div role="group" data-slot="field" data-orientation="vertical"  class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Discount</label>
                    <div data-slot="select" data-ui-root x-data="uiSelect(JSON.parse('{\u0022value\u0022:\u00220\u0022,\u0022multiple\u0022:false}'))" class="contents" @change="discount = $event.detail.value"><button type="button" role="combobox" aria-haspopup="listbox" aria-expanded="false" data-slot="select-trigger" data-size="default" data-state="closed"
    x-ref="trigger" x-bind:id="id + '-trigger'" x-bind:aria-expanded="open ? 'true' : 'false'" x-bind:data-state="state" x-bind:data-popup-open="open ? '' : null"
    x-bind:data-placeholder="label == null ? '' : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)"
     class="group/select-trigger flex w-full min-w-0 items-center justify-between gap-2 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-3.5 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-all duration-200 select-none hover:border-gray-400 hover:bg-gray-50/50 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-invalid:border-red-500 data-invalid:ring-3 data-invalid:ring-red-500/20 data-popup-open:border-brand-300 data-popup-open:ring-3 data-popup-open:ring-brand-500/20 data-[size=default]:h-11 data-[size=default]:rounded-[10px] data-[size=lg]:h-12 data-[size=lg]:rounded-[10px] data-[size=lg]:py-3 data-[size=lg]:ps-4.5 data-[size=lg]:pe-3.5 data-[size=sm]:h-9 data-[size=sm]:rounded-lg data-[size=sm]:py-2 data-[size=sm]:ps-3.5 data-[size=sm]:pe-2.5 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:border-gray-600 dark:hover:bg-gray-800/50 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:data-popup-open:border-brand-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0">
    <span data-slot="select-value" 
    class="flex flex-1 items-center gap-2 truncate text-start text-gray-800 group-data-placeholder/select-trigger:text-gray-400 dark:text-white/90 dark:group-data-placeholder/select-trigger:text-gray-500"
    x-text="label ?? '0%'">0%</span>
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
            <div class="flex flex-col gap-1 outline-none"><div role="option" tabindex="-1" data-slot="select-item" data-value="0"     x-init="register('0', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('0') ? 'true' : 'false'" x-bind:data-state="isSelected('0') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('0')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">0%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('0')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="5"     x-init="register('5', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('5') ? 'true' : 'false'" x-bind:data-state="isSelected('5') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('5')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">5%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('5')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="10"     x-init="register('10', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('10') ? 'true' : 'false'" x-bind:data-state="isSelected('10') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('10')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">10%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('10')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="15"     x-init="register('15', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('15') ? 'true' : 'false'" x-bind:data-state="isSelected('15') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('15')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">15%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('15')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="20"     x-init="register('20', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('20') ? 'true' : 'false'" x-bind:data-state="isSelected('20') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('20')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">20%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('20')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div>
                                                            <div role="option" tabindex="-1" data-slot="select-item" data-value="50"     x-init="register('50', $el.querySelector('[data-slot=select-item-text]').textContent.trim())"
    x-bind:aria-selected="isSelected('50') ? 'true' : 'false'" x-bind:data-state="isSelected('50') ? 'checked' : 'unchecked'"
    x-on:pointermove="highlight($el)" x-on:click="pick('50')"
     class="group/select-item relative flex w-full cursor-pointer items-center gap-3 rounded-lg py-2.5 ps-3 pe-8 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/select-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/select-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5">
    <span data-slot="select-item-text" class="flex flex-1 shrink-0 items-center gap-2 whitespace-nowrap">50%</span>
    <span class="pointer-events-none absolute end-3 flex items-center justify-center text-brand-500 dark:text-brand-400" data-slot="select-item-indicator">
        <span x-show="isSelected('50')" style="display: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4">
    <path d="M20 6L9 17l-5-5" />
  </svg>
</span>
    </span>
</div></div>
        </div>
    </div>
</template></div></div>
            </div>

            <!-- Save Product Button -->
            <div class="flex items-end sm:col-span-1 lg:col-span-2">
                <button data-slot="button" type="submit" x-bind:disabled="isDisabled" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 rounded-[10px] py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full px-3 sm:px-4">Save Product</button>
            </div>
        </div>

        <div class="flex items-center gap-2 pt-1 text-gray-500 dark:text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-5 shrink-0 text-gray-400 dark:text-gray-500">
    <circle cx="12" cy="12" r="10" />
    <path d="M12 16v-4M12 8h.01" />
  </svg>
            <p class="text-sm">
                After filling in the product details, press Enter/Return or click 'Save Product' to add it to the list.
            </p>
        </div>
    </form>
</div>

    <!-- Order Summary -->
    <div class="mt-8 flex justify-end">
    <div class="w-full max-w-56 space-y-3 sm:max-w-64">
        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">Order summary</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-gray-500 dark:text-gray-400">
                <span>Subtotal</span>
                <span class="font-medium text-gray-800 dark:text-white/90" x-text="formatCurrency(subtotal)"></span>
            </div>
            <div class="flex justify-between text-gray-500 dark:text-gray-400">
                <span>Vat (10%):</span>
                <span class="font-medium text-gray-800 dark:text-white/90" x-text="formatCurrency(vat)"></span>
            </div>
            <div class="flex items-center justify-between pt-1">
                <span class="text-base font-medium text-gray-800 dark:text-white/90">Total</span>
                <span class="text-lg font-semibold text-gray-800 dark:text-white/90" x-text="formatCurrency(total)"></span>
            </div>
        </div>
    </div>
</div>
</div>

    <!-- Bottom Action Footer -->
    <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents"><div class="border-t border-gray-200 p-6 sm:p-8 dark:border-gray-800">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">
                <button data-slot="button" type="button" @click="show()" class="group/button border bg-clip-padding text-sm font-medium transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex w-full shrink-0 items-center justify-center gap-2 whitespace-nowrap sm:w-auto"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 4.375c-3.34 0-6.218 1.98-7.534 4.833a1.893 1.893 0 000 1.585C3.782 13.646 6.66 15.625 10 15.625s6.218-1.98 7.535-4.832a1.893 1.893 0 000-1.585C16.218 6.354 13.34 4.375 10 4.375zM13.02 10a3.02 3.02 0 11-6.04 0 3.02 3.02 0 016.04 0z"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke="currentColor"
    />
  </svg>
                    Preview Invoice</button>
                <button data-slot="button" type="button"  class="group/button border border-transparent bg-clip-padding text-sm font-medium transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex w-full shrink-0 items-center justify-center gap-2 whitespace-nowrap sm:w-auto"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M13.333 16.667v-3.75c0-.69-.56-1.25-1.25-1.25H7.916c-.69 0-1.25.56-1.25 1.25v3.75M10 5.833H6.666m8.75 10.834H4.583c-.69 0-1.25-.56-1.25-1.25V4.583c0-.69.56-1.25 1.25-1.25h8.234c.331 0 .649.132.883.366l2.6 2.595c.234.234.366.553.366.884v8.239c0 .69-.56 1.25-1.25 1.25z"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke="currentColor"
    />
  </svg>
                    Save Invoice</button>
            </div>
        </div>

        <!-- Invoice Preview Dialog -->
        <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 gap-4 border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-h-[90vh] overflow-y-auto rounded-2xl p-6 sm:max-w-3xl sm:p-8">
            <div class="border-b border-gray-100 pb-5 dark:border-gray-800">
    <h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-title-sm font-medium text-gray-800 dark:text-white/90">Invoice: #<span x-text="details.invoiceNumber || '34834'"></span></h2>
    <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm text-gray-500 dark:text-gray-400 sr-only">Invoice details preview for #<span x-text="details.invoiceNumber || '34834'"></span></p>
</div>
    <div class="my-2 flex flex-col gap-6 sm:flex-row sm:items-stretch sm:justify-between">
    <!-- From -->
    <div class="flex-1 space-y-4">
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">From</p>
            <h4 class="mt-1 text-base font-semibold text-gray-800 dark:text-white/90">Pimjo LLC</h4>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                1280, Clair Street,
                <br />
                Massachusetts, New York - 02543
            </p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Issued On:</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="details.issueDate || '11 March, 2027'"></p>
        </div>
    </div>

    <!-- Divider -->
    <div class="hidden w-px bg-gray-200 sm:block dark:bg-gray-800"></div>

    <!-- To -->
    <div class="flex-1 space-y-4 sm:text-end">
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">To</p>
            <h4 class="mt-1 text-base font-semibold text-gray-800 dark:text-white/90" x-text="details.customer || 'David Thompson'"></h4>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                <template x-if="details.customerAddress"><span x-text="details.customerAddress"></span></template>
                <template x-if="!details.customerAddress">
                    <span>
                        355, Shobe Lane
                        <br />
                        Colorado, Fort Collins - 80543
                    </span>
                </template>
            </p>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Due On:</p>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="details.dueDate || '16 March, 2027'"></p>
        </div>
    </div>
</div>
    <div class="mt-4 overflow-hidden rounded-xl border border-gray-100 dark:border-gray-800">
    <div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="w-full min-w-full text-start">
            <thead class="border-t border-b border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50">
                <tr>
                    <th class="w-16 min-w-16 px-5 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">S.No.</th>
                    <th class="min-w-44 px-5 py-3 text-start text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Products</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Quantity</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Unit Cost</th>
                    <th class="min-w-28 px-5 py-3 text-center text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Discount</th>
                    <th class="min-w-28 px-5 py-3 text-end text-sm font-medium whitespace-nowrap text-gray-700 dark:text-gray-300">Total</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in items" :key="item.id">
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <td class="px-5 py-4 text-start text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="index + 1"></td>
                        <td class="px-5 py-4 text-start text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90" x-text="item.name"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="item.quantity"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="formatCurrency(item.unitCost)"></td>
                        <td class="px-5 py-4 text-center text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="item.discount + '%'"></td>
                        <td class="px-5 py-4 text-end text-sm whitespace-nowrap text-gray-500 dark:text-gray-400" x-text="formatCurrency(item.total)"></td>
                    </tr>
                </template>
            </tbody>
        </table></div>
    </div>
</div>
</div>
    <div class="mt-6 flex justify-end">
    <div class="w-full max-w-56 space-y-3 sm:max-w-64">
        <h4 class="text-sm font-medium text-gray-800 dark:text-white/90">Order summary</h4>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between text-gray-500 dark:text-gray-400">
                <span>Subtotal</span>
                <span class="font-medium text-gray-800 dark:text-white/90" x-text="formatCurrency(subtotal)"></span>
            </div>
            <div class="flex justify-between text-gray-500 dark:text-gray-400">
                <span>Vat (10%):</span>
                <span class="font-medium text-gray-800 dark:text-white/90" x-text="formatCurrency(vat)"></span>
            </div>
            <div class="flex items-center justify-between pt-1">
                <span class="text-base font-medium text-gray-800 dark:text-white/90">Total</span>
                <span class="text-lg font-semibold text-gray-800 dark:text-white/90" x-text="formatCurrency(total)"></span>
            </div>
        </div>
    </div>
</div>
                            <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 in-data-[slot=button-group]:rounded-lg rounded-full text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white absolute end-3 top-3" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                        <span class="sr-only">Close</span></button>
                    </div>
    </div>
</template></div>
</div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
