<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_Act_Report_EN extends Model
{
    protected $table = 'vw_act_report_engineer';

    public $primaryKey = 'notiket';

    protected $fillable = [
       'notiket', 
       'entrydate', 
       'project_id', 
       'project_name', 
       'visitting', 
       'OnSite', 
       'received', 
       'lat_receive', 
       'lng_receive', 
       'gow', 
       'lat_gow', 
       'lng_gow', 
       'arrived', 
       'lat_arrive', 
       'lng_arrive', 
       'work_start', 
       'lat_ws', 
       'lng_ws', 
       'work_stop', 
       'lat_wtp', 
       'lng_wtp', 
       'leave_site', 
       'lat_ls', 
       'lng_ls', 
       'travel_stop', 
       'lat_ts', 
       'lng_ts'
    ];
    
    public $incrementing = false;
}
