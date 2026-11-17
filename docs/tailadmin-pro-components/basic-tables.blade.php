<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Basic Tables
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
                Basic Tables
            </li>
        </ol>
    </nav>
</div>
    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Basic Table 1
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-white/5 dark:bg-white/3">
    <div class="max-w-full overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-gray-100 dark:border-white/5">
                <tr>
                                            <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 sm:px-6 dark:text-gray-400">User</th>
                                            <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 sm:px-6 dark:text-gray-400">Project Name</th>
                                            <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 sm:px-6 dark:text-gray-400">Team</th>
                                            <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 sm:px-6 dark:text-gray-400">Status</th>
                                            <th class="px-5 py-3 text-start text-xs font-medium text-gray-500 sm:px-6 dark:text-gray-400">Budget</th>
                                    </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                                                        <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
                        <td class="px-5 py-4 text-start sm:px-6">
                            <div class="flex items-center gap-3">
                                <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-17.jpg" alt="Lindsey Curtis" class="aspect-square size-full rounded-full object-cover">
                                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">LC</span>
</template></span>
                                <div>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Lindsey Curtis</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Web Designer</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">Agency Website</td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <div data-slot="avatar-group"  class="group/avatar-group flex *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! -space-x-2"><span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-22.jpg" alt="Team member 1" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">1</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-23.jpg" alt="Team member 2" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">2</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-24.jpg" alt="Team member 3" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">3</span>
</template></span></div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">3.9K</td>
                    </tr>
                                                        <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
                        <td class="px-5 py-4 text-start sm:px-6">
                            <div class="flex items-center gap-3">
                                <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-18.jpg" alt="Kaiya George" class="aspect-square size-full rounded-full object-cover">
                                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">KG</span>
</template></span>
                                <div>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Kaiya George</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Project Manager</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">Technology</td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <div data-slot="avatar-group"  class="group/avatar-group flex *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! -space-x-2"><span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-25.jpg" alt="Team member 1" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">1</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-26.jpg" alt="Team member 2" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">2</span>
</template></span></div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <span data-slot="badge" data-variant="light" data-color="warning" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]">Pending</span>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">24.9K</td>
                    </tr>
                                                        <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
                        <td class="px-5 py-4 text-start sm:px-6">
                            <div class="flex items-center gap-3">
                                <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-17.jpg" alt="Zain Geidt" class="aspect-square size-full rounded-full object-cover">
                                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">ZG</span>
</template></span>
                                <div>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Zain Geidt</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Content Writing</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">Blog Writing</td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <div data-slot="avatar-group"  class="group/avatar-group flex *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! -space-x-2"><span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-27.jpg" alt="Team member 1" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">1</span>
</template></span></div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">12.7K</td>
                    </tr>
                                                        <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
                        <td class="px-5 py-4 text-start sm:px-6">
                            <div class="flex items-center gap-3">
                                <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-20.jpg" alt="Abram Schleifer" class="aspect-square size-full rounded-full object-cover">
                                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">AS</span>
</template></span>
                                <div>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Abram Schleifer</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Digital Marketer</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">Social Media</td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <div data-slot="avatar-group"  class="group/avatar-group flex *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! -space-x-2"><span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-28.jpg" alt="Team member 1" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">1</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-29.jpg" alt="Team member 2" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">2</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-30.jpg" alt="Team member 3" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">3</span>
</template></span></div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">Cancel</span>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">2.8K</td>
                    </tr>
                                                        <tr class="transition hover:bg-gray-50/50 dark:hover:bg-white/2">
                        <td class="px-5 py-4 text-start sm:px-6">
                            <div class="flex items-center gap-3">
                                <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-21.jpg" alt="Carla George" class="aspect-square size-full rounded-full object-cover">
                                    <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">CG</span>
</template></span>
                                <div>
                                    <span class="block text-sm font-medium text-gray-800 dark:text-white/90">Carla George</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Front-end Developer</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">Website</td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <div data-slot="avatar-group"  class="group/avatar-group flex *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! -space-x-2"><span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-31.jpg" alt="Team member 1" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">1</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-32.jpg" alt="Team member 2" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">2</span>
</template></span>
                                                                    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-33.jpg" alt="Team member 3" class="aspect-square size-full rounded-full object-cover">
                                        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">3</span>
</template></span></div>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">
                            <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Active</span>
                        </td>
                        <td class="px-5 py-4 text-start text-sm text-gray-500 sm:px-6 dark:text-gray-400">4.5K</td>
                    </tr>
                            </tbody>
        </table>
    </div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Basic Table 2
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="card" data-size="default" x-data="tanstackTable('basic-table-two', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:\u00221\u0022,\u0022dealId\u0022:\u0022DE124321\u0022,\u0022user\u0022:{\u0022name\u0022:\u0022John Doe\u0022,\u0022email\u0022:\u0022johndeo@gmail.com\u0022,\u0022initials\u0022:\u0022JD\u0022,\u0022avatarClassName\u0022:\u0022bg-brand-50 text-brand-500 dark:bg-brand-500\\\/15 dark:text-brand-400\u0022},\u0022productName\u0022:\u0022Software License\u0022,\u0022dealValue\u0022:\u0022$18,50.34\u0022,\u0022closeDate\u0022:\u00222024-06-15\u0022,\u0022status\u0022:\u0022complete\u0022},{\u0022id\u0022:\u00222\u0022,\u0022dealId\u0022:\u0022DE124322\u0022,\u0022user\u0022:{\u0022name\u0022:\u0022Kierra Franci\u0022,\u0022email\u0022:\u0022kierra@gmail.com\u0022,\u0022initials\u0022:\u0022KF\u0022,\u0022avatarClassName\u0022:\u0022bg-pink-50 text-pink-600 dark:bg-pink-500\\\/15 dark:text-pink-400\u0022},\u0022productName\u0022:\u0022Software License\u0022,\u0022dealValue\u0022:\u0022$18,50.34\u0022,\u0022closeDate\u0022:\u00222024-06-15\u0022,\u0022status\u0022:\u0022complete\u0022},{\u0022id\u0022:\u00223\u0022,\u0022dealId\u0022:\u0022DE124323\u0022,\u0022user\u0022:{\u0022name\u0022:\u0022Emerson Workman\u0022,\u0022email\u0022:\u0022emerson@gmail.com\u0022,\u0022initials\u0022:\u0022EW\u0022,\u0022avatarClassName\u0022:\u0022bg-sky-50 text-sky-600 dark:bg-sky-500\\\/15 dark:text-sky-400\u0022},\u0022productName\u0022:\u0022Software License\u0022,\u0022dealValue\u0022:\u0022$18,50.34\u0022,\u0022closeDate\u0022:\u00222024-06-15\u0022,\u0022status\u0022:\u0022pending\u0022},{\u0022id\u0022:\u00224\u0022,\u0022dealId\u0022:\u0022DE124324\u0022,\u0022user\u0022:{\u0022name\u0022:\u0022Chance Philips\u0022,\u0022email\u0022:\u0022chance@gmail.com\u0022,\u0022initials\u0022:\u0022CP\u0022,\u0022avatarClassName\u0022:\u0022bg-orange-50 text-orange-600 dark:bg-orange-500\\\/15 dark:text-orange-400\u0022},\u0022productName\u0022:\u0022Software License\u0022,\u0022dealValue\u0022:\u0022$18,50.34\u0022,\u0022closeDate\u0022:\u00222024-06-15\u0022,\u0022status\u0022:\u0022complete\u0022},{\u0022id\u0022:\u00225\u0022,\u0022dealId\u0022:\u0022DE124325\u0022,\u0022user\u0022:{\u0022name\u0022:\u0022Terry Geidt\u0022,\u0022email\u0022:\u0022terry@gmail.com\u0022,\u0022initials\u0022:\u0022TG\u0022,\u0022avatarClassName\u0022:\u0022bg-green-50 text-green-600 dark:bg-green-500\\\/15 dark:text-green-400\u0022},\u0022productName\u0022:\u0022Software License\u0022,\u0022dealValue\u0022:\u0022$18,50.34\u0022,\u0022closeDate\u0022:\u00222024-06-15\u0022,\u0022status\u0022:\u0022complete\u0022}],\u0022extra\u0022:{\u0022statusConfig\u0022:{\u0022complete\u0022:{\u0022label\u0022:\u0022Complete\u0022,\u0022class\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\\\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]\u0022},\u0022pending\u0022:{\u0022label\u0022:\u0022Pending\u0022,\u0022class\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500\\\/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]\u0022},\u0022cancel\u0022:{\u0022label\u0022:\u0022Cancel\u0022,\u0022class\u0022:\u0022group\\\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\\u0026\\u003Esvg]:pointer-events-none [\\u0026\\u003Esvg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [\\u0026:has(\\u003Esvg:first-child)]:ps-1.5 [\\u0026:has(\\u003Esvg:last-child)]:pe-1.5 [\\u0026\\u003Esvg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500\\\/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]\u0022}}}}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Header Controls -->
    <div class="flex flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Recent Orders</div>
        </div>

        <div class="flex w-full items-center gap-3 sm:w-auto">
            <div class="flex-1 sm:w-64 sm:flex-initial md:w-72">
                <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center border bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 rounded-[10px] border-gray-300 dark:border-gray-700"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5 ps-3.5 pe-0"><svg class="size-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
                    <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"></div>
            </div>

            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex items-center justify-center border bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-transparent hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:bg-gray-800 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 shrink-0 gap-2 rounded-[10px] border-gray-300 px-4 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-white/5" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" class="size-5">
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                        Filter</button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="end"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;end&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="statusFilter === 'all' ? 'font-semibold text-brand-500 dark:text-brand-400' : ''" @click="statusFilter = 'all'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">All</div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="statusFilter === 'complete' ? 'font-semibold text-brand-500 dark:text-brand-400' : ''" @click="statusFilter = 'complete'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Complete</div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="statusFilter === 'pending' ? 'font-semibold text-brand-500 dark:text-brand-400' : ''" @click="statusFilter = 'pending'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Pending</div>
                                            <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    :class="statusFilter === 'cancel' ? 'font-semibold text-brand-500 dark:text-brand-400' : ''" @click="statusFilter = 'cancel'" class="group/dropdown-menu-item relative flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 outline-hidden transition-colors duration-200 select-none hover:bg-gray-100 hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400">Cancel</div></div>
    </div>
</template></div>
        </div>
    </div>

    <!-- Table Content -->
    <div class="max-w-full overflow-x-auto">
        <div class="min-w-175 2xl:min-w-202">
            <table class="min-w-full">
                <thead class="border-y border-gray-100 bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-3">
                                <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(isAllSelected) ? 'true' : 'false'"
    x-bind:data-state="Boolean(isAllSelected) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(isAllSelected) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(isAllSelected) })"
        aria-label="Select all orders" @change="handleSelectAll()" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(isAllSelected)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                <span>Deal ID</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Customer</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Product/Service</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Deal Value</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Close Date</th>
                        <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400">Action</th>
                    </tr>
                </thead>

                <tbody class="min-h-96 divide-y divide-gray-100 dark:divide-gray-800">
                    <template x-for="order in rows" :key="order.id">
                        <tr>
                            <td class="px-6 py-4 text-start">
                                <div class="flex items-center gap-3">
                                    <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(!!rowSelection[order.id]) ? 'true' : 'false'"
    x-bind:data-state="Boolean(!!rowSelection[order.id]) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(!!rowSelection[order.id]) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(!!rowSelection[order.id]) })"
        x-bind:aria-label="`Select deal ${order.dealId}`" @change="handleRowSelect(order.id)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(!!rowSelection[order.id])"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-400" x-text="order.dealId"></span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-start">
                                <div class="flex items-center gap-3">
                                    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-10"><template x-if="!loaded">
<span data-slot="avatar-fallback" :class="order.user.avatarClassName" class="flex items-center justify-center rounded-full bg-[#F3F4F6] text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400 size-full text-xs font-semibold select-none"><span x-text="order.user.initials"></span></span>
</template></span>
                                    <div>
                                        <span class="block text-sm font-medium text-gray-800 dark:text-white/90" x-text="order.user.name"></span>
                                        <span class="block text-sm text-gray-500 dark:text-gray-400" x-text="order.user.email"></span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-start"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="order.productName"></span></td>
                            <td class="px-6 py-4 text-start"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="order.dealValue"></span></td>
                            <td class="px-6 py-4 text-start"><span class="text-sm text-gray-700 dark:text-gray-400" x-text="order.closeDate"></span></td>

                            <td class="px-6 py-4 text-start">
                                <span data-slot="badge" x-bind:class="config(order.status).class" x-text="config(order.status).label"></span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button data-slot="button" type="button" aria-label="Delete order" @click="handleDelete(order.id)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-500"><svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg></button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="rows.length === 0" style="display: none;">
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
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
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">No orders found</h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search or filter to find what you're looking for.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div></div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Basic Table 3
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="card" data-size="default" x-data="tanstackTable('basic-table-three', JSON.parse('{\u0022rows\u0022:[{\u0022id\u0022:1,\u0022name\u0022:\u0022Bought PYPL\u0022,\u0022brand\u0022:\u0022paypal\u0022,\u0022date\u0022:\u0022Nov 23, 01:00 PM\u0022,\u0022price\u0022:\u0022$2,567.88\u0022,\u0022category\u0022:\u0022Finance\u0022,\u0022status\u0022:\u0022Success\u0022},{\u0022id\u0022:2,\u0022name\u0022:\u0022Bought AAPL\u0022,\u0022brand\u0022:\u0022apple\u0022,\u0022date\u0022:\u0022Nov 22, 09:00 PM\u0022,\u0022price\u0022:\u0022$3,987.45\u0022,\u0022category\u0022:\u0022Technology\u0022,\u0022status\u0022:\u0022Pending\u0022},{\u0022id\u0022:3,\u0022name\u0022:\u0022Netflix\u0022,\u0022brand\u0022:\u0022netflix\u0022,\u0022date\u0022:\u0022Oct 12, 03:54 PM\u0022,\u0022price\u0022:\u0022$6,754.99\u0022,\u0022category\u0022:\u0022Finance\u0022,\u0022status\u0022:\u0022Success\u0022},{\u0022id\u0022:4,\u0022name\u0022:\u0022Bought TSLA\u0022,\u0022brand\u0022:\u0022tesla\u0022,\u0022date\u0022:\u0022Sep 09, 02:00 AM\u0022,\u0022price\u0022:\u0022$1,445.41\u0022,\u0022category\u0022:\u0022Technology\u0022,\u0022status\u0022:\u0022Success\u0022},{\u0022id\u0022:5,\u0022name\u0022:\u0022Sell AMZN\u0022,\u0022brand\u0022:\u0022amazon\u0022,\u0022date\u0022:\u0022Feb 25, 08:00 PM\u0022,\u0022price\u0022:\u0022$5,698.55\u0022,\u0022category\u0022:\u0022Ecommerce\u0022,\u0022status\u0022:\u0022Failed\u0022},{\u0022id\u0022:6,\u0022name\u0022:\u0022Bought SPOT\u0022,\u0022brand\u0022:\u0022spotify\u0022,\u0022date\u0022:\u0022Jan 18, 11:20 AM\u0022,\u0022price\u0022:\u0022$1,280.00\u0022,\u0022category\u0022:\u0022Media\u0022,\u0022status\u0022:\u0022Success\u0022},{\u0022id\u0022:7,\u0022name\u0022:\u0022Sell ENVT\u0022,\u0022brand\u0022:\u0022envato\u0022,\u0022date\u0022:\u0022Jan 15, 04:30 PM\u0022,\u0022price\u0022:\u0022$840.50\u0022,\u0022category\u0022:\u0022Technology\u0022,\u0022status\u0022:\u0022Success\u0022}]}'))" class="group/card flex flex-col data-[size=sm]:p-4 w-full max-w-full min-w-0 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white p-0 sm:p-0 dark:border-gray-800 dark:bg-white/3"><!-- Table Header Controls -->
    <div class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div>
            <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">Latest Transactions</div>
        </div>

        <div class="flex w-full items-center gap-3 sm:w-auto">
            <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 flex-1 sm:w-75 sm:flex-initial"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
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
                <input type="text" data-slot="input-group-control" placeholder="Search..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div>

            <button data-slot="button" type="button"  class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 rounded-[10px] py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-10 shrink-0 px-3.5 text-gray-700 sm:px-4 sm:py-2.5 dark:text-gray-300"><svg class="size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8 2a.75.75 0 01.75.75v1h6.5v-1a.75.75 0 011.5 0v1h1.75A2.25 2.25 0 0120.75 6v13a2.25 2.25 0 01-2.25 2.25h-13A2.25 2.25 0 013.25 19V6A2.25 2.25 0 015.5 3.75h1.75v-1A.75.75 0 018 2zm0 3.25H5.5a.75.75 0 00-.75.75v2.25h14.5V6a.75.75 0 00-.75-.75H8zm11.25 4.5H4.75V19c0 .414.336.75.75.75h13a.75.75 0 00.75-.75V9.75z"
      fill="currentColor"
    />
  </svg>
                <span class="hidden sm:inline">05 Feb - 06 March</span></button>
        </div>
    </div>

    <!-- Table Content -->
    <div data-slot="card-content"  class="p-0"><div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-full">
                <thead class="border-y border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="h-11 min-w-44 py-3 ps-5 text-start text-sm font-normal text-gray-500 sm:ps-6 dark:text-gray-400">Name</th>
                        <th class="h-11 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400 min-w-44">Date</th>
                        <th class="h-11 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400 min-w-32">Price</th>
                        <th class="h-11 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400 min-w-36">Category</th>
                        <th class="h-11 px-4 py-3 text-start text-sm font-normal text-gray-500 dark:text-gray-400 min-w-28">Status</th>
                        <th class="h-11 min-w-16 py-3 pe-5 sm:pe-6"></th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                                                    <tr x-show="visibleIds[1]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#1b4bf1] text-white">
                                                                                    <svg class="size-4" width="21" height="24" viewBox="0 0 21 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      opacity="0.5"
      d="M18.427 6.976c.27-1.758 0-2.93-.944-4.013-1.034-1.217-2.922-1.713-5.35-1.713H5.166c-.495 0-.9.36-.99.857L1.256 20.594a.593.593 0 00.584.676h4.316l-.315 1.894c-.045.316.18.586.54.586h3.64c.45 0 .81-.316.855-.721l.764-4.78c.045-.406.45-.721.854-.721h.54c3.506 0 6.293-1.443 7.102-5.592.314-1.713.18-3.201-.72-4.193-.27-.316-.584-.541-.988-.767z"
      fill="#fff"
    />
    <path
      d="M18.427 6.976c.27-1.758 0-2.93-.944-4.013-1.034-1.217-2.922-1.713-5.35-1.713H5.166c-.495 0-.9.36-.99.857L1.256 20.594a.593.593 0 00.584.676h4.316l1.034-6.673c.09-.496.494-.857.989-.857h2.067c4.046 0 7.193-1.623 8.092-6.403.045-.09.045-.225.09-.36z"
      fill="#fff"
    />
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M19.62 7.346c0 .009-.004.025-.009.05a1.766 1.766 0 01-.067.278c-.507 2.585-1.651 4.463-3.347 5.674-1.69 1.208-3.777 1.642-5.952 1.642H8.392l-1.166 7.53H1.839c-1.143 0-1.959-1.006-1.825-2.08l.003-.021L2.944 1.898l.003-.014C3.136.84 4.019 0 5.166 0h6.967c2.503 0 4.886.493 6.297 2.148.586.674.994 1.415 1.197 2.283.2.854.185 1.758.035 2.735l-.016.104-.025.076zm-2.137-4.383c-1.034-1.217-2.922-1.713-5.35-1.713H5.166c-.495 0-.9.36-.99.857L1.256 20.594a.593.593 0 00.584.676h4.316l1.033-6.673c.09-.496.495-.857.99-.857h2.067c4.046 0 7.193-1.623 8.092-6.403a.687.687 0 00.047-.179c.01-.057.022-.12.043-.182.27-1.758 0-2.93-.944-4.013z"
      fill="#1B4BF1"
    />
    <path
      d="M8.402 7.022c.045-.316.45-.722.854-.722h5.485c.629 0 1.258.045 1.798.135.494.09 1.393.316 1.843.587.27-1.759 0-2.931-.944-4.013-.99-1.263-2.877-1.759-5.305-1.759H5.166c-.495 0-.9.36-.99.857L1.256 20.594a.593.593 0 00.584.676h4.316L8.402 7.022z"
      fill="#fff"
    />
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Bought PYPL</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Nov 23, 01:00 PM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$2,567.88</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Finance</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[2]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-black dark:bg-white">
                                                                                    <svg class="size-4 text-white dark:text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
    <path
      d="M16.953 6.822c-.096.055-2.37 1.231-2.37 3.838.108 2.973 2.87 4.015 2.917 4.015-.047.056-.417 1.42-1.512 2.85C15.12 18.759 14.155 20 12.691 20c-1.393 0-1.893-.821-3.5-.821-1.726 0-2.214.821-3.536.821-1.464 0-2.5-1.309-3.416-2.53C1.05 15.874.037 13.367.002 10.96-.023 9.683.24 8.43.906 7.364c.94-1.487 2.619-2.496 4.452-2.53 1.404-.043 2.654.9 3.512.9.821 0 2.357-.9 4.094-.9.75.001 2.75.212 3.989 1.987zM8.75 4.582c-.25-1.166.44-2.33 1.083-3.074C10.655.61 11.953 0 13.07 0c.072 1.165-.38 2.307-1.19 3.14-.726.898-1.976 1.574-3.13 1.441z"
      fill="currentColor"
    />
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Bought AAPL</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Nov 22, 09:00 PM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$3,987.45</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Technology</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="warning" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]">Pending</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[3]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-black text-white">
                                                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
    <g clip-path="url(#svgqYM0EZDL-clip0_7491_271436)">
      <path d="M7.515 0H4.07v18c1.13-.268 2.31-.402 3.445-.452V0z" fill="#C20000" />
      <path
        d="M7.515 0H4.07v13.773c1.13-.268 2.31-.402 3.445-.452V0z"
        fill="url(#svgqYM0EZDL-paint0_linear_7491_271436)"
      />
      <path d="M13.93 18V0h-3.445v17.584c2.011.128 3.445.416 3.445.416z" fill="#C20000" />
      <path
        d="M13.93 18V6.054h-3.445v11.53c2.011.128 3.445.416 3.445.416z"
        fill="url(#svgqYM0EZDL-paint1_linear_7491_271436)"
      />
      <path d="M13.93 18L7.515 0H4.07l6.263 17.575c2.091.122 3.597.425 3.597.425z" fill="#FA0000" />
    </g>
    <defs>
      <linearGradient
        id="svgqYM0EZDL-paint0_linear_7491_271436"
        x1="3.45535"
        y1="8.42411"
        x2="6.01945"
        y2="6.48893"
        gradientUnits="userSpaceOnUse"
      >
        <stop stop-color="#C20000" stop-opacity="0" />
        <stop offset="1" stop-color="#9D0000" />
      </linearGradient>
      <linearGradient
        id="svgqYM0EZDL-paint1_linear_7491_271436"
        x1="14.4293"
        y1="11.1013"
        x2="12.1071"
        y2="12.0689"
        gradientUnits="userSpaceOnUse"
      >
        <stop stop-color="#C20000" stop-opacity="0" />
        <stop offset="1" stop-color="#9D0000" />
      </linearGradient>
      <clipPath id="svgqYM0EZDL-clip0_7491_271436">
        <path fill="#fff" d="M0 0H18V18H0z" />
      </clipPath>
    </defs>
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Netflix</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Oct 12, 03:54 PM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$6,754.99</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Finance</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[4]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#E82127]">
                                                                                    <svg class="size-4 text-white" width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M10.522 20.952l2.944-16.556c2.806 0 3.69.308 3.819 1.564 0 0 1.882-.702 2.831-2.127-3.704-1.717-7.427-1.794-7.427-1.794l-2.172 2.645h.005L8.35 2.038S4.628 2.116.923 3.832C1.872 5.258 3.755 5.96 3.755 5.96c.128-1.256 1.012-1.564 3.8-1.566l2.967 16.558z"
      fill="currentColor"
    />
    <path
      d="M10.521 1.275c2.995-.023 6.422.463 9.932 1.992.469-.844.59-1.217.59-1.217A28.803 28.803 0 0010.52 0 28.798 28.798 0 000 2.05s.171.46.59 1.217c3.508-1.53 6.936-2.015 9.93-1.992h.001z"
      fill="currentColor"
    />
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Bought TSLA</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Sep 09, 02:00 AM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$1,445.41</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Technology</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[5]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-black">
                                                                                    <svg class="size-4.5 text-white" xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 25 22" fill="none">
    <g clip-path="url(#svgojKEDqPP-clip0_7491_271179)">
      <path
        d="M6.666 10.802c0-1.012.25-1.877.748-2.596.499-.719 1.18-1.261 2.046-1.628.792-.337 1.767-.579 2.926-.726a76.973 76.973 0 011.936-.176v-.374c0-.939-.102-1.57-.308-1.892-.308-.44-.792-.66-1.452-.66h-.176a2.408 2.408 0 00-1.254.462c-.352.264-.58.63-.682 1.1-.059.293-.205.462-.44.506L7.48 4.51c-.25-.059-.374-.19-.374-.396 0-.044.007-.095.022-.154.25-1.305.861-2.273 1.837-2.904C9.94.426 11.08.073 12.386 0h.55c1.672 0 2.977.433 3.916 1.298.147.147.284.305.407.473.125.168.224.319.297.45.073.133.14.324.198.573.059.25.103.422.132.517.03.095.052.3.066.616.015.315.022.502.022.56v5.325c0 .381.055.73.165 1.045.11.315.217.543.319.682.102.14.271.363.506.67.088.133.132.25.132.353 0 .117-.059.22-.176.308a1156.917 1156.917 0 01-1.98 1.716c-.176.132-.389.147-.638.044a7.579 7.579 0 01-.54-.506 18.803 18.803 0 01-.33-.352 4.87 4.87 0 01-.318-.429 9.073 9.073 0 00-.308-.429c-.821.895-1.628 1.452-2.42 1.672-.499.147-1.115.22-1.848.22-1.13 0-2.057-.348-2.783-1.045s-1.089-1.683-1.089-2.959zm3.784-.44c0 .572.143 1.03.429 1.375.286.345.67.517 1.155.517.044 0 .106-.007.187-.022.08-.015.136-.022.165-.022.616-.161 1.093-.557 1.43-1.188.161-.279.282-.583.363-.913.08-.33.125-.598.132-.803.007-.205.011-.543.011-1.012v-.55c-.85 0-1.496.059-1.936.176-1.29.367-1.936 1.18-1.936 2.442z"
        fill="#fff"
      />
      <path
        d="M19.69 17.446a.69.69 0 01.132-.176 3.45 3.45 0 011.056-.506 7.185 7.185 0 011.628-.242c.147-.015.286-.007.418.022.66.058 1.056.169 1.188.33.059.088.088.22.088.396v.154c0 .513-.14 1.118-.418 1.815-.279.697-.667 1.258-1.166 1.683-.073.059-.14.088-.198.088a.195.195 0 01-.088-.022c-.088-.044-.11-.125-.066-.242.543-1.276.814-2.163.814-2.662 0-.161-.03-.279-.088-.352-.147-.176-.557-.264-1.232-.264-.25 0-.543.014-.88.044a45.83 45.83 0 00-1.012.132c-.088 0-.147-.015-.176-.044-.03-.03-.037-.059-.022-.088 0-.015.007-.037.022-.066zM.044 17.072c.073-.117.19-.124.352-.022 3.667 2.127 7.656 3.19 11.968 3.19 2.875 0 5.713-.535 8.514-1.606a17.473 17.473 0 00.616-.264c.22-.088.392-.044.517.132s.085.338-.12.484c-.265.19-.602.41-1.013.66-1.261.748-2.67 1.328-4.224 1.738-1.555.411-3.073.616-4.554.616-2.288 0-4.451-.4-6.49-1.199a17.88 17.88 0 01-5.478-3.377c-.088-.073-.132-.147-.132-.22 0-.044.015-.088.044-.132z"
        fill="#F90"
      />
    </g>
    <defs>
      <clipPath id="svgojKEDqPP-clip0_7491_271179">
        <path fill="#fff" d="M0 0H24.1998V22H0z" />
      </clipPath>
    </defs>
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Sell AMZN</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Feb 25, 08:00 PM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$5,698.55</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Ecommerce</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">Failed</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[6]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#1DB954]">
                                                                                    <svg class="size-4 text-white" xmlns="http://www.w3.org/2000/svg" width="28" height="19" viewBox="0 0 28 19" fill="none">
    <path
      d="M25.781 7.32c-.406 0-.656-.101-1.008-.304-5.562-3.32-15.507-4.118-21.945-2.32-.281.077-.633.202-1.008.202C.79 4.898 0 4.094 0 3.055 0 1.992.656 1.39 1.36 1.187 4.11.383 7.187 0 10.54 0c5.702 0 11.679 1.188 16.046 3.734.61.352 1.008.836 1.008 1.766a1.81 1.81 0 01-1.813 1.82zm-2.422 5.953c-.406 0-.68-.18-.96-.328-4.883-2.89-12.165-4.054-18.641-2.297-.375.102-.578.204-.93.204-.836 0-1.515-.68-1.515-1.516s.406-1.39 1.21-1.617c2.172-.61 4.391-1.063 7.641-1.063 5.07 0 9.969 1.258 13.828 3.555.633.375.883.86.883 1.539-.008.844-.664 1.523-1.516 1.523zm-2.101 5.125c-.328 0-.531-.101-.836-.28-4.875-2.938-10.547-3.063-16.149-1.915-.304.078-.703.203-.93.203-.757 0-1.234-.601-1.234-1.234 0-.805.477-1.188 1.063-1.313 6.398-1.414 12.937-1.289 18.515 2.047.477.305.758.578.758 1.29a1.18 1.18 0 01-1.187 1.202z"
      fill="currentColor"
    />
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Bought SPOT</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Jan 18, 11:20 AM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$1,280.00</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Media</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                                                    <tr x-show="visibleIds[7]" class="h-16 border-b border-gray-100 dark:border-gray-800">
                            <td class="min-w-44 py-3 ps-5 text-start sm:ps-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#82B541]">
                                                                                    <svg class="size-3.5 text-white" xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18" fill="none">
    <path
      d="M13.123 13.013l-5.04.54a.092.092 0 01-.065-.165l4.93-3.84c.319-.262.525-.668.438-1.106-.088-.669-.64-1.106-1.34-1.019l-5.36.785c-.093.012-.143-.107-.068-.166l5.312-4.056c1.046-.815 1.134-2.415.175-3.346-.872-.872-2.272-.844-3.144.028L.403 9.376a1.52 1.52 0 00-.378 1.31c.147.787.931 1.309 1.718 1.165l4.615-.94c.1-.022.154.112.07.168l-5.119 3.278c-.64.406-.931 1.134-.728 1.862.203.96 1.166 1.512 2.097 1.281l7.652-1.884a.091.091 0 01.094.147L9.23 17.238c-.319.406.203.96.64.64l3.931-3.23c.7-.582.235-1.719-.668-1.631l-.01-.004z"
      fill="currentColor"
    />
  </svg>
                                                                            </div>
                                    <span class="text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white/90">Sell ENVT</span>
                                </div>
                            </td>
                            <td class="min-w-44 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Jan 15, 04:30 PM</td>
                            <td class="min-w-32 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">$840.50</td>
                            <td class="min-w-36 px-4 py-3 text-start text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">Technology</td>
                            <td class="min-w-28 px-4 py-3 text-start text-sm whitespace-nowrap">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                            <td class="min-w-16 py-3 pe-5 text-end whitespace-nowrap sm:pe-6">
                                <button data-slot="button" type="button" aria-label="More options" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg></button>
                            </td>
                        </tr>
                                        <tr x-show="totalEntries === 0" style="display: none;">
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
                                <h4 class="text-base font-semibold text-gray-800 dark:text-white/90">No transactions found</h4>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search to find what you're looking for.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table></div>
    </div>
</div></div>

    <!-- Table Footer - Pagination -->
    <div
    x-data="{
        classes: JSON.parse('{\u0022link\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]\u0022,\u0022linkActive\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500\\\/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-10 rounded-[10px]\u0022,\u0022nav\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px]\u0022,\u0022navDisabled\u0022:\u0022group\\\/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500\\\/20 dark:aria-invalid:border-red-500\\\/50 dark:aria-invalid:ring-red-500\\\/40 [\\u0026_svg]:pointer-events-none [\\u0026_svg]:shrink-0 [\\u0026_svg:not([class*=\\u0027size-\\u0027])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300\\\/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700\\\/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-10 rounded-[10px] pointer-events-none cursor-not-allowed opacity-50\u0022}'),
    }"
    class="border-t-0 px-5 py-4 sm:px-6"
>
    <!-- Mobile Pagination (< sm) -->
    <div class="flex w-full items-center justify-between sm:hidden">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-400">
            <span x-text="currentPage"></span>/<span x-text="totalPages"></span>
        </span>

        <div class="flex items-center gap-2">
            <a href="#" aria-label="Go to previous page" data-slot="pagination-link" :class="currentPage <= 1 ? classes.navDisabled : classes.nav" :aria-disabled="currentPage <= 1 ? 'true' : null" @click.prevent="goPrevious()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-start" class="rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
            </a>
            <a href="#" aria-label="Go to next page" data-slot="pagination-link" :class="currentPage >= totalPages ? classes.navDisabled : classes.nav" :aria-disabled="currentPage >= totalPages ? 'true' : null" @click.prevent="goNext()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-end" class="rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
            </a>
        </div>
    </div>

    <!-- Desktop Pagination (>= sm) -->
    <div class="hidden sm:flex sm:items-center sm:justify-start">
        <nav role="navigation" aria-label="pagination" data-slot="pagination"  class="flex mx-0 w-auto justify-start"><ul data-slot="pagination-content"  class="flex items-center gap-1.5"><li data-slot="pagination-item"><a href="#" aria-label="Go to previous page" data-slot="pagination-link" :class="currentPage <= 1 ? classes.navDisabled : classes.nav" :aria-disabled="currentPage <= 1 ? 'true' : null" @click.prevent="goPrevious()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-start" class="rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg>
                    </a></li>

                <template x-for="(item, index) in pages" :key="typeof item === 'number' ? item : `ellipsis-${index}`">
                    <li data-slot="pagination-item"><template x-if="typeof item === 'string'">
                            <span aria-hidden="true" data-slot="pagination-ellipsis"  class="flex size-8 items-center justify-center dark:text-white/90 [&amp;_svg:not([class*=size-])]:size-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <circle cx="12" cy="12" r="1" />
    <circle cx="19" cy="12" r="1" />
    <circle cx="5" cy="12" r="1" />
  </svg>
<span class="sr-only">More pages</span></span>
                        </template>
                        <template x-if="typeof item === 'number'">
                            <a href="#" data-slot="pagination-link" :data-active="currentPage === item ? 'true' : 'false'" :aria-current="currentPage === item ? 'page' : null" :class="currentPage === item ? classes.linkActive : classes.link" @click.prevent="currentPage = item" x-text="item"></a>
                        </template></li>
                </template>

                <li data-slot="pagination-item"><a href="#" aria-label="Go to next page" data-slot="pagination-link" :class="currentPage >= totalPages ? classes.navDisabled : classes.nav" :aria-disabled="currentPage >= totalPages ? 'true' : null" @click.prevent="goNext()">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" data-icon="inline-end" class="rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg>
                    </a></li></ul></nav>
    </div>
</div></div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Basic Table 4
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-4 pb-3 sm:px-6 dark:border-gray-800 dark:bg-white/3">
    <div class="mb-4 flex justify-between gap-2 sm:items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Featured Campaigns</h3>
        </div>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"   class="dropdown-toggle" ><svg class="text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-40 p-2"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer items-center gap-3 px-3 py-2.5 text-sm outline-hidden transition-colors duration-200 select-none focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full rounded-lg text-start font-normal text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">View More</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative cursor-pointer items-center gap-3 px-3 py-2.5 text-sm outline-hidden transition-colors duration-200 select-none focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 flex w-full rounded-lg text-start font-normal text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300">Delete</div></div>
    </div>
</template></div>
    </div>

    <div class="custom-scrollbar max-w-full overflow-x-auto">
        <div class="min-w-full">
            <table class="min-w-full">
                <!-- Table Header -->
                <thead class="border-y border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Products</th>
                        <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Campaign</th>
                        <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-01.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-01.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Grow your brand by...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                        </tr>
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-02.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-02.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Make Better Ideas...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="warning" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-amber-50 text-amber-600 [text-shadow:0_4px_4px_rgba(254,223,137,0.60)] dark:bg-amber-500/15 dark:text-orange-400 dark:[text-shadow:0_4px_4px_rgba(247,144,9,0.20)]">Pending</span>
                            </td>
                        </tr>
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-03.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-03.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Increase your website tra...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                        </tr>
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-04.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-04.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Grow your brand by...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="error" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)]">Failed</span>
                            </td>
                        </tr>
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-05.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-05.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Grow your brand by...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                        </tr>
                                            <tr>
                            <td class="py-3">
                                <div class="flex items-center gap-4.5">
                                    <div class="h-10 w-10 overflow-hidden rounded-full">
                                        <img width="40" height="40" src="/assets/images/user/user-06.jpg" alt="Wilson Gouse" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700 dark:text-gray-400">Wilson Gouse</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="flex w-full items-center gap-5">
                                    <div class="w-full max-w-8">
                                        <img width="40" height="40" src="/assets/images/brand/brand-06.svg" alt="brand" />
                                    </div>
                                    <div class="truncate">
                                        <p class="mb-0.5 truncate text-sm font-medium text-gray-700 dark:text-gray-400">Grow your brand by...</p>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Ads campaign</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                <span data-slot="badge" data-variant="light" data-color="success" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]">Success</span>
                            </td>
                        </tr>
                                    </tbody>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Basic Table 5
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pt-4 pb-3 sm:px-6 dark:border-gray-800 dark:bg-white/3">
    <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Orders</h3>
        </div>

        <div class="flex items-center gap-3">
            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" >
    <path
      d="M14.653 5.905a2.57 2.57 0 00-5.141 0m5.141 0a2.57 2.57 0 01-5.141 0m5.141 0h3.055m-8.196 0h-7.22m3.055 8.192a2.57 2.57 0 015.141 0m-5.141 0a2.57 2.57 0 005.141 0m-5.141 0H2.292m8.196 0h7.22"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
                Filter</button>
            <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3">See all</button>
        </div>
    </div>

    <div class="-mx-4 overflow-x-auto sm:-mx-6">
        <table class="min-w-full">
            <!-- Table Header -->
            <thead class="border-y border-gray-100 dark:border-gray-800">
                <tr>
                    <th class="py-3 ps-4 text-start text-xs font-medium text-gray-500 sm:ps-6 dark:text-gray-400">Products</th>
                    <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Category</th>
                    <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Country</th>
                    <th class="py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">CR</th>
                    <th class="py-3 pe-4 text-start text-xs font-medium text-gray-500 sm:pe-6 dark:text-gray-400">Value</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">TailGrids</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">UI Kits</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/usa.png" class="h-5 w-5 rounded-sm object-fill" alt="TailGrids" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$12,499</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">GrayGrids</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Templates</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/yemen.png" class="h-5 w-5 rounded-sm object-fill" alt="GrayGrids" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$5498</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">Uideck</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Templates</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/sudan.png" class="h-5 w-5 rounded-sm object-fill" alt="Uideck" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$4621</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">FormBold</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">SaaS</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/bangladesh.png" class="h-5 w-5 rounded-sm object-fill" alt="FormBold" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$13843</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">NextAdmin</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Templates</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/switzerland.png" class="h-5 w-5 rounded-sm object-fill" alt="NextAdmin" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$7523</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">Form Builder</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Templates</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/norway.png" class="h-5 w-5 rounded-sm object-fill" alt="Form Builder" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$1,377</td>
                    </tr>
                                    <tr>
                        <td class="py-3 ps-4 text-start text-sm font-medium text-gray-800 sm:ps-6 dark:text-white/90">AyroUI</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Templates</td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">
                            <div class="h-5 w-5">
                                <img src="/assets/images/flag/france.png" class="h-5 w-5 rounded-sm object-fill" alt="AyroUI" width="20" height="20" />
                            </div>
                        </td>
                        <td class="py-3 text-start text-sm text-gray-500 dark:text-gray-400">Dashboard</td>
                        <td class="py-3 pe-4 text-start text-sm font-medium text-green-600 sm:pe-6 dark:text-green-500">$599,00</td>
                    </tr>
                            </tbody>
        </table>
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
