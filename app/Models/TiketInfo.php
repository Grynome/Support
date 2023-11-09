<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketInfo extends Model
{
    protected $table = 'hgt_tiket_info';

    protected $fillable = [
        'notiket', 'category_id', 'merk_id', 'type_id', 'sn', 'pn', 'warranty', 'problem', 'action_plan', 'solve', 'created_at'
    ];
    public function get_ktgr(){
        return $this->belongsTo('\App\Models\CategoryUnit', 'category_id', 'category_id');
    }
    public function get_merk(){
        return $this->belongsTo('\App\Models\Merk', 'merk_id', 'id');
    }
    public function get_type(){
        return $this->belongsTo('\App\Models\TypeUnit', 'type_id', 'id');
    }
}
