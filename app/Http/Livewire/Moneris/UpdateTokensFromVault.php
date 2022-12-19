<?php

namespace App\Http\Livewire\Moneris;

use App\Libraries\Moneris\mpgTransaction;
use App\Libraries\Moneris\mpgRequest;
use App\Libraries\Moneris\mpgHttpsPost;

use App\Models\Moneris\MonerisToken;
use App\Jobs\Moneris\UpdateTokensFromVaultInChunks;

use Livewire\Component;

class UpdateTokensFromVault extends Component
{

    public $tokenCount;
    public $updateStatus;

    public function mount()
    {
        $this->setTokenCount();
    }

    public function setTokenCount() 
    {
        $this->tokenCount = MonerisToken::where('exp_date', null)->count();
    }

    public function updateTokens()
    {

        MonerisToken::where('exp_date', null)
            ->orWhere('exp_date', '')
            ->chunk(100, function ($tokens) {

            UpdateTokensFromVaultInChunks::dispatch($tokens);

        });
    
    }

    public function render()
    {
        return view('livewire.moneris.update-tokens-from-vault');
    }
}
