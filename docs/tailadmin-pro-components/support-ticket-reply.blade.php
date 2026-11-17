<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        Respuesta a Ticket
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
                Respuesta a Ticket
            </li>
        </ol>
    </nav>
</div>
    <div
    class="flex flex-col gap-6 xl:flex-row xl:items-start"
    x-data="{
        init() {
            // Scroll the new reply into view whenever the message count changes (not on first load)
            this.$watch('msgList.length', () => this.$nextTick(() => this.$refs.bottom?.scrollIntoView({ behavior: 'smooth' })));
        },
        msgList: JSON.parse('[{\u0022id\u0022:1,\u0022senderName\u0022:\u0022John D\u0022,\u0022senderRole\u0022:\u0022Customer\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/user-18.jpg\u0022,\u0022time\u0022:\u0022Mon, 3:20 PM (2 hrs ago)\u0022,\u0022message\u0022:\u0022Hi TailAdmin Team,\\nI hope you\\u0027re doing well.\\n\\nI\\u2019m currently working on customizing the TailAdmin dashboard and would like to add a new section labeled \\u201cReports.\\u201d Before I proceed, I wanted to check if there\\u2019s any official guide or best practice you recommend for adding custom pages within the TailAdmin structure.\u0022,\u0022isAgent\u0022:false},{\u0022id\u0022:2,\u0022senderName\u0022:\u0022Musharof Chowdhury\u0022,\u0022senderRole\u0022:\u0022From - tailadmin support team\u0022,\u0022senderAvatar\u0022:\u0022\\\/assets\\\/images\\\/user\\\/owner.png\u0022,\u0022time\u0022:\u0022Mon, 3:25 PM (2 hrs ago)\u0022,\u0022message\u0022:\u0022Hi John D,\\n\\nThanks for reaching out\\u2014and great to hear you\\u0027re customizing TailAdmin to fit your needs!\\nYes, you can definitely add custom pages like a \\u201cReports\\u201d section, and it\\u2019s quite straightforward. Here\\u2019s a quick guide to help you get started:\\n\\nTo include your new page in the sidebar:\\n\\u2022 Go to the sidebar configuration file (sidebarData.ts or similar)\\n\\u2022 Add a new entry with the label \\u0022Reports\\u0022 and route \\\/reports\u0022,\u0022isAgent\u0022:true}]'),
        selectedStatus: 'resolved',
        handleSendReply(text) {
            this.msgList.push({
                id: Date.now(),
                senderName: 'Musharof Chowdhury',
                senderRole: 'From - tailadmin support team',
                senderAvatar: '/assets/images/user/owner.png',
                time: 'Just now',
                message: text,
                isAgent: true,
            });
        },
    }"
>
    <!-- Left Column: Conversation & Reply Card -->
    <div class="flex-1 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xs dark:border-gray-800 dark:bg-white/3">
        <div class="flex flex-col gap-4 border-b border-gray-200 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 dark:border-gray-800">
    <div>
        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Ticket #346520 - Sidebar not responsive on mobile</h3>
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Mon, 3:20 PM (2 days ago)</p>
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> 4 of 120 </span>
        <div class="flex items-center gap-2">
            <button data-slot="button" type="button" aria-label="Previous ticket" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M15 18l-6-6 6-6" />
  </svg></button>
            <button data-slot="button" type="button" aria-label="Next ticket" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 size-8 rounded-lg in-data-[slot=button-group]:rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-4 rtl:rotate-180">
    <path d="M9 18l6-6-6-6" />
  </svg></button>
        </div>
    </div>
</div>

        <div data-slot="scroll-area"  class="relative max-h-155">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-x-hidden overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 max-h-155">
        <div class="min-w-0"><div class="space-y-7 p-5 sm:p-6">
        <template x-for="msg in msgList" x-bind:key="msg.id">
            <div class="border-b border-gray-200 pb-7 last:border-b-0 last:pb-0 dark:border-gray-800">
                <!-- User row -->
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span data-slot="avatar" data-size="default" x-data="{ loaded: false }"  class="group/avatar relative flex shrink-0 rounded-full select-none data-[size=lg]:size-12 data-[size=sm]:size-8 data-[size=xl]:size-14 data-[size=xs]:size-6 dark:after:mix-blend-lighten size-10"><img data-slot="avatar-image" x-show="loaded" style="display: none;" x-init="loaded = $el.complete && $el.naturalWidth > 0" x-on:load="loaded = true" x-on:error="loaded = false" x-bind:src="msg.senderAvatar" x-bind:alt="msg.senderName" class="aspect-square size-full rounded-full object-cover">
                            <template x-if="!loaded">
<span data-slot="avatar-fallback" x-text="msg.senderName.charAt(0)" class="flex size-full items-center justify-center rounded-full bg-[#F3F4F6] text-sm text-gray-700 group-data-[size=sm]/avatar:text-xs group-data-[size=xs]/avatar:text-xs dark:bg-[rgba(255,255,255,0.05)] dark:text-gray-400"></span>
</template></span>
                        <div>
                            <h4 class="text-sm font-medium text-gray-800 dark:text-white/90" x-text="msg.senderName"></h4>
                            <p class="text-xs font-normal text-gray-500 dark:text-gray-400" x-text="msg.senderRole"></p>
                        </div>
                    </div>
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400" x-text="msg.time"></span>
                </div>

                <!-- Message Body -->
                <div class="text-sm leading-relaxed font-normal whitespace-pre-wrap text-gray-600 dark:text-gray-400" x-text="msg.message"></div>
            </div>
        </template>
        <div x-ref="bottom"></div>
    </div></div>
    </div>
</div>

        <form
    x-data="{
        replyText: '',
        handleSubmit() {
            if (!this.replyText.trim()) return;
            handleSendReply(this.replyText);
            this.replyText = '';
        },
        handleKeyDown(e) {
            if (e.key === 'Enter' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault();
                this.handleSubmit();
            }
        },
        handleFileChange(e) {
            if (e.target.files && e.target.files.length > 0) e.target.value = '';
        },
    }"
    x-on:submit.prevent="handleSubmit()"
    class="border-t border-gray-200 p-5 sm:p-6 dark:border-gray-800"
>
    <input x-ref="fileInput" type="file" class="hidden" x-on:change="handleFileChange($event)" />

    <div data-slot="input-group" role="group"  class="group/input-group relative flex h-11 w-full min-w-0 items-center border outline-hidden in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 rounded-2xl border-gray-200 bg-white shadow-none transition-colors has-disabled:cursor-auto has-disabled:border-gray-200 has-disabled:bg-white dark:border-gray-800 dark:bg-gray-900 dark:has-disabled:border-gray-800 dark:has-disabled:bg-gray-900"><textarea data-slot="input-group-control" placeholder="Type your reply here..." x-model="replyText" x-on:keydown="handleKeyDown($event)" rows="3" class="flex min-w-0 border-gray-300 outline-hidden transition-colors focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 flex-1 resize-none rounded-none border-0 shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 focus:aria-invalid:border-transparent focus:aria-invalid:ring-0 focus-visible:aria-invalid:border-transparent focus-visible:aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 focus:data-[success=true]:border-transparent focus:data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:focus:aria-invalid:border-transparent dark:focus:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 min-h-25 w-full bg-transparent p-5 text-sm font-normal text-gray-800 placeholder:text-gray-400 dark:text-white/90 dark:placeholder:text-gray-500"></textarea>

        <div role="group" data-slot="input-group-addon" data-align="block-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="h-auto cursor-text gap-2 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last group-has-[&gt;input]/input-group:pb-2.5 [.border-t]:pt-2 flex w-full items-center justify-between p-3"><button type="button" data-slot="button" data-size="xs" @click="$refs.fileInput.click()" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding whitespace-nowrap outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center shadow-none px-2 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-3.5 h-auto cursor-pointer gap-1.5 rounded-lg py-2 ps-2 pe-2.5 text-sm font-medium text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-800 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="size-5">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.88029 3.10905C8.54002 1.44932 11.231 1.44933 12.8907 3.10906C14.5504 4.76878 14.5504 7.45973 12.8907 9.11946L12.0654 9.94479L11.0047 8.88413L11.83 8.0588C12.904 6.98486 12.904 5.24366 11.83 4.16972C10.7561 3.09577 9.01489 3.09577 7.94095 4.16971L7.11562 4.99504L6.05496 3.93438L6.88029 3.10905ZM8.88339 11.0055L9.94405 12.0661L9.11946 12.8907C7.45973 14.5504 4.76878 14.5504 3.10905 12.8907C1.44933 11.231 1.44933 8.54002 3.10905 6.88029L3.93364 6.0557L4.9943 7.11636L4.16971 7.94095C3.09577 9.01489 3.09577 10.7561 4.16971 11.83C5.24366 12.904 6.98486 12.904 8.0588 11.83L8.88339 11.0055ZM9.94422 7.11599C10.2371 6.8231 10.2371 6.34823 9.94422 6.05533C9.65132 5.76244 9.17645 5.76244 8.88356 6.05533L6.05513 8.88376C5.76224 9.17665 5.76224 9.65153 6.05513 9.94442C6.34802 10.2373 6.8229 10.2373 7.11579 9.94442L9.94422 7.11599Z"
      fill="currentColor"
    />
  </svg>
                Attach</button>

            <button data-slot="button" type="submit" x-bind:disabled="!replyText.trim()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 gap-2 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-9.5 cursor-pointer rounded-[10px] px-5 text-sm font-medium shadow-theme-xs disabled:cursor-not-allowed">Reply</button></div></div>
</form>

        <div class="flex items-center gap-4 px-5 pb-5 sm:px-6">
    <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> Status: </span>
    <div role="radiogroup" dir="ltr" data-slot="radio-group" style="outline: none;"
    x-data="{ value: 'resolved' }"  class="w-full flex items-center gap-5"><label class="flex items-center gap-2 cursor-pointer">
            <button type="button" role="radio" data-slot="radio-group-item" value="resolved"      aria-checked="true" data-state="checked"  data-checked=""  tabindex="0"
    x-bind:aria-checked="value === 'resolved' ? 'true' : 'false'" x-bind:data-state="value === 'resolved' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'resolved' ? '' : null"
    x-bind:tabindex="value === 'resolved' ? 0 : -1" x-on:click="value = 'resolved'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'resolved'"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
            <span class="text-sm font-normal text-gray-800 dark:text-white/90"> Resolved </span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <button type="button" role="radio" data-slot="radio-group-item" value="pending"      aria-checked="false" data-state="unchecked"  tabindex="-1"
    x-bind:aria-checked="value === 'pending' ? 'true' : 'false'" x-bind:data-state="value === 'pending' ? 'checked' : 'unchecked'" x-bind:data-checked="value === 'pending' ? '' : null"
    x-bind:tabindex="value === 'pending' ? 0 : -1" x-on:click="value = 'pending'"
     class="group/radio-group-item peer relative flex size-4 shrink-0 cursor-pointer items-center justify-center rounded-full border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors group-has-focus-visible/field-label:ring-0 group-has-disabled/field:opacity-50 after:absolute after:-inset-x-3 after:-inset-y-2 hover:border-brand-500 focus-visible:border-brand-500 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 data-checked:border-brand-500 data-checked:bg-brand-500 data-checked:hover:border-brand-600 data-checked:hover:bg-brand-600 aria-invalid:data-checked:border-red-500 aria-invalid:data-checked:bg-red-500 data-disabled:data-checked:border-gray-200 data-disabled:data-checked:bg-transparent dark:border-gray-700 dark:bg-gray-900 dark:hover:border-brand-400 dark:focus-visible:border-brand-400 dark:focus-visible:ring-brand-500/30 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:data-checked:border-brand-500 dark:data-checked:bg-brand-500 dark:data-checked:hover:border-brand-600 dark:data-checked:hover:bg-brand-600 dark:data-disabled:data-checked:border-gray-800">
    <span data-state="checked" data-slot="radio-group-indicator" x-show="value === 'pending'"  style="display: none;"  class="flex size-4 items-center justify-center"><span class="size-2 rounded-full bg-white group-data-disabled/radio-group-item:bg-gray-200 dark:group-data-disabled/radio-group-item:bg-gray-700"></span></span>
</button>
            <span class="text-sm font-normal text-gray-800 dark:text-white/90"> Pending </span>
        </label></div>
</div>
    </div>

    <!-- Right Column: Ticket Metadata Details -->
    <div class="w-full shrink-0 xl:w-[320px]">
        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xs dark:border-gray-800 dark:bg-white/3">
    <div class="border-b border-gray-200 px-6 py-5 dark:border-gray-800">
        <h3 class="text-lg font-medium text-gray-800 dark:text-white/90">Ticket Details</h3>
    </div>

    <div class="px-6 py-3">
        <ul class="text-sm">
            <li class="flex items-center justify-between border-b border-gray-100 py-2.5 dark:border-gray-800">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Customer </span>
                <span class="font-normal text-gray-800 dark:text-white/90">
                    John D
                </span>
            </li>

            <li class="flex items-center justify-between border-b border-gray-100 py-2.5 dark:border-gray-800">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Email </span>
                <span class="font-normal break-all text-gray-800 dark:text-white/90">
                    jhondelin@gmail.com
                </span>
            </li>

            <li class="flex items-center justify-between border-b border-gray-100 py-2.5 dark:border-gray-800">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Ticket ID </span>
                <span class="font-normal text-gray-800 dark:text-white/90">
                    #346520
                </span>
            </li>

            <li class="flex items-center justify-between border-b border-gray-100 py-2.5 dark:border-gray-800">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Category </span>
                <span class="font-normal text-gray-800 dark:text-white/90">
                    General Support
                </span>
            </li>

            <li class="flex items-center justify-between border-b border-gray-100 py-2.5 dark:border-gray-800">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Created </span>
                <span class="font-normal text-gray-800 dark:text-white/90">
                    Dec 20, 2028
                </span>
            </li>

            <li class="flex items-center justify-between py-2.5">
                <span class="w-28 text-gray-500 dark:text-gray-400"> Status </span>
                <span data-slot="badge" data-variant="light" data-color="info" data-size="sm"  class="group/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [&amp;&gt;svg]:pointer-events-none [&amp;&gt;svg]:shrink-0 h-5.5 rounded-lg px-2 py-0.5 text-xs [&amp;:has(&gt;svg:first-child)]:ps-1.5 [&amp;:has(&gt;svg:last-child)]:pe-1.5 [&amp;&gt;svg]:size-3 bg-sky-50 text-sky-500 [text-shadow:0_4px_4px_var(--color-sky-200)] dark:bg-sky-500/15 dark:text-sky-500 dark:[text-shadow:0_4px_4px_rgba(11,165,236,0.20)]">In Progress</span>
            </li>
        </ul>
    </div>
</div>
    </div>
</div>
            </div>
        </div>

    </div>

</body>


</html>
