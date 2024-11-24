<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Student; // Import Student model
use App\Models\Enrollment; // Import Enrollment model
use App\Mail\EnrollmentConfirmation;

class ApproveEnrollmentController extends Controller
{
    public function confirmPayment(Request $request, $id)
    {
            // Validate the amount paid input
        $validated = $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        // Log the enrollment ID for debugging
        \Log::info('Confirming payment for enrollment ID: ' . $id);

        // Retrieve the pending enrollment
        $enrollment = Enrollment::find($id);

        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found'], 404);
        }

        // Ensure at least one of course_id or package_id is present
        if (empty($enrollment->course_id) && empty($enrollment->package_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment must have either a course or a package associated.'
            ], 400);
        }

            // Determine the price from the course or package
    $price = 0;
    if (!empty($enrollment->course_id)) {
        $course = Course::find($enrollment->course_id);
        if (!$course) {
            return response()->json(['message' => 'Course not found.'], 404);
        }
        $price = $course->price;
    } elseif (!empty($enrollment->package_id)) {
        $package = Package::find($enrollment->package_id);
        if (!$package) {
            return response()->json(['message' => 'Package not found.'], 404);
        }
        $price = $package->price;
    }

    // Calculate the balance
    $balance = $price - $validated['amount_paid'];

    if ($balance < 0) {
        return response()->json([
            'success' => false,
            'message' => 'Amount paid cannot exceed the course or package price.'
        ], 400);
    }

        // Create a new student record
        $student = Student::create([
            'id' => $enrollment->id, // Maintain the same ID as enrollment
            'first_name' => $enrollment->first_name,
            'last_name' => $enrollment->last_name,
            'dob' => $enrollment->dob,
            'address' => $enrollment->address,
            'phone_number' => $enrollment->phone_number,
            'email' => $enrollment->email,
            'branch_id' => $enrollment->branch_id,
            'is_email_verified' => $enrollment->is_email_verified,
        ]);

        // If a package is associated, handle package-based enrollment
        if (!empty($enrollment->package_id)) {
            $package = Package::find($enrollment->package_id);

            if (!$package) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected package does not exist.',
                ], 404);
            }

            $packageCourses = $package->courses;

            if ($packageCourses->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected package has no associated courses.',
                ], 400);
            }

            $firstCourse = true; // Flag to track the first course

            foreach ($packageCourses as $course) {
                $hasPermit = $firstCourse; // Permit only for the first course
                $isApproved = $firstCourse ? 1 : 0; // Approve only the first course
                $status = $firstCourse ? 'ongoing' : 'pending'; // Ongoing for the first course, pending for others

                // Create the student course entry
                StudentCourse::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'is_package' => true,
                    'has_permit' => $hasPermit,
                    'is_approved' => $isApproved,
                    'status' => $status,
                ]);

                if ($firstCourse) {
                    $this->createSchedules($student, $course->id);
                }

                $firstCourse = false; // Only the first course gets these attributes
            }
        } elseif (!empty($enrollment->course_id)) {
            // For standard course-based enrollment
            StudentCourse::create([
                'student_id' => $student->id,
                'course_id' => $enrollment->course_id,
                'is_package' => false,
                'has_permit' => true,
                'is_approved' => true,
                'status' => 'ongoing',
            ]);

            $this->createSchedules($student, $enrollment->course_id);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment must have a course or package to proceed.',
            ], 400);
        }

        // Create a transaction entry for the student
        $this->createTransaction($student, $enrollment->course_id, $enrollment->package_id,  $balance,  $validated['payment_method']);

        // Remove the enrollment entry after successful approval
        $enrollment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment confirmed, student added successfully, and relevant records updated.',
            'student' => $student,
        ]);
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

    $nextAvailableTDCDate = function ($date) {
        $date=Carbon::now();
        $dayOfWeek = $date->dayOfWeek; // Get the current day of the week (0 = Sunday, 6 = Saturday)

        \Log::info('Current day of week: ' . $dayOfWeek);

        if ($dayOfWeek >= Carbon::TUESDAY && $dayOfWeek <= Carbon::FRIDAY) {
            // If today is between Tuesday and Friday, schedule the first session on the coming Saturday
            return $date->next(Carbon::SATURDAY);
        } else {
            // If today is Saturday, Sunday, or Monday, schedule the first session on the coming Tuesday
            return $date->next(Carbon::TUESDAY);
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

    // Determine the second session day based on whether the first is on Saturday or Tuesday
    $secondSessionTime = ($firstSessionTime->dayOfWeek == Carbon::SATURDAY)
        ? $firstSessionTime->copy()->addDay()  // Schedule the second session on Sunday if starting on Saturday
        : $firstSessionTime->copy()->addDay(); // Schedule the second session on Wednesday if starting on Tuesday

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

    // Create the second TDC session on the next valid day with the correct `schedule_finish` time
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



    private function createTransaction(Student $student, $courseId, $packageId = null, $balance, $paymentMethod)
    {
        Transaction::create([
            'student_id' => $student->id,
            'course_id' => $courseId,
            'package_id' => $packageId,
            'balance' => $balance, // Store the balance in the transaction
            'price' => $packageId ? Package::find($packageId)->price : Course::find($courseId)->price,
            'transaction_date' => Carbon::now(),
            'staff_id' => Auth::user()->id, // Assuming the current admin user is authenticated
            'branch_id' => Auth::user()->branch_id,
            'payment_method' => $paymentMethod,
        ]);

        \Log::info("Transaction created for student ID: {$student->id}, course ID: {$courseId}, package ID: {$packageId}");

        Mail::to($student->email)->send(new EnrollmentConfirmation($student, $courseId, $packageId, $balance, $paymentMethod));
    }
    public function getStudentSchedules($studentId)
    {
        // Fetch schedules for the specified student ID and order by scheduled_date in ascending order
        $schedules = Schedule::where('student_id', $studentId)
                             ->orderBy('scheduled_date', 'asc')
                             ->get();

        return response()->json($schedules); // Return the schedules as JSON
    }


}
