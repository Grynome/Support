<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeType extends Model
{
    protected $table = 'hgt_office_type';

    public $primaryKey = 'office_type_id';
    
    protected $fillable = [
        'office_type_id', 'name_type', 'deleted'
    ];
    public $incrementing = false;
}
