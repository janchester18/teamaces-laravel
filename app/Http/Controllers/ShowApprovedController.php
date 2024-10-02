<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Package; // Add this line
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;

class ShowApprovedController extends Controller
{
    public function index()
    {
        // Fetch students along with their courses
        $students = Student::with('courses')->get();

        // Fetch courses from the database
        $courses = Course::all(); // Fetch all courses from the database

        // Fetch packages from the database
        $packages = Package::where('is_active', 1)->get(); // Fetch active packages

        // Fetch the student courses (if necessary, depending on your use case)
        $studentCourses = StudentCourse::all();

        // Return the view with the fetched data
        return view('admin.student_management', compact('students', 'courses', 'packages', 'studentCourses')); // Include packages in the compact
    }
}
