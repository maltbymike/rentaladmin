<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        @livewire('profile.permissions.update-user-permissions-form', ['userToModify' => $userToModify])
    
        <x-jet-section-border />

        <div class="mt-10 sm:mt-0">
            @livewire('profile.permissions.update-moneris-permissions-form', ['userToModify' => $userToModify])
        </div>

    </div>

</x-app-layout>