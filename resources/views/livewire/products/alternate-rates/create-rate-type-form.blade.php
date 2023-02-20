<div x-data="{open: @entangle('showForm')}" class="col-span-full">

    <x-jet-button class="mb-4" x-on:click="open = ! open">Add New Rate Type</x-jet-button>
        
    <form x-show="open" wire:submit.prevent="newRateType" class="grid grid-cols-7 gap-3 py-3">

        <input wire:model="state.name" type="text" class="col-span-2 rounded-lg" placeholder="New Rate Type">

        <input wire:model="state.urlStart" type="text" class="col-span-3 rounded-lg" placeholder="Product URL Start">

        <input wire:model="state.urlEnd" type="text" class="col-span-2 rounded-lg" placeholder="Product Url End">

        @error('state.name')
            <x-flash-messages.error-message class="col-span-2 col-start-1">{{ $message }}</x-flash-message.error-message>
        @enderror

        @error('state.urlStart')
            <x-flash-messages.error-message class="col-span-3 col-start-3">{{ $message }}</x-flash-message.error-message>
        @enderror

        @error('state.urlEnd')
            <x-flash-messages.error-message class="col-span-3 col-start-6">{{ $message }}</x-flash-message.error-message>
        @enderror

        <div class="col-span-full grid grid-cols-7 gap-3">
            <x-jet-button type="submit" class="col-span-2 col-start-6 text-center" style="flex-flow: column">Save</x-jet-button>
        </div>

    </form>

    @if (session()->has('success'))
        <x-flash-messages.success-message>{{ session('success') }}</x-flash-messages.success-message>
    @endif

</div>