<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Avatar
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
                Avatar
            </li>
        </ol>
    </nav>
</div>
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Default Avatar
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="sm" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="xl" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Avatar Group
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div data-slot="avatar-group"  class="group/avatar-group flex -space-x-2 *:data-[slot=avatar]:ring-2 *:data-[slot=avatar]:ring-white dark:*:data-[slot=avatar]:ring-gray-800 dark:**:data-[slot=avatar-fallback]:bg-[#192130]! mx-auto w-fit"><span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-02.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-03.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-04.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-05.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template></span>
    <div data-slot="avatar-group-count"  class="relative flex size-10 shrink-0 items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 ring-2 ring-white group-has-data-[size=lg]/avatar-group:size-12 group-has-data-[size=sm]/avatar-group:size-8 group-has-data-[size=xl]/avatar-group:size-14 group-has-data-[size=xs]/avatar-group:size-6 dark:bg-[#192130] dark:text-gray-400 dark:ring-gray-800 [&amp;&gt;svg]:size-4 group-has-data-[size=lg]/avatar-group:[&amp;&gt;svg]:size-5 group-has-data-[size=sm]/avatar-group:[&amp;&gt;svg]:size-3">2+</div></div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Avatar with Online Indicator
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="sm" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="xl" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="online"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Avatar with Offline Indicator
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="sm" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="xl" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="offline"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
</div>
        </div>
    </div>
</div>        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <!-- Card Header -->
    <div class="px-6 py-5">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Avatar with Busy Indicator
        </h3>
            </div>

    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            <div class="flex flex-col items-center justify-center gap-5 sm:flex-row">
    <span data-slot="avatar" data-size="xs" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="busy"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="sm" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="busy"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="busy"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="busy"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    <span data-slot="avatar" data-size="xl" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-01.jpg" alt="user one" class="aspect-square size-full rounded-full object-cover">
        <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">U1</span>
</template>
        <span data-slot="avatar-badge" data-variant="busy"  class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
</div>
        </div>
    </div>
</div>    </div>

            </div>
        </div>

    </div>

</body>


</html>
