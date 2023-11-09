<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoggingHGT extends Model
{
    protected $table = 'hgt_logging';

    protected $fillable = [
        'key', 'who_is', 'action', 'created_at'
    ];
}
