<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Auth;
use App\Models\Student; // Import Student model
use App\Models\Enrollment; // Import Enrollment model

class ApproveEnrollmentController extends Controller
{
    public function confirmPayment($id)
{
    // Find the pending enrollment
    $enrollment = Enrollment::where('id', $id)->first();

    if (!$enrollment) {
        return response()->json(['message' => 'Enrollment not found'], 404);
    }

    // Move to the students table
    $student = Student::create([
        'id' => $enrollment->id, // Ensure this line is present and populated correctly
        'first_name' => $enrollment->first_name,
        'last_name' => $enrollment->last_name,
        'dob' => $enrollment->dob,
        'address' => $enrollment->address,
        'phone_number' => $enrollment->phone_number,
        'email' => $enrollment->email,
        'branch_id' => $enrollment->branch_id,
        'is_email_verified' => $enrollment->is_email_verified, // Ensure this logic fits your needs
    ]);

    // Insert into student_courses table
    $studentCourse = StudentCourse::create([
            'student_id' => $student->id,
            'course_id' => $enrollment->course_id,
            'is_package' => false,
            'has_permit' => true,
            'is_approved' => true, // Assuming this is managed here instead of in `students` table
            'status' => 'ongoing',
    ]);

    // Create transaction for the student
    $this->createTransaction($student, $enrollment->course_id);

    // Create schedules for the student
    $this->createSchedules($student, $enrollment->course_id);

    // Remove the enrollment
    $enrollment->delete();

    return response()->json(['message' => 'Payment confirmed, student added successfully, schedules created, and transaction recorded']);
}

    // Function to create schedules
    private function createSchedules(Student $student, $courseId)
    {
        $course = Course::find($courseId);

        if (!$student || !Student::find($student->id)) {
            \Log::error("Student not found with ID: {$student->id}");
            return;
        }

        if (!$course) {
            \Log::error("Course not found with ID: {$courseId}");
            return;
        }

        $numberOfSessions = $course->number_of_sessions;
        $hoursPerSession = $course->hours_per_session;
        $startDate = Carbon::now()->addDay()->startOfDay(); // Start from tomorrow
        $createdSchedules = 0;

        // Define a function to find the next TDC schedule based on the current date
        $nextAvailableTDCDate = function ($date) {
            // Calculate next TDC dates based on the day of the week
            switch ($date->dayOfWeek) {
                case Carbon::TUESDAY:
                case Carbon::WEDNESDAY:
                    return $date->next(Carbon::SATURDAY); // If today is Tuesday or Wednesday, schedule on Saturday
                case Carbon::SATURDAY:
                case Carbon::SUNDAY:
                    return $date->next(Carbon::TUESDAY); // If today is Saturday or Sunday, schedule on Tuesday
                case Carbon::MONDAY:
                    return $date->next(Carbon::TUESDAY); // If today is Monday, schedule on Tuesday
                case Carbon::THURSDAY:
                case Carbon::FRIDAY:
                    return $date->next(Carbon::SATURDAY); // If today is Thursday or Friday, schedule on Saturday
            }
        };

        while ($createdSchedules < $numberOfSessions) {
            $currentDate = $startDate->copy();

            // Check if a schedule already exists for the student on this day
            $existingSchedule = Schedule::where('student_id', $student->id)
                ->whereDate('scheduled_date', $currentDate->format('Y-m-d'))
                ->exists();

            if (!$existingSchedule) {
                // Check for TDC-specific scheduling (assuming courseId == 1 is TDC)
                if ($courseId == 1) {
                    // Move to the next valid TDC start date
                    $currentDate = $nextAvailableTDCDate($startDate->copy());

                    // Create two TDC sessions starting from the calculated current date
                    $this->createTDCSchedules($student, $courseId, $currentDate, $hoursPerSession);
                    $createdSchedules += 2; // Two sessions created for TDC

                    // Move startDate to the next valid day after both sessions (next Tuesday)
                    $startDate = $currentDate->next(Carbon::TUESDAY)->next(Carbon::SATURDAY);
                } else {
                    // For non-TDC courses, limit to one session per day with a set start time (e.g., 8 AM)
                    if ($this->scheduleWithLimit($student, $courseId, $currentDate->setTime(8, 0), $hoursPerSession)) {
                        $createdSchedules++;
                    }
                }
            }

            $startDate->addDay(); // Move to the next day
        }

        \Log::info("Created {$createdSchedules} schedules for student ID: {$student->id}");
    }


    private function createTDCSchedules(Student $student, $courseId, $startDate, $hoursPerSession)
    {
        // Set the first session start time to 8:00 AM on the correct date
        $firstSessionTime = $startDate->copy()->setTime(8, 0);
        $firstSessionFinish = $firstSessionTime->copy()->addHours($hoursPerSession);

        // Set the second session time to the day after the first session
        $secondSessionTime = $firstSessionTime->copy()->addDay()->setTime(8, 0); // Move to the next day at 8 AM
        $secondSessionFinish = $secondSessionTime->copy()->addHours($hoursPerSession);

        // Create the first TDC session with the correct `schedule_finish` time
        Schedule::create([
            'student_id' => $student->id,
            'branch_id' => $student->branch_id,
            'course_id' => $courseId,
            'scheduled_date' => $firstSessionTime,
            'schedule_finish' => $firstSessionFinish,
            'status' => 'pending',
        ]);

        // Create the second TDC session on the next day with the correct `schedule_finish` time
        Schedule::create([
            'student_id' => $student->id,
            'branch_id' => $student->branch_id,
            'course_id' => $courseId,
            'scheduled_date' => $secondSessionTime,
            'schedule_finish' => $secondSessionFinish,
            'status' => 'pending',
        ]);

        \Log::info("Created TDC schedules for student ID: {$student->id} on {$firstSessionTime->format('Y-m-d')} and {$secondSessionTime->format('Y-m-d')}");
    }



    // Helper function to create a session with limit checking for non-TDC courses
    private function scheduleWithLimit(Student $student, $courseId, $date, $hoursPerSession)
{
    $startTimes = [
        8 => '08:00:00',
        9 => '09:00:00',
        10 => '10:00:00',
        11 => '11:00:00',
        13 => '13:00:00',
        14 => '14:00:00',
        15 => '15:00:00',
        16 => '16:00:00',
        17 => '17:00:00'
    ];

    foreach ($startTimes as $hour => $time) {
        $scheduledDate = $date->setTime($hour, 0);
        $scheduleFinish = $scheduledDate->copy()->addHours($hoursPerSession);

        // Check if the student already has a schedule for this day
        $existingStudentSchedule = Schedule::where('student_id', $student->id)
            ->whereDate('scheduled_date', $scheduledDate->format('Y-m-d'))
            ->exists();

        if ($existingStudentSchedule) {
            return false; // A schedule already exists for this day for the student
        }

        $existingCount = Schedule::where('branch_id', $student->branch_id)
            ->where('course_id', $courseId)
            ->where('scheduled_date', '<=', $scheduleFinish)
            ->where('schedule_finish', '>', $scheduledDate)
            ->count();

        if ($existingCount < 2) {
            Schedule::create([
                'student_id' => $student->id,
                'branch_id' => $student->branch_id,
                'course_id' => $courseId,
                'scheduled_date' => $scheduledDate,
                'schedule_finish' => $scheduleFinish,
                'status' => 'pending',
            ]);
            return true;
        }
    }
    return false;
}

    // New function to create a transaction entry
    private function createTransaction(Student $student, $courseId)
    {
        // Get the course to retrieve the price
        $course = Course::find($courseId);

        // Ensure the course exists
        if (!$course) {
            \Log::error("Course not found with ID: {$courseId}");
            return;
        }

        // Create the transaction entry
        Transaction::create([
            'student_id' => $student->id,
            'branch_id' => $student->branch_id,
            'course_id' => $courseId,
            'price' => $course->price, // Assuming the Course model has a price field
            'staff_id' => Auth::user()->id, // Use the authenticated user's ID as staff_id
            'status' => 'paid', // Set status to 'paid'
        ]);

        \Log::info("Transaction created for student ID: {$student->id}, Course ID: {$courseId}");
    }


}
