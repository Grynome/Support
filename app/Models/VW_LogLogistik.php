<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_LogLogistik extends Model
{
    protected $table = 'vw_log_logistik';

    public $primaryKey = 'notiket';

    protected $fillable = [
        'full_name', 'notiket', 'part_name', 'dtime'
    ];
    public $incrementing = false;
}
