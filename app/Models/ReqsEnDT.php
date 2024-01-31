<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryReqs;

class ReqsEnDT extends Model
{
    protected $table = 'hgt_reqs_en_dt';

    public $primaryKey = 'id';

    protected $fillable = [
        'id_dt_reqs', 'ctgr_reqs', 'nominal', 'actual', 'filename', 'path', 'status'
    ];
    
    public $incrementing = false;

    public function get_ctgr(){
        return $this->belongsTo(CategoryReqs::class, 'ctgr_reqs', 'id');
    }
}
