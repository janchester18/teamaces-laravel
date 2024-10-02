<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class ShowEnrollmentController extends Controller
{
    public function showPendingEnrollments()
    {
        $staffBranchId = auth()->user()->branch_id;

        // Eager load the course relationship
        $pendingEnrollments = Enrollment::with('course') // Eager load the course
            ->where('branch_id', $staffBranchId)
            ->where('is_approved', false)
            ->where('is_email_verified', true)
            ->get();

        return view('admin.pending_enrollments', compact('pendingEnrollments'));
    }
}
