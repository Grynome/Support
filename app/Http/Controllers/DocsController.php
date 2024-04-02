<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Ticketing;

class DocsController extends Controller
{
    public function vw_upload_docs(){
        $now = Carbon::now()->endOfDay();
        $oneMonthAgo = $now->copy()->startOfDay()->subMonth(1);
        $data['docs'] = Ticketing::where('status', 10)->where('status_docs', 0)->whereBetween('closedate', [$oneMonthAgo, $now])->get();

        return view('Pages.Admin.inquiry')->with($data);
    }
    
    public function update_receive_docs($id)
    {
        $nik =  auth()->user()->nik;
        $dateTime = date("Y-m-d H:i:s");
        $value = [
            'status_docs'    => 1
        ];

        $query_docs_sts_ticket = Ticket::where('notiket', $id)->first();
        $result = $query_docs_sts_ticket->update($value);

        if($result) {
            $logging = [
                'notiket'    => $id,
                'action'    => 'Document Received',
                'id_admin'     => $nik,
                'created_at'     => $dateTime
            ];
            LogAdmin::insert($logging);
            Alert::toast('Documents its Received!', 'success');
            return redirect('helpdesk/manage=Ticket');
        }
        else {
            Alert::toast('Error when updating!', 'error');
            return back();
        }
    }
}
