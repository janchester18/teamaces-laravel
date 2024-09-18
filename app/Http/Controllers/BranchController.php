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
}
