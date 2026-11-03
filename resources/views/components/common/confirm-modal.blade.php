{{--
    Modal Konfirmasi Desain TailAdmin
    Menggantikan pop-up window.confirm() bawaan browser yang kaku.
--}}
<div x-data="{
    open: false,
    title: 'Konfirmasi Tindakan',
    message: 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    confirmText: 'Ya, Lanjutkan',
    cancelText: 'Batal',
    isDanger: true,
    formToSubmit: null,
    actionCallback: null,

    showConfirm(options) {
        this.title = options.title || 'Konfirmasi';
        this.message = options.message || 'Apakah Anda yakin?';
        this.confirmText = options.confirmText || 'Konfirmasi';
        this.cancelText = options.cancelText || 'Batal';
        this.isDanger = options.isDanger !== undefined ? options.isDanger : true;
        this.formToSubmit = options.form || null;
        this.actionCallback = options.onConfirm || null;
        this.open = true;
    },

    confirmAction() {
        this.open = false;
        if (this.formToSubmit) {
            this.formToSubmit.submit();
        } else if (typeof this.actionCallback === 'function') {
            this.actionCallback();
        }
    }
}"
@bks-confirm.window="showConfirm($event.detail)"
class="relative z-999999"
>
    {{-- Backdrop & Container --}}
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4" style="display: none;">
        <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.outside="open = false"
            class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-gray-900 border border-gray-100 dark:border-gray-800">

            {{-- Icon & Header --}}
            <div class="flex items-start gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                    :class="isDanger ? 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400' : 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400'">
                    <template x-if="isDanger">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </template>
                    <template x-if="!isDanger">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </template>
                </div>

                <div class="flex-1">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white" x-text="title"></h3>
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 leading-relaxed" x-text="message"></p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-6 flex items-center justify-end gap-2.5">
                <button type="button" @click="open = false"
                    class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition"
                    x-text="cancelText">
                </button>
                <button type="button" @click="confirmAction()"
                    class="rounded-xl px-4 py-2 text-xs font-semibold text-white shadow-theme-xs transition"
                    :class="isDanger ? 'bg-error-600 hover:bg-error-700' : 'bg-brand-600 hover:bg-brand-700'"
                    x-text="confirmText">
                </button>
            </div>
        </div>
    </div>
</div>
