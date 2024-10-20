<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExistingEnrollController extends Controller
{
    public function showForm()
    {
        // Get the authenticated student
        $student = Auth::guard('student')->user();

        // Fetch all courses
        $courses = Course::all();

        // Fetch the IDs of courses the student is already enrolled in
        $studentCourses = $student->courses()->pluck('courses.id')->toArray(); // Use 'courses.id' to specify the table

        return view('portal.add_course', compact('courses', 'studentCourses'));
    }

    public function store(Request $request)
    {
        // Get the authenticated student
        $student = Auth::guard('student')->user();

        // Validate the incoming request
        $request->validate([
            'course_id' => 'required|exists:courses,id', // Ensure course ID is provided and exists
        ]);

        // Check if the student is already enrolled in the course
        $isEnrolled = StudentCourse::where('student_id', $student->id)
            ->where('course_id', $request->course_id)
            ->exists();

        if ($isEnrolled) {
            // Return error response if already enrolled
            return response()->json([
                'message' => 'You are already enrolled in this course.',
            ], 400);
        }

        // Create a new student course record
        $studentCourse = new StudentCourse();
        $studentCourse->student_id = $student->id; // Use the authenticated student ID
        $studentCourse->course_id = $request->course_id; // Course ID from the form
        $studentCourse->is_package = 0; // Always 0
        $studentCourse->has_permit = 1; // Always 1
        $studentCourse->is_approved = 0; // Always 0
        $studentCourse->status = 'pending'; // Always pending
        $studentCourse->save(); // Save the record

        // Return a success response
        return response()->json(['message' => 'Enrollment successful!'], 200);
    }
}
