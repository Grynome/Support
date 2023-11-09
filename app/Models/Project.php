<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'hgt_project';

    public $primaryKey = 'project_id';

    protected $fillable = [
        'project_id', 'no_contract', 'partner_id', 'contact_person', 'project_name', 'startdate', 'enddate', 'mail_project', 'phone', 'desc', 'status', 'deleted', 'created_at' 
    ];

    public $incrementing = false;
    public function go_partner(){
        return $this->belongsTo('\App\Models\Partner', 'partner_id', 'partner_id');
    }
}
