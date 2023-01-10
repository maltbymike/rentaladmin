<?php

namespace App\Http\Livewire\Profile;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateUserForm extends Component
{
    use PasswordValidationRules;

    // Store form values
    public array $input = [];

    // Create the new user
    public function createUser()
    {
        // Ensure user is authorized
        if (! auth()->user()->can('manage users')) {
            
            session()->flash('failure', __('This user is not authorized to create users!'));

            return false;
        
        }

        // Validate input
        Validator::make($this->input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        // Create user
        User::create([
            'name' => $this->input['name'],
            'email' => $this->input['email'],
            'password' => Hash::make($this->input['password']),
        ]);

        // Let the view know that the permissions were updated
        $this->emit('saved');

    }

    // Render the component
    public function render()
    {
        return view('livewire.profile.create-user-form');
    }
}
