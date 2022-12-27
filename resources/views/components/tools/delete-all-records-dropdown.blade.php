<x-jet-dropdown align="right" width="w-60">
                
    <x-slot name="trigger">
        
        <x-jet-secondary-button class="py-2">{{ __('Clear Records') }}</x-jet-secondary-button>
        
    </x-slot>

    <x-slot name="content">

        <div class="px-3 py-16 flex items-center justify-center">

            <x-jet-danger-button {{ $attributes }}>{{ __('Delete All Records') }}</x-jet-danger-button>

        </div>

    </x-slot>

</x-jet-dropdown>