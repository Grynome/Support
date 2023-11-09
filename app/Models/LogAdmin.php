<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table = 'hgt_log_admin';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'action', 'id_admin'
    ];
    public $incrementing = false;
}