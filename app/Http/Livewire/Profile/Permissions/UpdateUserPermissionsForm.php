<?php

namespace App\Http\Livewire\Profile\Permissions;

use App\Models\User;
use Illuminate\Support\Str;

class UpdateUserPermissionsForm extends UpdatePermissions
{

    /**
     * The component's state.
     *
     * @var array
     */
    public $permissions = [
        'update_user_permissions' => false,
        'manage_users' => false,
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    protected $rules = [
        'permissions.*' => 'boolean',
        'permissions.update_user_permissions' => 'accepted_if:permissions.manage_users,true'
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
        'permissions.manage_users' => 'Manage Users',
        'permissions.update_user_permissions' => 'Update User Permissions',
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
        return view('livewire.profile.permissions.update-user-permissions-form');
    }

    /**
     * Save changes to user permissions
     * 
     * @return void
     */
    public function updateUserPermissions()
    {

        // Validate input
        $this->validate();

        // Build array of permissions to be updated
        $permissionsToUpdate = [
            'update user permissions' => $this->permissions['update_user_permissions'],
            'manage users' => $this->permissions['manage_users'],
        ];

        // Attempt to update user permissions
        if ($this->updatePermissions($this->userToModify, $permissionsToUpdate)) {
            
            // Let the view know that the permissions were updated
            $this->emit('saved');
        
        }

    }

}
