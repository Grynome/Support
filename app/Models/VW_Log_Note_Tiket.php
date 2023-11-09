<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VW_ReportTicket;

class VW_Log_Note_Tiket extends Model
{
    protected $table = 'vw_log_note_ticket';

    protected $fillable = [
        'notiket', 'ktgr_name', 'note', 'full_name', 'created_at'
    ];
    public function ticket()
    {
        return $this->belongsTo(VW_ReportTicket::class, 'notiket', 'notiket');
    }
}
