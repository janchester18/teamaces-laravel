<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ShowClassSchedule;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ShowApprovedController;
use App\Http\Controllers\ShowEnrollmentController;
use App\Http\Controllers\ApproveEnrollmentController;

Route::get('/', function () {
    return view('user.home'); // Make sure the view is located in resources/views/user/home.blade.php
})->name('home'); // This names the route 'home'

// About Us Route
Route::get('/about-us', function () {
    return view('user.about');
})->name('about');

// Courses Route
Route::get('/courses', function () {
    return view('user.courses');
})->name('courses');

// Branches Route
Route::get('/branches', function () {
    return view('user.branches');
})->name('branches');

// Gallery Route
Route::get('/gallery', function () {
    return view('user.gallery');
})->name('user.gallery');

// Portal Route
Route::get('/portal', function () {
    return view('user.portal');
})->name('user.portal');

// Enrollment Route
Route::get('/enrollment', function () {
    return view('user.enrollment');
})->name('enrollment');

Route::post('/create-branch', [BranchController::class, 'store']);
Route::get('/contact', [BranchController::class, 'index']);

Route::get('/contact', function () {
    return view('user.contact');
})->name('contact');

/* user routes */

/* branches */
Route::get('/branches', [BranchController::class, 'showBranches'])->name('branches');

/* enrollment routes */

// Route for showing the enrollment form
Route::get('/enrollment', [EnrollmentController::class, 'showForm'])->name('enrollment.form');

// Route for storing the enrollment data
Route::post('/enrollment', [EnrollmentController::class, 'store'])->name('enrollment.store');

// Route for showing the email verification form
Route::get('/verify-email', [EnrollmentController::class, 'showVerificationForm'])->name('enrollment.verify.form');

// Route for handling the email verification
Route::post('/verify-email', [EnrollmentController::class, 'verifyEmail'])->name('enrollment.verify');

//Admin Routes
// branch_analytics
Route::get('/branch_analytics', function () {
    return view('admin.branch_analytics');
})->name('branch_analytics');

// class_scheduling
Route::get('/class_scheduling', function () {
    return view('admin.class_scheduling');
})->name('class_scheduling');

// branch_management
Route::get('/branch_management', function () {
    return view('admin.branch_management');
})->name('branch_management');

// pending_enrollments
Route::get('/pending_enrollments', function () {
    return view('admin.pending_enrollments');
})->name('pending_enrollments');

// staff_management
Route::get('/staff_management', function () {
    return view('admin.staff_management');
})->name('staff_management');

// student_management
Route::get('/student_management', function () {
    return view('admin.student_management');
})->name('student_management');

// reports
Route::get('/reports', function () {
    return view('admin.student_management');
})->name('reports');

// settings
Route::get('/settings', function () {
    return view('admin.student_management');
})->name('settings');

// admin_login
Route::get('/admin_login', function () {
    return view('admin.admin_login');
})->name('login');


//LOGIN LOGIC////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Owner and staff redirection routes
Route::get('/owner/branch_analytics', function () {
    return view('owner.branch_analytics');
})->name('owner.branch_analytics')->middleware('auth');

Route::get('/admin/branch_analytics', function () {
    return view('admin.branch_analytics');
})->name('admin.branch_analytics')->middleware('auth');

//LOGOUT LOGIC////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('/logout', function () {
    Auth::logout(); // Logs the user out
    return redirect('/login'); // Redirect to login page after logout
})->name('logout');

//admin show routes
Route::get('/pending_enrollments', [ShowEnrollmentController::class, 'showPendingEnrollments'])->name('pending_enrollments');
Route::get('/student_management', [ShowApprovedController::class, 'index'])->name('student_management');
Route::get('/class_scheduling', [ShowClassSchedule::class, 'showClassSchedule'])->name('class_scheduling');


//staff-confirm payment route
Route::post('/confirm-payment/{student_id}', [ApproveEnrollmentController::class, 'confirmPayment'])->name('confirm_payment');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::delete('/enrollments/{id}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');


//schedule routes
Route::get('/students/{id}/schedules', [ShowApprovedController::class, 'fetchSchedule'])->name('students.schedules');
Route::get('/students/{student}', [ShowApprovedController::class, 'show'])->name('students.show');
Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update');
// Fetch student schedules
Route::get('/students/{studentId}/schedules', [StudentController::class, 'getStudentSchedules'])
    ->name('students.schedules');

// Update schedule status
Route::put('/schedules/{scheduleId}/update', [ScheduleController::class, 'updateScheduleStatus'])
    ->name('schedules.update');



