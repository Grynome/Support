<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeUnit extends Model
{
    protected $table = 'hgt_type_unit';

    protected $fillable = [
        'id', 'type_name', 'category_id', 'merk_id', 'deleted', 'created_at', 'updated_at'
    ];
    public function brand(){
        return $this->belongsTo('\App\Models\Merk', 'merk_id', 'id');
    }
    public function ktgr(){
        return $this->belongsTo('\App\Models\CategoryUnit', 'category_id', 'category_id');
    }
}
