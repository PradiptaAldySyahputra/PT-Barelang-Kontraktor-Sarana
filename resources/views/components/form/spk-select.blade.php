@props([
    'name' => 'spk_id',
    'selected' => null,
    'options' => [], // [id => label]
    'placeholder' => '-- Pilih atau cari SPK --',
    'wireModel' => null,
])

<div x-data="{
    open: false,
    cari: '',
    selectedId: @js($selected ?? ''),
    selectedText: '',
    list: @js(collect($options)->map(fn($label, $id) => ['id' => (string)$id, 'text' => $label])->values()),
    init() {
        this.updateSelectedText();
        this.$watch('selectedId', () => {
            this.updateSelectedText();
            if (@js($wireModel)) {
                $wire.set(@js($wireModel), this.selectedId || null);
            }
        });
    },
    updateSelectedText() {
        const found = this.list.find(item => String(item.id) === String(this.selectedId));
        this.selectedText = found ? found.text : '';
    },
    filteredList() {
        if (!this.cari.trim()) return this.list.slice(0, 100);
        const q = this.cari.toLowerCase();
        return this.list.filter(item => item.text.toLowerCase().includes(q)).slice(0, 50);
    },
    pilih(id) {
        this.selectedId = id;
        this.open = false;
        this.cari = '';
    },
    bersihkan() {
        this.selectedId = '';
        this.open = false;
        this.cari = '';
    }
}" class="relative w-full text-left" @click.outside="open = false">
    {{-- Input Asli untuk submit form standar non-livewire --}}
    @if (!$wireModel)
        <input type="hidden" name="{{ $name }}" :value="selectedId">
    @endif

    {{-- Kotak Pemicu Dropdown --}}
    <button type="button" @click="open = !open"
        class="flex h-9 w-full items-center justify-between rounded-xl border border-gray-300 bg-white px-3 text-xs text-gray-800 shadow-theme-xs hover:border-gray-400 focus:border-brand-400 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:border-gray-600 transition">
        <span class="truncate pr-2 text-left"
            :class="selectedText ? 'text-gray-900 dark:text-white font-medium' : 'text-gray-400'"
            x-text="selectedText || @js($placeholder)">
        </span>

        <div class="flex items-center gap-1 shrink-0 text-gray-400">
            <template x-if="selectedId">
                <span @click.stop="bersihkan()" class="p-0.5 hover:text-error-500 rounded-md transition" title="Kosongkan pilihan">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </span>
            </template>
            <svg class="w-4 h-4 transition-transform duration-150" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </button>

    {{-- Popover Pencarian & Daftar Opsi --}}
    <div x-show="open" x-transition.opacity.duration.100ms
        class="absolute left-0 top-full z-50 mt-1 max-h-64 w-full rounded-2xl border border-gray-200 bg-white p-2 shadow-2xl dark:border-gray-800 dark:bg-gray-900 flex flex-col"
        style="display: none;">
        
        <div class="relative mb-2 shrink-0">
            <input type="search" x-model="cari" x-ref="cariInput"
                placeholder="Ketik nomor SPK atau nama pekerjaan..."
                @keydown.escape="open = false"
                class="h-8 w-full rounded-lg border border-gray-200 bg-gray-50 px-2.5 text-xs text-gray-900 placeholder:text-gray-400 focus:border-brand-400 focus:bg-white focus:outline-none dark:border-gray-800 dark:bg-gray-950 dark:text-white">
        </div>

        <ul class="flex-1 overflow-y-auto space-y-1 custom-scrollbar max-h-48 text-xs">
            <li @click="bersihkan()"
                class="cursor-pointer rounded-lg px-2.5 py-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition italic">
                -- Tanpa Terkait SPK (Umum) --
            </li>

            <template x-for="item in filteredList()" :key="item.id">
                <li @click="pilih(item.id)"
                    :class="String(item.id) === String(selectedId) ? 'bg-brand-50 text-brand-700 font-semibold dark:bg-brand-500/15 dark:text-brand-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800'"
                    class="cursor-pointer rounded-lg px-2.5 py-1.5 transition flex items-center justify-between">
                    <span class="truncate" x-text="item.text"></span>
                    <template x-if="String(item.id) === String(selectedId)">
                        <svg class="w-3.5 h-3.5 shrink-0 text-brand-600 dark:text-brand-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </template>
                </li>
            </template>

            <li x-show="filteredList().length === 0" class="py-3 text-center text-xs text-gray-400 italic">
                Tidak ada SPK yang cocok dengan kata kunci
            </li>
        </ul>
    </div>
</div>
