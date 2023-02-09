<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisToken;
use App\Models\Moneris\MonerisPorPaymentToken;

use Livewire\Component;
use Livewire\WithPagination;

class ShowVaultProfiles extends Component
{
    use WithPagination;

    // filter flags
    public int $showExpired = 1; // 1 = Show All, 2 = Show Only Expired, 3 = Show Only Unexpired, 4 = Show Only Records with No Expiry Date Set
    public int $matchPorTokens = 1; // 1 = Show All, 2 = Show Only Tokens in POR, 3 = Only Tokens not in POR
    public bool $showAVS = false;
    public bool $filterForDeletion = false;

    protected $queryString = [
        'showExpired' => ['except' => 1, 'as' => 'exp'],
        'matchPorTokens' => ['except' => 1, 'as' => 'por'],
        'showAVS' => ['except' => false, 'as' => 'avs'],
        'filterForDeletion' => ['except' => false, 'as' => 'ffd'],
    ];

    public function deleteAllVaultRecords() 
    {
        // Ensure user is authorized
        if (! auth()->user()->can('manage moneris vault tokens')) {
            
            session()->flash('failure', __('This user is not authorized to manage moneris vault tokens!'));

            return false;
        
        }

        $delete = MonerisToken::where('data_key', '!=', '')->delete();
    }

    public function filterForDeletion($flag = true)
    {
        // Ensure person is authorized
        if (! auth()->user()->can('manage moneris vault tokens')) {
            
            session()->flash('failure', __('This user is not authorized to manage moneris vault tokens!'));

            return false;
        
        }

        // Reset properties that affect filtering
        $this->reset(['showExpired', 'matchPorTokens']);
        
        // Set flag
        $this->filterForDeletion = $flag;
    }

    public function render()
    {

        // Get Tokens Stored in moneris_por_payment_token table for comparison with moneris_vault_profiles
        $porTokens = MonerisPorPaymentToken::getUniqueTokensWithoutNull()
            ->pluck('por_token')
            ->toArray();

        return view('livewire.moneris.show-vault-profiles', [
            
            'profiles' =>
                MonerisToken::when($this->filterForDeletion,
                    function ($deleteQuery, $filterForDeletion) use ($porTokens) {
                        $deleteQuery->whereNotIn('data_key', $porTokens)
                            ->orWhere('exp_date', '<', now()->format('ym'));
                    },
                    function ($deleteQuery) use ($porTokens) {
                        $deleteQuery->when($this->showExpired === 2, function ($query, $showExpired) {
                            $query->where('exp_date', '<', now()->format('ym'));
                        })
                        ->when($this->showExpired === 3, function ($query, $showExpired) {
                            $query->where('exp_date', '>=', now()->format('ym'));
                        })
                        ->when($this->showExpired === 4, function ($query, $showExpired) {
                            $query->where('exp_date', null)
                                ->orWhere('exp_date', '');
                        })
                        ->when($this->matchPorTokens === 2, function ($query, $matchPorTokens) use ($porTokens) {
                            $query->whereIn('data_key', $porTokens);
                        })
                        ->when($this->matchPorTokens === 3, function ($query, $matchPorTokens) use ($porTokens) {
                            $query->whereNotIn('data_key', $porTokens);
                        });
                    }
                )
                ->paginate(20)
            
        ]);
    }

}
