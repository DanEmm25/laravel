<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // Import Log facade

class UserController extends Controller
{
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3', 'max:10'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:200']
        ]);

        // Hash the password
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        try {
            // Try to create the user
            User::create($incomingFields);
            return 'User created successfully!';
        } catch (\Exception $e) {
            // If an error occurs, log the error message
            Log::error('Error creating user: ' . $e->getMessage());
            return 'An error occurred while creating the user.';
        }
    }
}
