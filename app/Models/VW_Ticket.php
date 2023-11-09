<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Ticket extends Model
{
    protected $table = 'vw_hgt_ticket';
    
    public function get_project(){
        return $this->belongsTo('\App\Models\ProjectInfo', 'notiket', 'notiket');
    }
    public function get_tiket_part(){
        return $this->belongsTo('\App\Models\TiketPart', 'notiket', 'notiket');
    }
    public function info_tiket(){
        return $this->belongsTo('\App\Models\TiketInfo', 'notiket', 'notiket');
    }
}
