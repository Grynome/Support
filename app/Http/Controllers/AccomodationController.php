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
use App\Models\RefReqs;
use App\Models\Ticket;
use App\Models\VW_Reqs_En;

class AccomodationController extends Controller
{
    public function expenses($id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        
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
        if ($dsc != "Past") {
            $data['data_tiket'] = Ticket::select('notiket')
                                    ->where('status', '<', '10')
                                    ->where('en_id', $nik)
                                    ->where('notiket', '!=', $id)
                                    ->get();
        } else {
            $data['data_tiket'] = ActivityEngineer::select('hae.notiket')
                                    ->from(function ($query) use ($nik) {
                                        $query->select('notiket')
                                            ->from('hgt_activity_engineer')
                                            ->where('en_id', $nik)
                                            ->groupBy('notiket', 'en_id');
                                    }, 'hae')
                                    ->get();
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
                $data['data_reqs'] = VW_Reqs_En::where('status', 0)->orWhere('side_sts', 2)->get();
            } else {
                $data['data_reqs'] = VW_Reqs_En::all();
            }
        } else {
            if ($depart == 15) {
                if ($role == 19) {
                    $data['data_reqs'] = VW_Reqs_En::leftJoin('hgt_expenses as he', 'vw_reqs_en.id_expenses', '=', 'he.id_expenses')
                        ->where('he.status', '=', 0)
                        ->orWhere('side_sts', 3)
                        ->select('vw_reqs_en.*', 'he.status as sts_lead_acc')
                        ->get();
                } else {
                    $data['data_reqs'] = VW_Reqs_En::leftJoin('hgt_expenses as he', 'vw_reqs_en.id_expenses', '=', 'he.id_expenses')
                        ->where('vw_reqs_en.status', '>=', 1)
                        ->where('vw_reqs_en.status', '<', 3)
                        ->select('vw_reqs_en.*', 'he.status as sts_lead_acc')
                        ->get();
                    $data['cek_confirm'] = ReqsEnDT::select('id_dt_reqs')
                                        ->groupBy('id_dt_reqs')
                                        ->havingRaw('SUM(CASE WHEN `status` = 1 THEN 0 ELSE 1 END) = 0')
                                        ->get();
                }
            } else {
                $data['data_reqs'] = VW_Reqs_En::where('en_id', $nik)->where('status', '<', 3)->get();
            }
        }
        
        return view('Pages.Accomodation.vw_reqs')->with($data);
    }
    public function add_req_reimburse_en(Request $request, $dsc, $id)
    {
        $nik =  auth()->user()->nik;
        $now = Carbon::now()->addHours(7);
        
        $fuckingsubquery = DB::table(function ($query) {
            $query->selectRaw('*')
                ->from(function ($innerSubquery) {
                    $innerSubquery->select('notiket', 
                                DB::raw('max(act_description) AS last_act'),
                                DB::raw('MAX(visitting) AS last_visit'))
                        ->from('hgt_activity_engineer')
                        ->groupBy('notiket', 'visitting')
                        ->orderBy('visitting', 'DESC');
                }, 'hl2')
            ->groupBy('notiket');
        });

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
            $val = [
                'type_reqs'    => $request->type_reqs,
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
                $storeReqs = ReqsEn::create($val);
                $id_dt_reqs = $generate_dt_id;
                if ($storeReqs) {
                    $val_id = ReqsEn::where('id_dt_reqs', $id_dt_reqs)->first();
                    $get_val_id = $request->input('val_id_tiket_reqs', []);
                    $url_id = $id == 'Null' ? [] : [$id];
                    $data_notik = array_merge($url_id, $get_val_id);
                    foreach ($data_notik as $tiket) {
                        $get_visit = $fuckingsubquery->where('notiket', $tiket)->first();
                        
                        if (empty($get_visit)) {
                            $visit = 1;
                        } elseif (!empty($get_visit)) {
                            $visit = $get_visit->last_visit == 0 
                                        ? ($get_visit->last_act == 1 || $get_visit->last_act == 9
                                            ? 1
                                            : 2) 
                                        : ($get_visit->last_visit == 1
                                            ? ($get_visit->last_act == 1 || $get_visit->last_act == 9
                                                ? 2
                                                : 3)
                                            :($get_visit->last_visit == 2
                                                ? ($get_visit->last_act == 1 || $get_visit->last_act == 9
                                                    ? 3
                                                    : 4)
                                                : ($get_visit->last_act == 1 || $get_visit->last_act == 9
                                                    ? 4
                                                    : 5)));
                        }

                        RefReqs::create([
                            'id_reqs' => $val_id->id,
                            'notiket' => $tiket,
                            'reqs_at' => $visit
                        ]);
                    }
                }
            }else{
                $id_dt_reqs = $get_id->id_dt_reqs;
                if ($dsc == "Re") {
                    $get_id->update($val);
                    $get_dt = ReqsEnDT::where('id_dt_reqs', $id_dt_reqs)->delete();
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
        $refreqs = RefReqs::where('id_reqs', $id)->first();
        $get_dt = ReqsEnDT::where('id_dt_reqs', $get_id->id_dt_reqs);
        if($get_id && $get_dt) {
            $data_file = $get_dt->get();
            foreach ($data_file as $value) {
                if (!empty($value->path)) {
                    $pathFile = public_path("$value->path");

                    if (file_exists($pathFile)) {
                        unlink($pathFile);
                    }
                }
                $value->delete();
            }
            $get_id->delete();
            $refreqs->delete();
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
        if (isset($data['attachDT_file']) && $data['actual'] !== null) {
            foreach ($data['attachDT_file'] as $id => $val) {
                $reqsEnDT = ReqsEnDT::find($id);

                // Attach Request
                $fileName = uniqid() . '.' . $val[0]->getClientOriginalExtension();
                $path = 'uploads/attach_request/'.$fileName;
                
                if ($data['actual'][$id][0] == $reqsEnDT->actual) {
                    $val_actual = $reqsEnDT->actual;
                } else {
                    $val_actual = $data['actual'][$id][0];
                }
                
                $cleanedAmount = str_replace(['Rp', ',', '.'], '', $val_actual);
                $amount = (int) $cleanedAmount;

                if ($reqsEnDT) {
                   $execute = $reqsEnDT->update([
                        'filename' => $fileName, 
                        'path' => $path, 
                        'actual' => $amount
                    ]);
                    if ($execute) {
                        $val[0]->move(public_path('uploads/attach_request'), $fileName);
                    }
                }
            }
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('One of Row fields must be filled', 'error');
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
                if ($get_Reqs->type_reqs == 1) {
                    $query_dt = ReqsEnDT::where('id_dt_reqs', $id)->get();
                    foreach ($query_dt as $dt) {
                        $convert = str_replace(['Rp', ',', '.'], '', $dt->nominal);
                        $actual = (int) $convert;
                        ReqsEnDT::where('id', $dt->id)->update(['actual' => $actual]);
                    }
                }
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
        $query = ReqsEn::where('id', $id)->first();
        if ($query->type_reqs == 1) {
            $value = [
                'status'    => 3
            ];
        } else {
            $value = [
                'status'    => 2
            ];
        }
        
        if ($query) {
            $query->update($value);
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function finish_reqs(Request $request, $id){
        $get_data = VW_Reqs_En::where('id', $id)->first();
        if ($get_data->tln == $get_data->tla) {
            $value = [
                'status'    => 3
            ];
            $alert = "The Request had been Done!";
        } else if ($get_data->tln >= $get_data->tla) {
            $value = [
                'status'    => 3,
                'additional'    => 1
            ];
            $alert = "Updated Successfully!";
        } else {
            $role =  auth()->user()->role;
            $depart =  auth()->user()->depart;

            if ($get_data->side_sts == 4) {
                $value = [
                    'status'    => 3,
                    'additional'    => 4
                ];
                $alert = "The Request had been Done!";
            }else{
                list($alert, $adt) = $depart == 6 ? ["Confirmed Approved!", 3] : ($role == 19 ? ["Approved!", 4] : ["Approval Had been Sent", 2]);
                $value = [
                    'additional'    => $adt
                ];
            }
        }
        if ($get_data) {
            $query = ReqsEn::where('id', $id)->first();
            $query->update($value);
            Alert::toast($alert, 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
}
