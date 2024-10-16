<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ScheduleAdjustmentRequest;

class DisplayStudentRequestController extends Controller
{
    public function viewRequests()
    {
        // Get the authenticated student
        $student = Auth::guard('student')->user();

        // Fetch the adjustment requests for the student's schedules along with the current scheduled date
        $requests = ScheduleAdjustmentRequest::with(['schedule' => function($query) {
            $query->select('id', 'scheduled_date');
        }])
        ->whereHas('schedule', function($query) use ($student) {
            $query->where('student_id', $student->id);
        })
        ->get();

        // Return the requests view with the data
        return view('portal.requests_made', compact('requests'));
    }

}
