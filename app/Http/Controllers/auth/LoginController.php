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
            // Check if the user is inactive
            if (Auth::user()->status !== 'active') {
                Auth::logout(); // Logout if inactive
                return response()->json(['message' => 'Your account is inactive.'], 403);
            }

            // Check user role and redirect accordingly
            $redirectRoute = Auth::user()->role === 'owner' ? route('owner.branch_analytics_view') : route('admin.branch_analytics_view');

            // Login successful
            return response()->json(['redirect' => $redirectRoute]);
        }

        // If login attempt fails, return error
        return response()->json(['message' => ['Login failed. Please check your credentials.']], 422);
    }


}
