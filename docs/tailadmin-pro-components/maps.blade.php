<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Mapas
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
                Mapas
            </li>
        </ol>
    </nav>
</div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Map View
        </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Clear view of locations at a glance
            </p>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="relative z-0 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800" x-data>
        <!-- Visually hidden description for screen readers -->
        <p id="mapLocationView1Desc" class="sr-only">
            Interactive map showing the Washington D.C. metro area. Use arrow keys to pan and plus/minus
            keys to zoom.
        </p>
        <div
            id="mapLocationView1"
            data-others-map="maplibre"
            class="h-75 w-full"
            role="application"
            aria-label="Interactive location map"
            aria-describedby="mapLocationView1Desc"
            tabindex="0"
        ></div>

        <div class="absolute end-3 bottom-3 z-999">
    <div role="group" data-slot="button-group" data-orientation="vertical" aria-label="Zoom controls" class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 flex-col [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-b-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-t-none [&amp;&gt;[data-slot]~[data-slot]]:border-t-0 h-fit"><button data-slot="button" type="button" aria-label="Zoom in" x-on:click="$dispatch('map-zoom', { target: 'mapLocationView1', direction: 'in' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5v14" />
            </svg></button>
        <button data-slot="button" type="button" aria-label="Zoom out" x-on:click="$dispatch('map-zoom', { target: 'mapLocationView1', direction: 'out' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
            </svg></button></div>
</div>
    </div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Google Maps Location
        </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Find our physical location and headquarters on Google Maps
            </p>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="relative overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800">
        <iframe
            title="Google Maps office location"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1333.6584656966136!2d-4.6945960082501195!3d54.220715631170634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4863930029caaac3%3A0xec55feecc664402b!2sWest%20View%20Park!5e1!3m2!1sen!2sbd!4v1793599797008!5m2!1sen!2sbd"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            class="h-75 w-full border-0 grayscale"
        ></iframe>
    </div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Washington D.C. Region
        </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Interactive map with Home and Office Pinned
            </p>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="relative z-0 overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800" x-data>
        <!-- Visually hidden description for screen readers -->
        <p id="mapLocationView3Desc" class="sr-only">
            Interactive map showing the Washington D.C. region with Home and Office pinned. Use arrow
            keys to pan and plus/minus keys to zoom.
        </p>
        <div
            id="mapLocationView3"
            data-others-map="leaflet"
            class="h-75 w-full"
            role="application"
            aria-label="Interactive Leaflet location map"
            aria-describedby="mapLocationView3Desc"
            tabindex="0"
        ></div>

        <div class="absolute end-3 bottom-3 z-999">
    <div role="group" data-slot="button-group" data-orientation="vertical" aria-label="Zoom controls" class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 flex-col [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-b-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-t-none [&amp;&gt;[data-slot]~[data-slot]]:border-t-0 h-fit"><button data-slot="button" type="button" aria-label="Zoom in" x-on:click="$dispatch('map-zoom', { target: 'mapLocationView3', direction: 'in' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5v14" />
            </svg></button>
        <button data-slot="button" type="button" aria-label="Zoom out" x-on:click="$dispatch('map-zoom', { target: 'mapLocationView3', direction: 'out' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white dark:bg-gray-800"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
            </svg></button></div>
</div>
    </div>
        </div>
    </div>
</div>    </div>
            </div>
        </div>

    </div>

</body>


</html>
