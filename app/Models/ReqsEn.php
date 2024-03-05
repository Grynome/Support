<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RefReqs;

class ReqsEn extends Model
{
    protected $table = 'hgt_reqs_en';

    public $primaryKey = 'id';

    protected $fillable = [
        'type_reqs', 'id_dt_reqs', 'id_expenses', 'en_id', 'note', 'id_type_trans', 'status', 'additional', 'reject'
    ];
    
    public $incrementing = false;
    public function refsTicket()
    {
        return $this->hasMany(RefReqs::class, 'id_reqs', 'id');
    }
}
