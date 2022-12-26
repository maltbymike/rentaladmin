<?php

namespace App\Models\Moneris;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonerisPorPaymentToken extends Model
{
    use HasFactory;

    public $fillable = ['payment_id', 'por_token'];

    public $timestamps = false;

    public static function getUniqueTokens() {
        return MonerisPorPaymentToken::selectRaw('por_token, max(date) as date, count(*) as use_count, min(customer_id) as min_customer, max(customer_id) as max_customer')
            ->groupBy('por_token');
    }

    public static function getUniqueTokensWithoutNull() {
        return MonerisPorPaymentToken::selectRaw('por_token, max(date) as date, count(*) as use_count, min(customer_id) as min_customer, max(customer_id) as max_customer')
            ->groupBy('por_token')
            ->whereNotNull('por_token')
            ->where('por_token', '!=', 'null')
            ->where('por_token', '!=', '');
    }

}
