<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\Package;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $courseId;
    public $packageId;
    public $balance;
    public $paymentMethod;
    public $schedules; // Add this property for schedules

    public function __construct(Student $student, $courseId, $packageId, $balance, $paymentMethod)
    {
        $this->student = $student;
        $this->courseId = $courseId;
        $this->packageId = $packageId;
        $this->balance = $balance;
        $this->paymentMethod = $paymentMethod;

        // Load schedules for the student (assuming 'schedules' is a relationship)
        $this->schedules = $student->schedules; // You can modify this based on your relationship
    }

    public function build()
    {
        // Retrieve the course or package based on provided IDs
        $course = Course::find($this->courseId);
        $package = Package::find($this->packageId);

        // Return the email view, passing course/package and other info
        return $this->view('user.emails.enrollment_confirmation')
                    ->with([
                        'student' => $this->student,
                        'course' => $course,
                        'package' => $package,
                        'balance' => $this->balance,
                        'paymentMethod' => $this->paymentMethod,
                        'schedules' => $this->schedules, // Pass schedules here
                    ]);
    }
}
