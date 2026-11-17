<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Tablas de Precios
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
                Tablas de Precios
            </li>
        </ol>
    </nav>
</div>
        <div class="space-y-5 sm:space-y-6">
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Pricing Table 1
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div x-data="{ isMonthly: true }" class="w-full">
    <div class="mx-auto mb-7 w-full max-w-115 text-center">
        <h2 class="text-2xl leading-tight font-bold text-gray-800 sm:text-heading-five sm:leading-10 dark:text-white/90">Flexible Plans Tailored to Fit Your Unique Needs!</h2>
    </div>

    <div class="mb-10 text-center">
        <div role="group" data-slot="button-group" data-orientation="horizontal" aria-label="Billing frequency" class="w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-e-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-s-none [&amp;&gt;[data-slot]~[data-slot]]:border-s-0 relative z-1 mx-auto inline-flex rounded-full bg-gray-200 p-1 dark:bg-gray-800"><span
                aria-hidden="true"
                class="absolute start-1 top-1/2 -z-1 flex h-11 w-30 -translate-y-1/2 rounded-full bg-white shadow-theme-xs duration-200 ease-linear dark:bg-white/10"
                :class="isMonthly ? 'translate-x-0' : 'translate-x-full rtl:-translate-x-full'"
            ></span>
            <button type="button" :aria-pressed="isMonthly" class="flex h-11 w-30 items-center justify-center rounded-full text-base font-medium transition-colors focus-visible:outline-hidden"
                :class="isMonthly ? 'text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white/70'" @click="isMonthly = true">Monthly</button>
            <button type="button" :aria-pressed="!isMonthly" class="flex h-11 w-30 items-center justify-center rounded-full text-base font-medium transition-colors focus-visible:outline-hidden"
                :class="!isMonthly ? 'text-gray-800 dark:text-white/90' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white/70'" @click="isMonthly = false">Annually</button></div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                                <div data-slot="card" data-size="default"  class="group/card flex-col border data-[size=sm]:p-4 sm:p-6 row-span-4 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-3 p-0"><div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Starter</div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-end justify-between">
                            <div class="flex items-end gap-0.5">
                                <span class="text-heading-four leading-none font-bold text-gray-800 dark:text-white/90">$<span x-text="isMonthly ? '5.99' : '40.00'">5.99</span></span>
                                <span class="pb-1 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">/<span x-text="isMonthly ? 'month' : 'year'">month</span></span>
                            </div>

                            <span class="pb-1 text-title-lg leading-none font-semibold line-through text-gray-400 dark:text-gray-500">$<span x-text="isMonthly ? '12.00' : '150.00'">12.00</span></span>
                        </div>

                        <div data-slot="card-description"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">For solo designers &amp; freelancers</div>
                    </div></div>

                <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 bg-gray-200 dark:bg-gray-800"></div>

                <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>5 website</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>500 MB Storage</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Sub-Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>3 Custom Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Free SSL Certificate</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Traffic</span>
                            </li>
                                            </ul></div>

                <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-gray-800 text-white hover:bg-brand-500 hover:text-white dark:bg-white/10 dark:text-white dark:hover:bg-brand-600">Choose Starter</button></div></div>
                                <div data-slot="card" data-size="default"  class="group/card flex-col border data-[size=sm]:p-4 sm:p-6 row-span-4 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border-gray-800 bg-gray-800 dark:border-white/10 dark:bg-white/10"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-3 p-0"><div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 dark:text-white/90 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-white">Medium</div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-end justify-between">
                            <div class="flex items-end gap-0.5">
                                <span class="text-heading-four leading-none font-bold text-white">$<span x-text="isMonthly ? '10.99' : '100.00'">10.99</span></span>
                                <span class="pb-1 text-sm leading-5 font-normal text-white/70">/<span x-text="isMonthly ? 'month' : 'year'">month</span></span>
                            </div>

                            <span class="pb-1 text-title-lg leading-none font-semibold line-through text-white/70">$<span x-text="isMonthly ? '39.00' : '250.00'">39.00</span></span>
                        </div>

                        <div data-slot="card-description"  class="dark:text-gray-400 text-sm leading-5 font-normal text-white/70">For working on commercial projects</div>
                    </div></div>

                <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 bg-white/20 dark:bg-white/10"></div>

                <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>10 website</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>1 GB Storage</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Sub-Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>5 Custom Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Free SSL Certificate</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white/80">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Traffic</span>
                            </li>
                                            </ul></div>

                <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-brand-500/20">Choose Medium</button></div></div>
                                <div data-slot="card" data-size="default"  class="group/card flex-col border data-[size=sm]:p-4 sm:p-6 row-span-4 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-3 p-0"><div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Large</div>

                    <div class="flex flex-col gap-1">
                        <div class="flex items-end justify-between">
                            <div class="flex items-end gap-0.5">
                                <span class="text-heading-four leading-none font-bold text-gray-800 dark:text-white/90">$<span x-text="isMonthly ? '15.99' : '190.00'">15.99</span></span>
                                <span class="pb-1 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">/<span x-text="isMonthly ? 'month' : 'year'">month</span></span>
                            </div>

                            <span class="pb-1 text-title-lg leading-none font-semibold line-through text-gray-400 dark:text-gray-500">$<span x-text="isMonthly ? '59.00' : '350.00'">59.00</span></span>
                        </div>

                        <div data-slot="card-description"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">For teams larger than 5 members</div>
                    </div></div>

                <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 bg-gray-200 dark:bg-gray-800"></div>

                <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>15 website</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>10 GB Storage</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Sub-Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>10 Custom Domain</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Free SSL Certificate</span>
                            </li>
                                                    <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">
                                <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                <span>Unlimited Traffic</span>
                            </li>
                                            </ul></div>

                <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-gray-800 text-white hover:bg-brand-500 hover:text-white dark:bg-white/10 dark:text-white dark:hover:bg-brand-600">Choose Large</button></div></div>
            </div>
</div>
        </div>
    </div>
</div>            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Pricing Table 2
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 grid grid-rows-subgrid row-span-4 gap-6 rounded-2xl p-6 sm:p-8 transition-all border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-0 p-0"><div class="flex items-start justify-between">
                    <div class="flex flex-col gap-3">
                        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Personal</div>

                        <div class="flex flex-col gap-1">
                            <div class="flex items-end gap-1">
                                <span class="text-heading-four font-bold leading-none text-gray-800 dark:text-white/90">$59.00</span>
                                <span class="pb-1 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">/ Lifetime</span>
                            </div>

                            <div data-slot="card-description"  class="text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">For solo designers &amp; freelancers</div>
                        </div>
                    </div>

                                            <div class="flex size-14 shrink-0 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg class="size-7" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M16.25 16.199s.105-5.417-6.25-5.417S3.75 16.2 3.75 16.2m9.302-10.912a2.995 2.995 0 11-5.991 0 2.995 2.995 0 015.99 0z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </div>
                                    </div></div>

            <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 dark:bg-gray-800"></div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>5 website</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>500 MB Storage</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Sub-Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>3 Custom Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-400 dark:text-gray-600">
                                                            <svg class="size-4 shrink-0 text-gray-400 dark:text-gray-600" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.5 4.5L13.5 13.5M13.5 4.5L4.5 13.5"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Free SSL Certificate</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-400 dark:text-gray-600">
                                                            <svg class="size-4 shrink-0 text-gray-400 dark:text-gray-600" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.5 4.5L13.5 13.5M13.5 4.5L4.5 13.5"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Traffic</span>
                        </li>
                                    </ul></div>

            <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-gray-800 text-white hover:bg-brand-500 hover:text-white dark:bg-white/10 dark:text-white dark:hover:bg-brand-600">Choose This Plan</button></div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 grid grid-rows-subgrid row-span-4 gap-6 rounded-2xl p-6 sm:p-8 transition-all border-2 border-brand-500 bg-white dark:border-brand-500 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-0 p-0"><div class="flex items-start justify-between">
                    <div class="flex flex-col gap-3">
                        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Professional</div>

                        <div class="flex flex-col gap-1">
                            <div class="flex items-end gap-1">
                                <span class="text-heading-four font-bold leading-none text-gray-800 dark:text-white/90">$199.00</span>
                                <span class="pb-1 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">/ Lifetime</span>
                            </div>

                            <div data-slot="card-description"  class="text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">For solo designers &amp; freelancers</div>
                        </div>
                    </div>

                                            <div class="flex size-14 shrink-0 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg class="size-7" width="29" height="28" viewBox="0 0 29 28" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M12.297 3.555c-1.472 0-2.666 1.193-2.666 2.666v.888H6.295c-1.473 0-2.666 1.194-2.666 2.667v10.664c0 1.472 1.193 2.666 2.666 2.666h17.181c1.473 0 2.666-1.194 2.666-2.666V9.775c0-1.473-1.193-2.666-2.666-2.666h-3.774V6.22c0-1.473-1.193-2.666-2.666-2.666H12.297zm6.518 5.332H10.52h-4.225c-.491 0-.889.398-.889.889v1.191l9.13 3.913a.965.965 0 00.7 0l9.129-3.913V9.776c0-.491-.398-.889-.889-.889h-4.661zm-.89-1.778V6.22c0-.49-.398-.888-.889-.888h-4.74c-.49 0-.888.398-.888.888v.889h6.517zm-12.519 13.33V12.9l8.43 3.613a2.032 2.032 0 002.1 0L24.364 12.9v7.54c0 .49-.398.888-.888.888H6.295c-.491 0-.889-.398-.889-.888z"
      fill="currentColor"
    />
  </svg>
                        </div>
                                    </div></div>

            <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 dark:bg-gray-800"></div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>5 website</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>500 MB Storage</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Sub-Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>3 Custom Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Free SSL Certificate</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-400 dark:text-gray-600">
                                                            <svg class="size-4 shrink-0 text-gray-400 dark:text-gray-600" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.5 4.5L13.5 13.5M13.5 4.5L4.5 13.5"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Traffic</span>
                        </li>
                                    </ul></div>

            <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-brand-500/20">Choose This Plan</button></div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 grid grid-rows-subgrid row-span-4 gap-6 rounded-2xl p-6 sm:p-8 transition-all border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="flex flex-col group-data-[size=sm]/card:gap-1 gap-0 p-0"><div class="flex items-start justify-between">
                    <div class="flex flex-col gap-3">
                        <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Enterprise</div>

                        <div class="flex flex-col gap-1">
                            <div class="flex items-end gap-1">
                                <span class="text-heading-four font-bold leading-none text-gray-800 dark:text-white/90">$599.00</span>
                                <span class="pb-1 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">/ Lifetime</span>
                            </div>

                            <div data-slot="card-description"  class="text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">For solo designers &amp; freelancers</div>
                        </div>
                    </div>

                                            <div class="flex size-14 shrink-0 items-center justify-center rounded-[10.5px] bg-brand-50 text-brand-500 dark:bg-brand-500/10 dark:text-brand-400">
                            <svg class="size-7"
    xmlns="http://www.w3.org/2000/svg"
    width="24"
    height="24"
    viewBox="0 0 24 24"
    fill="none"
  >
    <path
      d="M14.63 4.095l1.499-1.5m3.492 4.993l1.5-1.5m-4.62.38l4.395-4.396m-9.734 2.145l2.6 5.266 5.811.845-4.206 4.1.993 5.788-5.198-2.733-5.199 2.733.993-5.788-4.206-4.1 5.812-.845 2.6-5.266z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        </div>
                                    </div></div>

            <div role="none" data-slot="separator" data-orientation="horizontal" 
    class="shrink-0 bg-gray-200 data-[orientation=horizontal]:h-px data-[orientation=horizontal]:w-full data-[orientation=vertical]:w-px data-[orientation=vertical]:self-stretch my-0 dark:bg-gray-800"></div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>5 website</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>500 MB Storage</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Sub-Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>3 Custom Domain</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Free SSL Certificate</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm font-normal leading-5 text-gray-700 dark:text-gray-300">
                                                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                                                        <span>Unlimited Traffic</span>
                        </li>
                                    </ul></div>

            <div data-slot="card-footer"  class="flex items-center border-t border-gray-100 dark:border-gray-800 border-none p-0 pt-2"><button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-gray-800 text-white hover:bg-brand-500 hover:text-white dark:bg-white/10 dark:text-white dark:hover:bg-brand-600">Choose This Plan</button></div></div>
    </div>
        </div>
    </div>
</div>            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Pricing Table 3
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 sm:p-6 relative row-span-3 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="group-data-[size=sm]/card:gap-1 flex flex-col justify-between gap-5 p-0"><div class="flex flex-col gap-1">
                    <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Personal</div>
                    <div data-slot="card-description"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">Perfect plan for Starters</div>
                </div>

                <div class="flex flex-col gap-0.5">
                    <span class="text-heading-five leading-none font-bold text-gray-800 dark:text-white/90">Free</span>
                    <span class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">For a Lifetime</span>
                </div></div>

            <div class="w-full">
                <button data-slot="button" type="button" disabled="disabled" class="group/button inline-flex shrink-0 items-center justify-center bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors cursor-not-allowed border border-gray-300 bg-white text-gray-400 opacity-60 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400">Current Plan</button>
            </div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Unlimited Projects</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Share with 5 team members</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Sync across devices</span>
                        </li>
                                    </ul></div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 sm:p-6 relative row-span-3 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="group-data-[size=sm]/card:gap-1 flex flex-col justify-between gap-5 p-0"><div class="flex flex-col gap-1">
                    <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Professional</div>
                    <div data-slot="card-description"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">For users who want to do more</div>
                </div>

                <div class="flex flex-col gap-0.5">
                    <span class="text-heading-five leading-none font-bold text-gray-800 dark:text-white/90">$99</span>
                    <span class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">/year</span>
                </div></div>

            <div class="w-full">
                <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-brand-500/20">Try for Free</button>
            </div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Unlimited Projects</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Share with 5 team members</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Sync across devices</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>30 days version history</span>
                        </li>
                                    </ul></div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex-col border data-[size=sm]:p-4 sm:p-6 dark:border-gray-800 relative row-span-3 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border-transparent bg-brand-500 text-white shadow-theme-xs dark:bg-brand-500"><div class="absolute end-4 top-4 rounded-lg bg-white/10 px-3 py-1 text-xs font-medium text-white">Recommended</div>
            
            <div data-slot="card-header"  class="group-data-[size=sm]/card:gap-1 flex flex-col justify-between gap-5 p-0"><div class="flex flex-col gap-1">
                    <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 dark:text-white/90 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-white">Team</div>
                    <div data-slot="card-description"  class="dark:text-gray-400 text-sm leading-5 font-normal text-white/90">Your entire team in one place</div>
                </div>

                <div class="flex flex-col gap-0.5">
                    <span class="text-heading-five leading-none font-bold text-white">$299</span>
                    <span class="text-sm leading-5 font-normal text-white/90">/year</span>
                </div></div>

            <div class="w-full">
                <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-white text-gray-800 hover:bg-gray-50 dark:bg-white dark:text-black">Try for Free</button>
            </div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white">
                            <svg class="size-4 shrink-0 text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Unlimited Projects</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white">
                            <svg class="size-4 shrink-0 text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Share with 5 team members</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white">
                            <svg class="size-4 shrink-0 text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Sync across devices</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white">
                            <svg class="size-4 shrink-0 text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Sharing permissions</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-white">
                            <svg class="size-4 shrink-0 text-white" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Admin tools</span>
                        </li>
                                    </ul></div></div>
                    <div data-slot="card" data-size="default"  class="group/card flex-col data-[size=sm]:p-4 sm:p-6 relative row-span-3 grid grid-rows-subgrid gap-6 rounded-2xl p-6 transition-all border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="group-data-[size=sm]/card:gap-1 flex flex-col justify-between gap-5 p-0"><div class="flex flex-col gap-1">
                    <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-title-lg font-semibold text-gray-800 dark:text-white/90">Enterprise</div>
                    <div data-slot="card-description"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">Run your company on your terms</div>
                </div>

                <div class="flex flex-col gap-0.5">
                    <span class="text-heading-five leading-none font-bold text-gray-800 dark:text-white/90">Custom</span>
                    <span class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">Reach out for a quote</span>
                </div></div>

            <div class="w-full">
                <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] text-sm font-medium shadow-theme-xs transition-colors bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-brand-500/20">Try for Free</button>
            </div>

            <div data-slot="card-content"  class="p-0"><ul class="space-y-3">
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Unlimited Projects</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Share with 5 team members</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Sync across devices</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>User provisioning (SCIM)</span>
                        </li>
                                            <li class="flex items-center gap-3 text-sm leading-5 font-normal text-gray-700 dark:text-gray-300">
                            <svg class="size-4 shrink-0 text-green-500" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M3.75 9.75L6.75 12.75L14.25 5.25"
      stroke="currentColor"
      stroke-width="1.8"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                            <span>Advanced security</span>
                        </li>
                                    </ul></div></div>
    </div>
        </div>
    </div>
</div>        </div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
