<?php

namespace App\Http\Livewire\Profile\Permissions;

use App\Models\User;
use Illuminate\Support\Str;

class UpdateMonerisPermissionsForm extends UpdatePermissions
{
    /**
     * The component's state.
     *
     * @var array
     */
    public $permissions = [
        'manage_moneris_vault_tokens' => false,
        'view_moneris_vault_tokens' => false,
    ];

    /**
     * The user that should be modified
     * 
     * @var App\Models\User
     */
    public $userToModify;

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    protected $rules = [
        'permissions.*' => 'boolean',
        'permissions.view_moneris_vault_tokens' => 'accepted_if:permissions.manage_moneris_vault_tokens,true',
    ];

    /**
     * The messages that should be returned on validation failure
     * 
     * @var array
     */
    protected $messages = [
        'accepted_if' => 'The [:attribute] option must be selected when the [:other] option is :value.',
    ];

    /**
     * The attribute names that should be used on validation failure
     */
    protected $validationAttributes = [
        'permissions.manage_moneris_vault_tokens' => 'Manage Moneris Vault Tokens',
        'permissions.view_moneris_vault_tokens' => 'View Moneris Vault Tokens',
    ];
        

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(User $userToModify)
    {
        $this->userToModify = $userToModify;

        foreach ($userToModify->getAllPermissions()->pluck('name') as $permission) {
            $this->permissions[Str::slug($permission, '_')] = true;
        }
    }

    /**
     * Show the update user permissions screen.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.profile.permissions.update-moneris-permissions-form');
    }

        /**
     * Save changes to user permissions
     * 
     * @return void
     */
    public function updateMonerisPermissions()
    {

        // Validate input
        $this->validate();

        // Build array of permissions to be updated
        $permissionsToUpdate = [
            'manage moneris vault tokens' => $this->permissions['manage_moneris_vault_tokens'],
            'view moneris vault tokens' => $this->permissions['view_moneris_vault_tokens'],
        ];

        // Attempt to update user permissions
        if ($this->updatePermissions($this->userToModify, $permissionsToUpdate)) {
            
            // Let the view know that the permissions were updated
            $this->emit('saved');
        
        }

    }
}
