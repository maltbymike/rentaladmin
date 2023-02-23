<?php

namespace App\Http\Livewire\Products\AlternateRates;

use Livewire\Component;
use App\Models\Product\Product;

class ProductRatesDialog extends Component
{    
    public bool $showProduct = false;

    public ?int $productId;

    public ?Product $product;

    protected $listeners = [
        'showProduct',
    ];

    public function showProduct(int $productId = 0)
    {
        $this->product = Product::where('id', $productId)
           ->first();

        $this->showProduct = true;
    }

    public function render()
    {
        return view('livewire.products.alternate-rates.product-rates-dialog');
    }
}
