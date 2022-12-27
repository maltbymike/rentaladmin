<div class="flex gap-3 justify-between w-3/4">

    <div>

        @empty($vault_file)

            <input type="file" wire:model="file" class="border p-2" />

            <x-jet-button wire:click.prevent="uploadMonerisVaultProfileFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

            <x-flash-messages.message-block for="file" />

        @else

            <!-- TODO - Show Progress Bar -->

            <span class="p-2">{{ $vault_file->file_name }}</span>

            <x-jet-button wire:click.prevent="queueVaultProfilesForProcessing({{ $vault_file->id }})" wire:loading.attr="disabled" wire:loading.target="queuePorPaymentsForProcessing" class="ml-3">Process File</x-jet-button>

            <x-flash-messages.message-block />

        @endif

    </div>

    <livewire:moneris.update-tokens-from-vault />
    
</div>
