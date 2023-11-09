<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Notif extends Model
{
    protected $table = 'vw_hgt_notifications';

    protected $fillable = [
        'kunci', 'bagian', 'user_from', 'to_nik', 'to_user', 'note', 'see', 'sts_ticket'
    ];
}
