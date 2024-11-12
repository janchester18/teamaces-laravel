<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Schedule as ScheduleModel;
use App\Mail\SchedReminder;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    // Get the schedules for today or the next few days
    $schedules = ScheduleModel::whereDate('scheduled_date', '>=', Carbon::now())
        ->orderBy('scheduled_date')
        ->get();

    // Group the schedules by student ID to ensure only one email per student
    $groupedSchedules = $schedules->groupBy('student_id');

    // Loop through each group of schedules (one per student)
    foreach ($groupedSchedules as $studentSchedules) {
        // Get the first schedule for the student (the next upcoming one)
        $nextSchedule = $studentSchedules->first();

        // Ensure the student and schedule exist before proceeding
        if ($nextSchedule && $nextSchedule->student) {
            $student = $nextSchedule->student;  // Get the student from the schedule

            // Send the email reminder for the next upcoming schedule
            Mail::to($student->email)->send(new SchedReminder($student, $nextSchedule));
        }
    }
})->dailyAt('19:00');  // You can adjust this frequency as needed
