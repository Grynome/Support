<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'hgt_source';

    public $primaryKey = 'sumber_id';

    protected $fillable = [
        'sumber_id', 'sumber_name', 'detail', 'deleted', 'created_at', 'updated_at' 
    ];

    public $incrementing = false;
}
