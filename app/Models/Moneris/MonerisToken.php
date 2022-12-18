<?php

namespace App\Models\Moneris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonerisToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'data_key',
        'created_at',
        'cust_id',
        'email',
        'phone',
        'note',
        'masked_pan',
    ];
}
