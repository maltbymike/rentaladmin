<?php

namespace App\Models\Product;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function wasCreatedAt(Carbon $timestamp)
    {
        return $this->created_at->equalTo($timestamp);
    }

    public function wasUpdatedAt(Carbon $timestamp)
    {
        return $this->updated_at->equalTo($timestamp);
    }

}
