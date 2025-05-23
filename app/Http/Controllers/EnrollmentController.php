<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Course;
use App\Models\Package;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\StudentCourse;
use GuzzleHttp\Client;

class EnrollmentController extends Controller
{
    /**
     * Show the enrollment form.
     */
    public function showForm()
    {
        // Fetch students along with their courses
        $students = Student::with('courses')->get();

        // Fetch students along with their courses
        $branches = Branch::where('status', 'active')->get();

        // Fetch courses from the database
        $courses = Course::all(); // Fetch all courses from the database

        // Fetch packages from the database
        $packages = Package::where('is_active', 1)->get(); // Fetch active packages

        // Fetch the student courses (if necessary, depending on your use case)
        $studentCourses = StudentCourse::all();

        // Return the view with the fetched data
        return view('user.enrollment', compact('students', 'branches', 'courses', 'packages', 'studentCourses')); // Include packages in the compact
    }

    /**
     * Handle the form submission and store enrollment.
     */
    public function store(Request $request)
    {
        // Validate form input, including checking if the email already exists
        $validatedData = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => [
                'required',
                'email',
                'unique:enrollments,email',
                'unique:students,email', // Check against the students table as well
            ],
            'course_id' => 'nullable|exists:courses,id', // Dropdown for courses
            'package_id' => 'nullable|exists:packages,id', // Dropdown for packages
            'payment_method' => 'required|string',

        ], [
            'email.unique' => 'This email address is already taken. Please use a different email address.', // Custom error message
        ]);

        // Create the enrollment record
        $enrollment = Enrollment::create($validatedData);

        // Generate a 4-digit verification code
        $verificationCode = sprintf('%04d', mt_rand(0, 9999));

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

        // Check if the payment method is online
        $enrollment = Enrollment::where('email', $email)->first();

        if ($enrollment && $enrollment->payment_method == 'online') {
            // Redirect to the online payment view
            Mail::raw("Your enrollment is now under processing for online payment. Please wait for the payment confirmation update to be sent to your email. Thank you..", function ($message) use ($enrollment) {
                $message->to($enrollment->email);
                $message->subject('Enrollment Under Processing');
            });
            return redirect()->route('enrollment.online.payment.view', ['enrollmentId' => $enrollment->id]);
        }

        // Send an email based on the payment method (online or walk-in)
        if ($enrollment->payment_method == 'online') {
            Mail::raw("Your enrollment is now under processing for online payment. Please wait for the payment confirmation update to be sent to your email. Thank you..", function ($message) use ($enrollment) {
                $message->to($enrollment->email);
                $message->subject('Enrollment Under Processing');
            });
        } else {
            Mail::raw("Please proceed to your branch of enrollment to settle the payment within 48 hours. Thank you.", function ($message) use ($enrollment) {
                $message->to($enrollment->email);
                $message->subject('Walk-in Payment Instructions');
            });
        }


        return redirect()->route('enrollment.success')->with('success', 'Enrollment submitted! Please check your email for further instructions.');
    }

    public function success()
    {
        return view('user.successful-enrollment'); // Load the successful enrollment view
    }
    public function destroy($id)
    {
        // Find the enrollment by ID
        $enrollment = Enrollment::find($id);

        // Check if enrollment exists
        if (!$enrollment) {
            return response()->json(['message' => 'Enrollment not found.'], 404);
        }

        // Delete the enrollment
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted successfully.']);
    }

    public function showOnlinePaymentView($enrollmentId)
    {
        // Fetch the enrollment record
        $enrollment = Enrollment::findOrFail($enrollmentId);

        // Fetch the course or package details based on the enrollment data
        $course = Course::find($enrollment->course_id);
        $package = Package::find($enrollment->package_id);

        // Set amount and description based on the selected course/package
        $amount = $course ? $course->price : ($package ? $package->price : 0);
        $description = $course ? $course->name : ($package ? $package->name : 'TDC');
        $amountInCents = (int) ($amount * 100);

        // Make PayMongo API request to create a payment link
        $client = new Client();
        $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
            'body' => json_encode([
                'data' => [
                    'attributes' => [
                        'amount' => $amountInCents,
                        'description' => $description,
                    ]
                ]
            ]),
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'secret key',
                'content-type' => 'application/json',
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        // Get the checkout URL from the PayMongo API response
        $checkoutUrl = $data['data']['attributes']['checkout_url'];

        // Return the payment view with dynamic data
        return view('user.online-payment', [
            'checkoutUrl' => $checkoutUrl,
            'amount' => $amount,
            'description' => $description
        ]);
    }
}
