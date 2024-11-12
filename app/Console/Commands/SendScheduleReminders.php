<?php

namespace App\Actions;

use App\Models\Student;
use App\Mail\ScheduleReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class SendScheduleReminders
{
    public function __invoke()
    {
        // Fetch students with schedules exactly 10 hours from now
        $students = Student::with('schedules')
            ->whereHas('schedules', function ($query) {
                $query->where('scheduled_date', '=', Carbon::now()->addHours(10)->format('Y-m-d H:i:s'));
            })
            ->get();

        // Send reminder emails
        foreach ($students as $student) {
            Mail::to($student->email)->send(new ScheduleReminder($student, $student->schedules));
        }

        \Log::info("Reminder emails sent to students with upcoming schedules.");
    }
}
