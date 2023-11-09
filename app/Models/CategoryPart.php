<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPart extends Model
{
    protected $table = 'hgt_category_part';

    public $primaryKey = 'id';

    protected $fillable = [
        'type_name', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}
