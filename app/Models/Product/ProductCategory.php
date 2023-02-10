<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public function subcategories()
    {
        return $this->hasMany(ProductCategory::class, 'wp_parent_id', 'wp_id');
    }

    public function descendants()
    {
        return $this->hasMany(ProductCategory::class, 'wp_parent_id', 'wp_id')
            ->with('descendants');
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'wp_parent_id', 'wp_id');
    }

    public function ancestors()
    {
        return $this->belongsTo(ProductCategory::class, 'wp_parent_id', 'wp_id')
            ->with('parent');
    }

}
