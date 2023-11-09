<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoggingLogistik extends Model
{
    protected $table = 'hgt_logging_logistik';

    protected $fillable = [
        'nik', 'notiket', 'action', 'dtime', 'created_at'
    ];
}
