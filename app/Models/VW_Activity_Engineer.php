<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Activity_Engineer extends Model
{
    protected $table = 'vw_hgt_activity_engineer';

    public $primaryKey = 'notiket';

    protected $fillable = [
        'notiket', 'nik', 'en_attach_id', 'full_name', 'act_description', 'sts_ticket', 'keterangan', 'act_time', 'latitude', 'longitude', 'status_activity', 'status', 'project_id'
    ];

    public $incrementing = false;
}
