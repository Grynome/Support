<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTransport extends Model
{
    protected $table = 'hgt_type_of_transport';

    public $primaryKey = 'id';

    protected $fillable = [
        'description', 'deleted'
    ];

    public $incrementing = false;
}
