<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_EnKPI_Detil extends Model
{
    protected $table = 'vw_hgt_en_kpi_detil';

    protected $fillable = [
        'notiket', 'sts_timeline', 'visiting', 'act_12', 'act_23', 'act_34', 'act_45', 'act_56', 'act_67'
    ];
}
