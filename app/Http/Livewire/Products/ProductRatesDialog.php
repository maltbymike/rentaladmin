<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\Product\Product;

class ProductRatesDialog extends Component
{    
    public bool $showProduct = true;

    public ?Product $product;

    public function render()
    {
        $this->product = Product::find(285);

        return view('livewire.products.product-rates-dialog');
    }
}
