<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\SLA;

class SLAController extends Controller
{
    public function sla()
    {
        $data['sla'] = SLA::all()->where('deleted', 0);
        return view('Pages/SLA/sla')->with($data);
    }
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $get_id = SLA::orderBy('sla_id','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $kode_awal = "SLA-00".$int."-HGT";
        } else {
            $sla_id = $get_id[0]->sla_id;
            $num = substr($sla_id, 4,4);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $kode_awal = "SLA-0".$int."-HGT";
            }elseif($int > 99 && $int < 1000){
                $kode_awal = "SLA-".$int."-HGT";
            }elseif($int <= 9){
                $kode_awal = "SLA-00".$int."-HGT";
            }
        }
        
        $values = [
            'sla_id'           => $kode_awal,
            'sla_name'    => $request->sla_name,
            'lama'    => $request->longer,
            'kondisi'    => $request->condition,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            SLA::insert($values);
            Alert::toast('Successfully Save Data', 'success');
            return redirect('Master/data=SLA');
        }
        else {
            Alert::toast('Failed saving', 'error');
            return back();
        }
    }
    public function update(Request $request, $id){
        $value = [
            'sla_name'    => $request->edit_name,
            'lama'    => $request->edit_lama,
            'kondisi'    => $request->edt_condition
        ];
        if ($value) {
        $query = SLA::where('sla_id', $id)->first();
        $query->update($value);
            Alert::toast('Success Updating!', 'success');
            return back();
        }
        else {
            Alert::toast('Error When Updating', 'error');
            return back();
        }
    }
    public function remove(Request $request, $id){
        $value = [
            'deleted'    => 1
        ];
        if ($value) {
        $query = SLA::where('sla_id', $id)->first();
        $query->update($value);
            Alert::toast('Success Remove Data', 'success');
            return back();
        }
        else {
            Alert::toast('Failed to Remove', 'error');
            return back();
        }
    }
}
