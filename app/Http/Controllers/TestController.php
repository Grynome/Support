<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Models\Event;
use App\Models\Test;
use App\Models\Ticket;
use App\Models\VW_Ticket;
use App\Models\WB_Category_Product;
use App\Models\RefReqs;
use App\Models\ReqsEn;

class TestController extends Controller
{
    public function index()
    {
        $data['categories'] = DB::table('hgt_reqs_en_dt as hred')
                            ->leftJoin('hgt_category_reqs as hcr', 'hred.ctgr_reqs', '=', 'hcr.id')
                            ->groupBy('ctgr_reqs')
                            ->pluck('hcr.description', 'hred.ctgr_reqs');

        $query = ReqsEn::leftJoin('hgt_reqs_en_dt as hred', 'hgt_reqs_en.id_dt_reqs', '=', 'hred.id_dt_reqs')
                ->leftJoin('hgt_type_of_transport as htot', 'hgt_reqs_en.id_type_trans', '=', 'htot.id')
                ->leftJoin('hgt_expenses as he', 'hgt_reqs_en.id_expenses', '=', 'he.id_expenses')
                ->leftJoin('hgt_category_expenses as hce', 'he.category', '=', 'hce.id')
                ->leftJoin('hgt_users as hu', 'hgt_reqs_en.en_id', '=', 'hu.nik')
                ->leftJoin('hgt_service_point as hp', 'hu.service_point', '=', 'hp.service_id')
                ->leftJoin('indonesia_cities as ic', 'hp.kota_id', '=', 'ic.id')
                ->groupBy('hgt_reqs_en.id_dt_reqs')
                ->selectRaw('
                    hgt_reqs_en.id,
                    he.expenses_date as reqs_date,
                    he.description as desc_exp,
                    hce.description as ctgr_exp,
                    hu.full_name as engineer,
                    ic.name as Kota,
                    type_reqs,
                    case
                        when type_reqs = 1 then "Reimburse"
                        ELSE "Estimation"
                    END AS desc_reqs,
                    htot.description as type_trans,
                    hgt_reqs_en.id_dt_reqs, 
                    SUM(nominal) AS tln, 
                    SUM(actual) AS tla,
                    he.paid_by,
                    he.note'
                )->where('hgt_reqs_en.status', 3);

        foreach ($data['categories'] as $id => $description) {
            $escapedDescription = str_replace(' ', '_', $description);
            $query->selectRaw("max(CASE WHEN ctgr_reqs = $id THEN nominal ELSE 0 END) AS `$escapedDescription`");
        }
        $rawQuery = $query->get();
        $idsRN = $rawQuery->pluck('id')->toArray();
        $data['refTC'] = RefReqs::whereIn('id_reqs', $idsRN)->get()
        ->groupBy('id_reqs');
        $data['dt_reqs'] = $rawQuery;
        
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
