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
        'notiket', 'id_dt_reqs', 'id_expenses', 'en_id', 'id_type_trans', 'status', 'reject'
    ];
    
    public $incrementing = false;

    public function type_trans(){
        return $this->belongsTo(TypeTransport::class, 'id_type_trans', 'id');
    }

    public function get_expenses(){
        return $this->belongsTo(Expenses::class, 'id_expenses', 'id_expenses');
    }

    public function get_user(){
        return $this->belongsTo(User::class, 'en_id', 'nik');
    }

}
