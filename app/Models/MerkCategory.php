<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerkCategory extends Model
{
    protected $table = 'hgt_merk_category';

    public $primaryKey = 'id';

    protected $fillable = [
        'merk_id', 'category_id', 'deleted', 'created_at'
    ];
    
    public $incrementing = false;

    public function merk(){
        return $this->belongsTo('\App\Models\Merk', 'merk_id', 'id');
    }
    public function category(){
        return $this->belongsTo('\App\Models\CategoryUnit', 'category_id', 'category_id');
    }
}
