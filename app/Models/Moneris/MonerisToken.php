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

    public function formattedExpDate() 
    {
        
        if ($expDateParts = str_split($this->exp_date, 2)) { 
            $formatted = $expDateParts[1] . "/" . $expDateParts[0];
        } else {
            $formatted = null;
        }

        return $formatted;

    }
}
