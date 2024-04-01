<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\ActivityEngineer;
use App\Models\CategoryExpenses;
use App\Models\TCCompare;
use App\Models\CategoryReqs;
use App\Models\TypeTransport;
use App\Models\ReqsEn;
use App\Models\ReqsEnDT;
use App\Models\Expenses;
use App\Models\RefReqs;
use App\Models\Ticket;
use App\Models\VW_Reqs_En;
use App\Models\User;

class AccomodationController extends Controller
{
    public function expenses($id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        
        $data['get_total'] = ReqsEnDT::select(\DB::raw('SUM(nominal) as total_reqs'))
                                ->where('id_dt_reqs', $id)
                                ->groupBy('id_dt_reqs')
                                ->first();
        
        $data['category_expanses'] = CategoryExpenses::where('deleted', 0)->get();
        
        return view('Pages.Accomodation.expenses')->with($data)->with('id_dt', $id);
    }
    public function request_reimburse($dsc, $id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        if ($dsc != "Past") {
            $data['data_tiket'] = Ticket::select('notiket')
                                    ->where('status', '<', '10')
                                    ->where('en_id', $nik)
                                    ->where('notiket', '!=', $id)
                                    ->get();
        } else {
            $data['data_tiket'] = ActivityEngineer::select('hae.notiket')
                                    ->from(function ($query) use ($nik) {
                                        $query->select('notiket')
                                            ->from('hgt_activity_engineer')
                                            ->where('en_id', $nik)
                                            ->groupBy('notiket', 'en_id');
                                    }, 'hae')
                                    ->get();
        }
        $data['ctgrqs'] = CategoryReqs::where('deleted', 0)->get();
        $data['ttns'] = TypeTransport::where('deleted', 0)->get();
        $data['top'] = ReqsEn::where('id_dt_reqs', $id)->first();
        
        return view('Pages.Accomodation.request')->with($data)->with('id_dt', $id)->with('dsc', $dsc);
    }
    public function vw_request_reimburse(Request $request, $id)
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        $depart =  auth()->user()->depart;

        $typeReqs = $request->type_reqs;
        $enReqs = $request->en_reqs;
        if ($role == 20 || ($role == 19 && $depart == 6)) {
            if ($role == 19 && $depart == 6) {
                $data['data_reqs'] = VW_Reqs_En::where(function($query) {
                                            $query->where('type_reqs', '=', 2)
                                                ->where('status', 0);
                                        })
                                        ->orWhere(function($query) {
                                            $query->where('side_sts', '=', 2)
                                                ->where('status', '<', 3);
                                        })
                                        ->get();
            } else {
                $data['data_reqs'] = VW_Reqs_En::all();
            }
        } else {
            if ($depart == 15) {
                if (empty($enReqs) && empty($typeReqs)) {
                    $data['data_reqs'] = VW_Reqs_En::where(function($case1) {
                                            $case1->where('type_reqs', 2)
                                                ->where('status', '>=', 1)
                                                ->where('status', '<', 3);
                                        })
                                        ->orWhere(function($case2) {
                                            $case2->where('type_reqs', 1)
                                                ->where('status', 0);
                                        })
                                        ->get();
                } else {
                    if (!empty($enReqs) && empty($typeReqs)) {
                        $data['data_reqs'] = VW_Reqs_En::where(function($case1) {
                                                $case1->where(function($nestedCase1) {
                                                        $nestedCase1->where('type_reqs', 2)
                                                                    ->where('status', '>=', 1)
                                                                    ->where('status', '<', 3);
                                                    })
                                                    ->orWhere(function($nestedCase2) {
                                                        $nestedCase2->where('type_reqs', 1)
                                                                    ->where('status', 0);
                                                    });
                                            })
                                            ->where('en_id', $enReqs)
                                            ->get();
                    } else if (empty($enReqs) && !empty($typeReqs)) {
                        $data['data_reqs'] = VW_Reqs_En::where('type_reqs', $typeReqs)
                                ->when($typeReqs == 2, function ($est) {
                                    $est->where(function ($case1) {
                                        $case1->where('status', '>=', 1)
                                            ->where('status', '<', 3);
                                    });
                                })
                                ->when($typeReqs == 1, function ($reims) {
                                    $reims->where(function ($case2) {
                                        $case2->where('status', 0);
                                    });
                                })
                                ->get();
                    } else {
                        $data['data_reqs'] = VW_Reqs_En::where('type_reqs', $typeReqs)
                                            ->where('en_id', $enReqs)
                                            ->when($typeReqs == 2, function ($est) {
                                                $est->where(function ($case1) {
                                                    $case1->where('status', '>=', 1)
                                                        ->where('status', '<', 3);
                                                });
                                            })
                                            ->when($typeReqs == 1, function ($reims) {
                                                $reims->where(function ($case2) {
                                                    $case2->where('status', 0);
                                                });
                                            })
                                            ->get();
                    }
                }
                $data['cek_confirm'] = ReqsEnDT::select('id_dt_reqs')
                                    ->groupBy('id_dt_reqs')
                                    ->havingRaw('SUM(CASE WHEN `status` = 1 THEN 0 ELSE 1 END) = 0')
                                    ->get();
            } else {
                $data['data_reqs'] = VW_Reqs_En::where('en_id', $nik)->where('status', '<', 3)->get();
            }
        }
        $data['engineer'] = VW_Reqs_en::select('en_id', 'full_name')
                            ->groupBy('en_id')->get();
        return view('Pages.Accomodation.vw_reqs')->with($data)->with('enReqs', $enReqs)->with('typeReqs', $typeReqs);
    }
    public function get_reqs_excel(Request $request){
        $enReqs = $request->en_xcl;

        $rawQ = ReqsEn::leftJoin('hgt_reqs_en_dt as hred', 'hgt_reqs_en.id_dt_reqs', '=', 'hred.id_dt_reqs')
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
                    ic.name as kota,
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
                )->where('type_reqs', 1)
                ->where('hgt_reqs_en.status', 0)
                ->where('en_id', $enReqs);

        $dt_reqs = $rawQ->pluck('id_dt_reqs')->unique()->toArray();

        $getReqs = DB::table('hgt_reqs_en_dt as hred')
                            ->leftJoin('hgt_category_reqs as hcr', 'hred.ctgr_reqs', '=', 'hcr.id')
                            ->whereIn('id_dt_reqs', $dt_reqs)
                            ->groupBy('ctgr_reqs')
                            ->pluck('hcr.description', 'hred.ctgr_reqs');

        foreach ($getReqs as $id => $description) {
            $escapedDescription = str_replace(' ', '_', $description);
            $rawQ->selectRaw("max(CASE WHEN ctgr_reqs = $id THEN nominal ELSE 0 END) AS `$escapedDescription`");
        }

        $resultQ = $rawQ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Sheet 1');
        $hr1 = [
            'Tanggal',
            'Tujuan',
            'Project',
            'No Tiket',
            'Case ID',
            'Transport',
            'KM',
            'Liter',
            'Total Claim'
        ];
        $hr2 = [
            'Total'
        ];

        $hrReqs = [];
        foreach ($getReqs as $id => $description) {
            $hrReqs[] = $description;
        }

        $headers = array_merge($hr1, $hrReqs, $hr2);
        $getUser = User::select('full_name', 'depart')
                    ->where('nik', $enReqs)
                    ->first();
        $sheet->setCellValue('A1', 'FORM CLAIM OPERASIONAL');
        $sheet->mergeCells('A1:J1');

        $sheet->setCellValue('A3', 'Name');
        $sheet->setCellValue('B3', $getUser->full_name);
        $sheet->setCellValue('E3', 'Jabatan');
        $sheet->setCellValue('F3', @$getUser->dept->department);
        $sheet->setCellValue('A4', 'NIK');

        $sheet->fromArray([$headers], NULL, 'A5');
        $row = 6;
        $grand_total = 0;
        foreach ($resultQ as $item) {
            $total_reqs = 0;
            $rowspan_refs = $item->refsTicket->count();
            $rowspan = max($rowspan_refs, 1);
            
            $tln = $item->tln;
            $tla = $item->tla;
            $kembali = $tln - $tla;
            $refsQ = $item->refsTicket;

            for ($i = 0; $i < $rowspan; $i++) {
                for ($a = 3; $a < 22; $a++) {
                    $col = $a < 22 ? chr(65 + $a) : chr(65 + floor($a / 22) - 1) . chr(65 + ($a % 22));
                    $sheet->mergeCells("$col$row:$col" . ($row + $rowspan - 1));
                }
                $sheet->mergeCells("A$row:A" . ($row + $rowspan - 1));
                $sch = $refsQ->isEmpty() ? '' : ($refsQ->has($i) ? $refsQ[$i]->ti->schedule : '');
                $get_sch = Carbon::parse($sch)->format('Y-m-d');
                $data = [
                    $get_sch,
                    $refsQ->isEmpty() ? '' : ($refsQ->has($i) ? $refsQ[$i]->gpi->go_end_user->end_user_name : ''),
                    $refsQ->isEmpty() ? '' : ($refsQ->has($i) ? $refsQ[$i]->gpi->go_jekfo->project_name : ''),
                    $refsQ->isEmpty() ? '' : ($refsQ->has($i) ? $refsQ[$i]->notiket : ''),
                    $refsQ->isEmpty() ? '' : ($refsQ->has($i) ? $refsQ[$i]->ti->case_id : ''),
                    $item->type_trans,
                    "",
                    "",
                    'Rp ' . number_format($tln, 0, ',', '.')
                ];
                foreach ($getReqs as $id => $description) {
                    $escapedDescription = str_replace(' ', '_', $description);
                    $data[] = 'Rp ' . number_format($item->$escapedDescription, 0, ',', '.');
                    $total_reqs += $item->$escapedDescription;
                }

                $data[] = 'Rp ' . number_format($total_reqs, 0, ',', '.');
                $grand_total += $total_reqs;
                $sheet->fromArray([$data], NULL, "A$row");
                $row++;
            }
        }
        $gtCol = chr(73 + count($getReqs));
        $NlCol = chr(73 + count($getReqs) + 1);
        $mergeColGT = $gtCol.$row;
        $mergeColNl = $NlCol.$row;
        $colC = $row + 1;
        $colP = $row + 2;
        $sheet->setCellValue("$mergeColGT", "Grand Total");
        $sheet->setCellValue("$mergeColNl", 'Rp ' . number_format($grand_total, 0, ',', '.'));
        $sheet->setCellValue("A$colC", "Catatan");

        $points = [
            '1. Bahan bakar yang di claim adalah Pertalite',
            '2. Tanggal Claim wajib di isi',
            '3. Claim BBM wajib isi Kilometer kendaraan saat di isi BBM  dan jumlah liter BBM',
            '4. Tujuan dan No ticket wajib di isi',
            '5. BBM yang di claim adalah, BBM yang dikeluarkan dari kantor ke Customer',
            '6. Claim dilakukan di minggu ke I dan Minggu Ke III',
            '7. Claim BBM tanpa km kendaraan, no ticket dan tujuan tidak akan di proses',
        ];
        $sheet->mergeCells("E$colP:F$colP");
        $sheet->mergeCells("E" . ($colP + 4) . ":F" . ($colP + 4));
        $sheet->mergeCells("E" . ($colP + 5) . ":F" . ($colP + 5));
        
        $sheet->setCellValue("E$colP", 'Penyusun,');
        $sheet->setCellValue("E". ($colP + 4), $getUser->full_name);
        $sheet->setCellValue("E". ($colP + 5), @$getUser->dept->department);

        $sheet->mergeCells("G$colP:H$colP");
        $sheet->mergeCells("G" . ($colP + 4) . ":H" . ($colP + 4));

        $sheet->setCellValue("G$colP", 'Mengetahui,');
        $sheet->setCellValue("G". ($colP + 4), "(                                             )");

        $sheet->mergeCells("I$colP:J$colP");
        $sheet->mergeCells("I" . ($colP + 4) . ":J" . ($colP + 4));

        $sheet->setCellValue("I$colP", 'Menyetujui,');
        $sheet->setCellValue("I". ($colP + 4), "(                                             )");
        

        foreach ($points as $point) {
            $sheet->setCellValue("A$colP", $point);
            $colP++;
        }

        $filename = "Form Claim Operational.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename .'"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
    public function done_reqs()
    {
        $nik =  auth()->user()->nik;
        $role =  auth()->user()->role;
        $depart =  auth()->user()->depart;
        if ($depart == 6) {
            $data['query_done_reqs'] = VW_Reqs_En::where('en_id', $nik)->where('status', 3)->get();
        } else {
            $data['query_done_reqs'] = VW_Reqs_En::where('status', 3)->get();
        }
        
        return response()->json($data);
    }
    public function add_req_reimburse_en(Request $request, $dsc, $id)
    {
        $nik =  auth()->user()->nik;
        $now = Carbon::now();
        
        $fuckingsubquery = DB::table(function ($query) {
            $query->selectRaw('*')
                ->from(function ($innerSubquery) {
                    $innerSubquery->select('notiket', 
                                DB::raw('max(act_description) AS last_act'),
                                DB::raw('MAX(visitting) AS last_visit'))
                        ->from('hgt_activity_engineer')
                        ->groupBy('notiket', 'visitting')
                        ->orderBy('visitting', 'DESC');
                }, 'hl2')
            ->groupBy('notiket');
        });

        if ( in_array($dsc, ["Add", "Past"]) ) {
            $tahun = $now->format('y');
            $bulan = $now->format('m');
            $hari = $now->format('d');
            $hasil = (int)($tahun . $bulan . $hari);

            $get_id = ReqsEn::orderBy('id_dt_reqs','desc')->take(1)->get();
            if ($get_id->isEmpty()) {
                $int = 1;
                    $generate_dt_id = $hasil.$int;
            } else {
                $dt_id = $get_id[0]->id_dt_reqs;
                $num = substr($dt_id, 6);
                $int = (int)$num;
                $int++;
                $generate_dt_id = $hasil.$int;
            }
            $val = [
                'type_reqs'    => $request->type_reqs,
                'id_dt_reqs'    => $generate_dt_id,
                'en_id'         => $nik,
                'id_type_trans' => $request->val_type_trans
            ];
        } else {
            if ($dsc == "Re") {
                $val = [
                    'id_type_trans' => $request->val_type_trans,
                    'status' => null,
                    'reject' => null,
                    'created_at' => $now
                ];
            }
            $get_id = ReqsEn::where('id_dt_reqs', $id)->first();
        }
        if($get_id) {
            if (in_array($dsc, ["Add", "Past"])) {
                $storeReqs = ReqsEn::create($val);
                $id_dt_reqs = $generate_dt_id;
                if ($storeReqs) {
                    $val_id = ReqsEn::where('id_dt_reqs', $id_dt_reqs)->first();
                    $get_val_id = $request->input('val_id_tiket_reqs', []);
                    $url_id = $id == 'Null' ? [] : [$id];
                    $data_notik = array_merge($url_id, $get_val_id);
                    foreach ($data_notik as $tiket) {
                        $get_visit = $fuckingsubquery->where('notiket', $tiket)->first();
                        
                        if (empty($get_visit)) {
                            $visit = 1;
                        } elseif (!empty($get_visit)) {
                            $visit = $get_visit->last_visit == 0
                                ? (in_array($get_visit->last_act, array_merge(range(1, 7), [9]))
                                    ? 1 
                                    : 2) 
                                : ($get_visit->last_visit == 1 
                                    ? (in_array($get_visit->last_act, array_merge(range(1, 7), [9]))
                                        ? 2 
                                        : 3) 
                                    : ($get_visit->last_visit == 2 
                                        ? (in_array($get_visit->last_act, array_merge(range(1, 7), [9]))
                                            ? 3 
                                            : 4) 
                                        : (in_array($get_visit->last_act, array_merge(range(1, 7), [9]))
                                            ? 4 
                                            : 5)));
                        }

                        RefReqs::create([
                            'id_reqs' => $val_id->id,
                            'notiket' => $tiket,
                            'reqs_at' => $visit
                        ]);
                    }
                }
            }else{
                $id_dt_reqs = $get_id->id_dt_reqs;
                if ($dsc == "Re") {
                    $get_id->update($val);
                    $get_dt = ReqsEnDT::where('id_dt_reqs', $id_dt_reqs)->delete();
                }
            }
            foreach ($request->input('val_ctgr') as $index => $category) {
                $nominal = $request->input('nominal')[$index];

                $cleanedAmount = str_replace(['Rp', ',', '.'], '', $nominal);
                $amount = (int) $cleanedAmount;
                // Attach Request
                if (!empty($request->file('attach_file')[$index])) {
                    $files = $request->file('attach_file')[$index];
                    
                    $fileName = uniqid() . '.' . $files->getClientOriginalExtension();
                    $path = 'uploads/attach_request/'.$fileName;
                } else {
                    $fileName = null;
                    $path = null;
                }
                
                $execute = ReqsEnDT::create([
                    'id_dt_reqs' => $id_dt_reqs,
                    'ctgr_reqs' => $category,
                    'nominal' => $amount,
                    'filename' => $fileName,
                    'path' => $path
                ]);
                if (!empty($request->file('attach_file')[$index])) {
                    if ($execute) {
                        $files->move(base_path("../public_html/uploads/attach_request"), $fileName);
                    }
                }
            }
            
            $url = url("My-Expenses/id=$id_dt_reqs");
            $get_hp1 = User::select('phone')->where('id', 27)->first();
            $get_hp2 = User::select('phone')->where('id', 83)->first();
            $message = urlencode("There's New Request.\nClick link to open the page : ($url)");
            $phone1 = substr("$get_hp1->phone",1);
            $phone2 = substr("$get_hp2->phone",1);
            $link1 = "https://wa.me/+62{$phone1}?text={$message}";
            $link2 = "https://wa.me/+62{$phone2}?text={$message}";
            Alert::toast('Successfully Add Request!', 'success');
            session()->flash('wa_l1', $link1);
            session()->flash('wa_l2', $link2);
            return redirect('My-Expenses/id=null');
        }
        else {
            Alert::toast('Error When Saving Data!', 'error');
            return back();
        }
    }
    public function destroy_dt_en(Request $request, $id){
        $get_dt = ReqsEnDT::where('id', $id)->first();
        if($get_dt) {
            $pathFile = base_path("../public_html/$get_dt->path");

            if (file_exists($pathFile)) {
                unlink($pathFile);
            }
            $get_dt->delete();

            Alert::toast('Successfully Delete Data Detil!', 'success');
            return back();
        } else {
            Alert::toast('Error When Deleting!', 'error');
            return back();
        }
    }
    public function destroy_reqs(Request $request, $id){
        $get_id = ReqsEn::where('id', $id)->first();
        $refreqs = RefReqs::where('id_reqs', $id)->first();
        $get_dt = ReqsEnDT::where('id_dt_reqs', $get_id->id_dt_reqs);
        if($get_id && $get_dt) {
            $data_file = $get_dt->get();
            foreach ($data_file as $value) {
                if (!empty($value->path)) {
                    $pathFile = base_path("../public_html/$value->path");

                    if (file_exists($pathFile)) {
                        unlink($pathFile);
                    }
                }
                $value->delete();
            }
            $get_id->delete();
            $refreqs->delete();
            $get_dt->delete();

            Alert::toast('Successfully Delete the Request!', 'success');
            return back();
        } else {
            Alert::toast('Error When Deleting!', 'error');
            return back();
        }
    }
    public function previewReimburse($fk)
    {
        $data['attachEN'] = AttReimburseEn::where('fk_id', $fk)->get();
        return view('Pages.Ticket.Reimburse.preview-reimburse')->with($data);
    }
    public function confirm_reqs(Request $request, $id){
        $role =  auth()->user()->role;
        $depart =  auth()->user()->depart;
        $value = [
            'status'    => 1
        ];
        $query = ReqsEn::where('id', $id)->first();
        if ($query) {
            $query->update($value);

            $url = url("My-Expenses/id=$query->id_dt_reqs");
            $getU1 = User::select('phone')->where('id', 177)->first();
            $getU2 = User::select('phone')->where('id', 179)->first();
            $message = urlencode("There's New Request.\nClick link to open the page : ($url)");

            $phone1 = substr("$getU1->phone",1);
            $phone2 = substr("$getU2->phone",1);

            $link1 = "https://wa.me/+62{$phone1}?text={$message}";
            $link2 = "https://wa.me/+62{$phone2}?text={$message}";
            

            Alert::toast('Successfully Updated Data', 'success');
            session()->flash('confirm1', $link1);
            session()->flash('confirm2', $link2);
            return redirect()->back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function reject_reqs(Request $request, $dsc, $id){
        $sts = $dsc == "Acc" ? 1 : 2;
        $value = [
            'reject'    => $sts
        ];
        $query = ReqsEn::where('id', $id)->first();
        if ($query) {
            $query->update($value);
            Alert::toast('Successfully Return it Back', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function check_detail_reqs_en(Request $request){
        $data = $request->all();
        $confirmedData = $data['confirmed'] ?? [];
        $nominalData = $data['nominal'] ?? [];
        
        $commonIds = array_unique(array_merge(array_keys($confirmedData), array_keys($nominalData)));

        if (!empty($commonIds)) {
            foreach ($commonIds as $id) {
                $reqsEnDT = ReqsEnDT::find($id);

                if ($reqsEnDT) {
                    if (isset($confirmedData[$id][0])) {
                        $status = $confirmedData[$id][0];
                        $reqsEnDT->update(['status' => $status]);
                    }

                    if (isset($nominalData[$id][0])) {
                        $nominal = $nominalData[$id][0];

                        if ($nominal != $reqsEnDT->nominal) {
                            $cleanedAmount = str_replace(['Rp', ',', '.'], '', $nominal);
                            $amount = (int) $cleanedAmount;
                            $reqsEnDT->update(['nominal' => $amount]);
                        }
                    }
                }
            }

            Alert::toast("Successfully Updated Data", 'success');
            return back();
        } else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function attach_detail_reqs_en(Request $request){
        $data = $request->all();
        if (isset($data['attachDT_file']) && $data['actual'] !== null) {
            foreach ($data['attachDT_file'] as $id => $val) {
                $reqsEnDT = ReqsEnDT::find($id);

                // Attach Request
                $fileName = uniqid() . '.' . $val[0]->getClientOriginalExtension();
                $path = 'uploads/attach_request/'.$fileName;
                
                if ($data['actual'][$id][0] == $reqsEnDT->actual) {
                    $val_actual = $reqsEnDT->actual;
                } else {
                    $val_actual = $data['actual'][$id][0];
                }
                
                $cleanedAmount = str_replace(['Rp', ',', '.'], '', $val_actual);
                $amount = (int) $cleanedAmount;

                if ($reqsEnDT) {
                   $execute = $reqsEnDT->update([
                        'filename' => $fileName, 
                        'path' => $path, 
                        'actual' => $amount
                    ]);
                    if ($execute) {
                        $val[0]->move(base_path("../public_html/uploads/attach_request"), $fileName);
                    }
                }
            }
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('One of Row fields must be filled', 'error');
            return back();
        }
    }
    public function store_expenses(Request $request, $id)
    {
        $total = $request->input('total_xps');
        
        $cleanedAmount = str_replace(['Rp', ',', '.'], '', $total);
        $amount = (int) $cleanedAmount;
        $values = [
            'description' => $request->desc_xps,
            'category' => $request->category_xps,
            'expenses_date' => $request->date_xps,
            'total' => $amount,
            'paid_by' => $request->paid_by_xps,
            'note' => $request->note_xps,
            'status' => 1
        ];
        
        if($values) {
            $store_expenses = Expenses::create($values);
            if ($store_expenses) {
                $get_id_expenses = Expenses::orderBy('id_expenses','desc')->take(1)->first();
                $get_Reqs = ReqsEn::where('id_dt_reqs', $id)->first();
                $get_Reqs->update(['id_expenses' => $get_id_expenses->id_expenses]);
                $query_dt = ReqsEnDT::where('id_dt_reqs', $id)->get();
                foreach ($query_dt as $dt) {
                    $convert = str_replace(['Rp', ',', '.'], '', $dt->nominal);
                    $actual = (int) $convert;
                    ReqsEnDT::where('id', $dt->id)->update(['actual' => $actual]);
                }
                Alert::toast("Success on Saving Data", 'success');
            }else{
                Alert::toast('Reqs En not updated!', 'warning');
            }
            return redirect('My-Expenses/id=null');
        }
        else {
            Alert::toast('Failed saving', 'error');
            return back();
        }
    }
    public function execute_reqs(Request $request, $id){
        $query = ReqsEn::where('id', $id)->first();
        if ($query->type_reqs == 1) {
            $value = [
                'status'    => 3
            ];
        } else {
            $value = [
                'status'    => 2
            ];
        }
        
        if ($query) {
            $query->update($value);
            Alert::toast('Successfully Updated Data', 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function finish_reqs(Request $request, $id){
        $get_data = VW_Reqs_En::where('id', $id)->first();
        if ($get_data->tln == $get_data->tla) {
        } else if ($get_data->tln >= $get_data->tla) {
            $value = [
                'status'    => 3,
                'additional'    => 1
            ];
        } else if ($get_data->tln <= $get_data->tla) {
            $value = [
                'status'    => 3,
                'additional'    => 2
            ];
        } else {
            $value = [
                'status'    => 3
            ];
        }
        if ($get_data) {
            $query = ReqsEn::where('id', $id)->first();
            $query->update($value);
            Alert::toast("The Request had been Done!", 'success');
            return back();
        }else {
            Alert::toast('Failed Updating', 'error');
            return back();
        }
    }
    public function inv_ex($id, $sub){
        $data['reqs'] = VW_Reqs_En::where('id', $id)->first();
        $data['date'] = Carbon::parse($data['reqs']->reqs_at)->format('Ymd');
        $data['getDT'] = ReqsEnDT::where('id_dt_reqs', $sub)->get();
        $data['getRef'] = ReqsEn::where('id', $id)->first();
        return view('Pages.Accomodation.Inv.vw_inv')->with($data);
    }
    public function add_note_le(Request $request, $id){
        $val_note = $request->note_less;

        $value = [
            'note'    => $val_note
        ];
        
        $getReqs = ReqsEn::where('id', $id)->first();

        if($getReqs) {
            $getReqs->update($value);
            Alert::toast("Success on Saving Data", 'success');
            return back();
        }
        else {
            Alert::toast('Failed saving', 'error');
            return back();
        }
    }

    public function downloadReceiptment($id)
    {
        $receiptAttach = ReqsEnDT::find($id);

        $path = base_path("../public_html/$receiptAttach->path");

        return response()->download($path);
    }
}
