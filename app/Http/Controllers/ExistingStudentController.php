<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Package;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnrollmentConfirmation;

class ExistingStudentController extends Controller
{
    public function existingStudents()
    {
        // Fetch not approved student courses
        $notApprovedCourses = StudentCourse::with('student', 'course') // Assuming you have relationships defined
            ->where('is_approved', 0)
            ->get();

        // Return the view with the fetched data
        return view('admin.existing_students', compact('notApprovedCourses'));
    }

    public function approveEnrollment(Request $request, $enrollmentId)
    {
        // Validate the amount paid
        $request->validate([
            'amount_paid' => 'required|numeric|min:0'
        ]);

        // Find the enrollment using the StudentCourse model
        $enrollment = StudentCourse::findOrFail($enrollmentId);

        // Update the 'is_approved' field
        $enrollment->is_approved = true; // Set to true to approve
        $enrollment->save();

        // Get the student's course details
        $course = Course::find($enrollment->course_id);
        $price = $course->price; // Get the course price

        // Calculate the balance after payment
        $newBalance = $price - $request->amount_paid;

        // Create schedules and transaction entries for the student
        $student = Student::find($enrollment->student_id);
        $this->createSchedules($student, $enrollment->course_id);
        // Only create a transaction if the course is not part of a package
        if ($enrollment->is_package == 0) {
            $this->createTransaction($student, $enrollment->course_id, $enrollment->package_id, $request->amount_paid, $newBalance);
        }

        return response()->json(['message' => 'Enrollment approved successfully, schedules and transaction created.']);
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
        $startDate = Carbon::tomorrow()->startOfDay(); // Start from tomorrow
        $createdSchedules = 0;

        // Keep scheduling one session per day until all sessions are created
        while ($createdSchedules < $numberOfSessions) {
            // Check if a schedule can be made on the current day
            if ($this->scheduleWithLimit($student, $courseId, $startDate->copy(), $hoursPerSession)) {
                $createdSchedules++;
            }

            // Move to the next day after each schedule
            $startDate->addDay();
        }

        \Log::info("Created {$createdSchedules} schedules for student ID: {$student->id}");
    }

    // Function to create TDC schedules
    private function createTDCSchedules(Student $student, $courseId, $startDate, $hoursPerSession)
    {
        // Set the first session start time to 8:00 AM on the correct date
        $firstSessionTime = $startDate->copy()->setTime(8, 0);
        $firstSessionFinish = $firstSessionTime->copy()->addHours($hoursPerSession);

        // Determine the second session day based on whether the first is on Saturday or Tuesday
        $secondSessionTime = ($firstSessionTime->dayOfWeek == Carbon::SATURDAY)
            ? $firstSessionTime->copy()->addDay()  // Schedule the second session on Sunday if starting on Saturday
            : $firstSessionTime->copy()->addDay(); // Schedule the second session on Wednesday if starting on Tuesday

        $secondSessionFinish = $secondSessionTime->copy()->addHours($hoursPerSession);

        // Create the first TDC session with the correct schedule_finish time
        Schedule::create([
            'student_id' => $student->id,
            'branch_id' => $student->branch_id,
            'course_id' => $courseId,
            'scheduled_date' => $firstSessionTime,
            'schedule_finish' => $firstSessionFinish,
            'status' => 'pending',
        ]);

        // Create the second TDC session on the next valid day with the correct schedule_finish time
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

    // Function to schedule non-TDC courses with time slot limits
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
    ];

    $maxStudentsPerSlot = 2; // Set the limit of students per time slot

    foreach ($startTimes as $hour => $time) {
        // Check if there are existing schedules for this course, branch, and time slot
        $existingSchedules = Schedule::where('course_id', $courseId)
            ->where('branch_id', $student->branch_id)
            ->whereDate('scheduled_date', $date->format('Y-m-d'))
            ->whereTime('scheduled_date', $time)
            ->get();

        // Count how many students are scheduled for this slot with a status other than 'done'
        $studentCount = $existingSchedules->where('status', '!=', 'done')->count();

        // If there is space or a 'done' status, schedule the student
        if ($studentCount < $maxStudentsPerSlot || $existingSchedules->where('status', 'done')->count() > 0) {
            Schedule::create([
                'student_id' => $student->id,
                'branch_id' => $student->branch_id,
                'course_id' => $courseId,
                'scheduled_date' => $date->setTime($hour, 0),
                'schedule_finish' => $date->copy()->addHours($hoursPerSession), // Ensure finish time is set correctly
                'status' => 'pending',
            ]);

            return true; // Successfully scheduled
        }
    }

    return false; // No available slots found
}

    // Function to create a transaction entry
    private function createTransaction(Student $student, $courseId, $packageId = null, $amountPaid, $newBalance)
    {
        // If there's a package, use the package price; otherwise, use the course price
        $price = $packageId ? Package::find($packageId)->price : Course::find($courseId)->price;

        // Create the transaction entry
        $transaction = Transaction::create([
            'student_id' => $student->id,
            'course_id' => $courseId,
            'package_id' => $packageId,
            'price' => $price,
            'balance' => $newBalance, // Store the calculated balance
            'transaction_date' => Carbon::now(),
            'staff_id' => Auth::user()->id, // Assuming the current admin user is authenticated
            'branch_id' => Auth::user()->branch_id,
            'payment_method' => 'walk_in',
        ]);

        \Log::info("Transaction created for student ID: {$student->id}, course ID: {$courseId}, package ID: {$packageId}, amount paid: {$amountPaid}, balance: {$newBalance}");
        Mail::to($student->email)->send(new EnrollmentConfirmation($student, $courseId, $packageId, $newBalance, 'walk_in'));
    }


// In your EnrollmentController.php
public function destroy($id)
{
    // Fetch the enrollment record
    $enrollment = StudentCourse::find($id);

    // Check if the enrollment exists
    if (!$enrollment) {
        return response()->json(['message' => 'Enrollment not found.'], 404);
    }

    // Perform the delete action
    $enrollment->delete();

    return response()->json(['message' => 'Enrollment deleted successfully.']);
}
}
