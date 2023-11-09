<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SLA extends Model
{
    protected $table = 'hgt_sla';

    public $primaryKey = 'sla_id';

    protected $fillable = [
        'sla_id', 'sla_name', 'lama', 'kondisi', 'deleted', 'created_at', 'updated_at' 
    ];

    public $incrementing = false;
}
