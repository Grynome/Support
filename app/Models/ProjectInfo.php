<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Project;

class ProjectInfo extends Model
{
    protected $table = 'hgt_project_info';

    public $primaryKey = 'id';

    protected $fillable = [
        'notiket', 'project_id', 'end_user_id', 'created_at' 
    ];

    public $incrementing = false;
    public function go_end_user(){
        return $this->belongsTo(Customer::class, 'end_user_id', 'end_user_id');
    }
    public function go_jekfo(){
        return $this->belongsTo(Project::class, 'project_id', 'project_id');
    }
}
