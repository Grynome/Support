<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function partner()
    {
        $data['partner'] = Partner::all()->where('deleted', '!=', 1);
        return view('Pages/Partner/partner')->with($data);
    }
    public function form()
    {
        $data['province'] = \Indonesia::allProvinces();
        return view('Pages/Partner/form')->with($data);
    }
    public function store_partner(Request $request){
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $get_id = Partner::orderBy('partner_id','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $kode_awal = "PTN-00".$int;
        } else {
            $partner_id = $get_id[0]->partner_id;
            $num = substr($partner_id, 4,4);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $kode_awal = "PTN-0".$int;
            }elseif($int > 99 && $int < 1000){
                $kode_awal = "PTN-".$int;
            }elseif($int <= 9){
                $kode_awal = "PTN-00".$int;
            }
        }
        $vals = [
            'partner_id'    => $kode_awal,
            'partner'    => $request->partner_name,
            'contact_person'     => $request->cp_partner,
            'telp'     => $request->phone_partner,
            'email'     => $request->email_partner,
            'address'     => $request->address_partner,
            'deleted'     => 0
        ];
        
        if($vals) {
            Partner::insert($vals);
            Alert::toast('Successfully Saved Data', 'success');
            return redirect('Master/data=Partner');
        }
        else {
            Alert::toast('Failed Saved', 'error');
            return back();
        }
    }
    
    public function form_patch($id)
    {
        $data['province'] = \Indonesia::allProvinces();
        $data['data_ptn'] = Partner::where('partner_id', $id)->first();
        return view('Pages/Partner/form')->with($data)->with('id', $id);
    }

    public function patch_partner(Request $request, $id_ptn){
        $values = [
            'partner'    => $request->partner_name,
            'contact_person'     => $request->cp_partner,
            'telp'     => $request->phone_partner,
            'email'     => $request->email_partner,
            'address'     => $request->address_partner
        ];

        $query = Partner::where('partner_id', $id_ptn)->first();
        $result = $query->update($values);
        if ($result) {
            Alert::success('Success', 'Data Have Been Updated');
            return back();
        }
        else {
            Alert::error('Failed', 'Error when Updating');
            return back();
        }
    }
    public function destroy_partner(Request $request, $id_ptn){
        $values = [
            'deleted'    => 1
        ];

        $query = Partner::where('partner_id', $id_ptn)->first();
        $result = $query->update($values);
        if ($result) {
            Alert::success('Success', 'Data Have Been Deleted');
            return back();
        }
        else {
            Alert::error('Failed', 'Error when Updating');
            return back();
        }
    }
}
