<?php

namespace App\Helpers;

use Carbon\Carbon;

class WeekHelper
{
    public static function getWeekNumber($date)
    {
        $carbonDate = Carbon::parse($date);

        $currentWeekNumber = $carbonDate->weekOfYear;

        $firstDayOfMonth = $carbonDate->copy()->startOfMonth();
        $firstDayOfMonthWeekNumber = $firstDayOfMonth->weekOfYear;

        $weekNumber = $currentWeekNumber - $firstDayOfMonthWeekNumber + 1;

        return $weekNumber;
    }
}
