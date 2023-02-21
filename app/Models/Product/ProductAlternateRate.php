<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAlternateRate extends Model
{
    use HasFactory;

    public function alternateProduct()
    {
        return $this->belongsTo(ProductAlternateRateProduct::class, 'product_alternate_rate_product_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
