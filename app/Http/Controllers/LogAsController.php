<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dept;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class LogAsController extends Controller
{
    public function vw_choose()
    {
        $data['dept'] = Dept::all()->whereIn('id', [6, 13]);
        return view('Pages.choose_depart')->with($data);
    }

    public function update_dept(Request $request){
        $nik =  auth()->user()->nik;
        $getUpdt = User::where('nik', $nik)->first();
        if($getUpdt) {
            if($request->val_dept != $getUpdt->depart){
                $updtDept = [
                    'depart'    => $request->val_dept
                ];
                $getUpdt->update($updtDept);
            }
            $getDept = Dept::where('id', $request->val_dept)->first();
            Alert::toast("Your Log as $getDept->department!", 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Your Log in Failed', 'error');
            return back();
        }
    }
}
