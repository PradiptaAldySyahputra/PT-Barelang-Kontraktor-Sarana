<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Chats
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
                Chats
            </li>
        </ol>
    </nav>
</div>
        <div
    data-slot="sidebar-wrapper"
    x-data="{
        users: JSON.parse('[{\u0022id\u0022:1,\u0022name\u0022:\u0022Lindsey Curtis\u0022,\u0022role\u0022:\u0022Designer\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022status\u0022:\u0022online\u0022,\u0022lastActive\u0022:\u00222026-11-13T10:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022Please preview the image\u0022,\u0022unreadCount\u0022:2},{\u0022id\u0022:2,\u0022name\u0022:\u0022Kaiya George\u0022,\u0022role\u0022:\u0022Project Manager\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022status\u0022:\u0022online\u0022,\u0022lastActive\u0022:\u00222026-11-13T09:48:59.035Z\u0022,\u0022lastMessage\u0022:\u0022I want to make an appointment tomorrow from 2:00 to 5:00pm?\u0022},{\u0022id\u0022:3,\u0022name\u0022:\u0022Zain Geidt\u0022,\u0022role\u0022:\u0022Content Writer\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-19.jpg\u0022,\u0022status\u0022:\u0022offline\u0022,\u0022lastActive\u0022:\u00222026-11-13T09:18:59.035Z\u0022,\u0022lastMessage\u0022:\u0022The updated knowledge base article is live\u0022},{\u0022id\u0022:4,\u0022name\u0022:\u0022Carla George\u0022,\u0022role\u0022:\u0022Front-end Developer\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-05.jpg\u0022,\u0022status\u0022:\u0022busy\u0022,\u0022lastActive\u0022:\u00222026-11-11T10:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022I will push the component fixes tonight\u0022},{\u0022id\u0022:5,\u0022name\u0022:\u0022Abram Schleifer\u0022,\u0022role\u0022:\u0022Digital Marketer\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-20.jpg\u0022,\u0022status\u0022:\u0022online\u0022,\u0022lastActive\u0022:\u00222026-11-13T09:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022All campaign analytics reports are ready\u0022},{\u0022id\u0022:6,\u0022name\u0022:\u0022Lincoln Donin\u0022,\u0022role\u0022:\u0022Product Designer\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-34.jpg\u0022,\u0022status\u0022:\u0022online\u0022,\u0022lastActive\u0022:\u00222026-11-10T10:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022Updated mobile responsive mockups for review\u0022},{\u0022id\u0022:7,\u0022name\u0022:\u0022Erin Geidthem\u0022,\u0022role\u0022:\u0022Copywriter\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-35.jpg\u0022,\u0022status\u0022:\u0022online\u0022,\u0022lastActive\u0022:\u00222026-11-08T10:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022Please check the revised email copies\u0022},{\u0022id\u0022:8,\u0022name\u0022:\u0022Alena Baptista\u0022,\u0022role\u0022:\u0022SEO Expert\u0022,\u0022avatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-36.jpg\u0022,\u0022status\u0022:\u0022offline\u0022,\u0022lastActive\u0022:\u00222026-11-13T08:03:59.035Z\u0022,\u0022lastMessage\u0022:\u0022Monthly audit completed without critical issues\u0022}]'),
        messages: JSON.parse('[{\u0022id\u0022:1,\u0022senderId\u0022:2,\u0022senderName\u0022:\u0022Kaiya George\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022timestamp\u0022:\u00222026-11-13T09:48:59.035Z\u0022,\u0022message\u0022:\u0022I want to make an appointment tomorrow from 2:00 to 5:00pm?\u0022,\u0022isSender\u0022:false},{\u0022id\u0022:2,\u0022senderId\u0022:1,\u0022senderName\u0022:\u0022Lindsey Curtis\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022timestamp\u0022:\u00222026-11-13T09:33:59.035Z\u0022,\u0022message\u0022:\u0022I want to make an appointment tomorrow from 2:00 to 5:00pm?\u0022,\u0022isSender\u0022:false},{\u0022id\u0022:3,\u0022senderId\u0022:\u0022current-user\u0022,\u0022senderName\u0022:\u0022You\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/owner.png\u0022,\u0022timestamp\u0022:\u00222026-11-13T08:03:59.035Z\u0022,\u0022message\u0022:\u0022If don\\u0027t like something, I\\u0027ll stay away from it.\u0022,\u0022isSender\u0022:true},{\u0022id\u0022:4,\u0022senderId\u0022:1,\u0022senderName\u0022:\u0022Lindsey Curtis\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022timestamp\u0022:\u00222026-11-13T08:03:59.035Z\u0022,\u0022message\u0022:\u0022I want more detailed information.\u0022,\u0022isSender\u0022:false},{\u0022id\u0022:5,\u0022senderId\u0022:\u0022current-user\u0022,\u0022senderName\u0022:\u0022You\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/owner.png\u0022,\u0022timestamp\u0022:\u00222026-11-13T08:03:59.035Z\u0022,\u0022message\u0022:\u0022They got there early, and got really good seats.\u0022,\u0022isSender\u0022:true},{\u0022id\u0022:6,\u0022senderId\u0022:1,\u0022senderName\u0022:\u0022Lindsey Curtis\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-17.jpg\u0022,\u0022timestamp\u0022:\u00222026-11-13T08:03:59.035Z\u0022,\u0022message\u0022:\u0022Please preview the image\u0022,\u0022isSender\u0022:false,\u0022imagePreview\u0022:\u0022\\\/assets\\\/images\\\/chat\\\/chat.jpg\u0022}]'),
        activeUserId: 1,
        searchQuery: '',
        openMobile: false,
        get activeUser() { return this.users.find((user) => user.id === this.activeUserId); },
        get filteredUsers() {
            const query = this.searchQuery.toLowerCase();
            return this.users.filter((user) => user.name.toLowerCase().includes(query) || user.role.toLowerCase().includes(query));
        },
        selectUser(user) {
            this.activeUserId = user.id;
            this.openMobile = false;
        },
        sendMessage(text) {
            this.messages = [...this.messages, {
                id: Date.now(),
                senderId: 'current-user',
                senderName: 'You',
                senderAvatar: '/assets/images/user/owner.png',
                isSender: true,
                message: text,
                timestamp: new Date().toISOString(),
            }];
            this.$nextTick(() => this.scrollToBottom(true));
        },
        scrollToBottom(smooth) {
            const viewport = document.getElementById('chat-message-bottom')?.closest('[data-slot=scroll-area-viewport]');
            viewport?.scrollTo({ top: viewport.scrollHeight, behavior: smooth ? 'smooth' : 'auto' });
        },
        // Keep following the bottom while the list is still growing (new rows, late-loading images)
        stickToBottom(ms) {
            const content = document.getElementById('chat-message-bottom')?.parentElement;
            if (!content) return;
            this.stickUntil = Date.now() + ms;
            if (this.stickObserver) return;
            this.stickObserver = new ResizeObserver(() => {
                if (Date.now() < this.stickUntil) this.scrollToBottom(false);
            });
            this.stickObserver.observe(content);
        },
        distance(timestamp, addSuffix) {
            if (!timestamp) return '';
            const date = new Date(timestamp);
            if (isNaN(date.getTime())) return String(timestamp);
            const seconds = Math.abs((Date.now() - date.getTime()) / 1000);
            if (seconds < 60) return 'Just now';
            const units = [['year', 31536000], ['month', 2592000], ['day', 86400], ['hour', 3600], ['minute', 60]];
            let label = '';
            for (const [unit, size] of units) {
                const count = Math.round(seconds / size);
                if (seconds >= size || unit === 'minute') {
                    label = count + ' ' + unit + (count === 1 ? '' : 's');
                    break;
                }
            }
            return addSuffix ? label + ' ago' : label;
        },
        formatMessageTime(timestamp) { return this.distance(timestamp, true); },
        formatLastActive(timestamp) { return this.distance(timestamp, false); },
    }"
    x-init="$nextTick(() => { scrollToBottom(false); stickToBottom(1500); })"
    x-on:keydown.escape.window="openMobile = false"
    class="group/sidebar-wrapper flex has-data-[variant=inset]:bg-gray-50 h-full min-h-0 min-w-0 w-full flex-1"
>
    <div class="flex h-[calc(100vh-174px)] min-h-0 min-w-0 w-full flex-1 flex-col gap-4 sm:gap-5 xl:flex-row">
        <div
    class="flex shrink-0 items-center justify-between rounded-2xl border border-gray-200 bg-white p-3 ps-5 xl:hidden dark:border-gray-800 dark:bg-gray-900"
>
    <span class="text-lg font-medium text-gray-800 dark:text-white/90"> Chats </span>

    <button data-slot="button" type="button" aria-label="Open conversation list" x-on:click="openMobile = !openMobile" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <path
      d="M4 6h16M4 18h16M4 12h16"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
    />
  </svg></button>
</div>
        <div
    data-slot="sidebar"
    class="hidden h-full w-80 shrink-0 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white text-gray-900 xl:flex dark:border-gray-800 dark:bg-white/3"
>
    <div class="flex items-center justify-between p-4 pb-0 sm:p-5 sm:pb-0">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Messages</h3>
    <button data-slot="button" type="button" aria-label="Menu" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4"
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
</div>
    <div class="px-4 py-3 sm:px-5">
    <div class="relative">
        <svg class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <input data-slot="input" type="text" placeholder="Search conversation..." x-model="searchQuery" class="w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-10 ps-9" />
    </div>
</div>
    <div class="custom-scrollbar min-h-0 flex-1 overflow-y-auto">
        <div class="space-y-1 p-3">
    <template x-if="filteredUsers.length === 0">
        <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">No conversations found</div>
    </template>
    <template x-for="user in filteredUsers" x-bind:key="user.id">
        <div
    role="button"
    tabindex="0"
    class="flex w-full cursor-pointer items-center gap-3 rounded-xl p-3 outline-hidden transition-colors"
    x-bind:class="user.id === activeUserId ? 'bg-gray-100 dark:bg-white/5' : 'hover:bg-gray-50 dark:hover:bg-white/3'"
    x-on:click="selectUser(user)"
    x-on:keydown.enter.prevent="selectUser(user)"
    x-on:keydown.space.prevent="selectUser(user)"
>
    <div class="relative shrink-0">
        <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="user.avatar" x-bind:alt="user.name" class="aspect-square size-full rounded-full object-cover">
            <template x-if="!loaded">
<span data-slot="avatar-fallback" x-text="user.name.charAt(0)" class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"></span>
</template>
            <span data-slot="avatar-badge" data-variant="online" x-bind:data-variant="user.status" class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    </div>

    <div class="min-w-0 flex-1">
        <div class="flex items-center justify-between gap-1">
            <h5 class="min-w-0 truncate text-sm font-medium text-gray-800 dark:text-white/90" x-text="user.name"></h5>
            <span class="shrink-0 text-xs text-gray-400 dark:text-gray-500" x-text="formatLastActive(user.lastActive)"></span>
        </div>

        <div class="mt-0.5 flex items-center justify-between gap-2">
            <p class="min-w-0 truncate text-xs text-gray-500 dark:text-gray-400" x-text="user.lastMessage || user.role"></p>
            <template x-if="user.unreadCount && user.unreadCount > 0">
                <span
                    class="flex h-4 min-w-4 shrink-0 items-center justify-center rounded-full bg-brand-500 px-1 text-[10px] font-medium text-white"
                    x-text="user.unreadCount"
                ></span>
            </template>
        </div>
    </div>
</div>
    </template>
</div>
    </div>
</div>


<template x-teleport="body">
    <div x-data x-show="openMobile" style="display: none;" class="xl:hidden">
        <div
            data-slot="sheet-overlay"
            class="fixed inset-0 isolate z-100 bg-black/50 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70"
            x-show="openMobile"
            x-transition.opacity.duration.200ms
            x-on:click="openMobile = false"
        ></div>
        <div
            data-slot="sheet-content"
            data-side="left"
            role="dialog"
            class="fixed inset-y-0 start-0 z-101 flex h-full w-3/4 flex-col gap-4 border-e border-gray-200 bg-white p-0 text-sm text-gray-700 shadow-theme-lg outline-none sm:max-w-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 flex w-80 flex-col text-gray-900"
            x-show="openMobile"
            x-transition:enter="transition-transform duration-200 ease-in-out"
            x-transition:enter-start="ltr:-translate-x-full rtl:translate-x-full"
            x-transition:leave="transition-transform duration-200 ease-in-out"
            x-transition:leave-end="ltr:-translate-x-full rtl:translate-x-full"
        >
            <div class="sr-only">
                <h2>Chat</h2>
                <p>Select a conversation</p>
            </div>

            <button data-slot="button" type="button" aria-label="Close conversation list" x-on:click="openMobile = false" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-11 absolute -end-13 top-2 rounded-full bg-white text-gray-700 shadow-theme-md transition hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 **:stroke-[1.5px]">
    <path d="M18 6L6 18M6 6l12 12" />
  </svg></button>

            <div class="flex items-center justify-between p-4 pb-0 sm:p-5 sm:pb-0">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Messages</h3>
    <button data-slot="button" type="button" aria-label="Menu" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4"
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
</div>
            <div class="px-4 py-3 sm:px-5">
    <div class="relative">
        <svg class="pointer-events-none absolute start-3 top-1/2 size-4 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <input data-slot="input" type="text" placeholder="Search conversation..." x-model="searchQuery" class="w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-10 ps-9" />
    </div>
</div>
            <div class="custom-scrollbar min-h-0 flex-1 overflow-y-auto">
                <div class="space-y-1 p-3">
    <template x-if="filteredUsers.length === 0">
        <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">No conversations found</div>
    </template>
    <template x-for="user in filteredUsers" x-bind:key="user.id">
        <div
    role="button"
    tabindex="0"
    class="flex w-full cursor-pointer items-center gap-3 rounded-xl p-3 outline-hidden transition-colors"
    x-bind:class="user.id === activeUserId ? 'bg-gray-100 dark:bg-white/5' : 'hover:bg-gray-50 dark:hover:bg-white/3'"
    x-on:click="selectUser(user)"
    x-on:keydown.enter.prevent="selectUser(user)"
    x-on:keydown.space.prevent="selectUser(user)"
>
    <div class="relative shrink-0">
        <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="user.avatar" x-bind:alt="user.name" class="aspect-square size-full rounded-full object-cover">
            <template x-if="!loaded">
<span data-slot="avatar-fallback" x-text="user.name.charAt(0)" class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"></span>
</template>
            <span data-slot="avatar-badge" data-variant="online" x-bind:data-variant="user.status" class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>
    </div>

    <div class="min-w-0 flex-1">
        <div class="flex items-center justify-between gap-1">
            <h5 class="min-w-0 truncate text-sm font-medium text-gray-800 dark:text-white/90" x-text="user.name"></h5>
            <span class="shrink-0 text-xs text-gray-400 dark:text-gray-500" x-text="formatLastActive(user.lastActive)"></span>
        </div>

        <div class="mt-0.5 flex items-center justify-between gap-2">
            <p class="min-w-0 truncate text-xs text-gray-500 dark:text-gray-400" x-text="user.lastMessage || user.role"></p>
            <template x-if="user.unreadCount && user.unreadCount > 0">
                <span
                    class="flex h-4 min-w-4 shrink-0 items-center justify-center rounded-full bg-brand-500 px-1 text-[10px] font-medium text-white"
                    x-text="user.unreadCount"
                ></span>
            </template>
        </div>
    </div>
</div>
    </template>
</div>
            </div>
        </div>
    </div>
</template>
        <div
    class="flex h-full min-w-0 flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"
>
    <div
    class="flex items-center justify-between border-b border-gray-200 p-4 sm:px-6 dark:border-gray-800"
>
    <div class="flex items-center gap-3">
        <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="activeUser.avatar" x-bind:alt="activeUser.name" class="aspect-square size-full rounded-full object-cover">
            <template x-if="!loaded">
<span data-slot="avatar-fallback" x-text="activeUser.name.charAt(0)" class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"></span>
</template>
            <span data-slot="avatar-badge" data-variant="online" x-bind:data-variant="activeUser.status" class="text-primary-foreground absolute top-0 end-0 z-10 inline-flex items-center justify-center rounded-full bg-blend-color ring-2 ring-white select-none dark:ring-black data-[variant=busy]:bg-amber-500 data-[variant=offline]:bg-red-500 data-[variant=online]:bg-green-500 group-data-[size=xs]/avatar:size-1.5 group-data-[size=xs]/avatar:[&amp;&gt;svg]:hidden group-data-[size=sm]/avatar:size-2 group-data-[size=sm]/avatar:[&amp;&gt;svg]:hidden group-data-[size=default]/avatar:size-2.5 group-data-[size=default]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=lg]/avatar:size-3 group-data-[size=lg]/avatar:[&amp;&gt;svg]:size-2 group-data-[size=xl]/avatar:size-3.5 group-data-[size=xl]/avatar:[&amp;&gt;svg]:size-2.5"></span></span>

        <div>
            <h4 class="text-sm font-semibold text-gray-800 dark:text-white/90" x-text="activeUser.name"></h4>
            <p class="text-gray-500 capitalize dark:text-gray-400" x-text="activeUser.status + ' • ' + activeUser.role"></p>
        </div>
    </div>

    <div class="flex items-center gap-1 sm:gap-2">
        <button data-slot="button" type="button" aria-label="Start voice call" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white">
  <path
    d="M20 17.052V12a8 8 0 10-16 0v5.052m16-3.011v5.709a1.5 1.5 0 01-1.5 1.5H14m-7.5-2.5h-1a1.5 1.5 0 01-1.5-1.5v-3.5a1.5 1.5 0 011.5-1.5h1a1.5 1.5 0 011.5 1.5v3.5a1.5 1.5 0 01-1.5 1.5zm11 0h1a1.5 1.5 0 001.5-1.5v-3.5a1.5 1.5 0 00-1.5-1.5h-1a1.5 1.5 0 00-1.5 1.5v3.5a1.5 1.5 0 001.5 1.5z"
    stroke="currentColor"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  />
</svg></button>
        <button data-slot="button" type="button" aria-label="Start video call" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-5 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
  </svg></button>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg" type="button" aria-label="More options"><svg class="size-5 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"
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
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-44 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">View Profile</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Mute Notifications</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Clear Chat History</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10">Block User</div></div>
    </div>
</template></div>
    </div>
</div>
    <div
    data-slot="scroll-area"
    x-data="{
        show: false,
        thumbHeight: 0,
        thumbTop: 0,
        update() {
            const el = this.$refs.viewport;
            if (!el) return;
            const { scrollTop, scrollHeight, clientHeight } = el;
            this.show = scrollHeight > clientHeight + 1;
            if (!this.show) return;
            const trackHeight = clientHeight;
            this.thumbHeight = Math.max(18, (clientHeight / scrollHeight) * trackHeight);
            this.thumbTop = (scrollTop / (scrollHeight - clientHeight)) * (trackHeight - this.thumbHeight);
        },
        startDrag(e) {
            const el = this.$refs.viewport;
            const startY = e.clientY;
            const startScroll = el.scrollTop;
            const ratio = (el.scrollHeight - el.clientHeight) / (el.clientHeight - this.thumbHeight);
            const move = (ev) => { el.scrollTop = startScroll + (ev.clientY - startY) * ratio; };
            const up = () => { window.removeEventListener('pointermove', move); window.removeEventListener('pointerup', up); };
            window.addEventListener('pointermove', move);
            window.addEventListener('pointerup', up);
        },
    }"
    x-init="$nextTick(() => update()); new ResizeObserver(() => update()).observe($refs.viewport); new ResizeObserver(() => update()).observe($refs.content)"
    
    class="relative flex-1 min-h-0"
>
    <div data-slot="scroll-area-viewport" x-ref="viewport" @scroll.passive="update()" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 [scrollbar-width:none] [&amp;::-webkit-scrollbar]:hidden!">
        <div class="min-w-0" x-ref="content"><div class="space-y-6 p-4 sm:p-6">
        <template x-for="message in messages" x-bind:key="message.id">
            <div class="flex gap-3" x-bind:class="message.isSender ? 'justify-end' : 'items-start'">
    <template x-if="!message.isSender">
        <span data-slot="avatar" data-size="sm" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten mt-1 shrink-0"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="message.senderAvatar" x-bind:alt="message.senderName" class="aspect-square size-full rounded-full object-cover">
            <template x-if="!loaded">
<span data-slot="avatar-fallback" x-text="message.senderName.charAt(0)" class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"></span>
</template></span>
    </template>

    <div class="max-w-[85%] sm:max-w-[70%]" x-bind:class="message.isSender ? 'text-end' : ''">
        <template x-if="message.imagePreview">
            <div class="mb-2 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                <img width="280" height="160" x-bind:src="message.imagePreview" alt="Shared image" class="h-auto w-full max-w-96 object-cover" />
            </div>
        </template>

        <div
            class="inline-block rounded-2xl px-4 py-2.5 text-sm"
            x-bind:class="message.isSender ? 'rounded-se-xs bg-brand-500 text-white' : 'rounded-ss-xs bg-gray-100 text-gray-800 dark:bg-white/5 dark:text-white/90'"
        >
            <p class="leading-relaxed" x-text="message.message"></p>
        </div>

        <p
            class="mt-1 text-xs text-gray-400 dark:text-gray-500"
            x-text="message.isSender ? formatMessageTime(message.timestamp) : `${message.senderName}, ${formatMessageTime(message.timestamp)}`"
        ></p>
    </div>
</div>
        </template>
        <div id="chat-message-bottom"></div>
    </div></div>
    </div>
    <div
        data-slot="scroll-area-scrollbar"
        data-orientation="vertical"
        x-show="show"
        style="display: none;"
        class="absolute end-0 top-0 flex h-full w-1.5 touch-none rounded-full bg-gray-100 transition-colors select-none dark:bg-gray-800"
    >
        <div
            data-slot="scroll-area-thumb"
            class="absolute start-0 w-full! rounded-full bg-gray-300 transition-colors hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500"
            x-bind:style="`height: ${thumbHeight}px; top: ${thumbTop}px`"
            @pointerdown.prevent="startDrag($event)"
        ></div>
    </div>
</div>
    <div
    class="sticky bottom-0 border-t border-gray-200 bg-white p-3 sm:p-4 dark:border-gray-800 dark:bg-gray-900"
    x-data="{
        text: '',
        submit() {
            if (!this.text.trim()) return;
            sendMessage(this.text);
            this.text = '';
        },
    }"
>
    <form action="" class="flex items-center gap-2" x-on:submit.prevent="submit()">
        <button data-slot="button" type="button" aria-label="Attach file" class="group/button inline-flex items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg shrink-0 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white"><svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8.582 1.542a3.587 3.587 0 013.587 3.587v8.325a2.17 2.17 0 01-4.337 0V5.13a.75.75 0 011.5 0v8.325a.669.669 0 001.337 0v-1.4l-.001-.019V5.13a2.087 2.087 0 00-4.173 0v8.325a3.506 3.506 0 007.01 0v-5.49a.75.75 0 011.5 0v5.49a5.006 5.006 0 01-10.01 0V5.13a3.587 3.587 0 013.587-3.587z"
      fill="currentColor"
    />
  </svg></button>

        <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 flex-1"><input type="text" data-slot="input-group-control" placeholder="Type a message..." x-model="text" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0">
            <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last pe-3.5 has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5"><button type="button" data-slot="button" data-size="icon-xs" aria-label="Voice input" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent hover:bg-gray-50 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center gap-2 text-sm shadow-none size-7 rounded-md p-0 has-[&gt;svg]:p-0 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"><svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10 15.208a5.833 5.833 0 01-5.833-5.833M10 15.208a5.833 5.833 0 005.833-5.833M10 15.208v2.5m-1.667 0h3.334m-1.667-5a3.333 3.333 0 01-3.333-3.333v-3.75a3.333 3.333 0 016.666 0v3.75A3.333 3.333 0 0110 12.708z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button></div></div>

        <button data-slot="button" type="submit" x-bind:disabled="!text.trim()" aria-label="Send message" class="group/button inline-flex items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg shrink-0"><svg class="size-4 rtl:-scale-x-100" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.985 2.444c-1.872-.873-3.832 1.026-3.02 2.924l1.856 4.337a.75.75 0 010 .59l-1.856 4.337c-.812 1.899 1.148 3.797 3.02 2.925l11.833-5.517c1.733-.808 1.733-3.271 0-4.079L4.985 2.444zm-1.64 2.334c-.271-.633.382-1.265 1.006-.975l11.834 5.518a.75.75 0 010 1.359L4.35 16.197c-.624.29-1.277-.342-1.006-.975L5.2 10.885a2.28 2.28 0 00.054-.138h3.864a.75.75 0 000-1.5H5.252a2.253 2.253 0 00-.052-.132L3.345 4.778z"
      fill="currentColor"
    />
  </svg></button>
    </form>
</div>
</div>
    </div>
</div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
