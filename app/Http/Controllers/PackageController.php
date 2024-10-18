<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        // Retrieve all packages with their related courses
        $packages = Package::with('courses')->get();
        $courses = Course::all(); // Retrieve all courses

        // Return the view with the packages data
        return view('owner.package_management', compact('packages', 'courses')); // Adjust the view name as needed
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id', // Make sure selected courses exist
        ]);

        // Create the package
        $package = Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_active' => $request->is_active,
        ]);

        // Attach courses to the package
        $package->courses()->attach($request->courses);

        return response()->json([
            'success' => true,
            'message' => 'Package added successfully!',
        ]);
    }

    public function update(Request $request, $id)
{
    $package = Package::findOrFail($id);

    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'is_active' => 'required|boolean',
        'courses' => 'array',
        'courses.*' => 'exists:courses,id', // Ensure selected courses exist
    ]);

    // Update the package
    $package->update($request->only('name', 'price', 'is_active'));

    // Sync courses
    $package->courses()->sync($request->courses);

    return response()->json(['success' => true, 'message' => 'Package updated successfully.']);
}
}
