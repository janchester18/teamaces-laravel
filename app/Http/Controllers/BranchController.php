<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch; // Include the Branch model

class BranchController extends Controller
{
    // Method to display the branches and map
    public function showBranches()
    {
        // Fetch all branches from the database
        $branches = Branch::all();

        // Pass the branches data to the view
        return view('user.branches', compact('branches'));
    }

    public function showOwnerBranches()
    {
        // Fetch all branches from the database
        $branches = Branch::all();

        // Pass the branches data to the view
        return view('owner.branch_management', compact('branches'));
    }

    // Store a newly created branch in the database
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Store the branch data
        $branch = new Branch();
        $branch->name = $request->branch_name;
        $branch->address = $request->address;
        $branch->latitude = $request->latitude;
        $branch->longitude = $request->longitude;

        // Set the status to active by default
        $branch->status = 'active';

        // Attempt to save the branch
        if ($branch->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add branch.']);
        }
    }


    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'branch_address' => 'required|string|max:255',
            'branch_status' => 'required|in:active,inactive', // Validate status
        ]);

        // Find the branch and update it
        $branch = Branch::findOrFail($id);
        $branch->name = $validated['branch_name'];
        $branch->address = $validated['branch_address'];
        $branch->status = $validated['branch_status']; // Update status
        $branch->save();

        // Return a JSON response
        return response()->json(['success' => true, 'message' => 'Branch updated successfully.']);
    }


}
