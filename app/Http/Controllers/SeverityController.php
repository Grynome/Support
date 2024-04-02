<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Severity;

class SeverityController extends Controller
{
    public function severity()
    {
        $data['sev'] = Severity::all()->where('deleted', 0);
        return view('Pages/Severity/severity')->with($data);
    }
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s");
        
        $values = [
            'severity_name'    => $request->severity_name,
            'deleted'    => 0,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            Severity::insert($values);
            Alert::toast('Successfully Saved Data', 'success');
            return redirect('Master/data=Severity');
        }
        else {
            Alert::toast('Failed Saved Data', 'error');
            return back();
        }
    }
    public function update(Request $request, $id){
        $value = [
            'severity_name'    => $request->edit_name
        ];
        $query = Severity::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Successfully Updating', 'success');
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
        $query = Severity::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Successfully Removed Data', 'success');
            return back();
        }
        else {
            Alert::toast('Failed Removed Data', 'error');
            return back();
        }
    }
}
