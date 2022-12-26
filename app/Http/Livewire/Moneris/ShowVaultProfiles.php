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
    public int $showExpired = 1; // 1 = Show All, 2 = Show Only Expired, 3 = Show Only Unexpired
    public int $matchPorTokens = 1; // 1 = Show All, 2 = Show Only Tokens in POR, 3 = Only Tokens not in POR
    public bool $showAVS = false;

    public function deleteAllVaultRecords() 
    {
        
        // TODO - Ensure person is authorized

        $delete = MonerisToken::where('data_key', '!=', '')->delete();

    }

    public function render()
    {

        $porTokens = MonerisPorPaymentToken::getUniqueTokensWithoutNull()
            ->pluck('por_token')
            ->toArray();

        return view('livewire.moneris.show-vault-profiles', [
            
            'profiles' => 
                MonerisToken::when($this->showExpired === 2, function ($query, $showExpired) {
                    $query->orWhere('exp_date', '<', now()->format('ym'));
                })
                ->when($this->showExpired === 3, function ($query, $showExpired) {
                    $query->orWhere('exp_date', '>=', now()->format('ym'));
                })
                ->when($this->matchPorTokens === 2, function ($query, $matchPorTokens) use ($porTokens) {
                    $query->orWhereIn('data_key', $porTokens);
                })
                ->when($this->matchPorTokens === 3, function ($query, $matchPorTokens) use ($porTokens) {
                    $query->orWhereNotIn('data_key', $porTokens);
                })
                ->paginate(20)
            
        ]);
    }

}
