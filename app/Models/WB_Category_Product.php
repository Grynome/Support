<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WB_Category_Product extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'category_product';

    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}
