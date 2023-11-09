<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectInfo extends Model
{
    protected $table = 'hgt_project_info';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'project_id', 'end_user_id', 'created_at' 
    ];

    public $incrementing = false;
    public function go_end_user(){
        return $this->belongsTo('\App\Models\Customer', 'end_user_id', 'end_user_id');
    }
    public function go_jekfo(){
        return $this->belongsTo('\App\Models\Project', 'project_id', 'project_id');
    }
}
