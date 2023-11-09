<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PKnowledgeController extends Controller
{
    public function pknowledge()
    {
        return view('Pages.ProblemKnowledge.index');
    }
}
