<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePoint extends Model
{
    protected $table = 'hgt_service_point';

    public $primaryKey = 'service_id';
    
    protected $fillable = [
        'service_id', 'service_name', 'ownership', 'alamat', 'provinsi_id', 'kota_id', 'phone', 'email', 'head', 'status', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}