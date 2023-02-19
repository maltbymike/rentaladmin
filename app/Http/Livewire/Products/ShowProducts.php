<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\Product\ProductStatus;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductVisibility;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class ShowProducts extends Component
{

    public Collection $categories;

    public \Illuminate\Support\Collection $state;

    public function mount()
    {
        $publishedStatus = ProductStatus::where('slug', 'publish')->first();
        $visibleStatus = ProductVisibility::where('slug', 'visible')->first();

        $this->state = collect([
            'status' => $publishedStatus->id,
            'visibility' => $visibleStatus->id,
        ]);

        $expire = now()->addMinutes(10);

        $this->categories = Cache::remember('categories', $expire, function() {
            return ProductCategory::whereNull('wp_parent_id')
                ->with('products')
                ->with('subcategoriesWithProductsAndDescendants')
                ->get();
        });
    }

    public function render()
    {
        return view('livewire.products.show-products');
    }
}
