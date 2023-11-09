<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_List_Engineer extends Model
{
    protected $table = 'vw_hgt_engineer';

    public $primaryKey = 'nik';

    protected $fillable = [
        'full_name', 'email', 'service_name'
    ];
    public $incrementing = false;
}
