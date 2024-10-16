<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\ScheduleAdjustmentRequest;

class StudentRequestAdjustmentController extends Controller
{
    public function showAdjustmentPage(Request $request)
    {
        // Initialize variables
        $schedule = null;
        $scheduledDate = null;
        $scheduleFinish = null;
        $status = null;
        $hoursPerSession = null; // Variable to hold hours per session

        // Check if a schedule ID is provided in the request
        if ($request->has('schedule_id')) {
            // Retrieve schedule data from the request
            $scheduleId = $request->input('schedule_id');

            // Retrieve full schedule from the database
            $schedule = Schedule::with('course')->find($scheduleId); // Eager load course

            // Set data to be passed to the view
            $scheduledDate = $schedule->scheduled_date ?? null;
            $scheduleFinish = $schedule->schedule_finish ?? null;
            $status = $schedule->status ?? null;

            // Get hours per session from the related course
            $hoursPerSession = $schedule->course->hours_per_session ?? null; // Accessing hours_per_session
        }

        // Get the current logged-in admin's branch_id
        $adminBranchId = auth()->user()->branch_id;

        // Fetch schedules that belong to the same branch as the logged-in admin
        $schedules = Schedule::with(['student', 'course']) // Eager load student and course
            ->where('branch_id', $adminBranchId)
            ->where('status', '!=', 'done') // Exclude schedules with 'done' status
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


        // Return the view with the filtered schedules, time slots, days of the week, and schedule data
        return view('portal.request_adjustment', compact('schedules', 'timeSlots', 'daysOfWeek', 'scheduleId', 'scheduledDate', 'scheduleFinish', 'status', 'schedule', 'hoursPerSession'));
    }

    public function submitAdjustment(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'new_schedule' => 'required|date',
            'new_schedule_finish' => 'required|date|after:new_schedule',
        ]);

        // Create a new adjustment request
        ScheduleAdjustmentRequest::create([
            'schedule_id' => $request->input('schedule_id'),
            'new_scheduled_date' => $request->input('new_schedule'),
            'new_schedule_finish' => $request->input('new_schedule_finish'),
            'status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Adjustment request submitted successfully.');
    }

}
