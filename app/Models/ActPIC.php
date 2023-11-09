<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TypeActPIC;

class ActPIC extends Model
{
    protected $table = 'hgt_act_pic';

    public $primaryKey = 'id';

    protected $fillable = [
        'nik', 'id_type', 'tanggal', 'description', 'created_at', 'updated_at'
    ];
    
    public $incrementing = false;

    public function pic(){
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
    public function type(){
        return $this->belongsTo(TypeActPIC::class, 'id_type', 'id');
    }
}
