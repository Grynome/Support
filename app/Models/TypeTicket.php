<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTicket extends Model
{
    protected $table = 'hgt_type_ticket';

    public $primaryKey = 'id';

    protected $fillable = [
        'type_name', 'deleted', 'created_at'
    ];

    public $incrementing = false;
}
