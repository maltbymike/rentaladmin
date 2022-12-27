<div>

    @empty($payment_file)

        <div class="flex justify-between items-center py-3 gap-3">

            <span><strong>{{ __('PaymentFile Table:') }}</strong></span>

            <input type="file" wire:model="file" class="border p-2" />

            <x-jet-button wire:click.prevent="uploadPorPaymentsFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

        </div>
        
        <x-flash-messages.message-block for="file" />

    @else

        <div class="flex justify-between items-center py-3 gap-3">

            <span><strong>{{ __('PaymentFile Table:') }}</strong></span>
            
            <span>{{ $payment_file->file_name }}</span>

            <x-jet-button wire:click.prevent="queuePorPaymentsForProcessing({{ $payment_file->id }})" wire:loading.attr="disabled" wire:loading.target="queuePorPaymentsForProcessing" class="ml-3">Process File</x-jet-button>

        </div>

        <x-flash-messages.message-block />
    
    @endempty

</div>
