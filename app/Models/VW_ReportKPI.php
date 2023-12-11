<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VW_ReportKPI extends Model
{
    protected $table = 'vw_hgt_report_kpi';

    protected $fillable = [
        'notiket', 'entrydate', 'email_masuk', 'closedate', 'jadwal_engineer', 'solved', 'duration_wn', 'close_duration', 'dept_en', 'dept_helpdesk', 'project_name'
    ];
}