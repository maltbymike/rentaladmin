<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisToken;

use Livewire\Component;
use Livewire\WithPagination;

class ShowVaultProfiles extends Component
{
    use WithPagination;

    // filter flags
    public int $showExpired = 1; // 1 = Show All, 2 = Show Only Expired, 3 = Show Only Unexpired
    public bool $showAVS = false;

    public function render()
    {

        return view('livewire.moneris.show-vault-profiles', [
            
            'profiles' => 
                MonerisToken::when($this->showExpired === 2, function ($query, $showExpired) {
                    $query->orWhere('exp_date', '<', now()->format('ym'));
                })
                ->when($this->showExpired === 3, function ($query, $showExpired) {
                    $query->orWhere('exp_date', '>=', now()->format('ym'));
                })
                ->paginate(50)
            
        ]);
    }

}
