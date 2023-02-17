<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Product\Product;
use Illuminate\Support\Collection;
use App\Models\Product\ProductStatus;
use App\Models\Product\Productproduct;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductVisibility;
use App\Models\Product\ProductShippingClass;
use App\Http\Integrations\IRWordpress\IRWordpressConnector;
use App\Http\Integrations\IRWordpress\Requests\GetProductsRequest;

class GetProductsFromApi extends Component
{

    public Collection $productsByStatus;

    public function getProductsFromApi()
    {

        $irWordpress = new IRWordpressConnector();
        $request = new GetProductsRequest();

        $i = 1;
        $productsFromApi = collect();

        do {

            $request->query()->set(['page' => $i]);

            $response = $irWordpress->send($request);

            $json = collect(json_decode($response->body(), true));

            $productsFromApi = $productsFromApi->merge($json);

            $totalPages = $response->header('x-wp-totalpages');

            $i++;

        } while ($i <= $totalPages);

        $this->upsertProducts($productsFromApi);
        
        $this->getProductsFromDatabase();
        
    }

    protected function getProductsFromDatabase()
    {

        $products = Product::all();

        $productsCollection = collect(['added' => collect(), 'updated' => collect(), 'toDelete' => collect()]);

        $lastUpdatedAt = $products->max('updated_at');

        foreach ($products as $product) { 
            
            if ($product->wasUpdatedAt($lastUpdatedAt)) {

                if ($product->wasCreatedAt($lastUpdatedAt)) {
                    
                    $productsCollection['added']->push($product);
                
                } else {
                    
                    $productsCollection['updated']->push($product);

                }

            } else {

                $productsCollection['toDelete']->push($product);

            }

        }

        $this->productsByStatus = $productsCollection;

    }

    public function mount()
    {
        $this->getProductsFromDatabase();
    }

    public function render()
    {
        return view('livewire.products.get-products-from-api');
    }

    public function upsertProducts(Collection $products)
    {

        // Get all product dependancies from database
        $categoriesFromDatabase = ProductCategory::all();
        $statusesFromDatabase = ProductStatus::all();
        $visibilitiesFromDatabase = ProductVisibility::all();
        $shippingClassesFromDatabase = ProductShippingClass::all();

        // Loop through products
        $products->each(function ($value) use (&$categoriesFromDatabase, &$statusesFromDatabase, &$visibilitiesFromDatabase, &$shippingClassesFromDatabase) {

            foreach ($value['meta_data'] as $meta) {
                switch ($meta['key']) {
                    case '_2_hour_rate':
                        $two_hour_rate = floatval($meta['value']);
                        break;
                    case '_4_hour_rate':
                        $four_hour_rate = floatval($meta['value']);
                        break;
                    case '_daily_rate':
                        $daily_rate = floatval($meta['value']);
                        break;
                    case '_weekly_rate':
                        $weekly_rate = floatval($meta['value']);
                        break;
                    case '_4_week_rate':
                        $four_week_rate = floatval($meta['value']);
                        break;
                }
            }

            $product = Product::firstOrNew(['wp_id' => $value['id']]);
            $product->name = $value['name'];
            $product->weblink = $value['permalink'];
            $product->description = $value['description'];
            $product->short_description = $value['short_description'];
            $product->sku = $value['sku'];
            $product->sell_price = $value['price'];
            $product->two_hour_rate = $two_hour_rate ?? '';
            $product->four_hour_rate = $four_hour_rate ?? '';
            $product->daily_rate = $daily_rate ?? '';
            $product->weekly_rate = $weekly_rate ?? '';
            $product->four_week_rate = $four_week_rate ?? '';
            $product->weight = $value['weight'];
            $product->length = $value['dimensions']['length'] ?? '';
            $product->width = $value['dimensions']['width'] ?? '';
            $product->height = $value['dimensions']['height'] ?? '';

            // Set Status
            if (! $productStatus = $statusesFromDatabase->firstWhere('slug', $value['status'])) {
                $status = new ProductStatus;
                $status->name = Str::headline($value['status']);
                $status->slug = $value['status'];
                $status->save();

                $productStatus = $status->id;

                // Refresh statusesFromDatabase
                $statusesFromDatabase = ProductStatus::all();
            }

            // Associate product status
            $product->status()->associate($productStatus);

            // Set visibility
            if (! $productVisibility = $visibilitiesFromDatabase->firstWhere('slug', $value['catalog_visibility'])) {
                $visibility = new ProductVisibility;
                $visibility->name = Str::headline($value['catalog_visibility']);
                $visibility->slug = $value['catalog_visibility'];
                $visibility->save();

                $productVisibility = $visibility->id;

                // Refresh visibilitiesFromDatabase
                $visibilitiesFromDatabase = ProductVisibility::all();
            }

            // Associate product status
            $product->visibility()->associate($productVisibility);

            // Set shipping class
            if (! $productShippingClass = $shippingClassesFromDatabase->firstWhere('slug', $value['shipping_class'])) {
                $shippingClass = new ProductShippingClass;
                $shippingClass->wp_id = $value['shipping_class_id'];
                $shippingClass->name = Str::headline($value['shipping_class']);
                $shippingClass->slug = $value['shipping_class'];
                $shippingClass->save();

                $productShippingClass = $shippingClass->id;

                // Refresh visibilitiesFromDatabase
                $shippingClassesFromDatabase = ProductShippingClass::all();
            }

            // Associate product shipping class
            $product->shippingClass()->associate($productShippingClass);


            $product->save();

            // Get categories from API
            foreach ($value['categories'] as $category) {
                $productCategories[] = $categoriesFromDatabase->firstWhere('wp_id', $category['id'])->id;
            }
            
            // Sync product categories
            $product->categories()->sync($productCategories);

        });

    }

}
