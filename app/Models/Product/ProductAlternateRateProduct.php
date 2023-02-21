<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAlternateRateProduct extends Model
{
    use HasFactory;

    public function rateType()
    {
        return $this->belongsTo(ProductAlternateRateType::class, 'product_alternate_rate_type_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
