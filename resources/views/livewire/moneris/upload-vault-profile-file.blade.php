<div class="flex gap-3 justify-between w-3/4">

    <div>

        @empty($vault_file)

            <div class="flex justify-between items-center py-3 gap-3">

                <input type="file" wire:model="file" class="border p-2" />

                <x-jet-button wire:click.prevent="uploadMonerisVaultProfileFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

            </div>
            
            <x-flash-messages.message-block for="file" />

        @else

            <!-- TODO - Show Progress Bar -->

            <div class="flex justify-between items-center py-3 gap-3">
                    
                <span class="p-2">{{ $vault_file->file_name }}</span>

                <x-jet-button wire:click.prevent="queueVaultProfilesForProcessing({{ $vault_file->id }})" wire:loading.attr="disabled" wire:loading.target="queuePorPaymentsForProcessing" class="ml-3">Process File</x-jet-button>

                <x-jet-danger-button wire:click.prevent="deleteFile({{ $vault_file->id }})" wire:loading.attr="disabled" wire:loading.target="deleteFile" class="ml-3">Delete File</x-jet-danger-button>

            </div>

            <x-flash-messages.message-block />

        @endif

    </div>

    <livewire:moneris.update-tokens-from-vault />
    
</div>
