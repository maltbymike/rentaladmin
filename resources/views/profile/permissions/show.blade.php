<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!-- @ if ($user->can('update user permissions')) -->
                @livewire('profile.permissions.update-user-permissions-form')

                <x-jet-section-border />
            <!-- @ endif -->

        </div>
    </div>
</x-app-layout>