<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function srch()
    {
        return view('Pages.Issue.search');
    }
    public function dirSearchIssue(Request $request)
    {
        $url = "Data/Detil-Report/" . $request->valNotiket;
        return redirect()->to($url);
    }
}
