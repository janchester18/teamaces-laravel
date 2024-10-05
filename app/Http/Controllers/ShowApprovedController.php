<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\StudentCourse;
use App\Models\Package; // Add this line

class ShowApprovedController extends Controller
{
    public function index()
    {
        // Get the current logged-in admin's branch_id
        $adminBranchId = auth()->user()->branch_id;

        // Fetch students along with their courses, filtered by the admin's branch_id
        $students = Student::with('courses')
                           ->where('branch_id', $adminBranchId)
                           ->get();

        // Fetch courses from the database
        $courses = Course::all();

        // Fetch active packages from the database
        $packages = Package::where('is_active', 1)->get();

        // Fetch student courses if necessary, depending on your use case
        $studentCourses = StudentCourse::all();

        // Fetch schedules if necessary, depending on your use case
        $schedules = Schedule::all();

        // Return the view with the fetched data
        return view('admin.student_management', compact('students', 'courses', 'packages', 'studentCourses', 'schedules'));
    }

    /**
     * Fetch the student's schedule for editing.
     */
    public function fetchSchedule($studentId)
    {
        $schedules = Schedule::where('student_id', $studentId)
            ->with(['course']) // Assuming 'course' is the relationship defined in the Schedule model
            ->orderBy('scheduled_date', 'asc') // Sort by scheduled_date in ascending order
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json(['message' => 'No schedules found for this student.'], 404);
        }

        return response()->json($schedules);
    }

    public function show($studentId)
    {
        $student = Student::findOrFail($studentId);
        $schedules = Schedule::with('course') // Eager load the course relationship
        ->where('student_id', $studentId) // Filter by student ID
        ->orderBy('scheduled_date', 'asc') // Sort by scheduled_date in ascending order
        ->get(); // Execute the query

        return view('admin.edit_schedule', compact('student', 'schedules'));
    }



}
