<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_AAEn extends Model
{
    protected $table = 'vw_attachment_activity_engineer';

    protected $fillable = [
       'id', 'notiket', 'en_attach_id', 'filename', 'path', 'note', 'type_attach'
    ];
}