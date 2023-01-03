<?php

namespace App\Http\Livewire\Profile\Permissions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Livewire\Component;

class UpdateUserPermissionsForm extends UpdatePermissions
{

    /**
     * The component's state.
     *
     * @var array
     */
    public $permissions = [
        'update_user_permissions' => false,
    ];

    /**
     * The rules to be applied to the data.
     *
     * @var array
     */
    protected $rules = [
        'permissions.update_user_permissions' => 'boolean',
    ];

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount()
    {
        foreach (auth()->user()->getAllPermissions()->pluck('name') as $permission) {
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
        ];

        // Attempt to update user permissions
        if ($this->updatePermissions(auth()->user(), $permissionsToUpdate)) {
            
            // Let the view know that the permissions were updated
            $this->emit('saved');
        
        }

    }

    /**
     * Validate updated properties
     * 
     * @param mixed
     * @return void
     */
    public function updated($propertyName)
    {
//        $this->validateOnly($propertyName);
    }
}
