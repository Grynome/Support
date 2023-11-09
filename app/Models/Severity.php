<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Severity extends Model
{
    protected $table = 'hgt_severity';

    protected $fillable = [
        'severity_name', 'deleted', 'created_at'
    ];
}
