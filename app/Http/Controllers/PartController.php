<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PartType;

class PartController extends Controller
{
    public function type_part()
    {
        $data['part'] = PartType::all()->where('deleted', 0);
        return view('Pages.PartType.index')->with($data);
    }
    
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s");
        
        $values = [
            'part_type'    => $request->type_part_name,
            'desc_type'    => $request->desc_type,
            'status'    => $request->return_or_not,
            'deleted'    => 0,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            PartType::insert($values);
            Alert::toast('Successfully saved data!', 'success');
            return redirect('Master/data=Type-Part');
        }
        else {
            Alert::toast('Gagal Disimpan', 'error');
            return back();
        }
    }

    public function update(Request $request, $id){
        $value = [
            'part_type'    => $request->edt_type_name,
            'desc_type'    => $request->edt_return_or_not,
            'status'    => $request->edt_desc_type
        ];
        $query = PartType::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Successfully Updated', 'success');
            return back();
        }
        else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }

    public function remove(Request $request, $id){
        $value = [
            'deleted'    => 1
        ];
        $query = PartType::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Successfully Removed Data', 'success');
            return back();
        }
        else {
            Alert::toast('Failed Removed', 'error');
            return back();
        }
    }
}
