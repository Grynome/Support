<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqsFL extends Model
{
    protected $table = 'hgt_reqs_fl';

    public $primaryKey = 'id';

    protected $fillable = [
        'id_reqs', 'sp'
    ];
    
    public $incrementing = false;
}
