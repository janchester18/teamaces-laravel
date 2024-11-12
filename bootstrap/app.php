<?php

use Carbon\Carbon;
use App\Mail\SchedReminder;
use Illuminate\Foundation\Application;
use App\Models\Schedule as ScheduleModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
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
        })->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
