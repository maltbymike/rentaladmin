<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_name', 'mime_type', 'path', 'disk', 'file_hash', 'collection', 'size'];
}