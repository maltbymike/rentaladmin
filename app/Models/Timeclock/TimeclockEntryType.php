<?php

namespace App\Models\Timeclock;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeclockEntryType extends Model
{
    use HasFactory;

    public function entries()
    {
        return $this->hasMany(TimeclockEntry::class);
    }
}
