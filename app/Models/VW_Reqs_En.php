<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Reqs_En extends Model
{
    protected $table = 'vw_reqs_en';
    
    public function get_expenses(){
        return $this->belongsTo(Expenses::class, 'id_expenses', 'id_expenses');
    }
}
