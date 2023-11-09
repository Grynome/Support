<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Dept;
use App\Models\Role;
use App\Models\ServicePoint;

class RegisterController extends Controller
{
    public function regs()
    {
        $data['dept'] = Dept::all();
        $data['sp'] = ServicePoint::all();
        $data['role'] = Role::where('id', '!=', 20)->orderBy('role','asc')->get();
        return view('auth/register')->with($data);
    }
    public function store(Request $request)
    {
        $getNIK = User::orderBy('nik','desc')->take(1)->get();
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        if ($getNIK->isEmpty()) {
            $int = 1;
            $kode_awal = "HGT-KR00".$int;
        }else {
            $nik = $getNIK[0]->nik;
            $num = substr($nik, 6);
            $int = (int)$num;
            $int++;
                
            if($int <= 9){
                $kode_awal = "HGT-KR00".$int;
            }elseif($int > 9 && $int < 100){
                $kode_awal = "HGT-KR0".$int;
            }elseif($int > 99 && $int < 1000){
                $kode_awal = "HGT-KR".$int;
            }
        }
            $values = [
                'nik'           => $kode_awal,
                'full_name'    => $request->name,
                'username'      => $request->username,
                'gender'        => $request->gender,
                'role'          => $request->role,
                'depart'          => $request->department,
                'service_point'          => $request->sp,
                'chanel'          => $request->chanel,
                'email'         => $request->email,
                'phone'         => $request->phone_wa,
                'tipe_kerja'         => $request->work_type,
                'verify'         => 0,
                'password'      => Hash::make($request->password),
                'created_at'      => $dateTime,
                'Terms'         => $request->term_con
            ];

            User::insert($values);

            if($values) {
                Alert::toast('Successfully Register!', 'success');
                return redirect('login');
            }
            else {
                Alert::toast('Failed Registration', 'error');
                return back();
            }
    }
}
