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

        // Attempt to save the branch
        if ($branch->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add branch.']);
        }
    }

}
