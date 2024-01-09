<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VW_Tiket_Part;
use App\Models\VW_Log_Note_Tiket;
use App\Models\TiketInfo;

class VW_ReportTicket extends Model
{
    protected $table = 'vw_report_ticket';
    public function parts()
    {
        return $this->hasMany(VW_Tiket_Part::class, 'notiket', 'notiket');
    }

    public function notes()
    {
        return $this->hasMany(VW_Log_Note_Tiket::class, 'notiket', 'notiket');
    }
    public function info_tiket(){
        return $this->belongsTo('\App\Models\TiketInfo', 'notiket', 'notiket');
    }
}
