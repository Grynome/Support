<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WB_Product extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'product';

    public $primaryKey = 'id';

    protected $fillable = [
        'product_name', 'filename', 'category', 'path', 'information', 'created_at'
    ];

    public $incrementing = false;
    public function category_prd(){
        return $this->belongsTo('\App\Models\WB_Category_Product', 'category', 'id');
    }
}
