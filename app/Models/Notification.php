<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'hgt_notification';

    public $primaryKey = 'notif_id';

    protected $fillable = [
        'kunci', 'bagian', 'from_user', 'to_user', 'note', 'status', 'send_at', 'created_at', 'updated_at'
    ];
    
    public $incrementing = false;
    
    public function user1(){
        return $this->belongsTo('\App\Models\User', 'from_user', 'nik');
    }
    public function user2(){
        return $this->belongsTo('\App\Models\User', 'to_user', 'nik');
    }
}
