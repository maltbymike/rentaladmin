<?php

namespace App\Http\Livewire\Products;

use App\Models\Product\ProductVisibility;
use Livewire\Component;
use App\Models\Product\ProductStatus;
use App\Models\Product\ProductCategory;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product\ProductAlternateRateType;

class InputAlternateRatesByCategory extends Component
{

    public array $breadcrumb = [];

    public ?ProductCategory $category;

    public ?Collection $rateTypes;

    public $currentCategory = null;

    public ?int $publishStatus;
    public ?int $visibleStatus;

    protected $queryString = [
        'currentCategory' => ['except' => null, 'as' => 'cat'],
    ];

    public function buildBreadcrumb(?ProductCategory $category)
    {
        $urlBase = route('products.compare.input-by-category') . '?cat=';

        if ($category === null) {

            $breadcrumb[] = [
                'name' => 'Root',
                'url' => $urlBase,
            ];

            return $breadcrumb;

        }

        if ($category->wp_parent_id === null) {

            // If this is a root category add it to the breadcrumb
            $breadcrumb[] = [
                'name' => $category->name,
                'url' => $urlBase . $category->wp_id
            ];

        } else {

            // Otherwise go down a level and add to the combined breadcrumb
            $breadcrumb = $this->buildBreadcrumb($category->ancestors);
            $breadcrumb[] = [
                'name' => $category->name,
                'url' => $urlBase . $category->wp_id
            ];

        }

        return $breadcrumb;

    }

    public function mount()
    {
        if (! $this->currentCategory) {
            $this->currentCategory = env('PRODUCTS_DEFAULT_CATEGORY');
        }

        $this->publishStatus = ProductStatus::where('name', 'Publish')->pluck('id')->first();
        $this->visibleStatus = ProductVisibility::where('name', 'Visible')->pluck('id')->first();

        $this->rateTypes = ProductAlternateRateType::all();
    }


    public function render()
    {

        $this->category = ProductCategory::where('wp_id', $this->currentCategory)
            ->with('subcategoriesWithDescendants')
            ->with('productsWithAlternateRates')
            ->first();
 
        $breadcrumb = $this->category->load('ancestors');

        $this->breadcrumb = $this->buildBreadcrumb($breadcrumb);

        return view('livewire.products.input-alternate-rates-by-category');
    }
}
