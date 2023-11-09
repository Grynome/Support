<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StsPending extends Model
{
    protected $table = 'hgt_ktgr_pending';

    public $primaryKey = 'id';

    protected $fillable = [
        'ktgr_pending', 'deleted'
    ];

    public $incrementing = false;
}
