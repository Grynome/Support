<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    protected $table = 'hgt_depart';

    protected $fillable = [
        'id', 'department'
    ];
}
