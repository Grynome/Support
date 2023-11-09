<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketPartNew extends Model
{
    protected $table = 'hgt_tiket_part_new';

    protected $fillable = [
        'notiket', 'part_detail_id'
    ];
}
