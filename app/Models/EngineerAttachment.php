<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngineerAttachment extends Model
{
    protected $table = 'hgt_engineer_attachment';

    public $primaryKey = 'id';

    protected $fillable = [
        'id', 'engineer_attach_id', 'filename', 'path', 'note'
    ];

    public $incrementing = false;
}
