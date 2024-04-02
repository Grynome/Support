<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class UserController extends Controller
{
    public function user(Request $request)
    {
        if (!isset($request->stats_user)) {
            $data['user'] = User::all();
        }else {
            if ($request->stats_user == 1) {
                $data['user'] = User::all()->where('verify', 1);
            } else {
                $data['user'] = User::all()->where('verify', 0);
            }
        }
        return view('Pages/User/user')->with($data)->with('sts_verify', $request->stats_user);
    }
    public function verify(Request $request, $id){
        $dateTime = date("Y-m-d H:i:s");
        $value = [
            'verify'    => 1,
            'verify_at'    => $dateTime
        ];
        $query = User::where('nik', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('User has been verified!', 'success');
            return back();
        }
        else {
            Alert::toast('Failed verify User!', 'error');
            return back();
        }
    }
    public function deactivated(Request $request, $id){
        $dateTime = date("Y-m-d H:i:s");
        $value = [
            'verify'    => 2,
            'verify_at'    => $dateTime
        ];
        $query = User::where('nik', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('User has been Deactivated!', 'success');
            return back();
        }
        else {
            Alert::toast('Failed Deactivated User!', 'error');
            return back();
        }
    }
}
