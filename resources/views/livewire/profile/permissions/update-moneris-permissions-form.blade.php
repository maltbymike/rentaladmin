<x-jet-form-section submit="updateMonerisPermissions">
    <x-slot name="title">
        {{ __('Moneris Vault') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Controls the users permissions to access the Moneris Vault.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Failure Messages -->
        <div class="col-span-full">
            @if (session()->has('failure'))
                <x-flash-messages.error-message>
                    {{ session('failure') }}
                </x-flash-messages.error-message>
            @endif
        </div>

        <!-- Manage Tokens -->
        <div class="col-span-6 align-middle">
            <div class="flex items-center gap-3">
                <x-tools.update-user-permission-toggle wire:model="permissions.manage_moneris_vault_tokens"> {{ __('Manage Moneris Vault Tokens') }}</x-tools.update-user-permission-toggle>
                <x-tools.more-info-icon-with-text>Select this option if the user should be allowed to update tokens stored in the Moneris Vault.</x-tools.more-info-icon-with-text>
            </div>
            <x-jet-input-error for="permissions.manage_moneris_vault_tokens" class="mt-2" />
        </div>

        <!-- Manage Tokens -->
        <div class="col-span-6 align-middle">
            <div class="flex items-center gap-3">
                <x-tools.update-user-permission-toggle wire:model="permissions.view_moneris_vault_tokens"> {{ __('View Moneris Vault Tokens') }}</x-tools.update-user-permission-toggle>
                <x-tools.more-info-icon-with-text>Select this option if the user should be allowed to view tokens stored in the Moneris Vault.</x-tools.more-info-icon-with-text>
            </div>
            <x-jet-input-error for="permissions.view_moneris_vault_tokens" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="updateMonerisPermissions">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>

</x-jet-form-section>