<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReqsEn;

class RefReqs extends Model
{
    protected $table = 'hgt_ref_reqs';

    public $primaryKey = 'id';

    protected $fillable = [
        'id_reqs', 'notiket', 'reqs_at'
    ];
    
    public $incrementing = false;

    public function get_reqs(){
        return $this->belongsTo(ReqsEn::class, 'id_reqs', 'id');
    }
}
