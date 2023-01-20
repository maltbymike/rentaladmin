<?php

namespace App\Models\Timeclock;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeclockEntry extends Model
{
    use HasFactory;

    protected $casts = [
        'is_start_time' => 'boolean',
    ];

    public function entryType()
    {
        return $this->belongsTo(TimeclockEntryType::class, 'timeclock_entry_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
