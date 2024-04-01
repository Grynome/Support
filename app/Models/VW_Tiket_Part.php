<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VW_ReportTicket;

class VW_Tiket_Part extends Model
{
    protected $table = 'vw_hgt_tiket_part_detail';

    public function ticket()
    {
        return $this->belongsTo(VW_ReportTicket::class, 'notiket', 'notiket');
    }
}