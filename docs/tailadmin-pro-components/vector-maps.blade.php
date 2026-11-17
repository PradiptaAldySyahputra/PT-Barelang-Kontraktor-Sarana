<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Mapa Vectorial
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
                Mapa Vectorial
            </li>
        </ol>
    </nav>
</div>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3">
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Global User Distribution</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Track active users and customer locations worldwide</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
        <div
            data-others-map="vector-map"
            data-config="{&quot;map&quot;:&quot;world&quot;,&quot;regionStyle&quot;:{&quot;initial&quot;:{&quot;fill&quot;:&quot;#D9D9D9&quot;,&quot;stroke&quot;:&quot;none&quot;,&quot;strokeWidth&quot;:0,&quot;strokeOpacity&quot;:0},&quot;hover&quot;:{&quot;fillOpacity&quot;:0.7,&quot;fill&quot;:&quot;#465FFF&quot;,&quot;cursor&quot;:&quot;pointer&quot;},&quot;selected&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;},&quot;selectedHover&quot;:{}},&quot;markers&quot;:[{&quot;name&quot;:&quot;United States&quot;,&quot;coords&quot;:[37.2580397,-104.657039]},{&quot;name&quot;:&quot;India&quot;,&quot;coords&quot;:[20.7504374,73.7276105]},{&quot;name&quot;:&quot;United Kingdom&quot;,&quot;coords&quot;:[53.613,-11.6368]},{&quot;name&quot;:&quot;Australia&quot;,&quot;coords&quot;:[-25.0304388,115.2092761]}],&quot;markerStyle&quot;:{&quot;initial&quot;:{&quot;r&quot;:5,&quot;strokeWidth&quot;:1,&quot;fill&quot;:&quot;#465FFF&quot;,&quot;fillOpacity&quot;:1},&quot;hover&quot;:{&quot;fill&quot;:&quot;#3538CD&quot;,&quot;fillOpacity&quot;:1},&quot;selected&quot;:{},&quot;selectedHover&quot;:{}}}"
            class="map-btn w-full"
            style="height: 274px; direction: ltr; text-align: left"
        ></div>
    </div>
</div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3" x-data>
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Country Traffic Analytics</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Visualize traffic volume and engagement by region</p>
    </div>

    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
        <div
            data-others-map="vector-map"
            data-config="{&quot;map&quot;:&quot;world&quot;,&quot;regionStyle&quot;:{&quot;initial&quot;:{&quot;fill&quot;:&quot;#C5D8FF&quot;,&quot;fillOpacity&quot;:1,&quot;stroke&quot;:&quot;white&quot;,&quot;strokeWidth&quot;:0.5,&quot;strokeOpacity&quot;:1},&quot;hover&quot;:{&quot;fillOpacity&quot;:0.8,&quot;fill&quot;:&quot;#465FFF&quot;,&quot;cursor&quot;:&quot;pointer&quot;},&quot;selected&quot;:{&quot;fill&quot;:&quot;#3538CD&quot;},&quot;selectedHover&quot;:{}}}"
            class="map-btn w-full"
            id="mapTrafficAnalytics"
            role="application"
            aria-label="Country traffic analytics map"
            style="height: 274px; direction: ltr; text-align: left"
        ></div>

        <div class="absolute end-3 bottom-3 z-10">
    <div role="group" data-slot="button-group" data-orientation="vertical" aria-label="Zoom controls" class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 flex-col [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-b-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-t-none [&amp;&gt;[data-slot]~[data-slot]]:border-t-0 h-fit"><button data-slot="button" type="button" aria-label="Zoom in" x-on:click="$dispatch('map-zoom', { target: 'mapTrafficAnalytics', direction: 'in' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5v14" />
            </svg></button>
        <button data-slot="button" type="button" aria-label="Zoom out" x-on:click="$dispatch('map-zoom', { target: 'mapTrafficAnalytics', direction: 'out' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
            </svg></button></div>
</div>
    </div>
</div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6 dark:border-gray-800 dark:bg-white/3" x-data>
    <div class="mb-5">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">US Customer Heatmap</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Analyze customer density and regional performance</p>
    </div>

    <div class="relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
        <div
            data-others-map="vector-map"
            data-config="{&quot;map&quot;:&quot;us_aea_en&quot;,&quot;regionStyle&quot;:{&quot;initial&quot;:{&quot;fill&quot;:&quot;#C5D8FF&quot;,&quot;fillOpacity&quot;:1,&quot;stroke&quot;:&quot;white&quot;,&quot;strokeWidth&quot;:2,&quot;strokeOpacity&quot;:1},&quot;hover&quot;:{&quot;fillOpacity&quot;:0.8,&quot;fill&quot;:&quot;#465FFF&quot;,&quot;cursor&quot;:&quot;pointer&quot;},&quot;selected&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;},&quot;selectedHover&quot;:{}},&quot;markers&quot;:[{&quot;name&quot;:&quot;Los Angeles&quot;,&quot;coords&quot;:[34.05,-118.24]},{&quot;name&quot;:&quot;New York&quot;,&quot;coords&quot;:[40.71,-74]},{&quot;name&quot;:&quot;Chicago&quot;,&quot;coords&quot;:[41.87,-87.62]},{&quot;name&quot;:&quot;Houston&quot;,&quot;coords&quot;:[29.76,-95.36]},{&quot;name&quot;:&quot;Denver&quot;,&quot;coords&quot;:[39.73,-104.99]},{&quot;name&quot;:&quot;Seattle&quot;,&quot;coords&quot;:[47.6,-122.33]},{&quot;name&quot;:&quot;Miami&quot;,&quot;coords&quot;:[25.76,-80.19]},{&quot;name&quot;:&quot;Atlanta&quot;,&quot;coords&quot;:[33.74,-84.38]},{&quot;name&quot;:&quot;Philadelphia&quot;,&quot;coords&quot;:[39.95,-75.16]},{&quot;name&quot;:&quot;Boston&quot;,&quot;coords&quot;:[42.36,-71.05]},{&quot;name&quot;:&quot;Nashville&quot;,&quot;coords&quot;:[36.16,-86.78]},{&quot;name&quot;:&quot;Dallas&quot;,&quot;coords&quot;:[32.77,-96.79]},{&quot;name&quot;:&quot;Minneapolis&quot;,&quot;coords&quot;:[44.97,-93.26]},{&quot;name&quot;:&quot;Washington D.C.&quot;,&quot;coords&quot;:[38.9,-77.03]},{&quot;name&quot;:&quot;San Francisco&quot;,&quot;coords&quot;:[37.77,-122.41]},{&quot;name&quot;:&quot;Las Vegas&quot;,&quot;coords&quot;:[36.1,-115.17]},{&quot;name&quot;:&quot;Phoenix&quot;,&quot;coords&quot;:[33.44,-112.07]},{&quot;name&quot;:&quot;San Antonio&quot;,&quot;coords&quot;:[29.42,-98.49]}],&quot;markerStyle&quot;:{&quot;initial&quot;:{&quot;fill&quot;:&quot;#465FFF&quot;,&quot;stroke&quot;:&quot;white&quot;,&quot;strokeWidth&quot;:2,&quot;r&quot;:5},&quot;hover&quot;:{&quot;fill&quot;:&quot;#3538CD&quot;},&quot;selected&quot;:{},&quot;selectedHover&quot;:{}}}"
            class="map-btn w-full"
            id="mapCustomerPinPoint"
            role="application"
            aria-label="US customer heatmap"
            style="height: 274px; direction: ltr; text-align: left"
        ></div>

        <div class="absolute end-3 bottom-3 z-10">
    <div role="group" data-slot="button-group" data-orientation="vertical" aria-label="Zoom controls" class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 flex-col [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-b-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-t-none [&amp;&gt;[data-slot]~[data-slot]]:border-t-0 h-fit"><button data-slot="button" type="button" aria-label="Zoom in" x-on:click="$dispatch('map-zoom', { target: 'mapCustomerPinPoint', direction: 'in' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5v14" />
            </svg></button>
        <button data-slot="button" type="button" aria-label="Zoom out" x-on:click="$dispatch('map-zoom', { target: 'mapCustomerPinPoint', direction: 'out' })" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] bg-white"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
            </svg></button></div>
</div>
    </div>
</div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
