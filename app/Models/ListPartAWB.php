<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListPartAWB extends Model
{
    protected $table = 'hgt_list_part_awb';

    protected $fillable = [
        'part_detail_id', 'part_id', 'status', 'nik', 'created_at'
    ];
}
