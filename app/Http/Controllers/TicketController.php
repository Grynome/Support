<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\TicketMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Query\Expression;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\Source;
use App\Models\CategoryUnit;
use App\Models\TypeUnit;
use App\Models\ServicePoint;
use App\Models\User;
use App\Models\SLA;
use App\Models\Merk;
use App\Models\Customer;
use App\Models\NewPart;
use App\Models\ReqsPart;
use App\Models\TiketPart;
use App\Models\TiketPartNew;
use App\Models\TiketPartDetail;
use App\Models\TiketInfo;
use App\Models\LogTiket;
use App\Models\VW_Ticket;
use App\Models\Severity;
use App\Models\VW_Tiket_Part;
use App\Models\Partner;
use App\Models\ProjectInfo;
use App\Models\ActivityEngineer;
use App\Models\VW_Activity_Engineer;
use App\Models\AttachmentFile;
use App\Models\EngineerAttachment;
use App\Models\ListPartAWB;
use App\Models\VW_List_Part_AWB;
use App\Models\LoggingLogistik;
use App\Models\PartType;
use App\Models\VW_LogLogistik;
use App\Models\OfficeType;
use App\Models\Notification;
use App\Models\LoggingHGT;
use App\Models\VW_List_Engineer;
use App\Models\MerkCategory;
use App\Models\TypeTicket;
use App\Models\CategoryPart;
use App\Models\VW_Docs;
use App\Models\VW_Log_Note_Tiket;
use App\Models\CategoryNote;
use App\Models\TiketPendingDaily;
use App\Models\VW_ReportTicket;
use App\Models\ProjectInTicket;
use App\Models\ManageTicketProcs;
use App\Models\Ticketing;
use App\Models\LogAdmin;
use App\Models\ReimburseEn;
use App\Models\AttReimburseEn;
use App\Models\StsPending;
use App\Models\ActivityL2En;
use App\Models\VW_Activity_L2Engineer;


class TicketController extends Controller
{
    public function manage(Request $request)
    {
        $depart =  auth()->user()->depart;
        $role =  auth()->user()->role;
        $nik =  auth()->user()->nik;
        $get_partner = $request->filter_prt;
        $get_project = $request->filter_prj;
        $get_stDate = $request->st_date;
        $get_ndDate = $request->nd_date;
        if ($depart == 4 || $role == 20 || $role == 15 || $depart == 3 || $depart == 5) {
            $data['project'] = ProjectInTicket::all();
            $data['partner'] = Partner::select('partner_id', 'partner')->where('deleted', 0)->get();
        }
        if ($depart == 4 || $role == 20 || $role == 15 || $depart == 3 || $depart == 5) {
            if ((isset($get_partner) || isset($get_project)) && (!isset($get_stDate) && !isset($get_ndDate))) {
                if (isset($get_project)) {
                    $data['ticket'] = ManageTicketProcs::where('partner_id', $get_partner)->where('project_id', $get_project)->get();
                } else {
                    $data['ticket'] = ManageTicketProcs::where('partner_id', $get_partner)->get();
                }
            } elseif ((isset($get_partner) || isset($get_project)) && (isset($get_stDate) && isset($get_ndDate))) {
                if (isset($get_project)) {
                    $data['ticket'] = ManageTicketProcs::where('partner_id', $get_partner)->where('project_id', $get_project)
                                    ->whereBetween('departure', [$get_stDate.' '.'00:00:00', $get_ndDate.' '.'23:59:59'])->get();
                } else {
                    $data['ticket'] = ManageTicketProcs::where('partner_id', $get_partner)
                                    ->whereBetween('departure', [$get_stDate.' '.'00:00:00', $get_ndDate.' '.'23:59:59'])->get();
                }
            } elseif (!isset($get_partner) && !isset($get_project) && (isset($get_stDate) && isset($get_ndDate))) {
                $data['ticket'] = ManageTicketProcs::whereBetween('departure', [$get_stDate.' '.'00:00:00', $get_ndDate.' '.'23:59:59'])->get();
            }else {
                $data['ticket'] = ManageTicketProcs::get();
            }
        } elseif ($depart == 6 || $depart == 13 || $role == 1) {
            if ($role == 1) {
                $data['ticket'] = ManageTicketProcs::where('status', '!=', 0)->get();
            } elseif ($depart == 6) {
                $data['ticket'] = ManageTicketProcs::where('nik', $nik)->where('status', '!=', 0)->get();
            } elseif ($depart == 13) {
                $data['ticket'] = ManageTicketProcs::where('l2_nik', $nik)->where('status', '!=', 0)->get();
            }
        } else if ($depart == 9){
            $data['ticket'] = Ticketing::where('status', 10)->where('total_return', '>', 0)->where('status_awb', 0)
                                ->whereIn('project_id', ['PRJ-020-HGT', 'PRJ-021-HGT'])->get();
        } else if ($depart == 10){
            $data['ticket'] = Ticketing::where('status', 10)->where('status_docs', 0)->get();
        }
        
        return view('Pages.Ticket.manage')->with($data)
            ->with('prt_id', $get_partner)
            ->with('prj_id', $get_project)
            ->with('val_stDate', $get_stDate)
            ->with('val_ndDate', $get_ndDate);
    }
    public function closed_page(Request $request)
    {
        $depart =  auth()->user()->depart;
        
        $now = Carbon::now()->addHours(7)->format('Y-m-d');
        $oneMonthAgo = Carbon::parse($now)->subMonth(1)->format('Y-m-d');   

        if (empty($request->stCl_date) && empty($request->ndCl_date)) {
            $tanggal1 = $oneMonthAgo;
            $tanggal2 = $now;
        } else {
            $tanggal1 = $request->stCl_date;
            $tanggal2 = $request->ndCl_date;
        }
        if ($depart == 6) {
            $nik =  auth()->user()->nik;
            $data['ticket_closed'] = DB::table(function ($query) use($nik, $tanggal1, $tanggal2) {
                                    $query->selectRaw("ht.notiket, 
                                            case_id, 
                                            heu.end_user_name as company,
                                            hti.sn,
                                            entrydate,
                                            closedate,
                                            hp.project_name,
                                            case
                                                when ht.status = 10 then 'closed'
                                            end as status,
                                            status_awb,
                                            status_docs")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_end_user as heu', 'hpi.end_user_id', '=', 'heu.end_user_id')
                                        ->leftJoin('hgt_tiket_info as hti', 'ht.notiket', '=', 'hti.notiket')
                                        ->whereBetween('closedate', [$tanggal1.' '.'00:00:00', $tanggal2.' '.'23:59:59'])
                                        ->where('en_id', $nik)
                                        ->orderBy('entrydate','desc');
                                })->get();
        } else if($depart == 10) {
            $data['ticket_closed'] = Ticketing::where('status_docs', 1)->whereBetween('docs_rcv_at', [$tanggal1.' '.'00:00:00', $tanggal2.' '.'23:59:59'])->get();
        } else if($depart == 9) {
            $data['ticket_closed'] = Ticketing::where('status_awb', 1)->whereBetween('awb_at', [$tanggal1.' '.'00:00:00', $tanggal2.' '.'23:59:59'])->get();
        } else {
            $data['ticket_closed'] = DB::table(function ($query) use($tanggal1, $tanggal2) {
                                    $query->selectRaw("ht.notiket, 
                                            case_id, 
                                            heu.end_user_name as company,
                                            hti.sn,
                                            entrydate,
                                            closedate,
                                            hp.project_name,
                                            case
                                                when ht.status = 10 then 'closed'
                                            end as status,
                                            status_awb,
                                            status_docs")
                                        ->from('hgt_ticket as ht')
                                        ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                        ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                        ->leftJoin('hgt_end_user as heu', 'hpi.end_user_id', '=', 'heu.end_user_id')
                                        ->leftJoin('hgt_tiket_info as hti', 'ht.notiket', '=', 'hti.notiket')
                                        ->whereBetween('closedate', [$tanggal1.' '.'00:00:00', $tanggal2.' '.'23:59:59']);
                                })->get();
        }
        return view('Pages.Ticket.closed')->with($data)
        ->with('st_dt_cl', $tanggal1)
        ->with('nd_dt_cl', $tanggal2);
    }
    public function ticket_today(Request $request)
    {
        $now = Carbon::now()->addHours(7)->format('Y-m-d');
        $data['ticket'] = ManageTicketProcs::whereBetween('departure', [$now.' '.'00:00:00', $now.' '.'23:59:59'])->get();
        return view('Pages.Ticket.today')->with($data);
    }
    public function form()
    {
        $data['project'] = Project::all()->where('deleted', '!=', 1);
        $data['src'] = Source::all()->where('deleted', '!=', 1);
        $data['ctgru'] = CategoryUnit::all()->where('deleted', '!=', 1);
        $data['tpu'] = TypeUnit::all()->where('deleted', '!=', 1);
        $data['sp'] = ServicePoint::all()->where('deleted', '!=', 1);
        $data['sla'] = SLA::all()->where('deleted', '!=', 1);
        $data['province'] = \Indonesia::allProvinces()->where('deleted', '!=', 1);
        $data['merk'] = Merk::all()->where('deleted', '!=', 1);
        $data['severity'] = Severity::all()->where('deleted', '!=', 1);
        $data['partner'] = Partner::all()->where('deleted', '!=', 1);
        $data['type'] = PartType::all()->where('deleted', '!=', 1);
        $data['customer'] = Customer::all()->where('deleted', '!=', 1);
        $data['office_type'] = OfficeType::all()->where('deleted', '!=', 1);
        return view('Pages/Ticket/form')->with($data);
    }
    public function notabs()
    {
        $data['project'] = Project::all()->where('deleted', 0);
        $data['l2'] = User::all()->where('depart', 13)->where('verify', 1);
        $data['src'] = Source::all()->where('deleted', 0);
        $data['ctgru'] = CategoryUnit::all()->where('deleted', 0);
        $data['tpu'] = TypeUnit::all()->where('deleted', 0);
        $data['sp'] = ServicePoint::all()->where('deleted', 0);
        $data['sla'] = SLA::all()->where('deleted', 0);
        $data['province'] = \Indonesia::allProvinces()->where('deleted', 0);
        $data['merk'] = Merk::all()->where('deleted', 0);
        $data['severity'] = Severity::all()->where('deleted', 0);
        $data['partner'] = Partner::all()->where('deleted', 0);
        $data['type'] = PartType::all()->where('deleted', 0);
        $data['customer'] = Customer::all()->where('deleted', 0);
        $data['office_type'] = OfficeType::all()->where('deleted', 0);
        $data['unit_detil'] = MerkCategory::all()->where('deleted', 0);
        $data['type_ticket'] = TypeTicket::all()->where('deleted', 0);
        $data['ctgr_part'] = CategoryPart::all()->where('deleted', 0);
        return view('Pages.Ticket.page')->with($data);
    }
    public function add_ticket(Request $request){
        $tgl = date("Y-m-d", strtotime("+7 hours"));
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $nik =  auth()->user()->nik;
        function getRomawi($bln){
            $array_bln = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
            return $array_bln[$bln];
        }
        $roman = getRomawi(date('n'));
        $dtGenerate = Carbon::now()->addHours(7)->format('ymd');
        $get_id = Ticket::where('entrydate','LIKE','%'.$tgl.'%')->orderBy('notiket','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $kode_awal = $dtGenerate."00".$int;
        } else {
            $notiket = $get_id[0]->notiket;
            // if ($roman == "II" || $roman == "IV" || $roman == "VI" || $roman == "IX" || $roman == "XI") {
            //     $num = substr($notiket, 15,15);
            // } elseif ($roman == "III" || $roman == "VII" || $roman == "XII") {
            //     $num = substr($notiket, 16,16);
            // } elseif ($roman == "VIII") {
            //     $num = substr($notiket, 17,17);
            // }else{
            //     $num = substr($notiket, 14,14);
            // }
            $num = substr($notiket, 6,6);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $kode_awal = $dtGenerate."0".$int;
            }elseif($int > 99 && $int < 1000){
                $kode_awal = $dtGenerate.$int;
            }elseif($int <= 9){
                $kode_awal = $dtGenerate."00".$int;
            }
        }

        $get_cust = Customer::orderBy('id','desc')->take(1)->get();
        if ($get_cust->isEmpty()) {
            $ai = 1;
                $id_cust = "CUST-00".$ai."-HGT";
        } else {
            $id_customer = $get_cust[0]->end_user_id;
            $get_int = substr($id_customer, 5,4);
            $ai = (int)$get_int;
            $ai++;
            if($ai > 9 && $ai < 100){
                $id_cust = "CUST-0".$ai."-HGT";
            }elseif($ai > 99){
                $id_cust = "CUST-".$ai."-HGT";
            }elseif($ai <= 9){
                $id_cust = "CUST-00".$ai."-HGT";
            }
        }

        if (empty($request->sch)) {
            $schedule = null;
        } elseif (!empty($request->sch)) {
            $schedule = date('Y-m-d H:i', strtotime($request->sch));
        }

        $get_part = TiketPartNew::orderBy('id','desc')->take(1)->get();
        if ($get_part->isEmpty()) {
                $autonumber = 1;
                $id_part = "HGT-PART-00".$autonumber;
        } else {
            $data_part = $get_part[0]->part_detail_id;
            $get_int_part = substr($data_part, 9);
            $autonumber = (int)$get_int_part;
            $autonumber++;
            if($autonumber > 9 && $autonumber < 100){
                $id_part = "HGT-PART-0".$autonumber;
            }elseif($autonumber > 99){
                $id_part = "HGT-PART-".$autonumber;
            }elseif($autonumber <= 9){
                $id_part = "HGT-PART-00".$autonumber;
            }
        }

        for ($i = 0; $i < $request->how_many; $i++) {
            $values_ticket = [
                'notiket'           => $kode_awal,
                'type_ticket'    => $request->type_ticket,
                'case_id'    => $request->reference_id,
                'entrydate'    => $dateTime,
                'ticketcoming'    => $request->date_come,
                'l2_id'    => $request->l2_engineer,
                'en_id'    => $request->engineer,
                'service_point'    => $request->servp,
                'schedule'    => $schedule,
                'sumber_id'    => $request->source_id,
                'sla'    => $request->sla,
                'severity'    => $request->severity,
                'part_reqs'    => $request->part_reqs,
                'created_at'    => $dateTime
            ];
            $values_cust = [
                'end_user_id'           => $id_cust,
                'end_user_name'    => $request->company_name,
                'office_type_id'    => $request->type_kantor,
                'contact_person'    => $request->contact_name,
                'phone'    => $request->input('phone_cust'),
                'ext_phone'    => $request->input('phone_ext'),
                'email'    => $request->input('email_cust'),
                'provinces'    => $request->provinces,
                'cities'    => $request->cities,
                'address'    => $request->addres_cst,
                'deleted'    => 0,
                'created_at'    => $dateTime
            ];
        
            $values_prj_info = [
                'notiket'           => $kode_awal,
                'project_id'           => $request->project_id,
                'end_user_id'      => $id_cust,
                'created_at'    => $dateTime
            ];

            $query_ticket = Ticket::insert($values_ticket);
            $query_cust = Customer::insert($values_cust);
            $queryPI = ProjectInfo::insert($values_prj_info);

            $autonumber++;
            if ($request->part_reqs == 1) {
                $values_tiket_part_n = [
                    'notiket'           => $kode_awal,
                    'part_detail_id'    => $id_part
                ];
                $values_tiket_part_dt = [
                    'part_detail_id'           => $id_part,
                    'unit_name'    => $request->type_unit,
                    'category_part'    => $request->kat_part,
                    'so_num'    => $request->so_num,
                    'rma'    => $request->rma_num,
                    'pn'    => $request->product_number,
                    'sn'    => $request->serial_number,
                    'type_part'    => $request->status_part,
                    'status'    => 0,
                    'created_at'    => $dateTime
                ];
                $queryPartN = TiketPartNew::insert($values_tiket_part_n);
                $queryTPD = TiketPartDetail::insert($values_tiket_part_dt);
                if($ai < 1000){
                    $id_part = "HGT-PART-".str_pad($autonumber, 3, "0", STR_PAD_LEFT);
                }elseif($ai > 999 && $ai < 10000){
                    $id_part = "HGT-PART-".str_pad($autonumber, 4, "0", STR_PAD_LEFT);
                }elseif($ai > 9999){
                    $id_part = "HGT-PART-".str_pad($autonumber, 5, "0", STR_PAD_LEFT);
                }
            }
            if (isset($request->type_unit_adding) && !isset($request->type_id)) {
                $values_unit_model = [
                    'type_name'           => $request->type_unit_adding,
                    'category_id'    => $request->ctgrpi_id,
                    'merk_id'    => $request->merk_id
                ];
                TypeUnit::insert($values_unit_model);
                $unitType = TypeUnit::all()->where('type_name',$request->type_unit_adding)->first();
                $values_info = [
                    'notiket'           => $kode_awal,
                    'category_id'    => $request->ctgrpi_id,
                    'merk_id'    => $request->merk_id,
                    'type_id'    => $unitType->id,
                    'sn'    => $request->sn_unit,
                    'pn'    => $request->pn_unit,
                    'warranty'    => $request->warranty,
                    'problem'    => $request->problematika,
                    'action_plan'    => $request->action_plan,
                    'created_at'    => $dateTime
                ];
                $queryTI = TiketInfo::insert($values_info);
            } else if (isset($request->type_id) && !isset($request->type_unit_adding)) {
                $values_info = [
                    'notiket'           => $kode_awal,
                    'category_id'    => $request->ctgrpi_id,
                    'merk_id'    => $request->merk_id,
                    'type_id'    => $request->type_id,
                    'sn'    => $request->sn_unit,
                    'pn'    => $request->pn_unit,
                    'warranty'    => $request->warranty,
                    'problem'    => $request->problematika,
                    'action_plan'    => $request->action_plan,
                    'created_at'    => $dateTime
                ];
                $queryTI = TiketInfo::insert($values_info);
            }else{
                if (isset($request->sn_unit) || isset($request->pn_unit) || isset($request->warranty) || isset($request->problematika) || isset($request->action_plan)) {
                    $values_info = [
                        'notiket'           => $kode_awal,
                        'category_id'    => $request->ctgrpi_id,
                        'merk_id'    => $request->merk_id,
                        'type_id'    => $request->type_id,
                        'sn'    => $request->sn_unit,
                        'pn'    => $request->pn_unit,
                        'warranty'    => $request->warranty,
                        'problem'    => $request->problematika,
                        'action_plan'    => $request->action_plan,
                        'created_at'    => $dateTime
                    ];
                    $queryTI = TiketInfo::insert($values_info);
                }
            }
            $notif = [
                'kunci'    => $kode_awal,
                'bagian'    => "Ticket",
                'from_user'    => $nik,
                'to_user'    => $request->engineer,
                'note'     => "New Ticket Coming",
                'status'     => 0,
                'created_at'     => $dateTime
            ];

            $logging = [
                'notiket'    => $kode_awal,
                'note'    => "Data Ticket Entry",
                'user'     => $nik,
                'type_log'     => 1,
                'created_at'     => $dateTime
            ];
            $queryNotif = Notification::insert($notif);
            $queryLogTiket = LogTiket::insert($logging);

            // $ticket = VW_Ticket::all()->where('notiket', $kode_awal)->first();
            // $note = VW_Log_Note_Tiket::where('notiket', $kode_awal)->get();
            // Mail::to('gery@hgt-services.com')->send(new TicketMailable($ticket, $note));
            $int++;
            $ai++;
            if($ai < 1000){
            	$id_cust = "CUST-".str_pad($ai, 3, "0", STR_PAD_LEFT)."-HGT";
            }elseif($ai > 999 && $ai < 10000){
            	$id_cust = "CUST-".str_pad($ai, 4, "0", STR_PAD_LEFT)."-HGT";
            }elseif($ai > 9999){
            	$id_cust = "CUST-".str_pad($ai, 5, "0", STR_PAD_LEFT)."-HGT";
            }
            $kode_awal = $dtGenerate.str_pad($int, 3, "0", STR_PAD_LEFT);
        }
            
        $files = $request->file('file');
        if (isset($files)) {
            foreach($files as $file) {
                $fileName = uniqid().'_'.$file->getClientOriginalName();
                $path = 'files/'.$fileName;
                if (!$path) {
                    return response()->json([
                        'error' => 'File upload failed.',
                    ], 500);
                }
                $file->move(public_path('files'),$fileName);
                $fileModel = new AttachmentFile();
                $fileModel->notiket = $kode_awal;
                $fileModel->type_attach = 0;
                $fileModel->filename = $fileName;
                $fileModel->path = $path;
                $fileModel->save();
            }
        }
        
        if($query_ticket) {
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Failed to Save', 'error');
            return back();
        }
    }
    public function detil($id){
        $depart =  auth()->user()->depart;
        $data['detail'] = VW_ReportTicket::all()->where('notiket',$id);
        $data['office_type'] = OfficeType::all()->where('deleted', 0);
        $data['province'] = \Indonesia::allProvinces()->where('deleted', 0);
        $data['severity'] = Severity::all()->where('deleted', 0);
        if ($depart == 10) {
            $data['file_attach_ticket'] = VW_Docs::all()->where('notiket',$id);
            $data['attach_uploaded'] = AttachmentFile::all()->where('notiket',$id);
        }else{
            $data['test'] = LogTiket::where('notiket','230705046')->orderBy('created_at', 'asc')->first();
            $data['file_attach_ticket'] = AttachmentFile::all()->where('notiket',$id)->where('type_attach',0);
            $data['log_detil'] = LogTiket::where('notiket',$id)->orderBy('created_at','desc')->get();
            $data['validate_problem'] = TiketInfo::all()->where('notiket',$id)->first();
            $data['tiket_part'] = VW_Tiket_Part::all()->where('notiket',$id);
            $data['engineer'] = VW_List_Engineer::all();
            $data['l2_en'] = VW_List_Engineer::all()->where('depart', 13);
            $data['sla'] = SLA::all()->where('deleted', 0);
            $data['type'] = PartType::all()->where('deleted', 0);
            $data['type_note'] = CategoryNote::all()->where('deleted', 0);
            $data['ktgr_unit'] = CategoryUnit::all()->where('deleted', 0);
            $data['merk'] = Merk::all()->where('deleted', 0);
            $data['typeTicket'] = TypeTicket::all()->where('deleted', 0);
            $data['source'] = Source::all()->where('deleted', 0);
            $data['ctgr_part'] = CategoryPart::all()->where('deleted', 0);
            if ($depart == 9) {
                $data['validate_awb'] = Ticket::select('status_awb')->where('notiket', $id)->first();
                $data['log_awb'] = VW_LogLogistik::all()->where('notiket',$id);
                $data['done_awb'] = VW_Tiket_Part::all()->where('notiket',$id)->whereNotNull('awb_num');
            }
            // elseif($depart == 6){
            //     $data['reimburseEn'] = DB::table(function ($query) use($id) {
            //                         $query->selectRaw('hre.*, IFNULL(har.qty_attach, 0) as qty_attach')
            //                             ->from('hgt_reimburse_en as hre')
            //                             ->leftJoin(DB::raw('(SELECT fk_id, COUNT(id) AS qty_attach FROM hgt_attach_reimburse GROUP BY fk_id) AS har'), 'hre.fk_id', '=', 'har.fk_id')
            //                             ->where('notiket', $id);
            //                         })->get();
            // }
            $data['getStsP'] = StsPending::all()->where('deleted', 0);
        }
        return view('Pages.Ticket.detil')->with($data)->with('id', $id);
    }
    public function add_note_at_detil(Request $request, $notiket){
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $getUpdt = Ticket::select('ext_status', 'sts_pending')->where('notiket', $notiket)->first();
        $logging = [
            'notiket'    => $notiket,
            'type_note'    => $request->type_note,
            'note'    => $request->log_note,
            'user'     => $nik,
            'created_at'     => $dateTime
        ];
        if($logging) {
            $updtTicket = Ticket::where('notiket', $notiket)->first();
            if($request->type_note != $getUpdt->ext_status){
                $updtEXT = [
                    'ext_status'    => $request->type_note
                ];
                $updtTicket->update($updtEXT);
            }
            if($request->ktgr_pending != $getUpdt->sts_pending){
                $updtPD = [
                    'sts_pending'    => $request->ktgr_pending
                ];
                $updtTicket->update($updtPD);
            }
            LogTiket::insert($logging);
            Alert::toast('Successfully adding note!', 'success');
            return back();
        }
        else {
            Alert::toast('Failed to save note', 'error');
            return back();
        }
    }
    public function update_engineer(Request $request, $key){
        $list_cek_activity = VW_Activity_Engineer::where('notiket',$key)->whereNotIn('act_description',[8, 9])->groupBy('act_time')->orderBy('act_time','desc')->limit(1)->first();
        $sts_timeline1st = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$key)->where('sts_timeline',0)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $sts_timeline2nd = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$key)->where('sts_timeline',1)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $sts_timeline3rd = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$key)->where('sts_timeline',2)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $validate = Ticket::select('status')->where('notiket',$key)->first();
        $nik =  auth()->user()->nik;
        $dept =  auth()->user()->depart;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        if ($dept == 6 || $dept == 1) {
            if ($validate->status == 9) {
                $value = [
                    'status'    => 1,
                    'respontime'    => $dateTime,
                    'updated_at'    => $dateTime
                ];
                $resp_en = [
                    'notiket'    =>  $key,
                    'en_id'    => $nik,
                    'act_description'    => 1,
                    'act_time'    => $dateTime,
                    'latitude'    => $request->latitude,
                    'longitude'    => $request->longitude,
                    'visitting'    => 0,
                    'status'    => 1,
                    'created_at'    => $dateTime
                ];
                $logging = [
                    'notiket'    => $key,
                    'note'    => 'Engineer received ticket',
                    'user'     => $nik,
                    'type_log'     => 1,
                    'created_at'     => $dateTime
                ];
                $alert_success = "Ticket Accepted!";
                $alert_failed = "Error when receive ticket!";
            } elseif ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && (($sts_timeline1st->act_description == 1) 
            || ((empty($sts_timeline2nd) || empty($sts_timeline3rd)) && (($validate->status == 2 && empty($sts_timeline2nd) && $sts_timeline1st->status_activity == 0) 
            || ($validate->status == 3 && empty($sts_timeline3rd) && $sts_timeline2nd->status_activity == 0)))))) {
                    if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 1)) {
                        $visit = 0;
                        $notes = "Engineer go to location";
                    }elseif ((($validate->status == 2 || $validate->status == 3) && empty($sts_timeline2nd))) {
                        $visit = 1;
                        $notes = "2nd OnSite : Engineer go to location";
                    }else{
                        $visit = 2;
                        $notes = "3rd OnSite : Engineer go to location";
                    }
                    $value = [
                        'updated_at'    => $dateTime
                    ];
                    $resp_en = [
                        'notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 2,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 1,
                        'created_at'    => $dateTime
                    ];
                    $logging = [
                        'notiket'    => $key,
                        'note'    => $notes,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime
                    ];
                $alert_success = "Your log Cabs recorded!";
                $alert_failed = "Error when updating!";
            } elseif ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && 
                    ($sts_timeline1st->act_description == 2 || @$sts_timeline2nd->act_description == 2 || @$sts_timeline3rd->act_description == 2))) {
                    if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 2)) {
                        $visit = 0;
                        $notes = "Engineer arrived to the location";
                    }elseif ((($validate->status == 2 || $validate->status == 3) && $sts_timeline2nd->act_description == 2)) {
                        $visit = 1;
                        $notes = "Engineer arrived to the location 2nd On Site";
                    }else{
                        $visit = 2;
                        $notes = "Engineer arrived to the location 3rd On Site";
                    }
                    $value = [
                        'updated_at'    => $dateTime
                    ];
                    $resp_en = [
                        'notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 3,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 1,
                        'created_at'    => $dateTime
                    ];
                    $logging = [
                        'notiket'    => $key,
                        'note'    => $notes,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime
                    ];
                $alert_success = "Your log arrive recorded!";
                $alert_failed = "Error when updating!";
            } elseif ((($validate->status == 1 || $validate->status == 2  || $validate->status == 3) 
                && ($sts_timeline1st->act_description == 3 || @$sts_timeline2nd->act_description == 3  || @$sts_timeline3rd->act_description == 3))) {
                    if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 3)) {
                        $visit = 0;
                        $notes = "Engineer start working";
                    }elseif ((($validate->status == 2 || $validate->status == 3) && $sts_timeline2nd->act_description == 3)) {
                        $visit = 1;
                        $notes = "Engineer start working 2nd On Site";
                    }else{
                        $visit = 2;
                        $notes = "Engineer start working 3rd On Site";
                    }
                    $value = [
                        'updated_at'    => $dateTime
                    ];
                    $resp_en = [
                        'notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 4,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 1,
                        'created_at'    => $dateTime
                    ];
                    $logging = [
                        'notiket'    => $key,
                        'note'    => $notes,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime
                    ];
                
                $alert_success = "Your log start working recorded!";
                $alert_failed = "Error when updating!";
            } elseif ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && ($sts_timeline1st->act_description == 4 || @$sts_timeline2nd->act_description == 4 || @$sts_timeline3rd->act_description == 4))) {
                if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 4)) {
                    $visit = 0;
                    $sts = 2;
                    $notes = "Engineer Stop Working";
                    $notes1 = "Engineer giving problem solving";
                    $notes2 = "Engineer Needed Part";
                }elseif ((($validate->status == 2 || $validate->status == 3) && $sts_timeline2nd->act_description == 4)) {
                    $visit = 1;
                    $sts = 3;
                    $notes = "Engineer Stop Working 2nd On Site";
                    $notes1 = "Engineer giving problem solving Stop Working 2nd On Site";
                    $notes2 = "Engineer Needed Part 2nd On Site";
                }else {
                    $visit = 2;
                    $notes = "Engineer Stop Working 3nd On Site";
                    $notes1 = "Engineer giving problem solving Stop Working 3nd On Site";
                }
                if ($request->check_en_part == 1) {
                        $value = [
                            'status'    => $sts,
                            'updated_at'    => $dateTime
                        ];
                        $resp_en = [
                            ['notiket'    =>  $key,
                            'en_id'    => $nik,
                            'act_description'    => 8,
                            'note'    => $request->note_reqs_part,
                            'act_time'    => $dateTime,
                            'latitude'    => $request->latitude,
                            'longitude'    => $request->longitude,
                            'visitting'    => $visit,
                            'status'    => 0,
                            'created_at'    => $dateTime],
                            ['notiket'    =>  $key,
                            'en_id'    => $nik,
                            'act_description'    => 5,
                            'act_time'    => $dateTime,
                            'latitude'    => $request->latitude,
                            'longitude'    => $request->longitude,
                            'visitting'    => $visit,
                            'status'    => 1,
                            'created_at'    => $dateTime]
                        ];
                        $logging = [
                            ['notiket'    => $key,
                            'note'    => $notes2,
                            'user'     => $nik,
                            'type_log'     => 1,
                            'created_at'     => $dateTime],
                            ['notiket'    => $key,
                            'note'    => "$notes",
                            'user'     => $nik,
                            'type_log'     => 1,
                            'created_at'     => $dateTime]
                        ];
                } else {
                    $value = [
                        'updated_at'    => $dateTime
                    ];
                    $resp_en = [
                        ['notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 9,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 0,
                        'created_at'    => $dateTime],
                        ['notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 5,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 1,
                        'created_at'    => $dateTime]
                    ];
                    $logging = [
                        ['notiket'    => $key,
                        'note'    => $notes1,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime],
                        ['notiket'    => $key,
                        'note'    => "$notes",
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime]
                    ];
                    $tiket_info = [
                        'solve'    => $request->repair_way
                    ];
                }
                $alert_success = "Your log stop working recorded!";
                $alert_failed = "Error when updating!";
            } elseif ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && ($sts_timeline1st->act_description == 5 || @$sts_timeline2nd->act_description == 5 || @$sts_timeline3rd->act_description == 5))) {
                    if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 5)) {
                        $visit = 0;
                        $notes = "Engineer Leave Site";
                    }elseif ((($validate->status == 2 || $validate->status == 3) && $sts_timeline2nd->act_description == 5)) {
                        $visit = 1;
                        $notes = "Engineer Leave Site 2nd On Site";
                    }else {
                        $visit = 2;
                        $notes = "Engineer Leave Site 3rd On Site";
                    }
                    $value = [
                        'updated_at'    => $dateTime
                    ];

                    $resp_en = [
                        'notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 6,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 1,
                        'created_at'    => $dateTime
                    ];

                    $logging = [
                        'notiket'    => $key,
                        'note'    => $notes,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime
                    ];
                
                $alert_success = "Your log leave site recorded!";
                $alert_failed = "Error when updating!";
            } elseif ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && $sts_timeline1st->act_description == 6 || @$sts_timeline2nd->act_description == 6 || @$sts_timeline3rd->act_description == 6)) {
                    if ((($validate->status == 1 || $validate->status == 2) && $sts_timeline1st->act_description == 6)) {
                        $visit = 0;
                        $notes = "Travel Stop";
                    }elseif ((($validate->status == 2 || $validate->status == 3) && $sts_timeline2nd->act_description == 6)) {
                        $visit = 1;
                        $notes = "Travel Stop 2nd On Site";
                    }else {
                        $visit = 2;
                        $notes = "Travel Stop 3rd On Site";
                    }
                    $value = [
                        'updated_at'    => $dateTime
                    ];

                    $resp_en = [
                        'notiket'    =>  $key,
                        'en_id'    => $nik,
                        'act_description'    => 7,
                        'act_time'    => $dateTime,
                        'latitude'    => $request->latitude,
                        'longitude'    => $request->longitude,
                        'visitting'    => $visit,
                        'status'    => 0,
                        'created_at'    => $dateTime
                    ];

                    $logging = [
                        'notiket'    => $key,
                        'note'    => $notes,
                        'user'     => $nik,
                        'type_log'     => 1,
                        'created_at'     => $dateTime
                    ];
                
                $alert_success = "Your log travel stop recorded!";
                $alert_failed = "Error when updating!";
            }
        } else {
            $get_prev_sts = Ticket::select('status')->where('notiket', $key)->first();
            $value = [
                'status'    => 10,
                'ext_status' => null,
                'sts_pending' => null,
                'prev_bin'    => $get_prev_sts->status,
                'closedate'    => $dateTime,
                'updated_at'    => $dateTime
            ];
            $logging = [
                'notiket'    => $key,
                'note'    => 'Ticket Closed',
                'user'     => $nik,
                'type_log'     => 1,
                'created_at'     => $dateTime
            ];
            $alert_success = "Ticket have been closed!";
            $alert_failed = "Error when updating!";
        }
        
        $query = Ticket::where('notiket', $key)->first();
        $result = $query->update($value);
        if($result) {
            if ($dept == 6 || $dept == 1) {
                if ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && ($sts_timeline1st->act_description == 4 || @$sts_timeline2nd->act_description == 4 || @$sts_timeline3rd->act_description == 4))) {
                    if ($request->check_en_part != 1) {
                        TiketInfo::where('notiket', $key)->update($tiket_info);
                    }
                }
                if (!empty($list_cek_activity)) {
                    $values_sts_act = [
                        'status'    => 0
                    ];
                    if ($list_cek_activity->sts_timeline == 0) {
                        $updt_status_act = ActivityEngineer::where('notiket', $key)->where('act_description', $sts_timeline1st->act_description)->where('status', $sts_timeline1st->status_activity)->first();
                    } elseif ($list_cek_activity->sts_timeline == 1) {
                        $updt_status_act = ActivityEngineer::where('notiket', $key)->where('act_description', $sts_timeline2nd->act_description)->where('status', $sts_timeline2nd->status_activity)->first();
                    }else {
                        $updt_status_act = ActivityEngineer::where('notiket', $key)->where('act_description', $sts_timeline3rd->act_description)->where('status', $sts_timeline3rd->status_activity)->first();
                    }
                    $resultquery = $updt_status_act->update($values_sts_act);
                }
                if ((($validate->status == 1 || $validate->status == 2 || $validate->status == 3) && ($sts_timeline1st->act_description == 4 || @$sts_timeline2nd->act_description == 4 || @$sts_timeline3rd->act_description == 4))) {
                    foreach ($resp_en as $value_act) {
                        ActivityEngineer::insert($value_act);
                    }
                    foreach ($logging as $val_log) {
                        LogTiket::insert($val_log);
                    }
                }else {
                    ActivityEngineer::insert($resp_en);
                    LogTiket::insert($logging);
                }
            }else {
                LogTiket::insert($logging);
            }
            Alert::toast("$alert_success", 'success');
            return back();
        }
        else {
            Alert::toast("$alert_failed", 'error');
            return back();
        }
    }
    public function update_l2engineer(Request $request, $key){
        $list_cek_activity = VW_Activity_L2Engineer::where('notiket',$key)->whereNotIn('act_description',[8, 9])->groupBy('act_time')->orderBy('act_time','desc')->limit(1)->first();
        $fuckingsubquery = DB::table(function ($query) use($key) {
                    $query->selectRaw('*')
                        ->from(function ($subquery) {
                            $subquery->selectRaw('*')
                                ->from(function ($innerSubquery) {
                                    $innerSubquery->select('notiket', 
                                                DB::raw('max(act_description) AS last_act'),
                                                DB::raw('MAX(visiting) AS last_visit'),  
                                                DB::raw('MAX(status) AS status'))
                                        ->from('hgt_activity_l2engineer')
                                        ->groupBy('notiket', 'visiting')
                                        ->orderBy('visiting', 'DESC');
                                }, 'hl2')
                            ->groupBy('notiket');
                        }, 'hl22')
                    ->where('notiket', $key);
                })->first();
        $nik =  auth()->user()->nik;
        $dept =  auth()->user()->depart;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        if (empty($fuckingsubquery)) {
            $resp_en = [
                'notiket'    =>  $key,
                'l2_id'    => $nik,
                'act_description'    => 1,
                'act_time'    => $dateTime,
                'latitude'    => $request->latitude,
                'longitude'    => $request->longitude,
                'visiting'    => 0,
                'status'    => 0,
                'created_at'    => $dateTime
            ];
            $logging = [
                'notiket'    => $key,
                'note'    => 'L2 on Stand By',
                'user'     => $nik,
                'type_log'     => 1,
                'created_at'     => $dateTime
            ];
            $alert_success = "U're on position Stand By!";
            $alert_failed = "Error when Updating!";
        } elseif (!empty($fuckingsubquery)) {
            if ($fuckingsubquery->last_act == 1 && ($fuckingsubquery->last_visit == 0 || $fuckingsubquery->last_visit == 1 || $fuckingsubquery->last_visit == 2)) {
                $act_desc = 2;
                $sts = 0;
                if ($fuckingsubquery->last_visit == 0) {
                    $visit = 0;
                    $notes = "L2 Start to Work";
                } elseif ($fuckingsubquery->last_visit == 1) {
                    $visit = 1;
                    $notes = "2nd : L2 Start to Work";
                }else{
                    $visit = 2;
                    $notes = "3rd : L2 Start to Work";
                }
            } elseif ($fuckingsubquery->last_act == 2 && ($fuckingsubquery->last_visit == 0 || $fuckingsubquery->last_visit == 1 || $fuckingsubquery->last_visit == 2)) {
                $act_desc = 3;
                $sts = 0;
                if ($fuckingsubquery->last_visit == 0) {
                    $visit = 0;
                    $notes = "L2 Work Stop";
                } elseif ($fuckingsubquery->last_visit == 1) {
                    $visit = 1;
                    $notes = "2nd : L2 Work Stop";
                }else{
                    $visit = 2;
                    $notes = "3rd : L2 Work Stop";
                }
            } elseif ($fuckingsubquery->last_act == 3 && ($fuckingsubquery->last_visit == 0 || $fuckingsubquery->last_visit == 1 || $fuckingsubquery->last_visit == 2)) {
                $act_desc = 4;
                $sts = 1;
                if ($fuckingsubquery->last_visit == 0) {
                    $visit = 0;
                    $notes = "L2 End Case";
                } elseif ($fuckingsubquery->last_visit == 1) {
                    $visit = 1;
                    $notes = "2nd : L2 End Case";
                }else{
                    $visit = 2;
                    $notes = "3rd : L2 End Case";
                }
            } elseif ($fuckingsubquery->last_act == 4 && $fuckingsubquery->status == 1 && ($fuckingsubquery->last_visit == 0 || $fuckingsubquery->last_visit == 1)) {
                $act_desc = 1;
                $sts = 0;
                if ($fuckingsubquery->last_visit == 0) {
                    $visit = 1;
                    $notes = "2nd : L2 on Stand By";
                } else {
                    $visit = 2;
                    $notes = "3rd : L2 on Stand By";
                }
            }
            
            $value = [
                'updated_at'    => $dateTime
            ];
            $resp_en = [
                'notiket'    =>  $key,
                'l2_id'    => $nik,
                'act_description'    => $act_desc,
                'act_time'    => $dateTime,
                'latitude'    => $request->latitude,
                'longitude'    => $request->longitude,
                'visiting'    => $visit,
                'status'    => $sts,
                'created_at'    => $dateTime
            ];
            $logging = [
                'notiket'    => $key,
                'note'    => $notes,
                'user'     => $nik,
                'type_log'     => 1,
                'created_at'     => $dateTime
            ];
            $alert_success = "Your logs recorded!";
            $alert_failed = "Error when updating!";
        }
        
        $query = ActivityL2En::insert($resp_en);
        if($query) {
            LogTiket::insert($logging);
            Alert::toast("$alert_success", 'success');
            return back();
        }
        else {
            Alert::toast("$alert_failed", 'error');
            return back();
        }
    }
    public function change_engineer(Request $request, $key){
        $get_sp_en = ServicePoint::select('service_id')->where('service_name',$request->sp_en_name)->first();
        $value = [
            'en_id'    => $request->nik_engineer,
            'service_point'    => $get_sp_en->service_id
        ];
        $query = Ticket::where('notiket', $key)->first();
        $result = $query->update($value);
        if($result) {
            $nik =  auth()->user()->nik;
            $depart =  auth()->user()->depart;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $data_en = User::all()->where('nik',$request->nik_engineer)->first();
            $logging = [
                'notiket'    => $key,
                'note'    => 'Change Engineer to'.' '.@$data_en->full_name,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Engineer successfully changed!', 'success');
            if ($depart == 6) {
                return redirect('helpdesk/manage=Ticket');
            } else {
                return back();
            }
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function change_l2(Request $request, $key){
        $value = [
            'l2_id'    => $request->nik_engineer
        ];
        $query = Ticket::where('notiket', $key)->first();
        $result = $query->update($value);
        if($result) {
            $nik =  auth()->user()->nik;
            $depart =  auth()->user()->depart;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $data_en = User::all()->where('nik',$request->nik_engineer)->first();
            $logging = [
                'notiket'    => $key,
                'note'    => 'Change Engineer to'.' '.@$data_en->full_name,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Engineer successfully changed!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function store_part_dt(Request $request, $notiket)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $part_detail_id = VW_Tiket_Part::select('part_detail_id')->where('notiket', $notiket)->first();
        if (empty($part_detail_id)) {
            $get_part = TiketPartNew::orderBy('id','desc')->take(1)->get();
            if ($get_part->isEmpty()) {
                $no = 1;
                    $id_part = "HGT-PART-00".$no;
            } else {
                $data_part = $get_part[0]->part_detail_id;
                $get_int_part = substr($data_part, 9);
                $autonumber = (int)$get_int_part;
                $autonumber++;
                if($autonumber > 9 && $autonumber < 100){
                    $id_part = "HGT-PART-0".$autonumber;
                }elseif($autonumber > 99){
                    $id_part = "HGT-PART-".$autonumber;
                }elseif($autonumber <= 9){
                    $id_part = "HGT-PART-00".$autonumber;
                }
            }
            $values_tiket_part_n = [
                'notiket'           => $notiket,
                'part_detail_id'    => $id_part
            ];
                TiketPartNew::insert($values_tiket_part_n);
        } else {
            $id_part = $part_detail_id->part_detail_id;
        }
        $values_part_dt = [
            'part_detail_id'           => $id_part,
            'unit_name'    => $request->type_unit_updt,
            'category_part'    => $request->kat_part_dt,
            'so_num'    => $request->so_num_updt,
            'rma'    => $request->rma_part_updt,
            'pn'    => $request->product_number_updt,
            'sn'    => $request->serial_number_updt,
            'type_part'    => $request->status_part_updt,
            'status'    => 0,
            'created_at'    => $dateTime
        ];
        $execute = TiketPartDetail::insert($values_part_dt);

            if($execute) {
                // set variable in session to indicate that modal should be open
                $nik =  auth()->user()->nik;
                $logging = [
                    'notiket'    => $notiket,
                    'note'    => "Added part to list detail part",
                    'user'     => $nik,
                    'created_at'     => $dateTime
                ];
                LogTiket::insert($logging);

                session()->flash('modal', 'part-detail');
                session()->flash('sweetalert', 'show');
                session()->flash('message', 'Successfully Adding Part in this Ticket!');
                
                return back();
            }
            else {
                Alert::toast('Failed insert part!', 'error');
                return back();
            }
    }
    public function part_detail($id)
    {
        $data['tiket_part'] = VW_Tiket_Part::all()->where('notiket',$id);
        $data['type'] = PartType::all()->where('deleted', '!=', 1);
        $data['ctgr_part'] = CategoryPart::all()->where('deleted', 0);
        return view('Pages.Ticket.Part-Section.ticket-part')->with($data)->with('id', $id);
    }
    public function update_part_detail(Request $request, $id, $notiket)
    {
        $updt_part = [
            'unit_name'    => $request->edt_type_unit_updt,
            'category_part'    => $request->edt_ktgr_part_dt,
            'so_num'    => $request->edt_so_num_updt,
            'eta'    => $request->eta_date,
            'rma'    => $request->edt_rma_updt,
            'pn'    => $request->edt_product_number_updt,
            'sn'    => $request->edt_serial_number_updt,
            'type_part'    => $request->edt_status_part_updt
        ];
        if($updt_part) {
        $query = TiketPartDetail::where('id', $id)->first();
        $query->update($updt_part);
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $notiket,
                'note'    => 'Action Change on PART '.$query->unit_name,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Part is Updated!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when updating part!', 'error');
            return back();
        }
    }
    public function delete_list_part(Request $request, $id, $notiket)
    {
        $get_list_part = TiketPartDetail::where('id', $id)->first();
        if($get_list_part) {
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $notiket,
                'note'    => 'Delete PART '.$get_list_part->unit_name,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            $get_list_part->delete();
            Alert::toast('Part Deleted!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when updating part!', 'error');
            return back();
        }
    }
    public function timeline_engineer($id)
    {
        $nik =  auth()->user()->nik;
        $data['status_ticket'] = VW_Ticket::select('status')->where('notiket',$id)->first();
        $data['sts_timeline1st'] = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$id)->where('sts_timeline',0)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $data['sts_timeline2nd'] = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$id)->where('sts_timeline',1)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $data['sts_timeline3rd'] = VW_Activity_Engineer::select('act_description', 'status_activity')->where('notiket',$id)->where('sts_timeline',2)->whereNotIn('act_description',[8, 9])->groupBy('act_description')->orderBy('act_time','desc')->limit(1)->first();
        $data['onsite'] = VW_Activity_Engineer::selectRaw('COUNT(*) AS total_row')
                        ->fromSub(function ($query) use ($id) {
                            $query->selectRaw('COUNT(sts_timeline) AS jumlah')
                                ->from('vw_hgt_activity_engineer')
                                ->where('notiket', $id)
                                ->whereIn('sts_timeline', [0, 1, 2])
                                ->groupBy('sts_timeline');
                        }, 'subquery')
                        ->first();
        $data['act_engineerst'] = VW_Activity_Engineer::all()->where('notiket',$id)->where('sts_timeline',0);
        $data['end_sitest'] = ActivityEngineer::where('notiket',$id)->where('visitting', 0)->where('status', 1)->first();
        $data['act_engineernd'] = VW_Activity_Engineer::all()->where('notiket',$id)->where('sts_timeline',1);
        $data['end_sitend'] = ActivityEngineer::where('notiket',$id)->where('visitting', 1)->where('status', 1)->first();
        $data['act_engineerrd'] = VW_Activity_Engineer::all()->where('notiket',$id)->where('sts_timeline',2);
        $data['end_siterd'] = ActivityEngineer::where('notiket',$id)->where('visitting', 2)->where('status', 1)->first();
        return view('Pages.Ticket.timeline-ticket-en')->with($data)->with('id', $id);
    }
    // Timeline L2 Engineer
    public function timeline_L2engineer($id)
    {
        $nik =  auth()->user()->nik;
        $data['status_ticket'] = VW_Ticket::select('status')->where('notiket',$id)->first();
        $data['vdt_l2'] = DB::table(function ($query) use($id) {
                    $query->selectRaw('hl22.*, ht.status as sts_ticket')
                        ->from(function ($subquery) {
                            $subquery->selectRaw('*')
                                ->from(function ($innerSubquery) {
                                    $innerSubquery->select('notiket',  
                                                DB::raw('max(act_description) AS last_act'),
                                                DB::raw('MAX(visiting) AS last_visit'),  
                                                DB::raw('MAX(status) AS status'))
                                        ->from('hgt_activity_l2engineer')
                                        ->groupBy('notiket', 'visiting')
                                        ->orderBy('visiting', 'DESC');
                                }, 'hl2')
                            ->groupBy('notiket');
                        }, 'hl22')
                        ->leftJoin('hgt_ticket as ht', 'hl22.notiket', '=', 'ht.notiket')
                    ->where('hl22.notiket', $id);
                })->first();
        $data['act_engineerst'] = VW_Activity_L2Engineer::where('notiket',$id)->where('sts_timeline',0)->orderBy('act_description', 'ASC')->get();
        $data['act_engineernd'] = VW_Activity_L2Engineer::where('notiket',$id)->where('sts_timeline',1)->orderBy('act_description', 'ASC')->get();
        $data['act_engineerrd'] = VW_Activity_L2Engineer::where('notiket',$id)->where('sts_timeline',2)->orderBy('act_description', 'ASC')->get();
        return view('Pages.Ticket.activity_L2')->with($data)->with('id', $id);
    }
    public function update_part_after(Request $request, $id)
    {
        $value = [
            'part_reqs'    => $request->sts_part_reqs
        ];
        $query_sts_part = Ticket::where('notiket', $id)->first();
        $result = $query_sts_part->update($value);
        if($result) {
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            if ($request->sts_part_reqs == 0) {
                $note = "Update Status From Yes PART to No";
            } else {
                $note = "Update Status From No PART to Yes";
            }
            
            $logging = [
                'notiket'    => $id,
                'note'    => $note,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            $part = TiketPartNew::where('notiket', $id)->first();
            if ($request->sts_part_reqs == 0 && !empty($part)) {
                $partDt = TiketPartDetail::where('part_detail_id', $part->part_detail_id);
                $DelPartDT = $partDt->delete();
                if ($DelPartDT) {
                    $part->delete();
                }
            }
            Alert::toast('Status parts successfully changed to Yes', 'success');
            return back();
        }
        else {
            Alert::toast('Error when updating ticket!', 'error');
            return back();
        }
    }
    public function update_ticket_send_to_engineer($id)
    {
        $value = [
            'status'    => 9
        ];
        $query_sts_ticket = Ticket::where('notiket', $id)->first();
        if($query_sts_ticket) {
            $result = $query_sts_ticket->update($value);
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $id,
                'note'    => 'Tickets are ready to be Taken, and sending to Engineer',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            $send = [
                'send_at'    => $dateTime
            ];
            $query_notif_to_en = Notification::where('kunci', $id)->first();
            $query_notif_to_en->update($send);

            $url = url("Detail/Ticket=$id");
            $get_hp = User::select('phone')->where('nik', $query_sts_ticket->en_id)->first();
            $get_l2 = User::select('phone')->where('nik', $query_sts_ticket->l2_id)->first();
            $message = urlencode("You have a new Ticket with No Ticket.$id\nClick link to open the page : ($url)");
            $phone = substr("$get_hp->phone",1);
            $link = "https://wa.me/+62{$phone}?text={$message}";
            if (!empty($get_l2)) {
                $phonel2 = substr("$get_l2->phone",1);
                $linkl2 = "https://wa.me/+62{$phonel2}?text={$message}";
                session()->flash('whatsapp_link_2', $linkl2);
            }
            Alert::toast('Ticket Successfully Sending to Engineer!', 'success');
            session()->flash('whatsapp_link_1', $link);
            return redirect()->back();
        }
        else {
            Alert::toast('Error when updating', 'error');
            return back();
        }
    }
    public function destroy_ticket($id)
    {
        $ticket_delete = Ticket::where('notiket', $id)->first();
        if($ticket_delete) {
            TiketInfo::where('notiket', $id)->delete();
            // ~~~~~
            $attachQuery = AttachmentFile::where('notiket', $id)->get();
            foreach ($attachQuery as $value) {
                $pathFile = public_path("$value->path");

                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
                $value->delete();
            }
            // ~~~~~
            LogTiket::where('notiket', $id)->delete();
            // ~~~~~
            $getPartDT = TiketPartNew::where('notiket', $id)->first();
            if ($getPartDT) {
                $delPartDT = TiketPartDetail::where('part_detail_id', $getPartDT->part_detail_id)->delete();
                if ($delPartDT) {
                    ListPartAWB::where('part_detail_id', $getPartDT->part_detail_id)->delete();
                    $getPartDT->delete();
                }
            }
            // ~~~~~
            $getEndUser = ProjectInfo::where('notiket', $id)->first();
            if ($getEndUser) {
                $getEU = Customer::where('end_user_id', $getEndUser->end_user_id)->delete();
                if ($getEU) {
                    $getEndUser->delete();
                }
            }
            // ~~~~~ 
            $getActEn = ActivityEngineer::where('notiket', $id)->get();
            foreach ($getActEn as $value) {
                $delAttachEn = EngineerAttachment::where('engineer_attach_id', $value->en_attach_id)->get();
                foreach ($delAttachEn as $item) {
                    $pathFile = public_path("$item->path");

                    if (file_exists($pathFile)) {
                        unlink($pathFile);
                    }
                    $item->delete();
                }
                $value->delete();
            }
            // ~~~~~
            Notification::where('kunci', $id)->delete();
            LoggingLogistik::where('notiket', $id)->delete();
            // ~~~~~
            TiketPendingDaily::where('tiket_pending', $id)->delete();
            // ~~~~~
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'key'    => $id,
                'who_is'    => $nik,
                'action'     => 'Ticket Delete',
                'created_at'     => $dateTime
            ];
            LoggingHGT::insert($logging);
            $ticket_delete->delete();
            Alert::toast('Ticket had been Deleted!', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function store_attachment_engineer(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $files = $request->file('files');

        $get_id_attachment = EngineerAttachment::orderBy('engineer_attach_id','desc')->take(1)->get();
        if ($get_id_attachment->isEmpty()) {
            $no = 1;
                $id_attach = "EN/Attach-00".$no;
        } else {
            $data_attach_engineer = $get_id_attachment[0]->engineer_attach_id;
            $get_int_attach = substr($data_attach_engineer, 10,10);
            $autonumber = (int)$get_int_attach;
            $autonumber++;
            if($autonumber > 9 && $autonumber < 100){
                $id_attach = "EN/Attach-0".$autonumber;
            }elseif($autonumber > 99 && $autonumber < 1000){
                $id_attach = "EN/Attach-".$autonumber;
            }elseif($autonumber <= 9){
                $id_attach = "EN/Attach-00".$autonumber;
            }
        }
        
        foreach ($files as $file) {
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('/uploads'), $fileName);
            
            $path = '/uploads/'.$fileName;

            $values_list = [
                'engineer_attach_id'           => $id_attach,
                'filename'    => $fileName,
                'path'    => $path,
                'note'    => $request->note_attach,
                'type_attach'    => $request->status_attachment,
                'created_at'    => $dateTime
            ];
            $updt_act = [
                'en_attach_id'           => $id_attach
            ];
            
            $result = EngineerAttachment::insert($values_list);
        }
        if($files) {
            $query = ActivityEngineer::where('notiket', $request->notik)->where('act_description', $request->status_attachment)->where('visitting', $request->onsite)->first();
            if ($request->status_attachment == 8 || $request->status_attachment == 9) {
                $query->timestamps = false;
            }
            $query->update($updt_act);
            Alert::toast('Atacchment Successfully Added!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when upload attachment!', 'error');
            return back();
        }
    }
    public function store_attachment_l2engineer(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));

        $get_id_attachment = EngineerAttachment::orderBy('engineer_attach_id','desc')->take(1)->get();
        if ($get_id_attachment->isEmpty()) {
            $no = 1;
                $id_attach = "EN/Attach-00".$no;
        } else {
            $data_attach_engineer = $get_id_attachment[0]->engineer_attach_id;
            $get_int_attach = substr($data_attach_engineer, 10,10);
            $autonumber = (int)$get_int_attach;
            $autonumber++;
            if($autonumber > 9 && $autonumber < 100){
                $id_attach = "EN/Attach-0".$autonumber;
            }elseif($autonumber > 99 && $autonumber < 1000){
                $id_attach = "EN/Attach-".$autonumber;
            }elseif($autonumber <= 9){
                $id_attach = "EN/Attach-00".$autonumber;
            }
        }
        
            $values_list = [
                'engineer_attach_id'    => $id_attach,
                'note'    => $request->note_attach,
                'type_attach'    => $request->status_attachment,
                'created_at'    => $dateTime
            ];
            $updt_act = [
                'en_attach_id'           => $id_attach
            ];
            
            $result = EngineerAttachment::insert($values_list);
        if($result) {
            $query = ActivityL2En::where('notiket', $request->notik)->where('act_description', $request->status_attachment)->where('visiting', $request->onsite)->first();
            $query->update($updt_act);
            Alert::toast('Note Added!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Add note!', 'error');
            return back();
        }
    }
    // AWB View 
    public function view_awb($key){
        $nik =  auth()->user()->nik;
        $get_part_detail_id = TiketPartNew::where('notiket',$key)->first();
        $data['validate_list'] = VW_List_Part_AWB::where('part_detail_id',$get_part_detail_id->part_detail_id)->where('status',0)->first();
        $data['data_list'] = VW_List_Part_AWB::all()->where('part_detail_id',$get_part_detail_id->part_detail_id)->where('nik',$nik)->where('status',0);
        $data['part_awb'] = VW_Tiket_Part::all()->where('part_detail_id',$get_part_detail_id->part_detail_id)->where('sts_type', 1);
        $data['dt_ticket'] = Ticketing::all()->where('notiket', $key)->where('deleted', '!=', 1)->first();
        $data['get_ads_sp'] = ServicePoint::all()->where('service_id', $data['dt_ticket']->service_id)->first();
        $data['validate_save'] = VW_Tiket_Part::where('part_detail_id', $get_part_detail_id->part_detail_id)
                        ->where(function($query) {
                            $query->whereNull('status_list')
                                  ->orWhere('status_list', 0);
                        })->where('sts_type', 1)->first();
        $data['hidden'] = VW_Ticket::all()->where('notiket', $key)->first();
        return view('Pages.Ticket.Part-Section.awb')->with($data)->with('key', $key);
    }
    public function store_part_list_awb(Request $request, $notiket, $pid)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        if ($request->vald == 1) {
            $sts = 0;
        } else {
            $sts = 1;
            $value_single = [
                'awb_num'    => $request->single_no_awb
            ];
        }
        
        $values_list = [
            'part_detail_id'           => $pid,
            'part_id'    => $request->part_id,
            'status'    => $sts,
            'nik'    => $nik,
            'created_at'    => $dateTime
        ];

            $result = ListPartAWB::insert($values_list);

            if($result) {
                if ($request->vald == 2) {
                    $get_part_detail_id = TiketPartNew::where('notiket',$notiket)->first();
                    $updt_part_awb = TiketPartDetail::where('part_detail_id', $get_part_detail_id->part_detail_id)->where('id', $request->part_id)->first();
                    $updt_part_awb->update($value_single);
                    
                    $val_log = [
                        'nik'           => $nik,
                        'notiket'    => $notiket,
                        'action'    => "Menambahkan no AWB : ".$request->single_no_awb." di part ".$updt_part_awb->unit_name,
                        'dtime'    => $dateTime,
                        'created_at'    => $dateTime
                    ];

                    LoggingLogistik::insert($val_log);
                    Alert::toast('Successfully update AWB!', 'success');
                }else{
                    session()->flash('modal', 'list-part-awb');
                    session()->flash('sweetalert', 'show');
                    session()->flash('message', 'Successfully Adding Part to the list!');
                }
                
                return back();
            }
            else {
                Alert::toast('Failed save data', 'error');
                return back();
            }
    }
    public function repeat_list($id, $part)
    {
        $list = ListPartAWB::where('part_detail_id', $id)->where('part_id', $part)->first();
        
        $result = $list->delete();
        if($result) {
        
            session()->flash('modal', 'list-part-awb');
            session()->flash('sweetalert', 'show');
            session()->flash('message', 'Successfully Deleted Part from list!');

            return back();
        }
        else {
            Alert::toast('Failed delete item!', 'error');
            return back();
        }
    }
    public function update_awb_all_list(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $valuelist = [
            'status'    => 1
        ];
        $value = [
            'awb_num'    => $request->awb_number
        ];
        
        $get_part_detail_id = TiketPartNew::where('notiket',$id)->first();
        $list_updt = ListPartAWB::where('part_detail_id', $get_part_detail_id->part_detail_id)->where('status', 0)->get();
            foreach ($list_updt as $item) {
            $query_list_ticket = ListPartAWB::where('part_detail_id', $item->part_detail_id)->where('part_id', $item->part_id)->first();
            $result_updt_list = $query_list_ticket->update($valuelist);
            if($result_updt_list){
                $query_sts_ticket = TiketPartDetail::where('part_detail_id', $item->part_detail_id)->where('id', $item->part_id)->first();
                $query_sts_ticket->update($value);
                
                $val_log = [
                    'nik'           => $nik,
                    'notiket'    => $id,
                    'action'    => "Menambahkan no AWB : ".$request->awb_number." di part ".$query_sts_ticket->unit_name,
                    'dtime'    => $dateTime,
                    'created_at'    => $dateTime
                ];

                LoggingLogistik::insert($val_log);
            }
        }
        if($list_updt) {
            Alert::toast('Successfully update all list!', 'success');
            return back();
        }
        else {
            Alert::toast('Failed to delete!', 'error');
            return back();
        }
    }
    public function update_finish_awb($id)
    {
        $value = [
            'status_awb'    => 1
        ];

        $query_awb_sts_ticket = Ticket::where('notiket', $id)->first();
        $result = $query_awb_sts_ticket->update($value);

        if($result) {
            Alert::toast('AWB Have Been Set Done!', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function update_journey_part(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));

        $query_get_part_detil = TiketPartDetail::where('id', $id)->first();
        if ($query_get_part_detil->status == 0) {
            $value = [
                'status'    => 1,
                'send'    => $dateTime
            ];
            $note = "Already send";
            $message = "Part Send its recorded!";
        } else {
            $value = [
                'status'    => 2,
                'arrive'    => $dateTime
            ];
            $note = "Received";
            $message = "Part its received";
        }
        
        $result = $query_get_part_detil->update($value);

        if($result) {
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $request->log_part_notik,
                'note'    => 'Update Part '.$query_get_part_detil->unit_name.' '.$note,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);

            session()->flash('modal', 'part-detail');
            session()->flash('sweetalert', 'show');
            session()->flash('message', $message);

            return back();
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function update_receive_docs($id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $value = [
            'status_docs'    => 1
        ];

        $query_docs_sts_ticket = Ticket::where('notiket', $id)->first();
        $result = $query_docs_sts_ticket->update($value);

        if($result) {
            $logging = [
                'notiket'    => $id,
                'action'    => 'Document Received',
                'id_admin'     => $nik,
                'created_at'     => $dateTime
            ];
            LogAdmin::insert($logging);
            Alert::toast('Documents its Received!', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function update_schedule_en(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $value = [
            'schedule'    => $request->sch_time_sch." ".$request->time_sch_en
        ];

        $query_change_sch = Ticket::where('notiket', $id)->first();
        $result = $query_change_sch->update($value);

        if($result) {
            $logging = [
                'notiket'    => $id,
                'note'    => 'Rechedule Engineer to '.$request->sch_time_sch." ".$request->time_sch_en,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Schedule engineer successfully updated!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function update_part_ready(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $value = [
            'updated_at'    => $dateTime
        ];

        $query = ActivityEngineer::where('notiket', $id)
                ->where('act_description', '=', 8)
                ->where(function($query) {
                    $query->where('updated_at', '=', NULL)
                          ->orWhere('updated_at', '=', 0);
                })
                ->orderBy('visitting', 'desc')
                ->limit(1)
                ->first();
        $result = $query->update($value);
        $get_en = Ticket::where('notiket', $id)->first();

        if($result) {
            $logging = [
                'notiket'    => $id,
                'note'    => 'Set part Request its Ready '.$query->note,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            $url = url("Timeline/Engineer/Ticket=$id");
            $get_hp = User::select('phone')->where('nik', $get_en->en_id)->first();
            $message = urlencode("Your No Ticket.$id its ready to be continues\nClick link to open the page : ($url)");
            $phone = substr("$get_hp->phone",1);
            $link = "https://wa.me/+62{$phone}?text={$message}";
            Alert::toast('Successfully update part ready!', 'success');
            return redirect()->away($link);
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function updt_end_user(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $value_eu = [
            'end_user_name'    => $request->company_eu,
            'office_type_id'    => $request->type_kantor_eu,
            'contact_person'    => $request->person_eu,
            'phone'    => $request->phone_eu,
            'ext_phone'    => $request->ext_phone_eu,
            'email'    => $request->email_eu,
            'provinces'    => $request->province_eu,
            'cities'    => $request->cities_eu,
            'address'    => $request->address_eu
        ];
        $value_eut = [
            'severity'    => $request->severity_eu
        ];

        $get_eu = ProjectInfo::where('notiket', $id)->first();
        $query_eu = Customer::where('end_user_id', $get_eu->end_user_id)
                ->first();

        if($query_eu) {
            $query_eu->update($value_eu);
            $query_eut = Ticket::where('notiket', $id)
                    ->first();
            $query_eut->update($value_eut);
            $logging = [
                'notiket'    => $id,
                'note'    => 'Update End User',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Successfully saved data!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Saving', 'error');
            return back();
        }
    }
    public function updt_close_instant(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $query = Ticket::where('notiket', $id)->first();
        if($query) {
            $value = [
                'status'    => 10,
                'ext_status' => null,
                'sts_pending'    => null,
                'closedate'    => $dateTime
            ];
            $logging = [
                'notiket'    => $id,
                'note'    => 'Ticket Closed',
                'user'     => $nik,
                'type_log'     => 1,
                'created_at'     => $dateTime
            ];
            $query->update($value);
            LogTiket::insert($logging);
            Alert::toast('Ticket Have been closed!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function remove_en_dt(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $query = Ticket::where('notiket', $id)->first();
        if($query) {
            $value = [
                'en_id'    => null,
                'service_point'    => null,
                'schedule'    => null

            ];
            $logging = [
                'notiket'    => $id,
                'note'    => 'Removing Engineer from ticket',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            $query->update($value);
            LogTiket::insert($logging);
            Alert::toast('Successfully removing engineer!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Removing', 'error');
            return back();
        }
    }
    public function remove_l2en_dt(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $query = Ticket::where('notiket', $id)->first();
        if($query) {
            $value = [
                'l2_id'    => null

            ];
            $logging = [
                'notiket'    => $id,
                'note'    => 'Removing Engineer from ticket',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            $query->update($value);
            LogTiket::insert($logging);
            Alert::toast('Successfully removing L2 engineer!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Removing', 'error');
            return back();
        }
    }
    public function prev_sts_ticket(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $query = Ticket::where('notiket', $id)->first();
        if($query) {
            $value = [
                'status'    => $query->prev_bin,
                'closedate'    => null

            ];
            $logging = [
                'notiket'    => $id,
                'note'    => 'Open ticket from Closed',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            $query->update($value);
            LogTiket::insert($logging);
            Alert::toast('Successfully Opened the ticket!', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function dt_updt_unit(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        
        $value = [
            'category_id'    => $request->dt_ktgr_u,
            'merk_id'    => $request->dt_merk_u,
            'type_id'    => $request->dt_type_u,
            'sn'    => $request->dt_sn_unit,
            'pn'    => $request->dt_pn_unit,
            'warranty'    => $request->edt_warranty_dt,
            'problem'    => $request->edt_prob,
            'action_plan'    => $request->edt_act_plan

        ];
        $query = TiketInfo::where('notiket', $id)->first();
        if($query && $value) {
            if ($request->dt_sn_unit != $query->sn && $request->dt_pn_unit == $query->pn) {
                $log_text = "There's a change SN From ".$query->sn." to ".$request->dt_sn_unit;
            }elseif ($request->dt_sn_unit == $query->sn && $request->dt_pn_unit != $query->pn) {
                $log_text = "There's a change PN From ".$query->pn." to ".$request->dt_pn_unit;
            }elseif ($request->dt_sn_unit != $query->sn && $request->dt_pn_unit != $query->pn) {
                $log_text = "There's a change SN From ".$query->sn." to ".$request->dt_sn_unit." And <br>
                            PN From ".$query->pn." to ".$request->dt_pn_unit;
            }else{
                $log_text = "Change's on Unit";
            }
            $logging = [
                'notiket'    => $id,
                'note'    => $log_text,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            $execute = LogTiket::insert($logging);
            if ($execute) {
                $query->update($value);
            }
            Alert::toast('Successfully Opened the ticket!', 'success');
            return back();
        } else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function updt_sla(Request $request, $key){
        $value = [
            'sla'    => $request->updt_sla
        ];
        $query = Ticket::where('notiket', $key)->first();
        if($query) {
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $data_sla = SLA::select('sla_name')->where('id',$request->updt_sla)->first();
            $logging = [
                'notiket'    => $key,
                'note'    => 'Change SLA from '.@$query->get_sla->sla_name.' to '.$data_sla->sla_name,
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            $query->update($value);
            Alert::toast('Successfully change SLAs!', 'success');
            return back();
        } else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function edt_note(Request $request, $id){
        $value = [
            'type_note'    => $request->edt_type_note,
            'note'    => $request->edt_log_note
        ];
        $query = LogTiket::where('id', $id)->first();
        $result = $query->update($value);
        if($result) {
            Alert::toast('Successfully Edit Note!', 'success');
            return back();
        } else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function delete_dt_note($id)
    {
        $logTiket = LogTiket::where('id', $id)->first();
        
        $result = $logTiket->delete();
        if($result) {
            session()->flash('modal', 'note-data');
            session()->flash('sweetalert', 'show');
            session()->flash('message', 'Successfully delete note!');
            return back();
        }
        else {
            Alert::toast('Failed delete item!', 'error');
            return back();
        }
    }
    public function edt_info_ticket(Request $request, $id){
        $value = [
            'type_ticket'    => $request->fm_dt_type_ticket,
            'case_id'    => $request->dt_csid,
            'sumber_id'    => $request->fm_dt_src
        ];
        $query = Ticket::where('notiket', $id)->first();
        $result = $query->update($value);
        if($result) {
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $id,
                'note'    => 'Update Info Ticket (Type Ticket/Case ID/Source)',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Successfully Edit Case ID!', 'success');
            return back();
        } else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function add_not_exist_dt_type(Request $request, $notik){
        $value = [
            'merk_id'    => $request->not_exist_merk,
            'category_id'    => $request->not_exist_ktgr,
            'type_name'    => $request->dt_type_unit_add
        ];
        $addUnitDT = TypeUnit::insert($value);
        if($addUnitDT) {
            $getTypeID = TypeUnit::select('id')->where('type_name',$request->dt_type_unit_add)->where('merk_id', $request->not_exist_merk)->where('category_id', $request->not_exist_ktgr)->first();
            $updtUnitDT = [
                'category_id'    => $request->not_exist_ktgr,
                'merk_id'    => $request->not_exist_merk,
                'type_id'    => $getTypeID->id
            ];
            $query = TiketInfo::where('notiket', $notik)->first();
            $query->update($updtUnitDT);
            $nik =  auth()->user()->nik;
            $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
            $logging = [
                'notiket'    => $notik,
                'note'    => 'Add Unit '.$request->dt_type_unit_add.' to update Type Unit on this Ticket',
                'user'     => $nik,
                'created_at'     => $dateTime
            ];
            LogTiket::insert($logging);
            Alert::toast('Successfully Add Type, and updated to this Ticket!', 'success');
            return back();
        } else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    public function store_attach_adm(Request $request, $id)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $files = $request->file('filesAdm');
        
        foreach ($files as $file) {
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('/uploads/bundle_adm'), $fileName);
            
            $path = '/uploads/bundle_adm/'.$fileName;

            $values_list = [
                'notiket'           => $id,
                'type_attach'    => $request->type_attach_adm,
                'filename'    => $fileName,
                'path'    => $path
            ];
            
            $result = AttachmentFile::insert($values_list);
        }
        if($files) {
            Alert::toast('Atacchment Successfully Added!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when upload attachment!', 'error');
            return back();
        }
    }
    public function add_attach_reimburse_en(Request $request, $id)
    {
        $files = $request->file('filesRR');
        $now = Carbon::now()->addHours(7);
        $get_id = ReimburseEn::orderBy('id','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $fk_id = "REA00".$int;
        } else {
            $fk_id = $get_id[0]->fk_id;
            $num = substr($fk_id, 3,3);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $fk_id = "REA0".$int;
            }elseif($int > 99 && $int < 1000){
                $fk_id = $int;
            }elseif($int <= 9){
                $fk_id = "REA00".$int;
            }
        }
        $getAmount = $request->nominal;
        $cleanedAmount = str_replace(['Rp', ',', '.'], '', $getAmount);
        
        $amount = (int) $cleanedAmount;
        $val = [
            'notiket'           => $id,
            'fk_id'    => $fk_id,
            'nominal'    => $amount,
            'description'    => $request->desc_reimburse,
            'created_at'    => $now
        ];
        
        $result = ReimburseEn::insert($val);
        if($result) {
            foreach ($files as $file) {
                $fileName = uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path('/uploads/reimburse_EN'), $fileName);
                
                $path = '/uploads/reimburse_EN/'.$fileName;

                $val_attach = [
                    'fk_id'           => $fk_id,
                    'filename'    => $fileName,
                    'path'    => $path
                ];
                
                AttReimburseEn::insert($val_attach);
            }
            Alert::toast('Atacchment Successfully Added!', 'success');
            return redirect("Detail/Ticket=$id");
        }
        else {
            Alert::toast('Error when upload attachment!', 'error');
            return back();
        }
    }
    public function previewReimburse($fk)
    {
        $data['attachEN'] = AttReimburseEn::where('fk_id', $fk)->get();
        return view('Pages.Ticket.Reimburse.preview-reimburse')->with($data);
    }
}