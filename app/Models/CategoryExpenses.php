<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryExpenses extends Model
{
    protected $table = 'hgt_category_expenses';

    public $primaryKey = 'id';

    protected $fillable = [
        'description', 'deleted'
    ];

    public $incrementing = false;
}
