<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReqsEn;
use App\Models\ProjectInfo;

class RefReqs extends Model
{
    protected $table = 'hgt_ref_reqs';

    public $primaryKey = 'id';

    protected $fillable = [
        'id_reqs', 'notiket', 'reqs_at'
    ];
    
    public $incrementing = false;

    public function gpi(){
        return $this->belongsTo(ProjectInfo::class, 'notiket', 'notiket');
    }
}
