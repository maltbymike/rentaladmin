<?php

namespace App\Http\Livewire\Timeclock;

use App\Models\Timeclock\TimeclockEntryType;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ShowTimeclockUsers extends Component
{
    
    public ?int $timeclockEntryType = null;
    public Collection $timeclockUsers;
    public string $query = '';


    protected function getTimeclockUsers($whereClause = false)
    {
        return User::select(['id', 'name'])
            ->when($whereClause, function ($query, $whereClause) {
                $query->where( 'name', 'like', '%' . $this->query . '%' );
            })
            ->with(['timeclockEntries' => function ($query) {
                $query->where('timeclock_entry_type_id', $this->timeclockEntryType);
            }])
            ->orderBy('name')
            ->get();
    }

    public function mount()
    {

        $this->timeclockEntryType = TimeclockEntryType::firstWhere('name', 'Worked')->id;

        $this->timeclockUsers = $this->getTimeclockUsers();

    }

    public function render()
    {
        return view('livewire.timeclock.show-timeclock-users');
    }

    public function updatedQuery()
    {
        $this->timeclockUsers = $this->getTimeclockUsers( ['name', 'like', '%' . $this->query . '%'] );
    }
}
