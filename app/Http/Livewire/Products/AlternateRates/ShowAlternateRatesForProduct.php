<?php

namespace App\Http\Livewire\Products\AlternateRates;

use Livewire\Component;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product\ProductAlternateRateType;

class ShowAlternateRatesForProduct extends Component
{
    public Collection $rateTypes;

    public $product;

    protected $listeners = [
        'showProduct',
    ];

    public function showProduct(int $productId = 0)
    {
        $this->product = Product::where('id', $productId)
           ->with('alternateProducts')->first();
    }


    public function render()
    {
        $this->rateTypes = ProductAlternateRateType::all();

        return view('livewire.products.alternate-rates.show-alternate-rates-for-product');
    }
}
