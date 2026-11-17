<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="w-full min-w-0">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Inbox Details
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
                Inbox Details
            </li>
        </ol>
    </nav>
</div>
        <div class="h-[calc(100vh-174px)] min-h-0 w-full min-w-0">
            <div
    data-slot="sidebar-wrapper"
    x-data="{
        openMobile: false,
        openCompose() { Alpine.$data(document.querySelector('[data-dlg=compose]')).show(); },
    }"
    x-on:keydown.escape.window="openMobile = false"
    class="group/sidebar-wrapper flex has-data-[variant=inset]:bg-gray-50 h-full min-h-0 min-w-0 w-full flex-1"
>
    <div class="flex h-full min-h-0 min-w-0 w-full flex-1 flex-col gap-4 sm:gap-5 xl:flex-row">
        <div class="flex shrink-0 items-center justify-between rounded-2xl border border-gray-200 bg-white p-3 ps-5 xl:hidden dark:border-gray-800 dark:bg-gray-900">
    <span class="text-lg font-medium text-gray-800 dark:text-white/90">
        Inbox Details
    </span>

    <button data-slot="button" type="button" aria-label="Open email folders menu" x-on:click="openMobile = !openMobile" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-11 rounded-[10px]"><svg class="size-6" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M2.43311 5.0001C2.43311 4.50304 2.83605 4.1001 3.33311 4.1001L16.6664 4.1001C17.1635 4.1001 17.5664 4.50304 17.5664 5.0001C17.5664 5.49715 17.1635 5.9001 16.6664 5.9001L3.33311 5.9001C2.83605 5.9001 2.43311 5.49716 2.43311 5.0001ZM2.43311 15.0001C2.43311 14.503 2.83605 14.1001 3.33311 14.1001L16.6664 14.1001C17.1635 14.1001 17.5664 14.503 17.5664 15.0001C17.5664 15.4972 17.1635 15.9001 16.6664 15.9001L3.33311 15.9001C2.83605 15.9001 2.43311 15.4972 2.43311 15.0001ZM3.33311 9.1001C2.83605 9.1001 2.43311 9.50304 2.43311 10.0001C2.43311 10.4972 2.83605 10.9001 3.33311 10.9001L16.6664 10.9001C17.1635 10.9001 17.5664 10.4972 17.5664 10.0001C17.5664 9.50304 17.1635 9.1001 16.6664 9.1001L3.33311 9.1001Z"
      fill="currentColor"
    />
  </svg></button>
</div>

        <div
    data-slot="sidebar"
    class="hidden h-full w-65 shrink-0 flex-col rounded-2xl border border-gray-200 bg-white p-4 text-gray-900 xl:flex dark:border-gray-800 dark:bg-gray-900"
>
    <button data-slot="button" type="button" x-on:click="openCompose()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-11 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 w-full"><svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
    Compose</button>
    <div class="mt-5 custom-scrollbar flex-1 space-y-5 overflow-y-auto">
    <!-- Mailbox Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">MAILBOX</h4>
        <nav class="flex flex-col gap-0.5">
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-brand-500 dark:text-brand-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.146 5.625h7.812a3.75 3.75 0 013.75 3.75v5c0 .69-.56 1.25-1.25 1.25H6.146m0-10A3.854 3.854 0 0110 9.48v6.146H3.542c-.69 0-1.25-.56-1.25-1.25V9.48a3.854 3.854 0 013.854-3.854zm5.404 0V3.127m0 0v-.623c0-.345.28-.625.625-.625h1.576a.624.624 0 110 1.248H11.55z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Inbox</span>
    </div>

            <span class="text-sm font-normal text-brand-500 dark:text-brand-400">
            3
        </span>
    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! rtl:-scale-x-100 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z"
      fill="currentColor"
    />
  </svg>
        <span>Sent</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.042 7.062v7.313a.5.5 0 00.5.5h12.916a.5.5 0 00.5-.5V7.062l-5.814 4.055a2 2 0 01-2.288 0L3.042 7.062zm13.916-1.87V5.2a.072.072 0 01-.03.055l-6.642 4.631a.5.5 0 01-.572 0L3.072 5.255a.071.071 0 01.041-.13h13.774c.038 0 .07.03.071.068zm1.5.022v9.161a2 2 0 01-2 2H3.542a2 2 0 01-2-2v-9.18-.03a1.571 1.571 0 011.571-1.54h13.774c.868 0 1.571.703 1.571 1.571v.018z"
      fill="currentColor"
    />
  </svg>
        <span>Drafts</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM11.0991 7.52507C11.0991 8.02213 11.5021 8.42507 11.9991 8.42507H12.0001C12.4972 8.42507 12.9001 8.02213 12.9001 7.52507C12.9001 7.02802 12.4972 6.62507 12.0001 6.62507H11.9991C11.5021 6.62507 11.0991 7.02802 11.0991 7.52507ZM12.0001 17.3714C11.5859 17.3714 11.2501 17.0356 11.2501 16.6214V10.9449C11.2501 10.5307 11.5859 10.1949 12.0001 10.1949C12.4143 10.1949 12.7501 10.5307 12.7501 10.9449V16.6214C12.7501 17.0356 12.4143 17.3714 12.0001 17.3714Z"
      fill="currentColor"
    />
  </svg>
        <span>Spam</span>
    </div>

            <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
            2
        </span>
    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
        <span>Trash</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.5 6.25V15.5C2.5 16.3284 3.17157 17 4 17H16C16.8284 17 17.5 16.3284 17.5 15.5V6.25M8.33333 10H11.6667M1.66667 3.75C1.66667 3.05964 2.22631 2.5 2.91667 2.5H17.0833C17.7737 2.5 18.3333 3.05964 18.3333 3.75V5C18.3333 5.69036 17.7737 6.25 17.0833 6.25H2.91667C2.22631 6.25 1.66667 5.69036 1.66667 5V3.75Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Archive</span>
    </div>

    </a>
                    </nav>
    </div>

    <!-- Filter Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">FILTER</h4>
        <nav class="flex flex-col">
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.001 2.337l2.358 4.777 5.27.766-3.814 3.718.9 5.25-4.714-2.48-4.714 2.48.9-5.25L2.373 7.88l5.271-.766 2.357-4.777z"
      stroke="currentColor"
    />
  </svg>
        <span>Starred</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.146 5.625h7.812a3.75 3.75 0 013.75 3.75v5c0 .69-.56 1.25-1.25 1.25H6.146m0-10A3.854 3.854 0 0110 9.48v6.146H3.542c-.69 0-1.25-.56-1.25-1.25V9.48a3.854 3.854 0 013.854-3.854zm5.404 0V3.127m0 0v-.623c0-.345.28-.625.625-.625h1.576a.624.624 0 110 1.248H11.55z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Important</span>
    </div>

    </a>
                    </nav>
    </div>

    <!-- Label Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">LABEL</h4>
        <div class="flex flex-col">
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
    >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-green-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Personal</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
    >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-red-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Work</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
    >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-orange-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Payments</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
    >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-sky-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Invoices</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
    >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-brand-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Blank</span>
    </div>

    </button>
                    </div>
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
            class="fixed inset-y-0 start-0 z-101 flex h-full w-3/4 flex-col gap-4 border-e border-gray-200 bg-white p-4 text-sm text-gray-700 shadow-theme-lg outline-none sm:max-w-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 w-65 text-gray-900"
            x-show="openMobile"
            x-transition:enter="transition-transform duration-200 ease-in-out"
            x-transition:enter-start="ltr:-translate-x-full rtl:translate-x-full"
            x-transition:leave="transition-transform duration-200 ease-in-out"
            x-transition:leave-end="ltr:-translate-x-full rtl:translate-x-full"
        >
            <div class="sr-only">
                <h2>Email Navigation</h2>
                <p>Folders, filters, and labels navigation menu</p>
            </div>

            <button data-slot="button" type="button" aria-label="Close email menu" x-on:click="openMobile = false" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:disabled:bg-brand-800 dark:disabled:text-brand-400 size-11 absolute -inset-e-13 top-2 rounded-full bg-white text-gray-700 shadow-theme-md transition hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 **:stroke-[1.5px]">
    <path d="M18 6L6 18M6 6l12 12" />
  </svg></button>

            <button data-slot="button" type="button" x-on:click="openMobile = false; openCompose()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-11 gap-2 rounded-[10px] px-5 py-3 [&amp;:has(&gt;svg:first-child)]:ps-4 [&amp;:has(&gt;svg:last-child)]:pe-4 w-full"><svg class="size-5" width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.091 3.532a2.25 2.25 0 00-3.182 0l-8.302 8.302c-.308.308-.52.7-.61 1.126l-.735 3.485a.75.75 0 00.888.889l3.485-.735a2.25 2.25 0 001.127-.611l8.301-8.302a2.25 2.25 0 000-3.182l-.972-.972zm-2.121 1.06a.75.75 0 011.06 0l.973.973a.75.75 0 010 1.06l-.899.899-2.033-2.033.899-.898zm-1.96 1.96l-6.342 6.342a.75.75 0 00-.203.376l-.498 2.358 2.358-.497a.75.75 0 00.376-.204l6.343-6.342-2.033-2.033z"
      fill="currentColor"
    />
  </svg>
    Compose</button>
            <div class="mt-5 custom-scrollbar flex-1 space-y-5 overflow-y-auto">
    <!-- Mailbox Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">MAILBOX</h4>
        <nav class="flex flex-col gap-0.5">
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-brand-500 dark:text-brand-400" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.146 5.625h7.812a3.75 3.75 0 013.75 3.75v5c0 .69-.56 1.25-1.25 1.25H6.146m0-10A3.854 3.854 0 0110 9.48v6.146H3.542c-.69 0-1.25-.56-1.25-1.25V9.48a3.854 3.854 0 013.854-3.854zm5.404 0V3.127m0 0v-.623c0-.345.28-.625.625-.625h1.576a.624.624 0 110 1.248H11.55z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Inbox</span>
    </div>

            <span class="text-sm font-normal text-brand-500 dark:text-brand-400">
            3
        </span>
    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! rtl:-scale-x-100 text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z"
      fill="currentColor"
    />
  </svg>
        <span>Sent</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.042 7.062v7.313a.5.5 0 00.5.5h12.916a.5.5 0 00.5-.5V7.062l-5.814 4.055a2 2 0 01-2.288 0L3.042 7.062zm13.916-1.87V5.2a.072.072 0 01-.03.055l-6.642 4.631a.5.5 0 01-.572 0L3.072 5.255a.071.071 0 01.041-.13h13.774c.038 0 .07.03.071.068zm1.5.022v9.161a2 2 0 01-2 2H3.542a2 2 0 01-2-2v-9.18-.03a1.571 1.571 0 011.571-1.54h13.774c.868 0 1.571.703 1.571 1.571v.018z"
      fill="currentColor"
    />
  </svg>
        <span>Drafts</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.5 12C3.5 7.30558 7.30558 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C7.30558 20.5 3.5 16.6944 3.5 12ZM12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2ZM11.0991 7.52507C11.0991 8.02213 11.5021 8.42507 11.9991 8.42507H12.0001C12.4972 8.42507 12.9001 8.02213 12.9001 7.52507C12.9001 7.02802 12.4972 6.62507 12.0001 6.62507H11.9991C11.5021 6.62507 11.0991 7.02802 11.0991 7.52507ZM12.0001 17.3714C11.5859 17.3714 11.2501 17.0356 11.2501 16.6214V10.9449C11.2501 10.5307 11.5859 10.1949 12.0001 10.1949C12.4143 10.1949 12.7501 10.5307 12.7501 10.9449V16.6214C12.7501 17.0356 12.4143 17.3714 12.0001 17.3714Z"
      fill="currentColor"
    />
  </svg>
        <span>Spam</span>
    </div>

            <span class="text-sm font-normal text-gray-700 dark:text-gray-400">
            2
        </span>
    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg>
        <span>Trash</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.5 6.25V15.5C2.5 16.3284 3.17157 17 4 17H16C16.8284 17 17.5 16.3284 17.5 15.5V6.25M8.33333 10H11.6667M1.66667 3.75C1.66667 3.05964 2.22631 2.5 2.91667 2.5H17.0833C17.7737 2.5 18.3333 3.05964 18.3333 3.75V5C18.3333 5.69036 17.7737 6.25 17.0833 6.25H2.91667C2.22631 6.25 1.66667 5.69036 1.66667 5V3.75Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Archive</span>
    </div>

    </a>
                    </nav>
    </div>

    <!-- Filter Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">FILTER</h4>
        <nav class="flex flex-col">
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.001 2.337l2.358 4.777 5.27.766-3.814 3.718.9 5.25-4.714-2.48-4.714 2.48.9-5.25L2.373 7.88l5.271-.766 2.357-4.777z"
      stroke="currentColor"
    />
  </svg>
        <span>Starred</span>
    </div>

    </a>
                            <a href="#" class="group flex h-10 items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"  x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-5 shrink-0 stroke-[1.5px]! text-gray-500 group-hover:text-gray-700 dark:text-gray-400 dark:group-hover:text-gray-200" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M6.146 5.625h7.812a3.75 3.75 0 013.75 3.75v5c0 .69-.56 1.25-1.25 1.25H6.146m0-10A3.854 3.854 0 0110 9.48v6.146H3.542c-.69 0-1.25-.56-1.25-1.25V9.48a3.854 3.854 0 013.854-3.854zm5.404 0V3.127m0 0v-.623c0-.345.28-.625.625-.625h1.576a.624.624 0 110 1.248H11.55z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        <span>Important</span>
    </div>

    </a>
                    </nav>
    </div>

    <!-- Label Section -->
    <div>
        <h4 class="mb-3 text-xs font-medium text-gray-700 uppercase dark:text-gray-400">LABEL</h4>
        <div class="flex flex-col">
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
     x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-green-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Personal</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
     x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-red-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Work</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
     x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-orange-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Payments</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
     x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-sky-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Invoices</span>
    </div>

    </button>
                            <button
    type="button"
    class="group flex h-10 w-full items-center justify-between rounded-lg px-3 py-2.5 text-start text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white"
     x-on:click="openMobile = false" >
    <div class="flex items-center gap-3">
        <svg class="size-4 shrink-0 rtl:rotate-180 text-brand-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M1.5 5.25C1.5 4.007 2.507 3 3.75 3h6.398c.597 0 1.169.237 1.591.66l3.1 3.1a1.75 1.75 0 010 2.48l-3.1 3.1a2.25 2.25 0 01-1.591.66H3.75C2.507 13 1.5 11.993 1.5 10.75v-5.5z"
      fill="currentColor"
    />
  </svg>
        <span>Blank</span>
    </div>

    </button>
                    </div>
    </div>
</div>
        </div>
    </div>
</template>

        <main class="flex h-full min-w-0 flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <div class="flex h-full min-w-0 w-full flex-col">
    <div class="flex flex-col gap-3 border-b border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
    <div class="flex items-center gap-3">
        <a href="https://laravel-demo.tailadmin.com/inbox">
            <button data-slot="button" type="button" aria-label="Back to inbox" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M12 19l-7-7 7-7M19 12H5" />
  </svg></button>
        </a>

        <div role="group" data-slot="button-group" data-orientation="horizontal"  class="flex w-fit items-stretch *:focus-visible:relative *:focus-visible:z-10 has-[&gt;[data-slot=button-group]]:gap-2 has-[select[aria-hidden=true]:last-child]:[&amp;&gt;[data-slot=select-trigger]:last-of-type]:rounded-e-lg [&amp;&gt;[data-slot=select-trigger]:not([class*=&#039;w-&#039;])]:w-fit [&amp;&gt;input]:flex-1 [&amp;&gt;[data-slot]:has(~[data-slot])]:rounded-e-none [&amp;&gt;[data-slot]~[data-slot]]:rounded-s-none [&amp;&gt;[data-slot]~[data-slot]]:border-s-0"><button data-slot="button" type="button" aria-label="Delete message" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg></button>

            <button data-slot="button" type="button" aria-label="Report spam" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" >
    <circle cx="12" cy="12" r="10" />
    <path d="M12 16v-4M12 8h.01" />
  </svg></button>

            <button data-slot="button" type="button" aria-label="Archive message" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.5 6.25V15.5C2.5 16.3284 3.17157 17 4 17H16C16.8284 17 17.5 16.3284 17.5 15.5V6.25M8.33333 10H11.6667M1.66667 3.75C1.66667 3.05964 2.22631 2.5 2.91667 2.5H17.0833C17.7737 2.5 18.3333 3.05964 18.3333 3.75V5C18.3333 5.69036 17.7737 6.25 17.0833 6.25H2.91667C2.22631 6.25 1.66667 5.69036 1.66667 5V3.75Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button></div>

        <button data-slot="button" type="button" aria-label="Mark unread" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.042 7.062v7.313a.5.5 0 00.5.5h12.916a.5.5 0 00.5-.5V7.062l-5.814 4.055a2 2 0 01-2.288 0L3.042 7.062zm13.916-1.87V5.2a.072.072 0 01-.03.055l-6.642 4.631a.5.5 0 01-.572 0L3.072 5.255a.071.071 0 01.041-.13h13.774c.038 0 .07.03.071.068zm1.5.022v9.161a2 2 0 01-2 2H3.542a2 2 0 01-2-2v-9.18-.03a1.571 1.571 0 011.571-1.54h13.774c.868 0 1.571.703 1.571 1.571v.018z"
      fill="currentColor"
    />
  </svg></button>
    </div>

    <div class="flex items-center justify-between gap-4 sm:justify-end">
        <span class="text-sm text-gray-500 dark:text-gray-400"> 4 of 120 </span>
        <div class="flex items-center gap-1.5">
            <button data-slot="button" type="button" aria-label="Previous email" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></button>
            <button data-slot="button" type="button" aria-label="Next email" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4 rtl:rotate-180" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M5.83333 12.6665L10 8.49984L5.83333 4.33317"
      stroke="currentColor"
      stroke-width="1.2"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>
        </div>
    </div>
</div>
    <div class="custom-scrollbar flex-1 overflow-x-hidden overflow-y-auto">
        <div class="space-y-6 p-4 sm:p-6">
    <!-- Sender Header -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-5 dark:border-gray-800">
        <div class="flex items-center gap-3.5">
            <span data-slot="avatar" data-size="lg" x-data="{ loaded: false }"  class="group/avatar relative flex size-10 shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" src="/assets/images/user/user-18.jpg" alt="Codescandy" class="aspect-square size-full rounded-full object-cover">
                <template x-if="!loaded">
<span data-slot="avatar-fallback"  class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400">C</span>
</template></span>

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Contact For “Website Design”</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-gray-700 dark:text-gray-300">Codescandy</span>
                    &lt;hello@example.com&gt;
                </p>
            </div>
        </div>

        <span class="hidden text-xs text-gray-400 sm:block dark:text-gray-500">Dec 20, 2028 (10:30 AM)</span>
    </div>

    <!-- Body Paragraphs -->
    <div class="space-y-4 text-sm leading-relaxed text-gray-600 dark:text-gray-300">
                    <p>Hello Dear Alexander,</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut rutrum mi. Aenean ac leo non justo suscipit consectetur. Nam vestibulum eleifend magna quis porta. ipsum dolor sit amet, consectetur adipiscing elit. Praesent ut rutrum mi. Aenean ac leo.</p>
                    <p>Praesent ut rutrum mi. Aenean ac leo non justo suscipit consectetur. Nam vestibulum eleifend magna quis porta.</p>
                    <p>Nullam tincidunt sodales diam, quis rhoncus dolor aliquet a. Nulla a rhoncus lectus. In nunc neque, pellentesque non massa ornare, accumsan ornare massa. odales diam, quis rhoncus dolor aliquet a. Nulla a rhoncus lectus. In nunc neque.</p>
                    <p>Suspendisse semper vel turpis vitae aliquam. Aenean semper dui in consequat ullamcorper.</p>
                    <p>Nullam tincidunt sodales diam, quis rhoncus dolor aliquet a. Nulla a rhoncus lectus. In nunc neque, pellentesque non massa ornare, accumsan ornare massa. sodales diam, quis rhoncus dolor aliquet a. Nulla a rhoncus lectus. In nunc neque.</p>
                    <p>Praesent ut rutrum mi. Aenean ac leo non justo suscipit consectetur. Nam vestibulum eleifend magna quis porta.</p>
            </div>
</div>
        <div class="mx-4 mb-6 rounded-xl border border-gray-200 bg-gray-50/70 p-4 sm:mx-6 dark:border-gray-800 dark:bg-gray-800/40">
        <div class="mb-3.5 flex items-center gap-2 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8.58191 1.54199C10.5624 1.54218 12.1688 3.14806 12.1688 5.12891V13.4541C12.1685 14.6513 11.1972 15.6221 9.99988 15.6221C8.80293 15.6217 7.83224 14.6511 7.83191 13.4541V5.12891C7.83191 4.71484 8.1679 4.37915 8.58191 4.37891C8.99612 4.37891 9.33191 4.71469 9.33191 5.12891V13.4541C9.33224 13.8226 9.63135 14.1217 9.99988 14.1221C10.3688 14.1221 10.6685 13.8229 10.6688 13.4541V12.0537C10.6687 12.0478 10.6679 12.0412 10.6678 12.0352L10.6688 5.12891C10.6688 3.97681 9.73429 3.04218 8.58191 3.04199C7.42969 3.04217 6.495 3.97664 6.495 5.12891V13.4541C6.49533 15.3893 8.06465 16.9587 9.99988 16.959C11.9353 16.959 13.5044 15.3895 13.5048 13.4541V7.96484C13.5049 7.55092 13.8409 7.21511 14.2548 7.21484C14.6689 7.21484 15.0046 7.55076 15.0048 7.96484V13.4541C15.0044 16.2179 12.7638 18.459 9.99988 18.459C7.23623 18.4587 4.99533 16.2177 4.995 13.4541V5.12891C4.995 3.14821 6.60126 1.54217 8.58191 1.54199Z"
      fill="currentColor"
    />
  </svg>
            <span>2 Attachments</span>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-xs dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                                                            <svg class="size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M19.5 19.75A2.25 2.25 0 0117.25 22H6.75a2.25 2.25 0 01-2.25-2.25V9.621c0-.596.237-1.169.659-1.59l5.367-5.371A2.25 2.25 0 0112.118 2h5.132a2.25 2.25 0 012.25 2.25v15.5zm-2.25.75a.75.75 0 00.75-.75V4.25a.75.75 0 00-.75-.75h-5.002l.003 4A2.25 2.25 0 0110 9.75H6v10c0 .414.336.75.75.75h10.5zM7.06 8.25l3.689-3.691.002 2.941a.75.75 0 01-.75.75H7.059zm1.19 6.25a.75.75 0 01.75-.75h6a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75zm0 3a.75.75 0 01.75-.75h3a.75.75 0 010 1.5H9a.75.75 0 01-.75-.75z"
      fill="currentColor"
    />
  </svg>
                                                    </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">Guidelines.pdf</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">PDF • 2.4 MB</p>
                        </div>
                    </div>

                    <button data-slot="button" type="button" aria-label="Download Guidelines.pdf" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4"
    class="fill-current"
    width="25"
    height="24"
    viewBox="0 0 25 24"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fillRule="evenodd"
      clipRule="evenodd"
      d="M12.6686 16.75C12.4526 16.75 12.2579 16.6587 12.1211 16.5126L7.5115 11.9059C7.21851 11.6131 7.21836 11.1382 7.51116 10.8452C7.80396 10.5523 8.27883 10.5521 8.57182 10.8449L11.9186 14.1896V4C11.9186 3.58579 12.2544 3.25 12.6686 3.25C13.0828 3.25 13.4186 3.58579 13.4186 4V14.1854L16.7615 10.8449C17.0545 10.5521 17.5294 10.5523 17.8222 10.8453C18.115 11.1383 18.1148 11.6131 17.8218 11.9059L13.2469 16.4776C13.1093 16.644 12.9013 16.75 12.6686 16.75ZM5.41663 16C5.41663 15.5858 5.08084 15.25 4.66663 15.25C4.25241 15.25 3.91663 15.5858 3.91663 16V18.5C3.91663 19.7426 4.92399 20.75 6.16663 20.75H19.1675C20.4101 20.75 21.4175 19.7426 21.4175 18.5V16C21.4175 15.5858 21.0817 15.25 20.6675 15.25C20.2533 15.25 19.9175 15.5858 19.9175 16V18.5C19.9175 18.9142 19.5817 19.25 19.1675 19.25H6.16663C5.75241 19.25 5.41663 18.9142 5.41663 18.5V16Z"
      fill="currentColor"
    />
  </svg></button>
                </div>
                            <div class="flex items-center justify-between rounded-xl border border-gray-200 bg-white p-3 shadow-xs dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center gap-3">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400">
                                                            <svg class="size-5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M11.05 6.9L10.45 7.35L11.05 6.9ZM4.25 5.25H8.5V3.75H4.25V5.25ZM3.5 18V6H2V18H3.5ZM19.75 18.75H4.25V20.25H19.75V18.75ZM20.5 9V18H22V9H20.5ZM19.75 6.75H12.25V8.25H19.75V6.75ZM11.65 6.45L10.3 4.65L9.1 5.55L10.45 7.35L11.65 6.45ZM12.25 6.75C12.0139 6.75 11.7916 6.63885 11.65 6.45L10.45 7.35C10.8749 7.91656 11.5418 8.25 12.25 8.25V6.75ZM22 9C22 7.75736 20.9926 6.75 19.75 6.75V8.25C20.1642 8.25 20.5 8.58579 20.5 9H22ZM19.75 20.25C20.9926 20.25 22 19.2426 22 18H20.5C20.5 18.4142 20.1642 18.75 19.75 18.75V20.25ZM2 18C2 19.2426 3.00736 20.25 4.25 20.25V18.75C3.83579 18.75 3.5 18.4142 3.5 18H2ZM8.5 5.25C8.73607 5.25 8.95836 5.36115 9.1 5.55L10.3 4.65C9.87508 4.08344 9.2082 3.75 8.5 3.75V5.25ZM4.25 3.75C3.00736 3.75 2 4.75736 2 6H3.5C3.5 5.58579 3.83579 5.25 4.25 5.25V3.75Z"
      fill="currentColor"
    />
  </svg>
                                                    </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-gray-800 dark:text-white/90">Branding Assets</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">Media • 18.5 MB</p>
                        </div>
                    </div>

                    <button data-slot="button" type="button" aria-label="Download Branding Assets" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4"
    class="fill-current"
    width="25"
    height="24"
    viewBox="0 0 25 24"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fillRule="evenodd"
      clipRule="evenodd"
      d="M12.6686 16.75C12.4526 16.75 12.2579 16.6587 12.1211 16.5126L7.5115 11.9059C7.21851 11.6131 7.21836 11.1382 7.51116 10.8452C7.80396 10.5523 8.27883 10.5521 8.57182 10.8449L11.9186 14.1896V4C11.9186 3.58579 12.2544 3.25 12.6686 3.25C13.0828 3.25 13.4186 3.58579 13.4186 4V14.1854L16.7615 10.8449C17.0545 10.5521 17.5294 10.5523 17.8222 10.8453C18.115 11.1383 18.1148 11.6131 17.8218 11.9059L13.2469 16.4776C13.1093 16.644 12.9013 16.75 12.6686 16.75ZM5.41663 16C5.41663 15.5858 5.08084 15.25 4.66663 15.25C4.25241 15.25 3.91663 15.5858 3.91663 16V18.5C3.91663 19.7426 4.92399 20.75 6.16663 20.75H19.1675C20.4101 20.75 21.4175 19.7426 21.4175 18.5V16C21.4175 15.5858 21.0817 15.25 20.6675 15.25C20.2533 15.25 19.9175 15.5858 19.9175 16V18.5C19.9175 18.9142 19.5817 19.25 19.1675 19.25H6.16663C5.75241 19.25 5.41663 18.9142 5.41663 18.5V16Z"
      fill="currentColor"
    />
  </svg></button>
                </div>
                    </div>
    </div>
    </div>
    <div class="sticky bottom-0 flex flex-wrap items-center gap-3 border-t border-gray-200 bg-white p-4 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
    <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:-scale-x-100">
    <path d="M12 19l-7-7 7-7M19 12H5" />
  </svg>
        Reply</button>
    <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-2"><svg class="size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M18.752 7.37695H5.25196M15.3773 4.00098L18.75 7.37587L15.3773 10.751M5.25 16.625H18.75M8.62471 20.001L5.25196 16.6261L8.62471 13.251"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg>
        Reply all</button>
    <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-2"><svg class="size-4 rtl:-scale-x-100"
    class="fill-current rtl:rotate-180"
    width="20"
    height="20"
    viewBox="0 0 20 20"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M17.4175 9.9986C17.4178 10.1909 17.3446 10.3832 17.198 10.53L12.2013 15.5301C11.9085 15.8231 11.4337 15.8233 11.1407 15.5305C10.8477 15.2377 10.8475 14.7629 11.1403 14.4699L14.8604 10.7472L3.33301 10.7472C2.91879 10.7472 2.58301 10.4114 2.58301 9.99715C2.58301 9.58294 2.91879 9.24715 3.33301 9.24715L14.8549 9.24715L11.1403 5.53016C10.8475 5.23717 10.8477 4.7623 11.1407 4.4695C11.4336 4.1767 11.9085 4.17685 12.2013 4.46984L17.1588 9.43049C17.3173 9.568 17.4175 9.77087 17.4175 9.99715C17.4175 9.99763 17.4175 9.99812 17.4175 9.9986Z"
      fill="currentColor"
    />
  </svg>
        Forward</button>
</div>
</div>
        </main>

        <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents" data-dlg="compose"><template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 gap-4 rounded-2xl border border-gray-200 bg-white p-6 text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 sm:max-w-xl">
            <div data-slot="dialog-header"  class="flex flex-col gap-2"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-lg font-semibold text-gray-800 dark:text-white/90">New Message</h2></div>

        <form
            class="space-y-4 pt-2"
            x-data="{ to: '', subject: '', message: '' }"
            x-on:submit.prevent="close(); to = ''; subject = ''; message = ''"
        >
            <div>
                <label class="mb-1.5 block text-xs font-medium text-gray-700 dark:text-gray-300">To</label>
                <input data-slot="input" type="email" placeholder="recipient@example.com" x-model="to" required="required" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <input data-slot="input" type="text" placeholder="Enter subject" x-model="subject" required="required" class="h-11 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40" />
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-medium text-gray-700 dark:text-gray-300">Message</label>
                <textarea data-slot="textarea" placeholder="Write your email content..." x-model="message" rows="6" required="required" class="flex min-h-20 w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40"></textarea>
            </div>

            <div class="flex items-center justify-between border-t border-gray-200 pt-4 dark:border-gray-800">
                <button data-slot="button" type="button"  class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-1.5"><svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M8.58191 1.54199C10.5624 1.54218 12.1688 3.14806 12.1688 5.12891V13.4541C12.1685 14.6513 11.1972 15.6221 9.99988 15.6221C8.80293 15.6217 7.83224 14.6511 7.83191 13.4541V5.12891C7.83191 4.71484 8.1679 4.37915 8.58191 4.37891C8.99612 4.37891 9.33191 4.71469 9.33191 5.12891V13.4541C9.33224 13.8226 9.63135 14.1217 9.99988 14.1221C10.3688 14.1221 10.6685 13.8229 10.6688 13.4541V12.0537C10.6687 12.0478 10.6679 12.0412 10.6678 12.0352L10.6688 5.12891C10.6688 3.97681 9.73429 3.04218 8.58191 3.04199C7.42969 3.04217 6.495 3.97664 6.495 5.12891V13.4541C6.49533 15.3893 8.06465 16.9587 9.99988 16.959C11.9353 16.959 13.5044 15.3895 13.5048 13.4541V7.96484C13.5049 7.55092 13.8409 7.21511 14.2548 7.21484C14.6689 7.21484 15.0046 7.55076 15.0048 7.96484V13.4541C15.0044 16.2179 12.7638 18.459 9.99988 18.459C7.23623 18.4587 4.99533 16.2177 4.995 13.4541V5.12891C4.995 3.14821 6.60126 1.54217 8.58191 1.54199Z"
      fill="currentColor"
    />
  </svg>
                    Attach Files</button>

                <div class="flex items-center gap-2">
                    <button data-slot="dialog-close" x-on:click="close()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-9 gap-1.5 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3" type="button" >Discard</button>
                    <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-9 rounded-lg px-4 py-2 in-data-[slot=button-group]:rounded-lg [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 gap-1.5"><svg class="size-4 rtl:-scale-x-100" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M4.98481 2.44399C3.11333 1.57147 1.15325 3.46979 1.96543 5.36824L3.82086 9.70527C3.90146 9.89367 3.90146 10.1069 3.82086 10.2953L1.96543 14.6323C1.15326 16.5307 3.11332 18.4291 4.98481 17.5565L16.8184 12.0395C18.5508 11.2319 18.5508 8.76865 16.8184 7.961L4.98481 2.44399ZM3.34453 4.77824C3.0738 4.14543 3.72716 3.51266 4.35099 3.80349L16.1846 9.32051C16.762 9.58973 16.762 10.4108 16.1846 10.68L4.35098 16.197C3.72716 16.4879 3.0738 15.8551 3.34453 15.2223L5.19996 10.8853C5.21944 10.8397 5.23735 10.7937 5.2537 10.7473L9.11784 10.7473C9.53206 10.7473 9.86784 10.4115 9.86784 9.99726C9.86784 9.58304 9.53206 9.24726 9.11784 9.24726L5.25157 9.24726C5.2358 9.20287 5.2186 9.15885 5.19996 9.11528L3.34453 4.77824Z"
      fill="currentColor"
    />
  </svg>
                        Send</button>
                </div>
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
        </div>
    </div>
            </div>
        </div>

    </div>

</body>


</html>
