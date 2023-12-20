<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTiket extends Model
{
    protected $table = 'hgt_tiket_log';

    protected $fillable = [
        'notiket', 'type_note', 'note', 'user', 'sts_pending', 'type_log', 'created_at'
    ];
    public function get_user(){
        return $this->belongsTo('\App\Models\User', 'user', 'nik');
    }
    public function typeNote(){
        return $this->belongsTo('\App\Models\CategoryNote', 'type_note', 'id');
    }
}