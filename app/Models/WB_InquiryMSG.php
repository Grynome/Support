<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WB_InquiryMSG extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'inquiry_question';

    public $primaryKey = 'id';

    protected $fillable = [
        'name', 'phone', 'email', 'message', 'created_at'
    ];

    public $incrementing = false;
}
