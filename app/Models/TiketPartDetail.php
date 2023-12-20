<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketPartDetail extends Model
{
    protected $table = 'hgt_tiket_part_detail';

    protected $fillable = [
        'part_detail_id', 'unit_name', 'category_part', 'so_num', 'awb_num', 'rma', 'pn', 'sn', 'type_part', 'part_onsite', 'status', 'send', 'eta', 'arrive', 'created_at'
    ];
}
