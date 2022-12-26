<?php

namespace App\Models\Moneris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonerisPorPaymentToken extends Model
{
    use HasFactory;

    public $fillable = ['payment_id', 'por_token'];

    public $timestamps = false;

}
