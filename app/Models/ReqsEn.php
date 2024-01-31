<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TypeTransport;
use App\Models\Expenses;
use App\Models\User;

class ReqsEn extends Model
{
    protected $table = 'hgt_reqs_en';

    public $primaryKey = 'id';

    protected $fillable = [
        'type_reqs', 'id_dt_reqs', 'id_expenses', 'en_id', 'id_type_trans', 'status', 'additional', 'reject'
    ];
    
    public $incrementing = false;
}
