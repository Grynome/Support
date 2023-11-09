<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_List_Part_AWB extends Model
{
    protected $table = 'vw_hgt_list_part_awb';

    public $primaryKey = 'notiket';

    protected $fillable = [
        'notiket', 'part_id', 'product_number', 'serial_number'
    ];
    public $incrementing = false;
}
