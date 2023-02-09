<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisPorPaymentToken;

use Livewire\Component;

class ShowPointOfRentalPaymentTokens extends Component
{
    public function deleteAllPorTokenRecords()
    {

        if (! auth()->user()->can('manage moneris vault tokens')) {
            
            session()->flash('failure', __('This user is not authorized to manage moneris vault tokens!'));

            return false;
        
        }
 
        $delete = MonerisPorPaymentToken::where('payment_id', '!=', '')->delete();
 
    }

    public function render()
    {
        
        // TODO Add filter for customers that are flagged to not save tokens
        return view('livewire.moneris.show-point-of-rental-payment-tokens', [
            'tokens' =>
                MonerisPorPaymentToken::getUniqueTokens()
                    ->paginate(20)
        ]);
    }
}
