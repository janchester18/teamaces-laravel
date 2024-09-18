<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    /**
     * Show the enrollment form.
     */
    public function showForm()
    {
        return view('user.enrollment'); // Path adjusted to 'user/enroll.blade.php'
    }

    /**
     * Handle the form submission and store enrollment.
     */
    public function store(Request $request)
    {
        // Validate form input
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email|unique:enrollments,email',
            'course' => 'required|string|max:255',
        ]);

        // Create the enrollment record
        $enrollment = Enrollment::create($validatedData);

        // Generate a 4-digit verification code
        $verificationCode = sprintf('%04d', mt_rand(0, 9999)); // Ensures the code is always 4 digits long

        // Store the code in a separate table for email verification
        DB::table('email_verification_tokens')->insert([
            'email' => $enrollment->email,
            'token' => $verificationCode,
            'created_at' => now(),
        ]);

        // Send raw email verification
        Mail::raw("Your verification code is {$verificationCode}. Please enter this code to verify your email address.", function ($message) use ($enrollment) {
            $message->to($enrollment->email);
            $message->subject('Your Email Verification Code');
        });


        // Redirect to the verification form with email as query parameter
        return redirect()->route('enrollment.verify.form', ['email' => $enrollment->email])
                         ->with('success', 'Enrollment submitted! Please check your email for the verification code.');
    }

    /**
     * Show the verification form.
     */
    public function showVerificationForm(Request $request)
    {
        $email = $request->query('email');
        return view('user.verify-form', ['email' => $email]); // Path adjusted to 'user/verify_form.blade.php'
    }

    /**
     * Verify the email using the code.
     */
    public function verifyEmail(Request $request)
    {
        $code = $request->input('code');
        $email = $request->input('email');

        // Find the email associated with this code
        $verification = DB::table('email_verification_tokens')
            ->where('email', $email)
            ->where('token', $code)
            ->first();

        if (!$verification) {
            return redirect()->route('enrollment.verify.form', ['email' => $email])
                             ->with('error', 'Invalid verification code.');
        }

        // Mark the email as verified in the enrollment table
        Enrollment::where('email', $email)->update(['is_email_verified' => true]);

        // Optionally, delete the used code
        DB::table('email_verification_tokens')->where('token', $code)->delete();

        return redirect()->route('enrollment.form')->with('success', 'Email verified successfully!');
    }
}
