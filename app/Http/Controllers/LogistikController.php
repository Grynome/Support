<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\TiketPartNew;
use App\Models\VW_List_Part_AWB;
use App\Models\VW_Tiket_Part;
use App\Models\ServicePoint;
use App\Models\VW_Logistik;
use App\Models\ListPartAWB;
use App\Models\TiketPartDetail;
use App\Models\LoggingLogistik;
use App\Models\Ticket;

class LogistikController extends Controller
{
    // Open Listed
    public function page_listed_part(Request $request)
    {
        $data['listed_part'] = VW_Logistik::where('status_tiket', 10)
                                ->where('total_return', '>', 0)
                                ->where('status_awb', 0)
                                ->whereIn('id_prj', [34, 35])
                                ->get();
                    
        return view('Pages.Logistik.awb_listed')->with($data);
    }
    // Closed Listed
    public function closed_listed(Request $request)
    {
        $data['awb_generated'] = VW_Logistik::where('status_awb', 1)->whereBetween('awb_at', [$tanggal1.' '.'00:00:00', $tanggal2.' '.'23:59:59'])->get();
                    
        return view('Pages.Logistik.awb_listed')->with($data);
    }
    // AWB View 
    public function view_awb($key){
        $nik =  auth()->user()->nik;
        $get_part_detail_id = TiketPartNew::where('notiket',$key)->first();
        $data['validate_list'] = VW_List_Part_AWB::where('part_detail_id',$get_part_detail_id->part_detail_id)->where('status',0)->first();
        $data['data_list'] = VW_List_Part_AWB::all()->where('part_detail_id',$get_part_detail_id->part_detail_id)->where('nik',$nik)->where('status',0);
        $data['part_awb'] = VW_Tiket_Part::all()->where('part_detail_id',$get_part_detail_id->part_detail_id)->where('sts_type', 1);
        $data['dt_ticket'] = VW_Logistik::all()->where('notiket', $key)->first();
        $data['get_ads_sp'] = ServicePoint::all()->where('service_id', $data['dt_ticket']->service_id)->first();
        $data['validate_save'] = VW_Tiket_Part::where('part_detail_id', $get_part_detail_id->part_detail_id)
                        ->where(function($query) {
                            $query->whereNull('status_list')
                                  ->orWhere('status_list', 0);
                        })->where('sts_type', 1)->first();
        return view('Pages.Logistik.awb')->with($data)->with('key', $key);
    }
    public function store_part_list_awb(Request $request, $notiket, $pid)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s");
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
        $dateTime = date("Y-m-d H:i:s");
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
            return redirect('Listed-Return/Parts');
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
    
    public function excel_lp(Request $request)
    {
        $listed_part = VW_Tiket_Part::all()
                                ->whereIn('id_prj', [34, 35])
                                ->where('sts_type', 1);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $headers = 
        [
            'No',
            'Tanggal Closed',
            'Tanggal Pick Up',
            'Tgl Request Pick Up',
            'Project',
            'Service Point',
            'Engineer',
            'Company',
            'Alamat',
            'Telpon',
            'Email',
            'SAP Order',
            'PN',
            'RMA',
            'Description',
            'Part Status',
            'Case ID',
            'AWB'
        ];
        $sheet->fromArray([$headers], NULL, 'A1');

        $no = 1;
        $row = 2;
        foreach ($listed_part as $item) {
                if ($item->dt_tc->get_pi->go_jekfo->id == 34) {
                    $ads = "";
                    $phn = @$item->dt_tc->get_u->phone;
                    $email = @$item->dt_tc->get_u->email;
                    $cpy = @$item->dt_tc->get_u->get_sp->service_name;
                } else {
                    $ads = @$item->dt_tc->get_pi->go_end_user->address;
                    $phn = @$item->dt_tc->get_pi->go_end_user->phone;
                    $email = @$item->dt_tc->get_pi->go_end_user->email;
                    $cpy = @$item->dt_tc->get_pi->go_end_user->end_user_name;
                }
                
                $data = [
                    $no,
                    '',
                    '',
                    '',
                    $item->dt_tc->get_pi->go_jekfo->project_name,
                    @$item->dt_tc->get_u->get_sp->service_name,
                    @$item->dt_tc->get_u->full_name,
                    $cpy,
                    $ads,
                    $phn,
                    $email,
                    '',
                    $item->pn,
                    "'" . $item->rma,
                    $item->unit_name,
                    $item->part_type,
                    "'" . @$item->dt_tc->case_id,
                    $item->awb_num
                ];
                $sheet->fromArray([$data], NULL, "A$row");
            $row++;
            $no++;
        }
        $filename = "Data Listed Parts.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
}
