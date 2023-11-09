<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActPIC extends Model
{
    protected $table = 'hgt_type_act_pic';

    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}
