<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class CategoryProductsList extends Component
{
    public Collection $products;

    public function render()
    {
        return view('livewire.products.category-products-list');
    }
}
