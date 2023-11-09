<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_MerkCategory extends Model
{
    protected $table = 'vw_merk_category';

    protected $fillable = [
        'merk_id', 'merk', 'category_id', 'category_name'
    ];
}
