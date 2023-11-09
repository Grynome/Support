<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\ServicePoint;
use App\Models\User;

class SPController extends Controller
{
    public function service_point()
    {
        $data['sp'] = ServicePoint::all()->where('deleted', 0);
        return view('Pages/ServicePoint/sp')->with($data);
    }
    public function form_sp()
    {
        $data['province'] = \Indonesia::allProvinces();
        $data['user'] = User::all()->where('depart', 4)->where('verify', 1);
        return view('Pages/ServicePoint/form')->with($data);
    }
    public function store(Request $request){
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $values = [
            'service_name'    => $request->sp_name,
            'ownership'    => $request->ownership_sp,
            'alamat'    => $request->address,
            'provinsi_id'    => $request->provinces_sp,
            'kota_id'    => $request->cities_sp,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'head'    => $request->nik_head,
            'status'    => 1,
            'deleted'    => 0,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            ServicePoint::insert($values);
            Alert::toast('Data Success Saved!', 'success');
            return redirect('Master/data=ServicePoint');
        }
        else {
            Alert::toast('Failed save data!', 'error');
            return back();
        }
    }
    public function form_udpate($id)
    {
        $data['province'] = \Indonesia::allProvinces();
        $data['user'] = User::all()->where('depart', 4)->where('verify', 1);
        $data['data_sp'] = ServicePoint::where('service_id', $id)->first();
        return view('Pages/ServicePoint/form')->with($data);                         
    }
    public function update(Request $request, $id)
    {
        $values = [
            'service_name'    => $request->sp_name,
            'ownership'    => $request->ownership_sp,
            'alamat'    => $request->address,
            'provinsi_id'    => $request->provinces_sp,
            'kota_id'    => $request->cities_sp,
            'phone'    => $request->phone,
            'email'    => $request->email,
            'head'    => $request->nik_head
        ];
        $query = ServicePoint::where('service_id', $id)->first();
        $result = $query->update($values);
        if ($result) {
            Alert::toast('Successfully saved!', 'success');
            return redirect('Master/data=ServicePoint');
        }
        else {
            Alert::toast('Failed updating!', 'error');
            return back();
        }                                
    }
    public function destroy($id)
    {
        $values = [
            'deleted'    => 1
        ];
        $query = ServicePoint::where('service_id', $id)->first();
        $result = $query->update($values);
        if ($result) {
            Alert::toast('Successfully deleted!', 'success');
            return redirect('Master/data=ServicePoint');
        }
        else {
            Alert::toast('Failed updating!', 'error');
            return back();
        }                                
    }
    // SP Detil
        public function sp_dt()
        {
            $data['sp'] = ServicePoint::all()->where('deleted', 0);
            return view('Pages.SP-DT.index')->with($data);
        }
}
