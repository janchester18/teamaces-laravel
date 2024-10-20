<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Create the inquiry
        Inquiry::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'message' => $validatedData['message'],
            'status' => Inquiry::STATUS_PENDING, // Set the default status as 'pending'
        ]);

        // Return a success response
        return response()->json(['message' => 'Inquiry submitted successfully!'], 200);
    }

    public function index()
    {
        // Fetch all inquiries from the database
        $inquiries = Inquiry::orderBy('created_at', 'desc')->get();

        // Pass the inquiries to the view
        return view('owner.inquiries_requests', compact('inquiries'));
    }

    public function markResolved(Request $request)
    {
        $inquiry = Inquiry::find($request->id);

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        $inquiry->status = 'resolved';
        $inquiry->save();

        return response()->json(['success' => true, 'message' => 'Inquiry marked as resolved']);
    }
}
