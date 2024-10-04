<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ShowClassSchedule extends Controller
{
    public function showClassSchedule()
    {
        // Get the current logged-in admin's branch_id
        $adminBranchId = auth()->user()->branch_id;

        // Fetch schedules that belong to the same branch as the logged-in admin
        $schedules = Schedule::with(['student', 'course']) // Eager load student and course
            ->where('branch_id', $adminBranchId)
            ->get();

        // Define the time slots (adjust as necessary)
        $timeSlots = [
            '8:00 AM', '9:00 AM', '10:00 AM',
            '11:00 AM', '12:00 PM', '1:00 PM',
            '2:00 PM', '3:00 PM', '4:00 PM'
        ];

        // Create a structure for the days of the week
        $daysOfWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $daysOfWeek[] = [
                'name' => $date->format('l'), // Day name (e.g., Monday)
                'date' => $date->format('Y-m-d') // Date (e.g., 2024-10-02)
            ];
        }

        // Return the view with the filtered schedules, time slots, and days of the week
        return view('admin.class_scheduling', compact('schedules', 'timeSlots', 'daysOfWeek'));
    }

}
