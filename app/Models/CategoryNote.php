<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryNote extends Model
{
    protected $table = 'hgt_category_note';

    public $primaryKey = 'id';

    protected $fillable = [
        'ktgr_name', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}
