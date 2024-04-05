<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated()
    {
        $role = auth()->user()->role;
        $depart = auth()->user()->depart;
        $verify = auth()->user()->verify;
        $nik = auth()->user()->nik;
        
        if ($verify != 1) {
            return redirect('/NotVerified');
        } else {
            if (in_array($role, [19, 1])) {
                return redirect('/');
            } else {
                if ($depart == 3) {
                        return redirect('/');
                } else {
                    if ($nik == "HGT-KR055") {
                        return redirect("/Choose-dept");
                    } else {
                        if (in_array($depart, [15, 10, 9])) {
                            return redirect('/');
                        } else {
                            return redirect()->route('manage.ticket');
                        }
                    }
                }
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.newLogin');
    }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
    /**
     * Get the password for the user.
     *
     * @return string
     */
    // public function getAuthPassword()
    // {
    //     return $this->password;
    // }
}
