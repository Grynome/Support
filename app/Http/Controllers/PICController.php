<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\ActPIC;
use App\Models\TypeActPIC;

class PICController extends Controller
{
    public function vw_actPIC()
    {
        $nik =  auth()->user()->nik;
        $dept =  auth()->user()->depart;
        if ($dept == 3) {
            $data['activity'] = ActPIC::all()->where('nik', $nik);
        } else {
            $data['activity'] = ActPIC::all();
        }
        
        $data['type_act'] = TypeActPIC::all()->where('deleted', 0);
        return view('Pages/PIC/actvity')->with($data);
    }
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $nik =  auth()->user()->nik;
        $values = [
            'nik'    => $nik,
            'id_type'    => $request->select_val_tap,
            'tanggal'    => $request->val_dt_tap,
            'description'    => $request->desc_pic,
            'created_at'    => $dateTime
        ];
        if($values) {
            ActPIC::insert($values);
            Alert::toast('Data Berhasil Disimpan', 'success');
             return back();
        }
        else {
            Alert::toast('Error when save date', 'error');
            return back();
        }
    }
    public function update(Request $request, $id){
        $value = [
            'id_type'    => $request->edt_type_act_pic,
            'tanggal'    => $request->edt_dt_tap,
            'description'    => $request->edt_desc_pic
        ];
        $query = ActPIC::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
        Alert::toast('Data Have Been Updated', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function remove(Request $request, $id){
        $query = ActPIC::where('id', $id)->delete();;
        if ($query) {
            Alert::toast('Data Have Been Removed', 'success');
            return back();
        }
        else {
            Alert::toast('Error when removing Data', 'error');
            return back();
        }
    }
}
