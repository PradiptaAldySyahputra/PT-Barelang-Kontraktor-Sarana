<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Lista de Tickets
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
                Lista de Tickets
            </li>
        </ol>
    </nav>
</div>
    <div
    class="space-y-6"
    x-data="tanstackTable('ticket-list', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:\u0022#323534\u0022,\u0022name\u0022:\u0022Lindsey Curtis\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Issue with Dashboard Login Access\u0022,\u0022date\u0022:\u002212 Feb, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022General Support\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022},{\u0022id\u0022:\u0022#323535\u0022,\u0022name\u0022:\u0022Kaiya George\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Billing Information Not Updating Properly\u0022,\u0022date\u0022:\u002213 Mar, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Billing \\u0026 Account\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022},{\u0022id\u0022:\u0022#323536\u0022,\u0022name\u0022:\u0022Zain Geidt\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Bug Found in Dark Mode Layout\u0022,\u0022date\u0022:\u002219 Mar, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022},{\u0022id\u0022:\u0022#323537\u0022,\u0022name\u0022:\u0022Abram Schleifer\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Request to Add New Integration Feature\u0022,\u0022date\u0022:\u002225 Apr, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022Feature Request\u0022,\u0022priority\u0022:\u0022Low\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022},{\u0022id\u0022:\u0022#323538\u0022,\u0022name\u0022:\u0022Carla George\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Slow Loading Time on Analytics Page\u0022,\u0022date\u0022:\u002211 May, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022},{\u0022id\u0022:\u0022#323539\u0022,\u0022name\u0022:\u0022Emery Culhane\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Unable to Save Changes in Settings\u0022,\u0022date\u0022:\u002229 Jun, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022General Support\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-34.jpg\u0022},{\u0022id\u0022:\u0022#323540\u0022,\u0022name\u0022:\u0022Livia Donin\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Mobile View Not Displaying Correctly\u0022,\u0022date\u0022:\u002222 Jul, 2027\u0022,\u0022status\u0022:\u0022In Progress\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-35.jpg\u0022},{\u0022id\u0022:\u0022#323541\u0022,\u0022name\u0022:\u0022Miracle Bator\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Component Missing from UI Library\u0022,\u0022date\u0022:\u002205 Aug, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022Feature Request\u0022,\u0022priority\u0022:\u0022Low\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-36.jpg\u0022},{\u0022id\u0022:\u0022#323542\u0022,\u0022name\u0022:\u0022Lincoln Herwitz\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Getting Error 500 on User Profile Page\u0022,\u0022date\u0022:\u002209 Sep, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022},{\u0022id\u0022:\u0022#323543\u0022,\u0022name\u0022:\u0022Ekstrom Bothman\u0022,\u0022email\u0022:\u0022demoemail@gmail.com\u0022,\u0022subject\u0022:\u0022Need Help with Customizing Sidebar Navigation\u0022,\u0022date\u0022:\u002215 Nov, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022General Support\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022},{\u0022id\u0022:\u0022#323544\u0022,\u0022name\u0022:\u0022Sophia Martinez\u0022,\u0022email\u0022:\u0022sophia.m@example.com\u0022,\u0022subject\u0022:\u0022How to Configure Webhook Endpoints for Payments\u0022,\u0022date\u0022:\u002228 Nov, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Billing \\u0026 Account\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022},{\u0022id\u0022:\u0022#323545\u0022,\u0022name\u0022:\u0022Marcus Chen\u0022,\u0022email\u0022:\u0022marcus.chen@example.com\u0022,\u0022subject\u0022:\u0022Chart Tooltip Display Misaligned on Safari\u0022,\u0022date\u0022:\u002204 Dec, 2027\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022Low\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022},{\u0022id\u0022:\u0022#323546\u0022,\u0022name\u0022:\u0022Elena Rostova\u0022,\u0022email\u0022:\u0022elena.r@example.com\u0022,\u0022subject\u0022:\u0022Translation strings missing in Spanish locale\u0022,\u0022date\u0022:\u002215 Dec, 2027\u0022,\u0022status\u0022:\u0022In Progress\u0022,\u0022category\u0022:\u0022General Support\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022},{\u0022id\u0022:\u0022#323547\u0022,\u0022name\u0022:\u0022James Wilson\u0022,\u0022email\u0022:\u0022j.wilson@example.com\u0022,\u0022subject\u0022:\u0022Dark theme contrast issue on high-res monitors\u0022,\u0022date\u0022:\u002222 Dec, 2027\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-34.jpg\u0022},{\u0022id\u0022:\u0022#323548\u0022,\u0022name\u0022:\u0022Amina Al-Mansoor\u0022,\u0022email\u0022:\u0022amina.al@example.com\u0022,\u0022subject\u0022:\u0022RTL layout inversion for date picker popup\u0022,\u0022date\u0022:\u002205 Jan, 2028\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022General Support\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-35.jpg\u0022},{\u0022id\u0022:\u0022#323549\u0022,\u0022name\u0022:\u0022Lucas Vance\u0022,\u0022email\u0022:\u0022lucas.v@example.com\u0022,\u0022subject\u0022:\u0022Need custom permission roles for team members\u0022,\u0022date\u0022:\u002212 Jan, 2028\u0022,\u0022status\u0022:\u0022Pending\u0022,\u0022category\u0022:\u0022Feature Request\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-36.jpg\u0022},{\u0022id\u0022:\u0022#323550\u0022,\u0022name\u0022:\u0022Chloe Dupont\u0022,\u0022email\u0022:\u0022chloe.d@example.com\u0022,\u0022subject\u0022:\u0022Invoice PDF download triggers 403 Forbidden\u0022,\u0022date\u0022:\u002218 Jan, 2028\u0022,\u0022status\u0022:\u0022Solved\u0022,\u0022category\u0022:\u0022Billing \\u0026 Account\u0022,\u0022priority\u0022:\u0022High\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022},{\u0022id\u0022:\u0022#323551\u0022,\u0022name\u0022:\u0022David Kim\u0022,\u0022email\u0022:\u0022david.kim@example.com\u0022,\u0022subject\u0022:\u0022Request for multi-factor authentication setup guide\u0022,\u0022date\u0022:\u002226 Jan, 2028\u0022,\u0022status\u0022:\u0022In Progress\u0022,\u0022category\u0022:\u0022Technical Issue\u0022,\u0022priority\u0022:\u0022Medium\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022}]}'))"
>
    <!-- 3 Metric Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
    <!-- Total Tickets -->
    <div class="flex items-center gap-5 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
        <div class="flex size-14 shrink-0 items-center justify-center rounded-lg bg-brand-500/10 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
            <svg class="size-7" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.95833 6.125C3.99184 6.125 3.20833 6.9085 3.20833 7.875V11.2998C4.69996 11.2998 5.9098 12.509 5.9098 14.0006C5.9098 15.4923 4.7006 16.7015 3.20897 16.7015L3.20833 20.125C3.20833 21.0915 3.99184 21.875 4.95833 21.875H23.0417C24.0082 21.875 24.7917 21.0915 24.7917 20.125V16.7015C23.3003 16.7011 22.0915 15.4921 22.0915 14.0006C22.0915 12.5092 23.3003 11.3001 24.7917 11.2998V7.875C24.7917 6.9085 24.0082 6.125 23.0417 6.125H4.95833Z"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        </div>
        <div>
            <h4 class="text-2xl leading-8 font-semibold text-gray-800 dark:text-white/90">5,347</h4>
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total tickets</p>
        </div>
    </div>

    <!-- Pending Tickets -->
    <div class="flex items-center gap-5 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
        <div class="flex size-14 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-amber-500 dark:bg-amber-500/15 dark:text-amber-400">
            <svg class="size-7" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.66667 4.66667H23.3333M4.66667 23.3333L23.3333 23.3333M21 4.66667V7.00002C21 10.866 17.866 14 14 14M7 4.66667V7.00002C7 10.866 10.134 14 14 14M14 14C17.866 14 21 17.134 21 21V23.3333M14 14C10.134 14 7 17.134 7 21L7 23.3333"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        </div>
        <div>
            <h4 class="text-2xl leading-8 font-semibold text-gray-800 dark:text-white/90">1,230</h4>
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Pending tickets</p>
        </div>
    </div>

    <!-- Solved Tickets -->
    <div class="flex items-center gap-5 rounded-xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/3">
        <div class="flex size-14 shrink-0 items-center justify-center rounded-lg bg-green-500/10 text-green-500 dark:bg-green-500/15 dark:text-green-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-7">
    <circle cx="12" cy="12" r="10" />
    <path d="M16 9l-5.5 5.5L8 12" />
  </svg>
        </div>
        <div>
            <h4 class="text-2xl leading-8 font-semibold text-gray-800 dark:text-white/90">4,117</h4>
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Solved tickets</p>
        </div>
    </div>
</div>

    <!-- Main Table Card -->
    <div data-slot="card" data-size="default"  class="group/card flex flex-col data-[size=sm]:p-4 sm:p-6 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 shadow-xs dark:border-gray-800 dark:bg-white/3"><div class="flex flex-col gap-4 border-b border-gray-200 pb-4 lg:flex-row lg:items-center lg:justify-between dark:border-gray-800">
    <!-- Title & Description -->
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Support Tickets</h3>
        <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Your most recent support tickets list</p>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <!-- Tab filter: All, Solved, Pending -->
        <div role="group" data-slot="button-group" data-orientation="horizontal"  class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-e-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-s-none [&amp;&gt;[data-slot]~[data-slot]]:border-s-0 order-1 flex-1 gap-0.5 rounded-lg bg-gray-100 p-0.5 *:data-slot:rounded-md! dark:bg-gray-800"><button data-slot="button" type="button" @click="handleTabChange('all')" x-bind:class="selectedTab === 'all'
                        ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-900 dark:hover:text-white'
                        : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 flex-1 px-3.5 text-sm font-medium transition-colors">All</button>
                            <button data-slot="button" type="button" @click="handleTabChange('solved')" x-bind:class="selectedTab === 'solved'
                        ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-900 dark:hover:text-white'
                        : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 flex-1 px-3.5 text-sm font-medium transition-colors">Solved</button>
                            <button data-slot="button" type="button" @click="handleTabChange('pending')" x-bind:class="selectedTab === 'pending'
                        ? 'bg-white text-gray-900 shadow-theme-xs hover:bg-white hover:text-gray-900 dark:bg-gray-900 dark:text-white dark:hover:bg-gray-900 dark:hover:text-white'
                        : 'text-gray-500 hover:bg-transparent hover:text-gray-900 dark:text-gray-400 dark:hover:bg-transparent dark:hover:text-white'" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 flex-1 px-3.5 text-sm font-medium transition-colors">Pending</button></div>

        <!-- Search Input -->
        <div data-slot="input-group" role="group"  class="group/input-group relative flex min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 order-3 h-11 w-full sm:order-2 sm:w-65 md:w-75"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
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
            <input type="text" data-slot="input-group-control" placeholder="Search..." x-bind:value="searchQuery" x-on:input="searchQuery = $event.target.value; pageIndex = 0" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div>

        <!-- Filter Dropdown -->
        <div class="order-2 sm:order-3">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 cursor-pointer gap-2 rounded-[10px] px-4 text-gray-700 dark:text-gray-300" type="button" ><svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M14.6534 5.90416C14.6534 4.48435 13.5024 3.33333 12.0826 3.33333C10.6627 3.33333 9.51174 4.48435 9.51172 5.90417M14.6534 5.90416C14.6534 7.324 13.5024 8.475 12.0826 8.475C10.6627 8.475 9.51172 7.324 9.51172 5.90417M14.6534 5.90416L17.7083 5.90413M9.51172 5.90417L2.29167 5.90413M5.34662 14.0958C5.34662 12.676 6.49762 11.525 7.91745 11.525C9.33728 11.525 10.4883 12.676 10.4883 14.0958M5.34662 14.0958C5.34662 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0958M5.34662 14.0958L2.29167 14.0958M10.4883 14.0958L17.7083 14.0958"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        <span x-text="selectedCategory || 'Filter'"></span></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-48"><div role="group" data-slot="dropdown-menu-group" class="flex flex-col gap-1"><div class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase">Category</div>
                                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleCategoryFilter('All Categories')" :class="!selectedCategory ? 'bg-gray-100 font-medium text-gray-900 dark:bg-gray-800 dark:text-white' : ''" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">All Categories</div>
                                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleCategoryFilter('General Support')" :class="selectedCategory === &#039;General Support&#039; ? 'bg-gray-100 font-medium text-gray-900 dark:bg-gray-800 dark:text-white' : ''" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">General Support</div>
                                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleCategoryFilter('Technical Issue')" :class="selectedCategory === &#039;Technical Issue&#039; ? 'bg-gray-100 font-medium text-gray-900 dark:bg-gray-800 dark:text-white' : ''" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Technical Issue</div>
                                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleCategoryFilter('Billing &amp; Account')" :class="selectedCategory === &#039;Billing &amp; Account&#039; ? 'bg-gray-100 font-medium text-gray-900 dark:bg-gray-800 dark:text-white' : ''" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Billing &amp; Account</div>
                                                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleCategoryFilter('Feature Request')" :class="selectedCategory === &#039;Feature Request&#039; ? 'bg-gray-100 font-medium text-gray-900 dark:bg-gray-800 dark:text-white' : ''" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Feature Request</div></div></div>
    </div>
</template></div>
        </div>
    </div>
</div>

        <div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1">
        <div class="min-w-0"><div >
    <table class="min-w-full">
        <thead class="border-b border-gray-200 bg-gray-50/60 dark:border-gray-800 dark:bg-white/2">
            <tr>
                <!-- Ticket ID with Select All Checkbox -->
                <th class="px-4 py-3 whitespace-nowrap sm:px-6">
                    <div class="flex items-center gap-3">
                        <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllPageRowsSelected || isSomePageRowsSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllPageRowsSelected || isSomePageRowsSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllPageRowsSelected || isSomePageRowsSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllPageRowsSelected || isSomePageRowsSelected) })"
        aria-label="Select all tickets" x-on:change="handleToggleSelectAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllPageRowsSelected || isSomePageRowsSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Ticket ID </span>
                    </div>
                </th>

                <!-- Requested By (Sortable) -->
                <th class="px-4 py-3 whitespace-nowrap sm:px-6">
                    <button type="button" x-on:click="toggleSort(&#039;name&#039;)" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden cursor-pointer">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Requested By</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="sortName === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="sortName === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                </th>

                <!-- Subject -->
                <th class="px-4 py-3 whitespace-nowrap sm:px-6">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Subject </span>
                </th>

                <!-- Create Date (Sortable) -->
                <th class="px-4 py-3 whitespace-nowrap sm:px-6">
                    <button type="button" x-on:click="toggleSort(&#039;date&#039;)" class="group flex w-full items-center justify-between gap-2 text-start focus:outline-hidden cursor-pointer">
    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Create Date</span>
    <span class="flex flex-col gap-0.5" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="sortDate === 'asc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'">
  <path
    d="M3.45.213a.5.5 0 00-.819 0L.091 3.841a.5.5 0 00.41.787h5.08a.5.5 0 00.41-.787L3.45.213z"
    fill="currentColor"
  />
</svg>        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none" class="size-2 transition-colors" :class="sortDate === 'desc' ? 'text-brand-500 dark:text-brand-400' : 'text-gray-300 dark:text-gray-700 group-hover:text-gray-400 dark:group-hover:text-gray-500'">
  <path
    d="M3.45 4.415a.5.5 0 01-.819 0L.091.787A.5.5 0 01.502 0h5.08a.5.5 0 01.41.787L3.45 4.415z"
    fill="currentColor"
  />
</svg>    </span>
</button>
                </th>

                <!-- Status -->
                <th class="px-4 py-3 whitespace-nowrap sm:px-6">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400"> Status </span>
                </th>

                <!-- Action header -->
                <th class="px-4 py-3 text-end whitespace-nowrap sm:px-6">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>

        <tbody>
            <template x-if="paginatedRows.length === 0">
                <tr class="hover:bg-transparent">
    <td colspan="6" class="py-14 text-center text-sm text-gray-500 dark:text-gray-400">
        <div class="flex flex-col items-center justify-center">
            <div class="mb-3 flex size-12 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                <svg class="size-6 text-gray-700 dark:text-gray-300" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.95833 6.125C3.99184 6.125 3.20833 6.9085 3.20833 7.875V11.2998C4.69996 11.2998 5.9098 12.509 5.9098 14.0006C5.9098 15.4923 4.7006 16.7015 3.20897 16.7015L3.20833 20.125C3.20833 21.0915 3.99184 21.875 4.95833 21.875H23.0417C24.0082 21.875 24.7917 21.0915 24.7917 20.125V16.7015C23.3003 16.7011 22.0915 15.4921 22.0915 14.0006C22.0915 12.5092 23.3003 11.3001 24.7917 11.2998V7.875C24.7917 6.9085 24.0082 6.125 23.0417 6.125H4.95833Z"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </div>
            <h4 class="text-base font-semibold text-gray-800 dark:text-white/90" x-text="hasFiltersActive ? 'No tickets found' : 'No tickets available'"></h4>
            <p
                class="mt-1 max-w-sm text-sm text-gray-500 dark:text-gray-400"
                x-text="hasFiltersActive ? 'We couldn\'t find any tickets matching your search or filter criteria.' : 'There are no support tickets available at this moment.'"
            ></p>
            <template x-if="hasFiltersActive">
                <button data-slot="button" type="button" x-on:click="handleClearFilters()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-1.5 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 mt-4 h-9 rounded-lg border-gray-300 px-3.5 text-xs font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 cursor-pointer">Clear Filters</button>
            </template>
        </div>
    </td>
</tr>
            </template>
            <template x-for="ticket in paginatedRows" x-bind:key="ticket.id">
                <tr class="border-b border-gray-200 transition-colors last:border-b-0 hover:bg-gray-50/50 dark:border-gray-800 dark:hover:bg-white/2">
    <!-- Checkbox + Ticket ID -->
    <td class="px-4 py-4 whitespace-nowrap sm:px-6">
        <div class="flex items-center gap-3">
            <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(selectedRowIds.includes(ticket.id)) ? 'true' : 'false'"
    x-bind:data-state="Boolean(selectedRowIds.includes(ticket.id)) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(selectedRowIds.includes(ticket.id)) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(selectedRowIds.includes(ticket.id)) })"
        x-bind:aria-label="`Select ticket ${ticket.id}`" x-on:change="handleToggleSelectRow(ticket.id, $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(selectedRowIds.includes(ticket.id))"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
            <a
                href="https://laravel-demo.tailadmin.com/support-ticket-reply"
                class="text-sm font-medium text-gray-800 transition-colors hover:text-brand-500 hover:underline dark:text-white/90 dark:hover:text-brand-400"
                x-text="ticket.id"
            ></a>
        </div>
    </td>

    <!-- Requested By -->
    <td class="px-4 py-4 whitespace-nowrap sm:px-6">
        <div>
            <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="ticket.name"></p>
            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="ticket.email"></p>
        </div>
    </td>

    <!-- Subject -->
    <td class="px-4 py-4 sm:px-6">
        <p class="max-w-xs truncate text-sm text-gray-800 dark:text-white/90" x-text="ticket.subject"></p>
    </td>

    <!-- Create Date -->
    <td class="px-4 py-4 whitespace-nowrap sm:px-6">
        <span class="text-sm text-gray-700 dark:text-gray-400" x-text="ticket.date"></span>
    </td>

    <!-- Status -->
    <td class="px-4 py-4 whitespace-nowrap sm:px-6">
        <span data-slot="badge" data-variant="light" data-color="info" data-size="sm" x-show="ticket.status !== 'Solved' && ticket.status !== 'Pending'" x-text="ticket.status" class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-sky-50 text-sky-500 [text-shadow:0_4px_4px_var(--color-sky-200)] dark:bg-sky-500/15 dark:text-sky-500 dark:[text-shadow:0_4px_4px_rgba(11,165,236,0.20)]"></span>
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm" x-show="ticket.status === 'Solved'" x-text="ticket.status" class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]"></span>
        <span data-slot="badge" data-variant="light" data-color="warning" data-size="sm" x-show="ticket.status === 'Pending'" x-text="ticket.status" class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]"></span>
    </td>

    <!-- Actions -->
    <td class="px-4 py-4 text-end whitespace-nowrap sm:px-6">
        <div class="flex justify-end">
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg hover:bg-white" type="button" aria-label="Actions"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36"><a role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
       href="https://laravel-demo.tailadmin.com/support-ticket-reply"     x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Reply</a>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleMarkSolved(ticket.id)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Mark as Solved</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="destructive"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleDelete(ticket.id)" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Delete</div></div>
    </div>
</template></div>
        </div>
    </td>
</tr>
            </template>
        </tbody>
    </table>
</div></div>
    </div>
</div>

        <div
    x-data="{
        get currentPage() { return pageIndex + 1; },
        get startEntry() { return totalEntries === 0 ? 0 : pageIndex * pageSize + 1; },
        get endEntry() { return Math.min((pageIndex + 1) * pageSize, totalEntries); },
        get pages() {
            const total = totalPages;
            const current = this.currentPage;
            if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
            if (current <= 4) return [1, 2, 3, 4, 5, 'ellipsis-end', total];
            if (current >= total - 3) return [1, 'ellipsis-start', total - 4, total - 3, total - 2, total - 1, total];
            return [1, 'ellipsis-start', current - 1, current, current + 1, 'ellipsis-end', total];
        },
    }"
    class="flex flex-col gap-4 border-t border-gray-200 pt-4 sm:flex-row sm:items-center sm:justify-between dark:border-gray-800"
>
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Showing
        <span class="font-medium text-gray-800 dark:text-white/90" x-text="startEntry"></span>
        to
        <span class="font-medium text-gray-800 dark:text-white/90" x-text="endEntry"></span>
        of
        <span class="font-medium text-gray-800 dark:text-white/90" x-text="totalEntries"></span>
    </p>

    <div x-show="totalPages > 0" class="flex items-center gap-1.5 self-center sm:self-auto">
        <button type="button" x-on:click="pageIndex = Math.max(0, pageIndex - 1)" x-bind:disabled="pageIndex <= 0" class="flex size-10 cursor-pointer items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Previous page">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
        </button>

        <div class="flex items-center gap-1.5">
            <template x-for="(item, index) in pages" x-bind:key="index">
                <div class="contents">
                    <template x-if="typeof item === 'string'">
                        <span class="flex size-10 items-center justify-center text-sm font-medium text-gray-500 dark:text-gray-400"> ... </span>
                    </template>
                    <template x-if="typeof item === 'number'">
                        <button
                            type="button"
                            x-on:click="pageIndex = item - 1"
                            class="flex size-10 cursor-pointer items-center justify-center rounded-[10px] text-sm font-medium transition-colors"
                            x-bind:class="currentPage === item
                                ? 'bg-brand-500 text-white shadow-theme-xs'
                                : 'border border-gray-200 bg-white text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5'"
                            x-bind:aria-current="currentPage === item ? 'page' : null"
                            x-text="item"
                        ></button>
                    </template>
                </div>
            </template>
        </div>

        <button type="button" x-on:click="pageIndex = Math.min(totalPages - 1, pageIndex + 1)" x-bind:disabled="pageIndex >= totalPages - 1" class="flex size-10 cursor-pointer items-center justify-center rounded-[10px] border border-gray-200 bg-white text-gray-700 shadow-theme-xs transition-colors hover:bg-gray-50 disabled:pointer-events-none disabled:opacity-40 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/5" aria-label="Next page">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
        </button>
    </div>
</div></div>
</div>
            </div>
        </div>

    </div>

</body>


</html>
