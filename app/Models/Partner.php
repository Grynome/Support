<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'hgt_partner';

    public $primaryKey = 'partner_id';

    protected $fillable = [
        'partner_id', 'partner', 'contact_person', 'telp', 'email', 'address', 'deleted', 'created_at' 
    ];

    public $incrementing = false;
}
