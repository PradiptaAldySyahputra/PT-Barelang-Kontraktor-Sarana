<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Perfil
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
                Perfil
            </li>
        </ol>
    </nav>
</div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/3">
            <h3 class="mb-5 text-lg font-semibold text-gray-800 lg:mb-7 dark:text-white/90">Profile</h3>
            <div class="space-y-6">
                <div data-slot="card" data-size="default" x-data="{
        profileData: JSON.parse('{\u0022avatarUrl\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-01.jpg\u0022,\u0022fullName\u0022:\u0022Musharof Chowdhury\u0022,\u0022role\u0022:\u0022Team Manager\u0022,\u0022location\u0022:\u0022Leeds, United Kingdom\u0022,\u0022firstName\u0022:\u0022Emirhan\u0022,\u0022lastName\u0022:\u0022Boruch\u0022,\u0022email\u0022:\u0022randomuser@pimjo.com\u0022,\u0022phone\u0022:\u0022+09 363 398 46\u0022,\u0022bio\u0022:\u0022Team Manager\u0022,\u0022socialLinks\u0022:{\u0022facebook\u0022:\u0022\u0022,\u0022x\u0022:\u0022\u0022,\u0022linkedin\u0022:\u0022\u0022,\u0022instagram\u0022:\u0022\u0022}}'),
        get initialLetter() {
            return this.profileData.firstName && this.profileData.firstName.trim() ? this.profileData.firstName.trim()[0].toUpperCase() : 'M';
        },
        get socialList() {
            const s = this.profileData.socialLinks;
            return [
                { name: 'Facebook', href: s.facebook || '#', hasLink: true, icon: 'facebook' },
                { name: 'X', href: s.x || '#', hasLink: true, icon: 'twitter-x' },
                { name: 'LinkedIn', href: s.linkedin || '#', hasLink: true, icon: 'linkedin' },
                { name: 'Instagram', href: s.instagram || '#', hasLink: true, icon: 'instagram' },
            ];
        },
    }" class="group/card flex flex-col gap-5 rounded-xl bg-white data-[size=sm]:p-4 dark:bg-white/3 relative overflow-hidden border border-gray-200 p-5 sm:p-6 lg:p-7 dark:border-gray-700"><div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents"><!-- Top Header Row: Title & Edit Button -->
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90">
                Personal Information
            </h2>

            <button data-slot="button" type="button" @click="show()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-lg py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-9 gap-2 px-3.5"><svg class="size-4.5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
                <span>Edit</span></button>
        </div>

        <!-- Profile Pic & Basic Meta -->
        <div class="mt-2 flex items-center gap-4 sm:gap-6">
            <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-16 shrink-0 sm:size-20"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="profileData.avatarUrl || '/assets/images/user/owner.png'" x-bind:alt="profileData.fullName || 'User profile'" class="aspect-square size-full rounded-full object-cover">
                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs bg-brand-400 text-xl font-medium text-white sm:text-2xl dark:bg-brand-400 dark:text-white"><span x-text="initialLetter"></span></span>
</template></span>

            <div class="flex flex-col gap-1">
                <h3 class="text-base font-semibold text-gray-800 sm:text-lg dark:text-white/90" x-text="profileData.fullName"></h3>

                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                    <span x-text="profileData.role"></span>
                    <span class="inline-block h-3.5 w-px bg-gray-300 dark:bg-gray-700"></span>
                    <span x-text="profileData.location"></span>
                </div>
            </div>
        </div>

        <!-- Details & Social Links Grid -->
        <div class="mt-2 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1 sm:gap-2">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
        First Name
    </p>
    <p class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90" x-text="profileData.firstName || '—'"></p>
</div>
                <div class="flex flex-col gap-1 sm:gap-2">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
        Email address
    </p>
    <p class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90" x-text="profileData.email || '—'"></p>
</div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1 sm:gap-2">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
        Last Name
    </p>
    <p class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90" x-text="profileData.lastName || '—'"></p>
</div>
                <div class="flex flex-col gap-1 sm:gap-2">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
        Phone
    </p>
    <p class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90" x-text="profileData.phone || '—'"></p>
</div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1 sm:gap-2">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">
        Bio
    </p>
    <p class="text-sm font-medium text-gray-800 sm:text-base dark:text-white/90" x-text="profileData.bio || '—'"></p>
</div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-2 sm:gap-3">
    <p class="text-xs font-normal text-gray-500 sm:text-sm dark:text-gray-400">Social links</p>
    <div class="flex flex-wrap items-center gap-2">
        <template x-for="link in socialList" :key="link.name">
            <div>
                <template x-if="link.icon === 'facebook'">
                    <div>
                        <template x-if="link.hasLink">
                            <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-full" :href="link.href" target="_blank" rel="noreferrer" :aria-label="link.name">
                                    <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M11.667 11.25h2.083l.833-3.333h-2.916V6.25c0-.857 0-1.666 1.666-1.666h1.25v-2.8a23.397 23.397 0 00-2.38-.117c-2.263 0-3.87 1.38-3.87 3.916v2.334h-2.5v3.333h2.5v7.084h3.334V11.25z"
      fill="currentColor"
    />
  </svg>
                                </a>
                        </template>
                        <template x-if="!link.hasLink">
                            <div :aria-label="link.name" class="flex size-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-theme-xs sm:size-11 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-600">
                                <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M11.667 11.25h2.083l.833-3.333h-2.916V6.25c0-.857 0-1.666 1.666-1.666h1.25v-2.8a23.397 23.397 0 00-2.38-.117c-2.263 0-3.87 1.38-3.87 3.916v2.334h-2.5v3.333h2.5v7.084h3.334V11.25z"
      fill="currentColor"
    />
  </svg>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="link.icon === 'twitter-x'">
                    <div>
                        <template x-if="link.hasLink">
                            <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-full" :href="link.href" target="_blank" rel="noreferrer" :aria-label="link.name">
                                    <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.749 3.104l3.424 4.529.37.49.405-.463 3.986-4.556h1.18l-4.757 5.437-.267.306.245.325 5.843 7.723H13.38l-3.805-4.974-.37-.486-.403.46-4.375 5H3.244l5.138-5.872.27-.307-.249-.325-5.572-7.287h3.918zM4.353 4.331l9.076 11.866.15.197h2.643l-.607-.802L6.641 3.726l-.15-.199H3.736l.616.804z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
                                </a>
                        </template>
                        <template x-if="!link.hasLink">
                            <div :aria-label="link.name" class="flex size-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-theme-xs sm:size-11 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-600">
                                <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M6.749 3.104l3.424 4.529.37.49.405-.463 3.986-4.556h1.18l-4.757 5.437-.267.306.245.325 5.843 7.723H13.38l-3.805-4.974-.37-.486-.403.46-4.375 5H3.244l5.138-5.872.27-.307-.249-.325-5.572-7.287h3.918zM4.353 4.331l9.076 11.866.15.197h2.643l-.607-.802L6.641 3.726l-.15-.199H3.736l.616.804z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="link.icon === 'linkedin'">
                    <div>
                        <template x-if="link.hasLink">
                            <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-full" :href="link.href" target="_blank" rel="noreferrer" :aria-label="link.name">
                                    <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M12.969 7.523a4.14 4.14 0 012.167-.226c.726.124 1.393.454 1.878 1.018.482.56.82 1.39.82 2.577V17h-2.292v-4.975c0-.934-.28-1.673-.758-2.178a2.276 2.276 0 00-1.748-.716c-1.282.046-2.468 1.12-2.469 2.894V17H8.283V7.567h2.306l-.022.887.939.253c.276-.503.796-.923 1.463-1.184zm-7.635.044V17H3V7.567h2.334zM4.152 3a1.166 1.166 0 11-.07 2.331 1.166 1.166 0 01.07-2.33z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
                                </a>
                        </template>
                        <template x-if="!link.hasLink">
                            <div :aria-label="link.name" class="flex size-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-theme-xs sm:size-11 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-600">
                                <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M12.969 7.523a4.14 4.14 0 012.167-.226c.726.124 1.393.454 1.878 1.018.482.56.82 1.39.82 2.577V17h-2.292v-4.975c0-.934-.28-1.673-.758-2.178a2.276 2.276 0 00-1.748-.716c-1.282.046-2.468 1.12-2.469 2.894V17H8.283V7.567h2.306l-.022.887.939.253c.276-.503.796-.923 1.463-1.184zm-7.635.044V17H3V7.567h2.334zM4.152 3a1.166 1.166 0 11-.07 2.331 1.166 1.166 0 01.07-2.33z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
                            </div>
                        </template>
                    </div>
                </template>
                <template x-if="link.icon === 'instagram'">
                    <div>
                        <template x-if="link.hasLink">
                            <a data-slot="button" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-full" :href="link.href" target="_blank" rel="noreferrer" :aria-label="link.name">
                                    <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.857 1.667c.938.002 1.413.007 1.824.019l.161.005.594.025c.886.041 1.491.182 2.023.388a4.06 4.06 0 011.476.961c.462.463.749.928.961 1.476.206.531.346 1.137.388 2.023.01.223.018.407.024.594l.005.161c.013.411.018.886.02 1.824v1.713a65.505 65.505 0 01-.019 1.824l-.005.162-.025.593c-.041.887-.182 1.492-.388 2.023a4.07 4.07 0 01-.961 1.476c-.463.463-.93.75-1.476.961-.532.206-1.137.346-2.023.388l-.594.025-.162.005c-.41.012-.885.018-1.823.02H9.144a65.1 65.1 0 01-1.824-.02l-.162-.005a53.705 53.705 0 01-.593-.025c-.887-.04-1.491-.182-2.023-.388a4.073 4.073 0 01-1.476-.96 4.086 4.086 0 01-.962-1.477c-.206-.531-.345-1.136-.387-2.023l-.025-.593-.005-.162c-.012-.41-.018-.886-.02-1.824V9.143c.002-.938.007-1.413.02-1.824l.005-.161c.006-.187.014-.371.025-.594.04-.887.181-1.491.387-2.023a4.066 4.066 0 01.962-1.476 4.08 4.08 0 011.476-.961c.531-.206 1.135-.346 2.023-.388.222-.01.406-.018.593-.024l.162-.005c.41-.013.886-.018 1.824-.02h1.713zM10 5.833a4.166 4.166 0 100 8.333 4.166 4.166 0 000-8.333zM10 7.5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm4.375-2.917a1.042 1.042 0 10.001 2.084 1.042 1.042 0 000-2.084z"
      fill="currentColor"
    />
  </svg>
                                </a>
                        </template>
                        <template x-if="!link.hasLink">
                            <div :aria-label="link.name" class="flex size-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-400 shadow-theme-xs sm:size-11 dark:border-gray-800 dark:bg-gray-800 dark:text-gray-600">
                                <svg class="size-5 fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.857 1.667c.938.002 1.413.007 1.824.019l.161.005.594.025c.886.041 1.491.182 2.023.388a4.06 4.06 0 011.476.961c.462.463.749.928.961 1.476.206.531.346 1.137.388 2.023.01.223.018.407.024.594l.005.161c.013.411.018.886.02 1.824v1.713a65.505 65.505 0 01-.019 1.824l-.005.162-.025.593c-.041.887-.182 1.492-.388 2.023a4.07 4.07 0 01-.961 1.476c-.463.463-.93.75-1.476.961-.532.206-1.137.346-2.023.388l-.594.025-.162.005c-.41.012-.885.018-1.823.02H9.144a65.1 65.1 0 01-1.824-.02l-.162-.005a53.705 53.705 0 01-.593-.025c-.887-.04-1.491-.182-2.023-.388a4.073 4.073 0 01-1.476-.96 4.086 4.086 0 01-.962-1.477c-.206-.531-.345-1.136-.387-2.023l-.025-.593-.005-.162c-.012-.41-.018-.886-.02-1.824V9.143c.002-.938.007-1.413.02-1.824l.005-.161c.006-.187.014-.371.025-.594.04-.887.181-1.491.387-2.023a4.066 4.066 0 01.962-1.476 4.08 4.08 0 011.476-.961c.531-.206 1.135-.346 2.023-.388.222-.01.406-.018.593-.024l.162-.005c.41-.013.886-.018 1.824-.02h1.713zM10 5.833a4.166 4.166 0 100 8.333 4.166 4.166 0 000-8.333zM10 7.5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm4.375-2.917a1.042 1.042 0 10.001 2.084 1.042 1.042 0 000-2.084z"
      fill="currentColor"
    />
  </svg>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>
            </div>
        </div>

        <!-- Edit Personal Information Dialog -->
        <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 gap-4 rounded-2xl border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-h-[90vh] w-full overflow-hidden p-0 sm:max-w-2xl">
            <div data-slot="scroll-area"  class="relative max-h-[90vh]">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 max-h-[90vh]">
        <div class="min-w-0"><div class="p-6 sm:p-8">
            <div data-slot="dialog-header"  class="flex flex-col gap-1 sm:gap-2"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">Edit Personal Information</h2>
                <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm text-gray-500 dark:text-gray-400">Update your details to keep your profile up-to-date.</p></div>

            <form
                class="mt-4 space-y-6"
                novalidate
                x-data="{
                    form: {},
                    errors: {},
                    touched: {},
                    avatarFileUrl: null,
                    get previewAvatarUrl() {
                        return this.avatarFileUrl || this.form.avatarUrl || '/assets/images/user/user-01.jpg';
                    },
                    validate() {
                        const errors = {};
                        const f = this.form;
                        if (!(f.firstName || '').trim()) errors.firstName = 'First name is required';
                        if (!(f.lastName || '').trim()) errors.lastName = 'Last name is required';
                        if (!(f.email || '').trim()) errors.email = 'Email is required';
                        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email.trim())) errors.email = 'Please enter a valid email address';
                        if (!(f.phone || '').trim()) errors.phone = 'Phone number is required';
                        return errors;
                    },
                    touch(key) {
                        this.touched[key] = true;
                        this.errors = this.validate();
                    },
                    errorOf(key) {
                        return this.touched[key] ? this.errors[key] : undefined;
                    },
                    submit() {
                        this.errors = this.validate();
                        if (Object.keys(this.errors).length) {
                            Object.keys(this.errors).forEach((k) => (this.touched[k] = true));
                            return null;
                        }
                        const f = this.form;
                        const fullName = `${f.firstName.trim()} ${f.lastName.trim()}`.trim();
                        return {
                            avatarUrl: this.previewAvatarUrl,
                            fullName: fullName || profileData.fullName,
                            role: profileData.role,
                            location: profileData.location,
                            firstName: f.firstName.trim(),
                            lastName: f.lastName.trim(),
                            email: f.email.trim(),
                            phone: f.phone.trim(),
                            bio: (f.bio || '').trim(),
                            socialLinks: {
                                facebook: (f.facebook || '').trim(),
                                x: (f.x || '').trim(),
                                linkedin: (f.linkedin || '').trim(),
                                instagram: (f.instagram || '').trim(),
                            },
                        };
                    },
                }"
                x-effect="if (open) { form = { firstName: profileData.firstName, lastName: profileData.lastName, email: profileData.email, phone: profileData.phone, bio: profileData.bio, facebook: profileData.socialLinks.facebook, x: profileData.socialLinks.x, linkedin: profileData.socialLinks.linkedin, instagram: profileData.socialLinks.instagram, avatarUrl: profileData.avatarUrl }; errors = {}; touched = {}; avatarFileUrl = null; }"
                @submit.prevent="const next = submit(); if (next) { profileData = next; close(); }"
            >
                <div class="space-y-4">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Change Profile Picture</h3>

    <div class="flex items-center gap-4 sm:gap-6">
        <div class="relative">
            <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-20 shrink-0 sm:size-24"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="previewAvatarUrl" x-bind:alt="profileData.fullName || 'Profile avatar'" class="aspect-square size-full rounded-full object-cover">
                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs bg-cyan-500 text-2xl font-medium text-white dark:bg-cyan-500 dark:text-white"><span x-text="initialLetter"></span></span>
</template></span>

            <!-- Overlaid Camera Button -->
            <button
                type="button"
                class="absolute end-0 bottom-0 flex size-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-theme-xs transition-colors hover:bg-gray-50 hover:text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white"
                aria-label="Upload profile picture"
                @click="$refs.avatarInput.click()"
            >
                <svg class="size-4.5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M12.6732 3.41872C12.4373 3.10275 12.066 2.91667 11.6717 2.91667H8.32825C7.93391 2.91667 7.56268 3.10275 7.32672 3.41872L6.83189 4.08131C6.59593 4.39727 6.2247 4.58336 5.83036 4.58336H3.54167C2.85131 4.58336 2.29167 5.14301 2.29167 5.83336V14.375C2.29167 15.0654 2.85131 15.625 3.54167 15.625H16.4583C17.1487 15.625 17.7083 15.0654 17.7083 14.375V5.83336C17.7083 5.14301 17.1487 4.58336 16.4583 4.58336H14.1696C13.7752 4.58336 13.404 4.39727 13.1681 4.08131L12.6732 3.41872Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
    <path
      d="M13.3333 9.79329C13.3333 11.6342 11.8409 13.1266 10 13.1266C8.15905 13.1266 6.66667 11.6342 6.66667 9.79329C6.66667 7.95234 8.15905 6.45996 10 6.45996C11.8409 6.45996 13.3333 7.95234 13.3333 9.79329Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
            </button>

            <input
                id="avatar-file-input"
                x-ref="avatarInput"
                type="file"
                accept="image/png,image/jpeg,image/webp"
                class="hidden"
                @change="const file = $event.target.files && $event.target.files[0]; if (file) avatarFileUrl = URL.createObjectURL(file)"
            />
        </div>

        <div class="flex flex-col gap-1 text-sm text-gray-500 dark:text-gray-400">
            <p class="font-normal">Upload a square image (200×200 px)</p>
            <p class="font-normal">in JPEG or PNG format.</p>
        </div>
    </div>
</div>

                <div class="space-y-4">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Personal Information</h3>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('firstName'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">First Name <span class="text-red-500">*</span></label>
            <input data-slot="input" type="text" x-model="form.firstName" placeholder="Enter first name" x-bind:aria-invalid="errorOf('firstName') ? 'true' : null" @blur="touch('firstName')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('firstName')" style="display: none;" x-text="errorOf('firstName')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('lastName'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Last Name <span class="text-red-500">*</span></label>
            <input data-slot="input" type="text" x-model="form.lastName" placeholder="Enter last name" x-bind:aria-invalid="errorOf('lastName') ? 'true' : null" @blur="touch('lastName')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('lastName')" style="display: none;" x-text="errorOf('lastName')"></p></div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('email'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Email Address <span class="text-red-500">*</span></label>
            <input data-slot="input" type="email" x-model="form.email" placeholder="info@example.com" x-bind:aria-invalid="errorOf('email') ? 'true' : null" @blur="touch('email')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('email')" style="display: none;" x-text="errorOf('email')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('phone'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Phone <span class="text-red-500">*</span></label>
            <input data-slot="input" type="text" x-model="form.phone" placeholder="+09 363 398 46" x-bind:aria-invalid="errorOf('phone') ? 'true' : null" @blur="touch('phone')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('phone')" style="display: none;" x-text="errorOf('phone')"></p></div>
    </div>

    <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('bio'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Bio</label>
        <textarea data-slot="textarea" x-model="form.bio" rows="3" placeholder="Write a brief bio..." x-bind:aria-invalid="errorOf('bio') ? 'true' : null" @blur="touch('bio')" class="flex min-h-20 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40"></textarea>
        <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('bio')" style="display: none;" x-text="errorOf('bio')"></p></div>
</div>

                <div class="space-y-4">
    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Social Links</h3>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('facebook'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Facebook</label>
            <input data-slot="input" type="url" x-model="form.facebook" placeholder="https://facebook.com/username" x-bind:aria-invalid="errorOf('facebook') ? 'true' : null" @blur="touch('facebook')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('facebook')" style="display: none;" x-text="errorOf('facebook')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('x'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">X.com</label>
            <input data-slot="input" type="url" x-model="form.x" placeholder="https://x.com/username" x-bind:aria-invalid="errorOf('x') ? 'true' : null" @blur="touch('x')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('x')" style="display: none;" x-text="errorOf('x')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('linkedin'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Linkedin</label>
            <input data-slot="input" type="url" x-model="form.linkedin" placeholder="https://linkedin.com/in/username" x-bind:aria-invalid="errorOf('linkedin') ? 'true' : null" @blur="touch('linkedin')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('linkedin')" style="display: none;" x-text="errorOf('linkedin')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('instagram'))" class="group/field flex w-full gap-2 data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto"><label data-slot="field-label"   class="group/field-label peer/field-label w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10 mb-1.5 block">Instagram</label>
            <input data-slot="input" type="url" x-model="form.instagram" placeholder="https://instagram.com/username" x-bind:aria-invalid="errorOf('instagram') ? 'true' : null" @blur="touch('instagram')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('instagram')" style="display: none;" x-text="errorOf('instagram')"></p></div>
    </div>
</div>

                <!-- Footer Actions -->
                <div class="flex flex-col-reverse justify-end gap-3 pt-3 sm:flex-row">
                    <button data-slot="button" type="button" @click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Close</button>
                    <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Save Changes</button>
                </div>
            </form>
        </div></div>
    </div>
</div>
                            <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 in-data-[slot=button-group]:rounded-lg rounded-full text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white absolute end-3 top-3" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                        <span class="sr-only">Close</span></button>
                    </div>
    </div>
</template></div></div>
                <div data-slot="card" data-size="default" x-data="{ address: JSON.parse('{\u0022country\u0022:\u0022United Kingdom\u0022,\u0022cityState\u0022:\u0022Leeds, East London\u0022,\u0022postalCode\u0022:\u0022ERT 2489\u0022,\u0022taxId\u0022:\u0022AS4568384\u0022}') }" class="group/card flex flex-col gap-5 bg-white data-[size=sm]:p-4 sm:p-6 dark:bg-white/3 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-700"><div class="flex flex-col gap-6 sm:flex-row lg:items-start lg:justify-between">
        <div class="flex-1">
            <h4 class="mb-4 text-lg font-semibold text-gray-800 lg:mb-6 dark:text-white/90">Address</h4>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                <div >
    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
        Country
    </p>
    <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="address.country"></p>
</div>
                <div >
    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
        City/State
    </p>
    <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="address.cityState"></p>
</div>
                <div >
    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
        Postal Code
    </p>
    <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="address.postalCode"></p>
</div>
                <div >
    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
        TAX ID
    </p>
    <p class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="address.taxId"></p>
</div>
            </div>
        </div>

        <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents"><div>
                <button data-slot="button" type="button" @click="show()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 w-full lg:w-auto"><svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
                    Edit</button>
            </div>

            <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-w-[calc(100%-2rem)] rounded-3xl p-6 sm:max-w-146 sm:p-10">
            <div data-slot="dialog-header"  class="flex flex-col gap-2 pe-14 text-start"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-2xl font-semibold text-gray-800 dark:text-white/90">Edit Address</h2>
        <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm text-gray-500 dark:text-gray-400">Update your details to keep your profile up-to-date.</p></div>

    <form
        class="space-y-6"
        novalidate
        x-data="{
            form: {},
            errors: {},
            touched: {},
            validate() {
                const errors = {};
                if (!(this.form.country || '').trim()) errors.country = 'Country is required';
                if (!(this.form.cityState || '').trim()) errors.cityState = 'City/State is required';
                if (!(this.form.postalCode || '').trim()) errors.postalCode = 'Postal Code is required';
                if (!(this.form.taxId || '').trim()) errors.taxId = 'TAX ID is required';
                return errors;
            },
            touch(key) {
                this.touched[key] = true;
                this.errors = this.validate();
            },
            errorOf(key) {
                return this.touched[key] ? this.errors[key] : undefined;
            },
            submit() {
                this.errors = this.validate();
                if (Object.keys(this.errors).length) {
                    Object.keys(this.errors).forEach((k) => (this.touched[k] = true));
                    return false;
                }
                return true;
            },
        }"
        x-effect="if (open) { form = { ...address }; errors = {}; touched = {}; }"
        @submit.prevent="if (submit()) { address = { ...form }; close(); }"
    >
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6">
            <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('country'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Country</label>
                <input data-slot="input" type="text" x-model="form.country" placeholder="Country" x-bind:aria-invalid="errorOf('country') ? 'true' : null" @blur="touch('country')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('country')" style="display: none;" x-text="errorOf('country')"></p></div>

            <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('cityState'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">City/State</label>
                <input data-slot="input" type="text" x-model="form.cityState" placeholder="City/State" x-bind:aria-invalid="errorOf('cityState') ? 'true' : null" @blur="touch('cityState')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('cityState')" style="display: none;" x-text="errorOf('cityState')"></p></div>

            <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('postalCode'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Postal Code</label>
                <input data-slot="input" type="text" x-model="form.postalCode" placeholder="Postal Code" x-bind:aria-invalid="errorOf('postalCode') ? 'true' : null" @blur="touch('postalCode')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('postalCode')" style="display: none;" x-text="errorOf('postalCode')"></p></div>

            <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('taxId'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">TAX ID</label>
                <input data-slot="input" type="text" x-model="form.taxId" placeholder="TAX ID" x-bind:aria-invalid="errorOf('taxId') ? 'true' : null" @blur="touch('taxId')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
                <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('taxId')" style="display: none;" x-text="errorOf('taxId')"></p></div>
        </div>

        <div data-slot="dialog-footer"  class="flex flex-col-reverse rounded-b-2xl sm:flex-row mx-0 mb-0 gap-3 p-0 pt-2 sm:justify-end">
    <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Close</button>
            <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Save Changes</button>
    </div>
    </form>
                            <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 in-data-[slot=button-group]:rounded-lg rounded-full text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white absolute end-3 top-3" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                        <span class="sr-only">Close</span></button>
                    </div>
    </div>
</template></div>
    </div></div>
                <div data-slot="card" data-size="default" x-data="{ twoFactorEnabled: false }" class="group/card flex flex-col gap-5 data-[size=sm]:p-4 sm:p-6 rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-700 dark:bg-white/3"><h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Security</h4>

    <div class="mt-1">
        <div class="flex flex-col justify-between gap-4 py-4 first:pt-0 sm:flex-row sm:items-center border-b border-gray-200 pb-4 dark:border-gray-700">
    <div>
        <h4 class="mb-1 text-base font-medium text-gray-800 dark:text-white/90">
            Change Password
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Receive real-time notifications and team alerts.
        </p>
    </div>
    <div class="flex shrink-0 items-center">
        <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents"><button data-slot="button" type="button" @click="show()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-2"><svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
                        <span>Change Password</span></button>

                    <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-w-[calc(100%-2rem)] rounded-3xl p-6 sm:max-w-146 sm:p-10">
            <div data-slot="dialog-header"  class="flex flex-col gap-2 pe-14 text-start"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-xl font-semibold text-gray-800 sm:text-2xl dark:text-white/90">Change Password</h2>
        <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm text-gray-500 dark:text-gray-400">Use a strong password to protect your account</p></div>

    <form
        class="space-y-5"
        novalidate
        x-data="{
            form: { currentPassword: '', newPassword: '', confirmPassword: '' },
            errors: {},
            touched: {},
            validate() {
                const errors = {};
                const currentPassword = this.form.currentPassword.trim();
                const newPassword = this.form.newPassword.trim();
                const confirmPassword = this.form.confirmPassword.trim();
                if (!currentPassword) errors.currentPassword = 'Current password is required';
                if (newPassword.length < 8) errors.newPassword = 'Password must be at least 8 characters';
                else if (currentPassword && currentPassword === newPassword) errors.newPassword = 'New password must be different from current password';
                if (!confirmPassword) errors.confirmPassword = 'Please confirm your new password';
                else if (newPassword !== confirmPassword) errors.confirmPassword = 'Passwords do not match';
                return errors;
            },
            touch(key) {
                this.touched[key] = true;
                this.errors = this.validate();
            },
            errorOf(key) {
                return this.touched[key] ? this.errors[key] : undefined;
            },
            submit() {
                this.errors = this.validate();
                if (Object.keys(this.errors).length) {
                    Object.keys(this.errors).forEach((k) => (this.touched[k] = true));
                    return false;
                }
                return true;
            },
        }"
        x-effect="if (open) { form = { currentPassword: '', newPassword: '', confirmPassword: '' }; errors = {}; touched = {}; }"
        @submit.prevent="if (submit()) close()"
    >
        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('currentPassword'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Current Password</label>
            <input data-slot="input" type="password" x-model="form.currentPassword" placeholder="Enter current password" x-bind:aria-invalid="errorOf('currentPassword') ? 'true' : null" @blur="touch('currentPassword')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('currentPassword')" style="display: none;" x-text="errorOf('currentPassword')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('newPassword'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">New Password</label>
            <input data-slot="input" type="password" x-model="form.newPassword" placeholder="Enter new password" x-bind:aria-invalid="errorOf('newPassword') ? 'true' : null" @blur="touch('newPassword')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('newPassword')" style="display: none;" x-text="errorOf('newPassword')"></p></div>

        <div role="group" data-slot="field" data-orientation="vertical" x-bind:data-invalid="Boolean(errorOf('confirmPassword'))" class="group/field flex w-full data-[invalid=true]:text-red-500 dark:data-[invalid=true]:text-red-400 flex-col *:w-full [&amp;&gt;.sr-only]:w-auto gap-1.5"><label data-slot="field-label"   class="group/field-label peer/field-label flex w-fit gap-2 text-sm leading-snug font-medium text-gray-700 select-none group-data-[disabled=true]/field:opacity-50 dark:text-gray-300 has-data-checked:border-brand-500/30 has-data-checked:bg-brand-500/5 dark:has-data-checked:border-brand-500/20 dark:has-data-checked:bg-brand-500/10">Confirm Password</label>
            <input data-slot="input" type="password" x-model="form.confirmPassword" placeholder="Confirm new password" x-bind:aria-invalid="errorOf('confirmPassword') ? 'true' : null" @blur="touch('confirmPassword')" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            <p class="text-sm font-normal text-red-500 dark:text-red-400" x-show="errorOf('confirmPassword')" style="display: none;" x-text="errorOf('confirmPassword')"></p></div>

        <div data-slot="dialog-footer"  class="flex flex-col-reverse rounded-b-2xl sm:flex-row mx-0 mb-0 gap-3 p-0 pt-2 sm:justify-end">
    <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Close</button>
            <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">Save Changes</button>
    </div>
    </form>
                            <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 in-data-[slot=button-group]:rounded-lg rounded-full text-gray-400 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white absolute end-3 top-3" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M18 6L6 18M6 6l12 12" />
  </svg>
                        <span class="sr-only">Close</span></button>
                    </div>
    </div>
</template></div>
    </div>
</div>

        <div class="flex flex-col justify-between gap-4 py-4 first:pt-0 sm:flex-row sm:items-center">
    <div>
        <h4 class="mb-1 text-base font-medium text-gray-800 dark:text-white/90">
            Two-factor authentication (2FA)
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Keep your account secure by enabling 2FA
        </p>
    </div>
    <div class="flex shrink-0 items-center">
        <button
    type="button"
    role="switch"
    data-slot="switch"
    data-size="sm"
            x-bind:aria-checked="twoFactorEnabled ? 'true' : 'false'"
    x-bind:data-state="twoFactorEnabled ? 'checked' : 'unchecked'"
    x-bind:data-checked="twoFactorEnabled ? '' : null"
    x-bind:data-unchecked="twoFactorEnabled ? null : ''"
     x-on:click="twoFactorEnabled = !twoFactorEnabled"     aria-label="Toggle two-factor authentication"
    class="peer relative inline-flex shrink-0 cursor-pointer items-center rounded-full transition-colors outline-hidden select-none focus-visible:ring-2 focus-visible:ring-brand-500/20 focus-visible:outline-hidden dark:focus-visible:ring-brand-500/30 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 data-checked:bg-brand-500 data-checked:hover:bg-brand-600 dark:data-checked:bg-brand-500 dark:data-checked:hover:bg-brand-600 data-disabled:cursor-not-allowed data-disabled:bg-gray-100 data-disabled:hover:bg-gray-100 dark:data-disabled:bg-gray-800 dark:data-disabled:hover:bg-gray-800 data-disabled:data-checked:bg-gray-100 data-disabled:data-checked:hover:bg-gray-100 dark:data-disabled:data-checked:bg-gray-800 dark:data-disabled:data-checked:hover:bg-gray-800 group-has-focus-visible/field-label:ring-0 after:absolute after:-inset-x-3 after:-inset-y-2 aria-invalid:ring-3 aria-invalid:ring-error-500/20 dark:aria-invalid:ring-error-500/40 h-5 w-11 p-[1.5px]"
>
    <span
        data-slot="switch-thumb"
        x-bind:data-checked="twoFactorEnabled ? '' : null"
        x-bind:data-unchecked="twoFactorEnabled ? null : ''"
        class="pointer-events-none block shrink-0 rounded-full bg-white shadow-theme-sm ring-0 transition-transform duration-150 ease-linear data-unchecked:translate-x-0 rtl:data-unchecked:translate-x-0 h-[17px] w-[26px] data-checked:translate-x-[15px] rtl:data-checked:-translate-x-[15px]"
    ></span>
</button>
    </div>
</div>
    </div></div>
                <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 sm:p-6 rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-700 dark:bg-white/3"><h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">
        Danger Zone
    </h4>

    <div class="mt-1">
                    <div class="flex flex-col justify-between gap-4 py-4 first:pt-0 sm:flex-row sm:items-center border-b border-gray-200 pb-4 dark:border-gray-700">
    <div>
        <h4 class="mb-1 text-base font-medium text-gray-800 dark:text-white/90">
            Logout all devices
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Sign out from every active session.
        </p>
    </div>
    <div class="flex shrink-0 items-center">
        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="size-5 rtl:rotate-180">
    <path
      d="M4 12h7.75M8 8l-3.998 4 3.997 4M9.75 4.996V4.25a1.5 1.5 0 011.5-1.5h6a1.5 1.5 0 011.5 1.5v15.5a1.5 1.5 0 01-1.5 1.5h-6a1.5 1.5 0 01-1.5-1.5V19"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        <span>Logout</span></button>
    </div>
</div>
                    <div class="flex flex-col justify-between gap-4 py-4 first:pt-0 sm:flex-row sm:items-center">
    <div>
        <h4 class="mb-1 text-base font-medium text-gray-800 dark:text-white/90">
            Delete account
        </h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Permanently remove your account and all data.
        </p>
    </div>
    <div class="flex shrink-0 items-center">
        <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 border-red-300 text-red-500 shadow-theme-xs hover:bg-red-50 hover:text-red-600 dark:border-red-500/40 dark:text-red-400 dark:hover:bg-red-500/10"><svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
                        <span>Delete</span></button>
    </div>
</div>
            </div></div>
            </div>
        </div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
