<?php

namespace App\Http\Livewire\Products\Categories;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\Product\ProductCategory;
use App\Http\Integrations\IRWordpress\IRWordpressConnector;
use App\Http\Integrations\IRWordpress\Requests\GetProductCategoriesRequest;

class GetProductCategoriesFromApi extends Component
{
    public Collection $categoriesByStatus;

    public function getProductCategories()
    {

        $irWordpress = new IRWordpressConnector();
        $request = new GetProductCategoriesRequest();

        $i = 1;
        $categoriesFromApi = collect();

        do {

            $request->query()->set(['page' => $i]);

            $response = $irWordpress->send($request);

            $json = collect(json_decode($response->body(), true));

            $categoriesFromApi = $categoriesFromApi->merge($json);

            $totalPages = $response->header('x-wp-totalpages');

            $i++;

        } while ($i <= $totalPages);

        $this->upsertCategories($categoriesFromApi);

        $this->getProductCategoriesFromDatabase();

    }

    protected function getProductCategoriesFromDatabase()
    {

        $categories = ProductCategory::with('parent')->get();

        $categoriesCollection = collect(['added' => collect(), 'updated' => collect(), 'toDelete' => collect()]);

        $lastUpdatedAt = $categories->max('updated_at');

        foreach ($categories as $category) { 
            
            if ($category->wasUpdatedAt($lastUpdatedAt)) {

                if ($category->wasCreatedAt($lastUpdatedAt)) {
                    
                    $categoriesCollection['added']->push($category);
                
                } else {
                    
                    $categoriesCollection['updated']->push($category);

                }

            } else {

                $categoriesCollection['toDelete']->push($category);

            }
        }

        $this->categoriesByStatus = $categoriesCollection;

    }

    public function mount()
    {
    
        $this->getProductCategoriesFromDatabase();
        
    }

    public function upsertCategories(Collection $categories)
    {

        // Create collection of id and name
        $categoriesWithoutParent = $categories->map(function ($value) {
            return [
                'wp_id' => $value['id'], 
                'name' => $value['name'], 
            ];
        });

        // Create collection of wp_id and wp_parent_id
        $categoriesWithParent = $categories->map(function ($value) {
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
