<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAlternateRateType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
}
