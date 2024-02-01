<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryNote;
use App\Models\StsPending;
use App\Models\User;

class LogTiket extends Model
{
    protected $table = 'hgt_tiket_log';

    protected $fillable = [
        'notiket', 'type_note', 'note', 'user', 'sts_pending', 'type_log', 'created_at'
    ];
    public function get_user(){
        return $this->belongsTo(User::class, 'user', 'nik');
    }
    public function typeNote(){
        return $this->belongsTo(CategoryNote::class, 'type_note', 'id');
    }
    public function typePending(){
        return $this->belongsTo(StsPending::class, 'sts_pending', 'id');
    }
}