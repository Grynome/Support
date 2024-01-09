<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TypeUnit;
use App\Models\Project;
use App\Models\VW_MerkCategory;
use App\Models\MerkCategory;
use App\Models\TypeTicket;
use App\Models\Source;
use App\Models\SLA;
use App\Models\Merk;
use App\Models\CategoryUnit;
use App\Models\Partner;
use App\Models\Severity;
use App\Models\OfficeType;
use App\Models\ServicePoint;
use App\Models\CategoryNote;
use App\Models\CategoryReqs;

class DataAjaxController extends Controller
{
    public function cities(Request $request)
    {
        return \Indonesia::findProvince($request->id, ['cities'])->cities->pluck('name', 'id');
    }

    public function districts(Request $request)
    {
        return \Indonesia::findCity($request->id, ['districts'])->districts->pluck('name', 'id');
    }

    public function villages(Request $request)
    {
        return \Indonesia::findDistrict($request->id, ['villages'])->villages->pluck('name', 'id');
    }
    public function engineer(Request $request)
    {
        return User::where('depart',6)->where('service_point', $request->id)->where('verify', 1)->pluck('full_name', 'nik');
    }
    public function typeunit(Request $request)
    {
        return TypeUnit::where('category_id', $request->ctgrpi_id)->where('merk_id', $request->merk_id)->pluck('type_name','id');
    }
    public function category(Request $request)
    {
        return VW_MerkCategory::where('merk_id', $request->merk_id)->pluck('category_name');
    }
    public function get_project_partner(Request $request)
    {
        return Project::with('go_partner')->where('partner_id', $request->partner_id)->where('deleted', 0)->get();
    }
    public function dtProject(Request $request)
    {
        return Project::where('partner_id', $request->prt_id)->where('deleted', 0)->pluck('project_name', 'project_id');
    }
    public function getTicketsTodayFD()
    {
        $tgl = date("Y-m-d", strtotime("+7 hours"));
        $num_ticket = Ticket::selectRaw('COUNT(*) AS today_ticket')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_ticket')
                                ->from('hgt_ticket')
                                ->where('created_at', 'LIKE','%'.$tgl.'%')
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        $num_close = Ticket::selectRaw('COUNT(*) AS today_close')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_close')
                                ->from('hgt_ticket')
                                ->where('closedate', 'LIKE','%'.$tgl.'%')
                                ->where('status', 10)
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        $progpen_ticket = Ticket::selectRaw('COUNT(*) AS today_progpen')
                        ->fromSub(function ($query) use ($tgl) {
                            $query->selectRaw('COUNT(*) AS total_progpen')
                                ->from('hgt_ticket')
                                ->where('schedule', 'LIKE','%'.$tgl.'%')
                                ->where('status', '<', 10)
                                ->groupBy('notiket');
                        }, 'subquery')
                        ->first();
        return response()->json([
            'today_ticketfd' => $num_ticket->today_ticket,
            'num_closefd' => $num_close->today_close,
            'progpenfd' => $progpen_ticket->today_progpen
        ]);
    }
    
    public function kpi_user(Request $request)
    {
        return User::where('depart', $request->id)->pluck('full_name', 'nik');
    }
    public function fetchTypeTicket()
    {
        $typeTicket = TypeTicket::where('deleted', 0)->get();
        return response()->json($typeTicket);
    }
    public function fetchSource()
    {
        $source = Source::where('deleted', 0)->get();
        return response()->json($source);
    }
    public function fetchSLA()
    {
        $sla = SLA::where('deleted', 0)->get();
        return response()->json($sla);
    }
    public function fetchUnitMerk()
    {
        $merkUnit = Merk::where('deleted', 0)->get();
        return response()->json($merkUnit);
    }
    public function fetchUnitCategory()
    {
        $categoryUnit = CategoryUnit::where('deleted', 0)->get();
        return response()->json($categoryUnit);
    }
    public function fetchPartner()
    {
        $partner = Partner::where('deleted', 0)->get();
        return response()->json($partner);
    }
    public function fetchTypeCompany()
    {
        $typeOffice = OfficeType::where('deleted', 0)->get();
        return response()->json($typeOffice);
    }
    public function fetchLocation()
    {
        $severity = Severity::where('deleted', 0)->get();
        return response()->json($severity);
    }
    public function fetchServicePoint()
    {
        $servicePoint = ServicePoint::where('deleted', 0)->get();
        return response()->json($servicePoint);
    }
    public function fetchTypeNote()
    {
        $categoryNote = CategoryNote::where('deleted', 0)->get();
        return response()->json($categoryNote);
    }
    public function checkUsernameAndEmail(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        
        $userByUsername = User::where('username', $username)->first();
        $userByEmail = User::where('email', $email)->first();
        
        $response = [
            'usernameExists' => !is_null($userByUsername),
            'emailExists' => !is_null($userByEmail),
        ];
        
        return response()->json($response);
    }
    public function getCategories()
    {
        $categories = CategoryReqs::all();

        return response()->json($categories);
    }
}