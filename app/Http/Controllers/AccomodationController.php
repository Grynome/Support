<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityEngineer;
use App\Models\CategoryExpenses;
use App\Models\TCCompare;
use App\Models\CategoryReqs;
use App\Models\TypeTransport;
use App\Models\ReqsEn;
use App\Models\ReqsEnDT;
use App\Models\Expenses;

class AccomodationController extends Controller
{
    public function expenses($id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        $data['data_reqs'] = ReqsEn::all()->where('id_dt_reqs', $id)->first();
        $data['get_total'] = ReqsEnDT::select(\DB::raw('SUM(nominal) as total_reqs'))
                                ->where('id_dt_reqs', $id)
                                ->groupBy('id_dt_reqs')
                                ->first();
        
        $data['category_expanses'] = CategoryExpenses::where('deleted', 0)->get();
        
        return view('Pages.Accomodation.expenses')->with($data)->with('id_dt', $id);
    }
    public function request_reimburse($dsc, $id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        if ($dsc == "Past") {
            if ($role == 20) {
                $data['data_tiket'] = ActivityEngineer::select('hae.notiket', 'ht.case_id', 'hp.project_name', 'ic.name as kota')
                                    ->from(function ($query) {
                                        $query->select('notiket')
                                            ->from('hgt_activity_engineer')
                                            ->whereNot('en_id', 'HGT-KR002')
                                            ->groupBy('notiket', 'en_id');
                                    }, 'hae')
                                    ->leftJoin('hgt_ticket as ht', 'hae.notiket', '=', 'ht.notiket')
                                    ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                    ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                    ->leftJoin('hgt_end_user as heu', 'hpi.end_user_id', '=', 'heu.end_user_id')
                                    ->leftJoin('indonesia_cities as ic', 'heu.cities', '=', 'ic.id')
                                    ->get();
            } else {
                $data['data_tiket'] = ActivityEngineer::select('hae.notiket', 'ht.case_id', 'hp.project_name', 'ic.name as kota')
                                    ->from(function ($query) use ($nik) {
                                        $query->select('notiket')
                                            ->from('hgt_activity_engineer')
                                            ->where('en_id', $nik)
                                            ->groupBy('notiket', 'en_id');
                                    }, 'hae')
                                    ->leftJoin('hgt_ticket as ht', 'hae.notiket', '=', 'ht.notiket')
                                    ->leftJoin('hgt_project_info as hpi', 'ht.notiket', '=', 'hpi.notiket')
                                    ->leftJoin('hgt_project as hp', 'hpi.project_id', '=', 'hp.project_id')
                                    ->leftJoin('hgt_end_user as heu', 'hpi.end_user_id', '=', 'heu.end_user_id')
                                    ->leftJoin('indonesia_cities as ic', 'heu.cities', '=', 'ic.id')
                                    ->get();
            }
        }
        $data['ctgrqs'] = CategoryReqs::where('deleted', 0)->get();
        $data['ttns'] = TypeTransport::where('deleted', 0)->get();
        $data['top'] = ReqsEn::where('id_dt_reqs', $id)->first();
        
        return view('Pages.Accomodation.request')->with($data)->with('id_dt', $id)->with('dsc', $dsc);
    }
    public function vw_request_reimburse()
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        $depart =  auth()->user()->depart;
        if ($role == 20 || ($role == 19 && $depart == 6)) {
            if ($role == 19 && $depart == 6) {
                $data['data_reqs'] = ReqsEn::all()->where('status', 0);
            } else {
                $data['data_reqs'] = ReqsEn::all();
            }
        } else {
            if ($depart == 15) {
                if ($role == 19) {
                    $data['data_reqs'] = ReqsEn::leftJoin('hgt_expenses as he', 'hgt_reqs_en.id_expenses', '=', 'he.id_expenses')
                        ->where('he.status', '=', 0)
                        ->select('hgt_reqs_en.*', 'he.status as sts_lead_acc')
                        ->get();
                } else {
                    $data['data_reqs'] = ReqsEn::leftJoin('hgt_expenses as he', 'hgt_reqs_en.id_expenses', '=', 'he.id_expenses')
                        ->where('hgt_reqs_en.status', '=', 1)
                        ->select('hgt_reqs_en.*', 'he.status as sts_lead_acc')
                        ->get();
                    $data['cek_confirm'] = ReqsEnDT::select('id_dt_reqs')
                                        ->groupBy('id_dt_reqs')
                                        ->havingRaw('SUM(CASE WHEN `status` = 1 THEN 0 ELSE 1 END) = 0')
                                        ->get();
                }
            } else {
                $data['data_reqs'] = ReqsEn::where('en_id', $nik)->get();
            }
        }
        
        return view('Pages.Accomodation.vw_reqs')->with($data);
    }
    public function add_req_reimburse_en(Request $request, $dsc, $id)
    {
        $nik =  auth()->user()->nik;
        $now = Carbon::now()->addHours(7);
        if ( in_array($dsc, ["Add", "Past"]) ) {
            $tahun = $now->format('y');
            $bulan = $now->format('m');
            $hari = $now->format('d');
            $hasil = (int)($tahun . $bulan . $hari);

            $get_id = ReqsEn::orderBy('id_dt_reqs','desc')->take(1)->get();
            if ($get_id->isEmpty()) {
                $int = 1;
                    $generate_dt_id = $hasil.$int;
            } else {
                $dt_id = $get_id[0]->id_dt_reqs;
                $num = substr($dt_id, 6);
                $int = (int)$num;
                $int++;
                $generate_dt_id = $hasil.$int;
            }
            if ($dsc == "Past") {
                $notiket = $request->val_id_tiket_reqs;
            } else {
                $notiket = $id;
            }
            $val = [
                'notiket'       => $notiket,
                'id_dt_reqs'    => $generate_dt_id,
                'en_id'         => $nik,
                'id_type_trans' => $request->val_type_trans
            ];
        } else {
            if ($dsc == "Re") {
                $val = [
                    'id_type_trans' => $request->val_type_trans,
                    'status' => null,
                    'reject' => null,
                    'created_at' => $now
                ];
            }
            $get_id = ReqsEn::where('id_dt_reqs', $id)->first();
        }
        if($get_id) {
            if (in_array($dsc, ["Add", "Past"])) {
                ReqsEn::create($val);
                $id_dt_reqs = $generate_dt_id;
            }else{
                $id_dt_reqs = $get_id->id_dt_reqs;
                if ($dsc == "Re") {
                    $get_id->update($val);
                    $get_dt = ReqsEnDT::where('id_dt_reqs', $id_dt_reqs)->first();
                    $get_dt->delete();
                }
            }
            foreach ($request->input('val_ctgr') as $index => $category) {
                $nominal = $request->input('nominal')[$index];

                $cleanedAmount = str_replace(['Rp', ',', '.'], '', $nominal);
                $amount = (int) $cleanedAmount;
                // Attach Request
                if (!empty($request->file('attach_file')[$index])) {
                    $files = $request->file('attach_file')[$index];
                    
                    $fileName = uniqid() . '.' . $files->getClientOriginalExtension();
                    $path = 'uploads/attach_request/'.$fileName;
                } else {
                    $fileName = null;
                    $path = null;
                }
                
                $execute = ReqsEnDT::create([
                    'id_dt_reqs' => $id_dt_reqs,
                    'ctgr_reqs' => $category,
                    'nominal' => $amount,
                    'filename' => $fileName,
                    'path' => $path
                ]);
                if (!empty($request->file('attach_file')[$index])) {
                    if ($execute) {
                        $files->move(public_path('uploads/attach_request'), $fileName);
                    }
                }
            }
            Alert::toast('Successfully Add Request!', 'success');
            return redirect('/My-Expenses');
        }
        else {
            Alert::toast('Error When Saving Data!', 'error');
            return back();
        }
    }
    public function destroy_dt_en(Request $request, $id){
        $get_dt = ReqsEnDT::where('id', $id)->first();
        if($get_dt) {
            $pathFile = public_path("$get_dt->path");

            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
            $get_dt->delete();

            Alert::toast('Successfully Delete Data Detil!', 'success');
            return back();
        } else {
            Alert::toast('Error When Deleting!', 'error');
            return back();
        }
    }
    public function destroy_reqs(Request $request, $id){
        $get_id = ReqsEn::where('id', $id)->first();
        $get_dt = ReqsEnDT::where('id_dt_reqs', $get_id->id_dt_reqs);
        if($get_id && $get_dt) {
            $data_file = $get_dt->get();
            foreach ($data_file as $value) {
                $pathFile = public_path("/$value->path");

                if (file_exists($pathFile)) {
                    unlink($pathFile);
                }
                $value->delete();
            }
            $get_id->delete();
            $get_dt->delete();

            Alert::toast('Successfully Delete the Request!', 'success');
            return back();
        } else {
            Alert::toast('Error When Deleting!', 'error');
            return back();
        }
    }
    public function previewReimburse($fk)
    {
        $data['attachEN'] = AttReimburseEn::where('fk_id', $fk)->get();
        return view('Pages.Ticket.Reimburse.preview-reimburse')->with($data);
    }
    public function confirm_reqs(Request $request, $id){
        $role =  auth()->user()->role;
        $depart =  auth()->user()->depart;
        $value = [
            'status'    => 1
        ];
        $query = ReqsEn::where('id', $id)->first();
        if ($query) {
            if ($depart == 6 && $role == 19) {
                $query->update($value);
            }else{
                $get_expenses = Expenses::where('id_expenses', $query->id_expenses)->first();
                $get_expenses->update($value);
            }
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function reject_reqs(Request $request, $dsc, $id){
        $sts = $dsc == "Acc" ? 1 : 2;
        $value = [
            'reject'    => $sts
        ];
        $query = ReqsEn::where('id', $id)->first();
        if ($query) {
            $query->update($value);
            Alert::toast('Successfully Return it Back', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function check_detail_reqs_en(Request $request){
        $data = $request->all();
        if (isset($data['confirmed'])) {
            foreach ($data['confirmed'] as $id => $statuses) {
                $reqsEnDT = ReqsEnDT::find($id);

                if ($reqsEnDT) {
                    $status = $statuses[0];
                    $reqsEnDT->update(['status' => $status]);
                }
            }
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function attach_detail_reqs_en(Request $request){
        $data = $request->all();
        if (isset($data['attachDT_file'])) {
            foreach ($data['attachDT_file'] as $id => $val) {
                $reqsEnDT = ReqsEnDT::find($id);

                // Attach Request
                $fileName = uniqid() . '.' . $val[0]->getClientOriginalExtension();
                $path = 'uploads/attach_request/'.$fileName;
                
                if ($reqsEnDT) {
                   $execute = $reqsEnDT->update(['filename' => $fileName, 'path' => $path]);
                    if ($execute) {
                        $val[0]->move(public_path('uploads/attach_request'), $fileName);
                    }
                }
            }
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function store_expenses(Request $request, $id)
    {
        $total = $request->input('total_xps');
        
        $cleanedAmount = str_replace(['Rp', ',', '.'], '', $total);
        $amount = (int) $cleanedAmount;
        $values = [
            'description' => $request->desc_xps,
            'category' => $request->category_xps,
            'expenses_date' => $request->date_xps,
            'total' => $amount,
            'paid_by' => $request->paid_by_xps,
            'note' => $request->note_xps
        ];
        
        if($values) {
            $store_expenses = Expenses::create($values);
            if ($store_expenses) {
                $get_id_expenses = Expenses::orderBy('id_expenses','desc')->take(1)->first();
                $get_Reqs = ReqsEn::where('id_dt_reqs', $id)->first();
                $get_Reqs->update(['id_expenses' => $get_id_expenses->id_expenses]);
                Alert::toast("Success on Saving Data", 'success');
            }else{
                Alert::toast('Reqs En not updated!', 'warning');
            }
            return redirect('/My-Expenses');
        }
        else {
            Alert::toast('Failed saving', 'error');
            return back();
        }
    }
    public function execute_reqs(Request $request, $id){
        $value = [
            'status'    => 2
        ];
        $query = ReqsEn::where('id', $id)->first();
        if ($query) {
            $query->update($value);
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
}
