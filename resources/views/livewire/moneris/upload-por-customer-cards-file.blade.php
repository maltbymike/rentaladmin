<div>

    @empty($customer_cards_file)

        <div class="flex justify-between items-center py-3 gap-3">

            <span><strong>{{ __('CustomerCard Table:') }}</strong></span>

            <input type="file" wire:model="file" class="border p-2" />

            <x-jet-button wire:click.prevent="uploadPorCustomerCardsFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

        </div>

        <x-flash-messages.message-block for="file" />

    @else

        <div class="flex justify-between items-center py-3 gap-3">

            <span><strong>CustomerCard Table:</strong></span>
            
            <span>{{ $customer_cards_file->file_name }}</span>

            <x-jet-button wire:click.prevent="queuePorCustomerCardsForProcessing({{ $customer_cards_file->id }})" wire:loading.attr="disabled" wire:loading.target="queuePorCustomerCardsForProcessing" class="ml-3">Process File</x-jet-button>

        </div>
        
        <x-flash-messages.message-block />
        
    @endempty

</div>