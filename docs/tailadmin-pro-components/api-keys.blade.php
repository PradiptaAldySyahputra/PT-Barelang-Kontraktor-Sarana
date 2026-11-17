<div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                    <div>
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
        API Keys
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
                API Keys
            </li>
        </ol>
    </nav>
</div>
        <div
    x-data="{
        keys: JSON.parse('[{\u0022id\u0022:\u00226\u0022,\u0022name\u0022:\u0022Saasbold\u0022,\u0022value\u0022:\u0022sk_live_0Xftd3jMXl1XQCFss67cKvDD0UjIAz5u\u0022,\u0022masked\u0022:\u0022sk_live_**********Az5u\u0022,\u0022status\u0022:\u0022Active\u0022,\u0022created\u0022:\u002213 Nov, 2026\u0022,\u0022lastUsed\u0022:\u002213 Nov, 2026, 07:57 AM\u0022}]'),
        copiedId: null,
        appName: 'Saasbold',
        busy: false,
        base: 'https://laravel-demo.tailadmin.com/api-keys',
        async call(method, path, body) {
            const res = await fetch(this.base + path, {
                method,
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                body: body ? JSON.stringify(body) : undefined,
            });
            if (!res.ok) throw new Error(await res.text());
            return res.json();
        },
        replace(row) { this.keys = this.keys.map((k) => (k.id === row.id ? row : k)); },
        async handleToggle(id) { try { this.replace((await this.call('PUT', `/${id}/toggle`)).apiKey); } catch (e) { console.error(e); } },
        async handleDelete(id) { try { await this.call('DELETE', `/${id}`); this.keys = this.keys.filter((k) => k.id !== id); } catch (e) { console.error(e); } },
        async handleRegenerate(id) { try { this.replace((await this.call('POST', `/${id}/regenerate`)).apiKey); } catch (e) { console.error(e); } },
        async handleCopy(apiKey) {
            try {
                await navigator.clipboard.writeText(apiKey.value);
                this.copiedId = apiKey.id;
                setTimeout(() => (this.copiedId = null), 1500);
            } catch (e) {}
        },
        async generate(dialog) {
            const name = this.appName.trim();
            if (!name || this.busy) return;
            this.busy = true;
            try {
                const { apiKey } = await this.call('POST', '', { name });
                this.keys = [apiKey, ...this.keys];
                dialog.close();
            } catch (e) { console.error(e); } finally { this.busy = false; }
        },
    }"
>
    <div data-slot="dialog" data-ui-root x-data="uiDialog()" class="contents" data-dlg="create"><div data-slot="card" data-size="default"  class="group/card flex flex-col p-5 data-[size=sm]:p-4 sm:p-6 gap-0 overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3"><div data-slot="card-header"  class="group-data-[size=sm]/card:gap-1 flex flex-col justify-between gap-5 border-b border-gray-100 pb-4 sm:flex-row sm:items-center dark:border-gray-800"><div>
                    <div data-slot="card-title"  class="mb-2 group-data-[size=sm]/card:mb-1 [div[data-slot=card-header]_&amp;]:mb-0 text-lg font-semibold text-gray-800 dark:text-white/90">API Keys</div>
                    <div data-slot="card-description"  class="text-sm text-gray-500 dark:text-gray-400">API keys are used to authenticate requests to the tailadmin API</div>
                </div>

                <button data-slot="button" type="button" @click="show()" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 bg-brand-500 text-white shadow-theme-xs hover:bg-brand-600 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 rounded-[10px] py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 h-11 gap-2 px-4 text-sm font-medium"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
    <path d="M5 12h14M12 5v14" />
  </svg>
                    Add API Key</button></div>

            <div data-slot="card-content"  class="p-0"><div data-slot="scroll-area"  class="relative w-full">
    <div data-slot="scroll-area-viewport" class="custom-scrollbar size-full overflow-y-auto rounded-[inherit] outline-none transition-[color,box-shadow] focus-visible:ring-[3px] focus-visible:ring-brand-500/20 focus-visible:outline-1 overflow-x-auto">
        <div class="min-w-0"><table class="min-w-187.5 min-w-full">
                        <thead class="border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="h-11 min-w-[380px] py-3 ps-4 text-start text-xs font-medium text-gray-500 sm:ps-6 dark:text-gray-400">Name & Key</th>
                                <th class="h-11 min-w-[120px] px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                                <th class="h-11 min-w-[130px] px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Created</th>
                                <th class="h-11 min-w-[140px] px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Last used</th>
                                <th class="h-11 min-w-[120px] px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-gray-400">Disable/Enable</th>
                                <th class="h-11 min-w-[100px] py-3 pe-4 text-center text-xs font-medium text-gray-500 sm:pe-6 dark:text-gray-400">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            <template x-for="apiKey in keys" :key="apiKey.id">
                                <tr class="dark:border-gray-800">
                                    <td class="py-4 ps-4 sm:ps-6">
                                        <div>
                                            <span class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300" x-text="apiKey.name"></span>
                                            <div class="flex items-center gap-2">
                                                <div data-slot="input-group" role="group"  class="group/input-group relative flex w-full min-w-0 items-center rounded-[10px] border border-gray-300 bg-white shadow-theme-xs outline-hidden transition-colors in-data-[slot=combobox-content]:focus-within:border-inherit in-data-[slot=combobox-content]:focus-within:ring-0 has-[[data-slot=input-group-control]:focus]:border-brand-300 has-[[data-slot=input-group-control]:focus]:ring-3 has-[[data-slot=input-group-control]:focus]:ring-brand-500/20 has-[[data-slot=input-group-control]:focus-visible]:border-brand-300 has-[[data-slot=input-group-control]:focus-visible]:ring-3 has-[[data-slot=input-group-control]:focus-visible]:ring-brand-500/20 has-[:is([data-slot=input-group-control],input,textarea):disabled]:cursor-not-allowed has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-200 has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-100/50 has-[:is([data-slot=input-group-control],input,textarea):disabled]:shadow-none has-[[data-slot][aria-invalid=true]]:border-red-500 has-[[data-slot][aria-invalid=true]]:ring-3 has-[[data-slot][aria-invalid=true]]:ring-red-500/20 has-[[data-slot][data-success=true]]:border-green-500 has-[[data-slot][data-success=true]]:ring-3 has-[[data-slot][data-success=true]]:ring-green-500/20 has-[&gt;[data-align=block-end]]:h-auto has-[&gt;[data-align=block-end]]:flex-col has-[&gt;[data-align=block-start]]:h-auto has-[&gt;[data-align=block-start]]:flex-col has-[&gt;textarea]:h-auto has-[&gt;[data-align=block-end]]:[&amp;&gt;input]:pt-3 has-[&gt;[data-align=block-start]]:[&amp;&gt;input]:pb-3 has-[&gt;[data-align=inline-end]]:[&amp;&gt;input]:pe-2 has-[&gt;[data-align=inline-start]]:[&amp;&gt;input]:ps-2 dark:border-gray-700 dark:bg-gray-900 dark:has-[[data-slot=input-group-control]:focus]:border-brand-500/40 dark:has-[[data-slot=input-group-control]:focus-visible]:border-brand-500/40 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:border-gray-800 dark:has-[:is([data-slot=input-group-control],input,textarea):disabled]:bg-gray-800/50 dark:has-[[data-slot][aria-invalid=true]]:border-red-500/50 dark:has-[[data-slot][aria-invalid=true]]:ring-red-500/40 dark:has-[[data-slot][data-success=true]]:border-green-500/50 dark:has-[[data-slot][data-success=true]]:ring-green-500/40 h-10 flex-1 sm:max-w-sm"><input type="text" data-slot="input-group-control" x-bind:value="apiKey.masked" readonly="readonly" class="w-full min-w-0 border-gray-300 py-2.5 ps-4 pe-4 font-normal outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:ring-brand-500/20 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:text-gray-400 aria-invalid:ring-red-500/20 data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:disabled:border-gray-800 dark:disabled:text-gray-500 dark:aria-invalid:ring-red-500/40 dark:data-[success=true]:ring-green-500/40 h-full flex-1 rounded-none border-0 bg-transparent shadow-none ring-0 focus:border-transparent focus:ring-0 focus:outline-hidden focus-visible:border-transparent focus-visible:ring-0 disabled:bg-transparent disabled:shadow-none aria-invalid:border-transparent aria-invalid:ring-0 data-[success=true]:border-transparent data-[success=true]:ring-0 dark:bg-transparent dark:focus:border-transparent dark:focus-visible:border-transparent dark:disabled:bg-transparent dark:aria-invalid:border-transparent dark:aria-invalid:ring-0 dark:data-[success=true]:border-transparent dark:data-[success=true]:ring-0 text-xs text-gray-700 dark:text-gray-300">
                                                    <div role="group" data-slot="input-group-addon" data-align="inline-end" 
    x-on:click="if (! $event.target.closest('button')) $el.parentElement.querySelector('input, textarea')?.focus()"
    class="flex h-auto cursor-text items-center justify-center gap-2 py-1.5 text-sm font-medium text-gray-500 select-none group-data-[disabled=true]/input-group:opacity-50 dark:text-gray-400 [&amp;&gt;kbd]:rounded-md [&amp;&gt;kbd]:border [&amp;&gt;kbd]:border-gray-200 [&amp;&gt;kbd]:bg-gray-50 dark:[&amp;&gt;kbd]:border-gray-700 dark:[&amp;&gt;kbd]:bg-gray-800 [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-4 order-last pe-3.5 has-[&gt;button]:-me-1 has-[&gt;kbd]:-me-0.5"><button type="button" data-slot="button" data-size="xs" x-bind:disabled="copiedId === apiKey.id" x-bind:aria-label="`Copy key for ${apiKey.name}`" @click="handleCopy(apiKey)" class="group/button shrink-0 justify-center border border-transparent bg-clip-padding font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent text-gray-700 hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:text-gray-300 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 flex items-center shadow-none h-7 gap-1 rounded-md px-2 text-xs [&amp;&gt;svg:not([class*=&#039;size-&#039;])]:size-3.5 disabled:border-none disabled:bg-transparent"><template x-if="copiedId === apiKey.id">
                                                                <span class="flex items-center gap-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5 text-success-500">
    <path d="M20 6L9 17l-5-5" />
  </svg>
                                                                    <span class="text-success-500">Copied</span>
                                                                </span>
                                                            </template>
                                                            <template x-if="copiedId !== apiKey.id">
                                                                <span class="flex items-center gap-1">
                                                                    <svg class="size-3.5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path
      fill-rule="evenodd"
      clip-rule="evenodd"
      d="M6.588 4.584a.5.5 0 01.5-.5h8.327a.5.5 0 01.5.5v8.329a.5.5 0 01-.5.5H7.088a.5.5 0 01-.5-.5V4.584zm.5-2a2 2 0 00-2 2v.51h-.503a2 2 0 00-2 2v8.322a2 2 0 002 2h8.322a2 2 0 002-2v-.503h.508a2 2 0 002-2V4.584a2 2 0 00-2-2H7.088zm6.319 12.329H7.088a2 2 0 01-2-2V6.594h-.503a.5.5 0 00-.5.5v8.322a.5.5 0 00.5.5h8.322a.5.5 0 00.5-.5v-.503z"
      fill="currentColor"
    />
  </svg>
                                                                    <span>Copy</span>
                                                                </span>
                                                            </template></button></div></div>

                                                <button data-slot="button" type="button" x-bind:aria-label="`Regenerate ${apiKey.name}`" @click="handleRegenerate(apiKey.id)" class="group/button inline-flex items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-[10px] size-10 shrink-0 text-gray-600 dark:text-gray-400"><svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
    <path
      d="M13.635 6.49a5.833 5.833 0 00-11.268 0c-.068.253-.111.43-.137.553M1.136 5.1L2.23 7.043l.062.11 2.054-1.156M2.365 9.51a5.833 5.833 0 0011.268 0c.07-.258.113-.437.14-.56m1.097 1.95l-1.098-1.95-.058-.103-2.054 1.156"
      stroke="currentColor"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    />
  </svg></button>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-start">
                                        <span data-slot="badge" class="capitalize" x-bind:class="apiKey.status === 'Active' ? 'group\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\u0026\u003Esvg]:pointer-events-none [\u0026\u003Esvg]:shrink-0 h-6 rounded-lg px-2.5 py-0.5 text-sm [\u0026:has(\u003Esvg:first-child)]:ps-2 [\u0026:has(\u003Esvg:last-child)]:pe-2 [\u0026\u003Esvg]:size-3.5 bg-green-50 text-green-600 [text-shadow:0_4px_4px_var(--color-green-200)] dark:bg-green-500\/15 dark:text-green-500 dark:[text-shadow:0_4px_4px_rgba(18,183,106,0.20)]' : 'group\/badge inline-flex w-fit shrink-0 items-center justify-center gap-1 font-medium whitespace-nowrap transition-colors select-none [\u0026\u003Esvg]:pointer-events-none [\u0026\u003Esvg]:shrink-0 h-6 rounded-lg px-2.5 py-0.5 text-sm [\u0026:has(\u003Esvg:first-child)]:ps-2 [\u0026:has(\u003Esvg:last-child)]:pe-2 [\u0026\u003Esvg]:size-3.5 bg-gray-100 text-gray-700 [text-shadow:0_4px_4px_var(--color-gray-300)] dark:bg-white\/5 dark:text-white\/80 dark:[text-shadow:0_4px_4px_rgba(255,255,255,0.10)]'" x-text="apiKey.status"></span>
                                    </td>

                                    <td class="px-4 py-4 text-start text-sm text-gray-600 dark:text-gray-400" x-text="apiKey.created"></td>
                                    <td class="px-4 py-4 text-start text-sm text-gray-600 dark:text-gray-400" x-text="apiKey.lastUsed"></td>

                                    <td class="px-4 py-4 text-start" x-data="{ get on() { return apiKey.status === 'Active'; }, set on(v) { if (v !== (apiKey.status === 'Active')) handleToggle(apiKey.id); } }">
                                        <button
    type="button"
    role="switch"
    data-slot="switch"
    data-size="default"
            x-bind:aria-checked="on ? 'true' : 'false'"
    x-bind:data-state="on ? 'checked' : 'unchecked'"
    x-bind:data-checked="on ? '' : null"
    x-bind:data-unchecked="on ? null : ''"
     x-on:click="on = !on"     x-bind:aria-label="`Toggle status for ${apiKey.name}`"
    class="peer relative inline-flex shrink-0 cursor-pointer items-center rounded-full transition-colors outline-hidden select-none focus-visible:ring-2 focus-visible:ring-brand-500/20 focus-visible:outline-hidden dark:focus-visible:ring-brand-500/30 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 data-checked:bg-brand-500 data-checked:hover:bg-brand-600 dark:data-checked:bg-brand-500 dark:data-checked:hover:bg-brand-600 data-disabled:cursor-not-allowed data-disabled:bg-gray-100 data-disabled:hover:bg-gray-100 dark:data-disabled:bg-gray-800 dark:data-disabled:hover:bg-gray-800 data-disabled:data-checked:bg-gray-100 data-disabled:data-checked:hover:bg-gray-100 dark:data-disabled:data-checked:bg-gray-800 dark:data-disabled:data-checked:hover:bg-gray-800 group-has-focus-visible/field-label:ring-0 after:absolute after:-inset-x-3 after:-inset-y-2 aria-invalid:ring-3 aria-invalid:ring-error-500/20 dark:aria-invalid:ring-error-500/40 h-6 w-13 p-0.5"
>
    <span
        data-slot="switch-thumb"
        x-bind:data-checked="on ? '' : null"
        x-bind:data-unchecked="on ? null : ''"
        class="pointer-events-none block shrink-0 rounded-full bg-white shadow-theme-sm ring-0 transition-transform duration-150 ease-linear data-unchecked:translate-x-0 rtl:data-unchecked:translate-x-0 h-5 w-[30px] data-checked:translate-x-[18px] rtl:data-checked:-translate-x-[18px]"
    ></span>
</button>
                                    </td>

                                    <td class="py-4 pe-4 text-center whitespace-nowrap sm:pe-6">
                                        <button data-slot="button" type="button" x-bind:aria-label="`Delete ${apiKey.name}`" @click="handleDelete(apiKey.id)" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-none bg-transparent focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 rounded-lg in-data-[slot=button-group]:rounded-lg size-8 text-gray-500 hover:bg-red-500/10 hover:text-red-500 dark:text-gray-400 dark:hover:bg-red-500/10 dark:hover:text-red-500"><svg class="size-5" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        </tbody>
                    </table></div>
    </div>
</div></div></div>

        <template x-teleport="body">
    <div x-show="open" style="display: none;" data-dialog-portal data-ui-root>
        <div data-slot="dialog-overlay" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" x-on:click="close()" class="fixed inset-0 isolate z-100 bg-black/50 duration-100 data-closed:animate-out data-closed:fade-out-0 data-open:animate-in data-open:fade-in-0 supports-backdrop-filter:backdrop-blur-xs dark:bg-black/70" style="pointer-events: auto;"></div>
        <div x-ref="content" role="dialog" tabindex="-1" x-bind:id="id" x-bind:aria-labelledby="titleId" x-bind:aria-describedby="descriptionId" data-slot="dialog-content" x-bind:data-state="state" x-bind:data-open="state === 'open' ? '' : null" data-state="closed" style="pointer-events: auto;"  class="fixed start-1/2 top-1/2 z-101 grid w-full -translate-x-1/2 -translate-y-1/2 gap-4 rounded-2xl border border-gray-200 bg-white text-sm text-gray-700 shadow-theme-lg duration-100 outline-none data-closed:animate-out data-closed:fade-out-0 data-closed:zoom-out-95 data-open:animate-in data-open:fade-in-0 data-open:zoom-in-95 sm:max-w-lg rtl:translate-x-1/2 dark:border-gray-800 dark:bg-[#1E2635] dark:text-gray-300 max-w-[600px] p-6 lg:p-10">
            <div data-slot="dialog-header"  class="flex flex-col gap-2 mb-4"><h2 data-slot="dialog-title" x-bind:id="titleId"  class="text-title-sm font-semibold text-gray-800 dark:text-white/90">Generate API key</h2>
                <p data-slot="dialog-description" x-bind:id="descriptionId"  class="text-sm leading-6 text-gray-500 dark:text-gray-400">To enable secure access to the web services, your app requires an API key with permissions for resources such as the S3 bucket.</p></div>

            <form class="space-y-4" @submit.prevent="generate($data)">
                <div>
                    <label data-slot="label" for="app-name" class="items-center gap-2 select-none group-data-[disabled=true]:pointer-events-none group-data-[disabled=true]:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:opacity-50 mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Enter your application name</label>
                    <input data-slot="input" id="app-name" x-model="appName" type="text" placeholder="e.g. My Application" class="w-full min-w-0 rounded-[10px] border border-gray-300 bg-white py-2.5 ps-4 pe-4 text-sm font-normal text-gray-800 shadow-theme-xs outline-hidden transition-colors file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-gray-700 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/20 focus-visible:border-brand-300 focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:cursor-not-allowed disabled:border-gray-200 disabled:bg-gray-100/50 disabled:text-gray-400 disabled:shadow-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 focus:aria-invalid:border-red-500 focus:aria-invalid:ring-red-500/20 focus-visible:aria-invalid:border-red-500 focus-visible:aria-invalid:ring-red-500/20 data-[success=true]:border-green-500 data-[success=true]:ring-3 data-[success=true]:ring-green-500/20 focus:data-[success=true]:border-green-500 focus:data-[success=true]:ring-green-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:file:text-gray-300 dark:placeholder:text-gray-500 dark:focus:border-brand-500/40 dark:focus-visible:border-brand-500/40 dark:disabled:border-gray-800 dark:disabled:bg-gray-800/50 dark:disabled:text-gray-500 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 dark:focus:aria-invalid:border-red-500/50 dark:focus:aria-invalid:ring-red-500/40 dark:focus-visible:aria-invalid:border-red-500/50 dark:focus-visible:aria-invalid:ring-red-500/40 dark:data-[success=true]:border-green-500/50 dark:data-[success=true]:ring-green-500/40 dark:focus:data-[success=true]:border-green-500/50 dark:focus:data-[success=true]:ring-green-500/40 h-11" />
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Naming your application makes it easier to recognize your API key in the future.</p>
                </div>

                <div data-slot="dialog-footer"  class="-mx-6 -mb-6 rounded-b-2xl p-4 mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <button data-slot="button" type="button" @click="close()" class="group/button inline-flex shrink-0 items-center justify-center border bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 border-gray-300 bg-transparent text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 focus-visible:ring-3 focus-visible:ring-gray-300/50 disabled:border-gray-200 disabled:bg-white disabled:text-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700/50 dark:hover:text-white dark:disabled:border-gray-800 dark:disabled:bg-gray-900 dark:disabled:text-gray-600 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 w-full sm:w-auto">Close</button>
                    <button data-slot="button" type="submit" x-bind:disabled="busy" class="group/button inline-flex shrink-0 items-center justify-center border border-transparent bg-clip-padding text-sm font-medium whitespace-nowrap transition-all outline-none select-none focus-visible:outline-hidden active:not-aria-[haspopup]:translate-y-px disabled:pointer-events-none aria-invalid:border-red-500 aria-invalid:ring-3 aria-invalid:ring-red-500/20 dark:aria-invalid:border-red-500/50 dark:aria-invalid:ring-red-500/40 [&amp;_svg]:pointer-events-none [&amp;_svg]:shrink-0 [&amp;_svg:not([class*=&#039;size-&#039;])]:size-5 shadow-theme-xs focus-visible:ring-3 focus-visible:ring-brand-500/20 disabled:bg-brand-200 disabled:text-white dark:bg-brand-500 dark:hover:bg-brand-600 dark:disabled:bg-brand-800 dark:disabled:text-brand-400 h-10 gap-2 rounded-[10px] px-4 py-2.5 [&amp;:has(&gt;svg:first-child)]:ps-3 [&amp;:has(&gt;svg:last-child)]:pe-3 w-full bg-brand-500 text-white hover:bg-brand-600 sm:w-auto">Generate Key</button>
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

</body>


</html>
