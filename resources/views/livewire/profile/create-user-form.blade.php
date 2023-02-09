<x-jet-form-section submit="createUser">

    <x-slot name="title">
        {{ __('Add a New User') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Enter the new users details') }}
    </x-slot>

    <x-slot name="form">

        <div class="col-span-6 sm:col-span-4 grid grid-cols-1 gap-3">

            <x-flash-messages.message-block />

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model="input.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model="input.email" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" wire:model="input.password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" wire:model="input.password_confirmation" required autocomplete="new-password" />
            </div>

        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="createUser">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>