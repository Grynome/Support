<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class AccomodationController extends Controller
{
    public function partner()
    {
        return view('Pages.Accomodation.index');
    }
}
