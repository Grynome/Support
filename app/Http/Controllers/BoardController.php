<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VW_Ticket;
use App\Models\Ticket;
use App\Models\VW_Activity_Engineer;
use App\Models\ActivityEngineer;
use Carbon\Carbon;

class BoardController extends Controller
{
    public function dashboard()
    {
        return view('Pages.Dashboard.page');
    }
    public function getTicketsToday()
    {
        $tgl = date("Y-m-d", strtotime("+7 hours"));
        $num_ticket = Ticket::selectRaw('COUNT(*) AS today_ticket')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_ticket')
                                ->from('hgt_ticket')
                                ->where('entrydate', 'LIKE','%'.$tgl.'%')
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        $num_close = Ticket::selectRaw('COUNT(*) AS today_close')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_close')
                                ->from('hgt_ticket')
                                ->where('closedate', 'LIKE','%'.$tgl.'%')
                                ->where('status', 10)
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        $progpen_ticket = Ticket::selectRaw('COUNT(*) AS today_progpen')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_progpen')
                                ->from('hgt_ticket')
                                ->where('schedule', 'LIKE','%'.$tgl.'%')
                                ->where('status', '<', 10)
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        return response()->json([
            'today_ticket' => $num_ticket->today_ticket,
            'num_close' => $num_close->today_close,
            'progpen' => $progpen_ticket->today_progpen
        ]);
    }
    public function getTickets()
    {
        $tgl = date("Y-m-d", strtotime("+7 hours"));
        $tickets = VW_Ticket::where('status', '<', 10)->where('departure', 'LIKE','%'.$tgl.'%')->get();
                                // ->where(function($query) {
                                //     $query->whereBetween('departure', [Carbon::now()->addHours(7)->subDay(), Carbon::now()->addHours(7)])
                                //     ->orWhere(function($query) {
                                //         $query->whereBetween('departure', [Carbon::now()->addHours(7), Carbon::now()->addHours(7)->addDay()]);
                                //     });
                                // })->get();
        return response()->json($tickets);
    }
    public function getStatusDash($tiketID)
    {
        $ticket = Ticket::select('status', 'notiket')->where('tiket_id', $tiketID)->first();
        $solve = VW_Activity_Engineer::select('act_description')
            ->where('notiket', $ticket->notiket)
            ->where('act_description', 9)
            ->first();
        $act_descriptst = VW_Activity_Engineer::select('act_time', 'act_description', 'status_activity')
            ->where('notiket', $ticket->notiket)
            ->where('sts_timeline', 0)
            ->whereNotIn('act_description', [8, 9])
            ->groupBy('act_description')
            ->orderBy('act_time', 'desc')
            ->first();
        $act_descriptnd = VW_Activity_Engineer::select('act_time', 'act_description', 'status_activity')
            ->where('notiket', $ticket->notiket)
            ->where('sts_timeline', 1)
            ->whereNotIn('act_description', [8, 9])
            ->groupBy('act_description')
            ->orderBy('act_time', 'desc')
            ->first();
        $act_descriptrd = VW_Activity_Engineer::select('act_time', 'act_description', 'status_activity')
            ->where('notiket', $ticket->notiket)
            ->where('sts_timeline', 2)
            ->whereNotIn('act_description', [8, 9])
            ->groupBy('act_description')
            ->orderBy('act_time', 'desc')
            ->first();
        $act_descript4th = VW_Activity_Engineer::select('act_time', 'act_description', 'status_activity')
            ->where('notiket', $ticket->notiket)
            ->where('sts_timeline', 3)
            ->whereNotIn('act_description', [8, 9])
            ->groupBy('act_description')
            ->orderBy('act_time', 'desc')
            ->first();
        $act_descript5th = VW_Activity_Engineer::select('act_time', 'act_description', 'status_activity')
            ->where('notiket', $ticket->notiket)
            ->where('sts_timeline', 4)
            ->whereNotIn('act_description', [8, 9])
            ->groupBy('act_description')
            ->orderBy('act_time', 'desc')
            ->first();
        $pending = ActivityEngineer::select('act_time','updated_at')
            ->where('notiket', $ticket->notiket)
            ->where('act_description', 8)
            ->orderBy('updated_at', 'asc')
            ->first();
        $solveValue = $solve ? $solve->act_description : null;
        $act_descriptionstVal = $act_descriptst ? $act_descriptst->act_description : null;
        $status_activitystVal = $act_descriptst ? $act_descriptst->status_activity : null;
        $act_timestVal = $act_descriptst ? date('H:i', strtotime($act_descriptst->act_time)) : null;
        $act_descriptionndVal = $act_descriptnd ? $act_descriptnd->act_description : null;
        $status_activityndVal = $act_descriptnd ? $act_descriptnd->status_activity : null;
        $act_timendVal = $act_descriptnd ? date('H:i', strtotime($act_descriptnd->act_time)) : null;
        $act_descriptionrdVal = $act_descriptrd ? $act_descriptrd->act_description : null;
        $status_activityrdVal = $act_descriptrd ? $act_descriptrd->status_activity : null;
        $act_timerdVal = $act_descriptrd ? date('H:i', strtotime($act_descriptrd->act_time)) : null;
        $act_description4thVal = $act_descript4th ? $act_descript4th->act_description : null;
        $status_activity4thVal = $act_descript4th ? $act_descript4th->status_activity : null;
        $act_time4thVal = $act_descript4th ? date('H:i', strtotime($act_descript4th->act_time)) : null;
        $act_description5thVal = $act_descript5th ? $act_descript5th->act_description : null;
        $status_activity5thVal = $act_descript5th ? $act_descript5th->status_activity : null;
        $act_time5thVal = $act_descript5th ? date('H:i', strtotime($act_descript5th->act_time)) : null;
        $pendingsts = $pending ? $pending->updated_at : null;
        $pendingactTime = $pending ? date('H:i', strtotime($pending->act_time)) : null;
        return response()->json([
            'status' => $ticket->status,
            'act_descriptionst' => $act_descriptionstVal,
            'status_activityst' => $status_activitystVal,
            'act_timest' => $act_timestVal,
            'act_descriptionnd' => $act_descriptionndVal,
            'status_activitynd' => $status_activityndVal,
            'act_timend' => $act_timendVal,
            'act_descriptionrd' => $act_descriptionrdVal,
            'status_activityrd' => $status_activityrdVal,
            'act_timerd' => $act_timerdVal,
            'act_description4th' => $act_description4thVal,
            'status_activity4th' => $status_activity4thVal,
            'act_time4th' => $act_time4thVal,
            'pending' => $pendingsts,
            'act_timepending' => $pendingactTime,
            'solve' => $solveValue
        ]);
    }
}
