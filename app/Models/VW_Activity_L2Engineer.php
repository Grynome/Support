<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Activity_L2Engineer extends Model
{
    protected $table = 'vw_hgt_activity_l2engineer';
    public $primaryKey = 'notiket';

    protected $fillable = [
        'notiket', 'nik', 'full_name', 'act_description', 'sts_ticket', 'act_time', 'latitude', 'longitude', 'status_activity', 'status', 'project_id'
    ];

    public $incrementing = false;
}
