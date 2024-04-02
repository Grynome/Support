<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\WhatNews;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function main()
    {
        $data['square'] = WhatNews::where('aktif', 1)->orderBy('created_at', 'desc')->get();
        return view('Pages.Dashboard.what-news')->with($data);
    }
    public function wn_form()
    {
        return view('Pages.WhatNews.index');
    }

    public function store_wn_square(Request $request)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s");
        
        $values = [
            'nik'    => $nik,
            'square'    => $request->wn_information,
            'aktif'    => 1,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            WhatNews::insert($values);
            Alert::toast('Successfully Sended!', 'success');
            return back();
        } else {
            Alert::toast('Failed Saving!', 'error');
            return back();
        }
    }
    public function downloadDocs()
    {
        $path = public_path('files/docs/Manual Book HGT Services.pdf');

        return response()->download($path);
    }
}
