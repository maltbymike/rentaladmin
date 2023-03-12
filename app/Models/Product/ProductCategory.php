<?php

namespace App\Models\Product;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class ProductCategory extends Model
{
    use HasFactory;
    // use HasRecursiveRelationships;

    public function subcategories()
    {
        return $this->hasMany(ProductCategory::class, 'wp_parent_id', 'wp_id');
    }

    public function subcategoriesWithDescendants()
    {
        return $this->hasMany(ProductCategory::class, 'wp_parent_id', 'wp_id')
            ->with('subcategoriesWithDescendants');
    }

    public function subcategoriesWithProductsAndDescendants()
    {
        return $this->hasMany(ProductCategory::class, 'wp_parent_id', 'wp_id')
            ->with('products')
            ->with('subcategoriesWithDescendants');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'wp_parent_id', 'wp_id');
    }

    public function ancestors()
    {
        return $this->belongsTo(ProductCategory::class, 'wp_parent_id', 'wp_id')
            ->with('ancestors');
    }

    public function wasCreatedAt(Carbon $timestamp)
    {
        return $this->created_at->equalTo($timestamp);
    }

    public function wasUpdatedAt(Carbon $timestamp)
    {
        return $this->updated_at->equalTo($timestamp);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function productsWithAlternateRates()
    {
        return $this->belongsToMany(Product::class)
            ->with('alternateProducts');
    }

}
