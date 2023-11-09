<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Pending extends Model
{
    protected $table = 'vw_dt_pending';

    protected $fillable = [
        'tiket_pending', 'tanggal', 'project_id'
    ];
}
