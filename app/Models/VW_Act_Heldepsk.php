<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Act_Heldepsk extends Model
{
    protected $table = 'vw_hgt_act_helpdesk';

    protected $fillable = [
       'notiket', 
       'ktgr_note', 
       'note', 
       'nik', 
       'full_name', 
       'created_at'
    ];
}
