<x-jet-form-section submit="updateUserPermissions">
    <x-slot name="title">
        {{ __('User Permissions') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Controls the users abilities to perform user management tasks.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Failure Messages -->
        @if (session()->has('failure'))
            <div class="col-span-full">
                <x-flash-messages.error-message>
                    {{ session('failure') }}
                </x-flash-messages.error-message>
            </div>
        @endif

        <!-- Manage Users -->
        <div class="col-span-6 align-middle">
            <div class="flex items-center gap-3">
                <x-tools.update-user-permission-toggle wire:model="permissions.manage_users"> {{ __('Manage Users') }}</x-tools.update-user-permission-toggle>
                <x-tools.more-info-icon-with-text>Select this option if the user should be allowed to Add, Delete and Edit other users.</x-tools.more-info-icon-with-text>
            </div>
            <x-jet-input-error for="permissions.manage_users" class="mt-2" />
        </div>
        
        <!-- Update User Permissions -->
        <div class="col-span-6 align-middle">
            <div class="flex items-center gap-3">
                <x-tools.update-user-permission-toggle wire:model="permissions.update_user_permissions"> {{ __('Update User Permissions') }}</x-tools.update-user-permission-toggle>
                <x-tools.more-info-icon-with-text>Select this option if the user should be allowed to update users permissions.</x-tools.more-info-icon-with-text>
            </div>
            <x-jet-input-error for="permissions.update_user_permissions" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="updateUserPermissions">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>