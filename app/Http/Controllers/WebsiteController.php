<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Models\WB_Category_Product;
use App\Models\WB_Product;
use App\Models\WB_InquiryMSG;

class WebsiteController extends Controller
{
    // Start Kategory Product
    public function vw_web_ctgr_prd()
    {
        $data['data'] = WB_Category_Product::all();
        return view('Pages-WB.Category-Product.index')->with($data);
    }
    // END Category Product
    // Start Product
    public function vw_web_prd()
    {
        $data['wb_product'] = WB_Product::all();
        $data['wb_category'] = WB_Category_Product::all();
        return view('Pages-WB.Product.index')->with($data);
    }
    
    public function store_wb_upload(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));

        $file = $request->file('wb_file_upload');
        $fileName = uniqid().'_'.$file->getClientOriginalName();
        $destinationPath = 'products';

        $path = 'Library/uploads/products/'.$fileName;

        $act_upload = Storage::disk('local')->putFileAs($destinationPath, $file, $fileName);
        if ($act_upload) {
            $fileModel = new WB_Product();
            $fileModel->product_name = $request->wb_product_name;
            $fileModel->filename = $fileName;
            $fileModel->category = $request->wb_category_product;
            $fileModel->path = $path;
            $fileModel->information = $request->product_information;
            $fileModel->created_at = $dateTime;
            $fileModel->save();
            Alert::toast('Successfully Upload File', 'success');
            return back();
        }
    }
    // END Product
    // Start Inquiry Message
    public function vw_web_inquiry_msg()
    {
        $data['inq_msg'] = WB_InquiryMSG::all();
        return view('Pages-WB.Inquiry-Message.index')->with($data);
    }
    // END Inquiry Message
    
}
