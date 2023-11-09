<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $table = 'hgt_merk_unit';
    public $primaryKey = 'id';

    protected $fillable = [
        'id', 'merk', 'deleted', 'created_at', 'updated_at'
    ];
}
