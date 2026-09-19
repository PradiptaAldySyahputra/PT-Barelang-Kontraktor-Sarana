<x-filament-panels::page>
    <form wire:submit="simpan" class="space-y-6">
        {{ $this->form }}

        <div class="flex justify-end gap-2">
            <x-filament::button type="submit" icon="heroicon-m-check">
                Simpan Semua
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
