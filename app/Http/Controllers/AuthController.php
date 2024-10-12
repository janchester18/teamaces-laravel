<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    // Show the login form for students
    public function showLoginForm()
    {
        return view('user.portal'); // This should point to your login view file
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'student_id' => 'required',
        ]);

        // Find the student
        $student = \App\Models\Student::where('email', $request->email)
                                    ->where('id', $request->student_id)
                                    ->first();

        if ($student) {
            // Log in the student and store a prefixed user_id
            Auth::guard('student')->login($student, $request->remember);

            // Store a prefixed ID to avoid conflicts
            session(['user_id' => 'student_' . $student->id]);

            return redirect()->intended('student/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    // Logout method
    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect('/'); // Redirect after logout
    }
}
