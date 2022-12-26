<?php

namespace App\Http\Livewire\Moneris;

use App\Models\Moneris\MonerisPorPaymentToken;

use Livewire\Component;

class ShowPointOfRentalPaymentTokens extends Component
{
    public function render()
    {
        // TODO Add filter for customers that are flagged to not save tokens
        return view('livewire.moneris.show-point-of-rental-payment-tokens', [
            'tokens' =>
                MonerisPorPaymentToken::selectRaw('por_token, max(date) as date, count(*) as use_count, min(customer_id) as min_customer, max(customer_id) as max_customer')
                    ->groupBy('por_token')
                    ->paginate(20)
        ]);
    }
}
