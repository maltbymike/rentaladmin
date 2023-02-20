<?php

namespace App\Http\Livewire\Products\AlternateRates;

use Livewire\Component;
use App\Models\Product\Product;

class ProductRatesDialog extends Component
{    
    public bool $showProduct = true;

    public ?Product $product;

    public function render()
    {
        $this->product = Product::find(285);

        return view('livewire.products.alternate-rates.product-rates-dialog');
    }
}
