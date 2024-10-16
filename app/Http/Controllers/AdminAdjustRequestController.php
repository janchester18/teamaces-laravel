<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScheduleAdjustmentRequest;

class AdminAdjustRequestController extends Controller
{
    public function index()
    {
        // Fetch schedule adjustment requests with related schedule and student information where status is 'pending'
        $requests = ScheduleAdjustmentRequest::with(['schedule.student'])
            ->where('status', 'pending') // Add this line to filter requests
            ->get();

        return view('admin.adjustment_request', compact('requests'));
    }


    public function processRequest(Request $request)
{
    $request->validate([
        'request_id' => 'required|exists:schedule_adjustment_requests,id',
        'decision' => 'required|in:approve,deny',
        'reason' => 'nullable|string',
    ]);

    // Find the request
    $adjustmentRequest = ScheduleAdjustmentRequest::with('schedule')->findOrFail($request->request_id);

    if ($request->decision === 'approve') {
        // Logic to approve the request
        $adjustmentRequest->status = 'approved';

        // Update the related schedule in the schedules table
        $schedule = $adjustmentRequest->schedule; // Get the related schedule

        // Assuming new_scheduled_date and new_schedule_finish are columns in the schedule_adjustment_requests table
        $schedule->scheduled_date = $adjustmentRequest->new_scheduled_date;
        $schedule->schedule_finish = $adjustmentRequest->new_schedule_finish;

        $schedule->save(); // Save the updated schedule
    } else {
        // Logic to deny the request
        $adjustmentRequest->status = 'denied';
        $adjustmentRequest->reason = $request->reason;
    }

    $adjustmentRequest->save(); // Save the adjustment request status

    return redirect()->route('schedule_adjustment_requests')->with('success', 'Adjustment request processed successfully.');
}

public function showRequestLogs()
{
    // Fetch schedule adjustment requests with related schedule and student information where status is 'pending'
    $requests = ScheduleAdjustmentRequest::with(['schedule.student'])
        ->get();

    return view('admin.adjustment_request_log', compact('requests'));
}


}
