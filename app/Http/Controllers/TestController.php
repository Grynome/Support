<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Test;
use App\Models\Ticket;
use App\Models\VW_Ticket;
use App\Models\WB_Category_Product;

class TestController extends Controller
{
    public function index()
    {
        $data['data'] = WB_Category_Product::all();
        return view('Pages.Test.test')->with($data);
    }
    public function upload(Request $request)
    {
        $file = $request->file('file_test');
        $fileName = $file->getClientOriginalName();
        $destinationPath = 'uploads';

        $act_upload = Storage::disk('local')->putFileAs($destinationPath, $file, $fileName);
        if ($act_upload) {
            Alert::toast('Successfully Upload File', 'success');
            return back();
        }
    }
}
