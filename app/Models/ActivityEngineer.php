<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityEngineer extends Model
{
    protected $table = 'hgt_activity_engineer';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'en_id', 'en_attach_id', 'act_description', 'note', 'act_time', 'latitude', 'longitude', 'visitting', 'status', 'created_at', 'updated_at'
    ];
    
    public $incrementing = false;
}
