<?php

namespace App\Http\Livewire\Profile\Permissions;

use Illuminate\Support\Arr;
use Livewire\Component;

class UpdatePermissions extends Component
{

    /**
     * Update Permissions
     * 
     * @param mixed $user
     * @param array $input
     * @return App\Models\User
     */
    public function updatePermissions($user, array $input)
    {

        if (! auth()->user()->can('update user permissions')) {
            
            session()->flash('failure', __('This user is not authorized to update user permissions!'));

            return false;
        
        }

        // Get currently set permissions and flip the array so that the values are array keys
        $permissions = $user->getAllPermissions()->pluck('name')->flip()->toArray();

        $currentPermissions = $permissions;

        // Loop through the supplied $input array and add or remove permission from $permissions array
        foreach ($input as $key => $value) {
            if ($value === true) {
                $permissions = Arr::add($permissions, $key, count($permissions));
            } else {
                $remove = Arr::pull($permissions, $key);
            }
        }

        // Update user permissions
        $user = $user->syncPermissions(array_flip($permissions)); 
        
        // Let the navigation menu know that changes were made to permissions
        $this->emit('refresh-navigation-menu');
        
        return $user;

    }

}
