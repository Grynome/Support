<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReqsUpload extends Model
{
    protected $table = 'hgt_reqs_upload';

    public $primaryKey = 'id';

    protected $fillable = [
        'id_dt', 'filename', 'path'
    ];
    
    public $incrementing = false;
}
