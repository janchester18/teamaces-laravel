<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
        // Display the student dashboard
        public function index()
        {
            // Optionally, you can pass the authenticated student to the view
            $student = Auth::guard('student')->user();

            // Fetch the schedules for the student
            $schedules = Schedule::where('student_id', $student->id)->get();

            return view('portal.student_dashboard', compact('student', 'schedules')); // Create this view file
        }
}
