<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    public $primaryKey = 'id';
    protected $fillable = [
        'name', 'status'
    ];
    public $incrementing = false;
}
