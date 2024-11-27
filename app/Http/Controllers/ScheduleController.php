<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\StudentCourse;

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

    public function update(Request $request, $id)
{
    $request->validate([
        'scheduled_date' => 'required|date',
        'schedule_finish' => 'required|date',
    ]);

    // Retrieve the schedule being updated
    $schedule = Schedule::findOrFail($id);

    // Extract necessary fields for checking conflicts
    $newStartDate = $request->input('scheduled_date');
    $newFinishDate = $request->input('schedule_finish');
    $courseId = $schedule->course_id;
    $branchId = $schedule->branch_id;
    $studentId = $schedule->student_id;

    // Log the new schedule time for debugging
    \Log::info("Attempting to schedule: Start - {$newStartDate}, Finish - {$newFinishDate}");

    // Check if the student already has a schedule with the exact same start and finish time
    $conflictingSchedule = Schedule::where('student_id', $studentId)
    ->where('id', '!=', $id) // Exclude the current schedule being updated
    ->where(function ($query) use ($newStartDate, $newFinishDate) {
        $query->where(function ($subQuery) use ($newStartDate, $newFinishDate) {
            // Overlaps if the new start time is within an existing schedule
            $subQuery->where('scheduled_date', '<=', $newStartDate)
                ->where('schedule_finish', '>', $newStartDate);
        })->orWhere(function ($subQuery) use ($newStartDate, $newFinishDate) {
            // Overlaps if the new finish time is within an existing schedule
            $subQuery->where('scheduled_date', '<', $newFinishDate)
                ->where('schedule_finish', '>=', $newFinishDate);
        })->orWhere(function ($subQuery) use ($newStartDate, $newFinishDate) {
            // Fully overlaps an existing schedule
            $subQuery->where('scheduled_date', '>=', $newStartDate)
                ->where('schedule_finish', '<=', $newFinishDate);
        });
    })
    ->exists();

    // If a conflict is found, return an error message
    if ($conflictingSchedule) {
    return response()->json([
        'success' => false,
        'message' => 'This schedule time conflicts with an existing schedule for the same student.'
    ]);
    }

    // Check if the course is "TDC" (course_id = 1)
    if ($courseId != 1) {
        // Check if the same time slot has 2 or more pending schedules with the same course and branch
        $conflictingSchedules = Schedule::where('branch_id', $branchId)
            ->where('course_id', $courseId)
            ->where('status', 'pending') // Only check pending schedules
            ->where(function ($query) use ($newStartDate, $newFinishDate) {
                // Check if the new start or finish time overlaps with existing schedules
                $query->where(function ($q) use ($newStartDate, $newFinishDate) {
                    $q->where('scheduled_date', '<=', $newStartDate)
                      ->where('schedule_finish', '>=', $newStartDate);  // Overlapping start time
                })
                ->orWhere(function ($q) use ($newStartDate, $newFinishDate) {
                    $q->where('scheduled_date', '<=', $newFinishDate)
                      ->where('schedule_finish', '>=', $newFinishDate);  // Overlapping finish time
                })
                ->orWhere(function ($q) use ($newStartDate, $newFinishDate) {
                    $q->where('scheduled_date', '>=', $newStartDate)
                      ->where('schedule_finish', '<=', $newFinishDate);  // Full overlap of the time range
                });
            })
            ->count();

        // If the number of conflicting schedules is 2 or more, return an error
        if ($conflictingSchedules >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'This schedule time slot is already fully booked for this course and branch. Only 2 students can have the same schedule per slot.'
            ]);
        }
    }

    // Update the schedule fields if no conflict
    $schedule->scheduled_date = $newStartDate;
    $schedule->schedule_finish = $newFinishDate;
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

        // Check if the status is set to 'done'
        if ($request->status === 'done') {
            // Get the student ID and course ID from the schedule
            $studentId = $schedule->student_id;
            $courseId = $schedule->course_id;

            // Check if all schedules for the student and course are marked as 'done'
            $allDone = Schedule::where('student_id', $studentId)
                ->where('course_id', $courseId)
                ->where('status', '!=', 'done')
                ->count() === 0;

            // If all schedules are done, update the student_courses status
            if ($allDone) {
                // Update the corresponding entry in the student_courses table
                $studentCourse = StudentCourse::where('student_id', $studentId)
                    ->where('course_id', $courseId)
                    ->first();

                if ($studentCourse) {
                    $studentCourse->status = 'done';
                    $studentCourse->save();
                }
            }
        }

        return response()->json(['message' => 'Schedule status updated successfully.']);
    }

}
