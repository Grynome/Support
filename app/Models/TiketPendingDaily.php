<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketPendingDaily extends Model
{
    protected $table = 'tiket_pending_daily';

    public $primaryKey = 'ID';

    protected $fillable = [
        'tanggal', 'tiket_pending'
    ];
}