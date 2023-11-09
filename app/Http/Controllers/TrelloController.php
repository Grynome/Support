<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticketing;
use Carbon\Carbon;

class TrelloController extends Controller
{
    public function trelloEn()
    {
        $yesterday = Carbon::now()->addHours(7)->subDay();
            $year3 = $yesterday->year;
            $month3 = $yesterday->month;
            $day3 = $yesterday->day;
        // Retrieve Tomorrow
        $tomorrow = Carbon::now()->addDay();
            $year1 = $tomorrow->year;
            $month1 = $tomorrow->month;
            $day1 = $tomorrow->day;
        // Retrieve The day after tomorrow
        $dayAfterTomorrow = Carbon::now()->addDays(2);
            $year2 = $dayAfterTomorrow->year;
            $month2 = $dayAfterTomorrow->month;
            $day2 = $dayAfterTomorrow->day;
        $data['tomorow'] = Ticketing::whereRaw("YEAR(departure) = $year1")
                                        ->whereRaw("MONTH(departure) = $month1")
                                        ->whereRaw("DAY(departure) = $day1")->get();
        $data['lusa'] = Ticketing::whereRaw("YEAR(departure) = $year2")
                                        ->whereRaw("MONTH(departure) = $month2")
                                        ->whereRaw("DAY(departure) = $day2")->get();
        $data['kamari'] = Ticketing::whereRaw("YEAR(departure) = $year3")
                                    ->whereRaw("MONTH(departure) = $month3")
                                    ->whereRaw("DAY(departure) = $day3")
                                    ->where("status", '<' ,10)->get();
        
        return view('Pages.Trello.engineer')->with($data);
    }
}
