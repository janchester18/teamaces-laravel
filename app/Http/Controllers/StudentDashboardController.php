<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\StudentCourse;
use Auth;

class StudentDashboardController extends Controller
{
    // Display the student dashboard
    public function index()
    {
        // Fetch the authenticated student
        $student = Auth::guard('student')->user();

        // Fetch the courses the student is enrolled in
        $courses = StudentCourse::where('student_id', $student->id)
            ->join('courses', 'student_courses.course_id', '=', 'courses.id')
            ->select('courses.*', 'student_courses.status', 'student_courses.id as student_course_id')
            ->get();

        // Fetch all schedules for the authenticated student
        $schedules = Schedule::where('student_id', $student->id)->get();

        // Log all schedules for the student
        \Log::info('Schedules for student ID ' . $student->id, $schedules->toArray());

        // Calculate completion percentage for each course
        foreach ($courses as $studentCourse) {
            // Get total sessions from the courses table
            $totalSessions = $studentCourse->number_of_sessions; // Get total sessions from courses table

            // Count the completed sessions for the current course
            $completedSessions = $schedules->where('course_id', $studentCourse->id)
                                             ->where('status', 'done')
                                             ->count(); // Count completed schedules for this course

            // Calculate completion percentage
            $studentCourse->completion_percentage = $totalSessions > 0 ? ($completedSessions / $totalSessions) * 100 : 0;
        }

        // Pass the student and courses to the view
        return view('portal.student_dashboard', compact('student', 'courses'));
    }

    public function courseDetails($id)
    {
        // Get the authenticated student
        $student = Auth::guard('student')->user();

        // Get the course by ID
        $course = Course::findOrFail($id);

        // Fetch the student's schedule for this course, ordered by scheduled_date
        $schedules = Schedule::where('student_id', $student->id)
                    ->where('course_id', $id)
                    ->orderBy('scheduled_date', 'asc') // Sort by scheduled_date in ascending order
                    ->get();

        // Return the course details view with the course and schedule data
        return view('portal.course_details', compact('course', 'schedules'));
    }

}
