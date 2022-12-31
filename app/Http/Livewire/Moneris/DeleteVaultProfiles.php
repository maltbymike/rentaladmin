<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisToken;
use App\Models\Moneris\MonerisPorPaymentToken;

use App\Jobs\Moneris\DeleteVaultProfilesInChunksJob;

use Livewire\Component;

class DeleteVaultProfiles extends Component
{
    
    public function queueTokensForDeletion()
    {
        // Get Tokens Stored in moneris_por_payment_token table for comparison with moneris_vault_profiles
        $porTokens = MonerisPorPaymentToken::getUniqueTokensWithoutNull()
            ->pluck('por_token')
            ->toArray();

        // Get tokens that should be deleted
        $tokensToDelete = MonerisToken::select('data_key')
            ->whereNotIn('data_key', $porTokens)
            ->orWhere('exp_date', '<', now()->format('ym'))
            ->pluck('data_key')
            ->toArray();
        
        foreach (array_chunk($tokensToDelete, 100) as $chunk) {

            DeleteVaultProfilesInChunksJob::dispatch($chunk);
        
        }       
        
    }

    public function render()
    {
        return view('livewire.moneris.delete-vault-profiles');
    }
}
