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

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Log the request data for debugging
        \Log::info('Request data:', $request->all());

        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:students,email',
            'course_id' => 'nullable|exists:courses,id', // Dropdown for courses
            'package_id' => 'nullable|exists:packages,id', // Dropdown for packages
        ]);

        // Check if both course_id and package_id are missing
        if (empty($validatedData['course_id']) && empty($validatedData['package_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'You must select at least one course or package.'
            ], 400);
        }

        // Generate a unique student ID
        $uniqueIdPart = date('y') . '-' . rand(10000, 99999);

        // Create a new student record
        $student = Student::create([
            'id' => $uniqueIdPart,
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'dob' => $validatedData['dob'],
            'address' => $validatedData['address'],
            'phone_number' => $validatedData['phone_number'],
            'email' => $validatedData['email'],
            'branch_id' => Auth::user()->branch_id,
            'is_email_verified' => 1,
        ]);

// Check if a package is being registered
if (isset($validatedData['package_id']) && !empty($validatedData['package_id'])) {
    // Retrieve the courses associated with the package
    $package = Package::find($validatedData['package_id']);

    if (!$package) {
        return response()->json([
            'success' => false,
            'message' => 'Selected package does not exist.',
        ], 404);
    }

    $packageCourses = $package->courses;

    // Check if the package has courses
    if ($packageCourses->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'The selected package has no associated courses.',
        ], 400);
    }

    // Store student course entries: approve all courses in the package
    $firstCourse = true; // Flag to track the first course

    foreach ($packageCourses as $course) {
        // Determine the value for has_permit and is_approved
        $hasPermit = $firstCourse; // true for the first course, false for others
        $isApproved = $firstCourse ? 1 : 0; // 1 for approved, 0 for not approved

        // Set status based on whether it's the first course
        $status = $firstCourse ? 'ongoing' : 'pending'; // 'ongoing' for the first course, 'pending' for others

        // Create the student course entry
        StudentCourse::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'is_package' => true,
            'has_permit' => $hasPermit, // Set according to the first course
            'is_approved' => $isApproved, // Set as 1 or 0
            'status' => $status, // Set status accordingly
        ]);

        // Create schedules only if this is the first course with permit and approval
        if ($firstCourse) {
            $this->createSchedules($student, $course->id);
        }

        // After processing the first course, set the flag to false
        $firstCourse = false; // Ensure this logic runs only once
    }
} elseif (isset($validatedData['course_id']) && !empty($validatedData['course_id'])) {
    // For normal course registration
    StudentCourse::create([
        'student_id' => $student->id,
        'course_id' => $validatedData['course_id'],
        'is_package' => false,
        'has_permit' => true,
        'is_approved' => true,
        'status' => 'ongoing',
    ]);

    // Call the function to create schedules
    $this->createSchedules($student, $validatedData['course_id']);
} else {
    // Handle the case where neither package_id nor course_id is provided
    return response()->json([
        'success' => false,
        'message' => 'Please provide either a course or a package for registration.',
    ], 400);
}



        // Create a transaction entry
        $this->createTransaction($student, $validatedData['course_id'], $validatedData['package_id']); // course_id is used for transaction

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Student added successfully.',
            'student' => $student,
        ]);
    }

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
        // Count how many students are already scheduled for this course, branch, and time slot
        $studentCount = Schedule::where('course_id', $courseId)
            ->where('branch_id', $student->branch_id)
            ->whereDate('scheduled_date', $date->format('Y-m-d'))
            ->whereTime('scheduled_date', $time)
            ->count();

        // If the current time slot has not reached the limit, schedule the student
        if ($studentCount < $maxStudentsPerSlot) {
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



    private function createTransaction(Student $student, $courseId, $packageId = null)
    {
        Transaction::create([
            'student_id' => $student->id,
            'course_id' => $courseId,
            'package_id' => $packageId,
            'price' => $packageId ? Package::find($packageId)->price : Course::find($courseId)->price,
            'transaction_date' => Carbon::now(),
            'staff_id' => Auth::user()->id, // Assuming the current admin user is authenticated
            'branch_id' => Auth::user()->branch_id,
        ]);

        \Log::info("Transaction created for student ID: {$student->id}, course ID: {$courseId}, package ID: {$packageId}");
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
