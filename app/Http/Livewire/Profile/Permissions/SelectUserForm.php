<?php

namespace App\Http\Livewire\Profile\Permissions;

use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class SelectUserForm extends Component
{

    public string $query = '';
    public Collection $users;
    public $userToModify;

    /**
     * Mount the component
     *
     * @return void
     */
    public function mount(string $userToModify)
    {
        $this->users = User::select(['id', 'name'])->orderBy('name')->get();
        $this->userToModify = $this->users->find($userToModify);
    }

    /**
     * Update the users property based on the search query
     *
     * @return void
     */
    public function updatedQuery()
    {
        $this->users = User::where( 'name', 'like', '%' . $this->query . '%' )->get();
    }

    /**
     * Show the view
     *
     * @return Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.profile.permissions.select-user-form');
    }
}
