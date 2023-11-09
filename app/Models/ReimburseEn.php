<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimburseEn extends Model
{
    protected $table = 'hgt_reimburse_en';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'id_attach_reimburse', 'nominal', 'description'
    ];
    
    public $incrementing = false;
}
