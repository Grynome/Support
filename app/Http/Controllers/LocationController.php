<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PVC;
use App\Models\KAB;
use App\Models\KEC;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $data['provinces'] = PVC::get();
        $data['cities'] = KAB::get();
        $data['district'] = KEC::get();

        return view('Pages.SearchLoc.search')->with($data);
    }
}
