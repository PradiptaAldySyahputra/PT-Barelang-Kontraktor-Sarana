<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Faq
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
                Faq
            </li>
        </ol>
    </nav>
</div>
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Faq’s 1
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="accordion" x-data="{ value: '0', collapsible: true }"  class="flex w-full flex-col space-y-4"><div data-slot="accordion-item" x-data="{ itemValue: '0', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all last:border-b dark:border-gray-800 dark:bg-white/3"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between py-3 ps-6 pe-3 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-gray-50 dark:aria-expanded:bg-white/3">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Do I get free updates?</h4>
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-transform duration-200 ease-linear group-aria-expanded/accordion-trigger:rotate-180 group-aria-expanded/accordion-trigger:text-gray-800 dark:bg-white/3 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 px-6 py-7"><p class="text-base text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '1', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all last:border-b dark:border-gray-800 dark:bg-white/3"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between py-3 ps-6 pe-3 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-gray-50 dark:aria-expanded:bg-white/3">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Which license type is suitable for me?</h4>
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-transform duration-200 ease-linear group-aria-expanded/accordion-trigger:rotate-180 group-aria-expanded/accordion-trigger:text-gray-800 dark:bg-white/3 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 px-6 py-7"><p class="text-base text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '2', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all last:border-b dark:border-gray-800 dark:bg-white/3"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between py-3 ps-6 pe-3 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-gray-50 dark:aria-expanded:bg-white/3">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Can I Customize TailAdmin to suit my needs?</h4>
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-transform duration-200 ease-linear group-aria-expanded/accordion-trigger:rotate-180 group-aria-expanded/accordion-trigger:text-gray-800 dark:bg-white/3 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 px-6 py-7"><p class="text-base text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '3', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all last:border-b dark:border-gray-800 dark:bg-white/3"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between py-3 ps-6 pe-3 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-gray-50 dark:aria-expanded:bg-white/3">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">What does Unlimited Projects mean?</h4>
                <span class="flex size-12 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-500 transition-transform duration-200 ease-linear group-aria-expanded/accordion-trigger:rotate-180 group-aria-expanded/accordion-trigger:text-gray-800 dark:bg-white/3 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 px-6 py-7"><p class="text-base text-gray-500 dark:text-gray-400">We have a 30-day refund policy. If you are not satisfied with the product, you can request a full refund within the first 30 days.</p></div>
</div></div></div>
        </div>
    </div>
</div>            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Faq’s 2
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="accordion" x-data="{ value: null, collapsible: true }"  class="flex w-full flex-col space-y-4"><div data-slot="accordion-item" x-data="{ itemValue: '0', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Do I get free updates?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '1', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Which license type is suitable for me?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '2', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">What are the Seats mentioned on pricing plans?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '3', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Can I Customize TailAdmin to suit my needs?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '4', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">What does Unlimited Projects mean?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '5', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Can I upgrade to a higher plan?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div>
            <div data-slot="accordion-item" x-data="{ itemValue: '6', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800 overflow-hidden rounded-xl border-none transition-all data-[state=open]:bg-brand-50 dark:data-[state=open]:bg-brand-500/10"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex-1 text-sm font-medium text-gray-800 outline-none focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 flex w-full cursor-pointer items-center justify-between bg-gray-100 px-6 py-4 text-start transition-colors no-underline hover:no-underline focus:outline-hidden aria-expanded:bg-brand-50 dark:bg-white/3 dark:aria-expanded:bg-brand-500/15">
        <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Are there dark and light mode options?</h4>

                <span class="flex size-7 shrink-0 items-center justify-center text-gray-500 transition-colors group-aria-expanded/accordion-trigger:text-gray-800 dark:text-gray-400 dark:group-aria-expanded/accordion-trigger:text-white/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5 group-aria-expanded/accordion-trigger:hidden">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden size-5 group-aria-expanded/accordion-trigger:inline">
    <path d="M5 12h14" />
  </svg>
                </span>
            </button>
</h3>

            <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 border-t border-brand-100 p-6 dark:border-brand-500/20"><p class="text-base text-gray-700 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum orem ipsum dolor sit amet, consectetur adipiscing elit nam fermentum, leo et lacinia accumsan.</p></div>
</div></div></div>
        </div>
    </div>
</div>            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Faq’s 3
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="accordion" x-data="{ value: '0', collapsible: true }"  class="w-full flex-col grid grid-cols-1 items-start gap-x-8 xl:grid-cols-2"><div class="border-b border-gray-200 xl:border-b-0 dark:border-gray-800">
                            <div data-slot="accordion-item" x-data="{ itemValue: '0', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex flex-1 items-center justify-between text-sm font-medium text-gray-800 transition-all outline-none hover:underline focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 gap-4 py-4 text-start">
        <div class="flex items-center gap-4 text-start">
                            <div class="shrink-0 text-gray-700 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Do I get free updates?</h4>
                        </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-slot="accordion-trigger-icon" class="pointer-events-none size-4 shrink-0 text-gray-500 transition-transform duration-200 ease-in-out group-hover/accordion-trigger:text-gray-700 group-data-[state=open]/accordion-trigger:rotate-180 dark:text-gray-400 dark:group-hover/accordion-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>
</h3>

                    <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 ps-10 pt-1 pb-4"><p class="text-base whitespace-pre-line text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.

Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></div>
</div></div>
                            <div data-slot="accordion-item" x-data="{ itemValue: '1', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex flex-1 items-center justify-between text-sm font-medium text-gray-800 transition-all outline-none hover:underline focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 gap-4 py-4 text-start">
        <div class="flex items-center gap-4 text-start">
                            <div class="shrink-0 text-gray-700 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Which license type is suitable for me?</h4>
                        </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-slot="accordion-trigger-icon" class="pointer-events-none size-4 shrink-0 text-gray-500 transition-transform duration-200 ease-in-out group-hover/accordion-trigger:text-gray-700 group-data-[state=open]/accordion-trigger:rotate-180 dark:text-gray-400 dark:group-hover/accordion-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>
</h3>

                    <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 ps-10 pt-1 pb-4"><p class="text-base whitespace-pre-line text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></div>
</div></div>
                            <div data-slot="accordion-item" x-data="{ itemValue: '2', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex flex-1 items-center justify-between text-sm font-medium text-gray-800 transition-all outline-none hover:underline focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 gap-4 py-4 text-start">
        <div class="flex items-center gap-4 text-start">
                            <div class="shrink-0 text-gray-700 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">What are the &quot;Seats&quot; mentioned on pricing plans?</h4>
                        </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-slot="accordion-trigger-icon" class="pointer-events-none size-4 shrink-0 text-gray-500 transition-transform duration-200 ease-in-out group-hover/accordion-trigger:text-gray-700 group-data-[state=open]/accordion-trigger:rotate-180 dark:text-gray-400 dark:group-hover/accordion-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>
</h3>

                    <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 ps-10 pt-1 pb-4"><p class="text-base whitespace-pre-line text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.</p></div>
</div></div>
                    </div>
            <div class="">
                            <div data-slot="accordion-item" x-data="{ itemValue: '3', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex flex-1 items-center justify-between text-sm font-medium text-gray-800 transition-all outline-none hover:underline focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 gap-4 py-4 text-start">
        <div class="flex items-center gap-4 text-start">
                            <div class="shrink-0 text-gray-700 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">Can I Customize TailAdmin to suit my needs?</h4>
                        </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-slot="accordion-trigger-icon" class="pointer-events-none size-4 shrink-0 text-gray-500 transition-transform duration-200 ease-in-out group-hover/accordion-trigger:text-gray-700 group-data-[state=open]/accordion-trigger:rotate-180 dark:text-gray-400 dark:group-hover/accordion-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>
</h3>

                    <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 ps-10 pt-1 pb-4"><p class="text-base whitespace-pre-line text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et nunc ut risus imperdiet lacinia.

Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p></div>
</div></div>
                            <div data-slot="accordion-item" x-data="{ itemValue: '4', get isOpen() { return value === this.itemValue; } }"
    x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
     class="border-b border-gray-200 last:border-b-0 dark:border-gray-800"><h3 class="flex">
    <button type="button" data-slot="accordion-trigger" x-bind:aria-expanded="isOpen ? 'true' : 'false'" aria-expanded="false" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
        x-on:click="value = (isOpen && collapsible) ? null : itemValue"
        
        class="group/accordion-trigger relative flex flex-1 items-center justify-between text-sm font-medium text-gray-800 transition-all outline-none hover:underline focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50 dark:text-white/90 dark:focus-visible:ring-brand-500/30 gap-4 py-4 text-start">
        <div class="flex items-center gap-4 text-start">
                            <div class="shrink-0 text-gray-700 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-6">
    <path d="M12 8.67h0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
    <path
      d="M12 11.215v4.224M21.25 12a9.25 9.25 0 11-18.5 0 9.25 9.25 0 0118.5 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white/90">What does &quot;Unlimited Projects&quot; mean?</h4>
                        </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" data-slot="accordion-trigger-icon" class="pointer-events-none size-4 shrink-0 text-gray-500 transition-transform duration-200 ease-in-out group-hover/accordion-trigger:text-gray-700 group-data-[state=open]/accordion-trigger:rotate-180 dark:text-gray-400 dark:group-hover/accordion-trigger:text-gray-300">
    <path
      d="M4.792 7.396L10 12.604l5.208-5.208"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>
</h3>

                    <div data-slot="accordion-content" role="region" x-show="isOpen" style="display: none;" x-bind:data-state="isOpen ? 'open' : 'closed'" data-state="closed"
    x-effect="if (isOpen) { $nextTick(() => $el.style.setProperty('--reka-accordion-content-height', $el.scrollHeight + 'px')) }"
    class="overflow-hidden text-sm data-[state=open]:animate-accordion-down">
    <div  class="text-gray-500 dark:text-gray-400 [&amp;_a]:text-brand-500 [&amp;_a]:underline [&amp;_a]:underline-offset-3 hover:[&amp;_a]:text-brand-600 dark:[&amp;_a]:text-brand-400 dark:hover:[&amp;_a]:text-brand-300 [&amp;_p:not(:last-child)]:mb-3 ps-10 pt-1 pb-4"><p class="text-base whitespace-pre-line text-gray-500 dark:text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis magna ac nibh malesuada consectetur at vitae ipsum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fermentum, leo et lacinia accumsan, ligula ante hendrerit nisi, eget vulputate ante justo et justo.</p></div>
</div></div>
                    </div></div>
        </div>
    </div>
</div>        </div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
