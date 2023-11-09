<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatNews extends Model
{
    protected $table = 'hgt_whats_news';

    public $primaryKey = 'id';

    protected $fillable = [
        'nik', 'square', 'aktif', 'created_at', 'updated_at'
    ];

    public $incrementing = false;
    public function user(){
        return $this->belongsTo('\App\Models\User', 'nik', 'nik');
    }
}
