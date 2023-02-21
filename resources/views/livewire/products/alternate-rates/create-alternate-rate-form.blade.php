<div x-data="{open: @entangle('showForm')}" class="col-span-full">

    @if($product)

        <x-jet-button class="mb-4" x-on:click="open = ! open">Add New Rate</x-jet-button>
            
        <form x-show="open" wire:submit.prevent="newRate" class="grid grid-cols-7 gap-3 py-3">

            <div class="col-span-full flex flex-col gap-3">
                <select wire:model="state.type">
                    <option value="">-- Rate Type --</option>
                    @foreach ($rateTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>                
                    @endforeach
                </select>
                @error('state.type')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>

            <div class="col-span-4 flex flex-col gap-3">
                <input wire:model="state.name" type="text" class="rounded-lg" />
                @error('state.name')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>

            <div class="col-span-3 flex flex-col gap-3">
                <input wire:model="state.identifier" type="text" class="rounded-lg" placeholder="URL Identifier" />
                @error('state.identifier')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>

            <div class="col-span-2 px-3 py-2">Alternate Rates:</div>

            <div class="flex flex-col gap-3">
                <input wire:model="state.rates.two_hour" type="text" class="rounded-lg text-end" placeholder="2 Hour" />
                @error('state.rates.two_hour')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>

            <div class="flex flex-col gap-3">
                <input wire:model="state.rates.four_hour" type="text" class="rounded-lg text-end" placeholder="4 Hour" />
                @error('state.rates.four_hour')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>
    
            <div class="flex flex-col gap-3">    
                <input wire:model="state.rates.daily" type="text" class="rounded-lg text-end" placeholder="Daily" />
                @error('state.rates.daily')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>
    
            <div class="flex flex-col gap-3">    
                <input wire:model="state.rates.weekly" type="text" class="rounded-lg text-end" placeholder="Weekly" />
                @error('state.rates.weekly')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>
    
            <div class="flex flex-col gap-3">    
                <input wire:model="state.rates.four_week" type="text" class="rounded-lg text-end" placeholder="4 Week" />
                @error('state.rates.four_week')
                    <x-flash-messages.error-message>{{ $message }}</x-flash-message.error-message>
                @enderror
            </div>
    
            <div class="col-span-full grid grid-cols-7 gap-3">
                <x-jet-button type="submit" class="col-span-2 col-start-6 text-center" style="flex-flow: column">Save</x-jet-button>
            </div>

        </form>

        @if (session()->has('success'))
            <x-flash-messages.success-message>{{ session('success') }}</x-flash-messages.success-message>
        @endif

    @endif

</div>