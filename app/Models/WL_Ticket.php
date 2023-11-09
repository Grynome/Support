<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WL_Ticket extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'tiket';

    public $primaryKey = 'tiket_id';

    public $incrementing = false;
}
