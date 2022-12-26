<div>

    <input type="file" wire:model="file" class="border p-2" />

    <x-jet-button wire:click.prevent="uploadMonerisVaultProfileFile" :disabled="$isDisabled" class="ml-3">Upload</x-jet-button>

    <x-flash-messages.message-block for="file" />

</div>
