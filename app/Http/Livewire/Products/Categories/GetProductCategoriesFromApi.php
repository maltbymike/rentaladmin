<?php

namespace App\Http\Livewire\Products\Categories;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\Product\ProductCategory;
use App\Http\Integrations\IRWordpress\IRWordpressConnector;
use App\Http\Integrations\IRWordpress\Requests\GetProductCategoriesRequest;

class GetProductCategoriesFromApi extends Component
{
    public ?Collection $categories;

    public function getProductCategories()
    {

        $irWordpress = new IRWordpressConnector();
        $request = new GetProductCategoriesRequest();

        $i = 1;
        $this->categories = new Collection;

        do {

            $request->query()->set(['page' => $i]);

            $response = $irWordpress->send($request);

            $json = new Collection(json_decode($response->body(), true));

            $this->categories = $this->categories->merge($json);

            $totalPages = $response->header('x-wp-totalpages');

            $i++;

        } while ($i <= $totalPages);

        $this->upsertCategories();

    }

    public function upsertCategories()
    {

        // Create collection of id and name
        $categoriesWithoutParent = $this->categories->map(function ($value) {
            return [
                'wp_id' => $value['id'], 
                'name' => $value['name'], 
            ];
        });

        // Create collection of wp_id and wp_parent_id
        $categoriesWithParent = $this->categories->map(function ($value) {
            return [
                'wp_id' => $value['id'],  
                'name' => $value['name'],
                'wp_parent_id' => $value['parent'] !== 0 ? $value['parent'] : null,
            ];
        });

        // Upsert wp_id and name without parent to ensure that the foreign key is intact
        ProductCategory::upsert(
            $categoriesWithoutParent->toArray(), 
            ['wp_id'], 
            ['name'],
        );

        // Upsert wp_parent_id now that all categories are in the database
        ProductCategory::upsert(
            $categoriesWithParent->toArray(),
            ['wp_id'], 
            ['name', 'wp_parent_id'],
        );
    }

    public function render()
    {
        return view('livewire.products.categories.get-product-categories-from-api');
    }
}
