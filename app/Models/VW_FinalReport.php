<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_FinalReport extends Model
{
    protected $table = 'vw_final_report';
    
    public function parts()
    {
        return $this->hasMany(VW_Tiket_Part::class, 'notiket', 'notiket');
    }
}
