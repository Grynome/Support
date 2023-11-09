<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityL2En extends Model
{
    protected $table = 'hgt_activity_l2engineer';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'l2_id', 'en_attach_id', 'act_description', 'note', 'act_time', 'latitude', 'longitude', 'visiting', 'status', 'created_at', 'updated_at'
    ];
    
    public $incrementing = false;
}
