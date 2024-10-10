<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');  // Your login view
    }

    public function login(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($request->only('email', 'password'))) {
            // Retrieve authenticated user
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->role == 'owner') {
                return redirect()->route('owner.branch_analytics');
            } elseif ($user->role == 'staff') {
                return redirect()->route('admin.branch_analytics_view');
            } else {
                Auth::logout(); // Logout if the role is not allowed
                return redirect()->route('login')->withErrors('Unauthorized role.');
            }
        }

        // If login attempt fails, redirect back with error message
        return redirect()->route('login')->withErrors('Login failed. Please check your credentials.');
    }
}
