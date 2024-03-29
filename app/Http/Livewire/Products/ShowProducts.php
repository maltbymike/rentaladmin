<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use App\Models\Product\Product;
use App\Models\Product\ProductStatus;
use Illuminate\Support\Facades\Cache;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductVisibility;
use Illuminate\Database\Eloquent\Collection;

class ShowProducts extends Component
{

    public Collection $categories;

    public ?int $showCategory;

    public \Illuminate\Support\Collection $state;

    protected $queryString = [];

    public function mount(int $category = null)
    {
        $this->showCategory = $category;
        $publishedStatus = ProductStatus::where('slug', 'publish')->first();
        $visibleStatus = ProductVisibility::where('slug', 'visible')->first();

        $this->state = collect([
            'status' => $publishedStatus->id,
            'visibility' => $visibleStatus->id,
        ]);
    }

    public function render()
    {
        $this->categories = ProductCategory::where('wp_parent_id', $this->showCategory)
                ->with('products')
                ->with('subcategoriesWithProductsAndDescendants')
                ->get();

        return view('livewire.products.show-products');
    }
}
