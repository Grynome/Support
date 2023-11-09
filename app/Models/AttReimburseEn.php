<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttReimburseEn extends Model
{
    protected $table = 'hgt_attach_reimburse';

    public $primaryKey = 'id';

    protected $fillable = [
        'filename', 'path', 'status'
    ];
    
    public $incrementing = false;
}
