<?php

use Carbon\Carbon;
use App\Models\Student;
use App\Mail\SchedReminder;
use App\Mail\BalanceReminder;
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
        })->dailyAt('19:00');

        $schedule->call(function () {
            // Fetch students with balance > 0 from transactions table
            $studentsWithBalance = Student::whereHas('transactions', function($query) {
                // Sum the balance from the transactions table and filter by balance > 0
                $query->selectRaw('SUM(balance) as total_balance')
                      ->groupBy('student_id')
                      ->havingRaw('SUM(balance) > 0');
            })->get();

            foreach ($studentsWithBalance as $student) {
                // Calculate the total balance from the student's transactions
                $totalBalance = $student->transactions()->sum('balance');

                // Log the total balance to check if it's calculated correctly
                \Log::info('Total balance for student ' . $student->id . ': ' . $totalBalance);

                // Convert the balance to Peso (or your local currency)
                $formattedBalance = number_format($totalBalance, 2); // Format it to 2 decimal places

                \Log::info('Formatted balance for student ' . $student->id . ': ' . $formattedBalance);

                // Send email reminder for balance, pass the balance to the email
                Mail::to($student->email)->send(new BalanceReminder($student, $formattedBalance));
            }
        })->dailyAt('17:00');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
