<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WL_Ticket;

class WLController extends Controller
{
    public function vw_sistem_lama()
    {
        $data['data'] = WL_Ticket::all();
        return view('Pages-WL.Ticket')->with($data);
    }
}
