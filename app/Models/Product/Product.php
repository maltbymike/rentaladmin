<?php

namespace App\Models\Product;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function alternateProducts()
    {
        return $this->belongsToMany(ProductAlternateRateProduct::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function shippingClass()
    {
        return $this->belongsTo(ProductShippingClass::class, 'product_shipping_class');
    }

    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'product_status_id');
    }

    public function visibility()
    {
        return $this->belongsTo(ProductVisibility::class, 'product_visibility_id');
    }

    public function wasCreatedAt(Carbon $timestamp)
    {
        return $this->created_at->equalTo($timestamp);
    }

    public function wasUpdatedAt(Carbon $timestamp)
    {
        return $this->updated_at->equalTo($timestamp);
    }

}
