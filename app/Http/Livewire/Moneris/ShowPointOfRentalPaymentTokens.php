<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisPorPaymentToken;

use Livewire\Component;

class ShowPointOfRentalPaymentTokens extends Component
{
    public function deleteAllPorTokenRecords()
    {
        // TODO - Ensure person is authorized
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
