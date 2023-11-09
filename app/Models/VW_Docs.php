<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Docs extends Model
{
    protected $table = 'vw_hgt_docs';

    protected $fillable = [
        'id', 'notiket', 'engineer_attach_id', 'filename', 'path', 'visiting'
    ];
}
