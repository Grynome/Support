<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Partner;

class ProjectController extends Controller
{
    public function project()
    {
        $data['project'] = Project::all()->where('deleted', '!=', 1);
        $data['partner'] = Partner::all()->where('deleted', '!=', 1);
        return view('Pages/Project/project')->with($data);
    }
    public function form_add()
    {
        $data['partner'] = Partner::all()->where('deleted', '!=', 1);
        return view('Pages/Project/form')->with($data);
    }
    public function form_udpate($id)
    {
        $data['partner'] = Partner::all()->where('deleted', '!=', 1);
        $data['data_project'] = Project::where('project_id', $id)->first();
        return view('Pages/Project/form')->with($data);                         
    }
    public function store(Request $request)
    {
        $dateTime = date("Y-m-d H:i:s", strtotime("+7 hours"));
        $get_id = Project::orderBy('project_id','desc')->take(1)->get();
        if ($get_id->isEmpty()) {
            $int = 1;
                $kode_awal = "PRJ-00".$int."-HGT";
        } else {
            $project_id = $get_id[0]->project_id;
            $num = substr($project_id, 4,4);
            $int = (int)$num;
            $int++;
            if($int > 9 && $int < 100){
                $kode_awal = "PRJ-0".$int."-HGT";
            }elseif($int > 99 && $int < 1000){
                $kode_awal = "PRJ-".$int."-HGT";
            }elseif($int <= 9){
                $kode_awal = "PRJ-00".$int."-HGT";
            }
        }
        
        $values = [
            'project_id'           => $kode_awal,
            'no_contract'           => $request->contract_prj,
            'partner_id'           => $request->partner_id,
            'contact_person'           => $request->contact_name,
            'project_name'    => $request->project_name,
            'startdate'    => $request->start_date,
            'enddate'    => $request->end_date,
            'mail_project'    => $request->project_mail,
            'phone'    => $request->phone_prj,
            'desc'    => $request->desc,
            'status'    => $request->sts,
            'created_at'    => $dateTime
        ];
        
        if($values) {
            Project::insert($values);
            Alert::toast('Successfully Saved Data', 'success');
            return redirect('Master/data=Project');
        }
        else {
            Alert::toast('Failed saving', 'error');
            return back();
        }
    }
    public function update(Request $request, $id){
        $values = [
            'partner_id'           => $request->partner_id,
            'no_contract'           => $request->contract_prj,
            'contact_person'           => $request->contact_name,
            'project_name'    => $request->project_name,
            'startdate'    => $request->start_date,
            'enddate'    => $request->end_date,
            'mail_project'    => $request->project_mail,
            'desc'    => $request->desc,
            'status'    => $request->sts
        ];

        $query = Project::where('project_id', $id)->first();
        $result = $query->update($values);
        if ($result) {
            Alert::toast('Successfully Updating', 'success');
            return redirect('Master/data=Project');
        }
        else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function destroy(Request $request, $id){
        $value = [
            'deleted'    => 1
        ];
        $query = Project::where('id', $id)->first();
        $result = $query->update($value);
        if ($result) {
            Alert::toast('Successfully Deleted Data', 'success');
            return back();
        }
        else {
            Alert::toast('Failed Deleted Data', 'error');
            return back();
        }
    }
}
