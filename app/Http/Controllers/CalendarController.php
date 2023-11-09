<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        return view('Pages.Calendar.index');
    }
    public function getData()
    {
        $events = Event::all();

        return response()->json($events);
    }
}
