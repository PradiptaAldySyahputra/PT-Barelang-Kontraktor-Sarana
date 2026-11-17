<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Calendar
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
                Calendar
            </li>
        </ol>
    </nav>
</div>
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
    <div class="custom-calendar relative">
        <div id="calendar" class="gap-0!"></div>
    </div>

    <div
    x-data="{
        eventTitle: '',
        eventStartDate: '',
        eventEndDate: '',
        eventLevel: 'Primary',
        isEditing: false,
        startPicker: null,
        endPicker: null,
        initPickers() {
            const prevArrow = '<svg class=\'stroke-current\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M12.5 15L7.5 10L12.5 5\' stroke=\'\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>';
            const nextArrow = '<svg class=\'stroke-current\' width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'><path d=\'M7.5 15L12.5 10L7.5 5\' stroke=\'\' stroke-width=\'1.5\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg>';
            const make = (el, value, onChange) => flatpickr(el, { dateFormat: 'Y-m-d', defaultDate: value || undefined, monthSelectorType: 'static', static: true, clickOpens: true, prevArrow, nextArrow, onChange: (_d, str) => onChange(str) });
            this.destroyPickers();
            if (this.$refs.startInput) this.startPicker = make(this.$refs.startInput, this.eventStartDate, (s) => (this.eventStartDate = s));
            if (this.$refs.endInput) this.endPicker = make(this.$refs.endInput, this.eventEndDate, (s) => (this.eventEndDate = s));
        },
        destroyPickers() {
            if (this.startPicker) this.startPicker.destroy();
            if (this.endPicker) this.endPicker.destroy();
            this.startPicker = null;
            this.endPicker = null;
        },
        save() {
            window.dispatchEvent(new CustomEvent('calendar-save', { detail: { title: this.eventTitle, start: this.eventStartDate, end: this.eventEndDate, level: this.eventLevel } }));
        },
    }"
    class="contents"
>
    <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents" @calendar-open.window="const d = $event.detail;
            isEditing = !!d.event;
            eventTitle = d.event ? d.event.title : '';
            eventStartDate = d.start;
            eventEndDate = d.end || d.start;
            eventLevel = d.event ? d.event.level : 'Primary';
            show();
            $nextTick(() => setTimeout(() => initPickers(), 50));"><template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full max-w-[calc(100%-2rem)] -translate-x-1/2 -translate-y-1/2 gap-4 rounded-2xl border border-gray-200 text-sm text-gray-700 duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 overflow-visible border-none bg-transparent p-0 shadow-none sm:max-w-175">
            <div data-slot="card" data-size="default"  class="group/card flex flex-col gap-5 data-[size=sm]:p-4 relative w-full rounded-3xl border border-gray-200 bg-white p-6 shadow-theme-lg sm:p-11 dark:border-gray-800 dark:bg-[#1E2635]"><!-- Top-end circular close button -->
                <button data-slot="dialog-close" x-on:click="close()" class="group/button shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 absolute end-6 top-6 hidden size-11 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-gray-800 sm:flex dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" type="button" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6"><path d="M18 6L6 18M6 6l12 12" /></svg>
                        <span class="sr-only">Close</span></button>

                <!-- Title and subtitle -->
                <div class="flex flex-col gap-2">
                    <h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-title-lg leading-8 font-semibold text-gray-800 sm:text-2xl dark:text-white/90">Add / Edit Event</h2>
                    <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm leading-5 font-normal text-gray-500 dark:text-gray-400">Plan your next big moment: schedule or edit an event to stay on track</p>
                </div>

                <!-- Form fields -->
                <form class="mt-6 space-y-5 sm:mt-8 sm:space-y-6" @submit.prevent="save(); close()">
                    <!-- Event Title -->
                    <div>
                        <label data-slot="label" for="event-title" class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Event Title</label>
                        <input data-slot="input" id="event-title" x-model="eventTitle" class="w-full min-w-0 border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11 rounded-[10px]" />
                    </div>

                    <!-- Event Color -->
                    <div>
                        <label data-slot="label"  class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-3 block text-sm font-medium text-gray-700 sm:mb-4 dark:text-gray-300">Event Color</label>
                        <div role="radiogroup" dir="ltr" data-slot="radio-group" style="outline: none;"
    x-data="{ value: 'Primary' }" x-init="$watch('value', (v) => (eventLevel = v)); $watch('eventLevel', (l) => (value = l))" class="w-full flex flex-wrap items-center gap-4 sm:gap-5"><div class="flex items-center gap-2">
                                    <button type="button" role="radio" data-slot="radio-group-item" value="Primary"  id="modal-color-primary"      aria-checked="true" data-state="checked"  data-checked=""  tabindex="0"
    x-bind:aria-checked="value === 'Primary' ? 'true' : 'false'" x-bind:data-state="value === 'Primary' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'Primary' ? '' : null"
    x-bind:tabindex="value === 'Primary' ? 0 : -1" x-on:click="value = 'Primary'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'Primary'"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                                    <label data-slot="label" for="modal-color-primary" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">Primary</label>
                                </div>
                                                            <div class="flex items-center gap-2">
                                    <button type="button" role="radio" data-slot="radio-group-item" value="Danger"  id="modal-color-danger"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'Danger' ? 'true' : 'false'" x-bind:data-state="value === 'Danger' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'Danger' ? '' : null"
    x-bind:tabindex="value === 'Danger' ? 0 : -1" x-on:click="value = 'Danger'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'Danger'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                                    <label data-slot="label" for="modal-color-danger" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">Danger</label>
                                </div>
                                                            <div class="flex items-center gap-2">
                                    <button type="button" role="radio" data-slot="radio-group-item" value="Success"  id="modal-color-success"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'Success' ? 'true' : 'false'" x-bind:data-state="value === 'Success' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'Success' ? '' : null"
    x-bind:tabindex="value === 'Success' ? 0 : -1" x-on:click="value = 'Success'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'Success'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                                    <label data-slot="label" for="modal-color-success" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">Success</label>
                                </div>
                                                            <div class="flex items-center gap-2">
                                    <button type="button" role="radio" data-slot="radio-group-item" value="Warning"  id="modal-color-warning"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'Warning' ? 'true' : 'false'" x-bind:data-state="value === 'Warning' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'Warning' ? '' : null"
    x-bind:tabindex="value === 'Warning' ? 0 : -1" x-on:click="value = 'Warning'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'Warning'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                                    <label data-slot="label" for="modal-color-warning" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">Warning</label>
                                </div>
                                                            <div class="flex items-center gap-2">
                                    <button type="button" role="radio" data-slot="radio-group-item" value="Info"  id="modal-color-info"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'Info' ? 'true' : 'false'" x-bind:data-state="value === 'Info' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'Info' ? '' : null"
    x-bind:tabindex="value === 'Info' ? 0 : -1" x-on:click="value = 'Info'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'Info'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
                                    <label data-slot="label" for="modal-color-info" class="flex items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 cursor-pointer text-sm font-normal text-gray-700 dark:text-gray-400">Info</label>
                                </div></div>
                    </div>

                    <!-- Enter Start Date -->
                    <div>
                        <label data-slot="label" for="event-start-date" class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Enter Start Date</label>
                        <input data-slot="input" x-ref="startInput" id="event-start-date" placeholder="dd/mm/yyyy" x-model="eventStartDate" class="w-full min-w-0 border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11 rounded-[10px]" />
                    </div>

                    <!-- Enter End Date -->
                    <div>
                        <label data-slot="label" for="event-end-date" class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Enter End Date</label>
                        <input data-slot="input" x-ref="endInput" id="event-end-date" placeholder="dd/mm/yyyy" x-model="eventEndDate" class="w-full min-w-0 border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11 rounded-[10px]" />
                    </div>

                    <!-- Action buttons -->
                    <div class="grid grid-cols-2 gap-3 pt-2 sm:flex sm:justify-end sm:pt-4">
                        <button data-slot="button" type="button" @click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 gap-2 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] px-5 py-3 sm:w-auto">Close</button>
                        <button data-slot="button" type="submit"  class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 w-full rounded-[10px] px-5 py-3 sm:w-auto"><span x-text="isEditing ? 'Save Changes' : 'Add Event'">Add Event</span></button>
                    </div>
                </form></div>
                    </div>
    </div>
</template></div>
</div>
</div>
            </div>
        </div>

    </div>

</body>


</html>
