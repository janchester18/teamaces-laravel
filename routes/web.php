<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ShowClassSchedule;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\OwnerReportsController;
use App\Http\Controllers\ShowApprovedController;
use App\Http\Controllers\ExistingEnrollController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ShowEnrollmentController;
use App\Http\Controllers\ExistingStudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\ApproveEnrollmentController;
use App\Http\Controllers\AdminAdjustRequestController;
use App\Http\Controllers\DisplayStudentRequestController;
use App\Http\Controllers\StudentRequestAdjustmentController;

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

// existing_students
Route::get('/existing_students', function () {
    return view('admin.existing_students');
})->name('existing_students');

//adjustment_requests
Route::get('/adjustment-requests', function () {
    return view('admin.adjustment_request'); // Ensure this matches your Blade view file
})->name('schedule_adjustment_requests');

//adjustment_requests
Route::get('/requests_log', function () {
    return view('admin.adjustment_request_log'); // Ensure this matches your Blade view file
})->name('requests.log');

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
    return view('admin.reports');
})->name('reports');

// settings
Route::get('/settings', function () {
    return view('admin.student_management');
})->name('settings');

// admin_login
Route::get('/admin_login', function () {
    return view('admin.admin_login');
})->name('admin_login');


//LOGIN LOGIC////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Owner and staff redirection routes
Route::get('/owner/branch_analytics?view=summary', function () {
    return view('owner.branch_analytics');
})->name('owner.branch_analytics_view')->middleware('auth');

Route::get('/admin/branch_analytics?view=summary', function () {
    return view('admin.branch_analytics');
})->name('admin.branch_analytics_view')->middleware('auth');


// LOGOUT LOGIC
Route::post('/logout', function (Request $request) {
    // Check the authentication status
    $userId = Auth::id();
    \Log::info("Logging out user ID: $userId");

    Auth::logout(); // Logs the user out

    // Access the session from the request instance
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

//admin show routes
Route::get('/pending_enrollments', [ShowEnrollmentController::class, 'showPendingEnrollments'])->name('pending_enrollments');
Route::get('/student_management', [ShowApprovedController::class, 'index'])->name('student_management');
Route::get('/class_scheduling', [ShowClassSchedule::class, 'showClassSchedule'])->name('class_scheduling');
Route::get('/tdc_schedules', [ShowClassSchedule::class, 'fetchTDCSchedules'])->name('tdc_schedules');


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

//dashboard routes
// Controller-based route for more complex logic
Route::get('/admin/branch_analytics', [DashboardController::class, 'index'])
    ->name('admin.branch_analytics');

Route::get('/branch_analytics/revenue-insights', [DashboardController::class, 'getRevenueInsights'])->name('revenue_insights');

// Controller-based route for more complex logic owner
Route::get('/owner/branch_analytics', [OwnerDashboardController::class, 'index'])
    ->name('owner.branch_analytics');

Route::get('/branch_analytics/revenue-insights', [OwnerDashboardController::class, 'getRevenueInsights'])->name('revenue_insights');

Route::prefix('student')->group(function () {
    // Show the login form
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('student.login');

    // Handle the login form submission
    Route::post('login', [AuthController::class, 'login'])->name('student.login.submit');

    // Handle logout
    Route::post('logout', [AuthController::class, 'logout'])->name('student.logout');
});

// Protect student routes using the custom guard
Route::middleware(['auth:student'])->group(function () {
    Route::get('student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});
Route::post('/student_logout', [AuthController::class, 'logout'])->name('student.logout');


Route::get('/course/{id}/details', [StudentDashboardController::class, 'courseDetails'])->name('course.details');
Route::get('/request-adjustment/form', [StudentRequestAdjustmentController::class, 'showAdjustmentPage'])->name('request.adjustment');

Route::post('/submit-adjustment', [StudentRequestAdjustmentController::class, 'submitAdjustment'])->name('submit.adjustment');
Route::get('/requests-made', [DisplayStudentRequestController::class, 'viewRequests'])->name('requests.made');
Route::get('/add_course', function () {
    return view('portal.add_course');
})->name('add_course');




Route::get('/adjustment-requests', [AdminAdjustRequestController::class, 'index'])->name('schedule_adjustment_requests');
Route::post('/adjustment-request/process', [AdminAdjustRequestController::class, 'processRequest'])->name('process.adjustment');
// In your routes file (web.php)
Route::get('/requests_log', [AdminAdjustRequestController::class, 'showRequestLogs'])->name('requests.log.data');

//existing student enrollment routes
Route::get('/existing_students', [ExistingStudentController::class, 'existingStudents'])->name('existing_students');
Route::post('/approve-enrollment/{enrollmentId}', [ExistingStudentController::class, 'approveEnrollment'])->name('enrollments.approve');
Route::delete('/delete-enrollments/{enrollmentId}', [ExistingStudentController::class, 'destroy'])->name('enrollments.delete');
Route::get('/add_course', [ExistingEnrollController::class, 'showForm'])->name('add_course');
Route::post('/enrollment/store', [ExistingEnrollController::class, 'store'])->name('existing-enrollment.store');


//owner nav routes
// branch_management
Route::get('/branch_management', function () {
    return view('owner.branch_management');
})->name('branch_management');
// add branch
Route::get('/add_map', function () {
    return view('owner.add_map');
})->name('branch.create.form');
// staff_management
Route::get('/staff_management', function () {
    return view('owner.staff_management');
})->name('staff_management');
// course_management
Route::get('/course_management', function () {
    return view('owner.course_management');
})->name('course_management');
// package_management
Route::get('/package_management', function () {
    return view('owner.package_management');
})->name('package_management');
// inquiries_requests
Route::get('/inquiries_requests', function () {
    return view('owner.inquiries_requests');
})->name('inquiries_requests');
// owner_reports
Route::get('/owner-reports', function () {
    return view('owner.owner-reports');
})->name('owner-reports');

//owner branch routes
Route::get('/branch_management', [BranchController::class, 'showOwnerBranches'])->name('branch_management');
Route::post('/branch/store', [BranchController::class, 'store'])->name('branch.store');
Route::put('/branch/update/{id}', [BranchController::class, 'update'])->name('branch.update');

//owner staff routes
Route::get('/staff_management', [UserController::class, 'showStaffManagement'])
    ->name('staff_management'); // This is the route name you'll use in your Blade views
Route::post('/staff/store', [UserController::class, 'store'])->name('staff.store');
Route::put('/staff/{id}', [UserController::class, 'update'])->name('staff.update');

//owner courses routes
Route::get('/course_management', [CourseController::class, 'index'])->name('course_management');
Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
Route::put('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');

//owner packages routes
Route::get('/package_management', [PackageController::class, 'index'])->name('package_management');
Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');
Route::put('/packages/{id}', [PackageController::class, 'update'])->name('packages.update');

//inquiries routes
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
Route::post('/inquiries/mark-resolved', [InquiryController::class, 'markResolved'])->name('inquiries.markResolved');
Route::get('/inquiries_requests', [InquiryController::class, 'index'])->name('inquiries_requests');

//admin reports
Route::post('/api/generate-insights', [ReportsController::class, 'generateInsights']);
Route::get('/reports', [ReportsController::class, 'getStudentDemographics'])->name('reports');
// Popular Courses routes
Route::post('/api/generate-course-insights', [ReportsController::class, 'generateCourseInsights']);
Route::get('/transactions', [ReportsController::class, 'getBranchTransactions'])
    ->name('transactions.branch')
    ->middleware('auth');


//owner reports
Route::post('/api/owner-generate-insights', [OwnerReportsController::class, 'generateInsights']);
Route::get('/owner-reports', [OwnerReportsController::class, 'getStudentDemographics'])->name('owner-reports');
// Popular Courses routes
Route::post('/api/owner-generate-course-insights', [OwnerReportsController::class, 'generateCourseInsights']);
Route::get('/owner-transactions', [OwnerReportsController::class, 'getBranchTransactions'])
    ->name('owner-transactions.branch');


//added features
//payment update
Route::post('/update-payment', [ReportsController::class, 'updatePayment'])->name('update.payment');

//online payment
Route::get('/enrollment/online-payment/{enrollmentId}', [EnrollmentController::class, 'showOnlinePaymentView'])->name('enrollment.online.payment.view');
Route::get('/enrollment/success', [EnrollmentController::class, 'success'])->name('enrollment.success');
