<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ShowClassSchedule extends Controller
{
    public function showClassSchedule()
    {
        // Optional: Get the current date
        $currentDate = Carbon::now();

        // Fetch all schedules with student and course relationships
        $schedules = Schedule::with(['student', 'course']) // Eager load student and course
            // You can choose to remove the date filter if you want all schedules
            // Commenting out the whereBetween clause to fetch all schedules
            // ->whereBetween('scheduled_date', [
            //     $monday->format('Y-m-d'),
            //     $monday->copy()->endOfWeek()->format('Y-m-d')
            // ])
            ->get();

        return view('admin.class_scheduling', compact('schedules', 'currentDate'));
    }
}
