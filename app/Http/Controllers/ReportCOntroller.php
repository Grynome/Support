<?php

namespace App\Http\Controllers;

use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\Ticket;
use App\Models\VW_Ticket;
use App\Models\VW_ReportTicket;
use App\Models\VW_Activity_Engineer;
use App\Models\VW_Tiket_Part;
use App\Models\LogTiket;
use App\Models\VW_Log_Note_Tiket;
use App\Models\Dept;
use App\Models\VW_ReportKPI;
use App\Models\VW_EnKPI_Detil;
use App\Models\VW_Act_Report_EN;
use App\Models\User;
use App\Models\VW_Act_Heldepsk;
use App\Models\VW_Pending;
use App\Models\TiketPendingDaily;
use App\Models\ProjectInTicket;
use App\Models\Partner;
use App\Models\Ticketing;
use App\Models\VRTP;
use App\Models\VW_FinalReport;
use App\Models\LastActEn;
use App\Models\VW_Ticket_Split;

class ReportCOntroller extends Controller
{
    public function report(Request $request)
    {
        $now = Carbon::now()->endOfDay();
        $oneMonthAgo = $now->copy()->startOfDay()->subMonth(1);
        $tanggal1 = $request->st_date_report.' '.'00:00:00';
        $tanggal2 = $request->nd_date_report.' '.'23:59:59';
        $data['partner'] = Partner::select('partner_id', 'partner')->where('deleted', 0)->get();
        $data['project'] = VW_FinalReport::select('project_id', 'project_name')->groupBy('project_name')->get();
        $data['office'] = VW_FinalReport::select('service_id', 'service_name')->where('service_id', '!=', '')->groupBy('service_name')->get();
        if (!empty($request->st_date_report) && !empty($request->nd_date_report)) {
            $eventTgl1 = $tanggal1;
            $eventTgl2 = $tanggal2;
        } else {
            $eventTgl1 = $oneMonthAgo;
            $eventTgl2 = $now;
        }
        if (!isset($request->stats_report) && 
            !isset($request->sort_sp_report) && 
            (!isset($request->prt_id) && !isset($request->sort_prj_report))) {
            $data['report'] = VW_FinalReport::all()->whereBetween('ticketcoming', [$eventTgl1, $eventTgl2]);
        } elseif(isset($request->stats_report) || (isset($request->prt_id) || isset($request->sort_prj_report)) || isset($request->sort_sp_report)) {
            if (!empty($request->stats_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_FinalReport::where('status', '!=', 10)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_FinalReport::where('status', 10)
                    ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            } elseif ((!empty($request->prt_id) || !empty($request->sort_prj_report)) && empty($request->stats_report) && empty($request->sort_sp_report)) {
                if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                    $data['report'] = VW_FinalReport::where('partner_id', $request->prt_id)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_FinalReport::where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                }
            } elseif (!empty($request->sort_sp_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && empty($request->stats_report)) {
                $data['report'] = VW_FinalReport::where('service_id', $request->sort_sp_report)
                                    ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
            } elseif (!empty($request->stats_report) && (!empty($request->prt_id) || !empty($request->sort_prj_report)) && empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                        $data['report'] = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                    } else {
                        $data['report'] = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->where('project_id', $request->sort_prj_report)
                                            ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                    }
                } else {
                    if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                        $data['report'] = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                    } else {
                        $data['report'] = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->where('project_id', $request->sort_prj_report)
                                            ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                    }
                }
            } elseif (!empty($request->stats_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && !empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_FinalReport::where('status', '!=', 10)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_FinalReport::where('status', 10)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            } elseif (empty($request->stats_report) && (!empty($request->prt_id) || !empty($request->sort_prj_report)) && !empty($request->sort_sp_report)) {
                if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                    $data['report'] = VW_FinalReport::where('service_id', $request->sort_sp_report)
                                        ->where('partner_id', $request->prt_id)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_FinalReport::where('service_id', $request->sort_sp_report)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                }
            } else {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_FinalReport::where('status', '!=', 10)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('ticketcoming', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_FinalReport::where('status', 10)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            }
        }
        return view('Pages.Report.report')->with($data)
        ->with('sts', $request->stats_report)
        ->with('prj', $request->sort_prj_report)
        ->with('prt', $request->prt_id)
        ->with('sp', $request->sort_sp_report)
        ->with('stsd', $oneMonthAgo)
        ->with('ndsd', $now)
        ->with('str', $request->st_date_report)
        ->with('ndr', $request->nd_date_report);
    }
    
    public function getViewDetilReport($notiket)
    {
        return view('Pages.Report.report-detil')->with('id', $notiket);
    }
    public function getReportDetil($notiket)
    {
        $data['query_part'] = VW_Tiket_Part::where('notiket', $notiket)->get();
        $data['query_note'] = VW_Log_Note_Tiket::where('notiket', $notiket)->get();
        return response()->json($data);
    }
    public function export(Request $request)
    {
        $extanggal1 = $request->ex_st.' '.'00:00:00';
        $extanggal2 = $request->ex_nd.' '.'23:59:59';
        $ex_sts = $request->ex_sts;
        $ex_prj = $request->ex_prj;
        $ex_prt = $request->ex_prt;
        $ex_sp = $request->ex_sp;
        
        if (!isset($ex_sts) && 
            !isset($ex_sp) && 
            (!isset($ex_prt) && !isset($ex_prj))) {
            $data_ticket = VW_FinalReport::all()->whereBetween('ticketcoming', [$extanggal1, $extanggal2]);
        } elseif(isset($ex_sts) || (isset($ex_prt) || isset($ex_prj)) || isset($ex_sp)) {
            if (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                    ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif ((!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sts) && empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_FinalReport::where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } elseif (!empty($ex_sp) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sts)) {
                $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                    ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
            } elseif (!empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    }
                } else {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                    }
                }
            } elseif (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && !empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif (empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && !empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } else {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Case ID',
            'Type Ticket',
            'Schedule',
            'Incoming Mail',
            'Entry Date',
            'Partner',
            'Project',
            'Category',
            'Unit',
            'Merk',
            'Unit Name',
            'SN',
            'PN',
            'Service Point',
            'User City',
            'Company',
            'Location',
            'Engineer',
            'Status',
            'Pending Status',
            'Note',
            'Onsite Ke',
            'SO',
            'Send',
            'Arrive',
            'Go',
            'Work Start',
            'Work Stop',
            'Leave Site',
            'Travel Stop',
            'Close Date'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($data_ticket as $item) {
            $carbonDate = Carbon::parse($item->ticketcoming);
            $tatst = Carbon::parse($item->entrydate);
            $tatnd = Carbon::parse($item->work_stop);
            $delivend = Carbon::parse($item->arrive);
            
            $get_tat = !empty($item->entrydate) && !empty($item->work_stop) ? $tatst->diffInDays($tatnd) : null;
            $get_deliv = !empty($item->entrydate) && !empty($item->arrive) ? $tatst->diffInDays($delivend) : null;
            $get_fe = !empty($item->arrive) && !empty($item->work_stop) ? $delivend->diffInDays($tatnd) : null;
            $weekN = $carbonDate->weekOfMonth;
                $data = [   
                    $no,
                    $item->notiket,
                    $item->case_id,
                    $item->type_ticket,
                    $item->schedule,
                    $item->ticketcoming,
                    $item->entrydate,
                    $item->partner,
                    $item->project_name,
                    $item->type_name,
                    $item->category_name,
                    $item->merk,
                    $item->unit_name,
                    $item->sn,
                    $item->pn,
                    $item->service_name,
                    $item->lok_kab,
                    $item->company,
                    $item->severity_name,
                    $item->full_name,
                    $item->sts_ticket,
                    $item->ktgr_pending,
                    $item->note,
                    $item->total_onsite,
                    $item->so_num,
                    $item->send,
                    $item->arrive,
                    $item->gow,
                    $item->work_start,
                    $item->work_stop,
                    $item->leave_site,
                    $item->travel_stop,
                    $item->closedate
                ];
                $sheet->fromArray([$data], NULL, "A$row");
            $row++;
            $no++;
        }
        $filename = "Ticket.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function exportDataPIC(Request $request)
    {
        $extanggal1 = $request->ex_stP.' '.'00:00:00';
        $extanggal2 = $request->ex_ndP.' '.'23:59:59';
        $ex_sts = $request->ex_stsP;
        $ex_prj = $request->ex_prjP;
        $ex_prt = $request->ex_prtP;
        $ex_sp = $request->ex_spP;
        
        if (!isset($ex_sts) && 
            !isset($ex_sp) && 
            (!isset($ex_prt) && !isset($ex_prj))) {
            $data_ticket = VW_FinalReport::all()->whereBetween('ticketcoming', [$extanggal1, $extanggal2]);
        } elseif(isset($ex_sts) || (isset($ex_prt) || isset($ex_prj)) || isset($ex_sp)) {
            if (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                    ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif ((!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sts) && empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_FinalReport::where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } elseif (!empty($ex_sp) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sts)) {
                $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                    ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
            } elseif (!empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_FinalReport::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    }
                } else {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_FinalReport::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    }
                }
            } elseif (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && !empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif (empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && !empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } else {
                if ($ex_sts == 1) {
                    $data_ticket = VW_FinalReport::where('status', '!=', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_FinalReport::where('status', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Case ID',
            'Incoming Mail',
            'Entry Date',
            'IM Bulan',
            'Minggu ke',
            'IM Hari',
            'Partner',
            'Project',
            'Onsite Ke',
            'SO',
            'Arrive',
            'Go',
            'Work Start',
            'Work Stop',
            'Close Date',
            'Week Close',
            'Bulan Close',
            'TAT',
            'Pengiriman',
            'FE',
            'Status'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($data_ticket as $item) {
            $carbonDate = Carbon::parse($item->ticketcoming);
            $tatst = Carbon::parse($item->entrydate);
            $tatnd = Carbon::parse($item->work_stop);
            $delivend = Carbon::parse($item->arrive);
            $cbCloseDate = Carbon::parse($item->closedate);
            
            $get_tat = !empty($item->entrydate) && !empty($item->work_stop) ? $tatst->diffInDays($tatnd) : null;
            $get_deliv = !empty($item->entrydate) && !empty($item->arrive) ? $tatst->diffInDays($delivend) : null;
            $get_fe = !empty($item->arrive) && !empty($item->work_stop) ? $delivend->diffInDays($tatnd) : null;
            $weekN = $carbonDate->weekOfMonth;
            $wCloseDate = $cbCloseDate->weekOfMonth;
            if ($item->status < 10) {
                $sts = 'Open';
            } else {
                $sts = 'Closed';
            }
                $data = [   
                    $no,
                    $item->notiket,
                    $item->case_id,
                    $item->ticketcoming,
                    $item->entrydate,
                    Carbon::parse($item->ticketcoming)->format('m'),
                    $weekN,
                    Carbon::parse($item->ticketcoming)->format('d'),
                    $item->partner,
                    $item->project_name,
                    $item->total_onsite,
                    $item->so_num,
                    $item->arrive,
                    $item->gow,
                    $item->work_start,
                    $item->work_stop,
                    $item->closedate,
                    $wCloseDate,
                    Carbon::parse($item->work_stop)->format('M'),
                    $get_tat,
                    $get_deliv,
                    $get_fe,
                    $sts
                ];
                $sheet->fromArray([$data], NULL, "A$row");
            $row++;
            $no++;
        }
        $filename = "Data Reporting PIC.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function exportDataSplit(Request $request)
    {
        $extanggal1 = $request->ex_stS.' '.'00:00:00';
        $extanggal2 = $request->ex_ndS.' '.'23:59:59';
        $ex_sts = $request->ex_stsS;
        $ex_prj = $request->ex_prjS;
        $ex_prt = $request->ex_prtS;
        $ex_sp = $request->ex_spS;
        
        if (!isset($ex_sts) && 
            !isset($ex_sp) && 
            (!isset($ex_prt) && !isset($ex_prj))) {
            $data_ticket = VW_Ticket_Split::all()->whereBetween('ticketcoming', [$extanggal1, $extanggal2]);
        } elseif(isset($ex_sts) || (isset($ex_prt) || isset($ex_prj)) || isset($ex_sp)) {
            if (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_Ticket_Split::where('status', '!=', 10)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_Ticket_Split::where('status', 10)
                    ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif ((!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sts) && empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_Ticket_Split::where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_Ticket_Split::where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } elseif (!empty($ex_sp) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sts)) {
                $data_ticket = VW_Ticket_Split::where('service_id', $ex_sp)
                                    ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
            } elseif (!empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_Ticket_Split::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_Ticket_Split::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    }
                } else {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_Ticket_Split::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_Ticket_Split::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                    }
                }
            } elseif (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && !empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_Ticket_Split::where('status', '!=', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_Ticket_Split::where('status', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif (empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && !empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_Ticket_Split::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_Ticket_Split::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                }
            } else {
                if ($ex_sts == 1) {
                    $data_ticket = VW_Ticket_Split::where('status', '!=', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('ticketcoming', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_Ticket_Split::where('status', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Case ID',
            'Incoming Mail',
            'Entry Date',
            'IM Bulan',
            'Minggu ke',
            'IM Hari',
            'Partner',
            'Project',
            'SO',
            'Arrive',
            'Onsite Ke',
            'Go',
            'Work Start',
            'Work Stop',
            'Close Date',
            'Week Close',
            'Bulan Close',
            'TAT',
            'Pengiriman',
            'FE',
            'Status'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($data_ticket as $item) {
            $carbonDate = Carbon::parse($item->ticketcoming);
            $tatst = Carbon::parse($item->entrydate);
            $tatnd = Carbon::parse($item->work_stop);
            $delivend = Carbon::parse($item->arrive);
            $cbCloseDate = Carbon::parse($item->closedate);
            
            $get_tat = !empty($item->entrydate) && !empty($item->work_stop) ? $tatst->diffInDays($tatnd) : null;
            $get_deliv = !empty($item->entrydate) && !empty($item->arrive) ? $tatst->diffInDays($delivend) : null;
            $get_fe = !empty($item->arrive) && !empty($item->work_stop) ? $delivend->diffInDays($tatnd) : null;
            $weekN = $carbonDate->weekOfMonth;
            $wCloseDate = $cbCloseDate->weekOfMonth;
            if ($item->status < 10) {
                $sts = 'Open';
            } else {
                $sts = 'Closed';
            }
                $data = [   
                    $no,
                    $item->notiket,
                    $item->case_id,
                    $item->ticketcoming,
                    $item->entrydate,
                    Carbon::parse($item->ticketcoming)->format('m'),
                    $weekN,
                    Carbon::parse($item->ticketcoming)->format('d'),
                    $item->partner,
                    $item->project_name,
                    $item->so_num,
                    $item->arrive,
                    $item->onsite,
                    $item->gow,
                    $item->work_start,
                    $item->work_stop,
                    $item->closedate,
                    $wCloseDate,
                    Carbon::parse($item->work_stop)->format('M'),
                    $get_tat,
                    $get_deliv,
                    $get_fe,
                    $sts
                ];
                $sheet->fromArray([$data], NULL, "A$row");
            $row++;
            $no++;
        }
        $filename = "Data Ticket - Split Onsite.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function chart(Request $request){
        $now = Carbon::now()->addHours(7)->format('Y-m-d');
        $date_st = $request->eoc_dtSt;
        $date_nd = $request->eoc_dtNd;
        if (empty($date_st) && empty($date_nd)) {
            $data['tot_ticket'] = VW_Ticket::whereBetween('entrydate', [$now.' '.'00:00:00', $now.' '.'23:59:59'])->count();
            $data['close_tcket'] = VW_Ticket::where('status', 10)->whereBetween('entrydate', [$now.' '.'00:00:00', $now.' '.'23:59:59'])->count();
            $data['open'] = TiketPendingDaily::whereBetween('tanggal', [$now.' '.'00:00:00', $now.' '.'23:59:59'])->count();
        } else {
            $data['tot_ticket'] = VW_Ticket::whereBetween('entrydate', [$date_st.' '.'00:00:00', $date_nd.' '.'23:59:59'])->count();
            $data['close_tcket'] = VW_Ticket::where('status', 10)->whereBetween('closedate', [$date_st.' '.'00:00:00', $date_nd.' '.'23:59:59'])->count();
            $data['pending_tcket'] = VW_Ticket::Where('status_pending', 4)->whereBetween('entrydate', [$date_st.' '.'00:00:00', $date_nd.' '.'23:59:59'])->count();
        }
        return view('Pages.Report.chart')->with($data)->with('dt_now', $now)->with('st_dt', $date_st)->with('st_nd', $date_nd);
    }
    public function getDataMonthlyChart()
    {
        $data = Ticket::select(DB::raw('date(created_at) AS bulan'), DB::raw('COUNT(*) AS total_tiket'))
            ->whereBetween('created_at', [date('Y').'-01-01', date('Y').'-12-31'])
            ->groupBy(DB::raw('date(created_at)'))
            ->get();

        $chartData = [
            'series' => [
                [
                    'name' => 'Total Tiket',
                    'data' => $data->pluck('total_tiket')->toArray(),
                ]
            ],
            'xaxis' => [
                [
                    'type' => 'datetime',
                    'categories' => $data->pluck('bulan')->toArray(),
                ]
            ]
        ];

        return response()->json($chartData);
    }
    // KPI Report
    public function kpi(Request $request){
        $now = Carbon::now()->addHours(7)->format('Y-m-d');
        $oneMonthAgo = Carbon::parse($now)->subMonth(1)->format('Y-m-d');
        
        if (!isset($request->sort_kpi_project) && !isset($request->kpi_st_date_report) && !isset($request->kpi_nd_date_report)) {
            $data['report'] = VW_Act_Report_EN::where('status', 10)->whereBetween('entrydate', [$oneMonthAgo.' '.'00:00:00', $now.' '.'23:59:59'])->get();
            $data['total_ticket'] = VW_Act_Report_EN::selectRaw('*')
                                    ->fromSub(function ($query) {
                                        $query->select('*')
                                            ->from('vw_act_report_engineer')
                                            ->where('status', 10)
                                            ->groupBy('notiket');
                                    }, 'subquery')
                                    ->whereBetween('entrydate', [$oneMonthAgo.' '.'00:00:00', $now.' '.'23:59:59'])->count();
            $data['all_total'] = VW_Activity_Engineer::selectRaw('COUNT(*) AS onsite')
                                    ->fromSub(function ($query) {
                                        $query->select('*')
                                            ->from('vw_hgt_activity_engineer')
                                            ->whereIn('sts_timeline', [0, 1, 2])
                                            ->groupBy('notiket', 'sts_timeline');
                                    }, 'subquery')
                                    ->where('status', 10)
                                    ->whereBetween('entrydate', [$oneMonthAgo.' '.'00:00:00', $now.' '.'23:59:59'])
                                    ->first();
        } elseif(isset($request->sort_kpi_project) || isset($request->sort_kpi_en) || isset($request->kpi_st_date_report) || isset($request->kpi_nd_date_report)) {
            $data['report'] = VW_Act_Report_EN::where('status', 10)->where('project_id', 'LIKE','%'.$request->sort_kpi_project.'%')
                            ->where('nik', 'LIKE','%'.$request->sort_kpi_en.'%')
                            ->whereBetween('entrydate', [$request->kpi_st_date_report.' '.'00:00:00', $request->kpi_nd_date_report.' '.'23:59:59'])->get();
            $data['total_ticket'] = VW_Act_Report_EN::selectRaw('*')
                                    ->fromSub(function ($query) use($request) {
                                        $query->select('*')
                                            ->from('vw_act_report_engineer')
                                            ->where('status', 10)
                                            ->where('project_id', 'LIKE','%'.$request->sort_kpi_project.'%')
                                            ->where('nik', 'LIKE','%'.$request->sort_kpi_en.'%')
                                            ->groupBy('notiket');
                                    }, 'subquery')
                                    ->whereBetween('entrydate', [$request->kpi_st_date_report.' '.'00:00:00', $request->kpi_nd_date_report.' '.'23:59:59'])->count();
            $data['all_total'] = VW_Activity_Engineer::selectRaw('COUNT(*) AS onsite')
                                    ->fromSub(function ($query) {
                                        $query->select('*')
                                            ->from('vw_hgt_activity_engineer')
                                            ->whereIn('sts_timeline', [0, 1, 2])
                                            ->groupBy('notiket', 'sts_timeline');
                                    }, 'subquery')
                                    ->where('status', 10)
                                    ->where('project_id', 'LIKE','%'.$request->sort_kpi_project.'%')
                                    ->where('nik', 'LIKE','%'.$request->sort_kpi_en.'%')
                                    ->whereBetween('entrydate', [$request->kpi_st_date_report.' '.'00:00:00', $request->kpi_nd_date_report.' '.'23:59:59'])
                                    ->first();
        }
        $data['project'] = VW_ReportKPI::select('project_id', 'project_name')->groupBy('project_id')->get();
        $data['en'] = VW_ReportKPI::select('nik', 'full_name')->whereNotNull('nik')->groupBy('nik')->get();
        
        return view('Pages.Report.kpi')->with($data)
        ->with('stsd', $oneMonthAgo)
        ->with('nded', $now)
        ->with('str', $request->kpi_st_date_report)
        ->with('ndr', $request->kpi_nd_date_report)
        ->with('skp', $request->sort_kpi_project)
        ->with('ske', $request->sort_kpi_en);
    }
    
    public function export_kpi(Request $request)
    {        
        if (!isset($request->srt_kpi_prj) && !isset($request->srt_kpi_st) && !isset($request->srt_kpi_nd)) {
            $data_ticket = VW_Act_Report_EN::where('status', 10)->whereBetween('entrydate', [$request->srt_kpi_st.' '.'00:00:00', $request->srt_kpi_nd.' '.'23:59:59'])->get();
        }else{
            $data_ticket = VW_Act_Report_EN::where('status', 10)->where('project_id', 'LIKE','%'.$request->srt_kpi_prj.'%')->where('nik', 'LIKE','%'.$request->srt_kpi_en.'%')->whereBetween('entrydate', [$request->srt_kpi_st.' '.'00:00:00', $request->srt_kpi_nd.' '.'23:59:59'])->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Onsite',
            'Engineer',
            'Service Name',
            'Project',
            'Kabupaten',
            'Entry Date',
            'Receive',
            'Go',
            'Arrive',
            'Start Work',
            'Stop Work',
            'Leave Site',
            'Travel Stop',
            'Close Date'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        $style = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $style1 = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ];
        $sheet->getStyle("A1:P1")->applyFromArray($style);
        foreach ($data_ticket as $item) {
                $data = [
                    $no,
                    $item->notiket,
                    $item->OnSite,
                    $item->full_name,
                    $item->service_name,
                    $item->project_name,
                    $item->kab,
                    $item->entrydate,
                    $item->received,
                    $item->gow,
                    $item->arrived,
                    $item->work_start,
                    $item->work_stop,
                    $item->leave_site,
                    $item->travel_stop,
                    $item->closedate
                ];

                $sheet->fromArray([$data], NULL, "A$row");

                $sheet->getStyle("A$row:P$row")->applyFromArray($style1);

            $row++;
            $no++;
        }
        $filename = "Data Report Engineer.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function getTicketDetails($notiket)
    {
        $data['get_act_en'] = VW_Activity_Engineer::select('full_name', 'sts_timeline', 'act_description', 'sts_ticket', 'act_time')->where('notiket', $notiket)->get();
        $data['get_note'] = VW_Log_Note_Tiket::where('notiket', $notiket)->get();
        $data['get_enkpi_dt'] = VW_EnKPI_Detil::where('notiket', $notiket)->get();
        return view('Pages.Report.kpi-detil')->with($data);
    }
    // Lat Lng Report
    public function latlng(Request $request){
        $now = Carbon::now()->addHours(7);
        $oneMonthAgo = $now->copy()->subMonth(1);
        
        if (!isset($request->sort_ltlg_project) && !isset($request->ltlg_st_date_report) && !isset($request->ltlg_nd_date_report)) {
            $data['report'] = VW_Act_Report_EN::all()->where('status', 10)->where('project_id', $request->sort_ltlg_project)
                            ->whereBetween('entrydate', [$oneMonthAgo.' '.'00:00:00', $now.' '.'23:59:59']);
        } elseif(isset($request->sort_ltlg_project) || isset($request->ltlg_st_date_report) || isset($request->ltlg_nd_date_report)) {
            $data['report'] = VW_Act_Report_EN::where('status', 10)->where('project_id', 'LIKE','%'.$request->sort_ltlg_project.'%')
                            ->whereBetween('entrydate', [$request->ltlg_st_date_report.' '.'00:00:00', $request->ltlg_nd_date_report.' '.'23:59:59'])->get();
        }
        $data['project'] = VW_ReportKPI::select('project_id', 'project_name')->groupBy('project_name')->get();
        
        return view('Pages.Report.latlng')->with($data)
        ->with('stsd', $oneMonthAgo)
        ->with('nded', $now)
        ->with('str', $request->ltlg_st_date_report)
        ->with('ndr', $request->ltlg_nd_date_report)
        ->with('skp', $request->sort_ltlg_project);
    }
    public function export_latlng(Request $request)
    {        
        if (!isset($request->srt_latlng_prj) && !isset($request->srt_latlng_st) && !isset($request->srt_latlng_nd)) {
            $data_ticket = VW_Act_Report_EN::where('status', 10)->whereBetween('entrydate', [$request->srt_latlng_st.' '.'00:00:00', $request->srt_latlng_nd.' '.'23:59:59'])->get();
        }else{
            $data_ticket = VW_Act_Report_EN::where('status', 10)->where('project_id', 'LIKE','%'.$request->srt_latlng_prj.'%')->whereBetween('entrydate', [$request->srt_latlng_st.' '.'00:00:00', $request->srt_latlng_nd.' '.'23:59:59'])->get();
        }

        // function distance($lat1, $lng1, $lat2, $lng2) {
        //     $earth_radius = 6371; // kilometers
        //     $dLat = deg2rad($lat2 - $lat1);
        //     $dLng = deg2rad($lng2 - $lng1);
        //     $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng/2) * sin($dLng/2);
        //     $c = 2 * asin(sqrt($a));
        //     $distance = $earth_radius * $c;
        //     return $distance;
        // }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        // Set the table header
        $headerColumns = ['No', 'Notiket', 'Engineer', 'Project Name', 'Kab.', 'Received', '', 'Go', '', 'Arrived', '', 'Work Start', '', 'Work Stop', '', 'Leave Site', '', 'Travel Stop', ''];
        $sheet->fromArray($headerColumns, NULL, 'A1');
        
        // Set the 'Lat' and 'Lng' headers for each section
        $sections = ['Received', 'Go', 'Arrived', 'Work Start', 'Work Stop', 'Leave Site', 'Travel Stop'];
        $columnIndex = 6;
        
        foreach ($sections as $section) {
            $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'Lat');
            $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'Lng');
            
            // Merge cells for each section
            $mergeRange = $sheet->getCellByColumnAndRow($columnIndex - 2, 1)->getColumn() . '1:' . $sheet->getCellByColumnAndRow($columnIndex - 1, 1)->getColumn() . '1';
            $sheet->mergeCells($mergeRange);
        }
        
        // Merge cells for the remaining columns
        $mergeCells = ['A1:A2', 'B1:B2', 'C1:C2', 'D1:D2', 'E1:E2', 'P1:Q1', 'R1:S1'];
        
        foreach ($mergeCells as $mergeRange) {
            $sheet->mergeCells($mergeRange);
        }

        $no = 1;
        $row = 3;
        $style = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $style1 = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ];
        $sheet->getStyle("A1:S2")->applyFromArray($style);
        foreach ($data_ticket as $item) {
                $data = [
                    $no,
                    $item->notiket,
                    $item->full_name,
                    $item->project_name,
                    $item->kab,
                    $item->lat_receive,
                    $item->lng_receive,
                    $item->lat_gow,
                    $item->lng_gow,
                    $item->lat_arrive,
                    $item->lng_arrive,
                    $item->lat_ws,
                    $item->lng_ws,
                    $item->lat_wtp,
                    $item->lng_wtp,
                    $item->lat_ls,
                    $item->lng_ls,
                    $item->lat_ts,
                    $item->lng_ts
                ];

                $sheet->fromArray([$data], NULL, "A$row");

                $sheet->getStyle("A$row:S$row")->applyFromArray($style1);

            $row++;
            $no++;
        }
        $filename = "Distance Latitude & Longitude.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    
    // Activity Helpdesk
    public function ActHP(Request $request){
        $now = Carbon::now()->addHours(7)->format('Y-m-d');
        $data['user_hp'] = User::select('nik', 'full_name')->where('depart', 4)->get();
        if (!isset($request->srt_user_hp) && !isset($request->srt_st_date_act) && !isset($request->srt_nd_date_act)) {
            $data['act_hp'] = VW_Act_Heldepsk::whereBetween('created_at', [$now.' '.'00:00:00', $now.' '.'23:59:59'])
                            ->where('depart', 4)->get();
            $data['total_ticket'] = VW_Act_Heldepsk::selectRaw('COUNT(*) AS tot_all')
                                    ->fromSub(function ($query) use ($now) {
                                        $query->select('*')
                                            ->from('vw_hgt_act_helpdesk')
                                            ->whereBetween('created_at', [$now.' '.'00:00:00', $now.' '.'23:59:59'])
                                            ->where('depart', 4)
                                            ->groupBy('notiket', 'nik');
                                    }, 'subquery')->first();
            $data['all_act'] = VW_Act_Heldepsk::whereBetween('created_at', [$now.' '.'00:00:00', $now.' '.'23:59:59'])
                                ->where('depart', 4)->count();
            $data['get_user'] = DB::table(function ($query) use ($now) {
                                    $query->select('vhch.*')
                                    ->from('vw_hgt_act_helpdesk as vhch')
                                    ->leftJoin('hgt_ticket as ht', 'vhch.notiket', '=', 'ht.notiket')
                                    ->whereBetween('ht.created_at', [$now.' '.'00:00:00', $now.' '.'23:59:59'])
                                    ->groupBy('vhch.notiket');
                                }, 'g_ak')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS total_tiket'))
                                ->groupBy('nik')
                                ->get();
        } elseif(isset($request->srt_user_hp) || isset($request->srt_st_date_act) || isset($request->srt_nd_date_act)) {
            $data['act_hp'] = VW_Act_Heldepsk::where('nik', 'LIKE','%'.$request->srt_user_hp.'%')
                            ->whereBetween('created_at', [$request->srt_st_date_act.' '.'00:00:00', $request->srt_nd_date_act.' '.'23:59:59'])
                            ->where('depart', 4)->get();
            $data['total_ticket'] = VW_Act_Heldepsk::selectRaw('COUNT(*) AS tot_all')
                                    ->fromSub(function ($query) use ($request) {
                                        $query->select('*')
                                            ->from('vw_hgt_act_helpdesk')
                                            ->where('nik', 'LIKE','%'.$request->srt_user_hp.'%')
                                            ->whereBetween('created_at', [$request->srt_st_date_act.' '.'00:00:00', $request->srt_nd_date_act.' '.'23:59:59'])
                                            ->where('depart', 4)
                                            ->groupBy('notiket', 'nik');
                                    }, 'subquery')
                                    ->first();
            $data['all_act'] = VW_Act_Heldepsk::where('nik', 'LIKE','%'.$request->srt_user_hp.'%')
                            ->where('depart', 4)
                            ->whereBetween('created_at', [$request->srt_st_date_act.' '.'00:00:00', $request->srt_nd_date_act.' '.'23:59:59'])->count();
            $data['get_user'] = DB::table(function ($query) use ($request) {
                                    $query->select('vhch.*')
                                    ->from('vw_hgt_act_helpdesk as vhch')
                                    ->leftJoin('hgt_ticket as ht', 'vhch.notiket', '=', 'ht.notiket')
                                    ->whereBetween('ht.created_at', [$request->srt_st_date_act.' '.'00:00:00', $request->srt_nd_date_act.' '.'23:59:59'])
                                    ->groupBy('vhch.notiket');
                                }, 'g_ak')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS total_tiket'))
                                ->where('nik', 'LIKE','%'.$request->srt_user_hp.'%')
                                ->groupBy('nik')
                                ->orderBy('total_tiket', 'DESC')
                                ->get();
        }
        return view('Pages.Report.helpdesk')->with($data)
        ->with('now_dt', $now)
        ->with('st_dt', $request->srt_st_date_act)
        ->with('nd_dt', $request->srt_nd_date_act)
        ->with('user_dt', $request->srt_user_hp);
    }
    
    public function export_act_hp(Request $request)
    {        
        if (!isset($request->get_hp_act)) {
            $data_ticket = VW_Act_Heldepsk::whereBetween('created_at', [$request->get_stDt.' '.'00:00:00', $request->get_ndDT.' '.'23:59:59'])
                            ->where('depart', 4)->get();
        }else{
            $data_ticket = VW_Act_Heldepsk::where('nik', 'LIKE','%'.$request->get_hp_act.'%')
                            ->whereBetween('created_at', [$request->get_stDt.' '.'00:00:00', $request->get_ndDT.' '.'23:59:59'])
                            ->where('depart', 4)->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Type Note',
            'Note',
            'User',
            'Created At'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        $style = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_DOUBLE,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $style1 = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ]
        ];
        $sheet->getStyle("A1:F1")->applyFromArray($style);
        foreach ($data_ticket as $item) {
                $data = [
                    $no,
                    $item->notiket,
                    $item->ktgr_note,
                    $item->note,
                    $item->full_name,
                    $item->created_at
                ];

                $sheet->fromArray([$data], NULL, "A$row");

                $sheet->getStyle("A$row:F$row")->applyFromArray($style1);

            $row++;
            $no++;
        }
        $filename = "Data Report Activity Helpdesk.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    // Report History Ticket
    public function hisTicket(Request $request){
        $now = Carbon::now()->addHours(7);
        $oneMonthAgo = $now->copy()->subMonth(1);

            $data['project'] = ProjectInTicket::all();
        if (empty($request->st_date_his_report) && empty($request->nd_date_his_report)) {
            $tanggal1 = $oneMonthAgo;
            $tanggal2 = $now;
        } else {
            $tanggal1 = $request->st_date_his_report;
            $tanggal2 = $request->nd_date_his_report;
        }
        
        if (empty($request->prj_hs_report)) {
            $data['report'] = VW_ReportTicket::all()->where('status', 10)
                                ->whereBetween('entrydate', [$tanggal1, $tanggal2]);
        } elseif (!empty($request->prj_hs_report)) {
            $data['report'] = VW_ReportTicket::all()->where('status', 10)
                                ->where('project_id', $request->prj_hs_report)
                                ->whereBetween('entrydate', [$tanggal1, $tanggal2]);
        }
        
        return view('Pages.Report.history-ticket')->with($data)
        ->with('hs_prj', $request->prj_hs_report)
        ->with('tanggal1', $tanggal1)
        ->with('tanggal2', $tanggal2);
    }
    public function detHisTiket($notiket){

        $data['get_part'] = VW_Tiket_Part::where('notiket', $notiket)->get();
        $data['activity'] = VW_Act_Report_EN::where('status', 10)->where('notiket', $notiket)->get();
        
        return view('Pages.Report.history-detil')->with($data);
    }
    
    public function export_his_ticket(Request $request)
    {   
        if (empty($request->his_prj)) {
            $data_ticket = VW_Ticket::where('status', 10)
                                    ->whereBetween('entrydate', [$request->his_st.' '.'00:00:00', $request->his_nd.' '.'23:59:59'])->get();
        } else {
            $data_ticket = VW_Ticket::where('status', 10)
                                    ->where('project_id', $request->his_prj)
                                    ->whereBetween('entrydate', [$request->his_st.' '.'00:00:00', $request->his_nd.' '.'23:59:59'])->get();
        }
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Case ID',
            'Location',
            'Project',
            'Entry Date',
            'Email Coming',
            'Deadline',
            'Part Name',
            'Part Type',
            'Send',
            'ETA',
            'Arrive',
            'Full Name',
            'Receive',
            'Go',
            'Arrive',
            'Work Start',
            'Work Stop',
            'Leave Site',
            'Travel Stop',
            'Close Date'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($data_ticket as $item) {
            $rowspan_part = VW_Tiket_Part::where('notiket', $item->notiket)->count();
            $rowspan_are = VW_Act_Report_EN::where('status', 10)->where('notiket', $item->notiket)->count();
            $rowspan = max($rowspan_part, $rowspan_are, 1);
            $query_part = VW_Tiket_Part::where('notiket', $item->notiket)->get();
            $query_are = VW_Act_Report_EN::where('status', 10)->where('notiket', $item->notiket)->get();
            for ($i = 0; $i < $rowspan; $i++) {
                for ($a = 0; $a < 8; $a++) {
                    $col = $a < 7 ? chr(65 + $a) : chr(65 + floor($a / 7) - 1) . chr(65 + ($a % 7));
                    $sheet->mergeCells("$col$row:$col" . ($row + $rowspan - 1));
                }
                $sheet->mergeCells("U$row:U" . ($row + $rowspan - 1));

                $data = [
                    $no,
                    $item->notiket,
                    $item->case_id,
                    $item->severity_name,
                    $item->project_name,
                    $item->entrydate,
                    $item->deadline,
                        $query_part->isEmpty() || !$query_part->has($i) ? '' : $query_part[$i]->unit_name,
                        $query_part->isEmpty() || !$query_part->has($i) ? '' : $query_part[$i]->part_type,
                        $query_part->isEmpty() || !$query_part->has($i) ? '' : $query_part[$i]->send,
                        $query_part->isEmpty() || !$query_part->has($i) ? '' : $query_part[$i]->eta,
                        $query_part->isEmpty() || !$query_part->has($i) ? '' : $query_part[$i]->arrive,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->full_name,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->received,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->gow,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->arrived,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->work_start,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->work_stop,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->leave_site,
                        $query_are->isEmpty() || !$query_are->has($i) ? '' : $query_are[$i]->travel_stop,
                    $item->closedate
                ];

                $sheet->fromArray([$data], NULL, "A$row");
                $row++;
            }
            $no++;
        }
        $filename = "Data History Engineer.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function export_cnt_sla(Request $request)
    {       
        if (empty($request->hst_prj)) {
            $data_ticket = VW_ReportTicket::where('status', 10)
                                    ->whereBetween('entrydate', [$request->hst_st.' '.'00:00:00', $request->hst_nd.' '.'23:59:59'])->get();
        } else {
            $data_ticket = VW_ReportTicket::where('status', 10)
                                    ->where('project_id', $request->hst_prj)
                                    ->whereBetween('entrydate', [$request->hst_st.' '.'00:00:00', $request->hst_nd.' '.'23:59:59'])->get();
        }
        $notikets = $data_ticket->pluck('notiket')->unique()->toArray();
        $query_parts = VW_Tiket_Part::whereIn('notiket', $notikets)
            ->where('sts_type', 0)
            ->orderBy('send', 'DESC')
            ->orderBy('arrive', 'DESC')
            ->get()
            ->keyBy('notiket');

        $query_areas = VW_Act_Report_EN::whereIn('notiket', $notikets)
            ->where('status', 10)
            ->orderBy('visitting', 'DESC')
            ->get()
            ->keyBy('notiket');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'On Site',
            'Case ID',
            'Location',
            'Project',
            'Kota User',
            'Service Point',
            'Email Coming',
            'Entry Date',
            'SO',
            'Send',
            'ETA',
            'Arrive',
            'Go',
            'Work Start',
            'Work Stop'
        ];
        
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($data_ticket as $item) {
            $query_part = $query_parts->get($item->notiket);
            $query_are = $query_areas->get($item->notiket);

                $data = [
                    $no,
                    $item->notiket,
                    $item->total_onsite,
                    $item->case_id,
                    $item->severity_name,
                    $item->project_name,
                    $item->lok_kab,
                    $item->service_name,
                    $item->ticketcoming,
                    $item->entrydate,
                    @$query_part->so_num,
                    @$query_part->send,
                    @$query_part->eta,
                    @$query_part->arrive,
                    @$query_are->gow,
                    @$query_are->work_start,
                    @$query_are->work_stop,
                    $item->closedate
                ];

                $sheet->fromArray([$data], NULL, "A$row");
                $row++;
                $no++;
        }
        $filename = "Data Count SLA History Report.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    
    // Report Each Week
    public function eachWeek(Request $request){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $role = auth()->user()->role;
        if (empty($request->chosen_year) && empty($request->chosen_month)) {
            $get_year = $currentYear;
            $get_month = $currentMonth;
        } else {
            $get_year = $request->chosen_year;
            $get_month = $request->chosen_month;
        }
        
        if ($role == 15 || $role == 20) {
            $weeks = [
                'week1' => '1', 
                'week2' => '2',
                'week3' => '3',
                'week4' => '4',
                'week5' => '5'
            ];
            $compare_tt = DB::table(function ($query) use($get_year, $get_month) {
                                    $query->selectRaw("prt.partner, hp.project_id, hp.project_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cr_week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cr_week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cr_week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cr_week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS cr_week5")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
                                
            $compare_pt = DB::table(function ($query) use($get_year, $get_month) {
                                    $query->selectRaw("prt.partner, hp.project_id as pt_prj, hp.project_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS pn_week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS pn_week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS pn_week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS pn_week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS pn_week5")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("ht.status < 10")
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
            $compare_ct = DB::table(function ($query) use($get_year, $get_month) {
                                    $query->selectRaw("prt.partner, hp.project_id  AS ct_prj, hp.project_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS cl_week5")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("ht.status = 10")
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
            $coalesceColumns = [];

            foreach ($weeks as $week => $weekNumber) {
                $coalesceColumns[] = "COALESCE(cr_$week, 0) as total$weekNumber";
                $coalesceColumns[] = "COALESCE(pn_$week, 0) as pending$weekNumber";
                $coalesceColumns[] = "COALESCE(cl_$week, 0) as close$weekNumber";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $data['compare'] = DB::table(DB::raw("({$compare_tt}) AS ctt"))
                ->leftJoin(DB::raw("({$compare_pt}) AS cpt"), 'ctt.project_id', '=', 'cpt.pt_prj')
                ->leftJoin(DB::raw("({$compare_ct}) AS cct"), 'ctt.project_id', '=', 'cct.ct_prj')
                ->select(
                    'ctt.partner',
                    'ctt.project_name',
                    DB::raw($coalesceExpression)
                )
                ->groupBy("ctt.project_id")
                ->orderBy('ctt.project_name', 'ASC')->get();
        } 
        if ($role > 1) {
            $data['project'] = DB::table(function ($query) {
                                    $query->selectRaw("hpi.project_id, hp.project_name")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->groupBy("hpi.project_id")
                                        ->orderBy('hp.project_name', 'ASC');
                                })->get();
            if (empty($request->chosen_prj)) {
                $htSubquery = DB::table('hgt_ticket')
                    ->selectRaw("CASE
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 THEN 'Week 1'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 THEN 'Week 2'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 THEN 'Week 3'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 THEN 'Week 4'
                                    ELSE 'Week 5'
                                END AS timeframe,
                                COUNT(tiket_id) AS data_count")
                    ->whereRaw("YEAR(ticketcoming) = $get_year")
                    ->whereRaw("MONTH(ticketcoming) = $get_month")
                    ->groupBy("timeframe")
                    ->orderByRaw('MIN(ticketcoming)')
                    ->toSql();
                
                $data['total_entry'] = Ticket::whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->count();

                $tpdSubquery = DB::table('hgt_ticket')
                        ->selectRaw("CONCAT('Week ', FLOOR((DAY(ticketcoming) - 1) / 7) + 1) AS wn_pending, COUNT(*) AS count_pending")
                        ->whereRaw("YEAR(ticketcoming) = $get_year")
                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                        ->whereRaw("status < 10")
                        ->groupByRaw("FLOOR((DAY(ticketcoming) - 1) / 7)")
                        ->orderBy('wn_pending')
                        ->toSql();

                $data['total_pending'] = Ticket::whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->whereRaw("status < 10")
                                        ->count();

                $htcSubquery = DB::table('hgt_ticket')
                    ->selectRaw("CONCAT('Week ', FLOOR((DAY(ticketcoming) - 1) / 7) + 1) AS wn_close, COUNT(*) AS close_count")
                    ->whereRaw("YEAR(ticketcoming) = $get_year")
                    ->whereRaw("MONTH(ticketcoming) = $get_month")
                    ->whereRaw("status = 10")
                    ->groupByRaw("FLOOR((DAY(ticketcoming) - 1) / 7)")
                    ->orderBy('wn_close')
                    ->toSql();

                $data['total_close'] = Ticket::whereRaw("YEAR(ticketcoming) = $get_year")
                                        ->whereRaw("MONTH(ticketcoming) = $get_month")
                                        ->where("status", 10)
                                        ->count();
            } else {
                $htSubquery = DB::table(function ($query) use($get_year,$get_month, $request) {
                                    $query->selectRaw("CASE
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 THEN 'Week 1'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 THEN 'Week 2'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 THEN 'Week 3'
                                    WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 THEN 'Week 4'
                                    ELSE 'Week 5'
                                END AS timeframe,
                                COUNT(tiket_id) AS data_count")
                            ->from('hgt_ticket as ht')
                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                            ->whereRaw("hpi.project_id = '$request->chosen_prj'")
                            ->whereRaw("YEAR(ticketcoming) = $get_year")
                            ->whereRaw("MONTH(ticketcoming) = $get_month")
                            ->groupBy("timeframe")
                            ->orderByRaw('MIN(ticketcoming)');
                    })->toSql();

                $data['total_entry'] = DB::table(function ($query) use($get_year,$get_month, $request) {
                                        $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj'")
                                            ->whereRaw("YEAR(ticketcoming) = $get_year")
                                            ->whereRaw("MONTH(ticketcoming) = $get_month");
                                        })->count();
                                        
                $tpdSubquery = DB::table(function ($query) use($get_year,$get_month, $request) {
                                    $query->selectRaw("CONCAT('Week ', FLOOR((DAY(ticketcoming) - 1) / 7) + 1) AS wn_pending, COUNT(*) AS count_pending")
                                    ->from('hgt_ticket as ht')
                                    ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                    ->whereRaw("project_id = '$request->chosen_prj'")
                                    ->whereRaw("YEAR(ticketcoming) = $get_year")
                                    ->whereRaw("MONTH(ticketcoming) = $get_month")
                                    ->whereRaw("status < 10")
                                    ->groupByRaw("FLOOR((DAY(ticketcoming) - 1) / 7)")
                                    ->orderBy('wn_pending');
                                })->toSql();

                $data['total_pending'] = DB::table(function ($query) use($get_year,$get_month, $request) {
                                        $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj'")
                                            ->whereRaw("YEAR(ticketcoming) = $get_year")
                                            ->whereRaw("MONTH(ticketcoming) = $get_month")
                                            ->whereRaw("status < 10");
                                        })->count();

                $htcSubquery = DB::table(function ($query) use($get_year,$get_month, $request) {
                                    $query->selectRaw("CONCAT('Week ', FLOOR((DAY(ticketcoming) - 1) / 7) + 1) AS wn_close, COUNT(*) AS close_count")
                                    ->from('hgt_ticket as ht')
                                    ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                    ->whereRaw("project_id = '$request->chosen_prj'")
                                    ->whereRaw("YEAR(ticketcoming) = $get_year")
                                    ->whereRaw("MONTH(ticketcoming) = $get_month")
                                    ->whereRaw("status = 10")
                                    ->groupByRaw("FLOOR((DAY(ticketcoming) - 1) / 7)")
                                    ->orderBy('wn_close');
                                })->toSql();
                    
                $data['total_close'] = DB::table(function ($query) use($get_year,$get_month, $request) {
                                            $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj'")
                                            ->whereRaw("YEAR(ticketcoming) = $get_year")
                                            ->whereRaw("MONTH(ticketcoming) = $get_month")
                                            ->where("status", 10);
                                        })->count();
            }
            $data['eachWeek'] = DB::table(DB::raw("({$htSubquery}) AS ht"))
                                ->leftJoin(DB::raw("({$tpdSubquery}) AS tpd"), 'ht.timeframe', '=', 'tpd.wn_pending')
                                ->leftJoin(DB::raw("({$htcSubquery}) AS htc"), 'ht.timeframe', '=', 'htc.wn_close')
                                ->select('ht.*', 'tpd.count_pending AS pending', 'htc.close_count AS close_sum')
                                ->get();
        }
        $years = [];
        $months = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        // Get all months
        for ($month = 1; $month <= 12; $month++) {
            $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthName = Carbon::createFromDate(null, $month, 1)->format('F');
            $months[$monthNumber] = $monthName;
        }
        $getSort = [
            'loop_year' => $years,
            'loop_month' => $months,
        ];
        // Chart Data
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Entry',
                    'backgroundColor' => 'colors.primary',
                    'data' => []
                ],
                [
                    'label' => 'Pending',
                    'backgroundColor' => 'colors.warning',
                    'data' => []
                ],
                [
                    'label' => 'Close',
                    'backgroundColor' => 'colors.success',
                    'data' => []
                ]
            ]
        ];
        foreach ($data['eachWeek'] as $record) {
            $chartData['labels'][] = $record->timeframe;
            $chartData['datasets'][0]['data'][] = $record->data_count;
            $chartData['datasets'][1]['data'][] = $record->pending;
            $chartData['datasets'][2]['data'][] = $record->close_sum;
        }

        $colors = ['#36A2EB', '#FFCE56', '#FF6384'];
        foreach ($chartData['datasets'] as $index => $dataset) {
            $chartData['datasets'][$index]['backgroundColor'] = $colors[$index];
        }
        return view('Pages.Report.mwd', compact('chartData'))->with($data)
        ->with($getSort)
        ->with('cprj', $request->chosen_prj)
        ->with('year', $get_year)
        ->with('month', $get_month);
    }
    // Detil pending each week
    public function dtEWPending($timeframe,$project,$month,$year){
        if ($timeframe == 'Week 1') {
            $num1 = 1;
            $num2 = 7;
        } else if ($timeframe == 'Week 2'){
            $num1 = 8;
            $num2 = 14;
        } else if ($timeframe == 'Week 3'){
            $num1 = 15;
            $num2 = 21;
        } else if ($timeframe == 'Week 4'){
            $num1 = 22;
            $num2 = 28;
        }
        if ($project == 'null') {
            if ($timeframe != 'Week 5') {
                $data['pending'] = VW_Ticket::whereRaw("YEAR(ticketcoming) = $year")
                    ->whereRaw("MONTH(ticketcoming) = $month")
                    ->whereRaw("DAY(ticketcoming) BETWEEN $num1 AND $num2")
                    ->whereRaw("status < 10")
                    ->get();
            } else {
                $data['pending'] = VW_Ticket::whereRaw("YEAR(ticketcoming) = $year")
                    ->whereRaw("MONTH(ticketcoming) = $month")
                    ->whereRaw("DAY(ticketcoming) > 28")
                    ->whereRaw("status < 10")
                    ->get();
            }
        } else {
            if ($timeframe != 'Week 5') {
                $data['pending'] = VW_Ticket::whereRaw("YEAR(ticketcoming) = $year")
                    ->whereRaw("MONTH(ticketcoming) = $month")
                    ->whereRaw("DAY(ticketcoming) BETWEEN $num1 AND $num2")
                    ->whereRaw("status < 10")
                    ->where("project_id", $project)
                    ->get();
            } else {
                $data['pending'] = VW_Ticket::whereRaw("YEAR(ticketcoming) = $year")
                    ->whereRaw("MONTH(ticketcoming) = $month")
                    ->whereRaw("DAY(ticketcoming) > 28")
                    ->whereRaw("status < 10")
                    ->where("project_id", $project)
                    ->get();
            }
        }

        return view('Pages.Report.DT.detil-each-ticket')->with($data)
        ->with('timeframe', $timeframe)
        ->with('month', $month)
        ->with('year', $year);
    }
    // Report Each Month
    public function eachMonth(Request $request){
        $currentYear = Carbon::now()->year;
        
        $role = auth()->user()->role;
        $depart = auth()->user()->depart;
        if (empty($request->chosen_year_em)) {
            $sort_year = $currentYear;
        } else {
            $sort_year = $request->chosen_year_em;
        }

        if ($role == 15 || $role == 20) {
            $months = [
                'jan' => '1', 
                'feb' => '2',
                'march' => '3',
                'april' => '4',
                'may' => '5',
                'june' => '6',
                'july' => '7',
                'aug' => '8',
                'sept' => '9',
                'october' => '10',
                'nov' => '11',
                'december' => '12'
            ];

            $compare_tt = DB::table(function ($query) use($sort_year) {
                                    $query->selectRaw("prt.partner, hpi.project_id, hp.project_name,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS cr_jan,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS cr_feb,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS cr_march,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS cr_april,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS cr_may,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS cr_june,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS cr_july,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS cr_aug,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS cr_sept,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS cr_october,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS cr_nov,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS cr_december")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
            $compare_pt = DB::table(function ($query) use($sort_year) {
                                    $query->selectRaw("hpi.project_id as pt_prj,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS pn_jan,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS pn_feb,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS pn_march,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS pn_april,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS pn_may,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS pn_june,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS pn_july,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS pn_aug,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS pn_sept,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS pn_october,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS pn_nov,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS pn_december")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("ht.status < 10")
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
            $compare_ct = DB::table(function ($query) use($sort_year) {
                                    $query->selectRaw("hpi.project_id AS ct_prj,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS cl_jan,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS cl_feb,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS cl_march,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS cl_april,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS cl_may,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS cl_june,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS cl_july,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS cl_aug,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS cl_sept,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS cl_october,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS cl_nov,
                                            SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS cl_december")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                        ->whereRaw("ht.status = 10")
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->groupBy("hpi.project_id");
                                })->toSql();
                                
            $coalesceColumns = [];

            foreach ($months as $month => $monthNumber) {
                $coalesceColumns[] = "COALESCE(cr_$month, 0) as total$monthNumber";
                $coalesceColumns[] = "COALESCE(pn_$month, 0) as pending$monthNumber";
                $coalesceColumns[] = "COALESCE(cl_$month, 0) as close$monthNumber";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $data['compare'] = DB::table(DB::raw("({$compare_tt}) AS ctt"))
                ->leftJoin(DB::raw("({$compare_pt}) AS cpt"), 'ctt.project_id', '=', 'cpt.pt_prj')
                ->leftJoin(DB::raw("({$compare_ct}) AS cct"), 'ctt.project_id', '=', 'cct.ct_prj')
                ->select(
                    'ctt.partner',
                    'ctt.project_name',
                    DB::raw($coalesceExpression)
                )
                ->groupBy("ctt.project_id")
                ->orderBy('ctt.project_name', 'ASC')->get();
        }

        if ($role > 1) {
            $data['project'] = DB::table(function ($query) {
                                    $query->selectRaw("hpi.project_id, hp.project_name")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->groupBy("hpi.project_id")
                                        ->orderBy('hp.project_name', 'ASC');
                                })->get();
            if (empty($request->chosen_prj_em)) {
                $htSubquery = DB::table('hgt_ticket')
                            ->selectRaw("DATE_FORMAT(ticketcoming, '%c') AS month_number, DATE_FORMAT(ticketcoming, '%M') AS month_name, COUNT(tiket_id) AS data_count")
                            ->whereRaw("YEAR(ticketcoming) = $sort_year")
                            ->groupBy("month_name")
                            ->toSql();
                $data['total_entry'] = Ticket::whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->count();
                $tpdSubquery = DB::table('hgt_ticket')
                            ->selectRaw("DATE_FORMAT(ticketcoming, '%M') AS mn_pending, COUNT(tiket_id) AS mb_pending_count")
                            ->whereRaw("YEAR(ticketcoming) = $sort_year")
                            ->whereRaw("status < 10")
                            ->groupBy("mn_pending")
                            ->toSql();

                $data['total_pending'] = Ticket::whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->whereRaw("status < 10")
                                        ->count();

                $htcSubquery = DB::table('hgt_ticket')
                            ->selectRaw("DATE_FORMAT(ticketcoming, '%M') AS mn_close, COUNT(tiket_id) AS mn_closecount")
                            ->whereRaw("YEAR(ticketcoming) = $sort_year")
                            ->whereRaw("status = 10")
                            ->groupBy("mn_close")
                            ->toSql();

                $data['total_close'] = Ticket::whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->where("status", 10)
                                        ->count();
            } else {
                $htSubquery = DB::table(function ($query) use($sort_year, $request) {
                                    $query->selectRaw("DATE_FORMAT(ticketcoming, '%c') AS month_number, DATE_FORMAT(ticketcoming, '%M') AS month_name, COUNT(tiket_id) AS data_count")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->whereRaw("project_id = '$request->chosen_prj_em'")
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->groupBy("month_name");
                                })->toSql();

                $data['total_entry'] = DB::table(function ($query) use($sort_year, $request) {
                                            $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj_em'")
                                            ->whereRaw("YEAR(ticketcoming) = $sort_year");
                                        })->count();

                $tpdSubquery = DB::table(function ($query) use($sort_year, $request) {
                                    $query->selectRaw("DATE_FORMAT(ticketcoming, '%M') AS mn_pending, COUNT(tiket_id) AS mb_pending_count")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->whereRaw("project_id = '$request->chosen_prj_em'")
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->whereRaw("status < 10")
                                        ->groupBy("mn_pending");
                                })->toSql();

                $data['total_pending'] = DB::table(function ($query) use($sort_year, $request) {
                                            $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj_em'")
                                            ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                            ->whereRaw("status < 10");
                                        })->count();

                $htcSubquery = DB::table(function ($query) use($sort_year, $request) {
                                    $query->selectRaw("DATE_FORMAT(ticketcoming, '%M') AS mn_close, COUNT(tiket_id) AS mn_closecount")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->whereRaw("project_id = '$request->chosen_prj_em'")
                                        ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                        ->whereRaw("status = 10")
                                        ->groupBy("mn_close");
                                })->toSql();

                $data['total_close'] = DB::table(function ($query) use($sort_year, $request) {
                                            $query->select('tiket_id')
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->whereRaw("project_id = '$request->chosen_prj_em'")
                                            ->whereRaw("YEAR(ticketcoming) = $sort_year")
                                            ->where("status", 10);
                                        })->count();
            }

            $data['eachMonth'] = DB::table(DB::raw("({$htSubquery}) AS ht"))
                                ->leftJoin(DB::raw("({$tpdSubquery}) AS tpd"), 'ht.month_name', '=', 'tpd.mn_pending')
                                ->leftJoin(DB::raw("({$htcSubquery}) AS htc"), 'ht.month_name', '=', 'htc.mn_close')
                                ->select('ht.*', 'tpd.mb_pending_count AS pending', 'htc.mn_closecount AS close_sum')
                                ->get();
        }
        $years = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        $getSort = [
            'loop_year' => $years,
        ];

        return view('Pages.Report.emd')->with($data)->with($getSort)
        ->with('prj_em', $request->chosen_prj_em)
        ->with('year', $sort_year);
    }
        public function export_wmly_tc(Request $request, $tfr){
            if ($tfr == 'Weekly') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ]; 
                $compare_tt = DB::table(function ($query) use($request) {
                                        $query->selectRaw("prt.partner, hp.project_id, hp.project_name,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cr_week1,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cr_week2,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cr_week3,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cr_week4,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS cr_week5")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("YEAR(ticketcoming) = $request->year_wkl_tc")
                                            ->whereRaw("MONTH(ticketcoming) = $request->month_wkl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
                                    
                $compare_pt = DB::table(function ($query) use($request) {
                                        $query->selectRaw("prt.partner, hp.project_id as pt_pid, hp.project_name as pt_prj,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS pn_week1,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS pn_week2,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS pn_week3,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS pn_week4,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS pn_week5")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("ht.status < 10")
                                            ->whereRaw("YEAR(ticketcoming) = $request->year_wkl_tc")
                                            ->whereRaw("MONTH(ticketcoming) = $request->month_wkl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
                $compare_ct = DB::table(function ($query) use($request) {
                                        $query->selectRaw("prt.partner, hp.project_id  as ct_pid, hp.project_name AS ct_prj,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM ticketcoming) >28 then 1 ELSE 0 END) AS cl_week5")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("ht.status = 10")
                                            ->whereRaw("YEAR(ticketcoming) = $request->year_wkl_tc")
                                            ->whereRaw("MONTH(ticketcoming) = $request->month_wkl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_tt = DB::table(function ($query) use($request) {
                                        $query->selectRaw("ht.notiket, prt.partner, hpi.project_id, hp.project_name,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS cr_jan,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS cr_feb,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS cr_march,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS cr_april,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS cr_may,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS cr_june,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS cr_july,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS cr_aug,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS cr_sept,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS cr_october,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS cr_nov,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS cr_december")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("YEAR(ticketcoming) = $request->yr_mtl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
                $compare_pt = DB::table(function ($query) use($request) {
                                        $query->selectRaw("hpi.project_id as pt_pid,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS pn_jan,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS pn_feb,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS pn_march,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS pn_april,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS pn_may,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS pn_june,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS pn_july,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS pn_aug,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS pn_sept,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS pn_october,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS pn_nov,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS pn_december")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("ht.status < 10")
                                            ->whereRaw("YEAR(ticketcoming) = $request->yr_mtl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
                $compare_ct = DB::table(function ($query) use($request) {
                                        $query->selectRaw("hpi.project_id as ct_pid,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 1 then 1 ELSE 0 END) AS cl_jan,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 2 then 1 ELSE 0 END) AS cl_feb,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 3 then 1 ELSE 0 END) AS cl_march,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 4 then 1 ELSE 0 END) AS cl_april,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 5 then 1 ELSE 0 END) AS cl_may,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 6 then 1 ELSE 0 END) AS cl_june,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 7 then 1 ELSE 0 END) AS cl_july,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 8 then 1 ELSE 0 END) AS cl_aug,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 9 then 1 ELSE 0 END) AS cl_sept,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 10 then 1 ELSE 0 END) AS cl_october,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 11 then 1 ELSE 0 END) AS cl_nov,
                                                SUM(CASE WHEN MONTH(ticketcoming) = 12 then 1 ELSE 0 END) AS cl_december")
                                            ->from('hgt_ticket as ht')
                                            ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                            ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                            ->leftJoin('hgt_partner as prt', 'hp.partner_id', '=', 'prt.partner_id')
                                            ->whereRaw("ht.status = 10")
                                            ->whereRaw("YEAR(ticketcoming) = $request->yr_mtl_tc")
                                            ->groupBy("hpi.project_id");
                                    })->toSql();
            }
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(cr_$desc, 0) as total$number";
                $coalesceColumns[] = "COALESCE(pn_$desc, 0) as pending$number";
                $coalesceColumns[] = "COALESCE(cl_$desc, 0) as close$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $queryTFRtc = DB::table(DB::raw("({$compare_tt}) AS ctt"))
                ->leftJoin(DB::raw("({$compare_pt}) AS cpt"), 'ctt.project_id', '=', 'cpt.pt_pid')
                ->leftJoin(DB::raw("({$compare_ct}) AS cct"), 'ctt.project_id', '=', 'cct.ct_pid')
                ->select(
                    'ctt.partner',
                    'ctt.project_name',
                    DB::raw($coalesceExpression)
                )
                ->orderBy('ctt.project_name', 'ASC')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            
            if ($tfr == 'Weekly') {
                $headers = ['No', 'Partner', 'Project', 'Week 1', '', '', 'Week 2', '', '', 'Week 3', '', '', 'Week 4', '', '', 'Week 5', '', ''];
                $sections = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                $excelName = 'Summary Weekly Ticket';
            } else {
                $headers = [
                    'No', 
                    'Partner',
                    'Project', 
                    'Januari', '', '',
                    'Februari','', '', 
                    'March', '', '',
                    'April', '', '',
                    'May', '', '',
                    'June', '', '',
                    'July', '', '',
                    'August', '', '',
                    'September', '', '',
                    'October', '', '',
                    'November', '', '',
                    'December', '', ''];
                $sections = [
                    'Januari', 
                    'Februari', 
                    'March', 
                    'April', 
                    'May', 
                    'June', 
                    'July', 
                    'August', 
                    'September', 
                    'October', 
                    'November', 
                    'December'
                ];
                $excelName = 'Summary Monthly Ticket';
            }

            $sheet->fromArray([$headers], NULL, 'A1');

            $columnIndex = 4;
            foreach ($sections as $section) {
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CR');
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'PN');
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CL');
            
                $mergeRange = $sheet->getCellByColumnAndRow($columnIndex - 3, 1)->getColumn() . '1:' . $sheet->getCellByColumnAndRow($columnIndex - 1, 1)->getColumn() . '1';
                $sheet->mergeCells($mergeRange);
            }
            
            $mergeCells = ['A1:A2', 'B1:B2', 'C1:C2'];
            
            foreach ($mergeCells as $mergeRange) {
                $sheet->mergeCells($mergeRange);
            }
            $no = 1;
            $row = 3;
            foreach ($queryTFRtc as $item) {
                if ($tfr == 'Weekly') {
                    $data = [
                        $no,
                        $item->partner,
                        $item->project_name,
                        $item->total1,
                        $item->pending1,
                        $item->close1,
                        $item->total2,
                        $item->pending2,
                        $item->close2,
                        $item->total3,
                        $item->pending3,
                        $item->close3,
                        $item->total4,
                        $item->pending4,
                        $item->close4,
                        $item->total5,
                        $item->pending5,
                        $item->close5
                    ];
                }else{
                    $data = [
                        $no,
                        $item->partner,
                        $item->project_name,
                        $item->total1,
                        $item->pending1,
                        $item->close1,
                        $item->total2,
                        $item->pending2,
                        $item->close2,
                        $item->total3,
                        $item->pending3,
                        $item->close3,
                        $item->total4,
                        $item->pending4,
                        $item->close4,
                        $item->total5,
                        $item->pending5,
                        $item->close5,
                        $item->total6,
                        $item->pending6,
                        $item->close6,
                        $item->total7,
                        $item->pending7,
                        $item->close7,
                        $item->total8,
                        $item->pending8,
                        $item->close8,
                        $item->total9,
                        $item->pending9,
                        $item->close9,
                        $item->total10,
                        $item->pending10,
                        $item->close10,
                        $item->total11,
                        $item->pending11,
                        $item->close11,
                        $item->total12,
                        $item->pending12,
                        $item->close12,
                    ];
                }
                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                $no++;
            }
            $filename = "$excelName.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    // Detil pending each Month
    public function dtEMPending($timeframe,$project,$year){
        if ($timeframe == 1) {
            $month = 'Januari';
        } elseif ($timeframe == 2) {
            $month = 'Februari';
        } elseif ($timeframe == 3) {
            $month = 'March';
        } elseif ($timeframe == 4) {
            $month = 'April';
        } elseif ($timeframe == 5) {
            $month = 'Mei';
        } elseif ($timeframe == 6) {
            $month = 'June';
        } elseif ($timeframe == 7) {
            $month = 'July';
        } elseif ($timeframe == 8) {
            $month = 'August';
        } elseif ($timeframe == 9) {
            $month = 'September';
        } elseif ($timeframe == 10) {
            $month = 'October';
        } elseif ($timeframe == 11) {
            $month = 'November';
        } elseif ($timeframe == 12) {
            $month = 'December';
        }
        
        if ($project == 'null') {
            $data['pending'] = Ticketing::whereRaw("YEAR(ticketcoming) = $year")
                ->whereRaw("MONTH(ticketcoming) = $timeframe")
                ->whereRaw("status < 10")
                ->get();
        } else {
            $data['pending'] = Ticketing::whereRaw("YEAR(ticketcoming) = $year")
                ->whereRaw("MONTH(ticketcoming) = $timeframe")
                ->whereRaw("status < 10")
                ->where("project_id", $project)
                ->get();
        }

        return view('Pages.Report.DT.detil-each-ticket')->with($data)
        ->with('timeframe', $month)
        ->with('year', $year);
    }
    // Report Each Week SP
    public function eachWeekSP(Request $request,$vdt){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $role = auth()->user()->role;
        if (empty($request->chosen_yearSP) && empty($request->chosen_monthSP)) {
            $get_year = $currentYear;
            $get_month = $currentMonth;
        } else {
            $get_year = $request->chosen_yearSP;
            $get_month = $request->chosen_monthSP;
        }
        if ($role == 15 || $role == 20) {
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ];
                
                $compare_ct = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cr_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cr_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cr_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cr_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS cr_week5")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->whereRaw("MONTH(entrydate) = $get_month")
                            ->groupBy("service_point")
                            ->toSql();

                $compare_pn = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS pn_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS pn_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS pn_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS pn_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS pn_week5")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->whereRaw("MONTH(entrydate) = $get_month")
                            ->whereRaw("status < 10")
                            ->groupBy("service_point")
                            ->toSql();
                            
                $compare_cl = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS cl_week5")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->whereRaw("MONTH(entrydate) = $get_month")
                            ->whereRaw("status = 10")
                            ->groupBy("service_point")
                            ->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_ct = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS cr_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS cr_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS cr_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS cr_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS cr_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS cr_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS cr_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS cr_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS cr_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS cr_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS cr_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS cr_december")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->groupBy("service_point")
                            ->toSql();

                $compare_pn = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS pn_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS pn_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS pn_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS pn_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS pn_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS pn_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS pn_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS pn_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS pn_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS pn_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS pn_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS pn_december")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->whereRaw("status < 10")
                            ->groupBy("service_point")
                            ->toSql();
                            
                $compare_cl = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS cl_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS cl_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS cl_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS cl_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS cl_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS cl_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS cl_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS cl_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS cl_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS cl_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS cl_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS cl_december")
                            ->whereRaw("YEAR(entrydate) = $get_year")
                            ->whereRaw("status = 10")
                            ->groupBy("service_point")
                            ->toSql();
            }
            
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(cr_$desc, 0) as total$number";
                $coalesceColumns[] = "COALESCE(pn_$desc, 0) as pending$number";
                $coalesceColumns[] = "COALESCE(cl_$desc, 0) as close$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $data['compare'] = DB::table(DB::raw("({$compare_ct}) AS cct"))
                ->leftJoin(DB::raw("({$compare_pn}) AS cpn"), 'cct.sp', '=', 'cpn.sp')
                ->leftJoin(DB::raw("({$compare_cl}) AS ccl"), 'cct.sp', '=', 'ccl.sp')
                ->leftJoin('hgt_service_point as hsp', 'cct.sp', '=', 'hsp.service_id')
                ->select(
                    'hsp.service_name',
                    DB::raw($coalesceExpression)
            )->get();
        }
        if ($role > 1) {
            $data['office'] = DB::table(function ($query) {
                                    $query->selectRaw("ht.service_point as service_id, sp.service_name")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_service_point as sp', 'ht.service_point', '=', 'sp.service_id')
                                        ->whereNotNull('ht.service_point')
                                        ->groupBy("ht.service_point")
                                        ->orderBy('sp.service_name', 'ASC');
                                })->get();
            if (empty($request->chosen_ewSP)) {
                if ($vdt == 'Week') {
                    $htSubquery = DB::table('hgt_ticket')
                        ->selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(tiket_id) AS data_count")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->groupBy("timeframe")
                        ->orderByRaw('MIN(entrydate)')
                        ->toSql();
                    
                    $data['total_entry'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->count();

                    $tpdSubquery = DB::table('hgt_ticket')
                        ->selectRaw("CONCAT('Week ', FLOOR((DAY(entrydate) - 1) / 7) + 1) AS wn_pending, COUNT(*) AS count_pending")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->whereRaw("status < 10")
                        ->groupByRaw("FLOOR((DAY(entrydate) - 1) / 7)")
                        ->orderBy('wn_pending')
                        ->toSql();

                    $data['total_pending'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->whereRaw("status < 10")
                                            ->count();

                    $htcSubquery = DB::table('hgt_ticket')
                        ->selectRaw("CONCAT('Week ', FLOOR((DAY(entrydate) - 1) / 7) + 1) AS wn_close, COUNT(*) AS close_count")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->whereRaw("status = 10")
                        ->groupByRaw("FLOOR((DAY(entrydate) - 1) / 7)")
                        ->orderBy('wn_close')
                        ->toSql();

                    $data['total_close'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->where("status", 10)
                                            ->count();
                } else {
                    $htSubquery = DB::table('hgt_ticket')
                        ->selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->groupBy("timeframe")
                        ->orderByRaw('MIN(entrydate)')
                        ->toSql();
                    
                    $data['total_entry'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->count();

                    $tpdSubquery = DB::table('hgt_ticket')
                        ->selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS wn_pending, COUNT(notiket) AS count_pending")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("status < 10")
                        ->groupBy("wn_pending")
                        ->orderBy('wn_pending')
                        ->toSql();

                    $data['total_pending'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("status < 10")
                                            ->count();

                    $htcSubquery = DB::table('hgt_ticket')
                        ->selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS wn_close, COUNT(notiket) AS close_count")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("status = 10")
                        ->groupBy("wn_close")
                        ->orderBy('wn_close')
                        ->toSql();

                    $data['total_close'] = Ticket::whereRaw("YEAR(entrydate) = $get_year")
                                            ->where("status", 10)
                                            ->count();
                }
            } else {
                if ($vdt == 'Week') {
                    $htSubquery = Ticket::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(tiket_id) AS data_count")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->groupBy("timeframe")
                        ->orderByRaw('MIN(entrydate)')
                        ->toSql();

                    $data['total_entry'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->count();
                                            
                    $tpdSubquery = Ticket::selectRaw("CONCAT('Week ', FLOOR((DAY(entrydate) - 1) / 7) + 1) AS wn_pending, COUNT(*) AS count_pending")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->whereRaw("status < 10")
                        ->groupByRaw("FLOOR((DAY(entrydate) - 1) / 7)")
                        ->orderBy('wn_pending')
                        ->toSql();

                    $data['total_pending'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->whereRaw("status < 10")
                                            ->count();

                    $htcSubquery = Ticket::selectRaw("CONCAT('Week ', FLOOR((DAY(entrydate) - 1) / 7) + 1) AS wn_close, COUNT(*) AS close_count")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->whereRaw("status = 10")
                        ->groupByRaw("FLOOR((DAY(entrydate) - 1) / 7)")
                        ->orderBy('wn_close')
                        ->toSql();
                        
                    $data['total_close'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("MONTH(entrydate) = $get_month")
                                            ->where("status", 10)
                                            ->count();
                } else {
                    $htSubquery = Ticket::selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->groupBy("timeframe")
                        ->orderByRaw('MIN(entrydate)')
                        ->toSql();

                    $data['total_entry'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->count();
                                            
                    $tpdSubquery = Ticket::selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS wn_pending, COUNT(notiket) AS count_pending")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->whereRaw("status < 10")
                        ->groupByRaw("wn_pending")
                        ->orderBy('wn_pending')
                        ->toSql();

                    $data['total_pending'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->whereRaw("status < 10")
                                            ->count();

                    $htcSubquery = Ticket::selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS wn_close, COUNT(notiket) AS close_count")
                        ->whereRaw("service_point = '$request->chosen_ewSP'")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("status = 10")
                        ->groupByRaw("wn_close")
                        ->orderBy('wn_close')
                        ->toSql();
                        
                    $data['total_close'] = Ticket::whereRaw("service_point = '$request->chosen_ewSP'")
                                            ->whereRaw("YEAR(entrydate) = $get_year")
                                            ->where("status", 10)
                                            ->count();
                
                }
                }
            $data['eachWeek'] = DB::table(DB::raw("({$htSubquery}) AS ht"))
                                ->leftJoin(DB::raw("({$tpdSubquery}) AS tpd"), 'ht.timeframe', '=', 'tpd.wn_pending')
                                ->leftJoin(DB::raw("({$htcSubquery}) AS htc"), 'ht.timeframe', '=', 'htc.wn_close')
                                ->select('ht.*', 'tpd.count_pending AS pending', 'htc.close_count AS close_sum')
                                ->get();
        }
        $years = [];
        $months = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        // Get all months
        for ($month = 1; $month <= 12; $month++) {
            $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthName = Carbon::createFromDate(null, $month, 1)->format('F');
            $months[$monthNumber] = $monthName;
        }
        $getSort = [
            'loop_year' => $years,
            'loop_month' => $months,
        ];

        return view('Pages.Report.ew-SP')->with($data)
        ->with($getSort)
        ->with('vdt', $vdt)
        ->with('ewSP', $request->chosen_ewSP)
        ->with('year', $get_year)
        ->with('month', $get_month);
    }
    // Detil pending each week
    public function dtSPPending($vdt,$timeframe,$sp,$month,$year){
        if ($timeframe == 'Week 1') {
            $num1 = 1;
            $num2 = 7;
        } else if ($timeframe == 'Week 2'){
            $num1 = 8;
            $num2 = 14;
        } else if ($timeframe == 'Week 3'){
            $num1 = 15;
            $num2 = 21;
        } else if ($timeframe == 'Week 4'){
            $num1 = 22;
            $num2 = 28;
        }
        if ($vdt == 'Week') {
            if ($month == 1) {
                $get_month = 'Januari';
            } elseif ($month == 2) {
                $get_month = 'Februari';
            } elseif ($month == 3) {
                $get_month = 'March';
            } elseif ($month == 4) {
                $get_month = 'April';
            } elseif ($month == 5) {
                $get_month = 'Mei';
            } elseif ($month == 6) {
                $get_month = 'June';
            } elseif ($month == 7) {
                $get_month = 'July';
            } elseif ($month == 8) {
                $get_month = 'August';
            } elseif ($month == 9) {
                $get_month = 'September';
            } elseif ($month == 10) {
                $get_month = 'October';
            } elseif ($month == 11) {
                $get_month = 'November';
            } elseif ($month == 12) {
                $get_month = 'December';
            }
            if ($sp == 'null') {
                if ($timeframe != 'Week 5') {
                    $data['eachSPCreated'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPPending'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2")
                                                        ->whereRaw("status < 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPClosed'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2")
                                                        ->whereRaw("status = 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                                ->groupBy('service_id')
                                                ->get();
                } else {
                    $data['eachSPCreated'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPPending'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28")
                                                        ->whereRaw("status < 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPClosed'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28")
                                                        ->whereRaw("status = 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                                ->groupBy('service_id')
                                                ->get();
                }
            } else {
                if ($timeframe != 'Week 5') {
                    $data['eachSPCreated'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPPending'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2")
                                                        ->whereRaw("status < 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPClosed'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) BETWEEN $num1 AND $num2")
                                                        ->whereRaw("status = 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                } else {
                    $data['eachSPCreated'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPPending'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28")
                                                        ->whereRaw("status < 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                    $data['eachSPClosed'] = DB::table(function ($query) use ($year, $month) {
                                                    $query->select('*')
                                                        ->from('vw_hgt_ticket')
                                                        ->whereRaw("YEAR(entrydate) = $year")
                                                        ->whereRaw("MONTH(entrydate) = $month")
                                                        ->whereRaw("DAY(entrydate) > 28")
                                                        ->whereRaw("status = 10");
                                                }, 'subquery')
                                                ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                                ->where("service_id", $sp)
                                                ->groupBy('service_id')
                                                ->get();
                }
            }
        } else {
            if ($timeframe == 1) {
                $get_month = 'Januari';
            } elseif ($timeframe == 2) {
                $get_month = 'Februari';
            } elseif ($timeframe == 3) {
                $get_month = 'March';
            } elseif ($timeframe == 4) {
                $get_month = 'April';
            } elseif ($timeframe == 5) {
                $get_month = 'Mei';
            } elseif ($timeframe == 6) {
                $get_month = 'June';
            } elseif ($timeframe == 7) {
                $get_month = 'July';
            } elseif ($timeframe == 8) {
                $get_month = 'August';
            } elseif ($timeframe == 9) {
                $get_month = 'September';
            } elseif ($timeframe == 10) {
                $get_month = 'October';
            } elseif ($timeframe == 11) {
                $get_month = 'November';
            } elseif ($timeframe == 12) {
                $get_month = 'December';
            }
            if ($sp == 'null') {
                $data['eachSPCreated'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                            ->groupBy('service_id')
                                            ->get();
                $data['eachSPPending'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe")
                                                    ->whereRaw("status < 10");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                            ->groupBy('service_id')
                                            ->get();
                $data['eachSPClosed'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe")
                                                    ->whereRaw("status = 10");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                            ->groupBy('service_id')
                                            ->get();
            }else{
                $data['eachSPCreated'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_tiket'))
                                            ->where("service_id", $sp)
                                            ->groupBy('service_id')
                                            ->get();
                $data['eachSPPending'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe")
                                                    ->whereRaw("status < 10");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_pending'))
                                            ->where("service_id", $sp)
                                            ->groupBy('service_id')
                                            ->get();
                $data['eachSPClosed'] = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_hgt_ticket')
                                                    ->whereRaw("YEAR(entrydate) = $year")
                                                    ->whereRaw("MONTH(entrydate) = $timeframe")
                                                    ->whereRaw("status = 10");
                                            }, 'subquery')
                                            ->select('service_id', 'service_name', DB::raw('COUNT(*) AS total_closed'))
                                            ->where("service_id", $sp)
                                            ->groupBy('service_id')
                                            ->get();
            }
        }
        return view('Pages.Report.DT.detil-each-sp')->with($data)
        ->with('vdt', $vdt)
        ->with('timeframe', $timeframe)
        ->with('month', $get_month)
        ->with('year', $year);
    }
        public function export_wmly_sp(Request $request, $vdt){
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ]; 
                $compare_ct = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cr_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cr_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cr_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cr_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS cr_week5")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->whereRaw("MONTH(entrydate) = $request->month_wkl_sp")
                            ->groupBy("service_point")
                            ->toSql();

                $compare_pn = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS pn_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS pn_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS pn_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS pn_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS pn_week5")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->whereRaw("MONTH(entrydate) = $request->month_wkl_sp")
                            ->whereRaw("status < 10")
                            ->groupBy("service_point")
                            ->toSql();
                            
                $compare_cl = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM entrydate) > 28 then 1 ELSE 0 END) AS cl_week5")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->whereRaw("MONTH(entrydate) = $request->month_wkl_sp")
                            ->whereRaw("status = 10")
                            ->groupBy("service_point")
                            ->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_ct = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS cr_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS cr_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS cr_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS cr_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS cr_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS cr_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS cr_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS cr_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS cr_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS cr_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS cr_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS cr_december")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->groupBy("service_point")
                            ->toSql();

                $compare_pn = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS pn_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS pn_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS pn_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS pn_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS pn_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS pn_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS pn_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS pn_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS pn_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS pn_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS pn_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS pn_december")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->whereRaw("status < 10")
                            ->groupBy("service_point")
                            ->toSql();
                            
                $compare_cl = Ticket::selectRaw("case when service_point IS NULL
                                    then 'null'
                                    ELSE service_point
                                    END AS sp,
                                    SUM(CASE WHEN MONTH(entrydate) = 1 then 1 ELSE 0 END) AS cl_jan,
                                    SUM(CASE WHEN MONTH(entrydate) = 2 then 1 ELSE 0 END) AS cl_feb,
                                    SUM(CASE WHEN MONTH(entrydate) = 3 then 1 ELSE 0 END) AS cl_march,
                                    SUM(CASE WHEN MONTH(entrydate) = 4 then 1 ELSE 0 END) AS cl_april,
                                    SUM(CASE WHEN MONTH(entrydate) = 5 then 1 ELSE 0 END) AS cl_may,
                                    SUM(CASE WHEN MONTH(entrydate) = 6 then 1 ELSE 0 END) AS cl_june,
                                    SUM(CASE WHEN MONTH(entrydate) = 7 then 1 ELSE 0 END) AS cl_july,
                                    SUM(CASE WHEN MONTH(entrydate) = 8 then 1 ELSE 0 END) AS cl_aug,
                                    SUM(CASE WHEN MONTH(entrydate) = 9 then 1 ELSE 0 END) AS cl_sept,
                                    SUM(CASE WHEN MONTH(entrydate) = 10 then 1 ELSE 0 END) AS cl_october,
                                    SUM(CASE WHEN MONTH(entrydate) = 11 then 1 ELSE 0 END) AS cl_nov,
                                    SUM(CASE WHEN MONTH(entrydate) = 12 then 1 ELSE 0 END) AS cl_december")
                            ->whereRaw("YEAR(entrydate) = $request->year_wkl_sp")
                            ->whereRaw("status = 10")
                            ->groupBy("service_point")
                            ->toSql();
            }
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(cr_$desc, 0) as total$number";
                $coalesceColumns[] = "COALESCE(pn_$desc, 0) as pending$number";
                $coalesceColumns[] = "COALESCE(cl_$desc, 0) as close$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $queryTfrSP = DB::table(DB::raw("({$compare_ct}) AS cct"))
                ->leftJoin(DB::raw("({$compare_pn}) AS cpn"), 'cct.sp', '=', 'cpn.sp')
                ->leftJoin(DB::raw("({$compare_cl}) AS ccl"), 'cct.sp', '=', 'ccl.sp')
                ->leftJoin('hgt_service_point as hsp', 'cct.sp', '=', 'hsp.service_id')
                ->select(
                    'hsp.service_name',
                    DB::raw($coalesceExpression)
            )->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            
            if ($vdt == 'Week') {
                $headers = ['No', 'Service Point', 'Week 1', '', '', 'Week 2', '', '', 'Week 3', '', '', 'Week 4', '', '', 'Week 5', '', ''];
                $sections = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                $excelName = 'Summary Weekly SP';
            } else {
                $headers = [
                    'No', 
                    'Service Point', 
                    'Januari', '', '',
                    'Februari','', '', 
                    'March', '', '',
                    'April', '', '',
                    'May', '', '',
                    'June', '', '',
                    'July', '', '',
                    'August', '', '',
                    'September', '', '',
                    'October', '', '',
                    'November', '', '',
                    'December', '', ''];
                $sections = [
                    'Januari', 
                    'Februari', 
                    'March', 
                    'April', 
                    'May', 
                    'June', 
                    'July', 
                    'August', 
                    'September', 
                    'October', 
                    'November', 
                    'December'
                ];
                $excelName = 'Summary Monthly SP';
            }

            $sheet->fromArray([$headers], NULL, 'A1');

            $columnIndex = 3;
            foreach ($sections as $section) {
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CR');
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'PN');
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CL');
            
                $mergeRange = $sheet->getCellByColumnAndRow($columnIndex - 3, 1)->getColumn() . '1:' . $sheet->getCellByColumnAndRow($columnIndex - 1, 1)->getColumn() . '1';
                $sheet->mergeCells($mergeRange);
            }
            
            $mergeCells = ['A1:A2', 'B1:B2'];
            
            foreach ($mergeCells as $mergeRange) {
                $sheet->mergeCells($mergeRange);
            }
            $no = 1;
            $row = 3;
            foreach ($queryTfrSP as $item) {
                if ($vdt == 'Week') {
                    $data = [
                        $no,
                        $item->service_name,
                        $item->total1,
                        $item->pending1,
                        $item->close1,
                        $item->total2,
                        $item->pending2,
                        $item->close2,
                        $item->total3,
                        $item->pending3,
                        $item->close3,
                        $item->total4,
                        $item->pending4,
                        $item->close4,
                        $item->total5,
                        $item->pending5,
                        $item->close5
                    ];
                }else{
                    $data = [
                        $no,
                        $item->service_name,
                        $item->total1,
                        $item->pending1,
                        $item->close1,
                        $item->total2,
                        $item->pending2,
                        $item->close2,
                        $item->total3,
                        $item->pending3,
                        $item->close3,
                        $item->total4,
                        $item->pending4,
                        $item->close4,
                        $item->total5,
                        $item->pending5,
                        $item->close5,
                        $item->total6,
                        $item->pending6,
                        $item->close6,
                        $item->total7,
                        $item->pending7,
                        $item->close7,
                        $item->total8,
                        $item->pending8,
                        $item->close8,
                        $item->total9,
                        $item->pending9,
                        $item->close9,
                        $item->total10,
                        $item->pending10,
                        $item->close10,
                        $item->total11,
                        $item->pending11,
                        $item->close11,
                        $item->total12,
                        $item->pending12,
                        $item->close12,
                    ];
                }
                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                $no++;
            }
            $filename = "$excelName.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    // Report Each Week Activity Engineer
    public function eachWeekAE(Request $request, $vdt){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $role = auth()->user()->role;
        
        if (empty($request->chosen_yearAE) && empty($request->chosen_monthAE)) {
            $get_year = $currentYear;
            $get_month = $currentMonth;
        } else {
            $get_year = $request->chosen_yearAE;
            $get_month = $request->chosen_monthAE;
        }
        if ($role == 15 || $role == 20) {
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ];
                $compare_go = VW_Activity_Engineer::selectRaw("nik, full_name,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cgo_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cgo_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cgo_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cgo_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) > 28 then 1 ELSE 0 END) AS cgo_week5")
                            ->whereRaw('act_description = 2')
                            ->whereRaw("YEAR(act_time) = $get_year")
                            ->whereRaw("MONTH(act_time) = $get_month")
                            ->groupBy("nik")
                            ->toSql();
                $compare_sch = VW_Act_Report_EN::selectRaw("nik,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS csch_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS csch_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS csch_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS csch_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) > 28 then 1 ELSE 0 END) AS csch_week5")
                            ->whereRaw("YEAR(schedule) = $get_year")
                            ->whereRaw("MONTH(schedule) = $get_month")
                            ->groupBy("nik")
                            ->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_go = VW_Activity_Engineer::selectRaw("nik, full_name,
                                    SUM(CASE WHEN MONTH(act_time) = 1 then 1 ELSE 0 END) AS cgo_jan,
                                    SUM(CASE WHEN MONTH(act_time) = 2 then 1 ELSE 0 END) AS cgo_feb,
                                    SUM(CASE WHEN MONTH(act_time) = 3 then 1 ELSE 0 END) AS cgo_march,
                                    SUM(CASE WHEN MONTH(act_time) = 4 then 1 ELSE 0 END) AS cgo_april,
                                    SUM(CASE WHEN MONTH(act_time) = 5 then 1 ELSE 0 END) AS cgo_may,
                                    SUM(CASE WHEN MONTH(act_time) = 6 then 1 ELSE 0 END) AS cgo_june,
                                    SUM(CASE WHEN MONTH(act_time) = 7 then 1 ELSE 0 END) AS cgo_july,
                                    SUM(CASE WHEN MONTH(act_time) = 8 then 1 ELSE 0 END) AS cgo_aug,
                                    SUM(CASE WHEN MONTH(act_time) = 9 then 1 ELSE 0 END) AS cgo_sept,
                                    SUM(CASE WHEN MONTH(act_time) = 10 then 1 ELSE 0 END) AS cgo_october,
                                    SUM(CASE WHEN MONTH(act_time) = 11 then 1 ELSE 0 END) AS cgo_nov,
                                    SUM(CASE WHEN MONTH(act_time) = 12 then 1 ELSE 0 END) AS cgo_december")
                            ->whereRaw('act_description = 2')
                            ->whereRaw("YEAR(act_time) = $get_year")
                            ->groupBy("nik")
                            ->toSql();
                $compare_sch = VW_Act_Report_EN::selectRaw("nik,
                                    SUM(CASE WHEN MONTH(schedule) = 1 then 1 ELSE 0 END) AS csch_jan,
                                    SUM(CASE WHEN MONTH(schedule) = 2 then 1 ELSE 0 END) AS csch_feb,
                                    SUM(CASE WHEN MONTH(schedule) = 3 then 1 ELSE 0 END) AS csch_march,
                                    SUM(CASE WHEN MONTH(schedule) = 4 then 1 ELSE 0 END) AS csch_april,
                                    SUM(CASE WHEN MONTH(schedule) = 5 then 1 ELSE 0 END) AS csch_may,
                                    SUM(CASE WHEN MONTH(schedule) = 6 then 1 ELSE 0 END) AS csch_june,
                                    SUM(CASE WHEN MONTH(schedule) = 7 then 1 ELSE 0 END) AS csch_july,
                                    SUM(CASE WHEN MONTH(schedule) = 8 then 1 ELSE 0 END) AS csch_aug,
                                    SUM(CASE WHEN MONTH(schedule) = 9 then 1 ELSE 0 END) AS csch_sept,
                                    SUM(CASE WHEN MONTH(schedule) = 10 then 1 ELSE 0 END) AS csch_october,
                                    SUM(CASE WHEN MONTH(schedule) = 11 then 1 ELSE 0 END) AS csch_nov,
                                    SUM(CASE WHEN MONTH(schedule) = 12 then 1 ELSE 0 END) AS csch_december")
                            ->whereRaw("YEAR(schedule) = $get_year")
                            ->groupBy("nik")
                            ->toSql();
            }
        
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(cgo_$desc, 0) as go$number";
                $coalesceColumns[] = "COALESCE(csch_$desc, 0) as schedule$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $data['compare'] = DB::table(DB::raw("({$compare_go}) AS cgo"))
                ->leftJoin(DB::raw("({$compare_sch}) AS csch"), 'cgo.nik', '=', 'csch.nik')
                ->select(
                    'cgo.full_name',
                    DB::raw($coalesceExpression)
                )->get();
        }
        if ($role > 1) {
            $data['en'] = VW_Act_Report_EN::select('nik', 'full_name')->groupBy('nik')->get();
            if (empty($request->chosen_enAE)) {
                if ($vdt == 'Week') {
                        $getSumTicket = Ticket::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(tiket_id) AS data_count")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->groupBy("timeframe")
                        ->toSql();
                        $getOnDuty = VW_Activity_Engineer::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                        ->whereRaw('act_description = 2')
                        ->whereRaw("YEAR(act_time) = $get_year")
                        ->whereRaw("MONTH(act_time) = $get_month")
                        ->groupBy("timeframe")
                        ->toSql();

                        $getSchedule = VW_Act_Report_EN::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(schedule) = $get_year")
                        ->whereRaw("MONTH(schedule) = $get_month")
                        ->groupBy("timeframe")
                        ->toSql();
                } else {
                    $getSumTicket = Ticket::selectRaw("DATE_FORMAT(entrydate, '%c') AS month_number, DATE_FORMAT(entrydate, '%M') AS timeframe, COUNT(notiket) AS data_count")
                    ->whereRaw("YEAR(entrydate) = $get_year")
                    ->groupBy("timeframe")
                    ->toSql();
                    $getOnDuty = VW_Activity_Engineer::selectRaw("DATE_FORMAT(act_time, '%c') AS month_number, DATE_FORMAT(act_time, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw('act_description = 2')
                        ->whereRaw("YEAR(act_time) = $get_year")
                        ->groupBy("timeframe")
                        ->toSql(); 

                    $getSchedule = VW_Act_Report_EN::selectRaw("DATE_FORMAT(schedule, '%c') AS month_number, DATE_FORMAT(schedule, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(schedule) = $get_year")
                        ->groupBy("timeframe")
                        ->toSql();
                }
            } else {
                if ($vdt == 'Week') {
                    $getSumTicket = Ticket::selectRaw("CASE
                                    WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 THEN 'Week 1'
                                    WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 THEN 'Week 2'
                                    WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 THEN 'Week 3'
                                    WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 THEN 'Week 4'
                                    ELSE 'Week 5'
                                END AS timeframe,
                                COUNT(tiket_id) AS data_count")
                    ->whereRaw("YEAR(entrydate) = $get_year")
                    ->whereRaw("MONTH(entrydate) = $get_month")
                    ->whereRaw("en_id = '$request->chosen_enAE'")
                    ->groupBy("timeframe")
                    ->toSql();
                    $getOnDuty = VW_Activity_Engineer::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM act_time) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                                ->whereRaw('act_description = 2')
                                ->whereRaw("YEAR(act_time) = $get_year")
                                ->whereRaw("MONTH(act_time) = $get_month")
                                ->whereRaw("nik = '$request->chosen_enAE'")
                                ->groupBy("timeframe")
                                ->toSql();
                    $getSchedule = VW_Act_Report_EN::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM schedule) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(schedule) = $get_year")
                        ->whereRaw("MONTH(schedule) = $get_month")
                        ->whereRaw("nik = '$request->chosen_enAE'")
                        ->groupBy("timeframe")
                        ->toSql();
                } else {
                    $getSumTicket = Ticket::selectRaw("DATE_FORMAT(entrydate, '%c') AS month_number, DATE_FORMAT(entrydate, '%M') AS timeframe, COUNT(notiket) AS data_count")
                    ->whereRaw("YEAR(entrydate) = $get_year")
                    ->whereRaw("en_id = '$request->chosen_enAE'")
                    ->groupBy("timeframe")
                    ->toSql();
                    $getOnDuty = VW_Activity_Engineer::selectRaw("DATE_FORMAT(act_time, '%c') AS month_number, DATE_FORMAT(act_time, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw('act_description = 2')
                        ->whereRaw("YEAR(act_time) = $get_year")
                        ->whereRaw("nik = '$request->chosen_enAE'")
                        ->groupBy("timeframe")
                        ->toSql(); 

                    $getSchedule = VW_Act_Report_EN::selectRaw("DATE_FORMAT(schedule, '%c') AS month_number, DATE_FORMAT(schedule, '%M') AS timeframe, COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(schedule) = $get_year")
                        ->whereRaw("nik = '$request->chosen_enAE'")
                        ->groupBy("timeframe")
                        ->toSql();
                }
            }
            $data['getActEN'] = DB::table(DB::raw("({$getSumTicket}) AS gst"))
                                ->leftJoin(DB::raw("({$getSchedule}) AS gsch"), 'gst.timeframe', '=', 'gsch.timeframe')
                                ->leftJoin(DB::raw("({$getOnDuty}) AS god"), 'gst.timeframe', '=', 'god.timeframe')
                                ->select('gst.*','god.data_count as sumOnDuty', 'gsch.data_count as sumSchedule')
                                ->get();
        }
        $years = [];
        $months = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        // Get all months
        for ($month = 1; $month <= 12; $month++) {
            $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthName = Carbon::createFromDate(null, $month, 1)->format('F');
            $months[$monthNumber] = $monthName;
        }
        $getSort = [
            'loop_year' => $years,
            'loop_month' => $months,
        ];

        return view('Pages.Report.ew-AE')->with($data)
        ->with($getSort)
        ->with('vdt', $vdt)
        ->with('enAE', $request->chosen_enAE)
        ->with('year', $get_year)
        ->with('month', $get_month);
    }
    // Detil pending each week
    public function dtActEW($vdt,$timeframe,$en,$month,$year){
        if ($vdt == 'Week') {
            if ($timeframe == 'Week 1') {
                $num1 = 1;
                $num2 = 7;
            } else if ($timeframe == 'Week 2'){
                $num1 = 8;
                $num2 = 14;
            } else if ($timeframe == 'Week 3'){
                $num1 = 15;
                $num2 = 21;
            } else if ($timeframe == 'Week 4'){
                $num1 = 22;
                $num2 = 28;
            }
            if ($month == 1) {
                $get_month = 'Januari';
            } elseif ($month == 2) {
                $get_month = 'Februari';
            } elseif ($month == 3) {
                $get_month = 'March';
            } elseif ($month == 4) {
                $get_month = 'April';
            } elseif ($month == 5) {
                $get_month = 'Mei';
            } elseif ($month == 6) {
                $get_month = 'June';
            } elseif ($month == 7) {
                $get_month = 'July';
            } elseif ($month == 8) {
                $get_month = 'August';
            } elseif ($month == 9) {
                $get_month = 'September';
            } elseif ($month == 10) {
                $get_month = 'October';
            } elseif ($month == 11) {
                $get_month = 'November';
            } elseif ($month == 12) {
                $get_month = 'December';
            }
            if ($en == 'null') {
                if ($timeframe != 'Week 5') {
                    $getOnDuty = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_act_report_engineer')
                                                        ->whereRaw("YEAR(gow) = $year")
                                                        ->whereRaw("MONTH(gow) = $month")
                                                        ->whereRaw("DAY(gow) BETWEEN $num1 and $num2");
                                                }, 'subquery')
                                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                                ->groupBy('nik')
                                                ->toSql();
                    $getSchedule = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                    $query->select('*')
                                        ->from('vw_act_report_engineer')
                                        ->whereRaw("YEAR(schedule) = $year")
                                        ->whereRaw("MONTH(schedule) = $month")
                                        ->whereRaw("DAY(schedule) BETWEEN $num1 and $num2");
                                }, 'subquery')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                                ->groupBy('nik')
                                ->toSql();
                } else {
                    $getOnDuty = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_act_report_engineer')
                                                        ->whereRaw("YEAR(gow) = $year")
                                                        ->whereRaw("MONTH(gow) = $month")
                                                        ->whereRaw("DAY(gow) > 28");
                                                }, 'subquery')
                                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                                ->groupBy('nik')
                                                ->toSql();
                    $getSchedule = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                    $query->select('*')
                                        ->from('vw_act_report_engineer')
                                        ->whereRaw("YEAR(schedule) = $year")
                                        ->whereRaw("MONTH(schedule) = $month")
                                        ->whereRaw("DAY(schedule) > 28");
                                }, 'subquery')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                                ->groupBy('nik')
                                ->toSql();
                }
            } else {
                if ($timeframe != 'Week 5') {
                    $getOnDuty = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_act_report_engineer')
                                                        ->whereRaw("YEAR(gow) = $year")
                                                        ->whereRaw("MONTH(gow) = $month")
                                                        ->whereRaw("DAY(gow) BETWEEN $num1 and $num2");
                                                }, 'subquery')
                                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                                ->whereRaw("nik = '$en'")
                                                ->groupBy('nik')
                                                ->toSql();
                    $getSchedule = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                    $query->select('*')
                                        ->from('vw_act_report_engineer')
                                        ->whereRaw("YEAR(schedule) = $year")
                                        ->whereRaw("MONTH(schedule) = $month")
                                        ->whereRaw("DAY(schedule) BETWEEN $num1 and $num2");
                                }, 'subquery')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                                ->whereRaw("nik = '$en'")
                                ->groupBy('nik')
                                ->toSql();
                } else {
                    $getOnDuty = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                    $query->select('*')
                                                        ->from('vw_act_report_engineer')
                                                        ->whereRaw("YEAR(gow) = $year")
                                                        ->whereRaw("MONTH(gow) = $month")
                                                        ->whereRaw("DAY(gow) > 28");
                                                }, 'subquery')
                                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                                ->whereRaw("nik = '$en'")
                                                ->groupBy('nik')
                                                ->toSql();
                    $getSchedule = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                    $query->select('*')
                                        ->from('vw_act_report_engineer')
                                        ->whereRaw("YEAR(schedule) = $year")
                                        ->whereRaw("MONTH(schedule) = $month")
                                        ->whereRaw("DAY(schedule) > 28");
                                }, 'subquery')
                                ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                                ->whereRaw("nik = '$en'")
                                ->groupBy('nik')
                                ->toSql();
                }
            }
        } else {
            if ($timeframe == 1) {
                $get_month = 'Januari';
            } elseif ($timeframe == 2) {
                $get_month = 'Februari';
            } elseif ($timeframe == 3) {
                $get_month = 'March';
            } elseif ($timeframe == 4) {
                $get_month = 'April';
            } elseif ($timeframe == 5) {
                $get_month = 'Mei';
            } elseif ($timeframe == 6) {
                $get_month = 'June';
            } elseif ($timeframe == 7) {
                $get_month = 'July';
            } elseif ($timeframe == 8) {
                $get_month = 'August';
            } elseif ($timeframe == 9) {
                $get_month = 'September';
            } elseif ($timeframe == 10) {
                $get_month = 'October';
            } elseif ($timeframe == 11) {
                $get_month = 'November';
            } elseif ($timeframe == 12) {
                $get_month = 'December';
            }
            if ($en == 'null') {
                $getOnDuty = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_act_report_engineer')
                                                    ->whereRaw("YEAR(gow) = $year")
                                                    ->whereRaw("MONTH(gow) = $timeframe");
                                            }, 'subquery')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                            ->groupBy('nik')
                                            ->toSql();
                $getSchedule = DB::table(function ($query) use ($year, $timeframe) {
                                $query->select('*')
                                    ->from('vw_act_report_engineer')
                                    ->whereRaw("YEAR(schedule) = $year")
                                    ->whereRaw("MONTH(schedule) = $timeframe");
                            }, 'subquery')
                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                            ->groupBy('nik')
                            ->toSql();
            } else {
                $getOnDuty = DB::table(function ($query) use ($year, $timeframe) {
                                                $query->select('*')
                                                    ->from('vw_act_report_engineer')
                                                    ->whereRaw("YEAR(gow) = $year")
                                                    ->whereRaw("MONTH(gow) = $timeframe");
                                            }, 'subquery')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalOnDuty'))
                                            ->whereRaw("nik = '$en'")
                                            ->groupBy('nik')
                                            ->toSql();
                $getSchedule = DB::table(function ($query) use ($year, $timeframe) {
                                $query->select('*')
                                    ->from('vw_act_report_engineer')
                                    ->whereRaw("YEAR(schedule) = $year")
                                    ->whereRaw("MONTH(schedule) = $timeframe");
                            }, 'subquery')
                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS totalSchedule'))
                            ->whereRaw("nik = '$en'")
                            ->groupBy('nik')
                            ->toSql();
            }
        }

        $data['gedtActEN'] = DB::table(DB::raw("({$getOnDuty}) AS god"))
                            ->leftJoin(DB::raw("({$getSchedule}) AS gsch"), 'god.nik', '=', 'gsch.nik')
                            ->select('god.*', 'gsch.totalSchedule as sumSchedule')
                            ->get();

        return view('Pages.Report.DT.detil-each-act')->with($data)
        ->with('vdt', $vdt)
        ->with('timeframe', $timeframe)
        ->with('month', $get_month)
        ->with('year', $year);
    }
        public function export_wmly_ae(Request $request, $vdt){
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ]; 
                $compare_go = VW_Activity_Engineer::selectRaw("nik, full_name,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cgo_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cgo_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cgo_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cgo_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM act_time) > 28 then 1 ELSE 0 END) AS cgo_week5")
                            ->whereRaw('act_description = 2')
                            ->whereRaw("YEAR(act_time) = $request->year_wkl_ae")
                            ->whereRaw("MONTH(act_time) = $request->month_wkl_ae")
                            ->groupBy("nik")
                            ->toSql();
                $compare_sch = VW_Act_Report_EN::selectRaw("nik,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS csch_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS csch_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS csch_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS csch_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM schedule) > 28 then 1 ELSE 0 END) AS csch_week5")
                            ->whereRaw("YEAR(schedule) = $request->year_wkl_ae")
                            ->whereRaw("MONTH(schedule) = $request->month_wkl_ae")
                            ->groupBy("nik")
                            ->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_go = VW_Activity_Engineer::selectRaw("nik, full_name,
                                    SUM(CASE WHEN MONTH(act_time) = 1 then 1 ELSE 0 END) AS cgo_jan,
                                    SUM(CASE WHEN MONTH(act_time) = 2 then 1 ELSE 0 END) AS cgo_feb,
                                    SUM(CASE WHEN MONTH(act_time) = 3 then 1 ELSE 0 END) AS cgo_march,
                                    SUM(CASE WHEN MONTH(act_time) = 4 then 1 ELSE 0 END) AS cgo_april,
                                    SUM(CASE WHEN MONTH(act_time) = 5 then 1 ELSE 0 END) AS cgo_may,
                                    SUM(CASE WHEN MONTH(act_time) = 6 then 1 ELSE 0 END) AS cgo_june,
                                    SUM(CASE WHEN MONTH(act_time) = 7 then 1 ELSE 0 END) AS cgo_july,
                                    SUM(CASE WHEN MONTH(act_time) = 8 then 1 ELSE 0 END) AS cgo_aug,
                                    SUM(CASE WHEN MONTH(act_time) = 9 then 1 ELSE 0 END) AS cgo_sept,
                                    SUM(CASE WHEN MONTH(act_time) = 10 then 1 ELSE 0 END) AS cgo_october,
                                    SUM(CASE WHEN MONTH(act_time) = 11 then 1 ELSE 0 END) AS cgo_nov,
                                    SUM(CASE WHEN MONTH(act_time) = 12 then 1 ELSE 0 END) AS cgo_december")
                            ->whereRaw('act_description = 2')
                            ->whereRaw("YEAR(act_time) = $request->year_wkl_ae")
                            ->groupBy("nik")
                            ->toSql();
                $compare_sch = VW_Act_Report_EN::selectRaw("nik,
                                    SUM(CASE WHEN MONTH(schedule) = 1 then 1 ELSE 0 END) AS csch_jan,
                                    SUM(CASE WHEN MONTH(schedule) = 2 then 1 ELSE 0 END) AS csch_feb,
                                    SUM(CASE WHEN MONTH(schedule) = 3 then 1 ELSE 0 END) AS csch_march,
                                    SUM(CASE WHEN MONTH(schedule) = 4 then 1 ELSE 0 END) AS csch_april,
                                    SUM(CASE WHEN MONTH(schedule) = 5 then 1 ELSE 0 END) AS csch_may,
                                    SUM(CASE WHEN MONTH(schedule) = 6 then 1 ELSE 0 END) AS csch_june,
                                    SUM(CASE WHEN MONTH(schedule) = 7 then 1 ELSE 0 END) AS csch_july,
                                    SUM(CASE WHEN MONTH(schedule) = 8 then 1 ELSE 0 END) AS csch_aug,
                                    SUM(CASE WHEN MONTH(schedule) = 9 then 1 ELSE 0 END) AS csch_sept,
                                    SUM(CASE WHEN MONTH(schedule) = 10 then 1 ELSE 0 END) AS csch_october,
                                    SUM(CASE WHEN MONTH(schedule) = 11 then 1 ELSE 0 END) AS csch_nov,
                                    SUM(CASE WHEN MONTH(schedule) = 12 then 1 ELSE 0 END) AS csch_december")
                            ->whereRaw("YEAR(schedule) = $request->year_wkl_ae")
                            ->groupBy("nik")
                            ->toSql();
            }
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(cgo_$desc, 0) as go$number";
                $coalesceColumns[] = "COALESCE(csch_$desc, 0) as schedule$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $queryTfrAE = DB::table(DB::raw("({$compare_go}) AS cgo"))
                ->leftJoin(DB::raw("({$compare_sch}) AS csch"), 'cgo.nik', '=', 'csch.nik')
                ->select(
                    'cgo.full_name',
                    DB::raw($coalesceExpression)
                )->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            
            if ($vdt == 'Week') {
                $headers = ['No', 'full_name', 'Week 1', '', 'Week 2', '', 'Week 3', '', 'Week 4', '', 'Week 5', ''];
                $sections = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                $excelName = 'Summary Weekly AE';
            } else {
                $headers = [
                    'No', 
                    'full_name', 
                    'Januari', '',
                    'Februari','',
                    'March', '',
                    'April', '',
                    'May', '',
                    'June', '',
                    'July', '',
                    'August', '',
                    'September', '',
                    'October', '',
                    'November', '',
                    'December', ''];
                $sections = [
                    'Januari', 
                    'Februari', 
                    'March', 
                    'April', 
                    'May', 
                    'June', 
                    'July', 
                    'August', 
                    'September', 
                    'October', 
                    'November', 
                    'December'
                ];
                $excelName = 'Summary Monthly AE';
            }

            $sheet->fromArray([$headers], NULL, 'A1');

            $columnIndex = 3;
            foreach ($sections as $section) {
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'GO');
                $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'SCH');
            
                $mergeRange = $sheet->getCellByColumnAndRow($columnIndex - 2, 1)->getColumn() . '1:' . $sheet->getCellByColumnAndRow($columnIndex - 1, 1)->getColumn() . '1';
                $sheet->mergeCells($mergeRange);
            }
            
            $mergeCells = ['A1:A2', 'B1:B2'];
            
            foreach ($mergeCells as $mergeRange) {
                $sheet->mergeCells($mergeRange);
            }
            $no = 1;
            $row = 3;
            foreach ($queryTfrAE as $item) {
                if ($vdt == 'Week') {
                    $data = [
                        $no,
                        $item->full_name,
                        $item->go1,
                        $item->schedule1,
                        $item->go2,
                        $item->schedule2,
                        $item->go3,
                        $item->schedule3,
                        $item->go4,
                        $item->schedule4,
                        $item->go5,
                        $item->schedule5,
                       ];
                }else{
                    $data = [
                        $no,
                        $item->full_name,
                        $item->go1,
                        $item->schedule1,
                        $item->go2,
                        $item->schedule2,
                        $item->go3,
                        $item->schedule3,
                        $item->go4,
                        $item->schedule4,
                        $item->go5,
                        $item->schedule5,
                        $item->go6,
                        $item->schedule6,
                        $item->go7,
                        $item->schedule7,
                        $item->go8,
                        $item->schedule8,
                        $item->go9,
                        $item->schedule9,
                        $item->go10,
                        $item->schedule10,
                        $item->go11,
                        $item->schedule11,
                        $item->go12,
                        $item->schedule12,
                    ];
                }
                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                $no++;
            }
            $filename = "$excelName.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    // Report Each Week Activity Engineer
    public function eachWeekHP(Request $request,$vdt){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        $role = auth()->user()->role;

        if (empty($request->chosen_yearHP) && empty($request->chosen_monthHP)) {
            $get_year = $currentYear;
            $get_month = $currentMonth;
        } else {
            $get_year = $request->chosen_yearHP;
            $get_month = $request->chosen_monthHP;
        }
        if ($role == 15 || $role == 20) {
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ];

                $compare_act = VW_Act_Heldepsk::selectRaw("nik, full_name as act_user,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS act_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS act_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS act_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS act_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS act_week5")
                            ->whereRaw("depart = 4")
                            ->whereRaw("YEAR(created_at) = $get_year")
                            ->whereRaw("MONTH(created_at) = $get_month")
                            ->groupBy("nik")
                            ->toSql();
                $compare_hdld = DB::table(function ($query) use ($get_year, $get_month) {
                                                $query->selectRaw('nik as hdld_user, created_at')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $get_year")
                                                    ->whereRaw("MONTH(created_at) = $get_month")
                                                    ->whereRaw("depart = '4'")
                                                    ->groupBy('notiket', 'nik', 'periode');
                                            })
                                            ->selectRaw("hdld_user,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS hdld_week1,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS hdld_week2,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS hdld_week3,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS hdld_week4,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS hdld_week5")
                                            ->groupBy('hdld_user')
                                            ->toSql();
                $compare_crt = DB::table(function ($query) use ($get_year, $get_month){
                                    $query->selectRaw('nik as crt_user,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 THEN 1 ELSE 0 END) AS crt_week1,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 THEN 1 ELSE 0 END) AS crt_week2,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 THEN 1 ELSE 0 END) AS crt_week3,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 THEN 1 ELSE 0 END) AS crt_week4,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 THEN 1 ELSE 0 END) AS crt_week5')
                                        ->from(function ($subquery) use ($get_year, $get_month) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MIN(created_at) AS note_terlama
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.note_terlama');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $get_year")
                                                ->whereRaw("MONTH(created_at) = $get_month");
                                        })
                                        ->groupBy('nik');
                                })->toSql();
                $compare_cl = DB::table(function ($query) use ($get_year, $get_month){
                                    $query->selectRaw('nik as cl_user,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS cl_week5')
                                        ->from(function ($subquery) use ($get_year, $get_month) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MAX(created_at) AS nt_last
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.nt_last');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $get_year")
                                                ->whereRaw("MONTH(created_at) = $get_month")
                                                ->whereRaw('status = 10');
                                        })
                                        ->groupBy('nik');
                                })->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_act = VW_Act_Heldepsk::selectRaw("nik, full_name as act_user,
                                SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS act_jan,
                                SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS act_feb,
                                SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS act_march,
                                SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS act_april,
                                SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS act_may,
                                SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS act_june,
                                SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS act_july,
                                SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS act_aug,
                                SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS act_sept,
                                SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS act_october,
                                SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS act_nov,
                                SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS act_december")
                            ->whereRaw("depart = 4")
                            ->whereRaw("YEAR(created_at) = $get_year")
                            ->groupBy("nik")
                            ->toSql();
                $compare_hdld = DB::table(function ($query) use ($get_year) {
                                    $query->selectRaw('nik as hdld_user, created_at')
                                        ->from('vw_hgt_act_helpdesk')
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->whereRaw("depart = 4")
                                        ->groupBy('notiket', 'nik', 'periode_mt');
                                })
                                ->selectRaw("hdld_user,
                                    SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS hdld_jan,
                                    SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS hdld_feb,
                                    SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS hdld_march,
                                    SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS hdld_april,
                                    SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS hdld_may,
                                    SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS hdld_june,
                                    SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS hdld_july,
                                    SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS hdld_aug,
                                    SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS hdld_sept,
                                    SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS hdld_october,
                                    SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS hdld_nov,
                                    SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS hdld_december")
                                ->groupBy('hdld_user')
                                ->toSql();
                $compare_crt = DB::table(function ($query) use ($get_year){
                                    $query->selectRaw('nik as crt_user,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS crt_jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS crt_feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS crt_march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS crt_april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS crt_may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS crt_june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS crt_july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS crt_aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS crt_sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS crt_october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS crt_nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS crt_december')
                                        ->from(function ($subquery) use ($get_year) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MIN(created_at) AS note_terlama
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.note_terlama');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $get_year")
                                                ;
                                        })
                                        ->groupBy('nik');
                                })->toSql();
                $compare_cl = DB::table(function ($query) use ($get_year){
                                    $query->selectRaw('nik as cl_user,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS cl_jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS cl_feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS cl_march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS cl_april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS cl_may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS cl_june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS cl_july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS cl_aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS cl_sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS cl_october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS cl_nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS cl_december')
                                        ->from(function ($subquery) use ($get_year) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MAX(created_at) AS nt_last
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.nt_last');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $get_year")
                                                ->whereRaw('status = 10');
                                        })
                                        ->groupBy('nik');
                                })->toSql();
            }
            
            $coalesceColumns = [];

            foreach ($timeframe as $desc => $number) {
                $coalesceColumns[] = "COALESCE(act_$desc, 0) as activity$number";
                $coalesceColumns[] = "COALESCE(hdld_$desc, 0) as handled$number";
                $coalesceColumns[] = "COALESCE(crt_$desc, 0) as created$number";
                $coalesceColumns[] = "COALESCE(cl_$desc, 0) as closed$number";
            }
            $coalesceExpression = implode(', ', $coalesceColumns);

            $data['compare'] = DB::table(DB::raw("({$compare_act}) AS act"))
                ->leftJoin(DB::raw("({$compare_hdld}) AS hdld"), "act.nik", '=', "hdld.hdld_user")
                ->leftJoin(DB::raw("({$compare_crt}) AS crt"), "act.nik", '=', "crt.crt_user")
                ->leftJoin(DB::raw("({$compare_cl}) AS cl"), "act.nik", '=', "cl.cl_user")
                ->select(
                    'act.act_user',
                    DB::raw($coalesceExpression)
                )->get();
        }
        if ($role > 1) {
            $data['hp'] = VW_Act_Heldepsk::select('nik', 'full_name')->where('depart', 4)->groupBy('nik')->get();
            if ($vdt == 'Week') {
                if (empty($request->chosen_enHP)) {
                    $getActHP = VW_Act_Heldepsk::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("MONTH(created_at) = $get_month")
                        ->whereRaw("depart = 4")
                        ->groupBy("timeframe")
                        ->toSql();
                        
                    $getSumTicket = Ticket::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM entrydate) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(tiket_id) AS data_count")
                        ->whereRaw("YEAR(entrydate) = $get_year")
                        ->whereRaw("MONTH(entrydate) = $get_month")
                        ->groupBy("timeframe")
                        ->toSql();
                } else {
                    $getActHP = VW_Act_Heldepsk::selectRaw("CASE
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 THEN 'Week 1'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 THEN 'Week 2'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 THEN 'Week 3'
                                        WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 THEN 'Week 4'
                                        ELSE 'Week 5'
                                    END AS timeframe,
                                    COUNT(notiket) AS data_count")
                        ->whereRaw("YEAR(created_at) = $get_year")
                        ->whereRaw("MONTH(created_at) = $get_month")
                        ->whereRaw("nik = '$request->chosen_enHP'")
                        ->whereRaw("depart = 4")
                        ->groupBy("timeframe")
                        ->orderByRaw('MIN(created_at)')
                        ->toSql();
                        
                    $getSumTicket = DB::table(function ($query) use($get_year, $get_month) {
                                        $query->select('vhch.*', DB::raw('CASE
                                                WHEN EXTRACT(DAY FROM ht.created_at) BETWEEN 1 AND 7 THEN "Week 1"
                                                WHEN EXTRACT(DAY FROM ht.created_at) BETWEEN 8 AND 14 THEN "Week 2"
                                                WHEN EXTRACT(DAY FROM ht.created_at) BETWEEN 15 AND 21 THEN "Week 3"
                                                WHEN EXTRACT(DAY FROM ht.created_at) BETWEEN 22 AND 28 THEN "Week 4"
                                                ELSE "Week 5"
                                            END AS timeframe'))
                                            ->from('vw_hgt_act_helpdesk as vhch')
                                            ->leftJoin('hgt_ticket as ht', 'vhch.notiket', '=', 'ht.notiket')
                                            ->whereRaw("YEAR(ht.created_at) = $get_year")
                                            ->whereRaw("MONTH(ht.created_at) = $get_month")
                                            ->groupBy('vhch.notiket');
                                    }, 'g_ak')
                                    ->whereRaw("nik = '$request->chosen_enHP'")
                                    ->groupBy('timeframe')
                                    ->select('timeframe', DB::raw('COUNT(*) AS data_count'))
                                    ->toSql();
                }
            } else {
                if (empty($request->chosen_enHP)) {
                    $getActHP = VW_Act_Heldepsk::selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS timeframe, COUNT(notiket) AS data_count")
                                ->whereRaw("YEAR(created_at) = $get_year")
                                ->whereRaw("depart = 4")
                                ->groupBy("timeframe")
                                ->toSql();

                    $getSumTicket = Ticket::selectRaw("DATE_FORMAT(entrydate, '%c') AS month_number, DATE_FORMAT(entrydate, '%M') AS timeframe, COUNT(tiket_id) AS data_count")
                                ->whereRaw("YEAR(entrydate) = $get_year")
                                ->groupBy("timeframe")
                                ->toSql();
                }else{
                    $getActHP = VW_Act_Heldepsk::selectRaw("DATE_FORMAT(created_at, '%c') AS month_number, DATE_FORMAT(created_at, '%M') AS timeframe, COUNT(notiket) AS data_count")
                                ->whereRaw("YEAR(created_at) = $get_year")
                                ->whereRaw("nik = '$request->chosen_enHP'")
                                ->whereRaw("depart = 4")
                                ->groupBy("timeframe")
                                ->toSql();

                    $getSumTicket = DB::table(function ($query) use($get_year) {
                                        $query->select('vhch.*', DB::raw("DATE_FORMAT(ht.created_at, '%c') AS month_number, DATE_FORMAT(ht.created_at, '%M') AS timeframe"))
                                            ->from('vw_hgt_act_helpdesk as vhch')
                                            ->leftJoin('hgt_ticket as ht', 'vhch.notiket', '=', 'ht.notiket')
                                            ->whereRaw("YEAR(ht.created_at) = $get_year")
                                            ->groupBy('vhch.notiket');
                                    }, 'g_ak')
                                    ->whereRaw("nik = '$request->chosen_enHP'")
                                    ->groupBy('timeframe')
                                    ->select('timeframe', DB::raw('COUNT(*) AS data_count'))
                                    ->toSql();
                }
            }
            $data['eachWeek'] = DB::table(DB::raw("({$getActHP}) AS ahp"))
                                ->leftJoin(DB::raw("({$getSumTicket}) AS gst"), 'ahp.timeframe', '=', 'gst.timeframe')
                                ->select('ahp.*', 'gst.data_count as sumTicket')
                                ->get();
        }
        $years = [];
        $months = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        // Get all months
        for ($month = 1; $month <= 12; $month++) {
            $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthName = Carbon::createFromDate(null, $month, 1)->format('F');
            $months[$monthNumber] = $monthName;
        }
        $getSort = [
            'loop_year' => $years,
            'loop_month' => $months,
        ];

        return view('Pages.Report.ew-HP')->with($data)
        ->with($getSort)
        ->with('vdt', $vdt)
        ->with('enHP', $request->chosen_enHP)
        ->with('year', $get_year)
        ->with('month', $get_month);
    }
        // Export Excel Act eachWeek HP
        public function export_actHP(Request $request, $vdt){
            if ($vdt == 'Week') {
                $timeframe = [
                    'week1' => '1', 
                    'week2' => '2',
                    'week3' => '3',
                    'week4' => '4',
                    'week5' => '5'
                ];
                
                $compare_act = VW_Act_Heldepsk::selectRaw("nik, full_name as act_user,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS act_week1,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS act_week2,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS act_week3,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS act_week4,
                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS act_week5")
                            ->whereRaw("depart = 4")
                            ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                            ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                            ->groupBy("nik")
                            ->toSql();
                $compare_hdld = DB::table(function ($query) use ($request) {
                                                $query->selectRaw('nik as hdld_user, created_at')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                    ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                                                    ->whereRaw("depart = '4'")
                                                    ->groupBy('notiket', 'nik', 'periode');
                                            })
                                            ->selectRaw("hdld_user,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS hdld_week1,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS hdld_week2,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS hdld_week3,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS hdld_week4,
                                                    SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS hdld_week5")
                                            ->groupBy('hdld_user')
                                            ->toSql();
                $compare_crt = DB::table(function ($query) use($request) {
                                    $query->selectRaw('nik as crt_user,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 THEN 1 ELSE 0 END) AS crt_week1,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 THEN 1 ELSE 0 END) AS crt_week2,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 THEN 1 ELSE 0 END) AS crt_week3,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 THEN 1 ELSE 0 END) AS crt_week4,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 THEN 1 ELSE 0 END) AS crt_week5')
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MIN(created_at) AS note_terlama
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.note_terlama');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                ->whereRaw("MONTH(created_at) = $request->act_month_srt");
                                        })
                                        ->groupBy('nik');
                                })->toSql();
                $compare_cl = DB::table(function ($query) use ($request) {
                                    $query->selectRaw('nik as cl_user,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS cl_week1,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS cl_week2,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS cl_week3,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS cl_week4,
                                            SUM(CASE WHEN EXTRACT(DAY FROM created_at) > 28 then 1 ELSE 0 END) AS cl_week5')
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MAX(created_at) AS nt_last
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.nt_last');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                                                ->whereRaw('status = 10');
                                        })
                                        ->groupBy('nik');
                                })->toSql();
            } else if($vdt == "Daily"){
                $compare_act = VW_Act_Heldepsk::selectRaw("nik, full_name,
                                    DATE_FORMAT(created_at, '%M%d') AS time_join,
                                    DATE_FORMAT(created_at, '%Y-%m-%d') AS timeframe, 
                                    COUNT(notiket) AS act_count")
                            ->whereRaw("depart = 4")
                            ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                            ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                            ->groupBy("nik", 'timeframe')
                            ->toSql();
                $compare_hdld = DB::table(function ($query) use ($request) {
                                                $query->selectRaw('notiket, nik as hdld_user, created_at')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                    ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                                                    ->whereRaw("depart = '4'")
                                                    ->groupBy('notiket', 'nik', 'periode');
                                            })
                                            ->selectRaw("hdld_user,
                                                DATE_FORMAT(created_at, '%M%d') AS time_join,
                                                DATE_FORMAT(created_at, '%Y-%m-%d') AS timeframe, 
                                                COUNT(notiket) AS hdld_count")
                                            ->groupBy('hdld_user', 'timeframe')
                                            ->toSql();
                $compare_crt = DB::table(function ($query) use($request) {
                                    $query->selectRaw("nik as crt_user,
                                            DATE_FORMAT(created_at, '%M%d') AS time_join,
                                            DATE_FORMAT(created_at, '%Y-%m-%d') AS timeframe, 
                                            COUNT(notiket) AS crt_count")
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MIN(created_at) AS note_terlama
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.note_terlama');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                ->whereRaw("MONTH(created_at) = $request->act_month_srt");
                                        })
                                        ->groupBy('nik', 'timeframe');
                                })->toSql();
                $compare_cl = DB::table(function ($query) use ($request) {
                                    $query->selectRaw("nik as cl_user,
                                            DATE_FORMAT(created_at, '%M%d') AS time_join,
                                            DATE_FORMAT(created_at, '%Y-%m-%d') AS timeframe, 
                                            COUNT(notiket) AS cl_count")
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MAX(created_at) AS nt_last
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.nt_last');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                ->whereRaw("MONTH(created_at) = $request->act_month_srt")
                                                ->whereRaw('status = 10');
                                        })
                                        ->groupBy('nik', 'timeframe');
                                })->toSql();
            } else {
                $timeframe = [
                    'jan' => '1', 
                    'feb' => '2',
                    'march' => '3',
                    'april' => '4',
                    'may' => '5',
                    'june' => '6',
                    'july' => '7',
                    'aug' => '8',
                    'sept' => '9',
                    'october' => '10',
                    'nov' => '11',
                    'december' => '12'
                ];
                $compare_act = VW_Act_Heldepsk::selectRaw("nik, full_name as act_user,
                                SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS act_jan,
                                SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS act_feb,
                                SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS act_march,
                                SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS act_april,
                                SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS act_may,
                                SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS act_june,
                                SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS act_july,
                                SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS act_aug,
                                SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS act_sept,
                                SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS act_october,
                                SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS act_nov,
                                SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS act_december")
                            ->whereRaw("depart = 4")
                            ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                            ->groupBy("nik")
                            ->toSql();
                $compare_hdld = DB::table(function ($query) use ($request) {
                                    $query->selectRaw('nik as hdld_user, created_at')
                                        ->from('vw_hgt_act_helpdesk')
                                        ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                        ->whereRaw("depart = 4")
                                        ->groupBy('notiket', 'nik', 'periode_mt');
                                })
                                ->selectRaw("hdld_user,
                                    SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS hdld_jan,
                                    SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS hdld_feb,
                                    SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS hdld_march,
                                    SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS hdld_april,
                                    SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS hdld_may,
                                    SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS hdld_june,
                                    SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS hdld_july,
                                    SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS hdld_aug,
                                    SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS hdld_sept,
                                    SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS hdld_october,
                                    SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS hdld_nov,
                                    SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS hdld_december")
                                ->groupBy('hdld_user')
                                ->toSql();
                $compare_crt = DB::table(function ($query) use($request) {
                                    $query->selectRaw('nik as crt_user,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS crt_jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS crt_feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS crt_march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS crt_april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS crt_may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS crt_june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS crt_july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS crt_aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS crt_sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS crt_october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS crt_nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS crt_december')
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MIN(created_at) AS note_terlama
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.note_terlama');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt");
                                        })
                                        ->groupBy('nik');
                                })->toSql();
                $compare_cl = DB::table(function ($query) use ($request) {
                                    $query->selectRaw('nik as cl_user,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS cl_jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS cl_feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS cl_march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS cl_april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS cl_may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS cl_june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS cl_july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS cl_aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS cl_sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS cl_october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS cl_nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS cl_december')
                                        ->from(function ($subquery) use ($request) {
                                            $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                ->from(function ($innerSubquery) {
                                                    $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                        ->from('vw_hgt_act_helpdesk as t1')
                                                        ->join(DB::raw('(
                                                            SELECT notiket, MAX(created_at) AS nt_last
                                                            FROM vw_hgt_act_helpdesk
                                                            GROUP BY notiket
                                                        ) t2'), function ($join) {
                                                            $join->on('t1.notiket', '=', 't2.notiket')
                                                                ->on('t1.created_at', '=', 't2.nt_last');
                                                        });
                                                }, 'vch')
                                                ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                ->whereRaw("YEAR(created_at) = $request->act_year_srt")
                                                ->whereRaw('status = 10');
                                        })
                                        ->groupBy('nik');
                                })->toSql();
            }
            if ($vdt == 'Daily') {
                $excelData = DB::table(DB::raw("({$compare_act}) AS act"))
                                    ->leftJoin(DB::raw("({$compare_hdld}) AS hdld"), function ($join) {
                                        $join->on('act.nik', '=', 'hdld.hdld_user')
                                            ->on('act.time_join', '=', 'hdld.time_join');
                                    })
                                    ->leftJoin(DB::raw("({$compare_crt}) AS crt"), function ($join) {
                                        $join->on('act.nik', '=', 'crt.crt_user')
                                            ->on('act.time_join', '=', 'crt.time_join');
                                    })
                                    ->leftJoin(DB::raw("({$compare_cl}) AS cl"), function ($join) {
                                        $join->on('act.nik', '=', 'cl.cl_user')
                                            ->on('act.time_join', '=', 'cl.time_join');
                                    })
                                    ->select('act.*', 'hdld.hdld_count', 'crt.crt_count', 'cl.cl_count')
                                    ->orderBy('act.timeframe', 'ASC')
                                    ->get();
            } else {
                $coalesceColumns = [];

                foreach ($timeframe as $desc => $number) {
                    $coalesceColumns[] = "COALESCE(act_$desc, 0) as activity$number";
                    $coalesceColumns[] = "COALESCE(hdld_$desc, 0) as handled$number";
                    $coalesceColumns[] = "COALESCE(crt_$desc, 0) as created$number";
                    $coalesceColumns[] = "COALESCE(cl_$desc, 0) as closed$number";
                }
                $coalesceExpression = implode(', ', $coalesceColumns);

                $excelData = DB::table(DB::raw("({$compare_act}) AS act"))
                    ->leftJoin(DB::raw("({$compare_hdld}) AS hdld"), 'act.nik', '=', 'hdld.hdld_user')
                    ->leftJoin(DB::raw("({$compare_crt}) AS crt"), 'act.nik', '=', 'crt.crt_user')
                    ->leftJoin(DB::raw("({$compare_cl}) AS cl"), 'act.nik', '=', 'cl.cl_user')
                    ->select(
                        'act.act_user',
                        DB::raw($coalesceExpression)
                    )->get();
            }
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            if ($vdt == 'Week') {
                $headerColumns = ['No', 'User', 'Week 1', '', '', '', 'Week 2', '', '', '', 'Week 3', '', '', '', 'Week 4', '', '', '', 'Week 5', '', '', '',];
                $sheet->fromArray($headerColumns, NULL, 'A1');
                $sections = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'];
                $secRow = 'V';
                $excelName = 'Activitty Helpdesk Weekly';
                $row = 3;
            } else if($vdt == "Daily"){
                $headerColumns = ['No', 'User', 'Timeframe', 'Activity', 'Handled', 'Created', 'Closing'];
                $sheet->fromArray($headerColumns, NULL, 'A1');
                $secRow = 'G';
                $excelName = 'Activity Helpdesk Daily';
                $row = 2;
            } else {
                $headerColumns = [
                    'No', 
                    'User', 
                    'Januari', '', '', '', 
                    'Februari', '', '', '', 
                    'March', '', '', '', 
                    'April', '', '', '', 
                    'May', '', '', '', 
                    'June', '', '', '', 
                    'July', '', '', '', 
                    'August', '', '', '', 
                    'September', '', '', '', 
                    'October', '', '', '', 
                    'November', '', '', '', 
                    'December', '', '', '',];
                $sheet->fromArray($headerColumns, NULL, 'A1');
                $sections = [
                    'Januari', 
                    'Februari', 
                    'March', 
                    'April', 
                    'May', 
                    'June', 
                    'July', 
                    'August', 
                    'September', 
                    'October', 
                    'November', 
                    'December'
                ];
                $secRow = 'AX';
                $excelName = 'Activitty Helpdesk Monthly';
                $row = 3;
            }
            if ($vdt != "Daily") {
                $columnIndex = 3;
                foreach ($sections as $section) {
                    $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'ACT');
                    $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'HDLD');
                    $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CRT');
                    $sheet->setCellValueByColumnAndRow($columnIndex++, 2, 'CL');
                
                    $mergeRange = $sheet->getCellByColumnAndRow($columnIndex - 4, 1)->getColumn() . '1:' . $sheet->getCellByColumnAndRow($columnIndex - 1, 1)->getColumn() . '1';
                    $sheet->mergeCells($mergeRange);
                }
                
                $mergeCells = ['A1:A2', 'B1:B2'];
                
                foreach ($mergeCells as $mergeRange) {
                    $sheet->mergeCells($mergeRange);
                }
            }

            $no = 1;
            $style = [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_DOUBLE,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ];
            $style1 = [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP,
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ]
            ];
            $sheet->getStyle("A1:" . $secRow . "2")->applyFromArray($style);
            foreach ($excelData as $item) {
                    if ($vdt == 'Week') {
                        $data = [
                            $no,
                            $item->act_user,
                            $item->activity1,
                            $item->handled1,
                            $item->created1,
                            $item->closed1,
                            $item->activity2,
                            $item->handled2,
                            $item->created2,
                            $item->closed2,
                            $item->activity3,
                            $item->handled3,
                            $item->created3,
                            $item->closed3,
                            $item->activity4,
                            $item->handled4,
                            $item->created4,
                            $item->closed4,
                            $item->activity5,
                            $item->handled5,
                            $item->created5,
                            $item->closed5
                        ];
                    } else if($vdt == "Daily"){
                        $data = [
                            $no,
                            $item->full_name,
                            $item->timeframe,
                            $item->act_count,
                            $item->hdld_count,
                            $item->crt_count,
                            $item->cl_count
                        ];
                    } else {
                        $data = [
                            $no,
                            $item->act_user,
                            $item->activity1,
                            $item->handled1,
                            $item->created1,
                            $item->closed1,
                            $item->activity2,
                            $item->handled2,
                            $item->created2,
                            $item->closed2,
                            $item->activity3,
                            $item->handled3,
                            $item->created3,
                            $item->closed3,
                            $item->activity4,
                            $item->handled4,
                            $item->created4,
                            $item->closed4,
                            $item->activity5,
                            $item->handled5,
                            $item->created5,
                            $item->closed5,
                            $item->activity6,
                            $item->handled6,
                            $item->created6,
                            $item->closed6,
                            $item->activity7,
                            $item->handled7,
                            $item->created7,
                            $item->closed7,
                            $item->activity8,
                            $item->handled8,
                            $item->created8,
                            $item->closed8,
                            $item->activity9,
                            $item->handled9,
                            $item->created9,
                            $item->closed9,
                            $item->activity10,
                            $item->handled10,
                            $item->created10,
                            $item->closed10,
                            $item->activity11,
                            $item->handled11,
                            $item->created11,
                            $item->closed11,
                            $item->activity12,
                            $item->handled12,
                            $item->created12,
                            $item->closed12
                        ];
                    }

                    $sheet->fromArray([$data], NULL, "A$row");

                    $sheet->getStyle("A$row:".$secRow.$row)->applyFromArray($style1);
                $row++;
                $no++;
            }
            $filename = "$excelName.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    // Detil pending each week
    public function dtEHP($vdt,$timeframe,$hp,$month,$year){
        if ($vdt == 'Week') {
            if ($timeframe == 'Week 1') {
                $num1 = 1;
                $num2 = 7;
            } else if ($timeframe == 'Week 2'){
                $num1 = 8;
                $num2 = 14;
            } else if ($timeframe == 'Week 3'){
                $num1 = 15;
                $num2 = 21;
            } else if ($timeframe == 'Week 4'){
                $num1 = 22;
                $num2 = 28;
            }
            
            if ($month == 1) {
                $get_month = 'Januari';
            } elseif ($month == 2) {
                $get_month = 'Februari';
            } elseif ($month == 3) {
                $get_month = 'March';
            } elseif ($month == 4) {
                $get_month = 'April';
            } elseif ($month == 5) {
                $get_month = 'Mei';
            } elseif ($month == 6) {
                $get_month = 'June';
            } elseif ($month == 7) {
                $get_month = 'July';
            } elseif ($month == 8) {
                $get_month = 'August';
            } elseif ($month == 9) {
                $get_month = 'September';
            } elseif ($month == 10) {
                $get_month = 'October';
            } elseif ($month == 11) {
                $get_month = 'November';
            } elseif ($month == 12) {
                $get_month = 'December';
            }
            
            if ($hp == 'null') {
                if ($timeframe != 'Week 5') {
                    $data['each_created'] = DB::table(function ($query) use($year, $month, $num1, $num2) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(notiket) AS total_tiket')
                                                    ->from(function ($subquery) use ($year, $month, $num1, $num2) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MIN(created_at) AS note_terlama
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.note_terlama');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                        ->groupBy('notiket');
                                                    })
                                                    ->groupBy('nik');
                                            })->get();
                    $data['each_handled'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                    ->where('depart', 4)
                                                    ->groupBy('notiket', 'nik', 'periode');
                                            }, 'subquery')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_act'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                    ->where('depart', 4);
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_closed'] = DB::table(function ($query) use ($month, $year, $num1, $num2) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(*) AS total_close')
                                                    ->from(function ($subquery) use ($month, $year, $num1, $num2) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MAX(created_at) AS nt_last
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.nt_last');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                        ->whereRaw('status = 10')
                                                        ->groupBy('notiket');
                                                    })
                                                    ->groupBy('nik');
                                            })->get();
                } else {
                    $data['each_created'] = DB::table(function ($query) use($year, $month) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(notiket) AS total_tiket')
                                                    ->from(function ($subquery) use ($year, $month) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MIN(created_at) AS note_terlama
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.note_terlama');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) > 28")
                                                        ->groupBy('notiket');
                                                    })
                                                    ->groupBy('nik');
                                            })->get();
                    $data['each_handled'] = DB::table(function ($query) use ($year, $month) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) > 28")
                                                    ->where('depart', 4)
                                                    ->groupBy('notiket', 'nik');
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_act'] = DB::table(function ($query) use ($year, $month) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) > 28")
                                                    ->where('depart', 4);
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_closed'] = DB::table(function ($query) use ($month, $year) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(*) AS total_close')
                                                    ->from(function ($subquery) use ($month, $year) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MAX(created_at) AS nt_last
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.nt_last');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) > 28")
                                                        ->whereRaw('status = 10')
                                                        ->groupBy('notiket');
                                                    })
                                                    ->groupBy('nik');
                                            })->get();
                }
            } else {
                if ($timeframe != 'Week 5') {
                    $data['each_created'] = DB::table(function ($query) use($year, $month, $num1, $num2, $hp) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(notiket) AS total_tiket')
                                                    ->from(function ($subquery) use ($year, $month, $num1, $num2) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MIN(created_at) AS note_terlama
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.note_terlama');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                        ->groupBy('notiket');
                                                    })
                                                    ->where('nik', $hp)
                                                    ->groupBy('nik');
                                            })->get();
                                        
                    $data['each_handled'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                    ->where('depart', 4)
                                                    ->groupBy('notiket', 'nik');
                                            }, 'subquery')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                            ->where('nik', $hp)
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_act'] = DB::table(function ($query) use ($year, $month, $num1, $num2) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                    ->where('depart', 4);
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                            ->where('nik', $hp)
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_closed'] = DB::table(function ($query) use ($month, $year, $num1, $num2, $hp) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(*) AS total_close')
                                                    ->from(function ($subquery) use ($month, $year, $num1, $num2) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MAX(created_at) AS nt_last
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.nt_last');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) BETWEEN $num1 AND $num2")
                                                        ->whereRaw('status = 10')
                                                        ->groupBy('notiket');
                                                    })
                                                    ->where('nik', $hp)
                                                    ->groupBy('nik');
                                            })->get();
                } else {
                    $data['each_created'] = DB::table(function ($query) use($year, $month) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(notiket) AS total_tiket')
                                                    ->from(function ($subquery) use ($year, $month) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MIN(created_at) AS note_terlama
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.note_terlama');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) > 28")
                                                        ->groupBy('notiket');
                                                    })
                                                    ->where('nik', $hp)
                                                    ->groupBy('nik');
                                            })->get();
                    $data['each_handled'] = DB::table(function ($query) use ($year, $month) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) > 28")
                                                    ->where('depart', 4)
                                                    ->groupBy('notiket', 'nik');
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                            ->where('nik', $hp)
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_act'] = DB::table(function ($query) use ($year, $month) {
                                                $query->select('*')
                                                    ->from('vw_hgt_act_helpdesk')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $month")
                                                    ->whereRaw("DAY(created_at) > 28")
                                                    ->where('depart', 4);
                                            }, 'thd')
                                            ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                            ->where('nik', $hp)
                                            ->groupBy('nik')
                                            ->get();
                    $data['each_closed'] = DB::table(function ($query) use ($month, $year) {
                                                $query->selectRaw('nik, full_name,
                                                        COUNT(*) AS total_close')
                                                    ->from(function ($subquery) use ($month, $year) {
                                                        $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                            ->from(function ($innerSubquery) {
                                                                $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                    ->from('vw_hgt_act_helpdesk as t1')
                                                                    ->join(DB::raw('(
                                                                        SELECT notiket, MAX(created_at) AS nt_last
                                                                        FROM vw_hgt_act_helpdesk
                                                                        GROUP BY notiket
                                                                    ) t2'), function ($join) {
                                                                        $join->on('t1.notiket', '=', 't2.notiket')
                                                                            ->on('t1.created_at', '=', 't2.nt_last');
                                                                    });
                                                            }, 'vch')
                                                        ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                        ->whereRaw("YEAR(created_at) = $year")
                                                        ->whereRaw("MONTH(created_at) = $month")
                                                        ->whereRaw("DAY(created_at) > 28")
                                                        ->whereRaw('status = 10')
                                                        ->groupBy('notiket');
                                                    })
                                                    ->where('nik', $hp)
                                                    ->groupBy('nik');
                                            })->get();
                }
            }
        } else {
            if ($timeframe == 1) {
                $get_month = 'Januari';
            } elseif ($timeframe == 2) {
                $get_month = 'Februari';
            } elseif ($timeframe == 3) {
                $get_month = 'March';
            } elseif ($timeframe == 4) {
                $get_month = 'April';
            } elseif ($timeframe == 5) {
                $get_month = 'Mei';
            } elseif ($timeframe == 6) {
                $get_month = 'June';
            } elseif ($timeframe == 7) {
                $get_month = 'July';
            } elseif ($timeframe == 8) {
                $get_month = 'August';
            } elseif ($timeframe == 9) {
                $get_month = 'September';
            } elseif ($timeframe == 10) {
                $get_month = 'October';
            } elseif ($timeframe == 11) {
                $get_month = 'November';
            } elseif ($timeframe == 12) {
                $get_month = 'December';
            }
            
            if ($hp == 'null') {
                $data['each_created'] = DB::table(function ($query) use($year, $timeframe) {
                                            $query->selectRaw('nik, full_name,
                                                    COUNT(notiket) AS total_tiket')
                                                ->from(function ($subquery) use ($year, $timeframe) {
                                                    $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                        ->from(function ($innerSubquery) {
                                                            $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                ->from('vw_hgt_act_helpdesk as t1')
                                                                ->join(DB::raw('(
                                                                    SELECT notiket, MIN(created_at) AS note_terlama
                                                                    FROM vw_hgt_act_helpdesk
                                                                    GROUP BY notiket
                                                                ) t2'), function ($join) {
                                                                    $join->on('t1.notiket', '=', 't2.notiket')
                                                                        ->on('t1.created_at', '=', 't2.note_terlama');
                                                                });
                                                        }, 'vch')
                                                    ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $timeframe")
                                                    ->groupBy('notiket');
                                                })
                                                ->groupBy('nik');
                                        })->get();
                $data['each_handled'] = DB::table(function ($query) use ($year, $timeframe) {
                                            $query->select('*')
                                                ->from('vw_hgt_act_helpdesk')
                                                ->whereRaw("YEAR(created_at) = $year")
                                                ->whereRaw("MONTH(created_at) = $timeframe")
                                                ->where('depart', 4)
                                                ->groupBy('notiket', 'nik', 'periode_mt');
                                        }, 'subquery')
                                        ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                        ->groupBy('nik')
                                        ->get();
                $data['each_act'] = DB::table(function ($query) use ($year, $timeframe) {
                                            $query->select('*')
                                                ->from('vw_hgt_act_helpdesk')
                                                ->whereRaw("YEAR(created_at) = $year")
                                                ->whereRaw("MONTH(created_at) = $timeframe")
                                                ->where('depart', 4);
                                        }, 'thd')
                                        ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                        ->groupBy('nik')
                                        ->get();
                $data['each_closed'] = DB::table(function ($query) use ($timeframe, $year) {
                                            $query->selectRaw('nik, full_name,
                                                    COUNT(*) AS total_close')
                                                ->from(function ($subquery) use ($timeframe, $year) {
                                                    $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                        ->from(function ($innerSubquery) {
                                                            $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                ->from('vw_hgt_act_helpdesk as t1')
                                                                ->join(DB::raw('(
                                                                    SELECT notiket, MAX(created_at) AS nt_last
                                                                    FROM vw_hgt_act_helpdesk
                                                                    GROUP BY notiket
                                                                ) t2'), function ($join) {
                                                                    $join->on('t1.notiket', '=', 't2.notiket')
                                                                        ->on('t1.created_at', '=', 't2.nt_last');
                                                                });
                                                        }, 'vch')
                                                    ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $timeframe")
                                                    ->whereRaw('status = 10')
                                                    ->groupBy('notiket');
                                                })
                                                ->groupBy('nik');
                                        })->get();
            } else {
                $data['each_created'] = DB::table(function ($query) use($year, $timeframe) {
                                            $query->selectRaw('nik, full_name,
                                                    COUNT(notiket) AS total_tiket')
                                                ->from(function ($subquery) use ($year, $timeframe) {
                                                    $subquery->select('vch.notiket', 'nik', 'full_name', 'ht.created_at')
                                                        ->from(function ($innerSubquery) {
                                                            $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                ->from('vw_hgt_act_helpdesk as t1')
                                                                ->join(DB::raw('(
                                                                    SELECT notiket, MIN(created_at) AS note_terlama
                                                                    FROM vw_hgt_act_helpdesk
                                                                    GROUP BY notiket
                                                                ) t2'), function ($join) {
                                                                    $join->on('t1.notiket', '=', 't2.notiket')
                                                                        ->on('t1.created_at', '=', 't2.note_terlama');
                                                                });
                                                        }, 'vch')
                                                    ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $timeframe")
                                                    ->groupBy('notiket');
                                                })
                                                ->where('nik', $hp)
                                                ->groupBy('nik');
                                        })->get();
                $data['each_handled'] = DB::table(function ($query) use ($year, $timeframe) {
                                            $query->select('*')
                                                ->from('vw_hgt_act_helpdesk')
                                                ->whereRaw("YEAR(created_at) = $year")
                                                ->whereRaw("MONTH(created_at) = $timeframe")
                                                ->where('depart', 4)
                                                ->groupBy('notiket', 'nik');
                                        }, 'subquery')
                                        ->select('nik', 'full_name', DB::raw('COUNT(*) AS tiket_handled'))
                                        ->where('nik', $hp)
                                        ->groupBy('nik')
                                        ->get();
                $data['each_act'] = DB::table(function ($query) use ($year, $timeframe) {
                                            $query->select('*')
                                                ->from('vw_hgt_act_helpdesk')
                                                ->whereRaw("YEAR(created_at) = $year")
                                                ->whereRaw("MONTH(created_at) = $timeframe")
                                                ->where('depart', 4);
                                        }, 'thd')
                                        ->select('nik', 'full_name', DB::raw('COUNT(*) AS activity_ticket'))
                                        ->where('nik', $hp)
                                        ->groupBy('nik')
                                        ->get();
                $data['each_closed'] = DB::table(function ($query) use ($timeframe, $year) {
                                            $query->selectRaw('nik, full_name,
                                                    COUNT(*) AS total_close')
                                                ->from(function ($subquery) use ($timeframe, $year) {
                                                    $subquery->select('vch.notiket', 'nik', 'full_name', 'note', 'ht.created_at')
                                                        ->from(function ($innerSubquery) {
                                                            $innerSubquery->select('t1.notiket', 't1.nik', 't1.full_name', 't1.note')
                                                                ->from('vw_hgt_act_helpdesk as t1')
                                                                ->join(DB::raw('(
                                                                    SELECT notiket, MAX(created_at) AS nt_last
                                                                    FROM vw_hgt_act_helpdesk
                                                                    GROUP BY notiket
                                                                ) t2'), function ($join) {
                                                                    $join->on('t1.notiket', '=', 't2.notiket')
                                                                        ->on('t1.created_at', '=', 't2.nt_last');
                                                                });
                                                        }, 'vch')
                                                    ->leftJoin('hgt_ticket as ht', 'vch.notiket', '=', 'ht.notiket')
                                                    ->whereRaw("YEAR(created_at) = $year")
                                                    ->whereRaw("MONTH(created_at) = $timeframe")
                                                    ->whereRaw('status = 10')
                                                    ->groupBy('notiket');
                                                })
                                                ->where('nik', $hp)
                                                ->groupBy('nik');
                                        })->get();
            }
        }
        return view('Pages.Report.DT.detil-each-helpdesk')->with($data)
        ->with('validate', $vdt)
        ->with('timeframe', $timeframe)
        ->with('month', $get_month)
        ->with('year', $year);
    }
    // Report Pending Ticket
    public function pedningTicket(Request $request){
        $data['project'] = ProjectInTicket::all();
        
        if (empty($request->prj_pd_tc)) {
            $data['report'] = VRTP::all();
        } elseif (!empty($request->prj_pd_tc)) {
            $data['report'] = VRTP::all()
                                ->where('project_id', $request->prj_pd_tc);
        }
        
        return view('Pages.Report.pending-tc')->with($data)
        ->with('pdTC_prj', $request->prj_pd_tc);
    }
        // export excel pending ticket
        public function export_pdTC(Request $request)
        {       
            if (empty($request->pdtcFlter)) {
                $data_pending = VRTP::all();
            } else {
                $data_pending = VRTP::where('project_id', $request->pdtcFlter)->get();
            }
            $notikets = $data_pending->pluck('notiket')->unique()->toArray();
            $query_parts = VW_Tiket_Part::whereIn('notiket', $notikets)
                ->where('sts_type', 0)
                ->orderBy('send', 'DESC')
                ->orderBy('arrive', 'DESC')
                ->get()
                ->keyBy('notiket');

            $query_areas = VW_Act_Report_EN::whereIn('notiket', $notikets)
                ->where('status', 10)
                ->orderBy('visitting', 'DESC')
                ->get()
                ->keyBy('notiket');
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            $headers = 
            [
                'No',
                'No Tiket',
                'Case ID',
                'Location',
                'Service Point',
                'Kota User',
                'Project',
                'Email Coming',
                'Entry Date',
                'Pending Status',
                'Catatan',
                'SO',
                'Send',
                'ETA',
                'Arrive',
                'Go',
                'Work Start',
                'Work Stop'
            ];
            
            $sheet->fromArray([$headers], NULL, 'A1');

            $no = 1;
            $row = 2;
            foreach ($data_pending as $item) {
                $query_part = $query_parts->get($item->notiket);
                $query_are = $query_areas->get($item->notiket);

                    $data = [
                        $no,
                        $item->notiket,
                        $item->case_id,
                        $item->severity_name,
                        $item->service_name,
                        $item->kota,
                        $item->project_name,
                        $item->ticketcoming,
                        $item->entrydate,
                        $item->root_cause,
                        $item->note,
                        @$query_part->so_num,
                        @$query_part->send,
                        @$query_part->eta,
                        @$query_part->arrive,
                        @$query_are->gow,
                        @$query_are->work_start,
                        @$query_are->work_stop,
                    ];

                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                    $no++;
            }
            $filename = "Data Pending Ticket.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    // Report Top Part
    public function topPart(Request $request){
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $data['project'] = ProjectInTicket::all();
        if (empty($request->chosen_year) && empty($request->chosen_month)) {
            $get_year = $currentYear;
            $get_month = $currentMonth;
        } else {
            $get_year = $request->chosen_year;
            $get_month = $request->chosen_month;
        }
        $get_prj = $request->chosen_prj_part;

        $years = [];
        $months = [];

        // Get all years
        for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
            $years[] = Carbon::createFromDate($year, 1, 1)->format('Y');
        }

        // Get all months
        for ($month = 1; $month <= 12; $month++) {
            $monthNumber = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthName = Carbon::createFromDate(null, $month, 1)->format('F');
            $months[$monthNumber] = $monthName;
        }
        $getSort = [
            'loop_year' => $years,
            'loop_month' => $months,
        ];
        if (empty($get_prj)) {
            $data['part_ew'] = DB::table(function ($query) use($get_year, $get_month) {
                                    $query->selectRaw("type_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) >28 then 1 ELSE 0 END) AS week5")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->whereRaw("MONTH(created_at) = $get_month")
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
        
            $data['part_em'] = DB::table(function ($query) use($get_year) {
                                    $query->selectRaw("type_name,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS december")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
        } else {
            $data['part_ew'] = DB::table(function ($query) use($get_year, $get_month, $get_prj) {
                                    $query->selectRaw("type_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) >28 then 1 ELSE 0 END) AS week5")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->where('project_id', $get_prj)
                                        ->whereRaw("MONTH(created_at) = $get_month")
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
        
            $data['part_em'] = DB::table(function ($query) use($get_year, $get_prj) {
                                    $query->selectRaw("type_name,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS december")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->where('project_id', $get_prj)
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
        }
        
        return view('Pages.Report.top-part')
        ->with('year', $get_year)
        ->with('month', $get_month)
        ->with('prj_part', $get_prj)
        ->with($getSort)
        ->with($data);
    }
        // export excel Top Part Weekly
        public function export_ew_topPart(Request $request)
        {   
            $get_year = $request->year_ew_part;
            $get_month = $request->month_ew_part;
            $get_prj = $request->prj_ew_part;
            if (empty($get_prj)) {
                $data_topPart = DB::table(function ($query) use($get_year, $get_month) {
                                    $query->selectRaw("type_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) >28 then 1 ELSE 0 END) AS week5")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->whereRaw("MONTH(created_at) = $get_month")
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
            } else {
                $data_topPart = DB::table(function ($query) use($get_year, $get_month, $get_prj) {
                                    $query->selectRaw("type_name,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 7 then 1 ELSE 0 END) AS week1,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 8 AND 14 then 1 ELSE 0 END) AS week2,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 15 AND 21 then 1 ELSE 0 END) AS week3,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) BETWEEN 22 AND 28 then 1 ELSE 0 END) AS week4,
                                                SUM(CASE WHEN EXTRACT(DAY FROM created_at) >28 then 1 ELSE 0 END) AS week5")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->where('project_id', $get_prj)
                                        ->whereRaw("MONTH(created_at) = $get_month")
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
            }
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            $headers = 
            [
                'No',
                'Category',
                'Week 1',
                'Week 2',
                'Week 3',
                'Week 4',
                'Week 5'
            ];
            
            $sheet->fromArray([$headers], NULL, 'A1');

            $no = 1;
            $row = 2;
            foreach ($data_topPart as $item) {
                    $data = [
                        $no,
                        $item->type_name,
                        $item->week1,
                        $item->week2,
                        $item->week3,
                        $item->week4,
                        $item->week5
                    ];

                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                    $no++;
            }
            $filename = "Data Top Part Weekly.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
        // export excel Top Part Monthly
        public function export_em_topPart(Request $request)
        {   
            $get_year = $request->year_em_part;
            $get_prj = $request->prj_em_part;
            if (empty($get_prj)) {
                $data_topPart = DB::table(function ($query) use($get_year) {
                                    $query->selectRaw("type_name,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS december")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
            } else {
                $data_topPart = DB::table(function ($query) use($get_year, $get_prj) {
                                    $query->selectRaw("type_name,
                                            SUM(CASE WHEN MONTH(created_at) = 1 then 1 ELSE 0 END) AS jan,
                                            SUM(CASE WHEN MONTH(created_at) = 2 then 1 ELSE 0 END) AS feb,
                                            SUM(CASE WHEN MONTH(created_at) = 3 then 1 ELSE 0 END) AS march,
                                            SUM(CASE WHEN MONTH(created_at) = 4 then 1 ELSE 0 END) AS april,
                                            SUM(CASE WHEN MONTH(created_at) = 5 then 1 ELSE 0 END) AS may,
                                            SUM(CASE WHEN MONTH(created_at) = 6 then 1 ELSE 0 END) AS june,
                                            SUM(CASE WHEN MONTH(created_at) = 7 then 1 ELSE 0 END) AS july,
                                            SUM(CASE WHEN MONTH(created_at) = 8 then 1 ELSE 0 END) AS aug,
                                            SUM(CASE WHEN MONTH(created_at) = 9 then 1 ELSE 0 END) AS sept,
                                            SUM(CASE WHEN MONTH(created_at) = 10 then 1 ELSE 0 END) AS october,
                                            SUM(CASE WHEN MONTH(created_at) = 11 then 1 ELSE 0 END) AS nov,
                                            SUM(CASE WHEN MONTH(created_at) = 12 then 1 ELSE 0 END) AS december")
                                        ->from('vw_hgt_tiket_part_detail')
                                        ->where('sts_type', 0)
                                        ->where('project_id', $get_prj)
                                        ->whereRaw("YEAR(created_at) = $get_year")
                                        ->groupBy('category_part');
                                })->get();
            }
            
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Sheet 1');
            $headers = 
            [
                'No',
                'Category',
                'Jan',
                'Feb',
                'March',
                'April',
                'May',
                'June',
                'July',
                'Augs',
                'Sept',
                'Oct',
                'Nov',
                'Desc'
            ];
            
            $sheet->fromArray([$headers], NULL, 'A1');

            $no = 1;
            $row = 2;
            foreach ($data_topPart as $item) {
                    $data = [
                        $no,
                        $item->type_name,
                        $item->jan,
                        $item->feb,
                        $item->march,
                        $item->april,
                        $item->may,
                        $item->june,
                        $item->july,
                        $item->aug,
                        $item->sept,
                        $item->october,
                        $item->nov,
                        $item->december
                    ];

                    $sheet->fromArray([$data], NULL, "A$row");
                    $row++;
                    $no++;
            }
            $filename = "Data Top Part Monthly.xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit();
        }
    
    public function report_tc_adm(Request $request)
    {
        $now = Carbon::now()->endOfDay();
        $oneMonthAgo = $now->copy()->startOfDay()->subMonth(1);
        $tanggal1 = $request->st_date_report.' '.'00:00:00';
        $tanggal2 = $request->nd_date_report.' '.'23:59:59';
        $data['partner'] = Partner::select('partner_id', 'partner')->where('deleted', 0)->get();
        $data['project'] = VW_ReportTicket::select('project_id', 'project_name')->groupBy('project_name')->get();
        $data['office'] = VW_ReportTicket::select('service_id', 'service_name')->where('service_id', '!=', '')->groupBy('service_name')->get();
        if (!empty($request->st_date_report) && !empty($request->nd_date_report)) {
            $eventTgl1 = $tanggal1;
            $eventTgl2 = $tanggal2;
        } else {
            $eventTgl1 = $oneMonthAgo;
            $eventTgl2 = $now;
        }
        if (!isset($request->stats_report) && 
            !isset($request->sort_sp_report) && 
            (!isset($request->prt_id) && !isset($request->sort_prj_report))) {
            $data['report'] = VW_ReportTicket::all()->whereBetween('entrydate', [$eventTgl1, $eventTgl2]);
        } elseif(isset($request->stats_report) || (isset($request->prt_id) || isset($request->sort_prj_report)) || isset($request->sort_sp_report)) {
            if (!empty($request->stats_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_ReportTicket::where('status', '!=', 10)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_ReportTicket::where('status', 10)
                    ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            } elseif ((!empty($request->prt_id) || !empty($request->sort_prj_report)) && empty($request->stats_report) && empty($request->sort_sp_report)) {
                if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                    $data['report'] = VW_ReportTicket::where('partner_id', $request->prt_id)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_ReportTicket::where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                }
            } elseif (!empty($request->sort_sp_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && empty($request->stats_report)) {
                $data['report'] = VW_ReportTicket::where('service_id', $request->sort_sp_report)
                                    ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
            } elseif (!empty($request->stats_report) && (!empty($request->prt_id) || !empty($request->sort_prj_report)) && empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                        $data['report'] = VW_ReportTicket::where('status', '<', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                    } else {
                        $data['report'] = VW_ReportTicket::where('status', '<', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->where('project_id', $request->sort_prj_report)
                                            ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                    }
                } else {
                    if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                        $data['report'] = VW_ReportTicket::where('status', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                    } else {
                        $data['report'] = VW_ReportTicket::where('status', 10)
                                            ->where('partner_id', $request->prt_id)
                                            ->where('project_id', $request->sort_prj_report)
                                            ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                    }
                }
            } elseif (!empty($request->stats_report) && (empty($request->prt_id) && empty($request->sort_prj_report)) && !empty($request->sort_sp_report)) {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_ReportTicket::where('status', '!=', 10)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_ReportTicket::where('status', 10)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            } elseif (empty($request->stats_report) && (!empty($request->prt_id) || !empty($request->sort_prj_report)) && !empty($request->sort_sp_report)) {
                if (!empty($request->prt_id) && empty($request->sort_prj_report)) {
                    $data['report'] = VW_ReportTicket::where('service_id', $request->sort_sp_report)
                                        ->where('partner_id', $request->prt_id)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_ReportTicket::where('service_id', $request->sort_sp_report)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                }
            } else {
                if ($request->stats_report == 1) {
                    $data['report'] = VW_ReportTicket::where('status', '!=', 10)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('entrydate', [$tanggal1, $tanggal2])->get();
                } else {
                    $data['report'] = VW_ReportTicket::where('status', 10)
                                        ->where('partner_id', $request->prt_id)
                                        ->where('project_id', $request->sort_prj_report)
                                        ->where('service_id', $request->sort_sp_report)
                                        ->whereBetween('closedate', [$tanggal1, $tanggal2])->get();
                }
            }
        }
        return view('Pages.Report.report-tc-admin')->with($data)
        ->with('sts', $request->stats_report)
        ->with('prj', $request->sort_prj_report)
        ->with('prt', $request->prt_id)
        ->with('sp', $request->sort_sp_report)
        ->with('stsd', $oneMonthAgo)
        ->with('ndsd', $now)
        ->with('str', $request->st_date_report)
        ->with('ndr', $request->nd_date_report);
    }
    
    public function export_dt_ticket(Request $request)
    {
        $extanggal1 = $request->ex_st;
        $extanggal2 = $request->ex_nd;
        $ex_sts = $request->ex_sts;
        $ex_prj = $request->ex_prj;
        $ex_prt = $request->ex_prt;
        $ex_sp = $request->ex_sp;
        if (!isset($ex_sts) && 
            !isset($ex_sp) && 
            (!isset($ex_prt) && !isset($ex_prj))) {
            $data_ticket = VW_ReportTicket::all()->whereBetween('entrydate', [$extanggal1, $extanggal2]);
        } elseif(isset($ex_sts) || (isset($ex_prt) || isset($ex_prj)) || isset($ex_sp)) {
            if (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_ReportTicket::where('status', '!=', 10)
                                        ->whereBetween('entrydate', [$tanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_ReportTicket::where('status', 10)
                    ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif ((!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sts) && empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_ReportTicket::where('partner_id', $ex_prt)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_ReportTicket::where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                }
            } elseif (!empty($ex_sp) && (empty($ex_prt) && empty($ex_prj)) && empty($ex_sts)) {
                $data_ticket = VW_ReportTicket::where('service_id', $ex_sp)
                                    ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
            } elseif (!empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && empty($ex_sp)) {
                if ($ex_sts == 1) {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_ReportTicket::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_ReportTicket::where('status', '<', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                    }
                } else {
                    if (!empty($ex_prt) && empty($ex_prj)) {
                        $data_ticket = VW_ReportTicket::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                    } else {
                        $data_ticket = VW_ReportTicket::where('status', 10)
                                            ->where('partner_id', $ex_prt)
                                            ->where('project_id', $ex_prj)
                                            ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                    }
                }
            } elseif (!empty($ex_sts) && (empty($ex_prt) && empty($ex_prj)) && !empty($ex_sp)) {
                if ($ex_sts == 1) {
                    $data_ticket = VW_ReportTicket::where('status', '!=', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_ReportTicket::where('status', 10)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            } elseif (empty($ex_sts) && (!empty($ex_prt) || !empty($ex_prj)) && !empty($ex_sp)) {
                if (!empty($ex_prt) && empty($ex_prj)) {
                    $data_ticket = VW_ReportTicket::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_ReportTicket::where('service_id', $ex_sp)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                }
            } else {
                if ($ex_sts == 1) {
                    $data_ticket = VW_ReportTicket::where('status', '!=', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('entrydate', [$extanggal1, $extanggal2])->get();
                } else {
                    $data_ticket = VW_ReportTicket::where('status', 10)
                                        ->where('partner_id', $ex_prt)
                                        ->where('project_id', $ex_prj)
                                        ->where('service_id', $ex_sp)
                                        ->whereBetween('closedate', [$extanggal1, $extanggal2])->get();
                }
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'No Tiket',
            'Case ID',
            'SLA Name',
            'Email Masuk',
            'Entry Date',
            'Deadline',
            'Jadwal Engineer',
            'Close Date',
            'Source',
            'Project',
            'Customer',
            'Company',
            'Phone',
            'Email',
            'Address',
            'Location',
            'Problem',
            'Action Plan',
            'Repair Way',
            'Category Unit',
            'Merk Unit',
            'Type Unit',
            'SN',
            'PN',
            'Warranty',
            'Part Request',
            'SO Number',
            'Unit Name',
            'Service Point',
            'Engineer',
            'Status',
            'Helpdesk',
            'Type Note',
            'Description',
            'Created At'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        function dateExcel($dateTime)
        {
            return Carbon::parse($dateTime)->format('n/j/Y  g:i:s A');
        }
        foreach ($data_ticket as $item) {
            $rowspan_part = $item->parts->count();
            $rowspan_note = $item->notes->count();
            $rowspan = max($rowspan_part, $rowspan_note, 1);
            $query_part = $item->parts;
            $query_note = $item->notes;
            for ($i = 0; $i < $rowspan; $i++) {
                for ($a = 0; $a < 27; $a++) {
                    $col = $a < 26 ? chr(65 + $a) : chr(65 + floor($a / 26) - 1) . chr(65 + ($a % 26));
                    $sheet->mergeCells("$col$row:$col" . ($row + $rowspan - 1));
                }
                $sheet->mergeCells("AD$row:AD" . ($row + $rowspan - 1));
                $sheet->mergeCells("AE$row:AE" . ($row + $rowspan - 1));
                $sheet->mergeCells("AF$row:AF" . ($row + $rowspan - 1));
                $data = [
                    $no,
                    $item->notiket,
                    $item->case_id,
                    $item->sla_name,
                    dateExcel($item->ticketcoming),
                    dateExcel($item->entrydate),
                    dateExcel($item->deadline),
                    dateExcel($item->departure),
                    dateExcel($item->closedate),
                    $item->sumber_name,
                    $item->project_name,
                    $item->contact_person,
                    $item->company,
                    $item->phone,
                    $item->email,
                    $item->address,
                    $item->severity_name,
                    $item->problem,
                    $item->action_plan,
                    $item->solve,
                    $item->category_name,
                    $item->merk,
                    $item->type_name,
                    $item->sn,
                    $item->pn,
                    $item->garansi,
                    $item->part_request,
                        $query_part->isEmpty() ? '' : ($query_part->has($i) ? $query_part[$i]->so_num : ''),
                        $query_part->isEmpty() ? '' : ($query_part->has($i) ? $query_part[$i]->unit_name : ''),
                    $item->service_name,
                    $item->full_name,
                    $item->dtStatus,
                        $query_note->isEmpty() ? '' : ($query_note->has($i) ? $query_note[$i]->full_name : ''),
                        $query_note->isEmpty() ? '' : ($query_note->has($i) ? $query_note[$i]->ktgr_name : ''),
                        $query_note->isEmpty() ? '' : ($query_note->has($i) ? $query_note[$i]->note : ''),
                        $query_note->isEmpty() || !$query_note->has($i) ? '' : dateExcel($query_note[$i]->created_at) 
                ];
                $sheet->fromArray([$data], NULL, "A$row");
                $row++;
            }
            $no++;
        }
        $filename = "Report Detail Ticket.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}