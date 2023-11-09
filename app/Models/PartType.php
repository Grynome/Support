<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartType extends Model
{
    protected $table = 'hgt_sts_type_part';
    public $primaryKey = 'id';

    protected $fillable = [
        'id', 'part_type', 'desc_type', 'status', 'deleted', 'created_at'
    ];
}
