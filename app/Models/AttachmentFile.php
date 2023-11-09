<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentFile extends Model
{
    protected $table = 'hgt_tiket_attachment';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'type_attach', 'filename', 'path'
    ];
    
    public $incrementing = false;
}
