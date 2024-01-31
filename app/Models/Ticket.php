<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'hgt_ticket';

    public $primaryKey = 'tiket_id';

    protected $fillable = [
        'notiket', 'type_ticket', 'case_id', 'sla', 'severity', 'entrydate', 'ticketcoming', 'pendingtime', 'respontime', 'closedate', 'l2_id', 'en_id', 'service_point', 'schedule', 'sumber_id', 'project_id', 'id_customer', 'part_reqs', 'status', 'ext_status', 'sts_pending', 'prev_bin', 'status_awb', 'status_docs', 'deleted', 'created_at', 'updated_at'
    ];

    public $incrementing = false;
    public function get_source(){
        return $this->belongsTo('\App\Models\Source', 'sumber_id', 'id');
    }
    public function get_project(){
        return $this->belongsTo('\App\Models\Project', 'project_id', 'project_id');
    }
    public function get_sla(){
        return $this->belongsTo('\App\Models\SLA', 'sla', 'id');
    }
}
