<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected function createScheduleEntries(Student $student, $courseId)
    {
        // Fetch the course details
        $course = \App\Models\Course::findOrFail($courseId);

        // Get the number of sessions and hours per session
        $numberOfSessions = $course->number_of_sessions; // Adjust this field based on your database
        $hoursPerSession = $course->hours_per_session; // Adjust this field based on your database

        // Calculate the start date for scheduling (tomorrow)
        $startDate = now()->addDay()->startOfDay(); // Tomorrow's date

        // Define the days for TDC
        $tdcDays = ['Tuesday', 'Saturday']; // Define allowed days for TDC

        // Initialize counter for created schedules
        $createdSchedules = 0;

        // Loop to create schedule entries
        while ($createdSchedules < $numberOfSessions) {
            // Schedule for each day until the required number of sessions is reached
            for ($i = 0; $i < 7; $i++) {
                $scheduledDate = $startDate->copy()->addDays($i);

                // Check if the course is TDC and if the day is valid
                if ($courseId == 1 && !in_array($scheduledDate->format('l'), $tdcDays)) {
                    continue; // Skip if not a valid TDC day
                }

                // Skip if the day is not valid for the course or if the number of sessions is met
                if ($createdSchedules >= $numberOfSessions) {
                    break;
                }

                // Create a new schedule entry
                \App\Models\Schedule::create([
                    'student_id' => $student->id,
                    'branch_id' => $student->branch_id,
                    'course_id' => $courseId,
                    'scheduled_date' => $scheduledDate,
                    'schedule_finish' => $scheduledDate->copy()->addHours($hoursPerSession),
                    'status' => 'scheduled', // Set the initial status
                ]);

                $createdSchedules++;
            }
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'scheduled_date' => 'required|date',
            'schedule_finish' => 'required|date',
        ]);

        // Find the schedule
        $schedule = Schedule::findOrFail($id);

        // Update the schedule fields
        $schedule->scheduled_date = $request->input('scheduled_date');
        $schedule->schedule_finish = $request->input('schedule_finish');
        $schedule->status = 'pending'; // Or whatever logic you need for status

        // Save the changes
        $schedule->save();

        return response()->json(['success' => true]);
    }

    public function updateScheduleStatus(Request $request, $scheduleId)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|in:pending,done,missed',
        ]);

        // Find the schedule by ID and update the status
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->status = $request->status;
        $schedule->save();

        return response()->json(['message' => 'Schedule status updated successfully.']);
    }

}
