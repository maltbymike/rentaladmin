<x-jet-dropdown align="right" width="w-60">
                
    <x-slot name="trigger">
        
        <x-jet-button wire:loading.attr="disabled" class="py-2">Delete Tokens</x-jet-button>
        
    </x-slot>

    <x-slot name="content">

        <div class="px-3 py-16 flex items-center justify-center">

            <x-jet-danger-button wire:click="queueTokensForDeletion">Start Deletion</x-jet-danger-button>

        </div>

    </x-slot>

</x-jet-dropdown>