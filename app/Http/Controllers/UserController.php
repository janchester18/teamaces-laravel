<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register() {
        return "Hello user!";
    }

    public function showStaffManagement()
    {
        // Fetch users with the role of 'staff'
        $staffMembers = User::where('role', 'staff')->get();
        // Fetch all branches from the database
        $branches = Branch::all();

        return view('owner.staff_management', compact('staffMembers', 'branches'));
    }

    public function store(Request $request)
    {
        // Validate the request, ensuring email and phone_number are unique
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'branch_id' => 'required|exists:branches,id',
            'phone_number' => 'required|string|max:15|unique:users',
        ]);

        // Generate a unique ID for the user
        do {
            $id = (string)rand(1, 10000);
        } while (\App\Models\User::where('id', $id)->exists());

        // Store the staff data
        $staff = new User();
        $staff->id = $id;
        $staff->name = $validated['name'];
        $staff->email = $validated['email'];
        $staff->password = bcrypt($validated['password']); // Encrypt password
        $staff->role = 'staff'; // Set role to staff by default
        $staff->branch_id = $validated['branch_id'];
        $staff->phone_number = $validated['phone_number'];
        $staff->status = 'active'; // Set status to active by default

        if ($staff->save()) {
            return response()->json(['success' => true, 'message' => 'Staff added successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to add staff.']);
        }
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'staff_name' => 'required|string|max:255',
        'staff_email' => 'required|string|email|max:255|unique:users,email,'.$id,
        'phone_number' => 'required|string|max:15|unique:users,phone_number,'.$id,
        'password' => 'nullable|string|min:8',
        'status' => 'required|in:active,inactive',
    ]);

    // Find the staff member
    $staff = User::findOrFail($id);

    // Update the staff data
    $staff->name = $validated['staff_name'];
    $staff->email = $validated['staff_email'];
    $staff->phone_number = $validated['phone_number'];
    if (!empty($request->password)) {
        $staff->password = bcrypt($request->password); // Encrypt the new password if provided
    }
    $staff->status = $validated['status'];

    // Save the updated staff
    $staff->save();

    return response()->json(['success' => true, 'message' => 'Staff updated successfully.']);
}


}
