<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryExpenses;

class Expenses extends Model
{
    protected $table = 'hgt_expenses';

    public $primaryKey = 'id_expenses';

    protected $fillable = [
        'id_expenses', 'description', 'category', 'expenses_date', 'total', 'paid_by', 'note', 'status'
    ];
    
    public $incrementing = false;

    public function ctgr_exp(){
        return $this->belongsTo(CategoryExpenses::class, 'category', 'id');
    }
}
