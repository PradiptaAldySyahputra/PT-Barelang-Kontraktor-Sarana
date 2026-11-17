<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="w-full min-w-0">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Inbox
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
                Inbox
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
        Inbox
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
            <div
    class="flex h-full min-w-0 w-full flex-col"
    x-data="{
        emails: JSON.parse('[{\u0022id\u0022:\u0022mail-1\u0022,\u0022sender\u0022:\u0022Wise\u0022,\u0022email\u0022:\u0022support@wise.com\u0022,\u0022subject\u0022:\u0022Transfer Confirmation #982341\u0022,\u0022content\u0022:\u0022Your recent international transfer of $1,250.00 USD has been completed successfully.\u0022,\u0022time\u0022:\u002212:16 PM\u0022,\u0022date\u0022:\u0022Today\u0022,\u0022badge\u0022:\u0022Important\u0022,\u0022isRead\u0022:false,\u0022isStarred\u0022:true},{\u0022id\u0022:\u0022mail-2\u0022,\u0022sender\u0022:\u0022Search Console\u0022,\u0022email\u0022:\u0022sc-noreply@google.com\u0022,\u0022subject\u0022:\u0022Weekly Performance Report for your verified site\u0022,\u0022content\u0022:\u0022Your site impressions increased by 24% over the last 7 days. Review the detailed breakdown.\u0022,\u0022time\u0022:\u0022Apr 24\u0022,\u0022date\u0022:\u0022Apr 24, 2028\u0022,\u0022badge\u0022:\u0022Social\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-3\u0022,\u0022sender\u0022:\u0022Paypal\u0022,\u0022email\u0022:\u0022service@paypal.com\u0022,\u0022subject\u0022:\u0022Invoice #INV-2028-09 received from Acquired Co.\u0022,\u0022content\u0022:\u0022You received an invoice from Acquired Co for $480.00 USD due on May 15, 2028.\u0022,\u0022time\u0022:\u0022Apr 30\u0022,\u0022date\u0022:\u0022Apr 30, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:true},{\u0022id\u0022:\u0022mail-4\u0022,\u0022sender\u0022:\u0022Google Meet\u0022,\u0022email\u0022:\u0022calendar@google.com\u0022,\u0022subject\u0022:\u0022Meeting invitation: TailAdmin Design System Sync\u0022,\u0022content\u0022:\u0022Tomorrow at 3:00 PM - 4:00 PM. Participants: Lindsey Curtis, Kaiya George, and 3 others.\u0022,\u0022time\u0022:\u0022Apr 16\u0022,\u0022date\u0022:\u0022Apr 16, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-5\u0022,\u0022sender\u0022:\u0022Loom\u0022,\u0022email\u0022:\u0022notifications@loom.com\u0022,\u0022subject\u0022:\u0022Alexander shared a new screen recording with you\u0022,\u0022content\u0022:\u0022Check out the walkthrough of the new responsive table layouts and filter components.\u0022,\u0022time\u0022:\u0022Apr 24\u0022,\u0022date\u0022:\u0022Apr 24, 2028\u0022,\u0022isRead\u0022:false,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-6\u0022,\u0022sender\u0022:\u0022Airbnb\u0022,\u0022email\u0022:\u0022automated@airbnb.com\u0022,\u0022subject\u0022:\u0022Your reservation in San Francisco is confirmed!\u0022,\u0022content\u0022:\u0022Reservation code: HMD4592. Check-in instructions and host contact details are available.\u0022,\u0022time\u0022:\u0022Mar 05\u0022,\u0022date\u0022:\u0022Mar 05, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-7\u0022,\u0022sender\u0022:\u0022Facebook\u0022,\u0022email\u0022:\u0022security@facebookmail.com\u0022,\u0022subject\u0022:\u0022New login to Business Manager from Chrome on Mac\u0022,\u0022content\u0022:\u0022We noticed a recent sign-in to your account. If this was you, no action is needed.\u0022,\u0022time\u0022:\u0022Feb 25\u0022,\u0022date\u0022:\u0022Feb 25, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-8\u0022,\u0022sender\u0022:\u0022Instagram\u0022,\u0022email\u0022:\u0022updates@instagram.com\u0022,\u0022subject\u0022:\u0022TailAdmin tagged you in a new post: Next.js 16 Launch\u0022,\u0022content\u0022:\u0022Take a look at the latest product release highlights and team announcements.\u0022,\u0022time\u0022:\u0022Feb 20\u0022,\u0022date\u0022:\u0022Feb 20, 2028\u0022,\u0022badge\u0022:\u0022Promotional\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-9\u0022,\u0022sender\u0022:\u0022FormBold\u0022,\u0022email\u0022:\u0022hello@formbold.com\u0022,\u0022subject\u0022:\u0022New form submission: Contact Inquiry received\u0022,\u0022content\u0022:\u0022Someone submitted the enterprise tier contact form. View submission details inside.\u0022,\u0022time\u0022:\u0022Jan 22\u0022,\u0022date\u0022:\u0022Jan 22, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-10\u0022,\u0022sender\u0022:\u0022GrayGrids\u0022,\u0022email\u0022:\u0022support@graygrids.com\u0022,\u0022subject\u0022:\u0022Your all-access license has been renewed\u0022,\u0022content\u0022:\u0022Thank you for being a valued customer. Download your latest template files today.\u0022,\u0022time\u0022:\u0022Feb 25\u0022,\u0022date\u0022:\u0022Feb 25, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false},{\u0022id\u0022:\u0022mail-11\u0022,\u0022sender\u0022:\u0022UIdeck\u0022,\u0022email\u0022:\u0022news@uideck.com\u0022,\u0022subject\u0022:\u00225 New Tailwind CSS Dashboard templates published\u0022,\u0022content\u0022:\u0022Explore the new premium additions to our UI kit library with responsive dark mode.\u0022,\u0022time\u0022:\u0022Feb 15\u0022,\u0022date\u0022:\u0022Feb 15, 2028\u0022,\u0022isRead\u0022:true,\u0022isStarred\u0022:false}]'),
        searchQuery: '',
        checkedIds: {},
        starredIds: {},
        init() {
            this.emails.forEach((email) => { if (email.isStarred) this.starredIds[email.id] = true; });
        },
        get filteredEmails() {
            const query = this.searchQuery.toLowerCase();
            return this.emails.filter((e) => e.sender.toLowerCase().includes(query) || e.subject.toLowerCase().includes(query) || e.content.toLowerCase().includes(query));
        },
        get allChecked() {
            return this.filteredEmails.length > 0 && this.filteredEmails.every((e) => this.checkedIds[e.id]);
        },
        handleSelectAll(checked) {
            const updated = {};
            if (checked) this.filteredEmails.forEach((e) => { updated[e.id] = true; });
            this.checkedIds = updated;
        },
        handleSelectFilter(filter) {
            const updated = {};
            this.filteredEmails.forEach((e) => {
                if (filter === 'all' || (filter === 'read' && e.isRead) || (filter === 'unread' && !e.isRead)) updated[e.id] = true;
            });
            this.checkedIds = updated;
        },
        handleToggleCheck(id, checked) { this.checkedIds = { ...this.checkedIds, [id]: checked }; },
        handleToggleStar(id) { this.starredIds = { ...this.starredIds, [id]: !this.starredIds[id] }; },
        handleDeleteSelected() { this.checkedIds = {}; },
    }"
>
    <div class="flex flex-col gap-3 border-b border-gray-200 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
    <div class="flex items-center gap-2">
        <div class="flex h-10 items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-3 dark:border-gray-800 dark:bg-gray-900">
            <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(allChecked) ? 'true' : 'false'"
    x-bind:data-state="Boolean(allChecked) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(allChecked) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(allChecked) })"
        aria-label="Select all messages" x-on:change="handleSelectAll($event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(allChecked)"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>
            <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button type="button"  data-slot="dropdown-menu-trigger"  aria-haspopup="menu"  aria-expanded="false"  data-state="closed"  x-ref="trigger"  x-bind:id="id + &#039;-trigger&#039;"  x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;"  x-bind:data-state="state"  x-bind:data-popup-open="open ? &#039;&#039; : null"  x-on:click="toggle()"  x-on:keydown="onTriggerKeydown($event)"  aria-label="Select options"   class="flex cursor-pointer items-center justify-center text-gray-500 outline-none transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200" ><svg class="size-3.5 transition-transform duration-200" x-bind:class="open && 'rotate-180'" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>
                <template x-teleport="body">
    <div x-show="open" style="display: none; position: fixed; left: 0; top: 0; min-width: max-content; transform: translate(0, -200%);" x-ref="wrapper" data-popper-content-wrapper dir="ltr">
        <div x-ref="content" role="menu" tabindex="-1" aria-orientation="vertical" data-orientation="vertical" style="outline: none;"
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-36 min-w-36 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleSelectFilter('all')" class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">All</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleSelectFilter('read')" class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Read</div>
                    <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
    @click="handleSelectFilter('unread')" class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Unread</div></div>
    </div>
</template></div>
        </div>

        <button data-slot="button" type="button" aria-label="Mark as read" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-5.5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M3.042 7.062v7.313a.5.5 0 00.5.5h12.916a.5.5 0 00.5-.5V7.062l-5.814 4.055a2 2 0 01-2.288 0L3.042 7.062zm13.916-1.87V5.2a.072.072 0 01-.03.055l-6.642 4.631a.5.5 0 01-.572 0L3.072 5.255a.071.071 0 01.041-.13h13.774c.038 0 .07.03.071.068zm1.5.022v9.161a2 2 0 01-2 2H3.542a2 2 0 01-2-2v-9.18-.03a1.571 1.571 0 011.571-1.54h13.774c.868 0 1.571.703 1.571 1.571v.018z"
      fill="currentColor"
    />
  </svg></button>

        <button data-slot="button" type="button" aria-label="Delete selected" @click="handleDeleteSelected()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.541 3.792a2.25 2.25 0 012.25-2.25h2.417a2.25 2.25 0 012.25 2.25v.25H16.666a.75.75 0 010 1.5h-.29v10.666a2.25 2.25 0 01-2.25 2.25h-8.25a2.25 2.25 0 01-2.25-2.25V5.541h-.292a.75.75 0 110-1.5H6.54v-.25zm8.334 9.454V5.541h-9.75v10.667c0 .414.336.75.75.75h8.25a.75.75 0 00.75-.75v-2.962zM8.041 4.041h3.917v-.25a.75.75 0 00-.75-.75H8.791a.75.75 0 00-.75.75v.25zM8.334 8a.75.75 0 01.75.75v5a.75.75 0 11-1.5 0v-5a.75.75 0 01.75-.75zm4.083.75a.75.75 0 00-1.5 0v5a.75.75 0 101.5 0v-5z"
      fill="currentColor"
    />
  </svg></button>

        <button data-slot="button" type="button" aria-label="Archive selected" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      d="M2.5 6.25V15.5C2.5 16.3284 3.17157 17 4 17H16C16.8284 17 17.5 16.3284 17.5 15.5V6.25M8.33333 10H11.6667M1.66667 3.75C1.66667 3.05964 2.22631 2.5 2.91667 2.5H17.0833C17.7737 2.5 18.3333 3.05964 18.3333 3.75V5C18.3333 5.69036 17.7737 6.25 17.0833 6.25H2.91667C2.22631 6.25 1.66667 5.69036 1.66667 5V3.75Z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>

        <div data-slot="dropdown-menu" data-ui-root x-data="uiDropdown(JSON.parse('{\u0022defaultOpen\u0022:false}'))" class="contents"><button data-slot="dropdown-menu-trigger" aria-haspopup="menu" aria-expanded="false" data-state="closed" x-ref="trigger" x-bind:id="id + &#039;-trigger&#039;" x-bind:aria-expanded="open ? &#039;true&#039; : &#039;false&#039;" x-bind:data-state="state" x-bind:data-popup-open="open ? &#039;&#039; : null" x-on:click="toggle()" x-on:keydown="onTriggerKeydown($event)" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg" type="button" aria-label="More actions"><svg 
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
            x-bind:id="id" x-bind:aria-labelledby="id + '-trigger'" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" data-side="bottom" data-align="start"
            data-slot="dropdown-menu-content" data-options="{&quot;side&quot;:&quot;bottom&quot;,&quot;sideOffset&quot;:8,&quot;align&quot;:&quot;start&quot;,&quot;alignOffset&quot;:0}" dir="ltr"
            x-on:keydown="onContentKeydown($event)"  class="z-99999 flex max-h-(--reka-dropdown-menu-content-available-height) min-w-65 origin-(--reka-dropdown-menu-content-transform-origin) flex-col gap-1 overflow-x-hidden overflow-y-auto rounded-2xl border border-gray-200 bg-white shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:overflow-hidden data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=inline-end]:slide-in-from-left-2 data-[side=inline-start]:slide-in-from-right-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2 dark:border-gray-800 dark:bg-[#1E2635] w-44 p-1.5"><div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Mark all as read</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Filter unread</div>
                <div role="menuitem" tabindex="-1" data-orientation="vertical" data-slot="dropdown-menu-item" data-variant="default"
          x-on:pointermove="highlight($el)" x-on:pointerleave="highlight(null)" x-on:click="closeAll()"
     class="group/dropdown-menu-item relative flex items-center gap-3 font-medium outline-hidden transition-colors duration-200 select-none hover:text-gray-700 focus:bg-gray-100 focus:text-gray-700 data-disabled:pointer-events-none data-disabled:opacity-50 data-highlighted:bg-gray-100 data-highlighted:text-gray-700 data-inset:ps-8 data-[variant=destructive]:text-red-500 data-[variant=destructive]:hover:bg-red-50 data-[variant=destructive]:hover:text-red-600 data-[variant=destructive]:focus:bg-red-50 data-[variant=destructive]:focus:text-red-600 data-[variant=destructive]:data-highlighted:bg-red-50 data-[variant=destructive]:data-highlighted:text-red-600 dark:hover:text-gray-300 dark:focus:bg-white/5 dark:focus:text-gray-300 dark:data-highlighted:bg-white/5 dark:data-highlighted:text-gray-300 dark:data-[variant=destructive]:text-red-400 dark:data-[variant=destructive]:hover:bg-red-500/10 dark:data-[variant=destructive]:hover:text-red-400 dark:data-[variant=destructive]:focus:bg-red-500/10 dark:data-[variant=destructive]:focus:text-red-400 dark:data-[variant=destructive]:data-highlighted:bg-red-500/10 dark:data-[variant=destructive]:data-highlighted:text-red-400 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg]:text-gray-500 group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-700 data-highlighted:[&amp;_svg]:text-gray-700 dark:[&amp;_svg]:text-gray-400 dark:group-hover/dropdown-menu-item:[&amp;_svg]:text-gray-300 dark:data-highlighted:[&amp;_svg]:text-gray-300 [&amp;_svg:not([class*=size-])]:size-5 data-[variant=destructive]:*:[svg]:text-red-500 dark:data-[variant=destructive]:*:[svg]:text-red-400 cursor-pointer rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">Mute selected</div></div>
    </div>
</template></div>
    </div>

    <div data-slot="input-group" role="group"  class="group/input-group relative flex min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 w-full sm:w-64"><div role="group" data-slot="input-group-addon" data-align="inline-start" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-first ps-3.5 has-[&gt;button]:-ms-1 has-[&gt;kbd]:-ms-0.5"><svg class="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M14.382 14.383l3.325 3.326m-1.249-8.334a7.082 7.082 0 01-7.083 7.081 7.082 7.082 0 110-14.163 7.082 7.082 0 017.083 7.082z"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></div>
        <input type="text" data-slot="input-group-control" placeholder="Search messages..." x-model="searchQuery" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0"></div>
</div>

    <div class="custom-scrollbar flex-1 overflow-x-hidden overflow-y-auto">
        <template x-if="filteredEmails.length === 0">
            <div class="p-8 text-center text-sm text-gray-500 dark:text-gray-400">No messages found matching your search.</div>
        </template>
        <template x-for="mail in filteredEmails" x-bind:key="mail.id">
            <div
    class="group flex items-center justify-between gap-3 border-b border-gray-100 px-4 py-3.5 transition-colors sm:px-6 dark:border-gray-800/60"
    x-bind:class="!mail.isRead
        ? 'bg-white font-medium dark:bg-white/3'
        : 'bg-gray-50/50 hover:bg-gray-100/70 dark:bg-transparent dark:hover:bg-white/5'"
>
    <!-- Left Column: Checkbox, Star, Sender -->
    <div class="flex w-36 shrink-0 items-center gap-2.5 sm:w-48 sm:gap-3">
        <button type="button" role="checkbox" data-slot="checkbox" value="on"
          x-bind:aria-checked="Boolean(Boolean(checkedIds[mail.id])) ? 'true' : 'false'"
    x-bind:data-state="Boolean(Boolean(checkedIds[mail.id])) ? 'checked' : 'unchecked'"
    x-bind:data-checked="Boolean(Boolean(checkedIds[mail.id])) ? '' : null"
        x-on:click="$dispatch('change', { checked: !Boolean(Boolean(checkedIds[mail.id])) })"
        x-bind:aria-label="`Select email from ${mail.sender}`" x-on:change="handleToggleCheck(mail.id, $event.detail.checked)" class="peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-md border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:text-white data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent data-disabled:data-checked:text-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800 dark:data-disabled:data-checked:text-gray-600">
    <span data-state="checked" data-slot="checkbox-indicator"
        x-show="Boolean(Boolean(checkedIds[mail.id]))"
        style="display: none;"
        class="grid place-content-center text-current transition-none [&>svg]:size-3 **:stroke-[1.5px]">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
    <path d="M20 6L9 17l-5-5" />
  </svg>
    </span>
</button>

        <button
            type="button"
            aria-label="Star message"
            class="cursor-pointer text-gray-400 transition hover:text-amber-500 dark:hover:text-amber-400"
            x-on:click="handleToggleStar(mail.id)"
        >
            <template x-if="starredIds[mail.id]">
                <svg class="size-4.5 text-amber-500 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
    <path
      d="M8.378.75l2.357 4.776 5.271.766-3.814 3.718.9 5.25-4.714-2.479-4.714 2.479.9-5.25L.75 6.292l5.271-.766L8.378.75z"
      fill="currentColor"
      stroke="currentColor"
    />
  </svg>
            </template>
            <template x-if="!starredIds[mail.id]">
                <svg class="size-4.5 text-gray-400 dark:text-gray-600" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
    <path
      d="M10.001 2.337l2.358 4.777 5.27.766-3.814 3.718.9 5.25-4.714-2.48-4.714 2.48.9-5.25L2.373 7.88l5.271-.766 2.357-4.777z"
      stroke="currentColor"
    />
  </svg>
            </template>
        </button>

        <a
            href="https://laravel-demo.tailadmin.com/inbox-details"
            class="truncate text-sm font-medium text-gray-800 hover:text-brand-500 dark:text-white/90 dark:hover:text-brand-400"
            x-text="mail.sender"
        ></a>
    </div>

    <!-- Center Column: Subject + Snippet Preview + Badge -->
    <a href="https://laravel-demo.tailadmin.com/inbox-details" class="flex min-w-0 flex-1 items-center justify-between gap-3">
        <p class="min-w-0 flex-1 truncate text-sm">
            <span class="font-medium text-gray-800 dark:text-white/90" x-text="mail.subject"></span>
            <span class="text-gray-500 dark:text-gray-400" x-text="'— ' + mail.content"></span>
        </p>

        <span data-slot="badge" data-variant="light" data-color="error" data-size="sm" x-show="mail.badge === 'Important'" x-text="mail.badge" class="group/badge w-fit items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-red-50 text-red-600 [text-shadow:0_4px_4px_var(--color-red-200)] dark:bg-red-500/15 dark:text-red-500 dark:[text-shadow:0_4px_4px_rgba(240,68,56,0.20)] hidden shrink-0 sm:inline-flex"></span>
        <span data-slot="badge" data-variant="light" data-color="success" data-size="sm" x-show="mail.badge === 'Social'" x-text="mail.badge" class="group/badge w-fit items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)] hidden shrink-0 sm:inline-flex"></span>
        <span data-slot="badge" data-variant="light" data-color="primary" data-size="sm" x-show="mail.badge === 'Promotional'" x-text="mail.badge" class="group/badge w-fit items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-brand-50 text-brand-500 [text-shadow:0_4px_4px_var(--color-brand-200)] dark:bg-brand-500/15 dark:text-brand-400 dark:[text-shadow:0_4px_4px_rgba(70,95,255,0.20)] hidden shrink-0 sm:inline-flex"></span>
    </a>

    <!-- Right Column: Time -->
    <div class="shrink-0 text-end">
        <span class="text-xs text-gray-400 dark:text-gray-500" x-text="mail.time"></span>
    </div>
</div>
        </template>
    </div>

    <div class="sticky bottom-0 flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Showing <span class="font-medium text-gray-800 dark:text-white">1–11</span> of
        <span class="font-medium text-gray-800 dark:text-white" x-text="filteredEmails.length"></span>
    </p>

    <div class="flex items-center gap-2">
        <button data-slot="button" type="button" aria-label="Previous page" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></button>
        <button data-slot="button" type="button" aria-label="Next page" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-9 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg class="size-4 rtl:rotate-180" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
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
