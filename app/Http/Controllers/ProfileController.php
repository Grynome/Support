<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile()
    {
        $nik =  auth()->user()->nik;
        $data['profile'] = User::all()->where('nik', $nik)->first();
        return view('Pages.Profile.index')->with($data);
    }
    public function update_biodata(Request $request)
    {
        $nik =  auth()->user()->nik;
        $phone_number = preg_replace('/[^0-9]/', '', $request->phone_user);
        if (substr($phone_number, 0, 2) == '62') {
            $phone_number = '0' . substr($phone_number, 2);
        }
        $value = [
            'full_name'    => $request->fn_user,
            'username'    => $request->un_user,
            'phone'    => $phone_number,
            'email'    => $request->mail_user
        ];
        $query = User::where('nik', $nik)->first();

        if($query) {
            $result = $query->update($value);
            Alert::toast('Profile updated successfully!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function reset_password(Request $request)
    {
        $nik =  auth()->user()->nik;
        $value = [
            'password'    => Hash::make($request->password_confirmation)
        ];
        $query = User::where('nik', $nik)->first();

        if($query) {
            $result = $query->update($value);
            Alert::toast('Password successfully change!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
    public function upload_image_user(Request $request){
        $nik =  auth()->user()->nik;
        $profile = $request->file('profile_file');
        // $cover = $request->file('cover_file');

        $nameProfile = uniqid().'_'.$profile->getClientOriginalName();
        $profile->move(public_path('/files/user/profile'), $nameProfile);
        
        $path = '/files/user/profile/'.$nameProfile;

        $imgUser = [
            'profile'           => $path
        ];
        
        $reesult = User::where('nik', $nik)->first()->update($imgUser);
        if($reesult) {
            Alert::toast('Succesfully updating!', 'success');
            return back();
        }
        else {
            Alert::toast('Error when Updating', 'error');
            return back();
        }
    }
}
