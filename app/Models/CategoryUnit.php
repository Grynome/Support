<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryUnit extends Model
{
    protected $table = 'hgt_category';

    public $primaryKey = 'category_id';
    protected $fillable = [
        'category_id', 'category_name', 'deleted', 'created_at', 'updated_at'
    ];
}
