<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Source;

class SourceController extends Controller
{
    public function source()
    {
        $data['source'] = Source::all()->where('deleted', 0);
        return view('Pages/Source/source')->with($data);
    }
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $get_id = Source::orderBy('sumber_id','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $kode_awal = "SRC-00".$int."-HGT";
        } else {
            $sumber_id = $get_id[0]->sumber_id;
            $num = substr($sumber_id, 4,4);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $kode_awal = "SRC-0".$int."-HGT";
            }elseif($int > 99 && $int < 1000){
                $kode_awal = "SRC-".$int."-HGT";
            }elseif($int <= 9){
                $kode_awal = "SRC-00".$int."-HGT";
            }
        }
        
        $values = [
            'sumber_id'           => $kode_awal,
            'sumber_name'    => $request->source_name,
            'detail'    => $request->detail,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            Source::insert($values);
            Alert::toast('Data Berhasil Disimpan', 'success');
            return redirect('Master/data=Source');
        }
        else {
            Alert::toast('Error when save date', 'error');
            return back();
        }
    }
    public function update(Request $request, $id){
        $value = [
            'sumber_name'    => $request->edit_name,
            'detail'    => $request->edit_detail
        ];
        $query = Source::where('sumber_id', $id)->first();
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
        $value = [
            'deleted'    => 1
        ];
        $query = Source::where('sumber_id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Data Have Been Removed', 'success');
            return back();
        }
        else {
            Alert::toast('Error when removing Data', 'error');
            return back();
        }
    }
}
