<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index() {
        $courses = Course::all(); // Get all courses
        return view('owner.course_management', compact('courses')); // Pass the courses to the view
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:50',
            'description' => 'required|string',
            'number_of_sessions' => 'required|integer',
            'hours_per_session' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        // Create the course
        $course = Course::create([
            'name' => $request->name,
            'acronym' => $request->acronym,
            'description' => $request->description,
            'number_of_sessions' => $request->number_of_sessions,
            'hours_per_session' => $request->hours_per_session,
            'price' => $request->price,
        ]);

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Course added successfully!',
            'course' => $course
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'acronym' => 'required|string|max:10', // Change max length as necessary
            'description' => 'required|string',
            'number_of_sessions' => 'required|integer',
            'hours_per_session' => 'required|integer', // Ensure this matches the form input type
            'price' => 'required|numeric',
        ]);

        // Find the course and update it with validated data
        $course = Course::findOrFail($id);
        $course->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Course updated successfully.']);
    }


}
