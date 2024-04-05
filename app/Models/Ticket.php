<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Source;
use App\Models\ProjectInfo;
use App\Models\SLA;
use App\Models\User;
use App\Models\Customer;

class Ticket extends Model
{
    protected $table = 'hgt_ticket';

    public $primaryKey = 'tiket_id';

    protected $fillable = [
        'notiket', 'type_ticket', 'case_id', 'sla', 'severity', 'entrydate', 'ticketcoming', 'pendingtime', 'respontime', 'closedate', 'l2_id', 'en_id', 'service_point', 'schedule', 'sumber_id', 'id_customer', 'part_reqs', 'status', 'ext_status', 'sts_pending', 'prev_bin', 'status_awb', 'status_docs', 'deleted', 'created_at', 'updated_at'
    ];

    public $incrementing = false;
    public function get_source(){
        return $this->belongsTo(Source::class, 'sumber_id', 'id');
    }
    public function get_pi(){
        return $this->belongsTo(ProjectInfo::class, 'notiket', 'notiket');
    }
    public function get_sla(){
        return $this->belongsTo(SLA::class, 'sla', 'id');
    }
    public function get_u(){
        return $this->belongsTo(User::class, 'en_id', 'nik');
    }
}
