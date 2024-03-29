<?php

namespace App\Models\Timeclock;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeclockEntry extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'clock_in_at' => 'datetime',
        'clock_out_at' => 'datetime',
    ];

    protected $fillable = [
        'timeclock_entry_type_id',
    ];
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function entryType()
    {
        return $this->belongsTo(TimeclockEntryType::class, 'timeclock_entry_type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
