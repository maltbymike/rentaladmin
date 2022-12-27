<div>

    @empty($payment_file)

        <input type="file" wire:model="file" class="border p-2" />

        <x-jet-button wire:click.prevent="uploadPorPaymentsFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

        <x-flash-messages.message-block for="file" />

    @else

        <span class="p-2"><strong>PaymentFile Table:</strong> {{ $payment_file->file_name }}</span>

        <x-jet-button wire:click.prevent="queuePorPaymentsForProcessing({{ $payment_file->id }})" wire:loading.attr="disabled" wire:loading.target="queuePorPaymentsForProcessing" class="ml-3">Process File</x-jet-button>

        <x-flash-messages.message-block />
    
    @endempty

</div>
